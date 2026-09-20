<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OwnerController extends Controller
{
    use AuthorizesRequests;

    /**
     * 1. عرض جدول مالكي وموردي متجر رونق
     */
    public function index()
    {
        $this->authorize('viewAny', Owner::class);

        $owners = User::where('role', 'owner')
            ->with(['actor', 'address.city'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.owner.index', compact('owners'));
    }

    /**
     * 2. عرض صفحة إضافة مالك جديد لمتجر رونق
     */
    public function create()
    {
        $this->authorize('create', Owner::class);

        $address = Address::with('city')->latest()->get();
        $roles   = Role::all();

        return response()->view('cms.owner.create', compact('address', 'roles'));
    }

    /**
     * 3. حفظ بيانات المالك الجديد في متجر رونق (AJAX - POST)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Owner::class);

        $validator = validator($request->all(), [
            'name'            => 'required|string|min:3|max:45',
            'email'           => 'required|email|max:45|unique:users,email',
            'phone'           => 'required|string|max:45',
            'password'        => 'required|string|min:6',
            'id_number'       => 'required|string|max:20',
            'whats_up_number' => 'required|string|max:45',
            'gender'          => 'required|in:male,female',
            'status'          => 'required|in:active,inactive',
            'address_id'      => 'required|exists:addresses,id',
            'role_name'       => 'required|exists:roles,name',
        ], [
            'name.required'            => 'اسم المالك مطلوب.',
            'name.min'                 => 'يجب ألا يقل الاسم عن 3 أحرف.',
            'email.required'           => 'البريد الإلكتروني مطلوب.',
            'email.email'              => 'يرجى كتابة بريد إلكتروني صحيح.',
            'email.unique'             => 'هذا البريد مسجل مسبقاً في متجر رونق.',
            'phone.required'           => 'رقم الهاتف مطلوب.',
            'password.required'        => 'كلمة المرور مطلوبة.',
            'password.min'             => 'يجب ألا تقل كلمة المرور عن 6 خانات.',
            'id_number.required'       => 'رقم الهوية مطلوب.',
            'whats_up_number.required' => 'رقم الواتساب مطلوب.',
            'gender.required'          => 'يرجى اختيار الجنس.',
            'status.required'          => 'يرجى تحديد حالة الحساب.',
            'address_id.required'      => 'يرجى اختيار العنوان المسجل.',
            'address_id.exists'        => 'العنوان المحدد غير مسجل في النظام.',
            'role_name.required'       => 'يرجى اختيار المسمى الوظيفي.',
            'role_name.exists'         => 'المسمى الوظيفي المحدد غير موجود.',
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

        DB::beginTransaction();
        try {
            // 1. إنشاء سجل المالك وحفظ الهوية والواتساب في جدول owners
            $ownerActor = new Owner();
            $ownerActor->id_number       = $request->input('id_number');
            $ownerActor->whats_up_number = $request->input('whats_up_number');
            $ownerActor->save();

            // 2. إنشاء المستخدم وربطه بالمالك عبر المورف (actor)
            $user = new User();
            $user->name         = $request->input('name');
            $user->email        = $request->input('email');
            $user->phone        = $request->input('phone');
            $user->password     = Hash::make($request->input('password'));
            $user->gender       = $request->input('gender');
            $user->role         = 'owner';
            $user->status       = $request->input('status');
            $user->addresses_id = $request->input('address_id');

            // ربط الـ Polymorphic Actor
            $user->actor_id     = $ownerActor->id;
            $user->actor_type   = Owner::class;
            $user->save();

            // تعيين الدور للمالك
            $user->assignRole($request->input('role_name'));

            DB::commit();

            Log::info('متجر رونق: تم تسجيل حساب مالك جديد بنجاح', [
                'user_id'  => $user->id,
                'owner_id' => $ownerActor->id,
                'email'    => $user->email,
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
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ بيانات المالك في قاعدة البيانات', [
                'error_message' => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
                'ip'            => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'text'    => 'تعذر حفظ بيانات المالك: ' . $e->getMessage(),
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
            ->with(['actor', 'address.city'])
            ->findOrFail($id);

        $this->authorize('view', $owner->actor ?? $owner);

        return response()->view('cms.owner.show', compact('owner'));
    }

    /**
     * 5. عرض صفحة تعديل بيانات المالك
     */
    public function edit($id)
    {
        $owner   = User::where('role', 'owner')->with('actor')->findOrFail($id);
        $address = Address::with('city')->latest()->get();

        $this->authorize('update', $owner->actor ?? $owner);

        return response()->view('cms.owner.edit', compact('owner', 'address'));
    }

    /**
     * 6. تحديث بيانات المالك في متجر رونق (AJAX - PUT/POST/JSON)
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'owner')->with('actor')->findOrFail($id);

        $this->authorize('update', $user->actor ?? $user);

        $validator = validator($request->all(), [
            'name'            => 'required|string|min:3|max:45',
            'email'           => 'required|email|max:45|unique:users,email,' . $user->id,
            'phone'           => 'required|string|max:45',
            'password'        => 'nullable|string|min:6',
            'id_number'       => 'required|string|max:20',
            'whats_up_number' => 'required|string|max:45',
            'gender'          => 'required|in:male,female',
            'status'          => 'required|in:active,inactive',
            'address_id'      => 'required|exists:addresses,id',
        ], [
            'name.required'            => 'اسم المالك مطلوب.',
            'email.required'           => 'البريد الإلكتروني مطلوب.',
            'email.unique'             => 'البريد الإلكتروني مستخدم بالفعل.',
            'phone.required'           => 'رقم الهاتف مطلوب.',
            'password.min'             => 'يجب ألا تقل كلمة المرور عن 6 خانات إن تم تعديلها.',
            'id_number.required'       => 'رقم الهوية مطلوب.',
            'whats_up_number.required' => 'رقم الواتساب مطلوب.',
            'gender.required'          => 'يرجى تحديد الجنس.',
            'status.required'          => 'يرجى تحديد حالة الحساب.',
            'address_id.required'      => 'يرجى تحديد العنوان.',
            'address_id.exists'        => 'العنوان المحدد غير مسجل بالنظام.',
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

        DB::beginTransaction();
        try {
            // 1. تحديث جدول users
            $user->name         = $request->input('name');
            $user->email        = $request->input('email');
            $user->phone        = $request->input('phone');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->gender       = $request->input('gender');
            $user->status       = $request->input('status');
            $user->addresses_id = $request->input('address_id');
            $user->save();

            // 2. تحديث جدول owners
            $ownerActor = $user->actor;
            if (!$ownerActor) {
                $ownerActor = new Owner();
                $ownerActor->save();
                $user->actor_id   = $ownerActor->id;
                $user->actor_type = Owner::class;
                $user->save();
            }

            $ownerActor->id_number       = $request->input('id_number');
            $ownerActor->whats_up_number = $request->input('whats_up_number');
            $ownerActor->save();

            DB::commit();

            Log::info('متجر رونق: تم تحديث بيانات المالك بنجاح', [
                'user_id'  => $user->id,
                'owner_id' => $ownerActor->id,
                'email'    => $user->email,
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
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث بيانات المالك', [
                'error_message' => $e->getMessage(),
                'user_id'       => $id,
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
     * 7. حذف حساب المالك وسجل المورف المرتبط به (AJAX - DELETE)
     */
    public function destroy($id)
    {
        $user = User::where('role', 'owner')->with('actor')->findOrFail($id);

        $this->authorize('delete', $user->actor ?? $user);

        DB::beginTransaction();
        try {
            $userEmail = $user->email;

            // حذف سجل المالك من جدول owners إن وجد
            if ($user->actor) {
                $user->actor->delete();
            }

            $user->delete();

            DB::commit();

            Log::info('متجر رونق: تم حذف حساب المالك', [
                'deleted_user_id' => $id,
                'email'           => $userEmail,
                'admin_id'        => auth('web')->id() ?? 'لوحة التحكم',
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف حساب المالك من متجر رونق',
                'message' => 'تم حذف حساب المالك من متجر رونق'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف حساب المالك', [
                'error_message' => $e->getMessage(),
                'user_id'       => $id,
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
