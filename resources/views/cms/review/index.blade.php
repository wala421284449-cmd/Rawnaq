@extends('parent')

@section('title', 'إدارة التقييمات | متجر رونق')
@section('main-title', 'التقييمات والآراء')
@section('sub-title', 'مراجعة واعتماد تقييمات العملاء للمنتجات والطلبات')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .reviews-wrapper {
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
            opacity: 0.92;
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <div class="reviews-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-card border-0">
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">قائمة التقييمات</h4>
                        <p class="text-muted mb-0 small">متابعة آراء وتعليقات العملاء على المنتجات</p>
                    </div>
                    <div>
                        <a href="{{ route('reviews.create') }}" class="btn-add-custom">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                            <span>إنشاء تقييم جديد</span>
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th>المستخدم</th>
                                    <th>المنتج</th>
                                    <th>التقييم (النجوم)</th>
                                    <th>التعليق</th>
                                    <th>الحالة</th>
                                    <th class="text-center" style="width: 150px;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reviews as $review)
                                    <tr>
                                        <td class="fw-bold text-center">#{{ $review->id }}</td>
                                        <td class="fw-bold text-dark">{{ $review->user->name ?? 'مستخدم محذوف' }}</td>
                                        <td>{{ $review->product->name ?? 'منتج غير محدد' }}</td>
                                        <td><span class="badge bg-warning text-dark px-2 py-1"><i
                                                    class="bi bi-star-fill"></i> {{ $review->rating }}</span></td>
                                        <td>{{ Str::limit($review->comment, 30) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $review->is_approved == 'approved' ? 'bg-success' : 'bg-secondary' }} px-3 py-1 rounded-pill">
                                                {{ $review->is_approved }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('reviews.show', $review->id) }}"
                                                    class="action-btn btn-show" title="عرض التفاصيل">
                                                    <i class="bi bi-eye fs-6"></i>
                                                </a>
                                                <a href="{{ route('reviews.edit', $review->id) }}"
                                                    class="action-btn btn-edit" title="تعديل الحالة">
                                                    <i class="bi bi-pencil fs-6"></i>
                                                </a>
                                                <button type="button" onclick="confirmDeleteReview({{ $review->id }})"
                                                    class="action-btn btn-delete" title="حذف">
                                                    <i class="bi bi-trash fs-6"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-5 text-center text-muted">
                                            <i class="bi bi-star fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                            لا توجد تقييمات مسجلة حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if (isset($reviews) && method_exists($reviews, 'hasPages') && $reviews->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDeleteReview(id) {
            Swal.fire({
                title: 'هل أنت متأكد من الحذف؟',
                text: "لن يمكنك استعادة هذا التقييم بعد حذفه!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، قم بالحذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/cms/admin/reviews/' + id)
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحذف!',
                                text: response.data.message,
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
                                text: error.response?.data?.message || 'حدث خطأ أثناء الحذف.'
                            });
                        });
                }
            });
        }
    </script>
@endsection
