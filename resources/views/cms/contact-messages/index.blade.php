@extends('parent')

@section('title', 'إدارة رسائل التواصل | متجر رونق')
@section('main-title', 'رسائل العملاء')
@section('sub-title', 'عرض ومتابعة رسائل واستفسارات العملاء الواردة للمتاجر')

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

        .card-header-custom {
            background: linear-gradient(to left, #ffffff, #fdf4ff);
            border-bottom: 1px solid #f8fafc;
            padding: 1.75rem 2rem;
        }

        .btn-add-custom {
            background: var(--rawnaq-gradient);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.65rem 1.6rem;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            transition: all 0.25s ease;
        }

        .btn-add-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(190, 24, 93, 0.4);
            color: #ffffff;
        }

        .table-custom th {
            background-color: #fdf4ff;
            color: var(--rawnaq-dark-title);
            font-weight: 800;
            font-size: 0.88rem;
            border-bottom: 2px solid #fbcfe8;
            padding: 1.1rem;
            text-align: right;
        }

        .table-custom td {
            vertical-align: middle;
            padding: 1.1rem;
            font-size: 0.9rem;
            color: #334155;
            border-bottom: 1px solid #f8fafc;
            text-align: right;
        }

        .badge-status {
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-unread {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .badge-read {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .badge-replied {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-show {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .btn-edit {
            background-color: #fef3c7;
            color: #d97706;
        }

        .btn-delete {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <div class="messages-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="card custom-card border-0">
                <!-- Header -->
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">قائمة رسائل التواصل والاستفسارات
                        </h4>
                        <p class="text-muted mb-0 small">البيانات الأساسية لرسائل العملاء وشركاء متجر رونق وحالة التفاعل</p>
                    </div>

                    <div>
                        <a href="{{ route('contact-messages.create') }}" class="btn-add-custom">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                            <span>إنشاء رسالة تواصل</span>
                        </a>
                    </div>
                </div>

                <!-- Table Body -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th>المرسل</th>
                                    <th>وسيلة الاتصال</th>
                                    <th>الموضوع</th>
                                    <th>المتجر المستهدف</th>
                                    <th class="text-center">الحالة</th>
                                    <th class="text-center" style="width: 150px;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($messages as $msg)
                                    <tr>
                                        <td class="fw-bold text-center">#{{ $msg->id }}</td>
                                        <td class="fw-bold text-dark">{{ $msg->name }}</td>
                                        <td class="text-muted" dir="ltr" style="text-align: right;">
                                            {{ $msg->phone_or_email }}</td>
                                        <td>{{ Str::limit($msg->subject, 30) }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                                {{ $msg->store->name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($msg->is_read === 'unread')
                                                <span class="badge-status badge-unread">غير مقروءة</span>
                                            @elseif($msg->is_read === 'read')
                                                <span class="badge-status badge-read">مقروءة</span>
                                            @else
                                                <span class="badge-status badge-replied">تم الرد</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- زر العرض -->
                                                <a href="{{ route('contact-messages.show', $msg->id) }}"
                                                    class="action-btn btn-show" title="عرض الرسالة">
                                                    <i class="bi bi-eye fs-6"></i>
                                                </a>
                                                <!-- زر التعديل المضاف -->
                                                <a href="{{ route('contact-messages.edit', $msg->id) }}"
                                                    class="action-btn btn-edit" title="تعديل الرسالة">
                                                    <i class="bi bi-pencil fs-6"></i>
                                                </a>
                                                <!-- زر الحذف -->
                                                <button type="button" onclick="confirmDeleteMessage({{ $msg->id }})"
                                                    class="action-btn btn-delete" title="حذف">
                                                    <i class="bi bi-trash fs-6"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-5 text-center text-muted">
                                            <i
                                                class="bi bi-chat-square-text fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                            لا توجد رسائل تواصل واردة حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if (isset($messages) && method_exists($messages, 'hasPages') && $messages->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDeleteMessage(id) {
            Swal.fire({
                title: 'هل أنت متأكد من الحذف؟',
                text: "لن يمكنك استعادة هذه الرسالة بعد حذفها!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، قم بالحذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/cms/admin/contact-messages/' + id)
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحذف!',
                                text: response.data.message || 'تم حذف الرسالة بنجاح.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1200);
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
