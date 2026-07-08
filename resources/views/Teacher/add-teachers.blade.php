<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Student Dashboard -->
    <div class="side-app">

        <!-- HTML -->
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">Add Teacher</h4>
                        <a href="{{ route('school.teachers', $school_id) }}" class="btn btn-info">
                            <i class="fas fa-chalkboard-teacher"></i> All Teachers
                        </a>
                    </div>
                    <div class="card-body bg-light">
                        <form id="createSchoolTeacher">
                            <div class="row">
                                <input type="hidden" name="school_id" id="school_id" value="{{ $school_id }}">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="surname">Surname</label>
                                        <input type="text" id="surname" name="surname" class="form-control"
                                            placeholder="Enter surname">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="firstname">Firstname</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control"
                                            placeholder="Enter firstname">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="othername">Othername</label>
                                        <input type="text" id="othername" name="othername" class="form-control"
                                            placeholder="Enter other name(s)">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="initials">Initials</label>
                                        <input type="text" id="initials" name="initials" class="form-control"
                                            placeholder="Enter initials">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="phonenumber">Phone Number</label>
                                        <input type="tel" id="phonenumber" name="phonenumber" class="form-control"
                                            placeholder="Enter phone number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="registration_number">Reg. No</label>
                                        <input type="text" id="registration_number" name="registration_number"
                                            class="form-control" placeholder="Enter registration number">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="Email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            placeholder="Enter teacher email">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="national_id">National ID No.</label>
                                        <input type="text" id="national_id" name="national_id" class="form-control"
                                            placeholder="Enter national ID number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" id="address" name="address" class="form-control"
                                            placeholder="Enter address">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="employee_number">Employee Number</label>
                                        <input type="text" id="employee_number" name="employee_number" class="form-control"
                                            placeholder="Enter employee number">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label" for="group_teacher">Group Teacher Groups
                                            (1,2,3,4,5)</label>
                                        <select id="group_teacher" name="group_teacher" class="form-control">
                                            <option value="" disabled selected>Select group</option>
                                            <option value="1">Group 1</option>
                                            <option value="2">Group 2</option>
                                            <option value="3">Group 3</option>
                                            <option value="4">Group 4</option>
                                            <option value="5">Group 5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-left">
                                <button type="submit" class="btn btn-primary">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#createSchoolTeacher').on('submit', function (e) {
                e.preventDefault();

                let isValid = true;
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');

                $form.find('.form-control, select').removeClass('is-invalid');

                const requiredFields = ['surname', 'firstname', 'phonenumber', 'email'];

                requiredFields.forEach(function (field) {
                    let input = $form.find(`[name="${field}"]`);
                    if (!input.val().trim()) {
                        input.addClass('is-invalid');
                        if (input.next('.invalid-feedback').length === 0) {
                            input.after('<div class="invalid-feedback">This field is required.</div>');
                        }
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
                    text: "You are about to submit the teacher data.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm($form, $submitBtn, false); // first try
                    }
                });
            });

            function submitForm($form, $submitBtn, confirmExisting) {
                $submitBtn.prop('disabled', true);
                const originalBtnHtml = $submitBtn.html();
                $submitBtn.html('Saving...<i class="fas fa-spinner fa-spin"></i>');

                let formData = $form.serialize();

                if (confirmExisting) {
                    formData += '&confirm_existing=1'; // append confirm flag
                }

                $.ajax({
                    url: '{{ route('teachers.store') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.exists && !confirmExisting) {
                            Swal.fire({
                                title: 'Email already exists',
                                text: response.message,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, continue',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    submitForm($form, $submitBtn, true); // retry with confirm flag
                                }
                            });
                        } else {
                            Swal.fire('Submitted!', response.message, 'success');
                            $form[0].reset();
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors) {
                                for (let field in errors) {
                                    let input = $form.find(`[name="${field}"]`);
                                    input.addClass('is-invalid');
                                    if (input.next('.invalid-feedback').length === 0) {
                                        input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                    }
                                }
                            }

                            if (xhr.responseJSON.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    text: xhr.responseJSON.message
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    text: 'Please fix the errors and try again.'
                                });
                            }
                        } else {
                            let errorMessage = xhr.responseJSON?.message || xhr.statusText || 'An unexpected error occurred';
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                html: `<pre>${errorMessage}</pre>`,
                            });
                        }
                    },
                    complete: function () {
                        $submitBtn.prop('disabled', false).html(originalBtnHtml);
                    }
                });
            }
        });
    </script>

@endsection
@section('js')
    <!-- c3.js Charts js-->
    <script src="{{ URL::asset('assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/charts-c3/c3-chart.js') }}"></script>
    <script src="{{ URL::asset('assets/js/charts.js') }}"></script>

    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection