@extends('parent')

@section('title', 'تعديل بيانات المتجر | متجر رونق')
@section('main-title', 'إدارة المتاجر')
@section('sub-title', 'تعديل بيانات المتجر الحالي في منصة متجر رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #f1f5f9;
        }

        .store-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08), 0 0 15px 0 rgba(147, 51, 234, 0.03);
            overflow: hidden;
            position: relative;
        }

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

        .ltr-input {
            direction: ltr;
            text-align: right;
        }

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
            cursor: pointer;
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
    <div class="store-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تعديل بيانات المتجر
                                    </h5>
                                    <small class="text-muted">تحديث معلومات وتفاصيل المتجر: {{ $store->name }}</small>
                                </div>
                            </div>
                            <a href="{{ route('stores.index') }}" class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="update_store_form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="p-4">

                                <!-- Section 1: المعلومات الأساسية للمتجر -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <span>المعلومات الأساسية</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Store Name -->
                                        <div class="col-md-6">
                                            <label for="name" class="custom-label">
                                                <span>اسم المتجر</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-shop-window"></i></span>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="{{ old('name', $store->name) }}" required>
                                            </div>
                                        </div>

                                        <!-- Slug -->
                                        <div class="col-md-6">
                                            <label for="slug" class="custom-label">
                                                <span>الرابط المختصر (Slug)</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                                <input type="text" name="slug" id="slug"
                                                    class="form-control ltr-input" value="{{ old('slug', $store->slug) }}">
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12">
                                            <label for="description" class="custom-label">
                                                <span>وصف المتجر</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text align-items-start pt-2"><i
                                                        class="bi bi-card-text"></i></span>
                                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $store->description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: الوسائط والاتصال -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-images"></i>
                                        <span>الوسائط ورقم التواصل</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- WhatsApp Number -->
                                        <div class="col-md-12">
                                            <label for="whatsapp_number" class="custom-label">
                                                <span>رقم الواتساب الخاص بالمتجر</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                                <input type="tel" name="whatsapp_number" id="whatsapp_number"
                                                    class="form-control ltr-input"
                                                    value="{{ old('whatsapp_number', $store->whatsapp_number) }}" required>
                                            </div>
                                        </div>

                                        <!-- Logo File -->
                                        <div class="col-md-6">
                                            <label for="logo" class="custom-label">
                                                <span>شعار المتجر (Logo)</span>
                                                <span class="badge-opt">اتركه فارغاً إن لمغنِ التغيير</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i
                                                        class="bi bi-file-earmark-image"></i></span>
                                                <input type="file" name="logo" id="logo" class="form-control"
                                                    accept="image/*">
                                            </div>
                                            @if ($store->logo)
                                                <small class="text-muted d-mt-1">الصورة الحالية مسجلة</small>
                                            @endif
                                        </div>

                                        <!-- Cover Image File -->
                                        <div class="col-md-6">
                                            <label for="cover_image" class="custom-label">
                                                <span>صورة الغلاف (Cover Image)</span>
                                                <span class="badge-opt">اتركه فارغاً إن لمغنِ التغيير</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-image"></i></span>
                                                <input type="file" name="cover_image" id="cover_image"
                                                    class="form-control" accept="image/*">
                                            </div>
                                            @if ($store->cover_image)
                                                <small class="text-muted d-mt-1">الصورة الحالية مسجلة</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3: العلاقات (المالك، العنوان، والحالة) -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-diagram-3-fill"></i>
                                        <span>الارتباطات والحالة</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- User (Owner) ID -->
                                        <div class="col-md-4">
                                            <label for="user_id" class="custom-label">
                                                <span>مالك المتجر</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                                <select name="user_id" id="user_id" class="form-select" required>
                                                    <option value="" disabled>اختر المالك...</option>
                                                    @foreach ($users ?? [] as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id', $store->user_id) == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Address ID -->
                                        <div class="col-md-4">
                                            <label for="address_id" class="custom-label">
                                                <span>عنوان المتجر</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                                <select name="address_id" id="address_id" class="form-select" required>
                                                    <option value="" disabled>اختر العنوان...</option>
                                                    @foreach ($addresses ?? [] as $address)
                                                        <option value="{{ $address->id }}"
                                                            {{ old('address_id', $store->address_id) == $address->id ? 'selected' : '' }}>
                                                            {{ $address->street }} - {{ $address->city->name ?? '' }}
                                                            ({{ $address->area }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-4">
                                            <label for="status" class="custom-label">
                                                <span>حالة المتجر</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-toggle2-on"></i></span>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="active"
                                                        {{ old('status', $store->status) == 'active' ? 'selected' : '' }}>
                                                        نشط (مفعل)</option>
                                                    <option value="inactive"
                                                        {{ old('status', $store->status) == 'inactive' ? 'selected' : '' }}>
                                                        غير نشط (معطل)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('stores.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performUpdate({{ $store->id }})"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                    <span>تحديث بيانات المتجر</span>
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
            formData.append('_method', 'PUT'); // إعلام لارافيل بأن الطلب عبارة عن تحديث
            formData.append('name', document.getElementById('name').value);
            formData.append('slug', document.getElementById('slug').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('whatsapp_number', document.getElementById('whatsapp_number').value);

            // جلب ملف الشعار الجديد إذا تم اختياره
            let logoInput = document.getElementById('logo');
            if (logoInput.files[0]) {
                formData.append('logo', logoInput.files[0]);
            }

            // جلب ملف صورة الغلاف الجديدة إذا تم اختيارها
            let coverInput = document.getElementById('cover_image');
            if (coverInput.files[0]) {
                formData.append('cover_image', coverInput.files[0]);
            }

            formData.append('user_id', document.getElementById('user_id').value);
            formData.append('address_id', document.getElementById('address_id').value);
            formData.append('status', document.getElementById('status').value);

            axios.post('/cms/admin/stores/' + id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم التحديث بنجاح',
                        text: response.data.text || response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });

                    setTimeout(function() {
                        window.location.href = "{{ route('stores.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    let message = 'حدث خطأ أثناء تحديث بيانات المتجر';
                    if (error.response && error.response.data) {
                        message = error.response.data.text || error.response.data.message || message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في التحديث',
                        text: message
                    });
                });
        }
    </script>
@endsection
