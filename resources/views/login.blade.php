@extends('layout.app')

@section('title', 'ورود یا ثبت‌نام')
@section('styles')
    @include('auth.partials.styles')
    <style>
        .auth-card { display: block; max-width: 450px; }
        .auth-form { padding: 38px; }
        .auth-mark { width: 58px; height: 58px; display: grid; place-items: center; margin: 0 auto 20px; border-radius: 18px; color: #fff; background: #e94560; font-size: 1.7rem; }
        .auth-form h1, .auth-form-subtitle { text-align: center; }
        .auth-hint { color: #76818b; text-align: center; font-size: .8rem; line-height: 1.8; margin: 18px 0 0; }
    </style>
@endsection

@section('content')
<main class="auth-page">
    <section class="auth-card">
        <div class="auth-form">
            <div class="auth-mark"><i class="bi bi-phone"></i></div>
            <h1>ورود یا ثبت‌نام</h1>
            <p class="auth-form-subtitle">شماره همراهت را وارد کن؛ فقط یک کد تأیید لازم است.</p>
            @error('auth') <div class="auth-message error">{{ $message }}</div> @enderror
            @include('auth.partials.phone-form', ['authId' => 'login'])
            <p class="auth-hint">اگر قبلاً حساب ساخته باشی وارد می‌شوی؛ در غیر این صورت حساب تو خودکار ساخته می‌شود.</p>
        </div>
    </section>
</main>
@endsection

@section('scripts') @include('auth.partials.otp-script') @endsection
