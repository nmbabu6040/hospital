<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-red-50 flex items-center justify-center">
            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>
        <h1 class="text-5xl font-bold text-gray-800 mb-3">500</h1>
        <h2 class="text-xl font-semibold text-gray-700 mb-3">কিছু একটা সমস্যা হয়েছে</h2>
        <p class="text-gray-500 mb-8">আমাদের সার্ভারে একটি অপ্রত্যাশিত সমস্যা দেখা দিয়েছে। আমরা দ্রুত এটি ঠিক করার
            চেষ্টা করছি। অনুগ্রহ করে কিছুক্ষণ পর আবার চেষ্টা করুন।</p>
        <a href="/"
            class="inline-block bg-brand text-white px-5 py-2.5 rounded-md font-medium hover:bg-brand-dark transition">হোমপেজে
            ফিরে যান</a>
    </div>
</body>

</html>
