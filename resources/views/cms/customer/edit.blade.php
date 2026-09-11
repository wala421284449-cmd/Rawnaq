@extends('parent')
@section('title', 'تعديل بيانات الزبون | متجر رونق')

@section('main-title', 'إدارة الزبائن')
@section('sub-title', 'تعديل بيانات حساب الزبون في متجر رونق')

@section('styles')
    <style>
        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.04);
        }

        .form-header {
            border-bottom: 1px solid #f8fafc;
        }

        .header-icon-box {
            width: 44px;
            height: 44px;
            background-color: #eff6ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1d4ed8;
        }

        .custom-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
            display: block;
            text-align: right;
        }

        .input-group-custom .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: none;
            border-radius: 0 10px 10px 0;
            color: #64748b;
        }

        .input-group-custom .form-control,
        .input-group-custom .form-select {
            border: 1px solid #e2e8f0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            padding: 0.6rem 0.85rem;
            font-size: 0.9rem;
            color: #1e293b;
        }

        .input-group-custom .form-control:focus,
        .input-group-custom .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .ltr-input {
            direction: ltr;
            text-align: right;
        }

        .field-hint {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.25rem;
            text-align: right;
        }

        .form-footer {
            background-color: #f8fafc;
            border-top: 1px solid #f1f5f9;
            border-radius: 0 0 16px 16px;
        }
    </style>
@endsection

@section('content')
    <div class="app-content py-4" dir="rtl">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">

                    <div class="card custom-form-card border-0" dir="rtl">
                        <!-- Header -->
                        <div class="form-header px-4 py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon-box">
                                    <i class="bi bi-person-gear fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">تعديل بيانات الزبون: {{ $customers->name }}</h5>
                                    <small class="text-muted">تحديث المعلومات الشخصية وبيانات الاتصال والتوصيل</small>
                                </div>
                            </div>
                            <a href="{{ route('customers.index') }}"
                                class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                <i class="bi bi-arrow-right"></i>
                                <span>العودة للقائمة</span>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="edit_customer_form">
                            @csrf

                            <div class="p-4 text-end">

                                <!-- Section 1: Basic & Identity Info -->
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-person-badge"></i>
                                    <span>البيانات الشخصية والحساب</span>
                                </div>

                                <div class="row g-3 mb-4">
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="custom-label">
                                            اسم الزبون الكامل <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ $customers->name }}" placeholder="مثال: أحمد محمد" required>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="custom-label">
                                            البريد الإلكتروني <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email" id="email"
                                                class="form-control ltr-input" value="{{ $customers->email }}"
                                                placeholder="customer@rawnaq.com" required>
                                        </div>
                                    </div>

                                    <!-- Password (Optional) -->
                                    <div class="col-md-6">
                                        <label for="password" class="custom-label">
                                            كلمة المرور الجديدة
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" id="password"
                                                class="form-control ltr-input"
                                                placeholder="اتركها فارغة إذا كنت لا ترغب بالتعديل"
                                                autocomplete="new-password">
                                        </div>
                                        <div class="field-hint">يترك الحقل فارغاً في حال الرغبة بالاحتفاظ بكلمة المرور
                                            الحالية</div>
                                    </div>

                                    <!-- ID Number -->
                                    <div class="col-md-6">
                                        <label for="id_number" class="custom-label">
                                            رقم الهوية الشخصية
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                            <input type="text" name="id_number" id="id_number"
                                                class="form-control ltr-input"
                                                value="{{ $customers->id_number ?? ($customers->actor?->id_number ?? '') }}"
                                                placeholder="مثال: 401xxxxxx">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                <!-- Section 2: Contact Info -->
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-telephone-inbound"></i>
                                    <span>بيانات الاتصال والتواصل</span>
                                </div>

                                <div class="row g-3 mb-4">
                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label for="phone" class="custom-label">
                                            رقم الهاتف الأساسي <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" name="phone" id="phone"
                                                class="form-control ltr-input" value="{{ $customers->phone }}"
                                                placeholder="059xxxxxxx" required>
                                        </div>
                                    </div>

                                    <!-- WhatsApp Number -->
                                    <div class="col-md-6">
                                        <label for="whats_up_number" class="custom-label">
                                            رقم الواتساب <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i
                                                    class="bi bi-whatsapp text-success"></i></span>
                                            <input type="tel" name="whats_up_number" id="whats_up_number"
                                                class="form-control ltr-input"
                                                value="{{ $customers->whats_up_number ?? ($customers->actor?->whats_up_number ?? '') }}"
                                                placeholder="059xxxxxxx" required>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                <!-- Section 3: Details & Address -->
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>التفاصيل الشخصية وعنوان التوصيل</span>
                                </div>

                                <div class="row g-3">
                                    <!-- Gender -->
                                    <div class="col-md-4">
                                        <label for="gender" class="custom-label">
                                            الجنس <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                            <select name="gender" id="gender" class="form-select" required>
                                                <option value="" disabled>اختر الجنس...</option>
                                                <option value="male" @selected($customers->gender == 'male' || $customers->gender == 'ذكر')>ذكر</option>
                                                <option value="female" @selected($customers->gender == 'female' || $customers->gender == 'أنثى')>أنثى</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-4">
                                        <label for="status" class="custom-label">
                                            حالة الحساب <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                            <select name="status" id="status" class="form-select" required>
                                                <option value="" disabled>اختر الحالة...</option>
                                                <option value="active" @selected($customers->status == 'active' || $customers->status == 1)>نشط</option>
                                                <option value="inactive" @selected($customers->status == 'inactive' || $customers->status == 0)>غير نشط</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-4">
                                        <label for="address_id" class="custom-label">
                                            العنوان المسجل <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <select name="address_id" id="address_id" class="form-select" required>
                                                <option value="" disabled>اختر العنوان...</option>
                                                @foreach ($address as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == ($customers->addresses_id ?? $customers->address_id))>
                                                        {{ $item->street }} - {{ $item->city->name ?? '' }}
                                                        ({{ $item->area }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer px-4 py-3 d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('customers.index') }}" class="btn btn-light px-4 border">
                                    إلغاء
                                </a>
                                <button type="button" onclick="performUpdate({{ $customers->id }})"
                                    class="btn btn-primary px-4 shadow-sm">
                                    <i class="bi bi-check-lg ms-1"></i> حفظ التعديلات
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function performUpdate(id) {
            let formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('id_number', document.getElementById('id_number').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('whats_up_number', document.getElementById('whats_up_number').value);
            formData.append('gender', document.getElementById('gender').value);
            formData.append('status', document.getElementById('status').value);
            formData.append('address_id', document.getElementById('address_id').value);

            let passwordVal = document.getElementById('password').value;
            if (passwordVal && passwordVal.trim() !== '') {
                formData.append('password', passwordVal);
            }

            // استخدام دالة store مع مسار الـ POST المخصص والتوجيه لصفحة الزبائن
            store('/cms/admin/customers_update/' + id, formData, '/cms/admin/customers');
        }
    </script>
@endsection
