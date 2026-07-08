<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Site keywords here">
    <meta name="description" content="">
    <meta name='copyright' content=''>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>ITEB &minus; Idaad & Thanawi Examination Board</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('asset/images/logo.png')); ?>">

    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/font-awesome.min.css')); ?>">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/niceselect.css')); ?>">
    <!-- Fancy Box CSS -->
    <link rel="stylesheet" href=" <?php echo e(asset('asset/css/jquery.fancybox.min.css')); ?>">
    <!-- Fancy Box CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/cube-portfolio.min.css')); ?>">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/owl.carousel.min.css')); ?>">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/animate.min.css')); ?>">
    <!-- Slick Nav CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/slicknav.min.css')); ?>">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/magnific-popup.css')); ?>">

    <!-- Eduland Stylesheet -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/normalize.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/responsive.css')); ?>">

    <!-- Eduland Colors -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/colors/color1.css')); ?>">

</head>

<body>


    <!-- Header -->
    <header class="header">
        <!-- Header Inner -->
        <div class="header-inner overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="<?php echo e(route('home.page')); ?>">
                                <img src="<?php echo e(asset('asset/images/logo.png')); ?>" alt="#"
                                    style="width: 180px; height: 100px; object-fit: contain; max-width: 100%;"
                                    class="logo-img">
                            </a>
                        </div>
                        <!--/ End Logo -->

                        <!-- Add this style tag right after your logo or in the head section -->
                        <style>
                            @media (max-width: 768px) {
                                .logo-img {
                                    width: 120px !important;
                                    height: 60px !important;
                                }
                            }

                            @media (max-width: 480px) {
                                .logo-img {
                                    width: 100px !important;
                                    height: 50px !important;
                                }
                            }
                        </style>
                        <div class="mobile-menu"></div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-12">
                        <div class="menu-bar">
                            <nav class="navbar navbar-default">
                                <div class="navbar-collapse">
                                    <!-- Main Menu -->
                                    <ul id="nav" class="nav menu navbar-nav">
                                        <li class="active"><a href="<?php echo e(route('home.page')); ?>"><i
                                                    class="fa fa-home"></i>Home</a></li>
                                        <li><a href="<?php echo e(route('users.login')); ?>"><i
                                                    class="fa fa-address-book"></i>Login</a></li>
                                    </ul>
                                    <!-- End Main Menu -->
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Header Inner -->
    </header>
    <!--/ End Header -->

    <!-- Slider Area -->
    <section class="home-slider">
        <div class="slider-active">
            <!-- Single Slider -->
            <div class="single-slider overlay">
                <div class="slider-image"
                    style="background-image:url(<?php echo e(asset('asset/images/slider/slider-bg1.jpg')); ?>)"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-10 col-12">
                            <!-- Slider Content -->
                            <div class="slider-content">
                                <h1 class="slider-title"><span>KAMSSA</span>NANSANA MUNICIPAL <b>Examination Council</b></h1>
                                <p class="slider-text">At the Uganda Muslim Supreme Council (UMSC) Examination Board, we
                                    are committed to upholding the highest standards in Islamic secondary education.</p>
                                <!-- Button -->
                                <div class="button">
                                    <a href="#about-iteb" class="btn white">About ITEB</a>
                                    <a href="#subjects" class="btn white primary">Our Subjects</a>
                                </div>
                                <!--/ End Button -->
                            </div>
                            <!--/ End Slider Content -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ End Single Slider -->
        </div>
    </section>
    <!--/ End Slider Area -->

    <!-- Courses -->
    <section id="subjects" class="courses section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="section-title bg">
                        <h2>Our <span>Subjects</span></h2>
                        <p>many schools are adopting a "duo curriculum" (Combining standard secondary
                            subjects with advanced Islamic Theology) to help students compete on the international
                            market</p>
                        <div class="icon"><i class="fa fa-clone"></i></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Course -->
                    <div class="single-course">
                        <!-- Course Head -->
                        <div class="course-head overlay">
                            <img src="<?php echo e(asset('asset/images/courses/course1.jpg')); ?>" alt="#">
                            <a href="<?php echo e(route('users.login')); ?>" class="btn white primary">Register Now</a>
                        </div>
                        <!-- Course Body -->
                        <div class="course-body">
                            <div class="name-price">
                                <div class="teacher-info">
                                    <img src="<?php echo e(asset('asset/images/author1.jpg')); ?>" alt="#">
                                    <h4 class="title"></h4>
                                </div>
                                <span class="price">ID & TH</span>
                            </div>
                            <h4 class="c-title"><a href="#">Islamic History</a></h4>
                            <p>Islamic History studies the Muslim world's past, from the Prophet's life to its
                                spread in Africa. It helps students understand their faith's origins and development.
                            </p>
                        </div>
                        <!-- Course Meta -->
                        <div class="course-meta">
                            <!-- Rattings -->
                            <ul class="rattings">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li class="point"><span>5.0</span></li>
                            </ul>
                            <!-- Course Info -->

                        </div>
                        <!--/ End Course Meta -->
                    </div>
                    <!--/ End Single Course -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Course -->
                    <div class="single-course">
                        <!-- Course Head -->
                        <div class="course-head overlay">
                            <img src="<?php echo e(asset('asset/images/courses/course3.jpg')); ?>" alt="#">
                            <a href="<?php echo e(route('users.login')); ?>" class="btn white primary">Register Now</a>
                        </div>
                        <!-- Course Body -->
                        <div class="course-body">
                            <div class="name-price">
                                <div class="teacher-info">
                                    <img src="<?php echo e(asset('asset/images/author3.jpg')); ?>" alt="#">
                                    <h4 class="title"></h4>
                                </div>
                                <span class="price">IT & TH</span>
                            </div>
                            <h4 class="c-title"><a href="#">Sources of exegesis</a></h4>
                            <p>examines the tools used to interpret the Qur'an. Studied at Uganda's O-Level, it
                                identifies the primary sources: the Qur'an itself, the Hadith, scholarly consensus, and
                                Arabic linguistics.</p>
                        </div>
                        <!-- Course Meta -->
                        <div class="course-meta">
                            <!-- Rattings -->
                            <ul class="rattings">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li class="point"><span>5.0</span></li>
                            </ul>
                            <!-- Course Info -->

                        </div>
                        <!--/ End Course Meta -->
                    </div>
                    <!--/ End Single Course -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Course -->
                    <div class="single-course">
                        <!-- Course Head -->
                        <div class="course-head overlay">
                            <img src="<?php echo e(asset('asset/images/courses/course2.jpg')); ?>" alt="#">
                            <a href="<?php echo e(route('users.login')); ?>" class="btn white primary">Register Now</a>
                        </div>
                        <!-- Course Body -->
                        <div class="course-body">
                            <div class="name-price">
                                <div class="teacher-info">
                                    <img src="<?php echo e(asset('asset/images/author2.jpg')); ?>" alt="#">
                                    <h4 class="title"></h4>
                                </div>
                                <span class="price">ID & TH</span>
                            </div>
                            <h4 class="c-title"><a href="#">Islamic Monotheism</a></h4>
                            <p>is the foundational belief in the absolute oneness of God (Tawhid). Studied at Uganda's
                                O-Level, it teaches that Allah is unique, without partners or equals.</p>
                        </div>
                        <!-- Course Meta -->
                        <div class="course-meta">
                            <!-- Rattings -->
                            <ul class="rattings">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li class="point"><span>5.0</span></li>
                            </ul>
                            <!-- Course Info -->

                        </div>
                        <!--/ End Course Meta -->
                    </div>
                    <!--/ End Single Course -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Course -->
                    <div class="single-course">
                        <!-- Course Head -->
                        <div class="course-head overlay">
                            <img src="<?php echo e(asset('asset/images/courses/course4.jpg')); ?>" alt="#">
                            <a href="<?php echo e(route('users.login')); ?>" class="btn white primary">Register Now</a>
                        </div>
                        <!-- Course Body -->
                        <div class="course-body">
                            <div class="name-price">
                                <div class="teacher-info">
                                    <img src="<?php echo e(asset('asset/images/author1.jpg')); ?>" alt="#">
                                    <h4 class="title"></h4>
                                </div>
                                <span class="price">ID & TH</span>
                            </div>
                            <h4 class="c-title"><a href="#">Quran Recitation and its Rules</a></h4>
                            <p>(Tajweed) teaches the correct pronunciation and melodious recitation of the Holy Quran.
                                Studied at Uganda's primary level, it covers articulation points, nasal sounds, and
                                stopping rules.</p>
                        </div>
                        <!-- Course Meta -->
                        <div class="course-meta">
                            <!-- Rattings -->
                            <ul class="rattings">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li class="point"><span>5.0</span></li>
                            </ul>
                            <!-- Course Info -->

                        </div>
                        <!--/ End Course Meta -->
                    </div>
                    <!--/ End Single Course -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Course -->
                    <div class="single-course">
                        <!-- Course Head -->
                        <div class="course-head overlay">
                            <img src="<?php echo e(asset('asset/images/courses/course5.jpg')); ?>" alt="#">
                            <a href="<?php echo e(route('users.login')); ?>" class="btn white primary">Register Now</a>
                        </div>
                        <!-- Course Body -->
                        <div class="course-body">
                            <div class="name-price">
                                <div class="teacher-info">
                                    <img src="<?php echo e(asset('asset/images/author3.jpg')); ?>" alt="#">
                                    <h4 class="title">ID & TH</h4>
                                </div>
                                <span class="price">ID & TH</span>
                            </div>
                            <h4 class="c-title"><a href="#">Composition and Comprehension</a></h4>
                            <p>develops Arabic writing and reading skills. Studied at Uganda's O-Level and A-Level, it
                                enables students to construct texts and understand classical literature</p>
                        </div>
                        <!-- Course Meta -->
                        <div class="course-meta">
                            <!-- Rattings -->
                            <ul class="rattings">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li class="point"><span>5.0</span></li>
                            </ul>
                            <!-- Course Info -->

                        </div>
                        <!--/ End Course Meta -->
                    </div>
                    <!--/ End Single Course -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Course -->
                    <div class="single-course">
                        <!-- Course Head -->
                        <div class="course-head overlay">
                            <img src="<?php echo e(asset('asset/images/courses/course3.jpg')); ?>" alt="#">
                            <a href="<?php echo e(route('users.login')); ?>" class="btn white primary">Register Now</a>
                        </div>
                        <!-- Course Body -->
                        <div class="course-body">
                            <div class="name-price">
                                <div class="teacher-info">
                                    <img src="<?php echo e(asset('asset/images/author2.jpg')); ?>" alt="#">
                                    <h4 class="title"></h4>
                                </div>
                                <span class="price">ID & TH</span>
                            </div>
                            <h4 class="c-title"><a href="#">Rhetoric</a></h4>
                            <p>is the study of eloquent and effective communication in Arabic. Studied at Uganda's
                                A-Level, it examines figurative language, stylistic devices, and composition techniques.
                            </p>
                        </div>
                        <!-- Course Meta -->
                        <div class="course-meta">
                            <!-- Rattings -->
                            <ul class="rattings">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li class="point"><span>5.0</span></li>
                            </ul>
                            <!-- Course Info -->

                        </div>
                        <!--/ End Course Meta -->
                    </div>
                    <!--/ End Single Course -->
                </div>
            </div>
        </div>
    </section>
    <!--/ End Courses -->

    <!-- Features -->
    <div class="features overlay section" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Single Feature -->
                    <div class="single-feature">
                        <div class="icon-img">
                            <img src="<?php echo e(asset('asset/images/feature1.jpg')); ?>" alt="#">
                            <i class="fa fa-clone"></i>
                        </div>
                        <div class="feature-content">
                            <h4 class="f-title">Religions and Sects</h4>
                            <p>is an A-Level subject examining different Islamic sects and other faith traditions . It
                                enables students to understand doctrinal differences and religious diversity, fostering
                                interfaith awareness and comparative theological analysis at university level </p>
                        </div>
                    </div>
                    <!--/ End Single Feature -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Single Feature -->
                    <div class="single-feature">
                        <div class="icon-img">
                            <img src="<?php echo e(asset('asset/images/feature2.jpg')); ?>" alt="#">
                            <i class="fa fa-book"></i>
                        </div>
                        <div class="feature-content">
                            <h4 class="f-title">sources of jurisprudence</h4>
                            <p>studies the primary evidence for Islamic law. At Uganda's O-Level, it examines the
                                Qur'an, Sunnah, scholarly consensus, and analogy. The subject teaches students how legal
                                rulings are derived from these foundations, ensuring daily practices are authentically
                                grounded.</p>
                        </div>
                    </div>
                    <!--/ End Single Feature -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Single Feature -->
                    <div class="single-feature">
                        <div class="icon-img">
                            <img src="<?php echo e(asset('asset/images/feature1.jpg')); ?>" alt="#">
                            <i class="fa fa-institution"></i>
                        </div>
                        <div class="feature-content">
                            <h4 class="f-title">grammar and morphology</h4>
                            <p>are the foundational sciences of Arabic linguistics. Studied at Uganda's A-Level, grammar
                                governs sentence structure while morphology examines word patterns. Together, they
                                enable students to accurately understand classical texts, including the Qur'an and
                                Hadith, in their original form.</p>
                        </div>
                    </div>
                    <!--/ End Single Feature -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Single Feature -->
                    <div class="single-feature">
                        <div class="icon-img">
                            <img src="<?php echo e(asset('asset/images/feature3.jpg')); ?>" alt="#">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="feature-content">
                            <h4 class="f-title">Sources of Prophetic Traditions</h4>
                            <p>examines the methodology for verifying Hadith. Studied at Uganda's O-Level, it covers
                                chains of narration, narrator reliability, and text analysis. The subject distinguishes
                                authentic from weak traditions, ensuring only verified teachings guide Islamic practice.
                            </p>
                        </div>
                    </div>
                    <!--/ End Single Feature -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Features -->

    <!-- Events -->
    <section id="about-iteb" class="events section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="section-title bg">
                        <h2>Examination <span>Structures</span></h2>
                        <p>Idaad (O-Level): The Ordinary Level secondary education stage specializing in Islamic
                            Theology.
                            Generally a 4-year program.</p>
                        <p>Thanawi (A-Level): The Advanced Level secondary education stage. Generally a 2-year program.
                        </p>
                        <div class="icon"><i class="fa fa-paper-plane"></i></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div class="event-img">
                        <img src="<?php echo e(asset('asset/images/event-left.png')); ?>" alt="#">
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="coming-event">
                        <!-- Single Event -->
                        <div class="single-event">
                            <div class="event-date">
                                <p>01<span></span></p>
                            </div>
                            <div class="event-content">
                                <h3 class="event-title"><a href="#">Data Collection</a></h3>
                                <p>Secure digital submission of examination papers with automated
                                    validation and error detection.</p>
                            </div>
                        </div>
                        <!-- End Single Event -->
                        <!-- Single Event -->
                        <div class="single-event">
                            <div class="event-date">
                                <p>02<span></span></p>
                            </div>
                            <div class="event-content">
                                <h3 class="event-title"><a href="#">Automated Grading</a></h3>
                                <p>System processes results using AI-powered algorithms aligned with
                                    national grading standards.</p>
                            </div>
                        </div>
                        <!-- End Single Event -->
                        <!-- Single Event -->
                        <div class="single-event">
                            <div class="event-date">
                                <p>03<span></span></p>
                            </div>
                            <div class="event-content">
                                <h3 class="event-title"><a href="#">Quality Control</a></h3>
                                <p>Multi-level verification by qualified examiners ensures accuracy
                                    before final approval.</p>
                            </div>
                        </div>
                        <!-- End Single Event -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Events -->

    <!-- Call To Action -->
    <section class="cta">
        <div class="cta-inner overlay section" style="background-image:url(<?php echo e(asset('asset/images/cta-bg.jpg')); ?>)"
            data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="text-content">
                            <h2>We <span>Focus on</span> Transparency, Quality & Religious Teachings</h2>
                            <p>Our institution upholds the highest standards in Islamic education by prioritizing
                                transparency in all our operations, ensuring clarity between educators and students. We
                                maintain uncompromising quality through structured curricula covering Quranic
                                recitation, Hadith verification, and jurisprudence. Most importantly, our religious
                                teachings remain rooted in authentic sources, nurturing students who practice their
                                faith with understanding and integrity.</p>
                            <!-- CTA Button -->
                            <div class="button">
                                <a class="btn white" href="<?php echo e(route('users.login')); ?>">Join With Now</a>
                                <a class="btn white primary" href="<?php echo e(route('users.login')); ?>">Check your results</a>
                            </div>
                            <!--/ End CTA Button -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <!-- Cta Image -->
                        <div class="cta-image">
                            <img src="<?php echo e(asset('asset/images/girl-1.png')); ?>" alt="#">
                        </div>
                        <!--/ End Cta Image -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Call To Action -->
    <!-- Faqs -->
    <section class="faqs section" id="FAQS">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="section-title bg">
                        <h2>Frequently Asked <span>Questions</span></h2>
                        <p>Find answers to common questions about our Idaad and Thanawi system of Islamic education.</p>
                        <div class="icon"><i class="fa fa-question"></i></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div class="faq-image"> <img src="<?php echo e(asset('asset/images/faq.png')); ?>" alt="#">
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="faq-main">
                        <div class="faq-content">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <!-- Single Faq -->
                                <div class="panel panel-default">
                                    <div class="faq-heading" id="FaqTitle1">
                                        <h4 class="faq-title"> <a class="collapsed" data-toggle="collapse"
                                                data-parent="#accordion" href="#faq1"><i class="fa fa-question">

                                                </i>What is the Idaad and Thanawi system?</a> </h4>
                                    </div>
                                    <div id="faq1" class="panel-collapse collapse" role="tabpanel"
                                        aria-labelledby="FaqTitle1">
                                        <div class="faq-body">The Idaad and Thanawi system is Uganda's structured
                                            Islamic secondary education framework.
                                            Idaad (O-Level) covers the first four years, building foundational
                                            knowledge.
                                            Thanawi (A-Level) is a two-year advanced program for deeper specialization
                                            in Islamic sciences.</div>
                                    </div>
                                </div> <!--/ End Single Faq --> <!-- Single Faq -->
                                <div class="panel panel-default active">
                                    <div class="faq-heading" id="FaqTitle2">
                                        <h4 class="faq-title"> <a class="collapsed" data-toggle="collapse"
                                                data-parent="#accordion" href="#faq2">
                                                <i class="fa fa-question"></i>How long does each level take to
                                                complete?</a> </h4>
                                    </div>
                                    <div id="faq2" class="panel-collapse collapse show" role="tabpanel"
                                        aria-labelledby="FaqTitle2">
                                        <div class="faq-body">Idaad (O-Level) spans four years, while Thanawi (A-Level)
                                            requires two years of study. Students typically begin after completing
                                            primary Islamic education,
                                            progressing systematically through the curriculum.</div>
                                    </div>
                                </div> <!--/ End Single Faq --> <!-- Single Faq -->
                                <div class="panel panel-default">
                                    <div class="faq-heading" id="FaqTitle3">
                                        <h4 class="faq-title"> <a class="collapsed" data-toggle="collapse"
                                                data-parent="#accordion" href="#faq3">
                                                <i class="fa fa-question"></i>What subjects are taught at Idaad
                                                level?</a> </h4>
                                    </div>
                                    <div id="faq3" class="panel-collapse collapse" role="tabpanel"
                                        aria-labelledby="FaqTitle3">
                                        <div class="faq-body">Idaad students study Islamic Monotheism, Sources of
                                            Exegesis, Sources of Jurisprudence, Sources of Prophetic Traditions,
                                            Qur'anic Orals, Arabic Composition
                                            and Comprehension, and Islamic History, among others.</div>
                                    </div>
                                </div> <!--/ End Single Faq --> <!-- Single Faq -->
                                <div class="panel panel-default">
                                    <div class="faq-heading" id="FaqTitle4">
                                        <h4 class="faq-title"> <a class="collapsed" data-toggle="collapse"
                                                data-parent="#accordion" href="#faq4">
                                                <i class="fa fa-question"></i>What makes Thanawi level different?</a>
                                        </h4>
                                    </div>
                                    <div id="faq4" class="panel-collapse collapse" role="tabpanel"
                                        aria-labelledby="FaqTitle4">
                                        <div class="faq-body">Thanawi offers advanced specialization with subjects like
                                            Qur'an Exegesis,
                                            Jurisprudence of Rituals, Religion and Sects, Rhetoric, and advanced Grammar
                                            and Morphology,
                                            preparing students for university-level Islamic scholarship.</div>
                                    </div>
                                </div> <!--/ End Single Faq --> <!-- Single Faq -->
                                <div class="panel panel-default">
                                    <div class="faq-heading" id="FaqTitle5">
                                        <h4 class="faq-title"> <a class="collapsed" data-toggle="collapse"
                                                data-parent="#accordion" href="#faq5">
                                                <i class="fa fa-question"></i>Are graduates qualified for university
                                                admission?</a>
                                        </h4>
                                    </div>
                                    <div id="faq5" class="panel-collapse collapse" role="tabpanel"
                                        aria-labelledby="FaqTitle5">
                                        <div class="faq-body">
                                            Yes, successful Thanawi graduates meet admission requirements for Islamic
                                            universities, including the Islamic University in Uganda (IUIU), where they
                                            can pursue bachelor's and postgraduate degrees in specialized Islamic
                                            disciplines.</div>
                                    </div>
                                </div> <!--/ End Single Faq -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--/ End Blogs -->

    <div class="clients">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="text-content text-center">
                        <h4>Idaad and Thanawi Examination Board</h4>
                        <p>The official examination board responsible for standardizing, administering,
                            and certifying Islamic secondary education across Uganda. We ensure quality
                            assessment at both Idaad (O-Level) and Thanawi (A-Level) stages,
                            maintaining academic excellence and authentic Islamic values
                            throughout the national curriculum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--/ End Clients CSS -->

    <!-- Footer -->
    <footer class="footer section">
        <!-- Footer Top -->
        <div class="footer-top overlay">
            <div class="container">
                <div class="row">

                    <!-- About -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-widget about">
                            <h2>About ITEB</h2>
                            <ul class="list">
                                <li><i class="fa fa-phone"></i>Phone: +256 702 595 554</li>
                                <li><i class="fa fa-envelope"></i>Email:
                                    <a href="mailto:info@iteb-ug.org">Info@iteb-ug.org</a>
                                </li>
                                <li>
                                    <i class="fa fa-map-marker"></i>
                                    <span>Address: Kampala - Kawempe. Uganda</span>
                                </li>
                            </ul>

                            <!-- Social -->
                            <ul class="social">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                            <!-- End Social -->
                        </div>
                    </div>

                    <!-- Useful Links -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-widget list">
                            <h2>Useful Links</h2>
                            <ul>
                                <li><i class="fa fa-angle-right"></i><a href="#">Home</a></li>
                                <li><i class="fa fa-angle-right"></i><a href="#about-iteb">Our Subjects</a></li>
                                <li><i class="fa fa-angle-right"></i><a href="#FAQS">FAQ's</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Extra Section (You can customize this) -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-widget">
                            <h2>Quick Contact</h2>
                            <p>
                                Have questions or need more information? Reach out to us and
                                our team will be happy to assist you.
                            </p>
                            <a href="mailto:info@iteb-ug.org" class="btn mt-3">
                                Contact Us
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/ End Footer Top -->

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <div class="copyright"
                            style="display:flex; justify-content:space-between; align-items:center; width:100%;">

                            <p style="margin:0;">
                                Designed and developed by
                                <a href="<?php echo e(route('coming.soon')); ?>">www.Techsate.com</a>.
                            </p>

                            <p style="margin:0;">
                                © <span id="year"></span> Iteb. All rights reserved.
                            </p>

                        </div>

                        <script>
                            document.getElementById("year").textContent = new Date().getFullYear();
                        </script>

                    </div>
                </div>
            </div>
        </div>
        <!--/ End Footer Bottom -->
    </footer>
    <!--/ End Footer -->

    <!-- Jquery JS-->
    <script src="<?php echo e(asset('asset/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/js/jquery-migrate.min.js')); ?>"></script>
    <!-- Colors JS-->
    <script src="<?php echo e(asset('asset/js/colors.js')); ?>"></script>
    <!-- Popper JS-->
    <script src="<?php echo e(asset('asset/js/popper.min.js')); ?>"></script>
    <!-- Bootstrap JS-->
    <script src="<?php echo e(asset('asset/js/bootstrap.min.js')); ?>"></script>
    <!-- Owl Carousel JS-->
    <script src="<?php echo e(asset('asset/js/owl.carousel.min.js')); ?>"></script>
    <!-- Jquery Steller JS -->
    <script src="<?php echo e(asset('asset/js/jquery.stellar.min.js')); ?>"></script>
    <!-- Final Countdown JS -->
    <script src="<?php echo e(asset('asset/js/finalcountdown.min.js')); ?>"></script>
    <!-- Fancy Box JS-->
    <script src="<?php echo e(asset('asset/js/facnybox.min.js')); ?>"></script>
    <!-- Magnific Popup JS-->
    <script src="<?php echo e(asset('asset/js/jquery.magnific-popup.min.js')); ?>"></script>
    <!-- Circle Progress JS -->
    <script src="<?php echo e(asset('asset/js/circle-progress.min.js')); ?>"></script>
    <!-- Nice Select JS -->
    <script src="<?php echo e(asset('asset/js/niceselect.js')); ?>"></script>
    <!-- Jquery Steller JS-->
    <script src="<?php echo e(asset('asset/js/jquery.stellar.min.js')); ?>"></script>
    <!-- Jquery Steller JS-->
    <script src="<?php echo e(asset('asset/js/cube-portfolio.min.js')); ?>"></script>
    <!-- Slick Nav JS-->
    <script src="<?php echo e(asset('asset/js/slicknav.min.js')); ?>"></script>
    <!-- Easing JS-->
    <script src="<?php echo e(asset('asset/js/easing.min.js')); ?>"></script>
    <!-- Waypoints JS-->
    <script src="<?php echo e(asset('asset/js/waypoints.min.js')); ?>"></script>
    <!-- Counter Up JS -->
    <script src="<?php echo e(asset('asset/js/jquery.counterup.min.js')); ?>"></script>
    <!-- Scroll Up JS-->
    <script src="<?php echo e(asset('asset/js/jquery.scrollUp.min.js')); ?>"></script>
    <!-- Gmaps JS-->
    <script src="<?php echo e(asset('asset/js/gmaps.min.js')); ?>"></script>
    <!-- Main JS-->
    <script src="<?php echo e(asset('asset/js/main.js')); ?>"></script>
</body>

</html><?php /**PATH C:\Users\USER\Desktop\huzaiphar\ple-examination-boards-updated\resources\views/home-page.blade.php ENDPATH**/ ?>