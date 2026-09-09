@extends('cms.parent')
@section('title', 'تفاصيل العنوان')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .address-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-form-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .form-header {
            border-bottom: 1px solid #f1f5f9;
        }

        .header-icon-box {
            width: 44px;
            height: 44px;
            background-color: #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: #475569;
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 50px;
            padding: 0.4rem 1.25rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .btn-return-custom:hover {
            background-color: #f8fafc;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1d4ed8;
        }

        .custom-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0.4rem;
        }

        .display-box {
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.925rem;
            color: #1e293b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            min-height: 45px;
        }

        .display-box i {
            color: #3b82f6;
            font-size: 1.1rem;
        }

        .coord-value {
            font-family: monospace;
            letter-spacing: 0.5px;
            color: #0f172a;
            direction: ltr;
        }

        .form-footer {
            background-color: #ffffff;
            border-top: 1px solid #f1f5f9;
            border-radius: 0 0 16px 16px;
        }

        .btn-edit-custom {
            background-color: #1d68f0;
            border: none;
            border-radius: 8px;
            padding: 0.55rem 1.6rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-edit-custom:hover {
            background-color: #1754c7;
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <div class="address-wrapper py-4" dir="rtl">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header px-4 py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-eye-fill fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">تفاصيل العنوان</h5>
                                    <small class="text-muted">عرض البيانات المسجلة للموقع الجغرافي</small>
                                </div>
                            </div>
                            <a href="{{ route('addresses.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Content Body -->
                        <div class="p-4">

                            <!-- Section 1: Basic Info -->
                            <div class="section-title mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle"></i>
                                <span>البيانات الأساسية</span>
                            </div>

                            <div class="row g-3 mb-3">
                                <!-- Street Name -->
                                <div class="col-md-6">
                                    <label class="custom-label">اسم الشارع / العنوان</label>
                                    <div class="display-box">
                                        <i class="bi bi-signpost-2"></i>
                                        <span>{{ $address->street }}</span>
                                    </div>
                                </div>

                                <!-- Nearest Landmark -->
                                <div class="col-md-6">
                                    <label class="custom-label">أقرب معلم</label>
                                    <div class="display-box">
                                        <i class="bi bi-building"></i>
                                        <span>{{ $address->nearest_landmark }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- City Info -->
                            <div class="mb-4">
                                <label class="custom-label">المدينة التابع لها</label>
                                <div class="display-box">
                                    <i class="bi bi-pin-map"></i>
                                    <span>{{ $address->city->name ?? 'غير محدد' }}</span>
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <!-- Section 2: Coordinates -->
                            <div class="section-title mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-geo"></i>
                                <span>الإحداثيات الجغرافية (Coordinates)</span>
                            </div>

                            <div class="row g-3">
                                <!-- Latitude -->
                                <div class="col-md-6">
                                    <label class="custom-label">خط العرض (Latitude)</label>
                                    <div class="display-box">
                                        <i class="bi bi-compass"></i>
                                        <span class="coord-value">{{ $address->latitude ?? $address->lateitude }}</span>
                                    </div>
                                </div>

                                <!-- Longitude -->
                                <div class="col-md-6">
                                    <label class="custom-label">خط الطول (Longitude)</label>
                                    <div class="display-box">
                                        <i class="bi bi-compass"></i>
                                        <span class="coord-value">{{ $address->longitude }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Actions -->
                        <div class="form-footer px-4 py-3 d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('addresses.index') }}" class="btn-return-custom">
                                العودة
                            </a>
                            <a href="{{ route('addresses.edit', $address->id) }}" class="btn-edit-custom d-flex align-items-center gap-2">
                                <i class="bi bi-pencil-square"></i>
                                <span>انتقال للتعديل</span>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection