<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - ITEB </title>
    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ------------------------------------------------------------
           ORANGE & BLACK THEME – FREST MINIMAL CARD DESIGN
           All original functionality preserved (role selector, password toggle,
           AJAX, CSRF, error handling, dynamic labels)
        ------------------------------------------------------------ */
        :root {
            --orange: #026837;
            /* repurposed variable name kept for minimal changes */
            --orange-dark: #410a2b;
            --orange-light: #c51619;
            --orange-subtle: #ecfdf5;
            --black: #0a0a0a;
            --gray-900: #18181b;
            --gray-700: #3f3f46;
            --gray-500: #71717a;
            --gray-300: #d4d4d8;
            --gray-100: #f4f4f5;
            --white: #ffffff;
            --radius: 20px;
            --radius-sm: 12px;
            --shadow: 0 20px 40px -12px rgba(22, 163, 74, 0.12), 0 8px 24px -6px rgba(0, 0, 0, 0.04);
            --transition: all 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(145deg, #f0fdf4 0%, #ecfdf5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* CARD – exactly like the Frest screenshot */
        .login-card {
            max-width: 500px;
            width: 100%;
            background: var(--white);
            border-radius: 32px;
            padding: 2.5rem 2.2rem;
            box-shadow: var(--shadow);
            transition: transform 0.2s;
        }

        .login-card:hover {
            transform: scale(1.01);
        }

        /* Brand / Logo */
        .brand {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--black);
            margin-bottom: 0.5rem;
        }

        .brand span {
            color: var(--orange);
        }

        /* Welcome message – exactly as described */
        .welcome-text {
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .welcome-text i,
        .welcome-text .emoji {
            color: var(--orange);
        }

        /* ---------- ROLE SELECTOR (kept original functionality) ---------- */
        .user-role-selector {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 2.5rem;
        }

        .role-btn {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 1rem 0.5rem;
            background: var(--gray-100);
            border: 2px solid transparent;
            border-radius: var(--radius-sm);
            color: var(--gray-700);
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
            cursor: pointer;
        }

        .role-btn i {
            font-size: 1.3rem;
            color: var(--gray-500);
            transition: var(--transition);
        }

        .role-btn.active {
            background: var(--orange-subtle);
            border-color: var(--orange);
            color: var(--orange-dark);
        }

        .role-btn.active i {
            color: var(--orange);
        }

        .role-btn:hover:not(.active) {
            background: #fafafa;
            border-color: var(--gray-300);
        }

        /* ---------- FORM ---------- */
        .login-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray-900);
            margin-bottom: 0.6rem;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1.5px solid var(--gray-300);
            border-radius: 40px;
            font-size: 0.95rem;
            background: var(--white);
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.08);
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            color: var(--gray-500);
            font-size: 1.1rem;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 1.2rem;
            background: none;
            border: none;
            color: var(--gray-500);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Row: Remember me + Forgot password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0 2rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: pointer;
            font-size: 0.95rem;
            color: var(--gray-700);
            font-weight: 500;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--orange);
            border-radius: 4px;
            cursor: pointer;
        }

        .forgot-password {
            color: var(--orange);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: var(--orange-dark);
            text-decoration: underline;
        }

        /* Primary button – orange */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 40px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-primary {
            background: var(--orange);
            color: white;
            box-shadow: 0 8px 16px -4px rgba(22, 163, 74, 0.28);
            margin-bottom: 1.5rem;
        }

        .btn-primary:hover {
            background: var(--orange-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -6px rgba(22, 163, 74, 0.36);
        }

        .btn-primary i {
            font-size: 1rem;
        }

        /* "New on our platform? Create an account" */
        .signup-link {
            text-align: center;
            margin: 1.8rem 0 1.5rem;
            font-size: 0.95rem;
            color: var(--gray-700);
            font-weight: 500;
        }


        .signup-link a {
            color: var(--orange);
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* OR divider – exactly as in the screenshot */
        .divider {
            display: flex;
            align-items: center;
            color: var(--gray-500);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 1.2rem 0 1.5rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--gray-300);
        }

        .divider span {
            margin: 0 1rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        /* Secondary button (Back to Homepage) – subtle outline, keeps original link */
        .btn-secondary {
            background: transparent;
            color: var(--gray-900);
            border: 2px solid var(--gray-300);
            box-shadow: none;
            margin-top: 0.5rem;
        }

        .btn-secondary:hover {
            border-color: var(--orange);
            color: var(--orange);
            background: rgba(22, 163, 74, 0.04);
            transform: translateY(-2px);
        }

        /* Error messages – kept original style */
        .error-text {
            display: block;
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 6px;
            margin-left: 12px;
            font-weight: 500;
        }

        button:disabled {
            opacity: 0.75;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .brand {
                font-size: 2rem;
            }

            .user-role-selector {
                flex-wrap: wrap;
            }

            .role-btn {
                min-width: 100px;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <!-- === FREST BRAND (exactly as in the image) === -->
        <!-- === BRAND WITH LOGO === -->
        <div style="text-align: center; margin-bottom: 1.8rem;">
            <img src="<?php echo e(asset('asset/images/logo.png')); ?>" alt="KAMSSA Logo" style="width: 110px; height: 110px; object-fit: contain;
                border-radius: 50%;
                box-shadow: 0 8px 32px -8px rgba(157,26,104,0.28),
                            0 0 0 6px #fff,
                            0 0 0 9px rgba(157,26,104,0.12);
                margin-bottom: 1rem;
                display: block;
                margin-left: auto;
                margin-right: auto;">

            <div style="font-size: 1.55rem; font-weight: 800; letter-spacing: -0.02em;
                color: #0a0a0a; margin-bottom: 0.15rem; line-height: 1.2;">
                <span style="color: #026837;">N</span>ansana <span style="color: #026837;">M</span>unicipal
                <span style="color: #026837;">E</span>xamination <span style="color: #026837;">C</span>ouncil
            </div>

            <div style="font-size: 0.78rem; font-weight: 700; letter-spacing: 3px;
                color: #026837; text-transform: uppercase; margin-bottom: 0.6rem;">
                KAMSSA — Uganda
            </div>

            <div style="width: 60px; height: 3px; border-radius: 2px;
                background: linear-gradient(90deg, #026837, #c51619);
                margin: 0 auto 1rem;"></div>
        </div>

        <div class="welcome-text" style="text-align: center; margin-bottom: 1.8rem;">
            <i class="fas fa-hand-sparkles" style="color: #026837;"></i>
            <strong>Welcome back!</strong><br>
            <span style="color: #71717a; font-size: 0.92rem;">Please sign in to your account to continue</span>
        </div>

        <!-- === ORIGINAL ROLE SELECTOR – fully functional, now in orange === -->
        <div class="user-role-selector">
            <button class="role-btn active" data-role="student">
                <i class="fas fa-user-graduate"></i>
                <span>Student</span>
            </button>
            <button class="role-btn" data-role="school">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>School</span>
            </button>
            <button class="role-btn" data-role="admin">
                <i class="fas fa-user-cog"></i>
                <span>Admin</span>
            </button>
        </div>

        <!-- === LOGIN FORM – everything original: action, CSRF, ids, dynamic labels, password toggle, AJAX === -->
        <form class="login-form" id="loginForm" action="<?php echo e(route('auth-user-check')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="role" id="login_role" value="student">

            <!-- Username / Registration field -->
            <div class="form-group">
                <label for="username" class="form-label" id="usernameLabel">REGISTRATION NUMBER</label>
                <div class="input-group">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" id="username" name="username" class="form-input"
                        placeholder="Enter your student registration number">
                </div>
                <small class="error-text" id="username-error"></small>
            </div>

            <!-- Password field with toggle -->
            <div class="form-group">
                <label for="password" class="form-label" id="passwordLabel">STUDENT PASSWORD</label>
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

            <!-- Remember me & Forgot password row -->
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember" value="1">
                    <span>Remember me</span>
                </label>
                <a href="javascript:void();" class="forgot-password" style="text-decoration: none;">Forgot password
                    ?</a>
                
            </div>

            <!-- SIGN IN BUTTON (orange) -->
            <button type="submit" class="btn btn-primary" id="loginBtn">
                <i class="fas fa-arrow-right-to-bracket"></i> Sign in
            </button>


            <div class="divider">
                <span>or</span>
            </div>

            <!-- Back to Homepage – original link kept, now as subtle outline button -->
            <a href="<?php echo e(url('/')); ?>" class="btn btn-secondary" style="text-decoration: none;">
                <i class="fas fa-home"></i> Back to Homepage
            </a>
        </form>
    </div>

    <!-- ============ ORIGINAL JAVASCRIPT – FULLY INTACT ============ -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ------------------------------
            // 1. ROLE SELECTOR – updates hidden input, labels & placeholders
            // ------------------------------
            const roleButtons = document.querySelectorAll('.role-btn');
            const roleInput = document.getElementById('login_role');
            const usernameLabel = document.querySelector('label[for="username"]');
            const usernameInput = document.getElementById('username');
            const passwordLabel = document.querySelector('label[for="password"]');

            function updateFormForRole(role) {
                switch (role) {
                    case 'student':
                        usernameLabel.textContent = 'REGISTRATION NUMBER';
                        usernameInput.placeholder = 'Enter your student registration number';
                        passwordLabel.textContent = 'STUDENT PASSWORD';
                        break;
                    case 'school':
                        usernameLabel.textContent = 'SCHOOL CENTER NUMBER';
                        usernameInput.placeholder = 'Enter your school center number';
                        passwordLabel.textContent = 'SCHOOL PASSWORD';
                        break;
                    case 'admin':
                        usernameLabel.textContent = 'ADMINISTRATOR ID / EMAIL';
                        usernameInput.placeholder = 'Enter your administrator credentials';
                        passwordLabel.textContent = 'ADMIN PASSWORD';
                        break;
                }
            }

            // Set initial active role
            let activeRole = 'student';
            roleInput.value = activeRole;
            updateFormForRole(activeRole);

            roleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    roleButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    activeRole = this.getAttribute('data-role');
                    roleInput.value = activeRole;
                    updateFormForRole(activeRole);
                });
            });

            // ------------------------------
            // 2. PASSWORD TOGGLE (eye icon)
            // ------------------------------
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
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

            // ------------------------------
            // 3. AJAX FORM SUBMISSION (spinner, error display, redirect)
            // ------------------------------
            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const originalBtnHtml = loginBtn.innerHTML;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Clear previous errors
                document.querySelectorAll('.error-text').forEach(el => el.textContent = '');

                // Disable button + show spinner
                loginBtn.disabled = true;
                loginBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Signing in...`;

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
                        if (!response.ok) throw data;
                        return data;
                    })
                    .then(data => {
                        if (data.status && data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            throw { message: 'Redirect missing' };
                        }
                    })
                    .catch(data => {
                        // Re-enable button on error
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
                        // General error
                        if (data.message && !data.errors) {
                            alert(data.message);
                        }
                    });
            });
        });
    </script>

    <!-- Optional: dynamic year (if you need it, uncomment) 
    <script>document.getElementById("year").textContent = new Date().getFullYear();</script> -->
</body>

</html><?php /**PATH C:\Users\USER\Desktop\huzaiphar\ple-examination-boards-updated\resources\views/users/login.blade.php ENDPATH**/ ?>