@extends('parent')

@section('title', 'تعديل التقييم | متجر رونق')
@section('main-title', 'التقييمات والآراء')
@section('sub-title', 'تحديث حالة الاعتماد أو محتوى التقييم')

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

        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08);
            overflow: hidden;
            position: relative;
        }

        .custom-form-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .form-header {
            border-bottom: 1px solid #f8fafc;
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            padding: 1.25rem 1.75rem;
        }

        .header-icon-box {
            width: 52px;
            height: 52px;
            background: var(--rawnaq-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.4rem;
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: var(--rawnaq-primary);
            background: #ffffff;
            border: 1.5px solid #fbcfe8;
            border-radius: 50px;
            padding: 0.45rem 1.35rem;
            font-weight: 700;
            text-decoration: none;
        }

        .section-box {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .custom-label {
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.45rem;
        }

        .input-group-custom .input-group-text {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
        }

        .input-group-custom .form-control,
        .input-group-custom .form-select {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            padding: 0.65rem 1rem;
            color: #1e293b;
        }

        .form-footer {
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            padding: 1.25rem 2rem;
            border-radius: 0 0 24px 24px;
        }

        .btn-save-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.65rem 2rem;
            font-size: 0.95rem;
            font-weight: 800;
            color: #ffffff;
            cursor: pointer;
        }

        .btn-cancel-custom {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 1.6rem;
            color: #64748b;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="reviews-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-form-card border-0">
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box"><i class="bi bi-pencil-square"></i></div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تعديل التقييم رقم:
                                        #{{ $review->id }}</h5>
                                    <small class="text-muted">تحديث حالة الموافقة أو محتوى التعليق</small>
                                </div>
                            </div>
                            <a href="{{ route('reviews.index') }}" class="btn-return-custom">العودة للقائمة <i
                                    class="bi bi-arrow-left"></i></a>
                        </div>

                        <form id="update_review_form">
                            @csrf
                            @method('PUT')
                            <div class="p-4">
                                <div class="section-box">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="custom-label">التقييم (النجوم)</label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-star"></i></span>
                                                <input type="text" name="rating" id="rating" class="form-control"
                                                    value="{{ $review->rating }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">حالة الموافقة (is_approved)</label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                                <select name="is_approved" id="is_approved" class="form-select" required>
                                                    <option value="pending"
                                                        {{ $review->is_approved == 'pending' ? 'selected' : '' }}>Pending
                                                        (معلق)</option>
                                                    <option value="approved"
                                                        {{ $review->is_approved == 'approved' ? 'selected' : '' }}>Approved
                                                        (معتمد)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="custom-label">تعليق العميل</label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-chat-text"></i></span>
                                                <input type="text" name="comment" id="comment" class="form-control"
                                                    value="{{ $review->comment }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('reviews.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performUpdateReview({{ $review->id }})"
                                    class="btn-save-custom">تحديث التقييم</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function performUpdateReview(id) {
            let formData = {
                rating: document.getElementById('rating').value,
                comment: document.getElementById('comment').value,
                is_approved: document.getElementById('is_approved').value,
            };

            axios.put('/cms/admin/reviews/' + id, formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title,
                        text: response.data.message,
                        timer: 1200,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('reviews.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في التحديث',
                        text: error.response?.data?.message || 'حدث خطأ'
                    });
                });
        }
    </script>
@endsection
