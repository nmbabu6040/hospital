<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 100px 40px 90px 40px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
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
            bottom: -70px;
            left: 0;
            right: 0;
            height: 70px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            font-size: 9px;
            color: #888;
            text-align: left;
        }

        .invoice-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: {{ $setting->themePrimaryColor() }};
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 4px 6px;
            font-size: 11px;
            vertical-align: top;
        }

        .info-table .label {
            color: #6b7280;
            width: 90px;
        }

        .info-table .value {
            font-weight: bold;
            border-bottom: 1px dotted #ccc;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.items th {
            background-color: {{ $setting->themePrimaryColor() }};
            color: #fff;
            text-align: left;
            padding: 8px 6px;
            font-size: 11px;
        }

        table.items td {
            padding: 7px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        table.items .text-right {
            text-align: right;
        }

        .totals-table {
            width: 100%;
            margin-top: 10px;
        }

        .totals-table td {
            padding: 4px 6px;
            font-size: 12px;
            text-align: right;
        }

        .totals-table .grand-total {
            font-size: 15px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 8px;
            color: {{ $setting->themePrimaryColor() }};
        }

        .payment-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            background-color: {{ $invoice->payment_status == 'paid' ? '#dcfce7' : '#fef3c7' }};
            color: {{ $invoice->payment_status == 'paid' ? '#15803d' : '#92400e' }};
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
                <td style="width: 55px; vertical-align: top;">
                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" style="width: 50px; height: 50px;">
                </td>
                <td style="vertical-align: top; padding-left: 8px;">
                    This is a computer-generated invoice and does not require a signature.
                    <br>Invoice No: {{ $invoice->invoice_no }} · Generated: {{ now()->format('d M, Y h:i A') }}
                    <br>Scan QR code to verify invoice details.
                </td>
            </tr>
        </table>
    </footer>

    <div class="invoice-title">Invoice</div>

    <table class="info-table">
        <tr>
            <td class="label">Invoice No</td>
            <td class="value">{{ $invoice->invoice_no }}</td>
            <td class="label">Date</td>
            <td class="value">{{ $invoice->invoice_date->format('d M, Y') }}</td>
        </tr>
        <tr>
            <td class="label">Patient Name</td>
            <td class="value">{{ $invoice->patient_name }}</td>
            <td class="label">Phone</td>
            <td class="value">{{ $invoice->phone }}</td>
        </tr>
        @if ($invoice->hospital)
            <tr>
                <td class="label">Branch</td>
                <td class="value">{{ $invoice->hospital->name }}</td>
                <td class="label">Payment Status</td>
                <td class="value"><span class="payment-badge">{{ ucfirst($invoice->payment_status) }}</span></td>
            </tr>
        @else
            <tr>
                <td class="label">Payment Status</td>
                <td class="value"><span class="payment-badge">{{ ucfirst($invoice->payment_status) }}</span></td>
                <td class="label"></td>
                <td class="value"></td>
            </tr>
        @endif
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 45%;">Item Description</th>
                <th style="width: 15%;" class="text-right">Qty</th>
                <th style="width: 20%;" class="text-right">Unit Price</th>
                <th style="width: 20%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Tk {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">Tk {{ number_format($item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td style="width: 70%;"></td>
            <td>Subtotal: Tk {{ number_format($invoice->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Discount: Tk {{ number_format($invoice->discount, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="grand-total">Total: Tk {{ number_format($invoice->total, 2) }}</td>
        </tr>
    </table>

    @if ($invoice->payment_method)
        <p style="margin-top: 15px; font-size: 11px;"><strong>Payment Method:</strong> {{ $invoice->payment_method }}
        </p>
    @endif

    @if ($invoice->notes)
        <div
            style="margin-top: 15px; padding: 10px; background: #f9fafb; border-left: 3px solid {{ $setting->themePrimaryColor() }}; font-size: 11px;">
            <strong>Notes:</strong> {{ $invoice->notes }}
        </div>
    @endif

</body>

</html>
