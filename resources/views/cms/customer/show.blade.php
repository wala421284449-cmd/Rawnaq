@extends('parent')

@section('title', 'تفاصيل الزبون | متجر رونق')
@section('main-title', 'إدارة الزبائن')
@section('sub-title', 'عرض الملف الشخصي وسجل طلبات الزبون')

@section('styles')
    <style>
        .profile-card,
        .info-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.04);
            background: #ffffff;
        }

        .avatar-circle-lg {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto;
        }

        .item-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background-color: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .field-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
        }

        .field-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
        }

        .ltr-value {
            direction: ltr;
            display: inline-block;
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <div class="app-content py-4" dir="rtl">
        <div class="container-fluid">

            <!-- Top Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">ملف الزبون: {{ $customer->name }}</h4>
                    <p class="text-muted small mb-0">عرض كافة البيانات الشخصية وجهات الاتصال والطلبات السابقة في متجر رونق
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.edit', $customer->id) }}"
                        class="btn btn-primary btn-sm px-3 rounded-pill d-inline-flex align-items-center gap-1">
                        <i class="bi bi-pencil-square"></i>
                        <span>تعديل البيانات</span>
                    </a>
                    <a href="{{ route('customers.index') }}"
                        class="btn btn-outline-secondary btn-sm px-3 rounded-pill d-inline-flex align-items-center gap-1">
                        <i class="bi bi-arrow-right"></i>
                        <span>العودة للقائمة</span>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column: Customer Profile Overview -->
                <div class="col-lg-4 col-md-5">
                    <div class="card profile-card p-4 text-center">
                        <div
                            class="avatar-circle-lg mb-3 {{ $customer->gender == 'female' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">
                            <i class="bi {{ $customer->gender == 'female' ? 'bi-person-female' : 'bi-person' }}"></i>
                        </div>

                        <h5 class="fw-bold text-dark mb-1">{{ $customer->name }}</h5>
                        <p class="text-muted small mb-3 ltr-value">{{ $customer->email }}</p>

                        <div class="mb-3">
                            @if ($customer->status == 'active' || $customer->status == 1)
                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                    <i class="bi bi-check-circle-fill ms-1"></i>حساب نشط
                                </span>
                            @else
                                <span
                                    class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1">
                                    <i class="bi bi-x-circle-fill ms-1"></i>حساب غير نشط
                                </span>
                            @endif
                        </div>

                        <hr class="opacity-25 my-3">

                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">نوع الحساب:</span>
                            <span class="fw-bold text-primary">زبون / عميل متجر</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">تاريخ الانضمام:</span>
                            <span class="fw-semibold text-dark">{{ $customer->created_at?->format('Y-m-d') ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">إجمالي الطلبات:</span>
                            <span class="fw-bold text-success">{{ $customer->orders?->count() ?? 0 }} طلب</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details & Orders -->
                <div class="col-lg-8 col-md-7">

                    <!-- Contact & Identity Info -->
                    <div class="card info-card p-4 mb-4 text-end">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-card-checklist ms-1"></i> بيانات الهوية والاتصال
                        </h6>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
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
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                    <div class="item-icon"><i class="bi bi-whatsapp"></i></div>
                                    <div>
                                        <div class="field-label">رقم الواتساب</div>
                                        <div class="field-value text-success ltr-value">
                                            {{ $customer->whats_up_number ?? ($customer->actor?->whats_up_number ?? 'غير مسجل') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                    <div class="item-icon"><i class="bi bi-telephone"></i></div>
                                    <div>
                                        <div class="field-label">رقم الهاتف الأساسي</div>
                                        <div class="field-value ltr-value">{{ $customer->phone ?? 'غير مسجل' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                    <div class="item-icon"><i class="bi bi-gender-ambiguous"></i></div>
                                    <div>
                                        <div class="field-label">الجنس</div>
                                        <div class="field-value">
                                            {{ $customer->gender == 'male' || $customer->gender == 'ذكر' ? 'ذكر' : 'أنثى' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="card info-card p-4 mb-4 text-end">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-geo-alt ms-1"></i> عنوان التوصيل المسجل
                        </h6>

                        @if ($customer->address)
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">المدينة</div>
                                        <div class="field-value">{{ $customer->address->city?->name ?? 'غير محددة' }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">المنطقة / الحي</div>
                                        <div class="field-value">{{ $customer->address->area }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">اسم الشارع</div>
                                        <div class="field-value">{{ $customer->address->street }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">تفاصيل إضافية / أقرب معلم</div>
                                        <div class="field-value">{{ $customer->address->building_details ?? 'لا يوجد' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3 bg-light rounded-3 text-muted small">
                                لا يوجد عنوان توصيل مسجل لهذا الزبون.
                            </div>
                        @endif
                    </div>

                    <!-- Orders Placed by this Customer -->
                    <div class="card info-card p-4 text-end">
                        <h6 class="fw-bold text-primary mb-3 d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-bag-check ms-1"></i> طلبات ومشتريات الزبون</span>
                            <span class="badge bg-primary rounded-pill">{{ $customer->orders?->count() ?? 0 }}</span>
                        </h6>

                        @if (isset($customer->orders) && $customer->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0 text-end">
                                    <thead class="table-light">
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
                                                <td class="fw-semibold">#{{ $order->id }}</td>
                                                <td>{{ $order->created_at?->format('Y-m-d') }}</td>
                                                <td class="ltr-value">
                                                    {{ number_format($order->total_price ?? $order->total, 2) }} ₪</td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $order->status ?? 'قيد المعالجة' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 bg-light rounded-3 text-muted">
                                <i class="bi bi-bag-x fs-2 d-block mb-1 text-secondary opacity-50"></i>
                                <span>لا توجد طلبات مسجلة لهذا الزبون في متجر رونق حتى الآن.</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
