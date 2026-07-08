@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="d-md-flex">
        <div class="w-40 bg-style h-100vh page-style">
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
        </style>

        <div class="w-80 page-content">
            <div class="page-single-content">
                <div class="card-body p-6">
                    <div class="row">
                        <div class="col-md-8 mx-auto d-block">

                            @include('sweetalert::alert')

                            <div class="container py-5">
                                <h1 class="mb-4">Welcome, {{ $userInfo->surname }} {{ $userInfo->firstname }}</h1>
                                <p class="text-muted mb-4">You're assigned to the following schools. Please select one to
                                    continue:</p>

                                <div class="row">
                                    @forelse($schoolsInExistance as $school)
                                                                    <div class="col-md-6 col-lg-4 mb-4 d-flex">
                                                                        <div class="card shadow-sm text-center p-3 w-100 d-flex flex-column school-card"
                                                                            style="cursor: pointer;" data-school-id="{{ $school->id }}"
                                                                            data-email="{{ $email }}">

                                                                            <?php
                                        $schoolProfile = DB::table('school_profiles')
                                            ->where('school_id', $school->id)
                                            ->first();
                                        $school->profile = $schoolProfile;
                                                                                                                                                                                                                                                                                                                                                        ?>

                                                                            <div class="d-flex flex-column align-items-center flex-grow-1">
                                                                                <div class="rounded-circle overflow-hidden"
                                                                                    style="width: 80px; height: 80px;">
                                                                                    <img src="{{ $school->profile && $school->profile->logo ? asset('storage/' . $school->profile->logo) : asset('assets/images/brand/uplogolight.png') }}"
                                                                                        alt="{{ $school->profile ? $school->profile->name : $school->name }}"
                                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                                </div>

                                                                                <h5 class="mt-3 text-wrap text-break">{{ $school->name }}</h5>

                                                                                <div class="mt-auto w-100">
                                                                                    <button class="btn btn-primary mt-3 w-100">Login to this
                                                                                        School</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <div class="alert alert-warning">No schools found for this account.</div>
                                        </div>
                                    @endforelse
                                </div>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        $(document).ready(function () {
            $('#login_button').on('click', function (e) {
                e.preventDefault();

                var button = $(this);
                button.prop('disabled', true).html('<i class="fe fe-arrow-right"></i> Logging in...');

                let email = $('#email').val();
                let password = $('#password').val();

                $('#email').removeClass('is-invalid is-valid');
                $('#password').removeClass('is-invalid is-valid');

                let errorMessages = [];

                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!email) {
                    errorMessages.push("Email is required.");
                    $('#email').addClass('is-invalid');
                } else if (!emailRegex.test(email)) {
                    errorMessages.push("Please enter a valid email address.");
                    $('#email').addClass('is-invalid');
                } else {
                    $('#email').addClass('is-valid');
                }

                if (!password) {
                    errorMessages.push("Password is required.");
                    $('#password').addClass('is-invalid');
                } else {
                    $('#password').addClass('is-valid');
                }

                if (errorMessages.length > 0) {
                    let errorList = '<ul>';
                    errorMessages.forEach((err, i) => {
                        errorList += `<li>${i + 1}. ${err}</li>`;
                    });
                    errorList += '</ul>';

                    Swal.fire({
                        title: 'Validation Error',
                        html: errorList,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    button.prop('disabled', false).html('<i class="fe fe-arrow-right"></i> Login');
                    return;
                }

                $.ajax({
                    url: "{{ route('auth-user-check') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email,
                        password: password
                    },
                    success: function (response) {
                        if (response.status) {
                            window.location.href = response.redirect_url
                        } else {

                            Swal.fire({
                                title: response.title ?? 'Login Failed',
                                text: response.message ??
                                    'We don’t recognize the email or password you provided.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {

                                $('#login_button').prop('disabled', false).html(
                                    '<i class="fe fe-arrow-right"></i> Login');
                            });
                        }
                    },
                    error: function (data) {

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
                                $('body').html(data
                                    .responseText);
                            }
                        } catch (e) {
                            $('body').html(data.responseText);
                        }

                        $('#login_button').prop('disabled', false).html(
                            '<i class="fe fe-arrow-right"></i> Login');
                    }
                });

            });
        });

        $(document).ready(function () {

            $('.school-card button').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                let button = $(this);
                let card = button.closest('.school-card');
                let schoolId = card.data('school-id');
                let email = card.data('email');

                // Set loading state
                button.prop('disabled', true).text('Logging in...');

                $.ajax({
                    url: "{{ route('auth-user-selected-school') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        selected_school_id: schoolId,
                        email: email
                    },
                    success: function (response) {

                        if (response.status && response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            button.prop('disabled', false).text('Login to this School');
                        }
                    },
                    error: function (xhr) {
                        $('body').html(xhr.responseText);

                        button.prop('disabled', false).text('Login to this School');
                    }
                });
            });
        });




    </script>
@endsection