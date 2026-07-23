<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ $systemSettings->system_name ?? 'Kampala Integrated Secondary School Examination Bureau' }} — {{ $systemSettings->tagline ?? 'Uganda\'s trusted secondary examination board standardizing O-LEVEL and A-LEVEL education.' }}">
    <title>{{ $systemSettings->short_name ?? 'Kamssa' }} —
        {{ $systemSettings->system_name ?? 'Kampala Integrated Secondary School Examination Bureau' }}
    </title>
    <link rel="icon" type="image/png" href="{{ $systemSettings->favicon_url ?? asset('asset/images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ─── Design Tokens ─────────────────────────────────────────── */
        :root {
            --emerald: #026837;
            --emerald-mid: #287C44;
            --emerald-lt: #287C44;
            --gold: #f0a500;
            --gold-lt: #f7c23e;
            --gold-pale: #fff8ec;
            --ink: #1a0612;
            --slate: #5a3a50;
            --mist: #fdf4f9;
            --white: #ffffff;
            --radius: 12px;
            --shadow-sm: 0 2px 12px #287C44;
            --shadow-md: 0 8px 40px #287C44;
            --shadow-lg: 0 20px 70px #287C44;
            --transition: .3s cubic-bezier(.4, 0, .2, 1);
        }

        /* ─── Reset & Base ───────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.65;
        }

        img {
            max-width: 100%;
            display: block;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        /* ─── Utility ────────────────────────────────────────────────── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 14px;
        }

        .section-label::before,
        .section-label::after {
            content: '';
            display: block;
            height: 1px;
            width: 28px;
            background: var(--gold);
        }

        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.2;
            color: var(--ink);
        }

        .section-heading span {
            color: var(--emerald);
        }

        .section-sub {
            font-size: 1.05rem;
            color: var(--slate);
            max-width: 560px;
            margin-top: 16px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--emerald);
            color: var(--white);
            padding: 14px 32px;
            border-radius: 50px;
            font-size: .9rem;
            font-weight: 600;
            letter-spacing: .02em;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .btn-primary:hover {
            background: var(--emerald-mid);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(26, 92, 64, .3);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--white);
            padding: 13px 30px;
            border-radius: 50px;
            font-size: .9rem;
            font-weight: 600;
            letter-spacing: .02em;
            border: 2px solid rgba(255, 255, 255, .5);
            transition: var(--transition);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, .12);
            border-color: var(--white);
            transform: translateY(-2px);
        }

        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gold);
            color: var(--ink);
            padding: 14px 32px;
            border-radius: 50px;
            font-size: .9rem;
            font-weight: 700;
            letter-spacing: .02em;
            transition: var(--transition);
        }

        .btn-gold:hover {
            background: var(--gold-lt);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(201, 150, 12, .35);
        }

        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        /* ─── Navigation ─────────────────────────────────────────────── */
        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0 0;
            transition: var(--transition);
        }

        #navbar.scrolled {
            background: rgba(14, 26, 20, .96);
            backdrop-filter: blur(16px);
            box-shadow: 0 2px 24px rgba(0, 0, 0, .2);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: contain;
            border: 2px solid rgba(255, 255, 255, .25);
        }

        .nav-logo-text {
            line-height: 1.2;
        }

        .nav-logo-text strong {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 2.01rem;
            color: var(--white);
            font-weight: 700;
        }

        .nav-logo-text span {
            font-size: .85rem;
            color: rgba(255, 255, 255, .6);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        .nav-links a {
            color: rgba(255, 255, 255, .8);
            font-size: .88rem;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gold);
            border-radius: 2px;
            transform: scaleX(0);
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--white);
        }

        .nav-links a:hover::after {
            transform: scaleX(1);
        }

        .nav-cta {
            background: var(--gold);
            color: var(--ink) !important;
            padding: 9px 22px;
            border-radius: 50px;
            font-weight: 700 !important;
            transition: var(--transition) !important;
        }

        .nav-cta::after {
            display: none !important;
        }

        .nav-cta:hover {
            background: var(--gold-lt) !important;
            color: var(--ink) !important;
        }

        .nav-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 6px;
        }

        .nav-hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--white);
            border-radius: 2px;
            transition: var(--transition);
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 72px;
            left: 0;
            right: 0;
            background: rgba(14, 26, 20, .98);
            backdrop-filter: blur(16px);
            padding: 24px;
            z-index: 999;
        }

        .mobile-menu.open {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .mobile-menu a {
            color: rgba(255, 255, 255, .85);
            font-size: 1rem;
            font-weight: 500;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        /* ─── Hero ───────────────────────────────────────────────────── */
        .hero {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #1a0612 0%, #026837 55%, #2a0a1a 100%);
            overflow: hidden;
        }

        .hero-bg-pattern {
            position: absolute;
            inset: 0;
            z-index: 0;
            background-image:
                radial-gradient(circle at 80% 20%, rgba(240, 165, 0, .12) 0%, transparent 50%),
                radial-gradient(circle at 10% 80%, rgba(196, 39, 138, .2) 0%, transparent 50%);
        }

        /* Geometric pattern */
        .hero-geo {
            position: absolute;
            right: -60px;
            top: 50%;
            transform: translateY(-50%);
            width: 680px;
            height: 680px;
            opacity: .07;
            z-index: 0;
        }

.hero-content {
    position: relative;
    z-index: 1;
    padding: 120px 0 80px;
    width: 100%;   /* ← add this line */
}

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(201, 150, 12, .15);
            border: 1px solid rgba(201, 150, 12, .3);
            color: var(--gold-lt);
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 7px 18px;
            border-radius: 50px;
            margin-bottom: 28px;
        }

        .hero-badge i {
            font-size: .7rem;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.6rem, 6vw, 4.8rem);
            font-weight: 800;
            line-height: 1.1;
            color: var(--white);
            max-width: 760px;
        }

        .hero-title em {
            font-style: normal;
            color: var(--gold-lt);
        }

        .hero-motto {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.1rem, 2vw, 1.4rem);
            color: rgba(255, 255, 255, .5);
            margin-top: 12px;
            letter-spacing: .04em;
            font-style: italic;
        }

        .hero-desc {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, .72);
            max-width: 560px;
            margin-top: 24px;
            line-height: 1.75;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 40px;
        }

        .hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-top: 64px;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, .1);
        }

        .hero-stat-item {}

        .hero-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--gold-lt);
            line-height: 1;
        }

        .hero-stat-label {
            font-size: .8rem;
            color: rgba(255, 255, 255, .55);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: 6px;
        }

        /* Floating card on hero */
        .hero-float-card {
            position: absolute;
            right: 6%;
            bottom: 12%;
            background: rgba(255, 255, 255, .07);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 16px;
            padding: 20px 26px;
            z-index: 2;
            animation: floatY 4s ease-in-out infinite;
        }

        @keyframes floatY {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .hero-float-card .fc-title {
            font-size: .75rem;
            color: rgba(255, 255, 255, .55);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .hero-float-card .fc-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--gold-lt);
            margin-top: 4px;
        }

        .hero-float-card .fc-sub {
            font-size: .78rem;
            color: rgba(255, 255, 255, .5);
            margin-top: 2px;
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .scroll-indicator span {
            font-size: .7rem;
            color: rgba(255, 255, 255, .4);
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .scroll-mouse {
            width: 22px;
            height: 36px;
            border: 2px solid rgba(255, 255, 255, .25);
            border-radius: 11px;
            position: relative;
        }

        .scroll-mouse::after {
            content: '';
            position: absolute;
            top: 6px;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 6px;
            background: rgba(255, 255, 255, .5);
            border-radius: 2px;
            animation: scrollBounce 1.8s ease-in-out infinite;
        }

        @keyframes scrollBounce {

            0%,
            100% {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }

            80% {
                transform: translateX(-50%) translateY(10px);
                opacity: 0;
            }
        }

        /* ─── Trust Bar ──────────────────────────────────────────────── */
        .trust-bar {
            border-top: 3px solid var(--gold);
        }

        .trust-bar-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 32px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .85rem;
            font-weight: 600;
            color: var(--slate);
        }

        .trust-item i {
            color: var(--emerald);
            font-size: 1.1rem;
        }

        /* ─── About ──────────────────────────────────────────────────── */
.about-section {
    padding: 48px 0 100px;
    background: var(--white);
}

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-visual {
            position: relative;
        }

        .about-main-card {
            background: linear-gradient(135deg, #1a0612 0%, #026837 100%);
            border-radius: 20px;
            padding: 48px 40px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .about-main-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .about-main-card .amc-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, .15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 24px;
        }

        .about-main-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .about-main-card p {
            font-size: .9rem;
            opacity: .85;
            line-height: 1.7;
        }

        .about-accent-card {
            position: absolute;
            bottom: -28px;
            right: -28px;
            background: var(--white);
            border-radius: 16px;
            padding: 22px 26px;
            box-shadow: var(--shadow-md);
            border-left: 4px solid var(--gold);
        }

        .about-accent-card .aac-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--emerald);
        }

        .about-accent-card .aac-label {
            font-size: .78rem;
            color: var(--slate);
            font-weight: 500;
        }

        .about-text {}

        .about-text .section-sub {
            max-width: 100%;
        }

        .about-pillars {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 32px;
        }

        .pillar-card {
            background: var(--mist);
            border-radius: var(--radius);
            padding: 20px;
            border-top: 3px solid var(--emerald);
            transition: var(--transition);
        }

        .pillar-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-sm);
        }

        .pillar-card i {
            font-size: 1.4rem;
            color: var(--emerald);
            margin-bottom: 10px;
        }

        .pillar-card h4 {
            font-size: .9rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .pillar-card p {
            font-size: .8rem;
            color: var(--slate);
            line-height: 1.6;
        }

        /* ─── System Features ────────────────────────────────────────── */
        .features-section {
            padding: 100px 0;
            background: var(--mist);
        }

        .features-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .features-header .section-sub {
            margin: 16px auto 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feat-card {
            background: var(--white);
            border-radius: 18px;
            padding: 36px 28px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-bottom: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .feat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--emerald), var(--gold));
            transform: scaleX(0);
            transform-origin: left;
            transition: var(--transition);
        }

        .feat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .feat-card:hover::after {
            transform: scaleX(1);
        }

        .feat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 22px;
        }

        .feat-icon.green {
            background: rgba(26, 92, 64, .1);
            color: var(--emerald);
        }

        .feat-icon.gold {
            background: rgba(201, 150, 12, .1);
            color: var(--gold);
        }

        .feat-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feat-card p {
            font-size: .88rem;
            color: var(--slate);
            line-height: 1.7;
        }

        .feat-tag {
            display: inline-block;
            margin-top: 16px;
            background: var(--mist);
            color: var(--emerald);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 50px;
        }

        /* ─── Examination Structure ──────────────────────────────────── */
        .levels-section {
            padding: 100px 0;
            background: var(--white);
        }

        .levels-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-top: 56px;
        }

        .level-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .level-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .level-header {
            padding: 40px 36px 32px;
            position: relative;
        }

        .level-header.uce {
            background: linear-gradient(135deg, #1a5c40 0%, #2e8b62 100%);
        }

        .level-header.uace {
            background: linear-gradient(135deg, #0a2e1e 0%, #1a5c40 100%);
        }

        .level-badge {
            display: inline-block;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, .15);
            color: rgba(255, 255, 255, .9);
            padding: 5px 14px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, .2);
            margin-bottom: 16px;
        }

        .level-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--white);
        }

        .level-header .level-sub {
            font-size: 1rem;
            color: rgba(255, 255, 255, .55);
            margin-top: 6px;
        }

        .level-duration {
            position: absolute;
            top: 36px;
            right: 36px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 12px;
            padding: 10px 16px;
            text-align: center;
        }

        .level-duration .dur-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--gold-lt);
            line-height: 1;
        }

        .level-duration .dur-label {
            font-size: .7rem;
            color: rgba(255, 255, 255, .6);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .level-body {
            background: var(--white);
            padding: 32px 36px;
        }

        .level-subjects-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 14px;
        }

        .subject-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .subject-chip {
            background: var(--mist);
            color: var(--slate);
            font-size: .78rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 50px;
            border: 1px solid rgba(0, 0, 0, .06);
        }

        /* ─── How It Works ───────────────────────────────────────────── */
        .how-section {
            padding: 100px 0;
            background: var(--ink);
        }

        .how-header {
            text-align: center;
            margin-bottom: 72px;
        }

        .how-header .section-heading {
            color: var(--white);
        }

        .how-header .section-sub {
            color: rgba(255, 255, 255, .55);
            margin: 16px auto 0;
        }

        .how-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            position: relative;
        }

        .how-steps::before {
            content: '';
            position: absolute;
            top: 36px;
            left: calc(12.5%);
            right: calc(12.5%);
            height: 2px;
            background: linear-gradient(90deg, var(--emerald), var(--gold));
            z-index: 0;
        }

        .how-step {
            text-align: center;
            padding: 0 16px;
            position: relative;
            z-index: 1;
        }

        .step-number {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 800;
            position: relative;
        }

        .step-number.s1 {
            background: var(--emerald);
            color: var(--white);
        }

        .step-number.s2 {
            background: var(--emerald-mid);
            color: var(--white);
        }

        .step-number.s3 {
            background: var(--gold);
            color: var(--ink);
        }

        .step-number.s4 {
            background: var(--gold-lt);
            color: var(--ink);
        }

        .how-step h4 {
            color: var(--white);
            font-size: .95rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .how-step p {
            color: rgba(255, 255, 255, .5);
            font-size: .83rem;
            line-height: 1.65;
        }

        /* ─── Subjects ───────────────────────────────────────────────── */
        .subjects-section {
            padding: 100px 0;
            background: var(--mist);
        }

        .subjects-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .subjects-tabs {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-bottom: 40px;
        }

        .sub-tab {
            padding: 10px 28px;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid rgba(26, 92, 64, .15);
            color: var(--slate);
            background: var(--white);
        }

        .sub-tab.active {
            background: var(--emerald);
            color: var(--white);
            border-color: var(--emerald);
        }

        .subjects-pane {
            display: none;
        }

        .subjects-pane.active {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .subject-card {
            background: var(--white);
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .subject-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .subject-icon {
            flex-shrink: 0;
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(26, 92, 64, .1);
            color: var(--emerald);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .subject-card h4 {
            font-size: .9rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .subject-card p {
            font-size: .8rem;
            color: var(--slate);
            line-height: 1.6;
        }

        /* ─── Stats Banner ───────────────────────────────────────────── */
        .stats-banner {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-mid) 100%);
            padding: 72px 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .stat-block {
            text-align: center;
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 800;
            color: var(--gold-lt);
            line-height: 1;
        }

        .stat-label {
            font-size: .82rem;
            color: rgba(255, 255, 255, .65);
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-top: 10px;
        }

        .stat-divider {
            width: 1px;
            background: rgba(255, 255, 255, .1);
            margin: auto;
        }

        /* ─── FAQ ────────────────────────────────────────────────────── */
        .faq-section {
            padding: 100px 0;
            background: var(--white);
        }

        .faq-layout {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 80px;
            align-items: flex-start;
        }

        .faq-sidebar {
            position: sticky;
            top: 100px;
        }

        .faq-sidebar .section-sub {
            max-width: 100%;
            margin-top: 16px;
        }

        .faq-sidebar-cta {
            margin-top: 36px;
            padding: 28px;
            background: var(--mist);
            border-radius: 16px;
            border-left: 4px solid var(--emerald);
        }

        .faq-sidebar-cta h4 {
            font-size: .95rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .faq-sidebar-cta p {
            font-size: .83rem;
            color: var(--slate);
            margin-bottom: 16px;
        }

        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .faq-item {
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: 14px;
            overflow: hidden;
            transition: var(--transition);
        }

        .faq-item.open {
            border-color: rgba(26, 92, 64, .25);
        }

        .faq-question {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            gap: 16px;
        }

        .faq-question h4 {
            font-size: .92rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .faq-toggle {
            flex-shrink: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--mist);
            color: var(--emerald);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .faq-item.open .faq-toggle {
            background: var(--emerald);
            color: var(--white);
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .4s ease, padding .3s ease;
        }

        .faq-answer-inner {
            padding: 0 24px 20px;
            font-size: .88rem;
            color: var(--slate);
            line-height: 1.75;
        }

        .faq-item.open .faq-answer {
            max-height: 300px;
        }

        /* ─── CTA Section ────────────────────────────────────────────── */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #0a1f15 0%, #1a5c40 100%);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(201, 150, 12, .1) 0%, transparent 65%);
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 680px;
            margin: 0 auto;
        }

        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
        }

        .cta-title em {
            font-style: normal;
            color: var(--gold-lt);
        }

        .cta-sub {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, .65);
            margin-top: 18px;
        }

        .cta-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
            margin-top: 40px;
        }

        /* ─── Footer ─────────────────────────────────────────────────── */
        footer {
            background: var(--ink);
            color: rgba(255, 255, 255, .7);
            padding: 72px 0 0;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 56px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .footer-brand {}

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-logo img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: contain;
            border: 2px solid rgba(255, 255, 255, .15);
        }

        .footer-logo strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--white);
            font-weight: 700;
        }

        .footer-brand p {
            font-size: .86rem;
            line-height: 1.75;
            max-width: 280px;
        }

        .footer-socials {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }

        .footer-socials a {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, .6);
            font-size: .9rem;
            transition: var(--transition);
        }

        .footer-socials a:hover {
            background: var(--emerald);
            color: var(--white);
            border-color: var(--emerald);
        }

        .footer-col h4 {
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--white);
            margin-bottom: 20px;
        }

        .footer-col ul {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-col ul li a {
            font-size: .85rem;
            color: rgba(255, 255, 255, .55);
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: var(--gold-lt);
            padding-left: 4px;
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
        }

        .footer-contact-item i {
            color: var(--gold);
            margin-top: 3px;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .footer-contact-item span {
            font-size: .84rem;
            line-height: 1.5;
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 0;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-bottom p {
            font-size: .8rem;
        }

        .footer-bottom a {
            color: var(--gold-lt);
        }

        /* ─── Back to top ────────────────────────────────────────────── */
        #back-top {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 800;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--emerald);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(26, 92, 64, .4);
            cursor: pointer;
            opacity: 0;
            transform: translateY(16px);
            transition: var(--transition);
            border: none;
        }

        #back-top.visible {
            opacity: 1;
            transform: none;
        }

        #back-top:hover {
            background: var(--emerald-mid);
        }

        /* ─── Responsive ─────────────────────────────────────────────── */
        @media (max-width: 1024px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 48px;
            }

            .about-visual {
                max-width: 520px;
            }

            .features-grid {
                grid-template-columns: 1fr 1fr;
            }

            .how-steps {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }

            .how-steps::before {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .nav-hamburger {
                display: flex;
            }

            .hero-float-card {
                display: none;
            }

            .levels-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .subjects-pane.active {
                grid-template-columns: 1fr;
            }

            .faq-layout {
                grid-template-columns: 1fr;
            }

            .faq-sidebar {
                position: static;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .about-pillars {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats {
                gap: 24px;
            }
        }

        /* ─── Reduced Motion ─────────────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }

        /* ─── Trust Bar ──────────────────────────────────────────────── */
.trust-bar {
    background: var(--white);
    border-top: 3px solid var(--gold);
    padding: 24px 0;
    box-shadow: var(--shadow-sm);
    position: relative;
    z-index: 2;
}

.trust-bar-inner {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: .78rem;
    font-weight: 600;
    color: var(--slate);
    padding: 4px 14px;
    position: relative;
    white-space: nowrap;
    flex: 1 1 0;
    justify-content: center;
}

.trust-item:not(:last-child)::after {
    content: '';
    position: absolute;
    right: -4px;
    top: 50%;
    transform: translateY(-50%);
    width: 1px;
    height: 20px;
    background: rgba(0, 0, 0, .1);
}

.trust-item i {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(2, 104, 55, .08);
    color: var(--emerald);
    font-size: .9rem;
    flex-shrink: 0;
}

@media (max-width: 1100px) {
    .trust-item {
        font-size: .72rem;
        padding: 4px 8px;
        gap: 8px;
    }

    .trust-item i {
        width: 26px;
        height: 26px;
        font-size: .8rem;
    }
}

@media (max-width: 900px) {
    .trust-bar-inner {
        flex-wrap: wrap;
        justify-content: center;
    }

    .trust-item {
        flex: 0 1 auto;
        padding: 8px 16px;
    }

    .trust-item:not(:last-child)::after {
        display: none;
    }
}

@media (max-width: 640px) {
    .trust-bar-inner {
        flex-direction: column;
        align-items: flex-start;
        flex-wrap: nowrap;
        gap: 4px;
    }

    .trust-item {
        width: 100%;
        justify-content: flex-start;
        padding: 10px 4px;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
    }

    .trust-item:last-child {
        border-bottom: none;
    }
}
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════════════════
     NAVIGATION
═══════════════════════════════════════════════════════ -->
    <nav id="navbar">
        <div class="container">
            <div class="nav-inner">
                <a href="{{ route('home.page') }}" class="nav-logo">
                    <img src="{{ $systemSettings->logo_url ?? asset('asset/images/logo.png') }}"
                        alt="{{ $systemSettings->short_name ?? 'Kamssa' }} Logo">
                    <div class="nav-logo-text">
                        <strong>KAMSSA</strong>
                    </div>
                </a>
                <ul class="nav-links">
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#subjects">Subjects</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="{{ route('users.login') }}" class="nav-cta">Portal Login</a></li>
                </ul>
                <div class="nav-hamburger" id="hamburger" aria-label="Open menu">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </nav>

    <div class="mobile-menu" id="mobileMenu">
        <a href="#about">About</a>
        <a href="#features">System Features</a>
        <a href="#subjects">Subjects</a>
        <a href="#faq">FAQ</a>
        <a href="{{ route('users.login') }}">Portal Login →</a>
    </div>


    <!-- ═══════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════ -->
    <section class="hero">
        <div class="hero-bg-pattern"></div>

        <!-- Geometric pattern -->
        <svg class="hero-geo" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <polygon points="200,20 380,110 380,290 200,380 20,290 20,110" stroke="white" stroke-width="1"
                fill="none" />
            <polygon points="200,60 340,130 340,270 200,340 60,270 60,130" stroke="white" stroke-width="1"
                fill="none" />
            <circle cx="200" cy="200" r="120" stroke="white" stroke-width="1" fill="none" />
            <circle cx="200" cy="200" r="80" stroke="white" stroke-width="1" fill="none" />
            <circle cx="200" cy="200" r="40" stroke="white" stroke-width="1" fill="none" />
            <line x1="200" y1="20" x2="200" y2="380" stroke="white" stroke-width="0.5" />
            <line x1="20" y1="200" x2="380" y2="200" stroke="white" stroke-width="0.5" />
            <line x1="62" y1="62" x2="338" y2="338" stroke="white" stroke-width="0.5" />
            <line x1="338" y1="62" x2="62" y2="338" stroke="white" stroke-width="0.5" />
        </svg>

        <div class="container hero-content">
            <div class="hero-badge">
                <i class="fa-solid fa-graduation-cap"></i>
                Official Examination Authority · Uganda
            </div>

            <h1 class="hero-title">
                Elevating Secondary<br>
                Education Across <em>Uganda</em>
            </h1>
            <p class="hero-motto">
                {{ $systemSettings->system_name ?? 'Kampala Integrated Secondary School Examination Bureau' }}</p>
            <p class="hero-desc">
                {{ $systemSettings->short_name ?? 'Kamssa' }} standardizes, administers and certifies
                secondary education at O-LEVEL and A-LEVEL — ensuring every
                candidate is assessed fairly and every graduate is equipped with the results
                they need to progress in their academic journey.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('users.login') }}" class="btn-gold">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    Access the Portal
                </a>
                <a href="#about" class="btn-outline">
                    <i class="fa-solid fa-circle-info"></i>
                    Learn More
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat-item">
                    <div class="hero-stat-num">2</div>
                    <div class="hero-stat-label">Education Levels</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-num">20+</div>
                    <div class="hero-stat-label">Examinable Subjects</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-num">100%</div>
                    <div class="hero-stat-label">Digital Processing</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-num">6yr</div>
                    <div class="hero-stat-label">Complete Programme</div>
                </div>
            </div>
        </div>

        <!-- Floating card -->
        <div class="hero-float-card">
            <div class="fc-title">System Status</div>
            <div class="fc-value"><i class="fa-solid fa-circle"
                    style="color:#4ade80;font-size:.6rem;vertical-align:middle;margin-right:6px;"></i>Live</div>
            <div class="fc-sub">Results processing active</div>
        </div>

        <div class="scroll-indicator">
            <div class="scroll-mouse"></div>
            <span>Scroll</span>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     TRUST BAR
═══════════════════════════════════════════════════════ -->
    <div class="trust-bar">
        <div class="container">
            <div class="trust-bar-inner">
                <div class="trust-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    Secure Data Management
                </div>
                <div class="trust-item">
                    <i class="fa-solid fa-check-double"></i>
                    Automated Mark Validation
                </div>
                <div class="trust-item">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Nationally Recognized Certification
                </div>
                <div class="trust-item">
                    <i class="fa-solid fa-file-signature"></i>
Official Passlips &amp; Transcripts
                </div>
                <div class="trust-item">
                    <i class="fa-solid fa-building-columns"></i>
                    Kampala · Uganda
                </div>
            </div>
        </div>
    </div>


    <!-- ═══════════════════════════════════════════════════════
     ABOUT
═══════════════════════════════════════════════════════ -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="about-grid">

                <div class="about-visual reveal">
                    <div class="about-main-card">
                        <div class="amc-icon">🎓</div>
                        <h3>Rooted in Academic<br>Excellence & Integrity</h3>
                        <p>{{ $systemSettings->short_name ?? 'Kamssa' }} upholds the highest
                            standards in secondary education assessment
                            — from Sciences and Languages to Humanities and Technical subjects — ensuring every
                            candidate is assessed with fairness, accuracy, and academic rigour.</p>
                    </div>
                    <div class="about-accent-card">
                        <div class="aac-num">6</div>
                        <div class="aac-label">Years to<br>Completion</div>
                    </div>
                </div>

                <div class="about-text reveal" style="transition-delay:.15s">
                    <div class="section-label">Who We Are</div>
                    <h2 class="section-heading">A Digital-First <span>Examination Board</span></h2>
                    <p class="section-sub">
                        We combine rigorous academic assessment standards with modern digital examination
                        management — giving schools, administrators, and students a seamless, transparent, and
                        trustworthy results experience.
                    </p>
                    <div class="about-pillars">
                        <div class="pillar-card">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <h4>Transparency</h4>
                            <p>Every mark, grade, and result is traceable and verifiable through our secure portal.</p>
                        </div>
                        <div class="pillar-card">
                            <i class="fa-solid fa-award"></i>
                            <h4>Quality</h4>
                            <p>Multi-level verification by qualified examiners before any result is published.</p>
                        </div>
                        <div class="pillar-card">
                            <i class="fa-solid fa-user-check"></i>
                            <h4>Integrity</h4>
                            <p>Fair, unbiased assessment for every candidate, upheld at every stage of the process.</p>
                        </div>
                        <div class="pillar-card">
                            <i class="fa-solid fa-bolt"></i>
                            <h4>Efficiency</h4>
                            <p>Automated grading algorithms aligned with national standards slash processing time.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     SYSTEM FEATURES
═══════════════════════════════════════════════════════ -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="features-header reveal">
                <div class="section-label">The Platform</div>
                <h2 class="section-heading">Everything You Need, <span>Built In</span></h2>
                <p class="section-sub">
                    The KAMSSA portal covers the complete examination lifecycle — from school registration and student
                    onboarding to automated grading, passlip generation, and recognition certificates.
                </p>
            </div>
            <div class="features-grid">
                <div class="feat-card reveal">
                    <div class="feat-icon green"><i class="fa-solid fa-school"></i></div>
                    <h3>School & Centre Management</h3>
                    <p>Register and manage participating schools (examination centres), assign unique secure passwords,
                        and control
                        each institution's access level to the examination portal.</p>
                    <span class="feat-tag">Administration</span>
                </div>
                <div class="feat-card reveal" style="transition-delay:.08s">
                    <div class="feat-icon gold"><i class="fa-solid fa-users"></i></div>
                    <h3>Candidate Registration</h3>
                    <p>Schools register candidates with full biographical data, class allocations, and examination-year
                        assignments through a structured, validated intake form.</p>
                    <span class="feat-tag">Enrolment</span>
                </div>
                <div class="feat-card reveal" style="transition-delay:.16s">
                    <div class="feat-icon green"><i class="fa-solid fa-pen-to-square"></i></div>
                    <h3>Mark Entry & Validation</h3>
                    <p>Subject-by-subject mark entry with automatic out-of-range detection and mandatory flagging —
                        eliminating data errors before they reach the grading stage.</p>
                    <span class="feat-tag">Examinations</span>
                </div>
                <div class="feat-card reveal" style="transition-delay:.24s">
                    <div class="feat-icon gold"><i class="fa-solid fa-chart-line"></i></div>
                    <h3>Automated Grading Engine</h3>
                    <p>Configurable grading scales for each academic year — the system automatically converts raw scores
                        to letter grades and division/class classifications per KAMSSA standards.</p>
                    <span class="feat-tag">Grading</span>
                </div>
                <div class="feat-card reveal" style="transition-delay:.32s">
                    <div class="feat-icon green"><i class="fa-solid fa-file-lines"></i></div>
                    <h3>Passlips & Transcripts</h3>
                    <p>Generate branded, print-ready passlips and full academic transcripts per candidate — formatted
                        for
                        official use and ready for download instantly.</p>
                    <span class="feat-tag">Documents</span>
                </div>
                <div class="feat-card reveal" style="transition-delay:.4s">
                    <div class="feat-icon gold"><i class="fa-solid fa-certificate"></i></div>
                    <h3>Recognition Certificates</h3>
                    <p>Issue school recognition certificates with a full audit trail — confirming institutional
                        compliance and authorisation to participate in KAMSSA examinations.</p>
                    <span class="feat-tag">Compliance</span>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     EXAMINATION LEVELS
═══════════════════════════════════════════════════════ -->
    <section class="levels-section">
        <div class="container">
            <div class="reveal" style="text-align:center;max-width:600px;margin:0 auto 0;">
                <div class="section-label">Programmes</div>
                <h2 class="section-heading">Two Levels. <span>One Journey.</span></h2>
                <p class="section-sub" style="margin:16px auto 0;">
                    Uganda's secondary education progresses through two clearly defined stages, each with its
                    own curriculum, subjects, and certification pathway.
                </p>
            </div>
            <div class="levels-grid">

                <!-- O-LEVEL -->
                <div class="level-card reveal" style="transition-delay:.1s">
                    <div class="level-header uce">
                        <div class="level-badge">Senior 1 – 4</div>
                        <h3>O-LEVEL</h3>
                        <p class="level-sub">Uganda Certificate of Education</p>
                        <div class="level-duration">
                            <div class="dur-num">4</div>
                            <div class="dur-label">Years</div>
                        </div>
                    </div>
                    <div class="level-body">
                        <div class="level-subjects-label">Core Subjects</div>
                        <div class="subject-chips">
                            <span class="subject-chip">Mathematics</span>
                            <span class="subject-chip">English Language</span>
                            <span class="subject-chip">Biology</span>
                            <span class="subject-chip">Chemistry</span>
                            <span class="subject-chip">Physics</span>
                            <span class="subject-chip">History & Political Education</span>
                            <span class="subject-chip">Geography</span>
                            <span class="subject-chip">Literature in English</span>
                            <span class="subject-chip">Agriculture</span>
                            <span class="subject-chip">Computer Studies</span>
                        </div>
                    </div>
                </div>

                <!-- A-LEVEL -->
                <div class="level-card reveal" style="transition-delay:.2s">
                    <div class="level-header uace">
                        <div class="level-badge">Senior 5 – 6</div>
                        <h3>A-LEVEL</h3>
                        <p class="level-sub">Uganda Advanced Certificate of Education</p>
                        <div class="level-duration">
                            <div class="dur-num">2</div>
                            <div class="dur-label">Years</div>
                        </div>
                    </div>
                    <div class="level-body">
                        <div class="level-subjects-label">Principal & Subsidiary Subjects</div>
                        <div class="subject-chips">
                            <span class="subject-chip">Mathematics</span>
                            <span class="subject-chip">Physics</span>
                            <span class="subject-chip">Chemistry</span>
                            <span class="subject-chip">Biology</span>
                            <span class="subject-chip">Economics</span>
                            <span class="subject-chip">Geography</span>
                            <span class="subject-chip">Literature in English</span>
                            <span class="subject-chip">History</span>
                            <span class="subject-chip">General Paper</span>
                            <span class="subject-chip">Subsidiary ICT</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════════════════ -->
    <section class="how-section">
        <div class="container">
            <div class="how-header reveal">
                <div class="section-label" style="color:var(--gold-lt);justify-content:center;">
                    <span style="background:var(--gold-lt);"></span>
                    How It Works
                    <span style="background:var(--gold-lt);"></span>
                </div>
                <h2 class="section-heading" style="color:var(--white);">From Registration to <span
                        style="color:var(--gold-lt);">Results</span></h2>
                <p class="section-sub" style="color:rgba(255,255,255,.55);margin:16px auto 0;">
                    A streamlined four-stage pipeline that takes each candidate from enrolment to a certified result —
                    entirely managed through the KAMSSA portal.
                </p>
            </div>
            <div class="how-steps">
                <div class="how-step reveal">
                    <div class="step-number s1">01</div>
                    <h4>School Submission</h4>
                    <p>Participating schools submit their candidate data and examination entries through the secure
                        KAMSSA
                        portal with built-in validation.</p>
                </div>
                <div class="how-step reveal" style="transition-delay:.1s">
                    <div class="step-number s2">02</div>
                    <h4>Mark Processing</h4>
                    <p>Marks are entered subject-by-subject. The system instantly flags anomalies and ensures every
                        score falls within the valid range.</p>
                </div>
                <div class="how-step reveal" style="transition-delay:.2s">
                    <div class="step-number s3">03</div>
                    <h4>Automated Grading</h4>
                    <p>The grading engine applies the configured scale to calculate letter grades, aggregate scores, and
                        final division/class classifications.</p>
                </div>
                <div class="how-step reveal" style="transition-delay:.3s">
                    <div class="step-number s4">04</div>
                    <h4>Certification</h4>
                    <p>Approved results trigger instant generation of individual passlips, full transcripts, and
                        official KAMSSA certificates.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     SUBJECTS
═══════════════════════════════════════════════════════ -->
    <section class="subjects-section" id="subjects">
        <div class="container">
            <div class="subjects-header reveal">
                <div class="section-label">Curriculum</div>
                <h2 class="section-heading">Examinable <span>Subjects</span></h2>
            </div>
            <div class="subjects-tabs">
                <button class="sub-tab active" data-pane="uce-pane">O-LEVEL</button>
                <button class="sub-tab" data-pane="uace-pane">A-LEVEL</button>
            </div>

            <div class="subjects-pane active" id="uce-pane">
                <div class="subject-card reveal">
                    <div class="subject-icon"><i class="fa-solid fa-calculator"></i></div>
                    <div>
                        <h4>Mathematics</h4>
                        <p>Covers algebra, geometry, statistics, and problem-solving skills required for the Uganda
                            Certificate of Education.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.06s">
                    <div class="subject-icon"><i class="fa-solid fa-book-open"></i></div>
                    <div>
                        <h4>English Language</h4>
                        <p>Develops reading comprehension, composition, and grammar skills essential for effective
                            communication.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.12s">
                    <div class="subject-icon"><i class="fa-solid fa-flask"></i></div>
                    <div>
                        <h4>Chemistry</h4>
                        <p>Introduces atomic structure, chemical reactions, and laboratory practice through both theory
                            and practical assessment.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.18s">
                    <div class="subject-icon"><i class="fa-solid fa-dna"></i></div>
                    <div>
                        <h4>Biology</h4>
                        <p>Explores living organisms, ecosystems, and human physiology, with an emphasis on practical
                            fieldwork and lab skills.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.24s">
                    <div class="subject-icon"><i class="fa-solid fa-earth-africa"></i></div>
                    <div>
                        <h4>Geography</h4>
                        <p>Covers physical and human geography, map work, and environmental studies relevant to Uganda
                            and the wider region.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.3s">
                    <div class="subject-icon"><i class="fa-solid fa-landmark"></i></div>
                    <div>
                        <h4>History & Political Education</h4>
                        <p>Examines Uganda's and Africa's history alongside civic and political education for informed
                            citizenship.</p>
                    </div>
                </div>
            </div>

            <div class="subjects-pane" id="uace-pane">
                <div class="subject-card reveal">
                    <div class="subject-icon"><i class="fa-solid fa-square-root-variable"></i></div>
                    <div>
                        <h4>Mathematics</h4>
                        <p>Advanced pure and applied mathematics, including calculus, mechanics, and statistics for
                            Principal-level study.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.06s">
                    <div class="subject-icon"><i class="fa-solid fa-atom"></i></div>
                    <div>
                        <h4>Physics</h4>
                        <p>In-depth study of mechanics, electricity, waves, and modern physics with extensive practical
                            experimentation.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.12s">
                    <div class="subject-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <div>
                        <h4>Economics</h4>
                        <p>Covers micro and macroeconomic theory, development economics, and their application to
                            Uganda's economy.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.18s">
                    <div class="subject-icon"><i class="fa-solid fa-feather-pointed"></i></div>
                    <div>
                        <h4>Literature in English</h4>
                        <p>Critical analysis of prose, poetry, and drama, developing advanced interpretive and
                            essay-writing skills.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.24s">
                    <div class="subject-icon"><i class="fa-solid fa-newspaper"></i></div>
                    <div>
                        <h4>General Paper</h4>
                        <p>A compulsory subsidiary subject testing general knowledge, current affairs, and
                            argumentative writing skills.</p>
                    </div>
                </div>
                <div class="subject-card reveal" style="transition-delay:.3s">
                    <div class="subject-icon"><i class="fa-solid fa-laptop-code"></i></div>
                    <div>
                        <h4>Subsidiary ICT</h4>
                        <p>Builds practical computing literacy and digital skills alongside principal subjects at
                            A-LEVEL.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     STATS BANNER
═══════════════════════════════════════════════════════ -->
    <div class="stats-banner">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-block reveal">
                    <div class="stat-num">4+</div>
                    <div class="stat-label">O-LEVEL Years</div>
                </div>
                <div class="stat-block reveal" style="transition-delay:.1s">
                    <div class="stat-num">20+</div>
                    <div class="stat-label">Taught Subjects</div>
                </div>
                <div class="stat-block reveal" style="transition-delay:.2s">
                    <div class="stat-num">100%</div>
                    <div class="stat-label">Digital Records</div>
                </div>
                <div class="stat-block reveal" style="transition-delay:.3s">
                    <div class="stat-num">A-Z</div>
                    <div class="stat-label">University Pathway</div>
                </div>
            </div>
        </div>
    </div>


    <!-- ═══════════════════════════════════════════════════════
     FAQ
═══════════════════════════════════════════════════════ -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div class="faq-layout">

                <div class="faq-sidebar reveal">
                    <div class="section-label">Common Questions</div>
                    <h2 class="section-heading">Got <span>Questions?</span></h2>
                    <p class="section-sub">
                        Everything you need to know about the O-LEVEL and A-LEVEL examination system and the KAMSSA
                        portal.
                    </p>
                    <div class="faq-sidebar-cta">
                        <h4>Can't find your answer?</h4>
                        <p>Reach out to the KAMSSA team directly — we're happy to help.</p>
                        <a href="mailto:info@kamssa.ug" class="btn-primary" style="font-size:.85rem;padding:11px 24px;">
                            <i class="fa-solid fa-envelope"></i> Email Us
                        </a>
                    </div>
                </div>

                <div class="faq-list reveal" style="transition-delay:.15s">

                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>What is the O-LEVEL and A-LEVEL system?</h4>
                            <div class="faq-toggle"><i class="fa-solid fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Uganda's structured secondary education framework. O-LEVEL (Senior 1–4) builds
                                foundational knowledge across sciences, languages, and humanities. A-LEVEL (Senior 5–6)
                                is a two-year advanced programme for deeper specialisation ahead of university.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>How long does each level take to complete?</h4>
                            <div class="faq-toggle"><i class="fa-solid fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                O-LEVEL spans four years (Senior 1 to Senior 4), while A-LEVEL requires two years
                                (Senior 5 to Senior 6). Candidates typically begin O-LEVEL after completing primary
                                education and progress systematically through the curriculum.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>What subjects are taught at O-LEVEL?</h4>
                            <div class="faq-toggle"><i class="fa-solid fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                O-LEVEL candidates study Mathematics, English Language, Biology, Chemistry, Physics,
                                History and Political Education, Geography, Literature in English, Agriculture, and
                                Computer Studies, among others.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>What makes A-LEVEL different?</h4>
                            <div class="faq-toggle"><i class="fa-solid fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                A-LEVEL offers advanced specialisation through three Principal subjects chosen from
                                combinations such as Mathematics, Physics, Chemistry, Biology, Economics, Geography,
                                History and Literature — plus a compulsory General Paper and a subsidiary subject.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Are graduates qualified for university admission?</h4>
                            <div class="faq-toggle"><i class="fa-solid fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Yes. Successful A-LEVEL candidates who meet the required point score are eligible for
                                admission to universities and tertiary institutions, where they can pursue diploma,
                                bachelor's, and postgraduate programmes across all fields.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>How does the KAMSSA portal handle grading?</h4>
                            <div class="faq-toggle"><i class="fa-solid fa-plus"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                The portal uses a configurable grading engine aligned with national standards.
                                Administrators set the grading scale per academic year, and the system automatically
                                converts raw marks into letter grades, aggregate scores, and division/class
                                classifications.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════ -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content reveal">
                <div class="section-label" style="color:var(--gold-lt);justify-content:center;">
                    <span style="background:var(--gold-lt);"></span>
                    Get Started
                    <span style="background:var(--gold-lt);"></span>
                </div>
                <h2 class="cta-title">
                    Ready to Access the <em>KAMSSA Portal?</em>
                </h2>
                <p class="cta-sub">
                    Schools, administrators, and authorised examiners can log in to the portal to manage registrations,
                    enter marks, and generate results.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('users.login') }}" class="btn-gold">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Login to the Portal
                    </a>
                    <a href="mailto:info@kamssa.ug" class="btn-outline">
                        <i class="fa-solid fa-envelope"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════ -->
    <footer>
        <div class="container">
            <div class="footer-grid">

                <div class="footer-brand">
                    <div class="footer-logo">
                        <img src="{{ $systemSettings->logo_url ?? asset('asset/images/logo.png') }}"
                            alt="{{ $systemSettings->short_name ?? 'Kamssa' }} Logo">
                        <strong>{{ $systemSettings->system_name ?? 'Kampala Integrated Secondary School Examination Bureau' }}</strong>
                    </div>
                    <p>The examination authority responsible for standardising, administering, and certifying
                        O-LEVEL and A-LEVEL secondary education in Uganda.</p>
                    <div class="footer-socials">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="{{ route('home.page') }}">Home</a></li>
                        <li><a href="#about">About KAMSSA</a></li>
                        <li><a href="#features">System Features</a></li>
                        <li><a href="#subjects">Subjects</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Portal</h4>
                    <ul>
                        <li><a href="{{ route('users.login') }}">Admin Login</a></li>
                        <li><a href="{{ route('users.login') }}">School Login</a></li>
                        <li><a href="{{ route('users.login') }}">Check Results</a></li>
                        <li><a href="{{ route('coming.soon') }}">Techsate.com</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Contact</h4>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>+256 702 595 554</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span><a href="mailto:info@kamssa.ug" style="color:var(--gold-lt);">info@kamssa.ug</a></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Kampala – Kawempe, Uganda</span>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <p>© <span id="footer-year"></span>
                    {{ $systemSettings->system_name ?? 'Kampala Integrated Secondary School Examination Bureau' }}.
                    All rights reserved.</p>
                <p>Designed & developed by <a href="{{ route('coming.soon') }}">Techsate.com</a></p>
            </div>
        </div>
    </footer>


    <!-- Back to top -->
    <button id="back-top" aria-label="Back to top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>


    <!-- ═══════════════════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════════════════ -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ── Year ── */
            document.getElementById('footer-year').textContent = new Date().getFullYear();

            /* ── Navbar scroll ── */
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                navbar.classList.toggle('scrolled', window.scrollY > 40);
                document.getElementById('back-top').classList.toggle('visible', window.scrollY > 300);
            }, { passive: true });

            /* ── Back to top ── */
            document.getElementById('back-top').addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            /* ── Mobile menu ── */
            const hamburger = document.getElementById('hamburger');
            const mobileMenu = document.getElementById('mobileMenu');
            hamburger.addEventListener('click', () => {
                mobileMenu.classList.toggle('open');
            });
            mobileMenu.querySelectorAll('a').forEach(a => {
                a.addEventListener('click', () => mobileMenu.classList.remove('open'));
            });

            /* ── Smooth scroll for anchor links ── */
            document.querySelectorAll('a[href^="#"]').forEach(a => {
                a.addEventListener('click', e => {
                    const target = document.querySelector(a.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            /* ── Reveal on scroll ── */
            const reveals = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            reveals.forEach(el => observer.observe(el));

            /* ── Subject tabs ── */
            document.querySelectorAll('.sub-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    document.querySelectorAll('.sub-tab').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.subjects-pane').forEach(p => p.classList.remove('active'));
                    tab.classList.add('active');
                    document.getElementById(tab.dataset.pane).classList.add('active');
                });
            });

            /* ── FAQ accordion ── */
            document.querySelectorAll('.faq-question').forEach(question => {
                question.addEventListener('click', () => {
                    const item = question.closest('.faq-item');
                    const isOpen = item.classList.contains('open');
                    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
                    if (!isOpen) item.classList.add('open');
                });
            });

        });
    </script>
</body>

</html>