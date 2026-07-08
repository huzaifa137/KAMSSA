<?php
use App\Http\Controllers\Helper; 
?>
@extends('layouts-side-bar.master')
@section('content')
    <div class="side-app">

        <style>
            .user-dropdown {
                max-width: 500px;
                width: 100%;
                right: 0;
                left: auto !important;
            }

            .btn-inline-orange {
                color: #FF9800;
                border: 1px solid #FF9800;
                ;
                background-color: transparent;
            }

            .btn-inline-orange:hover {
                background-color: #FF9800;
                ;
                c olor: white;
            }

            .dataTables_filter {
                float: right !important;
                text-align: right !important;
            }
        </style>

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.users-config-header')
                    </div>

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add User</h5>
                    </div>
                    <div class="card-body bg-light">
                        <form id="createSchoolTeacher">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="username">username</label>
                                        <input type="text" id="username" name="username" class="form-control"
                                            placeholder="Enter username">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="firstname">Firstname</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control"
                                            placeholder="Enter firstname">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="phonenumber">Phone Number</label>
                                        <input type="tel" id="phonenumber" name="phonenumber" class="form-control"
                                            placeholder="Enter phone number">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="Email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            placeholder="Enter user email">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group mt-3">
                                        <label class="form-label">Attach Roles to users</label>
                                        <div class="row">
                                            @foreach ($roles as $role)
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                                            value="{{ $role->id }}" id="role_{{ $role->id }}">
                                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                                            <i class="fas fa-crown me-1 text-warning"></i> {{ $role->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Users</h5>
                </div>

                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="schoolsTable" class="table table-striped table-bordered  align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Username</th>
                                    <th>Firstname</th>
                                    <th>Gender</th>
                                    <th>Phone Number</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $statusConfig = [
                                        10 => ['label' => 'Active', 'class' => 'text-success', 'icon' => 'fas fa-check-circle'],
                                        0 => ['label' => 'Banned', 'class' => 'text-danger', 'icon' => 'fas fa-ban'],
                                        8 => ['label' => 'Locked', 'class' => 'text-warning', 'icon' => 'fas fa-lock'],
                                        9 => ['label' => 'Suspended', 'class' => 'text-secondary', 'icon' => 'fas fa-user-slash'],
                                    ];
                                @endphp

                                @forelse ($users as $key => $user)
                                    <tr>
                                        <td style="width:1px;">{{ $key + 1 }}</td>
                                        <td class="fw-bold">{{ @$user->username }}</td>
                                        <td class="fw-bold">{{ @$user->firstname }}</td>
                                        <td class="fw-bold">{{ @$user->gender }}</td>
                                        <td class="fw-bold">{{ @$user->phonenumber }}</td>

                                        <td>
                                            @php
                                                $status = $statusConfig[$user->account_status] ?? ['label' => 'Unknown', 'class' => 'text-muted', 'icon' => 'fas fa-question-circle'];
                                            @endphp
                                            <span class="{{ $status['class'] }}">
                                                <i class="{{ $status['icon'] }}"></i> {{ $status['label'] }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-inline-orange btn-view-user"
                                                data-user-id="{{ $user->id }}" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            &nbsp;

                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-info btn-change-status"
                                                data-id="{{ $user->id }}" data-status="{{ $user->account_status }}"
                                                title="Change Status">
                                                <i class="fas fa-sync-alt"></i>
                                            </a>
                                            &nbsp;

                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-edit"
                                                data-id="{{ $user->id }}"
                                                data-edit-url="{{ route('update.teacher.profile', $user->id) }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            &nbsp;
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-delete"
                                                data-id="{{ $user->id }}" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No users found.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Roles & Permissions</h5>
                </div>

                <div class="card-body p-3">

                    <style>
                        .role-card {
                            border: 1px solid #e0e0e0;
                            border-radius: 8px;
                            overflow: hidden;
                            margin-bottom: 20px;
                            transition: all 0.2s ease-in-out;
                            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                        }

                        .role-card:hover {
                            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                            transform: translateY(-2px);
                        }

                        .role-card-header {
                            background-color: #f8f9fa;
                            padding: 15px 20px;
                            border-bottom: 1px solid #e9ecef;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            flex-wrap: wrap;
                        }

                        .role-title {
                            font-size: 1.25rem;
                            color: #2d9eef;
                            font-weight: 600;
                            margin-bottom: 5px;
                        }

                        .role-user-count {
                            font-size: 0.9rem;
                            color: #6c757d;
                            background-color: #e9ecef;
                            padding: 3px 8px;
                            border-radius: 15px;
                            margin-left: 10px;
                            font-weight: bold;
                        }

                        .role-search-add-group {
                            display: flex;
                            gap: 10px;
                            flex-grow: 1;
                            justify-content: flex-end;
                            flex-wrap: wrap;
                        }

                        .role-search-add-group .form-control-sm {
                            max-width: 200px;
                            flex-grow: 0;
                            flex-shrink: 1;
                        }

                        @media (max-width: 768px) {

                            .role-card-header {
                                flex-direction: column;
                                align-items: flex-start;
                            }

                            .role-search-add-group {
                                width: 100%;
                                margin-top: 15px;
                                justify-content: center;
                            }

                            .role-search-add-group .form-control-sm {
                                max-width: 100%;
                            }

                            .role-user-count {
                                margin-left: 0;
                                margin-top: 5px;
                            }
                        }

                        .user-chip-container {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 8px;
                            padding: 10px 0;
                            border-top: 1px solid #eee;
                            margin-top: 15px;
                        }

                        .user-chip {
                            display: inline-flex;
                            align-items: center;
                            background-color: #2d9eef;
                            color: white;
                            padding: 6px 12px;
                            border-radius: 20px;
                            font-size: 0.875rem;
                            font-weight: 500;
                            white-space: nowrap;
                            transition: background-color 0.2s ease;
                        }

                        .user-chip:hover {
                            background-color: #248ad6;
                        }

                        .btn-remove-user {
                            background-color: transparent;
                            border: none;
                            color: white;
                            margin-left: 8px;
                            font-size: 0.8rem;
                            padding: 0 5px;
                            cursor: pointer;
                            transition: color 0.2s ease;
                        }

                        .btn-remove-user:hover {
                            color: #ffdddd;
                        }

                        .card-body.no-users-message {
                            text-align: center;
                            color: #6c757d;
                            font-style: italic;
                            padding: 20px;
                        }

                        .role-search-add-group {
                            position: relative;
                        }

                        .user-dropdown {
                            position: absolute;
                            top: 100%;
                            left: 0;
                            z-index: 1050;
                            background-color: #fff;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                        }
                    </style>

                    @foreach ($roles as $role)
                        <div class="card role-card">
                            <div class="role-card-header">
                                <div>
                                    <strong class="role-title">{{ $role->name }}</strong>
                                    <span class="role-user-count">{{ $role->users->count() }} Users</span>
                                </div>

                                <div class="role-search-add-group position-relative">
                                    <input type="search" class="form-control form-control-sm add-user-input"
                                        placeholder="Add Users in role..." data-role-id="{{ $role->id }}" autocomplete="off" />

                                    <div class="dropdown-menu w-100 p-2 user-dropdown"
                                        style="max-height: 200px; overflow-y: auto; display: none;"
                                        data-role-id="{{ $role->id }}">
                                        <input type="text" class="form-control mb-2 user-search-input"
                                            placeholder="Search users in role..." style="border: 1.5px solid blue;">

                                        <div class="user-list">
                                            @foreach ($users as $user)
                                                <a href="#" class="dropdown-item user-item" data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->firstname }} ({{ $user->email }})">
                                                    {{ $user->firstname }} ({{ $user->email }})
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse show" id="role-{{ $role->id }}">
                                <div class="card-body">
                                    @if ($role->users->count() > 0)
                                        <div class="user-chip-container">
                                            @foreach ($role->users as $user)
                                                <div class="user-chip" data-role-id="{{ $role->id }}" data-user-id="{{ $user->id }}">
                                                    {{ $user->firstname }} ({{ $user->email }})
                                                    <button class="btn-remove-user" title="Remove User">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="card-body no-users-message">
                                            No users assigned to this role yet.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="userInfoModalLabel">User Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Username:</strong> <span id="modalUsername"></span></p>
                            <p><strong>Firstname:</strong> <span id="modalFirstname"></span></p>
                            <p><strong>Gender:</strong> <span id="modalGender"></span></p>
                            <p><strong>Phone Number:</strong> <span id="modalPhoneNumber"></span></p>
                            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="changeStatusForm">
                            <div class="modal-header">
                                <h5 class="modal-title">Change Account Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="statusUserId">
                                <div class="form-group">
                                    <label for="newStatus">Select New Status</label>
                                    <select id="newStatus" class="form-control">
                                        <option value="10">Active</option>
                                        <option value="0">Banned</option>
                                        <option value="8">Locked</option>
                                        <option value="9">Suspended</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Change Status</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
        $(document).ready(function () {
            $('#createSchoolTeacher').on('submit', function (e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const originalBtnHtml = $submitBtn.html();

                // Clear previous errors
                $form.find('.form-control, select').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                let isValid = true;
                const requiredFields = ['username', 'firstname', 'phonenumber', 'email'];

                // Front-end required validation
                requiredFields.forEach(function (field) {
                    let input = $form.find(`[name="${field}"]`);
                    if (!input.val().trim()) {
                        input.addClass('is-invalid');
                        if (input.next('.invalid-feedback').length === 0) {
                            input.after('<div class="invalid-feedback">This field is required.</div>');
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

                // Confirmation modal
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to add new user.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disable button and show loading spinner
                        $submitBtn.prop('disabled', true).html('Saving...<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '{{ route('users.store.new.user') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Submitted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr) {
                                if (xhr.status === 422) {
                                    const errors = xhr.responseJSON.errors;
                                    for (let field in errors) {
                                        let input = $form.find(`[name="${field}"]`);
                                        input.addClass('is-invalid');
                                        if (input.next('.invalid-feedback').length === 0) {
                                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                        }
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        text: 'Please fix the errors and try again.'
                                    });
                                } else {
                                    const errorMessage = xhr.responseJSON?.message || xhr.statusText || 'An unexpected error occurred';
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Server Error',
                                        html: `<pre>${errorMessage}</pre>`
                                    });
                                }
                            },
                            // error: function (data) {
                            //     $('body').html(data.responseText);
                            // },
                            complete: function () {

                                $submitBtn.prop('disabled', false).html(originalBtnHtml);
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function () {
            $('.btn-view-user').on('click', function () {
                let userId = $(this).data('user-id');

                $.ajax({
                    url: `/users/${userId}/details`,
                    type: 'GET',
                    success: function (data) {

                        $('#modalUsername').text(data.username || '');
                        $('#modalFirstname').text(data.firstname || '');
                        $('#modalGender').text(data.gender || '');
                        $('#modalPhoneNumber').text(data.phonenumber || '');
                        $('#modalEmail').text(data.email || '');

                        let modal = new bootstrap.Modal(document.getElementById('userInfoModal'));
                        modal.show();
                    },
                    error: function (xhr) {
                        $('body').html(xhr.responseText);
                    }
                });
            });
        });

        $(document).ready(function () {
            // Open modal with user's current status
            $('.btn-change-status').on('click', function () {
                const userId = $(this).data('id');
                const currentStatus = $(this).data('status');

                $('#statusUserId').val(userId);
                $('#newStatus').val(currentStatus);
                $('#changeStatusModal').modal('show');
            });

            // Submit form with SweetAlert confirmation
            $('#changeStatusForm').on('submit', function (e) {
                e.preventDefault();
                const userId = $('#statusUserId').val();
                const newStatus = $('#newStatus').val();

                $('#changeStatusModal').modal('hide');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will update the user's account status.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to update status
                        $.ajax({
                            url: `/users/${userId}/change-status`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: newStatus
                            },
                            success: function (response) {
                                $('#changeStatusModal').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: 'Account status has been changed.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Optionally reload the page or update row dynamically
                                location.reload();
                            },
                            error: function (xhr) {
                                Swal.fire('Error', 'Failed to change status.', 'error');
                            }
                        });
                    }
                });
            });
        });

    </script>

@endsection
@section('js')
    {{-- jQuery is typically loaded in the master layout before other scripts that depend on it --}}
    {{-- Ensure jQuery is loaded *before* DataTables, either here or in your master.blade.php --}}

    {{-- DataTables JS (using CDN for consistency) --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- DataTables Buttons JS --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    {{-- Export libraries (only if you intend to use export buttons like Excel, PDF) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    {{-- Buttons HTML5 export, print and column visibility (only if used) --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#schoolsTable').DataTable({
                responsive: false, // Ensure this is compatible with your CSS/layout
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                dom: 'frtip', // Defines table controls (Filter, Row length, Table, Info, Paging)
                columnDefs: [{
                    orderable: false,
                    targets: [1, 4, 5] // Adjust these target indices if columns change
                },
                {
                    className: 'text-center',
                    targets: '_all'
                }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search users..."
                }
            });

            // Delete functionality
            $('#schoolsTable tbody').on('click', '.btn-delete', function () {
                var userId = $(this).data('id');
                var row = table.row($(this).parents('tr'));

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/user/' + userId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                row.remove()
                                    .draw(); // Remove row from DataTable and redraw

                                Swal.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                );
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong deleting the school.',
                                    'error'
                                );
                            }
                            // error: function(data) {
                            // $('body').html(data.responseText);
                            // }
                        });
                    }
                });
            });

            // Edit functionality
            $('#schoolsTable tbody').on('click', '.btn-edit', function () {
                var editUrl = $(this).data('edit-url');

                Swal.fire({
                    title: 'Edit User ?',
                    text: "You are about to edit this user.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = editUrl;
                    }
                });
            });
        });

        $(document).ready(function () {
            $('.add-user-input').on('focus click', function () {
                const roleId = $(this).data('role-id');
                $(`.user-dropdown[data-role-id="${roleId}"]`).show();
                $(`.user-dropdown[data-role-id="${roleId}"] .user-search-input`).val('').trigger('input');
            });

            $('.user-search-input').on('input', function () {
                const query = $(this).val().toLowerCase();
                const dropdown = $(this).closest('.user-dropdown');
                dropdown.find('.user-item').each(function () {
                    const name = $(this).data('user-name').toLowerCase();
                    $(this).toggle(name.indexOf(query) > -1);
                });
            });


            $('.user-dropdown').on('click', '.user-item', function (e) {
                e.preventDefault();

                const userId = $(this).data('user-id');
                const userName = $(this).data('user-name');
                const roleId = $(this).closest('.user-dropdown').data('role-id');

                Swal.fire({
                    title: `Add user "${userName}" to this role?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, add user',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX to add user to role
                        $.ajax({
                            url: '/roles/add-user',  // Your route to handle adding
                            method: 'POST',
                            data: {
                                user_id: userId,
                                role_id: roleId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire('Added!', response.message, 'success').then(() => {
                                    // Reload the page after user clicks OK on success alert
                                    location.reload();
                                });

                                // Optional: UI updates before reload (won't persist after reload)
                                $(`.user-dropdown[data-role-id="${roleId}"]`).hide();
                                $(`.add-user-input[data-role-id="${roleId}"]`).val('');

                                const userChip = `
                            <div class="user-chip" data-role-id="${roleId}" data-user-id="${userId}">
                                ${userName}
                                <button class="btn-remove-user" title="Remove User">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;

                                const container = $(`#role-${roleId} .user-chip-container`);

                                const noUsersMessage = $(`#role-${roleId} .no-users-message`);
                                if (noUsersMessage.length) {
                                    noUsersMessage.remove();
                                    container.show();
                                }

                                container.append(userChip);

                                const countSpan = $(`.role-card[data-role-id="${roleId}"] .role-user-count`);
                                if (countSpan.length) {
                                    let count = parseInt(countSpan.text()) || 0;
                                    countSpan.text(`${count + 1} Users`);
                                } else {
                                    const countElement = $(`.role-card-header [data-role-id="${roleId}"]`).find('.role-user-count');
                                    if (countElement.length) {
                                        let count = parseInt(countElement.text()) || 0;
                                        countElement.text(`${count + 1} Users`);
                                    }
                                }
                            },
                            error: function (xhr) {
                                Swal.fire('Error', xhr.responseJSON?.message || 'Failed to add user to role', 'error');
                            }
                            // error: function (data) {
                            //     $('body').html(data.responseText);
                            // }
                        });
                    }
                });
            });

            // Click outside to close dropdown
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.role-search-add-group').length) {
                    $('.user-dropdown').hide();
                }
            });
        });

        $(document).on('click', '.btn-remove-user', function () {
            const chip = $(this).closest('.user-chip');
            const userId = chip.data('user-id');
            const roleId = chip.data('role-id');

            Swal.fire({
                title: 'Remove User?',
                text: 'Are you sure you want to remove this user from the role?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/roles/remove-user',
                        method: 'POST',
                        data: {
                            user_id: userId,
                            role_id: roleId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('Removed!', response.message, 'success').then(() => {
                                // Reload page after user clicks OK on success alert
                                location.reload();
                            });

                            // Optional: UI updates before reload (won't persist)
                            chip.remove();

                            const countSpan = $(`.role-card[data-role-id="${roleId}"] .role-user-count`);
                            if (countSpan.length) {
                                let count = parseInt(countSpan.text()) || 1;
                                count = Math.max(count - 1, 0);
                                countSpan.text(`${count} Users`);
                            }

                            const container = $(`#role-${roleId} .user-chip-container`);
                            if (container.children().length === 0) {
                                container.parent().html(`
                            <div class="card-body no-users-message">
                                No users assigned to this role yet.
                            </div>
                        `);
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message || 'Failed to remove user from role', 'error');
                        }
                    });
                }
            });
        });


    </script>
@endsection