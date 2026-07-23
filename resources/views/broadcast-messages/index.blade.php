@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .nb-table th,
                .nb-table td {
                    padding: 10px 12px;
                    border: 1px solid #e8e8e8;
                    vertical-align: middle;
                }

                .nb-table thead th {
                    background: #026837;
                    color: #fff;
                }

                .nb-table tbody tr:nth-child(even) {
                    background: #fafafa;
                }

                .role-pill {
                    padding: 2px 8px;
                    border-radius: 12px;
                    font-size: 0.68rem;
                    font-weight: 600;
                    color: #fff;
                    margin-left: 6px;
                }

                .role-pill.administrator {
                    background-color: #6a123f;
                }

                .role-pill.marks_entrant {
                    background-color: #17a2b8;
                }

                .active-pill {
                    padding: 2px 8px;
                    border-radius: 12px;
                    font-size: 0.68rem;
                    font-weight: 600;
                    margin-left: 6px;
                }

                .active-pill.inactive {
                    background-color: #f8e6e6;
                    color: #a71d2a;
                    border: 1px solid #a71d2a;
                }

                .priority-pill {
                    padding: 3px 10px;
                    border-radius: 12px;
                    font-size: 0.72rem;
                    font-weight: 700;
                    letter-spacing: .3px;
                    text-transform: uppercase;
                }

                .priority-pill.normal {
                    background: #e6f7ea;
                    color: #1e7e34;
                    border: 1px solid #1e7e34;
                }

                .priority-pill.important {
                    background: #fff6e0;
                    color: #8a6100;
                    border: 1px solid #c99400;
                }

                .priority-pill.urgent {
                    background: #fdeaea;
                    color: #a71d2a;
                    border: 1px solid #a71d2a;
                }

                .audience-pill {
                    padding: 3px 10px;
                    border-radius: 12px;
                    font-size: 0.75rem;
                    font-weight: 600;
                    background: #eef6f0;
                    color: #026837;
                    border: 1px solid #026837;
                    white-space: nowrap;
                }

                .nb-mode-row {
                    display: flex;
                    gap: 18px;
                    flex-wrap: wrap;
                    margin-bottom: 12px;
                    padding: 10px 12px;
                    background: #f7f9f8;
                    border: 1px solid #e2e8f0;
                    border-radius: 8px;
                }

                .nb-mode-option {
                    font-size: 0.85rem;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    margin: 0;
                    cursor: pointer;
                }

                .nb-picker-list {
                    border: 1px solid #e2e8f0;
                    border-radius: 8px;
                    max-height: 320px;
                    overflow-y: auto;
                }

                .nb-picker-row {
                    display: flex;
                    align-items: flex-start;
                    gap: 10px;
                    padding: 8px 12px;
                    border-bottom: 1px dashed #eee;
                    margin: 0;
                    cursor: pointer;
                    font-weight: 400;
                }

                .nb-picker-row:hover {
                    background: #f7fbf8;
                }

                .nb-picker-row input {
                    margin-top: 4px;
                }

                .nb-picker-name {
                    font-size: 0.87rem;
                    font-weight: 600;
                    display: block;
                }

                .nb-picker-meta {
                    font-size: 0.76rem;
                    color: #6c757d;
                    display: block;
                }

                .nb-tabs .nav-link {
                    border: 1px solid #ccc;
                    border-radius: 14px;
                    font-size: 0.82rem;
                    font-weight: 600;
                    color: #333;
                    margin-right: 6px;
                }

                .nb-tabs .nav-link.active {
                    background: #026837 !important;
                    color: #fff !important;
                    border-color: #026837;
                }

                .subject-cell {
                    max-width: 260px;
                }

                .excerpt-cell {
                    max-width: 340px;
                    color: #6c757d;
                    font-size: 0.85rem;
                }

                .read-progress {
                    height: 6px;
                    border-radius: 4px;
                    background: #eee;
                    overflow: hidden;
                    width: 90px;
                }

                .read-progress span {
                    display: block;
                    height: 100%;
                    background: #026837;
                }
            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#026837;">
                    <h4 class="mb-0"><i class="fa fa-bullhorn me-2"></i> Notifications</h4>
                    <div class="d-flex">
                        <a href="{{ route('notifications.inbox') }}"
                            class="btn btn-sm btn-outline-light px-3 py-2 rounded-pill mr-2">
                            <span style="color:#FFF;">
                                <i class="fa fa-inbox"></i> My Inbox
                            </span>
                        </a>

                        <button type="button" class="btn btn-sm btn-outline-light px-4 py-2 rounded-pill"
                            data-toggle="modal" data-target="#composeMessageModal">
                            <span style="color:#FFF;">
                                <i class="fa fa-paper-plane"></i> Compose Message
                            </span>
                        </button>
                    </div>

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
                        Compose a message once and deliver it to any mix of <strong>Schools</strong> and
                        <strong>System Users</strong> — pick everyone, or hand-pick exactly who should see it.
                        Recipients see the message in their own inbox and you can track who has read it below.
                    </p>

                    @if ($messages->isEmpty())
                        <p class="text-muted">No messages sent yet. Click <strong>Compose Message</strong> to send your first
                            notification.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table nb-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Preview</th>
                                        <th>Priority</th>
                                        <th>Sent To</th>
                                        <th>Sender</th>
                                        <th>Sent</th>
                                        <th>Read Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $index => $message)
                                        @php
                                            $readPct = $message->recipients_count > 0
                                                ? round(($message->read_count / $message->recipients_count) * 100)
                                                : 0;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="subject-cell text-start"><strong>{{ $message->subject }}</strong></td>
                                            <td class="excerpt-cell text-start">{{ $message->excerpt }}</td>
                                            <td>
                                                <span
                                                    class="priority-pill {{ $message->priority }}">{{ $message->priority_label }}</span>
                                            </td>
                                            <td><span class="audience-pill">{{ $message->audience_label }}</span></td>
                                            <td>{{ optional($message->sender)->firstname }}
                                                {{ optional($message->sender)->lastname }}</td>
                                            <td class="text-nowrap">{{ $message->created_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="read-progress"><span style="width:{{ $readPct }}%;"></span></div>
                                                    <small
                                                        class="text-muted">{{ $message->read_count }}/{{ $message->recipients_count }}</small>
                                                </div>
                                            </td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('notifications.show', $message->id) }}"
                                                    class="btn btn-outline-dark btn-sm" title="View details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" title="Delete"
                                                    onclick="nbDeleteMessage({{ $message->id }}, '{{ addslashes($message->subject) }}')">
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

    {{-- ===================== COMPOSE MODAL ===================== --}}
    <div class="modal fade" id="composeMessageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('notifications.store') }}" id="composeMessageForm">
                    @csrf
                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title"><i class="fa fa-paper-plane me-2"></i> Compose Message</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" class="form-control" maxlength="255" required
                                    placeholder="e.g. Deadline extension for subject registration">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Priority</label>
                                <select name="priority" class="form-control">
                                    <option value="normal">Normal</option>
                                    <option value="important">Important</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Message</label>
                                <textarea name="body" class="form-control" rows="5" required
                                    placeholder="Write the message you want to send..."></textarea>
                            </div>
                        </div>

                        <hr>

                        <label class="fw-bold mb-2">Recipients</label>
                        @include('broadcast-messages.partials.recipient-picker')

                        <div
                            class="alert alert-light border mt-3 mb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <span><i class="fa fa-users me-2 text-success"></i>
                                <strong id="nbTotalSelectedLabel">No recipients selected yet</strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#026837;">
                            <i class="fa fa-paper-plane me-2"></i>Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function nbToggleSchoolsMode() {
            const mode = document.querySelector('input[name="schools_mode"]:checked').value;
            document.getElementById('nbSchoolsListWrapper').style.display = mode === 'selected' ? 'block' : 'none';

            // "All" mode doesn't need individual boxes checked, but keep them
            // in sync visually / clear them out when switching to none.
            if (mode !== 'selected') {
                document.querySelectorAll('.nb-school-check').forEach(cb => cb.checked = false);
            }
            nbUpdatePickedCounts();
        }

        function nbToggleUsersMode() {
            const mode = document.querySelector('input[name="users_mode"]:checked').value;
            document.getElementById('nbUsersListWrapper').style.display = mode === 'selected' ? 'block' : 'none';

            if (mode !== 'selected') {
                document.querySelectorAll('.nb-user-check').forEach(cb => cb.checked = false);
            }
            nbUpdatePickedCounts();
        }

        function nbFilterList(listId, term) {
            term = term.toLowerCase().trim();
            document.querySelectorAll('#' + listId + ' .nb-picker-row').forEach(row => {
                row.style.display = row.dataset.search.includes(term) ? 'flex' : 'none';
            });
        }

        function nbSelectAllVisible(listId, checked) {
            document.querySelectorAll('#' + listId + ' .nb-picker-row').forEach(row => {
                if (row.style.display !== 'none') {
                    row.querySelector('input[type=checkbox]').checked = checked;
                }
            });
            nbUpdatePickedCounts();
        }

        function nbUpdatePickedCounts() {
            const schoolsMode = document.querySelector('input[name="schools_mode"]:checked').value;
            const usersMode = document.querySelector('input[name="users_mode"]:checked').value;

            const schoolsChecked = document.querySelectorAll('.nb-school-check:checked').length;
            const usersChecked = document.querySelectorAll('.nb-user-check:checked').length;

            document.getElementById('nbSchoolsPickedCount').textContent = schoolsMode === 'all'
                ? '{{ $schools->count() }}'
                : (schoolsMode === 'selected' ? schoolsChecked : 0);

            document.getElementById('nbUsersPickedCount').textContent = usersMode === 'all'
                ? '{{ $systemUsers->count() }}'
                : (usersMode === 'selected' ? usersChecked : 0);

            const parts = [];
            if (schoolsMode === 'all') parts.push('All Schools ({{ $schools->count() }})');
            else if (schoolsMode === 'selected') parts.push(schoolsChecked + ' School(s)');

            if (usersMode === 'all') parts.push('All System Users ({{ $systemUsers->count() }})');
            else if (usersMode === 'selected') parts.push(usersChecked + ' System User(s)');

            document.getElementById('nbTotalSelectedLabel').textContent = parts.length
                ? 'Sending to: ' + parts.join(' + ')
                : 'No recipients selected yet';
        }

        document.getElementById('composeMessageForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const schoolsMode = document.querySelector('input[name="schools_mode"]:checked').value;
            const usersMode = document.querySelector('input[name="users_mode"]:checked').value;

            if (schoolsMode === 'none' && usersMode === 'none') {
                Swal.fire({ icon: 'warning', title: 'No recipients selected', text: 'Please choose Schools and/or System Users to receive this message.', confirmButtonColor: '#026837' });
                return;
            }

            if (schoolsMode === 'selected' && document.querySelectorAll('.nb-school-check:checked').length === 0) {
                Swal.fire({ icon: 'warning', title: 'Pick at least one school', text: 'You chose "specific schools" but haven\'t selected any yet.', confirmButtonColor: '#026837' });
                return;
            }

            if (usersMode === 'selected' && document.querySelectorAll('.nb-user-check:checked').length === 0) {
                Swal.fire({ icon: 'warning', title: 'Pick at least one system user', text: 'You chose "specific users" but haven\'t selected any yet.', confirmButtonColor: '#026837' });
                return;
            }

            Swal.fire({
                title: 'Send this message?',
                text: 'Are you sure you want to deliver this notification to the selected recipients?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#026837',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Send It',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sending...',
                        text: 'Delivering your message. Please wait.',
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

        function nbDeleteMessage(id, subject) {
            Swal.fire({
                icon: 'warning',
                title: 'Delete "' + subject + '"?',
                text: 'This will remove the message for every recipient. This cannot be undone.',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete',
            }).then(result => {
                if (!result.isConfirmed) return;

                fetch('/notifications/' + id, {
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
    </script>
@endsection