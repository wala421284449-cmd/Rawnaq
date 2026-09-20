@extends('parent')

@section('title', 'تفاصيل صورة المعرض | متجر رونق')
@section('main-title', 'إدارة معرض المتاجر')
@section('sub-title', 'عرض تفاصيل الصورة والبيانات المرتبطة بها في متجر رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .gallery-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08);
            overflow: hidden;
            position: relative;
        }

        .custom-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .preview-img-container {
            width: 100%;
            max-height: 400px;
            background: #fdf4ff;
            border: 2px dashed #fbcfe8;
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .preview-img-container img {
            max-width: 100%;
            max-height: 380px;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(190, 24, 93, 0.15);
        }

        .info-group {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 16px;
            padding: 1.25rem;
            height: 100%;
        }

        .info-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .info-value {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: var(--rawnaq-primary);
            background: #ffffff;
            border: 1.5px solid #fbcfe8;
            border-radius: 50px;
            padding: 0.5rem 1.4rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(190, 24, 93, 0.06);
            transition: all 0.25s ease;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .btn-edit-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.8rem;
            font-size: 0.95rem;
            font-weight: 800;
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(190, 24, 93, 0.3);
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-edit-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(190, 24, 93, 0.4);
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <div class="gallery-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-card border-0">
                        <!-- Header -->
                        <div
                            class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light p-3 rounded-4 text-danger fs-3 shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-image"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تفاصيل صورة المعرض
                                    </h4>
                                    <span class="text-muted small">رقم الصورة: <span
                                            class="fw-semibold text-dark">#{{ $mediaGallery->id }}</span></span>
                                </div>
                            </div>
                            <a href="{{ route('media-galleries.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <i class="bi bi-arrow-right"></i>
                                <span>العودة للقائمة</span>
                            </a>
                        </div>

                        <hr class="m-0 text-muted opacity-25">

                        <!-- Body Content -->
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Image Preview Box -->
                                <div class="col-12">
                                    <div class="preview-img-container">
                                        <img src="{{ asset($mediaGallery->file_path) }}" alt="Gallery Image Preview">
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-type text-danger"></i> عنوان / وصف الصورة
                                        </div>
                                        <div class="info-value">{{ $mediaGallery->title ?? 'لا يوجد عنوان مضاف' }}</div>
                                    </div>
                                </div>

                                <!-- Media Type -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-tag text-success"></i> نوع الوسائط</div>
                                        <div class="info-value">{{ $mediaGallery->media_type ?? 'gallery' }}</div>
                                    </div>
                                </div>

                                <!-- Store Info -->
                                <div class="col-md-12">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-shop text-primary"></i> المتجر التابع له
                                        </div>
                                        <div class="info-value mt-1">
                                            <a href="{{ route('stores.show', $mediaGallery->stores_id) }}"
                                                class="text-decoration-none text-dark fw-bold hover-primary">
                                                <i class="bi bi-link-45deg text-danger"></i>
                                                {{ $mediaGallery->store->name ?? 'غير محدد' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="card-footer bg-light p-4 d-flex justify-content-end gap-2 border-0">
                            <a href="{{ route('media-galleries.edit', $mediaGallery->id) }}" class="btn-edit-custom">
                                <i class="bi bi-pencil-square"></i>
                                <span>تعديل بيانات الصورة</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
