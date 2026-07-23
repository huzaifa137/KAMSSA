{{-- Recipient picker: two tabs (Schools / System Users), each with a
     search box and "select all" toggle. Selections are read out of the
     DOM by the compose form's JS at submit time (see index.blade.php),
     based on which mode radio (none/all/selected) is active for each. --}}
<div class="recipient-picker">
    <ul class="nav nav-pills nb-tabs mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#nb-tab-schools" role="tab">
                <i class="fa fa-school me-1"></i> &nbsp; Schools &nbsp;
                <span class="badge bg-light text-dark ms-1" id="nbSchoolsPickedCount">0</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nb-tab-users" role="tab">
                <i class="fa fa-user-shield me-1"></i> &nbsp; System Users &nbsp;
                <span class="badge bg-light text-dark ms-1" id="nbUsersPickedCount">0</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        {{-- ===================== SCHOOLS TAB ===================== --}}
        <div class="tab-pane fade show active" id="nb-tab-schools" role="tabpanel">

            <div class="nb-mode-row">
                <label class="nb-mode-option">
                    <input type="radio" name="schools_mode" value="none" checked onchange="nbToggleSchoolsMode()">
                    Don't include schools
                </label>
                <label class="nb-mode-option">
                    <input type="radio" name="schools_mode" value="all" onchange="nbToggleSchoolsMode()">
                    All schools <span class="text-muted">({{ $schools->count() }})</span>
                </label>
                <label class="nb-mode-option">
                    <input type="radio" name="schools_mode" value="selected" onchange="nbToggleSchoolsMode()">
                    Choose specific schools
                </label>
            </div>

            <div id="nbSchoolsListWrapper" style="display:none;">
                <div class="d-flex gap-2 mb-2 flex-wrap align-items-center">
                    <input type="text" class="form-control form-control-sm nb-search" style="max-width:280px;"
                        placeholder="Search by school name, code or district..."
                        oninput="nbFilterList('nbSchoolsList', this.value)"> &nbsp; 
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="nbSelectAllVisible('nbSchoolsList', true)">Select visible</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="nbSelectAllVisible('nbSchoolsList', false)">Clear visible</button>
                </div>

                <div class="nb-picker-list" id="nbSchoolsList">
                    @foreach ($schools as $school)
                        <label class="nb-picker-row"
                            data-search="{{ strtolower($school->House . ' ' . $school->Number . ' ' . $school->district) }}">
                            <input type="checkbox" class="nb-school-check" name="schools[]" value="{{ $school->ID }}"
                                onchange="nbUpdatePickedCounts()">
                            <span class="nb-picker-main">
                                <span class="nb-picker-name">{{ $school->House }}</span>
                                <span class="nb-picker-meta">
                                    {{ $school->Number }}
                                    @if ($school->district) &middot; {{ $school->district }} @endif
                                    @if ($school->administrator_names) &middot; {{ $school->administrator_names }} @endif
                                </span>
                            </span>
                        </label>
                    @endforeach

                    @if ($schools->isEmpty())
                        <p class="text-muted small mb-0 p-2">No schools registered yet.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===================== SYSTEM USERS TAB ===================== --}}
        <div class="tab-pane fade" id="nb-tab-users" role="tabpanel">

            <div class="nb-mode-row">
                <label class="nb-mode-option">
                    <input type="radio" name="users_mode" value="none" checked onchange="nbToggleUsersMode()">
                    Don't include system users
                </label>
                <label class="nb-mode-option">
                    <input type="radio" name="users_mode" value="all" onchange="nbToggleUsersMode()">
                    All system users <span class="text-muted">({{ $systemUsers->count() }})</span>
                </label>
                <label class="nb-mode-option">
                    <input type="radio" name="users_mode" value="selected" onchange="nbToggleUsersMode()">
                    Choose specific users
                </label>
            </div>

            <div id="nbUsersListWrapper" style="display:none;">
                <div class="d-flex gap-2 mb-2 flex-wrap align-items-center">
                    <input type="text" class="form-control form-control-sm nb-search" style="max-width:280px;"
                        placeholder="Search by name, username or email..."
                        oninput="nbFilterList('nbUsersList', this.value)">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="nbSelectAllVisible('nbUsersList', true)">Select visible</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="nbSelectAllVisible('nbUsersList', false)">Clear visible</button>
                </div>

                <div class="nb-picker-list" id="nbUsersList">
                    @foreach ($systemUsers as $user)
                        <label class="nb-picker-row"
                            data-search="{{ strtolower($user->firstname . ' ' . $user->lastname . ' ' . $user->username . ' ' . $user->email) }}">
                            <input type="checkbox" class="nb-user-check" name="users[]" value="{{ $user->id }}"
                                onchange="nbUpdatePickedCounts()">
                            <span class="nb-picker-main">
                                <span class="nb-picker-name">{{ $user->firstname }} {{ $user->lastname }}
                                    @if ($user->system_role === 'marks_entrant')
                                        <span class="role-pill marks_entrant">Marks Entrant</span>
                                    @else
                                        <span class="role-pill administrator">Administrator</span>
                                    @endif
                                    @if (!$user->is_active)
                                        <span class="active-pill inactive">Inactive</span>
                                    @endif
                                </span>
                                <span class="nb-picker-meta">{{ $user->username }} &middot; {{ $user->email }}</span>
                            </span>
                        </label>
                    @endforeach

                    @if ($systemUsers->isEmpty())
                        <p class="text-muted small mb-0 p-2">No system users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
