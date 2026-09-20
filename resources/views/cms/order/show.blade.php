@extends('parent')

@section('title', 'تفاصيل الطلب | متجر رونق')
@section('main-title', 'الطلبات والحجوزات')
@section('sub-title', 'استعراض كافة تفاصيل الطلب أو الحجز مع قائمة المنتجات المطلوبة')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .orders-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-show-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08);
            overflow: hidden;
            position: relative;
        }

        .custom-show-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .show-header {
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            border-bottom: 1px solid #f8fafc;
            padding: 1.75rem 2rem;
        }

        .header-icon-box {
            width: 52px;
            height: 52px;
            background: var(--rawnaq-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.4rem;
        }

        /* تحسين تنسيق كارد المعلومات لتكون منظمة بالاتجاه الصحيح */
        .info-box {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 18px;
            padding: 1.25rem 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1e293b;
        }

        /* تنسيق جدول منتجات الطلب */
        .items-section-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--rawnaq-dark-title);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table-items th {
            background-color: #fdf4ff;
            color: var(--rawnaq-dark-title);
            font-weight: 800;
            font-size: 0.85rem;
            border-bottom: 2px solid #fbcfe8;
            padding: 0.9rem;
            text-align: right;
        }

        .table-items td {
            vertical-align: middle;
            padding: 0.9rem;
            font-size: 0.9rem;
            color: #334155;
            border-bottom: 1px solid #f8fafc;
            text-align: right;
        }

        .product-mini-img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #fbcfe8;
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: var(--rawnaq-primary);
            background: #ffffff;
            border: 1.5px solid #fbcfe8;
            border-radius: 50px;
            padding: 0.5rem 1.4rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <div class="orders-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-10">
                    <div class="card custom-show-card border-0">
                        <!-- رأس الصفحة -->
                        <div class="show-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <a href="{{ route('orders.index') }}" class="btn-return-custom">
                                    <i class="bi bi-arrow-right"></i> <span>العودة للقائمة</span>
                                </a>
                            </div>
                            <div class="d-flex align-items-center gap-3 text-end">
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تفاصيل الطلب رقم:
                                        #{{ $order->id }}</h5>
                                    <small class="text-muted">عرض تفاصيل العميل، المتجر، حالة الدفع، والمنتجات
                                        المطلوبة</small>
                                </div>
                                <div class="header-icon-box"><i class="bi bi-receipt"></i></div>
                            </div>
                        </div>

                        <!-- محتوى التفاصيل -->
                        <div class="p-4">
                            <!-- معلومات الفاتورة والعميل -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label"><i class="bi bi-person text-danger fs-5"></i> اسم العميل
                                        </div>
                                        <div class="info-value">{{ $order->customer_name }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label"><i class="bi bi-phone text-danger fs-5"></i> رقم الهاتف
                                        </div>
                                        <div class="info-value text-end" dir="ltr">{{ $order->customer_phone }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label"><i class="bi bi-shop text-danger fs-5"></i> المتجر التابع له
                                        </div>
                                        <div class="info-value">
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                                {{ $order->store->name ?? 'غير محدد' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <div class="info-label"><i class="bi bi-person-badge text-danger fs-5"></i> المستخدم
                                            (صاحب الحساب)</div>
                                        <div class="info-value">
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                                {{ $order->user->name ?? 'غير محدد' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <div class="info-label"><i class="bi bi-grid text-danger fs-5"></i> نوع الطلب</div>
                                        <div class="info-value">{{ $order->type }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <div class="info-label"><i class="bi bi-cash-stack text-danger fs-5"></i> الإجمالي
                                            الكلي</div>
                                        <div class="info-value text-danger">{{ $order->total_amount }} $</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <div class="info-label"><i class="bi bi-flag text-danger fs-5"></i> حالة الطلب</div>
                                        <div class="info-value">
                                            <span
                                                class="badge bg-secondary text-white px-3 py-1">{{ $order->status }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- قسم تفاصيل المنتجات المطلوبة (Order Items) -->
                            <div class="card border border-light-subtle shadow-sm rounded-4 p-3 mb-3">
                                <div class="items-section-title">
                                    <i class="bi bi-box-seam text-danger"></i>
                                    <span>المنتجات المطلوبة ضمن هذا الطلب</span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-items mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 60px;" class="text-center">الصورة</th>
                                                <th>اسم المنتج</th>
                                                <th>رمز المنتج (SKU)</th>
                                                <th class="text-center">الكمية</th>
                                                <th class="text-center">سعر الوحدة</th>
                                                <th class="text-center">المجموع الفرعي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($order->items ?? [] as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="{{ $item->product && $item->product->main_image ? asset('storage/' . $item->product->main_image) : asset('images/default.png') }}"
                                                            alt="صورة المنتج" class="product-mini-img">
                                                    </td>
                                                    <td class="fw-bold text-dark">
                                                        {{ $item->product->name ?? 'منتج غير محدد' }}</td>
                                                    <td>
                                                        <code class="text-purple bg-light px-2 py-1 rounded" dir="ltr">
                                                            {{ $item->product->sku ?? '---' }}
                                                        </code>
                                                    </td>
                                                    <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                                    <td class="text-center">{{ $item->price }} $</td>
                                                    <td class="text-center fw-bold text-danger">
                                                        {{ $item->quantity * $item->price }} $</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="py-4 text-center text-muted">
                                                        <i
                                                            class="bi bi-basket fs-3 d-block mb-1 text-secondary opacity-50"></i>
                                                        لا توجد منتجات مسجلة تفصيلياً لهذا الطلب حتى الآن.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ذيل الصفحة وأزرار الإجراءات -->
                        <div class="card-footer bg-white border-top p-4 d-flex justify-content-end">
                            <a href="{{ route('orders.edit', $order->id) }}"
                                class="btn px-4 py-2 fw-bold text-white shadow-sm"
                                style="background: var(--rawnaq-gradient); border: none; border-radius: 12px;">
                                <i class="bi bi-pencil-square"></i> تعديل الطلب
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
