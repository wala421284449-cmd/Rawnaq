<!doctype html>
<html lang="ar" dir="rtl">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>رونق || @yield('title')</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#be185d" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a0824" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="لوحة التحكم | متجر رونق" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="لوحة تحكم إدارية مبنية على Bootstrap 5، سريعة ومتوافقة مع المعايير الحديثة." />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('cms/css/adminlte.rtl.css') }}" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts (Cairo Font for Arabic)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --rawnaq-primary: #be185d;
            --rawnaq-primary-hover: #9d174d;
            --rawnaq-rose: #d946ef;
            --rawnaq-accent: #ec4899;
            --rawnaq-dark: #180820;
            --rawnaq-dark-soft: #230b2e;
            --rawnaq-sidebar-active: linear-gradient(135deg, #be185d 0%, #a21caf 100%);
            /* تعديل لون خلفية الشاشة الكبيرة ليصبح بدرجات الزهري البارد الهادئ */
            --rawnaq-bg-cool-rose: #fef6fa;
        }

        body,
        * {
            font-family: 'Cairo', sans-serif !important;
        }

        /* تغيير خلفية الصفحة الكبيرة بالكامل إلى الزهري البارد الهادئ بدلاً من الأبيض أو الأزرق */
        body {
            background-color: var(--rawnaq-bg-cool-rose) !important;
        }

        .app-main {
            background-color: var(--rawnaq-bg-cool-rose) !important;
        }

        .app-content {
            background-color: var(--rawnaq-bg-cool-rose) !important;
        }

        /* التحكم في إظهار وإخفاء زر الثلاث شرطات */
        body.sidebar-open [data-lte-toggle="sidebar"],
        body:not(.sidebar-collapse) [data-lte-toggle="sidebar"]:not(.sidebar-close-btn) {
            display: none !important;
        }

        body.sidebar-collapse [data-lte-toggle="sidebar"]:not(.sidebar-close-btn) {
            display: inline-block !important;
        }

        /* الهيدر العلوي */
        .app-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #fce7f3 !important;
            box-shadow: 0 2px 10px rgba(190, 24, 93, 0.03);
        }

        .app-header .nav-link {
            color: #4a044e !important;
            font-weight: 600;
        }

        .app-header .nav-link:hover {
            color: var(--rawnaq-primary) !important;
        }

        /* الشريط الجانبي (Sidebar) */
        .app-sidebar {
            background: linear-gradient(180deg, var(--rawnaq-dark) 0%, var(--rawnaq-dark-soft) 100%) !important;
            border-left: 1px solid rgba(254, 205, 232, 0.1) !important;
        }

        .sidebar-brand {
            background-color: rgba(24, 8, 32, 0.95) !important;
            border-bottom: 1px solid rgba(244, 114, 182, 0.15) !important;
            height: 60px;
        }

        .sidebar-brand .brand-link {
            color: #fdf2f8 !important;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        .sidebar-brand .brand-text {
            color: #ffffff !important;
            font-size: 1.25rem;
            font-weight: 800;
        }

        .sidebar-close-btn {
            color: #f472b6 !important;
            opacity: 0.85;
            transition: 0.2s ease;
            text-decoration: none;
        }

        .sidebar-close-btn:hover {
            opacity: 1;
            color: #ffffff !important;
        }

        /* عناصر القائمة الجانبية */
        .sidebar-wrapper .nav-header {
            color: #f472b6 !important;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding-top: 1rem;
        }

        .sidebar-wrapper .nav-link {
            color: #e2e8f0 !important;
            font-weight: 500;
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.2s ease;
        }

        .sidebar-wrapper .nav-link:hover {
            background-color: rgba(236, 72, 153, 0.15) !important;
            color: #ffffff !important;
        }

        .sidebar-wrapper .nav-link.active {
            background: var(--rawnaq-sidebar-active) !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(190, 24, 93, 0.35);
        }

        .sidebar-wrapper .nav-icon {
            color: #f472b6 !important;
        }

        .sidebar-wrapper .nav-link.active .nav-icon {
            color: #ffffff !important;
        }

        /* نافذة المستخدم المنسدلة */
        .user-menu .user-header {
            background: linear-gradient(135deg, #be185d 0%, #86198f 100%) !important;
            color: #ffffff !important;
        }

        /* أزرار الإجراءات والروابط */
        .btn-primary {
            background: linear-gradient(135deg, #be185d 0%, #a21caf 100%) !important;
            border-color: #be185d !important;
            box-shadow: 0 4px 12px rgba(190, 24, 93, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #9d174d 0%, #86198f 100%) !important;
            border-color: #9d174d !important;
        }

        /* التذييل (Footer) */
        .app-footer {
            background-color: #ffffff !important;
            border-top: 1px solid #fce7f3 !important;
            color: #701a75 !important;
            font-size: 0.875rem;
        }

        .app-footer a {
            color: var(--rawnaq-primary) !important;
            font-weight: 700;
        }

        /* شارات التنبيهات */
        .navbar-badge.badge.text-bg-danger {
            background-color: #be185d !important;
        }

        .navbar-badge.badge.text-bg-warning {
            background-color: #f59e0b !important;
            color: #ffffff !important;
        }

        /* الـ Breadcrumb والمحتوى الرئيسي */
        .app-content-header h3 {
            color: #4a044e;
            font-weight: 700;
        }

        .breadcrumb-item a {
            color: var(--rawnaq-primary);
            text-decoration: none;
        }
    </style>
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE RTL)-->
    <link rel="stylesheet" href="{{ asset('cms/css/adminlte.rtl.css') }}"
        onerror="this.onerror=null;this.href='{{ asset('cms/css/adminlte.css') }}';" />
    <!--end::Required Plugin(AdminLTE RTL)-->

    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
    <!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />
    @yield('styles')
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list fs-5"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">الرئيسية</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">تواصل معنا</a></li>
                </ul>
                <!--end::Start Navbar Links-->

                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::Navbar Search-->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            <i class="bi bi-search"></i>
                        </a>
                        <!-- قائمة البحث المنسدلة السريعة -->
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3 border-0 shadow-lg mt-2"
                            style="width: 300px; border-radius: 1rem;" dir="rtl">
                            <form action="{{ route('products.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control form-control-sm border-0 bg-light"
                                        placeholder="ابحث عن منتج، رمز SKU...">
                                    <button class="btn btn-outline-secondary btn-sm border-0" type="submit"
                                        style="background-color: rgba(var(--rawnaq-primary-rgb, 219, 39, 119), 0.1); color: var(--rawnaq-primary);">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!--end::Navbar Search-->

                    <!--begin::Notifications Dropdown Menu (جرس التنبيهات الحقيقي والفعال) -->
                    <!--begin::Notifications Dropdown Menu (تصميم احترافي متناسق) -->
                    <li class="nav-item dropdown px-2">
                        <a class="nav-link dropdown-toggle position-relative hide-arrow d-flex align-items-center justify-content-center"
                            href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="width: 40px; height: 40px;">

                            <!-- أيقونة الجرس -->
                            <i class="bi bi-bell-fill fs-5" style="color: var(--rawnaq-primary);"></i>

                            <!-- عداد الإشعارات غير المقروءة -->
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="position-absolute translate-middle badge rounded-pill bg-danger border border-white"
                                    style="top: 8px; left: 8px; font-size: 0.6rem; padding: 0.3em 0.5em; min-width: 18px;">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <!-- القائمة المنسدلة لعرض الإشعارات -->
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-3"
                            aria-labelledby="notificationDropdown" style="width: 360px; border-radius: 1rem;"
                            dir="rtl">

                            <!-- هيدر القائمة -->
                            <li
                                class="dropdown-header fw-bold text-dark d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom px-0">
                                <span class="fs-6 text-dark fw-bold">التنبيهات الواردة</span>
                                <span class="badge px-2 py-1"
                                    style="font-size: 0.75rem; border-radius: 6px; background-color: rgba(var(--rawnaq-primary-rgb, 219, 39, 119), 0.1); color: var(--rawnaq-primary);">
                                    {{ auth()->user()->unreadNotifications->count() }} جديد
                                </span>
                            </li>

                            <!-- محتوى الإشعارات -->
                            <div style="max-height: 300px; overflow-y: auto;" class="ps-1">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li class="mb-2">
                                        <div class="p-3 rounded-4 bg-light border-0 text-wrap d-flex flex-column gap-2 shadow-sm"
                                            style="background: #fdf2f8 !important; border: 1px solid rgba(var(--rawnaq-primary-rgb, 219, 39, 119), 0.15) !important;">

                                            <!-- عنوان الإشعار مع الأيقونة -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fw-bold text-dark d-flex align-items-center gap-1"
                                                    style="font-size: 0.85rem;">
                                                    <i class="bi bi-circle-fill"
                                                        style="font-size: 6px; color: var(--rawnaq-primary);"></i>
                                                    <span
                                                        style="color: var(--rawnaq-primary);">{{ $notification->data['title'] ?? 'تنبيه جديد' }}</span>
                                                </div>
                                                <small class="text-muted" style="font-size: 0.68rem;">
                                                    <i
                                                        class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>

                                            <!-- نص الرسالة -->
                                            <div class="text-secondary text-end px-1"
                                                style="font-size: 0.78rem; line-height: 1.4;">
                                                {{ $notification->data['message'] ?? '' }}
                                            </div>

                                            <!-- زر تحديد كمقروء -->
                                            <div
                                                class="d-flex justify-content-end align-items-center pt-1 border-top border-light-subtle mt-1">
                                                <form
                                                    action="{{ route('admin.notifications.read', $notification->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-link btn-sm text-decoration-none p-0 fw-bold d-flex align-items-center gap-1"
                                                        style="font-size: 0.72rem; color: var(--rawnaq-primary);">
                                                        <span>تحديد كمقروء</span>
                                                        <i class="bi bi-check2-all fs-6"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center py-4 text-muted">
                                        <i class="bi bi-bell-slash fs-2 text-secondary opacity-50 mb-2 d-block"></i>
                                        <span class="small">لا توجد إشعارات جديدة حالياً</span>
                                    </li>
                                @endforelse
                            </div>
                        </ul>
                    </li>
                    <!--end::Notifications Dropdown Menu-->
                    <!--end::Notifications Dropdown Menu-->
                    <!--end::Messages Dropdown Menu-->

                    <!--begin::Fullscreen Toggle-->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <!--end::Fullscreen Toggle-->

                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 text-secondary"></i>
                            <span class="d-none d-md-inline ms-1">{{ auth()->user()->name ?? 'المستخدم' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Header-->
                            <li class="user-header">
                                <i class="bi bi-person-circle display-4"></i>
                                <p class="mt-2">
                                    {{ auth()->user()->name ?? 'المستخدم الحالي' }}
                                    <small>{{ auth()->user()->email ?? '' }}</small>
                                </p>
                            </li>
                            <!--end::User Header-->
                            <!--begin::Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">الملف الشخصي</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="post"
                                    class="float-end">
                                    @csrf
                                    <button type="submit" class="btn btn-default btn-flat text-danger">تسجيل
                                        الخروج</button>
                                </form>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->

        <!--begin::Sidebar-->
        <aside class="app-sidebar shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand d-flex align-items-center justify-content-between px-3">
                <a href="{{ url('/') }}" class="brand-link d-flex align-items-center gap-2">
                    <i class="bi bi-gem text-pink fs-4"></i>
                    <span class="brand-text">متجر رونق</span>
                </a>
                <!-- زر إغلاق القائمة من الداخل عند فتحها -->
                <button type="button" class="btn btn-link sidebar-close-btn p-0" data-lte-toggle="sidebar"
                    title="إغلاق القائمة">
                    <i class="bi bi-x-lg fs-5"></i>
                </button>
            </div>
            <!--end::Sidebar Brand-->

            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                        aria-label="القائمة الرئيسية" data-accordion="false" id="navigation">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    لوحة التحكم
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon bi bi-house-door"></i>
                                        <p>الصفحة الرئيسية</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @canany(['Index Role', 'Create Role', 'Index Permission', 'Create Permission'])
                            <li class="nav-header">الأدوار والصلاحيات</li>
                        @endcanany

                        <li class="nav-item">
                            @canany(['Index Role', 'Create Role'])
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-person-badge"></i>
                                    <p>
                                        الأدوار
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                            @endcanany

                            <ul class="nav nav-treeview">
                                @can('Index Role')
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link">
                                            <i class="nav-icon bi bi-list-task"></i>
                                            <p>قائمة الأدوار</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('Create Role')
                                    <li class="nav-item">
                                        <a href="{{ route('roles.create') }}" class="nav-link">
                                            <i class="nav-icon bi bi-plus-circle"></i>
                                            <p>إضافة دور</p>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </li>

                        <li class="nav-item">
                            @canany(['Index Permission', 'Create Permission'])
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-shield-lock"></i>
                                    <p>
                                        الصلاحيات
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                            @endcanany

                            <ul class="nav nav-treeview">
                                @can('Index Permission')
                                    <li class="nav-item">
                                        <a href="{{ route('permissions.index') }}" class="nav-link">
                                            <i class="nav-icon bi bi-list-task"></i>
                                            <p>قائمة الصلاحيات</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('Create Permission')
                                    <li class="nav-item">
                                        <a href="{{ route('permissions.create') }}" class="nav-link">
                                            <i class="nav-icon bi bi-plus-circle"></i>
                                            <p>إضافة صلاحية</p>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                        @canany(['Index Admin', 'Create Admin', 'Index Customer', 'Create Customer', 'Index Owner',
                            'Create Owner', 'Index ContactMessage', 'Create ContactMessage'])
                            <li class="nav-header">إدارة المستخدمين</li>
                        @endcanany

                        @canany(['Index Admin', 'Create Admin'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>
                                        المشرفين
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Admin')
                                        <li class="nav-item">
                                            <a href="{{ route('admins.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض المشرفين</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create Admin')
                                        <li class="nav-item">
                                            <a href="{{ route('admins.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p>إضافة مشرف</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>

                        @endcanany

                        @canany(['Index Customer', 'Create Customer'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-person-badge-fill nav-icon"></i>
                                    <p>
                                        الزبائن
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Customer')
                                        <li class="nav-item">
                                            <a href="{{ route('customers.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض الزبائن</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create Customer')
                                        <li class="nav-item">
                                            <a href="{{ route('customers.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p>إضافة زبون</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany

                        @canany(['Index Owner', 'Create Owner'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-person-workspace nav-icon"></i>
                                    <p>
                                        الملاك
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Owner')
                                        <li class="nav-item">
                                            <a href="{{ route('owners.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض الملاك</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create Owner')
                                        <li class="nav-item">
                                            <a href="{{ route('owners.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p>إضافة مالك</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany

                        @canany([
                            'Index City',
                            'Create City',
                            'Index Address',
                            'Create Address',
                            'Index Store',
                            'Create
                            Store',
                            'Index MediaGallery',
                            'Create MediaGallery',
                            'Index category',
                            'Create category',
                            'Index service',
                            'Create service',
                            'Index product',
                            'Create product',
                            'Index Offer',
                            'Create Offer',
                            'Index Order',
                            'Create Order',
                            'Index Review',
                            'Create Review',
                            ])
                            <li class="nav-header">إدارة المحتوى</li>
                        @endcanany

                        @canany(['Index City', 'Create City'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-globe-americas"></i>
                                    <p>
                                        المدن
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index City')
                                        <li class="nav-item">
                                            <a href="{{ route('cities.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض المدن</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create City')
                                        <li class="nav-item">
                                            <a href="{{ route('cities.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p>إضافة مدينة</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany

                        @canany(['Index Address', 'Create Address'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-geo-alt-fill nav-icon"></i>
                                    <p>
                                        العناوين
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Address')
                                        <li class="nav-item">
                                            <a href="{{ route('addresses.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض العناوين</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create Address')
                                        <li class="nav-item">
                                            <a href="{{ route('addresses.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p>إضافة عنوان</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index Store', 'Create Store'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-shop" style="color: #e83e8c; margin-left: 8px;"></i>
                                    <p>
                                        المتاجر
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Store')
                                        <li class="nav-item">
                                            <a href="{{ route('stores.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض المتاجر</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create Store')
                                        <li class="nav-item">
                                            <a href="{{ route('stores.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p>إضافة المتاجر</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index MediaGallery', 'Create MediaGallery'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-images" style="color: #e83e8c;"></i>
                                    <p>
                                        معرض الصور والملفات
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index MediaGallery')
                                        <li class="nav-item">
                                            <a href="{{ route('media-galleries.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض معرض الصور والملفات</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create MediaGallery')
                                        <li class="nav-item">
                                            <a href="{{ route('media-galleries.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p>إضافة معرض الصور والملفات</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index ContactMessage', 'Create ContactMessage'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-envelope" style="color: #e83e8c;"></i>
                                    <p>
                                        رسائل التواصل
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index ContactMessage')
                                        <li class="nav-item">
                                            <a href="{{ route('contact-messages.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض رسائل التواصل </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create ContactMessage')
                                        <li class="nav-item">
                                            <a href="{{ route('contact-messages.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p> انشاء رسالة تواصل </p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index category', 'Create category'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-list-nested" style="color: #e83e8c;"></i>
                                    <p>
                                        التصنيفات
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index category')
                                        <li class="nav-item">
                                            <a href="{{ route('categories.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض التصنيفات </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create category')
                                        <li class="nav-item">
                                            <a href="{{ route('categories.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p> انشاء تصنيف </p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index service', 'Create service'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-gear" style="color: #e83e8c;"></i>
                                    <p>
                                        الخدمات
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index service')
                                        <li class="nav-item">
                                            <a href="{{ route('services.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض الخدمات </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create service')
                                        <li class="nav-item">
                                            <a href="{{ route('services.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p> انشاء خدمة </p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index product', 'Create product'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-box-seam" style="color: #e83e8c;"></i>
                                    <p>
                                        المنتجات
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index product')
                                        <li class="nav-item">
                                            <a href="{{ route('products.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض المنتجات </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create product')
                                        <li class="nav-item">
                                            <a href="{{ route('products.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p> انشاء المنتجات </p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index Offer', 'Create Offer'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-percent" style="color: #e83e8c;"></i>
                                    <p>
                                        العروض
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Offer')
                                        <li class="nav-item">
                                            <a href="{{ route('offers.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض العروض </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create Offer')
                                        <li class="nav-item">
                                            <a href="{{ route('offers.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p> انشاء عروض </p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index Order', 'Create Order'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-cart-check" style="color: #e83e8c;"></i>
                                    <p>
                                        الطلبات
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Order')
                                        <li class="nav-item">
                                            <a href="{{ route('orders.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض الطلبات </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create Order')
                                        <li class="nav-item">
                                            <a href="{{ route('orders.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p> انشاء طلب </p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['Index Review', 'Create Review'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="bi bi-star" style="color: #e83e8c;"></i>
                                    <p>
                                        التقييمات
                                        <i class="nav-arrow bi bi-chevron-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Index Review')
                                        <li class="nav-item">
                                            <a href="{{ route('reviews.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-list-task"></i>
                                                <p>عرض التقييمات </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Create Review')
                                        <li class="nav-item">
                                            <a href="{{ route('reviews.create') }}" class="nav-link">
                                                <i class="nav-icon bi bi-plus-circle"></i>
                                                <p> انشاء تقييم </p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany

                        <li class="nav-header">الإعدادات</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-key"></i>
                                <p>تغيير كلمة المرور</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>تعديل الملف الشخصي</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-person"></i>
                                <p>الملف الشخصي</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="post" class="float-end">
                                @csrf
                                <button type="submit" class="btn btn-default btn-flat text-danger">تسجيل
                                    الخروج</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->

        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('main-title')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('sub-title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content Header-->

            <!--begin::App Content-->
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->

        <!--begin::Footer-->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline"> الإصدار {{ env('APP_VERSION', '1.0.0') }}</div>
            <strong>
                جميع الحقوق محفوظة &copy; {{ now()->year }}
                <a href="#" class="text-decoration-none">{{ env('APP_NAME', 'رونق') }}</a>.
            </strong>
        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Script-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('cms/js/adminlte.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/crud.js') }}"></script>

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!-- استدعاء مكتبة Laravel Echo و Pusher JS عبر CDN لتعمل فوراً -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <script>
        // تهيئة اتصال Laravel Echo باستخدام إعدادات Reverb
        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: '{{ env('VITE_REVERB_APP_KEY', 'skea777tuabbv5igotcy') }}',
            wsHost: '{{ env('VITE_REVERB_HOST', 'localhost') }}',
            wsPort: {{ env('VITE_REVERB_PORT', 8080) }},
            wssPort: {{ env('VITE_REVERB_PORT', 8080) }},
            forceTLS: (('{{ env('VITE_REVERB_SCHEME', 'http') }}') === 'https'),
            enabledTransports: ['ws', 'wss'],
        });
        // استماع المستخدم الحالي لقناته الخاصة فور تسجيل دخوله
        @if (auth()->check())
            window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
                .notification((notification) => {
                    console.log('تم استقبال إشعار لحظي:', notification);

                    // 1. زيادة رقم العداد في الجرس تلقائياً
                    let badge = document.querySelector('.badge.bg-danger');
                    if (badge) {
                        let currentCount = parseInt(badge.innerText) || 0;
                        badge.innerText = currentCount + 1;
                    } else {
                        let bellIcon = document.querySelector('#notificationDropdown');
                        if (bellIcon) {
                            let newBadge = document.createElement('span');
                            newBadge.className =
                                'position-absolute translate-middle badge rounded-pill bg-danger border border-white';
                            newBadge.style.cssText =
                                'top: 8px; left: 8px; font-size: 0.6rem; padding: 0.3em 0.5em; min-width: 18px;';
                            newBadge.innerText = '1';
                            bellIcon.appendChild(newBadge);
                        }
                    }

                    // 2. إظهار تنبيه خفيف (Toast أو Alert بسيط)
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: notification.title || 'تنبيه جديد',
                            text: notification.message || 'وصلك إشعار لحظي جديد',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });
                    }
                });
        @endif
    </script> <!-- التصحيح هنا -->
    <!--end::Script-->
    @yield('scripts')
</body>
<!--end::Body-->

</html>
