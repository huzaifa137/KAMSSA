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
            word-break: break-word;
        }

        /* Image Preview */
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

        /* Search box */
        .search-wrapper {
            position: relative;
            max-width: 400px;
            margin: 0 auto 20px auto;
        }

        .search-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8a8a8a;
        }

        #studentSearchInput {
            padding-left: 40px;
            border-radius: 30px;
            border: 1px solid #dee2e6;
        }

        #studentSearchInput:focus {
            border-color: #263f2e;
            box-shadow: 0 0 0 0.2rem rgba(38, 63, 46, 0.15);
        }

        /* --- PRINT STYLES (FIXED) --- */
        #allPasslipsPrintContainer {
            display: none;
        }

        @media print {

            /* Hide everything except the print container */
            body * {
                visibility: hidden;
            }

            #allPasslipsPrintContainer,
            #allPasslipsPrintContainer * {
                visibility: visible;
            }

            #allPasslipsPrintContainer {
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            /* Each passlip occupies one full A4 page, centered */
            .print-page {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: 100vh;
                /* Full viewport height = A4 page */
                page-break-after: always;
                margin: 0;
                padding: 0;
                background: white;
                box-sizing: border-box;
            }

            .print-page:last-child {
                page-break-after: auto;
            }

            /* Ensure the document-container is its original size (204mm x 289mm) and not scaled */
            .print-page .document-container {
                width: 204mm !important;
                height: 289mm !important;
                padding: 5mm !important;
                box-sizing: border-box !important;
                margin: 0 !important;
                transform: none !important;
                zoom: 1 !important;
                page-break-inside: avoid;
                background: #fff;
                box-shadow: none !important;
                border: none !important;
            }

            /* Override any flex‑grow or stretching */
            .print-page .document-container * {
                transform: none !important;
                zoom: 1 !important;
            }

            /* Hide the watermark, signatures, etc. (already hidden in passlip view) */
        }

        /* Responsive styles (unchanged) */
        @media screen and (max-width: 768px) {
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
                min-width: 220px;
            }

            .btn-action {
                padding: 4px 8px;
                font-size: 0.75rem;
                margin: 2px;
            }

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

            .student-info-card {
                padding: 15px;
            }

            .student-info-card strong {
                font-size: 1rem;
            }

            #previewImage {
                width: 140px;
                height: 160px;
            }

            .preview-badge {
                padding: 3px 10px;
                font-size: 0.7rem;
            }

            .upload-area {
                padding: 20px 15px;
            }

            .upload-area i {
                font-size: 30px;
            }

            .upload-area p {
                font-size: 0.9rem;
            }

            .search-wrapper {
                max-width: 100%;
            }
        }

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

        @media screen and (min-width: 769px) and (max-width: 1024px) {
            .card-header .w-33 {
                font-size: 0.9rem;
            }

            .btn-action {
                padding: 5px 10px;
                font-size: 0.8rem;
            }
        }

        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -15px;
            padding: 0 15px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

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

        /* Search box */
.search-wrapper {
    position: relative;
    max-width: 400px;
    margin: 0 auto 20px auto;
}

.search-wrapper i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #8a8a8a;
}

#studentSearchInput {
    padding-left: 40px;
    border-radius: 30px;
    border: 2px solid #263f2e; /* Changed from 1px to 2px and made it the primary color */
    background-color: #f8f9fa; /* Added subtle background */
    transition: all 0.3s ease;
}

/* Keep the focus styles but also apply them by default */
#studentSearchInput:focus,
#studentSearchInput {
    border-color: #263f2e;
    box-shadow: 0 0 0 0.2rem rgba(38, 63, 46, 0.25);
    outline: none;
}

/* Optional: Add hover effect for better interaction */
#studentSearchInput:hover {
    border-color: #1a2f20;
    box-shadow: 0 0 0 0.15rem rgba(38, 63, 46, 0.15);
}

    </style>

    <div class="side-app">
        <div class="stats-container">
            @if (isset($groupedByStudent) && $groupedByStudent->count() > 0)

                <div class="row justify-content-center">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert"
                            style="border-radius: 12px; border-left: 5px solid #dc3545; font-weight: 500;">
                            <i class="fas fa-times-circle me-2 fs-5"></i>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="col-12 col-md-8 col-lg-6 text-center mb-4">
                        <button id="downloadAllPasslipBtn" class="btn btn-primary px-5 w-100">
                            <i class="fas fa-print me-2"></i>
                            Print All Passlips ({{ $groupedByStudent->count() }} students)
                        </button>

                        <div id="progressWrapperPasslip" style="display:none; margin-top: 15px;">
                            <div style="font-weight:bold; margin-bottom:6px;">
                                <span id="progressTextPasslip">Preparing...</span>
                            </div>
                            <div style="background:#e9ecef; border-radius:8px; height:22px; width:100%;">
                                <div id="progressBarPasslip"
                                    style="background:#28a745; height:100%; width:0%; border-radius:8px; transition:width 0.3s ease; text-align:center; color:white; font-size:13px; line-height:22px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden container for print -->
                <div id="allPasslipsPrintContainer"></div>

                <script>
                    document.getElementById('downloadAllPasslipBtn').addEventListener('click', async function () {
                        const ALL_STUDENT_IDS = @json($groupedByStudent->keys()->values());
                        const btn = this;
                        const progressWrapper = document.getElementById('progressWrapperPasslip');
                        const progressBar = document.getElementById('progressBarPasslip');
                        const progressText = document.getElementById('progressTextPasslip');
                        const total = ALL_STUDENT_IDS.length;

                        btn.disabled = true;
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Preparing...';
                        progressWrapper.style.display = 'block';

                        let combinedHtml = '';
                        let loaded = 0;

                        for (let i = 0; i < total; i++) {
                            const studentId = ALL_STUDENT_IDS[i];
                            const percent = Math.round(((i + 1) / total) * 100);
                            progressText.textContent = `Loading ${i + 1} of ${total}: ${studentId}`;
                            progressBar.style.width = percent + '%';
                            progressBar.textContent = percent + '%';

                            try {
                                const response = await fetch(`/passlip/passlip/download/${studentId}`);
                                const htmlText = await response.text();
                                const parser = new DOMParser();
                                const parsedDoc = parser.parseFromString(htmlText, 'text/html');
                                const certEl = parsedDoc.querySelector('.document-container');
                                if (certEl) {
                                    combinedHtml += `<div class="print-page">${certEl.outerHTML}</div>`;
                                    loaded++;
                                } else {
                                    console.warn('No .document-container found for', studentId);
                                }
                            } catch (err) {
                                console.error(`Failed to load passlip for ${studentId}:`, err);
                            }
                        }

                        const printContainer = document.getElementById('allPasslipsPrintContainer');
                        printContainer.innerHTML = combinedHtml;

                        progressText.textContent = `Ready! ${loaded} of ${total} passlips loaded.`;
                        progressBar.style.width = '100%';
                        progressBar.textContent = '100%';

                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-print me-2"></i> Print All Passlips (' + total + ' students)';

                        setTimeout(() => {
                            progressWrapper.style.display = 'none';
                            window.print();
                        }, 300);
                    });
                </script>

                <div class="card mt-4">
                    <div class="card-header text-white d-flex align-items-center" style="background-color: #263f2e;">
                        <div class="w-33 text-start">
                            <h5 class="mb-0">{{ Helper::schoolName($filters['school_number']) }}</h5>
                        </div>
                        <div class="w-33 text-center">
                            <strong>Category: {{ $filters['category'] }} | Year: {{ $filters['year'] }}</strong>
                        </div>
                        <div class="w-33 text-end">
                            <strong>Total Students:</strong> {{ $totalStudents }}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="search-wrapper">
                            <i class="fas fa-search"></i>
                            <input type="text" id="studentSearchInput" class="form-control"
                                placeholder="Search by student name or registration number...">
                        </div>

                        <div class="table-responsive-wrapper">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:1px;">No.</th>
                                        
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
                                            
                                            <td class="student-name-cell">
                                                <span class="student-name">{{ Helper::getStudentName($studentId) }}</span>
                                                
                                            </td>
                                            <td>
                                                <a href="{{ route('passlip.download', ['student_id' => $studentId]) }}"
                                                    class="btn btn-sm btn-primary btn-action" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> Passlip
                                                </a>
                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Upload Modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-camera-retro mr-2"></i> Student Photo Upload</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="studentId">
                                    <div class="student-info-card">
                                        <p class="mb-1">Uploading photo for:</p>
                                        <strong id="studentName"></strong>
                                    </div>
                                    <div class="image-preview-container">
                                        <div class="preview-wrapper">
                                            <img id="previewImage" src="{{ asset('assets/images/default-user.jpg') }}"
                                                alt="Student photo preview">
                                            <span class="preview-badge" id="previewBadge">Preview</span>
                                        </div>
                                    </div>
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
 </div>
                    </div>
                </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Photo upload logic (unchanged)
        $(document).ready(function () {
            $('.uploadBtn').click(function () {
                let studentId = $(this).data('student');
                let name = $(this).data('name');
                $('#studentId').val(studentId);
                $('#studentName').text(name + " (" + studentId + ")");
                $('#previewImage').attr('src', '{{ asset('assets/images/default-user.jpg') }}');
                $('#photoInput').val('');
                $('#fileName').text('');
                $('.upload-area').removeClass('border-success');
                $('#uploadModal').modal('show');
            });

            $('#uploadArea').click(function () { $('#photoInput').click(); });

            $('#photoInput').change(function () {
                const file = this.files[0];
                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        Swal.fire({ icon: 'error', title: 'File Too Large', text: 'Please select an image under 5MB' });
                        $(this).val('');
                        return;
                    }
                    if (!file.type.match('image.*')) {
                        Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Please select an image file (JPG, PNG, GIF)' });
                        $(this).val('');
                        return;
                    }
                    $('#fileName').text('Selected: ' + file.name);
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $('#previewImage').attr('src', e.target.result);
                        $('.upload-area').addClass('border-success');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#submitUpload').click(function () {
                let studentId = $('#studentId').val();
                let file = $('#photoInput')[0].files[0];
                if (!file) {
                    Swal.fire({ icon: 'error', title: 'No File Selected', text: 'Please select an image to upload', confirmButtonColor: '#263f2e' });
                    return;
                }
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
                        Swal.fire({ title: 'Uploading...', text: 'Please wait while we upload your photo', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
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
                                Swal.fire({ icon: 'success', title: 'Success!', text: 'Photo uploaded successfully', confirmButtonColor: '#263f2e' })
                                    .then(() => {
                                        $('#uploadModal').modal('hide');
                                        let studentId = $('#studentId').val();
                                        let timestamp = new Date().getTime();
                                        let newSrc = `/assets/student_photos/${studentId}.jpg?v=${timestamp}`;
                                        $(`button[data-student="${studentId}"]`).closest('tr').find('img').attr('src', newSrc);
                                        $(`button[data-student="${studentId}"]`).html('<i class="fas fa-edit"></i> Update');
                                    });
                            },
                            error: function (xhr) {
                                let errorMessage = 'Upload failed';
                                if (xhr.responseJSON && xhr.responseJSON.message) errorMessage = xhr.responseJSON.message;
                                Swal.fire({ icon: 'error', title: 'Upload Failed', text: errorMessage, confirmButtonColor: '#263f2e' });
                            }
                        });
                    }
                });
            });

            // Drag and drop
            let uploadArea = document.getElementById('uploadArea');
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });
            function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }
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

            // Live search
            $('#studentSearchInput').on('keyup', function () {
                const value = $(this).val().toLowerCase().trim();
                $('table tbody tr').each(function () {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection