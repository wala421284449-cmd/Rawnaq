@extends('parent')

@section('title', 'تفاصيل المالك | متجر رونق')
@section('main-title', 'إدارة المالكين')
@section('sub-title', 'عرض الملف الشخصي وبيانات المنتجات التابعة للمالك')

@section('styles')
    <style>
        .profile-card,
        .info-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background-color: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
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
    <div class="app-content pt-4" dir="rtl">
        <div class="container-fluid">

            <!-- Top Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">ملف المالك: {{ $owner->name }}</h4>
                    <p class="text-muted small mb-0">عرض كافة البيانات الشخصية وجهات الاتصال والمنتجات المسجلة باسمه في متجر
                        رونق</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('owners.edit', $owner->id) }}"
                        class="btn btn-primary btn-sm px-3 rounded-pill d-inline-flex align-items-center gap-1">
                        <i class="bi bi-pencil-square"></i>
                        <span>تعديل البيانات</span>
                    </a>
                    <a href="{{ route('owners.index') }}"
                        class="btn btn-outline-secondary btn-sm px-3 rounded-pill d-inline-flex align-items-center gap-1">
                        <i class="bi bi-arrow-right"></i>
                        <span>العودة للقائمة</span>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column: Owner Profile Overview -->
                <div class="col-lg-4 col-md-5">
                    <div class="card profile-card p-4 text-center">
                        <div
                            class="avatar-circle-lg mb-3 {{ $owner->gender == 'female' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">
                            <i class="bi {{ $owner->gender == 'female' ? 'bi-person-female' : 'bi-person' }}"></i>
                        </div>

                        <h5 class="fw-bold text-dark mb-1">{{ $owner->name }}</h5>
                        <p class="text-muted small mb-3 ltr-value">{{ $owner->email }}</p>

                        <div class="mb-3">
                            @if ($owner->status == 'active' || $owner->status == 1)
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
                            <span class="text-muted">الصفة / الدور:</span>
                            <span class="fw-bold text-primary">مالك ومورد منتجات</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">تاريخ التسجيل:</span>
                            <span class="fw-semibold text-dark">{{ $owner->created_at?->format('Y-m-d') ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">عدد المنتجات:</span>
                            <span class="fw-bold text-success">{{ $owner->products?->count() ?? 0 }} منتج</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details & Products -->
                <div class="col-lg-8 col-md-7">

                    <!-- Contact & Legal Info -->
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
                                            {{ $owner->id_number ?? ($owner->actor?->id_number ?? 'غير مسجل') }}
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
                                            {{ $owner->whats_up_number ?? ($owner->actor?->whats_up_number ?? 'غير مسجل') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                    <div class="item-icon"><i class="bi bi-telephone"></i></div>
                                    <div>
                                        <div class="field-label">رقم الهاتف الأساسي</div>
                                        <div class="field-value ltr-value">{{ $owner->phone ?? 'غير مسجل' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                                    <div class="item-icon"><i class="bi bi-gender-ambiguous"></i></div>
                                    <div>
                                        <div class="field-label">الجنس</div>
                                        <div class="field-value">
                                            {{ $owner->gender == 'male' ? 'ذكر' : ($owner->gender == 'female' ? 'أنثى' : 'غير محدد') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="card info-card p-4 mb-4 text-end">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-geo-alt ms-1"></i> العنوان المسجل
                        </h6>

                        @if ($owner->address)
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">المدينة</div>
                                        <div class="field-value">{{ $owner->address->city?->name ?? 'غير محددة' }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">المنطقة / الحي</div>
                                        <div class="field-value">{{ $owner->address->area }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">اسم الشارع</div>
                                        <div class="field-value">{{ $owner->address->street }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="field-label">تفاصيل المبنى / أقرب معلم</div>
                                        <div class="field-value">{{ $owner->address->building_details ?? 'لا يوجد' }}</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3 bg-light rounded-3 text-muted small">
                                لا يوجد عنوان مسجل لهذا المالك.
                            </div>
                        @endif
                    </div>

                    <!-- Products Owned by this Owner -->
                    <div class="card info-card p-4 text-end">
                        <h6 class="fw-bold text-primary mb-3 d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-box-seam ms-1"></i> المنتجات المسجلة باسم المالك</span>
                            <span class="badge bg-primary rounded-pill">{{ $owner->products?->count() ?? 0 }}</span>
                        </h6>

                        @if (isset($owner->products) && $owner->products->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0 text-end">
                                    <thead class="table-light">
                                        <tr>
                                            <th>اسم المنتج</th>
                                            <th>الكمية المتوفرة</th>
                                            <th>السعر</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($owner->products as $product)
                                            <tr>
                                                <td class="fw-semibold">{{ $product->name }}</td>
                                                <td>{{ $product->quantity ?? ($product->stock ?? 0) }} قطعة</td>
                                                <td class="ltr-value">
                                                    {{ $product->price ? number_format($product->price, 2) . ' ₪' : '-' }}
                                                </td>
                                                <td>
                                                    @if ($product->status == 'active' || $product->status == 1)
                                                        <span class="badge bg-success-subtle text-success">متوفر</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary">غير
                                                            متوفر</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 bg-light rounded-3 text-muted">
                                <i class="bi bi-box-arrow-in-down fs-2 d-block mb-1 text-secondary opacity-50"></i>
                                <span>لا توجد منتجات مسجلة باسم هذا المالك في متجر رونق حتى الآن.</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
