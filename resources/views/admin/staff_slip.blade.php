<!DOCTYPE html>
<html>

<head>
    <title>Salary Slip</title>
    <style>
        body {
            font-family: sans-serif;
                    font-family: DejaVu Sans, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 8px;

    }
</style>

</head>

<body>

    <h2>Staff Salary Slip</h2>

    <table>
        <tr>
            <th>Staff Name</th>
            <td>{{ $salary->account->account_holder }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ \Carbon\Carbon::parse($salary->date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Gross Amount</th>
            <td>&#8377;{{ number_format($salary->gross_amount, 2) }}</td>
        </tr>
        <tr>
            <th>Deduction</th>
            <td>&#8377;{{ number_format($salary->deduct_amount, 2) }}</td>
        </tr>
        <tr>
            <th>Net Pay</th>
            <td>&#8377;{{ number_format($salary->net_amount, 2) }}</td>

        </tr>
        <tr>
            <th>Bank</th>
            <td>{{ $salary->account->bank_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Account No.</th>
            <td>{{ $salary->account->account ?? '-' }}</td>
        </tr>
        <tr>
            <th>IFSC</th>
            <td>{{ $salary->account->ifsc ?? '-' }}</td>
        </tr>
    </table>

    <p style="margin-top: 40px;">Signature: ____________________________</p>

</body>

</html>
