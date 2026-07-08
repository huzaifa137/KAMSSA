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

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">Edit School Information</h4>
                        <a href="{{ route('school.allSchools') }}" class="btn text-white" style="background-color: #c51619;">
                            <i class="fas fa-school me-2"></i> All Schools
                        </a>
                    </div>
                    <div class="card-body bg-light">
                        <form id="updateSchoolForm">
                            <div class="row">
                                <input type="hidden" name="school_id" value="{{ $school_id }}">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">School Type</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.SCHOOL_TYPE'), $school->school_type, 'school_type');
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-email">Email</label>
                                        <input type="email" id="example-email" name="email" class="form-control"
                                            placeholder="Email" value="{{ $school->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Gender</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.SCHOOL_GENDER'), $school->gender, 'gender');
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Regional Level</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.REGIONAL_LEVEL'), $school->regional_level, 'regional_level');
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">School Ownership</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.SCHOOL_OWNERSHIP'), $school->school_ownership, 'school_ownership', 1);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Boarding Status</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.SCHOOL_GENDER'), $school->boarding_status, 'boarding_status', 1);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">School Name</label>
                                        <input class="form-control" type="text" name="name"
                                            value="{{ $school->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">School Products</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.SCHOOL_PRODUCTS'), $school->school_product, 'school_product', 1);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Registration Code</label>
                                        <input class="form-control" type="search" name="registration_code"
                                            value="{{ $school->registration_code }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Contact Phone Number</label>
                                        <input class="form-control" type="tel" name="phone"
                                            value="{{ $school->phone }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label">Population</label>
                                        <?php
                                        echo Helper::DropMasterDataAsc(config('constants.options.SCHOOL_POPULATION'), $school->population, 'population', 1);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-left">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Update Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#updateSchoolForm').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');

                $form.find('.form-control, select').removeClass('is-invalid');

                $form.find('input, select').each(function() {
                    if (!$(this).val().trim()) {
                        $(this).addClass('is-invalid');

                        if ($(this).next('.invalid-feedback').length === 0) {
                            $(this).after(
                                '<div class="invalid-feedback">This field is required.</div>');
                        }

                        isValid = false;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Form',
                        text: 'Please fill in all required fields before submitting.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to update the school data.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $submitBtn.prop('disabled', true);
                        const originalBtnHtml = $submitBtn.html();
                        $submitBtn.html('Updating...<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '{{ route('update.school') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Success!',
                                    'School has been updated successfully.',
                                    'success'
                                );
                                $form[0].reset();
                            },
                            error: function(data) {
                                $('body').html(data.responseText);
                            },
                            complete: function() {
                                $submitBtn.prop('disabled', false).html(
                                    originalBtnHtml);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
@section('js')
    <!-- c3.js Charts js-->
    <script src="{{ URL::asset('assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/charts-c3/c3-chart.js') }}"></script>
    <script src="{{ URL::asset('assets/js/charts.js') }}"></script>

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
