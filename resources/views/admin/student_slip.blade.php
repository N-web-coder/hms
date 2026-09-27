<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body { font-family: sans-serif; font-size: 14px;
                            font-family: DejaVu Sans, sans-serif; }
        .heading { text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
    </style>
</head>
<body>

    <div class="heading">Student Fee Payment Receipt</div>

    <table>
        <tr>
            <th>Student Name</th>
            <td>{{ $payment->user->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Amount Paid</th>
            <td>&#8377;{{ number_format($payment->amount) }} </td>
        </tr>
        <tr>
            <th>Payment Mode</th>
            <td>{{ $payment->payment_mode }}</td>
        </tr>
        <tr>
            <th>Reference No.</th>
            <td>{{ $payment->ref_no ?? '-' }}</td>
        </tr>
        <tr>
            <th>Payment Date</th>
            <td>{{ \Carbon\Carbon::parse($payment->date)->format('d M Y') }}</td>
        </tr>

    </table>

    <p style="margin-top: 40px;">Signature: ______________________</p>

</body>
</html>
