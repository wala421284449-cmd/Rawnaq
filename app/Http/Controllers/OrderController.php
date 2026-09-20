<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\OrderStatusNotification;

class OrderController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة الطلبات والحجوزات مع جلب العلاقات (المتجر والمستخدم) والتصفح.
     */
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::with(['store', 'user'])->latest()->paginate(10);
        return view('cms.order.index', compact('orders'));
    }

    /**
     * عرض صفحة إنشاء طلب أو حجز جديد مع تمرير المتاجر والمستخدمين.
     */
    public function create()
    {
        $this->authorize('create', Order::class);

        $stores = Store::all();
        $users = User::all();
        return view('cms.order.create', compact('stores', 'users'));
    }

    /**
     * تخزين طلب أو حجز جديد مع Validation محكم وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Order::class);

        $request->validate([
            'customer_name'  => 'required|string|min:2|max:45',
            'customer_phone' => 'required|string|max:45',
            'type'           => 'required|string|max:45',
            'total_amount'   => 'required|numeric|min:0',
            'status'         => 'required|string|max:45',
            'booking_date'   => 'nullable|date',
            'stores_id'      => 'required|exists:stores,id',
            'user_id'        => 'required|exists:users,id',
        ], [
            'customer_name.required'  => 'اسم العميل حقل إلزامي.',
            'customer_name.min'       => 'اسم العميل يجب ألا يقل عن حرفين.',
            'customer_phone.required' => 'رقم هاتف العميل حقل إلزامي.',
            'type.required'           => 'نوع الطلب/الحجز حقل إلزامي.',
            'total_amount.required'   => 'الإجمالي حقل إلزامي.',
            'total_amount.numeric'    => 'الإجمالي يجب أن يكون قيمة رقمية.',
            'status.required'         => 'حالة الطلب حقل إلزامي.',
            'stores_id.required'      => 'يجب اختيار المتجر التابع له الطلب.',
            'stores_id.exists'        => 'المتجر المختار غير موجود.',
            'user_id.required'        => 'يجب اختيار المستخدم.',
            'user_id.exists'          => 'المستخدم المختار غير موجود.',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create($request->all());

            // إرسال الإشعار للمستخدم/المشرف الحالي النشط في لوحة التحكم بكل أمان
            $activeUser = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();
            if ($activeUser) {
                $activeUser->notify(new OrderStatusNotification($order));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم حفظ الطلب أو الحجز الجديد بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ الطلب أو الحجز', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ الطلب في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل طلب أو حجز معين.
     */
    public function show($id)
    {
        $order = Order::with(['store', 'user', 'items.product'])->findOrFail($id);

        $this->authorize('view', $order);

        return view('cms.order.show', compact('order'));
    }

    /**
     * عرض صفحة تعديل الطلب أو الحجز.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        $this->authorize('update', $order);

        $stores = Store::all();
        $users = User::all();

        return view('cms.order.edit', compact('order', 'stores', 'users'));
    }

    /**
     * تحديث بيانات الطلب أو الحجز مع حماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $this->authorize('update', $order);

        $request->validate([
            'customer_name'  => 'required|string|min:2|max:45',
            'customer_phone' => 'required|string|max:45',
            'type'           => 'required|string|max:45',
            'total_amount'   => 'required|numeric|min:0',
            'status'         => 'required|string|max:45',
            'booking_date'   => 'nullable|date',
            'stores_id'      => 'required|exists:stores,id',
            'user_id'        => 'required|exists:users,id',
        ], [
            'customer_name.required'  => 'اسم العميل حقل إلزامي.',
            'customer_phone.required' => 'رقم هاتف العميل حقل إلزامي.',
            'type.required'           => 'نوع الطلب حقل إلزامي.',
            'total_amount.required'   => 'الإجمالي حقل إلزامي.',
            'status.required'         => 'حالة الطلب حقل إلزامي.',
            'stores_id.required'      => 'يجب اختيار المتجر.',
            'user_id.required'        => 'يجب اختيار المستخدم.',
        ]);

        DB::beginTransaction();
        try {
            $order->update($request->all());

            // إرسال الإشعار للمستخدم الحالي عند التحديث
            $activeUser = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();
            if ($activeUser) {
                $activeUser->notify(new OrderStatusNotification($order));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات الطلب بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث بيانات الطلب', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تعديل بيانات الطلب.',
            ], 500);
        }
    }

    /**
     * حذف الطلب من النظام مع حماية بالـ Transactions.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $this->authorize('delete', $order);

        DB::beginTransaction();
        try {
            $order->delete();

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف الطلب نهائياً من النظام.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف الطلب', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف الطلب من النظام.',
            ], 400);
        }
    }
}
