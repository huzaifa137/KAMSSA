<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Idaad and Thanawi Examination Board</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('asset/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet (ITEB green theme) -->
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">

    <!-- Custom Portal Styles (green theme overrides & portal components) -->
    <style>
        :root {
            --iteb-green: #026837;
            --iteb-green-light: #1E7A3D;
            --iteb-green-dark: #0A3A18;
        }

        /* Override Bootstrap primary color with ITEB green */
        .btn-primary {
            background-color: var(--iteb-green) !important;
            border-color: var(--iteb-green) !important;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: var(--iteb-green-dark) !important;
            border-color: var(--iteb-green-dark) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 75, 30, 0.15);
        }

        .btn-outline-primary {
            color: var(--iteb-green);
            border-color: var(--iteb-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--iteb-green);
            border-color: var(--iteb-green);
            color: #fff;
        }

        .text-primary {
            color: var(--iteb-green) !important;
        }

        .bg-primary {
            background-color: var(--iteb-green) !important;
        }

        .border-primary {
            border-color: var(--iteb-green) !important;
        }

        /* Portal specific cards & components */
        .portal-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .portal-card:hover {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transform: translateY(-5px);
        }

        .captcha-code {
            font-family: 'Courier New', monospace;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 6px;
            background: linear-gradient(145deg, var(--iteb-green), var(--iteb-green-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            border: 1px dashed var(--iteb-green-light);
            border-radius: 8px;
            padding: 0.25rem 0.75rem;
            display: inline-block;
        }

        .form-floating>.form-control:focus,
        .form-floating>.form-select:focus {
            border-color: var(--iteb-green-light);
            box-shadow: 0 0 0 0.25rem rgba(13, 75, 30, 0.1);
        }

        .results-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .results-table thead {
            background-color: var(--iteb-green);
            color: white;
        }

        .results-table th {
            padding: 1rem 1.2rem;
            font-weight: 600;
            border: none;
        }

        .results-table td {
            padding: 1rem 1.2rem;
            background-color: white;
            border-bottom: 1px solid #e9ecef;
        }

        .results-table tbody tr:hover td {
            background-color: #f8fcf9;
        }

        .grade-badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-align: center;
            min-width: 60px;
        }

        .grade-a {
            background-color: rgba(40, 167, 69, 0.12);
            color: #1e7a3d;
        }

        .grade-b {
            background-color: rgba(13, 75, 30, 0.12);
            color: #026837;
        }

        .grade-c {
            background-color: rgba(255, 193, 7, 0.12);
            color: #856404;
        }

        .summary-card {
            background: linear-gradient(145deg, #f8fcf9, #f0f7f2);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .footer .btn-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding-left: 0;
        }

        .footer .btn-link:hover {
            color: #fff;
            text-decoration: none;
            padding-left: 5px;
        }

        /* WOW animations */
        .wow {
            visibility: hidden;
        }

        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start (exactly as about page) -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start (exact structure from about page, with Student Portal link added and active) -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
            <a href="{{ route('home.page') }}" class="navbar-brand d-flex align-items-center">
                <img src="{{ $systemSettings->logo_url ?? URL::asset('assets/images/brand/logo.png') }}" alt="ITEB Logo" class="navbar-logo me-3">
                <h1 style="color: #FE5D37" class="m-0 text-primary">ITEB</h1>
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{ route('home.page') }}" class="nav-item nav-link">Home</a>
                    <a href="{{ route('about.us') }}" class="nav-item nav-link">About Us</a>
                    <a href="{{ route('public.portal') }}" class="nav-item nav-link active">Student Portal</a>
                    <a href="{{ route('contact.us') }}" class="nav-item nav-link">Contact Us</a>
                    <a href="{{ route('users.login') }}" class="nav-item nav-link">Login</a>
                </div>
                <a href="{{ route('public.portal') }}" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">
                    Portal<i class="fa fa-arrow-right ms-3"></i>
                </a>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Page Header Start (same style as about page, updated for portal) -->
        <div class="container-xxl py-5 page-header position-relative mb-5">
            <div class="container py-5">
                <h1 class="display-2 text-white animated slideInDown mb-4">Student Results Portal</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('public.portal') }}">Student Portal</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Check Results</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- Portal Main Section: Lookup Form + Important Info -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5">
                    <!-- LEFT COLUMN: Results Lookup Form -->
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="portal-card p-4 p-lg-5">
                            <h2 class="mb-3 text-primary">Results Lookup</h2>
                            <p class="text-secondary mb-4">Enter your examination details to retrieve your official
                                results.</p>

                            <form id="resultsForm">
                                <div class="row g-4">
                                    <!-- Registration Number -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="registrationNumber"
                                                placeholder="Registration Number" required maxlength="20">
                                            <label for="registrationNumber"><i
                                                    class="fa fa-id-card me-2 text-primary"></i>Registration
                                                Number</label>
                                        </div>
                                    </div>
                                    <!-- Examination Year -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="examYear" required>
                                                <option value="">Select Year</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                            <label for="examYear"><i
                                                    class="fa fa-calendar-alt me-2 text-primary"></i>Examination
                                                Year</label>
                                        </div>
                                    </div>
                                    <!-- Examination Type -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="examType" required>
                                                <option value="">Select Exam Type</option>
                                                <option value="idaad">Idaad (Ordinary Level)</option>
                                                <option value="thanawi">Thanawi (Advanced Level)</option>
                                            </select>
                                            <label for="examType"><i
                                                    class="fa fa-graduation-cap me-2 text-primary"></i>Examination
                                                Type</label>
                                        </div>
                                    </div>
                                    <!-- Center Number (Optional) -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="centerNumber"
                                                placeholder="Center Number (Optional)">
                                            <label for="centerNumber"><i
                                                    class="fa fa-school me-2 text-primary"></i>Center Number
                                                (Optional)</label>
                                        </div>
                                    </div>
                                    <!-- CAPTCHA Row -->
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap align-items-center bg-light p-3 rounded-3">
                                            <div class="me-4 mb-2 mb-sm-0">
                                                <label class="fw-bold text-dark mb-1"><i
                                                        class="fa fa-shield-alt text-primary me-1"></i>Security</label>
                                                <div class="captcha-code" id="captchaText">A3B7C9</div>
                                            </div>
                                            <div class="flex-grow-1 me-2" style="min-width: 160px;">
                                                <input type="text" class="form-control" id="captchaInput"
                                                    placeholder="Enter code" required maxlength="6">
                                            </div>
                                            <button type="button" class="btn btn-outline-primary"
                                                id="refreshCaptcha">
                                                <i class="fa fa-redo"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Privacy Alert -->
                                    <div class="col-12">
                                        <div class="alert alert-info d-flex align-items-center mb-2"
                                            style="background-color: rgba(13,75,30,0.05); border-left: 4px solid var(--iteb-green);">
                                            <i class="fa fa-info-circle fs-4 me-3 text-primary"></i>
                                            <div class="small">Your results are confidential and encrypted. Only
                                                displayed after successful verification.</div>
                                        </div>
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100 py-3">
                                            <i class="fa fa-search me-2"></i> Retrieve Results
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Loading Spinner (hidden by default) -->
                        <div class="text-center py-5 my-4" id="loadingSpinner" style="display: none;">
                            <div class="spinner-border text-primary" style="width: 3.5rem; height: 3.5rem;"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-3 fs-5 text-primary fw-semibold">Retrieving your results...</p>
                            <p class="text-muted small">This may take a few moments</p>
                        </div>

                        <!-- Results Display Section (hidden by default) -->
                        <div id="resultsSection" style="display: none;">
                            <div class="portal-card p-4 p-lg-5 mt-5">
                                <div class="text-center mb-4">
                                    <h3 class="text-primary" id="studentName">Ismail Kateregga</h3>
                                    <p class="mb-2" id="studentProgram">Thanawi - Advanced Level</p>
                                    <div class="alert alert-success d-inline-flex align-items-center gap-2 mx-auto"
                                        style="background-color: rgba(40,167,69,0.1); border-left-color: #28a745;">
                                        <i class="fa fa-check-circle text-success"></i>
                                        <span>Official results for <span id="examDetails">2025 Thanawi
                                                Examination</span></span>
                                    </div>
                                </div>

                                <!-- Student Info Grid -->
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Registration Number</small>
                                            <h6 class="fw-bold mb-0" id="displayRegNo">U123456789</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Center Name</small>
                                            <h6 class="fw-bold mb-0" id="displayCenter">Kampala High School</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Examination Year</small>
                                            <h6 class="fw-bold mb-0" id="displayYear">2025</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Index Number</small>
                                            <h6 class="fw-bold mb-0" id="displayIndex">UGN234567</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- Results Table -->
                                <div class="table-responsive">
                                    <table class="results-table">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Paper Code</th>
                                                <th>Marks</th>
                                                <th>Grade</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultsTableBody"></tbody>
                                    </table>
                                </div>

                                <!-- Summary Section -->
                                <div class="summary-card mt-5 p-4">
                                    <div class="row g-3 text-center">
                                        <div class="col-6 col-md-3">
                                            <div class="fs-2 fw-bold text-primary" id="totalPoints">18</div>
                                            <span class="text-muted small">Total Points</span>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="fs-2 fw-bold text-primary" id="division">I</div>
                                            <span class="text-muted small">Division</span>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="fs-2 fw-bold text-primary" id="aggregate">12</div>
                                            <span class="text-muted small">Aggregate</span>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="fs-2 fw-bold text-primary" id="overallGrade">A</div>
                                            <span class="text-muted small">Overall Grade</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex flex-wrap gap-3 mt-4 justify-content-center">
                                    <button class="btn btn-primary px-4 py-2" id="printResults">
                                        <i class="fa fa-print me-2"></i>Print
                                    </button>
                                    <button class="btn btn-outline-primary px-4 py-2" id="downloadResults">
                                        <i class="fa fa-download me-2"></i>Download PDF
                                    </button>
                                    <button class="btn btn-outline-secondary px-4 py-2" id="newSearch">
                                        <i class="fa fa-search me-2"></i>New Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Important Information & Help -->
                    <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="bg-light rounded-4 p-4 p-lg-5 h-100">
                            <h3 class="mb-4 d-flex align-items-center">
                                <i class="fa fa-info-circle text-primary fs-2 me-3"></i>
                                Important Information
                            </h3>
                            <div class="alert alert-warning d-flex align-items-start border-0"
                                style="background-color: rgba(255,193,7,0.1);">
                                <i class="fa fa-exclamation-triangle text-warning fs-5 me-3 mt-1"></i>
                                <div><strong>Provisional results:</strong> These results are provisional until confirmed
                                    by the examination board.</div>
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Results
                                    released 6-8 weeks after exams</li>
                                <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Verify
                                    personal details match registration</li>
                                <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Contact school
                                    for discrepancies</li>
                                <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Keep
                                    registration number confidential</li>
                                <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Printed
                                    results require school stamp</li>
                            </ul>

                            <h4 class="mt-5 mb-3"><i class="fa fa-question-circle text-primary me-2"></i>Frequently
                                Asked Questions</h4>
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item border-0 mb-3">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-white shadow-sm rounded-3"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            When are results released?
                                        </button>
                                    </h6>
                                    <div id="faq1" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body bg-light rounded-bottom">
                                            Idaad results: March, Thanawi results: May each year.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0 mb-3">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-white shadow-sm rounded-3"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            Forgot registration number?
                                        </button>
                                    </h6>
                                    <div id="faq2" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body bg-light rounded-bottom">
                                            Contact your school administration or the examination board.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-white shadow-sm rounded-3"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            Are these results final?
                                        </button>
                                    </h6>
                                    <div id="faq3" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body bg-light rounded-bottom">
                                            They are provisional until officially confirmed by the board.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 p-3 rounded-3"
                                style="background: linear-gradient(145deg, #e9f1e9, #dbe8db);">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-headset text-primary fs-1 me-3"></i>
                                    <div>
                                        <h5 class="mb-1">Need direct help?</h5>
                                        <p class="mb-0 small">Call +256 800 123 456 or email results@iteb.org.ug</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call To Action Start (school registration) -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-light rounded-4 overflow-hidden">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                            <div class="position-relative h-100">
                                <img class="img-fluid h-100 w-100 object-fit-cover"
                                    src="{{ asset('asset/img/call-to-action.jpg') }}" alt="Register School"
                                    style="min-height: 300px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="p-5">
                                <h1 class="mb-4 text-primary">Register Your School</h1>
                                <p class="mb-4">Join the ITEB family and ensure your students receive accurate,
                                    timely, and secure examination results. Our platform offers seamless results
                                    submission, tracking, and comprehensive reports.</p>
                                <a href="{{ route('contact.us') }}" class="btn btn-primary py-3 px-5 rounded-pill">
                                    Get Started Now <i class="fa fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call To Action End -->

        <!-- Footer Start (exact copy from about page, with minor contact updates) -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Get In Touch</h3>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Kampala - Kawempe Division</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+256 700 123456</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@iteb.org.ug</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Quick Links</h3>
                        <a class="btn btn-link text-white-50" href="{{ route('home.page') }}">Home</a>
                        <a class="btn btn-link text-white-50" href="{{ route('about.us') }}">About Us</a>
                        <a class="btn btn-link text-white-50" href="{{ route('public.portal') }}">Student Portal</a>
                        <a class="btn btn-link text-white-50" href="{{ route('contact.us') }}">Contact Us</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Photo Gallery</h3>
                        <div class="row g-2 pt-2">
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1"
                                    src="{{ asset('asset/img/classes-1.jpg') }}" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1"
                                    src="{{ asset('asset/img/classes-2.jpg') }}" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1"
                                    src="{{ asset('asset/img/classes-3.jpg') }}" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1"
                                    src="{{ asset('asset/img/classes-4.jpg') }}" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1"
                                    src="{{ asset('asset/img/classes-5.jpg') }}" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1"
                                    src="{{ asset('asset/img/classes-6.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Newsletter</h3>
                        <p>Subscribe for exam updates & announcements.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text"
                                placeholder="Your email">
                            <button type="button"
                                class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">ITEB</a>, All Right Reserved.
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FAQs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries (same as about page) -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('asset/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('asset/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('asset/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset/js/main.js') }}"></script>

    <!-- Portal Functionality Script -->
    <script>
        // Initialize WOW.js for scroll animations
        new WOW().init();

        // Set current year in footer if element exists
        if (document.getElementById('year')) {
            document.getElementById('year').textContent = new Date().getFullYear();
        }

        // CAPTCHA Generator
        function generateCaptcha() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            let captcha = '';
            for (let i = 0; i < 6; i++) {
                captcha += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('captchaText').textContent = captcha;
            return captcha;
        }

        let currentCaptcha = generateCaptcha();

        document.getElementById('refreshCaptcha').addEventListener('click', function() {
            currentCaptcha = generateCaptcha();
            document.getElementById('captchaInput').value = '';
        });

        // Sample results data (matching the original portal)
        const sampleResults = {
            studentName: "Ismail Kateregga",
            program: "Thanawi - Advanced Level",
            regNo: "U123456789",
            center: "Kampala High School",
            year: "2025",
            indexNo: "UGN234567",
            examType: "Thanawi Examination",
            subjects: [{
                    name: "Mathematics",
                    code: "MAT401",
                    marks: 85,
                    grade: "A",
                    remarks: "Excellent"
                },
                {
                    name: "Physics",
                    code: "PHY402",
                    marks: 78,
                    grade: "B+",
                    remarks: "Very Good"
                },
                {
                    name: "Chemistry",
                    code: "CHE403",
                    marks: 82,
                    grade: "A-",
                    remarks: "Excellent"
                },
                {
                    name: "Biology",
                    code: "BIO404",
                    marks: 76,
                    grade: "B",
                    remarks: "Good"
                },
                {
                    name: "Computer Studies",
                    code: "COM405",
                    marks: 90,
                    grade: "A+",
                    remarks: "Outstanding"
                },
                {
                    name: "General Paper",
                    code: "GP406",
                    marks: 65,
                    grade: "C+",
                    remarks: "Satisfactory"
                }
            ],
            totalPoints: 18,
            division: "I",
            aggregate: 12,
            overallGrade: "A"
        };

        // Populate results with sample data
        function populateResults() {
            document.getElementById('studentName').textContent = sampleResults.studentName;
            document.getElementById('studentProgram').textContent = sampleResults.program;
            document.getElementById('displayRegNo').textContent = sampleResults.regNo;
            document.getElementById('displayCenter').textContent = sampleResults.center;
            document.getElementById('displayYear').textContent = sampleResults.year;
            document.getElementById('displayIndex').textContent = sampleResults.indexNo;
            document.getElementById('examDetails').textContent = `${sampleResults.year} ${sampleResults.examType}`;

            document.getElementById('totalPoints').textContent = sampleResults.totalPoints;
            document.getElementById('division').textContent = sampleResults.division;
            document.getElementById('aggregate').textContent = sampleResults.aggregate;
            document.getElementById('overallGrade').textContent = sampleResults.overallGrade;

            const tableBody = document.getElementById('resultsTableBody');
            tableBody.innerHTML = '';

            sampleResults.subjects.forEach(subject => {
                let gradeClass = 'grade-badge ';
                if (subject.grade.startsWith('A')) gradeClass += 'grade-a';
                else if (subject.grade.startsWith('B')) gradeClass += 'grade-b';
                else gradeClass += 'grade-c';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${subject.name}</td>
                    <td>${subject.code}</td>
                    <td>${subject.marks}</td>
                    <td><span class="${gradeClass}">${subject.grade}</span></td>
                    <td>${subject.remarks}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Form submission handler
        document.getElementById('resultsForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate CAPTCHA
            const captchaInput = document.getElementById('captchaInput').value.toUpperCase();
            if (captchaInput !== currentCaptcha) {
                alert('Invalid CAPTCHA code. Please try again.');
                generateCaptcha();
                return;
            }

            // Hide form card? (We keep it visible, but show spinner)
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('resultsSection').style.display = 'none';

            // Simulate API call
            setTimeout(() => {
                document.getElementById('loadingSpinner').style.display = 'none';
                populateResults();
                document.getElementById('resultsSection').style.display = 'block';

                // Scroll to results smoothly
                document.getElementById('resultsSection').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Refresh CAPTCHA
                currentCaptcha = generateCaptcha();
                document.getElementById('captchaInput').value = '';
            }, 1500);
        });

        // Print functionality
        document.getElementById('printResults').addEventListener('click', function() {
            const printContent = document.querySelector('#resultsSection .portal-card').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Official Results - ITEB</title>
                    <style>
                        body { font-family: 'Heebo', sans-serif; padding: 2rem; }
                        .portal-card { max-width: 1000px; margin: 0 auto; }
                        .grade-badge { display: inline-block; padding: 0.25rem 1rem; border-radius: 50px; }
                        .grade-a { background: #d4edda; color: #155724; }
                        .grade-b { background: #d1ecf1; color: #0c5460; }
                        .grade-c { background: #fff3cd; color: #856404; }
                        .results-table { width: 100%; border-collapse: collapse; }
                        .results-table th { background: #026837; color: white; padding: 12px; }
                        .results-table td { padding: 10px; border-bottom: 1px solid #ddd; }
                    </style>
                </head>
                <body>
                    ${printContent}
                    <p style="text-align: center; margin-top: 30px; color: #666;">Official Document - Printed on ${new Date().toLocaleDateString()}</p>
                </body>
                </html>
            `;
            window.print();
            window.location.reload();
        });

        // Download PDF (simulated)
        document.getElementById('downloadResults').addEventListener('click', function() {
            alert('PDF download would be integrated with a library. For now, you can print to PDF.');
        });

        // New Search
        document.getElementById('newSearch').addEventListener('click', function() {
            document.getElementById('resultsSection').style.display = 'none';
            document.getElementById('resultsForm').reset();
            currentCaptcha = generateCaptcha();
            document.getElementById('captchaInput').value = '';
            document.getElementById('lookup-form').scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    targetEl.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
