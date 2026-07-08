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
                        <form id="createPermissionFeature">
                            <div class="row">

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">User Access Configuration</label>
                                        <?php
    echo Helper::DropMasterData(config('constants.options.URPF'), '', 'permission_feature', 1);
                                                                                                ?>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Permission Scope</label>
                                        <select name="scope" id="scope" class="gender input-sm form-control select2">
                                            <option value="">-- Select --</option>
                                            <option value="School">School</option>
                                            <option value="System">System</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="mt-4 text-left">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Save Permission Feature
                                </button>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="bg-info">
                        <h3 class="text-center pt-1 mt-1 text-white">All User Access Configuration</h3>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped card-table table-vcenter text-nowrap mb-0" id="teachersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Feature Permission Name</th>
                                        <th class="text-center">Scope</th>
                                        <th class="text-center">Add</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($permissions as $key => $permission)
                                        @php
                                            $features = explode(',', $permission->features);
                                            $featureSet = collect($features);
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{  Helper::item_md_name($permission->name) }}</td>
                                            <td class="text-center">{{ $permission->scope }}</td>
                                            <td class="text-center">
                                                <input type="checkbox" disabled {{ $featureSet->contains('add_' . Helper::item_md_name($permission->name)) ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" disabled {{ $featureSet->contains('view_' . Helper::item_md_name($permission->name)) ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" disabled {{ $featureSet->contains('edit_' . Helper::item_md_name($permission->name)) ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" disabled {{ $featureSet->contains('delete_' . Helper::item_md_name($permission->name)) ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-danger btn-delete"
                                                    data-name="{{ $permission->name }}" data-scope="{{ $permission->scope }}"
                                                    data-title="{{ Helper::item_md_name($permission->name) }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No Permissions Found.</td>
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
        $(document).ready(function () {
            $('#createPermissionFeature').on('submit', function (e) {
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
                    text: "Confirm to create Permission Previledge.",
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
                            url: '{{ route('store.permission.role') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Success!',
                                    'Feature has been created successfully.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });

                                $form[0].reset();
                            },
                            error: function (xhr) {
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    let errorMessage = '';
                                    for (let field in errors) {
                                        errorMessage += errors[field].join('<br>') + '<br>';
                                    }
                                    Swal.fire('Validation Error', errorMessage, 'error');
                                } else if (xhr.status === 409) {
                                    Swal.fire('Permission Exists', xhr.responseJSON.message, 'warning');
                                } else {
                                    Swal.fire('Error', 'Something went wrong while updating. Please try again.', 'error');
                                    console.error(xhr.responseText);
                                }
                            },
                            // error: function (data) {
                            //     $('body').html(data.responseText);
                            // },
                            complete: function () {
                                $submitBtn.prop('disabled', false).html(
                                    originalBtnHtml);
                            }
                        });
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function () {
                    const name = this.dataset.name;
                    const scope = this.dataset.scope;
                    const title = this.dataset.title || name;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `This will delete all "${title}" permissions under scope "${scope}".`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route('permissions.delete') }}', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ name, scope })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: data.message,
                                            icon: 'success'
                                        }).then(() => {
                                            location.reload(); // 🔁 Reloads the page after success
                                        });
                                    } else {
                                        Swal.fire('Error!', data.message, 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error(error);
                                    Swal.fire('Error!', 'Something went wrong.', 'error');
                                });
                        }
                    });
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

    <script>

    </script>
@endsection