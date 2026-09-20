<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PermissionController extends Controller
{
    use AuthorizesRequests;

    /**
     * 1. عرض جدول الصلاحيات في متجر رونق
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        $permissions = Permission::orderBy('id', 'desc')->paginate(10);
        return view('cms.spatie.permission.index', compact('permissions'));
    }

    /**
     * 2. عرض صفحة إضافة صلاحية جديدة لمتجر رونق
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        return response()->view('cms.spatie.permission.create');
    }

    /**
     * 3. حفظ الصلاحية الجديدة في متجر رونق (AJAX - POST)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        $validator = validator($request->all(), [
            'name'       => 'required|string|min:2|max:45|unique:permissions,name',
            'guard_name' => 'required|string|in:admin,customer,owner',
        ], [
            'name.required'      => 'اسم الصلاحية مطلوب.',
            'name.unique'        => 'هذه الصلاحية مسجلة مسبقاً في متجر رونق.',
            'guard_name.required' => 'نطاق الحراسة (Guard) مطلوب.',
            'guard_name.in'      => 'النطاق المحدد غير صحيح.',
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
            $permission = new Permission();
            $permission->name = $request->input('name');
            $permission->guard_name = $request->input('guard_name');
            $permission->save();

            DB::commit();

            Log::info('متجر رونق: تم تسجيل صلاحية جديدة بنجاح', [
                'permission_id'   => $permission->id,
                'permission_name' => $permission->name,
                'admin_id'        => auth('web')->id() ?? 'لوحة التحكم',
                'ip'              => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم بنجاح',
                'text'    => 'تمت إضافة الصلاحية بنجاح',
                'message' => 'تمت إضافة الصلاحية بنجاح'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ الصلاحية', [
                'error_message' => $e->getMessage(),
                'ip'            => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'text'    => 'تعذر حفظ الصلاحية: ' . $e->getMessage(),
                'message' => 'تعذر حفظ الصلاحية'
            ], 500);
        }
    }

    /**
     * 4. عرض تفاصيل الصلاحية في متجر رونق
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        $this->authorize('view', $permission);

        return response()->view('cms.spatie.permission.show', compact('permission'));
    }

    /**
     * 5. حذف الصلاحية من متجر رونق (AJAX - DELETE)
     */
    public function destroy($id, Request $request)
    {
        $permission = Permission::findOrFail($id);

        $this->authorize('delete', $permission);

        DB::beginTransaction();
        try {
            $permissionName = $permission->name;

            $permission->delete();

            DB::commit();

            Log::info('متجر رونق: تم حذف الصلاحية', [
                'deleted_permission_id' => $id,
                'permission_name'       => $permissionName,
                'admin_id'              => auth('web')->id() ?? 'لوحة التحكم',
            ]);

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف الصلاحية من متجر رونق',
                'message' => 'تم حذف الصلاحية من متجر رونق'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف الصلاحية', [
                'error_message' => $e->getMessage(),
                'permission_id' => $id,
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر حذف الصلاحية لوجود أدوار مرتبطة بها',
                'message' => 'تعذر حذف الصلاحية لوجود أدوار مرتبطة بها'
            ], 400);
        }
    }
}
