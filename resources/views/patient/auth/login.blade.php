<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-bg {
            background: linear-gradient(135deg, var(--color-brand) 0%, var(--color-brand-dark) 100%);
            position: relative;
            overflow: hidden;
        }

        .auth-bg::before,
        .auth-bg::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .auth-bg::before {
            width: 400px;
            height: 400px;
            top: -150px;
            right: -100px;
        }

        .auth-bg::after {
            width: 300px;
            height: 300px;
            bottom: -120px;
            left: -80px;
        }

        .auth-card {
            transform: perspective(1000px) rotateX(0deg);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .auth-card:hover {
            transform: perspective(1000px) rotateX(2deg) translateY(-4px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.4);
        }

        .auth-input {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .auth-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -8px var(--color-brand);
        }
    </style>
</head>

<body class="auth-bg min-h-screen flex items-center justify-center px-4">

    <div class="auth-card bg-white rounded-2xl p-8 w-full max-w-md relative z-10">
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-brand">{{ config('app.name') }}</a>
            <p class="text-sm text-gray-500 mt-1">Patient Portal Login</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('patient.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email or Phone</label>
                <input type="text" name="login" value="{{ old('login') }}" required autofocus
                    class="auth-input w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required
                    class="auth-input w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button type="submit"
                class="btn-primary w-full transform hover:scale-[1.02] active:scale-[0.98] transition-transform">Login</button>
        </form>

        <p class="text-sm text-center mt-6 text-gray-500">
            নতুন রোগী? <a href="{{ route('patient.register') }}" class="text-brand font-medium hover:underline">Register
                Now</a>
        </p>
    </div>

</body>

</html>
