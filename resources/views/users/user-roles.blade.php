<?php
use App\Http\Controllers\Controller;
?>

@extends('layouts.master')

@section('css')
    <!-- Morris Charts css -->
    <link href="{{ URL::asset('assets/plugins/morris/morris.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <!--Row-->
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <h4 class="page-title" style="text-align: center;">USER ROLES</h4>
            <div class="table-responsive">

                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User Role</th>
                            {{-- <th>Total Users</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($user_data as $key => $item)
                            <tr>
                                <td style="width:30px;">{{ $key + 1 }}.</td>
                                <td>{{ $item->user_name }}</td>
                                {{-- <td>{{ Controller::totalRows('users_and_roles', 'uar_role_id', $item->id) }}</td> --}}
                                <td style="min-width:250px;">
                                    {{-- <a href="{{'view-users-and-roles/'.$item->id}}" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-users"></i>Add / View Users</a> --}}
                                    <a onclick="return confirm('Are you sure you want to edit this user_role ?')"
                                        href="{{ 'edit-role/' . $item->id }}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-fw fa-edit"></i>Edit</a>
                                    <a onclick="return confirm('Are you sure you want to delete this user role ?')"
                                        href="{{ 'delete-role/' . $item->id }}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-fw fa-trash"></i>Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!--End row-->



    <!--Row-->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">

        </div>
    </div>

    <!--End row-->
    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.checkAll').click(function() {
                var firstCheckBox = false;
                $('.all').each(function(index) {
                    if (index == 0) {
                        firstCheckBox = ($(this).is(':checked')) ? true : false;
                    }

                    if (!firstCheckBox)
                        $(this).attr('checked', true);
                    else
                        $(this).attr('checked', false);

                });
            });
            $('.checkAll2').click(function() {
                var firstCheckBox = false;
                $('.all2').each(function(index) {
                    if (index == 0) {
                        firstCheckBox = ($(this).is(':checked')) ? true : false;
                    }

                    if (!firstCheckBox)
                        $(this).attr('checked', true);
                    else
                        $(this).attr('checked', false);

                });
            });
        });
    </script>


    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/chart.extension.js') }}"></script>
    <!-- ECharts js-->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index2.js') }}"></script>
@endsection
