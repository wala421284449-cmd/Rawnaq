<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Address::class);

        $addresses = Address::with('city')->orderBy('id', 'desc')->paginate(10);
        return view('cms.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Address::class);

        $cities = City::where('is_active', 'active')->orWhere('is_active', 1)->orderBy('name')->get();
        return response()->view('cms.address.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. إضافة صلاحية الإنشاء هنا لتكتمل الحماية
        $this->authorize('create', Address::class);

        $validator = validator($request->all(), [
            'area'             => 'required|string|max:45',
            'street'           => 'required|string|max:45',
            'building_details' => 'nullable|string|max:45',
            'city_id'          => 'required|exists:cities,id',
            'latitude'         => 'nullable|numeric|between:-90,90',
            'longitude'        => 'nullable|numeric|between:-180,180',
        ], [
            'area.required'        => 'حقل المنطقة أو الحي مطلوب.',
            'area.max'             => 'يجب ألا تتجاوز المنطقة 45 حرفاً.',
            'street.required'      => 'اسم الشارع مطلوب.',
            'street.max'           => 'يجب ألا يتجاوز اسم الشارع 45 حرفاً.',
            'building_details.max' => 'تفاصيل المبنى يجب ألا تتجاوز 45 حرفاً.',
            'city_id.required'     => 'يرجى اختيار المدينة التابع لها العنوان.',
            'city_id.exists'       => 'المدينة المختارة غير مسجلة في النظام.',
            'latitude.numeric'     => 'خط العرض يجب أن يكون قيمة رقمية عشرية.',
            'latitude.between'     => 'خط العرض يجب أن يكون بين -90 و 90 درجة.',
            'longitude.numeric'    => 'خط الطول يجب أن يكون قيمة رقمية عشرية.',
            'longitude.between'    => 'خط الطول يجب أن يكون بين -180 و 180 درجة.',
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
            $address = new Address();
            $address->area = $request->input('area');
            $address->street = $request->input('street');
            $address->building_details = $request->input('building_details');
            $address->city_id = $request->input('city_id');
            $address->latitude = $request->input('latitude');
            $address->longitude = $request->input('longitude');
            $address->save();

            DB::commit();

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحفظ بنجاح',
                'text'    => 'تمت إضافة العنوان الجديد بنجاح',
                'message' => 'تمت إضافة العنوان الجديد بنجاح'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ العنوان', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في النظام',
                'text'    => 'حدث خطأ أثناء حفظ البيانات في قاعدة البيانات',
                'message' => 'حدث خطأ أثناء حفظ البيانات في قاعدة البيانات'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $address = Address::with('city')->findOrFail($id);

        // 2. إضافة فحص الصلاحية للعرض
        $this->authorize('view', $address);

        return response()->view('cms.address.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        $this->authorize('update', $address);

        $cities = City::where('is_active', 'active')->orWhere('is_active', 1)->orderBy('name')->get();
        return response()->view('cms.address.edit', compact('address', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validator = validator($request->all(), [
            'area'             => 'required|string|max:45',
            'street'           => 'required|string|max:45',
            'building_details' => 'nullable|string|max:45',
            'city_id'          => 'required|exists:cities,id',
            'latitude'         => 'nullable|numeric|between:-90,90',
            'longitude'        => 'nullable|numeric|between:-180,180',
        ], [
            'area.required'        => 'حقل المنطقة أو الحي مطلوب.',
            'area.max'             => 'يجب ألا تتجاوز المنطقة 45 حرفاً.',
            'street.required'      => 'اسم الشارع مطلوب.',
            'street.max'           => 'يجب ألا يتجاوز اسم الشارع 45 حرفاً.',
            'building_details.max' => 'تفاصيل المبنى يجب ألا تتجاوز 45 حرفاً.',
            'city_id.required'     => 'يرجى اختيار المدينة التابع لها العنوان.',
            'city_id.exists'       => 'المدينة المختارة غير مسجلة في النظام.',
            'latitude.numeric'     => 'خط العرض يجب أن يكون قيمة رقمية عشرية.',
            'latitude.between'     => 'خط العرض يجب أن يكون بين -90 و 90 درجة.',
            'longitude.numeric'    => 'خط الطول يجب أن يكون قيمة رقمية عشرية.',
            'longitude.between'    => 'خط الطول يجب أن يكون بين -180 و 180 درجة.',
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
            $address->area = $request->input('area');
            $address->street = $request->input('street');
            $address->building_details = $request->input('building_details');
            $address->city_id = $request->input('city_id');
            $address->latitude = $request->input('latitude');
            $address->longitude = $request->input('longitude');
            $address->save();

            DB::commit();

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم التعديل بنجاح',
                'text'    => 'تم تحديث بيانات العنوان بنجاح',
                'message' => 'تم تحديث بيانات العنوان بنجاح'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث العنوان', [
                'id'    => $address->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر تحديث العنوان في قاعدة البيانات',
                'message' => 'تعذر تحديث العنوان في قاعدة البيانات'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        // 3. تمرير كائن الـ $address بدلاً من اسم الكلاس للفحص الصحيح
        $this->authorize('delete', $address);

        DB::beginTransaction();
        try {
            $address->delete();

            DB::commit();

            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف العنوان من النظام نهائياً',
                'message' => 'تم حذف العنوان من النظام نهائياً'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف العنوان', [
                'id'    => $address->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'icon'    => 'error',
                'title'   => 'فشلت العملية',
                'text'    => 'تعذر حذف العنوان لوجود بيانات مرتبطة به',
                'message' => 'تعذر حذف العنوان لوجود بيانات مرتبطة به'
            ], 400);
        }
    }
}
