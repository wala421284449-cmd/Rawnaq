@extends('parent')

@section('title', 'إدارة العروض | متجر رونق')
@section('main-title', 'العروض والتخفيضات')
@section('sub-title', 'عرض ومتابعة العروض الترويجية والخصومات الخاصة بالمنتجات والمتاجر')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .offers-wrapper {
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

        .discount-badge {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
            padding: 0.3rem 0.7rem;
            border-radius: 8px;
            font-weight: 800;
            font-size: 0.85rem;
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
    <div class="offers-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-card border-0">
                <!-- Header -->
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">قائمة العروض والخصومات</h4>
                        <p class="text-muted mb-0 small">إدارة وتتبع العروض الترويجية والأسعار الخاصة بالمنتجات</p>
                    </div>

                    <div>
                        <a href="{{ route('offers.create') }}" class="btn-add-custom">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                            <span>إنشاء عرض جديد</span>
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
                                    <th>عنوان العرض</th>
                                    <th>المنتج المستهدف</th>
                                    <th>المتجر</th>
                                    <th class="text-center">نسبة الخصم</th>
                                    <th>سعر العرض</th>
                                    <th>فترة العرض</th>
                                    <th class="text-center">الحالة</th>
                                    <th class="text-center" style="width: 150px;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($offers as $offer)
                                    <tr>
                                        <td class="fw-bold text-center">#{{ $offer->id }}</td>
                                        <td class="fw-bold text-dark">{{ $offer->title }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $offer->product->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $offer->store->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($offer->discount_percentage)
                                                <span class="discount-badge">{{ $offer->discount_percentage }}%</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-danger">{{ $offer->sale_price }} $</td>
                                        <td>
                                            <small class="text-muted d-block">من: {{ $offer->start_date }}</small>
                                            <small class="text-muted d-block">إلى: {{ $offer->end_date }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if ($offer->is_active === 'active')
                                                <span class="badge-status badge-active">نشط</span>
                                            @else
                                                <span class="badge-status badge-inactive">غير نشط</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('offers.show', $offer->id) }}" class="action-btn btn-show"
                                                    title="عرض التفاصيل">
                                                    <i class="bi bi-eye fs-6"></i>
                                                </a>
                                                <a href="{{ route('offers.edit', $offer->id) }}"
                                                    class="action-btn btn-edit" title="تعديل">
                                                    <i class="bi bi-pencil fs-6"></i>
                                                </a>
                                                <button type="button" onclick="confirmDeleteOffer({{ $offer->id }})"
                                                    class="action-btn btn-delete" title="حذف">
                                                    <i class="bi bi-trash fs-6"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-5 text-center text-muted">
                                            <i class="bi bi-tags fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                            لا توجد عروض مسجلة حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if (isset($offers) && method_exists($offers, 'hasPages') && $offers->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $offers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDeleteOffer(id) {
            Swal.fire({
                title: 'هل أنت متأكد من الحذف؟',
                text: "لن يمكنك استعادة هذا العرض بعد حذفه!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، قم بالحذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/cms/admin/offers/' + id)
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحذف!',
                                text: response.data.message || 'تم حذف العرض بنجاح.',
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
                                text: error.response?.data?.message || 'حدث خطأ أثناء محاولة الحذف.'
                            });
                        });
                }
            });
        }
    </script>
@endsection
