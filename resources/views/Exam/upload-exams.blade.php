<?php
use App\Http\Controllers\Helper; 
?>
@extends('layouts-side-bar.master')
@section('content')

    <style>
        .swal2-container.swal2-backdrop-show {
            z-index: 20000 !important;
        }
    </style>

    <div class="side-app">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.exam-buttons')
                    </div>
                </div>
            </div>
        </div>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <div class="row">
            <div class="col-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center mb-5">
                        <h4 class="card-title mb-0 text-white">
                            <i class="bi bi-list-check me-2"></i> Manage Exam
                        </h4>
                        <a href="{{ route('edit.exams') }}" class="btn btn-outline-light ms-auto text-white">
                            <i class="bi bi-gear me-2"></i> Edit Exams
                        </a>
                    </div>

                    <div class="col-12">
                        @php
                            $terms = [
                                26 => 'Term 1',
                                29 => 'Term 2',
                                30 => 'Term 3',
                            ];
                        @endphp

                        @foreach ($terms as $termKey => $termName)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="mb-0">{{ $termName }} - {{ $activeYear }}</h4>
                                </div>

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered  mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Exam</th>
                                                    <th>Class</th>
                                                    <th>Status</th>
                                                    <th>Class List</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if(isset($exams[$termKey]) && $exams[$termKey]->count())


                                                    @if ($exams[$termKey]->count() > 0)

                                                    @endif

                                                    @foreach ($exams[$termKey] as $exam)

                                                        @php
                                                            $classIds = json_decode($exam->ce_class_ids, true);
                                                        @endphp

                                                        @foreach ($classIds as $index => $classId)

                                                            <tr class="{{ $exam->ce_status == 'Published' ? 'table-success' : '' }}">
                                                                @if ($index == 0)
                                                                    <td rowspan="{{ count($classIds) }}">
                                                                        {{ $exam->ce_exam_name }}
                                                                    </td>
                                                                @endif

                                                                <td>
                                                                    {{ Helper::item_md_name($classId) }}
                                                                </td>

                                                                <td>
                                                                    @if ($exam->ce_exam_status == 0)
                                                                        <span class="badge bg-secondary">
                                                                            Results Not Uploaded
                                                                        </span>
                                                                    @elseif ($exam->ce_exam_status == 1)
                                                                        <span class="badge bg-warning text-dark">
                                                                            Results Uploaded & Computed
                                                                        </span>
                                                                    @elseif ($exam->ce_exam_status == 2)
                                                                        <span class="badge bg-success">
                                                                            Results Published
                                                                        </span>
                                                                    @else
                                                                        <span class="badge bg-dark">
                                                                            Unknown Status
                                                                        </span>
                                                                    @endif
                                                                </td>

                                                                <td class="text-center">
                                                                    <a href="{{ route('exams.download.classlist', ['exam' => $exam->id, 'class' => $classId]) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <i class="bi bi-download"></i> Download XLS
                                                                    </a>
                                                                </td>

                                                                <td class="text-center">
                                                                    <button class="btn btn-sm btn-warning text-dark upload-results-btn"
                                                                        data-exam-id="{{ $exam->id }}" data-class-id="{{ $classId }}"
                                                                        data-exam-name="{{ $exam->ce_exam_name }}">
                                                                        <i class="bi bi-upload"></i> Upload Results
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                        @endforeach

                                                    @endforeach

                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-4">
                                                            No exams created for {{ $termName }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="modal fade" id="uploadResultsModal" tabindex="-1"
                            aria-labelledby="uploadResultsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <form method="POST" action="{{ route('exams.upload.results') }}"
                                    enctype="multipart/form-data" class="modal-content border-0 shadow-lg"
                                    id="uploadResultsForm">
                                    @csrf

                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title d-flex align-items-center" id="uploadResultsModalLabel">
                                            <i class="bi bi-file-earmark-excel-fill text-success me-2 fs-4"></i>
                                            <span>Upload Results – <strong id="examTitle"
                                                    class="text-primary"></strong></span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body p-4">
                                        <input type="hidden" name="exam_id" id="exam_id">
                                        <input type="hidden" name="class_id" id="class_id">

                                        <div class="alert alert-warning border-0 bg-light-warning d-flex align-items-center mb-4"
                                            role="alert">
                                            <i class="bi bi-exclamation-triangle-fill me-3 fs-4 text-warning"></i>
                                            <div>
                                                <small class="text-uppercase fw-bold d-block">Important Note</small>
                                                Please upload the exact Excel file template that was previously downloaded
                                                to ensure data mapping is correct.
                                            </div>
                                        </div>

                                        <div class="mb-4">

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label fw-bold m-0 text-dark">Excel Data Import</label>
                                                <span
                                                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">Required</span>
                                            </div>

                                            <div class="position-relative rounded-4 bg-light border border-2 border-dashed border-primary d-flex align-items-center justify-content-center"
                                                style="height: 180px; transition: all 0.3s ease;">
                                                <input type="file" name="results_file" id="file-input-1"
                                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                                    style="cursor: pointer; z-index: 5;" accept=".xlsx,.xls" required>

                                                <div class="text-center p-3">
                                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                                                        style="width: 54px; height: 54px;">
                                                        <i class="bi bi-cloud-arrow-up fs-3"></i>
                                                    </div>
                                                    <h6 class="fw-bold mb-1" id="label-1">Drop your Excel file here</h6>
                                                    <p class="text-muted small mb-0" id="sub-label-1">or click to browse
                                                        computer</p>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between mt-2 px-1">
                                                <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Supports:
                                                    .xlsx, .xls</small>
                                                <small class="text-muted">Max: 10MB</small>
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('file-input-1').addEventListener('change', function (e) {
                                                const name = e.target.files[0]?.name;
                                                if (name) {
                                                    document.getElementById('label-1').innerText = name;
                                                    document.getElementById('label-1').classList.add('text-primary');
                                                    document.getElementById('sub-label-1').innerText = "File selected successfully";
                                                }
                                            });
                                        </script>
                                    </div>

                                    <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                            <i class="bi bi-x-circle me-1"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary px-4 shadow-sm" id="confirmUploadBtn">
                                            <i class="bi bi-check-circle me-1"></i> Confirm & Upload
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    </div>
    </div>
    </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Upload Successful',
                text: "{{ session('success') }}",
                confirmButtonColor: '#0d6efd'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            $(document).ready(function () {
                var modal = new bootstrap.Modal(document.getElementById('uploadResultsModal'));
                modal.show();
            });
        </script>
    @endif

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.upload-results-btn', function () {

        let examId = $(this).data('exam-id');
        let classId = $(this).data('class-id');
        let examName = $(this).data('exam-name');

        $('#exam_id').val(examId);
        $('#class_id').val(classId);
        $('#examTitle').text(examName);

        $('#uploadResultsModal').modal('show');

    });

    $(document).ready(function () {

        $('#uploadResultsForm').on('submit', function (e) {

            if (!this.checkValidity()) {
                return;
            }

            e.preventDefault();

            Swal.fire({
                title: 'Confirm Upload',
                html: 'Are you sure you want to upload and process these results?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, upload',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#confirmUploadBtn').prop('disabled', true).html('Uploading... <i class="fas fa-spinner fa-spin"></i>');
                    this.submit();
                }
            });
        });
    });
</script>