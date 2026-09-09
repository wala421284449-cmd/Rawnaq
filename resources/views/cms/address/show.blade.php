@extends('parent')
@section('title', 'تفاصيل العنوان: ' . $address->area)
@section('main_title', 'إدارة العناوين')
@section('sub_title', 'عرض تفاصيل العنوان')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .address-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .detail-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .detail-row {
            padding: 1.1rem 0;
            border-bottom: 1px solid #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value {
            font-weight: 600;
            color: #1e293b;
        }

        .coord-badge {
            background: #f1f5f9;
            color: #334155;
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('content')
    <div class="address-wrapper py-4" dir="rtl">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <div class="card detail-card border-0">

                        <!-- Header -->
                        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    style="width: 44px; height: 44px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">تفاصيل العنوان #{{ $address->id }}</h5>
                                    <small class="text-muted">البيانات الكاملة والإحداثيات الجغرافية</small>
                                </div>
                            </div>
                            <a href="{{ route('addresses.index') }}" class="btn btn-light rounded-pill px-3 border">
                                <i class="bi bi-arrow-right"></i> العودة للقائمة
                            </a>
                        </div>

                        <!-- Body: عرض كل شيء بالتفصيل -->
                        <div class="p-4">
                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-hash"></i> الرقم التعريفي (ID):</span>
                                <span class="detail-value text-muted">#{{ $address->id }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-buildings"></i> المدينة التابع لها:</span>
                                <span class="detail-value text-primary fs-6">
                                    {{ $address->city->name ?? 'غير محددة' }}
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-pin-map"></i> المنطقة (area):</span>
                                <span class="detail-value">{{ $address->area }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-signpost-2"></i> الشارع (street):</span>
                                <span class="detail-value">{{ $address->street }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-building"></i> تفاصيل المبنى / أقرب معلم
                                    (building_details):</span>
                                <span
                                    class="detail-value text-muted">{{ $address->building_details ?? 'لا توجد تفاصيل إضافية' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-compass"></i> خط العرض (latitude):</span>
                                <span class="coord-badge">{{ $address->latitude ?? 'غير محدد' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-compass"></i> خط الطول (longitude):</span>
                                <span class="coord-badge">{{ $address->longitude ?? 'غير محدد' }}</span>
                            </div>

                            @if ($address->latitude && $address->longitude)
                                <div class="detail-row">
                                    <span class="detail-label"><i class="bi bi-map"></i> الموقع على الخريطة:</span>
                                    <a href="https://www.google.com/maps?q={{ $address->latitude }},{{ $address->longitude }}"
                                        target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-box-arrow-up-right"></i> فتح في خرائط Google
                                    </a>
                                </div>
                            @endif

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-calendar-plus"></i> تاريخ الإنشاء:</span>
                                <span class="detail-value text-muted" dir="ltr">
                                    {{ $address->created_at ? $address->created_at->format('Y-m-d - h:i A') : 'غير متوفر' }}
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-clock-history"></i> آخر تحديث:</span>
                                <span class="detail-value text-muted" dir="ltr">
                                    {{ $address->updated_at ? $address->updated_at->format('Y-m-d - h:i A') : 'غير متوفر' }}
                                </span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="p-4 bg-light border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('addresses.edit', $address->id) }}"
                                class="btn btn-warning rounded-pill px-4 text-white fw-bold">
                                <i class="bi bi-pencil-square"></i> تعديل هذا العنوان
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
