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
            <h4 class="page-title" style="text-align: center;">HEAD OF PROJECT/UNITS/DIVISIONS</h4>
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h3 class="heading">
                            <?php
                            
                            use App\Http\Controllers\Helper;
                            use App\Http\Controllers\MasterApproval;
                            use App\Http\Controllers\Controller;
                            $controller = new Controller();
                            
                            use App\Http\Controllers\TravelAuthorisationFormController;
                            $links = TravelAuthorisationFormController::links();
                            
                            $url = url()->current();
                            $url_parts = explode('/', $url);
                            $method = ucwords(str_replace(' ', ' ', lcfirst(str_replace('-', ' ', strtolower(@$url_parts[4])))));
                            
                            ?>
                        </h3>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">

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


                                <link rel="stylesheet" href="/assets/lib/multi-select/css/multi-select.css" />

                                <script src="/assets/lib/multi-select/js/jquery.multi-select.js"></script>
                                <script src="/assets/lib/multi-select/js/jquery.quicksearch.js"></script>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#searchable').multiSelect();
                                        $('#select_all').click(function() {
                                            $('#searchable').multiSelect('select_all');
                                        });
                                        $('#deselect_all').click(function() {
                                            $('#searchable').multiSelect('deselect_all');
                                        });
                                    });
                                </script>

                                <input type="hidden" value="{{ $role }}" id="role" />
                                @if (!$isHead)
                                    <div class="col-sm-12 col-md-12">
                                        <p><span class="label label-default">Pending Users</span></p>
                                        <select id="searchable" multiple="multiple">
                                            @foreach ($users as $user)
                                                @if (in_array($user->id, $ex))
                                                    <option selected value="{{ $user->id }}">
                                                        {{ Helper::full_name($user->id) }}</option>
                                                @else
                                                    <option value="{{ $user->id }}">{{ Helper::full_name($user->id) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-md-6"><br />
                                        <div class="btn btn-xs btn-warning pull-left" id="select_all">Select All</div>
                                        <div class="btn btn-xs btn-warning pull-right" id="deselect_all">Deselect All</div>
                                    </div>
                                    <div class="col-sm-6 col-md-6"><br />
                                        <div class="btn btn-primary pull-right" id="saveChanges"><i
                                                class="fa fa-fw fa-save"></i> Save Changes</div>
                                    </div>
                                @else
                                    <table id="table" border="1">
                                        <tr>
                                            <th style="width:30px;">No.</th>
                                            <th>Code</th>
                                            <th>Project/Unit/Division</th>
                                            <th>Head</th>
                                        </tr>

                                       

                                    </table>
                                @endif

                               

                            </div>
                        </div>
                    </div>
                </div>
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
