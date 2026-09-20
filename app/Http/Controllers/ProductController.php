<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\GeneralNotification;

class ProductController extends Controller
{
    use AuthorizesRequests;

    /**
     * عرض قائمة المنتجات مع جلب العلاقات (المتجر والتصنيف) والتصفح.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->search($request->input('search'))
            ->byCategory($request->input('category_id'))
            ->priceRange($request->input('min_price'), $request->input('max_price'))
            ->sortProducts($request->input('sort'))
            ->paginate(10)
            ->withQueryString(); // للحفاظ على فلاتر البحث عند التنقل بين الصفحات

        $categories = Category::all();

        return view('cms.product.index', compact('products', 'categories'));
    }

    /**
     * عرض صفحة إنشاء منتج جديد مع تمرير المتاجر والتصنيفات.
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        $stores = Store::all();
        $categories = Category::all();
        return view('cms.product.create', compact('stores', 'categories'));
    }

    /**
     * تخزين منتج جديد مع معالجة الصورة والـ Validation وحماية بالـ Transactions.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $request->validate([
            'name'           => 'required|string|min:2|max:45',
            'sku'            => 'required|string|max:45|unique:products,sku',
            'description'    => 'nullable|string',
            'base_price'     => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'main_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'required|in:active,inactive',
            'stores_id'      => 'required|exists:stores,id',
            'categories_id'  => 'required|exists:categories,id',
        ], [
            'name.required'          => 'اسم المنتج حقل إلزامي.',
            'name.min'               => 'اسم المنتج يجب ألا يقل عن حرفين.',
            'sku.required'           => 'رمز المنتج (SKU) حقل إلزامي.',
            'sku.unique'             => 'رمز المنتج (SKU) مستخدم مسبقاً، يرجى اختيار رمز فريد.',
            'base_price.required'    => 'السعر الأساسي حقل إلزامي.',
            'base_price.numeric'     => 'السعر يجب أن يكون قيمة رقمية.',
            'stock_quantity.required' => 'كمية المخزون حقل إلزامي.',
            'stock_quantity.integer' => 'كمية المخزون يجب أن تكون رقماً صحيحاً.',
            'main_image.image'       => 'الملف المرفق يجب أن يكون صورة صالحاً.',
            'main_image.mimes'       => 'صورة المنتج يجب أن تكون بالامتدادات التالية: jpg, jpeg, png, webp.',
            'main_image.max'         => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',
            'is_active.required'     => 'حالة التفعيل حقل إلزامي.',
            'stores_id.required'     => 'يجب اختيار المتجر التابع له المنتج.',
            'stores_id.exists'       => 'المتجر المختار غير موجود في النظام.',
            'categories_id.required' => 'يجب اختيار التصنيف التابع له المنتج.',
            'categories_id.exists'   => 'التصنيف المختار غير موجود في النظام.',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except('main_image');
            $imagePath = null;

            // معالجة رفع الصورة الرئيسية إن وجدت
            if ($request->hasFile('main_image')) {
                $imagePath = $request->file('main_image')->store('products', 'public');
                $data['main_image'] = $imagePath;
            }

            $product = Product::create($data);

            // إرسال إشعار فوري للمستخدم الحالي عند إضافة منتج جديد
            $activeUser = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();
            if ($activeUser) {
                $activeUser->notify(new GeneralNotification(
                    'إدارة المنتجات',
                    'تم إضافة المنتج الجديد (' . $product->name . ') بنجاح.'
                ));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم الإضافة بنجاح',
                'message' => 'تم حفظ المنتج الجديد وإضافته للنظام بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // حذف الصورة المرفوعة في حال حدث خطأ أثناء الحفظ في قاعدة البيانات
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            Log::error('متجر رونق: فشل حفظ المنتج الجديد', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر حفظ المنتج في قاعدة البيانات.',
            ], 500);
        }
    }

    /**
     * عرض تفاصيل منتج معين.
     */
    public function show($id)
    {
        $product = Product::with(['store', 'category'])->findOrFail($id);

        $this->authorize('view', $product);

        return view('cms.product.show', compact('product'));
    }

    /**
     * عرض صفحة تعديل المنتج مع جلب البيانات.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->authorize('update', $product);

        $stores = Store::all();
        $categories = Category::all();
        return view('cms.product.edit', compact('product', 'stores', 'categories'));
    }

    /**
     * تحديث بيانات المنتج مع معالجة الصورة الجديدة والـ Validation وحماية بالـ Transactions.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->authorize('update', $product);

        $request->validate([
            'name'           => 'required|string|min:2|max:45',
            'sku'            => 'required|string|max:45|unique:products,sku,' . $id,
            'description'    => 'nullable|string',
            'base_price'     => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'main_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'required|in:active,inactive',
            'stores_id'      => 'required|exists:stores,id',
            'categories_id'  => 'required|exists:categories,id',
        ]);

        DB::beginTransaction();
        try {
            // 1. الاحتفاظ بمسار الصورة القديمة قبل التحديث
            $oldImage = $product->main_image;

            $data = $request->except('main_image');

            // 2. إذا تم رفع صورة جديدة، قم بتخزينها وتحديث المسار في المصفوفة
            if ($request->hasFile('main_image')) {
                $data['main_image'] = $request->file('main_image')->store('products', 'public');
            }

            // 3. تحديث بيانات المنتج في القاعدة
            $product->update($data);

            // 4. إذا تم رفع صورة جديدة بنجاح، وكان هناك صورة قديمة، قم بحذف القديمة بأمان
            if ($request->hasFile('main_image') && $oldImage) {
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // إرسال إشعار للمستخدم
            $activeUser = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();
            if ($activeUser) {
                $activeUser->notify(new GeneralNotification(
                    'إدارة المنتجات',
                    'تم تحديث بيانات المنتج (' . $product->name . ') بنجاح.'
                ));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم التحديث بنجاح',
                'message' => 'تم تعديل بيانات المنتج بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // إذا حدث خطأ، احذف الصورة الجديدة المرفوعة إن وجدت
            if (isset($data['main_image']) && $request->hasFile('main_image')) {
                if (Storage::disk('public')->exists($data['main_image'])) {
                    Storage::disk('public')->delete($data['main_image']);
                }
            }

            Log::error('متجر رونق: فشل تحديث بيانات المنتج', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر تعديل بيانات المنتج.',
            ], 500);
        }
    }

    /**
     * حذف المنتج وصورته المرتبطة من النظام مع حماية بالـ Transactions.
     */
    /**
     * حذف المنتج مؤقتاً (Soft Delete) مع إرسال إشعار.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);

        DB::beginTransaction();
        try {
            $productName = $product->name;
            $product->delete(); // حذف مؤقت (يملأ عمود deleted_at)

            // إرسال إشعار لحظي أو في قاعدة البيانات
            $activeUser = auth('admin')->user() ?? auth('owner')->user();
            if ($activeUser) {
                $activeUser->notify(new \App\Notifications\GeneralNotification(
                    'أرشيف المنتجات',
                    'تم نقل المنتج (' . $productName . ') إلى الأرشيف مؤقتاً.'
                ));
            }

            DB::commit();

            return response()->json([
                'title'   => 'تم النقل للأرشيف',
                'message' => 'تم حذف المنتج مؤقتاً ونقله إلى الأرشيف بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر نقل المنتج للأرشيف.',
            ], 500);
        }
    }

    /**
     * عرض واجهة الأرشيف (المنتجات المحذوفة مؤقتاً فقط)
     */
    public function archive()
    {
        // جلب العناصر المحذوفة مؤقتاً فقط باستخدام onlyTrashed
        $products = Product::onlyTrashed()->with(['store', 'category'])->latest()->paginate(10);
        return view('cms.product.archive', compact('products'));
    }

    /**
     * استعادة المنتج من الأرشيف
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        DB::beginTransaction();
        try {
            $product->restore(); // إعادة تعيين deleted_at إلى null
            DB::commit();

            return response()->json([
                'title'   => 'تمت الاستعادة',
                'message' => 'تم استعادة المنتج وإرجاعه للواجهة الرئيسية بنجاح.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر استعادة المنتج.',
            ], 500);
        }
    }

    /**
     * الحذف النهائي والكامل من قاعدة البيانات (Force Delete)
     */
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        DB::beginTransaction();
        try {
            $imagePath = $product->main_image;

            // حذف الصورة المرتبطة من التخزين إن وجدت
            if ($imagePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
            }

            $product->forceDelete(); // حذف نهائي من الجدول
            DB::commit();

            return response()->json([
                'title'   => 'تم الحذف النهائي!',
                'message' => 'تم مسح المنتج من قاعدة البيانات بشكل نهائي.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'title'   => 'خطأ في النظام',
                'message' => 'تعذر الحذف النهائي للمنتج.',
            ], 500);
        }
    }
    /**
     * تصدير بيانات المنتجات إلى ملف CSV
     */
    public function export()
    {
        $this->authorize('viewAny', Product::class);

        $fileName = 'products_export_' . date('Y-m-d_H-i-s') . '.csv';
        $products = Product::with(['store', 'category'])->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            // إضافة BOM لدعم اللغة العربية في برامج الـ Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // رؤوس الأعمدة في الملف
            fputcsv($file, ['ID', 'اسم المنتج', 'رمز SKU', 'المتجر', 'التصنيف', 'السعر الأساسي', 'المخزون', 'الحالة']);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->store->name ?? 'غير محدد',
                    $product->category->name ?? 'غير محدد',
                    $product->base_price,
                    $product->stock_quantity,
                    $product->is_active
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $this->authorize('create', Product::class);

        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx,xls|max:2048'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $content = file_get_contents($path);

        // تحويل الترميز من ويندوز العربي إلى UTF-8 بامتياز ودون أخطاء
        $convertedContent = @iconv('Windows-1256', 'UTF-8//IGNORE', $content);
        if (!$convertedContent || trim($convertedContent) === '') {
            $convertedContent = $content; // لو كان الملف أصلاً UTF-8
        }

        // إزالة ترميز BOM إن وجد
        $convertedContent = str_replace("\xEF\xBB\xBF", '', $convertedContent);

        $lines = array_filter(explode("\n", $convertedContent));
        if (count($lines) <= 1) {
            return redirect()->back()->with('error', 'الملف فارغ أو لا يحتوي على بيانات.');
        }

        // استخراج صف العناوين الأول لتحديد أماكن الأعمدة بذكاء
        $headerRow = str_getcsv(trim(array_shift($lines)));

        $headerRow = array_map(function ($item) {
            return trim($item);
        }, $headerRow);

        $successCount = 0;

        foreach ($lines as $line) {
            $row = str_getcsv(trim($line));
            if (empty($row) || count($row) < 2) {
                continue;
            }

            $dataRow = [];
            foreach ($headerRow as $index => $heading) {
                $dataRow[$heading] = $row[$index] ?? null;
            }

            $name       = trim($dataRow['اسم المنتج'] ?? $row[1] ?? $row[0] ?? '');
            $sku        = trim($dataRow['رمز SKU'] ?? $dataRow['SKU'] ?? $row[2] ?? $row[1] ?? '');
            $base_price = is_numeric($dataRow['السعر الأساسي'] ?? $dataRow['السعر'] ?? $row[3] ?? null) ? ($dataRow['السعر الأساسي'] ?? $dataRow['السعر'] ?? $row[3]) : 50;
            $stock      = is_numeric($dataRow['المخزون'] ?? $row[4] ?? null) ? ($dataRow['المخزون'] ?? $row[4]) : 10;

            if (empty($name) || empty($sku)) {
                \Illuminate\Support\Facades\Log::error("فشل استيراد منتج لعدم وجود الاسم أو الـ SKU. البيانات: " . json_encode($row));
                continue;
            }

            if (Product::where('sku', $sku)->exists()) {
                continue;
            }

            Product::create([
                'name'           => $name,
                'sku'            => $sku,
                'stores_id'      => \App\Models\Store::first()->id ?? 1,
                'categories_id'  => \App\Models\Category::first()->id ?? 1,
                'base_price'     => $base_price,
                'stock_quantity' => $stock,
                'is_active'      => 'active'
            ]);

            $successCount++;
        }

        $activeUser = auth('admin')->user() ?? auth('owner')->user();
        if ($activeUser) {
            $activeUser->notify(new \App\Notifications\GeneralNotification(
                'استيراد البيانات',
                "تم استيراد [{$successCount}] سجل بنجاح من الملف."
            ));
        }

        return redirect()->back()->with('success', "تمت العملية بنجاح وتم استيراد {$successCount} منتج.");
    }
}
