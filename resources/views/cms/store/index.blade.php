@extends('parent')

@section('title', 'إدارة المتاجر | متجر رونق')
@section('main-title', 'إدارة المتاجر')
@section('sub-title', 'عرض وإدارة جميع المتاجر المسجلة في منصة متجر رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .store-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08);
            overflow: hidden;
            position: relative;
        }

        .custom-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .card-header-custom {
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            border-bottom: 1px solid #f8fafc;
            padding: 1.5rem;
        }

        .btn-add-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 6px 18px rgba(190, 24, 93, 0.3);
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-add-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(190, 24, 93, 0.4);
            color: #ffffff;
        }

        .table-custom th {
            background-color: #fdf4ff;
            color: var(--rawnaq-dark-title);
            font-weight: 800;
            font-size: 0.88rem;
            border-bottom: 2px solid #fbcfe8;
            padding: 1rem;
        }

        .table-custom td {
            vertical-align: middle;
            padding: 1rem;
            font-size: 0.9rem;
            color: #334155;
            border-bottom: 1px solid #f8fafc;
        }

        .badge-status {
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-active {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-inactive {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-show { background-color: #e0f2fe; color: #0369a1; }
        .btn-edit { background-color: #fef3c7; color: #b45309; }
        .btn-delete { background-color: #fee2e2; color: #991b1b; }

        .action-btn:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <div class="store-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-card border-0">
                <!-- Header -->
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">قائمة المتاجر</h4>
                        <p class="text-muted mb-0 small">إدارة وعرض تفاصيل المتاجر التابعة للموردين والمالكين</p>
                    </div>
                    <a href="{{ route('stores.create') }}" class="btn-add-custom">
                        <i class="bi bi-plus-lg fs-6"></i>
                        <span>إضافة متجر جديد</span>
                    </a>
                </div>

                <!-- Table Body -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المتجر</th>
                                    <th>المالك</th>
                                    <th>العنوان</th>
                                    <th>رقم الواتساب</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stores as $store)
                                    <tr>
                                        <td class="fw-bold">#{{ $store->id }}</td>
                                        <td class="fw-bold text-dark">{{ $store->name }}</td>
                                        <td>{{ $store->user->name ?? 'غير محدد' }}</td>
                                        <td>{{ $store->address->street ?? '' }} - {{ $store->address->city->name ?? '' }}</td>
                                        <td dir="ltr" class="text-end">{{ $store->whatsapp_number }}</td>
                                        <td>
                                            @if ($store->status === 'active')
                                                <span class="badge-status badge-active">نشط</span>
                                            @else
                                                <span class="badge-status badge-inactive">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('stores.show', $store->id) }}" class="action-btn btn-show" title="عرض التفاصيل">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('stores.edit', $store->id) }}" class="action-btn btn-edit" title="تعديل">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" onclick="confirmDelete({{ $store->id }})" class="action-btn btn-delete" title="حذف">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-5 text-muted">
                                            <i class="bi bi-shop fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                            لا توجد متاجر مسجلة حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($stores->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $stores->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن يمكنك استعادة هذا المتجر بعد الحذف!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، قم بالحذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/cms/admin/stores/' + id)
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحذف!',
                                text: response.data.message || 'تم حذف المتجر بنجاح.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                            setTimeout(() => { location.reload(); }, 1200);
                        })
                        .catch(function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ!',
                                text: error.response?.data?.message || 'حدث خطأ أثناء محاولة الحذف.'
                            });
                        });
                }
            });
        }
    </script>
@endsection
