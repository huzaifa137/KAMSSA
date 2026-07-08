<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
@section('content')
    <style>
        .form-check-input {
            transform: scale(1.5);
            margin-right: 10px;
        }

        .form-check-label {
            line-height: 1.5;
        }

        .class-card:hover {
            border-color: #0d6efd !important;
            cursor: pointer;
        }

        .form-check-input:checked+.form-check-label {
            color: #0d6efd;
            font-weight: bold;
        }

        .form-check-input {
            transform: scale(1.5);
            margin-right: 10px;
        }

        .form-check-label {
            line-height: 1.5;
        }

        .class-card:hover {
            border-color: #0d6efd !important;
            cursor: pointer;
        }

        .class-card {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6 !important;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .class-card:hover {
            border-color: #0d6efd !important;
            cursor: pointer;
        }

        .selected-card {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }

        .selected-card .form-check-label {
            color: white !important;
            font-weight: bold;
        }

        .form-check-label {
            margin-bottom: 0;
            display: block;
            padding: 15px 5px;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(.375em + .1875rem) center !important;
            background-size: calc(.75em + .375rem) calc(.75em + .375rem) !important;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="side-app">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.grading-buttons')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">
                            <i class="bi bi-pencil-square me-2"></i> Create Exam
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <form id="create-exam-form">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ExaminationName" style="font-weight: bolder">Examination Name *</label>
                                        <?php
                                        // Add 'required' parameter and ensure it has an ID
                                        echo Helper::DropMasterData(config('constants.options.ExaminationName'), '', 'ExaminationName', 1);
                                        ?>
                                        <div class="invalid-feedback" id="examNameError" style="display: none;">
                                            Please select an examination name.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="Examination Name" style="font-weight: bolder">Active Year</label>
                                    <input type="number" class="form-control" placeholder="Year" name="year"
                                        value="{{ $activeYear }}" readonly required>
                                </div>

                                <div class="col-md-3">
                                    <label style="font-weight: bolder;">Activate Marks upload</label>

                                    <!-- Hidden input for toggle value -->
                                    <input type="hidden" name="marks_upload_enabled" id="marksUploadEnabled"
                                        value="{{ isset($activeYear) && $activeYear ? '1' : '0' }}">

                                    <div style="display:flex; align-items:center; margin-bottom:8px;">
                                        <span style="margin-right:10px;">Off</span>

                                        <label
                                            style="position:relative; display:inline-block; width:50px; height:26px; margin:0;">
                                            <input type="checkbox" id="yearToggle" style="opacity:0; width:0; height:0;"
                                                {{ isset($activeYear) && $activeYear ? 'checked' : '' }}
                                                onchange="
                                document.getElementById('marksUploadEnabled').value = this.checked ? '1' : '0';
                                this.nextElementSibling.style.backgroundColor = this.checked ? '#28a745' : '#ccc';
                                this.nextElementSibling.nextElementSibling.style.transform = this.checked ? 'translateX(24px)' : 'translateX(0)';
                            ">

                                            <span
                                                style="
                            position:absolute;
                            cursor:pointer;
                            top:0; left:0; right:0; bottom:0;
                            background-color:{{ isset($activeYear) && $activeYear ? '#28a745' : '#ccc' }};
                            transition:0.4s;
                            border-radius:34px;
                        "></span>

                                            <span
                                                style="
                            position:absolute;
                            height:18px;
                            width:18px;
                            left:4px;
                            bottom:4px;
                            background-color:white;
                            transition:0.4s;
                            border-radius:50%;
                            transform:{{ isset($activeYear) && $activeYear ? 'translateX(24px)' : 'translateX(0)' }};
                        "></span>
                                        </label>

                                        <span style="margin-left:10px;">On</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected classes container -->
                            <div id="selected-classes-container">
                                <!-- Selected classes will be added here as hidden inputs -->
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button id="submit-button" type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i> Create Exam
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mb-3"
                    style="background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #026837;">
                    <label for="yearFilter" class="form-label"
                        style="font-weight: 600; color: #026837; font-size: 16px; margin-bottom: 10px; display: block;">
                        <i class="fas fa-calendar-alt" style="margin-right: 8px; color: #026837;"></i>Select Year
                    </label>

                    <button type="button" id="toggleActiveExamsBtn" class="btn btn-sm mb-3"
                        style="
        background-color:#026837;
        color:white;
        border-radius:20px;
        padding:6px 14px;
        font-weight:600;
    ">
                        <i class="fas fa-eye me-1"></i> Show Active Examinations Upload
                    </button>

                    <div id="activeExamsSection" class="mb-4" style="display:none;">

                        <div class="mb-3"
                            style="background: linear-gradient(135deg, #e8fff0 0%, #dcfce7 100%);
               padding: 20px;
               border-radius: 10px;
               border-left: 4px solid #28a745;">

                            <label style="font-weight:600; color:#155724; font-size:16px;">
                                <i class="fas fa-toggle-on me-2"></i> Active Examinations
                            </label>
                        </div>

                        <div class="table-responsive"
                            style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">

                            <table id="activeExamsTable" class="table table-striped table-bordered"
                                style="margin-bottom:0;">
                                <thead style="display:none;">
                                    <tr>
                                        <th>No</th>
                                        <th>Examination</th>
                                        <th>Year</th>
                                        <th>Active</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>

                    <select id="yearFilter" class="form-control"
                        style="
                            border-radius: 8px;
                            border: 2px solid #026837;
                            padding: 0 15px;
                            height: 44px;
                            line-height: 44px;
                            background-color: white;
                            transition: all 0.3s ease;
                            max-width: 300px;
                        ">

                        <option value="">-- Select Year --</option>
                        <!-- Years will be loaded dynamically -->
                    </select>
                </div>

                <div class="table-responsive"
                    style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                    <table id="examsTable" class="table table-striped table-bordered"
                        style="margin-bottom: 0; border: none;">
                        <thead
                            style="background: linear-gradient(90deg, #026837 0%, #026837 100%); color: white; display:none;">
                            <tr>
                                <th style="padding: 16px 12px; border: none; font-weight: 600; text-align: center;">No</th>
                                <th style="padding: 16px 12px; border: none; font-weight: 600;">Examination Name</th>
                                <th style="padding: 16px 12px; border: none; font-weight: 600;">Classification</th>
                                <th style="padding: 16px 12px; border: none; font-weight: 600; text-align: center;">Active
                                </th>
                            </tr>
                        </thead>
                        <tbody style="background-color: white;">
                            <!-- Exams will load here via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    </div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            let yearSelect = $('#yearFilter');
            let examsTableBody = $('#examsTable tbody');

            // Load years on page load
            $.get('/exam-years', function(years) {
                years.forEach(year => {
                    yearSelect.append(`<option value="${year}">${year}</option>`);
                });
            });

            // When a year is selected
            yearSelect.on('change', function() {
                let selectedYear = $(this).val();
                examsTableBody.html('');

                if (!selectedYear) {
                    $('#examsTable thead').hide();
                    return;
                }

                $.get(`/exams-by-year/${selectedYear}`, function(exams) {

                    $('#examsTable thead').show();

                    if (exams.length === 0) {
                        examsTableBody.html(`
                <tr><td colspan="4" class="text-center text-muted">
                    No exams found for this year.
                </td></tr>
            `);
                        return;
                    }

                    exams.forEach((exam, index) => {
                        examsTableBody.append(`
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td>${exam.examination_name}</td>
                    <td>${exam.examination_classification}</td>
                    <td>${renderToggle(exam)}</td>
                </tr>
            `);
                    });
                });
            });

        });

        $(document).on('change', '.exam-toggle', function() {
            let checkbox = $(this);
            let examId = checkbox.data('id');
            let isActive = checkbox.is(':checked') ? 1 : 0;

            $.ajax({
                url: '/toggle-exam-active',
                type: 'POST',
                data: {
                    exam_id: examId,
                    is_active: isActive,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error', 'An error occurred while updating the exam.', 'error');
                    // Reset checkbox state on error
                    checkbox.prop('checked', !isActive);
                }
            });
        });

        function renderToggle(exam) {
            return `
    <div style="display:flex; justify-content:center;">
        <label style="position:relative; width:50px; height:26px;">
            <input type="checkbox" class="exam-toggle"
                data-id="${exam.id}" ${exam.is_active ? 'checked' : ''}
                style="opacity:0; width:0; height:0;">

            <span style="
                position:absolute; inset:0;
                background:${exam.is_active ? '#28a745' : '#ccc'};
                border-radius:34px; transition:.4s;">
            </span>

            <span style="
                position:absolute; height:18px; width:18px;
                left:4px; bottom:4px; background:white;
                border-radius:50%; transition:.4s;
                transform:${exam.is_active ? 'translateX(24px)' : 'translateX(0)'};
            "></span>
        </label>
    </div>`;
        }

        function loadActiveExams() {
            $.get('/active-exams', function(exams) {

                let tbody = $('#activeExamsTable tbody');
                tbody.empty();

                if (exams.length === 0) {
                    $('#toggleActiveExamsBtn').hide();
                    $('#activeExamsSection').hide();
                    return;
                }

                $('#toggleActiveExamsBtn').show();
                $('#activeExamsTable thead').show();

                exams.forEach((exam, index) => {
                    tbody.append(`
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td>${exam.examination_name}</td>
                    <td>${exam.year}</td>
                    <td>${renderToggle(exam)}</td>
                </tr>
            `);
                });
            });
        }


        // Load on page start
        loadActiveExams();
    </script>


    <script>
        $(document).ready(function() {
            $('#create-exam-form').on('submit', function(e) {
                e.preventDefault();

                // Reset error states
                $('#examNameError').hide();

                // Get the select element - adjust selector based on what Helper::DropMasterData generates
                // Assuming it generates a select with name="ExaminationName" or id="ExaminationName"
                let examNameSelect = $('select[name="ExaminationName"]');

                // Check if examination name is selected (has a value)
                if (!examNameSelect.val()) {
                    // Show error
                    $('#examNameError').show();

                    // Add Bootstrap validation class
                    examNameSelect.addClass('is-invalid');

                    // Scroll to error
                    $('html, body').animate({
                        scrollTop: examNameSelect.offset().top - 100
                    }, 500);

                    // Show error alert
                    Swal.fire({
                        title: 'Validation Error',
                        text: 'Please select an examination name.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                    });

                    return false;
                }

                // Remove invalid class if validation passes
                examNameSelect.removeClass('is-invalid');

                // Validate the toggle value (optional debugging)
                let marksUploadValue = $('#marksUploadEnabled').val();
                console.log('Marks upload enabled:', marksUploadValue);
                console.log('Examination Name:', examNameSelect.val());

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to submit the form and create the exam?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let submitBtn = $('#submit-button');
                        submitBtn.prop('disabled', true);
                        submitBtn.html('Creating Exam... <i class="fas fa-spinner fa-spin"></i>');

                        // Serialize form data
                        let formData = $(this).serialize();

                        // Debug: Log form data
                        console.log('Form data being sent:', formData);

                        $.ajax({
                            url: '/store-created-examination',
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Success', response.message, 'success')
                                        .then(() => {
                                            location.reload();
                                        });

                                    // Optional: Reset form immediately (won't hurt before reload)
                                    $('#create-exam-form')[0].reset();
                                    $('#marksUploadEnabled').val('0');
                                    $('#yearToggle').prop('checked', false).trigger(
                                        'change');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Check if it's a validation error response
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    let errorMessage = '';
                                    $.each(xhr.responseJSON.errors, function(key,
                                        value) {
                                        errorMessage += value + '\n';
                                    });
                                    Swal.fire('Error', errorMessage, 'error');
                                }
                                // Check if it's a dd() dump from Laravel
                                else if (xhr.responseText && xhr.responseText.includes(
                                        'html')) {
                                    $('body').html(xhr.responseText);
                                } else {
                                    Swal.fire('Error', 'An error occurred: ' + error,
                                        'error');
                                }
                            },
                            complete: function() {
                                submitBtn.prop('disabled', false);
                                submitBtn.html(
                                    '<i class="bi bi-plus-circle me-2"></i> Create Exam'
                                );
                            }
                        });
                    } else {
                        console.log('Form submission cancelled');
                    }
                });
            });

            // Add validation on change for examination name
            $('select[name="ExaminationName"]').on('change', function() {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    $('#examNameError').hide();
                }
            });
        });
    </script>

    <script>
        $('#toggleActiveExamsBtn').on('click', function() {
            let section = $('#activeExamsSection');
            let btn = $(this);

            if (section.is(':visible')) {
                section.slideUp(200);
                btn.html('<i class="fas fa-eye me-1"></i> Show Active Examinations');
            } else {
                section.slideDown(200);
                btn.html('<i class="fas fa-eye-slash me-1"></i> Hide Active Examinations');
            }
        });
    </script>
@endsection

<!-- Load jQuery and SweetAlert2 from CDNs -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
