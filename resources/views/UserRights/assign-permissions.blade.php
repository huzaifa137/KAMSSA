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
                    <br>
                    <div class="bg-info d-flex justify-content-between align-items-center px-3 py-2">
                        <h3 class="text-white mb-0">All User Permission Features</h3>
                        <div id="manage-users-role" class="text-white">
                           <a href="{{ route('add-users') }}" class="btn btn-light">
                                <i class="fa fa-user-shield mr-2"></i> Manage All Users
                            </a>
                        </div>
                    </div>

                    <br>

                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-shield-halved me-2"></i> Set Permissions Per Role</h4>
                    </div>

                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                    <div class="container mt-5">
                        <div class="card shadow-sm border-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($roles as $role)
                                    <li
                                        class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-4 px-4 bg-light">
                                        <div class="col-md-3 col-sm-12 mb-3 mb-md-0">
                                            <h4 class="fw-bold text-primary mb-0"><i class="fas fa-crown me-2"></i>
                                                {{$role->name}}</h4>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-3 mb-md-0 d-flex flex-wrap align-items-center">
                                            <h6 class="text-muted me-3 mb-2 pb-2">User Access Controls:</h6>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($rolePermissions[$role->id] ?? [] as $permission)
                                                    <span
                                                        class="badge bg-primary text-white rounded-pill d-inline-flex align-items-center px-3 py-2 me-2 mb-2 shadow-sm"
                                                        style="font-size: 0.95rem; line-height: 1.2;">
                                                        <span class="me-2">
                                                            {{ ucfirst(Helper::item_md_name($permission->permission_id)) }} ->
                                                            <span class="text-warning">Scope:</span>
                                                            {{ ucfirst($permission->permission_scope) }}
                                                        </span>
                                                        <button type="button"
                                                            class="border-0 bg-transparent text-white p-0 m-0 d-flex align-items-center justify-content-center remove-permission"
                                                            data-role-id="{{ $role->id }}"
                                                            data-feature="{{ $permission->permission_id }}"
                                                            data-scope="{{ $permission->permission_scope }}">
                                                            &nbsp;<i class="fa fa-trash"
                                                                style="font-size: 0.85rem; color: rgb(178, 84, 84);"
                                                                aria-hidden="true"></i>&nbsp;
                                                        </button>
                                                    </span> &nbsp; &nbsp;
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 text-md-end">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                                    id="dropdownAdminList{{ $role->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fas fa-plus-circle me-1"></i>Add Permission
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                                                    aria-labelledby="dropdownAdminList{{ $role->id }}">
                                                    <li>
                                                        <h6 class="dropdown-header">Available Permissions</h6>
                                                    </li>
                                                    @foreach ($permissions as $permission)
                                                        <li>
                                                            <form action="{{ route('storeRolePermissions', $role->id) }}"
                                                                method="POST" id="role-permission-form-{{ $role->id }}">
                                                                @csrf
                                                                <input type="hidden" name="permissions[]"
                                                                    value="{{ $permission->name }}">
                                                                <input type="hidden" name="permissions_scope[]"
                                                                    value="{{ $permission->scope }}">
                                                                <a class="dropdown-item add-permission" href="#"
                                                                    data-role-id="{{ $role->id }}"
                                                                    data-permission-name="{{ $permission->name }}"
                                                                    data-permission-scope="{{ $permission->scope }}">
                                                                    <i class="fas fa-lock me-2"></i>
                                                                    {{ ucfirst(Helper::item_md_name($permission->name)) }} -
                                                                    {{ ucfirst($permission->scope) }}
                                                                </a>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-shield-halved me-2"></i> Set Permission Access</h4>
                    </div>

                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                    <div class="container mt-5">
                        <div class="shadow-sm border-0">
                            <ul class="list-group">
                                @foreach ($roles as $role)
                                    @php
                                        $roleId = 'role_' . $role->id;
                                    @endphp

                                    <li class="list-group-item mb-4 py-3 rounded border border-primary bg-white"
                                        id="{{ $roleId }}">

                                        <div class="col-md-12 col-sm-12 mb-3 mb-md-0">
                                            <h4 class="fw-bold text-primary mb-3">
                                                <i class="fas fa-crown me-2"></i> {{ $role->name }}
                                            </h4>
                                        </div>

                                        <form class="permission-form" data-role="{{ $roleId }}" data-role-id="{{ $role->id }}">
                                            @csrf
                                            <div class="card-body p-0">
                                                @if ($permissions->isNotEmpty())
                                                    <div class="table-responsive">
                                                        <table class="table  table-bordered align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th class="text-center">
                                                                        <input type="checkbox" class="select-all-rows"
                                                                            data-role="{{ $roleId }}">
                                                                    </th>
                                                                    <th>Permission Name</th>
                                                                    <th class="text-center">Scope</th>
                                                                    @foreach(['add', 'view', 'edit', 'delete'] as $action)
                                                                        <th class="text-center">
                                                                            <input type="checkbox" class="select-all-action"
                                                                                data-role="{{ $roleId }}" data-action="{{ $action }}">
                                                                            {{ ucfirst($action) }}
                                                                        </th>
                                                                    @endforeach
                                                                    <th class="text-center">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($permissions as $permission)
                                                                    <tr class="permission-row" data-role="{{ $roleId }}">
                                                                        <td class="text-center">
                                                                            <input type="checkbox" class="select-row"
                                                                                data-role="{{ $roleId }}">
                                                                        </td>
                                                                        <td>{{ ucfirst(Helper::item_md_name($permission->name)) }}</td>
                                                                        <td class="text-center">{{ ucfirst($permission->scope) }}</td>

                                                                        @foreach (['add', 'view', 'edit', 'delete'] as $action)
                                                                            @php
                                                                                $featureKey = "{$action}_{$permission->name}";
                                                                                $roleNumericId = $role->id;
                                                                                $isChecked = false;

                                                                                if (isset($permissionsByRole[$roleNumericId])) {
                                                                                    foreach ($permissionsByRole[$roleNumericId] as $perm) {
                                                                                        if ($perm->feature === $featureKey && $perm->is_marked) {
                                                                                            $isChecked = true;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <td class="text-center">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input permission-checkbox"
                                                                                    name="permissions[]" value="{{ $featureKey }}"
                                                                                    data-scope="{{ $permission->scope }}"
                                                                                    data-role="{{ $roleId }}" data-action="{{ $action }}" {{ $isChecked ? 'checked' : '' }}>
                                                                            </td>
                                                                        @endforeach

                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-primary btn-save-permission">
                                                                                <i class="fas fa-save"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="text-end mt-3">
                                                        <button type="submit" class="btn btn-success save-all-permissions">
                                                            <i class="fas fa-save me-1"></i> Save All Permissions
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning text-center my-3" role="alert">
                                                        <i class="fas fa-exclamation-triangle me-2"></i> No permissions found to
                                                        display.
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0" href="#manage-users-role"><i class="fa fa-user-shield mr-2"></i> Manage Users Per
                            Role</h4>
                    </div>

                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                    <div class="container mt-5">
                        <div class="container mt-5">
                            @foreach ($roles as $role)
                                <div class="card shadow-sm border-0 mb-4">
                                    <div
                                        class="card-header bg-light py-4 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                        <h4 class="fw-bold text-primary mb-3 mb-md-0">
                                            <i class="fas fa-crown me-2"></i> {{ $role->name }} (<span
                                                class="user-count">{{ $role->users->count() }}</span>)
                                        </h4>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-primary me-2" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#usersCollapse{{ $role->id }}" aria-expanded="true"
                                                aria-controls="usersCollapse{{ $role->id }}">
                                                <i class="fas fa-users me-1"></i> <span class="collapse-text">Hide Users</span>
                                            </button> &nbsp;
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownAddUser{{ $role->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fas fa-user-plus me-1"></i> Add User to Role
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                                                    aria-labelledby="dropdownAddUser{{ $role->id }}">
                                                    <li>
                                                        <h6 class="dropdown-header">Available Users</h6>
                                                    </li>
                                                    @foreach ($users as $user)
                                                        <li>
                                                            <a class="dropdown-item add-user-to-role" href="#"
                                                                data-role-id="{{ $role->id }}" data-user-id="{{ $user->id }}">
                                                                <i class="fas fa-user me-2"></i> {{ $user->name }}
                                                                ({{ $user->email }})
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse show" id="usersCollapse{{ $role->id }}">
                                        <div class="card-body bg-light-subtle">
                                            <h5 class="mb-3 text-secondary"><i class="fas fa-user-friends me-2"></i> Users in
                                                this role</h5>
                                            @if ($role->users->count() > 0)
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($role->users as $user) &nbsp; &nbsp;
                                                        <div class="user-card me-3 mb-3">
                                                            <div class="card">
                                                                <div
                                                                    class="card-body py-2 px-3 bg-transparent d-flex justify-content-between align-items-center">
                                                                    @if ($user->user_role == 5)
                                                                                                            <?php
                                                                        $teacher = DB::table('teachers')->where('id', $user->username)->first();
                                                                                                                                                                                                                                                                                                                                                                                                                    ?>
                                                                                                            <h6 class="mb-0">{{ $teacher->surname }}</h6>
                                                                                                            <small class="text-muted">{{ $user->email }}</small>
                                                                    @elseif ($user->user_role == 0)
                                                                        <h6 class="mb-0">{{ $user->username }}</h6>
                                                                        <small class="text-muted">{{ $user->email }}</small>
                                                                    @endif
                                                                    &nbsp;
                                                                    <button class="btn btn-danger delete-user"
                                                                        data-user-id="{{ $user->id }}" data-role-id="{{ $role->id }}">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>

                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted fst-italic mb-0">No users assigned to this role yet.</p>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <style>
        .delete-user {
            padding: 2px 4px;
            font-size: 10px;
            line-height: 1;
            height: 24px;
            width: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .delete-user i {
            font-size: 12px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).ready(function () {
            $('.permission-form').each(function () {
                const form = $(this);
                const roleId = form.data('role');
                const roleDbId = form.data('role-id');

                // Select all rows for this role
                form.find('.select-all-rows').on('change', function () {
                    const checked = $(this).is(':checked');
                    form.find('.select-row').prop('checked', checked);
                    form.find('.permission-checkbox').prop('checked', checked);
                });

                // Select row-specific checkboxes
                form.find('.select-row').on('change', function () {
                    const row = $(this).closest('tr');
                    const checked = $(this).is(':checked');
                    row.find('.permission-checkbox').prop('checked', checked);
                });

                // Select column (add/view/edit/delete)
                form.find('.select-all-action').on('change', function () {
                    const action = $(this).data('action');
                    const checked = $(this).is(':checked');
                    form.find(`.permission-checkbox[data-action="${action}"]`).prop('checked', checked);
                });

                // Submit Save All Permissions
                form.on('submit', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to save these permissions for this role?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, save it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const permissions = [];

                            form.find('input[name="permissions[]"]:checked').each(function () {
                                permissions.push({
                                    feature: $(this).val(),
                                    scope: $(this).data('scope')
                                });
                            });

                            $.ajax({
                                url: '{{ route("store.multiple.permissions") }}',
                                type: 'POST',
                                contentType: 'application/json',
                                data: JSON.stringify({
                                    role_id: roleDbId,
                                    permissions: permissions,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                }),
                                success: function (response) {
                                    Swal.fire('Saved!', response.message, 'success').then(() => {
                                        location.reload();
                                    });
                                },
                                // error: function (xhr) {
                                //     $('body').html(xhr.responseText);
                                // }
                                error: function (xhr) {
                                    let message = 'Something went wrong.';

                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        message = xhr.responseJSON.message;
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Permission Denied',
                                        text: message,
                                        confirmButtonColor: '#d33'
                                    });
                                }

                            });
                        }
                    });
                });
            });
        });

        $(document).ready(function () {

            // Add Permission
            $('.add-permission').on('click', function (e) {
                e.preventDefault();

                var roleId = $(this).data('role-id');
                var permissionName = $(this).data('permission-name');
                var permissionScope = $(this).data('permission-scope');

                var form = $('#role-permission-form-' + roleId);

                form.find('input[name="permissions[]"]').val(permissionName);
                form.find('input[name="permissions_scope[]"]').val(permissionScope);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to proceed with this action?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: form.serialize(),
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
                                }
                            },
                            // error: function (data) {
                            //     $('body').html(data.responseText);
                            // }
                        });
                    }
                });
            });

            // Remove Permission
            $('.remove-permission').on('click', function (e) {
                e.preventDefault();

                var roleId = $(this).data('role-id');
                var permissionId = $(this).data('feature');
                var permissionScope = $(this).data('scope');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to remove this permission?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/remove-permissions/' + roleId + '/remove',
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                permission_id: permissionId,
                                role_id: roleId,
                                permission_scope: permissionScope
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                    }).then(() => {
                                        $('[data-feature="' + permissionId + '"]').closest('.badge').remove();
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function (data) {
                                $('body').html(data.responseText);
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function () {
            $(".add-user-to-role").on('click', function (e) {
                e.preventDefault();

                var roleId = $(this).data("role-id");
                var userId = $(this).data("user-id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to assign this user to the role.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, assign it!',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('assignUserToRole') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                role_id: roleId,
                                user_id: userId,
                            },
                            success: function (response) {
                                if (response.success) {

                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'User added to the role.',
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    }).then(function () {

                                        location.reload();
                                    });
                                } else {

                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message || 'Failed to assign user.',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            },
                            error: function (xhr, status, error) {

                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An unexpected error occurred. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        });
                    } else {

                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The user was not assigned to the role.',
                            icon: 'info',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });

        $(document).ready(function () {
            $(".delete-user").on('click', function (e) {
                e.preventDefault();

                var userId = $(this).data("user-id");
                var roleId = $(this).data("role-id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to remove this user from this role.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('removeUserFromRole') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                user_id: userId,
                                role_id: roleId
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Removed!',
                                        text: 'User has been removed from this role.',
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    }).then(function () {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message || 'Failed to remove user.',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An unexpected error occurred. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The user was not removed from this role.',
                            icon: 'info',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });

    </script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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