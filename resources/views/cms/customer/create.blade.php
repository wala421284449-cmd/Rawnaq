@extends('cms.parent')
@section('title', 'إضافة زبون جديد')
@section('main_title', 'إدارة الزبائن')
@section('sub_title', 'إضافة زبون')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .customer-wrapper {
        font-family: 'Cairo', system-ui, -apple-system, sans-serif;
    }

    .custom-form-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.03);
    }

    .form-header {
        border-bottom: 1px solid #f8fafc;
    }

    .header-icon-box {
        width: 46px;
        height: 46px;
        background-color: #eff6ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
    }

    .btn-return-custom {
        font-size: 0.85rem;
        color: #475569;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.45rem 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-return-custom:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    .section-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1d4ed8;
    }

    .custom-label {
        font-size: 0.825rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.35rem;
    }

    .input-group-custom .input-group-text {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: none;
        border-radius: 0 10px 10px 0;
        color: #64748b;
        padding: 0.6rem 0.85rem;
    }

    .input-group-custom .form-control,
    .input-group-custom .form-select {
        border: 1px solid #e2e8f0;
        border-right: none;
        border-radius: 10px 0 0 10px;
        padding: 0.6rem 0.85rem;
        font-size: 0.9rem;
        color: #1e293b;
        background-color: #ffffff;
    }

    .input-group-custom .form-control:focus,
    .input-group-custom .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .input-group-custom .form-control:focus + .input-group-text,
    .input-group-custom:focus-within .input-group-text {
        border-color: #3b82f6;
    }

    .form-footer {
        background-color: #f8fafc;
        border-top: 1px solid #f1f5f9;
        border-radius: 0 0 16px 16px;
    }

    .btn-save-custom {
        background-color: #1d68f0;
        border: none;
        border-radius: 8px;
        padding: 0.55rem 1.6rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff;
        transition: all 0.2s;
    }

    .btn-save-custom:hover {
        background-color: #1754c7;
    }

    .btn-cancel-custom {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.55rem 1.4rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cancel-custom:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }
</style>
@endsection

@section('content')
<div class="customer-wrapper py-4" dir="rtl">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">

                <div class="card custom-form-card border-0">
                    <!-- Header -->
                    <div class="form-header px-4 py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon-box">
                                <i class="bi bi-person-plus-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">إضافة زبون جديد</h5>
                                <small class="text-muted">أدخل البيانات الشخصية ومعلومات الاتصال للزبون</small>
                            </div>
                        </div>
                        <a href="{{ route('customers.index') }}" class="btn-return-custom d-flex align-items-center gap-2">
                            <span>العودة للقائمة</span>
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>

                    <!-- Form -->
                    <form id="create_customer_form">
                        <div class="p-4">

                            <!-- Section 1: Personal & Identity Info -->
                            <div class="section-title mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-person-badge"></i>
                                <span>البيانات الشخصية والهوية</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="name" class="custom-label">
                                        اسم الزبون <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="مثال: أحمد محمد" required>
                                    </div>
                                </div>

                                <!-- ID Number -->
                                <div class="col-md-6">
                                    <label for="id_number" class="custom-label">
                                        رقم الهوية <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                        <input type="text" name="id_number" id="id_number" class="form-control" placeholder="مثال: 401xxxxxx" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="custom-label">
                                        البريد الإلكتروني <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="example@domain.com" required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <label for="password" class="custom-label">
                                        كلمة المرور <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <!-- Section 2: Contact Info -->
                            <div class="section-title mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-telephone-inbound"></i>
                                <span>معلومات التواصل والاتصال</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label for="phone" class="custom-label">
                                        رقم الهاتف <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="059xxxxxxx" required>
                                    </div>
                                </div>

                                <!-- WhatsApp Number -->
                                <div class="col-md-6">
                                    <label for="whats_up_number" class="custom-label">
                                        رقم الواتساب <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-whatsapp text-success"></i></span>
                                        <input type="text" name="whats_up_number" id="whats_up_number" class="form-control" placeholder="059xxxxxxx" required>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <!-- Section 3: Account Settings & Location -->
                            <div class="section-title mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-sliders"></i>
                                <span>بيانات العنوان والحساب</span>
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
                                            <option value="" disabled selected>...اختر الجنس</option>
                                            <option value="male">ذكر</option>
                                            <option value="female">أنثى</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-4">
                                    <label for="status" class="custom-label">
                                        الحالة <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="" disabled selected>...اختر الحالة</option>
                                            <option value="active">نشط</option>
                                            <option value="inactive">غير نشط</option>
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
                                            <option value="" disabled selected>...اختر العنوان</option>
                                            @foreach ($address as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->street }} - {{ $item->city->name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Actions -->
                        <div class="form-footer px-4 py-3 d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('customers.index') }}" class="btn-cancel-custom">
                                إلغاء
                            </a>
                            <button type="button" onclick="performStore()" class="btn-save-custom d-flex align-items-center gap-2">
                                <i class="bi bi-check2"></i>
                                <span>حفظ الزبون</span>
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
    function performStore() {
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('id_number', document.getElementById('id_number').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('whats_up_number', document.getElementById('whats_up_number').value);
        formData.append('password', document.getElementById('password').value);
        formData.append('gender', document.getElementById('gender').value);
        formData.append('status', document.getElementById('status').value);
        formData.append('address_id', document.getElementById('address_id').value);

        // إرسال طلب التخزين
        store('/cms/admin/customers', formData);
    }
</script>
@endsection