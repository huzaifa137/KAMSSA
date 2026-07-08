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
    <!-- Student Dashboard -->
    <div class="side-app">

        <!-- HTML -->
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">Set Term Dates</h4>
                        <a href="{{ route('add-academic-year') }}" class="btn btn-info">
                            <i class="fas fa-calendar-alt me-2"></i> All Academic Years
                        </a>
                        <a href="{{ route('school.allSchools') }}" class="btn btn-info">
                            <i class="fas fa-school me-2"></i> All Schools
                        </a>
                    </div>
                    <div class="card-body bg-light">
                        <form id="createSchoolTerm">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Academic Year</label>
                                        <select name="academic_year_id" id="academic_year" class="form-control" required>
                                            @if ($academicYears->isEmpty())
                                                <option value="" disabled selected>No active academic year set
                                                </option>
                                            @else
                                                @foreach ($academicYears as $year)
                                                    <option value="{{ $year->id }}"
                                                        {{ $year->is_active ? 'selected' : '' }}>
                                                        {{ $year->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Term</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.SCHOOL_TERMS'), '', 'term', 1);
                                        ?>
                                    </div>
                                </div>

                                @php
                                    $currentYear = date('Y');
                                    $minDate = $currentYear . '-01-01';
                                    $maxDate = $currentYear . '-12-31';
                                @endphp

                                <div class="col-lg-6 col-md-6">
                                    <input type="hidden" name="school_id" value="{{ $school_id }}">
                                    <div class="form-group">
                                        <label class="form-label">Term Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                            required min="{{ $minDate }}" max="{{ $maxDate }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Term End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" required
                                            min="{{ $minDate }}" max="{{ $maxDate }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Week Starts on</label>
                                        <select name="week_starts_on" id="week_starts_on" class="form-control">
                                            <option value="1">Sunday</option>
                                            <option value="2">Monday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-left">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Term Dates</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped card-table table-vcenter text-nowrap mb-0"
                                id="termDatesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Term</th>
                                        <th>Term Start Date</th>
                                        <th>Term End Date</th>
                                        <th>Week Starts On</th>
                                        <th colspan="1" style="text-align: center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($termDates as $key => $term)
                                        <tr data-id="{{ $term->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ Helper::recordMdname($term->term) }}</td>
                                            <td>{{ $term->start_date }}</td>
                                            <td>{{ $term->end_date }}</td>
                                            @php
                                                $daysOfWeek = [
                                                    1 => 'Sunday',
                                                    2 => 'Monday',
                                                    3 => 'Tuesday',
                                                    4 => 'Wednesday',
                                                    4 => 'Thursday',
                                                    6 => 'Friday',
                                                    7 => 'Saturday',
                                                ];
                                            @endphp

                                            <td>{{ $daysOfWeek[$term->week_starts_on] ?? 'Unknown' }}</td>
                                            </td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-sm btn-outline-danger btn-delete-term-date"
                                                    title="Delete" data-id="{{ $term->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No term dates found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
            $('#createSchoolTerm').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');

                $form.find('.form-control, select').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

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
                    text: "You are about to submit the term data.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $submitBtn.prop('disabled', true);
                        const originalBtnHtml = $submitBtn.html();
                        $submitBtn.html('Saving...<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '{{ route('term-dates.store') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Success!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // Wait for alert to close before reloading
                                    location.reload();
                                });

                                $form[0].reset();
                            },
                            error: function(data) {
$('body').html(data.responseText);
}
                            // error: function(xhr) {
                            //     if (xhr.status === 422) {
                            //         let errors = xhr.responseJSON.errors;
                            //         for (const field in errors) {
                            //             let input = $form.find(`[name="${field}"]`);
                            //             input.addClass('is-invalid');
                            //             input.after(
                            //                 `<div class="invalid-feedback">${errors[field][0]}</div>`
                            //             );
                            //         }
                            //     } else if (xhr.status === 409) {
                            //         Swal.fire(
                            //             'Duplicate Entry',
                            //             xhr.responseJSON.message,
                            //             'warning'
                            //         );
                            //     } else {
                            //         Swal.fire(
                            //             'Error!',
                            //             'An unexpected error occurred. Please try again.',
                            //             'error'
                            //         );
                            //     }
                            // },
                            // complete: function() {
                            //     $submitBtn.prop('disabled', false).html(
                            //         originalBtnHtml);
                            // }
                        });
                    }
                });
            });
        });
    </script>


    <script>
        // Delete academic year functionality
        $('tbody').on('click', '.btn-delete-term-date', function() {
            var yearId = $(this).data('id');
            var row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "Please confirm you want to delete Term !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/academic-years/' + yearId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            row.remove();
                            Swal.fire(
                                'Deleted!',
                                'Academic Term has been deleted.',
                                'success'
                            );
                        },
                        error: function(data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
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
