@extends('layouts-side-bar.master')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

@section('content')
    <?php use App\Http\Controllers\Helper; ?>

    <style>
        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #263f2e 0%, #1a2f20 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 25px;
            border: none;
        }

        .modal-header .modal-title {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
            font-size: 28px;
            transition: all 0.3s;
        }

        .modal-header .close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px 25px;
        }

        .modal-footer {
            border: none;
            padding: 20px 25px;
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
        }

        /* Student Info Card */
        .student-info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #263f2e;
        }

        .student-info-card p {
            margin: 0;
            font-size: 1.1rem;
        }

        .student-info-card strong {
            color: #263f2e;
            font-size: 1.2rem;
        }

        /* Image Preview Container */
        .image-preview-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .preview-wrapper {
            position: relative;
            display: inline-block;
        }

        #previewImage {
            width: 160px;
            height: 180px;
            border-radius: 15px;
            border: 4px solid #e9ecef;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        #previewImage:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .preview-badge {
            position: absolute;
            bottom: -10px;
            right: -10px;
            background: #263f2e;
            color: white;
            border-radius: 30px;
            padding: 5px 15px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(38, 63, 46, 0.3);
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #263f2e;
            background: #e9ecef;
        }

        .upload-area i {
            font-size: 40px;
            color: #263f2e;
            margin-bottom: 10px;
        }

        .upload-area p {
            margin: 5px 0;
            color: #6c757d;
        }

        .upload-area .file-name {
            font-size: 0.9rem;
            color: #263f2e;
            font-weight: 500;
            margin-top: 10px;
        }

        #photoInput {
            display: none;
        }

        /* Submit Button */
        .btn-upload {
            background: linear-gradient(135deg, #263f2e 0%, #1a2f20 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(38, 63, 46, 0.4);
            color: white;
        }

        .btn-upload:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Table Styles */
        .w-33 {
            width: 33.33%;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background: #263f2e;
            color: white;
            font-weight: 600;
            border: none;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin: 0 3px;
            transition: all 0.3s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .swal2-container {
            z-index: 99999 !important;
        }
    </style>

    <style>
        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #263f2e 0%, #1a2f20 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 25px;
            border: none;
        }

        .modal-header .modal-title {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
            font-size: 28px;
            transition: all 0.3s;
        }

        .modal-header .close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px 25px;
        }

        .modal-footer {
            border: none;
            padding: 20px 25px;
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
        }

        /* Student Info Card */
        .student-info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #263f2e;
        }

        .student-info-card p {
            margin: 0;
            font-size: 1.1rem;
        }

        .student-info-card strong {
            color: #263f2e;
            font-size: 1.2rem;
            word-break: break-word;
        }

        /* Image Preview Container */
        .image-preview-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .preview-wrapper {
            position: relative;
            display: inline-block;
        }

        #previewImage {
            width: 160px;
            height: 180px;
            border-radius: 15px;
            border: 4px solid #e9ecef;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        #previewImage:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .preview-badge {
            position: absolute;
            bottom: -10px;
            right: -10px;
            background: #263f2e;
            color: white;
            border-radius: 30px;
            padding: 5px 15px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(38, 63, 46, 0.3);
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #263f2e;
            background: #e9ecef;
        }

        .upload-area i {
            font-size: 40px;
            color: #263f2e;
            margin-bottom: 10px;
        }

        .upload-area p {
            margin: 5px 0;
            color: #6c757d;
        }

        .upload-area .file-name {
            font-size: 0.9rem;
            color: #263f2e;
            font-weight: 500;
            margin-top: 10px;
            word-break: break-all;
        }

        #photoInput {
            display: none;
        }

        /* Submit Button */
        .btn-upload {
            background: linear-gradient(135deg, #263f2e 0%, #1a2f20 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(38, 63, 46, 0.4);
            color: white;
        }

        .btn-upload:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Table Styles - Responsive */
        .w-33 {
            width: 33.33%;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            width: 100%;
            margin-bottom: 1rem;
        }

        .table thead th {
            background: #263f2e;
            color: white;
            font-weight: 600;
            border: none;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin: 0 3px;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .swal2-container {
            z-index: 99999 !important;
        }

        /* Mobile Responsive Styles */
        @media screen and (max-width: 768px) {

            /* Header adjustments */
            .card-header {
                flex-direction: column;
                text-align: center !important;
                gap: 10px;
            }

            .card-header .w-33 {
                width: 100% !important;
                text-align: center !important;
            }

            .card-header h5 {
                font-size: 1rem;
            }

            /* Table responsive */
            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .table td {
                min-width: 120px;
            }

            .table td:first-child {
                min-width: 50px;
            }

            .table td:nth-child(2) {
                min-width: 140px;
            }

            .table td:last-child {
                min-width: 280px;
            }

            /* Action buttons in table */
            .btn-action {
                padding: 4px 8px;
                font-size: 0.75rem;
                margin: 2px;
            }

            /* Modal responsive */
            .modal-dialog {
                margin: 10px;
            }

            .modal-body {
                padding: 20px 15px;
            }

            .modal-header {
                padding: 15px;
            }

            .modal-header .modal-title {
                font-size: 1.1rem;
            }

            .modal-footer {
                padding: 15px;
                flex-direction: column;
                gap: 10px;
            }

            .modal-footer button {
                width: 100%;
                margin: 0 !important;
            }

            /* Student info card */
            .student-info-card {
                padding: 15px;
            }

            .student-info-card strong {
                font-size: 1rem;
            }

            /* Preview image */
            #previewImage {
                width: 140px;
                height: 160px;
            }

            .preview-badge {
                padding: 3px 10px;
                font-size: 0.7rem;
            }

            /* Upload area */
            .upload-area {
                padding: 20px 15px;
            }

            .upload-area i {
                font-size: 30px;
            }

            .upload-area p {
                font-size: 0.9rem;
            }
        }

        /* Small mobile devices */
        @media screen and (max-width: 480px) {
            .modal-body {
                padding: 15px 10px;
            }

            .student-info-card {
                padding: 12px;
            }

            .student-info-card p {
                font-size: 0.9rem;
            }

            .student-info-card strong {
                font-size: 0.95rem;
            }

            #previewImage {
                width: 120px;
                height: 140px;
            }

            .upload-area {
                padding: 15px 10px;
            }

            .upload-area i {
                font-size: 25px;
            }

            .upload-area p {
                font-size: 0.8rem;
            }

            .upload-area .file-name {
                font-size: 0.8rem;
            }

            .btn-upload {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            /* Table text size */
            .table td {
                font-size: 0.9rem;
            }

            .table td strong {
                font-size: 0.9rem;
            }

            .btn-action {
                padding: 3px 6px;
                font-size: 0.7rem;
            }
        }

        /* Tablet devices */
        @media screen and (min-width: 769px) and (max-width: 1024px) {
            .card-header .w-33 {
                font-size: 0.9rem;
            }

            .btn-action {
                padding: 5px 10px;
                font-size: 0.8rem;
            }
        }

        /* For better table scrolling on mobile */
        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -15px;
            padding: 0 15px;
        }

        /* Ensure images don't overflow */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Better touch targets for mobile */
        @media (hover: none) and (pointer: coarse) {
            .btn-action {
                padding: 8px 12px;
            }

            .upload-area {
                min-height: 150px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
        }
    </style>

    <div class="side-app">
        <div class="stats-container">
            @if (isset($groupedByStudent))

                @if(isset($groupedByStudent) && $groupedByStudent->count() > 0)

                    <div class="row justify-content-center">

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert"
                                style="border-radius: 12px; border-left: 5px solid #dc3545; font-weight: 500;">
                                <i class="fas fa-times-circle me-2 fs-5"></i>
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- Certificates -->
                        <div class="col-12 col-md-6 col-lg-5 text-center mb-4">
                            <button id="downloadAllBtn" class="btn btn-danger px-5 w-100">
                                <i class="fas fa-file-pdf me-2"></i>
                                Download All Certificates ({{ $groupedByStudent->count() }} students)
                            </button>

                            <div id="progressWrapper" style="display:none; margin-top: 15px;">
                                <div style="font-weight:bold; margin-bottom:6px;">
                                    <span id="progressText">Preparing...</span>
                                </div>
                                <div style="background:#e9ecef; border-radius:8px; height:22px; width:100%;">
                                    <div id="progressBar"
                                        style="background:#28a745; height:100%; width:0%; border-radius:8px;
                                                                                                                            transition:width 0.3s ease; text-align:center; color:white;
                                                                                                                            font-size:13px; line-height:22px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Passlips -->
                        <div class="col-12 col-md-6 col-lg-5 text-center mb-4">
                            <button id="downloadAllPasslipBtn" class="btn btn-primary px-5 w-100">
                                <i class="fas fa-file-pdf me-2"></i>
                                Download All Passlips ({{ $groupedByStudent->count() }} students)
                            </button>

                            <div id="progressWrapperPasslip" style="display:none; margin-top: 15px;">
                                <div style="font-weight:bold; margin-bottom:6px;">
                                    <span id="progressTextPasslip">Preparing...</span>
                                </div>
                                <div style="background:#e9ecef; border-radius:8px; height:22px; width:100%;">
                                    <div id="progressBarPasslip"
                                        style="background:#28a745; height:100%; width:0%; border-radius:8px;
                                                                                                                            transition:width 0.3s ease; text-align:center; color:white;
                                                                                                                            font-size:13px; line-height:22px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

                    <script>
                        document.getElementById('downloadAllBtn').addEventListener('click', async function () {

                            const ALL_STUDENT_IDS = @json($groupedByStudent->keys()->values());

                            const btn = this;
                            const progressWrapper = document.getElementById('progressWrapper');
                            const progressBar = document.getElementById('progressBar');
                            const progressText = document.getElementById('progressText');
                            const total = ALL_STUDENT_IDS.length;

                            btn.disabled = true;
                            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating...';
                            progressWrapper.style.display = 'block';

                            const { PDFDocument } = PDFLib;
                            const mergedPdf = await PDFDocument.create();

                            for (let i = 0; i < total; i++) {
                                const studentId = ALL_STUDENT_IDS[i];
                                const percent = Math.round((i / total) * 100);

                                progressText.textContent = `Generating ${i + 1} of ${total}: ${studentId}`;
                                progressBar.style.width = percent + '%';
                                progressBar.textContent = percent + '%';

                                await new Promise(async (resolve) => {
                                    const iframe = document.createElement('iframe');
                                    iframe.style.cssText = 'position:fixed;left:-9999px;top:-9999px;width:1122px;height:794px;border:none;visibility:hidden;';
                                    document.body.appendChild(iframe);

                                    // iframe.onload = async () => {
                                    //     try {
                                    //         // Wait for QR code + border image + fonts
                                    //         await new Promise(r => setTimeout(r, 3000));

                                    //         // ✅ Capture the full body (preserves margins around certificate border)
                                    //         const certEl = iframe.contentDocument.body;

                                    //         if (!certEl) {
                                    //             console.warn('Body not found for', studentId);
                                    //             document.body.removeChild(iframe);
                                    //             resolve();
                                    //             return;
                                    //         }

                                    //         const canvas = await html2canvas(certEl, {
                                    //             scale: 3,
                                    //             useCORS: true,
                                    //             allowTaint: false,
                                    //             scrollX: 0,
                                    //             scrollY: 0,
                                    //             width: 1122,       // ✅ Fixed width matching iframe
                                    //             height: 794,       // ✅ Fixed height matching iframe
                                    //             windowWidth: 1122,
                                    //             windowHeight: 794,
                                    //             backgroundColor: '#FFF'  // ✅ Matches certificate body background
                                    //         });

                                    //         const imgData = canvas.toDataURL('image/jpeg', 1.0);

                                    //         const { jsPDF } = window.jspdf;
                                    //         const pdf = new jsPDF({
                                    //             orientation: 'landscape',
                                    //             unit: 'mm',
                                    //             format: 'a4'
                                    //         });

                                    //         // ✅ Full A4 landscape: 297mm × 210mm
                                    //         pdf.addImage(imgData, 'JPEG', 0, 0, 297, 210);

                                    //         const pdfBytes = pdf.output('arraybuffer');
                                    //         const studentPdf = await PDFDocument.load(pdfBytes);
                                    //         const copiedPages = await mergedPdf.copyPages(studentPdf, studentPdf.getPageIndices());
                                    //         copiedPages.forEach(page => mergedPdf.addPage(page));

                                    //     } catch (err) {
                                    //         console.error(`Failed for ${studentId}:`, err);
                                    //     }

                                    //     document.body.removeChild(iframe);
                                    //     resolve();
                                    // };

                                    // iframe.src = `/passlip/certificate/${studentId}`;


                                    iframe.onload = async () => {
                                        try {
                                            await new Promise(r => setTimeout(r, 3000));

                                            // ✅ Check if student was skipped (failed grade)
                                            const bodyEl = iframe.contentDocument.body;
                                            if (bodyEl && bodyEl.getAttribute('data-skipped') === 'true') {
                                                console.log(`Skipping failed student: ${studentId}`);
                                                document.body.removeChild(iframe);
                                                resolve();
                                                return;
                                            }

                                            const certEl = iframe.contentDocument.body;

                                            if (!certEl) {
                                                console.warn('Body not found for', studentId);
                                                document.body.removeChild(iframe);
                                                resolve();
                                                return;
                                            }

                                            const canvas = await html2canvas(certEl, {
                                                scale: 3,
                                                useCORS: true,
                                                allowTaint: false,
                                                scrollX: 0,
                                                scrollY: 0,
                                                width: 1122,       // ✅ Fixed width matching iframe
                                                height: 794,       // ✅ Fixed height matching iframe
                                                windowWidth: 1122,
                                                windowHeight: 794,
                                                backgroundColor: '#FFF'  // ✅ Matches certificate body background
                                            });

                                            const imgData = canvas.toDataURL('image/jpeg', 1.0);

                                            const { jsPDF } = window.jspdf;
                                            const pdf = new jsPDF({
                                                orientation: 'landscape',
                                                unit: 'mm',
                                                format: 'a4'
                                            });

                                            // ✅ Full A4 landscape: 297mm × 210mm
                                            pdf.addImage(imgData, 'JPEG', 0, 0, 297, 210);

                                            const pdfBytes = pdf.output('arraybuffer');
                                            const studentPdf = await PDFDocument.load(pdfBytes);
                                            const copiedPages = await mergedPdf.copyPages(studentPdf, studentPdf.getPageIndices());
                                            copiedPages.forEach(page => mergedPdf.addPage(page));

                                        } catch (err) {
                                            console.error(`Failed for ${studentId}:`, err);
                                        }

                                        document.body.removeChild(iframe);
                                        resolve();
                                    };

                                    iframe.src = `/passlip/certificate/${studentId}?bulk=1`;
                                });
                            }

                            progressText.textContent = 'Finalizing merged PDF...';
                            progressBar.style.width = '100%';
                            progressBar.textContent = '100%';

                            const mergedBytes = await mergedPdf.save();
                            const blob = new Blob([mergedBytes], { type: 'application/pdf' });
                            const url = URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = `All_Certificates_{{ $filters['school_number'] }}_{{ $filters['year'] }}.pdf`;
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                            URL.revokeObjectURL(url);

                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-file-pdf me-2"></i> Download All Certificates ({{ $groupedByStudent->count() }} students)';
                            progressText.textContent = `Done! ${total} certificates merged and downloaded.`;
                        });
                    </script>

                    <script>
                        document.getElementById('downloadAllPasslipBtn').addEventListener('click', async function () {

                            const ALL_STUDENT_IDS = @json($groupedByStudent->keys()->values());

                            const btn = this;
                            const progressWrapper = document.getElementById('progressWrapperPasslip');
                            const progressBar = document.getElementById('progressBarPasslip');
                            const progressText = document.getElementById('progressTextPasslip');
                            const total = ALL_STUDENT_IDS.length;

                            btn.disabled = true;
                            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating...';
                            progressWrapper.style.display = 'block';

                            const { PDFDocument } = PDFLib;
                            const mergedPdf = await PDFDocument.create();

                            let generated = 0;
                            for (let i = 0; i < total; i++) {
                                const studentId = ALL_STUDENT_IDS[i];
                                const percent = Math.round((i / total) * 100);

                                progressText.textContent = `Processing ${i + 1} of ${total}: ${studentId}`;
                                progressBar.style.width = percent + '%';
                                progressBar.textContent = percent + '%';

                                await new Promise(async (resolve) => {
                                    const iframe = document.createElement('iframe');
                                    // ✅ Portrait dimensions (794 wide × 1122 tall)
                                    iframe.style.cssText = 'position:fixed;left:-9999px;top:-9999px;width:794px;height:1122px;border:none;visibility:hidden;';
                                    document.body.appendChild(iframe);

                                    iframe.onload = async () => {
                                        try {
                                            await new Promise(r => setTimeout(r, 2500));

                                            const certEl = iframe.contentDocument.querySelector('.document-container');

                                            if (!certEl) {
                                                console.warn('No .document-container element found for', studentId);
                                                document.body.removeChild(iframe);
                                                resolve();
                                                return;
                                            }

                                            // ✅ Portrait window dimensions
                                            const canvas = await html2canvas(certEl, {
                                                scale: 3,
                                                useCORS: true,
                                                allowTaint: false,
                                                scrollX: 0,
                                                scrollY: 0,
                                                width: certEl.offsetWidth,
                                                height: certEl.offsetHeight,
                                                windowWidth: 794,
                                                windowHeight: 1122
                                            });

                                            const imgData = canvas.toDataURL('image/jpeg', 1.0);

                                            const { jsPDF } = window.jspdf;
                                            // ✅ Portrait orientation
                                            const pdf = new jsPDF({
                                                orientation: 'portrait',
                                                unit: 'mm',
                                                format: 'a4'
                                            });

                                            // ✅ A4 portrait dimensions: 210mm wide × 297mm tall
                                            pdf.addImage(imgData, 'JPEG', 0, 0, 210, 297);

                                            const pdfBytes = pdf.output('arraybuffer');
                                            const studentPdf = await PDFDocument.load(pdfBytes);
                                            const copiedPages = await mergedPdf.copyPages(studentPdf, studentPdf.getPageIndices());
                                            copiedPages.forEach(page => mergedPdf.addPage(page));

                                        } catch (err) {
                                            console.error(`Failed for ${studentId}:`, err);
                                        }

                                        document.body.removeChild(iframe);
                                        resolve();
                                        generated++;
                                    };

                                    iframe.src = `/passlip/passlip/download/${studentId}`;
                                });
                            }

                            progressText.textContent = `Done! ${generated} certificates generated (${total - generated} failed students skipped).`;
                            progressBar.style.width = '100%';
                            progressBar.textContent = '100%';

                            const mergedBytes = await mergedPdf.save();
                            const blob = new Blob([mergedBytes], { type: 'application/pdf' });
                            const url = URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = `All_Passlips_{{ $filters['school_number'] }}_{{ $filters['year'] }}.pdf`;
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                            URL.revokeObjectURL(url);

                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-file-pdf me-2"></i> Download All Passlips ({{ $groupedByStudent->count() }} students)';
                            progressText.textContent = `Done! ${total} Passlips merged and downloaded.`;
                        });
                    </script>
                @endif
                <div class="card mt-4">
                    <div class="card-header text-white d-flex align-items-center" style="background-color: #263f2e;">
                        <div class="w-33 text-start">
                            <h5 class="mb-0">
                                {{ Helper::schoolName($filters['school_number']) }}
                            </h5>
                        </div>

                        <div class="w-33 text-center">
                            <strong>
                                Category: {{ $filters['category'] }} |
                                Year: {{ $filters['year'] }}
                            </strong>
                        </div>

                        <div class="w-33 text-end">
                            <strong>Total Students:</strong> {{ $totalStudents }}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive-wrapper">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:1px;">No.</th>
                                        <th style="width:70px; text-align:center;">Photo</th>
                                        <th style="text-align: center">Student Information</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedByStudent as $studentId => $allocations)
                                        @php
                                            $photoPath = public_path('assets/student_photos/' . $studentId . '.jpg');
                                            $photoExists = file_exists($photoPath);
                                            $cacheBuster = $photoExists ? '?v=' . filemtime($photoPath) : '';
                                        @endphp

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td style="text-align:center; width:140px;">
                                                @if($photoExists)
                                                    <img src="{{ asset('assets/student_photos/' . $studentId . '.jpg') . $cacheBuster }}"
                                                        style="width:110px;height:140px;object-fit:cover;border-radius:10px;border:2px solid #e9ecef;">
                                                @else
                                                    <img src="{{ asset('assets/images/default-user.jpg') }}"
                                                        style="width:110px;height:140px;object-fit:cover;border-radius:10px;border:2px solid #e9ecef;">
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $studentId }}</strong> - {{ Helper::getStudentName($studentId) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('passlip.download', ['student_id' => $studentId]) }}"
                                                    class="btn btn-sm btn-primary btn-action" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> Passlip
                                                </a>

                                                <a href="{{ route('certificate.view', ['student_id' => $studentId]) }}"
                                                    class="btn btn-sm btn-success btn-action" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> Certificate
                                                </a>

                                                <button class="btn btn-sm btn-warning btn-action uploadBtn"
                                                    data-student="{{ $studentId }}"
                                                    data-name="{{ Helper::getStudentName($studentId) }}">
                                                    @if($photoExists)
                                                        <i class="fas fa-edit"></i> Update
                                                    @else
                                                        <i class="fas fa-upload"></i> Upload
                                                    @endif
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Beautified Upload Modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="fas fa-camera-retro mr-2"></i>
                                        Student Photo Upload
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" id="studentId">

                                    <!-- Student Info Card -->
                                    <div class="student-info-card">
                                        <p class="mb-1">Uploading photo for:</p>
                                        <strong id="studentName"></strong>
                                    </div>

                                    <!-- Image Preview -->
                                    <div class="image-preview-container">
                                        <div class="preview-wrapper">
                                            <img id="previewImage" src="{{ asset('assets/images/default-user.jpg') }}"
                                                alt="Student photo preview">
                                            <span class="preview-badge" id="previewBadge">Preview</span>
                                        </div>
                                    </div>

                                    <!-- Upload Area -->
                                    <div class="upload-area" id="uploadArea">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p class="mb-1"><strong>Click to select photo</strong></p>
                                        <p class="small text-muted">or drag and drop</p>
                                        <p class="small text-muted">Supports: JPG, PNG, GIF (Max 5MB)</p>
                                        <div class="file-name" id="fileName"></div>
                                    </div>

                                    <input type="file" id="photoInput" accept="image/*">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times mr-2"></i>Cancel
                                    </button>
                                    <button type="button" class="btn btn-upload" id="submitUpload">
                                        <i class="fas fa-upload mr-2"></i>Upload Photo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Trigger upload button click
            $('.uploadBtn').click(function () {
                let studentId = $(this).data('student');
                let name = $(this).data('name');

                $('#studentId').val(studentId);
                $('#studentName').text(name + " (" + studentId + ")");

                // Reset preview and file input
                $('#previewImage').attr('src', '{{ asset('assets/images/default-user.jpg') }}');
                $('#photoInput').val('');
                $('#fileName').text('');
                $('.upload-area').removeClass('border-success');

                $('#uploadModal').modal('show');
            });

            // Click on upload area triggers file input
            $('#uploadArea').click(function () {
                $('#photoInput').click();
            });

            // File input change handler
            $('#photoInput').change(function () {
                const file = this.files[0];

                if (file) {
                    // Validate file size (5MB limit)
                    if (file.size > 5 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'Please select an image under 5MB'
                        });
                        $(this).val('');
                        return;
                    }

                    // Validate file type
                    if (!file.type.match('image.*')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File',
                            text: 'Please select an image file (JPG, PNG, GIF)'
                        });
                        $(this).val('');
                        return;
                    }

                    // Display file name
                    $('#fileName').text('Selected: ' + file.name);

                    // Preview image
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $('#previewImage').attr('src', e.target.result);
                        $('.upload-area').addClass('border-success');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Submit upload
            $('#submitUpload').click(function () {
                let studentId = $('#studentId').val();
                let file = $('#photoInput')[0].files[0];

                if (!file) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No File Selected',
                        text: 'Please select an image to upload',
                        confirmButtonColor: '#263f2e'
                    });
                    return;
                }

                // Show confirmation dialog
                Swal.fire({
                    title: 'Upload Photo?',
                    html: `Are you sure you want to upload this photo for <strong>${studentId}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#263f2e',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, upload it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Uploading...',
                            text: 'Please wait while we upload your photo',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        let formData = new FormData();
                        formData.append('photo', file);
                        formData.append('studentId', studentId);
                        formData.append('_token', '{{ csrf_token() }}');

                        $.ajax({
                            url: "{{ route('student.photo.upload') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Photo uploaded successfully',
                                    confirmButtonColor: '#263f2e'
                                }).then(() => {
                                    $('#uploadModal').modal('hide');

                                    // Instead of full page reload, update just the image
                                    let studentId = $('#studentId').val();
                                    let timestamp = new Date().getTime();
                                    let newSrc = `/assets/student_photos/${studentId}.jpg?v=${timestamp}`;

                                    // Find the image in the table row and update it
                                    $(`button[data-student="${studentId}"]`).closest('tr').find('img').attr('src', newSrc);

                                    // Update button text
                                    $(`button[data-student="${studentId}"]`).html('<i class="fas fa-edit"></i> Update');
                                });
                            },
                            error: function (xhr) {
                                let errorMessage = 'Upload failed';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Upload Failed',
                                    text: errorMessage,
                                    confirmButtonColor: '#263f2e'
                                });
                            }
                        });
                    }
                });
            });

            // Drag and drop functionality
            let uploadArea = document.getElementById('uploadArea');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                uploadArea.classList.add('border-success');
                uploadArea.style.backgroundColor = '#e9ecef';
            }

            function unhighlight() {
                uploadArea.classList.remove('border-success');
                uploadArea.style.backgroundColor = '#f8f9fa';
            }

            uploadArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;

                if (files.length) {
                    $('#photoInput')[0].files = files;
                    $('#photoInput').trigger('change');
                }
            }
        });
    </script>

    <!-- Certificate download script remains the same -->
    <script>
        document.querySelectorAll('.downloadCertificateForm').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Downloading...',
                    text: 'Please wait while your certificate is being prepared.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                let formData = new FormData(this);
                let studentId = this.querySelector('input[name="student_id"]').value;

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(async response => {
                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(errorText || `HTTP error! status: ${response.status}`);
                        }
                        return response.blob();
                    })
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = "certificate_" + studentId + ".pdf";
                        document.body.appendChild(a);
                        a.click();

                        setTimeout(() => {
                            document.body.removeChild(a);
                            window.URL.revokeObjectURL(url);
                            Swal.fire({
                                icon: 'success',
                                title: 'Downloaded!',
                                text: 'Certificate has been downloaded successfully.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#263f2e'
                            });
                        }, 100);
                    })
                    .catch(err => {
                        Swal.close();
                        error({
                            responseText: err.message
                        });
                        console.error('Download error:', err);
                    });
            });
        });

        function error(data) {
            $('body').html(data.responseText);
        }
    </script>
@endsection