@extends('parent')
@section('title', 'تفاصيل المشرف')
@section('main_title', 'إدارة المشرفين')
@section('sub_title', 'عرض الملف الشخصي للمشرف')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .admin-show-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .profile-card,
        .info-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .avatar-circle {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
        }

        .btn-back-custom {
            font-size: 0.875rem;
            color: #475569;
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 50px;
            padding: 0.4rem 1.25rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back-custom:hover {
            background-color: #f8fafc;
            color: #0f172a;
        }

        .info-label {
            font-size: 0.825rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
        }

        .item-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background-color: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .status-badge-lg {
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
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
    </style>
@endsection

@section('content')
    <div class="admin-show-wrapper py-4" dir="rtl">
        <div class="container-fluid px-3">

            <!-- Top Actions Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold text-dark mb-1">بيانات المشرف #{{ $admin->id }}</h4>
                    <p class="text-muted small mb-0">عرض كافة البيانات التفصيلية والحساب المرتبط</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admins.edit', $admin->id) }}"
                        class="btn btn-primary d-flex align-items-center gap-2">
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
                                    <i class="bi bi-check-circle-fill"></i> حساب نشط
                                </span>
                            @else
                                <span class="status-badge-lg status-inactive-lg">
                                    <i class="bi bi-x-circle-fill"></i> حساب معطل
                                </span>
                            @endif
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <div class="d-flex justify-content-between text-start small mb-2">
                            <span class="text-muted">الدور الإداري:</span>
                            <span class="fw-bold text-primary">{{ $admin->role ?? 'مشرف نظام' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-start small mb-2">
                            <span class="text-muted">تاريخ التسجيل:</span>
                            <span class="fw-semibold text-dark">{{ $admin->created_at?->format('Y-m-d') ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-start small">
                            <span class="text-muted">آخر تعديل:</span>
                            <span class="fw-semibold text-dark">{{ $admin->updated_at?->diffForHumans() ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right Detail Cards -->
                <div class="col-lg-8 col-md-7">
                    <!-- Contact Info -->
                    <div class="card info-card border-0 p-4 mb-4">
                        <h6 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-person-vcard"></i>
                            <span>معلومات الاتصال والحساب</span>
                        </h6>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                    <div class="item-icon"><i class="bi bi-envelope"></i></div>
                                    <div>
                                        <div class="info-label">البريد الإلكتروني</div>
                                        <div class="info-value">{{ $admin->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                    <div class="item-icon"><i class="bi bi-telephone"></i></div>
                                    <div>
                                        <div class="info-label">رقم الهاتف</div>
                                        <div class="info-value" style="direction: ltr; text-align: right;">
                                            {{ $admin->phone ?? 'غير مسجل' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="card info-card border-0 p-4">
                        <h6 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt"></i>
                            <span>بيانات العنوان والموقع</span>
                        </h6>

                        @if ($admin->address)
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                        <div class="item-icon"><i class="bi bi-buildings"></i></div>
                                        <div>
                                            <div class="info-label">المدينة</div>
                                            <div class="info-value">{{ $admin->address->city?->name ?? 'غير محددة' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                        <div class="item-icon"><i class="bi bi-pin-map"></i></div>
                                        <div>
                                            <div class="info-label">المنطقة / الحي</div>
                                            <div class="info-value">{{ $admin->address->area }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                        <div class="item-icon"><i class="bi bi-signpost-2"></i></div>
                                        <div>
                                            <div class="info-label">الشارع</div>
                                            <div class="info-value">{{ $admin->address->street }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                        <div class="item-icon"><i class="bi bi-building"></i></div>
                                        <div>
                                            <div class="info-label">تفاصيل المبنى</div>
                                            <div class="info-value">{{ $admin->address->building_details ?? 'لا يوجد' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($admin->address->latitude && $admin->address->longitude)
                                    <div class="col-12">
                                        <div
                                            class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="item-icon"><i class="bi bi-compass"></i></div>
                                                <div>
                                                    <div class="info-label">الإحداثيات الجغرافية</div>
                                                    <div class="info-value small">
                                                        Lat: {{ $admin->address->latitude }} | Long:
                                                        {{ $admin->address->longitude }}
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="https://www.google.com/maps?q={{ $admin->address->latitude }},{{ $admin->address->longitude }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-map"></i> فتح الخريطة
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4 bg-light rounded-3 text-muted">
                                <i class="bi bi-geo-slash fs-2 d-block mb-1 text-secondary opacity-50"></i>
                                <span>لم يتم ربط هذا المشرف بأي عنوان حتى الآن.</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
