@extends('parent')

@section('title', 'قائمة المالكين | متجر رونق')
@section('main-title', 'إدارة المالكين')
@section('sub-title', 'عرض قائمة المالكين والموردين لمتجر رونق')

@section('styles')
    <style>
        .card {
            border-radius: 12px;
        }

        .table th {
            font-weight: 600;
            letter-spacing: 0.3px;
            background-color: #f8f9fa;
            text-align: right;
        }

        .table td {
            text-align: right;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .ltr-text {
            direction: ltr;
            display: inline-block;
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <div class="app-content pt-4" dir="rtl">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden" dir="rtl">

                        <!-- Header -->
                        <div
                            class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="card-title fw-bold m-0 text-dark">
                                <i class="bi bi-shop text-primary ms-2"></i>قائمة المالكين والموردين - متجر رونق
                            </h5>
                            <a href="{{ route('owners.create') }}" class="btn btn-primary btn-sm rounded-2 px-3 shadow-sm">
                                <i class="bi bi-person-plus-fill ms-1"></i> إضافة مالك جديد
                            </a>
                        </div>

                        <!-- Table Wrapper -->
                        <div class="card-body p-0 table-responsive" dir="rtl">
                            <table class="table table-hover align-middle mb-0 text-end">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th style="width: 70px" class="text-center py-3">#ID</th>
                                        <th class="py-3 text-end">المالك</th>
                                        <th class="py-3 text-end">بيانات الاتصال</th>
                                        <th class="py-3 text-end">رقم الهوية</th>
                                        <th class="py-3 text-end">رقم الواتساب</th>
                                        <th class="py-3 text-end">العنوان</th>
                                        <th class="text-center py-3">الحالة</th>
                                        <th class="text-center py-3" style="width: 160px">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($owners as $owner)
                                        <tr class="border-bottom">
                                            <!-- ID -->
                                            <td class="text-center fw-bold text-muted py-3">
                                                <span
                                                    class="badge bg-light text-secondary border">#{{ $owner->id }}</span>
                                            </td>

                                            <!-- Name & Avatar -->
                                            <td class="py-3 text-end">
                                                <div class="d-flex align-items-center justify-content-start">
                                                    <div
                                                        class="avatar-circle ms-2 {{ $owner->gender == 'male' ? 'bg-primary-subtle text-primary' : ($owner->gender == 'female' ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary') }}">
                                                        <i
                                                            class="bi {{ $owner->gender == 'male' ? 'bi-person' : ($owner->gender == 'female' ? 'bi-person-female' : 'bi-person-fill') }}"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold text-dark">{{ $owner->name }}</h6>
                                                        <small
                                                            class="text-muted">{{ $owner->gender == 'male' ? 'ذكر' : ($owner->gender == 'female' ? 'أنثى' : '') }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Contact Info -->
                                            <td class="py-3 text-end">
                                                <div class="d-flex flex-column gap-1">
                                                    <small class="text-dark">
                                                        <i class="bi bi-envelope text-muted ms-1"></i>
                                                        <span class="ltr-text">{{ $owner->email }}</span>
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="bi bi-telephone text-muted ms-1"></i>
                                                        <span class="ltr-text">{{ $owner->phone ?? 'غير محدد' }}</span>
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- ID Number -->
                                            <td class="py-3 text-end">
                                                <span
                                                    class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-normal">
                                                    <i class="bi bi-card-heading text-primary ms-1"></i>
                                                    <span
                                                        class="ltr-text">{{ $owner->id_number ?? ($owner->actor?->id_number ?? 'غير محدد') }}</span>
                                                </span>
                                            </td>

                                            <!-- WhatsApp Number -->
                                            <td class="py-3 text-end">
                                                @php
                                                    $whatsapp =
                                                        $owner->whats_up_number ?? $owner->actor?->whats_up_number;
                                                @endphp
                                                @if ($whatsapp)
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}"
                                                        target="_blank"
                                                        class="text-success text-decoration-none fw-semibold small">
                                                        <i class="bi bi-whatsapp ms-1"></i>
                                                        <span class="ltr-text">{{ $whatsapp }}</span>
                                                    </a>
                                                @else
                                                    <small class="text-muted">غير محدد</small>
                                                @endif
                                            </td>

                                            <!-- Address -->
                                            <td class="py-3 text-end">
                                                <span
                                                    class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-normal">
                                                    <i class="bi bi-geo-alt text-primary ms-1"></i>
                                                    {{ $owner->address->street ?? 'غير محدد' }}
                                                    {{ isset($owner->address->city) ? '- ' . $owner->address->city->name : '' }}
                                                </span>
                                            </td>

                                            <!-- Status -->
                                            <td class="text-center py-3">
                                                @if ($owner->status == 'active' || $owner->status == 1)
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                                        <i class="bi bi-check-circle-fill ms-1"></i>نشط
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1">
                                                        <i class="bi bi-x-circle-fill ms-1"></i>غير نشط
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-center py-3">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('owners.show', $owner->id) }}"
                                                        class="btn btn-sm btn-outline-info action-btn"
                                                        data-bs-toggle="tooltip" title="عرض التفاصيل">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('owners.edit', $owner->id) }}"
                                                        class="btn btn-sm btn-outline-primary action-btn"
                                                        data-bs-toggle="tooltip" title="تعديل">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="performDestroy({{ $owner->id }}, this)"
                                                        class="btn btn-sm btn-outline-danger action-btn"
                                                        data-bs-toggle="tooltip" title="حذف">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <i
                                                    class="bi bi-shop-window fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                لا يوجد مالكين مسجلين في متجر رونق حالياً.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if (method_exists($owners, 'hasPages') && $owners->hasPages())
                            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center" dir="rtl">
                                {{ $owners->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        function performDestroy(id, reference) {
            var tooltip = bootstrap.Tooltip.getInstance(reference);
            if (tooltip) {
                tooltip.hide();
            }
            confirmDestroy('/cms/admin/owners/' + id, reference);
        }
    </script>
@endsection
