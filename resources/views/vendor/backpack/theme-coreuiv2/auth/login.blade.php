@extends(backpack_view('layouts.plain'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    {{-- Line Awesome Icons - للأيقونات --}}
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <style>
        /* ============================================
           Login Page - Sama Water Branding
           ============================================ */
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif !important;
            background: var(--primary-deep) !important;
            min-height: 100vh;
            direction: rtl;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            background: #FFFFFF;
            border-radius: 28px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
        }

        /* القسم الأيسر - Branding */
        .left-panel {
            width: 45%;
            background: var(--primary-gradient);
            padding: 60px 40px;
            position: relative;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }

        .left-panel img.logo {
            width: 220px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
        }

        .brand-text {
            font-size: 36px;
            font-weight: 900;
            color: #fff;
            margin-top: 20px;
            position: relative;
            z-index: 1;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            font-family: 'Cairo', sans-serif;
            letter-spacing: 1px;
        }

        /* القسم الأيمن - Login Form */
        .right-panel {
            width: 55%;
            padding: 60px 50px;
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 15px 35px rgba(111, 106, 248, 0.3);
            transform: rotate(-5deg);
        }

        .login-header-icon i {
            font-size: 36px;
            color: #fff;
            font-weight: 900;
            transform: rotate(5deg);
        }

        .title {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--primary-deep);
            text-align: center;
            font-family: 'Cairo', sans-serif;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 40px;
            font-size: 16px;
            text-align: center;
            font-family: 'Cairo', sans-serif;
        }

        /* Form Inputs */
        .input-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 28px;
            position: relative;
        }

        .input-icon-box {
            width: 56px;
            height: 56px;
            background: #f1f5f9;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
            border: 1.5px solid #e2e8f0;
        }

        .input-wrapper:focus-within .input-icon-box {
            background: var(--primary-gradient);
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(111, 106, 248, 0.2);
        }

        .input-wrapper i {
            color: #64748b;
            font-size: 22px;
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within i {
            color: #fff;
            transform: scale(1.1);
        }

        .input-box,
        .modern-input {
            flex: 1;
            height: 56px;
            padding: 0 20px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            font-size: 16px;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            color: #1e293b;
        }

        .input-box:focus,
        .modern-input:focus {
            border-color: var(--primary-light);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(111, 106, 248, 0.1);
            outline: none;
        }

        /* Password Toggle Box */
        .password-toggle-box {
            background: #f1f5f9;
            cursor: pointer;
        }

        .password-toggle {
            background: transparent !important;
            border: none !important;
            width: 100%;
            height: 100%;
            color: #64748b;
        }

        .input-wrapper:focus-within .password-toggle-box {
            background: var(--primary-gradient);
        }

        .input-wrapper:focus-within .password-toggle {
            color: #fff;
        }

        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            font-size: 15px;
            color: #475569;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-left: 10px;
            cursor: pointer;
            accent-color: var(--primary-light);
        }

        /* Login Button */
        .btn-login-unified {
            background: var(--success-gradient);
            width: 100%;
            height: 56px;
            border-radius: 16px;
            color: white;
            border: none;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-login-unified:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #f1f5f9;
            color: #94a3b8;
            font-size: 14px;
        }

        .login-footer a {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-wrapper { flex-direction: column; max-width: 500px; }
            .left-panel, .right-panel { width: 100%; padding: 40px 30px; }
        }
    </style>
@endsection

@section('content')
<div class="login-wrapper">
    <!-- LEFT SIDE - Branding -->
    <div class="left-panel">
        <img class="logo" src="{{ asset('logo/Logo-2.png') }}" alt="Sama Water Logo">
        <div class="brand-text">مياه سما</div>
        <p style="color: rgba(255,255,255,0.8); margin-top: 10px; font-weight: 500;">نقاء يستحق الثقة</p>
    </div>

    <!-- RIGHT SIDE - Login Form -->
    <div class="right-panel">
        <div class="login-header">
            <div class="login-header-icon">
                <i class="la la-shield-alt"></i>
            </div>
            <div class="title">تسجيل الدخول</div>
            <div class="subtitle">مرحباً بك مجدداً في نظام مياه سما</div>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger" style="background: #fef2f2; color: #991b1b; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
            <ul class="mb-0" style="padding-right: 20px;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('backpack.auth.login') }}">
            @csrf

            <div class="input-wrapper">
                <div class="input-icon-box">
                    <i class="la la-user"></i>
                </div>
                <input 
                    type="text" 
                    class="input-box" 
                    name="{{ $username }}" 
                    placeholder="رقم الهاتف أو البريد الإلكتروني"
                    value="{{ old($username) }}"
                    required
                    autofocus
                >
            </div>

            <div class="input-wrapper">
                <div class="input-icon-box password-toggle-box">
                    <button type="button" class="password-toggle" id="passwordToggle">
                        <i class="la la-eye" id="passwordToggleIcon"></i>
                    </button>
                </div>
                <input 
                    type="password" 
                    class="input-box" 
                    name="password" 
                    id="password"
                    placeholder="كلمة المرور"
                    required
                >
            </div>

            <div class="checkbox-wrapper">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">تذكرني على هذا الجهاز</label>
            </div>

            <button type="submit" class="btn-login-unified">
                <i class="la la-sign-in-alt"></i>
                دخول للنظام
            </button>
        </form>

        <div class="login-footer">
            تم التطوير بواسطة <a href="https://baitpait.com/" target="_blank">بيت البرمجيات</a>
        </div>
    </div>
</div>

<script>
    document.getElementById('passwordToggle').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('passwordToggleIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('la-eye', 'la-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('la-eye-slash', 'la-eye');
        }
    });
</script>
@endsection
