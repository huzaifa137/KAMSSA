@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="d-md-flex">
        <div class="w-40 bg-style h-100vh page-style">
            <div class="page-content">
                <div class="page-single-content">
                    <div class="card-body text-white py-5 px-8 text-center">
                        <a href="{{ url('/') }}"><img src="{{ URL::asset('assets/images/png/3.png') }}" alt="img"
                                class=" text-center supplier-logo"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-80 page-content">
            <div class="page-single-content">
                <div class="card-body p-6">
                    <div class="row">


                        @include('sweetalert::alert')

                        <div class="col-md-8 mx-auto d-block">
                            <div class="">
                                <h1 class="mb-2">Verification</h1>
                                <p class="text-muted">Enter the 5-digit code sent to <span
                                        class="text-primary">{{ $user_check_email }}</span></p>
                            </div>

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

                            <form action="{{ route('supplier-user-otp-verification') }}"
                                class="mt-5 border p-4 bg-light shadow" method="POST">

                                <input type="hidden" name="hidden_otp" id="hidden_otp" value={{ $user_id_check }}>

                                <div class="d-flex justify-content-between mb-4">
                                    <input type="text" data-position="1" class="form-control text-center otp-input mx-1"
                                        maxlength="1" style="width: 50px;" id="otp_1" autofocus>
                                    <input type="text" data-position="2" class="form-control text-center otp-input mx-1"
                                        maxlength="1" style="width: 50px;" id="otp_2">
                                    <input type="text" data-position="3" class="form-control text-center otp-input mx-1"
                                        maxlength="1" style="width: 50px;" id="otp_3">
                                    <input type="text" data-position="4" class="form-control text-center otp-input mx-1"
                                        maxlength="1" style="width: 50px;" id="otp_4">
                                    <input type="text" data-position="5" class="form-control text-center otp-input mx-1"
                                        maxlength="1" style="width: 50px;" id="otp_5">
                                </div>

                                <p class="text-muted">Didn't receive a code? &nbsp; <span
                                        style="color: blue; cursor: pointer;" id="regenerate_otp">Resend</span></p>

                                <div class="row">
                                    <div class="col-4">
                                        <button type="button" id="otp_verification" class="btn btn-primary btn-block"> <i
                                                class="fe fe-check"></i>
                                            Verify</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.otp-input').forEach(function(input) {
            input.addEventListener('input', function(e) {
                const regex = /^[0-9]$/;
                if (!regex.test(e.target.value)) {
                    e.target.value = '';
                }
            });
        });

        document.querySelectorAll('.otp-input').forEach(function(input) {
            input.addEventListener('input', function(e) {
                const regex = /^[0-9]$/;
                if (!regex.test(e.target.value)) {
                    e.target.value = '';
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('otp_verification')
                        .click();
                }
            });
        });

        $(document).on('change keyup', '#otp_1,#otp_2, #otp_3, #otp_4, #otp_5', function() {
            var next = parseInt($(this).attr('data-position')) + 1;
            if (next <= 5 && !$('#otp_' + next).val()) $('#otp_' + next).focus();

        });

        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                otp();
            }
        });

        $('#otp_verification').click(function() {
            otp();
        });

        function otp(){
            
            var otp_1 = $('#otp_1').val();
            var otp_2 = $('#otp_2').val();
            var otp_3 = $('#otp_3').val();
            var otp_4 = $('#otp_4').val();
            var otp_5 = $('#otp_5').val();

            var hidden_otp = $('#hidden_otp').val();

            if (otp_1 == "" || otp_2 == "" || otp_3 == "" || otp_4 == "" || otp_5 == "") {

                Swal.fire({
                    icon: 'error',
                    title: 'error!',
                    text: 'Please enter OTP token before submitting',
                });

                return false;
            }

            var form_data = new FormData();

            form_data.append('otp_1', otp_1);
            form_data.append('otp_2', otp_2);
            form_data.append('otp_3', otp_3);
            form_data.append('otp_4', otp_4);
            form_data.append('otp_5', otp_5);

            form_data.append('hidden_otp', hidden_otp);

            $.ajax({

                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: form_data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                url: '/supplier-user-otp-verification',
                success: function(data) {
                    if (data.status) {
                        window.location.href = data.redirect_url;
                    } else {
                        Swal.fire({
                            title: data.title,
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                return;
                            }
                        });
                    }
                },

                error: function(data) {
                    $('body').html(data.responseText);
                }
            });

        }


        $(document).ready(function() {
            $('#regenerate_otp').click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to regenerate the OTP?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, regenerate it!',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#regenerate_otp').html(
                            '<i class="fe fe-loader"></i> <a class="text-success">Regenerating...</a>'
                        );
                        $('#regenerate_otp').css('cursor', 'default');

                        var hidden_otp = $('#hidden_otp').val();

                        var form_data = new FormData();

                        form_data.append('hidden_otp', hidden_otp);
                        form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        $.ajax({
                            type: "POST",
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: form_data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'),
                                'Accept': 'application/json'
                            },
                            url: '/regenerate-otp',
                            success: function(data) {
                                $('#regenerate_otp').html('Resend');
                                $('#regenerate_otp').css('cursor', 'pointer');
                                if (data.status) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonText: 'Okay'
                                    });
                                }
                            },
                            error: function(data) {
                                $('body').html(data.responseText);
                            }
                        });
                    } else {
                        $('#regenerate_otp').html('Resend');
                        $('#regenerate_otp').css('cursor', 'pointer');
                    }
                });
            });
        });
    </script>
@endsection
