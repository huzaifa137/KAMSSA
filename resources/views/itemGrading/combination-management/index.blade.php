@extends('layouts-side-bar.master')

@section('content')
<div class="side-app">
    <div class="container-fluid mt-3">

        <style>
            .cm-table th, .cm-table td {
                padding: 8px 10px;
                border: 1px solid #e8e8e8;
                text-align: center;
                vertical-align: middle;
            }
            .cm-table thead th { background: #026837; color: #fff; }
            .cm-table tbody tr:nth-child(even) { background: #fafafa; }
            .cm-table tbody tr.inactive-row { opacity: .55; }

            .active-pill {
                padding: 3px 10px; border-radius: 12px; font-size: .75rem; font-weight: 600;
            }
            .active-pill.active { background-color: #e6f7ea; color: #1e7e34; border: 1px solid #1e7e34; }
            .active-pill.inactive { background-color: #f8e6e6; color: #a71d2a; border: 1px solid #a71d2a; }

            .subject-chip {
                display: inline-block;
                padding: 2px 9px;
                margin: 2px;
                border-radius: 12px;
                background: #eef3ff;
                color: #1c4ea3;
                font-size: .78rem;
                font-weight: 600;
            }

            .cm-actions { display: flex; align-items: center; justify-content: center; gap: 8px; }

            #combinationSubjectsContainer {
                max-height: 260px;
                overflow-y: auto;
                border: 1px solid #e8e8e8;
                border-radius: 8px;
                padding: 10px 14px;
            }
            #combinationSubjectsContainer .form-check { margin-bottom: 4px; }
        </style>

        <div class="card shadow-lg border-0">
            <div class="card-header d-flex justify-content-between align-items-center" style="background:#026837;">
                <h5 class="text-white mb-0"><i class="fa fa-layer-group me-2"></i> UACE Combinations</h5>
                <button class="btn btn-light btn-sm" onclick="cmOpenAddModal()">
                    <i class="fa fa-plus me-1"></i> Add Combination
                </button>
            </div>

            <div class="card-body">
                <p class="text-muted mb-3">
                    Define the standardized UACE combinations (e.g. PCM, HEG) and which principal subjects belong
                    to each. Once defined here, schools pick a combination per student on the Subject Registration
                    screen instead of ticking individual subjects.
                </p>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table cm-table mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Subjects</th>
                                <th>Students Assigned</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($combinations['UACE'] as $combination)
                                <tr class="{{ $combination->status === 'Inactive' ? 'inactive-row' : '' }}">
                                    <td><strong>{{ $combination->code }}</strong></td>
                                    <td class="text-start">{{ $combination->name }}</td>
                                    <td class="text-start">
                                        @foreach($combination->subjects as $subject)
                                            <span class="subject-chip">{{ $subject->md_name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $combination->student_count }}</td>
                                    <td>
                                        <span class="active-pill {{ strtolower($combination->status) }}">{{ $combination->status }}</span>
                                    </td>
                                    <td>
                                        <div class="cm-actions">
                                            <button class="btn btn-sm btn-outline-primary" title="Edit"
                                                onclick='cmOpenEditModal(
                                                    {{ $combination->id }},
                                                    {{ json_encode($combination->code) }},
                                                    {{ json_encode($combination->name) }},
                                                    {{ json_encode($combination->subjects->pluck("md_id")) }}
                                                )'>
                                                <i class="fa fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" title="Toggle Active/Inactive"
                                                onclick="cmToggleStatus({{ $combination->id }})">
                                                <i class="fa fa-toggle-on"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" title="Delete"
                                                onclick="cmDeleteCombination({{ $combination->id }}, {{ json_encode($combination->code) }}, {{ $combination->student_count }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted py-4">
                                        No combinations defined yet. Click "Add Combination" to create the first one (e.g. PCM).
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Add / Edit modal --}}
<div class="modal fade" id="combinationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="combinationForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="combinationFormMethod" value="POST">
                <div class="modal-header" style="background:#026837;">
                    <h5 class="modal-title text-white" id="combinationModalTitle">Add Combination</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>

                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Code</label>
                        <input type="text" name="code" id="combinationCode" class="form-control" placeholder="e.g. PCM" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" id="combinationName" class="form-control" placeholder="e.g. Physics, Chemistry, Mathematics" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-semibold">Principal Subjects</label>
                        <div id="combinationSubjectsContainer">
                            @foreach($availableSubjects['UACE'] as $subject)
                                <div class="form-check">
                                    <input class="form-check-input combination-subject-checkbox" type="checkbox"
                                        name="subject_ids[]" value="{{ $subject->md_id }}" id="subj-{{ $subject->md_id }}">
                                    <label class="form-check-label" for="subj-{{ $subject->md_id }}">
                                        {{ $subject->md_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Only Optional subjects can belong to a combination — compulsory subjects like General Paper are registered automatically for everyone.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save me-1"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function cmResetCheckboxes() {
        document.querySelectorAll('.combination-subject-checkbox').forEach(cb => cb.checked = false);
    }

    function cmOpenAddModal() {
        document.getElementById('combinationModalTitle').innerHTML = '<i class="fa fa-plus me-2"></i> Add Combination';
        document.getElementById('combinationForm').action = "{{ route('combination.management.store') }}";
        document.getElementById('combinationFormMethod').value = 'POST';
        document.getElementById('combinationCode').value = '';
        document.getElementById('combinationName').value = '';
        cmResetCheckboxes();
        $('#combinationModal').modal('show');
    }

    function cmOpenEditModal(id, code, name, subjectIds) {
        document.getElementById('combinationModalTitle').innerHTML = '<i class="fa fa-pen me-2"></i> Edit Combination';
        document.getElementById('combinationForm').action = "{{ url('combination-management') }}/" + id;
        document.getElementById('combinationFormMethod').value = 'PUT';
        document.getElementById('combinationCode').value = code;
        document.getElementById('combinationName').value = name;
        cmResetCheckboxes();
        subjectIds.forEach(sid => {
            const cb = document.getElementById('subj-' + sid);
            if (cb) cb.checked = true;
        });
        $('#combinationModal').modal('show');
    }

    function cmToggleStatus(id) {
        fetch("{{ url('combination-management') }}/" + id + "/toggle-status", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    Swal.fire({ icon: 'error', title: 'Could not update', text: data.message || 'Please try again.', confirmButtonColor: '#d33' });
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Please try again.', confirmButtonColor: '#d33' });
            });
    }

    function cmDeleteCombination(id, code, studentCount) {
        if (studentCount > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Cannot delete "' + code + '"',
                html: 'This combination already has <strong>' + studentCount + '</strong> student(s) assigned to it.<br><br>Deactivate it instead to keep historic records intact.',
                confirmButtonColor: '#026837'
            });
            return;
        }

        Swal.fire({
            icon: 'warning',
            title: 'Delete "' + code + '"?',
            text: 'This cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) return;

            fetch("{{ url('combination-management') }}/" + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Deleted', text: data.message, confirmButtonColor: '#026837' })
                            .then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Could not delete', text: data.message || 'Please try again.', confirmButtonColor: '#d33' });
                    }
                })
                .catch(() => {
                    Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Please try again.', confirmButtonColor: '#d33' });
                });
        });
    }
</script>
@endsection