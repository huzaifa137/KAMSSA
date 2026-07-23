<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        {{ $category === 'UACE' ? 'A Level Subject Performance' : ($category === 'PLE' ? 'PLE Subject Performance' : 'O Level Subject Performance') }}
    </title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
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
            margin: 0 auto;
            background: #fff;
            padding: 14mm 14mm;
        }

        .box {
            border: 2px solid #000;
            padding: 14px 22px 12px 22px;
        }

        .box-header {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 14px;
            position: relative;
        }

.box-header .logo-circle {
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

.box-header .logo-circle img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}


        .box-header h1 {
            font-size: 19px;
            font-weight: bold;
            text-align: center;
            margin: 2px 0;
            line-height: 1.3;
        }

        .box-title {
            text-align: center;
            font-weight: bold;
            font-size: 13.5px;
            margin: 6px 0 2px 0;
            letter-spacing: .5px;
        }

        .box-meta {
            text-align: center;
            font-size: 12.5px;
            margin-bottom: 14px;
        }

        table.perf-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        table.perf-table th,
        table.perf-table td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: center;
        }

        table.perf-table th.subj-col,
        table.perf-table td.subj-col {
            text-align: left;
        }

        table.perf-table th {
            font-weight: bold;
        }

        .box-footer {
            text-align: center;
            font-style: italic;
            font-size: 11px;
            margin-top: 16px;
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
                width: auto;
                min-height: auto;
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

    <div class="sheet">
        <div class="box">
            <div class="box-header">
    <div class="logo-circle">
        <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="KAMSSA Logo">
    </div>

    <h1>
        KAMPALA INTEGRATED SECONDARY SCHOOLS'<br>
        EXAMINATION BUREAU {{ $year }}
    </h1>
</div>


            <div class="box-title">
                {{ $category === 'UACE' ? 'UACE MOCK SUBJECTSLIP' : ($category === 'PLE' ? 'PLE MOCK SUBJECTSLIP' : 'UCE MOCK SUBJECTSLIP') }}
            </div>
            <div class="box-meta">
                SCHOOL {{ strtoupper($schoolName) }} &nbsp; DISTRICT {{ strtoupper($schoolDistrict) }} &nbsp; TEST
                CENTER NO: NA
            </div>

            <table class="perf-table">
                <thead>
                    <tr>
                        <th class="subj-col">Subject</th>
                        @foreach($gradeScale as $g)
                            <th>{{ $g }}</th>
                        @endforeach
                        @if($showPassColumn)
                            <th>% Pass</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $i => $row)
                        <tr>
                            <td class="subj-col">{{ $i + 1 }}. {{ $row['subject']->md_name }}</td>
                            @foreach($gradeScale as $g)
                                <td>{{ $row['tally'][$g] ?? 0 }}</td>
                            @endforeach
                            @if($showPassColumn)
                                <td>{{ number_format($row['percent_pass'], 2) }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="box-footer">&quot;Quality assessment for reliable results&quot;</div>
        </div>
    </div>

</body>

</html>