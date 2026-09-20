@extends('parent')

@section('title', 'تفاصيل التقييم | متجر رونق')
@section('main-title', 'التقييمات والآراء')
@section('sub-title', 'استعراض تفاصيل تقييم العميل للمنتج والطلب المرتبط')

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

        .custom-show-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08);
            overflow: hidden;
            position: relative;
        }

        .custom-show-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .show-header {
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            border-bottom: 1px solid #f8fafc;
            padding: 1.75rem 2rem;
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
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.2);
        }

        /* تنسيق صناديق المعلومات بشكل مرتب ومتناسق RTL */
        .info-box {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 18px;
            padding: 1.25rem 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .info-box:hover {
            border-color: #fbcfe8;
            box-shadow: 0 5px 15px rgba(190, 24, 93, 0.03);
        }

        .info-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-align: right;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1e293b;
            text-align: right;
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: var(--rawnaq-primary);
            background: #ffffff;
            border: 1.5px solid #fbcfe8;
            border-radius: 50px;
            padding: 0.5rem 1.4rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
        }

        .comment-box {
            background: linear-gradient(to bottom, #fafafa, #fdf4ff);
            border: 1.5px dashed #fbcfe8;
        }
    </style>
@endsection

@section('content')
    <div class="reviews-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-show-card border-0">
                        <!-- رأس الصفحة -->
                        <div class="show-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <a href="{{ route('reviews.index') }}" class="btn-return-custom">
                                    <i class="bi bi-arrow-right"></i> <span>العودة للقائمة</span>
                                </a>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-end">
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تفاصيل التقييم رقم:
                                        #{{ $review->id }}</h5>
                                    <small class="text-muted">عرض تفاصيل التقييم والتعليق والمستخدم والمنتج</small>
                                </div>
                                <div class="header-icon-box"><i class="bi bi-star-fill"></i></div>
                            </div>
                        </div>

                        <!-- محتوى التفاصيل الفاخر -->
                        <div class="p-4">
                            <div class="row g-4">
                                <!-- اسم المستخدم -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-person text-danger fs-5"></i> <span>اسم المستخدم</span>
                                        </div>
                                        <div class="info-value">{{ $review->user->name ?? 'غير محدد' }}</div>
                                    </div>
                                </div>

                                <!-- المنتج المتقيّم -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-box-seam text-danger fs-5"></i> <span>المنتج المتقيّم</span>
                                        </div>
                                        <div class="info-value">{{ $review->product->name ?? 'غير محدد' }}</div>
                                    </div>
                                </div>

                                <!-- التقييم (النجوم) -->
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-star-fill text-warning fs-5"></i> <span>التقييم (النجوم)</span>
                                        </div>
                                        <div class="info-value text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= intval($review->rating) ? '-fill' : '' }}"></i>
                                            @endfor
                                            <span class="text-dark ms-2 fs-6">({{ $review->rating }}/5)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- الطلب المرتبط -->
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-receipt text-danger fs-5"></i> <span>الطلب المرتبط</span>
                                        </div>
                                        <div class="info-value">
                                            <span class="badge bg-light text-dark border px-3 py-1 rounded-pill">
                                                #{{ $review->orders_id ?? 'غير متوفر' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- حالة الموافقة -->
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-flag text-danger fs-5"></i> <span>حالة الموافقة</span>
                                        </div>
                                        <div class="info-value">
                                            <span
                                                class="badge {{ $review->is_approved == 'approved' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 rounded-pill">
                                                {{ $review->is_approved == 'approved' ? 'معتمد (Approved)' : 'معلق (Pending)' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- تعليق العميل -->
                                <div class="col-12">
                                    <div class="info-box comment-box">
                                        <div class="info-label">
                                            <i class="bi bi-chat-quote text-danger fs-5"></i> <span>تعليق العميل</span>
                                        </div>
                                        <div class="info-value fw-normal text-secondary py-2"
                                            style="line-height: 1.8; font-size: 1rem;">
                                            "{{ $review->comment }}"
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الإجراءات في الأسفل -->
                        <div class="card-footer bg-white border-top p-4 d-flex justify-content-end">
                            <a href="{{ route('reviews.edit', $review->id) }}"
                                class="btn px-4 py-2 fw-bold text-white shadow-sm"
                                style="background: var(--rawnaq-gradient); border: none; border-radius: 12px;">
                                <i class="bi bi-pencil-square"></i> تعديل التقييم
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
