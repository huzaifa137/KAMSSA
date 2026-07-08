<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
@section('content')
    <div class="side-app">

        <style>
            .swal2-container {
                z-index: 99999 !important;
            }

            .dataTables_filter {
                float: right !important;
                text-align: right !important;
            }
        </style>
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
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"  style="background-color: #026837;">
                        <h4 class="card-title mb-0 text-white">Students List</h4>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="schoolsTable" class="table table-striped table-bordered  align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Admission No.</th>
                                        <th>Class</th>
                                        <th>Stream</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                            <td>{{ $student->gender }}</td>
                                            <td>{{ $student->admission_number }}</td>
                                            <td>{{ Helper::recordMdname($student->senior) }}</td>
                                            <td>{{ Helper::recordMdname($student->stream) }}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-id="{{ $student->id }}"
                                                    class="btn btn-outline-primary btn-sm btn-edit-student">
                                                    <i class="fa fa-edit mr-1"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Edit Student Modal -->
                    <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog"
                        aria-labelledby="editStudentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <form id="updateStudentForm">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                                        <button type="button" class="close text-white" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="student_id" id="edit_student_id">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Basic Info -->
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" name="firstname" id="edit_firstname"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" name="lastname" id="edit_lastname"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select name="gender" id="edit_gender" class="form-control">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Admission Number</label>
                                                    <input type="text" name="admission_number" id="edit_admission_number"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Class</label>

                                                    <select class="form-control select2" id="edit_senior"
                                                        name="edit_senior">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($classRecord as $class)
                                                            <option value="{{ $class->md_id }}">
                                                                {{ $class->md_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="form-group">
                                                    <label>Stream</label>
                                                    <select name="stream" id="edit_stream" class="form-control" disabled>
                                                        <option value="">-- Select Stream --</option>
                                                        @foreach ($StreamRecord as $stream)
                                                            <option value="{{ $stream->stream_id }}">
                                                                {{ Helper::recordMdname($stream->stream_id) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <!-- Guardian / Contact -->
                                                <div class="form-group">
                                                    <label>Primary Contact</label>
                                                    <input type="text" name="primary_contact" id="edit_primary_contact"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Other Contact</label>
                                                    <input type="text" name="other_contact" id="edit_other_contact"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="date" name="date_of_birth" id="edit_date_of_birth"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nationality</label>
                                                    <input type="text" name="nationality" id="edit_nationality"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Guardian Names</label>
                                                    <input type="text" name="guardian_names" id="edit_guardian_names"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Guardian Phone</label>
                                                    <input type="text" name="guardian_phone" id="edit_guardian_phone"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-save me-1"></i> Update Student
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                let requiredFields = ['firstname', 'lastname', 'senior', 'stream', 'gender'];

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
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                let input = $form.find(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: 'Please fix the highlighted errors.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: xhr.responseJSON?.message ||
                                    'An unexpected error occurred.'
                            });
                        }
                    },
                    // error: function (data) {
                    //     $('body').html(data.responseText);
                    // },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html(originalHtml);
                    }
                });
            }
        });


        $(document).ready(function() {

            $('.btn-edit-student').on('click', function() {
                const studentId = $(this).data('id');

                $.ajax({
                    url: "{{ url('/students/Information') }}/" + studentId,
                    method: 'GET',
                    success: function(student) {
                        $('#edit_student_id').val(student.id);
                        $('#edit_firstname').val(student.firstname);
                        $('#edit_lastname').val(student.lastname);
                        $('#edit_gender').val(student.gender);
                        $('#edit_admission_number').val(student.admission_number);
                        $('#edit_senior').val(student.senior_id);
                        $('#edit_stream').val(student.stream_id);
                        $('#edit_primary_contact').val(student.primary_contact);
                        $('#edit_other_contact').val(student.other_contact);
                        $('#edit_date_of_birth').val(student.date_of_birth);
                        $('#edit_nationality').val(student.nationality);
                        $('#edit_guardian_names').val(student.guardian_names);
                        $('#edit_guardian_phone').val(student.guardian_phone);

                        $('#editStudentModal').modal('show');
                    },
                    error: function(data) {
                        $('body').html(data.responseText);
                    }
                });
            });


            // Submit update
            $('#updateStudentForm').on('submit', function(e) {
                e.preventDefault();

                const studentId = $('#edit_student_id').val();
                const formData = $(this).serialize();

                Swal.fire({
                    title: 'Confirm Update',
                    text: 'Are you sure you want to update this student?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {

                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: "{{ url('/students/update') }}/" + studentId,
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        success: function(response) {

                            Swal.fire({
                                title: 'Success',
                                text: response.message ||
                                    'Student updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#editStudentModal').modal('hide');
                                location.reload();
                            });

                        },
                        error: function(xhr) {
                            let errorText = 'Something went wrong';

                            if (xhr.status === 422 && xhr.responseJSON.errors) {
                                errorText = Object.values(xhr.responseJSON.errors).join(
                                    '<br>');
                            }

                            Swal.fire({
                                title: 'Error',
                                html: errorText,
                                icon: 'error',
                                didOpen: () => {
                                    const swalEl = Swal.getPopup();
                                    swalEl.style.zIndex =
                                        parseInt($('.modal').css(
                                        'z-index')) + 10;
                                }
                            });
                        }
                    });

                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#schoolsTable').DataTable({
                responsive: false,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                dom: 'frtip',
                columnDefs: [{
                        orderable: false,
                        targets: [1, 4, 5]
                    },
                    {
                        className: 'text-center',
                        targets: '_all'
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Students..."
                }
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
