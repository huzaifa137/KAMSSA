<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <br> <br>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12">

            <style>
                .google-avatar {
                    width: 80px;
                    height: 80px;
                    background-color: #287C44;
                    color: white;
                    font-size: 36px;
                    font-weight: bold;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .google-avatar {
                    width: 80px;
                    height: 80px;
                    background-color: #287C44;
                    color: white;
                    font-size: 36px;
                    font-weight: bold;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
            </style>
            <div class="card box-widget widget-user">
                @php
                    $initial = strtoupper(substr($user->username, 0, 1));
                @endphp

                <div class="widget-user-image mx-auto mt-5">
                    <div class="google-avatar">
                        {{ $initial }}
                    </div>
                </div>

                <div class="card-body text-center">
                    <div class="pro-user">
                        @if ($user->username != null)
                            <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{ $user->username }}</h4>
                        @elseif ($user->firstname != null && $user->lastname != null)
                            <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{ $user->firstname }}
                                {{ $user->lastname }}</h4>
                        @endif
                        @if ($user->user_role == 1)
                            <h6 class="pro-user-desc text-muted">Enrolled as : Student</h6>
                        @else
                            <h6 class="pro-user-desc text-muted">Enrolled as : Admin</h6>
                        @endif
                        @if ($user->account_status == 10)
                            <a href="#" class="btn btn-success btn-sm mt-3">
                                <i class="fas fa-check-circle"></i> Account Status: Active
                            </a>
                        @elseif ($user->account_status == 0)
                            <a href="#" class="btn btn-danger btn-sm mt-3">
                                <i class="fas fa-ban"></i> Account Status: Banned
                            </a>
                        @elseif ($user->account_status == 8)
                            <a href="#" class="btn btn-secondary btn-sm mt-3">
                                <i class="fas fa-lock"></i> Account Status: Locked
                            </a>
                        @elseif ($user->account_status == 9)
                            <a href="#" class="btn btn-warning btn-sm mt-3 text-white">
                                <i class="fas fa-exclamation-triangle"></i> Account Status: Suspended
                            </a>
                        @endif


                    </div>
                </div>
                <div class="card-footer p-0">
                    <div class="row">
                        <div class="col-sm-12 border-right text-center">
                            <div class="description-block p-4">
                                <h5 class="description-header mb-1 font-weight-bold">0</h5>
                                <span class="text-muted">Enrolled Courses</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="main-content-body main-content-body-profile card mg-b-20">
                <!-- main-profile-body -->
                <div class="main-profile-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="about">
                            <br>
                            <div class="col-xl-12 col-lg-12">
                                <div class="card border p-0 shadow-none">
                                    @php
                                        $initial = strtoupper(substr($user->username, 0, 1));
                                        $FL = strtoupper(substr($user->firstname, 0, 1));
                                        $LL = strtoupper(substr($user->lastname, 0, 1));
                                    @endphp

                                    <div class="d-flex align-items-center p-4">

                                        @if ($user->firstname != null && $user->lastname != null)
                                            <div class="google-avatar">
                                                {{ $FL }}{{ $LL }}
                                            </div>
                                        @elseif($user->username != null)
                                            <div class="google-avatar">
                                                {{ $initial }}
                                            </div>
                                        @endif

                                        <div class="wrapper ml-3">
                                            @if ($user->firstname != null && $user->lastname != null)
                                                <p class="mb-0 mt-1 text-dark font-weight-semibold">{{ $user->firstname }}
                                                    {{ $user->lastname }}</p>
                                            @elseif($user->username != null)
                                                <p class="mb-0 mt-1 text-dark font-weight-semibold">{{ $user->username }}
                                                </p>
                                            @endif

                                            @if ($user->user_role == 1)
                                                <small class="text-muted">Enrolled Student</small>
                                            @else
                                                <small class="text-muted">Enrolled Student</small>
                                            @endif
                                        </div>

                                        <div class="float-right ml-auto">
                                            <div class="btn-group ml-3 mb-0">
                                                <a href="{{ url('/student/edit-student-profile') }}"
                                                    class="btn btn-link p-0 d-flex align-items-center"
                                                    title="Edit Profile Information">
                                                    <i class="fe fe-edit mr-1"></i>
                                                    Edit Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body pt-2">
                                        <div class="d-flex mb-3">
                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                                viewBox="0 0 24 24" width="24">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3" />
                                                <path
                                                    d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z" />
                                            </svg>
                                            <div class="h6 mb-0 ml-3 mt-1">{{ $user->email }}</div>
                                        </div>

                                        <div class="d-flex">
                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                                viewBox="0 0 24 24" width="24">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M15.2 18.21c1.21.41 2.48.67 3.8.76v-1.5c-.88-.07-1.75-.22-2.6-.45l-1.2 1.19zM6.54 5h-1.5c.09 1.32.35 2.59.75 3.79l1.2-1.21c-.24-.83-.39-1.7-.45-2.58zM14 8h5V5h-5z"
                                                    opacity=".3" />
                                                <path
                                                    d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.1-.03-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.58l2.2-2.21c.28-.27.36-.66.25-1.01C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1zM5.03 5h1.5c.07.88.22 1.75.46 2.59L5.79 8.8c-.41-1.21-.67-2.48-.76-3.8zM19 18.97c-1.32-.09-2.6-.35-3.8-.76l1.2-1.2c.85.24 1.72.39 2.6.45v1.51zM12 3v10l3-3h6V3h-9zm7 5h-5V5h5v3z" />
                                            </svg>
                                            @if ($user->phonenumber)
                                                <div class="h6 mb-0 ml-3 mt-1">{{ $user->phonenumber }}</div>
                                            @else
                                                <div class="h6 mb-0 ml-3 mt-1">-</div>
                                            @endif
                                        </div>
                                        <div class="d-flex mt-2">
                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                                viewBox="0 0 24 24" width="24" fill="currentColor">
                                                <path
                                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                                                <path d="M0 0h24v24H0z" fill="none" />
                                            </svg>
                                            @if ($user->country)
                                                <div class="h6 mb-0 ml-3 mt-1">{{ $user->country }}</div>
                                            @else
                                                <div class="h6 mb-0 ml-3 mt-1">-</div>
                                            @endif
                                        </div>

                                        <div class="d-flex mt-2" style="color: #287C44;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                                height="24">
                                                <path
                                                    d="M12 2a5 5 0 0 1 5 5v1a5 5 0 0 1-10 0V7a5 5 0 0 1 5-5zm-3 13c-2.21 0-4 1.79-4 4v3h14v-3c0-2.21-1.79-4-4-4H9z" />
                                            </svg>
                                            @if ($user->gender)
                                                <div class="h6 mb-0 ml-3 mt-1"> <span
                                                        style="color: #424e79;">{{ $user->gender }}</span></div>
                                            @else
                                                <div class="h6 mb-0 ml-3 mt-1"> <span style="color: #424e79;">-</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
@endsection
@section('js')
    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection
