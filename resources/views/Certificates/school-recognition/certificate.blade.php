<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>School Recognition Certificate – {{ $cert->certificate_number }}</title>
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

        /* ── CERTIFICATE CONTAINER ── */
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

        /* ── BORDER IMAGE ── */
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

        /* ── CONTENT INSIDE BORDER ──
           Matches the student certificate exactly: absolute, no flex,
           content just flows naturally top-to-bottom. Footer sits where
           it falls after the paragraphs. */
        .certificate-content {
            position: absolute;
            left: 22mm;
            right: 22mm;
            top: 10mm;
            bottom: 18mm;
        }

        /* ── BISMILLAH ── */
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
            color: #1e5cc4;
            margin-bottom: 10px;
        }

        /* ── HEADER ── */
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
            color: #026837;
        }

        .red {
            color: #b11226;
            font-weight: bold;
        }

        .left h3 {
            margin: 5px 0;
        }

        .left h4 {
            margin-top: 4px;
            font-size: 12px;
            color: #555;
            font-weight: 600;
        }

        .center-logo {
            width: 110px;
            height: 170px;
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

        .right h2 {
            margin: 0;
            font-size: 22px;
            color: #026837;
        }

        .right h3 {
            margin: 5px 0;
        }

        .right h4 {
            margin-top: 4px;
            font-size: 12px;
            color: #555;
        }

        /* ── CERTIFICATE TITLE BAND ── */
        .cert-title-band {
            text-align: center;
            margin: 6px 0 5px;
        }

        .cert-title-band h3 {
            display: inline-block;
            font-size: 17px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #026837;
            border-bottom: 2.5px solid #b11226;
            padding-bottom: 3px;
            margin: 0;
            text-transform: uppercase;
        }

        /* ── DIVIDER ── */
        .divider {
            border: none;
            border-top: 1.5px solid #c8a96e;
            margin: 5px 0;
        }

        /* ── ARABIC PARAGRAPH ── */
        .arabic {
            direction: rtl;
            unicode-bidi: embed;
            text-align: justify;
            font-size: 18px;
            line-height: 1.7;
            margin-top: 8px;
        }

        /* ── ENGLISH PARAGRAPH ── */
        .english {
            margin-top: 8px;
            font-size: 15px;
            line-height: 1.8;
            font-family: Tahoma, Arial, sans-serif;
            text-align: justify;
            margin-bottom: 15px;
        }

        /* ── FOOTER ──
           margin-top: 20px matches the student certificate footer spacing exactly */
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

        .date-ar {
            direction: rtl;
        }

        .signature-space {
            height: 60px;
        }

        /* ── WATERMARK ── */
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

        * {
            box-sizing: border-box;
        }

        .nowrap {
            white-space: nowrap;
        }

        #qr {
            display: flex;
            justify-content: center;
        }

        .reg-number-box {
            display: inline-block;
            border: 1.5px solid #026837;
            border-radius: 6px;
            padding: 1px 7px;
            font-weight: bold;
            font-size: 13px;
            color: #026837;
            letter-spacing: 1px;
        }

        .ar-inline {
            direction: rtl;
            unicode-bidi: embed;
            display: inline;
        }
    </style>
</head>

<body>

    @php
        use App\Http\Controllers\Helper;
        $currentDate = date('d/m/Y');
        $issuedDateFmt = \Carbon\Carbon::parse($cert->issued_date)->format('d/m/Y');
    @endphp

    <div class="certificate">

        {{-- ── BORDER ── --}}
        <div class="certificate-bg">
            <img src="{{ asset('assets/certificates/border.jpg') }}" alt="border">
        </div>

        {{-- ── WATERMARK ── --}}
        <div class="watermark">
            <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="Watermark">
        </div>

        <div class="certificate-content">

            {{-- ── HEADER ── --}}
            <div class="header">

                <div class="left">
                    <h2>Kampala Integrated Secondary School Examination Bureau</h2>
                    <h3 class="red">KAMSSA</h3>
                    <h4>Kampala, Uganda</h4>
                </div>

                <div class="center-logo">
                    <img src="{{ asset('assets/images/brand/uplogolight.png') }}" alt="KAMSSA logo"
                        style="max-width: 150%; max-height: 150%;">
                </div>

                <div class="right">
                    <h2>
                        <span
                            class="ar-inline">{!! Helper::arabicWordSpacing('المجلس الأعلى الإسلامي الأوغندي') !!}</span>
                    </h2>
                    <h3 class="red">
                        <span
                            class="ar-inline">{!! Helper::arabicWordSpacing('هيئة الامتحانات الإعدادية والثانوية') !!}</span>
                        <span style="direction:rtl; unicode-bidi:embed;">(أوغندا)</span>
                    </h3>
                    <h4>
                        <span class="ar-inline">كمبالا، أوغندا</span>
                    </h4>
                </div>

            </div>

            {{-- ── TITLE BAND ── --}}
            <div class="cert-title-band">
                <h3>Certificate of Recognition</h3>
            </div>

            <hr class="divider">

            {{-- ── ENGLISH BODY ── --}}
            <div class="english">
                The Board hereby certifies that
                <b>{{ $schoolNameEn }}</b>,
                located in <b>{{ $location }}</b>,
                registered under Board Reference No.&nbsp;<span
                    class="reg-number-box">{{ $cert->certificate_number }}</span>,
                is a recognised institution known to and approved by the
                <b>Kampala Integrated Secondary School Examination Bureau (KAMSSA)</b>.
                This school is duly authorised to participate in KAMSSA examinations.
                This certificate is issued on <b>{{ \Carbon\Carbon::parse($cert->issued_date)->format('d F Y') }}</b>.
            </div>

            {{-- ── FOOTER ── --}}
            <div class="footer">

                <div class="footer-col">
                    <div>Date of Issue {{ $issuedDateFmt }}</div>
                    <div class="sign">
                        <b><span class="ar-inline">{!! Helper::arabicWordSpacing('سكرتير التعليم للمجلس') !!}</span></b>
                        <div class="signature-space"></div>
                        <strong style="white-space:nowrap; direction:ltr; unicode-bidi:embed;">
                            Secretary for Education (KAMSSA)
                        </strong>
                    </div>
                </div>

                <div class="sno-section" style="display:flex; flex-direction:column; align-items:center;">
                    <div style="padding-bottom:5px;">
                        <strong>Ref: {{ $cert->certificate_number }}</strong>
                    </div>
                    <div id="qr"></div>
                </div>

                <div class="footer-empty">&nbsp;</div>

                <div class="footer-col date-ar">
                    <div>
                        <span class="ar-inline">التاريخ
                            {{ Helper::toArabicNumberDateReversed($issuedDateFmt) }}</span>&nbsp;
                    </div>
                    <div class="sign">
                        <b><span
                                class="ar-inline">{!! Helper::arabicWordSpacing('السكرتير التنفيذي للهيئة') !!}</span></b>
                        <div class="signature-space"></div>
                        <strong style="white-space:nowrap; direction:ltr; unicode-bidi:embed;">
                            Executive Secretary (KAMSSA)
                        </strong>
                    </div>
                </div>

            </div>
        </div>{{-- /certificate-content --}}
    </div>{{-- /certificate --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        window.onload = function () {
            const qrData = "Certificate No: {{ $cert->certificate_number }}\nSchool: {{ $schoolNameEn }}\nSchool Code: {{ $schoolNumber }}\nIssued: {{ \Carbon\Carbon::parse($cert->issued_date)->format('d M Y') }}";

            new QRCode(document.getElementById("qr"), {
                text: qrData,
                width: 90,
                height: 90,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            if (window.self !== window.top) {
                return;
            }

            const element = document.querySelector('.certificate');
            const opt = {
                margin: 0,
                filename: 'recognition_certificate_{{ $schoolNumber }}.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 4, useCORS: true, scrollY: 0 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            setTimeout(function () {
                html2pdf().set(opt).from(element).save();
            }, 600);
        };
    </script>

</body>

</html>