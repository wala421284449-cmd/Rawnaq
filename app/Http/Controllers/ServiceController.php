<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة الخدمات مع جلب العلاقات (المتجر والتصنيف) والتصفح.
     */
    public function index()
    {
        $this->authorize('viewAny', Service::class);

        $services = Service::with(['store', 'category'])->latest()->paginate(10);
        return view('cms.service.index', compact('services'));
    }

    /**
     * عرض صفحة إنشاء خدمة جديدة مع إرسال المتاجر والتصنيفات للقوائم المنسدلة.
     */
    public function create()
    {
        $this->authorize('create', Service::class);

        $stores = Store::all();
        $categories = Category::all();
        return view('cms.service.create', compact('stores', 'categories'));
    }

    /**
     * تخزين خدمة جديدة في النظام مع Validation ممتاز وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Service::class);

        $request->validate([
            'name'             => 'required|string|min:2|max:45',
            'description'      => 'nullable|string|max:255',
            'price'            => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'is_available'     => 'required|in:available,unavailable',
            'stores_id'        => 'required|exists:stores,id',
            'categories_id'    => 'required|exists:categories,id',
        ], [
            'name.required'             => 'اسم الخدمة حقل إلزامي.',
            'name.min'                  => 'اسم الخدمة يجب ألا يقل عن حرفين.',
            'name.max'                  => 'اسم الخدمة يجب ألا يتجاوز 45 حرفاً.',
            'price.required'            => 'سعر الخدمة حقل إلزامي.',
            'price.numeric'             => 'سعر الخدمة يجب أن يكون قيمة رقمية صحيحة.',
            'duration_minutes.required' => 'مدة الخدمة بالدقائق حقل إلزامي.',
            'duration_minutes.integer'  => 'مدة الخدمة يجب أن تكون رقماً صحيحاً.',
            'is_available.required'     => 'حالة توفر الخدمة حقل إلزامي.',
            'is_available.in'           => 'حالة التوفر المختارة غير صالحة.',
            'stores_id.required'        => 'يجب اختيار المتجر التابع له الخدمة.',
            'stores_id.exists'          => 'المتجر المختار غير موجود في النظام.',
            'categories_id.required'    => 'يجب اختيار التصنيف التابع له الخدمة.',
            'categories_id.exists'      => 'التصنيف المختار غير موجود في النظام.',
        ]);

        DB::beginTransaction();
        try {
            Service::create($request->all());

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم حفظ الخدمة الجديدة بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ الخدمة الجديدة', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ الخدمة في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل خدمة معينة.
     */
    public function show($id)
    {
        $service = Service::with(['store', 'category'])->findOrFail($id);

        $this->authorize('view', $service);

        return view('cms.service.show', compact('service'));
    }

    /**
     * عرض صفحة تعديل الخدمة مع جلب البيانات اللازمة.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        $this->authorize('update', $service);

        $stores = Store::all();
        $categories = Category::all();
        return view('cms.service.edit', compact('service', 'stores', 'categories'));
    }

    /**
     * تحديث بيانات الخدمة مع Validation محكم وحماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $this->authorize('update', $service);

        $request->validate([
            'name'             => 'required|string|min:2|max:45',
            'description'      => 'nullable|string|max:255',
            'price'            => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'is_available'     => 'required|in:available,unavailable',
            'stores_id'        => 'required|exists:stores,id',
            'categories_id'    => 'required|exists:categories,id',
        ], [
            'name.required'             => 'اسم الخدمة حقل إلزامي.',
            'name.min'                  => 'اسم الخدمة يجب ألا يقل عن حرفين.',
            'name.max'                  => 'اسم الخدمة يجب ألا يتجاوز 45 حرفاً.',
            'price.required'            => 'سعر الخدمة حقل إلزامي.',
            'price.numeric'             => 'سعر الخدمة يجب أن يكون قيمة رقمية.',
            'duration_minutes.required' => 'مدة الخدمة حقل إلزامي.',
            'duration_minutes.integer'  => 'مدة الخدمة يجب أن تكون رقماً صحيحاً.',
            'is_available.required'     => 'حالة توفر الخدمة حقل إلزامي.',
            'stores_id.required'        => 'يجب اختيار المتجر.',
            'stores_id.exists'          => 'المتجر المختار غير موجود.',
            'categories_id.required'    => 'يجب اختيار التصنيف.',
            'categories_id.exists'      => 'التصنيف المختار غير موجود.',
        ]);

        DB::beginTransaction();
        try {
            $service->update($request->all());

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات الخدمة بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث بيانات الخدمة', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تعديل بيانات الخدمة.',
            ], 500);
        }
    }

    /**
     * حذف الخدمة من النظام مع حماية بالـ Transactions.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $this->authorize('delete', $service);

        DB::beginTransaction();
        try {
            $service->delete();

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف الخدمة نهائياً من النظام.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف الخدمة', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف الخدمة من النظام.',
            ], 400);
        }
    }
}
