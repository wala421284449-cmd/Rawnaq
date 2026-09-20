<?php

namespace App\Http\Controllers;

use App\Models\MediaGallery;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MediaGalleryController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة صور المعرض مع دعم الفلترة حسب المتجر إن وجد.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', MediaGallery::class);

        $storeId = $request->get('store_id');

        $galleries = MediaGallery::with('store')
            ->when($storeId, function ($query, $storeId) {
                return $query->where('stores_id', $storeId);
            })
            ->latest()
            ->paginate(10);

        return view('cms.media-galleries.index', compact('galleries', 'storeId'));
    }

    /**
     * عرض صفحة نموذج إضافة صور جديدة لمعرض المتجر.
     */
    public function create(Request $request)
    {
        $this->authorize('create', MediaGallery::class);

        $stores = Store::all();
        $selectedStoreId = $request->get('store_id');

        return view('cms.media-galleries.create', compact('stores', 'selectedStoreId'));
    }

    /**
     * تخزين صور المعرض الجديدة مع فاليديشن قوي، الصلاحيات، وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', MediaGallery::class);

        $request->validate([
            'stores_id'  => 'required|integer|exists:stores,id',
            'images'     => 'required|array|min:1',
            'images.*'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // كل صورة بحد أقصى 2 ميجا
            'title'      => 'nullable|string|max:150',
            'media_type' => 'nullable|string|max:45',
        ], [
            'stores_id.required' => 'حقل المتجر إلزامي، يرجى اختيار المتجر التابع له الصور.',
            'stores_id.exists'   => 'المتجر المختار غير موجود في النظام.',
            'images.required'    => 'يجب اختيار ملف صورة واحدة على الأقل.',
            'images.array'       => 'بيانات الصور المرسلة غير صالحة.',
            'images.min'         => 'يجب رفع صورة واحدة على الأقل.',
            'images.*.image'     => 'الملف المرفوع يجب أن يكون صورة صالحَة.',
            'images.*.mimes'     => 'يُسمح فقط بالصيغ التالية: jpeg, png, jpg, gif, svg.',
            'images.*.max'       => 'حجم الصورة الواحدة يجب ألا يتجاوز 2 ميجابايت.',
            'title.max'          => 'عنوان الصورة يجب ألا يتجاوز 150 حرفاً.',
            'media_type.max'     => 'نوع الوسائط طويل جداً.',
        ]);

        DB::beginTransaction();
        try {
            $uploadedPaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imageName = time() . '_gallery_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('storage/stores/gallery'), $imageName);

                    $filePath = 'storage/stores/gallery/' . $imageName;
                    $uploadedPaths[] = $filePath;

                    MediaGallery::create([
                        'file_path'  => $filePath,
                        'media_type' => $request->media_type ?? 'gallery',
                        'title'      => $request->title,
                        'stores_id'  => $request->stores_id,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم رفع وتخزين صور المعرض بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // تنظيف الملفات المرفوعة في حال حدوث خطأ في قاعدة البيانات
            foreach ($uploadedPaths as $path) {
                if (File::exists(public_path($path))) {
                    File::delete(public_path($path));
                }
            }

            Log::error('متجر رونق: فشل رفع وتخزين صور المعرض', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ صور المعرض في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل صورة معينة في المعرض.
     */
    public function show($id)
    {
        $mediaGallery = MediaGallery::with('store')->findOrFail($id);

        $this->authorize('view', $mediaGallery);

        return view('cms.media-galleries.show', compact('mediaGallery'));
    }

    /**
     * عرض صفحة تعديل بيانات صورة المعرض.
     */
    public function edit($id)
    {
        $mediaGallery = MediaGallery::findOrFail($id);

        $this->authorize('update', $mediaGallery);

        $stores = Store::all();

        return view('cms.media-galleries.edit', compact('mediaGallery', 'stores'));
    }

    /**
     * تحديث بيانات صورة المعرض مع الصلاحيات والفاليديشن وحماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $media = MediaGallery::findOrFail($id);

        $this->authorize('update', $media);

        $request->validate([
            'stores_id'  => 'required|integer|exists:stores,id',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'      => 'nullable|string|max:150',
            'media_type' => 'nullable|string|max:45',
        ], [
            'stores_id.required' => 'حقل المتجر إلزامي.',
            'stores_id.exists'   => 'المتجر المختار غير مسجل.',
            'image.image'        => 'الملف المرفوع يجب أن يكون صورة.',
            'image.mimes'        => 'صيغة الصورة غير مدعومة (يُسمح بـ jpeg, png, jpg, gif, svg).',
            'image.max'          => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',
            'title.max'          => 'عنوان الصورة يجب ألا يتجاوز 150 حرفاً.',
            'media_type.max'     => 'نوع الوسائط طويل جداً.',
        ]);

        DB::beginTransaction();
        try {
            $filePath = $media->file_path;
            $newFilePath = null;

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = time() . '_gallery_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('storage/stores/gallery'), $imageName);
                $newFilePath = 'storage/stores/gallery/' . $imageName;
                $filePath = $newFilePath;
            }

            $media->update([
                'file_path'  => $filePath,
                'media_type' => $request->media_type ?? 'gallery',
                'title'      => $request->title,
                'stores_id'  => $request->stores_id,
            ]);

            // حذف الصورة القديمة من السيرفر بعد نجاح التحديث في قاعدة البيانات
            if ($newFilePath && $media->getOriginal('file_path') && File::exists(public_path($media->getOriginal('file_path')))) {
                File::delete(public_path($media->getOriginal('file_path')));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات الصورة بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // حذف الصورة الجديدة إذا حدث خطأ في قاعدة البيانات
            if (isset($newFilePath) && File::exists(public_path($newFilePath))) {
                File::delete(public_path($newFilePath));
            }

            Log::error('متجر رونق: فشل تحديث بيانات صورة المعرض', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تحديث بيانات الصورة.',
            ], 500);
        }
    }

    /**
     * حذف صورة المعرض من القاعدة والسيرفر مع الصلاحيات وحماية الـ Transactions.
     */
    public function destroy($id)
    {
        $media = MediaGallery::findOrFail($id);

        $this->authorize('delete', $media);

        DB::beginTransaction();
        try {
            $filePath = $media->file_path;

            $media->delete();

            // حذف الملف الفعلي من السيرفر بعد نجاح الحذف من قاعدة البيانات
            if ($filePath && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف الصورة من المعرض بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف صورة المعرض', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف الصورة من النظام.',
            ], 500);
        }
    }
}
