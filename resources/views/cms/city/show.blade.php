@extends('parent')
@section('title', 'تفاصيل المدينة: ' . $city->name . ' | متجر رونق')
@section('main-title', 'إدارة المدن')
@section('sub-title', 'عرض تفاصيل وبيانات المدينة')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #fce7f3;
            --rawnaq-bg-soft: #fdf4ff;
        }

        .city-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        /* كرت التفاصيل الفاخر */
        .detail-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.07), 0 0 15px 0 rgba(147, 51, 234, 0.03);
            overflow: hidden;
            position: relative;
        }

        /* شريط علوي ملون يعكس هوية المتجر */
        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .card-header-custom {
            border-bottom: 1px solid #fce7f3;
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            padding: 1.25rem 1.75rem;
        }

        .header-icon-box {
            width: 50px;
            height: 50px;
            background: var(--rawnaq-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.35rem;
            box-shadow: 0 8px 18px rgba(190, 24, 93, 0.28);
            transform: rotate(-3deg);
            transition: transform 0.3s ease;
        }

        .detail-card:hover .header-icon-box {
            transform: rotate(0deg) scale(1.05);
        }

        .btn-back-custom {
            font-size: 0.875rem;
            color: var(--rawnaq-primary);
            background-color: #ffffff;
            border: 1.5px solid #fbcfe8;
            border-radius: 50px;
            padding: 0.45rem 1.35rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(190, 24, 93, 0.06);
            transition: all 0.25s ease;
        }

        .btn-back-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 6px 15px rgba(190, 24, 93, 0.25);
            transform: translateY(-2px);
        }

        /* أسطر التفاصيل */
        .detail-row {
            padding: 1.15rem 1.25rem;
            border-bottom: 1px solid #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .detail-row:hover {
            background-color: #fdf4ff;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 700;
            color: #475569;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-label i {
            color: var(--rawnaq-primary);
            font-size: 1.1rem;
        }

        .detail-value {
            font-weight: 700;
            color: #1e293b;
            font-size: 0.95rem;
        }

        .slug-badge {
            background: #faf5ff;
            color: #7e22ce;
            border: 1px solid #f3e8ff;
            padding: 0.35rem 0.8rem;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
            font-size: 0.825rem;
            font-weight: 700;
        }

        .status-available {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .status-unavailable {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* الفوتر */
        .card-footer-custom {
            background: linear-gradient(to right, #ffffff, #fdf4ff);
            border-top: 1px solid #fce7f3;
            padding: 1.25rem 2rem;
            border-radius: 0 0 24px 24px;
        }

        .btn-edit-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.8rem;
            font-size: 0.92rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            box-shadow: 0 6px 18px rgba(190, 24, 93, 0.3);
            transition: all 0.25s ease;
        }

        .btn-edit-custom:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(190, 24, 93, 0.42);
        }
    </style>
@endsection

@section('content')
    <div class="city-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="card detail-card border-0">

                        <!-- Header -->
                        <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-buildings-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تفاصيل المدينة:
                                        {{ $city->name }}</h5>
                                    <small class="text-muted">البيانات الكاملة للمدينة المسجلة في متجر رونق</small>
                                </div>
                            </div>
                            <a href="{{ route('cities.index') }}" class="btn-back-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Body: عرض كل شيء بالتفصيل -->
                        <div class="p-4">
                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-hash"></i> الرقم التعريفي (ID):</span>
                                <span class="detail-value" style="color: #9333ea;">#{{ $city->id }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-building"></i> اسم المدينة (City Name):</span>
                                <span class="detail-value text-dark fs-6">{{ $city->name }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-link-45deg"></i> الرابط اللطيف (Slug):</span>
                                <span class="slug-badge">{{ $city->slug ?? 'غير محدد' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-toggle2-on"></i> حالة التفعيل (Status):</span>
                                <span>
                                    @if ($city->is_active == 1 || $city->is_active === 'active' || $city->is_active === '1')
                                        <span class="status-badge status-available">
                                            <i class="bi bi-check-circle-fill"></i> مفعلة في النظام
                                        </span>
                                    @else
                                        <span class="status-badge status-unavailable">
                                            <i class="bi bi-x-circle-fill"></i> غير مفعلة
                                        </span>
                                    @endif
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-calendar-plus"></i> تاريخ الإنشاء:</span>
                                <span class="detail-value text-secondary" dir="ltr">
                                    {{ $city->created_at ? $city->created_at->format('Y-m-d - h:i A') : 'غير متوفر' }}
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-clock-history"></i> آخر تعديل:</span>
                                <span class="detail-value text-secondary" dir="ltr">
                                    {{ $city->updated_at ? $city->updated_at->format('Y-m-d - h:i A') : 'غير متوفر' }}
                                </span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer-custom d-flex justify-content-end">
                            <a href="{{ route('cities.edit', $city->id) }}"
                                class="btn-edit-custom d-flex align-items-center gap-2">
                                <i class="bi bi-pencil-square"></i>
                                <span>تعديل المدينة</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
