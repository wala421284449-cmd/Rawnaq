<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactMessageController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة رسائل التواصل مع دعم الفلترة حسب المتجر.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ContactMessage::class);

        $storeId = $request->get('store_id');

        $messages = ContactMessage::with(['store', 'user'])
            ->when($storeId, function ($query, $storeId) {
                return $query->where('stores_id', $storeId);
            })
            ->latest()
            ->paginate(10);

        return view('cms.contact-messages.index', compact('messages', 'storeId'));
    }

    /**
     * عرض صفحة نموذج إضافة رسالة تواصل جديدة.
     */
    public function create()
    {
        $this->authorize('create', ContactMessage::class);

        $stores = Store::all();
        return view('cms.contact-messages.create', compact('stores'));
    }

    /**
     * تخزين رسالة تواصل جديدة مع Validation محكم وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ContactMessage::class);

        $request->validate([
            'stores_id'      => 'required|integer|exists:stores,id',
            'name'           => 'required|string|min:3|max:45',
            'phone_or_email' => ['required', 'string', 'max:45', function ($attribute, $value, $fail) {
                $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);
                $isPhone = preg_match('/^[0-9\+\-\s\(\)]+$/', $value);

                if (!$isEmail && !$isPhone) {
                    $fail('حقل وسيلة الاتصال يجب أن يكون بريداً إلكترونياً صالحاً أو رقم هاتف صحيح.');
                }
            }],
            'subject'        => 'required|string|min:3|max:45',
            'message'        => 'required|string|min:10',
        ], [
            'stores_id.required'      => 'حقل المتجر المستهدف إلزامي، يرجى اختيار المتجر.',
            'stores_id.exists'        => 'المتجر المختار غير مسجل في النظام.',
            'name.required'           => 'اسم المرسل حقل إلزامي.',
            'name.string'             => 'اسم المرسل يجب أن يكون نصاً صالحاً.',
            'name.min'                => 'اسم المرسل يجب ألا يقل عن 3 أحرف.',
            'name.max'                => 'اسم المرسل يجب ألا يتجاوز 45 حرفاً.',
            'phone_or_email.required' => 'وسيلة الاتصال (الهاتف أو البريد) إجبارية.',
            'subject.required'        => 'موضوع الرسالة حقل إلزامي.',
            'message.required'        => 'نص الرسالة محتوى أساسي لا يمكن إفراغه.',
            'message.min'             => 'نص الرسالة قصير جداً، يجب ألا يقل عن 10 أحرف لتوضيح الاستفسار.',
        ]);

        DB::beginTransaction();
        try {
            ContactMessage::create([
                'stores_id'      => $request->stores_id,
                'name'           => $request->name,
                'phone_or_email' => $request->phone_or_email,
                'subject'        => $request->subject,
                'message'        => $request->message,
                'is_read'        => 'unread',
                'user_id'        => auth('admin')->id(),
            ]);

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم حفظ رسالة التواصل وإرسالها بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ رسالة التواصل', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ رسالة التواصل في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل رسالة تواصل معينة (مع تحويل حالتها إلى مقروء تلقائياً).
     */
    public function show($id)
    {
        $message = ContactMessage::with(['store', 'user'])->findOrFail($id);
        $this->authorize('view', $message);

        if ($message->is_read === 'unread') {
            $message->update(['is_read' => 'read']);
        }

        return view('cms.contact-messages.show', compact('message'));
    }

    /**
     * عرض صفحة تعديل رسالة تواصل.
     */
    public function edit($id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('update', $message);

        $stores = Store::all();
        return view('cms.contact-messages.edit', compact('message', 'stores'));
    }

    /**
     * تحديث بيانات رسالة التواصل مع Validation محكم وحماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('update', $message);

        $request->validate([
            'stores_id'      => 'required|integer|exists:stores,id',
            'name'           => 'required|string|min:3|max:45',
            'phone_or_email' => 'required|string|max:45',
            'subject'        => 'required|string|min:3|max:45',
            'message'        => 'required|string|min:10',
            'is_read'        => 'required|in:unread,read,replied',
        ], [
            'stores_id.required'      => 'حقل المتجر إلزامي.',
            'stores_id.exists'        => 'المتجر المختار غير موجود.',
            'name.required'           => 'اسم المرسل مطلوب.',
            'name.min'                => 'اسم المرسل قصير جداً.',
            'name.max'                => 'اسم المرسل يجب ألا يتجاوز 45 حرفاً.',
            'phone_or_email.required' => 'وسيلة الاتصال مطلوبة.',
            'subject.required'        => 'موضوع الرسالة مطلوب.',
            'message.required'        => 'نص الرسالة مطلوب.',
            'message.min'             => 'نص الرسالة يجب ألا يقل عن 10 أحرف.',
            'is_read.required'        => 'حالة القراءة مطلوبة.',
            'is_read.in'              => 'قيمة حالة القراءة المحددة غير صالحة.',
        ]);

        DB::beginTransaction();
        try {
            $message->update($request->all());

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات رسالة التواصل بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث رسالة التواصل', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تعديل بيانات رسالة التواصل.',
            ], 500);
        }
    }

    /**
     * تحديث حالة الرسالة فقط (مستخدمة من صفحة العرض).
     */
    public function updateStatus(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('update', $message);

        $request->validate([
            'is_read' => 'required|in:unread,read,replied',
        ], [
            'is_read.required' => 'حالة القراءة مطلوبة.',
            'is_read.in'       => 'الحالة المختارة غير مدعومة.',
        ]);

        DB::beginTransaction();
        try {
            $message->update([
                'is_read' => $request->is_read,
            ]);

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث',
                'message' => 'تم تغيير حالة الرسالة بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تغيير حالة رسالة التواصل', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تغيير حالة الرسالة.',
            ], 500);
        }
    }

    /**
     * حذف رسالة التواصل من النظام مع حماية بالـ Transactions.
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('delete', $message);

        DB::beginTransaction();
        try {
            $message->delete();

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف رسالة التواصل نهائياً.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف رسالة التواصل', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف رسالة التواصل من النظام.',
            ], 400);
        }
    }
}
