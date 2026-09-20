<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة المتاجر
     */
    public function index()
    {
        $this->authorize('viewAny', Store::class);

        $stores = Store::with(['user', 'address.city'])->orderBy('id', 'desc')->paginate(10);
        return view('cms.store.index', compact('stores'));
    }

    /**
     * عرض صفحة إضافة متجر جديد
     */
    public function create()
    {
        $this->authorize('create', Store::class);

        $users = User::all();
        $addresses = Address::with('city')->get();
        return view('cms.store.create', compact('users', 'addresses'));
    }

    /**
     * حفظ المتجر الجديد في قاعدة البيانات مع الفاليديشن وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Store::class);

        $request->validate([
            'name'            => 'required|string|max:150',
            'slug'            => 'nullable|string|max:150|unique:stores,slug',
            'description'     => 'nullable|string',
            'whatsapp_number' => 'required|string|max:45',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'user_id'         => 'required|exists:users,id',
            'address_id'      => 'required|exists:addresses,id',
            'status'          => 'required|in:active,inactive',
        ], [
            'name.required'            => 'اسم المتجر حقل إلزامي.',
            'slug.unique'              => 'الرابط المختصر مستخدم من قبل، يجدر أن يكون فريداً.',
            'whatsapp_number.required' => 'رقم الواتساب حقل إلزامي للتواصل.',
            'logo.image'               => 'شعار المتجر يجب أن يكون صورة.',
            'logo.max'                 => 'حجم الشعار يجب ألا يتجاوز 2 ميجابايت.',
            'cover_image.image'        => 'صورة الغلاف يجب أن تكون صورة.',
            'cover_image.max'          => 'حجم صورة الغلاف يجب ألا يتجاوز 2 ميجابايت.',
            'user_id.required'         => 'يجب تحديد مالك المتجر.',
            'user_id.exists'           => 'المالك المختار غير موجود في النظام.',
            'address_id.required'      => 'يجب تحديد عنوان المتجر.',
            'address_id.exists'        => 'العنوان المختار غير موجود في النظام.',
            'status.in'                => 'حالة المتجر غير صحيحة.',
        ]);

        DB::beginTransaction();
        try {
            $logoPath = null;
            $coverPath = null;

            // معالجة رفع الشعار
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('stores/logos', 'public');
            }

            // معالجة رفع صورة الغلاف
            if ($request->hasFile('cover_image')) {
                $coverPath = $request->file('cover_image')->store('stores/covers', 'public');
            }

            // توليد الـ Slug تلقائياً إذا لم تقم بإدخاله
            $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

            // التأكد من تفرد الـ Slug نهائياً
            $originalSlug = $slug;
            $counter = 1;
            while (Store::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            Store::create([
                'name'            => $request->name,
                'slug'            => $slug,
                'description'     => $request->description,
                'whatsapp_number' => $request->whatsapp_number,
                'logo'            => $logoPath,
                'cover_image'     => $coverPath,
                'user_id'         => $request->user_id,
                'address_id'      => $request->address_id,
                'status'          => $request->status,
            ]);

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم إنشاء المتجر الجديد بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // تنظيف الملفات المرفوعة في حال حدوث خطأ
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            if ($coverPath && Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }

            Log::error('متجر رونق: فشل حفظ المتجر الجديد', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ المتجر في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل متجر معين
     */
    public function show(Store $store)
    {
        $this->authorize('view', $store);

        $store->load(['user', 'address.city']);
        return view('cms.store.show', compact('store'));
    }

    /**
     * عرض صفحة التعديل
     */
    public function edit(Store $store)
    {
        $this->authorize('update', $store);

        $users = User::all();
        $addresses = Address::with('city')->get();
        return view('cms.store.edit', compact('store', 'users', 'addresses'));
    }

    /**
     * تحديث بيانات المتجر مع الفاليديشن وحماية بالـ Transactions.
     */
    public function update(Request $request, Store $store)
    {
        $this->authorize('update', $store);

        $request->validate([
            'name'            => 'required|string|max:150',
            'slug'            => 'nullable|string|max:150|unique:stores,slug,' . $store->id,
            'description'     => 'nullable|string',
            'whatsapp_number' => 'required|string|max:45',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'user_id'         => 'required|exists:users,id',
            'address_id'      => 'required|exists:addresses,id',
            'status'          => 'required|in:active,inactive',
        ], [
            'name.required'            => 'اسم المتجر حقل إلزامي.',
            'slug.unique'              => 'الرابط المختصر مستخدم من قبل.',
            'whatsapp_number.required' => 'رقم الواتساب حقل إلزامي.',
            'user_id.required'         => 'يجب تحديد مالك المتجر.',
            'address_id.required'      => 'يجب تحديد عنوان المتجر.',
        ]);

        DB::beginTransaction();
        try {
            $logoPath = $store->logo;
            $coverPath = $store->cover_image;
            $newLogoPath = null;
            $newCoverPath = null;

            if ($request->hasFile('logo')) {
                $newLogoPath = $request->file('logo')->store('stores/logos', 'public');
                $logoPath = $newLogoPath;
            }

            if ($request->hasFile('cover_image')) {
                $newCoverPath = $request->file('cover_image')->store('stores/covers', 'public');
                $coverPath = $newCoverPath;
            }

            $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

            // منع تكرار الـ slug مع استثناء المتجر الحالي
            $originalSlug = $slug;
            $counter = 1;
            while (Store::where('slug', $slug)->where('id', '!=', $store->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            $store->update([
                'name'            => $request->name,
                'slug'            => $slug,
                'description'     => $request->description,
                'whatsapp_number' => $request->whatsapp_number,
                'logo'            => $logoPath,
                'cover_image'     => $coverPath,
                'user_id'         => $request->user_id,
                'address_id'      => $request->address_id,
                'status'          => $request->status,
            ]);

            // حذف الملفات القديمة من السيرفر بعد نجاح التحديث
            if ($newLogoPath && $store->getOriginal('logo') && Storage::disk('public')->exists($store->getOriginal('logo'))) {
                Storage::disk('public')->delete($store->getOriginal('logo'));
            }
            if ($newCoverPath && $store->getOriginal('cover_image') && Storage::disk('public')->exists($store->getOriginal('cover_image'))) {
                Storage::disk('public')->delete($store->getOriginal('cover_image'));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات المتجر بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // حذف الملفات الجديدة إذا حدث خطأ
            if (isset($newLogoPath) && Storage::disk('public')->exists($newLogoPath)) {
                Storage::disk('public')->delete($newLogoPath);
            }
            if (isset($newCoverPath) && Storage::disk('public')->exists($newCoverPath)) {
                Storage::disk('public')->delete($newCoverPath);
            }

            Log::error('متجر رونق: فشل تحديث بيانات المتجر', [
                'id'    => $store->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تعديل بيانات المتجر.',
            ], 500);
        }
    }

    /**
     * حذف المتجر مع إزالة صوره المرتبطة من السيرفر.
     */
    public function destroy(Store $store)
    {
        $this->authorize('delete', $store);

        DB::beginTransaction();
        try {
            $logoPath = $store->logo;
            $coverPath = $store->cover_image;

            $store->delete();

            // حذف الصور المرتبطة من التخزين بعد نجاح الحذف من القاعدة
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            if ($coverPath && Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف المتجر بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف المتجر', [
                'id'    => $store->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف المتجر لوجود بيانات مرتبطة به.',
            ], 400);
        }
    }
}
