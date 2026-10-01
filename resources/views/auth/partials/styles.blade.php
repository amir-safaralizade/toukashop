<style>
    .auth-page { min-height: calc(100vh - 76px); padding: 48px 16px; display: grid; place-items: center; background: radial-gradient(circle at 15% 15%, #ffe4ea 0, transparent 34%), radial-gradient(circle at 85% 85%, #dff8f3 0, transparent 34%), #f8f9fb; }
    .auth-card { width: min(100%, 920px); display: grid; grid-template-columns: .85fr 1.15fr; overflow: hidden; border: 1px solid #e8ebee; border-radius: 28px; background: #fff; box-shadow: 0 24px 70px rgba(31,41,55,.11); }
    .auth-visual { padding: 42px; display: flex; flex-direction: column; justify-content: space-between; color: #fff; background: linear-gradient(145deg, #e94560, #c62f4a); }
    .auth-visual img { width: 145px; max-height: 70px; object-fit: contain; filter: brightness(0) invert(1); }
    .auth-visual h2 { margin: 40px 0 12px; font-weight: 950; font-size: 2rem; line-height: 1.5; }
    .auth-visual p { margin: 0; line-height: 2; opacity: .88; }
    .auth-benefits { list-style: none; padding: 0; margin: 34px 0 0; }
    .auth-benefits li { display: flex; gap: 9px; align-items: center; margin-top: 13px; font-size: .9rem; }
    .auth-form { padding: 46px clamp(24px, 6vw, 64px); }
    .auth-form h1 { font-size: 1.75rem; font-weight: 950; margin-bottom: 8px; color: #242d36; }
    .auth-form-subtitle { color: #74808b; line-height: 1.8; margin-bottom: 30px; }
    .auth-field { margin-bottom: 18px; }
    .auth-label { display: block; font-weight: 800; font-size: .88rem; margin-bottom: 8px; color: #3c4853; }
    .auth-input { width: 100%; height: 50px; border: 1px solid #dfe4e8; border-radius: 14px; background: #fafbfc; padding: 0 14px; outline: none; transition: .2s; }
    .auth-input:focus { background: #fff; border-color: #e94560; box-shadow: 0 0 0 4px rgba(233,69,96,.09); }
    .otp-row { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 9px; }
    .otp-send { min-width: 122px; border: 1px solid #e94560; border-radius: 14px; padding: 0 13px; color: #e94560; background: #fff; font-weight: 850; }
    .otp-send:disabled { color: #8d969f; border-color: #d8dde1; cursor: wait; }
    .auth-submit { width: 100%; border: 0; border-radius: 14px; padding: 13px; background: #e94560; color: #fff; font-weight: 900; box-shadow: 0 10px 22px rgba(233,69,96,.22); transition: .2s; }
    .auth-submit:hover { background: #d93652; transform: translateY(-1px); }
    .auth-message { display: none; border-radius: 11px; padding: 10px 12px; margin: 10px 0 16px; font-size: .85rem; }
    .auth-message.success { display: block; color: #126348; background: #e6f7f1; }
    .auth-message.error { display: block; color: #a3263b; background: #fff0f3; }
    .field-error { display: block; color: #c62842; font-size: .8rem; margin-top: 6px; }
    .auth-switch { text-align: center; color: #697580; margin: 22px 0 0; }
    .auth-switch a { color: #e94560; font-weight: 850; text-decoration: none; }
    .remember-row { display: flex; gap: 8px; align-items: center; margin: 0 0 18px; color: #66717c; font-size: .88rem; }
    .remember-row input { accent-color: #e94560; width: 17px; height: 17px; }
    @media (max-width: 767px) { .auth-page { padding: 24px 12px; } .auth-card { grid-template-columns: 1fr; } .auth-visual { display: none; } .auth-form { padding: 32px 22px; } }
</style>
