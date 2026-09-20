@extends('parent')

@section('title', 'تفاصيل الزبون: ' . $customer->name . ' | متجر رونق')
@section('main-title', 'إدارة الزبائن')
@section('sub-title', 'عرض الملف الشخصي وسجل طلبات الزبون')

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

        .customer-show-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        /* كروت التفاصيل الفاخرة */
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

        /* الصورة الرمزية للزبون */
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
            transition: transform 0.3s ease;
        }

        .profile-card:hover .avatar-circle-lg {
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

        /* رؤوس بطاقات المعلومات */
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

        /* صناديق تفاصيل البيانات */
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

        .ltr-value {
            direction: ltr;
            display: inline-block;
            text-align: right;
        }

        /* شارات الحالة الموحدة */
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

        /* جدول الطلبات */
        .orders-table thead th {
            background-color: #fdf4ff;
            color: #581c87;
            font-weight: 800;
            font-size: 0.85rem;
            border-bottom: 1px solid #f5d0fe;
            padding: 0.85rem 1rem;
        }

        .orders-table tbody td {
            padding: 0.85rem 1rem;
            color: #334155;
            font-size: 0.9rem;
            border-bottom: 1px solid #f8fafc;
        }

        .orders-table tbody tr:hover {
            background-color: #fdf2f8;
        }

        .order-status-badge {
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
            color: var(--rawnaq-primary);
            border: 1px solid #f5d0fe;
            border-radius: 20px;
            padding: 0.25rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 700;
        }
    </style>
@endsection

@section('content')
    <div class="customer-show-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">

            <!-- Top Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">ملف الزبون: {{ $customer->name }}</h4>
                    <p class="text-muted small mb-0">عرض كافة البيانات الشخصية وعنوان التوصيل وسجل المشتريات في متجر رونق</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('customers.edit', $customer->id) }}"
                        class="btn-edit-custom d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square"></i>
                        <span>تعديل البيانات</span>
                    </a>
                    <a href="{{ route('customers.index') }}" class="btn-back-custom d-flex align-items-center gap-2">
                        <span>العودة للقائمة</span>
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column: Customer Profile Overview -->
                <div class="col-lg-4 col-md-5">
                    <div class="card profile-card p-4 text-center">
                        <div class="avatar-circle-lg mb-3">
                            <i
                                class="bi {{ $customer->gender == 'female' || $customer->gender == 'أنثى' ? 'bi-person-heart' : 'bi-person' }}"></i>
                        </div>

                        <h5 class="fw-bold text-dark mb-1">{{ $customer->name }}</h5>
                        <p class="text-muted small mb-3 ltr-value">{{ $customer->email }}</p>

                        <div class="mb-3">
                            @if ($customer->status == 'active' || $customer->status == 1)
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
                            <span class="text-muted fw-semibold">نوع الحساب:</span>
                            <span class="role-pill">
                                <i class="bi bi-person-check-fill"></i>
                                زبون / عميل متجر
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small mb-3">
                            <span class="text-muted fw-semibold">الجنس:</span>
                            <span class="fw-bold text-dark">
                                {{ $customer->gender == 'female' || $customer->gender == 'أنثى' ? 'أنثى' : 'ذكر' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small mb-3">
                            <span class="text-muted fw-semibold">تاريخ الانضمام:</span>
                            <span class="fw-bold text-dark">{{ $customer->created_at?->format('Y-m-d') ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small">
                            <span class="text-muted fw-semibold">إجمالي الطلبات:</span>
                            <span class="fw-bold" style="color: var(--rawnaq-primary);">
                                {{ $customer->orders?->count() ?? 0 }} طلب
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details & Orders -->
                <div class="col-lg-8 col-md-7">

                    <!-- Contact & Identity Info -->
                    <div class="card info-card p-4 mb-4 text-end">
                        <div class="info-card-header">
                            <i class="bi bi-person-vcard-fill"></i>
                            <span>بيانات الهوية والتواصل</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-card-heading"></i></div>
                                    <div>
                                        <div class="field-label">رقم الهوية الشخصية</div>
                                        <div class="field-value ltr-value">
                                            {{ $customer->id_number ?? ($customer->actor?->id_number ?? 'غير مسجل') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-whatsapp"></i></div>
                                    <div>
                                        <div class="field-label">رقم الواتساب</div>
                                        <div class="field-value ltr-value">
                                            {{ $customer->whats_up_number ?? ($customer->actor?->whats_up_number ?? 'غير مسجل') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-telephone-inbound-fill"></i></div>
                                    <div>
                                        <div class="field-label">رقم الهاتف الأساسي</div>
                                        <div class="field-value ltr-value">{{ $customer->phone ?? 'غير مسجل' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="detail-box">
                                    <div class="item-icon"><i class="bi bi-envelope-at-fill"></i></div>
                                    <div>
                                        <div class="field-label">البريد الإلكتروني المعتمد</div>
                                        <div class="field-value ltr-value text-break">{{ $customer->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="card info-card p-4 mb-4 text-end">
                        <div class="info-card-header">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>عنوان التوصيل المسجل</span>
                        </div>

                        @if ($customer->address)
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-buildings-fill"></i></div>
                                        <div>
                                            <div class="field-label">المدينة</div>
                                            <div class="field-value">{{ $customer->address->city?->name ?? 'غير محددة' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-pin-map-fill"></i></div>
                                        <div>
                                            <div class="field-label">المنطقة / الحي</div>
                                            <div class="field-value">{{ $customer->address->area }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-signpost-2-fill"></i></div>
                                        <div>
                                            <div class="field-label">اسم الشارع</div>
                                            <div class="field-value">{{ $customer->address->street }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-box">
                                        <div class="item-icon"><i class="bi bi-building"></i></div>
                                        <div>
                                            <div class="field-label">تفاصيل إضافية / أقرب معلم</div>
                                            <div class="field-value">
                                                {{ $customer->address->building_details ?? 'لا يوجد' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4 rounded-4"
                                style="background: #fdf4ff; border: 1.5px dashed #f5d0fe;">
                                <div class="d-inline-flex p-3 rounded-circle mb-2"
                                    style="background: #ffffff; color: var(--rawnaq-primary);">
                                    <i class="bi bi-geo-slash fs-2"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">لا يوجد عنوان توصيل</h6>
                                <p class="text-muted small mb-0">لم يقم هذا الزبون بتسجيل عنوان توصيل حتى الآن.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Orders Placed by this Customer -->
                    <div class="card info-card p-4 text-end">
                        <div class="info-card-header justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-bag-check-fill"></i>
                                <span>طلبات ومشتريات الزبون</span>
                            </div>
                            <span class="role-pill">
                                {{ $customer->orders?->count() ?? 0 }} طلب
                            </span>
                        </div>

                        @if (isset($customer->orders) && $customer->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table orders-table align-middle mb-0 text-end">
                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>تاريخ الطلب</th>
                                            <th>إجمالي المبلغ</th>
                                            <th>حالة الطلب</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->orders as $order)
                                            <tr>
                                                <td class="fw-bold" style="color: #9333ea;">#{{ $order->id }}</td>
                                                <td class="text-muted">{{ $order->created_at?->format('Y-m-d') }}</td>
                                                <td class="ltr-value fw-bold text-dark">
                                                    {{ number_format($order->total_price ?? $order->total, 2) }} ₪
                                                </td>
                                                <td>
                                                    <span class="order-status-badge">
                                                        {{ $order->status ?? 'قيد المعالجة' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 rounded-4"
                                style="background: #fdf4ff; border: 1.5px dashed #f5d0fe;">
                                <div class="d-inline-flex p-3 rounded-circle mb-2"
                                    style="background: #ffffff; color: var(--rawnaq-primary);">
                                    <i class="bi bi-bag-x fs-2"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">لا توجد طلبات سابقة</h6>
                                <p class="text-muted small mb-0">لم يقم هذا الزبون بإتمام أي عملية شراء في متجر رونق حتى
                                    الآن.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
