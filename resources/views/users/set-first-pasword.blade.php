@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="d-md-flex">
        <div class="w-40 bg-style h-100vh page-style">
            <div class="page-content">
                <div class="page-single-content">
                    <div class="card-body text-white py-5 px-8 text-center">
                        <img src="{{ URL::asset('assets/images/png/3.png') }}" alt="img" class="supplier-logo text-center">
                    </div>
                </div>
            </div>
        </div>

        <style>
            .toggle-password {
                position: absolute;
                top: 50%;
                right: 15px;
                transform: translateY(-50%);
                cursor: pointer;
                font-size: 18px;
                color: #6c757d;
            }

            .toggle-password.active {
                color: #007bff;
            }
        </style>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

        <div class="w-80 page-content">
            <div class="page-single-content">
                <div class="card-body p-6">
                    <div class="row">
                        <div class="col-md-8 mx-auto d-block">
                            <div class="">
                                <h1 class="mb-2">Set Password</h1>
                                <p class="text-muted">Please set your password for your account : <span
                                        style="color: green">{{$useremail}}</span></p>

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

                                <form action="{{ route('user-store-first-password') }}" method="POST">

                                    <input type="hidden" name="generated_id" value="{{$generated_id}}">

                                    @csrf
                                    <div class="input-group mb-4">
                                        <span class="input-group-addon">
                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                                viewBox="0 0 24 24" width="24">
                                                <g fill="none">
                                                    <path d="M0 0h24v24H0V0z" />
                                                    <path d="M0 0h24v24H0V0z" opacity=".87" />
                                                </g>
                                                <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"
                                                    opacity=".3" />
                                                <path
                                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                            </svg>
                                        </span>
                                        <input type="password" name="password" class="form-control" id="passwordInput"
                                            placeholder="Enter password" required>
                                        <span class="toggle-password" toggle="#passwordInput">
                                            <i class="fa-solid fa-eye"></i>
                                        </span>
                                    </div>

                                    @error('password')
                                        <div style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="input-group mb-4">
                                        <span class="input-group-addon">
                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                                viewBox="0 0 24 24" width="24">
                                                <g fill="none">
                                                    <path d="M0 0h24v24H0V0z" />
                                                    <path d="M0 0h24v24H0V0z" opacity=".87" />
                                                </g>
                                                <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"
                                                    opacity=".3" />
                                                <path
                                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                            </svg>
                                        </span>
                                        <input type="password" name="confirmPassword" class="form-control"
                                            id="confirmPasswordInput" placeholder="Confirm password" required>
                                        <span class="toggle-password" toggle="#confirmPasswordInput">
                                            <i class="fa-solid fa-eye"></i>
                                        </span>
                                    </div>

                                    @error('confirmPassword')
                                        <div style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-lg btn-primary btn-block px-4"
                                                onclick="confirmSubmission(this)">
                                                <i class="fe fe-arrow-right"></i> Set Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="pt-4">
                                <div class="font-weight-normal fs-16">Forget it <a class="btn-link font-weight-normal"
                                        href="{{ url('/') }}">Send me back</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function confirmSubmission(button) {

            $('input[name="password"], input[name="confirmPassword"]')
                .removeClass('is-invalid is-valid');

            let password = $('input[name="password"]').val().trim();
            let confirmPassword = $('input[name="confirmPassword"]').val().trim();
            let errors = [];

            let regex = {
                uppercase: /[A-Z]/,
                lowercase: /[a-z]/,
                digit: /[0-9]/,
                special: /[@$!%*?&#]/
            };

            if (!password) {
                errors.push("Password is required.");
            } else {
                if (password.length < 6) {
                    errors.push("Password must be at least 6 characters.");
                }
                if (!regex.uppercase.test(password)) {
                    errors.push("Password must include at least one uppercase letter.");
                }
                if (!regex.lowercase.test(password)) {
                    errors.push("Password must include at least one lowercase letter.");
                }
                if (!regex.digit.test(password)) {
                    errors.push("Password must include at least one digit.");
                }
                if (!regex.special.test(password)) {
                    errors.push("Password must include at least one special character.");
                }
            }

            if (password !== confirmPassword) {
                errors.push("Passwords do not match.");
            }

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Failed',
                    html: errors.join('<br>'),
                });

                if (!password || errors.length > 0) {
                    $('input[name="password"]').addClass('is-invalid');
                }

                if (password !== confirmPassword) {
                    $('input[name="confirmPassword"]').addClass('is-invalid');
                }

                return;
            }

            $('input[name="password"]').addClass('is-valid');
            $('input[name="confirmPassword"]').addClass('is-valid');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to proceed with the submission?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.disabled = true;
                    button.innerHTML = '<i class="fe fe-loader"></i> Sending...';
                    document.querySelector("form").submit();
                }
            });
        }

        $(document).ready(function () {
            $(".toggle-password").on('click', function () {
                const inputSelector = $(this).attr("toggle");
                const input = $(inputSelector);
                const icon = $(this).find('i');
                const isPassword = input.attr("type") === "password";

                input.attr("type", isPassword ? "text" : "password");
                $(this).toggleClass("active");

                icon.toggleClass("fa-eye fa-eye-slash");
            });
        });
    </script>

@endsection