<?php
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper;
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
            <h4 class="page-title" style="text-align: center;">Account Information</h4>
            <div class="table-responsive">


                <table id="table" class="table table-bordered table-striped" style="clear: both">
                    <tbody>

                        <tr>
                            <td width="35%" style="font-weight: bold;">Username</td>
                            <td width="65%">
                                <p>{{ @$user_profile_data->username }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="35%" style="font-weight: bold;">Firstname</td>
                            <td width="65%">
                                <p>{{ @$user_profile_data->firstname }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Lastname</td>
                            <td>
                                <p>{{ @$user_profile_data->lastname }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Email</td>
                            <td>
                                <p>{{ @$user_profile_data->email }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Gender</td>
                            <td>
                                <p>{{ @$user_profile_data->gender }}</p>
                            </td>
                        <tr>

                            <td style="font-weight: bold;">Phonenumber</td>
                            <td>
                                <p>{{ @$user_profile_data->phonenumber }}</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Account Status</td>
                            <td>
                                @if (@$user_profile_data->account_status == 10)
                                    <p>Active</p>
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <td style="font-weight: bold;">Country</td>
                            <td>
                                <p>{{ @$user_profile_data->country }}</p>
                            </td>
                        </tr>



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
