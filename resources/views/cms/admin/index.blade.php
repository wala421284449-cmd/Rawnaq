@extends('parent')
@section('title', 'قائمة المشرفين | متجر رونق')
@section('main-title', 'إدارة المشرفين')
@section('sub-title', 'عرض قائمة المشرفين المسجلين في النظام')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #f1f5f9;
        }

        .admin-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        /* كرت الجدول الرئيسي الفاخر */
        .custom-table-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.07), 0 0 15px 0 rgba(147, 51, 234, 0.03);
            overflow: hidden;
            position: relative;
        }

        /* شريط علوي ملون ينبض بالحياة */
        .custom-table-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .table-header {
            border-bottom: 1px solid #fce7f3;
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            padding: 1.25rem 1.75rem;
        }

        .header-icon-box {
            width: 50px;
            height: 50px;
            background: var(--rawnaq-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.35rem;
            box-shadow: 0 8px 18px rgba(190, 24, 93, 0.28);
            transform: rotate(-3deg);
            transition: transform 0.3s ease;
        }

        .custom-table-card:hover .header-icon-box {
            transform: rotate(0deg) scale(1.05);
        }

        /* زر إضافة مشرف جديد */
        .btn-create-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.6rem;
            font-size: 0.92rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.3);
            transition: all 0.25s ease;
        }

        .btn-create-custom:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(190, 24, 93, 0.42);
        }

        /* تنسيق الجدول */
        .custom-table {
            margin-bottom: 0;
        }

        .custom-table thead th {
            background-color: #fdf4ff;
            color: #581c87;
            font-weight: 800;
            font-size: 0.88rem;
            border-bottom: 1px solid #f5d0fe;
            padding: 1.1rem 1.25rem;
            white-space: nowrap;
        }

        .custom-table tbody td {
            padding: 1.1rem 1.25rem;
            color: #334155;
            font-size: 0.92rem;
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
        }

        .custom-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .custom-table tbody tr:hover {
            background-color: #fdf2f8;
        }

        .cell-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
            border: 1px solid #fbcfe8;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--rawnaq-primary);
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* شارات موحدة وراقية */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
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
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
            color: #86198f;
            border: 1px solid #f5d0fe;
            border-radius: 8px;
            padding: 0.3rem 0.75rem;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .address-badge {
            background-color: #faf5ff;
            color: #7e22ce;
            border: 1px solid #f3e8ff;
            border-radius: 8px;
            padding: 0.3rem 0.75rem;
            font-size: 0.82rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* توحيد أزرار العمليات بالكامل (نفس الخلفية والحدود واللون) */
        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background-color: #fdf2f8 !important;
            border: 1px solid #fbcfe8 !important;
            color: #be185d !important;
            transition: all 0.25s ease;
            font-size: 0.95rem;
            cursor: pointer;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--rawnaq-gradient) !important;
            border-color: transparent !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(190, 24, 93, 0.35);
        }

        /* فوتر الجدول وترقيم الصفحات */
        .table-footer {
            background: linear-gradient(to right, #ffffff, #fdf4ff);
            border-top: 1px solid #fce7f3;
            padding: 1.1rem 1.75rem;
            border-radius: 0 0 24px 24px;
        }

        .table-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .table-footer .page-item .page-link {
            color: #701a75;
            background-color: #ffffff;
            border: 1px solid #fbcfe8;
            border-radius: 10px !important;
            padding: 0.45rem 0.85rem;
            font-weight: 700;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(190, 24, 93, 0.03);
        }

        .table-footer .page-item .page-link:hover {
            background-color: #fdf2f8;
            color: var(--rawnaq-primary);
            border-color: var(--rawnaq-primary);
            transform: translateY(-1px);
        }

        .table-footer .page-item.active .page-link {
            background: var(--rawnaq-gradient) !important;
            border-color: transparent !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(190, 24, 93, 0.35);
        }

        .table-footer .page-item.disabled .page-link {
            background-color: #f8fafc;
            border-color: #f1f5f9;
            color: #cbd5e1;
        }

        .table-footer p.text-muted,
        .table-footer .small {
            font-weight: 600;
            color: #701a75 !important;
            font-size: 0.85rem;
            margin-bottom: 0;
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
                        <div class="table-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">قائمة المشرفين</h5>
                                    <small class="text-muted">إدارة حسابات المشرفين، الأدوار، وبيانات التواصل في متجر
                                        رونق</small>
                                </div>
                            </div>
                            @can('Create Admin')
                                <a href="{{ route('admins.create') }}"
                                    class="btn-create-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-plus-lg fs-6"></i>
                                    <span>إضافة مشرف جديد</span>
                                </a>
                            @endcan

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
                                            @canany(['Delete Admin', 'Show Admin', 'Edit Admin'])
                                                <th style="width: 140px" class="text-center">العمليات</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($admins as $admin)
                                            <tr>
                                                <td class="text-center fw-bold" style="color: #9333ea;">{{ $admin->id }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 fw-semibold">
                                                        <div class="cell-icon">
                                                            <i class="bi bi-person-fill"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-dark fw-bold">{{ $admin->name }}</div>
                                                            <small class="text-muted fw-normal">
                                                                انضم {{ $admin->created_at?->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-secondary fw-semibold">
                                                        <i class="bi bi-envelope-at me-1"
                                                            style="color: var(--rawnaq-primary);"></i>
                                                        {{ $admin->email }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-dark"
                                                        style="direction: ltr; display: inline-block;">
                                                        {{ $admin->phone ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="role-badge">
                                                        <i class="bi bi-shield-check"></i>
                                                        {{ $admin->role ?? 'مشرف' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($admin->address)
                                                        <span class="address-badge">
                                                            <i class="bi bi-geo-alt-fill"></i>
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
                                                        @can('Show Admin')
                                                            <a href="{{ route('admins.show', $admin->id) }}" class="action-btn"
                                                                title="عرض التفاصيل">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        @endcan


                                                        @can('Edit Admin')
                                                            <!-- تعديل -->
                                                            <a href="{{ route('admins.edit', $admin->id) }}" class="action-btn"
                                                                title="تعديل">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                        @endcan

                                                        @can('Delete Admin')
                                                            <button type="button"
                                                                onclick="performDestroy({{ $admin->id }}, this)"
                                                                class="action-btn" title="حذف">
                                                                <i class="bi bi-trash3"></i>
                                                            </button>
                                                        @endcan
                                                        <!-- حذف -->

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <div class="d-inline-flex p-3 rounded-circle mb-3"
                                                        style="background: #fdf2f8;">
                                                        <i class="bi bi-shield-slash fs-1"
                                                            style="color: var(--rawnaq-primary);"></i>
                                                    </div>
                                                    <h6 class="fw-bold text-dark">لا يوجد مشرفين مسجلين حالياً</h6>
                                                    <p class="text-muted small mb-0">يمكنك إضافة مشرف جديد بالضغط على زر
                                                        الإضافة أعلاه.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if ($admins->hasPages())
                            <div class="table-footer d-flex justify-content-center align-items-center">
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
