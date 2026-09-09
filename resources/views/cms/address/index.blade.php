@extends('parent')
@section('title', 'قائمة العناوين')
@section('main_title', 'إدارة العناوين')
@section('sub_title', 'قائمة العناوين المسجلة')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .address-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-table-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 4px 10px -2px rgba(0, 0, 0, 0.02);
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
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease-in-out;
        }

        .btn-create-custom:hover {
            background-color: #1d4ed8;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
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
            font-size: 0.925rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background-color: #fcfdfe;
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
    <div class="address-wrapper py-4" dir="rtl">
        <div class="container-fluid">
            <div class="card custom-table-card border-0">

                <!-- الهيدر -->
                <div class="table-header p-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon-box">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">جدول العناوين</h5>
                            <small class="text-muted">عرض البيانات الأساسية لجميع العناوين</small>
                        </div>
                    </div>
                    <a href="{{ route('addresses.create') }}" class="btn-create-custom d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i>
                        <span>إضافة عنوان جديد</span>
                    </a>
                </div>

                <!-- جدول العرض المختصر -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table custom-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px" class="text-center">#</th>
                                    <th>المنطقة</th>
                                    <th>الشارع</th>
                                    <th>المدينة التابع لها</th>
                                    <th style="width: 160px" class="text-center">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($addresses as $item)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $item->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 fw-semibold text-dark">
                                                <i class="bi bi-pin-map text-primary"></i>
                                                <span>{{ $item->area }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary">{{ $item->street }}</span>
                                        </td>
                                        <td>
                                            <span class="d-inline-flex align-items-center gap-1 px-3 py-1 rounded-pill"
                                                style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; font-size: 0.85rem; font-weight: 600;">
                                                <i class="bi bi-buildings" style="font-size: 0.8rem;"></i>
                                                {{ $item->city->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- عرض التفاصيل الكاملة -->
                                                <a href="{{ route('addresses.show', $item->id) }}"
                                                    class="action-btn btn-action-show" title="عرض كافة التفاصيل">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <!-- تعديل -->
                                                <a href="{{ route('addresses.edit', $item->id) }}"
                                                    class="action-btn btn-action-edit" title="تعديل">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <!-- حذف AJAX عبر confirmDestroy -->
                                                <button type="button" onclick="performDestroy({{ $item->id }}, this)"
                                                    class="action-btn btn-action-delete" title="حذف">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                            لا توجد عناوين مضافة حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if (method_exists($addresses, 'hasPages') && $addresses->hasPages())
                    <div class="p-3 d-flex justify-content-center border-top">
                        {{ $addresses->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function performDestroy(id, reference) {
            confirmDestroy('/cms/admin/addresses/' + id, reference);
        }
    </script>
@endsection
