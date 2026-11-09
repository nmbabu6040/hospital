<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Register | {{ config('app.name') }}</title>
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

<body class="auth-bg min-h-screen flex items-center justify-center px-4 py-10">

    <div class="auth-card bg-white rounded-2xl p-8 w-full max-w-md relative z-10">
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-brand">{{ config('app.name') }}</a>
            <p class="text-sm text-gray-500 mt-1">Create Your Patient Account</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('patient.register.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="auth-input w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="auth-input w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    class="auth-input w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required
                    class="auth-input w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="auth-input w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <button type="submit"
                class="btn-primary w-full transform hover:scale-[1.02] active:scale-[0.98] transition-transform">Create
                Account</button>
        </form>

        <p class="text-sm text-center mt-6 text-gray-500">
            আগে থেকেই অ্যাকাউন্ট আছে? <a href="{{ route('patient.login') }}"
                class="text-brand font-medium hover:underline">Login</a>
        </p>
    </div>

</body>

</html>
