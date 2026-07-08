@extends('layouts-side-bar.master')

@section('content')

    <style>
        .swal2-container {
            z-index: 20000 !important;
        }

        .modal {
            z-index: 10500;
        }

        .modal-backdrop {
            z-index: 10400;
        }
    </style>
    <div class="side-app">
        <div class="card">

            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background-color:#026837;">

                <h4 class="card-title mb-0">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Academic Years Management
                </h4>
            </div>

            <div class="card-body bg-light">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="createYearForm">
                    @csrf

                    <div class="row">

                        <div class="col-md-4">
                            <label>Year (EN)</label>
                            <input type="text" name="year_en" class="form-control" placeholder="2026" required>
                        </div>

                        <div class="col-md-4">
                            <label>Year (AR)</label>
                            <input type="text" name="year_ar" class="form-control" placeholder="٢٠٢٦" required>
                        </div>

                        <div class="col-md-2">
                            <label>Status</label>

                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>&nbsp;</label>

                            <button type="submit" class="btn btn-block text-white" style="background-color:#c51619;">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="text-white" style="background-color:#026837;">

                            <tr>
                                <th style="width:1px;">#</th>
                                <th>Year EN</th>
                                <th>Year AR</th>
                                <th>Status</th>
                                <th width="180" style="text-align: center;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($years as $key => $year)

                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <strong>{{ $year->year_en }}</strong>
                                    </td>

                                    <td style="font-size:18px;">
                                        {{ $year->year_ar }}
                                    </td>

                                    <td>
                                        @if($year->status == 'Active')
                                            <span class="badge badge-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td style="text-align: center;">

                                        <button class="btn btn-sm text-white edit-btn" style="background-color:#c51619;"
                                            data-id="{{ $year->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('academic.years.delete', $year->id) }}" method="POST"
                                            style="display:inline-block;" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-sm btn-danger delete-btn">

                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No academic years added
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div class="modal fade" id="editYearModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title">Edit Academic Year</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="edit_id">

                        <div class="form-group">
                            <label>Year (EN)</label>
                            <input type="text" id="edit_year_en" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Year (AR)</label>
                            <input type="text" id="edit_year_ar" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select id="edit_status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn text-white" style="background-color:#c51619;" id="updateYearBtn">
                            Update
                        </button>
                    </div>

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
        $(document).ready(function () {

            // =========================
            // CREATE YEAR (NEW FIX)
            // =========================
            $('#createYearForm').submit(function (e) {
                e.preventDefault();

                let form = $(this);
                let btn = form.find('button[type="submit"]');

                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');

                $.ajax({
                    url: "{{ route('academic.years.store') }}",
                    type: "POST",
                    data: form.serialize(),

                    success: function (response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Academic year created successfully',
                            confirmButtonColor: '#c51619'
                        }).then(() => {
                            location.reload();
                        });

                    },

                    error: function (xhr) {

                        let message = 'Something went wrong';

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors).map(e => e[0]).join('\n');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: message,
                            confirmButtonColor: '#c51619'
                        });

                    },

                    complete: function () {
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-save"></i> Save');
                    }
                });
            });


            // =========================
            // DELETE
            // =========================
            $('.delete-btn').click(function (e) {
                e.preventDefault();

                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This academic year will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'Deleting...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();
                    }
                });
            });


            // =========================
            // EDIT
            // =========================
            $('.edit-btn').click(function () {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Edit Academic Year?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#c51619',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, edit it!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: '/academic-years/edit/' + id,
                            type: 'GET',

                            success: function (data) {

                                $('#edit_id').val(data.id);
                                $('#edit_year_en').val(data.year_en);
                                $('#edit_year_ar').val(data.year_ar);
                                $('#edit_status').val(data.status);

                                $('#editYearModal').modal('show');
                            },

                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to load record'
                                });
                            }
                        });
                    }
                });
            });


            // =========================
            // UPDATE
            // =========================
            $('#updateYearBtn').click(function () {

                let id = $('#edit_id').val();
                let btn = $(this);

                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i> Updating...');

                $.ajax({
                    url: '/academic-years/update/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        year_en: $('#edit_year_en').val(),
                        year_ar: $('#edit_year_ar').val(),
                        status: $('#edit_status').val()
                    },

                    success: function (response) {

                        $('#editYearModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message,
                            confirmButtonColor: '#c51619'
                        }).then(() => {
                            location.reload();
                        });
                    },

                    error: function (xhr) {

                        let message = 'Something went wrong';

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors).map(e => e[0]).join('\n');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: message
                        });
                    },

                    complete: function () {
                        btn.prop('disabled', false);
                        btn.html('Update');
                    }
                });

            });

        });
    </script>
@endsection