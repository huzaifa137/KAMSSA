<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        {{ $category === 'UACE' ? 'A Level Student Report' : ($category === 'PLE' ? 'PLE Student Report' : 'O Level Student Report') }}
    </title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background: #e9e9e9;
        }

        .toolbar {
            padding: 14px 18px;
        }

        .toolbar button {
            background: #0b6b3a;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .sheet {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto 12px auto;
            background: #fff;
            padding: 10mm 12mm;
        }

        .passlip-box {
            border: 2px solid #000;
            padding: 10px 16px 8px 16px;
            margin-bottom: 8mm;
            height: 84mm;
            overflow: hidden;
        }

        .sheet .passlip-box:last-child {
            margin-bottom: 0;
        }

        .slip-header {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 14px;
            position: relative;
        }

        .slip-header .logo-circle {
            position: absolute;
            left: 0;
            top: -2px;
            width: 60px;
            height: 60px;
            border: none;
            border-radius: 0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slip-header .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }



        .slip-header h1 {
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            margin: 0;
            line-height: 1.3;
        }

        .slip-title {
            text-align: center;
            font-weight: bold;
            font-size: 12.5px;
            letter-spacing: .5px;
            margin: 4px 0 2px 0;
        }

        .slip-meta {
            text-align: center;
            font-size: 11.5px;
            margin-bottom: 6px;
        }

        .slip-meta .combination-line {
            font-weight: bold;
            margin-top: 1px;
        }

        table.slip-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
        }

        table.slip-table th,
        table.slip-table td {
            border: 1px solid #000;
            padding: 2px 8px;
        }

        table.slip-table th {
            font-weight: bold;
            text-align: left;
        }

        table.slip-table td.grade-col,
        table.slip-table th.grade-col {
            text-align: center;
            width: 90px;
        }

        table.slip-table td.no-col,
        table.slip-table th.no-col {
            width: 34px;
            text-align: center;
        }

        .slip-total-row td {
            font-weight: bold;
        }

        .slip-footer {
            text-align: center;
            font-style: italic;
            font-size: 10.5px;
            margin-top: 6px;
        }

        @media print {
            body {
                background: #fff;
            }

            .toolbar {
                display: none;
            }

            .sheet {
                margin: 0;
                box-shadow: none;
                width: auto;
                min-height: auto;
            }

            .page-break {
                page-break-after: always;
            }
        }

        @page {
            size: A4;
            margin: 8mm;
        }
    </style>
</head>

<body>

    <div class="toolbar">
        <button onclick="window.print()"><i class="fa fa-print"></i> Print</button>
    </div>

    @forelse($chunks as $chunk)
        <div class="sheet {{ !$loop->last ? 'page-break' : '' }}">
            @foreach($chunk as $slip)
                <div class="passlip-box">
                    <div class="slip-header">
                        <div class="logo-circle">
                            <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="KAMSSA Logo">
                        </div>

                        <h1>KAMPALA INTEGRATED SECONDARY SCHOOLS'<br>EXAMINATION BUREAU {{ $year }}</h1>
                    </div>

                    <div class="slip-title">
                        {{ $category === 'UACE' ? 'UACE MOCK PASSLIP' : ($category === 'PLE' ? 'PLE MOCK PASSLIP' : 'MOCK PASSLIP') }}
                    </div>

                    <div class="slip-meta">
                        @if($category === 'UACE')
                            <span style="font-weight:Bold;"><span style="font-weight:Bold;">Student's
                                    Name</span></span>{{ strtoupper($slip['name']) }} &nbsp; SCHOOL
                            {{ strtoupper($slip['school']) }} &nbsp; DISTRICT {{ strtoupper($slip['district']) }} &nbsp; TEST CENTER
                            NO: NA
                            <div class="combination-line">COMBINATION {{ $slip['combination_code'] ?? 'NA' }}</div>
                        @else
                            <span style="font-weight:Bold;">Student's Name</span> {{ strtoupper($slip['name']) }} &nbsp; <span
                                style="font-weight:Bold;">School</span> {{ strtoupper($slip['school']) }} &nbsp; <span
                                style="font-weight:Bold;">District</span> {{ strtoupper($slip['district']) }} &nbsp; <span
                                style="font-weight:Bold;">Center No:</span> NA
                        @endif
                    </div>

                    <table class="slip-table">
                        <thead>
                            <tr>
                                @if($category === 'UACE')
                                    <th class="no-col">No</th>
                                @endif
                                <th>Subject</th>
                                <th class="grade-col">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slip['results'] as $i => $r)
                                <tr>
                                    @if($category === 'UACE')
                                        <td class="no-col">{{ $i + 1 }}</td>
                                    @endif
                                    <td>{{ $r['subject']->md_name }}</td>
                                    <td class="grade-col">{{ $r['grade'] }}</td>
                                </tr>
                            @endforeach
                            @if($category === 'UACE')
                                <tr class="slip-total-row">
                                    <td colspan="2">TOTAL: POINTS</td>
                                    <td class="grade-col">{{ $slip['total_points'] }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="slip-footer">&quot;Quality assessment for reliable results&quot;</div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="sheet">
            <p style="text-align:center;margin-top:40px;">No students found for the selected filters.</p>
        </div>
    @endforelse

</body>

</html>