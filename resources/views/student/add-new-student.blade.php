<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
@section('content')
    <div class="side-app">

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.subjects-buttons')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">Add Student</h4>
                        <a href="{{ url('students/all-students') }}" class="btn text-white"
                            style="background-color: #16c53c;">
                            <i class="fas fa-users text-white"></i> All Students
                        </a>
                    </div>
                    <div class="card-body bg-light">
                        <form id="createStudentForm" method="POST" action="{{ route('students.store') }}">
                            @csrf

                            <div class="student-form-grid">

                                <div class="form-group">
                                    <label>School <span class="text-danger">*</span></label>
                                    <select name="School" class="form-control select2" required>
                                        <option value="">-- Select School --</option>
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->ID }}">
                                                {{ $school->House }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="Category" class="form-control select2" required>
                                        <option value="">-- Select --</option>
                                        <option value="UCE">O-LEVEL (UCE)</option>
                                        <option value="UACE">A-LEVEL (UACE)</option>
                                        <!-- <option value="PLE">Primary - PLE</option> -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Admission Year <span class="text-danger">*</span></label>
                                    <select name="Admission_Year" id="year" class="form-control select2" required>
                                        <option value="">-- Select Year --</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->year_en}}">{{ $year->year_en }} - {{ $year->year_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Student ID <span class="text-danger">*</span></label>
                                    <input type="text" name="Student_ID" class="form-control" id="Student_ID" readonly
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>Student Name <span class="text-danger">*</span></label>
                                    <input type="text" name="Student_Name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Student Name (AR)</label>
                                    <input type="text" name="Student_Name_AR" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="Date_of_Birth" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Student Nationality</label>
                                    <input type="text" name="StudentNationality" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Student Sex <span class="text-danger">*</span></label>
                                    <select name="StudentSex" class="form-control select2" required>
                                        <option value="">-- Select --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn text-white" style="background-color:#0bb931;">
                                    <i class="fa-solid fa-paper-plane me-2"></i> Submit
                                </button>
                            </div>

                        </form>

                        <style>
                            .student-form-grid {
                                display: grid;
                                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                                gap: 10px 20px;
                            }

                            .student-form-grid .form-group {
                                margin-bottom: 5px;
                            }

                            .student-form-grid label {
                                margin-bottom: 3px;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {

            function submitStudentForm($form, $submitBtn) {

                let formData = {
                    Student_Name: $form.find('[name="Student_Name"]').val(),
                    Student_Name_AR: $form.find('[name="Student_Name_AR"]').val(),
                    date_of_birth: $form.find('[name="Date_of_Birth"]').val(),
                    nationality: $form.find('[name="StudentNationality"]').val(),
                    StudentSex: $form.find('[name="StudentSex"]').val(),
                    school_id: $form.find('[name="School"]').val(),
                    Category: $form.find('[name="Category"]').val(),
                    Admission_Year: $form.find('[name="Admission_Year"]').val(),
                    Student_ID: $form.find('[name="Student_ID"]').val()
                };

                let originalHtml = $submitBtn.html();
                $submitBtn.prop('disabled', true).html('Saving... <i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire('Success!', response.message, 'success');
                        $form[0].reset();
                        $('.select2').val('').trigger('change');
                    },
                    error: function (data) {
                        $('body').html(data.responseText);
                    },
                    complete: function () {
                        $submitBtn.prop('disabled', false).html(originalHtml);
                    }
                });
            }

            // Function to generate student ID dynamically
            function updateStudentID() {
                let schoolId = $('select[name="School"]').val();
                let category = $('select[name="Category"]').val();
                let year = $('select[name="Admission_Year"]').val();

                if (schoolId && category && year) {
                    $.ajax({
                        url: '{{ route('students.generate-id') }}',
                        data: {
                            school_id: schoolId,
                            category: category,
                            year: year
                        },
                        success: function(res) {
                            $('#Student_ID').val(res.student_id);
                        }
                    });
                } else {
                    $('#Student_ID').val('');
                }
            }

            // Trigger Student ID update when selections change
            $('select[name="School"], select[name="Category"], select[name="Admission_Year"]').on('change',
                updateStudentID);

            // Form submission with validation and SweetAlert confirmation
            $('#createStudentForm').on('submit', function (e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                let isValid = true;

                $form.find('.form-control').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                // Required fields
                let requiredFields = ['School', 'Category', 'Admission_Year', 'Student_ID', 'Student_Name',
                    'StudentSex'
                ];

                requiredFields.forEach(field => {
                    let input = $form.find(`[name="${field}"]`);
                    if (!input.val() || input.val().trim() === '') {
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">This field is required.</div>');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Form',
                        text: 'Please fill in all required fields before submitting.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to submit the student data.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('Submitting form via AJAX:', $form.serialize());
                        submitStudentForm($form, $submitBtn);
                    }
                });

            });

        });
    </script>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script></script>
@endsection