<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::with('city')->orderBy('id', 'desc')->paginate(10);
        return view('cms.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::where('is_active', 'active')->orWhere('is_active', 1)->orderBy('name')->get();
        return response()->view('cms.address.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        $address = new Address();
        $address->area = $request->input('area');
        $address->street = $request->input('street');
        $address->building_details = $request->input('building_details');
        $address->city_id = $request->input('city_id');
        $address->latitude = $request->input('latitude');
        $address->longitude = $request->input('longitude');
        $isSaved = $address->save();

        return response()->json([
            'icon'    => $isSaved ? 'success' : 'error',
            'title'   => $isSaved ? 'تم الحفظ بنجاح' : 'فشلت العملية',
            'text'    => $isSaved ? 'تمت إضافة العنوان الجديد بنجاح' : 'حدث خطأ أثناء حفظ البيانات في قاعدة البيانات',
            'message' => $isSaved ? 'تمت إضافة العنوان الجديد بنجاح' : 'حدث خطأ أثناء حفظ البيانات في قاعدة البيانات'
        ], $isSaved ? 201 : 400);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $address = Address::with('city')->findOrFail($id);
        return response()->view('cms.address.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        $cities = City::where('is_active', 'active')->orWhere('is_active', 1)->orderBy('name')->get();
        return response()->view('cms.address.edit', compact('address', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
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

        $address->area = $request->input('area');
        $address->street = $request->input('street');
        $address->building_details = $request->input('building_details');
        $address->city_id = $request->input('city_id');
        $address->latitude = $request->input('latitude');
        $address->longitude = $request->input('longitude');
        $isSaved = $address->save();

        return response()->json([
            'icon'    => $isSaved ? 'success' : 'error',
            'title'   => $isSaved ? 'تم التعديل بنجاح' : 'فشلت العملية',
            'text'    => $isSaved ? 'تم تحديث بيانات العنوان بنجاح' : 'تعذر تحديث العنوان في قاعدة البيانات',
            'message' => $isSaved ? 'تم تحديث بيانات العنوان بنجاح' : 'تعذر تحديث العنوان في قاعدة البيانات'
        ], $isSaved ? 200 : 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $isDeleted = $address->delete();

        if ($isDeleted) {
            return response()->json([
                'icon'    => 'success',
                'title'   => 'تم الحذف بنجاح',
                'text'    => 'تم حذف العنوان من النظام نهائياً',
                'message' => 'تم حذف العنوان من النظام نهائياً'
            ], 200);
        }

        return response()->json([
            'icon'    => 'error',
            'title'   => 'فشلت العملية',
            'text'    => 'تعذر حذف العنوان، يرجى المحاولة لاحقاً',
            'message' => 'تعذر حذف العنوان، يرجى المحاولة لاحقاً'
        ], 400);
    }
}
