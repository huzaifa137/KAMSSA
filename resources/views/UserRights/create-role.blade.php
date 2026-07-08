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
                        @include('layouts.user-rights-headers')
                    </div>

                    <div class="card-body bg-light">
                        <form id="createSchoolForm">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Create Role</label>
                                        <input class="form-control" type="text" name="name" placeholder="Enter role name">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Role Scope</label>
                                        <select name="scope" id="scope" class="gender input-sm form-control">
                                            <option value="">-- Select --</option>
                                            <option value="School">School</option>
                                            <option value="System">System</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-4 text-left">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Save Role
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-info">
                        <h3 class="text-center pt-1 mt-1 text-white">All User Roles</h3>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped card-table table-vcenter text-nowrap mb-0" id="teachersTable">
                                <thead>
                                    <tr>
                                        <th style="width:1px;">#</th>
                                        <th class="text-center">Role Name</th>
                                        <th class="text-center">Scope</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $key => $role)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->scope }}</td>
                                            <td class="text-center">

                                                <button class="btn btn-sm btn-primary btn-edit-teacher" title="Edit"
                                                    data-id="{{ $role->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button class="btn btn-sm btn-danger btn-delete-teacher" title="Delete"
                                                    data-id="{{ $role->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No User Roles Found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <!-- Edit Role Modal -->
                                <div class="modal fade" id="editRoleModal" tabindex="-1"
                                    aria-labelledby="editRoleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="editRoleForm">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                                                    <button type="button" class="btn-close btn-danger"
                                                        data-bs-dismiss="modal" aria-label="Close">x</button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" id="editRoleId">

                                                    <div class="mb-3">
                                                        <label for="editRoleName" class="form-label">Role Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="editRoleName" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editRoleScope" class="form-label">Scope</label>
                                                        <select class="form-control" name="scope" id="editRoleScope"
                                                            required>
                                                            <option value="">-- Select --</option>
                                                            <option value="School">School</option>
                                                            <option value="System">System</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Update Role
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#createSchoolForm').on('submit', function (e) {
                e.preventDefault();

                let isValid = true;
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');

                $form.find('.form-control, select').removeClass('is-invalid');

                $form.find('input, select').each(function () {
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
                    text: "Confirm to store new Role.",
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
                            url: '{{ route('store.role') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Success!',
                                    'Role has been created successfully.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });

                                $form[0].reset();
                            },
                            // error: function (data) {
                            //     $('body').html(data.responseText);
                            // },
                            // complete: function () {
                            //     $submitBtn.prop('disabled', false).html(
                            //         originalBtnHtml);
                            // }
                            error: function (xhr) {
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
                            complete: function () {
                                $submitBtn.prop('disabled', false).html(
                                    originalBtnHtml);
                            }
                        });
                    }
                });
            });
        });

        $('.btn-edit-teacher').on('click', function () {
            const roleId = $(this).data('id');

            $.ajax({
                url: `/roles/${roleId}`,
                method: 'GET',
                success: function (response) {
                    $('#editRoleId').val(response.id);
                    $('#editRoleName').val(response.name);

                    // Normalize scope to match <option> values (e.g., "School", "System")
                    if (response.scope) {
                        const normalizedScope = response.scope.trim().toLowerCase();
                        const capitalizedScope = normalizedScope.charAt(0).toUpperCase() + normalizedScope.slice(1);
                        $('#editRoleScope').val(capitalizedScope);
                    } else {
                        $('#editRoleScope').val('');
                    }

                    $('#editRoleModal').modal('show');
                },
                error: function (data) {
                    $('body').html(data.responseText);
                }
            });
        });


        // Handle update role form submission
        $('#editRoleForm').on('submit', function (e) {
            e.preventDefault();

            const roleId = $('#editRoleId').val();
            const formData = $(this).serialize();

            $.ajax({
                url: `/roles/${roleId}`,
                method: 'PUT',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function () {
                    Swal.fire('Success', 'Role updated successfully.', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (let field in errors) {
                            errorMessage += errors[field].join('<br>') + '<br>';
                        }
                        Swal.fire('Validation Error', errorMessage, 'error');
                    } else {
                        Swal.fire('Error', 'Update failed.', 'error');
                    }
                }
                // error: function (data) {
                //     $('body').html(data.responseText);
                // }
            });
        });


        $(document).on('click', '.btn-delete-teacher', function (e) {
            e.preventDefault();

            const roleId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This role will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/roles/${roleId}`,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') 
                        },
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                'The role has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload(); 
                            });
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete the role.',
                                'error'
                            );
                        }
                    });
                }
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

    <script>

    </script>
@endsection