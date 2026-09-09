@extends('parent')
@section('title', 'تعديل بيانات المشرف')
@section('main_title', 'إدارة المشرفين')
@section('sub_title', 'تعديل بيانات المشرف')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .admin-wrapper {
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
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .input-group-custom .input-group-text {
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 10px 10px 0;
            color: #64748b;
            padding: 0.6rem 0.85rem;
        }

        .input-group-custom .form-control,
        .input-group-custom .form-select {
            border: 1.5px solid #e2e8f0;
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
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
            outline: none;
        }

        .input-group-custom:focus-within .input-group-text {
            border-color: #3b82f6;
        }

        .field-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.35rem;
        }

        .form-footer {
            background-color: #ffffff;
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
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
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
    <div class="admin-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-12">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header px-4 py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-person-gear fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">تعديل بيانات المشرف #{{ $admin->id }}</h5>
                                    <small class="text-muted">تحديث بيانات الحساب والمعلومات الشخصية للمشرف</small>
                                </div>
                            </div>
                            <a href="{{ route('admins.index') }}" class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="edit_admin_form">
                            <div class="p-4">

                                <!-- Section 1: Basic Info -->
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-person-lines-fill"></i>
                                    <span>البيانات الشخصية</span>
                                </div>

                                <div class="row g-3 mb-4">
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="custom-label">
                                            اسم المشرف <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="مثال: أحمد محمد" value="{{ $admin->name }}" required>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="custom-label">
                                            البريد الإلكتروني <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="example@domain.com" value="{{ $admin->email }}" required>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label for="phone" class="custom-label">
                                            رقم الهاتف <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="phone" id="phone" class="form-control"
                                                placeholder="059xxxxxxx" value="{{ $admin->phone }}" required>
                                        </div>
                                    </div>

                                    <!-- Password (اختياري عند التعديل) -->
                                    <div class="col-md-6">
                                        <label for="password" class="custom-label">كلمة المرور الجديدة</label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="اترك الحقل فارغاً إذا لم ترغب في التغيير"
                                                autocomplete="new-password">
                                        </div>
                                        <div class="field-hint">يترك فارغاً في حال الرغبة بالاحتفاظ بكلمة المرور الحالية
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                <!-- Section 2: Account Settings & Location -->
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-sliders"></i>
                                    <span>إعدادات الحساب والموقع</span>
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
                                                <option value="" disabled>...اختر الجنس</option>
                                                <option value="male" @selected($admin->gender == 'male' || $admin->gender == 'ذكر')>ذكر</option>
                                                <option value="female" @selected($admin->gender == 'female' || $admin->gender == 'أنثى')>أنثى</option>
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
                                                <option value="" disabled>...اختر الحالة</option>
                                                <option value="active" @selected($admin->status == 'active' || $admin->status == 1)>نشط</option>
                                                <option value="inactive" @selected($admin->status == 'inactive' || $admin->status == 0)>غير نشط</option>
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
                                                <option value="" disabled>...اختر العنوان</option>
                                                @foreach ($address as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $admin->addresses_id)>
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
                                <a href="{{ route('admins.index') }}" class="btn-cancel-custom">إلغاء</a>
                                <button type="button" onclick="performUpdate({{ $admin->id }})"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2"></i>
                                    <span>حفظ التعديلات</span>
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
            let data = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                gender: document.getElementById('gender').value,
                status: document.getElementById('status').value,
                address_id: document.getElementById('address_id').value,
            };

            let passwordVal = document.getElementById('password').value;
            if (passwordVal.trim() !== '') {
                data.password = passwordVal;
            }

            update('/cms/admin/admins/' + id, data, '/cms/admin/admins');
        }
    </script>
@endsection
