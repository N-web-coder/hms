<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
            color: #333;
        }

        .invoice-box {
            border: 1px solid #eee;
            padding: 20px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar img {
            height: 70px;
        }

        .invoice-title {
            background: #007bff;
            color: white;
            padding: 10px;
            font-size: 22px;
            font-weight: bold;
            text-align: right;
        }

        .details,
        .bank-info {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .details div,
        .bank-info div {
            width: 48%;
            float: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 13px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 300px;
        }

        .totals table {
            width: 100%;
        }

        .grand-total {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .signature {
            text-align: right;
            font-size: 14px;
        }

        .terms {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
        }

        .signature {
            width: 300px;
            margin-left: auto;
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="invoice-box">
        <div class="top-bar">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="Logo" style="height: 70px;">

            <div class="invoice-title"> INVOICE</div>
        </div>

        <div class="details d-flex justify-content-between align-items-center">
            <div>
                <p><strong>Invoice From:</strong><br>
                    {{ $companyInfo->owner }}
                    {{ $companyInfo->companyName }}
                    @if (!empty($companyInfo->address))
                        {{ $companyInfo->address }}
                    @endif
                    @if (!empty($companyInfo->city))
                        {{ $companyInfo->city }}
                    @endif
                    @if (!empty($companyInfo->pincode))
                        {{ $companyInfo->pincode }}
                    @endif
                    @if (!empty($companyInfo->state))
                        {{ $companyInfo->state }}
                    @endif
                    @if (!empty($companyInfo->gst))
                        GST : {{ $companyInfo->gst }}
                    @endif
                    <br>
                </p>
            </div>

            <div style="width: 48%; float: right; text-align: right;">
                <p><strong>Invoice To:</strong><br>
                    {{ $student->name }}<br>
                    {{ $student->email }}<br>
                    {{ $student->mobile }}<br>
                    Address: {{ $invoice->admission->address }}<br>
                    Pincode: {{ $invoice->admission->pincode }}
                </p>
            </div>


        </div>

        <p><strong>Invoice No:</strong> {{ $invoice->invoice_no }} &nbsp;&nbsp;
            <strong>Date:</strong> {{ $invoice->invoice_date }}
        </p>
        <p><strong>Payment Status:</strong> {{ ucfirst($invoice->status) }}</p>


        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Discount</th>
                    <th>Tax</th>
                    <th>Remarks</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ ucfirst($invoice->feeType->name) }}</td>
                    <td>&#8377; {{ number_format($invoice->gross_amount, 2) }}</td>
                    <td>1</td>
                    <td>&#8377; {{ number_format($invoice->discount_amount, 2) }}</td>
                    <td>&#8377; {{ number_format($invoice->tax_amount, 2) }}</td>
                    <td>&#8377; {{ $invoice->remarks ?? 'N/A' }}</td>
                    <td>&#8377; {{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:20px; overflow:hidden; font-size:14px;">
            <div style="width:48%; float:left;">
                <p><strong>Payment Mode:</strong> {{ ucfirst($invoice->payment_mode) }}</p>
                <p><strong>Bank Info:</strong><br>
                    A/C Holder: {{ $account->account_holder ?? 'N/A' }}<br>
                    Account No: {{ $account->account ?? 'N/A' }}<br>
                    IFSC: {{ $account->ifsc ?? 'N/A' }}<br>
                    Bank: {{ $account->bank_name ?? 'N/A' }}</p>
            </div>

            <div style="width:48%; float:right;">
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td>Sub Total</td>
                        <td> &#8377; {{ number_format($invoice->gross_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td> &#8377; {{ number_format($invoice->tax_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td> &#8377; {{ number_format($invoice->discount_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td> &#8377; 0.00</td>
                    </tr>
                    <tr style="background:#007bff; color:#fff; font-weight:bold;">
                        <td>Grand Total</td>
                        <td> &#8377; {{ number_format($invoice->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Paid Amount</td>
                        <td> &#8377; {{ number_format($invoice->paid_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="signature" style="width: 300px; margin-left: auto; margin-top: 50px; text-align: right;">
            <p><strong>{{ Auth::user()->name }}</strong></p>
            <p>Authorized Signature</p>
        </div>


        <div class="terms">
            <p><strong>Terms & Conditions:</strong> Payment due within 7 days.</p>
        </div>
    </div>
</body>

</html>
