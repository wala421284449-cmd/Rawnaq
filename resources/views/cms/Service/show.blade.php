@extends('parent')

@section('title', 'تفاصيل الخدمة | متجر رونق')
@section('main-title', 'الخدمات')
@section('sub-title', 'عرض تفاصيل ومعلومات الخدمة المحددة ضمن منصة رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .services-wrapper {
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
            box-shadow: 0 8px 18px rgba(190, 24, 93, 0.28);
        }

        .info-box {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 18px;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-box:hover {
            background: #ffffff;
            border-color: #fbcfe8;
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.04);
        }

        .info-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1e293b;
        }

        .service-desc-box {
            background: #fdf4ff;
            border: 1px dashed #fbcfe8;
            border-radius: 18px;
            padding: 1.5rem;
            color: #334155;
            font-size: 1rem;
            line-height: 1.8;
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
            box-shadow: 0 2px 8px rgba(190, 24, 93, 0.06);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 6px 15px rgba(190, 24, 93, 0.25);
            transform: translateY(-2px);
        }

        .btn-edit-custom {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.65rem 2rem;
            font-weight: 800;
            font-size: 0.95rem;
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
        }

        .btn-edit-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(190, 24, 93, 0.4);
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <div class="services-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-show-card border-0">
                        <!-- Header -->
                        <div class="show-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-grid-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تفاصيل الخدمة:
                                        {{ $service->name }}</h5>
                                    <small class="text-muted">رقم التعريف: #{{ $service->id }}</small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('services.index') }}" class="btn-return-custom">
                                    <i class="bi bi-arrow-right"></i>
                                    <span>العودة للقائمة</span>
                                </a>
                            </div>
                        </div>

                        <!-- Body Content -->
                        <div class="p-4">
                            <div class="row g-4">
                                <!-- اسم الخدمة -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-tag text-danger fs-5"></i>
                                            <span>اسم الخدمة</span>
                                        </div>
                                        <div class="info-value">{{ $service->name }}</div>
                                    </div>
                                </div>

                                <!-- المتجر -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-shop text-danger fs-5"></i>
                                            <span>المتجر التابع له</span>
                                        </div>
                                        <div class="info-value">
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $service->store->name ?? 'غير محدد' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- التصنيف -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-bookmark text-danger fs-5"></i>
                                            <span>التصنيف</span>
                                        </div>
                                        <div class="info-value">
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $service->category->name ?? 'غير محدد' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- السعر -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-cash-stack text-danger fs-5"></i>
                                            <span>السعر</span>
                                        </div>
                                        <div class="info-value text-danger">{{ $service->price }} $</div>
                                    </div>
                                </div>

                                <!-- مدة الخدمة -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-clock text-danger fs-5"></i>
                                            <span>مدة الخدمة</span>
                                        </div>
                                        <div class="info-value">{{ $service->duration_minutes }} دقيقة</div>
                                    </div>
                                </div>

                                <!-- حالة التوفر -->
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label">
                                            <i class="bi bi-flag text-danger fs-5"></i>
                                            <span>حالة توفر الخدمة</span>
                                        </div>
                                        <div class="info-value">
                                            @if ($service->is_available === 'available')
                                                <span
                                                    class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold">متوفرة</span>
                                            @else
                                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold">غير
                                                    متوفرة</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- وصف الخدمة -->
                                <div class="col-12">
                                    <div class="info-box">
                                        <div class="info-label mb-2">
                                            <i class="bi bi-text-paragraph text-danger fs-5"></i>
                                            <span>وصف الخدمة</span>
                                        </div>
                                        <div class="service-desc-box">
                                            {{ $service->description ?? 'لا يوجد وصف تفصيلي لهذه الخدمة.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="card-footer bg-white border-top p-4 d-flex justify-content-end">
                            <a href="{{ route('services.edit', $service->id) }}" class="btn-edit-custom">
                                <i class="bi bi-pencil-square fs-5"></i>
                                <span>تعديل الخدمة</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
