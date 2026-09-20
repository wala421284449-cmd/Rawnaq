<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends Controller
{
    use AuthorizesRequests;

    /**
     * 1. عرض جدول زبائن متجر رونق مع الترقيم والبحث التلقائي
     */
    public function index()
    {
        $this->authorize('viewAny', Customer::class);

        $customers = User::where('role', 'customer')
            ->with(['actor', 'address.city'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.customer.index', compact('customers'));
    }

    /**
     * 2. عرض صفحة إضافة زبون جديد
     */
    public function create()
    {
        $this->authorize('create', Customer::class);

        $address = Address::with('city')->latest()->get();
        $roles = Role::all();

        return response()->view('cms.customer.create', compact('address', 'roles'));
    }

    /**
     * 3. حفظ بيانات الزبون الجديد في قاعدة البيانات (AJAX - POST)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Customer::class);

        $validator = validator($request->all(), [
            'name'            => 'required|string|min:3|max:45',
            'email'           => 'required|email|max:45|unique:users,email',
            'phone'           => 'required|string|max:45',
            'password'        => 'required|string|min:6',
            'id_number'       => 'nullable|string|max:20',
            'whats_up_number' => 'required|string|max:45',
            'gender'          => 'required|in:male,female',
            'status'          => 'required|in:active,inactive',
            'address_id'      => 'required|exists:addresses,id',
            'role_name'       => 'required|exists:roles,name',
        ], [
            'name.required'            => 'اسم الزبون مطلوب.',
            'name.min'                 => 'يجب ألا يقل الاسم عن 3 أحرف.',
            'email.required'           => 'البريد الإلكتروني مطلوب.',
            'email.email'              => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique'             => 'هذا البريد الإلكتروني مسجل مسبقاً لدى زبون آخر.',
            'phone.required'           => 'رقم الهاتف مطلوب.',
            'password.required'        => 'كلمة المرور مطلوبة.',
            'password.min'             => 'يجب ألا تقل كلمة المرور عن 6 خانات.',
            'whats_up_number.required' => 'رقم الواتساب مطلوب للتواصل وإرسال إشعارات الطلب.',
            'gender.required'          => 'يرجى تحديد الجنس.',
            'status.required'          => 'يرجى تحديد حالة الحساب.',
            'address_id.required'      => 'يرجى تحديد عنوان التوصيل.',
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
            // 1. إنشاء سجل الزبون في جدول customers
            $customerActor = new Customer();
            $customerActor->id_number       = $request->input('id_number');
            $customerActor->whats_up_number = $request->input('whats_up_number');
            $customerActor->save();

            // 2. إنشاء المستخدم وربطه بالزبون
            $user = new User();
            $user->name         = $request->input('name');
            $user->email        = $request->input('email');
            $user->phone        = $request->input('phone');
            $user->password     = Hash::make($request->input('password'));
            $user->gender       = $request->input('gender');
            $user->role         = 'customer';
            $user->status       = $request->input('status');
            $user->addresses_id = $request->input('address_id');

            $user->actor_id     = $customerActor->id;
            $user->actor_type   = Customer::class;
            $user->save();

            $user->assignRole($request->input('role_name'));

            DB::commit();

            Log::info('متجر رونق: تم تسجيل حساب زبون جديد بنجاح', [
                'user_id'     => $user->id,
                'customer_id' => $customerActor->id,
                'email'       => $user->email,
                'admin_id'    => auth('web')->id() ?? 'لوحة التحكم',
                'ip'          => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم بنجاح',
                'text'    => 'تمت إضافة الزبون بنجاح إلى متجر رونق',
                'message' => 'تمت إضافة الزبون بنجاح إلى متجر رونق'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل إضافة الزبون في قاعدة البيانات', [
                'error_message' => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
                'ip'            => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'text'    => 'تعذر حفظ بيانات الزبون: ' . $e->getMessage(),
                'message' => 'تعذر حفظ بيانات الزبون في قاعدة البيانات'
            ], 500);
        }
    }

    /**
     * 4. عرض تفاصيل ملف الزبون وطلباته
     */
    public function show($id)
    {
        $customer = User::where('role', 'customer')
            ->with(['actor', 'address.city'])
            ->findOrFail($id);

        // التحقق من صلاحية العرض (تمرير الـ actor أو الـ user بحسب إعدادات السياسة لديك)
        $this->authorize('view', $customer->actor ?? $customer);

        return response()->view('cms.customer.show', compact('customer'));
    }

    /**
     * 5. عرض صفحة تعديل بيانات الزبون
     */
    public function edit($id)
    {
        $customer = User::where('role', 'customer')->with('actor')->findOrFail($id);
        $address  = Address::with('city')->latest()->get();

        $this->authorize('update', $customer->actor ?? $customer);

        // تصحيح الاسم ليكون مفرداً وموافقاً للـ View
        return response()->view('cms.customer.edit', compact('customer', 'address'));
    }

    /**
     * 6. تحديث بيانات الزبون في قاعدة البيانات (AJAX - POST / PUT)
     */
    public function update(Request $request, $id)
    {
        $customerUser = User::where('role', 'customer')->with('actor')->findOrFail($id);
        $this->authorize('update', $customerUser->actor ?? $customerUser);

        $validator = validator($request->all(), [
            'name'            => 'required|string|min:3|max:45',
            'email'           => 'required|email|max:45|unique:users,email,' . $customerUser->id,
            'phone'           => 'required|string|max:45',
            'password'        => 'nullable|string|min:6',
            'id_number'       => 'nullable|string|max:20',
            'whats_up_number' => 'required|string|max:45',
            'gender'          => 'required|in:male,female',
            'status'          => 'required|in:active,inactive',
            'address_id'      => 'required|exists:addresses,id',
        ], [
            'name.required'            => 'اسم الزبون مطلوب.',
            'email.required'           => 'البريد الإلكتروني مطلوب.',
            'email.unique'             => 'البريد الإلكتروني مستخدم بالفعل.',
            'phone.required'           => 'رقم الهاتف مطلوب.',
            'password.min'             => 'يجب ألا تقل كلمة المرور عن 6 خانات في حال الرغبة بتغييرها.',
            'whats_up_number.required' => 'رقم الواتساب مطلوب.',
            'gender.required'          => 'يرجى تحديد الجنس.',
            'status.required'          => 'يرجى تحديد حالة الحساب.',
            'address_id.required'      => 'يرجى تحديد عنوان التوصيل.',
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
            $customerUser->name         = $request->input('name');
            $customerUser->email        = $request->input('email');
            $customerUser->phone        = $request->input('phone');

            if ($request->filled('password')) {
                $customerUser->password = Hash::make($request->input('password'));
            }

            $customerUser->gender       = $request->input('gender');
            $customerUser->status       = $request->input('status');
            $customerUser->addresses_id = $request->input('address_id');
            $customerUser->save();

            $customerActor = $customerUser->actor;
            if (!$customerActor) {
                $customerActor = new Customer();
                $customerActor->save();
                $customerUser->actor_id   = $customerActor->id;
                $customerUser->actor_type = Customer::class;
                $customerUser->save();
            }

            $customerActor->id_number       = $request->input('id_number');
            $customerActor->whats_up_number = $request->input('whats_up_number');
            $customerActor->save();

            DB::commit();

            Log::info('متجر رونق: تم تحديث بيانات الزبون بنجاح', [
                'user_id'     => $customerUser->id,
                'customer_id' => $customerActor->id,
                'email'       => $customerUser->email,
                'admin_id'    => auth('web')->id() ?? 'لوحة التحكم',
                'ip'          => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم التعديل بنجاح',
                'text'    => 'تم تحديث بيانات الزبون بنجاح',
                'message' => 'تم تحديث بيانات الزبون بنجاح'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث بيانات الزبون', [
                'error_message' => $e->getMessage(),
                'user_id'       => $id,
                'line'          => $e->getLine(),
                'ip'            => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر تحديث بيانات الزبون في قاعدة البيانات',
                'message' => 'تعذر تحديث بيانات الزبون في قاعدة البيانات'
            ], 500);
        }
    }

    /**
     * 7. حذف حساب الزبون وسجل المورف المرتبط به (AJAX - DELETE)
     */
    public function destroy($id)
    {
        $customerUser = User::where('role', 'customer')->with('actor')->findOrFail($id);

        // التحقق من الصلاحية مبكراً وبشكل آمن
        $this->authorize('delete', $customerUser->actor ?? $customerUser);

        DB::beginTransaction();
        try {
            $userEmail = $customerUser->email;

            if ($customerUser->actor) {
                $customerUser->actor->delete();
            }

            $customerUser->delete();

            DB::commit();

            Log::info('متجر رونق: تم حذف حساب الزبون', [
                'deleted_user_id' => $id,
                'email'           => $userEmail,
                'admin_id'        => auth('web')->id() ?? 'لوحة التحكم',
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف حساب الزبون من متجر رونق',
                'message' => 'تم حذف حساب الزبون من متجر رونق'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف حساب الزبون', [
                'error_message' => $e->getMessage(),
                'user_id'       => $id,
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر حذف الزبون لوجود طلبات أو بيانات مرتبطة به في المتجر',
                'message' => 'تعذر حذف الزبون لوجود بيانات مرتبطة به في المتجر'
            ], 400);
        }
    }
}
