<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 100px 40px 100px 40px;
        }

        body {
            font-family: 'notosansbengali', 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 80px;
            border-bottom: 3px solid {{ $setting->themePrimaryColor() }};
            padding-bottom: 10px;
        }

        header table {
            width: 100%;
            border-collapse: collapse;
        }

        header .logo-cell {
            width: 70px;
        }

        header img {
            height: 55px;
        }

        header .name-cell {
            text-align: left;
            padding-left: 10px;
        }

        header h1 {
            font-size: 20px;
            margin: 0;
            color: {{ $setting->themePrimaryColor() }};
        }

        header p {
            font-size: 10px;
            margin: 2px 0 0 0;
            color: #555;
        }

        footer {
            position: fixed;
            bottom: -85px;
            left: 0;
            right: 0;
            height: 85px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            font-size: 9px;
            color: #888;
            text-align: left;
        }

        .patient-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .patient-info td {
            padding: 4px 6px;
            font-size: 11px;
            vertical-align: top;
        }

        .patient-info .label {
            color: #6b7280;
            width: 90px;
        }

        .patient-info .value {
            font-weight: bold;
            border-bottom: 1px dotted #ccc;
        }

        .report-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 15px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            padding: 6px 0;
        }

        table.results {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.results th {
            background-color: {{ $setting->themePrimaryColor() }};
            color: #fff;
            text-align: left;
            padding: 8px 6px;
            font-size: 11px;
        }

        table.results td {
            padding: 7px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        table.results .abnormal {
            color: #dc2626;
            font-weight: bold;
        }

        .comment-box {
            margin-top: 20px;
            padding: 10px;
            background: #f9fafb;
            border-left: 3px solid {{ $setting->themePrimaryColor() }};
            font-size: 11px;
        }

        .signature-area {
            margin-top: 50px;
            width: 100%;
        }

        .signature-area .sig-line {
            border-top: 1px solid #333;
            width: 180px;
            padding-top: 4px;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <header>
        <table>
            <tr>
                @if ($setting->logo)
                    <td class="logo-cell"><img src="{{ public_path('storage/' . $setting->logo) }}"></td>
                @endif
                <td class="name-cell">
                    <h1>{{ config('app.name') }}</h1>
                    <p>{{ $setting->address }}</p>
                    <p>Phone: {{ $setting->hotline }} @if ($setting->email)
                            | Email: {{ $setting->email }}
                        @endif
                    </p>
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 60px; vertical-align: top;">
                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" style="width: 55px; height: 55px;">
                </td>
                <td style="vertical-align: top; padding-left: 8px; text-align: left;">
                    This is a computer-generated report and does not require a signature. For any queries, contact:
                    {{ $setting->hotline }}
                    <br>Report ID: {{ $onlineReport->report_id }} · Generated: {{ now()->format('d M, Y h:i A') }}
                    <br>Scan QR code to verify report authenticity.
                </td>
            </tr>
        </table>
    </footer>

    <table class="patient-info">
        <tr>
            <td class="label">Patient Name</td>
            <td class="value">{{ $onlineReport->patient_name }}</td>
            <td class="label">Report ID</td>
            <td class="value">{{ $onlineReport->report_id }}</td>
        </tr>
        <tr>
            <td class="label">Age / Gender</td>
            <td class="value">{{ $onlineReport->age ?: '—' }}
                {{ $onlineReport->gender ? '/ ' . $onlineReport->gender : '' }}</td>
            <td class="label">Report Date</td>
            <td class="value">{{ $onlineReport->report_date?->format('d M, Y') ?: now()->format('d M, Y') }}</td>
        </tr>
        <tr>
            <td class="label">Patient ID</td>
            <td class="value">{{ $onlineReport->patient_ref_id ?: '—' }}</td>
            <td class="label">Referred By</td>
            <td class="value">{{ $onlineReport->referred_by ?: 'Self' }}</td>
        </tr>
        <tr>
            <td class="label">Phone</td>
            <td class="value">{{ $onlineReport->phone }}</td>
            <td class="label"></td>
            <td class="value"></td>
        </tr>
    </table>

    <div class="report-title">Laboratory Investigation Report</div>

    <table class="results">
        <thead>
            <tr>
                <th style="width: 40%;">Test Name</th>
                <th style="width: 15%;">Result</th>
                <th style="width: 15%;">Unit</th>
                <th style="width: 30%;">Normal Range</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($onlineReport->items as $item)
                <tr>
                    <td>{{ $item->test_name }}</td>
                    <td class="{{ $item->is_abnormal ? 'abnormal' : '' }}">
                        {{ $item->result_value ?: '—' }}{{ $item->is_abnormal ? ' *' : '' }}</td>
                    <td>{{ $item->unit ?: '—' }}</td>
                    <td>{{ $item->normal_range ?: '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($onlineReport->items->where('is_abnormal', true)->count())
        <p style="font-size: 10px; color: #dc2626; margin-top: 8px;">* indicates value outside the normal reference
            range.</p>
    @endif

    @if ($onlineReport->comment)
        <div class="comment-box">
            <strong>Comment:</strong><br>
            {{ $onlineReport->comment }}
        </div>
    @endif

    <table class="signature-area">
        <tr>
            <td style="width: 60%;"></td>
            <td>
                <div class="sig-line">
                    {{ $onlineReport->verified_by ?: 'Consultant Pathologist' }}<br>
                    <span style="color: #888;">Verified By</span>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
