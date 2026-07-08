@extends('layouts.master')

@section('css')
    <!-- Morris Charts css -->
    <link href="{{ URL::asset('assets/plugins/morris/morris.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <!--Row-->
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <h4 class="page-title" style="text-align: center;">Account Registration</h4>
            <br>

            <form action="{{ route('store-internal-user') }}" class="border" method="POST" id="userForm">

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

                <div class="row">

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="username input-sm form-control"
                            placeholder="Enter username" value="{{ old('username') }}">
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Firstname<span class="text-danger"></span></label>
                        <input type="text" name="firstname" id="firstname" class="firstname input-sm form-control"
                            placeholder="Enter Firstname" value="{{ old('firstname') }}">
                        <span class="text-danger">
                            @error('firstname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Lastname<span class="text-danger"></span></label>
                        <input type="text" name="lastname" id="lastname" class="lastname input-sm form-control"
                            placeholder="Enter Lastname" value="{{ old('lastname') }}">
                        <span class="text-danger">
                            @error('lastname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Gender<span class="text-danger"></span></label>
                        <select name="gender" id="gender" class="gender input-sm form-control">
                            @if (@$info->gender)
                                <option value="{{ $info->gender }}">{{ @$info->gender }}</option>
                            @else
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="email input-sm form-control"
                            placeholder="Enter Email" value="{{ old('email') }}">
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Phonenumber<span class="text-danger"></span></label>
                        <input type="text" name="phonenumber" id="phonenumber" class="phonenumber input-sm form-control"
                            placeholder="Enter phonenumber" value="{{ old('phonenumber') }}">
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
                        <input type="text" name="country" id="country" class="country input-sm form-control"
                            placeholder="Enter Country" value="{{ old('country') }}">
                        <span class="text-danger">
                            @error('country')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <!-- Include Font Awesome for the eye icon -->
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Password<span class="text-danger"></span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="password input-sm form-control"
                                placeholder="Enter Password" value="{{ old('password') }}">
                            <span class="input-group-text" style="cursor:pointer;"
                                onclick="togglePassword('password', this)">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Confirm Password<span class="text-danger"></span></label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="input-sm form-control" placeholder="Enter Confirm password">
                            <span class="input-group-text" style="cursor:pointer;"
                                onclick="togglePassword('confirm_password', this)">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <span class="text-danger">
                            @error('confirm_password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <script>
                        function togglePassword(fieldId, icon) {
                            const input = document.getElementById(fieldId);
                            if (input.type === "password") {
                                input.type = "text";
                                icon.querySelector('i').classList.remove('fa-eye');
                                icon.querySelector('i').classList.add('fa-eye-slash');
                            } else {
                                input.type = "password";
                                icon.querySelector('i').classList.remove('fa-eye-slash');
                                icon.querySelector('i').classList.add('fa-eye');
                            }
                        }
                    </script>

                </div>

                <div class="row">
                    <div class="col-md-4" style="padding-top: 1rem;">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-plus"></i> Register User
                        </button>
                    </div>
                </div>

            </form>

            <br> <br>
        </div>
    </div>
    <!--End row-->

    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- FontAwesome for icons -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("userForm");
            const submitButton = form.querySelector("button[type='submit']");

            form.addEventListener("submit", function (e) {
                e.preventDefault();

                const firstname = document.getElementById("firstname").value.trim();
                const lastname = document.getElementById("lastname").value.trim();
                const username = document.getElementById("username").value.trim();
                const country = document.getElementById("country").value.trim();
                const phonenumber = document.getElementById("phonenumber").value.trim();
                const email = document.getElementById("email").value.trim();
                const password = document.getElementById("password").value;
                const confirm_password = document.getElementById("confirm_password").value.trim();

                let errors = [];

                if (!username) {
                    errors.push('• Username is required');
                    $('#username').addClass('is-invalid');
                }

                if (!firstname) {
                    errors.push('• Firstname is required');
                    $('#firstname').addClass('is-invalid');
                }

                if (!lastname) {
                    errors.push('• lastname is required');
                    $('#lastname').addClass('is-invalid');
                }

                if (!email) {
                    errors.push('• Email is required');
                    $('#email').addClass('is-invalid');
                }

                if (!phonenumber) {
                    errors.push('• Phonenumber is required field');
                    $('#phonenumber').addClass('is-invalid');
                }

                if (!confirm_password) {
                    errors.push('• Confirm Passsword is required field');
                    $('#confirm_password').addClass('is-invalid');
                }

                if (!country) {
                    errors.push('• Country is required field');
                    $('#country').addClass('is-invalid');
                }

                const phoneRegex = /^\d{10}$/;
                if (!phoneRegex.test(phonenumber)) {
                    errors.push('• Please enter a valid phone number (10 digits)');
                }

                if (!password) {
                    errors.push('• Password is required field');
                    $('#password').addClass('is-invalid');
                } else if (!confirm_password) {
                    errors.push('• Confirm password is required field');
                } else if (password !== confirm_password) {

                    errors.push('• Passwords do not match');
                }

                if (errors.length > 0) {
                    Swal.fire('Missing or Invalid Fields', errors.join('<br>'), 'error');
                    return false;
                }

                Swal.fire({
                    title: 'Confirm Submission',
                    text: "Are you sure you want to create this user?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitButton.innerHTML =
                            'Creating user account...<i class="fas fa-spinner fa-spin"></i>';
                        submitButton.disabled = true;

                        form.submit();
                    }
                });
            });
        });
    </script>

    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/chart.extension.js') }}"></script>
    <!-- ECharts js-->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index2.js') }}"></script>
@endsection