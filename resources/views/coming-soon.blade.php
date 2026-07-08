<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSate Technologies · coming soon</title>
    <!-- Font Awesome 6 (free) for subtle icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(145deg, #0b0f1c 0%, #1a1f33 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: #eef2ff;
        }

        .glass-card {
            background: rgba(18, 22, 40, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(90, 120, 255, 0.25);
            border-radius: 3rem;
            padding: 3.5rem 2.5rem;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 30px 60px -10px rgba(0, 20, 80, 0.5), 0 0 0 1px rgba(160, 190, 255, 0.1) inset;
            transition: transform 0.3s ease;
        }

        .glass-card:hover {
            transform: scale(1.01);
            box-shadow: 0 35px 70px -8px #0f1a3a;
        }

        /* tech grid background (very subtle) */
        .grid-pattern {
            position: relative;
        }

        .grid-pattern::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(100, 150, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(100, 150, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            border-radius: 3rem;
        }

        .logo-badge {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1.2rem;
        }

        .company {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .icon-box {
            background: rgba(0, 230, 255, 0.1);
            border: 1.5px solid #4e7aff;
            border-radius: 18px;
            padding: 0.7rem 1rem;
            font-size: 1.7rem;
            color: #a6c1ff;
            box-shadow: 0 8px 16px -6px #0028aa30;
        }

        .company-name {
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: -0.02em;
            background: linear-gradient(120deg, #ffffff, #bdd3ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .company-tag {
            font-size: 1rem;
            font-weight: 400;
            color: #9bb2ff;
            margin-top: 4px;
            letter-spacing: 0.3px;
        }

        .status-pill {
            background: rgba(20, 40, 70, 0.7);
            border-radius: 60px;
            padding: 0.6rem 1.6rem;
            border: 1px solid #3f5bb5;
            font-size: 0.95rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ccdcff;
            backdrop-filter: blur(4px);
        }

        .status-pill i {
            color: #4ef97d;
            font-size: 0.7rem;
        }

        .main-message {
            margin: 2.8rem 0 3rem 0;
        }

        .coming-soon {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #b1cbff 80%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.2rem;
            text-shadow: 0 2px 15px rgba(0, 120, 255, 0.3);
        }

        .description {
            font-size: 1.3rem;
            color: #cfddff;
            max-width: 550px;
            font-weight: 400;
            line-height: 1.5;
            border-left: 4px solid #3d7eff;
            padding-left: 1.8rem;
            margin-top: 0.5rem;
        }

        .phone-block {
            background: rgba(10, 18, 40, 0.7);
            border-radius: 100px;
            padding: 1.1rem 2.2rem;
            display: inline-flex;
            align-items: center;
            gap: 1.2rem;
            border: 1px solid rgba(90, 140, 255, 0.5);
            backdrop-filter: blur(4px);
            margin: 1.5rem 0 2rem 0;
            box-shadow: 0 10px 20px -10px #001c4b;
        }

        .phone-block i {
            font-size: 2rem;
            color: #6e9eff;
            background: rgba(0, 40, 100, 0.6);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 60px;
            border: 1px solid #3f71d0;
        }

        .phone-number {
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: white;
            text-decoration: none;
            transition: all 0.2s;
            background: linear-gradient(145deg, #fff, #d3e2ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .phone-number:hover {
            text-shadow: 0 0 12px #80b3ff;
        }

        .hint {
            color: #9fb0e0;
            font-size: 1rem;
            margin-left: 0.5rem;
            border-bottom: 1px dashed #526db9;
            cursor: help;
        }

        .footer-links {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 2.5rem;
            border-top: 1px solid rgba(110, 150, 255, 0.2);
            padding-top: 2rem;
            font-size: 1rem;
            color: #9eb3ee;
        }

        .footer-links a {
            color: #b7cdff;
            text-decoration: none;
            margin-right: 2rem;
            transition: 0.2s;
            border-bottom: 1px solid transparent;
        }

        .footer-links a:hover {
            color: white;
            border-bottom-color: #5f91ff;
        }

        .small-note {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .live-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 255, 100, 0.08);
            padding: 0.3rem 1rem;
            border-radius: 40px;
            border: 1px solid #29cc6a30;
        }

        .live-dot {
            width: 10px;
            height: 10px;
            background: #34e06d;
            border-radius: 50%;
            box-shadow: 0 0 12px #00f56b;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(1.2);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* responsiveness */
        @media (max-width: 550px) {
            .glass-card {
                padding: 2.2rem 1.5rem;
                border-radius: 2rem;
            }

            .coming-soon {
                font-size: 3rem;
            }

            .phone-number {
                font-size: 1.7rem;
            }

            .company-name {
                font-size: 1.5rem;
            }

            .icon-box {
                font-size: 1.4rem;
                padding: 0.5rem 0.8rem;
            }

            .phone-block {
                padding: 0.8rem 1.5rem;
            }
        }

        @media (max-width: 380px) {
            .phone-number {
                font-size: 1.4rem;
            }

            .phone-block i {
                width: 38px;
                height: 38px;
                font-size: 1.5rem;
            }
        }

        .built-badge {
            font-size: 0.8rem;
            opacity: 0.6;
            margin-top: 0.5rem;
            text-align: right;
        }
    </style>
</head>

<body class="grid-pattern">
    <div class="glass-card">
        <!-- top row: company + status -->
        <div class="logo-badge">
            <div class="company">
                <div class="icon-box">
                    <i class="fas fa-microchip"></i>
                </div>
                <div>
                    <div class="company-name">TechSate Technologies</div>
                    <div class="company-tag">
                        <i class="far fa-copyright" style="font-size: 0.7rem;"></i>
                        Precision. Innovation. Impact.
                    </div>
                </div>
            </div>
            <div class="status-pill">
                <i class="fas fa-circle"></i> Nationwide Innovations.
            </div>
        </div>

        <!-- main coming soon content -->
        <div class="main-message">
            <div class="coming-soon">
                COMING <br> SOON
            </div>
            <div class="description">
                We’re preparing to unveil our new digital headquarters. <br> <span style="color:#aac3ff;">Reach out to
                    us via a phone call.</span>
            </div>
        </div>

        <!-- phone area (prominent, exactly as requested) -->
        <div class="phone-block">
            <i class="fas fa-phone-alt"></i>
            <span>
                <span class="phone-number">0702 082 209</span>
                <span class="hint" title="Direct line to TechSate Technologies"></span>
            </span>
        </div>

        <!-- additional info + live indicator -->
        <div class="footer-links">
            <div class="small-note">
                <i class="far fa-clock" style="color: #5e8bff;"></i>
                <span>Go‑live on <strong> <span id="countdown-tomorrow">tomorrow 09:00 UTC</span></strong></span>
                <span class="live-indicator">
                    <span class="live-dot"></span> ready
                </span>
            </div>
            <div>
                <a href="#"><i class="far fa-envelope"></i> info@techsatetech.com</a>
                <!-- fake subtle link just for aesthetics -->
            </div>
        </div>

        <!-- discreet copyright with phone repeat (only for safe keeping) -->
        <div class="built-badge">
            <i class="fas fa-cog"></i> TechSate Technologies · 0702 082 209
        </div>
    </div>

    <!-- tiny script to make the countdown show tomorrow's date dynamically, but keep text simple -->
    <script>
        (function () {
            // optional: just to display a realistic 'tomorrow' date (user friendly)
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 4);
            const options = { weekday: 'long', month: 'short', day: 'numeric' };
            const dateStr = tomorrow.toLocaleDateString('en-US', options);
            const countdownElem = document.getElementById('countdown-tomorrow');
            if (countdownElem) {
                countdownElem.innerText = dateStr + ' · 09:00 UTC';
            }
        })();
    </script>
    <!-- ensure that even without script, placeholder says 'tomorrow' (already in html) -->
</body>

</html>