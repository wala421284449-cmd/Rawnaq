<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CityController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', City::class);

        $cities = City::orderBy('id', 'desc')->paginate(10);
        return view('cms.city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', City::class);

        return response()->view('cms.city.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', City::class);

        $validator = validator($request->all(), [
            'name'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255|unique:cities,slug',
            'is_active' => 'required|in:active,inactive',
        ], [
            'name.required'      => 'اسم المدينة حقل إلزامي.',
            'is_active.required' => 'يرجى تحديد حالة النشاط.',
            'is_active.in'       => 'حالة النشاط غير صالحة.',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->getMessageBag()->first();

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في المدخلات',
                'text'    => $firstError,
                'message' => $firstError
            ], 400);
        }

        DB::beginTransaction();
        try {
            $city = new City();
            $city->name = $request->input('name');
            $city->slug = $request->input('slug') ?: Str::slug($request->input('name'));
            $city->is_active = $request->input('is_active');
            $city->save();

            DB::commit();

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم بنجاح',
                'text'    => 'تمت إضافة المدينة بنجاح',
                'message' => 'تمت إضافة المدينة بنجاح'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ المدينة', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'message' => 'فشلت إضافة المدينة في قاعدة البيانات'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        $this->authorize('view', $city);

        return view('cms.city.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $this->authorize('update', $city);

        // توحيد اسم المتغير ليطابق الـ View (إذا كنتِ تستخدمين city مفرد أو جمع حسب تصميمك)
        return response()->view('cms.city.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $this->authorize('update', $city);

        $validator = validator($request->all(), [
            'name'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255|unique:cities,slug,' . $city->id,
            'is_active' => 'required|in:active,inactive',
        ], [
            'name.required'      => 'اسم المدينة حقل إلزامي.',
            'slug.unique'        => 'الرابط المختصر (Slug) مستخدم مسبقاً.',
            'is_active.required' => 'حالة النشاط مطلوبة.',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->getMessageBag()->first();

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في الإدخال',
                'text'    => $firstError,
                'message' => $firstError
            ], 400);
        }

        DB::beginTransaction();
        try {
            $city->name = $request->input('name');
            $city->slug = $request->input('slug') ?: Str::slug($request->input('name'));
            $city->is_active = $request->input('is_active');
            $city->save();

            DB::commit();

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم بنجاح',
                'text'    => 'تم تعديل المدينة بنجاح',
                'message' => 'تم تعديل المدينة بنجاح'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث المدينة', [
                'id'    => $city->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'message' => 'فشلت عملية التعديل'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $this->authorize('delete', $city);

        DB::beginTransaction();
        try {
            $city->delete();

            DB::commit();

            return response()->json([
                'icon'  => 'success',
                'title' => 'تم حذف المدينة بنجاح',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف المدينة', [
                'id'    => $city->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'icon'  => 'error',
                'title' => 'فشلت عملية الحذف لوجود بيانات مرتبطة بها',
            ], 400);
        }
    }
}
