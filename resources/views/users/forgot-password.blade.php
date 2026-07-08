<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Uganda Examination Grading System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #026837;
            --primary-light: #1E7A3D;
            --secondary: #F2A900;
            --accent: #1A73E8;
            --dark: #0C2915;
            --light: #F8FCF9;
            --gray: #5F6C72;
            --gray-light: #E8F0E9;
            --white: #FFFFFF;
            --success: #28A745;
            --warning: #FFC107;
            --danger: #DC3545;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --radius-lg: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.7;
            font-weight: 400;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Header */
        header {
            background-color: var(--white);
            padding: 1.6rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            position: relative;
            z-index: 100;
        }

        .header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
        }

        .logo-icon {
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-icon {
            transform: rotate(-10deg);
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
        }

        .logo-text p {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 500;
        }

        .nav-menu {
            display: flex;
            gap: 3.5rem;
            margin-left: auto;
            margin-right: 2rem;
        }

        .nav-link {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            position: relative;
            padding: 0.5rem 0;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 75, 30, 0.15);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary-light);
        }

        .btn-outline:hover {
            background-color: rgba(13, 75, 30, 0.05);
            transform: translateY(-2px);
        }

        /* Main Content */
        .forgot-password-wrapper {
            flex: 1;
            display: flex;
            min-height: calc(100vh - 96px);
        }

        /* Left Panel - Graphic */
        .graphic-panel {
            flex: 1;
            background: linear-gradient(135deg, rgba(13, 75, 30, 0.95), rgba(30, 122, 61, 0.85)),
                url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .graphic-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .graphic-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            max-width: 500px;
        }

        .graphic-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .graphic-icon i {
            font-size: 3.5rem;
            color: var(--white);
        }

        .graphic-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .graphic-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 2rem;
        }

        /* Right Panel - Form */
        .form-panel {
            flex: 1;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .form-container {
            max-width: 450px;
            width: 100%;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-header h1 {
            font-size: 2.2rem;
            color: var(--dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .form-header p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .form-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(13, 75, 30, 0.1);
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 1.2rem;
        }

        .input-with-icon .form-control {
            padding-left: 3.5rem;
        }

        .alert {
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-left: 4px solid var(--danger);
            color: var(--danger);
        }

        .alert-icon {
            font-size: 1.25rem;
            margin-top: 0.1rem;
        }

        .btn-block {
            width: 100%;
            padding: 1.1rem;
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 1rem;
        }

        .btn-block:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .form-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-light);
        }

        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: var(--primary-light);
        }

        .security-info {
            background: rgba(13, 75, 30, 0.05);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-top: 2rem;
            border-left: 4px solid var(--primary);
        }

        .security-info h4 {
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-info p {
            color: var(--gray);
            font-size: 0.9rem;
            margin: 0;
        }

        /* Loading Animation */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--white);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .forgot-password-wrapper {
                flex-direction: column;
            }

            .graphic-panel {
                min-height: 300px;
            }

            .form-panel {
                min-height: auto;
            }
        }

        @media (max-width: 768px) {
            .header-wrapper {
                flex-direction: column;
                gap: 1.5rem;
            }

            .nav-menu {
                margin: 0;
                gap: 2rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .graphic-content h1 {
                font-size: 2rem;
            }

            .form-card {
                padding: 2rem;
            }

            .form-header h1 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            .graphic-panel {
                padding: 2rem;
            }

            .graphic-content h1 {
                font-size: 1.8rem;
            }

            .graphic-icon {
                width: 100px;
                height: 100px;
            }

            .graphic-icon i {
                font-size: 2.5rem;
            }

            .form-panel {
                padding: 2rem;
            }

            .form-card {
                padding: 1.5rem;
            }
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 2rem 0;
            margin-top: auto;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container header-wrapper">
            <a href="{{ url('/') }}" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-university"></i>
                </div>
                <div class="logo-text">
                    <h1>Uganda Grading System</h1>
                    <p>Student Results Portal</p>
                </div>
            </a>

            <nav class="nav-menu">
                <a href="{{ url('/') }}" class="nav-link"><i class="fas fa-home"></i> Home</a>
                <a href="{{ url('/portal') }}" class="nav-link"><i class="fas fa-search"></i> Check Results</a>
                <a href="{{ url('/help') }}" class="nav-link"><i class="fas fa-question-circle"></i> Help</a>
                <a href="{{ url('/contact') }}" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
            </nav>

            <a href="{{ url('users/login') }}" class="btn btn-outline">
                <i class="fas fa-sign-in-alt"></i> Back to Login
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="forgot-password-wrapper">
        <!-- Left Panel: Graphic -->
        <div class="graphic-panel">
            <div class="graphic-content">
                <div class="graphic-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h1>Account Recovery</h1>
                <p>Secure password reset process for Uganda Examination System users. Your academic data is protected
                    with bank-level security.</p>

                <div class="security-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>SSL Encrypted Connection</span>
                </div>
            </div>
        </div>

        <!-- Right Panel: Form -->
        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <h1>Reset Password</h1>
                    <p>Enter your registered email to receive  a <br>password reset link</p>
                </div>

                <div class="form-card">
                    <!-- Success Message -->
                    <div class="alert alert-success" id="successMessage" style="display: none;">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <div>
                            <strong>Success!</strong> Password reset link has been sent to your email.
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div class="alert alert-danger" id="errorMessage" style="display: none;">
                        <i class="fas fa-exclamation-circle alert-icon"></i>
                        <div id="errorText"></div>
                    </div>

                    <form id="forgotPasswordForm">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="email">
                                <i class="fas fa-envelope"></i> Email Address *
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Enter your registered email address" required autocomplete="email">
                            </div>
                        </div>

                        <div class="security-info">
                            <h4><i class="fas fa-info-circle"></i> Security Information</h4>
                            <p>The reset link will expire in 24 hours. If you don't see the email, check your spam
                                folder.</p>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                            <i class="fas fa-paper-plane"></i> Send Reset Link
                        </button>
                    </form>

                    <div class="form-footer">
                        <a href="{{ url('users/login') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i> Back to Login
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-bottom">
                <p>
                    &copy; <span id="year"></span> Uganda Examination Grading System.
                    All rights reserved. | Ministry of Education and Sports
                </p>
            </div>
        </div>
    </footer>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Set current year in footer
        document.getElementById('year').textContent = new Date().getFullYear();

        // Form submission handler
        document.getElementById('forgotPasswordForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const submitBtn = document.getElementById('submitBtn');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            // Reset messages
            successMessage.style.display = 'none';
            errorMessage.style.display = 'none';

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showError('Please enter a valid email address.');
                return;
            }

            // Show confirmation dialog
            const result = await Swal.fire({
                title: 'Confirm Password Reset',
                html: `We will send a password reset link to:<br><strong>${email}</strong>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#026837',
                cancelButtonColor: '#5F6C72',
                confirmButtonText: 'Yes, send reset link',
                cancelButtonText: 'Cancel',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });

            if (result.isConfirmed) {
                // Disable button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<div class="spinner"></div> Sending...';

                // Simulate API call (replace with actual AJAX call)
                setTimeout(() => {
                    // For demo purposes - show success
                    successMessage.style.display = 'flex';

                    // Reset form
                    document.getElementById('forgotPasswordForm').reset();

                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Reset Link';

                    // Show success toast
                    Swal.fire({
                        title: 'Link Sent!',
                        text: 'Password reset link has been sent to your email.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });

                }, 1500);
            }
        });

        // Show error message
        function showError(message) {
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');

            errorText.textContent = message;
            errorMessage.style.display = 'flex';

            // Scroll to error
            errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Enter key support
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const form = document.getElementById('forgotPasswordForm');
                const submitBtn = document.getElementById('submitBtn');

                if (!submitBtn.disabled) {
                    form.dispatchEvent(new Event('submit'));
                }
            }
        });

        // Email input validation
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('input', function () {
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage.style.display === 'flex') {
                errorMessage.style.display = 'none';
            }
        });

        // Add CSS animation library
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css';
        document.head.appendChild(link);
    </script>
</body>

</html>