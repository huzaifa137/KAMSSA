@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="d-md-flex">
        <div class="w-40 bg-style min-h-100vh page-style">
            <div class="page-content">
                <div class="page-single-content">
                    <div class="card-body text-white py-5 px-8 text-center">
                        <a href="{{ url('/users/home-page') }}"><img src="{{ URL::asset('assets/images/png/3.png') }}"
                                alt="img" class=" text-center supplier-logo"></a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .input-group {
                display: flex;
                align-items: stretch;
            }

            .input-group-addon {
                padding: 6px 12px;
                background-color: #eee;
                border: 1px solid #ccc;
                border-right: none;
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 48px;
            }

            .input-wrapper {
                position: relative;
                flex: 1;
            }

            .input-wrapper input {
                width: 100%;
                height: 100%;
                padding: 6px 40px 6px 12px;
                border: 1px solid #ccc;
                border-left: none;
                box-sizing: border-box;
                font-size: 14px;
            }

            .toggle-password {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                cursor: pointer;
                height: 20px;
                width: 20px;
                fill: #888;
            }

            .btn-google {
                background-color: #db4437;
                color: white;
            }

            .btn-facebook {
                background-color: #3b5998;
                color: white;
            }

            .btn-twitter {
                background-color: #1da1f2;
                color: white;
            }

            .btn i {
                margin-right: 8px;
            }
        </style>

        <!-- Font Awesome CDN -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

        <div class="w-80 page-content">
            <div class="page-single-content">
                <div class="card-body p-6">
                    <div class="row">
                        <div class="col-md-8 mx-auto d-block">
                            <h1 class="mb-2">Register Account</h1>
                            <p class="text-muted">Create new student account</p>

                            <div class="form-border">
                                <form action="{{ route('user-account-creation') }}" method="POST">
                                    @csrf

                                    <div class="input-group mb-3">
                                        <span class="input-group-addon"><svg class="svg-icon"
                                                xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                                width="24">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z"
                                                    opacity=".3" />
                                                <circle cx="12" cy="8" opacity=".3" r="2" />
                                                <path
                                                    d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" />
                                            </svg></span>
                                        <input type="text" class="form-control" placeholder="Username"
                                            id="student_username">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-addon"><svg class="svg-icon"
                                                xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                                width="24">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3" />
                                                <path
                                                    d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z" />
                                            </svg></span>
                                        <input type="email" class="form-control" placeholder="Enter Email"
                                            id="student_mail">
                                    </div>

                                    <div class="input-group mb-4">
                                        <span class="input-group-addon">
                                            <!-- Lock Icon -->
                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="20"
                                                width="20" viewBox="0 0 24 24">
                                                <g fill="none">
                                                    <path d="M0 0h24v24H0V0z" />
                                                    <path d="M0 0h24v24H0V0z" opacity=".87" />
                                                </g>
                                                <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"
                                                    opacity=".3" />
                                                <path
                                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0
                                                                                                                                                        2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1
                                                                                                                                                        0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                            </svg>
                                        </span>

                                        <div class="input-wrapper">
                                            <input type="password" class="form-control" placeholder="Password"
                                                id="student_password">
                                            <svg class="toggle-password" onclick="togglePassword('student_password', this)"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11
                                                                                                                                                        11-7.5c-1.73-4.39-6-7.5-11-7.5zm0
                                                                                                                                                        13c-2.76 0-5-2.24-5-5s2.24-5
                                                                                                                                                        5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66
                                                                                                                                                        0-3 1.34-3 3s1.34 3 3 3
                                                                                                                                                        3-1.34 3-3-1.34-3-3-3z" />
                                            </svg>
                                        </div>
                                    </div>



                                    <div class="input-group mb-4">
                                        <span class="input-group-addon">
                                            <!-- Lock Icon -->
                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="20"
                                                width="20" viewBox="0 0 24 24">
                                                <g fill="none">
                                                    <path d="M0 0h24v24H0V0z" />
                                                    <path d="M0 0h24v24H0V0z" opacity=".87" />
                                                </g>
                                                <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"
                                                    opacity=".3" />
                                                <path
                                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0
                                                                                                                                                        2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1
                                                                                                                                                        0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                            </svg>
                                        </span>

                                        <div class="input-wrapper">
                                            <input type="password" class="form-control" placeholder="Confirm Password"
                                                id="student_confirm_password">
                                            <svg class="toggle-password"
                                                onclick="toggleConfirmPassword('student_confirm_password', this)"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11
                                                                                                                                                        11-7.5c-1.73-4.39-6-7.5-11-7.5zm0
                                                                                                                                                        13c-2.76 0-5-2.24-5-5s2.24-5
                                                                                                                                                        5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66
                                                                                                                                                        0-3 1.34-3 3s1.34 3 3 3
                                                                                                                                                        3-1.34 3-3-1.34-3-3-3z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" />
                                            <span class="custom-control-label">Agree to the terms<a
                                                    href="{{ url('/users/terms-and-conditions') }}" class="btn-link"> and
                                                    policies</a></span>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-lg btn-primary btn-block px-4"
                                                id="submitUserInformation"><i class="fe fe-arrow-right"></i> Create a new
                                                account</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="pt-4">
                                <div class="font-weight-normal fs-16">You Already have an account <a
                                        class="btn-link font-weight-normal" href="{{ url('/users/login') }}">Login
                                        Here</a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function toggleConfirmPassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.addEventListener('DOMContentLoaded', function() {
            $('#submitUserInformation').on('click', function(e) {
                e.preventDefault();

                var button = $(this);
                button.prop('disabled', true).html('<i class="fe fe-arrow-right"></i> Creating account...');

                var username = $('#student_username').val();
                var email = $('#student_mail').val();
                var password = $('#student_password').val();
                var confirmPassword = $('#student_confirm_password').val();
                var termsAccepted = $('input[type="checkbox"]:checked').length > 0;

                var errorMessages = [];

                $('#student_username').removeClass('is-invalid').removeClass('is-valid');
                $('#student_mail').removeClass('is-invalid').removeClass('is-valid');
                $('#student_password').removeClass('is-invalid').removeClass('is-valid');
                $('#student_confirm_password').removeClass('is-invalid').removeClass('is-valid');
                $('input[type="checkbox"]').removeClass('is-invalid').removeClass('is-valid');

                if (!username) {
                    errorMessages.push("Username is required.");
                    $('#student_username').addClass('is-invalid');
                } else {
                    $('#student_username').addClass('is-valid');
                }

                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!email) {
                    errorMessages.push("Email is required.");
                    $('#student_mail').addClass('is-invalid');
                } else if (!emailRegex.test(email)) {
                    errorMessages.push("Please enter a valid email address.");
                    $('#student_mail').addClass('is-invalid');
                } else {
                    $('#student_mail').addClass('is-valid');
                }

                if (!password) {
                    errorMessages.push("Password is required.");
                    $('#student_password').addClass('is-invalid');
                } else {
                    $('#student_password').addClass('is-valid');
                }

                if (!confirmPassword) {
                    errorMessages.push("Confirm Password is required.");
                    $('#student_confirm_password').addClass('is-invalid');
                } else {
                    $('#student_confirm_password').addClass('is-valid');
                }

                if (password !== confirmPassword) {
                    errorMessages.push("Passwords do not match.");
                    $('#student_password').addClass('is-invalid');
                    $('#student_confirm_password').addClass('is-invalid');
                }

                var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (password && !passwordRegex.test(password)) {
                    errorMessages.push(
                        "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one special character."
                    );
                    $('#student_password').addClass('is-invalid');
                }

                if (!termsAccepted) {
                    errorMessages.push("You must agree to the terms and policy.");
                    $('input[type="checkbox"]').addClass('is-invalid');
                }

                if (errorMessages.length > 0) {
                    var errorList = '<ul>';
                    errorMessages.forEach(function(error, index) {
                        errorList += '<li>' + (index + 1) + '. ' + error + '</li>';
                    });
                    errorList += '</ul>';

                    Swal.fire({
                        title: 'Error!',
                        html: errorList,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    button.prop('disabled', false).html(
                        '<i class="fe fe-arrow-right"></i> Create a new account');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Please confirm that all the information is correct before creating your account.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, create my account!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        var form_data = new FormData();

                        form_data.append('_token', '{{ csrf_token() }}');
                        form_data.append('username', username);
                        form_data.append('email', email);
                        form_data.append('password', password);
                        form_data.append('confirmPassword', confirmPassword);
                        form_data.append('termsAccepted', termsAccepted);

                        $.ajax({
                            url: "{{ route('user-account-creation') }}",
                            method: "POST",
                            data: form_data,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.title ??
                                            'OTP SENT',
                                        html: response.message ??
                                            'Your account has been successfully created.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Optional redirect or form reset
                                        window.location.href = response
                                            .redirect_url ?? '/dashboard';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.title ??
                                            'Account Creation Failed',
                                        html: response.message ??
                                            'There was an issue creating your account.',
                                        confirmButtonText: 'OK'
                                    });
                                }

                                button.prop('disabled', false).html(
                                    '<i class="fe fe-arrow-right"></i> Create a new account'
                                );
                            },
                            error: function(data) {
                                try {
                                    const response = data.responseJSON;
                                    if (response && response.message) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            html: response.message,
                                            confirmButtonText: 'OK'
                                        });
                                    } else {
                                        $('body').html(data.responseText);
                                    }
                                } catch (e) {
                                    $('body').html(data.responseText);
                                }

                                button.prop('disabled', false).html(
                                    '<i class="fe fe-arrow-right"></i> Create a new account'
                                );
                            }
                        });
                    } else {
                        button.prop('disabled', false).html(
                            '<i class="fe fe-arrow-right"></i> Create a new account');
                    }
                });
            });

            document.querySelector('form').addEventListener('submit', function() {
                var button = document.getElementById('submitUserInformation');
                button.disabled = true;
                button.innerHTML = '<i class="fe fe-arrow-right"></i> Creating account...';
            });
        });
    </script>
@endsection
