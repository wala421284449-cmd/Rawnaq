<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('role', 'admin') // أو جدول Admins إن كان منفصلاً
            ->with('address.city')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $address = Address::with('city')->latest()->get();

        return response()->view('cms.admin.create', compact('address'));
    }

    /**
     * Store a newly created resource in storage.
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
            'name.required'       => 'اسم المشرف مطلوب.',
            'name.min'            => 'يجب ألا يقل الاسم عن 3 أحرف.',
            'name.max'            => 'يجب ألا يتجاوز الاسم 45 حرفاً.',
            'email.required'      => 'البريد الإلكتروني مطلوب.',
            'email.email'         => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'        => 'هذا البريد الإلكتروني مسجل مسبقاً لمستخدم آخر.',
            'phone.required'      => 'رقم الهاتف مطلوب.',
            'password.required'   => 'كلمة المرور مطلوبة.',
            'password.min'        => 'يجب ألا تقل كلمة المرور عن 6 خانات.',
            'gender.required'     => 'يرجى تحديد جنس المشرف.',
            'gender.in'           => 'قيمة الجنس المحددة غير صحيحة.',
            'status.required'     => 'يرجى تحديد حالة الحساب.',
            'status.in'           => 'حالة الحساب يجب أن تكون نشط أو غير نشط.',
            'address_id.required' => 'يرجى اختيار العنوان المسجل.',
            'address_id.exists'   => 'العنوان المختار غير مسجل في النظام.',
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

        $admin = new User();
        $admin->name         = $request->input('name');
        $admin->email        = $request->input('email');
        $admin->phone        = $request->input('phone');
        $admin->password     = Hash::make($request->input('password'));
        $admin->gender       = $request->input('gender');
        $admin->role         = 'admin';
        $admin->status       = $request->input('status');
        $admin->addresses_id = $request->input('address_id'); // ربط المفتاح الأجنبي

        $isSaved = $admin->save();

        return response()->json([
            'icon'    => $isSaved ? 'success' : 'error',
            'title'   => $isSaved ? 'تم بنجاح' : 'فشلت العملية',
            'text'    => $isSaved ? 'تمت إضافة المشرف بنجاح' : 'تعذر حفظ المشرف في قاعدة البيانات',
            'message' => $isSaved ? 'تمت إضافة المشرف بنجاح' : 'تعذر حفظ المشرف في قاعدة البيانات'
        ], $isSaved ? 201 : 400);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = User::with('address.city')->findOrFail($id);
        return view('cms.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin   = User::findOrFail($id);
        $address = Address::with('city')->latest()->get();

        return response()->view('cms.admin.edit', compact('admin', 'address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $admin = User::findOrFail($id);

        $validator = validator($request->all(), [
            'name'       => 'required|string|min:3|max:45',
            'email'      => 'required|email|max:45|unique:users,email,' . $admin->id,
            'phone'      => 'required|string|max:45',
            'password'   => 'nullable|string|min:6', // اختياري عند التعديل
            'gender'     => 'required|in:male,female',
            'status'     => 'required|in:active,inactive',
            'address_id' => 'required|exists:addresses,id',
        ], [
            'name.required'       => 'اسم المشرف مطلوب.',
            'name.min'            => 'يجب ألا يقل الاسم عن 3 أحرف.',
            'email.required'      => 'البريد الإلكتروني مطلوب.',
            'email.unique'        => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'phone.required'      => 'رقم الهاتف مطلوب.',
            'password.min'        => 'يجب ألا تقل كلمة المرور عن 6 خانات إن تم تغييرها.',
            'gender.required'     => 'يرجى تحديد جنس المشرف.',
            'status.required'     => 'يرجى تحديد حالة الحساب.',
            'address_id.required' => 'يرجى اختيار العنوان المسجل.',
            'address_id.exists'   => 'العنوان المختار غير مسجل في النظام.',
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

        $admin->name         = $request->input('name');
        $admin->email        = $request->input('email');
        $admin->phone        = $request->input('phone');

        // تعديل كلمة المرور فقط إذا قام المستخدم بإدخال كلمة مرور جديدة
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        $admin->gender       = $request->input('gender');
        $admin->status       = $request->input('status');
        $admin->addresses_id = $request->input('address_id');

        $isSaved = $admin->save();

        return response()->json([
            'icon'    => $isSaved ? 'success' : 'error',
            'title'   => $isSaved ? 'تم التعديل بنجاح' : 'فشلت العملية',
            'text'    => $isSaved ? 'تم تحديث بيانات المشرف بنجاح' : 'تعذر تحديث المشرف في قاعدة البيانات',
            'message' => $isSaved ? 'تم تحديث بيانات المشرف بنجاح' : 'تعذر تحديث المشرف في قاعدة البيانات'
        ], $isSaved ? 200 : 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $isDeleted = $admin->delete();

        if ($isDeleted) {
            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف حساب المشرف من النظام',
                'message' => 'تم حذف حساب المشرف من النظام'
            ], 200);
        }

        return response()->json([
            'icon'    => 'error',
            'title'   => 'فشلت العملية',
            'text'    => 'تعذر حذف المشرف، يرجى المحاولة لاحقاً',
            'message' => 'تعذر حذف المشرف، يرجى المحاولة لاحقاً'
        ], 400);
    }
}
