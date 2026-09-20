@extends('parent')
@section('title', 'إضافة عنوان جديد | متجر رونق')
@section('main-title', 'إدارة العناوين')
@section('sub-title', 'إضافة عنوان جديد للنظام')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #f1f5f9;
        }

        .address-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        /* كرت النموذج الرئيسي */
        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08), 0 0 15px 0 rgba(147, 51, 234, 0.03);
            overflow: hidden;
            position: relative;
        }

        /* شريط علوي ملون ينبض بالحياة */
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

        /* حاويات الأقسام لتنظيم حيوي ومريح */
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

        /* تفاعل الإدخال الحيوي المضيء */
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
    <div class="address-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">إضافة عنوان جديد</h5>
                                    <small class="text-muted">أدخل تفاصيل المنطقة والشارع والموقع الجغرافي في نظام
                                        رونق</small>
                                </div>
                            </div>
                            <a href="{{ route('addresses.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="create_address_form">
                            @csrf
                            <div class="p-4">

                                <!-- Section 1: البيانات الأساسية -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <span>البيانات الأساسية للعنوان</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Area Name -->
                                        <div class="col-md-6">
                                            <label for="area" class="custom-label">
                                                <span>المنطقة / الحي (Area)</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                                <input type="text" name="area" id="area" class="form-control"
                                                    placeholder="مثال: حي الرمال" required>
                                            </div>
                                        </div>

                                        <!-- Street Name -->
                                        <div class="col-md-6">
                                            <label for="street" class="custom-label">
                                                <span>اسم الشارع (Street)</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-signpost-2"></i></span>
                                                <input type="text" name="street" id="street" class="form-control"
                                                    placeholder="مثال: شارع عمر المختار" required>
                                            </div>
                                        </div>

                                        <!-- Building Details -->
                                        <div class="col-md-6">
                                            <label for="building_details" class="custom-label">
                                                <span>تفاصيل المبنى / أقرب معلم</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                <input type="text" name="building_details" id="building_details"
                                                    class="form-control" placeholder="مثال: عمارة النور - الطابق الثالث">
                                            </div>
                                        </div>

                                        <!-- City Selection -->
                                        <div class="col-md-6">
                                            <label for="city_id" class="custom-label">
                                                <span>المدينة التابع لها</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                                <select name="city_id" id="city_id" class="form-select" required>
                                                    <option value="" disabled selected>اختر المدينة التابع لها
                                                        العنوان...</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: الإحداثيات الجغرافية -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-compass-fill"></i>
                                        <span>الإحداثيات الجغرافية</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Latitude -->
                                        <div class="col-md-6">
                                            <label for="latitude" class="custom-label">
                                                <span>خط العرض (Latitude)</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-compass"></i></span>
                                                <input type="text" name="latitude" id="latitude"
                                                    class="form-control ltr-input" placeholder="مثال: 31.5016">
                                            </div>
                                            <div class="field-hint">
                                                <i class="bi bi-info-circle ms-1"></i> قيمة عشرية جغرافية لخط العرض
                                            </div>
                                        </div>

                                        <!-- Longitude -->
                                        <div class="col-md-6">
                                            <label for="longitude" class="custom-label">
                                                <span>خط الطول (Longitude)</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-compass"></i></span>
                                                <input type="text" name="longitude" id="longitude"
                                                    class="form-control ltr-input" placeholder="مثال: 34.4668">
                                            </div>
                                            <div class="field-hint">
                                                <i class="bi bi-info-circle ms-1"></i> قيمة عشرية جغرافية لخط الطول
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('addresses.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performStore()"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                    <span>حفظ العنوان</span>
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
            formData.append('area', document.getElementById('area').value);
            formData.append('street', document.getElementById('street').value);
            formData.append('building_details', document.getElementById('building_details').value);
            formData.append('city_id', document.getElementById('city_id').value);
            formData.append('latitude', document.getElementById('latitude').value);
            formData.append('longitude', document.getElementById('longitude').value);

            axios.post('/cms/admin/addresses', formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم بنجاح',
                        text: response.data.text || response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });

                    // التوجيه الفوري والمضمون إلى صفحة قائمة العناوين الرئيسية
                    setTimeout(function() {
                        window.location.href = "{{ route('addresses.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    let message = 'حدث خطأ أثناء حفظ العنوان';
                    if (error.response && error.response.data) {
                        message = error.response.data.text || error.response.data.message || message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الحفظ',
                        text: message
                    });
                });
        }
    </script>
@endsection
