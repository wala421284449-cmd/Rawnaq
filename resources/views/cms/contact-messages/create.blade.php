@extends('parent')

@section('title', 'إنشاء رسالة تواصل جديدة | متجر رونق')
@section('main-title', 'رسائل العملاء')
@section('sub-title', 'إضافة وتسجيل رسالة تواصل جديدة يدوياً ضمن منصة رونق')

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
            transform: rotate(-3deg);
            transition: transform 0.3s ease;
        }

        .custom-form-card:hover .header-icon-box {
            transform: rotate(0deg) scale(1.05);
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
            position: relative;
            transition: all 0.25s ease;
        }

        .section-box:hover {
            background: #ffffff;
            border-color: #fbcfe8;
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.04);
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

        .input-group-custom .input-group-text {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
            padding: 0.65rem 1rem;
            transition: all 0.25s ease;
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
            transition: all 0.25s ease;
        }

        .input-group-custom .form-control:focus,
        .input-group-custom .form-select:focus {
            border-color: #d946ef;
            box-shadow: 0 0 0 4px rgba(217, 70, 239, 0.15);
            outline: none;
        }

        .input-group-custom:focus-within .input-group-text {
            border-color: #d946ef;
            color: #be185d;
            background-color: #fdf4ff;
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
            border-color: #cbd5e1;
        }
    </style>
@endsection

@section('content')
    <div class="store-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">إضافة رسالة تواصل
                                        جديدة</h5>
                                    <small class="text-muted">تسجيل رسالة تواصل واستفسار جديدة تابعة للمتجر في
                                        النظام</small>
                                </div>
                            </div>
                            <a href="{{ route('contact-messages.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <span>العودة للقائمة</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="create_message_form">
                            @csrf
                            <div class="p-4">

                                <!-- Section 1: بيانات المتجر والمرسل -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-info-circle"></i>
                                        <span>معلومات المتجر والمرسل</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Store Selection -->
                                        <div class="col-md-12">
                                            <label for="stores_id" class="custom-label">
                                                <span>اختر المتجر المستهدف</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-shop-window"></i></span>
                                                <select name="stores_id" id="stores_id" class="form-select" required>
                                                    <option value="" disabled selected>اختر المتجر التابع له
                                                        الرسالة...</option>
                                                    @foreach ($stores ?? [] as $store)
                                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Sender Name -->
                                        <div class="col-md-6">
                                            <label for="name" class="custom-label">
                                                <span>اسم المرسل</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="مثال: أحمد محمد" required>
                                            </div>
                                        </div>

                                        <!-- Phone or Email -->
                                        <div class="col-md-6">
                                            <label for="phone_or_email" class="custom-label">
                                                <span>وسيلة الاتصال (هاتف أو بريد إلكتروني)</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="text" name="phone_or_email" id="phone_or_email"
                                                    class="form-control" placeholder="email@example.com أو رقم الهاتف"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: محتوى الرسالة -->
                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-chat-square-text"></i>
                                        <span>محتوى الرسالة والاستفسار</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Subject -->
                                        <div class="col-md-12">
                                            <label for="subject" class="custom-label">
                                                <span>موضوع الرسالة</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-bookmark"></i></span>
                                                <input type="text" name="subject" id="subject" class="form-control"
                                                    placeholder="مثال: استفسار حول توفر المنتج" required>
                                            </div>
                                        </div>

                                        <!-- Message Body -->
                                        <div class="col-md-12">
                                            <label for="message" class="custom-label">
                                                <span>نص الرسالة</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom align-items-start">
                                                <span class="input-group-text pt-3"><i
                                                        class="bi bi-text-paragraph"></i></span>
                                                <textarea name="message" id="message" class="form-control" rows="4"
                                                    placeholder="اكتب تفاصيل الاستفسار أو الرسالة هنا..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('contact-messages.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performStoreMessage()"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                    <span>حفظ وإرسال الرسالة</span>
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
        function performStoreMessage() {
            let formData = {
                stores_id: document.getElementById('stores_id').value,
                name: document.getElementById('name').value,
                phone_or_email: document.getElementById('phone_or_email').value,
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value,
            };

            axios.post('/cms/admin/contact-messages', formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم الإضافة بنجاح',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });

                    setTimeout(function() {
                        window.location.href = "{{ route('contact-messages.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    let message = 'حدث خطأ أثناء حفظ رسالة التواصل';
                    if (error.response && error.response.data) {
                        message = error.response.data.message || message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الحفظ',
                        text: message
                    });
                });
        }
    </script>
@endsection
