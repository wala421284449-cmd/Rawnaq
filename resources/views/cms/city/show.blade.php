@extends('parent')
@section('title', 'تفاصيل المدينة')
@section('main_title', 'إدارة المدن')
@section('sub_title', 'عرض تفاصيل المدينة')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .city-wrapper {
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
            padding: 1rem 0;
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

        .slug-badge {
            background: #f1f5f9;
            color: #334155;
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.9rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.825rem;
            font-weight: 600;
        }

        .status-available {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .status-unavailable {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
    </style>
@endsection

@section('content')
    <div class="city-wrapper py-4" dir="rtl">
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
                                    <h5 class="fw-bold mb-0 text-dark">تفاصيل المدينة: {{ $city->name }}</h5>
                                    <small class="text-muted">كافة البيانات المسجلة في قاعدة البيانات</small>
                                </div>
                            </div>
                            <a href="{{ route('cities.index') }}" class="btn btn-light rounded-pill px-3 border">
                                <i class="bi bi-arrow-right"></i> العودة للقائمة
                            </a>
                        </div>

                        <!-- Body: عرض كل شيء بالتفصيل -->
                        <div class="p-4">
                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-hash"></i> الرقم التعريفي (ID):</span>
                                <span class="detail-value text-muted">#{{ $city->id }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-building"></i> اسم المدينة (name):</span>
                                <span class="detail-value fs-6 text-primary">{{ $city->name }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-link-45deg"></i> الرابط اللطيف (slug):</span>
                                <span class="slug-badge">{{ $city->slug ?? 'غير محدد' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-toggle-on"></i> حالة التفعيل (is_active):</span>
                                <span>
                                    @if ($city->is_active == 1 || $city->is_active === 'active' || $city->is_active === '1')
                                        <span class="status-badge status-available">
                                            <i class="bi bi-check-circle-fill"></i> مفعلة في النظام
                                        </span>
                                    @else
                                        <span class="status-badge status-unavailable">
                                            <i class="bi bi-x-circle-fill"></i> غير مفعلة
                                        </span>
                                    @endif
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-calendar-plus"></i> تاريخ الإنشاء
                                    (created_at):</span>
                                <span class="detail-value text-muted" dir="ltr">
                                    {{ $city->created_at ? $city->created_at->format('Y-m-d - h:i A') : 'غير متوفر' }}
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-clock-history"></i> آخر تعديل
                                    (updated_at):</span>
                                <span class="detail-value text-muted" dir="ltr">
                                    {{ $city->updated_at ? $city->updated_at->format('Y-m-d - h:i A') : 'غير متوفر' }}
                                </span>
                            </div>
                        </div>

                        <!-- Footer: أزرار التعديل -->
                        <div class="p-4 bg-light border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('cities.edit', $city->id) }}"
                                class="btn btn-warning rounded-pill px-4 text-white fw-bold">
                                <i class="bi bi-pencil-square"></i> تعديل المدينة
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
