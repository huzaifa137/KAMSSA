@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .su-table th,
                .su-table td {
                    padding: 10px 12px;
                    border: 1px solid #e8e8e8;
                    vertical-align: middle;
                }

                .su-table thead th {
                    background: #026837;
                    color: #fff;
                }

                .su-table tbody tr:nth-child(even) {
                    background: #fafafa;
                }

                .role-pill {
                    padding: 3px 10px;
                    border-radius: 12px;
                    font-size: 0.75rem;
                    font-weight: 600;
                    color: #fff;
                }

                .role-pill.administrator {
                    background-color: #6a123f;
                }

                .role-pill.marks_entrant {
                    background-color: #17a2b8;
                }

                .active-pill {
                    padding: 3px 10px;
                    border-radius: 12px;
                    font-size: 0.75rem;
                    font-weight: 600;
                }

                .active-pill.active {
                    background-color: #e6f7ea;
                    color: #1e7e34;
                    border: 1px solid #1e7e34;
                }

                .active-pill.inactive {
                    background-color: #f8e6e6;
                    color: #a71d2a;
                    border: 1px solid #a71d2a;
                }

                .assignment-picker {
                    border: 1px solid #e2e8f0;
                    border-radius: 8px;
                    padding: 12px;
                    max-height: 360px;
                    overflow-y: auto;
                }

                .me-tabs {
                    display: flex;
                    gap: 6px;
                    margin-bottom: 10px;
                    flex-wrap: wrap;
                }

                .me-tab {
                    border: 1px solid #ccc;
                    background: #fff;
                    padding: 4px 12px;
                    border-radius: 14px;
                    font-size: 0.8rem;
                    font-weight: 600;
                    cursor: pointer;
                }

                .me-tab.active {
                    background: #026837;
                    color: #fff;
                    border-color: #026837;
                }

                .me-subject-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 6px 4px;
                    border-bottom: 1px dashed #eee;
                    flex-wrap: wrap;
                    gap: 6px;
                }

                .me-subject-name {
                    font-size: 0.85rem;
                    font-weight: 500;
                }

                .me-subject-papers {
                    display: flex;
                    gap: 10px;
                    flex-wrap: wrap;
                }

                .me-paper-check {
                    font-size: 0.8rem;
                    margin: 0;
                    display: flex;
                    align-items: center;
                    gap: 4px;
                    font-weight: 600;
                }

                .system-role-toggle-note {
                    display: none;
                }
            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#026837;">
                    <h4 class="mb-0"><i class="fa fa-users-cog me-2"></i> System Users</h4>
                    <button type="button" class="btn btn-sm btn-outline-light px-4 py-2 rounded-pill" data-toggle="modal"
                        data-target="#createUserModal">
                        <span style="color:#FFF;"><i class="fa fa-user-plus me-2"></i></span> <span style="color:#FFF;">Add
                            System User</span>
                    </button>
                </div>

                <div class="card-body">
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            @if (session('success'))
                                Swal.fire({ icon: 'success', title: 'Success!', text: @json(session('success')), confirmButtonColor: '#026837' });
                            @endif
                            @if (session('fail'))
                                Swal.fire({ icon: 'error', title: 'Error', text: @json(session('fail')), confirmButtonColor: '#d33' });
                            @endif
                            @if ($errors->any())
                                Swal.fire({ icon: 'error', title: 'Please check the form', html: `{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor: '#d33' });
                            @endif
                                        });
                    </script>

                    <p class="text-muted small">
                        System users are the accounts that log in on the Admin tab. An <strong>Administrator</strong> has
                        full
                        access. A <strong>Marks Entrant</strong> can only enter marks for the subjects &amp; papers assigned
                        to them below — everything else in the admin area is hidden from that account.
                    </p>

                    @if ($users->isEmpty())
                        <p class="text-muted">No system users yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table su-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Assignments</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        @php
                                            $isEntrant = $user->system_role === 'marks_entrant';
                                            $userAssignments = $assignmentsByUser[$user->id] ?? collect();
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-start">{{ $user->firstname }} {{ $user->lastname }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="role-pill {{ $isEntrant ? 'marks_entrant' : 'administrator' }}">
                                                    {{ $isEntrant ? 'Marks Entrant' : 'Administrator' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($isEntrant)
                                                    <span class="badge bg-info text-white">{{ $user->mark_assignments_count }}
                                                        paper(s)</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="active-pill {{ $user->is_active ? 'active' : 'inactive' }}">
                                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-nowrap">
                                                <button type="button" class="btn btn-outline-dark btn-sm" title="Edit"
                                                    onclick='suOpenEditModal(@json($user), @json($userAssignments->values()))'>
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm {{ $user->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                                    title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}"
                                                    onclick="suToggleStatus({{ $user->id }}, this)">
                                                    <i class="fa {{ $user->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" title="Delete"
                                                    onclick="suDelete({{ $user->id }}, '{{ addslashes($user->firstname . ' ' . $user->lastname) }}')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    {{-- ===================== CREATE MODAL ===================== --}}
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('system-users.store') }}" id="createUserForm">

                    @csrf
                    <div class="modal-header text-white" style="background-color:#FFF;">
                        <h5 class="modal-title" style="color:#026837;"><i class="fa fa-user-plus me-2"></i>Add System User
                        </h5>
                        <button type="button" class="close text-dark" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input type="text" name="firstname" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phonenumber" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="create_password" class="form-control"
                                        required minlength="6">

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('create_password', this)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label>Role</label>
                                <select name="system_role" class="form-control" id="createSystemRole"
                                    onchange="suToggleAssignmentPicker('create')">
                                    <option value="">Administrator (full access)</option>
                                    <option value="marks_entrant">Marks Entrant (restricted)</option>
                                </select>
                            </div>
                        </div>

                        <div id="createAssignmentWrapper" style="display:none;">
                            <label class="fw-bold">Assign Subjects &amp; Papers</label>
                            @include('marks-entrants.partials.assignment-picker', ['prefix' => 'create'])
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#026837;">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== EDIT MODAL ===================== --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" id="editUserForm" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title"><i class="fa fa-user-edit me-2"></i> Edit System User</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input type="text" name="firstname" id="edit_firstname" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input type="text" name="lastname" id="edit_lastname" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="edit_username" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phonenumber" id="edit_phonenumber" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>

                                <div class="input-group">
                                    <input type="password" name="password" id="edit_password" class="form-control"
                                        minlength="6">

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('edit_password', this)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label>Role</label>
                                <select name="system_role" class="form-control" id="editSystemRole"
                                    onchange="suToggleAssignmentPicker('edit')">
                                    <option value="">Administrator (full access)</option>
                                    <option value="marks_entrant">Marks Entrant (restricted)</option>
                                </select>
                            </div>
                        </div>

                        <div id="editAssignmentWrapper" style="display:none;">
                            <label class="fw-bold">Assign Subjects &amp; Papers</label>
                            @include('marks-entrants.partials.assignment-picker', ['prefix' => 'edit'])
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#026837;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function suToggleAssignmentPicker(prefix) {
            const role = document.getElementById(prefix + 'SystemRole').value;
            document.getElementById(prefix + 'AssignmentWrapper').style.display = role === 'marks_entrant' ? 'block' : 'none';
        }

        function meShowTab(prefix, code) {
            document.querySelectorAll('#picker-' + prefix + ' .me-tab').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('#picker-' + prefix + ' .me-panel').forEach(el => el.style.display = 'none');
            document.querySelector('#picker-' + prefix + ' .me-tab[data-target="me-panel-' + prefix + '-' + code + '"]').classList.add('active');
            document.getElementById('me-panel-' + prefix + '-' + code).style.display = 'block';
        }

        function meFilterAssignments(prefix, term) {
            term = term.toLowerCase().trim();
            document.querySelectorAll('#picker-' + prefix + ' .me-subject-row').forEach(row => {
                row.style.display = row.dataset.search.includes(term) ? 'flex' : 'none';
            });
        }

        function suOpenEditModal(user, assignments) {
            document.getElementById('editUserForm').action = '/system-users/' + user.id;
            document.getElementById('edit_firstname').value = user.firstname || '';
            document.getElementById('edit_lastname').value = user.lastname || '';
            document.getElementById('edit_username').value = user.username || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_phonenumber').value = user.phonenumber || '';

            const roleSelect = document.getElementById('editSystemRole');
            roleSelect.value = user.system_role === 'marks_entrant' ? 'marks_entrant' : '';
            suToggleAssignmentPicker('edit');

            // Reset then re-check the assignments belonging to this user.
            document.querySelectorAll('#picker-edit input[type=checkbox]').forEach(cb => cb.checked = false);
            (assignments || []).forEach(value => {
                const cb = document.querySelector('#picker-edit input[value="' + value + '"]');
                if (cb) cb.checked = true;
            });

            $('#editUserModal').modal('show');
        }

        function suToggleStatus(id, btn) {
            fetch('/system-users/' + id + '/toggle-status', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Updated', text: data.message, confirmButtonColor: '#026837' })
                            .then(() => window.location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Could not update', text: data.message || 'Please try again.', confirmButtonColor: '#d33' });
                    }
                })
                .catch(() => Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Please try again.', confirmButtonColor: '#d33' }));
        }

        function suDelete(id, name) {
            Swal.fire({
                icon: 'warning',
                title: 'Delete ' + name + '?',
                text: 'This cannot be undone.',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete',
            }).then(result => {
                if (!result.isConfirmed) return;

                fetch('/system-users/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted', text: data.message, confirmButtonColor: '#026837' })
                                .then(() => window.location.reload());
                        } else {
                            Swal.fire({ icon: 'error', title: 'Could not delete', text: data.message || 'Please try again.', confirmButtonColor: '#d33' });
                        }
                    })
                    .catch(() => Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Please try again.', confirmButtonColor: '#d33' }));
            });
        }

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('createUserForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Create System User?',
                text: 'Are you sure you want to create this system user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#026837',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Create User',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Creating the system user. Please wait.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection