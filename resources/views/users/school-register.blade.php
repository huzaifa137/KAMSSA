<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register School - KAMSSA</title>
    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ------------------------------------------------------------
           Same palette / pill-input language as the KAMSSA login page
        ------------------------------------------------------------ */
        :root {
            --orange: #026837;
            --orange-dark: #410a2b;
            --orange-light: #287C44;
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

.register-card {
    max-width: 600px;   /* ← caps the width, same idea as .login-card's 500px */
    width: 100%;
    background: var(--white);
    border-radius: 32px;
    padding: 2.5rem 2.2rem;
    box-shadow: var(--shadow);
    transition: transform 0.2s;
}

        .register-card:hover {
            transform: scale(1.005);
        }

        .badge-ref {
            display: inline-block;
            background: var(--orange-subtle);
            padding: 8px 30px;
            border-radius: 50px;
            margin-top: 8px;
            border: 1px solid rgba(2, 104, 55, 0.2);
            color: var(--orange);
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 3px;
            font-family: 'Courier New', monospace;
        }

        .welcome-text {
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .welcome-text i {
            color: var(--orange);
        }

        .section-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray-900);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .section-title span.dot {
            display: inline-block;
            width: 4px;
            height: 16px;
            background: var(--orange);
            border-radius: 4px;
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 1.4rem;
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
            box-shadow: 0 0 0 4px rgba(2, 104, 55, 0.08);
        }

        .form-input.is-invalid {
            border-color: #dc2626;
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            color: var(--gray-500);
            font-size: 1.1rem;
            pointer-events: none;
        }

        .error-text {
            display: block;
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 6px;
            margin-left: 12px;
            font-weight: 500;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .register-card {
                padding: 2rem 1.5rem;
            }
        }

        /* Category cards */
        .category-option input {
            display: none;
        }

        .category-card {
            padding: 20px;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius-sm);
            background: transparent;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .category-card .icon {
            font-size: 30px;
            margin-bottom: 8px;
            color: var(--orange);
        }

        .category-card.category-negative .icon {
            color: #dc2626;
        }

        .category-card .title {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 15px;
        }

        .category-card .sub {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        .category-card.selected {
            border-color: var(--orange);
            background: var(--orange-subtle);
        }

        .category-card.category-negative.selected {
            border-color: #dc2626;
            background: #fdf2f2;
        }

        /* Buttons – same pill treatment as login page */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
            box-shadow: 0 8px 16px -4px rgba(2, 104, 55, 0.28);
        }

        .btn-primary:hover {
            background: var(--orange-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -6px rgba(2, 104, 55, 0.36);
            color: white;
        }

        .btn-secondary {
            background: transparent;
            color: var(--gray-900);
            border: 2px solid var(--gray-300);
        }

        .btn-secondary:hover {
            border-color: var(--orange);
            color: var(--orange);
            background: rgba(2, 104, 55, 0.04);
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.75;
            cursor: not-allowed;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.5rem;
            border-top: 2px solid var(--gray-100);
            margin-top: 0.5rem;
        }

        .divider {
            display: flex;
            align-items: center;
            color: var(--gray-500);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 1.6rem 0 1.2rem;
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
    </style>
</head>

<body>
    <div class="register-card">

        <!-- === BRAND WITH LOGO – same block as the login page === -->
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="
                        width:110px;
                        height:110px;
                        border-radius:50%;
                        box-shadow:
                            0 8px 32px -8px rgba(157,26,104,0.28),
                            0 0 0 6px #fff,
                            0 0 0 9px #287C44;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        margin:0 auto 1rem;
                        background:#fff;
                    ">
                <img src="{{ asset('asset/images/logo.png') }}" alt="KAMSSA Logo"
                    style="width:80px; height:100px; object-fit:contain;">
            </div>

            <div style="font-size: 1.55rem; font-weight: 800; letter-spacing: -0.02em;
                color: #0a0a0a; margin-bottom: 0.15rem; line-height: 1.2;">
                <span style="color: #026837;">K</span>ampala <span style="color: #026837;">I</span>ntegrated
                <span style="color: #026837;">S</span>econdary <span style="color: #026837;">S</span>chools
                <span style="color: #026837;">E</span>xamination
            </div>

            <div style="font-size: 0.78rem; font-weight: 700; letter-spacing: 3px;
                color: #026837; text-transform: uppercase; margin-bottom: 0.6rem;">
                KAMSSA — Uganda
            </div>

            <div style="width: 60px; height: 3px; border-radius: 2px;
                background: linear-gradient(90deg, #026837, #287C44);
                margin: 0 auto 1rem;"></div>
        </div>

        <div class="welcome-text" style="text-align: center;">
            <i class="fas fa-school"></i>
            <strong>Register your school</strong><br>
            <span style="color: #71717a; font-size: 0.92rem;">Fill in the details below to add your school</span>
        </div>

        <div style="text-align:center; margin-bottom: 1.8rem;">
            <span style="color:#8899aa; font-size:11px; text-transform:uppercase; letter-spacing:2px;">
                School Reference
            </span>
            <div>
                <span class="badge-ref">IT-{{ str_pad($nextNumber, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div style="margin-top:6px;">
                <span style="color:#a1a1aa; font-size:11px;">
                    <i class="fas fa-sync-alt" style="font-size:10px;"></i> Auto-generated
                </span>
            </div>
        </div>

        <!-- === FORM – action, CSRF, ids, validation & AJAX all preserved === -->
        <form id="createHouseForm" method="POST" action="{{ route('houses.store') }}">
            @csrf

            {{-- School Information --}}
            <div class="section-title"><span class="dot"></span>School Information</div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <div class="form-group">
                    <label class="form-label" for="House">School Name</label>
                    <div class="input-group">
                        <i class="fas fa-university input-icon"></i>
                        <input type="text" name="House" id="House"
                            class="form-input @error('House') is-invalid @enderror"
                            placeholder="Type school name..." value="{{ old('House') }}" required>
                    </div>
                    @error('House')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="Location">District</label>
                    <div class="input-group">
                        <i class="fas fa-location-dot input-icon"></i>
                        <input type="text" name="Location" id="Location"
                            class="form-input @error('Location') is-invalid @enderror"
                            placeholder="Enter district..." value="{{ old('Location') }}" required>
                    </div>
                    @error('Location')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Category Selection --}}
            <div class="section-title" style="margin-top: 0.5rem;" id="categorySelectionContainer">
                <span class="dot"></span>Category Selection
            </div>

            <div class="grid-2" style="margin-bottom: 0.5rem;">
                <label for="categoryAnswers" class="category-option"
                    onclick="selectCategory('categoryAnswers', 'categoryNoAnswers')">
                    <input type="radio" name="Category" id="categoryAnswers" value="Answer Sheets"
                        {{ old('Category') == 'Answer Sheets' ? 'checked' : '' }}>
                    <div class="category-card {{ old('Category') == 'Answer Sheets' ? 'selected' : '' }}">
                        <div class="icon"><i class="fas fa-file-pen"></i></div>
                        <div class="title">Answer Sheets</div>
                        <div class="sub">Exam materials provided</div>
                    </div>
                </label>

                <label for="categoryNoAnswers" class="category-option"
                    onclick="selectCategory('categoryNoAnswers', 'categoryAnswers')">
                    <input type="radio" name="Category" id="categoryNoAnswers" value="No Answer Sheets"
                        {{ old('Category') == 'No Answer Sheets' ? 'checked' : '' }}>
                    <div class="category-card category-negative {{ old('Category') == 'No Answer Sheets' ? 'selected' : '' }}">
                        <div class="icon"><i class="fas fa-ban"></i></div>
                        <div class="title">No Answer Sheets</div>
                        <div class="sub">No exam materials</div>
                    </div>
                </label>
            </div>
            <small class="error-text" id="categoryError" style="display:none; margin-bottom: 1rem;"></small>

            {{-- Administrator Details --}}
            <div class="section-title" style="margin-top: 1.2rem;">
                <span class="dot"></span>Administrator Details
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="AdministratorNames">Full Name(s)</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="AdministratorNames" id="AdministratorNames"
                            class="form-input @error('AdministratorNames') is-invalid @enderror"
                            placeholder="Enter administrator name..." value="{{ old('AdministratorNames') }}"
                            required>
                    </div>
                    @error('AdministratorNames')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="AdministratorTelephones">Telephone</label>
                    <div class="input-group">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" name="AdministratorTelephones" id="AdministratorTelephones"
                            class="form-input @error('AdministratorTelephones') is-invalid @enderror"
                            placeholder="e.g. 0712-345-678" value="{{ old('AdministratorTelephones') }}" required>
                    </div>
                    @error('AdministratorTelephones')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label" for="Title">Position Title</label>
                    <div class="input-group">
                        <i class="fas fa-briefcase input-icon"></i>
                        <input type="text" name="Title" id="Title"
                            class="form-input @error('Title') is-invalid @enderror"
                            placeholder="e.g. Headteacher, Principal, Director..." value="{{ old('Title') }}"
                            required>
                    </div>
                    @error('Title')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="form-actions">
               
            </div>

                <button type="submit" id="submitBtn" class="btn btn-primary"  style="width: 100%; text-decoration: none;margin-bottom:1em;">
                    <i class="fas fa-save"></i> Create School
                </button>

                <a href="{{ url('/users/login') }}" class="btn btn-primary" style="width: 100%; text-decoration: none;background-color: orange;">
                    <i class="fas fa-arrow-left"></i> Back to login
                </a>
                
            <div class="divider">
                <span>or</span>
            </div>

            <a href="{{ url('/') }}" class="btn btn-secondary" style="width: 100%; text-decoration: none;">
                <i class="fas fa-home"></i> Back to Homepage
            </a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#createHouseForm').on('submit', function (e) {
                e.preventDefault();

                let $form = $(this);
                let $btn = $('#submitBtn');
                let isValid = true;

                // Clear previous errors
                $form.find('.form-input').removeClass('is-invalid');
                $form.find('.error-text.field-error').remove();
                $('#categoryError').hide();

                // Validate required fields
                ['House', 'Location', 'AdministratorNames', 'AdministratorTelephones', 'Title'].forEach(function (field) {
                    let $input = $form.find('[name="' + field + '"]');
                    if (!$input.val() || $input.val().trim() === '') {
                        $input.addClass('is-invalid');
                        $input.closest('.form-group')
                            .append('<small class="error-text field-error">This field is required.</small>');
                        isValid = false;
                    }
                });

                // Validate Category selection
                if (!$('input[name="Category"]:checked').length) {
                    $('#categoryError').text('Please select a category.').show();
                    isValid = false;
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Form',
                        text: 'Please fill in all required fields.',
                        confirmButtonColor: '#026837'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Save this school?',
                    html: '<span style="color:#555;">You are about to register <strong>'
                        + $('#House').val().trim() + '</strong>.</span>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#026837',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, save it!',
                    cancelButtonText: 'Cancel'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        let originalHtml = $btn.html();
                        $btn.prop('disabled', true)
                            .html('Saving… <i class="fas fa-spinner fa-spin ms-1"></i>');

                        $.ajax({
                            url: $form.attr('action'),
                            method: 'POST',
                            data: $form.serialize(),
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved!',
                                    text: response.message || 'School has been added successfully.',
                                    confirmButtonColor: '#026837'
                                }).then(function () {
                                    $form[0].reset();
                                    $('.category-card').removeClass('selected');
                                });
                            },
                            error: function (data) {
                                $('body').html(data.responseText);
                            },
                            complete: function () {
                                $btn.prop('disabled', false).html(originalHtml);
                            }
                        });
                    }
                });
            });
        });

        // Category card selection styling
        function selectCategory(selectedId, otherId) {
            const selectedCard = document.querySelector(`label[for="${selectedId}"] .category-card`);
            const otherCard = document.querySelector(`label[for="${otherId}"] .category-card`);

            selectedCard.classList.add('selected');
            otherCard.classList.remove('selected');

            $('#categoryError').hide();
        }

        // Initialize selection on page load (e.g. after validation redirect with old input)
        document.addEventListener('DOMContentLoaded', function () {
            const selectedCategory = document.querySelector('input[name="Category"]:checked');
            if (selectedCategory) {
                const selectedId = selectedCategory.id;
                const otherId = selectedId === 'categoryAnswers' ? 'categoryNoAnswers' : 'categoryAnswers';
                selectCategory(selectedId, otherId);
            }
        });
    </script>
</body>

</html>