@extends('layout.app')

@section('title', 'ثبت‌نام')
@section('styles') @include('auth.partials.styles') @endsection

@section('content')
<main class="auth-page">
    <div class="auth-card">
        <aside class="auth-visual">
            <img src="{{ asset('site/logos/black-logo-min.png') }}" alt="فروشگاه توکا">
            <div>
                <h2>به توکا خوش آمدی</h2>
                <p>در چند ثانیه حساب بسازید؛ سبد فعلی شما بعد از ثبت‌نام همان‌جا باقی می‌ماند.</p>
                <ul class="auth-benefits"><li><i class="bi bi-phone"></i> ثبت‌نام با تأیید شماره همراه</li><li><i class="bi bi-bag-heart"></i> پیگیری آسان سفارش‌ها</li><li><i class="bi bi-stars"></i> خرید سریع‌تر در دفعات بعد</li></ul>
            </div>
        </aside>
        <section class="auth-form">
            <h1>ساخت حساب کاربری</h1>
            <p class="auth-form-subtitle">اطلاعات کوتاه زیر را وارد کنید؛ نیازی به رمز عبور نیست.</p>
            <form action="{{ route('auth.register') }}" method="POST" novalidate>
                @csrf
                <div class="auth-field">
                    <label class="auth-label" for="name">نام و نام خانوادگی</label>
                    <input class="auth-input" id="name" name="name" type="text" maxlength="80" autocomplete="name" value="{{ old('name') }}" placeholder="مثلاً علی رضایی" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="auth-field">
                    <label class="auth-label" for="phone">شماره همراه</label>
                    <input class="auth-input" id="phone" name="phone" type="tel" inputmode="numeric" dir="ltr" maxlength="11" autocomplete="tel" value="{{ old('phone') }}" placeholder="09121234567" required>
                    @error('phone') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="auth-field">
                    <label class="auth-label" for="code">کد تأیید پیامکی</label>
                    <div class="otp-row">
                        <input class="auth-input" id="code" name="code" type="text" inputmode="numeric" dir="ltr" maxlength="6" autocomplete="one-time-code" placeholder="------" required>
                        <button class="otp-send" type="button" data-send-otp>ارسال کد</button>
                    </div>
                    @error('code') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div id="otpMessage" class="auth-message" role="status"></div>
                <button class="auth-submit" type="submit">ثبت‌نام و ورود</button>
                <p class="auth-switch">قبلاً ثبت‌نام کرده‌اید؟ <a href="{{ route('auth.login-view') }}">وارد شوید</a></p>
            </form>
        </section>
    </div>
</main>
@endsection

@section('scripts') @include('auth.partials.otp-script', ['purpose' => 'register']) @endsection
