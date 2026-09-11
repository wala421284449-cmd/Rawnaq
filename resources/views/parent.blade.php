<!doctype html>
<html lang="ar" dir="rtl">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>رونق || @yield('title')</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="لوحة التحكم | AdminLTE v4" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="لوحة تحكم إدارية مبنية على Bootstrap 5، سريعة ومتوافقة مع المعايير الحديثة." />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('cms/css/adminlte.rtl.css') }}" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts (Cairo Font for Arabic)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body,
        * {
            font-family: 'Cairo', sans-serif !important;
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

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
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
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">الرئيسية</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">تواصل معنا</a></li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::Navbar Search-->
                    <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                    <!--end::Navbar Search-->

                    <!--begin::Messages Dropdown Menu-->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-chat-text"></i>
                            <span class="navbar-badge badge text-bg-danger">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-2 text-center text-secondary">
                            <span>لا توجد رسائل جديدة</span>
                        </div>
                    </li>
                    <!--end::Messages Dropdown Menu-->

                    <!--begin::Notifications Dropdown Menu-->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i>
                            <span class="navbar-badge badge text-bg-warning">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-2 text-center text-secondary">
                            <span>لا توجد إشعارات جديدة</span>
                        </div>
                    </li>
                    <!--end::Notifications Dropdown Menu-->

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
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-none d-md-inline ms-1">{{ auth()->user()->name ?? 'المستخدم' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Header-->
                            <li class="user-header text-bg-primary">
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
                                <a href="#" class="btn btn-default btn-flat float-end text-danger">تسجيل
                                    الخروج</a>
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
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <a href="{{ url('/') }}" class="brand-link">
                    <img src="{{ asset('cms/assets/img/AdminLTELogo.png') }}" alt="Logo"
                        class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light">رونق</span>
                </a>
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

                        <li class="nav-header">الأدوار والصلاحيات</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-person-badge"></i>
                                <p>
                                    الأدوار
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon bi bi-list-task"></i>
                                        <p>قائمة الأدوار</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>إضافة دور</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-shield-lock"></i>
                                <p>
                                    الصلاحيات
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon bi bi-list-task"></i>
                                        <p>قائمة الصلاحيات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>إضافة صلاحية</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header">إدارة المستخدمين</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>
                                    المشرفين
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admins.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-list-task"></i>
                                        <p>عرض المشرفين</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admins.create') }}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>إضافة مشرف</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="bi bi-person-badge-fill"></i>
                                <p>
                                    الزبائن
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('customers.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-list-task"></i>
                                        <p>عرض الزبائن</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('customers.create') }}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>إضافة زبون</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="bi bi-person-workspace text-primary"></i>
                                <p>
                                    الملاك
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('owners.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-list-task"></i>
                                        <p>عرض الملاك</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('owners.create') }}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>إضافة مالك</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header">إدارة المحتوى</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-globe-americas"></i>
                                <p>
                                    المدن
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('cities.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-list-task"></i>
                                        <p>عرض المدن</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cities.create') }}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>إضافة مدينة</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="bi bi-geo-alt-fill"></i>
                                <p>
                                    العناوين
                                    <i class="nav-arrow bi bi-chevron-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('addresses.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-list-task"></i>
                                        <p>عرض العناوين</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('addresses.create') }}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>إضافة عنوان</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

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
                            <a href="#" onclick="{{ login() }}" class="nav-link">
                                <i class="nav-icon bi bi-box-arrow-right text-danger"></i>
                                <p>تسجيل الخروج</p>
                            </a>
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
    <script src="{{ asset('js/crud.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <!--end::Script-->
    @yield('scripts')
</body>
<!--end::Body-->

</html>
