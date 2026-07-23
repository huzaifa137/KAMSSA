<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pass Slip</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: Arial, sans-serif;
        }

        .document-container {
            width: 204mm;
            height: 289mm;
            padding: 5mm;
            box-sizing: border-box;
            background-color: #fff;
            position: relative;
            overflow: hidden;
            margin: 0 auto;
        }

        header {
            text-align: center;
            position: relative;
            margin-bottom: 0;
            padding-bottom: 10px;
        }

        header::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: 6px;
            width: 100%;
            border-bottom: 2px solid #074603;
        }

        header::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            border-bottom: 4px solid #074603;
        }

        .header-english {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }

        .logo-section {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pass-slip-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
        }

        .pass-slip-banner h1 {
            font-size: 22px;
            margin: 0;
        }

        .student-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            border: 1px solid #000;
            padding: 5px;
        }

        .info-col {
            width: 48%;
        }

        .info-col.center {
            text-align: center;
        }

        .info-row {
            display: flex;
            margin-bottom: 2px;
        }

        .info-col.center .info-row {
            justify-content: center;
        }

        .label {
            font-weight: bold;
            min-width: 70px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            page-break-inside: avoid;
            position: relative;
            z-index: 1;
            border: 1px solid #000;
        }

        th, td {
            border: 0.5px solid #000;
            padding: 2px 3px;
            text-align: center;
        }

        .category-row {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer-stats {
            margin-top: 5px;
            border: 1px solid #000;
            padding: 5px;
            font-size: 10px;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="document-container">
        @php
            use App\Http\Controllers\Helper;
            use Illuminate\Support\Facades\DB;

            // Define the function only once per request
            if (!function_exists('getGradeForMark')) {
                function getGradeForMark($mark, $category)
                {
                    $grade = DB::table('grading_settings')
                        ->where('category', $category)
                        ->where('type', 'Marks')
                        ->where('from_mark', '<=', $mark)
                        ->where('to_mark', '>=', $mark)
                        ->value('grade');
                    return $grade ?: 'N/A';
                }
            }
        @endphp

        {{-- HEADER --}}
        <header>
            <div class="header-english">KAMSSA — KAMPALA INTEGRATED SECONDARY SCHOOL EXAMINATION BUREAU</div>
            <div class="logo-section">
                <div class="logo-placeholder">
                    <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="KAMSSA logo"
                        style="max-width: 120%; max-height: 120%; object-fit: contain;">
                </div>
            </div>
        </header>

        {{-- PASS SLIP TITLE --}}
        <div class="pass-slip-banner">
            <h1 style="font-family:Georgia, 'Times New Roman', Times, serif">PASS SLIP</h1>
        </div>

        {{-- STUDENT INFO (no photo) --}}
        <div class="student-info">
            <div class="info-col">
                <div class="info-row"><span class="label">NAME:</span> {{ Helper::getStudentName($studentId) }}</div>
                <div class="info-row"><span class="label">INDEX NO:</span> {{ $studentId }}</div>
                <div class="info-row"><span class="label">GENDER:</span> {{ Helper::getStudentSex($studentId) }}</div>
                <div class="info-row"><span class="label">SCH NAME:</span> {{ Helper::getStudentSchool($studentId) }}</div>
            </div>

            <div class="info-col center">
                <div class="info-row">
                    <span class="label">LEVEL:</span>
                    @if ($categoryCode == "UACE")
                        <span>A'LEVEL</span>
                    @elseif ($categoryCode == "PLE")
                        <span>PRIMARY LEVEL</span>
                    @else
                        <span>O'LEVEL</span>
                    @endif
                </div>
                <div class="info-row">
                    <span class="label">YEAR:</span>
                    <span>{{ $year }}</span>
                </div>
            </div>
        </div>

        {{-- RESULTS TABLE (GRADE column) --}}
        <table>
            <thead>
                <tr>
                    <th style="width:30px;">#</th>
                    <th style="width:80px;">PAPER CODE</th>
                    <th>PAPER</th>
                    <th style="width:60px;">GRADE</th>
                </tr>
            </thead>
            <tbody>
                @php $serial = 1; @endphp
                @foreach ($categories as $category)
                    <tr class="category-row">
                        <td colspan="4" style="text-align:left;">{{ $category['title_en'] }}</td>
                    </tr>
                    @foreach ($category['codes'] as $code)
                        @if (isset($subjects[$code]))
                            @php
                                $mark = floor(Helper::getStudentMarksBySubject(
                                    $studentId,
                                    $code,
                                    $studentCategory,
                                    $year,
                                    $schoolId
                                ));
                                $grade = getGradeForMark($mark, $categoryCode);
                            @endphp
                            <tr>
                                <td>{{ $serial++ }}</td>
                                <td>{{ $code }}</td>
                                <td style="text-align:left;">
                                    @if ($categoryCode == "UACE")
                                        {{ \Illuminate\Support\Str::upper(
                                            Helper::getPasslipSubjectEnName(config('constants.options.UACEPapers'), $code)
                                        ) }}
                                    @elseif ($categoryCode == "PLE")
                                        {{ \Illuminate\Support\Str::upper(
                                            Helper::getPasslipSubjectEnName(config('constants.options.PLEPapers'), $code)
                                        ) }}
                                    @else
                                        {{ \Illuminate\Support\Str::upper(
                                            Helper::getPasslipSubjectEnName(config('constants.options.UCEPapers'), $code)
                                        ) }}
                                    @endif
                                </td>
                                <td>{{ $grade }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>

        {{-- FOOTER STATS --}}
        @php
            $pleConstant = config('constants.options.PLEPapers');
            if ($categoryCode == "UACE") {
                $allSubjectCodes = DB::table('master_datas')
                    ->where('md_master_code_id', config('constants.options.UACEPapers'))
                    ->pluck('md_code');
            } elseif ($categoryCode == "PLE") {
                $allSubjectCodes = DB::table('master_datas')
                    ->where('md_master_code_id', $pleConstant)
                    ->pluck('md_code');
            } else {
                $allSubjectCodes = DB::table('master_datas')
                    ->where('md_master_code_id', config('constants.options.UCEPapers'))
                    ->pluck('md_code');
            }
            $stats = Helper::calculatePasslipStats($studentId, $allSubjectCodes, $studentCategory, $year, $schoolId);
        @endphp

        <div class="footer-stats">
            <div class="stat-row">
                <span style="padding-left:5px;">TOTAL MARK: {{ $stats['total'] }}</span>
            </div>
            <div class="stat-row">
                <span style="padding-left:5px;">AVERAGE SCORE: {{ $stats['average'] }}</span>
            </div>
            <div class="stat-row">
                <span style="padding-left:5px;">GRADE: {{ $stats['grade'] }}</span>
            </div>
        </div>

        {{-- Watermark, Signatures, Grading Scale removed --}}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        window.onload = function () {
            if (window !== window.parent) return;

            const element = document.querySelector('.document-container');
            const opt = {
                margin: 0,
                filename: 'passlip_{{ $studentId }}.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 3, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };
            html2pdf().set(opt).from(element).save();
        };
    </script>
</body>

</html>