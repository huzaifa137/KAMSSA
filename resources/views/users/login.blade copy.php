<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Uganda National Grading System</title>
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
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.08);
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            max-width: 1300px;
            width: 100%;
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            min-height: 750px;
        }

        /* Left Panel - Premium Government Design */
        .login-brand {
            background: linear-gradient(135deg, #081C0E 0%, var(--dark) 50%, #14301D 100%);
            padding: 4rem 3.5rem;
            color: var(--white);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 15% 15%, rgba(242, 169, 0, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 85% 85%, rgba(30, 122, 61, 0.1) 0%, transparent 50%),
                linear-gradient(45deg, transparent 48%, rgba(255, 255, 255, 0.02) 48%, rgba(255, 255, 255, 0.02) 52%, transparent 52%),
                linear-gradient(-45deg, transparent 48%, rgba(255, 255, 255, 0.02) 48%, rgba(255, 255, 255, 0.02) 52%, transparent 52%);
            background-size: 100% 100%, 100% 100%, 60px 60px, 60px 60px;
        }

        .government-header {
            position: relative;
            z-index: 2;
            margin-bottom: 4rem;
        }

        .official-badge {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            padding: 0.8rem 1.5rem;
            width: fit-content;
            margin-bottom: 2.5rem;
        }

        .badge-icon {
            color: var(--secondary);
            font-size: 1.2rem;
        }

        .badge-text {
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .portal-logo {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 3rem;
        }

        .portal-emblem {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--white), #f5f5f5);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .portal-emblem::before {
            content: '';
            position: absolute;
            inset: 4px;
            border: 2px solid var(--primary);
            border-radius: 16px;
            opacity: 0.7;
        }

        .portal-emblem i {
            font-size: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .portal-title h1 {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }

        .portal-title p {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .welcome-message {
            position: relative;
            z-index: 2;
            margin-bottom: 4rem;
        }

        .welcome-message h2 {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--white), #FFE8A3);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            max-width: 500px;
        }

        .welcome-message p {
            font-size: 1.15rem;
            opacity: 0.9;
            line-height: 1.7;
            max-width: 500px;
        }

        .portal-features {
            position: relative;
            z-index: 2;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-3px);
        }

        .feature-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 1rem;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--secondary), #FFD166);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            font-size: 20px;
            flex-shrink: 0;
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .feature-description {
            font-size: 0.95rem;
            opacity: 0.8;
            line-height: 1.6;
        }

        .government-footer {
            position: absolute;
            bottom: 3rem;
            left: 3.5rem;
            right: 3.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .trust-badge i {
            color: var(--secondary);
            font-size: 1.1rem;
        }

        .copyright {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Right Panel - Login Form */
        .login-form-container {
            padding: 5rem 4rem;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f5f9f7 0%, var(--light) 100%);
            position: relative;
        }

        .login-form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--secondary), var(--accent));
        }

        .form-header {
            margin-bottom: 3.5rem;
        }

        .form-header h2 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 0.8rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .form-header p {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 400px;
        }

        .user-role-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .role-btn {
            flex: 1;
            padding: 1.2rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            background: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: var(--dark);
        }

        .role-btn.active {
            border-color: var(--primary);
            background: rgba(13, 75, 30, 0.05);
            color: var(--primary);
            box-shadow: 0 4px 12px rgba(13, 75, 30, 0.1);
        }

        .role-btn:hover:not(.active) {
            border-color: var(--primary-light);
        }

        .role-icon {
            font-size: 1.4rem;
        }

        .login-form {
            flex: 1;
        }

        .form-group {
            margin-bottom: 2.2rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.8rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 1rem;
        }

        .input-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1.1rem 1rem 1.1rem 3.5rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--white);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13, 75, 30, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 1.2rem;
        }

        .password-toggle {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 1.2rem;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remember-me input {
            width: 20px;
            height: 20px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-me label {
            font-size: 0.95rem;
            color: var(--gray);
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            padding: 1.2rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 1.05rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(13, 75, 30, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 75, 30, 0.3);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary-light);
        }

        .btn-secondary:hover {
            background-color: rgba(13, 75, 30, 0.05);
            transform: translateY(-2px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 3rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gray-light), transparent);
        }

        .divider span {
            padding: 0 1.5rem;
            color: var(--gray);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .single-sign-on {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 2.5rem;
        }

        .sso-btn {
            flex: 1;
            padding: 1rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: var(--dark);
        }

        .sso-btn:hover {
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .form-footer {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-light);
            color: var(--gray);
            font-size: 0.95rem;
        }

        .form-footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }

        .footer-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .login-container {
                max-width: 500px;
                grid-template-columns: 1fr;
            }

            .login-brand {
                display: none;
            }

            .login-form-container {
                padding: 3rem 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .user-role-selector {
                flex-direction: column;
            }

            .single-sign-on {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .login-form-container {
                padding: 2.5rem 2rem;
            }

            .form-header h2 {
                font-size: 2rem;
            }

            .form-footer-links {
                flex-direction: column;
                gap: 1rem;
            }
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 3rem 0;
            height: 3px;
            background: linear-gradient(90deg,
                    transparent 0%,
                    var(--primary-light) 25%,
                    var(--secondary) 50%,
                    var(--primary-light) 75%,
                    transparent 100%);
            border-radius: 3px;
            position: relative;
            overflow: visible;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background: var(--secondary);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .divider::before {
            left: 30%;
        }

        .divider::after {
            right: 30%;
        }

        .error-text {
            color: #e3342f;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        button:disabled {
            opacity: 0.75;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Panel - Premium Government Design -->
        <div class="login-brand">
            <div class="government-header">
                <div class="official-badge">
                    <i class="fas fa-certificate badge-icon"></i>
                    <span class="badge-text">OFFICIAL GOVERNMENT PORTAL</span>
                </div>

                <div class="portal-logo">
                    <div class="portal-emblem">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="portal-title">
                        <h1>Uganda National Grading System</h1>
                        <p>Ministry of Education & Sports</p>
                    </div>
                </div>
            </div>

            <div class="welcome-message">
                <h2>Secure Access to National Examination Data</h2>
                <p>Login to the official government platform for standardized grading of Idaad and Thanawi examination
                    results across Uganda.</p>
            </div>

            <div class="portal-features">
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">
                            <i class="fas fa-shield"></i>
                        </div>
                        <div class="feature-title">Government-Grade Security</div>
                    </div>
                    <div class="feature-description">
                        Multi-layer encryption, biometric verification, and blockchain-secured data storage ensure
                        maximum security for sensitive examination data.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-title">Real-Time Analytics</div>
                    </div>
                    <div class="feature-description">
                        Advanced analytics dashboard with predictive insights and comprehensive reporting for
                        educational planning and policy development.
                    </div>
                </div>
            </div>

            <div class="government-footer">
                <div class="trust-badge">
                    <i class="fas fa-lock"></i>
                    <span>ISO 27001 Certified • GDPR Compliant</span>
                </div>
                <div class="copyright">
                    © <span id="year"></span> Ministry of Education & Sports
                </div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="login-form-container">
            <div class="form-header">
                <h2>Secure Portal Login</h2>
                <p>Select your role and enter your credentials</p>
            </div>

            <div class="user-role-selector">
                <button class="role-btn active" data-role="student">
                    <i class="fas fa-user-graduate role-icon"></i>
                    <span>Student</span>
                </button>
                <button class="role-btn" data-role="teacher">
                    <i class="fas fa-chalkboard-teacher role-icon"></i>
                    <span>Teacher</span>
                </button>
                <button class="role-btn" data-role="admin">
                    <i class="fas fa-user-cog role-icon"></i>
                    <span>Administrator</span>
                </button>
            </div>

            <form class="login-form" id="loginForm" action="{{ route('auth-user-check') }}" method="POST">
                @csrf

                <input type="hidden" name="role" id="login_role" value="student">

                <div class="form-group">
                    <label for="username" class="form-label">User ID / Registration Number</label>
                    <div class="input-group">
                        <i class="fas fa-id-card input-icon"></i>
                        <input type="text" id="username" name="username" class="form-input"
                            placeholder="Enter your user ID or registration number">
                    </div>
                    <small class="error-text" id="username-error"></small>
                </div>


                <div class="form-group">
                    <label for="password" class="form-label">Secure Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter your secure password">
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <small class="error-text" id="password-error"></small>
                </div>

                <div class="form-options">
                    <div class="remember-me"> <input type="checkbox" name="remember" id="remember" value="1">
                        <label for="remember">Remember this device</label>
                    </div>
                    <a href="{{ url('/users/forgot-password') }}" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary" id="loginBtn">
                    <i class="fas fa-shield-alt"></i> Authenticate & Continue
                </button>

                <div class="divider"></div>

                <a href="{{url('/')}}" class="btn btn-secondary" style="text-decoration: none;">
                    <i class="fas fa-home"></i> Back to Homepage
                </a>

            </form>
        </div>
    </div>

    <script>
        // Role selection functionality
        document.addEventListener('DOMContentLoaded', function () {
            const roleButtons = document.querySelectorAll('.role-btn');

            // Set initial active state
            let activeRole = 'student';
            const roleInput = document.getElementById('login_role');

            roleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const selectedRole = this.getAttribute('data-role');

                    roleButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    activeRole = selectedRole;
                    roleInput.value = selectedRole; // 🔥 THIS IS KEY

                    updateFormForRole(selectedRole);
                });
            });

            // Function to update form based on selected role
            function updateFormForRole(role) {
                const usernameLabel = document.querySelector('label[for="username"]');
                const usernameInput = document.getElementById('username');
                const passwordLabel = document.querySelector('label[for="password"]');

                switch (role) {
                    case 'student':
                        usernameLabel.textContent = 'Registration Number';
                        usernameInput.placeholder = 'Enter your student registration number';
                        passwordLabel.textContent = 'Student Password';
                        break;
                    case 'teacher':
                        usernameLabel.textContent = 'Teacher ID / Email';
                        usernameInput.placeholder = 'Enter your teacher identification number';
                        passwordLabel.textContent = 'Teacher Password';
                        break;
                    case 'admin':
                        usernameLabel.textContent = 'Administrator ID / Email';
                        usernameInput.placeholder = 'Enter your administrator credentials';
                        passwordLabel.textContent = 'Admin Password';
                        break;
                }
            }

            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle eye icon
                    const eyeIcon = this.querySelector('i');
                    if (type === 'text') {
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                    } else {
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                    }
                });
            }
            updateFormForRole(activeRole);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');

            // Store original button HTML
            const originalBtnHtml = loginBtn.innerHTML;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Clear previous errors
                document.querySelectorAll('.error-text').forEach(el => el.textContent = '');

                // 🔒 Disable button + show spinner
                loginBtn.disabled = true;
                loginBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Logging in...`;

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            throw data;
                        }
                        return data;
                    })
                    .then(data => {
                        // ✅ Success → redirect (button stays disabled)
                        if (data.status && data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            throw { message: 'Redirect missing' };
                        }
                    })
                    .catch(data => {
                        // ❌ Re-enable button on error
                        loginBtn.disabled = false;
                        loginBtn.innerHTML = originalBtnHtml;

                        // Validation errors
                        if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const errorEl = document.getElementById(`${key}-error`);
                                if (errorEl) {
                                    errorEl.textContent = data.errors[key][0];
                                }
                            });
                        }

                        // Other errors
                        if (data.message && !data.errors) {
                            alert(data.message);
                        }
                    });
            });
        });
    </script>


    {{--
    <script> debugging issues
        document.getElementById("year").textContent = new Date().getFullYear();
    </script> --}}

</body>

</html>