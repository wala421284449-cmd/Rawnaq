<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة التصنيفات مع دعم التصفح والبحث إن وجد.
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);

        $categories = Category::latest()->paginate(10);
        return view('cms.category.index', compact('categories'));
    }

    /**
     * عرض صفحة نموذج إنشاء تصنيف جديد.
     */
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('cms.category.create');
    }

    /**
     * تخزين تصنيف جديد مع Validation محكم وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $request->validate([
            'name' => 'required|string|min:2|max:45|unique:categories,name',
            'type' => 'required|string|min:2|max:45',
        ], [
            'name.required' => 'اسم التصنيف حقل إلزامي لا يمكن تركه فارغاً.',
            'name.string'   => 'اسم التصنيف يجب أن يكون نصاً صالحاً.',
            'name.min'      => 'اسم التصنيف قصير جداً، يجب ألا يقل عن حرفين.',
            'name.max'      => 'اسم التصنيف يجب ألا يتجاوز 45 حرفاً.',
            'name.unique'   => 'هذا التصنيف مسجل مسبقاً، يرجى اختيار اسم مختلف.',

            'type.required' => 'نوع التصنيف حقل إلزامي لتحديد التصنيف.',
            'type.string'   => 'نوع التصنيف يجب أن يكون نصاً.',
            'type.min'      => 'نوع التصنيف قصير جداً.',
            'type.max'      => 'نوع التصنيف يجب ألا يتجاوز 45 حرفاً.',
        ]);

        DB::beginTransaction();
        try {
            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
            ]);

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم حفظ التصنيف الجديد وإضافته للنظام بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ التصنيف الجديد', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ التصنيف في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل تصنيف معين.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('view', $category);

        return view('cms.category.show', compact('category'));
    }

    /**
     * عرض صفحة تعديل تصنيف معين.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('update', $category);

        return view('cms.category.edit', compact('category'));
    }

    /**
     * تحديث بيانات التصنيف مع Validation محكم وحماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('update', $category);

        $request->validate([
            'name' => 'required|string|min:2|max:45|unique:categories,name,' . $id,
            'type' => 'required|string|min:2|max:45',
        ], [
            'name.required' => 'اسم التصنيف حقل إلزامي.',
            'name.string'   => 'اسم التصنيف يجب أن يكون نصاً.',
            'name.min'      => 'اسم التصنيف يجب ألا يقل عن حرفين.',
            'name.max'      => 'اسم التصنيف يجب ألا يتجاوز 45 حرفاً.',
            'name.unique'   => 'اسم التصنيف مستخدم في تصنيف آخر، يرجى تغييره.',

            'type.required' => 'نوع التصنيف حقل إلزامي.',
            'type.string'   => 'نوع التصنيف يجب أن يكون نصاً.',
            'type.min'      => 'نوع التصنيف قصير جداً.',
            'type.max'      => 'نوع التصنيف يجب ألا يتجاوز 45 حرفاً.',
        ]);

        DB::beginTransaction();
        try {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
            ]);

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات التصنيف بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث بيانات التصنيف', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تحديث بيانات التصنيف.',
            ], 500);
        }
    }

    /**
     * حذف التصنيف من النظام نهائياً مع حماية بالـ Transactions.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('delete', $category);

        DB::beginTransaction();
        try {
            $category->delete();

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف التصنيف نهائياً من النظام.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف التصنيف', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف التصنيف لوجود منتجات أو بيانات مرتبطة به.',
            ], 400);
        }
    }
}
