<script>
document.addEventListener('DOMContentLoaded', () => {
    const normalizeDigits = value => value
        .replace(/[۰-۹]/g, char => '۰۱۲۳۴۵۶۷۸۹'.indexOf(char))
        .replace(/[٠-٩]/g, char => '٠١٢٣٤٥٦٧٨٩'.indexOf(char));

    document.querySelectorAll('[data-phone-auth]').forEach(form => {
        const phone = form.querySelector('[name="phone"]');
        const code = form.querySelector('[name="code"]');
        const codeStage = form.querySelector('[data-code-stage]');
        const action = form.querySelector('[data-auth-action]');
        const changePhone = form.querySelector('[data-change-phone]');
        const message = form.querySelector('[data-auth-message]');
        let stage = form.dataset.startStage || 'phone';

        const showMessage = (text, type) => {
            message.textContent = text;
            message.className = `auth-message ${type}`;
        };
        const setStage = nextStage => {
            stage = nextStage;
            codeStage.hidden = stage !== 'code';
            phone.readOnly = stage === 'code';
            action.textContent = stage === 'code' ? 'تأیید و ورود' : 'ادامه';
            action.disabled = false;
            (stage === 'code' ? code : phone).focus();
        };

        setStage(stage);
        form.addEventListener('submit', event => {
            event.preventDefault();
            action.click();
        });
        changePhone.addEventListener('click', () => {
            code.value = '';
            message.className = 'auth-message';
            setStage('phone');
        });

        action.addEventListener('click', async () => {
            phone.value = normalizeDigits(phone.value.trim());
            if (!/^09\d{9}$/.test(phone.value)) {
                showMessage('شماره همراه معتبر وارد کنید؛ مثال: 09121234567', 'error');
                phone.focus();
                return;
            }

            if (stage === 'code') {
                code.value = normalizeDigits(code.value.trim());
                if (!/^\d{6}$/.test(code.value)) {
                    showMessage('کد تأیید ۶ رقمی را وارد کنید.', 'error');
                    code.focus();
                    return;
                }
                action.disabled = true;
                action.textContent = 'در حال ورود…';
                form.submit();
                return;
            }

            action.disabled = true;
            action.textContent = 'کمی صبر کنید…';
            try {
                const response = await fetch(@json(route('otp.send')), {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': @json(csrf_token())},
                    body: JSON.stringify({phone: phone.value, purpose: 'authenticate'})
                });
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || Object.values(data.errors || {})[0]?.[0] || 'دریافت کد انجام نشد.');

                setStage('code');
                if (data.debug_code) {
                    code.value = data.debug_code;
                    showMessage(`حالت تست: کد ${data.debug_code}`, 'success');
                } else {
                    showMessage('کد تأیید برای شماره شما ارسال شد.', 'success');
                }
            } catch (error) {
                showMessage(error.message, 'error');
                action.disabled = false;
                action.textContent = 'ادامه';
            }
        });
    });
});
</script>
