@extends('layouts.master2')
@section('css')
@endsection
@section('content') 
    <div class="d-md-flex">
        <div class="w-40 bg-style min-h-100vh page-style">
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

                        <div class="col-md-12">
                            <div class="card overflow-hidden">
                                <div class="card-header bg-light"
                                    style="display: flex; justify-content: center; align-items: center;">
                                    <h4 style="margin: 0;">Welcome to {{ $systemSettings->system_name ?? 'Iteb Academics' }} Terms and Policies</h4>
                                </div>

                                <div class="card-body">
                                    <p>Welcome to {{ $systemSettings->system_name ?? 'Iteb Academics' }}, an online learning platform dedicated to helping
                                        users
                                        master
                                        programming and coding skills. By accessing our platform, you agree to be bound
                                        by
                                        the terms and
                                        policies laid out below. Please review them carefully before using our services.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card overflow-hidden">
                                <div class="card-header bg-light">
                                    <h4 class="">Using Our Services</h4>
                                </div>
                                <div class="card-body">
                                    <p>You must follow all applicable policies made available to you within the
                                        Services.
                                        Don't misuse our
                                        Services. For example, don't interfere with our Services or try to access them
                                        using
                                        a method other
                                        than the interface and the instructions that we provide.</p>
                                    <p>Using our Services does not give you ownership of any intellectual property
                                        rights in
                                        our Services or
                                        the content you access. You may not use content from our Services unless you
                                        obtain
                                        permission from
                                        its owner or are otherwise permitted by law.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card overflow-hidden">
                                <div class="card-header bg-light">
                                    <h4 class="">Privacy Policy</h4>
                                </div>
                                <div class="card-body">
                                    <p>We take your privacy seriously. When you use our services, you’re trusting us
                                        with
                                        your information.
                                        We collect data such as your name, email address, and usage patterns to improve
                                        the
                                        platform. We do
                                        not sell or share your data with third parties without your consent. Please
                                        review
                                        our full <a href="#">Privacy Policy</a> for more details.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card overflow-hidden">
                                <div class="card-header bg-light">
                                    <h4 class="">Copyright</h4>
                                </div>
                                <div class="card-body">
                                    <p>All content provided on this platform, including text, code samples, videos,
                                        graphics, and tutorials,
                                        is the property of {{ $systemSettings->system_name ?? 'Iteb Academics' }} or its content providers and is protected
                                        by
                                        international
                                        copyright laws. You may not reproduce, distribute, or create derivative works
                                        without explicit
                                        permission.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card overflow-hidden">
                                <div class="card-header bg-light">
                                    <h4 class="">Terms and Conditions</h4>
                                </div>
                                <div class="card-body">
                                    <p>By registering on and using our platform, you agree to the following terms:</p>
                                    <ul class="list-style3">
                                        <li>You must be at least 13 years old to use the platform.</li>
                                        <li>You are responsible for maintaining the confidentiality of your account
                                            information.</li>
                                        <li>You will not engage in any activity that disrupts or interferes with our
                                            services or networks.
                                        </li>
                                        <li>You agree not to copy, modify, or distribute content unless explicitly
                                            permitted.</li>
                                        <li>Your access may be terminated for violating these terms or engaging in
                                            unlawful
                                            behavior.</li>
                                        <li>We reserve the right to modify or discontinue any feature without prior
                                            notice.
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
                                rel="stylesheet">

                            <a href="{{ url('users/register') }}" class="btn btn-primary text-white">
                                <i class="fas fa-arrow-left me-2"></i> Return to registration
                            </a>

                            <br>
                            <br>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
