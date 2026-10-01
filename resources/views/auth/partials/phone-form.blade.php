@php
    $authId = $authId ?? 'pageAuth';
    $redirectAfterAuth = $redirectAfterAuth ?? null;
    $showCodeStage = $errors->has('code');
@endphp
<form action="{{ route('auth.login') }}" method="POST" novalidate data-phone-auth data-start-stage="{{ $showCodeStage ? 'code' : 'phone' }}">
    @csrf
    @if($redirectAfterAuth)<input type="hidden" name="redirect" value="{{ $redirectAfterAuth }}">@endif
    <div class="auth-field" data-phone-stage>
        <label class="auth-label" for="{{ $authId }}Phone">شماره همراه</label>
        <input class="auth-input" id="{{ $authId }}Phone" name="phone" type="tel" inputmode="numeric" dir="ltr" maxlength="11" autocomplete="tel" value="{{ old('phone') }}" placeholder="09121234567" required>
        @error('phone') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="auth-field" data-code-stage @if(!$showCodeStage) hidden @endif>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <label class="auth-label mb-0" for="{{ $authId }}Code">کد تأیید</label>
            <button class="btn btn-link btn-sm p-0 text-decoration-none" type="button" data-change-phone>تغییر شماره</button>
        </div>
        <input class="auth-input" id="{{ $authId }}Code" name="code" type="text" inputmode="numeric" dir="ltr" maxlength="6" autocomplete="one-time-code" placeholder="کد ۶ رقمی" required>
        @error('code') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="auth-message" data-auth-message role="status"></div>
    <label class="remember-row"><input type="checkbox" name="remember" value="1"> ورود من حفظ شود</label>
    <button class="auth-submit" type="button" data-auth-action>{{ $showCodeStage ? 'تأیید و ورود' : 'ادامه' }}</button>
</form>
