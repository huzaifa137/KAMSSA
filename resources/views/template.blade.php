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

        html,
        body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: Arial, sans-serif;
        }

        th.code-col {
            width: 80px;
            padding: 5px;
            font-weight: bold;
        }

        td.code-col {
            width: 80px;
            padding: 5px;
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

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
            text-align: center;
            width: 100%;
            opacity: 0.4;
        }

        .watermark img {
            width: 40%;
            display: block;
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

        .header-arabic {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
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
        }

        .info-col:nth-child(3) {
            word-break: break-word;
        }

        .info-col:nth-child(1) {
            width: 30%;
        }

        .info-col.center {
            width: 20%;
            text-align: center;
        }

        .info-col:nth-child(3) {
            width: 50%;
        }

        .info-col {
            width: 32%;
        }

        .info-col.center {
            text-align: center;
        }

        .info-col.center .label {
            display: inline-block;
            width: 70px;
            text-align: left;
        }

        .info-row {
            display: flex;
            margin-bottom: 2px;
        }

        .label {
            font-weight: bold;
            min-width: 70px;
        }

        .photo-box {
            width: 80px;
            height: 100px;
            border: 1px solid #000;
            background-color: #ddd;
            text-align: center;
            line-height: 100px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            page-break-inside: avoid;
            position: relative;
            z-index: 1;
        }

        th,
        td {
            border: 0.5px solid #000;
            padding: 2px 3px;
            text-align: center;
            border-collapse: collapse;
        }

        .category-row {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .score-col,
        .code-col {
            font-weight: normal;
            width: 50px;
        }

        .footer-stats {
            margin-top: 5px;
            border-top: 2px solid #000;
            padding-top: 3px;
            font-size: 10px;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            font-weight: bold;
            margin-bottom: 1em;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            text-align: center;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            text-align: center;
        }

        .sig-box {
            width: 160px;
            text-align: center;
            font-size: 10px;
        }

        .sig-img {
            height: 60px;
            margin-bottom: 5px;
        }

        .sig-img img {
            max-height: 60px;
            max-width: 140px;
            object-fit: contain;
        }

        .sig-line {
            border-top: 1px solid transparent;
            margin-top: 5px;
            padding-top: 3px;
            font-weight: bold;
        }

        .grading-scale {
            margin-top: 10px;
            font-size: 9px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 5px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            font-weight: bold;
        }

        /* Center column rows */
        .info-col.center .info-row {
            display: flex !important;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .info-col.center .label {
            width: 60px;
            text-align: right;
            font-weight: bold;
        }

        .info-col.center .value {
            width: 60px;
            text-align: left;
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

        th,
        td {
            border: 0.25px solid #333;
            padding: 2px 3px;
            text-align: center;
        }

        th,
        td {
            border-style: solid;
            border-color: #000;
            border-width: 0.5px;
            padding: 2px 3px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="document-container">
        @php
        use App\Http\Controllers\Helper;
        @endphp
        <div class="watermark">
            <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="Covido logo">
        </div>

        <header>
            <div class="header-arabic" style="color: #1e5cc4;">بسم الله الرحمن الرحيم</div>
            <div class="header-arabic" style="direction: rtl;">
    هيئة الامتحانات الإعدادية والثانوية (أوغندا)
</div>
            <div class="header-english">IDAAD AND THANAWI EXAMINATIONS BOARD (U)</div>

            <div class="logo-section">
                <div class="logo-placeholder">
                    <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="Covido logo"
                        style="max-width: 120%; max-height: 120%; object-fit: contain;">
                </div>
            </div>
        </header>

        <div class="pass-slip-banner">
            <h1 style="font-family:Georgia, 'Times New Roman', Times, serif">PASS SLIP</h1>
            <h1 style="direction: rtl;font-family:Georgia, 'Times New Roman', Times, serif;">كشف&nbsp;الدرجات</h1>
        </div>

        <div class="student-info" style="border: #000 solid 1px;">

            <!-- LEFT -->
            <div class="info-col" style="padding:5px;">
                <div class="info-row"><span class="label">NAME:</span> {{ Helper::getStudentName($studentId) }}</div>
                <div class="info-row"><span class="label">INDEX NO:</span> {{ $studentId }}</div>
                <div class="info-row"><span class="label">GENDER:</span> {{ Helper::getStudentSex($studentId) }}</div>
                <div class="info-row"><span class="label">SCH NAME:</span> {{ Helper::getStudentSchool($studentId) }}
                </div>
            </div>

            <!-- CENTER (NEW) -->
            <div class="info-col center" style="padding:5px;">
                <div class="info-row">
                    <span class="label">LEVEL:</span>
                    @if ($categoryCode == "TH")
<span class="value">A'LEVEL</span>
@elseif ($categoryCode == "PLE")
<span class="value">PRIMARY LEVEL</span>
@else
<span class="value">O'LEVEL</span>
@endif
                </div>

                <div class="info-row">
                    <span class="label">YEAR:</span>
                    <span class="value">{{ $year }}</span>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="info-col" style="text-align: right;">
                <div class="photo-box" style="float: right; margin-left: 10px;">
                    @php
                    $photo = public_path('assets/student_photos/' . $studentId . '.jpg');
                    @endphp

                    @if(file_exists($photo))
                    <img src="{{ asset('assets/student_photos/' . $studentId . '.jpg') }}"
                        style="width:100%; height:100%; object-fit:cover;">
                    @else
                    <img src="{{ asset('assets/images/default-user.png') }}"
                        style="width:100%; height:100%; object-fit:cover;">
                    @endif
                </div>

                <div style="font-weight: bold"> @if(Helper::getStudentSex($studentId) == 'Female')
                    اسم الطالبة
                    @else
                    اسم الطالب
                    @endif<span style="font-weight: normal;"> :
                        <span style="font-size:1.26em;">{!!
                            Helper::arabicWordSpacing(Helper::getStudentARName($studentId)) !!}</span></span>
                </div>
                <div style="font-weight: bold">المرحلة <span style="font-weight: normal;"> : <span
                            style="font-size:1.26em;">{{ Helper::getStudentARLevel($studentId) }}</span></span>
                </div>
                <div style="font-weight: bold">العام <span style="font-weight: normal;"> : <span
                            style="font-size:1.26em;">{{ Helper::toArabicNumberDate($year) }}</span></span>
                </div>
                <div style="font-weight: bold"> {!! Helper::arabicWordSpacing('اسم المدرسة ') !!} <span
                        style="font-weight: normal;"><span style="font-size:1.26em;">:
                            {!! Helper::arabicWordSpacing(Helper::ar_schoolName($schoolId)) !!}</span></span>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th class="code-col" style="font-weight: bold;">PAPER CODE</th>
                    <th style="font-weight: bold;">PAPER</th>
                    <th class="score-col" style="font-weight: bold;">SCORE</th>
                    <th class="score-col" style="font-weight: bold;">الدرجات</th>
                    <th style="font-weight: bold;">{!! Helper::arabicWordSpacing('اسم الورقة') !!}</th>
                    <th class="code-col" style="font-weight: bold;">رمز الورقة</th>
                </tr>
            </thead>
            @php $serial = 1; @endphp
            <tbody>
                @foreach ($categories as $category)
                <tr class="category-row">
                    <td colspan="3" style="text-align: left;">{{ $category['title_en'] }}</td>
                    <td colspan="4" style="text-align:right;">
                        {!! Helper::arabicWordSpacing($category['title_ar']) !!}
                    </td>
                </tr>

                @foreach ($category['codes'] as $code)
                @if (isset($subjects[$code]))
                <tr>
                    <td>{{ $serial++ }}</td> <!-- continuous serial number -->
                    <td class="code-col">{{ $code }}</td>

@if ($categoryCode == "TH")
<td style="text-align: left;">
    {{ \Illuminate\Support\Str::upper(
    Helper::getPasslipSubjectEnName(config('constants.options.ThanawiPapers'), $code)
    ) }}
</td>
@elseif ($categoryCode == "PLE")
<td style="text-align: left;">
    {{ \Illuminate\Support\Str::upper(
    Helper::getPasslipSubjectEnName(config('constants.options.PLEPapers'), $code)
    ) }}
</td>
@else
<td style="text-align: left;">
    {{ \Illuminate\Support\Str::upper(
    Helper::getPasslipSubjectEnName(config('constants.options.IdaadPapers'), $code)
    ) }}
</td>
@endif


                    <td class="score-col">
                        {{ floor(Helper::getStudentMarksBySubject(
                        $studentId,
                        $code,
                        $studentCategory,
                        $year,
                        $schoolId
                        )) }}
                    </td>

                    <td class="score-col">
                        {{ Helper::numberToArabicDB(Helper::getStudentMarksBySubject(
                        $studentId,
                        $code,
                        $studentCategory,
                        $year,
                        $schoolId
                        )) }}
                    </td>

@if ($categoryCode == "TH")
<td style="text-align:right;font-size:1.30em;">
    @php
    $subject = Helper::getPasslipSubjectARName(config('constants.options.ThanawiPapers'), $code);
    $words = explode(' ', $subject);
    $subjectWithSpacing = implode('&nbsp;', $words);
    @endphp
    {!! $subjectWithSpacing !!}
</td>
@elseif ($categoryCode == "PLE")
<td style="text-align:right;font-size:1.30em;">
    @php
    $subject = Helper::getPasslipSubjectARName(config('constants.options.PLEPapers'), $code);
    $words = explode(' ', $subject ?? '');
    $subjectWithSpacing = implode('&nbsp;', $words);
    @endphp
    {!! $subjectWithSpacing !!}
</td>
@else
<td style="text-align:right;font-size:1.30em;">
    @php
    $subject = Helper::getPasslipSubjectARName(config('constants.options.IdaadPapers'), $code);
    $words = explode(' ', $subject);
    $subjectWithSpacing = implode('&nbsp;', $words);
    @endphp
    {!! $subjectWithSpacing !!}
</td>
@endif

                    <td class="code-col">{{ $code }}</td>
                </tr>
                @endif
                @endforeach
                @endforeach
            </tbody>
        </table>

@php
$pleConstant = config('constants.options.PLEPapers');
if ($categoryCode == "TH") {
    $allSubjectCodes = DB::table('master_datas')
        ->where('md_master_code_id', config('constants.options.ThanawiPapers'))
        ->pluck('md_code');
} elseif ($categoryCode == "PLE") {
    $allSubjectCodes = DB::table('master_datas')
        ->where('md_master_code_id', $pleConstant)
        ->pluck('md_code');
} else {
    $allSubjectCodes = DB::table('master_datas')
        ->where('md_master_code_id', config('constants.options.IdaadPapers'))
        ->pluck('md_code');
}
$stats = Helper::calculatePasslipStats($studentId, $allSubjectCodes, $studentCategory, $year, $schoolId);
@endphp


        <div class="footer-stats" style="border:#000 solid 1px">
            <div class="stat-row">
                <span style="padding-left: 5px;">TOTAL MARK: {{ $stats['total'] }}</span>
                <span style="direction: rtl;padding-right: 5px;">المجموع
                    &nbsp; : {{ Helper::toArabicNumberDate($stats['total']) }}</span>
            </div>
            <div class="stat-row">
                <span style="padding-left: 5px;">AVERAGE SCORE: {{ $stats['average'] }}</span>
                <span style="direction: rtl;padding-right: 5px;">النسبة المئوية
                    &nbsp; : {{ Helper::toArabicNumberDate($stats['average']) }}</span>
            </div>
            <div class="stat-row">
                <span style="padding-left: 5px;">GRADE: {{ $stats['grade'] }}</span>
                <span style="direction: rtl;padding-right: 5px;">التقدير
                    &nbsp; : {{ Helper::getArabicGradeComment($stats['grade']) }}</span>
            </div>
        </div>

        <div class="signatures">

            <div class="sig-box">

                <strong style="font-size: 1.26em;;">{!! Helper::arabicWordSpacing('مدير هيئة الامتحانات') !!}</strong>

                <div class="sig-img">
                    <img src="{{ asset('assets/signatures/chairman.png') }}" alt="Chairman Signature">
                </div>

                <div class="sig-line" style="margin-top: 14px;">
                    CHAIRMAN
                </div>

            </div>

            <div class="sig-box">

                <strong style="font-size: 1.26em;">{!! Helper::arabicWordSpacing('السكرتير التنفيذي') !!}</strong>

                <div class="sig-img" style="margin-top: 14px;">
                    <img src="{{ asset('assets/signatures/Executive.png') }}" alt="Executive Secretary Signature">
                </div>

                <div class="sig-line">
                    EXECUTIVE SECRETARY
                </div>

            </div>

        </div>

        <div class="grading-scale">
            <div>80-100 - EXCELLENT (FIRST CLASS)</div>
            <div>70-79.9 - VERY GOOD (SECOND CLASS UPPER)</div>
            <div>60-69.9 - GOOD (SECOND CLASS LOWER)</div>
            <div>50-59.9 - PASS (THIRD CLASS)</div>
            <div>0-49.9 - FAIL</div>
        </div>

        <div style="display: flex; gap: 40px; align-items: center; margin-top:1em;">
            <div> ممتاز - {{ Helper::toArabicNumberPackge(80) }} - {{ Helper::toArabicNumberPackge(100) }}</div>
            <div> جيد جداً - {{ Helper::toArabicNumberPackge(70) }} - {{ Helper::toArabicNumberPackge(79.9) }}</div>
            <div>جيد - {{ Helper::toArabicNumberPackge(60) }} - {{ Helper::toArabicNumberPackge(69.9) }}</div>
            <div>مقبول - {{ Helper::toArabicNumberPackge(50) }} - {{ Helper::toArabicNumberPackge(59.9) }}</div>
            <div>راسب - {{ Helper::toArabicNumberPackge(0) }} - {{ Helper::toArabicNumberPackge(49.9) }}</div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        window.onload = function () {

            if (window !== window.parent) {
                return;
            }

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