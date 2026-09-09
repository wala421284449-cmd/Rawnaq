<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    /**
     * 1. عرض جدول مالكي وموردي متجر رونق
     */
    public function index()
    {
        $owners = User::where('role', 'owner')
            ->with('address.city')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.owner.index', compact('owners'));
    }

    /**
     * 2. عرض صفحة إضافة مالك جديد لمتجر رونق
     */
    public function create()
    {
        $address = Address::with('city')->latest()->get();

        return response()->view('cms.owner.create', compact('address'));
    }

    /**
     * 3. حفظ بيانات المالك الجديد في متجر رونق (AJAX - POST)
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name'       => 'required|string|min:3|max:45',
            'email'      => 'required|email|max:45|unique:users,email',
            'phone'      => 'required|string|max:45',
            'password'   => 'required|string|min:6',
            'gender'     => 'required|in:male,female',
            'status'     => 'required|in:active,inactive',
            'address_id' => 'required|exists:addresses,id',
        ], [
            'name.required'       => 'اسم المالك مطلوب.',
            'name.min'            => 'يجب ألا يقل الاسم عن 3 أحرف.',
            'email.required'      => 'البريد الإلكتروني مطلوب.',
            'email.email'         => 'يرجى كتابة بريد إلكتروني صحيح.',
            'email.unique'        => 'هذا البريد مسجل مسبقاً في متجر رونق.',
            'phone.required'      => 'رقم الهاتف مطلوب.',
            'password.required'   => 'كلمة المرور مطلوبة.',
            'password.min'        => 'يجب ألا تقل كلمة المرور عن 6 خانات.',
            'gender.required'     => 'يرجى اختيار الجنس.',
            'status.required'     => 'يرجى تحديد حالة الحساب.',
            'address_id.required' => 'يرجى اختيار العنوان المسجل.',
            'address_id.exists'   => 'العنوان المحدد غير مسجل في النظام.',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->getMessageBag()->first();

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في إدخال البيانات',
                'text'    => $firstError,
                'message' => $firstError,
                'errors'  => $validator->errors()
            ], 400);
        }

        try {
            $owner = new User();
            $owner->name         = $request->input('name');
            $owner->email        = $request->input('email');
            $owner->phone        = $request->input('phone');
            $owner->password     = Hash::make($request->input('password'));
            $owner->gender       = $request->input('gender');
            $owner->role         = 'owner'; // تعيين الدور كمالك متجر في رونق
            $owner->status       = $request->input('status');
            $owner->addresses_id = $request->input('address_id');
            $owner->save();

            // تسجيل الحدث كـ INFO في السجلات (Audit Logging)
            Log::info('متجر رونق: تم تسجيل حساب مالك جديد بنجاح', [
                'owner_id' => $owner->id,
                'email'    => $owner->email,
                'admin_id' => auth('web')->id() ?? 'لوحة التحكم',
                'ip'       => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم بنجاح',
                'text'    => 'تمت إضافة مالك المتجر بنجاح',
                'message' => 'تمت إضافة مالك المتجر بنجاح'
            ], 201);
        } catch (\Exception $e) {
            // تسجيل الخطأ كـ ERROR في السجلات
            Log::error('متجر رونق: فشل حفظ بيانات المالك في قاعدة البيانات', [
                'error_message' => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
                'ip'            => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'text'    => 'تعذر حفظ بيانات المالك في قاعدة البيانات',
                'message' => 'تعذر حفظ بيانات المالك في قاعدة البيانات'
            ], 500);
        }
    }

    /**
     * 4. عرض تفاصيل ملف المالك في متجر رونق
     */
    public function show($id)
    {
        $owner = User::where('role', 'owner')
            ->with('address.city')
            ->findOrFail($id);

        return response()->view('cms.owner.show', compact('owner'));
    }

    /**
     * 5. عرض صفحة تعديل بيانات المالك
     */
    public function edit($id)
    {
        $owner   = User::where('role', 'owner')->findOrFail($id);
        $address = Address::with('city')->latest()->get();

        return response()->view('cms.owner.edit', compact('owner', 'address'));
    }

    /**
     * 6. تحديث بيانات المالك في متجر رونق (AJAX - PUT/JSON)
     */
    public function update(Request $request, $id)
    {
        $owner = User::where('role', 'owner')->findOrFail($id);

        $validator = validator($request->all(), [
            'name'       => 'required|string|min:3|max:45',
            'email'      => 'required|email|max:45|unique:users,email,' . $owner->id,
            'phone'      => 'required|string|max:45',
            'password'   => 'nullable|string|min:6',
            'gender'     => 'required|in:male,female',
            'status'     => 'required|in:active,inactive',
            'address_id' => 'required|exists:addresses,id',
        ], [
            'name.required'       => 'اسم المالك مطلوب.',
            'email.required'      => 'البريد الإلكتروني مطلوب.',
            'email.unique'        => 'البريد الإلكتروني مستخدم بالفعل.',
            'phone.required'      => 'رقم الهاتف مطلوب.',
            'password.min'        => 'يجب ألا تقل كلمة المرور عن 6 خانات إن تم تعديلها.',
            'gender.required'     => 'يرجى تحديد الجنس.',
            'status.required'     => 'يرجى تحديد حالة الحساب.',
            'address_id.required' => 'يرجى تحديد العنوان.',
            'address_id.exists'   => 'العنوان المحدد غير مسجل بالنظام.',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->getMessageBag()->first();

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في تحديث البيانات',
                'text'    => $firstError,
                'message' => $firstError,
                'errors'  => $validator->errors()
            ], 400);
        }

        try {
            $owner->name         = $request->input('name');
            $owner->email        = $request->input('email');
            $owner->phone        = $request->input('phone');

            if ($request->filled('password')) {
                $owner->password = Hash::make($request->input('password'));
            }

            $owner->gender       = $request->input('gender');
            $owner->status       = $request->input('status');
            $owner->addresses_id = $request->input('address_id');
            $owner->save();

            Log::info('متجر رونق: تم تحديث بيانات المالك بنجاح', [
                'owner_id' => $owner->id,
                'email'    => $owner->email,
                'admin_id' => auth('web')->id() ?? 'لوحة التحكم',
                'ip'       => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم التعديل بنجاح',
                'text'    => 'تم تحديث بيانات المالك في متجر رونق بنجاح',
                'message' => 'تم تحديث بيانات المالك في متجر رونق بنجاح'
            ], 200);
        } catch (\Exception $e) {
            Log::error('متجر رونق: فشل تحديث بيانات المالك', [
                'error_message' => $e->getMessage(),
                'owner_id'      => $id,
                'line'          => $e->getLine(),
                'ip'            => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر تحديث بيانات المالك في قاعدة البيانات',
                'message' => 'تعذر تحديث بيانات المالك في قاعدة البيانات'
            ], 500);
        }
    }

    /**
     * 7. حذف حساب المالك (AJAX - DELETE)
     */
    public function destroy($id)
    {
        try {
            $owner = User::where('role', 'owner')->findOrFail($id);
            $ownerEmail = $owner->email;
            $owner->delete();

            Log::info('متجر رونق: تم حذف حساب المالك', [
                'deleted_owner_id' => $id,
                'email'            => $ownerEmail,
                'admin_id'         => auth('web')->id() ?? 'لوحة التحكم',
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف حساب المالك من متجر رونق',
                'message' => 'تم حذف حساب المالك من متجر رونق'
            ], 200);
        } catch (\Exception $e) {
            Log::error('متجر رونق: فشل حذف حساب المالك', [
                'error_message' => $e->getMessage(),
                'owner_id'      => $id,
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر حذف المالك لوجود بيانات مرتبطة به في المتجر',
                'message' => 'تعذر حذف المالك لوجود بيانات مرتبطة به في المتجر'
            ], 400);
        }
    }
}
