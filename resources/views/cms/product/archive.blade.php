@extends('parent')

@section('title', 'أرشيف المنتجات | متجر رونق')
@section('main-title', 'أرشيف المنتجات المحذوفة')
@section('sub-title', 'إدارة ومتابعة المنتجات المؤرشفة وإمكانية استعادتها أو حذفها نهائياً')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .archive-wrapper {
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

        .btn-back-custom {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.65rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.25);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
        }

        .btn-back-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(190, 24, 93, 0.35);
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

        .action-btn {
            padding: 0.45rem 1rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-restore {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .btn-restore:hover {
            background-color: #065f46;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-force-delete {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .btn-force-delete:hover {
            background-color: #991b1b;
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <div class="archive-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-card border-0">
                <!-- Header -->
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">
                            <i class="bi bi-archive-fill me-2" style="color: var(--rawnaq-primary);"></i> أرشيف المنتجات
                            المحذوفة
                        </h4>
                        <p class="text-muted mb-0 small">استعراض العناصر المؤرشفة، مع إمكانية استعادتها للواجهة النشطة أو
                            حذفها نهائياً</p>
                    </div>

                    <div>
                        <a href="{{ route('products.index') }}" class="btn-back-custom">
                            <i class="bi bi-arrow-right fs-5"></i>
                            <span>العودة للمنتجات النشطة</span>
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
                                    <th>تاريخ الحذف</th>
                                    <th class="text-center" style="width: 220px;">الإجراءات</th>
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
                                        <td>
                                            <code class="text-purple bg-light px-2 py-1 rounded"
                                                dir="ltr">{{ $product->sku }}</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $product->store->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted" dir="rtl">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $product->deleted_at->locale('ar')->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- زر الاستعادة -->
                                                <button type="button"
                                                    onclick="restoreProduct('{{ route('admin.products.restore', $product->id) }}')"
                                                    class="action-btn btn-restore" title="استعادة المنتج">
                                                    <i class="bi bi-arrow-counterclockwise fs-6"></i>
                                                    <span>استعادة</span>
                                                </button>

                                                <!-- زر الحذف النهائي -->
                                                <button type="button"
                                                    onclick="forceDeleteProduct('{{ route('admin.products.forceDelete', $product->id) }}')"
                                                    class="action-btn btn-force-delete" title="حذف نهائي">
                                                    <i class="bi bi-trash-fill fs-6"></i>
                                                    <span>حذف نهائي</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-5 text-center text-muted">
                                            <i
                                                class="bi bi-folder2-open display-4 text-secondary opacity-50 mb-3 d-block"></i>
                                            <h6 class="fw-bold text-dark mb-1">الأرشيف فارغ تماماً</h6>
                                            <p class="small text-muted mb-0">لا توجد أي منتجات محذوفة مؤقتاً في الوقت
                                                الحالي.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if (isset($products) && method_exists($products, 'hasPages') && $products->hasPages())
                    <div class="card-footer bg-white py-3 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // دالة الاستعادة باستخدام Axios و SweetAlert2
        function restoreProduct(url) {
            Swal.fire({
                title: 'هل أنت متأكد من استعادة المنتج؟',
                text: "سيتم إرجاع المنتج إلى قائمة المنتجات النشطة في النظام.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، استعد!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(url)
                        .then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'تمت الاستعادة!',
                                text: response.data.message ||
                                    'تم إرجاع المنتج للواجهة الرئيسية بنجاح.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1200);
                        })
                        .catch(error => {
                            Swal.fire('خطأ!', 'حدث خطأ أثناء محاولة الاستعادة.', 'error');
                        });
                }
            });
        }

        // دالة الحذف النهائي باستخدام Axios و SweetAlert2
        function forceDeleteProduct(url) {
            Swal.fire({
                title: 'تحذير: حذف نهائي!',
                text: "لن تتمكن من استعادة هذا المنتج نهائياً بعد الآن من قاعدة البيانات!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، احذف نهائياً!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(url)
                        .then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحذف النهائي!',
                                text: response.data.message || 'تم مسح المنتج من النظام نهائياً.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1200);
                        })
                        .catch(error => {
                            Swal.fire('خطأ!', 'حدث خطأ أثناء محاولة الحذف النهائي.', 'error');
                        });
                }
            });
        }
    </script>
@endsection
