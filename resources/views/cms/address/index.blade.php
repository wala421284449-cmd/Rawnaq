@extends('parent')
@section('title', 'قائمة العناوين | متجر رونق')
@section('main-title', 'إدارة العناوين')
@section('sub-title', 'قائمة العناوين المسجلة في النظام')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #f1f5f9;
        }

        .address-wrapper {
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

        /* زر إضافة عنوان جديد */
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

        .city-badge {
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
            color: #86198f;
            border: 1px solid #f5d0fe;
            border-radius: 8px;
            padding: 0.35rem 0.85rem;
            font-size: 0.84rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* توحيد أزرار العمليات بالكامل لتكون نفس المظهر واللون */
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
    <div class="address-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-table-card border-0">

                <!-- الهيدر -->
                <div class="table-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon-box">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">جدول العناوين</h5>
                            <small class="text-muted">عرض وإدارة البيانات الأساسية لكافة العناوين المسجلة في متجر
                                رونق</small>
                        </div>
                    </div>
                    @can('Create Address')
                        <a href="{{ route('addresses.create') }}" class="btn-create-custom d-flex align-items-center gap-2">
                            <i class="bi bi-plus-lg fs-6"></i>
                            <span>إضافة عنوان جديد</span>
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
                                    <th>المنطقة / الحي</th>
                                    <th>اسم الشارع</th>
                                    <th>المدينة التابع لها</th>
                                    @canany(['Show Address', 'Edit Address', 'Delete Address'])
                                        <th style="width: 160px" class="text-center">العمليات</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($addresses as $item)
                                    <tr>
                                        <td class="text-center fw-bold" style="color: #9333ea;">{{ $item->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 fw-semibold">
                                                <div class="cell-icon">
                                                    <i class="bi bi-pin-map-fill"></i>
                                                </div>
                                                <span class="text-dark fw-bold">{{ $item->area }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary fw-semibold">
                                                <i class="bi bi-signpost-2 me-1" style="color: var(--rawnaq-primary);"></i>
                                                {{ $item->street }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="city-badge">
                                                <i class="bi bi-buildings"></i>
                                                {{ $item->city->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                @can('Show Address')
                                                    <!-- عرض التفاصيل -->
                                                    <a href="{{ route('addresses.show', $item->id) }}" class="action-btn"
                                                        title="عرض كافة التفاصيل">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('Edit Address')
                                                    <!-- تعديل -->
                                                    <a href="{{ route('addresses.edit', $item->id) }}" class="action-btn"
                                                        title="تعديل">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                @endcan
                                                @can('Delete Address')
                                                    <!-- حذف -->
                                                    <button type="button" onclick="performDestroy({{ $item->id }}, this)"
                                                        class="action-btn" title="حذف">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                @endcan


                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: #fdf2f8;">
                                                <i class="bi bi-geo-slash fs-1" style="color: var(--rawnaq-primary);"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark">لا توجد عناوين مضافة حالياً</h6>
                                            <p class="text-muted small mb-0">يمكنك البدء بإضافة أول عنوان عبر النقر على زر
                                                الإضافة أعلاه.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- الترقيم والصفحات -->
                @if (method_exists($addresses, 'hasPages') && $addresses->hasPages())
                    <div class="table-footer d-flex justify-content-center align-items-center">
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
