<!--app header-->
<div class="app-header header top-header">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="header-brand" href="<?php echo e(url('/' . ($page = '#'))); ?>">
                <img src="<?php echo e($systemSettings->logo_url ?? URL::asset('assets/images/brand/logo.png')); ?>"
                    class="header-brand-img desktop-lgo"
                    alt="<?php echo e($systemSettings->short_name ?? 'System'); ?> logo">
            </a>


            <?php
                use App\Http\Controllers\Helper;
            ?>

            <div class="dropdown side-nav">
                <div class="app-sidebar__toggle" data-toggle="sidebar">
                    <a class="open-toggle" href="#">
                        <svg class="header-icon mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                    <a class="close-toggle" href="#">
                        <svg class="header-icon mt-1" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="d-flex order-lg-2 ml-auto">
                <div class="display-name">
                    <?php if(Session('LoggedSchool')): ?>
                        <span style="line-height:40px;">
                            School :
                            <span class="text-primary font-weight-bold">
                                <?php echo e(Helper::schoolNameByID(Session('LoggedSchool'))); ?>

                            </span>
                        </span>
                    <?php else: ?>
                        <span style="line-height:40px;">
                            Role :
                            <span class="text-primary font-weight-bold">
                                <?php echo e(Helper::logged_admin_user()); ?>

                            </span>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="dropdown profile-dropdown">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <i class="fa fa-fw fa-cog fa-2x"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                        <div class="text-center">
                            <a href="#" class="dropdown-item text-center user pb-0 font-weight-bold">

                            </a>
                            <div class="dropdown-divider"></div>
                        </div>

                        <?php if(!Session('LoggedSchool')): ?>

                            <a class="dropdown-item d-flex" href="<?php echo e(url('academic-years')); ?>">
                                <i class="fas fa-clock fa-2x mr-3"></i>
                                <div class="mt-1">Academic Years</div>
                            </a>

                            <a class="dropdown-item d-flex" href="<?php echo e(route('system-configuration.index')); ?>">
                                <i class="fas fa-cogs fa-2x mr-3"></i>
                                <div class="mt-1">System Configuration</div>
                            </a>


                            <a class="dropdown-item d-flex"
                                href="<?php echo e(url('/update-teacher-profile', Session('LoggedStudent'))); ?>">
                                <i class="fa fa-user fa-2x mr-3"></i>
                                <div class="mt-1">User Profile</div>
                            </a>
                        <?php endif; ?>

                         <?php if(Session('LoggedSchool')): ?>
                            <a class="dropdown-item d-flex" href="#" data-toggle="modal" data-target="#passwordChangeModal">
                                <i class="fas fa-key fa-2x mr-3"></i>
                                <div class="mt-1">Update Password</div>
                            </a>
                        <?php endif; ?>
                        <a class="dropdown-item d-flex" href="#" id="logoutLink">
                            <i class="fa fa-sign-out fa-2x mr-3"></i>
                            <div class="mt-1">Sign Out</div>
                        </a>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            document.getElementById('logoutLink').addEventListener('click', function (event) {
                                event.preventDefault();

                                Swal.fire({
                                    title: "Are you sure?",
                                    text: "Do you really want to sign out?",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, Sign out",
                                    cancelButtonText: "Cancel",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '<?php echo e(route('student-logout')); ?>';
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/app header--><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/layouts-side-bar/header.blade.php ENDPATH**/ ?>