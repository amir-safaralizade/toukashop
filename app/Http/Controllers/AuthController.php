<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginView(Request $request)
    {
        if (auth()->check() && !auth()->user()->is_guest) {
            return redirect()->route('account.index');
        }

        if ($request->query('redirect') === 'cart') {
            $request->session()->put('url.intended', route('cart.mycart'));
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->merge(['phone' => $this->normalizeDigits($request->input('phone')), 'code' => $this->normalizeDigits($request->input('code'))]);
        $data = $request->validate([
            'phone' => ['required', 'regex:/^09\d{9}$/'],
            'code' => ['required', 'digits:6'],
            'remember' => ['nullable', 'boolean'],
        ], ['phone.regex' => 'شماره همراه باید با 09 شروع شود و 11 رقم باشد.', 'code.digits' => 'کد تأیید باید ۶ رقم باشد.']);

        $phone = $data['phone'];
        $user = User::where('is_guest', false)->where(function ($query) use ($phone) {
            $query->where('phone', $phone)->orWhere('email', $phone);
        })->first();

        $this->consumeCode($phone, $data['code']);
        $guest = Auth::user()?->is_guest ? Auth::user() : null;
        $user = DB::transaction(function () use ($guest, $user, $phone) {
            if (!$user) {
                if ($guest) {
                    $guest->update([
                        'name' => 'کاربر ' . substr($phone, -4),
                        'phone' => $phone,
                        'email' => $phone . '@mobile.local',
                        'password' => Str::password(32),
                        'is_guest' => false,
                        'guest_token' => null,
                    ]);
                    return $guest->fresh();
                }

                return User::create([
                    'name' => 'کاربر ' . substr($phone, -4),
                    'phone' => $phone,
                    'email' => $phone . '@mobile.local',
                    'password' => Str::password(32),
                    'is_guest' => false,
                ]);
            }

            if (!$user->phone) {
                $user->update(['phone' => $phone]);
            }

            if ($guest && $guest->id !== $user->id) {
                $this->mergeGuestCart($guest, $user);
            }

            return $user;
        });

        Auth::login($user, (bool) ($data['remember'] ?? false));
        $request->session()->regenerate();
        $request->session()->forget('guest_token');
        Cookie::queue(Cookie::forget('anon_client_id'));

        if ($request->input('redirect') === 'cart') {
            return redirect()->route('cart.mycart')->with('success', 'شماره همراه تأیید شد؛ حالا سفارش را تکمیل کنید.');
        }

        return redirect()->intended(route('page.home'))->with('success', 'با موفقیت وارد حساب شدید.');
    }

    public function registerView() { return redirect()->route('auth.login-view'); }

    public function register(Request $request) { return $this->login($request); }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget('anon_client_id'));
        return redirect()->route('page.home')->with('success', 'از حساب کاربری خارج شدید.');
    }

    private function consumeCode(string $phone, string $code): void
    {
        $result = DB::transaction(function () use ($phone, $code) {
            $verification = VerificationCode::where('phone', $phone)->where('channel', 'sms')
                ->where('verified', false)->latest('id')->lockForUpdate()->first();

            if (!$verification || $verification->isExpired()) {
                return 'expired';
            }
            if ($verification->attempts >= 5) {
                return 'limited';
            }
            if (!hash_equals($verification->code, $code)) {
                $verification->increment('attempts');
                return 'invalid';
            }
            $verification->update(['verified' => true]);
            return 'valid';
        });

        $message = match ($result) {
            'expired' => 'کد منقضی شده است؛ کد جدید بگیرید.',
            'limited' => 'تعداد تلاش بیش از حد مجاز است؛ کد جدید بگیرید.',
            'invalid' => 'کد تأیید صحیح نیست.',
            default => null,
        };
        if ($message) throw ValidationException::withMessages(['code' => $message]);
    }

    private function mergeGuestCart(User $guest, User $user): void
    {
        $guestCart = Order::where('user_id', $guest->id)->where('status', 'pending')->latest()->first();
        if (!$guestCart) return;

        $userCart = Order::where('user_id', $user->id)->where('status', 'pending')->latest()->first();
        if (!$userCart) {
            $guestCart->update(['user_id' => $user->id]);
            return;
        }

        foreach ($guestCart->items()->with('variant')->get() as $guestItem) {
            $existing = $userCart->items()->where('product_variant_id', $guestItem->product_variant_id)->first();
            if (!$existing) {
                $guestItem->update(['order_id' => $userCart->id]);
                continue;
            }
            $quantity = $existing->quantity + $guestItem->quantity;
            if ($guestItem->variant) $quantity = min($quantity, $guestItem->variant->stock);
            $existing->update(['quantity' => $quantity, 'total_price' => $quantity * $existing->unit_price]);
            $guestItem->delete();
        }

        $total = $userCart->items()->sum('total_price');
        $userCart->update(['total_price' => $total, 'final_price' => max(0, $total - $userCart->discount_amount)]);
        $guestCart->delete();
    }

    private function normalizeDigits(?string $value): string
    {
        return str_replace(
            ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],
            ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'],
            trim((string) $value)
        );
    }
}
