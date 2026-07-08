@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.iteb-grading-buttons')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-white" style="background-color:#9d1a68;">
                        <h4 class="mb-0"><i class="fa fa-users me-2"></i> Bulk Student Import</h4>
                    </div>

                    <div class="card-body bg-light">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-1"></i>
                            Use this page to import a whole class of students at once for a given year/category/school —
                            <strong>Student_ID is generated automatically</strong>, so you only need names and basic
                            details. Do this <strong>before</strong> Subject Registration, since that page needs the
                            students to already exist.
                        </div>

                        <form id="selectForm" method="GET" action="{{ route('student.bulk.import.manage') }}">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label><strong>Select Year</strong></label>
                                    <select name="year" class="form-control select2" required>
                                        <option value="">-- Select Year --</option>
                                        @for ($year = 2024; $year <= 2026; $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label><strong>Select Category</strong></label>
                                    <select name="category" class="form-control select2" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $code => $label)
                                            <option value="{{ $code }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label><strong>Select School</strong></label>
                                    <select name="school_id" class="form-control select2" required>
                                        <option value="">-- Select School --</option>
                                        @foreach ($houses as $house)
                                            <option value="{{ $house->ID }}">{{ $house->House }} ({{ $house->Number }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn text-white px-5" style="background-color:#9d1a68;">
                                    <i class="fa fa-upload me-2"></i> Open Import Page
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('selectForm').addEventListener('submit', function () {
            Swal.fire({
                title: 'Loading…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
        });
    </script>
@endsection