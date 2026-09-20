@extends('parent')
@section('title', 'قائمة الصلاحيات | متجر رونق')
@section('main-title', 'إدارة الصلاحيات')
@section('sub-title', 'عرض وإدارة الصلاحيات المسجلة في النظام')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #f1f5f9;
        }

        .permission-wrapper {
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

        /* شريط علوي ملون */
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

        /* زر إضافة صلاحية جديدة */
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

        .guard-badge {
            border-radius: 8px;
            padding: 0.35rem 0.85rem;
            font-size: 0.84rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid transparent;
        }

        /* أزرار العمليات الموحدة */
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

        .table-footer {
            background: linear-gradient(to right, #ffffff, #fdf4ff);
            border-top: 1px solid #fce7f3;
            padding: 1.1rem 1.75rem;
            border-radius: 0 0 24px 24px;
        }
    </style>
@endsection

@section('content')
    <div class="permission-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-table-card border-0">

                <!-- الهيدر -->
                <div class="table-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon-box">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">قائمة الصلاحيات</h5>
                            <small class="text-muted">عرض وإدارة الصلاحيات المتاحة لنظام متجر رونق</small>
                        </div>
                    </div>
                    @can('Create Permission')
                        <a href="{{ route('permissions.create') }}" class="btn-create-custom d-flex align-items-center gap-2">
                            <i class="bi bi-plus-lg fs-6"></i>
                            <span>إضافة صلاحية جديدة</span>
                        </a>
                    @endcan

                </div>

                <!-- جدول العرض -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table custom-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px" class="text-center">#</th>
                                    <th>اسم الصلاحية</th>
                                    <th>نطاق الحراسة (Guard)</th>
                                    @canany(['Show Permission', 'Delete Permission'])
                                        <th style="width: 140px" class="text-center">العمليات</th>
                                    @endcanany

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $permission)
                                    <tr>
                                        <td class="text-center fw-bold" style="color: #9333ea;">{{ $permission->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 fw-semibold">
                                                <div class="cell-icon">
                                                    <i class="bi bi-key-fill"></i>
                                                </div>
                                                <span class="text-dark fw-bold">{{ $permission->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($permission->guard_name == 'admin')
                                                <span class="guard-badge"
                                                    style="background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%); color: #be185d; border-color: #fbcfe8;">
                                                    <i class="bi bi-shield-lock-fill"></i> مشرف (Admin)
                                                </span>
                                            @elseif ($permission->guard_name == 'customer')
                                                <span class="guard-badge"
                                                    style="background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); color: #7c3aed; border-color: #ddd6fe;">
                                                    <i class="bi bi-person-heart"></i> زبون (Customer)
                                                </span>
                                            @elseif ($permission->guard_name == 'owner')
                                                <span class="guard-badge"
                                                    style="background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%); color: #e11d48; border-color: #fecdd3;">
                                                    <i class="bi bi-shop"></i> مالك (Owner)
                                                </span>
                                            @else
                                                <span class="guard-badge"
                                                    style="background: #f8fafc; color: #64748b; border-color: #e2e8f0;">
                                                    <i class="bi bi-lock-fill"></i> {{ $permission->guard_name }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                @can('Show Permission')
                                                    <!-- عرض التفاصيل (Show) -->
                                                    <a href="{{ route('permissions.show', $permission->id) }}"
                                                        class="action-btn" title="عرض التفاصيل">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('Delete Permission')
                                                    <!-- حذف -->
                                                    <button type="button" onclick="performDestroy({{ $permission->id }}, this)"
                                                        class="action-btn" title="حذف">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                @endcan



                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: #fdf2f8;">
                                                <i class="bi bi-key fs-1" style="color: var(--rawnaq-primary);"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark">لا توجد صلاحيات مسجلة حالياً</h6>
                                            <p class="text-muted small mb-0">يمكنك البدء بإضافة صلاحية جديدة عبر النقر على
                                                زر الإضافة أعلاه.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- الترقيم -->
                @if (method_exists($permissions, 'hasPages') && $permissions->hasPages())
                    <div class="table-footer d-flex justify-content-center align-items-center">
                        {{ $permissions->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function performDestroy(id, reference) {
            confirmDestroy('/cms/admin/permissions/' + id, reference);
        }
    </script>
@endsection
