<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
@section('content')
    <div class="side-app">

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.subjects-buttons')
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        <h4 class="text-white mb-0">Search Students</h4>
                    </div>
                    <div class="card-body bg-light">
                        <form id="studentSearchForm">
                            <div class="form-group mb-3">
                                <label for="search_criteria">Select Search Criteria</label>
                                <select id="search_criteria" class="form-control">
                                    <option value="" selected disabled>Select...</option>
                                    <option value="admission_number">Admission Number</option>
                                    <option value="name">Student Full Name</option>
                                    {{-- <option value="phone">Phone Number</option> --}}
                                    {{-- <option value="student_id">Student ID</option> --}}
                                </select>
                            </div>

                            <div id="search_inputs">
                                <!-- Dynamically populated fields here -->
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn d-none text-white" id="searchBtn"
                                    style="background-color:#287C44;">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Results -->
                <div class="card mt-4 d-none" id="resultsCard">
                    <div class="card-header text-white" style="background-color:#026837;">
                        <h5 class="mb-0">Search Results</h5>
                    </div>
                    <div class="card-body bg-white" id="searchResults">
                        <!-- Results will be rendered here -->
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            const searchInputs = {
                admission_number: `
                                    <div class="form-group">
                                        <label for="admission_number">Admission Number</label>
                                        <input type="text" name="admission_number" class="form-control" placeholder="Enter admission number">
                                    </div>
                                `,
                name: `
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" class="form-control" placeholder="Enter first name">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname" class="form-control" placeholder="Enter last name">
                                    </div>
                                `,
                phone: `
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                                    </div>
                                `,
                student_id: `
                                    <div class="form-group">
                                        <label for="student_id">Student ID</label>
                                        <input type="number" name="student_id" class="form-control" placeholder="Enter student ID">
                                    </div>
                                `
            };

            $('#search_criteria').on('change', function () {
                const selected = $(this).val();
                $('#search_inputs').html(searchInputs[selected] || '');
                $('#searchBtn').removeClass('d-none');
                $('#resultsCard').addClass('d-none');
            });

            $('#studentSearchForm').on('submit', function (e) {
                e.preventDefault();

                const criteria = $('#search_criteria').val();
                const formData = $(this).serialize();

                if (!criteria) {
                    Swal.fire('Error', 'Please select a search criteria.', 'error');
                    return;
                }

                $('#searchBtn').prop('disabled', true).html(
                    'Searching... <i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '{{ route('students.search.ajax') }}',
                    method: 'GET',
                    data: formData + '&criteria=' + criteria,
                    success: function (response) {
                        $('#resultsCard').removeClass('d-none');
                        $('#searchResults').html(response.html);
                    },
                    // error: function (xhr) {
                    //     Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong.', 'error');
                    // },
                    error: function (data) {
                        $('body').html(data.responseText);
                    },
                    complete: function () {
                        $('#searchBtn').prop('disabled', false).html(
                            '<i class="fas fa-search"></i> Search');
                    }
                });
            });
        });
    </script>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script></script>
@endsection