@extends('parent')

@section('title', 'قائمة الزبائن | متجر رونق')
@section('main-title', 'إدارة الزبائن')
@section('sub-title', 'عرض قائمة عملاء وزبائن متجر رونق')

@section('styles')
    <style>
        .custom-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .table-top-bar {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
        }

        .btn-add-customer {
            background-color: #0d6efd;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 0.55rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-add-customer:hover {
            background-color: #0b5ed7;
            color: #ffffff;
        }

        .custom-table {
            margin-bottom: 0;
        }

        .custom-table thead th {
            background-color: #ffffff;
            color: #334155;
            font-weight: 700;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.1rem 1rem;
            white-space: nowrap;
            text-align: center;
        }

        .custom-table tbody td {
            padding: 1rem;
            color: #334155;
            font-size: 0.9rem;
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
            text-align: center;
            white-space: nowrap;
        }

        .custom-table tbody tr:hover {
            background-color: #fbfcfe;
        }

        .user-avatar-male {
            width: 38px;
            height: 38px;
            background-color: #dbeafe;
            color: #2563eb;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .user-avatar-female {
            width: 38px;
            height: 38px;
            background-color: #fce7f3;
            color: #db2777;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .id-badge {
            background-color: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .whatsapp-link {
            color: #16a34a;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            direction: ltr;
        }

        .whatsapp-link:hover {
            color: #15803d;
        }

        .gender-badge-male {
            background-color: #e0f2fe;
            color: #0284c7;
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.825rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .gender-badge-female {
            background-color: #ffe4e6;
            color: #e11d48;
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.825rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .location-badge {
            background-color: #f0fdf4;
            color: #16a34a;
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge-active {
            background-color: #dcfce7;
            color: #16a34a;
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.825rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge-inactive {
            background-color: #f1f5f9;
            color: #64748b;
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.825rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            border: 1px solid;
            background-color: #ffffff;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-view {
            border-color: #06b6d4;
            color: #06b6d4;
        }

        .btn-view:hover {
            background-color: #06b6d4;
            color: #fff;
        }

        .btn-edit {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .btn-edit:hover {
            background-color: #3b82f6;
            color: #fff;
        }

        .btn-delete {
            border-color: #ef4444;
            color: #ef4444;
        }

        .btn-delete:hover {
            background-color: #ef4444;
            color: #fff;
        }

        .table-footer {
            background-color: #ffffff;
            border-top: 1px solid #f1f5f9;
            padding: 1rem 1.5rem;
        }

        .ltr-text {
            direction: ltr;
            display: inline-block;
        }
    </style>
@endsection

@section('content')
    <div class="app-content py-4" dir="rtl">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-12">

                    <div class="card custom-card">
                        <!-- Top Action Bar -->
                        <div class="table-top-bar d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                                <i class="bi bi-people text-primary"></i>
                                <span>قائمة الزبائن - متجر رونق</span>
                            </div>

                            <a href="{{ route('customers.create') }}" class="btn-add-customer">
                                <i class="bi bi-person-plus-fill"></i>
                                <span>إضافة زبون جديد</span>
                            </a>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table custom-table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#ID</th>
                                        <th style="text-align: right; padding-right: 1.5rem;">الزبون</th>
                                        <th>بيانات الاتصال</th>
                                        <th>رقم الهوية</th>
                                        <th>رقم الواتساب</th>
                                        <th>الجنس</th>
                                        <th>العنوان</th>
                                        <th>الحالة</th>
                                        <th style="width: 140px;">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $item)
                                        <tr>
                                            <!-- ID -->
                                            <td class="text-muted fw-semibold">#{{ $item->id }}</td>

                                            <!-- Customer Name & Avatar -->
                                            <td style="text-align: right; padding-right: 1.5rem;">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($item->gender == 'male' || $item->gender == 'ذكر')
                                                        <div class="user-avatar-male"><i class="bi bi-person"></i></div>
                                                    @else
                                                        <div class="user-avatar-female"><i class="bi bi-person-female"></i>
                                                        </div>
                                                    @endif
                                                    <span class="fw-bold text-dark">{{ $item->name }}</span>
                                                </div>
                                            </td>

                                            <!-- Contact Info -->
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <span class="text-muted small d-inline-flex align-items-center gap-1">
                                                        <span class="ltr-text">{{ $item->email }}</span>
                                                        <i class="bi bi-envelope text-secondary"></i>
                                                    </span>
                                                    <span
                                                        class="text-dark small fw-semibold d-inline-flex align-items-center gap-1 ltr-text">
                                                        {{ $item->phone ?? '-' }}
                                                        <i class="bi bi-telephone text-secondary"></i>
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- ID Number -->
                                            <td>
                                                @php
                                                    $idNumber = $item->id_number ?? ($item->actor?->id_number ?? null);
                                                @endphp
                                                @if ($idNumber)
                                                    <span class="id-badge">
                                                        <span class="ltr-text">{{ $idNumber }}</span>
                                                        <i class="bi bi-card-heading text-primary"></i>
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <!-- WhatsApp Number -->
                                            <td>
                                                @php
                                                    $whatsapp =
                                                        $item->whats_up_number ??
                                                        ($item->actor?->whats_up_number ?? null);
                                                @endphp
                                                @if ($whatsapp)
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}"
                                                        target="_blank" class="whatsapp-link" title="مراسلة عبر واتساب">
                                                        <span>{{ $whatsapp }}</span>
                                                        <i class="bi bi-whatsapp"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <!-- Gender -->
                                            <td>
                                                @if ($item->gender == 'male' || $item->gender == 'ذكر')
                                                    <span class="gender-badge-male">
                                                        ذكر <i class="bi bi-gender-male"></i>
                                                    </span>
                                                @else
                                                    <span class="gender-badge-female">
                                                        أنثى <i class="bi bi-gender-female"></i>
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Address -->
                                            <td>
                                                @if ($item->address)
                                                    <span class="location-badge">
                                                        {{ $item->address->street ?? '' }}
                                                        {{ isset($item->address->city) ? '- ' . $item->address->city->name : '' }}
                                                        <i class="bi bi-geo-alt"></i>
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if ($item->status == 'active' || $item->status == 1)
                                                    <span class="status-badge-active">
                                                        <i class="bi bi-check-circle-fill"></i> نشط
                                                    </span>
                                                @else
                                                    <span class="status-badge-inactive">
                                                        <i class="bi bi-x-circle-fill"></i> غير نشط
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <button type="button"
                                                        onclick="performDestroy({{ $item->id }}, this)"
                                                        class="action-btn btn-delete" title="حذف">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <a href="{{ route('customers.edit', $item->id) }}"
                                                        class="action-btn btn-edit" title="تعديل">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>

                                                    <a href="{{ route('customers.show', $item->id) }}"
                                                        class="action-btn btn-view" title="عرض">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5 text-muted">
                                                <i class="bi bi-people fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                                <span class="fw-semibold">لا يوجد زبائن مسجلين في متجر رونق حالياً.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if (method_exists($customers, 'hasPages') && $customers->hasPages())
                            <div class="table-footer d-flex justify-content-center">
                                {{ $customers->links() }}
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
            confirmDestroy('/cms/admin/customers/' + id, reference);
        }
    </script>
@endsection
