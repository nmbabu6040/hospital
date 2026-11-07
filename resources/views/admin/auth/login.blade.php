<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Admin Login</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
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
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button type="submit" class="btn-primary w-full">Login</button>
        </form>

        <p class="text-xs text-gray-400 text-center mt-6">Demo: admin@example.com / password123</p>
    </div>

</body>

</html>
