<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة التقييمات مع جلب العلاقات (المستخدم، المنتج، الطلب) والتصفح.
     */
    public function index()
    {
        $this->authorize('viewAny', Review::class);

        $reviews = Review::with(['user', 'product', 'order'])->latest()->paginate(10);
        return view('cms.review.index', compact('reviews'));
    }

    /**
     * عرض صفحة إنشاء تقييم جديد مع تمرير المستخدمين والمنتجات والطلبات.
     */
    public function create()
    {
        $this->authorize('create', Review::class);

        $users = User::all();
        $products = Product::all();
        $orders = Order::all();
        return view('cms.review.create', compact('users', 'products', 'orders'));
    }

    /**
     * تخزين تقييم جديد في قاعدة البيانات مع Validation دقيق وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Review::class);

        $request->validate([
            'rating'      => 'required|string|max:45',
            'comment'     => 'required|string|min:3|max:45',
            'is_approved' => 'required|string|in:pending,approved',
            'user_id'     => 'required|exists:users,id',
            'products_id' => 'required|exists:products,id',
            'orders_id'   => 'required|exists:orders,id',
        ], [
            'rating.required'      => 'حقل تقييم النجوم إلزامي.',
            'rating.max'           => 'قيمة التقييم يجب ألا تتجاوز 45 حرفاً.',
            'comment.required'     => 'حقل تعليق العميل إلزامي.',
            'comment.min'          => 'التعليق يجب ألا يقل عن 3 أحرف.',
            'comment.max'          => 'التعليق يجب ألا يتجاوز 45 حرفاً.',
            'is_approved.required' => 'حالة الموافقة حقل إلزامي.',
            'is_approved.in'       => 'حالة الموافقة المختارة غير صالحة.',
            'user_id.required'     => 'يجب اختيار المستخدم صاحب التقييم.',
            'user_id.exists'       => 'المستخدم المختار غير موجود في النظام.',
            'products_id.required' => 'يجب اختيار المنتج المراد تقييمه.',
            'products_id.exists'   => 'المنتج المختار غير موجود في النظام.',
            'orders_id.required'   => 'يجب اختيار الطلب المرتبط بالتقييم.',
            'orders_id.exists'     => 'الطلب المختار غير موجود في النظام.',
        ]);

        DB::beginTransaction();
        try {
            Review::create($request->all());

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم حفظ تقييم العميل الجديد بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ تقييم العميل', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ التقييم في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل تقييم معين مع علاقاته.
     */
    public function show($id)
    {
        $review = Review::with(['user', 'product', 'order'])->findOrFail($id);

        $this->authorize('view', $review);

        return view('cms.review.show', compact('review'));
    }

    /**
     * عرض صفحة تعديل بيانات التقييم مع تمرير البيانات اللازمة.
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);

        $this->authorize('update', $review);

        $users = User::all();
        $products = Product::all();
        $orders = Order::all();

        return view('cms.review.edit', compact('review', 'users', 'products', 'orders'));
    }

    /**
     * تحديث بيانات التقييم وحالة اعتماده مع Validation محكم وحماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $this->authorize('update', $review);

        $request->validate([
            'rating'      => 'required|string|max:45',
            'comment'     => 'required|string|min:3|max:45',
            'is_approved' => 'required|string|in:pending,approved',
        ], [
            'rating.required'      => 'حقل تقييم النجوم إلزامي.',
            'rating.max'           => 'قيمة التقييم يجب ألا تتجاوز 45 حرفاً.',
            'comment.required'     => 'حقل تعليق العميل إلزامي.',
            'comment.min'          => 'التعليق يجب ألا يقل عن 3 أحرف.',
            'comment.max'          => 'التعليق يجب ألا يتجاوز 45 حرفاً.',
            'is_approved.required' => 'حالة الموافقة حقل إلزامي.',
            'is_approved.in'       => 'حالة الموافقة المختارة غير صالحة.',
        ]);

        DB::beginTransaction();
        try {
            $review->update($request->all());

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات التقييم وحالته بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث تقييم العميل', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تعديل بيانات التقييم.',
            ], 500);
        }
    }

    /**
     * حذف التقييم من النظام نهائياً مع حماية بالـ Transactions.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        $this->authorize('delete', $review);

        DB::beginTransaction();
        try {
            $review->delete();

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف التقييم نهائياً من النظام.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف تقييم العميل', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف التقييم من النظام.',
            ], 400);
        }
    }
}
