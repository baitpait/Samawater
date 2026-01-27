@extends(backpack_view('layouts.plain'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    {{-- Line Awesome Icons - للأيقونات --}}
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <style>
        /* ============================================
           Login Page - Unified Design
           ============================================ */
        body {
            margin: 0;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        /* القسم الأيسر - Branding */
        .left-panel {
            width: 45%;
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.5;
            }
            50% {
                opacity: 0.8;
            }
        }

        .left-panel img.logo {
            width: 180px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.1));
        }

        .brand-text {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            margin-top: 20px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            font-family: 'Cairo', sans-serif;
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
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3);
        }

        .login-header-icon i {
            font-size: 36px;
            color: #fff;
            font-weight: 900;
        }

        .title {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #1A1A1A;
            text-align: center;
            font-family: 'Cairo', sans-serif;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 40px;
            font-size: 16px;
            text-align: center;
            font-family: 'Cairo', sans-serif;
        }

        /* Form Inputs - Unified Design */
        .input-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            position: relative;
        }


        .input-icon-box {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(111, 106, 248, 0.2);
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within .input-icon-box {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(111, 106, 248, 0.3);
        }

        .input-wrapper i {
            color: #fff;
            font-size: 22px;
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within i {
            transform: scale(1.1);
        }

        .input-box,
        .modern-input {
            flex: 1;
            height: 56px;
            padding: 0 24px 0 50px;
            border-radius: 16px;
            background: #f8f9fa;
            border: 2px solid #e5e7eb;
            font-size: 16px;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            color: #1f2937;
        }

        /* Password Toggle Box - مثل input-icon-box */
        .password-toggle-box {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(111, 106, 248, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .password-toggle-box:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(111, 106, 248, 0.3);
        }

        /* Password Toggle Button - داخل البوكس */
        .password-toggle {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            color: #fff !important;
            transition: all 0.2s ease !important;
        }

        .password-toggle i {
            font-size: 22px !important;
            color: #fff !important;
            transition: all 0.3s ease !important;
        }

        .password-toggle-box:hover i {
            transform: scale(1.1);
        }

        .password-toggle:active {
            transform: scale(0.95);
        }

        .input-box:focus,
        .modern-input:focus {
            border-color: #6f6af8;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(111, 106, 248, 0.1);
            outline: none;
        }

        .input-box::placeholder,
        .modern-input::placeholder {
            color: #9ca3af;
        }

        /* Checkbox - Remember Me */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            font-size: 15px;
            color: #374151;
            font-family: 'Cairo', sans-serif;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-left: 10px;
            cursor: pointer;
            accent-color: #6f6af8;
        }

        .checkbox-wrapper label {
            cursor: pointer;
            font-weight: 500;
        }

        /* Login Button - Unified Design */
        .btn-login,
        .btn-login-unified {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            width: 100%;
            height: 56px;
            padding: 15px;
            border-radius: 16px;
            color: white;
            border: none;
            font-size: 18px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-login:hover,
        .btn-login-unified:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-login:active,
        .btn-login-unified:active {
            transform: translateY(0);
        }

        /* Error Messages */
        .alert {
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-family: 'Cairo', sans-serif;
            border: none;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
            font-family: 'Cairo', sans-serif;
        }

        .login-footer a {
            color: #6f6af8;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Hide Backpack default footer */
        footer.app-footer,
        .app-footer,
        footer.sticky-footer,
        .sticky-footer {
            display: none !important;
            visibility: hidden !important;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 500px;
            }

            .left-panel {
                width: 100%;
                padding: 40px 30px;
            }

            .right-panel {
                width: 100%;
                padding: 40px 30px;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }

            .login-wrapper {
                border-radius: 20px;
            }

            .left-panel {
                padding: 30px 20px;
            }

            .right-panel {
                padding: 30px 20px;
            }

            .title {
                font-size: 24px;
            }

            .login-header-icon {
                width: 64px;
                height: 64px;
            }

            .login-header-icon i {
                font-size: 28px;
            }
        }
    </style>
@endsection

@section('content')
<div class="login-wrapper">
    <!-- LEFT SIDE - Branding -->
    <div class="left-panel">
        <img class="logo" src="{{ asset('logo/Logo-2.png') }}" alt="Eleyyaa Logo">
        <div class="brand-text">لوحة التحكم</div>
    </div>

    <!-- RIGHT SIDE - Login Form -->
    <div class="right-panel">
        <div class="login-header">
            <div class="login-header-icon">
                <i class="la la-lock"></i>
            </div>
            <div class="title">تسجيل الدخول</div>
            <div class="subtitle">أدخل بياناتك للوصول إلى لوحة التحكم</div>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <i class="la la-exclamation-circle"></i>
            <strong>حدث خطأ:</strong>
            <ul class="mb-0 mt-2" style="padding-right: 1.5rem;">
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
                    <i class="la la-envelope"></i>
                </div>
                <input 
                    type="text" 
                    class="input-box modern-input" 
                    name="{{ $username }}" 
                    placeholder="رقم الهاتف أو البريد الإلكتروني"
                    value="{{ old($username) }}"
                    required
                    autofocus
                >
            </div>

            <div class="input-wrapper">
                <div class="input-icon-box password-toggle-box">
                    <button 
                        type="button" 
                        class="password-toggle" 
                        id="passwordToggle" 
                        aria-label="إظهار/إخفاء كلمة المرور"
                    >
                        <i class="la la-eye" id="passwordToggleIcon"></i>
                    </button>
                </div>
                <input 
                    type="password" 
                    class="input-box modern-input" 
                    name="password" 
                    id="password"
                    placeholder="كلمة المرور"
                    required
                >
            </div>

            <div class="checkbox-wrapper">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">تذكرني</label>
            </div>

            <button type="submit" class="btn-login btn-login-unified">
                <i class="la la-sign-in-alt"></i>
                تسجيل الدخول
            </button>
        </form>

        <div class="login-footer">
            تم التطوير بواسطة <a href="https://baitpait.com/" target="_blank">بيت البرمجيات وتكنولوجيا المعلومات</a>
        </div>
    </div>
</div>

<script>
    // Password Toggle Functionality - Fast & Smooth
    (function() {
        function initPasswordToggle() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');
            const passwordToggleIcon = document.getElementById('passwordToggleIcon');

            if (!passwordInput || !passwordToggle || !passwordToggleIcon) {
                // Retry after a short delay if elements not found
                setTimeout(initPasswordToggle, 100);
                return;
            }

            // Ensure toggle is visible
            passwordToggle.style.display = 'flex';
            passwordToggle.style.visibility = 'visible';
            passwordToggle.style.opacity = '1';
            passwordToggle.style.zIndex = '100';

            // Fast toggle with smooth animation
            passwordToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Quick toggle
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                
                // Smooth icon transition
                if (isPassword) {
                    passwordToggleIcon.classList.remove('la-eye');
                    passwordToggleIcon.classList.add('la-eye-slash');
                    passwordToggle.setAttribute('aria-label', 'إخفاء كلمة المرور');
                } else {
                    passwordToggleIcon.classList.remove('la-eye-slash');
                    passwordToggleIcon.classList.add('la-eye');
                    passwordToggle.setAttribute('aria-label', 'إظهار كلمة المرور');
                }
                
                // Focus back to input for better UX
                passwordInput.focus();
            });

            // Keyboard support (Enter/Space)
            passwordToggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    passwordToggle.click();
                }
            });

            // Make toggle focusable
            passwordToggle.setAttribute('tabindex', '0');
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPasswordToggle);
        } else {
            initPasswordToggle();
        }
    })();
</script>
@endsection

