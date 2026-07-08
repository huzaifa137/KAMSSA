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
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

        <div class="row">
            <div class="col-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">
                            <i class="bi bi-pencil-square me-2"></i> Create Exam
                        </h4>
                    </div>

                    <div class="card-body bg-white">
                        <form>
                            @csrf

                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="text" class="form-control" placeholder="Create Exam" name="exam_name"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
    echo Helper::DropMasterData(config('constants.options.SCHOOL_TERMS'), '', 'term', 1);
                                                                                                    
                                                                                                    ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <input type="number" class="form-control" placeholder="Year" name="year"
                                        value="{{ $activeYear }}" disabled required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                                    <span>Select the Classes You Wish to Take this Exam</span>
                                    <span id="selected-count" class="badge rounded-pill bg-primary text-white">0</span>
                                </label>
                                <div class="row g-2">
                                    @foreach ($SecondaryClasses as $index => $class)
                                        <div class="col-4">
                                            <div
                                                class="form-check card text-center class-card {{ $index < 3 ? 'selected-card' : '' }}">
                                                <input class="form-check-input d-none class-checkbox" type="checkbox"
                                                    name="class_ids[]" value="{{ $class->md_id }}"
                                                    id="class_{{ $class->md_id }}" @if($index < 3) checked @endif>

                                                <label class="form-check-label stretched-link" for="class_{{ $class->md_id }}">
                                                    {{ $class->md_name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="selection-summary" class="mt-2 text-muted fw-bold big">
                                    <span style="font-weight: bold;">Selected Classes:</span> <span
                                        id="summary-text">None</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button id="submit-button" type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i> Create Exam
                                    </button>
                                </div>
                            </div>

                        </form>
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
        $(document).ready(function () {
            $('.class-checkbox').on('change', function () {
                if ($(this).is(':checked')) {
                    $(this).closest('.class-card').addClass('selected-card');
                } else {
                    $(this).closest('.class-card').removeClass('selected-card');
                }
            });
        });

        $(document).ready(function () {
            function updateSelectionUI() {
                let selectedNames = [];

                $('.class-checkbox:checked').each(function () {
                    selectedNames.push($(this).siblings('.form-check-label').text().trim());
                });

                $('#selected-count').text(selectedNames.length);

                if (selectedNames.length > 0) {
                    $('#summary-text').text(selectedNames.join(', ')).removeClass('text-danger');
                } else {
                    $('#summary-text').text('None selected').addClass('text-danger');
                }
            }

            updateSelectionUI();

            $('.class-checkbox').on('change', function () {
                if ($(this).is(':checked')) {
                    $(this).closest('.class-card').addClass('selected-card');
                } else {
                    $(this).closest('.class-card').removeClass('selected-card');
                }
                updateSelectionUI();
            });
        });


$(document).ready(function () {
    function updateSelectionUI() {
        let selectedNames = [];

        $('.class-checkbox:checked').each(function () {
            selectedNames.push($(this).siblings('.form-check-label').text().trim());
        });

        $('#selected-count').text(selectedNames.length);

        if (selectedNames.length > 0) {
            $('#summary-text').text(selectedNames.join(', ')).removeClass('text-danger');
        } else {
            $('#summary-text').text('None selected').addClass('text-danger');
        }
    }

    updateSelectionUI();

    $('.class-checkbox').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.class-card').addClass('selected-card');
        } else {
            $(this).closest('.class-card').removeClass('selected-card');
        }
        updateSelectionUI();
    });

    $('form').on('submit', function (e) {
        e.preventDefault();

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

                let formData = $(this).serialize();

                $.ajax({
                    url: '/store-created-exam',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        // Show success message
                        Swal.fire('Success', 'Exam created successfully!', 'success');
                    },
                    error: function (data) {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();

                        let errors = data.responseJSON.errors;

                        if (errors) {
                            $.each(errors, function (field, messages) {
                                let inputField = $('[name="' + field + '"]');
                                inputField.addClass('is-invalid');
                                inputField.after('<div class="invalid-feedback">' + messages.join('<br>') + '</div>');
                            });
                        }

                        if (errors && Object.keys(errors).length > 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please fix the errors and try again.',
                            });
                        }
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="bi bi-plus-circle me-2"></i> Create Exam');
                    }
                });
            } else {
                console.log('Form submission cancelled');
            }
        });
    });
});

    </script>

@endsection

<!-- Load jQuery and SweetAlert2 from CDNs -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>