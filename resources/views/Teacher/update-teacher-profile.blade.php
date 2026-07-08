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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $teacher->firstname }} {{ $teacher->surname }} Profile</h4>
                        <a href="{{ route('school.teachers', $school_id) }}" class="btn btn-info">
                            <i class="fas fa-chalkboard-teacher"></i> All Teachers
                        </a>
                    </div>

                    <div class="card-body row">
                        <div class="col-12 mb-4">
                            <div class="card p-4 shadow-sm border rounded">
                                <h4 class="mb-4 text-center">Teacher Profile</h4>

                                <div class="p-3 border rounded bg-light">

                                    <div class="text-center mb-4">
                                        <img id="logoPreview"
                                            src="{{ $teacher?->teacher_profile ? asset('storage/' . $teacher->teacher_profile) : $teacher->teacher_profile ?? asset('assets/images/brand/uplogolight.png') }}"
                                            class="img-fluid rounded border p-2"
                                            style="max-height: 180px; object-fit: contain;" alt="Teacher Profile">
                                    </div>

                                    <form method="POST" action="{{ route('teachers.update', $teacher->id) }}"
                                        enctype="multipart/form-data" id="updateTeacherForm">
                                        @csrf
                                        @method('POST')

                                        <input type="hidden" name="school_id" value="{{ $teacher->school_id }}">


                                        <div class="form-group mb-4">
                                            <label class="form-label">Upload Teacher Profile</label>
                                            <input type="file" name="teacher_profile" id="ProfileUpload"
                                                class="form-control" accept="image/*" onchange="previewLogo(event)">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="surname" class="form-label">Surname</label>
                                                    <input type="text" name="surname" id="surname" class="form-control"
                                                        value="{{ $teacher->surname }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="firstname" class="form-label">First Name</label>
                                                    <input type="text" name="firstname" id="firstname" class="form-control"
                                                        value="{{ $teacher->firstname }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="othername" class="form-label">Other Name</label>
                                                    <input type="text" name="othername" id="othername" class="form-control"
                                                        value="{{ $teacher->othername }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="initials" class="form-label">Initials</label>
                                                    <input type="text" name="initials" id="initials" class="form-control"
                                                        value="{{ $teacher->initials }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="phonenumber" class="form-label">Phone Number</label>
                                                    <input type="text" name="phonenumber" id="phonenumber"
                                                        class="form-control" value="{{ $teacher->phonenumber }}">
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="gender" class="form-label">Gender</label>
                                                        <select id="gender" name="gender" class="form-control">
                                                            <option value="{{ $teacher->gender }}">{{ $teacher->gender }}
                                                            </option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="registration_number" class="form-label">Registration
                                                        Number</label>
                                                    <input type="text" name="registration_number" id="registration_number"
                                                        class="form-control" value="{{ $teacher->registration_number }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="national_id" class="form-label">National ID</label>
                                                    <input type="text" name="national_id" id="national_id"
                                                        class="form-control" value="{{ $teacher->national_id }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="address" class="form-label">Postal Address</label>
                                                    <input type="text" name="address" id="address" class="form-control"
                                                        value="{{ $teacher->address }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="employee_number" class="form-label">Employee
                                                        Number</label>
                                                    <input type="text" name="employee_number" id="employee_number"
                                                        class="form-control" value="{{ $teacher->employee_number }}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label" for="group_teacher">Group Teacher Groups
                                                        (1,2,3,4,5)</label>
                                                    <select id="group_teacher" name="group_teacher" class="form-control">
                                                        @if(empty($teacher->group_teacher))
                                                            <option value="" disabled selected>Select group</option>
                                                        @else
                                                            <option value="{{ $teacher->group_teacher }}">
                                                                Group {{ $teacher->group_teacher }}</option>
                                                        @endif
                                                        <option value="1">Group 1</option>
                                                        <option value="2">Group 2</option>
                                                        <option value="3">Group 3</option>
                                                        <option value="4">Group 4</option>
                                                        <option value="5">Group 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <i class="fas fa-save me-2"></i> Update Teacher Profile
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <style>
                                    .form-control[type="file"] {
                                        padding: 0.2rem 0.2rem;
                                        width: 100%;
                                        font-size: 1rem;
                                        font-weight: 400;
                                        line-height: 1.5;
                                        color: #212529;
                                        background-color: #fff;
                                        border: 1px solid #ced4da;
                                        border-radius: 0.25rem;
                                        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                                        display: block;
                                        height: calc(1.5em + 0.75rem + 2px);
                                        box-sizing: border-box;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>

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
            $('#updateTeacherForm').on('submit', function (e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                let formData = new FormData(this);

                // Reset previous errors
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to update this teacher's profile.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $submitBtn.prop('disabled', true);
                        const originalBtnHtml = $submitBtn.html();
                        $submitBtn.html('Updating... <i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: "{{ route('teachers.update', $teacher->id) }}",
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: 'Teacher profile has been successfully updated.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            // error: function(xhr) {
                            //     if (xhr.status === 422) {
                            //         let errors = xhr.responseJSON.errors;
                            //         for (let field in errors) {
                            //             let input = $form.find(`[name="${field}"]`);
                            //             input.addClass('is-invalid');
                            //             input.after(
                            //                 `<div class="invalid-feedback">${errors[field][0]}</div>`
                            //             );
                            //         }

                            //         Swal.fire({
                            //             icon: 'error',
                            //             title: 'Validation Error',
                            //             text: 'Please correct the highlighted fields.'
                            //         });
                            //     } else {
                            //         console.error(xhr);
                            //         Swal.fire({
                            //             icon: 'error',
                            //             title: 'Oops!',
                            //             text: 'Something went wrong while updating.'
                            //         });
                            //     }
                            // },
                            error: function (data) {
                                $('body').html(data.responseText);
                            },
                            complete: function () {
                                $submitBtn.prop('disabled', false).html(
                                    originalBtnHtml);
                            }
                        });
                    }
                });
            });
        });
    </script>


    <!-- JS to Preview Logo -->
    <script>
        function previewLogo(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('logoPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
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