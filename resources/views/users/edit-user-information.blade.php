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
            <h4 class="page-title" style="text-align: center;">User Information Update</h4>
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

                    <!-- Include Font Awesome -->
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Password<span class="text-danger"></span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="input-sm form-control"
                                placeholder="Enter Password">
                            <span class="input-group-text" style="cursor:pointer;"
                                onclick="togglePassword('password', this)">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
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
                    </div>

                    <script>
                        function togglePassword(fieldId, icon) {
                            const input = document.getElementById(fieldId);
                            const i = icon.querySelector('i');
                            if (input.type === "password") {
                                input.type = "text";
                                i.classList.remove('fa-eye');
                                i.classList.add('fa-eye-slash');
                            } else {
                                input.type = "password";
                                i.classList.remove('fa-eye-slash');
                                i.classList.add('fa-eye');
                            }
                        }
                    </script>

                </div>

                <div class="row">
                    <div class="col-md-4" style="padding-top: 1rem;">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-edit"></i> Update User Information
                        </button>
                    </div>

                </div>

            </form>


            <br> <br>
        </div>
    </div>
    <!--End row-->
    </div>
    </div><!-- end app-content-->
    </div>

    <br> <br>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("userForm");
            const submitButton = form.querySelector("button[type='submit']");

            form.addEventListener("submit", function (e) {
                e.preventDefault();

                const username = document.getElementById("username").value.trim();
                const firstname = document.getElementById("firstname").value.trim();
                const lastname = document.getElementById("lastname").value.trim();
                const gender = document.getElementById("gender").value.trim();
                const email = document.getElementById("email").value.trim();
                const phonenumber = document.getElementById("phonenumber").value.trim();
                const country = document.getElementById("country").value.trim();
                const password = document.getElementById("password").value.trim();
                const confirmPassword = document.getElementById("confirm_password").value.trim();

                const errors = [];
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).{6,}$/;

                if (!username) {
                    errors.push('• Username is required.');
                    document.getElementById("username").classList.add("is-invalid");
                }

                if (!email) {
                    errors.push('• Email is required.');
                    document.getElementById("email").classList.add("is-invalid");
                }

                if ((password && !confirmPassword) || (!password && confirmPassword)) {
                    errors.push('• Both Password and Confirm Password must be filled to update password.');
                }

                if (password && confirmPassword) {
                    if (password !== confirmPassword) {
                        errors.push('• Passwords do not match.');
                    } else if (!passwordRegex.test(password)) {
                        errors.push(
                            '• Password must be at least 6 characters and contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@$!%*?&#).'
                        );
                    }
                }

                if (phonenumber && !/^\d{10}$/.test(phonenumber)) {
                    errors.push('• Phone number must be 10 digits.');
                }

                if (errors.length > 0) {
                    Swal.fire('Validation Errors', errors.join('<br>'), 'error');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to update the user information?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitButton.innerHTML =
                            'Updating... <i class="fas fa-spinner fa-spin"></i>';
                        submitButton.disabled = true;
                        form.submit();
                    }
                });
            });
        });
    </script>

    <!-- Additional Scripts -->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/chart.extension.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index2.js') }}"></script>
@endsection