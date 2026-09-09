@extends('parent')
@section('title', 'قائمة المدن')
@section('main_title', 'إدارة المدن')
@section('sub_title', 'قائمة المدن')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .city-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-table-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .table-header {
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
        }

        .header-icon-box {
            width: 42px;
            height: 42px;
            background-color: #eff6ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
        }

        .btn-create-custom {
            background-color: #2563eb;
            border-radius: 50px;
            padding: 0.5rem 1.3rem;
            font-size: 0.88rem;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-create-custom:hover {
            background-color: #1d4ed8;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .custom-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.875rem;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
        }

        .custom-table tbody td {
            padding: 1.1rem 1.25rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
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

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid transparent;
            transition: all 0.2s;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .btn-action-show {
            background-color: #eff6ff;
            color: #2563eb;
            border-color: #dbeafe;
        }

        .btn-action-show:hover {
            background-color: #2563eb;
            color: #fff;
        }

        .btn-action-edit {
            background-color: #fffbeb;
            color: #d97706;
            border-color: #fef3c7;
        }

        .btn-action-edit:hover {
            background-color: #d97706;
            color: #fff;
        }

        .btn-action-delete {
            background-color: #fef2f2;
            color: #dc2626;
            border-color: #fee2e2;
        }

        .btn-action-delete:hover {
            background-color: #dc2626;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="city-wrapper py-4" dir="rtl">
        <div class="container-fluid">
            <div class="card custom-table-card border-0">
                <!-- الهيدر -->
                <div class="table-header p-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon-box">
                            <i class="bi bi-buildings-fill fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">إدارة المدن</h5>
                            <small class="text-muted">نظرة عامة على المدن المسجلة</small>
                        </div>
                    </div>
                    <a href="{{ route('cities.create') }}" class="btn-create-custom d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i>
                        <span>إضافة مدينة</span>
                    </a>
                </div>

                <!-- الجدول المختصر: الرقم، الاسم، الحالة، العمليات فقط -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table custom-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px" class="text-center">#</th>
                                    <th>اسم المدينة</th>
                                    <th class="text-center">الحالة</th>
                                    <th style="width: 160px" class="text-center">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cities as $city)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $city->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 fw-semibold">
                                                <i class="bi bi-geo-alt text-primary"></i>
                                                <span>{{ $city->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($city->is_active == 1 || $city->is_active === 'active' || $city->is_active === '1')
                                                <span class="status-badge status-available">
                                                    <i class="bi bi-check-circle-fill"></i> مفعلة
                                                </span>
                                            @else
                                                <span class="status-badge status-unavailable">
                                                    <i class="bi bi-x-circle-fill"></i> غير مفعلة
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- زر العرض يفتح صفحة show -->
                                                <a href="{{ route('cities.show', $city->id) }}"
                                                    class="action-btn btn-action-show" title="عرض كافة التفاصيل">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('cities.edit', $city->id) }}"
                                                    class="action-btn btn-action-edit" title="تعديل">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button type="button" onclick="performDestroy({{ $city->id }}, this)"
                                                    class="action-btn btn-action-delete" title="حذف">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                            لا توجد مدن مضافة حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if (method_exists($cities, 'hasPages') && $cities->hasPages())
                    <div class="p-3 d-flex justify-content-center border-top">
                        {{ $cities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function performDestroy(id, reference) {
            confirmDestroy('/cms/admin/cities/' + id, reference);
        }
    </script>
@endsection
