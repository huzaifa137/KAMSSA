<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #287C44;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #287C44;
            font-size: 24px;
            margin: 0 0 5px 0;
        }

        .header h3 {
            color: #555;
            font-size: 16px;
            margin: 0;
        }

        .summary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            margin-bottom: 20px;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #287C44;
            color: white;
            font-weight: bold;
            padding: 10px 5px;
            text-align: center;
            border: 1px solid #1e5f33;
        }

        td {
            padding: 8px 5px;
            border: 1px solid #dee2e6;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>{{ $company_name }}</h1>
        <h3>School Passwords Master List</h3>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td><strong>Total Records:</strong> {{ $total_records }} Schools</td>
                <td><strong>Export Date:</strong> {{ $export_date }}</td>
            </tr>
            <tr>
                <td><strong>Exported By:</strong> {{ $exported_by }}</td>
                <td></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="8%">Sr.</th>
                <th width="20%">School ID</th>
                <th width="52%">School Name</th>
                <th width="20%">Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($passwords as $password)
                <tr>
                    <td class="text-center">{{ $password['sr_no'] }}</td>
                    <td class="text-center">{{ $password['school_id'] }}</td>
                    <td>{{ $password['school_name'] }}</td>
                    <td class="text-center" style="font-family: monospace; font-weight: bold;">
                        {{ $password['password_plain'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This document contains confidential information. Unauthorized distribution is prohibited.</p>
        <p>© {{ date('Y') }} {{ $company_name }}. All rights reserved.</p>
    </div>

</body>

</html>
