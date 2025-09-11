@extends('layout.app')

@section('styles')
    <style>
        :root {
            --pink: #ff9eb7;
            --light-pink: #ffd6de;
            --dark-pink: #ff7ba3;
            --purple: #b399d4;
            --light-purple: #d9c5f4;
            --cream: #fff4f6;
            --white: #ffffff;
            --text-dark: #5a3d5c;
            --text-light: #ffffff;
            --black: #1a1a1a;
        }

        .login-page {
            min-height: 100vh;
            background-color: var(--cream);
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .login-container {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(179, 153, 212, 0.15);
            overflow: hidden;
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .login-image {
            background: linear-gradient(45deg, var(--pink), var(--purple));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-image img {
            max-width: 100%;
            height: auto;
        }

        .login-form-container {
            padding: 3rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--text-dark);
            opacity: 0.7;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border: 1px solid var(--light-purple);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--cream);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(179, 153, 212, 0.2);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-left: 0.5rem;
        }

        .forgot-password {
            color: var(--purple);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--dark-pink);
        }

        .login-btn {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background: linear-gradient(45deg, var(--pink), var(--purple));
            color: var(--white);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(179, 153, 212, 0.3);
        }

        .social-login {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .social-login-title {
            position: relative;
            color: var(--text-dark);
            opacity: 0.7;
            margin-bottom: 1rem;
        }

        .social-login-title::before,
        .social-login-title::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background-color: var(--light-purple);
        }

        .social-login-title::before {
            right: 0;
        }

        .social-login-title::after {
            left: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--cream);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: linear-gradient(45deg, var(--pink), var(--purple));
            color: var(--white);
        }

        .register-link {
            text-align: center;
            color: var(--text-dark);
        }

        .register-link a {
            color: var(--purple);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: var(--dark-pink);
        }

        /* رسپانسیو */
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-image {
                display: none;
            }

            .login-form-container {
                padding: 2rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="login-page">
        <div class="container">
            <div class="login-container">
                <!-- بخش تصویر -->
                <div class="login-image">
                    <img src="{{ asset('site/logos/black-logo-min.png') }}" alt="ورود به ونل">
                </div>

                <!-- بخش فرم -->
                <div class="login-form-container">
                    <div class="login-header">
                        <h1 class="login-title">ورود به حساب کاربری</h1>
                        <p class="login-subtitle">لطفاً برای ورود به حساب کاربری خود اطلاعات را وارد کنید</p>
                    </div>

                    <form action="{{ route('auth.login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="phone" class="form-label">شماره همراه</label>
                            <input type="text" id="phone" name="phone" class="form-control"
                                   placeholder="09121234567">
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">رمز عبور</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="***">
                        </div>

                        <div class="remember-forgot">
                            <div class="remember-me">
                                <input type="checkbox" id="remember">
                                <label for="remember">مرا به خاطر بسپار</label>
                            </div>
                            <a href="#" class="forgot-password">رمز عبور را فراموش کرده‌اید؟</a>
                        </div>

                        <button type="submit" class="login-btn">ورود به حساب</button>

                        <div class="register-link">
                            حساب کاربری ندارید؟ <a href="{{route('auth.register-view')}}">ثبت نام کنید</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
