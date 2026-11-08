<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRegisterRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth('patient')->check()) {
            return redirect()->route('home');
        }

        return view('patient.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::guard('patient')->attempt([$field => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            // intended() থাকলে সেখানে ফিরে যাবে (যেমন appointment পেজ থেকে লগইন করলে সেখানেই), না থাকলে Home-এ
            return redirect()->intended(route('home'))->with('success', 'স্বাগতম, ' . auth('patient')->user()->name . '!');
        }

        return back()->withErrors(['login' => 'ভুল ইমেইল/ফোন অথবা পাসওয়ার্ড।'])->onlyInput('login');
    }

    public function showRegister()
    {
        if (auth('patient')->check()) {
            return redirect()->route('home');
        }

        return view('patient.auth.register');
    }

    public function register(PatientRegisterRequest $request)
    {
        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('patient')->login($patient);

        return redirect()->intended(route('home'))->with('success', 'স্বাগতম! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে।');
    }

    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
