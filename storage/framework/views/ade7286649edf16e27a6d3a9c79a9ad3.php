<?php
use App\Helpers\PermissionHelper;
use App\Models\SchoolPassword;
use App\Models\User;
use Illuminate\Support\Facades\Session;

$__loggedInMarksEntrant = Session('LoggedAdmin')
    ? optional(User::find(Session('LoggedAdmin')))->isMarksEntrant()
    : false;
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="app-sidebar app-sidebar2">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="<?php echo e(url('/student/dashboard')); ?>">
            <img src="<?php echo e(URL::asset('assets/images/brand/uplogolight.png')); ?>" alt="Covido logo" class="sidebar-logo">
        </a>
    </div>
</div>

<aside class="app-sidebar app-sidebar3">
    <ul class="side-menu">

        <?php if(!Session('LoggedSchool') && $__loggedInMarksEntrant): ?>
            
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(url('enter-marks')); ?>">
                    <i class="fas fa-edit fa-2x mr-3"></i>
                    Enter Marks
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('notifications.inbox')); ?>">
                    <i class="fa fa-inbox fa-2x mr-3"></i>
                    My Inbox
                    <?php $adminUnread = \App\Http\Controllers\Helper::adminUnreadBroadcastCount(); ?>
                    <?php if($adminUnread > 0): ?>
                        <span class="badge badge-danger ml-2"><?php echo e($adminUnread); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        <?php elseif(!Session('LoggedSchool')): ?>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(url('/student/dashboard')); ?>">
                    <i class="fa fa-home fa-2x mr-3"></i>
                    Dashboard
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.allSchools')); ?>">
                    <i class="fa fa-school fa-2x mr-3"></i>
                    Schools
                </a>
            </li>

            <li class="slide has-sub">
                <a class="side-menu__item" href="#" data-toggle="submenu">
                    <i class="fa fa-user-graduate fa-2x mr-3"></i>
                    <span>Students</span>
                    <i class="fas fa-chevron-down dropdown-icon ml-auto"></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?php echo e(route('students.individual.search')); ?>"><i class="fas fa-search me-2"></i>Search
                            Student</a></li>
                    <li><a href="<?php echo e(route('students.add.new.student')); ?>"><i class="fas fa-user-plus me-2"></i>Add
                            Students</a></li>
                    <li><a href="<?php echo e(route('students.all.students')); ?>"><i class="fas fa-users me-2"></i>All Students</a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('student.bulk.import.index')); ?>">
                            <i class="fa fa-upload me-2"></i>Bulk Student Import
                        </a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo e(route('admin.student.approvals')); ?>">
                            <i class="fas fa-user-check me-2"></i>Student Approvals
                            <?php
                                $pendingApprovalCount = \App\Models\StudentRegistration::where('status', 'Pending Admin Approval')->count();
                            ?>
                            <?php if($pendingApprovalCount > 0): ?>
                                <span class="badge badge-danger ml-2"><?php echo e($pendingApprovalCount); ?></span>
                            <?php endif; ?>
                        </a>
                    </li> -->

                    <!-- <li><a href="<?php echo e(route('passlip.generate')); ?>"><i class="fas fa-scroll me-3"></i>Passlips &
                            Certificates</a></li> -->

                </ul>
            </li>

            <li class="slide has-sub">
                <a class="side-menu__item" href="#" data-toggle="submenu">
                    <i class="fas fa-balance-scale-right fa-2x mr-3"></i>
                    <span>Marks</span>
                    <i class="fas fa-chevron-down dropdown-icon ml-auto"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo e(url('enter-marks')); ?>">
                            <i class="fas fa-edit me-2"></i>Enter Marks
                        </a>
                    </li>
                    <li><a href="<?php echo e(route('system-users.index')); ?>"><i class="fas fa-user-check mr-2"></i>Marks
                            Entrants & System Users</a></li>
                </ul>
            </li>

            <li class="slide has-sub">
                <a class="side-menu__item" href="#" data-toggle="submenu">
                    <i class="fas fa-sliders-h fa-2x mr-3"></i>
                    <span>Grading</span>
                    <i class="fas fa-chevron-down dropdown-icon ml-auto"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo e(route('grading.settings')); ?>">
                            <i class="fas fa-percent me-2"></i>Grading Settings
                        </a>
                    </li>
                    <li><a href="<?php echo e(url('iteb/grading-summary')); ?>"><i class="fa-solid fa-chart-column me-2"></i></i>Grading
                            Summary</a></li>
                </ul>
            </li>

            <li class="slide has-sub">
                <a class="side-menu__item" href="#" data-toggle="submenu">
                    <i class="fa fa-tasks fa-2x mr-3"></i>
                    <span>Subjects</span>
                    <i class="fas fa-chevron-down dropdown-icon ml-auto"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo e(route('subject.management.index')); ?>">
                            <i class="fas fa-layer-group me-2"></i>Subject Management
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('subject.registration.index')); ?>">
                            <i class="fas fa-check-circle me-2"></i>Subject Registrations
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('combination.management.index')); ?>">
                            <i class="fas fa-layer-group me-2"></i>Combinations (UACE)
                        </a>
                    </li>

                </ul>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('reports.dashboard')); ?>">
                    <i class="fas fa-chart-pie fa-xl me-2"></i>
                    Reports & Passlips
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.passwords.setup')); ?>">
                    <i class="fas fa-key fa-2x mr-3"></i>
                    Schools & Passwords
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('notifications.index')); ?>">
                    <i class="fa fa-bullhorn fa-2x mr-3"></i>
                    Notifications
                    <?php $adminUnread = \App\Http\Controllers\Helper::adminUnreadBroadcastCount(); ?>
                    <?php if($adminUnread > 0): ?>
                        <span class="badge badge-danger ml-2"><?php echo e($adminUnread); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        <?php endif; ?>

        <?php if(!Session('LoggedStudent')): ?>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(url('/school/dashboard')); ?>">
                    <i class="fa fa-home fa-2x mr-3"></i>
                    Dashboard
                </a>
            </li>
            
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.reports.dashboard')); ?>">
                    <i class="fas fa-poll fa-2x mr-3"></i>
                    Reports & Passlips
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.messages.index')); ?>">
                    <i class="fa fa-inbox fa-2x mr-3"></i>
                    Messages
                    <?php $schoolUnread = \App\Http\Controllers\Helper::schoolUnreadBroadcastCount(); ?>
                    <?php if($schoolUnread > 0): ?>
                        <span class="badge badge-danger ml-2"><?php echo e($schoolUnread); ?></span>
                    <?php endif; ?>
                </a>
            </li>

        <?php endif; ?>

        <li class="slide">
            <a class="side-menu__item" href="#" id="logoutMenu">
                <i class="fa fa-sign-out fa-2x mr-3"></i>
                Logout
            </a>
        </li>

    </ul>
</aside>

<!-- Password Change Modal -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" role="dialog" aria-labelledby="passwordChangeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #026837 0%, #038F16 100%); border-radius: 16px 16px 0 0; padding: 20px 30px; border: none;">
                <div class="d-flex align-items-center">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fas fa-key text-white" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold" id="passwordChangeModalLabel" style="font-size: 18px;">Change Default Password</h5>
                        <p class="text-white-50 mb-0" style="font-size: 13px;">Please update your password for security</p>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div style="background: #fff8e1; border-left: 4px solid #ffc107; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
                    <p class="mb-0" style="font-size: 13px; color: #856404;">
                        <i class="fas fa-info-circle" style="color: #ffc107;"></i>
                        Your account is using the default password. For security reasons, please change it now.
                    </p>
                </div>

                <form id="passwordChangeForm">
                    <?php echo csrf_field(); ?>
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold" style="color: #333; font-size: 14px;">Current Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current_password" 
                                   placeholder="Enter current password" required
                                   style="border-radius: 10px 0 0 10px; border: 2px solid #e2e8f0; padding: 12px 16px; font-size: 14px;">
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" style="border-radius: 0 10px 10px 0; cursor: pointer; background: white; border: 2px solid #e2e8f0; border-left: none;">
                                    <i class="fas fa-eye" style="color: #666;"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold" style="color: #333; font-size: 14px;">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" 
                                   placeholder="Enter new password (min 4 characters)" required minlength="4"
                                   style="border-radius: 10px 0 0 10px; border: 2px solid #e2e8f0; padding: 12px 16px; font-size: 14px;">
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" style="border-radius: 0 10px 10px 0; cursor: pointer; background: white; border: 2px solid #e2e8f0; border-left: none;">
                                    <i class="fas fa-eye" style="color: #666;"></i>
                                </span>
                            </div>
                        </div>
                        <small class="text-muted" style="font-size: 12px;">Minimum 4 characters</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold" style="color: #333; font-size: 14px;">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" 
                                   placeholder="Confirm new password" required minlength="4"
                                   style="border-radius: 10px 0 0 10px; border: 2px solid #e2e8f0; padding: 12px 16px; font-size: 14px;">
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" style="border-radius: 0 10px 10px 0; cursor: pointer; background: white; border: 2px solid #e2e8f0; border-left: none;">
                                    <i class="fas fa-eye" style="color: #666;"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="passwordError" style="display: none; color: #e74c3c; font-size: 13px; margin-top: -10px; margin-bottom: 15px;">
                        <i class="fas fa-exclamation-circle"></i> <span id="errorMessage"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #eee; padding: 20px 30px; border-radius: 0 0 16px 16px;">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" style="border-radius: 10px; padding: 10px 30px; font-weight: 600;">Skip for now</button>
                <button type="button" class="btn btn-primary" id="updatePasswordBtn" style="background: linear-gradient(135deg, #026837 0%, #038F16 100%); border: none; border-radius: 10px; padding: 10px 35px; font-weight: 600; box-shadow: 0 4px 15px rgba(2,104,55,0.3);">
                    <i class="fas fa-save me-2"></i> Update Password
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        const sidebarState = localStorage.getItem('sidebar-state');

        if (sidebarState === 'closed') {
            $('body').addClass('sidenav-toggled');
        } else {
            $('body').removeClass('sidenav-toggled');
        }

        $(document).on('click', '[data-toggle="sidebar"]', function () {
            setTimeout(function () {
                if ($('body').hasClass('sidenav-toggled')) {
                    localStorage.setItem('sidebar-state', 'closed');
                } else {
                    localStorage.setItem('sidebar-state', 'open');
                }
            }, 100);
        });

        // Submenu toggle
        $('[data-toggle="submenu"]').on('click', function (e) {
            e.preventDefault();
            var $slide = $(this).closest('.slide');
            $('.slide').not($slide).removeClass('active');
            $slide.toggleClass('active');
        });

        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const input = $(this).closest('.input-group').find('input');
            const icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Handle password update
       // Handle password update
$('#updatePasswordBtn').on('click', function() {
    const $btn = $(this);
    const currentPassword = $('#current_password').val();
    const newPassword = $('#new_password').val();
    const confirmPassword = $('#confirm_password').val();
    
    // Reset errors
    $('#passwordError').hide();
    $('.form-control').removeClass('is-invalid');

    // Validate current password
    if (!currentPassword || currentPassword.trim() === '') {
        $('#current_password').addClass('is-invalid');
        showError('Please enter your current password.');
        return;
    }

    // Validate new password
    if (!newPassword || newPassword.trim() === '') {
        $('#new_password').addClass('is-invalid');
        showError('Please enter a new password.');
        return;
    }

    if (newPassword.length < 4) {
        $('#new_password').addClass('is-invalid');
        showError('New password must be at least 4 characters long.');
        return;
    }

    // Validate confirm password
    if (!confirmPassword || confirmPassword.trim() === '') {
        $('#confirm_password').addClass('is-invalid');
        showError('Please confirm your new password.');
        return;
    }

    if (newPassword !== confirmPassword) {
        $('#confirm_password').addClass('is-invalid');
        showError('Passwords do not match.');
        return;
    }

    // Validate that new password is different from current
    if (newPassword === currentPassword) {
        showError('New password must be different from the current password.');
        return;
    }

    // All validation passed — ask for confirmation before submitting
    Swal.fire({
        title: 'Confirm Password Change',
        text: 'Are you sure you want to update your password?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#026837',
        cancelButtonColor: '#d33',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            submitPasswordUpdate($btn, currentPassword, newPassword);
        }
    });
});

function submitPasswordUpdate($btn, currentPassword, newPassword) {
    const originalHtml = $btn.html();
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');

    $.ajax({
        url: '<?php echo e(route("school.update.password")); ?>',
        method: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            current_password: currentPassword,
            new_password: newPassword,
            school_id: '<?php echo e(Session::get("LoggedSchool")); ?>'
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Password Updated!',
                    text: 'Your password has been changed successfully.',
                    confirmButtonColor: '#026837'
                }).then(function() {
                    $('#passwordChangeModal').modal('hide');
                    location.reload();
                });
            } else {
                showError(response.message || 'Failed to update password.');
            }
        },
        error: function(xhr) {
            let errorMsg = 'An error occurred. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            showError(errorMsg);
        },
        complete: function() {
            $btn.prop('disabled', false).html(originalHtml);
        }
    });
}

        function showError(message) {
            $('#errorMessage').text(message);
            $('#passwordError').show();
        }

        // Enter key support for form submission
        $('#passwordChangeForm input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#updatePasswordBtn').click();
            }
        });

        // Clear error when user types
        $('.form-control').on('input', function() {
            $(this).removeClass('is-invalid');
            $('#passwordError').hide();
        });

        // Check if password needs changing (only for logged-in school users)
        <?php if(Session::has('LoggedSchool')): ?>
            <?php
                $schoolId = DB::table('houses')->where('ID', Session::get('LoggedSchool'))->value('Number');
                $schoolPassword = \App\Models\SchoolPassword::where('school_id', $schoolId)->first();
                $needsPasswordChange = $schoolPassword && $schoolPassword->password_plain === '123456789';
            ?>

            <?php if($needsPasswordChange): ?>
                // Show modal after a short delay
                setTimeout(function() {
                    $('#passwordChangeModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#passwordChangeModal').modal('show');
                }, 1000);
            <?php endif; ?>
        <?php endif; ?>

    });

    document.getElementById('logoutMenu').addEventListener('click', function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to Logout?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Logout",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo e(route('student-logout')); ?>';
            }
        });
    });

    // Scroll-aware logo shrink
    (function () {
        const sidebar = document.querySelector('.app-sidebar3');
        const logoWrapper = document.querySelector('.app-sidebar__logo');
        if (!sidebar || !logoWrapper) return;
        sidebar.addEventListener('scroll', () => {
            logoWrapper.classList.toggle('scrolled', sidebar.scrollTop > 20);
        });
    })();

    // Correct "current page" active highlighting
    $(window).on('load', function () {
        var pageUrl = window.location.href.split(/[?#]/)[0];

        $('.app-sidebar3 .slide').removeClass('active is-expanded');

        $('.app-sidebar3 .side-menu__item, .app-sidebar3 .sub-menu a').each(function () {
            if (this.href === pageUrl) {
                $(this).closest('.slide').addClass('active');
                $(this).addClass('active');
            }
        });
    });
</script>
<style>
    /* ── Sidebar base ── */
    .side-menu {
        list-style: none;
        padding: 0;
        margin: 100px 0 0 !important;
    }

    .slide {
        position: relative;
        margin-bottom: 4px;
    }

    .side-menu__item {
        display: flex;
        align-items: center;
        padding: 11px 20px;
        color: #333;
        text-decoration: none;
        transition: all .25s ease;
        border-radius: 8px;
        margin: 0 8px;
    }

    .side-menu__item:hover,
    .slide.active>.side-menu__item {
        background: linear-gradient(135deg, #026837 0%, #038F16 100%);
        color: #fff !important;
        transform: translateX(4px);
    }

    .app-sidebar3 ul.side-menu li.slide.active>a.side-menu__item,
    .app-sidebar3 ul.side-menu li.slide.active>a.side-menu__item i,
    .app-sidebar3 ul.side-menu li.slide.active>a.side-menu__item span {
        color: #fff !important;
    }

    .side-menu__item i:first-child {
        width: 35px;
    }

    .dropdown-icon {
        transition: transform .25s;
        font-size: 12px;
    }

    .slide.active .dropdown-icon {
        transform: rotate(180deg);
    }

    /* Sub-menus */
    .sub-menu {
        display: none;
        list-style: none;
        padding: 6px 0 6px 44px;
        margin: 4px 0;
        background: rgba(79, 70, 229, .04);
        border-radius: 8px;
    }

    .slide.active>.sub-menu {
        display: block;
        animation: fadeIn .25s ease;
    }

    .sub-menu li {
        margin: 3px 0;
    }

    .sub-menu li a {
        display: flex;
        align-items: center;
        padding: 7px 14px;
        color: #555;
        text-decoration: none;
        border-radius: 6px;
        transition: all .2s;
        font-size: 13.5px;
    }

    .sub-menu li a:hover {
        background: linear-gradient(135deg, #026837 0%, #038F16 100%);
        color: #fff !important;
        transform: translateX(4px);
    }

    .sub-menu li a i {
        width: 24px;
        font-size: 13px;
    }

    /* Badges */
    .badge-danger {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.18);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Logo */
    .app-sidebar__logo {
        padding: 20px 0 30px;
        text-align: center;
        border-bottom: 1px solid #eee;
        margin-bottom: 14px;
        transition: padding .3s;
    }

    .app-sidebar__logo.scrolled {
        padding: 10px 0 14px;
    }

    .sidebar-logo {
        width: 130px;
        height: auto;
        max-width: 170px;
        object-fit: contain;
        transition: all .3s;
        display: block;
        margin: 0 auto;
    }

    .app-sidebar__logo.scrolled .sidebar-logo {
        width: 90px;
    }

    .sidenav-toggled .sidebar-logo {
        width: 40px !important;
    }

    .sidebar-logo:hover {
        transform: scale(1.04);
    }

    @media (max-width: 768px) {
        div.app-sidebar.app-sidebar2 {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 250px !important;
            height: auto !important;
            z-index: 10001 !important;
            background: transparent !important;
            pointer-events: none !important;
            transform: translateX(-250px) !important;
            transition: transform .3s ease !important;
        }

        .sidenav-toggled div.app-sidebar.app-sidebar2 {
            transform: translateX(0) !important;
        }

        div.app-sidebar.app-sidebar2 .app-sidebar__logo {
            display: block !important;
            pointer-events: all !important;
            background: transparent !important;
            padding: 12px 0 14px !important;
        }

        div.app-sidebar.app-sidebar2 .sidebar-logo {
            width: 70px !important;
            display: block !important;
            margin: 0 auto !important;
        }
    }

    /* Override for submenu items */
    .app-sidebar3 ul.side-menu li.slide .sub-menu li a,
    .app-sidebar3 ul.side-menu li.slide .sub-menu li a i,
    .app-sidebar3 ul.side-menu li.slide .sub-menu li a span {
        color: #555;
        background: transparent;
        transition: color .2s, background .2s, transform .2s;
    }

    .app-sidebar3 ul.side-menu li.slide .sub-menu li a:hover,
    .app-sidebar3 ul.side-menu li.slide .sub-menu li a:focus {
        background: linear-gradient(135deg, #026837 0%, #038F16 100%) !important;
        transform: translateX(4px);
        color: #fff !important;
    }

    .app-sidebar3 ul.side-menu li.slide .sub-menu li a:hover i,
    .app-sidebar3 ul.side-menu li.slide .sub-menu li a:hover span,
    .app-sidebar3 ul.side-menu li.slide .sub-menu li a:focus i,
    .app-sidebar3 ul.side-menu li.slide .sub-menu li a:focus span {
        color: #fff !important;
    }

    /* Modal custom styles */
    .modal-content {
     
   border-radius: 16px;
    }
    .modal-header {
     
   border-radius: 16px 16px 0 0;
    }
    .modal-footer {
     
   border-radius: 0 0 16px 16px;
    }
    .form-control:focus {
        border-color: #026837 !important ;
       
   box-shadow: 0 0 0 0.2rem rgba(2,104,55,0.15) !important;
    }
    .is-invalid {
        border-color: #e74c3c !important;
    }

    /* Ensure SweetAlert2 always renders above the Bootstrap modal */
.swal2-container {
    z-index: 20000 !important;
}
</style><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/layouts-side-bar/side-menu.blade.php ENDPATH**/ ?>