@extends('parent')
@section('title', 'تعديل عنوان')
@section('main_title', 'إدارة العناوين')
@section('sub_title', 'تعديل بيانات العنوان')

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
    <div class="address-wrapper py-3" dir="rtl">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">

                    <div class="card custom-form-card border-0">
                        <div class="form-header px-4 py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-geo-alt-fill fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">تعديل العنوان #{{ $address->id }}</h5>
                                    <small class="text-muted">تعديل تفاصيل العنوان والموقع الجغرافي</small>
                                </div>
                            </div>
                            <a href="{{ route('addresses.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <form id="edit_address_form">
                            <div class="p-4">
                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-info-circle"></i>
                                    <span>البيانات الأساسية</span>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="area" class="custom-label">
                                            المنطقة / الحي (Area) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                            <input type="text" name="area" id="area" class="form-control"
                                                placeholder="مثال: حي الرمال" value="{{ $address->area }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="street" class="custom-label">
                                            اسم الشارع (Street) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-signpost-2"></i></span>
                                            <input type="text" name="street" id="street" class="form-control"
                                                placeholder="مثال: شارع عمر المختار" value="{{ $address->street }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="building_details" class="custom-label">تفاصيل المبنى / أقرب معلم</label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" name="building_details" id="building_details"
                                                class="form-control" placeholder="مثال: عمارة القصاص"
                                                value="{{ $address->building_details }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="city_id" class="custom-label">
                                            المدينة التابع لها <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                            <select name="city_id" id="city_id" class="form-select" required>
                                                <option value="" disabled>...اختر المدينة التابع لها العنوان</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ $city->id == $address->city_id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                <div class="section-title mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-geo"></i>
                                    <span>الإحداثيات الجغرافية (اختياري)</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="latitude" class="custom-label">خط العرض (Latitude)</label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-compass"></i></span>
                                            <input type="text" name="latitude" id="latitude" class="form-control"
                                                placeholder="مثال: 31.25" value="{{ $address->latitude }}">
                                        </div>
                                        <div class="field-hint">قيمة عشرية محصورة بين -90 و 90</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="longitude" class="custom-label">خط الطول (Longitude)</label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text"><i class="bi bi-compass"></i></span>
                                            <input type="text" name="longitude" id="longitude" class="form-control"
                                                placeholder="مثال: 35.2" value="{{ $address->longitude }}">
                                        </div>
                                        <div class="field-hint">قيمة عشرية محصورة بين -180 و 180</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-footer px-4 py-3 d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('addresses.index') }}" class="btn-cancel-custom">إلغاء</a>
                                <button type="button" onclick="performUpdate({{ $address->id }})"
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
                area: document.getElementById('area').value,
                street: document.getElementById('street').value,
                building_details: document.getElementById('building_details').value,
                city_id: document.getElementById('city_id').value,
                latitude: document.getElementById('latitude').value,
                longitude: document.getElementById('longitude').value,
            };

            update('/cms/admin/addresses/' + id, data, '/cms/admin/addresses');
        }
    </script>
@endsection
