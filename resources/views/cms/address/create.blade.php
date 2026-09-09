@extends('parent')
@section('title', 'إضافة عنوان جديد')
@section('main_title', 'إدارة العناوين')
@section('sub_title', 'إضافة عنوان جديد')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .address-wrapper {
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
    <div class="address-wrapper py-4" dir="rtl">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header px-4 py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-geo-alt-fill fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">إضافة عنوان جديد</h5>
                                    <span class="text-muted small">أدخل تفاصيل العنوان والموقع الجغرافي</span>
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

                                <!-- Section 1: Basic Info -->
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-info-circle"></i>
                                    <span>البيانات الأساسية</span>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Area Name -->
                                    <div class="col-md-6">
                                        <label for="area" class="custom-label">
                                            المنطقة / الحي (Area) <span class="text-danger">*</span>
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
                                            اسم الشارع (Street) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-signpost-2"></i></span>
                                            <input type="text" name="street" id="street" class="form-control"
                                                placeholder="مثال: شارع عمر المختار" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <!-- Building Details -->
                                    <div class="col-md-6">
                                        <label for="building_details" class="custom-label">
                                            تفاصيل المبنى / أقرب معلم (Building Details)
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
                                            المدينة التابع لها <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                            <select name="city_id" id="city_id" class="form-select" required>
                                                <option value="" disabled selected>...اختر المدينة التابع لها العنوان
                                                </option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                <!-- Section 2: Coordinates -->
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-geo"></i>
                                    <span>الإحداثيات الجغرافية (Coordinates - اختياري)</span>
                                </div>

                                <div class="row g-3">
                                    <!-- Latitude -->
                                    <div class="col-md-6">
                                        <label for="latitude" class="custom-label">
                                            خط العرض (Latitude)
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-compass"></i></span>
                                            <input type="text" name="latitude" id="latitude" class="form-control"
                                                placeholder="مثال: 31.5016">
                                        </div>
                                        <div class="field-hint">قيمة عشرية جغرافية تمثل خط العرض</div>
                                    </div>

                                    <!-- Longitude -->
                                    <div class="col-md-6">
                                        <label for="longitude" class="custom-label">
                                            خط الطول (Longitude)
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-compass"></i></span>
                                            <input type="text" name="longitude" id="longitude" class="form-control"
                                                placeholder="مثال: 34.4668">
                                        </div>
                                        <div class="field-hint">قيمة عشرية جغرافية تمثل خط الطول</div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer px-4 py-3 d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('addresses.index') }}" class="btn-cancel-custom">
                                    إلغاء
                                </a>
                                <button type="button" onclick="performStore()"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2"></i>
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
                        timer: 1500
                    });
                    window.location.href = '/cms/admin/addresses';
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.title || 'خطأ في المدخلات',
                        text: error.response.data.text || error.response.data.message
                    });
                });
        }
    </script>
@endsection
