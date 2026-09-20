@extends('parent')
@section('title', 'تفاصيل المسمى الوظيفي: ' . $role->name . ' | متجر رونق')
@section('main-title', 'إدارة المسميات الوظيفية')
@section('sub-title', 'عرض تفاصيل الصلاحيات والنطاق للمسمى الوظيفي')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .role-show-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .profile-card,
        .info-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.06), 0 0 15px 0 rgba(147, 51, 234, 0.02);
            overflow: hidden;
            position: relative;
        }

        .profile-card::before,
        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 4px;
            background: var(--rawnaq-gradient);
        }

        .avatar-circle-lg {
            width: 95px;
            height: 95px;
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.6rem;
            margin: 0 auto;
            box-shadow: 0 10px 24px rgba(190, 24, 93, 0.32);
            border: 3px solid #ffffff;
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

        .info-card-header {
            color: var(--rawnaq-dark-title);
            font-weight: 800;
            font-size: 1.05rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-card-header i {
            color: var(--rawnaq-primary);
            font-size: 1.2rem;
        }

        .detail-box {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 16px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .item-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
            border: 1px solid #fbcfe8;
            color: var(--rawnaq-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .field-label {
            font-size: 0.8rem;
            color: #701a75;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .field-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 700;
        }
    </style>
@endsection

@section('content')
    <div class="role-show-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">

            <!-- Top Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">المسمى الوظيفي: {{ $role->name }}</h4>
                    <p class="text-muted small mb-0">عرض تفاصيل الصلاحيات ونطاق العمل الخاص بهذا الدور في متجر رونق</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('roles.index') }}" class="btn-back-custom d-flex align-items-center gap-2">
                        <span>العودة للقائمة</span>
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column: Overview -->
                <div class="col-lg-4 col-md-5">
                    <div class="card profile-card p-4 text-center">
                        <div class="avatar-circle-lg mb-3">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>

                        <h5 class="fw-bold text-dark mb-1">{{ $role->name }}</h5>
                        <p class="text-muted small mb-3">نطاق الحراسة:
                            @if ($role->guard_name == 'admin')
                                <span class="badge px-2 py-1"
                                    style="background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8;">مشرف
                                    (Admin)</span>
                            @elseif ($role->guard_name == 'customer')
                                <span class="badge px-2 py-1"
                                    style="background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe;">زبون
                                    (Customer)</span>
                            @elseif ($role->guard_name == 'owner')
                                <span class="badge px-2 py-1"
                                    style="background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3;">مالك
                                    (Owner)</span>
                            @else
                                <span class="badge px-2 py-1 bg-light text-secondary">{{ $role->guard_name }}</span>
                            @endif
                        </p>

                        <hr class="my-3" style="border-color: #fce7f3; opacity: 0.8;">

                        <div class="d-flex justify-content-between align-items-center small mb-3">
                            <span class="text-muted fw-semibold">معرف النظام (ID):</span>
                            <span class="fw-bold text-dark">#{{ $role->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small mb-3">
                            <span class="text-muted fw-semibold">تاريخ الإنشاء:</span>
                            <span class="fw-bold text-dark">{{ $role->created_at?->format('Y-m-d') ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details & Permissions -->
                <div class="col-lg-8 col-md-7">
                    <div class="card info-card p-4 mb-4 text-end">
                        <div class="info-card-header">
                            <i class="bi bi-shield-shaded"></i>
                            <span>معلومات المسمى الوظيفي الأساسية</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-person-badge"></i></div>
                                    <div>
                                        <div class="field-label">اسم المسمى الوظيفي</div>
                                        <div class="field-value">{{ $role->name }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-lock-fill"></i></div>
                                    <div>
                                        <div class="field-label">النطاق (Guard Name)</div>
                                        <div class="field-value">
                                            @if ($role->guard_name == 'admin')
                                                <span class="badge px-3 py-2"
                                                    style="background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; font-size: 0.85rem;">
                                                    مشرف (Admin)
                                                </span>
                                            @elseif ($role->guard_name == 'customer')
                                                <span class="badge px-3 py-2"
                                                    style="background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; font-size: 0.85rem;">
                                                    زبون (Customer)
                                                </span>
                                            @elseif ($role->guard_name == 'owner')
                                                <span class="badge px-3 py-2"
                                                    style="background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; font-size: 0.85rem;">
                                                    مالك (Owner)
                                                </span>
                                            @else
                                                {{ $role->guard_name }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
