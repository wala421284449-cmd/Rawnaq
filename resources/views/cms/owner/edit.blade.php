@extends('parent')
@section('title', 'تعديل بيانات المالك: ' . $owner->name . ' | متجر رونق')
@section('main-title', 'إدارة المالكين')
@section('sub-title', 'تعديل بيانات مالك / مورد متجر رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #f1f5f9;
        }

        .owner-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        /* كرت النموذج الفاخر */
        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08), 0 0 15px 0 rgba(147, 51, 234, 0.03);
            overflow: hidden;
            position: relative;
        }

        /* شريط علوي ملون يعكس هوية المتجر */
        .custom-form-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .form-header {
            border-bottom: 1px solid #f8fafc;
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            padding: 1.25rem 1.75rem;
        }

        .header-icon-box {
            width: 52px;
            height: 52px;
            background: var(--rawnaq-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.4rem;
            box-shadow: 0 8px 18px rgba(190, 24, 93, 0.28);
            transform: rotate(-3deg);
            transition: transform 0.3s ease;
        }

        .custom-form-card:hover .header-icon-box {
            transform: rotate(0deg) scale(1.05);
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: var(--rawnaq-primary);
            background: #ffffff;
            border: 1.5px solid #fbcfe8;
            border-radius: 50px;
            padding: 0.45rem 1.35rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(190, 24, 93, 0.06);
            transition: all 0.25s ease;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 6px 15px rgba(190, 24, 93, 0.25);
            transform: translateY(-2px);
        }

        /* حاويات الأقسام المنظمة */
        .section-box {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            transition: all 0.25s ease;
        }

        .section-box:hover {
            background: #ffffff;
            border-color: #fbcfe8;
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.04);
        }

        /* شارة عنوان القسم موحدة بلون رونق */
        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
            border: 1px solid #f5d0fe;
            color: var(--rawnaq-primary);
            font-size: 0.92rem;
            font-weight: 800;
            padding: 0.45rem 1.1rem;
            border-radius: 30px;
            margin-bottom: 1.25rem;
        }

        .custom-label {
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.45rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* شارات موحدة لمطلوب واختياري */
        .badge-req {
            background-color: #fdf2f8;
            color: var(--rawnaq-primary);
            border: 1px solid #fbcfe8;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
        }

        .badge-opt {
            background-color: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
        }

        .input-group-custom .input-group-text {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
            padding: 0.65rem 1rem;
            transition: all 0.25s ease;
        }

        .input-group-custom .form-control,
        .input-group-custom .form-select {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            padding: 0.65rem 1rem;
            font-size: 0.925rem;
            color: #1e293b;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        /* تفاعل الإدخال المضيء بلون رونق */
        .input-group-custom .form-control:focus,
        .input-group-custom .form-select:focus {
            border-color: #d946ef;
            box-shadow: 0 0 0 4px rgba(217, 70, 239, 0.15);
            outline: none;
        }

        .input-group-custom:focus-within .input-group-text {
            border-color: #d946ef;
            color: #be185d;
            background-color: #fdf4ff;
        }

        .field-hint {
            font-size: 0.78rem;
            color: #9333ea;
            margin-top: 0.35rem;
            font-weight: 600;
        }

        .ltr-input {
            direction: ltr;
            text-align: right;
        }

        /* تذييل النموذج */
        .form-footer {
            background: linear-gradient(to right, #ffffff, #fdf4ff);
            border-top: 1px solid #f1f5f9;
            padding: 1.25rem 2rem;
            border-radius: 0 0 24px 24px;
        }

        .btn-save-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.65rem 2rem;
            font-size: 0.95rem;
            font-weight: 800;
            color: #ffffff;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.35);
            transition: all 0.25s ease;
        }

        .btn-save-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(190, 24, 93, 0.45);
            color: #ffffff;
        }

        .btn-cancel-custom {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 1.6rem;
            font-size: 0.92rem;
            font-weight: 700;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-cancel-custom:hover {
            background-color: #f8fafc;
            color: #1e293b;
            border-color: #cbd5e1;
        }
    </style>
@endsection

@section('content')
    <div class="owner-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-person-gear"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تعديل بيانات المالك:
                                        {{ $owner->name }}</h5>
                                    <small class="text-muted">تحديث بيانات الحساب، معلومات التواصل، ومقر العمل في متجر
                                        رونق</small>
                                </div>
                            </div>
                            <a href="{{ route('owners.index') }}" class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="edit-owner-form">
                            @csrf
                            <div class="p-4">

                                <!-- Section 1: بيانات الحساب والاتصال -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-person-badge-fill"></i>
                                        <span>بيانات الحساب والاتصال</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Name Input -->
                                        <div class="col-md-6">
                                            <label for="name" class="custom-label">
                                                <span>الاسم الكامل</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="مثال: أحمد محمد" value="{{ $owner->name }}" required />
                                            </div>
                                        </div>

                                        <!-- Email Input -->
                                        <div class="col-md-6">
                                            <label for="email" class="custom-label">
                                                <span>البريد الإلكتروني</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                                                <input type="email" name="email" id="email"
                                                    class="form-control ltr-input" placeholder="owner@rawnaq.com"
                                                    value="{{ $owner->email }}" required />
                                            </div>
                                        </div>

                                        <!-- Password Input (Optional on Update) -->
                                        <div class="col-md-6">
                                            <label for="password" class="custom-label">
                                                <span>كلمة المرور الجديدة</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                                <input type="password" name="password" id="password"
                                                    class="form-control ltr-input"
                                                    placeholder="اتركها فارغة إن لم ترغب في التغيير"
                                                    autocomplete="new-password" />
                                            </div>
                                            <div class="field-hint">
                                                <i class="bi bi-info-circle ms-1"></i> اترك الحقل فارغاً في حال الرغبة
                                                بالاحتفاظ بكلمة المرور الحالية
                                            </div>
                                        </div>

                                        <!-- ID Number Input -->
                                        <div class="col-md-6">
                                            <label for="id_number" class="custom-label">
                                                <span>رقم الهوية الشخصية</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                                <input type="text" name="id_number" id="id_number"
                                                    class="form-control ltr-input" placeholder="40xxxxxxx"
                                                    value="{{ $owner->id_number ?? ($owner->actor?->id_number ?? '') }}"
                                                    required />
                                            </div>
                                        </div>

                                        <!-- Phone Input -->
                                        <div class="col-md-6">
                                            <label for="phone" class="custom-label">
                                                <span>رقم الهاتف</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                                <input type="tel" name="phone" id="phone"
                                                    class="form-control ltr-input" placeholder="059xxxxxxx"
                                                    value="{{ $owner->phone }}" required />
                                            </div>
                                        </div>

                                        <!-- WhatsApp Number Input -->
                                        <div class="col-md-6">
                                            <label for="whats_up_number" class="custom-label">
                                                <span>رقم الواتساب</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                                <input type="tel" name="whats_up_number" id="whats_up_number"
                                                    class="form-control ltr-input" placeholder="059xxxxxxx"
                                                    value="{{ $owner->whats_up_number ?? ($owner->actor?->whats_up_number ?? '') }}"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: التفاصيل الشخصية والعنوان -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span>التفاصيل الشخصية والعنوان</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Gender Select -->
                                        <div class="col-md-4">
                                            <label for="gender" class="custom-label">
                                                <span>الجنس</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i
                                                        class="bi bi-gender-ambiguous"></i></span>
                                                <select name="gender" id="gender" class="form-select" required>
                                                    <option value="" disabled>اختر الجنس...</option>
                                                    <option value="male" @selected($owner->gender == 'male' || $owner->gender == 'ذكر')>ذكر</option>
                                                    <option value="female" @selected($owner->gender == 'female' || $owner->gender == 'أنثى')>أنثى</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Status Select -->
                                        <div class="col-md-4">
                                            <label for="status" class="custom-label">
                                                <span>حالة الحساب</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-toggle2-on"></i></span>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="" disabled>اختر الحالة...</option>
                                                    <option value="active" @selected($owner->status == 'active' || $owner->status == 1)>نشط (مفعل)</option>
                                                    <option value="inactive" @selected($owner->status == 'inactive' || $owner->status == 0)>غير نشط (معطل)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Address Select -->
                                        <div class="col-md-4">
                                            <label for="address_id" class="custom-label">
                                                <span>العنوان المسجل</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                                <select name="address_id" id="address_id" class="form-select" required>
                                                    <option value="" disabled>اختر العنوان...</option>
                                                    @foreach ($address as $item)
                                                        <option value="{{ $item->id }}" @selected($item->id == ($owner->addresses_id ?? $owner->address_id))>
                                                            {{ $item->street }} - {{ $item->city->name ?? '' }}
                                                            ({{ $item->area }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('owners.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performUpdate({{ $owner->id }})"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle fs-5"></i>
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
                id_number: document.getElementById('id_number').value,
                whats_up_number: document.getElementById('whats_up_number').value,
                gender: document.getElementById('gender').value,
                status: document.getElementById('status').value,
                address_id: document.getElementById('address_id').value,
            };

            let passwordVal = document.getElementById('password').value;
            if (passwordVal && passwordVal.trim() !== '') {
                data.password = passwordVal;
            }

            axios.put('/cms/admin/owners/' + id, data)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم التعديل بنجاح',
                        text: response.data.text || response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });

                    // التوجيه الفوري لصفحة قائمة المالكين
                    setTimeout(function() {
                        window.location.href = "{{ route('owners.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    let message = 'حدث خطأ أثناء حفظ التعديلات';
                    if (error.response && error.response.data) {
                        message = error.response.data.text || error.response.data.message || message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في التعديل',
                        text: message
                    });
                });
        }
    </script>
@endsection
