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
@section('page-header')
@endsection
@section('content')
    <br> <br>

    <div class="row ">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <h4 class="page-title" style="text-align: center;">Student Information Update</h4>
            <br>

            <form action="{{ route('update-internal-user') }}" class="border" method="POST" id="userForm">

                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif

                <input type="hidden" name="user_id" id="user_id" value="{{ $info->id }}">

                <div class="row">

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="usernameinput-sm form-control"
                            placeholder="Enter username" value="{{ @$info->username }}" required>
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Firstname<span class="text-danger"></span></label>
                        <input type="text" name="firstname" id="firstname" class="input-sm form-control"
                            placeholder="Enter Firstname" value="{{ @$info->firstname }}">
                        <span class="text-danger">
                            @error('firstname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Lastname<span class="text-danger"></span></label>
                        <input type="text" name="lastname" id="lastname" class="input-sm form-control"
                            placeholder="Enter Lastname" value="{{ @$info->lastname }}">
                        <span class="text-danger">
                            @error('lastname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Gender<span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="input-sm form-control">
                            @if (@$info->gender)
                                <option value="{{ $info->gender }}">{{ @$info->gender }}</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            @else
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="email input-sm form-control"
                            placeholder="Enter Email" value="{{ @$info->email }}">
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Phonenumber<span class="text-danger"></span></label>
                        <input type="text" name="phonenumber" id="phonenumber" class="input-sm form-control"
                            placeholder="Enter phonenumber" value="{{ @$info->phonenumber }}">
                        <span class="text-danger">
                            @error('phonenumber')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Country<span class="text-danger"></span></label>
                        <input type="text" name="country" id="country" class="input-sm form-control"
                            placeholder="Enter Country" value="{{ @$info->country }}">
                        <span class="text-danger">
                            @error('country')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Password<span class="text-danger"></span></label>
                        <input type="password" name="password" id="password" class="input-sm form-control"
                            placeholder="Enter Password">
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Confirm Password<span class="text-danger"></span></label>
                        <input type="password" name="confirm_password" id="confirm_password"
                            class="input-sm form-control" placeholder="Enter Confirm password">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="padding-top: 1rem;">
                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-edit"></i> Update Student Information
                        </button>
                    </div>

                </div>

            </form>


            <br> <br>
        </div>
    </div>

    </div>
    </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('js')
    <script>
        document.getElementById('userForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm_password').value.trim();
            const submitBtn = document.getElementById('submitBtn');

            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).{6,}$/;

            if ((password && !confirmPassword) || (!password && confirmPassword)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Both Password and Confirm Password must be provided if you want to update the password.'
                });
                return;
            }

            if (password && confirmPassword) {
                if (password !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Mismatch',
                        text: 'Password and Confirm Password do not match.'
                    });
                    return;
                }

                if (!passwordRegex.test(password)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Weak Password',
                        html: `Password must:
                        <ul style="text-align: left;">
                            <li>Be at least 6 characters</li>
                            <li>Contain one uppercase letter</li>
                            <li>Contain one lowercase letter</li>
                            <li>Contain one digit</li>
                            <li>Contain one special character (@$!%*?&#)</li>
                        </ul>`
                    });
                    return;
                }
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update the student information?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    submitBtn.innerHTML =
                        'Updating student information... <i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;

                    setTimeout(() => {
                        event.target.submit();
                    }, 500); 
                }
            });
        });
    </script>


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
