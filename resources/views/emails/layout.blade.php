<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: {{ \App\Models\Setting::get()->themePrimaryColor() }};
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .body {
            padding: 25px;
            color: #333;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer {
            padding: 15px 25px;
            background: #f9fafb;
            font-size: 11px;
            color: #888;
            text-align: center;
        }

        .btn {
            display: inline-block;
            background: {{ \App\Models\Setting::get()->themePrimaryColor() }};
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
        }

        .info-row {
            padding: 6px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row strong {
            color: #555;
            display: inline-block;
            width: 120px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="body">
            @yield('content')
        </div>
        <div class="footer">
            {{ \App\Models\Setting::get()->address }}<br>
            Phone: {{ \App\Models\Setting::get()->hotline }}
        </div>
    </div>
</body>

</html>
