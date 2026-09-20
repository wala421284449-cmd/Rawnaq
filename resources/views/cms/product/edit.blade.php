@extends('parent')

@section('title', 'تعديل المنتج | متجر رونق')
@section('main-title', 'المنتجات')
@section('sub-title', 'تحديث وتعديل بيانات المنتج المختار ضمن منصة رونق')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .products-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08), 0 0 15px 0 rgba(147, 51, 234, 0.03);
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
            box-shadow: 0 2px 8px rgba(190, 24, 93, 0.06);
            transition: all 0.25s ease;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 6px 15px rgba(190, 24, 93, 0.25);
            transform: translateY(-2px);
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
            background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);
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
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .badge-req {
            background-color: #fdf2f8;
            color: var(--rawnaq-primary);
            border: 1px solid #fbcfe8;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
        }

        .badge-opt {
            background-color: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
        }

        .input-group-custom .input-group-text {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
            padding: 0.65rem 1rem;
        }

        .input-group-custom .form-control,
        .input-group-custom .form-select {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            padding: 0.65rem 1rem;
            font-size: 0.925rem;
            color: #1e293b;
            font-weight: 500;
        }

        .input-group-custom .form-control:focus,
        .input-group-custom .form-select:focus {
            border-color: #d946ef;
            box-shadow: 0 0 0 4px rgba(217, 70, 239, 0.15);
            outline: none;
        }

        .form-footer {
            background: linear-gradient(to right, #ffffff, #fdf4ff);
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
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.35);
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .btn-save-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(190, 24, 93, 0.45);
            color: #ffffff;
        }

        .btn-cancel-custom {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 1.6rem;
            font-size: 0.92rem;
            font-weight: 700;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-cancel-custom:hover {
            background-color: #f8fafc;
            color: #1e293b;
        }
    </style>
@endsection

@section('content')
    <div class="products-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تعديل المنتج:
                                        {{ $product->name }}</h5>
                                    <small class="text-muted">تحديث وتعديل تفاصيل ومعلومات المنتج الحالي</small>
                                </div>
                            </div>
                            <a href="{{ route('products.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="update_product_form" enctype="multipart/form-data">
                            @csrf
                            <div class="p-4">
                                <!-- Section 1: المعلومات الأساسية -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-info-circle"></i>
                                        <span>المعلومات الأساسية والارتباطات</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <label for="name" class="custom-label">
                                                <span>اسم المنتج</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="{{ $product->name }}" required>
                                            </div>
                                        </div>

                                        <!-- SKU -->
                                        <div class="col-md-6">
                                            <label for="sku" class="custom-label">
                                                <span>رمز المنتج (SKU)</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-upc"></i></span>
                                                <input type="text" name="sku" id="sku" class="form-control"
                                                    value="{{ $product->sku }}" required>
                                            </div>
                                        </div>

                                        <!-- Store Selection -->
                                        <div class="col-md-6">
                                            <label for="stores_id" class="custom-label">
                                                <span>المتجر التابع له</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                                <select name="stores_id" id="stores_id" class="form-select" required>
                                                    <option value="" disabled>اختر المتجر...</option>
                                                    @foreach ($stores ?? [] as $store)
                                                        <option value="{{ $store->id }}"
                                                            {{ $product->stores_id == $store->id ? 'selected' : '' }}>
                                                            {{ $store->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Category Selection -->
                                        <div class="col-md-6">
                                            <label for="categories_id" class="custom-label">
                                                <span>التصنيف</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-bookmark"></i></span>
                                                <select name="categories_id" id="categories_id" class="form-select"
                                                    required>
                                                    <option value="" disabled>اختر التصنيف...</option>
                                                    @foreach ($categories ?? [] as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $product->categories_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: التسعير، المخزون والحالة -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-cash-stack"></i>
                                        <span>التسعير، المخزون والصورة</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Base Price -->
                                        <div class="col-md-4">
                                            <label for="base_price" class="custom-label">
                                                <span>السعر الأساسي ($)</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                                <input type="text" name="base_price" id="base_price" class="form-control"
                                                    value="{{ $product->base_price }}" required>
                                            </div>
                                        </div>

                                        <!-- Stock Quantity -->
                                        <div class="col-md-4">
                                            <label for="stock_quantity" class="custom-label">
                                                <span>كمية المخزون</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-stack"></i></span>
                                                <input type="number" name="stock_quantity" id="stock_quantity"
                                                    class="form-control" value="{{ $product->stock_quantity }}" required>
                                            </div>
                                        </div>

                                        <!-- Is Active Status -->
                                        <div class="col-md-4">
                                            <label for="is_active" class="custom-label">
                                                <span>حالة التفعيل</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                                <select name="is_active" id="is_active" class="form-select" required>
                                                    <option value="active"
                                                        {{ $product->is_active === 'active' ? 'selected' : '' }}>نشط
                                                    </option>
                                                    <option value="inactive"
                                                        {{ $product->is_active === 'inactive' ? 'selected' : '' }}>غير نشط
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Main Image -->
                                        <div class="col-md-12">
                                            <label for="main_image" class="custom-label">
                                                <span>صورة المنتج الرئيسية (اتركها فارغة إن لم ترد التغيير)</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-image"></i></span>
                                                <input type="file" name="main_image" id="main_image"
                                                    class="form-control" accept="image/*">
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12">
                                            <label for="description" class="custom-label">
                                                <span>وصف المنتج</span>
                                                <span class="badge-opt">اختياري</span>
                                            </label>
                                            <div class="input-group input-group-custom align-items-start">
                                                <span class="input-group-text pt-3"><i
                                                        class="bi bi-text-paragraph"></i></span>
                                                <textarea name="description" id="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('products.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performUpdateProduct({{ $product->id }})"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                    <span>تحديث المنتج</span>
                                </button>
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
        function performUpdateProduct(id) {
            let formData = new FormData();
            formData.append('_method', 'PUT'); // إبلاغ لارافيل بأن الطلب PUT
            formData.append('name', document.getElementById('name').value);
            formData.append('sku', document.getElementById('sku').value);
            formData.append('stores_id', document.getElementById('stores_id').value);
            formData.append('categories_id', document.getElementById('categories_id').value);
            formData.append('base_price', document.getElementById('base_price').value);
            formData.append('stock_quantity', document.getElementById('stock_quantity').value);
            formData.append('is_active', document.getElementById('is_active').value);
            formData.append('description', document.getElementById('description').value);

            let imageFile = document.getElementById('main_image').files[0];
            if (imageFile) {
                formData.append('main_image', imageFile); // إرفاق ملف الصورة الفعلي بالـ FormData
            }

            axios.post('/cms/admin/products/' + id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم التحديث بنجاح',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });

                    setTimeout(function() {
                        window.location.href = "{{ route('products.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    let message = 'حدث خطأ أثناء تحديث المنتج';
                    if (error.response && error.response.data) {
                        message = error.response.data.message || message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في التحديث',
                        text: message
                    });
                });
        }
    </script>
@endsection
