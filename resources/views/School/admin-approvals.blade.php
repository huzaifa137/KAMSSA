@extends('layouts-side-bar.master')
@section('content')
    <style>
        :root {
            --forest: #026837;
            --green: #287C44;
            --green-light: #3da05a;
            --mint: #e8f5e9;
            --amber: #f59e0b;
            --coral: #ef4444;
            --slate: #64748b;
            --radius: 14px;
        }

        .page-hero {
            background: linear-gradient(135deg, #026837 0%, #287C44 100%);
            color: #fff;
            border-radius: 16px;
            padding: 24px 28px;
            margin-bottom: 24px;
        }

        .tab-bar {
            display: flex;
            gap: 6px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 9px 20px;
            border-radius: 50px;
            border: 2px solid #dee2e6;
            background: #fff;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: .2s;
        }

        .tab-btn.active {
            background: var(--forest);
            color: #fff;
            border-color: var(--forest);
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        /* School cards */
        .school-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 18px;
        }

        .school-card {
            border-radius: var(--radius);
            background: #fff;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .07);
            text-decoration: none;
            color: inherit;
            display: block;
            transition: .25s;
        }

        .school-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(13, 75, 31, .14);
            text-decoration: none;
            color: inherit;
        }

        .sc-head {
            background: linear-gradient(135deg, #026837, #287C44);
            color: #fff;
            padding: 16px 18px 12px;
        }

        .sc-num {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .sc-name {
            font-size: 12px;
            opacity: .85;
            margin-top: 2px;
        }

        .sc-body {
            padding: 14px 18px;
        }

        .sc-stat {
            text-align: center;
        }

        .sc-stat .n {
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
        }

        .sc-stat .l {
            font-size: 11px;
            color: var(--slate);
            margin-top: 3px;
        }

        .c-pending {
            color: #e67e22;
        }

        .c-approved {
            color: var(--green);
        }

        .c-total {
            color: #3b82f6;
        }

        .c-slots {
            color: #8b5cf6;
        }

        .slot-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--green);
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            margin-top: 8px;
        }

        .slot-pill.warn {
            background: #fef3c7;
            border-color: #fde68a;
            color: #92400e;
        }

        .slot-pill.danger {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        .lock-badge {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 50px;
            background: #dcfce7;
            color: var(--green);
            border: 1px solid #86efac;
            font-weight: 600;
        }

        .lock-badge.closed {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fca5a5;
        }

        /* Slot management */
        .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            background: #fff;
            border-radius: var(--radius);
            padding: 18px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
            margin-bottom: 20px;
        }

        .search-box input {
            flex: 1;
            min-width: 200px;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-search {
            padding: 10px 22px;
            background: var(--forest);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px;
        }

        .school-result-row {
            background: #fff;
            border-radius: 10px;
            padding: 16px 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
            margin-bottom: 12px;
            border-left: 4px solid var(--green);
        }

        .school-result-row .sname {
            font-weight: 700;
            font-size: 15px;
        }

        .school-result-row .smeta {
            font-size: 12px;
            color: var(--slate);
        }

        /* Period management */
        .period-card {
            background: #fff;
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
            margin-bottom: 16px;
        }

        .period-active-badge {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
        }

        .period-inactive-badge {
            background: #f1f5f9;
            color: var(--slate);
            border: 1px solid #e2e8f0;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 11px;
        }

        /* Inputs */
        .form-control-sm2 {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
        }

        .btn-green {
            background: var(--green);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-green:hover {
            background: var(--forest);
        }

        .btn-outline-green {
            background: #fff;
            color: var(--green);
            border: 1.5px solid var(--green);
            border-radius: 8px;
            padding: 7px 16px;
            font-weight: 600;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-danger2 {
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 12px;
            cursor: pointer;
        }

        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .dot-open {
            background: #22c55e;
        }

        .dot-closed {
            background: #ef4444;
        }
    </style>

    <div class="side-app">

        {{-- PAGE HERO --}}
        <div class="page-hero d-flex justify-content-between align-items-start flex-wrap" style="gap:12px;">
            <div>
                <h4 class="mb-1"><i class="fas fa-user-check mr-2"></i>Student Approvals & Registration Management</h4>
                <small style="opacity:.8;">Manage school slots, registration periods, and review submitted students</small>
            </div>
            <div class="text-right">
                <div style="font-size:28px; font-weight:800;">{{ collect($schools)->sum('pending_count') }}</div>
                <small style="opacity:.8;">Total Pending Approval</small>
                <div class="mt-1">
                    @if($globalOpen)
                        <span
                            style="background:rgba(255,255,255,.2); padding:4px 12px; border-radius:50px; font-size:11px; font-weight:700;">
                            <span class="status-dot dot-open"></span> Registration OPEN
                        </span>
                    @else
                        <span
                            style="background:rgba(255,255,255,.15); padding:4px 12px; border-radius:50px; font-size:11px; font-weight:700;">
                            <span class="status-dot dot-closed"></span> Registration CLOSED
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB BAR --}}
        <div class="tab-bar">
            <button class="tab-btn active" data-tab="tab-schools"><i class="fas fa-school mr-1"></i> Schools
                Overview</button>
            <button class="tab-btn" data-tab="tab-slots"><i class="fas fa-ticket-alt mr-1"></i> Manage Slots</button>
            <button class="tab-btn" data-tab="tab-period"><i class="fas fa-calendar-alt mr-1"></i> Registration
                Period</button>
        </div>

        {{-- ═══════════════════════ TAB 1: SCHOOLS OVERVIEW ═══════════════════════ --}}
        <div class="tab-pane active" id="tab-schools">
            @if(empty($schools))
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No school registrations found yet.</h5>
                    <p class="text-muted">Once schools start registering students, they'll appear here.</p>
                </div>
            @else
                <div class="school-grid">
                    @foreach($schools as $school)
                        <a href="{{ route('admin.student.approvals.detail', $school['prefix']) }}" class="school-card">
                            <div class="sc-head">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="sc-num">{{ $school['prefix'] }}</div>
                                        <div class="sc-name">{{ $school['school_name'] }}</div>
                                        <div class="sc-name">Year: {{ $school['admission_year'] }}</div>
                                    </div>
                                    @if($school['pending_count'] > 0)
                                        <span
                                            style="background:rgba(255,200,0,.25); color:#fef9c3; border:1px solid rgba(255,200,0,.4); padding:3px 9px; border-radius:50px; font-size:11px; font-weight:700;">
                                            <i class="fas fa-clock mr-1"></i>{{ $school['pending_count'] }} Pending
                                        </span>
                                    @endif
                                </div>
                                {{-- Slot pill --}}
                                @php
                                    $rem = $school['slots_remaining'];
                                    $pillClass = $rem > 5 ? '' : ($rem > 0 ? 'warn' : 'danger');
                                @endphp
                                <div class="slot-pill {{ $pillClass }} mt-2">
                                    <i class="fas fa-ticket-alt"></i>
                                    {{ $school['slots_allocated'] }} allocated &bull;
                                    {{ $rem }} remaining
                                    @if($school['school_reg_open'])
                                        &bull; <span class="status-dot dot-open" style="width:7px;height:7px;"></span>Open
                                    @else
                                        &bull; <span class="status-dot dot-closed" style="width:7px;height:7px;"></span>Closed
                                    @endif
                                </div>
                            </div>
                            <div class="sc-body">
                                <div class="row text-center no-gutters">
                                    <div class="col-3 sc-stat">
                                        <div class="n c-total">{{ $school['total_registered'] }}</div>
                                        <div class="l">Registered</div>
                                    </div>
                                    <div class="col-3 sc-stat">
                                        <div class="n c-pending">{{ $school['pending_count'] }}</div>
                                        <div class="l">Pending</div>
                                    </div>
                                    <div class="col-3 sc-stat">
                                        <div class="n c-approved">{{ $school['approved_count'] }}</div>
                                        <div class="l">Approved</div>
                                    </div>
                                    <div class="col-3 sc-stat">
                                        <div class="n c-slots">{{ $school['slots_allocated'] }}</div>
                                        <div class="l">Slots</div>
                                    </div>
                                </div>
                                <div class="mt-2" style="font-size:11px; color:var(--slate); text-align:right;">
                                    Last activity:
                                    {{ $school['latest_submission'] ? \Carbon\Carbon::parse($school['latest_submission'])->diffForHumans() : 'N/A' }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ═══════════════════════ TAB 2: MANAGE SLOTS ═══════════════════════ --}}
        <div class="tab-pane" id="tab-slots">
            <div class="search-box">
                <i class="fas fa-search text-muted"></i>
                <input type="text" id="slotSearchInput" placeholder="Search school by name or number…">
                <select id="slotYearSelect" class="form-control-sm2" style="max-width:160px;">
                    @if($activeYear)
                        <option value="{{ $activeYear->year_en }}">{{ $activeYear->year_en }}</option>
                    @endif
                    @foreach(range(date('Y') - 2, date('Y') + 1) as $y)
                        @if(!$activeYear || $y != $activeYear->year_en)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endif
                    @endforeach
                </select>
                <button class="btn-search" id="slotSearchBtn"><i class="fas fa-search mr-1"></i>Search</button>
            </div>

            <div id="slotResultsContainer"></div>

            {{-- Assign Slots Modal --}}
            <div class="modal fade" id="assignSlotsModal" tabindex="-1">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background:var(--forest); color:#fff;">
                            <h5 class="modal-title"><i class="fas fa-ticket-alt mr-2"></i>Assign Registration Slots</h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p><strong id="assignSchoolName"></strong></p>
                            <input type="hidden" id="assignSchoolId">
                            <input type="hidden" id="assignYear">
                            <div class="mb-3">
                                <label class="font-weight-600" style="font-size:13px;">Current Allocation</label>
                                <div id="currentSlotInfo" class="mt-1" style="font-size:13px; color:var(--slate);"></div>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-600" style="font-size:13px;">Add Slots <span
                                        style="color:var(--coral);">*</span></label>
                                <input type="number" id="slotsToAdd" class="form-control-sm2 mt-1" placeholder="e.g. 10"
                                    min="1" max="500">
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-600" style="font-size:13px;">Reason (optional)</label>
                                <input type="text" id="slotReason" class="form-control-sm2 mt-1"
                                    placeholder="e.g. Extra payment received">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-green" id="confirmAssignSlots"><i class="fas fa-check mr-1"></i>Assign
                                Slots</button>
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- History Modal --}}
            <div class="modal fade" id="slotHistoryModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background:var(--forest); color:#fff;">
                            <h5 class="modal-title"><i class="fas fa-history mr-2"></i>Slot Allocation History</h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body p-0">
                            <div id="historyList" style="max-height:400px; overflow-y:auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════ TAB 3: REGISTRATION PERIOD ═══════════════════════ --}}
        <div class="tab-pane" id="tab-period">

            {{-- Current Status Banner --}}
            <div class="period-card mb-3" style="border-left:4px solid {{ $globalOpen ? '#22c55e' : '#ef4444' }};">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong style="font-size:15px;">
                            <span class="status-dot {{ $globalOpen ? 'dot-open' : 'dot-closed' }}"></span>
                            Global Registration is currently <span
                                style="color:{{ $globalOpen ? '#16a34a' : '#dc2626' }}">{{ $globalOpen ? 'OPEN' : 'CLOSED' }}</span>
                        </strong>
                        @if($globalPeriod)
                            <div style="font-size:12px; color:var(--slate); margin-top:4px;">
                                Period: <strong>{{ $globalPeriod->name ?? 'Unnamed' }}</strong> &bull;
                                Year: {{ $globalPeriod->admission_year }} &bull;
                                @if($globalPeriod->opens_at) Opens:
                                {{ \Carbon\Carbon::parse($globalPeriod->opens_at)->format('d M Y H:i') }} @endif
                                @if($globalPeriod->closes_at) &bull; Closes:
                                {{ \Carbon\Carbon::parse($globalPeriod->closes_at)->format('d M Y H:i') }} @endif
                            </div>
                        @else
                            <div style="font-size:12px; color:var(--slate); margin-top:4px;">No active registration period
                                configured.</div>
                        @endif
                    </div>
                    @if($globalPeriod)
<div class="d-flex align-items-center" style="gap:10px;">
    <span style="font-size:12px; color:var(--slate);">
        {{ $globalPeriod->is_active ? 'Click to close' : 'Click to open' }}
    </span>
    {{-- Toggle switch --}}
    <label style="position:relative; display:inline-block; width:52px; height:28px; margin:0; cursor:pointer;">
        <input type="checkbox" id="globalPeriodToggle"
            data-id="{{ $globalPeriod->id }}"
            {{ $globalPeriod->is_active ? 'checked' : '' }}
            style="opacity:0; width:0; height:0;">
        <span style="
            position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0;
            background:{{ $globalPeriod->is_active ? '#22c55e' : '#e2e8f0' }};
            border-radius:28px; transition:.3s;
        ">
            <span style="
                position:absolute; content:''; height:20px; width:20px;
                left:{{ $globalPeriod->is_active ? '28px' : '4px' }};
                bottom:4px; background:white; border-radius:50%; transition:.3s;
                display:block;
            "></span>
        </span>
    </label>
</div>
                    @endif
                </div>
            </div>

            {{-- Create New Period Form --}}
            <div class="period-card">
                <h5 class="mb-3" style="color:var(--forest);"><i class="fas fa-plus-circle mr-2"></i>Create / Activate
                    Registration Period</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label style="font-size:13px; font-weight:600;">Period Name</label>
                        <input type="text" id="newPeriodName" class="form-control-sm2 mt-1"
                            placeholder="e.g. 2026 Admissions Window">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label style="font-size:13px; font-weight:600;">Admission Year <span
                                style="color:var(--coral);">*</span></label>
                        <input type="number" id="newPeriodYear" class="form-control-sm2 mt-1"
                            value="{{ $activeYear ? $activeYear->year_en : date('Y') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label style="font-size:13px; font-weight:600;">Opens At (optional)</label>
                        <input type="datetime-local" id="newPeriodOpens" class="form-control-sm2 mt-1">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label style="font-size:13px; font-weight:600;">Closes At (optional)</label>
                        <input type="datetime-local" id="newPeriodCloses" class="form-control-sm2 mt-1">
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap:12px;">
                    <button class="btn-green" id="createPeriodBtn">
                        <i class="fas fa-save mr-1"></i>Save & Activate Period
                    </button>
                    <small class="text-muted">Activating a new period automatically deactivates the current one.</small>
                </div>
            </div>

            {{-- All Periods Table --}}
            <div class="period-card">
                <h5 class="mb-3" style="color:var(--forest);"><i class="fas fa-list mr-2"></i>All Registration Periods</h5>
                <div id="periodsTableWrap">
                    <div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Loading…</div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>

    {{-- Edit Period Modal --}}
<div class="modal fade" id="editPeriodModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background:#026837; color:#fff;">
                <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Edit Registration Period</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="editPeriodForm">
                <div class="modal-body">
                    <input type="hidden" id="editPeriodId">
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600;">Period Name</label>
                        <input type="text" id="editPeriodName" class="form-control-sm2 mt-1" placeholder="e.g. 2026 Admissions Window">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600;">Admission Year <span style="color:#ef4444;">*</span></label>
                        <input type="number" id="editPeriodYear" class="form-control-sm2 mt-1">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600;">Opens At (optional)</label>
                        <input type="datetime-local" id="editPeriodOpens" class="form-control-sm2 mt-1">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:13px; font-weight:600;">Closes At (optional)</label>
                        <input type="datetime-local" id="editPeriodCloses" class="form-control-sm2 mt-1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-green" id="editPeriodSaveBtn">
                        <i class="fas fa-save mr-1"></i>Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div> {{-- /side-app --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <script>
    // ── Tab switching ─────────────────────────────────────────────────────────────
    $(document).on('click', '.tab-btn', function () {
        $('.tab-btn').removeClass('active');
        $('.tab-pane').removeClass('active');
        $(this).addClass('active');
        $('#' + $(this).data('tab')).addClass('active');
        if ($(this).data('tab') === 'tab-period') loadPeriods();
    });

    // ── Slot search ───────────────────────────────────────────────────────────────
    let currentSearchPage = 1;

    $('#slotSearchBtn').on('click', function () { searchSchools(1); });
    $('#slotSearchInput').on('keypress', function (e) { if (e.which === 13) searchSchools(1); });

    function searchSchools(page = 1) {
        
        currentSearchPage = page;
        const q    = $('#slotSearchInput').val().trim();
        const year = $('#slotYearSelect').val();

        if (page === 1) {
            $('#slotResultsContainer').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Searching…</div>');
        }

        $.get('{{ route("admin.school.slots.search") }}', { q, year, page }, function (res) {
            if (!res.schools || res.schools.length === 0) {
                $('#slotResultsContainer').html('<div class="text-center py-5 text-muted"><i class="fas fa-search fa-2x mb-2"></i><br>No schools found.</div>');
                return;
            }

            let html = `<div style="font-size:12px; color:var(--slate); margin-bottom:10px;">
                Showing ${(res.page - 1) * res.per_page + 1}–${Math.min(res.page * res.per_page, res.total)} of <strong>${res.total}</strong> schools
            </div>`;

            res.schools.forEach(s => {
                const slot   = s.slot;
                const alloc  = slot ? slot.slots_allocated : 0;
                const used   = slot ? slot.slots_used : 0;
                const rem    = slot ? slot.slots_remaining : 0;
                const pct    = alloc > 0 ? Math.round((used / alloc) * 100) : 0;
                const barClr = pct >= 100 ? '#ef4444' : pct >= 80 ? '#f59e0b' : '#22c55e';

                html += `
                    <div class="school-result-row">
                        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:10px;">
                            <div>
                                <div class="sname">${s.House} <span style="font-size:12px; color:#94a3b8;">[${s.Number}]</span></div>
                                <div class="smeta">${s.Location || '—'} &bull; Year: ${res.year}</div>
                                <div class="mt-2" style="font-size:12px;">
                                    <strong>${alloc}</strong> allocated &bull;
                                    <strong>${used}</strong> used &bull;
                                    <strong style="color:${rem > 0 ? '#16a34a' : '#dc2626'}">${rem}</strong> remaining
                                </div>
                                <div style="margin-top:6px; height:6px; background:#e2e8f0; border-radius:50px; width:200px;">
                                    <div style="height:6px; border-radius:50px; background:${barClr}; width:${Math.min(pct, 100)}%;"></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end" style="gap:6px;">
                                <button class="btn-green btn-assign-slots"
                                    data-id="${s.ID}" data-name="${s.House}" data-number="${s.Number}"
                                    data-alloc="${alloc}" data-used="${used}" data-rem="${rem}" data-year="${res.year}">
                                    <i class="fas fa-plus mr-1"></i>Add Slots
                                </button>
                                <button class="btn-outline-green btn-view-history" data-id="${s.ID}" data-year="${res.year}" data-name="${s.House}">
                                    <i class="fas fa-history mr-1"></i>History
                                </button>
                                ${slot ? `
                                <button class="btn-outline-green btn-toggle-reg" data-id="${s.ID}" data-year="${res.year}"
                                    data-open="${slot.registration_open ? '1' : '0'}"
                                    style="${slot.registration_open ? 'color:#dc2626;border-color:#dc2626;' : 'color:#16a34a;border-color:#16a34a;'}">
                                    <i class="fas fa-${slot.registration_open ? 'lock' : 'unlock'} mr-1"></i>
                                    ${slot.registration_open ? 'Close for School' : 'Open for School'}
                                </button>` : `
                                <button class="btn-outline-green btn-toggle-reg" data-id="${s.ID}" data-year="${res.year}" data-open="0"
                                    style="color:#16a34a;border-color:#16a34a;">
                                    <i class="fas fa-unlock mr-1"></i>Open for School
                                </button>`}
                            </div>
                        </div>
                    </div>`;
            });

            // ── Pagination ────────────────────────────────────────────────────────
            if (res.total_pages > 1) {
                html += `<div class="d-flex justify-content-center align-items-center flex-wrap" style="gap:6px; margin-top:16px;">`;

                html += `<button class="btn-outline-green page-btn" data-page="1"
                    ${res.page === 1 ? 'disabled style="opacity:.4;cursor:default;"' : ''}>«</button>`;
                html += `<button class="btn-outline-green page-btn" data-page="${res.page - 1}"
                    ${res.page === 1 ? 'disabled style="opacity:.4;cursor:default;"' : ''}>‹</button>`;

                const start = Math.max(1, res.page - 2);
                const end   = Math.min(res.total_pages, res.page + 2);
                for (let p = start; p <= end; p++) {
                    html += `<button class="page-btn ${p === res.page ? 'btn-green' : 'btn-outline-green'}"
                        data-page="${p}" ${p === res.page ? 'style="cursor:default;"' : ''}>${p}</button>`;
                }

                html += `<button class="btn-outline-green page-btn" data-page="${res.page + 1}"
                    ${res.page === res.total_pages ? 'disabled style="opacity:.4;cursor:default;"' : ''}>›</button>`;
                html += `<button class="btn-outline-green page-btn" data-page="${res.total_pages}"
                    ${res.page === res.total_pages ? 'disabled style="opacity:.4;cursor:default;"' : ''}>»</button>`;

                html += `<span style="font-size:12px; color:var(--slate); margin-left:8px;">Page ${res.page} of ${res.total_pages}</span>`;
                html += `</div>`;
            }

            $('#slotResultsContainer').html(html);
        });
    }

    // ── Pagination click ──────────────────────────────────────────────────────────
    $(document).on('click', '.page-btn:not([disabled])', function () {
        searchSchools(parseInt($(this).data('page')));
    });

    // ── Assign Slots modal ────────────────────────────────────────────────────────
    $(document).on('click', '.btn-assign-slots', function () {
        const d = $(this).data();
        $('#assignSchoolId').val(d.id);
        $('#assignYear').val(d.year);
        $('#assignSchoolName').text(d.name + ' [' + d.number + ']');
        $('#currentSlotInfo').html(`Allocated: <strong>${d.alloc}</strong> &bull; Used: <strong>${d.used}</strong> &bull; Remaining: <strong>${d.rem}</strong>`);
        $('#slotsToAdd').val('');
        $('#slotReason').val('');
        $('#assignSlotsModal').modal('show');
    });

    $('#confirmAssignSlots').on('click', function () {
        const slots = parseInt($('#slotsToAdd').val());
        if (!slots || slots < 1) { Swal.fire('Error', 'Enter a valid number of slots (min 1)', 'error'); return; }

        $.post('{{ route("admin.school.slots.assign") }}', {
            _token: '{{ csrf_token() }}',
            school_id: $('#assignSchoolId').val(),
            admission_year: $('#assignYear').val(),
            slots,
            reason: $('#slotReason').val()
        }, function (res) {
            $('#assignSlotsModal').modal('hide');
            Swal.fire({ icon: 'success', title: 'Slots Assigned', text: res.message, confirmButtonColor: '#287C44' });
            searchSchools(currentSearchPage);
        }).fail(function (xhr) {
            Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong', 'error');
        });
    });

    // ── Toggle per-school registration ────────────────────────────────────────────
    $(document).on('click', '.btn-toggle-reg', function () {
        const id   = $(this).data('id');
        const year = $(this).data('year');
        const open = $(this).data('open') == '1' ? 0 : 1;
        const msg  = open ? 'Open registration for this school?' : 'Close registration for this school?';

        Swal.fire({ title: msg, icon: 'question', showCancelButton: true, confirmButtonColor: '#287C44', confirmButtonText: 'Yes' }).then(r => {
            if (!r.isConfirmed) return;
            $.post('{{ route("admin.school.slots.toggle") }}', {
                _token: '{{ csrf_token() }}', school_id: id, admission_year: year, open
            }, function (res) {
                Swal.fire({ icon: 'success', title: res.message, timer: 1500, showConfirmButton: false });
                searchSchools(currentSearchPage);
            });
        });
    });

    // ── Slot history ──────────────────────────────────────────────────────────────
    $(document).on('click', '.btn-view-history', function () {
        const id   = $(this).data('id');
        const year = $(this).data('year');
        const name = $(this).data('name');
        $('#historyList').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i></div>');
        $('#slotHistoryModal').modal('show');
        $('.modal-title', '#slotHistoryModal').html('<i class="fas fa-history mr-2"></i>History — ' + name);

        $.get('{{ route("admin.school.slots.history") }}', { school_id: id, admission_year: year }, function (res) {
            if (!res.history || res.history.length === 0) {
                $('#historyList').html('<div class="text-center p-4 text-muted">No history yet.</div>');
                return;
            }
            let h = '';
            res.history.forEach((row, i) => {
                h += `<div style="padding:12px 16px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong>+${row.slots_added} slots</strong> → Total: ${row.total_after}
                        ${row.reason ? `<br><small class="text-muted">${row.reason}</small>` : ''}
                    </div>
                    <small class="text-muted">${row.created_at}</small>
                </div>`;
            });
            $('#historyList').html(h);
        });
    });

    // ── Registration Period Tab ───────────────────────────────────────────────────
    function loadPeriods() { }

    // ── Create Period ─────────────────────────────────────────────────────────────
    $('#createPeriodBtn').on('click', function () {
        const year = parseInt($('#newPeriodYear').val());
        if (!year) { Swal.fire('Error', 'Admission year is required', 'error'); return; }

        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving…');

        Swal.fire({
            title: 'Activate this registration period?',
            text: 'This will deactivate any currently active period.',
            icon: 'question', showCancelButton: true, confirmButtonColor: '#026837',
        }).then(r => {
            if (!r.isConfirmed) {
                $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i>Save & Activate Period');
                return;
            }
            $.ajax({
                url: '{{ route("admin.registration.period.save") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#newPeriodName').val(),
                    admission_year: year,
                    opens_at: $('#newPeriodOpens').val() || null,
                    closes_at: $('#newPeriodCloses').val() || null,
                    is_active: 1,
                },
                success: function (res) {
                    Swal.fire('Success', res.message || 'Period saved & activated!', 'success')
                        .then(() => location.reload());
                },
                error: function (data) { $('body').html(data.responseText); },
                complete: function () {
                    $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i>Save & Activate Period');
                }
            });
        });
    });

    // ── Close Period button ───────────────────────────────────────────────────────
    $('#closePeriodBtn').on('click', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Close global registration?',
            text: 'Schools will no longer be able to register students globally.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', confirmButtonText: 'Yes, close it'
        }).then(r => {
            if (!r.isConfirmed) return;
            $.ajax({
                url: `{{ url('/admin/registration-period') }}/${id}`,
                method: 'PUT',
                data: { _token: '{{ csrf_token() }}', is_active: 0 },
                success: () => location.reload(),
                error: xhr => Swal.fire('Error', xhr.responseJSON?.message || 'Failed', 'error')
            });
        });
    });

    // ── Open Period button ────────────────────────────────────────────────────────
    $('#openPeriodBtn').on('click', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Open global registration?',
            icon: 'question', showCancelButton: true, confirmButtonColor: '#026837',
            confirmButtonText: 'Yes, open it'
        }).then(r => {
            if (!r.isConfirmed) return;
            $.ajax({
                url: `{{ url('/admin/registration-period') }}/${id}`,
                method: 'PUT',
                data: { _token: '{{ csrf_token() }}', is_active: 1 },
                success: () => location.reload(),
                error: xhr => Swal.fire('Error', xhr.responseJSON?.message || 'Failed', 'error')
            });
        });
    });

    // ── Edit Period modal open ────────────────────────────────────────────────────
    $(document).on('click', '.btn-edit-period', function () {
        const id     = $(this).data('id');
        const name   = $(this).data('name');
        const year   = $(this).data('year');
        const opens  = $(this).data('opens') || '';
        const closes = $(this).data('closes') || '';

        $('#editPeriodId').val(id);
        $('#editPeriodName').val(name);
        $('#editPeriodYear').val(year);
        $('#editPeriodOpens').val(opens ? opens.replace(' ', 'T').substring(0, 16) : '');
        $('#editPeriodCloses').val(closes ? closes.replace(' ', 'T').substring(0, 16) : '');
        $('#editPeriodModal').modal('show');
    });

    // ── Edit Period form submit ───────────────────────────────────────────────────
    $('#editPeriodForm').on('submit', function (e) {
        e.preventDefault();
        const id   = $('#editPeriodId').val();
        const $btn = $('#editPeriodSaveBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving…');

        $.ajax({
            url: `{{ url('/admin/registration-period') }}/${id}`,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#editPeriodName').val(),
                admission_year: $('#editPeriodYear').val(),
                opens_at: $('#editPeriodOpens').val() || null,
                closes_at: $('#editPeriodCloses').val() || null,
                is_active: 1,
            },
            success: function (res) {
                $('#editPeriodModal').modal('hide');
                Swal.fire('Updated', res.message || 'Period updated!', 'success')
                    .then(() => location.reload());
            },
            error: function (xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Failed to update', 'error');
            },
            complete: function () {
                $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i>Save Changes');
            }
        });
    });

    // ── Render periods table ──────────────────────────────────────────────────────
    $('#periodsTableWrap').html(`
        @if($globalPeriod)
            <table class="table table-sm table-bordered" style="font-size:13px;">
                <thead style="background:#026837; color:#fff;">
                    <tr><th>Name</th><th>Year</th><th>Opens</th><th>Closes</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $globalPeriod->name ?? '—' }}</td>
                        <td>{{ $globalPeriod->admission_year }}</td>
                        <td>{{ $globalPeriod->opens_at ? \Carbon\Carbon::parse($globalPeriod->opens_at)->format('d M Y H:i') : '—' }}</td>
                        <td>{{ $globalPeriod->closes_at ? \Carbon\Carbon::parse($globalPeriod->closes_at)->format('d M Y H:i') : '—' }}</td>
                        <td>
                            @if($globalPeriod->is_active)
                                <span class="period-active-badge">ACTIVE</span>
                            @else
                                <span class="period-inactive-badge">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <button class="btn-outline-green btn-edit-period mr-1"
                                data-id="{{ $globalPeriod->id }}"
                                data-name="{{ $globalPeriod->name ?? '' }}"
                                data-year="{{ $globalPeriod->admission_year }}"
                                data-opens="{{ $globalPeriod->opens_at }}"
                                data-closes="{{ $globalPeriod->closes_at }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-danger2 btn-delete-period" data-id="{{ $globalPeriod->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="text-center py-4 text-muted"><i class="fas fa-calendar-times fa-2x mb-2"></i><br>No registration periods configured yet.</div>
        @endif
    `);

    // ── Delete period ─────────────────────────────────────────────────────────────
    $(document).on('click', '.btn-delete-period', function () {
        const id = $(this).data('id');
        Swal.fire({ title: 'Delete this period?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626' })
            .then(r => {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: `{{ url('/admin/registration-period') }}/${id}`,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: () => location.reload()
                });
            });
    });

    // ── Global period toggle switch ───────────────────────────────────────────────
    $('#globalPeriodToggle').on('change', function () {
        const id       = $(this).data('id');
        const isActive = $(this).is(':checked') ? 1 : 0;
        const action   = isActive ? 'open' : 'close';

        Swal.fire({
            title: `${isActive ? 'Open' : 'Close'} global registration?`,
            text: isActive
                ? 'Schools will be able to register students globally.'
                : 'Schools will no longer be able to register students globally.',
            icon: 'question', showCancelButton: true,
            confirmButtonColor: isActive ? '#026837' : '#dc2626',
            confirmButtonText: `Yes, ${action} it`
        }).then(r => {
            if (!r.isConfirmed) {
                $(this).prop('checked', !$(this).is(':checked'));
                return;
            }
            $.ajax({
                url: `{{ url('/admin/registration-period') }}/${id}`,
                method: 'PUT',
                data: { _token: '{{ csrf_token() }}', is_active: isActive },
                success: () => location.reload(),
                error: xhr => {
                    $(this).prop('checked', !$(this).is(':checked'));
                    Swal.fire('Error', xhr.responseJSON?.message || 'Failed', 'error');
                }
            });
        });
    });
</script>
@endsection