<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;

class AuthController extends Controller
{
    public function loginView(Request $request)
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^09\d{9}$/',
            'password' => 'required|string|min:4',
        ]);

        $user = User::where('email', $request->phone)
            ->where('is_guest', false)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'phone' => 'اطلاعات ورود نادرست است.',
            ])->withInput();
        }

        auth()->login($user);

        // حذف توکن مهمان
        session()->forget('guest_token');
        Cookie::queue(Cookie::forget('anon_client_id'));

        return redirect()->intended('/');
    }


    public function registerView(Request $request)
    {
        return view('register');
    }

    public function register(Request $request)
    {

    }

    public function logout(Request $request)
    {
    }
}
