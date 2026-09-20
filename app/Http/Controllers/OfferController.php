<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\GeneralNotification;

class OfferController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة العروض مع جلب العلاقات (المتجر والمنتج) والتصفح.
     */
    public function index()
    {
        $this->authorize('viewAny', Offer::class);

        $offers = Offer::with(['store', 'product'])->latest()->paginate(10);
        return view('cms.offer.index', compact('offers'));
    }

    /**
     * عرض صفحة إنشاء عرض جديد مع إرسال المتاجر والمنتجات للقوائم المنسدلة.
     */
    public function create()
    {
        $this->authorize('create', Offer::class);

        $stores = Store::all();
        $products = Product::all();
        return view('cms.offer.create', compact('stores', 'products'));
    }

    /**
     * تخزين عرض جديد في النظام مع Validation ممتاز وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Offer::class);

        $request->validate([
            'title'               => 'required|string|min:2|max:45',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'sale_price'          => 'required|numeric|min:0',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'is_active'           => 'required|in:active,inactive',
            'stores_id'           => 'required|exists:stores,id',
            'products_id'         => 'required|exists:products,id',
        ], [
            'title.required'                => 'عنوان العرض حقل إلزامي.',
            'title.min'                     => 'عنوان العرض يجب ألا يقل عن حرفين.',
            'title.max'                     => 'عنوان العرض يجب ألا يتجاوز 45 حرفاً.',
            'discount_percentage.numeric'   => 'نسبة الخصم يجب أن تكون قيمة رقمية.',
            'discount_percentage.min'       => 'نسبة الخصم لا يمكن أن تكون سالبة.',
            'discount_percentage.max'       => 'نسبة الخصم لا يمكن أن تتجاوز 100%.',
            'sale_price.required'           => 'سعر العرض حقل إلزامي.',
            'sale_price.numeric'            => 'سعر العرض يجب أن يكون قيمة رقمية.',
            'start_date.required'           => 'تاريخ البدء حقل إلزامي.',
            'start_date.date'               => 'تاريخ البدء غير صالح.',
            'end_date.required'             => 'تاريخ الانتهاء حقل إلزامي.',
            'end_date.date'                 => 'تاريخ الانتهاء غير صالح.',
            'end_date.after_or_equal'       => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء أو مساوياً له.',
            'is_active.required'            => 'حالة العرض حقل إلزامي.',
            'stores_id.required'            => 'يجب اختيار المتجر.',
            'stores_id.exists'              => 'المتجر المختار غير موجود في النظام.',
            'products_id.required'          => 'يجب اختيار المنتج المستهدف.',
            'products_id.exists'            => 'المنتج المختار غير موجود في النظام.',
        ]);

        DB::beginTransaction();
        try {
            $offer = Offer::create($request->all());

            // إرسال إشعار فوري عند إضافة عرض جديد
            $activeUser = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();
            if ($activeUser) {
                $activeUser->notify(new GeneralNotification(
                    'إدارة العروض الترويجية',
                    'تم إضافة عرض جديد (' . $offer->title . ') بنجاح.'
                ));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم حفظ العرض الترويجي الجديد بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حفظ العرض الترويجي', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ العرض في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل عرض معين.
     */
    public function show($id)
    {
        $offer = Offer::with(['store', 'product'])->findOrFail($id);

        $this->authorize('view', $offer);

        return view('cms.offer.show', compact('offer'));
    }

    /**
     * عرض صفحة تعديل العرض مع جلب البيانات اللازمة.
     */
    public function edit($id)
    {
        $offer = Offer::findOrFail($id);

        $this->authorize('update', $offer);

        $stores = Store::all();
        $products = Product::all();
        return view('cms.offer.edit', compact('offer', 'stores', 'products'));
    }

    /**
     * تحديث بيانات العرض مع Validation محكم وحماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);

        $this->authorize('update', $offer);

        $request->validate([
            'title'               => 'required|string|min:2|max:45',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'sale_price'          => 'required|numeric|min:0',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'is_active'           => 'required|in:active,inactive',
            'stores_id'           => 'required|exists:stores,id',
            'products_id'         => 'required|exists:products,id',
        ], [
            'title.required'                => 'عنوان العرض حقل إلزامي.',
            'discount_percentage.numeric'   => 'نسبة الخصم يجب أن تكون رقمية.',
            'sale_price.required'           => 'سعر العرض حقل إلزامي.',
            'start_date.required'           => 'تاريخ البدء حقل إلزامي.',
            'end_date.required'             => 'تاريخ الانتهاء حقل إلزامي.',
            'end_date.after_or_equal'       => 'تاريخ الانتهاء يجب ألا يسبق تاريخ البدء.',
            'is_active.required'            => 'حالة العرض حقل إلزامي.',
            'stores_id.required'            => 'يجب اختيار المتجر.',
            'products_id.required'          => 'يجب اختيار المنتج.',
        ]);

        DB::beginTransaction();
        try {
            $offer->update($request->all());

            // إرسال إشعار فوري عند تحديث العرض
            $activeUser = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();
            if ($activeUser) {
                $activeUser->notify(new GeneralNotification(
                    'إدارة العروض الترويجية',
                    'تم تحديث بيانات العرض (' . $offer->title . ') بنجاح.'
                ));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات العرض بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل تحديث العرض الترويجي', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تعديل بيانات العرض.',
            ], 500);
        }
    }

    /**
     * حذف العرض من النظام مع حماية بالـ Transactions.
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);

        $this->authorize('delete', $offer);

        DB::beginTransaction();
        try {
            $offerTitle = $offer->title;
            $offer->delete();

            // إرسال إشعار فوري عند حذف العرض
            $activeUser = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();
            if ($activeUser) {
                $activeUser->notify(new GeneralNotification(
                    'إدارة العروض الترويجية',
                    'تم حذف العرض (' . $offerTitle . ') نهائياً من النظام.'
                ));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف!',
                'message' => 'تم حذف العرض الترويجي نهائياً من النظام.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('متجر رونق: فشل حذف العرض الترويجي', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حذف العرض الترويجي من النظام.',
            ], 400);
        }
    }
}
