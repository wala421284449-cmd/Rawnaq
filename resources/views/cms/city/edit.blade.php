@extends('parent')
@section('title', 'تعديل مدينة')
@section('main_title', 'إدارة المدن')
@section('sub_title', 'تعديل بيانات المدينة')

@section('styles')
    <!-- تضمين خط Cairo وأيقونات Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .city-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 4px 10px -2px rgba(0, 0, 0, 0.02);
        }

        .form-header {
            border-bottom: 1px solid #f3f4f6;
        }

        .header-icon-box {
            width: 38px;
            height: 38px;
            background-color: #eff6ff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: #64748b;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 0.45rem 1.25rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .btn-return-custom:hover {
            background-color: #f1f5f9;
            color: #1e293b;
            border-color: #cbd5e1;
        }

        .custom-label {
            font-size: 0.885rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .custom-field {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 0.7rem 1rem;
            font-size: 0.925rem;
            color: #1e293b;
            background-color: #fcfdfe;
            transition: all 0.2s ease-in-out;
        }

        .custom-field:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .custom-field::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .form-footer {
            background-color: #fcfdfe;
            border-top: 1px solid #f1f5f9;
            border-radius: 0 0 20px 20px;
        }

        .btn-save-custom {
            background-color: #2563eb;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.75rem;
            font-size: 0.925rem;
            font-weight: 600;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
            transition: all 0.2s;
        }

        .btn-save-custom:hover {
            background-color: #1d4ed8;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
            transform: translateY(-1px);
        }

        .btn-cancel-custom {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-size: 0.925rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-cancel-custom:hover {
            background-color: #f8fafc;
            color: #334155;
            border-color: #cbd5e1;
        }
    </style>
@endsection

@section('content')
    <div class="city-wrapper py-5" dir="rtl">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">تعديل مدينة: {{ $cities->name }}</h5>
                                    <small class="text-muted">قم بتعديل البيانات التالية للمدينة</small>
                                </div>
                            </div>
                            <a href="{{ route('cities.index') }}" class="btn-return-custom">
                                العودة للقائمة
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="edit-city-form">
                            @csrf
                            <div class="p-4">
                                <!-- City Name -->
                                <div class="mb-4">
                                    <label for="name" class="custom-label d-flex align-items-center gap-2">
                                        <i class="bi bi-buildings text-primary"></i>
                                        <span>اسم المدينة <small class="text-muted fw-normal">(City Name)</small></span>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control custom-field"
                                        placeholder="أدخل اسم المدينة" value="{{ $cities->name }}" required />
                                </div>

                                <!-- City Slug -->
                                <div class="mb-4">
                                    <label for="slug" class="custom-label d-flex align-items-center gap-2">
                                        <i class="bi bi-link-45deg text-primary"></i>
                                        <span>الرابط اللطيف <small class="text-muted fw-normal">(Slug)</small></span>
                                    </label>
                                    <input type="text" name="slug" id="slug"
                                        class="form-control custom-field text-start" dir="ltr" placeholder="gaza-city"
                                        value="{{ $cities->slug }}" />
                                </div>

                                <!-- City is_active -->
                                <div class="mb-2">
                                    <label for="is_active" class="custom-label d-flex align-items-center gap-2">
                                        <i class="bi bi-toggle-on text-primary"></i>
                                        <span>حالة التفعيل <small class="text-muted fw-normal">(Active
                                                Status)</small></span>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="is_active" id="is_active" class="form-select custom-field" required>
                                        <option value="" disabled>-- اختر حالة المدينة --</option>
                                        <option value="active" {{ $cities->is_active === 'active' ? 'selected' : '' }}>
                                            مفعل (Active)
                                        </option>
                                        <option value="inactive" {{ $cities->is_active === 'inactive' ? 'selected' : '' }}>
                                            غير مفعل (Inactive)
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer px-4 py-3 d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('cities.index') }}" class="btn-cancel-custom">
                                    إلغاء
                                </a>
                                <button type="button" onclick="performUpdate({{ $cities->id }})"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check-lg fs-5"></i>
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
            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', document.getElementById('name').value);
            formData.append('slug', document.getElementById('slug').value);
            formData.append('is_active', document.getElementById('is_active').value);

            store('/cms/admin/cities/' + id, formData);
        }
    </script>
@endsection
