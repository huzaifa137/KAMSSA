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
                        <a href="{{ url('students/all-students') }}" class="btn text-white" style="background-color: #287C44;">
                            <i class="fas fa-users text-white"></i> All Students
                        </a>
                    </div>
                    <div class="card-body bg-light">
                        <form id="createStudentForm">

                            <div class="row">
                                <!-- Left column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Firstname <span style="color: red;">(*)</span></label>
                                        <input type="text" name="firstname" class="form-control"
                                            placeholder="Enter firstname">
                                    </div>
                                    <div class="form-group">
                                        <label>Lastname <span style="color: red;">(*)</span></label>
                                        <input type="text" name="lastname" class="form-control"
                                            placeholder="Enter lastname">
                                    </div>
                                    <div class="form-group">
                                        <label>Senior <span style="color: red;">(*)</span></label>

                                        <select class="form-control select2" id="senior" name="senior">
                                            <option value="">-- Select --</option>
                                            @foreach ($classRecord as $class)
                                                <option value="{{ $class->md_name }}">
                                                    {{ $class->md_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Stream <span style="color: red;">(*)</span></label>
                                        <input type="text" class="form-control" id="stream" name="stream"
                                            placeholder="Enter stream" value="{{ old('stream') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Gender <span style="color: red;">(*)</span> </label>
                                        <select name="gender" class="form-control">
                                            <option value="">Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Admission Number</label>
                                        <input type="text" name="admission_number" class="form-control"
                                            placeholder="Admission number">
                                    </div>
                                    <div class="form-group">
                                        <label>Primary Contact</label>
                                        <input type="text" name="primary_contact" class="form-control"
                                            placeholder="Phone number">
                                    </div>
                                    <div class="form-group">
                                        <label>Other Contact</label>
                                        <input type="text" name="other_contact" class="form-control"
                                            placeholder="Alternate number">
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Admission</label>
                                        <input type="date" name="date_of_admission" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Place of Birth</label>
                                        <input type="text" name="place_of_birth" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <input type="text" name="nationality" class="form-control">
                                    </div>
                                </div>

                                <!-- Right column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PLE Score</label>
                                        <input type="number" step="0.01" name="ple_score" class="form-control"
                                            placeholder="Enter PLE score">
                                    </div>
                                    <div class="form-group">
                                        <label>UCE Score</label>
                                        <input type="number" step="0.01" name="uce_score" class="form-control"
                                            placeholder="Enter UCE score">
                                    </div>
                                    <div class="form-group">
                                        <label>School <span style="color: red;">(*)</span></label>
                                        <select name="school_id" id="school_id" class="form-control select2">
                                            <option value="">-- Select School --</option>

                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}"
                                                    {{ $school->id == $school_id ? 'selected' : '' }}>
                                                    {{ $school->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Primary School Name</label>
                                        <input type="text" name="primary_school_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Guardian Names</label>
                                        <input type="text" name="guardian_names" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Relation to Student</label>
                                        <input type="text" name="relation" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Guardian Phone</label>
                                        <input type="text" name="guardian_phone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Guardian Email</label>
                                        <input type="email" name="guardian_email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Home Address</label>
                                        <textarea name="home_address" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Birth Certificate Entry Number</label>
                                        <input type="text" name="birth_certificate_entry_number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Medical History</label>
                                        <textarea name="medical_history" class="form-control" rows="2"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea name="comments" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-left">
                                <button type="submit" class="btn text-white" style="background-color: #287C44;">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </form>
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
        $(document).ready(function() {
            $('#createStudentForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                let isValid = true;

                $form.find('.form-control, select').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                // Basic required fields
                let requiredFields = ['firstname', 'lastname', 'gender', 'school_id', 'senior', 'stream'];

                requiredFields.forEach(field => {
                    let input = $form.find(`[name="${field}"]`);
                    if (!input.val().trim()) {
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
                        submitStudentForm($form, $submitBtn);
                    }
                });
            });

            function submitStudentForm($form, $submitBtn) {
                let formData = $form.serialize();
                let originalHtml = $submitBtn.html();

                $submitBtn.prop('disabled', true).html('Saving... <i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '{{ route('students.store') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Success!', response.message, 'success');
                        $form[0].reset();
                    },
                    // error: function(xhr) {
                    //     if (xhr.status === 422) {
                    //         let errors = xhr.responseJSON.errors;
                    //         for (let field in errors) {
                    //             let input = $form.find(`[name="${field}"]`);
                    //             input.addClass('is-invalid');
                    //             input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                    //         }

                    //         Swal.fire({
                    //             icon: 'error',
                    //             title: 'Validation Error',
                    //             text: 'Please fix the highlighted errors.'
                    //         });
                    //     } else {
                    //         Swal.fire({
                    //             icon: 'error',
                    //             title: 'Server Error',
                    //             text: xhr.responseJSON?.message ||
                    //                 'An unexpected error occurred.'
                    //         });
                    //     }
                    // },
                    error: function(data) {
                        $('body').html(data.responseText);
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html(originalHtml);
                    }
                });
            }
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
