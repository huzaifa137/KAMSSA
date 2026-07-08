<div class="app-sidebar app-sidebar2">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{ url('/student/dashboard') }}">
            <img src="{{ URL::asset('assets/images/brand/uplogolight.png') }}" alt="Covido logo"
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

        @if (!Session('LoggedSchool'))
            <li class="slide">
                <a class="side-menu__item" href="{{ url('/student/dashboard') }}">
                    <i class="fa fa-home fa-2x mr-3"></i>
                    Dashboard
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('school.allSchools') }}">
                    <i class="fa fa-school fa-2x mr-3"></i>
                    Schools
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('students.individual.search') }}">
                    <i class="fa fa-user-graduate fa-2x mr-3"></i>
                    Students
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('academic.years') }}">
                    <i class="fas fa-clock fa-2x mr-3"></i> Academic Years
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ url('/enter-marks') }}">
                    <i class="fas fa-balance-scale-right fa-2x mr-3"></i>
                    Grading & Marks
                </a>
            </li>

            
            <li class="slide">
                <a class="side-menu__item" href="{{ route('grading.settings') }}">
                    <i class="fas fa-sliders-h fa-2x mr-3"></i>
                    Grading Settings
                </a>
            </li>

            {{-- ── NEW: Bulk Student Import ── --}}
            <li class="slide">
                <a class="side-menu__item" href="{{ route('student.bulk.import.index') }}">
                    <i class="fa fa-file-excel fa-2x mr-3"></i>
                    Bulk Student Import
                </a>
            </li>

            {{-- ── NEW: UCE/UACE Subject Management (master subject list) ── --}}
            <li class="slide">
                <a class="side-menu__item" href="{{ route('subject.management.index') }}">
                    <i class="fa fa-book fa-2x mr-3"></i>
                    Subject Management
                </a>
            </li>

            {{-- ── NEW: UCE/UACE Subject Registration (optional subjects) ── --}}
            <li class="slide">
                <a class="side-menu__item" href="{{ route('subject.registration.index') }}">
                    <i class="fa fa-tasks fa-2x mr-3"></i>
                    Subject Registration
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('school.passwords.setup') }}">
                    <i class="fas fa-key fa-2x mr-3"></i>
                    Schools & Passwords
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('passlip.generate') }}">
                    <i class="fas fa-scroll fa-2x mr-3"></i>
                    Passlips & Certificates
                </a>
            </li>

            {{-- ── NEW: School Recognition Certificates ── --}}
            <li class="slide">
                <a class="side-menu__item" href="{{ route('school.recognition.index') }}">
                    <i class="fas fa-certificate fa-2x mr-3"></i>
                    Recognition Certificates
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.student.approvals') }}">
                    <i class="fas fa-user-check fa-2x mr-3"></i>
                    Student Approvals
                    @php
                        $pendingApprovalCount = \App\Models\StudentRegistration::where('status', 'Pending Admin Approval')->count();
                    @endphp
                    @if($pendingApprovalCount > 0)
                        <span class="badge badge-danger ml-2" style="border-radius:12px; font-size:11px; padding:3px 8px;">
                            {{ $pendingApprovalCount }}
                        </span>
                    @endif
                </a>
            </li>
        @endif

        @if (!Session('LoggedStudent'))
            <li class="slide">
                <a class="side-menu__item" href="{{ url('/school/dashboard') }}">
                    <i class="fa fa-home fa-2x mr-3"></i>
                    Dashboard
                </a>
            </li>

            <!-- Register Student -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('school.register.student') }}">
                    <i class="fas fa-user-plus fa-2x mr-3"></i>
                    Register Student
                </a>
            </li>

            {{-- ── NEW: School's own Recognition Certificate ── --}}
            <li class="slide">
                <a class="side-menu__item" href="{{ route('school.recognition.view') }}">
                    <i class="fas fa-certificate fa-2x mr-3"></i>
                    Recognition Certificate
                </a>
            </li>
        @endif

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
                window.location.href = '{{ route('student-logout') }}';
            }
        });
    });
</script>

<!--aside closed-->