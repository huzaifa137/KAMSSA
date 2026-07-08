<!-- Horizontal-menu -->
<div class="horizontal-main hor-menu clearfix">
    <div class="horizontal-mainwrapper container clearfix">

        <!-- Add Font Awesome CDN link in your <head> -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">

                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-users hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Users <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/users/users-register') }}">Register new User</a></li>
                        <li><a href="{{ url('/users/users-information') }}">View users information</a></li>
                    </ul>
                </li>

                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-sliders-h hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Settings <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('master-data/master-code-list') }}">Master Code</a></li>
                        <li><a href="{{ url('master-data/master-code-to-data') }}">Master Data</a></li>
                    </ul>
                </li>

                <li class="logout-item" style="float: right;">
                    <a href="{{ route('admin-logout') }}" class="logout-link"
                        style="display: flex; align-items: center;">
                        <i class="fas fa-sign-out-alt hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('admin-logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const logoutLink = document.querySelector('.logout-link');
                        logoutLink.addEventListener('click', function (e) {
                            e.preventDefault(); // prevent default link action

                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You will be logged out of the system!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, logout!',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Submit the logout form
                                    document.getElementById('logout-form').submit();
                                }
                            });
                        });
                    });
                </script>

            </ul>
        </nav>
        <!--Nav end -->
    </div>
</div>
<!-- Horizontal-menu end -->