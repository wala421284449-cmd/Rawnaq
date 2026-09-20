@extends('parent')

@section('title', 'تفاصيل المتجر | متجر رونق')
@section('main-title', 'إدارة المتاجر')
@section('sub-title', 'عرض كافة المعلومات والتفاصيل الخاصة بالمتجر')

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

        .info-group {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 16px;
            padding: 1.25rem;
            height: 100%;
            transition: all 0.25s ease;
        }

        .info-group:hover {
            background: #ffffff;
            border-color: #fbcfe8;
            box-shadow: 0 5px 15px rgba(190, 24, 93, 0.04);
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
    <div class="store-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-card border-0">
                        <!-- Header (تم تعديل التوزيع ليكون متناسقاً تماماً) -->
                        <div
                            class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light p-3 rounded-4 text-danger fs-3 shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-shop"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">{{ $store->name }}
                                    </h4>
                                    <span class="text-muted small">رابط المتجر: <span dir="ltr"
                                            class="fw-semibold text-dark">{{ $store->slug }}</span></span>
                                </div>
                            </div>
                            <a href="{{ route('stores.index') }}" class="btn-return-custom d-flex align-items-center gap-2">
                                <i class="bi bi-arrow-right"></i>
                                <span>العودة للقائمة</span>
                            </a>
                        </div>

                        <hr class="m-0 text-muted opacity-25">

                        <!-- Body Content -->
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Owner -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-person-badge text-danger"></i> مالك المتجر
                                        </div>
                                        <div class="info-value">{{ $store->user->name ?? 'غير محدد' }}</div>
                                        <small class="text-muted">{{ $store->user->email ?? '' }}</small>
                                    </div>
                                </div>

                                <!-- WhatsApp -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-whatsapp text-success"></i> رقم الواتساب
                                        </div>
                                        <div class="info-value" dir="ltr">{{ $store->whatsapp_number }}</div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-geo-alt text-danger"></i> العنوان والموقع
                                        </div>
                                        <div class="info-value">
                                            {{ $store->address->street ?? '' }} - {{ $store->address->city->name ?? '' }}
                                        </div>
                                        <small class="text-muted">المنطقة: {{ $store->address->area ?? '' }}</small>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-toggle2-on text-primary"></i> حالة المتجر
                                        </div>
                                        <div class="info-value mt-1">
                                            @if ($store->status === 'active')
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold">نشط
                                                    (مفعل)</span>
                                            @else
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold">غير
                                                    نشط (معطل)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-card-text text-secondary"></i> وصف ونبذة عن
                                            المتجر</div>
                                        <div class="info-value text-secondary fw-normal mt-2">
                                            {{ $store->description ?? 'لا يوجد وصف مضاف لهذا المتجر.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="card-footer bg-light p-4 d-flex justify-content-end gap-2 border-0">
                            <a href="{{ route('stores.edit', $store->id) }}" class="btn-edit-custom">
                                <i class="bi bi-pencil-square"></i>
                                <span>تعديل بيانات المتجر</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
