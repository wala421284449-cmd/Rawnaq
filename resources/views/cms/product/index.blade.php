@extends('parent')

@section('title', 'إدارة المنتجات | متجر رونق')
@section('main-title', 'المنتجات')
@section('sub-title', 'عرض ومتابعة المنتجات والسلع المتاحة للمتاجر ضمن منصة رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .products-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08);
            overflow: hidden;
            position: relative;
        }

        .custom-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .card-header-custom {
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            border-bottom: 1px solid #f8fafc;
            padding: 1.75rem 2rem;
        }

        .btn-add-custom {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.65rem 1.6rem;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            transition: all 0.25s ease;
        }

        .btn-add-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(190, 24, 93, 0.4);
            color: #ffffff;
        }

        .btn-archive-custom {
            background: #ffffff;
            color: var(--rawnaq-primary);
            border: 2px solid #fbcfe8;
            border-radius: 14px;
            padding: 0.6rem 1.4rem;
            font-weight: 800;
            font-size: 0.92rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            transition: all 0.25s ease;
        }

        .btn-archive-custom:hover {
            background: #fdf4ff;
            border-color: var(--rawnaq-primary);
            color: var(--rawnaq-primary);
            transform: translateY(-2px);
        }

        .btn-export-custom {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.65rem 1.4rem;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            transition: all 0.25s ease;
        }

        .btn-export-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.35);
            color: #ffffff;
        }

        .btn-import-custom {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.65rem 1.4rem;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            transition: all 0.25s ease;
        }

        .btn-import-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.35);
            color: #ffffff;
        }

        .table-custom th {
            background-color: #fdf4ff;
            color: var(--rawnaq-dark-title);
            font-weight: 800;
            font-size: 0.88rem;
            border-bottom: 2px solid #fbcfe8;
            padding: 1.1rem;
            text-align: right;
        }

        .table-custom td {
            vertical-align: middle;
            padding: 1.1rem;
            font-size: 0.9rem;
            color: #334155;
            border-bottom: 1px solid #f8fafc;
            text-align: right;
        }

        .product-img {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #fbcfe8;
            box-shadow: 0 4px 10px rgba(190, 24, 93, 0.1);
        }

        .badge-status {
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-inactive {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-show {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .btn-edit {
            background-color: #fef3c7;
            color: #d97706;
        }

        .btn-delete {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <div class="products-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-card border-0">
                <!-- Header -->
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">قائمة المنتجات والسلع</h4>
                        <p class="text-muted mb-0 small">إدارة ومتابعة المنتجات، المخزون، والأسعار الخاصة بالمتاجر</p>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <!-- زر استيراد Excel (يفتح الـ Modal) -->
                        <button type="button" class="btn-import-custom" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="bi bi-file-earmark-arrow-up-fill fs-5"></i>
                            <span>استيراد Excel</span>
                        </button>

                        <!-- زر تصدير Excel -->
                        <a href="{{ route('admin.products.export') }}" class="btn-export-custom">
                            <i class="bi bi-file-earmark-excel-fill fs-5"></i>
                            <span>تصدير Excel</span>
                        </a>

                        <!-- زر الانتقال للأرشيف -->
                        <a href="{{ route('admin.products.archive') }}" class="btn-archive-custom">
                            <i class="bi bi-archive-fill fs-5"></i>
                            <span>أرشيف المحذوفات</span>
                        </a>

                        <!-- زر إنشاء منتج جديد -->
                        <a href="{{ route('products.create') }}" class="btn-add-custom">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                            <span>إنشاء منتج جديد</span>
                        </a>
                    </div>
                </div>

                <!-- Table Body -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th style="width: 70px;" class="text-center">الصورة</th>
                                    <th>اسم المنتج</th>
                                    <th>رمز المنتج (SKU)</th>
                                    <th>المتجر</th>
                                    <th>التصنيف</th>
                                    <th>السعر</th>
                                    <th class="text-center">المخزون</th>
                                    <th class="text-center">الحالة</th>
                                    <th class="text-center" style="width: 150px;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="fw-bold text-center">#{{ $product->id }}</td>
                                        <td class="text-center">
                                            @if ($product->main_image)
                                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="صورة المنتج"
                                                    class="product-img">
                                            @else
                                                <img src="{{ asset('images/default.png') }}" alt="صورة افتراضية"
                                                    class="product-img">
                                            @endif
                                        </td>
                                        <td class="fw-bold text-dark">{{ $product->name }}</td>
                                        <td><code class="text-purple bg-light px-2 py-1 rounded"
                                                dir="ltr">{{ $product->sku }}</code></td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $product->store->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $product->category->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-danger">{{ $product->base_price }} $</td>
                                        <td class="text-center fw-bold">{{ $product->stock_quantity }}</td>
                                        <td class="text-center">
                                            @if ($product->is_active === 'active')
                                                <span class="badge-status badge-active">نشط</span>
                                            @else
                                                <span class="badge-status badge-inactive">غير نشط</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('products.show', $product->id) }}"
                                                    class="action-btn btn-show" title="عرض التفاصيل">
                                                    <i class="bi bi-eye fs-6"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="action-btn btn-edit" title="تعديل">
                                                    <i class="bi bi-pencil fs-6"></i>
                                                </a>
                                                <button type="button" onclick="confirmDeleteProduct({{ $product->id }})"
                                                    class="action-btn btn-delete" title="نقل للأرشيف">
                                                    <i class="bi bi-trash fs-6"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="py-5 text-center text-muted">
                                            <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                            لا توجد منتجات مسجلة حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if (isset($products) && method_exists($products, 'hasPages') && $products->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal نموذج استيراد البيانات -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 20px;">
                <div class="modal-header bg-light" style="border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title fw-bold text-dark">استيراد بيانات المنتجات دفعة واحدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold text-secondary">اختر ملف CSV أو Excel:</label>
                            <input type="file" name="file" id="file" class="form-control"
                                accept=".csv, .txt, .xlsx" required style="border-radius: 12px; padding: 0.65rem;">
                            <small class="text-muted d-block mt-2">يجب أن يكون الملف بصيغة CSV وموافقاً لترتيب أعمدة التصدير
                                الخاصة بالنظام.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px;">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"
                            style="border-radius: 10px;">إلغاء</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold" style="border-radius: 10px;">بدء
                            الاستيراد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDeleteProduct(id) {
            Swal.fire({
                title: 'هل أنت متأكد من النقل للأرشيف؟',
                text: "سيتم نقل المنتج إلى الأرشيف ويمكنك استعادته لاحقاً!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، قم بالنقل',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/cms/admin/products/' + id)
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم النقل للأرشيف!',
                                text: response.data.message || 'تم حذف المنتج مؤقتاً بنجاح.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1200);
                        })
                        .catch(function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ!',
                                text: error.response?.data?.message ||
                                    'حدث خطأ أثناء محاولة الحذف المؤقت.'
                            });
                        });
                }
            });
        }
    </script>
@endsection
