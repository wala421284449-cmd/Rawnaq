<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::orderBy('id', 'desc')->paginate(10);
        return view('cms.city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::where('is_active', 'active')->get();
        return response()->view('cms.city.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255|unique:cities,slug',
            'is_active' => 'required|in:active,inactive',
        ]);

        if (!$validator->fails()) {
            $city = new City();
            $city->name = $request->input('name');
            $city->slug = $request->input('slug') ?: \Illuminate\Support\Str::slug($request->input('name'));
            $city->is_active = $request->input('is_active');
            $isSaved = $city->save();

            return response()->json([
                'icon'    => $isSaved ? 'success' : 'error',
                'title'   => $isSaved ? 'تم بنجاح' : 'فشلت العملية',
                'text'    => $isSaved ? 'تمت إضافة المدينة بنجاح' : 'فشلت إضافة المدينة',
                'message' => $isSaved ? 'تمت إضافة المدينة بنجاح' : 'فشلت إضافة المدينة'
            ], $isSaved ? 201 : 400);
        } else {
            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في المدخلات',
                'text'    => $validator->getMessageBag()->first(),
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return view('cms.city.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cities = City::findorFail($id);
        return response()->view('cms.city.edit', compact('cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validator = validator($request->all(), [
            'name'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255|unique:cities,slug,' . $city->id,
            'is_active' => 'required|in:active,inactive',
        ]);

        if (!$validator->fails()) {
            $city->name = $request->input('name');
            $city->slug = $request->input('slug') ?: \Illuminate\Support\Str::slug($request->input('name'));
            $city->is_active = $request->input('is_active');
            $isSaved = $city->save();

            return response()->json([
                'icon'    => $isSaved ? 'success' : 'error',
                'title'   => $isSaved ? 'تم بنجاح' : 'فشلت العملية',
                'text'    => $isSaved ? 'تم تعديل المدينة بنجاح' : 'فشلت عملية التعديل',
                'message' => $isSaved ? 'تم تعديل المدينة بنجاح' : 'فشلت عملية التعديل'
            ], $isSaved ? 200 : 400);
        } else {
            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في الإدخال',
                'text'    => $validator->getMessageBag()->first(),
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $isDeleted = $city->delete();

        if ($isDeleted) {
            return response()->json([
                'icon'  => 'success',
                'title' => 'تم حذف المدينة بنجاح',
            ], 200);
        }

        return response()->json([
            'icon'  => 'error',
            'title' => 'فشلت عملية الحذف',
        ], 400);
    }
}
