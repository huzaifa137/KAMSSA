<?php
use App\Http\Controllers\Helper;
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="app-header header top-header">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand text-left" href="{{ url('/') }}">
                <div class="logo-wrapper" style="width: 200px; height: 50px; overflow: hidden;">
                    <img src="{{ $systemSettings->logo_url ?? URL::asset('assets/images/brand/logo.png') }}"
                        class="header-brand-img desktop-lgo" alt="{{ $systemSettings->short_name ?? 'System' }} logo"
                        style="width: 100%; height: 100%; object-fit:contain;">
                </div>
            </a>

            <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>

            <div class="d-flex order-lg-2 ml-auto">
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch">
                    <svg class="header-icon search-icon" x="1008" y="1248" viewBox="0 0 24 24" height="100%"
                        width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                    </svg>
                </a>
                
                <style>
                    .google-avatar-sm {
                        width: 40px;
                        height: 40px;
                        background-color: #287C44;
                        color: white;
                        font-size: 16px;
                        font-weight: bold;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        text-transform: uppercase;
                    }

                    .nav-link .google-avatar-sm {
                        vertical-align: middle;
                    }
                </style>


                <div class="dropdown profile-dropdown">


                    {{-- @php
                        $user = null;

                        if (session()->has('LoggedAdmin')) {
                            $user = DB::table('users')->where('id', session('LoggedAdmin'))->first();
                        } elseif (session()->has('LoggedStudent')) {
                            $user = DB::table('users')->where('id', session('LoggedStudent'))->first();
                        }

                        $initial = strtoupper(substr($user->username, 0, 1));
                        $FL = strtoupper(substr($user->firstname, 0, 1));
                        $LL = strtoupper(substr($user->lastname, 0, 1));
                    @endphp --}}

                    <a href="#" class="nav-link pr-0 leading-none text-primary" data-toggle="dropdown">
                        <span>
                            {{-- @if ($user->firstname && $user->lastname)
                                <div class="google-avatar-sm">
                                    {{ $FL }}{{ $LL }}
                                </div>
                            @elseif ($user->username)
                                <div class="google-avatar-sm">
                                    {{ $initial }}
                                </div>
                            @endif --}}
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                        <div class="text-center">
                            <a href="#"
                                class="dropdown-item text-center user pb-0 font-weight-bold">{{ Helper::active_user() }}</a>
                            {{-- @if ($user->user_role == 1)
                                <span class="text-center user-semi-title">Enrolled Student</span>
                            @else
                                <span class="text-center user-semi-title">Admin</span>
                            @endif --}}
                            <div class="dropdown-divider"></div>
                        </div>
                        <a class="dropdown-item d-flex" href="{{ route('users-profile') }}">
                            <svg class="header-icon mr-3" x="1008" y="1248" viewBox="0 0 24 24" height="100%"
                                width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                <path d="M0 0h24v24H0V0z" fill="none" />
                                <path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3" />
                                <circle cx="12" cy="8" opacity=".3" r="2" />
                                <path
                                    d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" />
                            </svg>
                            <div class="mt-1">Profile</div>
                        </a>

                        @if (Session('LoggedAdmin'))
                            <a class="dropdown-item d-flex" href="{{ route('system-configuration.index') }}">
                                <i class="fa fa-cogs mr-3"></i>
                                <div class="mt-1">System Configuration</div>
                            </a>
                        @endif


                        <a class="dropdown-item d-flex" href="#" onclick="confirmLogout(event)">
                            <svg class="header-icon mr-3" x="1008" y="1248" viewBox="0 0 24 24" height="100%"
                                width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                <path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none" />
                                <path d="M6 20h12V10H6v10zm2-6h3v-3h2v3h3v2h-3v3h-2v-3H8v-2z" opacity=".3" />
                                <path
                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM8.9 6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H8.9V6zM18 20H6V10h12v10zm-7-1h2v-3h3v-2h-3v-3h-2v3H8v2h3z" />
                            </svg>
                            <div class="mt-1">Sign Out</div>
                        </a>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmLogout(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Sign Out',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('user-logout') }}';
            }
        });
    }
</script>
<!--/app header-->
