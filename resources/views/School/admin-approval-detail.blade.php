@extends('layouts-side-bar.master')
@section('content')
<style>
.card { border:none; border-radius:12px; box-shadow:0 2px 15px rgba(0,0,0,.08); }
.badge-pending  { background:#ffc107; color:#000; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
.badge-approved { background:#22c55e; color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
.badge-returned { background:#ef4444; color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
.badge-photo    { background:#f59e0b; color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; }
.badge-attached { background:#3b82f6; color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; }
table thead th  { background:#026837; color:#fff; padding:12px 14px; font-size:13px; }
table tbody td  { padding:10px 14px; vertical-align:middle; border-bottom:1px solid #f1f5f9; font-size:13px; }
tr.locked-row   { background:#f0fdf4 !important; }
.slot-info-bar  { background:#f8fafc; border-radius:10px; padding:14px 18px; border:1px solid #e2e8f0; margin-bottom:18px; font-size:13px; }
.action-bar     { background:#f8f9fa; border-radius:10px; padding:14px 18px; margin-bottom:18px; border:1px solid #e0e0e0; }
.filter-tabs    { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:14px; }
.ftab { padding:7px 16px; border-radius:50px; border:1.5px solid #dee2e6; background:#fff; font-size:12px; font-weight:600; cursor:pointer; }
.ftab.active { background:#026837; color:#fff; border-color:#026837; }
</style>

<div class="side-app">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                     style="background:#026837; border-radius:12px 12px 0 0;">
                    <div>
                        <h4 class="card-title mb-0"><i class="fas fa-user-check mr-2"></i>{{ $schoolPrefix }} — Student Registrations</h4>
                        <small style="opacity:.85;">{{ $schoolName }}</small>
                    </div>
                    <a href="{{ route('admin.student.approvals') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back
                    </a>
                </div>

                <div class="card-body">

                    {{-- Slot info bar --}}
                    @if($slot)
                    <div class="slot-info-bar d-flex flex-wrap" style="gap:20px; align-items:center;">
                        <div><i class="fas fa-ticket-alt mr-1 text-purple" style="color:#8b5cf6;"></i>
                            <strong>{{ $slot->slots_allocated }}</strong> Slots Allocated</div>
                        <div><i class="fas fa-user-graduate mr-1" style="color:#3b82f6;"></i>
                            <strong>{{ $slot->slots_used }}</strong> Used</div>
                        <div><i class="fas fa-check-circle mr-1" style="color:#22c55e;"></i>
                            <strong>{{ $slot->slotsRemaining() }}</strong> Remaining</div>
                        <div>
                            <span style="background:{{ $slot->registration_open ? '#dcfce7' : '#fee2e2' }};
                                color:{{ $slot->registration_open ? '#166534' : '#dc2626' }};
                                padding:3px 12px; border-radius:50px; font-size:11px; font-weight:700;">
                                <i class="fas fa-{{ $slot->registration_open ? 'unlock' : 'lock' }} mr-1"></i>
                                School Registration {{ $slot->registration_open ? 'Open' : 'Closed' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($registrations->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>No registrations for this school.
                        </div>
                    @else
                        {{-- Filter tabs --}}
                        <div class="filter-tabs">
                            <button class="ftab active" data-filter="all">All ({{ $registrations->count() }})</button>
                            <button class="ftab" data-filter="Pending Admin Approval">
                                Pending Approval ({{ $registrations->where('status','Pending Admin Approval')->count() }})
                            </button>
                            <button class="ftab" data-filter="Approved">
                                Approved ({{ $registrations->where('status','Approved')->count() }})
                            </button>
                            <button class="ftab" data-filter="Returned">
                                Returned ({{ $registrations->where('status','Returned')->count() }})
                            </button>
                            <button class="ftab" data-filter="Pending Photo Submission">
                                Photo Pending ({{ $registrations->where('status','Pending Photo Submission')->count() }})
                            </button>
                        </div>

                        {{-- Action bar --}}
                        <div class="action-bar d-flex justify-content-between align-items-center flex-wrap" style="gap:10px;">
                            <div class="d-flex align-items-center" style="gap:12px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <label class="custom-control-label font-weight-600" for="checkAll">Select All Visible</label>
                                </div>
                                <span id="selectedCount" class="text-muted" style="font-size:13px;">0 selected</span>
                            </div>
                            <div class="d-flex" style="gap:8px; flex-wrap:wrap;">
                                <button id="approveBtn" class="btn text-white btn-sm" style="background:#c51619; display:none;">
                                    <i class="fas fa-check mr-1"></i>Approve Selected
                                </button>
                                <button id="rejectBtn" class="btn btn-warning btn-sm" style="display:none;">
                                    <i class="fas fa-undo mr-1"></i>Return Selected
                                </button>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="approvalTable">
                                <thead>
                                    <tr>
                                        <th style="width:40px;"></th>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Class</th>
                                        <th>Year</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>Status</th>
                                        <th>Locked</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $i => $reg)
                                    <tr class="{{ $reg->is_locked ? 'locked-row' : '' }}" data-status="{{ $reg->status }}">
                                        <td>
                                           <input type="checkbox" class="approval-checkbox"
                                                    value="{{ $reg->id }}"
                                                    data-student-id="{{ $reg->student_id }}"
                                                    data-status="{{ $reg->status }}"
                                                    {{ !in_array($reg->status, ['Pending Admin Approval', 'Returned']) ? 'disabled' : '' }}>
                                        </td>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <img src="/assets/student_photos/{{ $reg->student_id }}.jpg"
                                                onerror="this.src='/assets/images/default-user.jpg';"
                                                style="width:44px;height:56px;object-fit:cover;border-radius:6px;border:2px solid #e9ecef;">
                                        </td>
                                        <td><code>{{ $reg->student_id }}</code></td>
                                        <td>
                                            {{ $reg->student_name }}
                                            @if($reg->student_name_ar)
                                                <br><small class="text-muted">{{ $reg->student_name_ar }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $reg->category === 'ID' ? 'info' : 'secondary' }}">
                                                {{ $reg->category === 'ID' ? 'Idaad' : 'Thanawi' }}
                                            </span>
                                        </td>
                                        <td>{{ $reg->class ?? '—' }}</td>
                                        <td>{{ $reg->admission_year }}</td>
                                        <td>{{ $reg->student_sex }}</td>
                                        <td>{{ $reg->date_of_birth ? \Carbon\Carbon::parse($reg->date_of_birth)->format('d/m/Y') : '—' }}</td>
                                        <td>
                                            @if($reg->status === 'Pending Admin Approval')
                                                <span class="badge-pending">Pending Approval</span>
                                            @elseif($reg->status === 'Approved')
                                                <span class="badge-approved">Approved</span>
                                            @elseif($reg->status === 'Returned')
                                                <span class="badge-returned">Returned</span>
                                            @elseif($reg->status === 'Attached Image, Pending Submission')
                                                <span class="badge-attached">Photo Attached</span>
                                            @else
                                                <span class="badge-photo">{{ $reg->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reg->is_locked)
                                                <span title="Submitted — locked for editing" style="color:#16a34a; font-size:16px;"><i class="fas fa-lock"></i></span>
                                            @else
                                                <span style="color:#94a3b8; font-size:16px;"><i class="fas fa-unlock"></i></span>
                                            @endif
                                        </td>
                                        <td style="white-space:nowrap;">
    <button class="btn btn-sm btn-info view-student mr-1"
        data-id="{{ $reg->id }}" data-student='@json($reg)' title="View Details">
        <i class="fas fa-eye"></i>
    </button>

    @if(in_array($reg->status, ['Pending Admin Approval', 'Attached Image, Pending Submission', 'Returned', 'Approved']))
        @if($reg->is_locked)
            <button class="btn btn-sm btn-warning btn-toggle-lock"
                data-id="{{ $reg->id }}"
                data-lock="0"
                data-student-id="{{ $reg->student_id }}"
                title="Unlock so school can edit"
                style="border-radius:6px;">
                <i class="fas fa-unlock-alt mr-1"></i>Unlock
            </button>
        @else
            <button class="btn btn-sm btn-secondary btn-toggle-lock"
                data-id="{{ $reg->id }}"
                data-lock="1"
                data-student-id="{{ $reg->student_id }}"
                title="Lock to prevent editing"
                style="border-radius:6px;">
                <i class="fas fa-lock mr-1"></i>Lock
            </button>
        @endif
    @endif
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

{{-- View Student Modal --}}
<div class="modal fade" id="viewStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#026837; color:#fff;">
                <h5 class="modal-title"><i class="fas fa-user mr-2"></i>Student Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img id="modal_photo" src="/assets/images/default-user.jpg"
                        style="width:100px;height:120px;object-fit:cover;border-radius:10px;border:3px solid #c51619;">
                    <h5 class="mt-2 mb-0" id="modal_name"></h5>
                    <p class="text-muted" id="modal_name_ar"></p>
                    <code id="modal_student_id"></code>
                </div>
                <div class="row" id="modal_details"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<script>
// ── Filter tabs ───────────────────────────────────────────────────────────────
$(document).on('click', '.ftab', function () {
    $('.ftab').removeClass('active');
    $(this).addClass('active');
    const f = $(this).data('filter');
    $('#approvalTable tbody tr').each(function () {
        const s = $(this).data('status');
        $(this).toggle(f === 'all' || s === f);
    });
    updateSelectedCount();
    updateActionButtons();
});

// ── Check all (visible only) ─────────────────────────────────────────────────
$('#checkAll').on('change', function () {
    const checked = this.checked;
    $('#approvalTable tbody tr:visible .approval-checkbox:not([disabled])').prop('checked', checked);
    updateSelectedCount();
    updateActionButtons();
});

$(document).on('change', '.approval-checkbox', function () {
    updateSelectedCount();
    updateActionButtons();
});

function updateSelectedCount() {
    const n = $('.approval-checkbox:checked').length;
    $('#selectedCount').text(n + ' selected');
}

function updateActionButtons() {
    const n = $('.approval-checkbox:checked').length;
    const anyPending = $('.approval-checkbox:checked').filter(function() {
        return $(this).data('status') === 'Pending Admin Approval';
    }).length > 0;
    $('#approveBtn, #rejectBtn').toggle(n > 0 && anyPending);
}

// ── Approve / Return ─────────────────────────────────────────────────────────
function getSelectedIds() {
    return $('.approval-checkbox:checked').map(function() { return $(this).val(); }).get();
}

$('#approveBtn').on('click', function () {
    const ids = getSelectedIds();
    if (!ids.length) return;
    Swal.fire({
        title: 'Approve ' + ids.length + ' student(s)?',
        text: 'They will be added to the main students database.',
        icon: 'question', showCancelButton: true,
        confirmButtonColor: '#c51619', confirmButtonText: 'Yes, Approve'
    }).then(r => {
        if (!r.isConfirmed) return;
        submitAction(ids, 'Approved');
    });
});

$('#rejectBtn').on('click', function () {
    const ids = getSelectedIds();
    if (!ids.length) return;
    Swal.fire({
        title: 'Return ' + ids.length + ' student(s)?',
        text: 'They will be returned to the school for correction and resubmission.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#e67e22', confirmButtonText: 'Yes, Return'
    }).then(r => {
        if (!r.isConfirmed) return;
        submitAction(ids, 'Rejected');
    });
});

function submitAction(ids, action) {
    $.post('{{ route("admin.update.approval.status") }}', {
        _token: '{{ csrf_token() }}',
        ids: JSON.stringify(ids),
        action
    }, function (res) {
        let msg = res.message;
        if (res.errors && res.errors.length) msg += '\n\nWarnings:\n' + res.errors.join('\n');
        Swal.fire({ icon: 'success', title: 'Done', text: msg, confirmButtonColor: '#c51619' })
            .then(() => location.reload());
    }).fail(xhr => Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong', 'error'));
}


// ── Toggle student lock ───────────────────────────────────────────────────────
$(document).on('click', '.btn-toggle-lock', function () {
    const id        = $(this).data('id');
    const lock      = $(this).data('lock');   // 0 = unlock, 1 = lock
    const studentId = $(this).data('student-id');
    const action    = lock == 1 ? 'lock' : 'unlock';
    const $btn      = $(this);

    Swal.fire({
        title: lock == 1 ? 'Lock this student?' : 'Unlock this student?',
        html: lock == 1
            ? `<b>${studentId}</b> will be locked — the school will not be able to edit.`
            : `<b>${studentId}</b> will be unlocked — the school can edit and resubmit.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: lock == 1 ? '#64748b' : '#f59e0b',
        confirmButtonText: lock == 1 ? 'Yes, Lock' : 'Yes, Unlock',
    }).then(r => {
        if (!r.isConfirmed) return;

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.post('{{ route("admin.student.toggle.lock") }}', {
            _token: '{{ csrf_token() }}',
            id,
            lock,
        }, function (res) {
            Swal.fire({
                icon: 'success',
                title: res.is_locked ? 'Locked' : 'Unlocked',
                text: res.message,
                confirmButtonColor: '#026837',
                timer: 2000,
                showConfirmButton: false,
            }).then(() => location.reload());
        }).fail(function (xhr) {
            $btn.prop('disabled', false);
            Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong', 'error');
        });
    });
});

// ── View student modal ────────────────────────────────────────────────────────
$(document).on('click', '.view-student', function () {
    const s = $(this).data('student');
    $('#modal_name').text(s.student_name);
    $('#modal_name_ar').text(s.student_name_ar || '');
    $('#modal_student_id').text(s.student_id);
    $('#modal_photo').attr('src', '/assets/student_photos/' + s.student_id + '.jpg')
        .on('error', function () { this.src = '/assets/images/default-user.jpg'; });

    const fields = [
        ['Category', s.category === 'ID' ? 'Idaad' : 'Thanawi'],
        ['Gender', s.student_sex], ['Admission Year', s.admission_year],
        ['Date of Birth', s.date_of_birth], ['Nationality', s.student_nationality || '—'],
        ['Birth Place', s.birth_place || '—'], ['Class', s.class || '—'],
        ['Section', s.section || '—'], ['District', s.district || '—'],
        ['Status', s.status], ['Locked', s.is_locked ? 'Yes (Submitted)' : 'No'],
        ['Submitted At', s.submitted_at || '—'],
    ];

    let html = '';
    fields.forEach(([lbl, val]) => {
        html += `<div class="col-md-4 mb-2"><small class="text-muted">${lbl}</small><div><strong>${val || '—'}</strong></div></div>`;
    });
    $('#modal_details').html(html);
    $('#viewStudentModal').modal('show');
});
</script>
@endsection