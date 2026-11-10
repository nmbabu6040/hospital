<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $admin = Auth::guard('admin')->user();

            if ($admin->two_factor_enabled) {
                // সাময়িকভাবে লগ-আউট করে রাখো, OTP verify হওয়ার আগ পর্যন্ত session শুরু হবে না
                Auth::guard('admin')->logout();

                $code = (string) random_int(100000, 999999);

                $admin->update([
                    'two_factor_code' => $code,
                    'two_factor_expires_at' => now()->addMinutes(10),
                ]);

                try {
                    Mail::to($admin->email)->send(new TwoFactorCodeMail($code));
                } catch (\Exception $e) {
                    \Log::error('2FA email failed: ' . $e->getMessage());
                }

                $request->session()->put('2fa_admin_id', $admin->id);
                $request->session()->put('2fa_remember', $request->boolean('remember'));

                return redirect()->route('admin.2fa.show');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }

    public function showTwoFactor(Request $request)
    {
        if (! $request->session()->has('2fa_admin_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.two-factor');
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate(['code' => ['required', 'string']]);

        $adminId = $request->session()->get('2fa_admin_id');
        $admin = \App\Models\Admin::find($adminId);

        if (! $admin || $admin->two_factor_code !== $request->code || now()->gt($admin->two_factor_expires_at)) {
            return back()->withErrors(['code' => 'ভুল অথবা মেয়াদোত্তীর্ণ কোড। আবার চেষ্টা করুন।']);
        }

        $admin->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);

        Auth::guard('admin')->login($admin, $request->session()->get('2fa_remember', false));
        $request->session()->forget(['2fa_admin_id', '2fa_remember']);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
