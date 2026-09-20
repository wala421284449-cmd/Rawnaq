@extends('parent')

@section('title', 'إضافة صور لمعرض المتجر | متجر رونق')
@section('main-title', 'إدارة معرض المتاجر')
@section('sub-title', 'رفع وإضافة صور إضافية جديدة لمعرض المتجر ضمن منصة متجر رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
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
                                    <i class="bi bi-images"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">إضافة صور لمعرض المتجر
                                    </h5>
                                    <small class="text-muted">رفع صور إضافية متعددة لمعرض المتجر الخاص بمنصة رونق</small>
                                </div>
                            </div>
                            <a href="{{ route('media-galleries.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للمعرض</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="create_gallery_form" enctype="multipart/form-data">
                            @csrf
                            <div class="p-4">

                                <!-- Section 1: اختيار المتجر والبيانات -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-shop"></i>
                                        <span>اختيار المتجر ومعلومات الصور</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Store Selection -->
                                        <div class="col-md-12">
                                            <label for="stores_id" class="custom-label">
                                                <span>اختر المتجر</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-shop-window"></i></span>
                                                <select name="stores_id" id="stores_id" class="form-select" required>
                                                    <option value="" disabled selected>اختر المتجر التابع له الصور...
                                                    </option>
                                                    @foreach ($stores ?? [] as $store)
                                                        <option value="{{ $store->id }}"
                                                            {{ isset($selectedStoreId) && $selectedStoreId == $store->id ? 'selected' : '' }}>
                                                            {{ $store->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Title -->
                                        <div class="col-md-6">
                                            <label for="title" class="custom-label">
                                                <span>عنوان أو وصف الصورة</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-type"></i></span>
                                                <input type="text" name="title" id="title" class="form-control"
                                                    placeholder="مثال: الواجهة الداخلية للمتجر">
                                            </div>
                                        </div>

                                        <!-- Media Type -->
                                        <div class="col-md-6">
                                            <label for="media_type" class="custom-label">
                                                <span>نوع الوسائط</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                                <input type="text" name="media_type" id="media_type" class="form-control"
                                                    placeholder="gallery" value="gallery">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: رفع الصور المتعددة -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span>ملفات الصور</span>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="images" class="custom-label">
                                                <span>اختر صور المعرض (يمكنك اختيار أكثر من صورة دفعة واحدة)</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-images"></i></span>
                                                <input type="file" name="images[]" id="images" class="form-control"
                                                    accept="image/*" multiple required>
                                            </div>
                                            <small class="text-muted mt-1 d-block">اضغط على زر (Ctrl) أثناء اختيار الصور
                                                لتحديد عدة صور معاً.</small>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('media-galleries.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performStoreGallery()"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                    <span>رفع وحفظ الصور</span>
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
        function performStoreGallery() {
            let formData = new FormData();
            formData.append('stores_id', document.getElementById('stores_id').value);
            formData.append('title', document.getElementById('title').value);
            formData.append('media_type', document.getElementById('media_type').value);

            // جلب مجموعة الصور المحددة ورفعها كـ Array
            let imagesInput = document.getElementById('images');
            for (let i = 0; i < imagesInput.files.length; i++) {
                formData.append('images[]', imagesInput.files[i]);
            }

            axios.post('/cms/admin/media-galleries', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم بنجاح',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });

                    setTimeout(function() {
                        window.location.href = "{{ route('media-galleries.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    let message = 'حدث خطأ أثناء رفع صور المعرض';
                    if (error.response && error.response.data) {
                        message = error.response.data.message || message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الرفع',
                        text: message
                    });
                });
        }
    </script>
@endsection
