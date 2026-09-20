@extends('parent')

@section('title', 'إنشاء طلب أو حجز جديد | متجر رونق')
@section('main-title', 'الطلبات والحجوزات')
@section('sub-title', 'إضافة طلب أو حجز جديد وتحديد بيانات العميل والمتجر والمبلغ')

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

        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08);
            overflow: hidden;
            position: relative;
        }

        .custom-form-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: var(--rawnaq-gradient);
        }

        .form-header {
            border-bottom: 1px solid #f8fafc;
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            padding: 1.25rem 1.75rem;
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
            box-shadow: 0 8px 18px rgba(190, 24, 93, 0.28);
        }

        .btn-return-custom {
            font-size: 0.875rem;
            color: var(--rawnaq-primary);
            background: #ffffff;
            border: 1.5px solid #fbcfe8;
            border-radius: 50px;
            padding: 0.45rem 1.35rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-color: transparent;
        }

        .section-box {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #fdf2f8;
            border: 1px solid #f5d0fe;
            color: var(--rawnaq-primary);
            font-size: 0.92rem;
            font-weight: 800;
            padding: 0.45rem 1.1rem;
            border-radius: 30px;
            margin-bottom: 1.25rem;
        }

        .custom-label {
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.45rem;
        }

        .badge-req {
            background-color: #fdf2f8;
            color: var(--rawnaq-primary);
            border: 1px solid #fbcfe8;
            font-size: 0.72rem;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
        }

        .input-group-custom .input-group-text {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
        }

        .input-group-custom .form-control,
        .input-group-custom .form-select {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            padding: 0.65rem 1rem;
            color: #1e293b;
        }

        .form-footer {
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            padding: 1.25rem 2rem;
            border-radius: 0 0 24px 24px;
        }

        .btn-save-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.65rem 2rem;
            font-size: 0.95rem;
            font-weight: 800;
            color: #ffffff;
            cursor: pointer;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.35);
        }

        .btn-cancel-custom {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 1.6rem;
            color: #64748b;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="orders-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-form-card border-0">
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box"><i class="bi bi-cart-plus"></i></div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">إنشاء طلب أو حجز جديد
                                    </h5>
                                    <small class="text-muted">تسجيل طلب أو حجز جديد ضمن النظام</small>
                                </div>
                            </div>
                            <a href="{{ route('orders.index') }}" class="btn-return-custom">العودة للقائمة <i
                                    class="bi bi-arrow-left"></i></a>
                        </div>

                        <form id="create_order_form">
                            @csrf
                            <div class="p-4">
                                <div class="section-box">
                                    <div class="section-badge"><i class="bi bi-person"></i> بيانات العميل والارتباطات</div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="custom-label"><span>اسم العميل</span> <span
                                                    class="badge-req">مطلوب</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" name="customer_name" id="customer_name"
                                                    class="form-control" placeholder="مثال: أحمد محمد" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label"><span>رقم الهاتف</span> <span
                                                    class="badge-req">مطلوب</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                                <input type="text" name="customer_phone" id="customer_phone"
                                                    class="form-control" placeholder="0590000000" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label"><span>المتجر التابع له</span> <span
                                                    class="badge-req">مطلوب</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                                <select name="stores_id" id="stores_id" class="form-select" required>
                                                    <option value="" disabled selected>اختر المتجر...</option>
                                                    @foreach ($stores ?? [] as $store)
                                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label"><span>المستخدم (صاحب الحساب)</span> <span
                                                    class="badge-req">مطلوب</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                                <select name="user_id" id="user_id" class="form-select" required>
                                                    <option value="" disabled selected>اختر المستخدم...</option>
                                                    @foreach ($users ?? [] as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-box">
                                    <div class="section-badge"><i class="bi bi-cash-stack"></i> تفاصيل الطلب والدفع</div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="custom-label"><span>نوع الطلب</span> <span
                                                    class="badge-req">مطلوب</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-grid"></i></span>
                                                <input type="text" name="type" id="type" class="form-control"
                                                    placeholder="order / booking" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="custom-label"><span>الإجمالي ($)</span> <span
                                                    class="badge-req">مطلوب</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                                <input type="text" name="total_amount" id="total_amount"
                                                    class="form-control" placeholder="250.00" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="custom-label"><span>الحالة</span> <span
                                                    class="badge-req">مطلوب</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                                <input type="text" name="status" id="status" class="form-control"
                                                    value="pending" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label"><span>تاريخ الحجز</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                <input type="date" name="booking_date" id="booking_date"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label"><span>bookings_or_orderscol
                                                    (اختياري)</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                                                <input type="text" name="bookings_or_orderscol"
                                                    id="bookings_or_orderscol" class="form-control"
                                                    placeholder="حقل إضافي">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('orders.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performStoreOrder()" class="btn-save-custom">حفظ
                                    الطلب</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function performStoreOrder() {
            let formData = {
                customer_name: document.getElementById('customer_name').value,
                customer_phone: document.getElementById('customer_phone').value,
                stores_id: document.getElementById('stores_id').value,
                user_id: document.getElementById('user_id').value,
                type: document.getElementById('type').value,
                total_amount: document.getElementById('total_amount').value,
                status: document.getElementById('status').value,
                booking_date: document.getElementById('booking_date').value,
                bookings_or_orderscol: document.getElementById('bookings_or_orderscol').value,
            };

            axios.post('/cms/admin/orders', formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title,
                        text: response.data.message,
                        timer: 1200,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('orders.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الحفظ',
                        text: error.response?.data?.message || 'حدث خطأ'
                    });
                });
        }
    </script>
@endsection
