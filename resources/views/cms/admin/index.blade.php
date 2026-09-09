@extends('parent')
@section('title', 'قائمة المشرفين')
@section('main_title', 'إدارة المشرفين')
@section('sub_title', 'عرض قائمة المشرفين')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .admin-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-table-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .table-header {
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
        }

        .header-icon-box {
            width: 44px;
            height: 44px;
            background-color: #eff6ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
        }

        .btn-create-custom {
            background-color: #1d68f0;
            border: none;
            border-radius: 8px;
            padding: 0.55rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .btn-create-custom:hover {
            background-color: #1754c7;
            color: #ffffff;
        }

        .custom-table {
            margin-bottom: 0;
        }

        .custom-table thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.875rem;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
            white-space: nowrap;
        }

        .custom-table tbody td {
            padding: 1rem 1.25rem;
            color: #334155;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .cell-icon {
            width: 36px;
            height: 36px;
            background-color: #f1f5f9;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .status-inactive {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .role-badge {
            background-color: #f5f3ff;
            color: #7c3aed;
            border: 1px solid #ddd6fe;
            border-radius: 6px;
            padding: 0.25rem 0.65rem;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .address-badge {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
            border-radius: 6px;
            padding: 0.25rem 0.65rem;
            font-size: 0.825rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
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
            text-decoration: none;
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

        .table-footer {
            background-color: #ffffff;
            border-top: 1px solid #f1f5f9;
            padding: 1rem 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="admin-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-12">

                    <div class="card custom-table-card border-0">
                        <!-- Table Header -->
                        <div
                            class="table-header px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-shield-lock-fill fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">قائمة المشرفين</h5>
                                    <small class="text-muted">إدارة حسابات المشرفين، الأدوار، وبيانات التواصل</small>
                                </div>
                            </div>
                            <a href="{{ route('admins.create') }}"
                                class="btn-create-custom d-flex align-items-center gap-2">
                                <i class="bi bi-plus-lg"></i>
                                <span>إضافة مشرف جديد</span>
                            </a>
                        </div>

                        <!-- Table -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table custom-table align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px" class="text-center">#</th>
                                            <th>المشرف</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>رقم الهاتف</th>
                                            <th>الدور (Role)</th>
                                            <th>العنوان السكني</th>
                                            <th>الحالة</th>
                                            <th style="width: 140px" class="text-center">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($admins as $admin)
                                            <tr>
                                                <td class="text-center fw-bold text-muted">{{ $admin->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 fw-semibold">
                                                        <div class="cell-icon">
                                                            <i class="bi bi-person-fill text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <div>{{ $admin->name }}</div>
                                                            <small class="text-muted fw-normal">انضم
                                                                {{ $admin->created_at?->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted"><i
                                                            class="bi bi-envelope me-1"></i>{{ $admin->email }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        style="direction: ltr; display: inline-block;">{{ $admin->phone ?? '-' }}</span>
                                                </td>
                                                <td>
                                                    <span class="role-badge">
                                                        <i class="bi bi-person-badge"></i>
                                                        {{ $admin->role ?? 'مشرف' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($admin->address)
                                                        <span class="address-badge">
                                                            <i class="bi bi-geo-alt"></i>
                                                            {{ $admin->address->city?->name ?? '' }} -
                                                            {{ $admin->address->area }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted small">غير محدد</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($admin->status == 'active' || $admin->status == 1)
                                                        <span class="status-badge status-active">
                                                            <i class="bi bi-check-circle-fill"></i> نشط
                                                        </span>
                                                    @else
                                                        <span class="status-badge status-inactive">
                                                            <i class="bi bi-x-circle-fill"></i> غير نشط
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                                        <!-- عرض -->
                                                        <a href="{{ route('admins.show', $admin->id) }}"
                                                            class="action-btn btn-action-show" title="عرض التفاصيل">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        <!-- تعديل -->
                                                        <a href="{{ route('admins.edit', $admin->id) }}"
                                                            class="action-btn btn-action-edit" title="تعديل">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>

                                                        <!-- حذف -->
                                                        <button type="button"
                                                            onclick="performDestroy({{ $admin->id }}, this)"
                                                            class="action-btn btn-action-delete" title="حذف">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <i
                                                        class="bi bi-shield-slash fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                    <span class="fw-semibold">لا يوجد مشرفين مسجلين حالياً.</span>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if ($admins->hasPages())
                            <div class="table-footer d-flex justify-content-center">
                                {{ $admins->links() }}
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
        function performDestroy(id, reference) {
            confirmDestroy('/cms/admin/admins/' + id, reference);
        }
    </script>
@endsection
