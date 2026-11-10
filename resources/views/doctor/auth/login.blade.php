<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-bg {
            background: linear-gradient(135deg, var(--color-brand) 0%, var(--color-brand-dark) 100%);
        }

        .auth-card {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }
    </style>
</head>

<body class="auth-bg min-h-screen flex items-center justify-center px-4">

    <div class="auth-card bg-white rounded-2xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-brand">{{ config('app.name') }}</a>
            <p class="text-sm text-gray-500 mt-1">Doctor Portal</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('doctor.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>
            <button type="submit" class="btn-primary w-full">Login</button>
        </form>

        <p class="text-xs text-gray-400 text-center mt-6">লগইন সমস্যায় Admin-এর সাথে যোগাযোগ করুন।</p>
    </div>

</body>

</html>
