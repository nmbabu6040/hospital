<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Login | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-bg {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }

        .auth-card {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body class="auth-bg min-h-screen flex items-center justify-center px-4">

    <div class="auth-card bg-white rounded-2xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-brand/10 flex items-center justify-center">
                <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-xl font-bold">Two-Factor Verification</h1>
            <p class="text-sm text-gray-500 mt-1">আপনার ইমেইলে পাঠানো ৬-ডিজিটের কোড দিন</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.2fa.verify') }}" method="POST" class="space-y-5">
            @csrf
            <input type="text" name="code" maxlength="6" required autofocus placeholder="______"
                class="w-full text-center text-3xl tracking-[1em] border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand">
            <button type="submit" class="btn-primary w-full">Verify & Login</button>
        </form>

        <p class="text-xs text-gray-400 text-center mt-6">কোড না পেলে Spam ফোল্ডার চেক করুন। কোডের মেয়াদ ১০ মিনিট।</p>
    </div>

</body>

</html>
