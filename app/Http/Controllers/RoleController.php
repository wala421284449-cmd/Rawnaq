<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;

    /**
     * 1. عرض جدول المسميات الوظيفية والأدوار في متجر رونق
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::withCount('permissions')->get();

        return view('cms.spatie.role.index', compact('roles'));
    }

    /**
     * 2. عرض صفحة إضافة مسمى وظيفي جديد لمتجر رونق
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return response()->view('cms.spatie.role.create');
    }

    /**
     * 3. حفظ المسمى الوظيفي الجديد في متجر رونق (AJAX - POST)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $validator = validator($request->all(), [
            'name'       => 'required|string|min:2|max:45|unique:roles,name',
            'guard_name' => 'required|string|in:admin,customer,owner',
        ], [
            'name.required'       => 'اسم المسمى الوظيفي مطلوب.',
            'name.unique'         => 'هذا المسمى الوظيفي مسجل مسبقاً في متجر رونق.',
            'guard_name.required' => 'نطاق الحراسة (Guard) مطلوب.',
            'guard_name.in'       => 'النطاق المحدد غير صحيح.',
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
            $role = new Role();
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard_name');
            $role->save();

            DB::commit();

            Log::info('متجر رونق: تم تسجيل مسمى وظيفي جديد بنجاح', [
                'role_id'   => $role->id,
                'role_name' => $role->name,
                'admin_id'  => auth('web')->id() ?? 'لوحة التحكم',
                'ip'        => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم بنجاح',
                'text'    => 'تمت إضافة المسمى الوظيفي بنجاح',
                'message' => 'تمت إضافة المسمى الوظيفي بنجاح'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ المسمى الوظيفي', [
                'error_message' => $e->getMessage(),
                'ip'            => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'text'    => 'تعذر حفظ المسمى الوظيفي: ' . $e->getMessage(),
                'message' => 'تعذر حفظ المسمى الوظيفي'
            ], 500);
        }
    }

    /**
     * 4. عرض تفاصيل المسمى الوظيفي في متجر رونق
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        $this->authorize('view', $role);

        return response()->view('cms.spatie.role.show', compact('role'));
    }

    /**
     * 5. حذف المسمى الوظيفي من متجر رونق (AJAX - DELETE)
     */
    public function destroy($id, Request $request)
    {
        $role = Role::findOrFail($id);

        $this->authorize('delete', $role);

        DB::beginTransaction();
        try {
            $roleName = $role->name;

            $role->delete();

            DB::commit();

            Log::info('متجر رونق: تم حذف المسمى الوظيفي', [
                'deleted_role_id' => $id,
                'role_name'       => $roleName,
                'admin_id'        => auth('web')->id() ?? 'لوحة التحكم',
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف المسمى الوظيفي من متجر رونق',
                'message' => 'تم حذف المسمى الوظيفي من متجر رونق'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف المسمى الوظيفي', [
                'error_message' => $e->getMessage(),
                'role_id'       => $id,
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر حذف المسمى الوظيفي لوجود بيانات مرتبطة به',
                'message' => 'تعذر حذف المسمى الوظيفي لوجود بيانات مرتبطة به'
            ], 400);
        }
    }

    /**
     * 6. عرض صفحة تعديل صلاحيات الدور المحددة في متجر رونق
     */
    public function editRolePermissions(string $id)
    {
        $role = Role::findOrFail($id);

        $this->authorize('update', $role);

        $permissions = Permission::where('guard_name', $role->guard_name)->get();

        // جلب أسماء الصلاحيات التي يمتلكها الدور حالياً لتعليمها بـ Checked
        $rolePermissions = $role->permissions()->pluck('name')->toArray();

        return view('cms.spatie.role.role-permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * 7. حفظ وتحديث الصلاحيات للدور في قاعدة البيانات
     */
    public function updateRolePermissions(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $this->authorize('update', $role);

        DB::beginTransaction();
        try {
            // إذا لم يتم تحديد أي Checkbox، نمرر مصفوفة فارغة لإلغاء كل الصلاحيات
            $permissions = $request->input('permissions', []);

            // الدالة السحرية من السباتي تقوم بحذف القديم ومزامنة الجديد فوراً
            $role->syncPermissions($permissions);

            DB::commit();

            Log::info('متجر رونق: تم تحديث صلاحيات الدور بنجاح', [
                'role_id'   => $role->id,
                'role_name' => $role->name,
            ]);

            return redirect()->route('roles.index')->with('success', 'تم تحديث صلاحيات الدور بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث صلاحيات الدور', [
                'role_id' => $role->id,
                'error'   => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'تعذر تحديث صلاحيات الدور.');
        }
    }
}
