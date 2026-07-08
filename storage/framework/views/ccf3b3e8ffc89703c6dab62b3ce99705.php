<div class="app-sidebar app-sidebar2">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="<?php echo e(url('/student/dashboard')); ?>">
            <img src="<?php echo e(URL::asset('assets/images/brand/uplogolight.png')); ?>" alt="Covido logo"
                style="width: 100%; height: auto; max-width: 170px;">
        </a>
    </div>
</div>

<?php
use App\Helpers\PermissionHelper;
?>

<aside class="app-sidebar app-sidebar3">
    <ul class="side-menu" style="margin-top:100px !important;">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <?php if(!Session('LoggedSchool')): ?>
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

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('students.individual.search')); ?>">
                    <i class="fa fa-user-graduate fa-2x mr-3"></i>
                    Students
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('academic.years')); ?>">
                    <i class="fas fa-clock fa-2x mr-3"></i> Academic Years
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(url('/enter-marks')); ?>">
                    <i class="fas fa-balance-scale-right fa-2x mr-3"></i>
                    Grading & Marks
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.passwords.setup')); ?>">
                    <i class="fas fa-key fa-2x mr-3"></i>
                    Schools & Passwords
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('grading.settings')); ?>">
                    <i class="fas fa-sliders-h fa-2x mr-3"></i>
                    Grading Settings
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('passlip.generate')); ?>">
                    <i class="fas fa-scroll fa-2x mr-3"></i>
                    Passlips & Certificates
                </a>
            </li>

            
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.recognition.index')); ?>">
                    <i class="fas fa-certificate fa-2x mr-3"></i>
                    Recognition Certificates
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('admin.student.approvals')); ?>">
                    <i class="fas fa-user-check fa-2x mr-3"></i>
                    Student Approvals
                    <?php
                        $pendingApprovalCount = \App\Models\StudentRegistration::where('status', 'Pending Admin Approval')->count();
                    ?>
                    <?php if($pendingApprovalCount > 0): ?>
                        <span class="badge badge-danger ml-2" style="border-radius:12px; font-size:11px; padding:3px 8px;">
                            <?php echo e($pendingApprovalCount); ?>

                        </span>
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

            <!-- Register Student -->
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.register.student')); ?>">
                    <i class="fas fa-user-plus fa-2x mr-3"></i>
                    Register Student
                </a>
            </li>

            
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('school.recognition.view')); ?>">
                    <i class="fas fa-certificate fa-2x mr-3"></i>
                    Recognition Certificate
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

<style>
    .sub-menu {
        display: none;
        padding-left: 40px;
    }

    .slide.active>.sub-menu {
        display: block;
    }

    .has-sub>a {
        cursor: pointer;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        $('#helpSupportToggle').on('click', function (e) {
            e.preventDefault();
            $(this).parent('.slide').toggleClass('active');
        });
    });

    document.getElementById('logoutMenu').addEventListener('click', function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to Logout ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Logout",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo e(route('student-logout')); ?>';
            }
        });
    });
</script>

<!--aside closed--><?php /**PATH C:\Users\USER\Desktop\huzaiphar\ple-examination-boards-updated\resources\views/layouts-side-bar/side-menu.blade.php ENDPATH**/ ?>