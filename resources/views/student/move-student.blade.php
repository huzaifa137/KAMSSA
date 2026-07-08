{{-- FILE: resources/views/students/move-student.blade.php (updated) --}}
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
            <div class="col-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">Move Student</h4>
                    </div>

                    <div class="card-body bg-light">
                        <!-- Search Form -->
                        <form id="searchStudentForm" class="mb-4">
                            <input type="hidden" name="school_id" value="{{ $school_id }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="current_senior">Current Class</label>
                                        <select class="form-control select2" id="current_senior" name="senior" required>
                                            <option value="">-- Select Class --</option>
                                            @foreach ($classrooms as $class)
                                                <option value="{{ $class->class_name }}">
                                                    {{ Helper::recordMdname($class->class_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="current_stream">Current Stream</label>
                                        <select class="form-control select2" id="current_stream" name="stream" required>
                                            <option value="">-- Select Stream --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="invisible d-block">Search</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Student Results and Move Form -->
                        <form id="moveStudentForm" style="display: none;">
                            <h5 class="text-primary mb-3">Students Found</h5>

                            <!-- Placeholder styled table -->
                            <div id="student-list-container" class="mb-4">
                                <table class="table table-bordered ">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center align-middle" style="width: 50px;">
                                                <input type="checkbox" class="form-check-input" id="selectAllCheckboxes">
                                            </th>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <th>Stream</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- JS will inject student rows here -->
                                    </tbody>
                                </table>
                            </div>

                            <hr class="my-4">

                            <h5 class="text-primary mb-3">Move to New Class and Stream</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Class <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="new_senior" name="new_senior" required>
                                            <option value="">-- Select Class --</option>
                                            @foreach ($classrooms as $class)
                                                <option value="{{ $class->class_name }}">
                                                    {{ Helper::recordMdname($class->class_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">This field is required.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Stream <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="new_stream" name="new_stream" required>
                                            <option value="">-- Select Stream --</option>
                                        </select>
                                        <div class="invalid-feedback">This field is required.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-sync-alt"></i> Move Selected Student(s)
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
    </div>

@endsection

<!-- Load jQuery and SweetAlert2 from CDNs -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script to handle dynamic stream loading and form submission -->
<script>
    $(document).ready(function () {

        // --- Helper Functions ---
        function showMessage(icon, title, text) {
            Swal.fire({ icon, title, text });
        }

        function resetForm($form) {
            $form[0].reset();
            $form.find('.form-control, select').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
        }

        function renderStudents(students) {
            const container = $('#student-list-container');
            container.empty();

            if (students.length > 0) {
                let tableHtml = `
            <div class="table-responsive">
                <table class="table table-striped table-bordered  align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle" style="width: 50px;">
                                <input type="checkbox" class="form-check-input" id="selectAllCheckboxes">
                            </th>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Admission No.</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
                students.forEach((student, index) => {
                    tableHtml += `
                <tr>
                    <td class="text-center">
                            <input class="form-check-input" type="checkbox" name="student_ids[]" value="${student.id}">
                    </td>
                    <td>${index + 1}</td>
                    <td>${student.firstname} ${student.lastname}</td>
                    <td>${student.admission_number || 'N/A'}</td>
                </tr>
            `;
                });
                tableHtml += `
                    </tbody>
                </table>
            </div>
        `;
                container.append(tableHtml);
                $('#moveStudentForm').show();

                // Select all behavior
                $('#selectAllCheckboxes').on('change', function () {
                    const checked = $(this).is(':checked');
                    $('input[name="student_ids[]"]').prop('checked', checked);
                });

            } else {
                container.append('<p class="text-danger">No students found in the selected class and stream.</p>');
                $('#moveStudentForm').hide();
            }
        }



        // --- Event Listeners ---

        // Event listener for the "Current Class" dropdown to load streams
        $('#current_senior').on('change', function () {
            let className = $(this).val();
            let $streamSelect = $('#current_stream');

            $streamSelect.empty().append('<option value="">-- Select Stream --</option>');

            if (className) {
                $.ajax({
                    url: "{{ route('streams.by.class') }}",
                    method: 'GET',
                    data: { class_id: className },
                    success: function (response) {
                        if (response.length > 0) {
                            response.forEach(function (stream) {
                                $streamSelect.append(
                                    $('<option>', {
                                        value: stream.stream_id,
                                        text: stream.display_name
                                    })
                                );

                            });
                        }
                    },
                    error: function (data) {
                        $('body').html(data.responseText);
                    }
                });
            }
        });

        // Event listener for the "Search" form
        $('#searchStudentForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('students.search') }}",
                method: 'GET',
                data: formData,
                beforeSend: function () {
                    $('#student-list-container').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Searching...</div>');
                },
                success: function (response) {
                    renderStudents(response);
                },
                error: function (xhr) {
                    let errorMessage = 'An unexpected error occurred.';
                    if (xhr.status === 422) {
                        errorMessage = 'Please select both a class and a stream.';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showMessage('error', 'Search Failed', errorMessage);
                    renderStudents([]); // Clear the list on error
                }
            });
        });

        // Event listener for the "New Class" dropdown to load streams
        $('#new_senior').on('change', function () {
            let className = $(this).val();
            let $streamSelect = $('#new_stream');

            $streamSelect.empty().append('<option value="">-- Select Stream --</option>');

            if (className) {
                $.ajax({
                    url: "{{ route('streams.by.class') }}",
                    method: 'GET',
                    data: { class_id: className },
                    success: function (response) {
                        if (response.length > 0) {
                            response.forEach(function (stream) {
                                $streamSelect.append(
                                    $('<option>', {
                                        value: stream.stream_id,
                                        text: stream.display_name
                                    })
                                );
                            });
                        }
                    },
                    error: function (data) {
                        $('body').html(data.responseText);
                    }
                });
            }
        });


        // Event listener for the "Move Student" form
        $('#moveStudentForm').on('submit', function (e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');

            let studentIds = [];
            $('[name="student_ids[]"]:checked').each(function () {
                studentIds.push($(this).val());
            });

            if (studentIds.length === 0) {
                showMessage('error', 'Selection Required', 'Please select at least one student to move.');
                return;
            }

            let newSenior = $('#new_senior').val();
            let newStream = $('#new_stream').val();

            if (!newSenior || !newStream) {
                showMessage('error', 'Incomplete Form', 'Please select the new class and stream.');
                return;
            }

            Swal.fire({
                title: 'Confirm Move',
                text: `Are you sure you want to move the selected ${studentIds.length} student(s)?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, move them!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitMoveForm(studentIds, newSenior, newStream, $submitBtn);
                }
            });
        });

        function submitMoveForm(studentIds, newSenior, newStream, $submitBtn) {
            let originalHtml = $submitBtn.html();
            $submitBtn.prop('disabled', true).html('Moving... <i class="fas fa-spinner fa-spin"></i>');

            let formData = {
                student_ids: studentIds,
                new_senior: newSenior,
                new_stream: newStream,
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('students.move') }}",
                method: 'POST',
                data: formData,
                success: function (response) {
                    showMessage('success', 'Success!', response.message);
                    resetForm($('#moveStudentForm'));
                    $('#moveStudentForm').hide();
                    $('#student-list-container').empty();
                },
                error: function (xhr) {
                    let errorMessage = 'An unexpected error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showMessage('error', 'Move Failed', errorMessage);
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).html(originalHtml);
                }
            });
        }
    });
</script>