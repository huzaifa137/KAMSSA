<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background: white;
        }

        body {
            width: 297mm;
            height: 210mm;
            margin: auto;
            background: #FFF;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CERTIFICATE CONTAINER */
        .certificate {
            width: 287mm;
            height: 198mm;

            position: relative;

            margin-left: auto;
            margin-right: auto;
            margin-top: 6mm;
            margin-bottom: 6mm;

            display: block;
        }

        /* BORDER IMAGE */
        .certificate-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .certificate-bg img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            display: block;
        }

        /* CONTENT INSIDE BORDER */
        .certificate-content {
            position: absolute;
            left: 22mm;
            right: 22mm;
            top: 10mm;
            /* top: 16mm; */
            bottom: 18mm;
        }

        /* BISMILLAH */

        .bismillah {
            text-align: center;
            color: #1e5cc4;
            font-size: 24px;
            font-weight: bold;
        }

        .bismillah-translation {
            text-align: center;
            font-style: italic;
            font-size: 13px;
            margin-bottom: 15px;
        }

        /* HEADER */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left {
            width: 40%;
        }

        .left h2 {
            margin: 0;
            font-size: 22px;
        }

        .red {
            color: #b11226;
            font-weight: bold;
        }

        .left h3 {
            margin: 5px 0;
        }

        .left h4 {
            margin-top: 8px;
        }

        .center-logo {
            width: 110px;
            height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .right {
            width: 40%;
            text-align: right;
            direction: rtl;
        }

        .right h3 {
            margin: 5px 0;
        }

        /* ARABIC PARAGRAPH */

        .arabic {
            direction: rtl;
            text-align: justify;
            /* changed from 'right' */
            font-size: 20px;
            line-height: 1.7;
            margin-top: 10px;
        }

        .english {
            margin-top: 8px;
            font-size: 16px;
            line-height: 1.7;
            font-family: Tahoma, Arial, sans-serif;
            text-align: justify;
            /* add this */
        }

        /* ENGLISH PARAGRAPH */

        /* FOOTER */

        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .footer-col,
        .sno-section,
        .footer-empty {
            flex: 1;
            text-align: center;
        }

        .footer-col strong,
        .footer-col b {
            white-space: nowrap;
        }

        .sign {
            margin-top: 15px;
        }

        .qr {
            width: 90px;
            height: 90px;
            margin-top: 8px;
            background: repeating-linear-gradient(45deg,
                    black,
                    black 5px,
                    white 5px,
                    white 10px);
        }

        .date-ar {
            direction: rtl;
        }

        * {
            box-sizing: border-box;
        }

        .nowrap {
            white-space: nowrap;
        }

        .signature-space {
            height: 60px;
        }

        .watermark {
            position: absolute;
            top: 65%;
            left: 42%;
            transform: translate(-50%, -50%);
            z-index: 0;
            opacity: 0.3;
            width: 200px;
            height: auto;
            pointer-events: none;
        }

        .certificate-content>* {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>

    @php
        use App\Http\Controllers\Helper;
        $currentDate = date('d/m/Y');
    @endphp

    <div class="certificate">

        <div class="certificate-bg">
            <img src="{{ asset('/assets/certificates/border.jpg') }}">
        </div>

        <div class="watermark">
            <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="Watermark">
        </div>

        <div class="certificate-content">

            <div class="header">

                <div class="left">
                    <h2 style="color: #026837;">Kampala Integrated Secondary School Examination Bureau</h2>
                    <h3 class="red">KAMSSA</h3>
                    @if ($level == "A'LEVEL")
                        <h3 style="text-align: center;"><strong>'A' LEVEL Certificate </strong></h3>
                    @else
                        <h3 style="text-align: center;"><strong>'O' LEVEL Certificate </strong></h3>
                    @endif
                </div>


                <div class="center-logo">
                    <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="KAMSSA logo"
                        style="max-width: 150%; max-height: 150%;">
                </div>


                <div class="right">
                    <h2 style="color: #026837;">Uganda</h2>
                    <h3 class="red">Secondary Examinations Board</h3>
                </div>
            </div>

            @if ($categoryCode == "UACE")
                @php
                    $allSubjectCodes = DB::table('master_datas')
                        ->where('md_master_code_id', config('constants.options.UACEPapers'))
                        ->pluck('md_code');
                    $stats = Helper::calculatePasslipStats(
                        $studentId,
                        $allSubjectCodes,
                        $studentCategory,
                        $year,
                        $schoolId,
                    );
                @endphp
            @else
                @php
                    $allSubjectCodes = DB::table('master_datas')
                        ->where('md_master_code_id', config('constants.options.UCEPapers'))
                        ->pluck('md_code');
                    $stats = Helper::calculatePasslipStats(
                        $studentId,
                        $allSubjectCodes,
                        $studentCategory,
                        $year,
                        $schoolId,
                    );
                @endphp
            @endif

            <div class="english">
                The Board hereby certifies that <b>{{ Helper::getStudentName($studentId) }}</b> Born in
                <b>{{ Helper::getStudentYearofBirth($studentId) }}</b> of
                <b>{{ Helper::getStudentNationality($studentId) }}</b> Nationality, sat for the
                final examinations in
                <b>{{ Helper::getStudentAdmissionYear($studentId) }}</b>,
                at <b>{{ Helper::getStudentSchool($studentId) }}</b> under registration Number
                <b>{{ $studentId }}</b>, after successful completion of
                <b>{{ $level == "O'LEVEL" ? 'O-LEVEL (UCE)' : 'A-LEVEL (UACE)' }}</b> and passed with
                <b>{{ $stats['average'] }}%</b>.
                Grade: <b>{{ $stats['grade'] }}</b>.
            </div>

            <div class="footer">

                <div class="footer-col">
                    <div>Date of Issue {{ $currentDate }}</div>
                    <div class="sign">
                        <div class="signature-space"></div>
                        <strong style="white-space: nowrap;">Secretary for
                            Education (KAMSSA)</strong>
                    </div>
                </div>


                <div class="sno-section" style="display: flex; flex-direction: column; align-items: center;">
                    <div style="padding-bottom: 5px;"><strong>SNO: {{ $snoRank }}</strong></div>
                    <div id="qr" style="display: flex; justify-content: center;"></div>
                </div>

                <div class="footer-empty">
                    &nbsp;
                </div>

                <div class="footer-col">
                    <div>&nbsp;</div>
                    <div class="sign">
                        <div class="signature-space"></div>
                        <strong style="white-space: nowrap;">Executive Secretary
                            (KAMSSA)</strong>

                    </div>
                </div>

            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    window.onload = function () {

        const qrData = "Name: {{ $studentRegisteredname }}\nIndex No: {{ $studentRegisteredNumber }}\nGrade: {{ $studentAchievedGrade }}";

        if (window.self !== window.top) {
            new QRCode(document.getElementById("qr"), {
                text: qrData,
                width: 90,
                height: 90,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            return;
        }

        const element = document.querySelector('.certificate');

        new QRCode(document.getElementById("qr"), {
            text: qrData,
            width: 90,
            height: 90,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        const opt = {
            margin: 0,
            filename: 'certificate_{{ $studentId }}.pdf',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 4, useCORS: true, scrollY: 0 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        setTimeout(function () {
            html2pdf().set(opt).from(element).save();
        }, 500);
    };
</script>
</body>

</html>