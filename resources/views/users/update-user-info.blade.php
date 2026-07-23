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
                        <h4 class="card-title mb-0 text-white">Update User</h4>
                        <a href="javascript:void();" class="btn text-white" style="background-color: #287C44;">
                            <i class="fas fa-edit"></i> Edit User</a>
                    </div>
                    <div class="card-body bg-light">

                        <form id="createSchoolTeacher">
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ $teacher->id }}">

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" id="username" name="username" class="form-control"
                                            placeholder="Enter username" value="{{ old('username', $teacher->username) }}">
                                    </div>

                                    {{-- <div class="form-group">
                                        <label class="form-label" for="firstname">Firstname</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control"
                                            placeholder="Enter firstname"
                                            value="{{ old('firstname', @$teacher->firstname) }}">
                                    </div> --}}

                                    {{-- <div class="form-group">
                                        <label class="form-label" for="phonenumber">Phone Number</label>
                                        <input type="tel" id="phonenumber" name="phonenumber" class="form-control"
                                            placeholder="Enter phone number"
                                            value="{{ old('phonenumber', @$teacher->phonenumber) }}">
                                    </div> --}}
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    {{-- <div class="form-group">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="male" {{ old('gender', @$teacher->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', @$teacher->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div> --}}

                                    <div class="form-group">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            placeholder="Enter teacher email" value="{{ old('email', $teacher->email) }}">
                                    </div>
                                </div>

                                {{-- <div class="col-lg-12 col-md-12">
                                    <div class="form-group mt-3">
                                        <label class="form-label">Attached Roles</label>
                                        <div class="row">
                                            @foreach ($roles as $role)
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                                            value="{{ $role->id }}"
                                                            id="role_{{ $role->id }}"
                                                            {{ in_array($role->id, $userRoles) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                                            <i class="fas fa-crown me-1 text-warning"></i> {{ $role->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Update
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

                const requiredFields = ['username', 'email'];

                requiredFields.forEach(function (field) {
                    let input = $form.find(`[name="${field}"]`);
                    if (!input.val().trim()) {
                        input.addClass('is-invalid');

                        if (input.next('.invalid-feedback').length === 0) {
                            input.after(
                                '<div class="invalid-feedback">This field is required.</div>');
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
                    text: "You are about to update the user data.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $submitBtn.prop('disabled', true);
                        const originalBtnHtml = $submitBtn.html();
                        $submitBtn.html('Saving...<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '{{ route('users.update.information') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Submitted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload(); // 🔄 Reload after Swal is dismissed
                                });
                            },
                            error: function (xhr) {
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    for (let field in errors) {
                                        let input = $form.find(`[name="${field}"]`);
                                        input.addClass('is-invalid');
                                        if (input.next('.invalid-feedback').length === 0) {
                                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                        }
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        text: 'Please fix the errors and try again.'
                                    });
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
            });
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