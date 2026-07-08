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
    <div class="side-app">

        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center  bg-primary">
                <h4 class="card-title mb-0 text-white">Configure School Options</h4>
                <a href="{{ route('school.allSchools') }}" class="btn btn-info">
                    <i class="fas fa-school me-2"></i> All Schools
                </a>
            </div>
            <div class="card-body p-5">
                <div class="row gx-5">

                    <div class="col-md-6 border-end border-primary border-3 pe-md-5">
                        <h5 class="text-primary mb-4 pb-2 border-bottom">All School Options</h5>
                        @forelse ($masterDataDetails as $index => $masterData)
                            <div
                                class="pb-3 {{ $index < count($masterDataDetails) - 1 ? 'mb-4 border-bottom border-secondary-subtle' : '' }}">
                                <h6 class="fw-bold text-dark">{{ $masterData['name'] }}</h6>
                                <p class="text-muted small mb-0">{{ $masterData['description'] }}</p>
                            </div>
                        @empty
                            <div class="alert alert-info border-0 text-center py-3" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i> No specific school options are defined yet.
                            </div>
                        @endforelse
                    </div>

                    <div class="col-md-6 ps-md-5">
                        <h5 class="text-primary mb-4 pb-2 border-bottom">Action</h5>

                        <form id="configureSchoolOptionsForm">
                            @csrf
                            @forelse ($allDynamicFields as $index => $field)
                                <div
                                    class="pb-3 {{ $index < count($allDynamicFields) - 1 ? 'mb-4 border-bottom border-secondary-subtle' : '' }}">
                                    <label for="{{ $field->field_name }}" class="form-label fw-semibold text-secondary">
                                        {{ ucfirst(str_replace(['dynamic_', '_'], ['', ' '], $field->field_name)) }}
                                    </label>
                                    @if ($field->field_type === 'input')
                                        <input type="text" class="form-control form-control-sm"
                                            id="{{ $field->field_name }}" name="{{ $field->field_name }}"
                                            value="{{ $field->field_value ?? '' }}" data-id="{{ $field->id }}"
                                            @if ($field->field_name !== 'school_name') readonly @endif>
                                    @elseif ($field->field_type === 'textarea')
                                        <textarea class="form-control form-control-sm" id="{{ $field->field_name }}" name="{{ $field->field_name }}"
                                            rows="3" data-id="{{ $field->id }}" readonly>{{ $field->field_value ?? '' }}</textarea>
                                    @elseif ($field->field_type === 'select')
                                        <select class="form-control form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}" data-id="{{ $field->id }}">
                                            @if (is_array($field->field_options))
                                                @foreach ($field->field_options as $option)
                                                    <option value="{{ $option['value'] }}"
                                                        @if ($option['value'] == $field->field_value) selected @endif>
                                                        {{ $option['text'] }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="{{ $field->field_value }}" selected>
                                                    {{ $field->field_value }}
                                                </option>
                                            @endif
                                        </select>
                                    @endif
                                </div>
                            @empty
                                <div class="alert alert-info border-0 text-center py-3" role="alert">
                                    <i class="bi bi-info-circle-fill me-2"></i> No dynamic custom fields have been added.
                                </div>
                            @endforelse

                            <div class="mt-4 text-right">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <i class="fas fa-save me-2"></i> Save School Options
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#configureSchoolOptionsForm').on('submit', function(e) {
                    e.preventDefault();

                    let isValid = true;
                    let $form = $(this);
                    let $submitBtn = $form.find('button[type="submit"]');

                    $form.find('.form-control, select').removeClass('is-invalid');

                    let dynamicFieldsData = [];
                    $form.find('input, textarea, select').each(function() {
                        let $this = $(this);
                        let fieldId = $this.data('id');
                        let fieldName = $this.attr('name');
                        let fieldValue = $this.val();

                        if (fieldId) {

                            if ($this.prop('required') && !fieldValue
                                .trim()) {
                                $this.addClass('is-invalid');
                                if ($this.next('.invalid-feedback').length === 0) {
                                    $this.after(
                                        '<div class="invalid-feedback">This field is required.</div>'
                                    );
                                }
                                isValid = false;
                            }
                            dynamicFieldsData.push({
                                id: fieldId,
                                name: fieldName,
                                value: fieldValue
                            });
                        }
                    });

                    let formDataToSend = {
                        _token: $form.find('input[name="_token"]').val(),
                        dynamic_fields: dynamicFieldsData
                    };


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
                        text: "You are about to save the school options.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, save it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $submitBtn.prop('disabled', true);
                            const originalBtnHtml = $submitBtn.html();
                            $submitBtn.html('Saving...<i class="fas fa-spinner fa-spin"></i>');

                            $.ajax({
                                url: '{{ route('school.configure') }}',
                                method: 'POST',
                                data: formDataToSend,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Saved!',
                                        'School options have been configured successfully.',
                                        'success'
                                    );
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
                $('#dynamic_school_name').prop('readonly', false);
            });
        </script>

    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
