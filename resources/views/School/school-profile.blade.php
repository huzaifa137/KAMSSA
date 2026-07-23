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
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card shadow-lg">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $school->name }} Profile</h4>
                        <a href="{{ route('school.allSchools') }}" class="btn text-white" style="background-color: #287C44;">
                            <i class="fas fa-school me-2"></i> All Schools
                        </a>
                    </div>

                    <div class="card-body row">
                        <div class="col-12 mb-4">
                            <div class="card p-4 shadow-sm border rounded">
                                <h4 class="mb-4 text-center">School Logo</h4>

                                <div class="p-3 border rounded bg-light">
                                    <div class="text-center mb-4">
                                        <img id="logoPreview"
                                            src="{{ $profile?->logo ? asset('storage/' . $profile->logo) : $school->logo ?? asset('assets/images/brand/uplogolight.png') }}"
                                            class="img-fluid rounded border p-2"
                                            style="max-height: 180px; object-fit: contain;" alt="School Logo">
                                    </div>

                                    <form method="POST" action="{{ route('schools.store.profile') }}"
                                        enctype="multipart/form-data" id="updateSchoolForm">
                                        @csrf
                                        @method('POST')

                                        <input type="hidden" name="school_id" value="{{ $school->id }}">

                                        <div class="form-group mb-4">
                                            <label class="form-label">Upload New Logo</label>
                                            <input type="file" name="logo" id="logoUpload" class="form-control"
                                                accept="image/*" onchange="previewLogo(event)">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="schoolName" class="form-label">School Name</label>
                                                    <input type="text" name="name" id="schoolName"
                                                        class="form-control" value="{{ $profile->name ?? $school->name }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="schoolEmail" class="form-label">Email Address</label>
                                                    <input type="email" name="email" id="schoolEmail"
                                                        class="form-control"
                                                        value="{{ $profile->email ?? $school->email }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="schoolType" class="form-label">Postal Address</label>
                                                    <input type="text" name="school_type" id="schoolType"
                                                        class="form-control" placeholder="P.O BOX 000-00100 Kampala"
                                                        value="{{ $profile->school_type ?? '' }}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">Boarding Status</label>
                                                    <?php
                                                    echo Helper::DropMasterData(config('constants.options.SCHOOL_GENDER'), $profile->boarding_status ?? $school->boarding_status, 'boarding_status', 1);
                                                    ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="schoolPopulation" class="form-label">Mission</label>
                                                    <textarea name="population" id="schoolPopulation" class="form-control" rows="4" maxlength="300"
                                                        placeholder="Enter your mission here...">{{ $profile->population ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="registrationCode" class="form-label">School Name (Short
                                                        Version)</label>
                                                    <input type="text" name="registration_code" id="registrationCode"
                                                        class="form-control"
                                                        value="{{ $profile->registration_code ?? '' }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="schoolPhone" class="form-label">Phone Number</label>
                                                    <input type="text" name="phone" id="schoolPhone"
                                                        class="form-control"
                                                        value="{{ $profile->phone ?? $school->phone }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="schoolGender" class="form-label">Gender</label>
                                                    <?php
                                                    echo Helper::DropMasterData(config('constants.options.SCHOOL_GENDER'), $profile->gender ?? $school->gender, 'gender');
                                                    ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="schoolMotto" class="form-label">School Motto</label>
                                                    <input type="text" name="motto" id="schoolMotto"
                                                        class="form-control" value="{{ $profile->motto ?? '' }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="schoolVision" class="form-label">Vision</label>
                                                    <textarea name="vision" id="schoolVision" class="form-control" rows="4" maxlength="300"
                                                        placeholder="Enter your vision here...">{{ $profile->vision ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="admissionPrefix" class="form-label">Admission
                                                                Number Prefix</label>
                                                            <input type="text" name="admission_prefix"
                                                                id="admissionPrefix" class="form-control"
                                                                placeholder="e.g ADMNO/"
                                                                value="{{ $profile->admission_prefix ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="admissionStart" class="form-label">Admission
                                                                Number Begins At</label>
                                                            <input type="text" name="admission_start"
                                                                id="admissionStart" class="form-control"
                                                                placeholder="e.g 0001/"
                                                                value="{{ $profile->admission_start ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-0">
                                                            <label for="admissionSuffix" class="form-label">Admission
                                                                Number Suffix</label>
                                                            <input type="text" name="admission_suffix"
                                                                id="admissionSuffix" class="form-control"
                                                                placeholder="e.g /2025"
                                                                value="{{ $profile->admission_suffix ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <i class="fas fa-save me-2"></i> Update School Profile Details
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <style>
                                    .form-control[type="file"] {
                                        padding: 0.2rem 0.2rem;
                                        width: 100%;
                                        font-size: 1rem;
                                        font-weight: 400;
                                        line-height: 1.5;
                                        color: #212529;
                                        background-color: #fff;
                                        border: 1px solid #ced4da;
                                        border-radius: 0.25rem;
                                        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                                        display: block;
                                        height: calc(1.5em + 0.75rem + 2px);
                                        box-sizing: border-box;
                                    }

                                    @media (max-width: 575.98px) {
                                        .form-control[type="file"] {
                                            min-width: unset;
                                        }
                                    }
                                </style>
                            </div>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="col-md-12">
                            <h4 class="text-center text-primary">{{ $school->name }} Information</h4>

                            <!-- School Info Table -->
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $school->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Registration Code</th>
                                        <td>{{ $school->registration_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $school->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $school->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>School Type</th>
                                        <td>{{ Helper::recordMdname($school->school_type) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ Helper::recordMdname($school->gender) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Regional Level</th>
                                        <td>{{ Helper::recordMdname($school->regional_level) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ownership</th>
                                        <td>{{ Helper::recordMdname($school->school_ownership) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Boarding Status</th>
                                        <td>{{ Helper::recordMdname($school->boarding_status) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Products</th>
                                        <td>{{ Helper::recordMdname($school->school_product) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Population</th>
                                        <td>{{ Helper::recordMdname($school->population) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date Added</th>
                                        <td>{{ \Carbon\Carbon::parse($school->date_added)->format('F j, Y') }}</td>
                                    </tr>
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
                $form.find('.invalid-feedback').remove(); 

                $form.find('input, select, textarea').each(function() {
                    if ($(this).attr('name') === 'logo') {
                        return true; 
                    }

                    if (!$(this).val().trim()) {
                        $(this).addClass('is-invalid');
                        $(this).after(
                        '<div class="invalid-feedback">This field is required.</div>');
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
                    text: "You are about to update the school profile.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData($form[0]);

                        $submitBtn.prop('disabled', true);
                        const originalBtnHtml = $submitBtn.html();
                        $submitBtn.html('Saving...<i class="fas fa-spinner fa-spin ms-2"></i>');

                        $.ajax({
                            url: '{{ route('schools.store.profile') }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Updated!',
                                    text: response.message ||
                                        'School profile updated successfully.',
                                    icon: 'success'
                                }).then((result) => {
                                    if (result.isConfirmed || result.dismiss ===
                                        Swal.DismissReason.timer || result
                                        .dismiss === Swal.DismissReason.backdrop
                                    ) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    let errorMessage = '';
                                    for (let field in errors) {
                                        errorMessage += errors[field].join('<br>') +
                                            '<br>';
                                    }
                                    Swal.fire('Validation Error', errorMessage,
                                        'error');
                                } else {
                                    Swal.fire('Error',
                                        'Something went wrong while updating. Please try again.',
                                        'error');
                                    console.error(xhr.responseText);
                                }
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

    <!-- JS to Preview Logo -->
    <script>
        function previewLogo(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('logoPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
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
