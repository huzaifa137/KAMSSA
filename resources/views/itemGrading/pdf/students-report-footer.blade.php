<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Report Footer</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 1cm;
        }

        .footer-page {
            text-align: center;
            margin-top: 5cm;
        }

        .end-message {
            font-size: 16px;
            color: #c51619;
            margin: 20px 0;
        }

        .stats-summary {
            margin-top: 2cm;
            padding: 20px;
            background-color: #f8fafc;
            border: 1px solid #ddd;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
        }

        .signature {
            margin-top: 3cm;
            font-size: 12px;
        }

        .footer-note {
            position: absolute;
            bottom: 1cm;
            left: 1cm;
            right: 1cm;
            font-size: 9px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="footer-page">
        <div class="end-message">
            <h2>End of Report</h2>
            <p>Total Students: {{ $total }}</p>
        </div>

        <div class="stats-summary">
            <h4 style="color: #c51619;">Report Summary</h4>
            <p><strong>Total Pages:</strong> {{ ceil($total / 100) + 2 }}</p>
            <p><strong>Generated:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
            <p><strong>Report ID:</strong> {{ uniqid() }}</p>
        </div>

        <div class="signature">
            <p>_________________________</p>
            <p>Authorized Signature</p>
        </div>
    </div>

    <div class="footer-note">
        This is a computer generated document. No signature is required.
    </div>
</body>

</html>