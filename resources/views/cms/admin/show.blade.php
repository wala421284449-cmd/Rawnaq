@extends('parent')
@section('title', 'تفاصيل المشرف | متجر رونق')
@section('main-title', 'إدارة المشرفين')
@section('sub-title', 'عرض الملف الشخصي وبيانات المشرف')

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

        .admin-show-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        /* البطاقات الأساسية */
        .profile-card,
        .info-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.06), 0 0 15px 0 rgba(147, 51, 234, 0.02);
            overflow: hidden;
            position: relative;
        }

        /* شريط علوي ملون يعكس هوية المتجر */
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

        /* دائرة الصورة الرمزية */
        .avatar-circle {
            width: 100px;
            height: 100px;
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            margin: 0 auto;
            box-shadow: 0 10px 24px rgba(190, 24, 93, 0.32);
            border: 3px solid #ffffff;
            transition: transform 0.3s ease;
        }

        .profile-card:hover .avatar-circle {
            transform: scale(1.05);
        }

        /* أزرار الإجراءات العلوية */
        .btn-edit-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.55rem 1.4rem;
            font-size: 0.9rem;
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

        /* نصوص وبطاقات التفاصيل */
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
            transition: all 0.25s ease;
        }

        .detail-box:hover {
            background: #ffffff;
            border-color: #fbcfe8;
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.05);
            transform: translateY(-1px);
        }

        .info-label {
            font-size: 0.8rem;
            color: #701a75;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .info-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 700;
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

        /* شارات الحالة المنسجمة */
        .status-badge-lg {
            padding: 0.45rem 1.1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-active-lg {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .status-inactive-lg {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .role-pill {
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
            color: #86198f;
            border: 1px solid #f5d0fe;
            border-radius: 8px;
            padding: 0.25rem 0.65rem;
            font-size: 0.825rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-map-link {
            border: 1.5px solid var(--rawnaq-primary);
            color: var(--rawnaq-primary);
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.4rem 1rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-map-link:hover {
            background-color: var(--rawnaq-primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(190, 24, 93, 0.25);
        }
    </style>
@endsection

@section('content')
    <div class="admin-show-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">

            <!-- Top Actions Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">ملف المشرف: {{ $admin->name }}</h4>
                    <p class="text-muted small mb-0">استعراض تفاصيل الحساب، الصلاحيات، وبيانات الموقع في متجر رونق</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admins.edit', $admin->id) }}" class="btn-edit-custom d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square"></i>
                        <span>تعديل البيانات</span>
                    </a>
                    <a href="{{ route('admins.index') }}" class="btn-back-custom d-flex align-items-center gap-2">
                        <span>العودة للقائمة</span>
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Profile Summary Card -->
                <div class="col-lg-4 col-md-5">
                    <div class="card profile-card border-0 p-4 text-center">
                        <div class="avatar-circle mb-3">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $admin->name }}</h5>
                        <p class="text-muted small mb-3">{{ $admin->email }}</p>

                        <div class="mb-4">
                            @if ($admin->status == 'active' || $admin->status == 1)
                                <span class="status-badge-lg status-active-lg">
                                    <i class="bi bi-check-circle-fill"></i> حساب نشط (مفعل)
                                </span>
                            @else
                                <span class="status-badge-lg status-inactive-lg">
                                    <i class="bi bi-x-circle-fill"></i> حساب معطل
                                </span>
                            @endif
                        </div>

                        <hr class="my-3" style="border-color: #fce7f3; opacity: 0.8;">

                        <div class="d-flex justify-content-between align-items-center small mb-3">
                            <span class="text-muted fw-semibold">الدور في النظام:</span>
                            <span class="role-pill">
                                <i class="bi bi-shield-check"></i>
                                {{ $admin->role ?? 'مشرف نظام' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small mb-3">
                            <span class="text-muted fw-semibold">الجنس:</span>
                            <span class="fw-bold text-dark">
                                {{ $admin->gender == 'female' || $admin->gender == 'أنثى' ? 'أنثى' : 'ذكر' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small mb-3">
                            <span class="text-muted fw-semibold">تاريخ الانضمام:</span>
                            <span class="fw-bold text-dark">{{ $admin->created_at?->format('Y-m-d') ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small">
                            <span class="text-muted fw-semibold">آخر نشاط/تعديل:</span>
                            <span class="fw-bold" style="color: var(--rawnaq-primary);">
                                {{ $admin->updated_at?->diffForHumans() ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Detail Cards -->
                <div class="col-lg-8 col-md-7">
                    <!-- Contact Info -->
                    <div class="card info-card border-0 p-4 mb-4">
                        <div class="info-card-header">
                            <i class="bi bi-person-vcard-fill"></i>
                            <span>بيانات الاتصال والحساب</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-envelope-at-fill"></i></div>
                                    <div>
                                        <div class="info-label">البريد الإلكتروني المعتمد</div>
                                        <div class="info-value text-break">{{ $admin->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-telephone-inbound-fill"></i></div>
                                    <div>
                                        <div class="info-label">رقم الهاتف الأساسي</div>
                                        <div class="info-value" style="direction: ltr; text-align: right;">
                                            {{ $admin->phone ?? 'غير مسجل' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="card info-card border-0 p-4">
                        <div class="info-card-header">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>تفاصيل العنوان الجغرافي المسجل</span>
                        </div>

                        @if ($admin->address)
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-buildings-fill"></i></div>
                                        <div>
                                            <div class="info-label">المدينة</div>
                                            <div class="info-value">{{ $admin->address->city?->name ?? 'غير محددة' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-pin-map-fill"></i></div>
                                        <div>
                                            <div class="info-label">المنطقة / الحي</div>
                                            <div class="info-value">{{ $admin->address->area }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-signpost-2-fill"></i></div>
                                        <div>
                                            <div class="info-label">الشارع</div>
                                            <div class="info-value">{{ $admin->address->street }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-building"></i></div>
                                        <div>
                                            <div class="info-label">تفاصيل المبنى / المعلم</div>
                                            <div class="info-value">
                                                {{ $admin->address->building_details ?? 'لا توجد تفاصيل إضافية' }}</div>
                                        </div>
                                    </div>
                                </div>

                                @if ($admin->address->latitude && $admin->address->longitude)
                                    <div class="col-12">
                                        <div class="detail-box justify-content-between flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="item-icon"><i class="bi bi-compass-fill"></i></div>
                                                <div>
                                                    <div class="info-label">الإحداثيات الجغرافية المحددة</div>
                                                    <div class="info-value small font-monospace">
                                                        Lat: {{ $admin->address->latitude }} | Long:
                                                        {{ $admin->address->longitude }}
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="https://www.google.com/maps?q={{ $admin->address->latitude }},{{ $admin->address->longitude }}"
                                                target="_blank" class="btn-map-link d-inline-flex align-items-center gap-2">
                                                <i class="bi bi-map"></i>
                                                <span>فتح في الخرائط</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5 rounded-4"
                                style="background: #fdf4ff; border: 1.5px dashed #f5d0fe;">
                                <div class="d-inline-flex p-3 rounded-circle mb-2"
                                    style="background: #ffffff; color: var(--rawnaq-primary);">
                                    <i class="bi bi-geo-slash fs-2"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">لا يوجد عنوان مسجل</h6>
                                <p class="text-muted small mb-0">لم يتم ربط هذا المشرف بأي عنوان جغرافي حتى الآن.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
