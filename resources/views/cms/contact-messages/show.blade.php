@extends('parent')

@section('title', 'تفاصيل رسالة التواصل | متجر رونق')
@section('main-title', 'رسائل العملاء')
@section('sub-title', 'عرض تفاصيل الاستفسار والبيانات المرتبطة بالرسالة الواردة')

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

        .info-group {
            background: #fafafa;
            border: 1px solid #f3e8ff;
            border-radius: 16px;
            padding: 1.25rem;
            height: 100%;
        }

        .info-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .info-value {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
        }

        .message-content-box {
            background: #fdf4ff;
            border: 1px dashed #fbcfe8;
            border-radius: 16px;
            padding: 1.5rem;
            color: #334155;
            font-size: 1rem;
            line-height: 1.8;
            white-space: pre-line;
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
            box-shadow: 0 2px 8px rgba(190, 24, 93, 0.06);
            transition: all 0.25s ease;
        }

        .btn-return-custom:hover {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border-color: transparent;
            transform: translateY(-2px);
        }

        /* زر التعديل الفاخر المطابق لتصميم المدينة */
        .btn-edit-custom {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.65rem 2rem;
            font-weight: 800;
            font-size: 0.95rem;
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
        }

        .btn-edit-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(190, 24, 93, 0.4);
            color: #ffffff;
        }

        .badge-status-select {
            border: 1.5px solid #fbcfe8;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            font-weight: 700;
            color: var(--rawnaq-dark-title);
            background-color: #fdf4ff;
            outline: none;
            transition: all 0.2s ease;
        }

        .badge-status-select:focus {
            border-color: #be185d;
            box-shadow: 0 0 0 3px rgba(190, 24, 93, 0.15);
        }
    </style>
@endsection

@section('content')
    <div class="messages-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card custom-card border-0">
                        <!-- Header -->
                        <div
                            class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light p-3 rounded-4 text-danger fs-3 shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">تفاصيل الرسالة الواردة
                                    </h4>
                                    <span class="text-muted small">رقم الرسالة: <span
                                            class="fw-semibold text-dark">#{{ $message->id }}</span></span>
                                </div>
                            </div>
                            <a href="{{ route('contact-messages.index') }}"
                                class="btn-return-custom d-flex align-items-center gap-2">
                                <i class="bi bi-arrow-right"></i>
                                <span>العودة للقائمة</span>
                            </a>
                        </div>

                        <hr class="m-0 text-muted opacity-25">

                        <!-- Body Content -->
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Sender Name -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-person text-danger"></i> اسم المرسل</div>
                                        <div class="info-value">{{ $message->name }}</div>
                                    </div>
                                </div>

                                <!-- Contact Info (Phone or Email) -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-envelope text-success"></i> وسيلة الاتصال
                                        </div>
                                        <div class="info-value" dir="ltr" style="text-align: right;">{{ $message->phone_or_email }}</div>
                                    </div>
                                </div>

                                <!-- Subject -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-bookmark text-primary"></i> موضوع الرسالة
                                        </div>
                                        <div class="info-value">{{ $message->subject }}</div>
                                    </div>
                                </div>

                                <!-- Target Store -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label"><i class="bi bi-shop text-warning"></i> المتجر المستهدف
                                        </div>
                                        <div class="info-value mt-1">
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                                {{ $message->store->name ?? 'غير محدد' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Body -->
                                <div class="col-12">
                                    <div class="info-group">
                                        <div class="info-label mb-2"><i class="bi bi-text-paragraph text-info"></i> نص
                                            الرسالة</div>
                                        <div class="message-content-box">
                                            {{ $message->message }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Updater -->
                                <div class="col-md-12">
                                    <div
                                        class="info-group d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div class="info-label mb-0"><i class="bi bi-flag text-danger"></i> حالة متابعة
                                            الرسالة:</div>
                                        <div class="d-flex align-items-center gap-2">
                                            <select id="message_status" class="badge-status-select"
                                                onchange="updateMessageStatus({{ $message->id }})">
                                                <option value="unread"
                                                    {{ $message->is_read === 'unread' ? 'selected' : '' }}>غير مقروءة
                                                </option>
                                                <option value="read" {{ $message->is_read === 'read' ? 'selected' : '' }}>
                                                    مقروءة</option>
                                                <option value="replied"
                                                    {{ $message->is_read === 'replied' ? 'selected' : '' }}>تم الرد عليها
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions: زر التعديل بتصميم مطابق لصفحة المدينة -->
                        <div class="card-footer bg-white border-top p-4 d-flex justify-content-end">
                            <a href="{{ route('contact-messages.edit', $message->id) }}" class="btn-edit-custom">
                                <i class="bi bi-pencil-square fs-5"></i>
                                <span>تعديل الرسالة</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateMessageStatus(id) {
            let status = document.getElementById('message_status').value;

            axios.put('/cms/admin/contact-messages/' + id + '/status', {
                    is_read: status
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.title || 'تم بنجاح',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: error.response?.data?.message || 'حدث خطأ أثناء تحديث حالة الرسالة.'
                    });
                });
        }
    </script>
@endsection
