@extends('parent')

@section('title', 'تعديل رسالة التواصل | متجر رونق')
@section('main-title', 'رسائل العملاء')
@section('sub-title', 'تعديل وتحديث بيانات رسالة التواصل الواردة للمتجر')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-dark-title: #4a044e;
        }

        .messages-wrapper {
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
    <div class="messages-wrapper py-3" dir="rtl">
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
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تعديل رسالة التواصل
                                    </h5>
                                    <small class="text-muted">تحديث بيانات رسالة الاستفسار أو تغيير حالتها</small>
                                </div>
                            </div>
                            <a href="{{ route('contact-messages.index') }}"
                                class="btn-cancel-custom d-flex align-items-center gap-2">
                                <i class="bi bi-arrow-right"></i>
                                <span>العودة للقائمة</span>
                            </a>
                        </div>

                        <!-- Form -->
                        <form id="update_message_form">
                            @csrf
                            @method('PUT')
                            <div class="p-4">

                                <div class="section-box">
                                    <div class="section-badge">
                                        <i class="bi bi-info-circle"></i>
                                        <span>معلومات المرسل والرسالة</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Store Selection -->
                                        <div class="col-md-12">
                                            <label for="stores_id" class="custom-label">
                                                <span>المتجر المستهدف</span>
                                                <span class="badge-req">مطلوب</span>
                                            </label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                                <select name="stores_id" id="stores_id" class="form-select" required>
                                                    @foreach ($stores ?? [] as $store)
                                                        <option value="{{ $store->id }}"
                                                            {{ $message->stores_id == $store->id ? 'selected' : '' }}>
                                                            {{ $store->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <label for="name" class="custom-label"><span>اسم المرسل</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="{{ $message->name }}" required>
                                            </div>
                                        </div>

                                        <!-- Phone or Email -->
                                        <div class="col-md-6">
                                            <label for="phone_or_email" class="custom-label"><span>وسيلة
                                                    الاتصال</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="text" name="phone_or_email" id="phone_or_email"
                                                    class="form-control" value="{{ $message->phone_or_email }}" required>
                                            </div>
                                        </div>

                                        <!-- Subject -->
                                        <div class="col-md-12">
                                            <label for="subject" class="custom-label"><span>موضوع الرسالة</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-bookmark"></i></span>
                                                <input type="text" name="subject" id="subject" class="form-control"
                                                    value="{{ $message->subject }}" required>
                                            </div>
                                        </div>

                                        <!-- Message Body -->
                                        <div class="col-md-12">
                                            <label for="message" class="custom-label"><span>نص الرسالة</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-text-paragraph"></i></span>
                                                <textarea name="message" id="message" class="form-control" rows="4" required>{{ $message->message }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-12">
                                            <label for="is_read" class="custom-label"><span>حالة القراءة</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                                <select name="is_read" id="is_read" class="form-select" required>
                                                    <option value="unread"
                                                        {{ $message->is_read === 'unread' ? 'selected' : '' }}>غير مقروءة
                                                    </option>
                                                    <option value="read"
                                                        {{ $message->is_read === 'read' ? 'selected' : '' }}>مقروءة</option>
                                                    <option value="replied"
                                                        {{ $message->is_read === 'replied' ? 'selected' : '' }}>تم الرد
                                                        عليها</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('contact-messages.index') }}" class="btn-cancel-custom">إلغاء الأمر</a>
                                <button type="button" onclick="performUpdateMessage({{ $message->id }})"
                                    class="btn-save-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                    <span>حفظ التعديلات</span>
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
        function performUpdateMessage(id) {
            let formData = {
                stores_id: document.getElementById('stores_id').value,
                name: document.getElementById('name').value,
                phone_or_email: document.getElementById('phone_or_email').value,
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value,
                is_read: document.getElementById('is_read').value,
            };

            axios.put('/cms/admin/contact-messages/' + id, formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم التحديث بنجاح',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });

                    setTimeout(function() {
                        window.location.href = "{{ route('contact-messages.index') }}";
                    }, 1200);
                })
                .catch(function(error) {
                    let message = 'حدث خطأ أثناء تحديث الرسالة';
                    if (error.response && error.response.data) {
                        message = error.response.data.message || message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في التعديل',
                        text: message
                    });
                });
        }
    </script>
@endsection
