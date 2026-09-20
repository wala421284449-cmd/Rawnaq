<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>تسجيل الدخول | متجر رونق</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="لوحة تحكم متجر رونق" />

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('cms/css/adminlte.css') }}" />

    <style>
        :root {
            --primary-rose: #d946ef;
            --primary-berry: #be185d;
            --accent-pink: #ec4899;
            --bg-dark: #201026;
            --text-main: #2e1065;
            --text-muted: #70587c;
        }

        body {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #180820 0%, #2b1035 50%, #1a0824 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* توهجات ضوئية */
        body::before {
            content: "";
            position: absolute;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.22) 0%, transparent 70%);
            top: 5%;
            right: 12%;
            border-radius: 50%;
            filter: blur(50px);
            z-index: 0;
        }

        body::after {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(190, 24, 93, 0.22) 0%, transparent 70%);
            bottom: 5%;
            left: 12%;
            border-radius: 50%;
            filter: blur(50px);
            z-index: 0;
        }

        .login-box {
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .brand-logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.8rem;
        }

        .brand-icon-box {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #f43f5e 0%, #be185d 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.9rem;
            box-shadow: 0 10px 25px rgba(225, 29, 72, 0.4);
            margin-bottom: 0.85rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-title {
            color: #ffffff;
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .brand-subtitle {
            color: #fbcfe8;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            opacity: 0.85;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 45px rgba(17, 2, 23, 0.45);
            overflow: hidden;
        }

        .login-card-body {
            padding: 2.3rem;
        }

        .form-heading {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .form-heading h5 {
            font-weight: 800;
            color: #4a044e;
            margin-bottom: 0.3rem;
        }

        .form-heading p {
            font-size: 0.85rem;
            color: #701a75;
            opacity: 0.75;
            margin: 0;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #581c87;
            margin-bottom: 0.4rem;
            display: block;
            text-align: right;
        }

        .input-group-custom {
            margin-bottom: 1.25rem;
        }

        .input-group-custom .input-group-text {
            background-color: #fdf4ff;
            border: 1px solid #f5d0fe;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #a21caf;
            padding: 0.7rem 1rem;
        }

        .input-group-custom .form-control {
            border: 1px solid #f5d0fe;
            border-right: none;
            border-radius: 12px 0 0 12px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            color: #3b0764;
            background-color: #ffffff;
        }

        .input-group-custom .form-control:focus {
            border-color: #d946ef;
            box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.18);
            outline: none;
        }

        .input-group-custom:focus-within .input-group-text {
            border-color: #d946ef;
            color: #c026d3;
        }

        .ltr-input {
            direction: ltr;
            text-align: right;
        }

        .btn-login {
            background: linear-gradient(135deg, #e11d48 0%, #a21caf 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.35);
            transition: all 0.25s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #be123c 0%, #86198f 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(190, 24, 93, 0.45);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.825rem;
            color: #f5d0fe;
            opacity: 0.75;
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #701a75;
            cursor: pointer;
            user-select: none;
        }

        .form-check-input {
            cursor: pointer;
            border-color: #e879f9;
        }

        .form-check-input:checked {
            background-color: #be185d;
            border-color: #be185d;
        }

        .forgot-link {
            font-size: 0.825rem;
            color: #be185d;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #86198f;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-box">

        <!-- Logo & Branding -->
        <div class="brand-logo-wrap">
            <div class="brand-icon-box">
                <i class="bi bi-gem"></i>
            </div>
            <h1 class="brand-title">متجر رونق</h1>
            <span class="brand-subtitle">نظام الإدارة ولوحة التحكم</span>
        </div>

        <!-- Login Card -->
        <div class="card login-card">
            <div class="login-card-body">
                <div class="form-heading">
                    <h5>تسجيل الدخول</h5>
                    <p>أدخل بيانات الحساب للوصول إلى لوحة التحكم</p>
                </div>

                <form id="login-form" onsubmit="event.preventDefault(); performLogin();">
                    @csrf

                    <!-- Email Input -->
                    <div class="input-group-custom">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-heart"></i></span>
                            <input type="email" name="email" id="email" class="form-control ltr-input"
                                placeholder="admin@rawnaq.com" required autofocus />
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="input-group-custom">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control ltr-input"
                                placeholder="••••••••" required />
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                        <div class="form-check m-0 d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="checkbox" id="remember_me" name="remember" />
                            <label class="form-check-label" for="remember_me">تذكر بيانات تسجيل دخولي</label>
                        </div>
                        <a href="#" class="forgot-link">هل نسيت كلمة المرور؟</a>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" id="btn-submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-left ms-1"></i> الدخول إلى المتجر
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="login-footer">
            <span>&copy; {{ date('Y') }} جميع الحقوق محفوظة لـ <strong>متجر رونق</strong></span>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function performLogin() {
            let email = document.getElementById('email').value.trim();
            let password = document.getElementById('password').value;
            let remember = document.getElementById('remember_me').checked;
            let btn = document.getElementById('btn-submit');

            if (!email || !password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'تنبيه',
                    text: 'يرجى إدخال البريد الإلكتروني وكلمة المرور',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#be185d'
                });
                return;
            }

            // تعطيل الزر لتجنب التكرار أثناء المعالجة
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm ms-1"></span> جاري الدخول...';

            axios.post('/login', {
                    email: email,
                    password: password,
                    remember: remember
                })
                .then(function(response) {
                    // التحويل المباشر والفوري دون انتظار
                    window.location.href = response.data.redirect || '/cms/admin';
                })
                .catch(function(error) {
                    // إعادة تفعيل الزر في حال حدوث خطأ
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-box-arrow-in-left ms-1"></i> الدخول إلى المتجر';

                    let errorMessage = 'بيانات الدخول غير صحيحة، يرجى المحاولة ثانية';

                    if (error.response && error.response.data) {
                        if (error.response.data.title) {
                            errorMessage = error.response.data.title;
                        } else if (error.response.data.message) {
                            errorMessage = error.response.data.message;
                        } else if (error.response.data.errors) {
                            let firstKey = Object.keys(error.response.data.errors)[0];
                            errorMessage = error.response.data.errors[firstKey][0];
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'فشل الدخول',
                        text: errorMessage,
                        confirmButtonText: 'حسناً',
                        confirmButtonColor: '#be185d'
                    });
                });
        }
    </script>
</body>

</html>
