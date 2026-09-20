@extends('parent')
@section('title', 'صلاحيات المسمى الوظيفي: ' . $role->name . ' | متجر رونق')
@section('main-title', 'إدارة المسميات الوظيفية')
@section('sub-title', 'تخصيص وإدارة الصلاحيات المرتبطة بالدور')

@section('styles')
    <style>
        :root {
            --rawnaq-gradient: linear-gradient(135deg, #e11d48 0%, #be185d 50%, #9333ea 100%);
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-dark-title: #4a044e;
            --rawnaq-border: #f1f5f9;
        }

        .role-perms-wrapper {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        /* كرت النموذج الرئيسي الفاخر */
        .custom-form-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 15px 35px -5px rgba(190, 24, 93, 0.08), 0 0 15px 0 rgba(147, 51, 234, 0.03);
            overflow: hidden;
            position: relative;
        }

        /* شريط علوي ملون */
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
            border-bottom: 1px solid #fce7f3;
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

        /* بطاقات الصلاحيات الفرعية */
        .permission-item-box {
            background: #fafafa;
            border: 1.5px solid #f3e8ff;
            border-radius: 16px;
            padding: 1.1rem 1.25rem;
            transition: all 0.25s ease;
        }

        .permission-item-box:hover {
            background: #ffffff;
            border-color: #fbcfe8;
            box-shadow: 0 6px 18px rgba(190, 24, 93, 0.04);
            transform: translateY(-2px);
        }

        /* تخصيص الـ Checkbox / Switch بلون رونق */
        .form-check-input:checked {
            background-color: #be185d;
            border-color: #be185d;
        }

        .form-check-input:focus {
            border-color: #d946ef;
            box-shadow: 0 0 0 4px rgba(217, 70, 239, 0.15);
        }

        /* الأزرار الفاخرة */
        .btn-save-custom {
            background: var(--rawnaq-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.65rem 2.5rem;
            font-size: 0.95rem;
            font-weight: 800;
            color: #ffffff;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.35);
            transition: all 0.25s ease;
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
            padding: 0.65rem 1.8rem;
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

        .form-footer {
            background: linear-gradient(to right, #ffffff, #fdf4ff);
            border-top: 1px solid #fce7f3;
            padding: 1.25rem 2rem;
            border-radius: 0 0 24px 24px;
        }
    </style>
@endsection

@section('content')
    <div class="role-perms-wrapper py-3" dir="rtl">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-10">

                    <div class="card custom-form-card border-0">
                        <!-- Header -->
                        <div class="form-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-box">
                                    <i class="bi bi-shield-shaded"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--rawnaq-dark-title);">
                                        صلاحيات المسمى الوظيفي: <span class="text-primary">{{ $role->name }}</span>
                                    </h5>
                                    <small class="text-muted">تحديد وتفعيل الصلاحيات البرمجية المرتبطة بهذا الدور</small>
                                </div>
                            </div>
                            <span class="badge px-3 py-2 fw-bold"
                                style="background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%); color: #be185d; border: 1px solid #fbcfe8; font-size: 0.85rem; border-radius: 10px;">
                                <i class="bi bi-lock-fill"></i> النطاق: {{ $role->guard_name }}
                            </span>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('roles.update-permissions', $role->id) }}" method="POST">
                            @csrf
                            <div class="p-4">

                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">اختر الصلاحيات المطلوبة
                                        لتفعيلها لهذا الدور:</span>
                                    <span class="text-muted small">إجمالي الصلاحية المتاحة بالنطاق:
                                        {{ count($permissions) }}</span>
                                </div>
                                <hr class="mt-0 mb-4" style="border-color: #fce7f3;">

                                <div class="row g-3">
                                    @forelse($permissions as $permission)
                                        <div class="col-md-4 col-lg-3">
                                            <div
                                                class="permission-item-box d-flex align-items-center justify-content-between">
                                                <div
                                                    class="form-check form-switch m-0 d-flex align-items-center gap-2 w-100 cursor-pointer">
                                                    <input class="form-check-input fs-5 ms-0" type="checkbox"
                                                        name="permissions[]" value="{{ $permission->name }}"
                                                        id="perm_{{ $permission->id }}"
                                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                                        style="cursor: pointer;">
                                                    <label class="form-check-label fw-bold text-dark m-0"
                                                        for="perm_{{ $permission->id }}"
                                                        style="cursor: pointer; font-size: 0.88rem;">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-5">
                                            <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: #fdf2f8;">
                                                <i class="bi bi-shield-slash fs-1 text-danger"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark">لا توجد صلاحيات مسجلة لهذا النطاق حالياً</h6>
                                            <p class="text-muted small mb-0">يرجى إضافة صلاحيات جديدة بنطاق
                                                <strong>{{ $role->guard_name }}</strong> أولاً.</p>
                                        </div>
                                    @endforelse
                                </div>

                            </div>

                            <!-- Footer Actions -->
                            <div class="form-footer d-flex justify-content-between align-items-center">
                                <a href="{{ route('roles.index') }}"
                                    class="btn-cancel-custom d-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-right"></i>
                                    <span>إلغاء والعودة</span>
                                </a>
                                <button type="submit"
                                    class="btn-save-custom d-flex align-items-center gap-2 {{ $permissions->isEmpty() ? 'disabled' : '' }}">
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
