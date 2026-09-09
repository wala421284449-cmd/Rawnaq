@extends('parent')
@section('title', 'إضافة مالك جديد | متجر رونق')

@section('main-title', 'إدارة المالكين')
@section('sub-title', 'إضافة مالك / مورد جديد لمتجر رونق')

@section('styles')
    <style>
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            text-align: right;
            display: block;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-left: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .ltr-input {
            direction: ltr;
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <div class="app-content pt-4" dir="rtl">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="card card-custom" dir="rtl">

                        <!-- Header -->
                        <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-shop-window fs-5"></i>
                                </div>
                                <h5 class="card-title fw-bold m-0 text-dark">إضافة مالك جديد - متجر رونق</h5>
                            </div>
                            <a href="{{ route('owners.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                <i class="bi bi-arrow-right"></i>
                                <span>العودة للقائمة</span>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="create-owner-form" onsubmit="event.preventDefault(); performStore();">
                            @csrf

                            <div class="card-body p-4 text-end">

                                <!-- Section 1: Account Info -->
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-person-badge ms-1"></i> بيانات الحساب والاتصال
                                </h6>

                                <div class="row g-3 mb-4">
                                    <!-- Name Input -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="مثال: أحمد محمد" value="{{ old('name') }}" required />
                                        </div>
                                    </div>

                                    <!-- Email Input -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email" id="email" class="form-control ltr-input"
                                                placeholder="owner@rawnaq.com" value="{{ old('email') }}" required />
                                        </div>
                                    </div>

                                    <!-- Password Input -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" id="password" class="form-control ltr-input"
                                                placeholder="••••••••" autocomplete="new-password" required />
                                        </div>
                                    </div>

                                    <!-- ID Number Input -->
                                    <div class="col-md-6">
                                        <label for="id_number" class="form-label">رقم الهوية الشخصية <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                            <input type="text" name="id_number" id="id_number" class="form-control ltr-input"
                                                placeholder="40xxxxxxx" value="{{ old('id_number') }}" required />
                                        </div>
                                    </div>

                                    <!-- Phone Input -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" name="phone" id="phone" class="form-control ltr-input"
                                                placeholder="059xxxxxxx" value="{{ old('phone') }}" required />
                                        </div>
                                    </div>

                                    <!-- WhatsApp Number Input -->
                                    <div class="col-md-6">
                                        <label for="whats_up_number" class="form-label">رقم الواتساب <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                            <input type="tel" name="whats_up_number" id="whats_up_number"
                                                class="form-control ltr-input" placeholder="059xxxxxxx"
                                                value="{{ old('whats_up_number') }}" required />
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                <!-- Section 2: Personal Details & Address -->
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-sliders ms-1"></i> التفاصيل الشخصية والعنوان
                                </h6>

                                <div class="row g-3">
                                    <!-- Gender Select -->
                                    <div class="col-md-4">
                                        <label for="gender" class="form-label">الجنس <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                            <select name="gender" id="gender" class="form-select" required>
                                                <option value="" disabled selected>اختر الجنس...</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Status Select -->
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">حالة الحساب <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                            <select name="status" id="status" class="form-select" required>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Address Select -->
                                    <div class="col-md-4">
                                        <label for="address_id" class="form-label">العنوان المسجل <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <select name="address_id" id="address_id" class="form-select" required>
                                                <option value="" disabled selected>اختر العنوان...</option>
                                                @foreach ($address as $item)
                                                    <option value="{{ $item->id }}" {{ old('address_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->street }} - {{ $item->city->name ?? '' }} ({{ $item->area }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="card-footer bg-light px-4 py-3 d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('owners.index') }}" class="btn btn-light px-4 border">إلغاء</a>
                                <button type="button" onclick="performStore()" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bi bi-check-lg ms-1"></i> حفظ بيانات المالك
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
            formData.append('password', document.getElementById('password').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('gender', document.getElementById('gender').value);
            formData.append('status', document.getElementById('status').value);
            formData.append('address_id', document.getElementById('address_id').value);
            formData.append('id_number', document.getElementById('id_number').value);
            formData.append('whats_up_number', document.getElementById('whats_up_number').value);

            store('/cms/admin/owners', formData, '/cms/admin/owners');
        }
    </script>
@endsection
