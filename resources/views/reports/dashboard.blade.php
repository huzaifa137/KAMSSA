@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .rpt-hero {
                    background: linear-gradient(135deg, #0b6b3a 0%, #0f8a4d 100%);
                    border-radius: 14px;
                    color: #fff;
                    padding: 28px 30px;
                    margin-bottom: 26px;
                }

                .rpt-hero h3 {
                    font-weight: 700;
                    margin-bottom: 4px;
                }

                .rpt-hero p {
                    opacity: .9;
                    margin-bottom: 0;
                }

                .rpt-card {
                    border: 1px solid #e7ebf0;
                    border-radius: 16px;
                    padding: 26px 24px;
                    height: 100%;
                    background: #fff;
                    transition: all .18s ease;
                    cursor: pointer;
                    position: relative;
                    overflow: hidden;
                }

                .rpt-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 14px 30px rgba(15, 138, 77, .14);
                    border-color: #0f8a4d;
                }

                .rpt-card .rpt-icon {
                    width: 54px;
                    height: 54px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                    margin-bottom: 18px;
                    color: #fff;
                }

                .rpt-card .rpt-icon.bg-passlip {
                    background: linear-gradient(135deg, #0f8a4d, #0b6b3a);
                }

                .rpt-card .rpt-icon.bg-subjectslip {
                    background: linear-gradient(135deg, #1c6fd6, #0d4ea3);
                }

                .rpt-card .rpt-icon.bg-analysed {
                    background: linear-gradient(135deg, #c0392b, #922b21);
                }

                .rpt-card h5 {
                    font-weight: 700;
                    margin-bottom: 8px;
                }

                .rpt-card p.desc {
                    color: #6b7785;
                    font-size: .92rem;
                    margin-bottom: 14px;
                }

                .rpt-card .rpt-tag {
                    display: inline-block;
                    font-size: .72rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: .04em;
                    padding: 3px 10px;
                    border-radius: 20px;
                    background: #f0f4f2;
                    color: #0b6b3a;
                }

                .rpt-card .generate-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 20px;
                    background: linear-gradient(135deg, #0f8a4d, #0b6b3a);
                    color: #fff;
                    border: none;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 0.85rem;
                    transition: all 0.3s ease;
                    text-decoration: none;
                    position: relative;
                    overflow: hidden;
                    box-shadow: 0 4px 15px rgba(15, 138, 77, 0.3);
                }

                .rpt-card .generate-btn::before {
                    content: '';
                    position: absolute;
                    top: -2px;
                    left: -2px;
                    right: -2px;
                    bottom: -2px;
                    background: linear-gradient(135deg, #0f8a4d, #ffd700, #0f8a4d);
                    background-size: 300% 300%;
                    border-radius: 50px;
                    z-index: -1;
                    animation: glowMove 3s ease infinite;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }

                .rpt-card .generate-btn:hover::before {
                    opacity: 1;
                }

                .rpt-card .generate-btn:hover {
                    transform: translateY(-2px) scale(1.02);
                    box-shadow: 0 8px 30px rgba(15, 138, 77, 0.4);
                }

                .rpt-card .generate-btn i {
                    transition: transform 0.3s ease;
                }

                .rpt-card .generate-btn:hover i {
                    transform: translateX(5px) rotate(-5deg);
                }

                @keyframes glowMove {
                    0% {
                        background-position: 0% 50%;
                    }

                    50% {
                        background-position: 100% 50%;
                    }

                    100% {
                        background-position: 0% 50%;
                    }
                }

                @keyframes glowMoveRed {
                    0% {
                        background-position: 0% 50%;
                    }

                    50% {
                        background-position: 100% 50%;
                    }

                    100% {
                        background-position: 0% 50%;
                    }
                }
            </style>

            <div class="rpt-hero">
                <h3><i class="fa fa-file-alt me-2"></i> Reports &amp; Passlips</h3>
                <p>Generate mock passlips, subject slips and analysed reports — student-wise or school-wise, ready to print.
                </p>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="rpt-card" onclick="openReportModal('passlip')">
                        <span class="rpt-tag mb-3">Student-wise</span>
                        <div class="rpt-icon bg-passlip"><i class="fa fa-id-card"></i></div>
                        <h5>Mock Passlip</h5>
                        <p class="desc">Individual student result slip — subject &amp; grade breakdown, 3 slips per printed
                            A4 page.</p>
                        <button class="generate-btn" onclick="openReportModal('passlip')">
                            <i class="fa fa-print"></i> Generate Now
                        </button>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="rpt-card" onclick="openReportModal('subjectslip')">
                        <span class="rpt-tag mb-3">School-wise</span>
                        <div class="rpt-icon bg-subjectslip"><i class="fa fa-chart-bar"></i></div>
                        <h5>Mock Subjectslip</h5>
                        <p class="desc">Per-subject grade distribution and pass rate across the whole school.</p>
                        <button class="generate-btn" style="
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 8px 20px;
                        background: linear-gradient(135deg, #1c6fd6, #0d4ea3);
                        color: #fff;
                        border: none;
                        border-radius: 50px;
                        font-weight: 600;
                        font-size: 0.85rem;
                        transition: all 0.3s ease;
                        text-decoration: none;
                        position: relative;
                        overflow: hidden;
                        box-shadow: 0 4px 15px rgba(28, 111, 214, 0.3);
                        cursor: pointer;
                        z-index: 1;
                    " onmouseenter="this.style.transform='translateY(-2px) scale(1.02)'; this.style.boxShadow='0 8px 30px rgba(28, 111, 214, 0.4)'; this.querySelector('.btn-glow-blue').style.opacity='1';"
                            onmouseleave="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(28, 111, 214, 0.3)'; this.querySelector('.btn-glow-blue').style.opacity='0';"
                            onclick="event.stopPropagation(); openReportModal('subjectslip')">
                            <span class="btn-glow-blue" style="
                            position: absolute;
                            top: -2px;
                            left: -2px;
                            right: -2px;
                            bottom: -2px;
                            background: linear-gradient(135deg, #1c6fd6, #ffd700, #1c6fd6);
                            background-size: 300% 300%;
                            border-radius: 50px;
                            z-index: -1;
                            animation: glowMoveBlue 3s ease infinite;
                            opacity: 0;
                            transition: opacity 0.3s ease;
                        "></span>
                            <i class="fa fa-print"
                                style="transition: transform 0.3s ease; position: relative; z-index: 2;"></i>
                            <span style="position: relative; z-index: 2;">Generate Now</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="rpt-card" onclick="openReportModal('analysed')">
                        <span class="rpt-tag mb-3">School-wise</span>
                        <div class="rpt-icon bg-analysed"><i class="fa fa-table"></i></div>
                        <h5>Mock Analysed Report</h5>
                        <p class="desc">One grid — every student against every subject grade, for the whole school.</p>
                        <button class="generate-btn" style="
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 20px;
                    background: linear-gradient(135deg, #c0392b, #922b21);
                    color: #fff;
                    border: none;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 0.85rem;
                    transition: all 0.3s ease;
                    text-decoration: none;
                    position: relative;
                    overflow: hidden;
                    box-shadow: 0 4px 15px rgba(192, 57, 43, 0.3);
                    cursor: pointer;
                    z-index: 1;
                " onmouseenter="this.style.transform='translateY(-2px) scale(1.02)'; this.style.boxShadow='0 8px 30px rgba(192, 57, 43, 0.4)'; this.querySelector('.btn-glow-red').style.opacity='1';"
                            onmouseleave="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(192, 57, 43, 0.3)'; this.querySelector('.btn-glow-red').style.opacity='0';"
                            onclick="event.stopPropagation(); openReportModal('analysed')">
                            <span class="btn-glow-red" style="
                        position: absolute;
                        top: -2px;
                        left: -2px;
                        right: -2px;
                        bottom: -2px;
                        background: linear-gradient(135deg, #c0392b, #ffd700, #c0392b);
                        background-size: 300% 300%;
                        border-radius: 50px;
                        z-index: -1;
                        animation: glowMoveRed 3s ease infinite;
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    "></span>
                            <i class="fa fa-print"
                                style="transition: transform 0.3s ease; position: relative; z-index: 2;"></i>
                            <span style="position: relative; z-index: 2;">Generate Now</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Filter modal shared by all 3 cards --}}
    <div class="modal fade" id="reportFilterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="reportFilterForm" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportFilterTitle">Generate Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>


                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category" id="reportCategory" class="form-control" required>
                                <option value="UCE">UCE (O-Level)</option>
                                <option value="UACE">UACE (A-Level)</option>
                                <!-- <option value="PLE">PLE</option> -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Year</label>
                            <select name="year" id="reportYear" class="form-control" required>
                                @foreach($years as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($portal === 'bureau')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">School</label>
                                <select name="school_number" id="reportSchool" class="form-control" required>
                                    <option value="">-- Select School --</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->Number }}">{{ $school->House }} ({{ $school->Number }})</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="school_number" value="{{ $lockedSchoolNumber }}">
                            <p class="text-muted small mb-3">
                                <i class="fa fa-lock me-1"></i> Reports are generated for your school only.
                            </p>
                        @endif

                        <div class="mb-1" id="studentIdWrap" style="display:none">
                            <label class="form-label fw-semibold">Student <span class="text-muted fw-normal">(optional —
                                    leave blank for the whole school)</span></label>
                            <div class="position-relative">
                                <input type="text" id="studentSearchInput" class="form-control" autocomplete="off"
                                    placeholder="Type a name or ID to search…">
                                <input type="hidden" name="student_id" id="studentIdSelect" value="">
                                <div id="studentSearchResults" class="list-group shadow-sm" style="
                                    display:none; position:absolute; z-index:1060; width:100%;
                                    max-height:220px; overflow-y:auto; margin-top:2px;">
                                </div>
                            </div>
                            <small class="text-muted d-block mt-1" id="studentIdHint">Select Category, Year and School to load
                                students.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#03871D;"><i
                                class="fa fa-print me-1"></i> Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        const REPORT_ROUTES = {
            passlip: "{{ $portal === 'bureau' ? route('reports.mock.passlip') : route('school.reports.mock.passlip') }}",
            subjectslip: "{{ $portal === 'bureau' ? route('reports.mock.subjectslip') : route('school.reports.mock.subjectslip') }}",
            analysed: "{{ $portal === 'bureau' ? route('reports.mock.analysed') : route('school.reports.mock.analysed') }}",
        };
        const REPORT_TITLES = {
            passlip: 'Generate Mock Passlip',
            subjectslip: 'Generate Mock Subjectslip',
            analysed: 'Generate Mock Analysed Report',
        };
        const STUDENTS_FOR_SCHOOL_URL = "{{ $portal === 'bureau' ? route('reports.students.for.school') : route('school.reports.students.for.school') }}";
        const PORTAL = @json($portal);
        const LOCKED_SCHOOL_NUMBER = @json($lockedSchoolNumber);

        let currentReportType = null;
        let allStudents = [];         // [{id, name}] for the currently selected category/year/school
        let studentsFetchToken = 0;   // guards against a stale response overwriting a newer one

        function openReportModal(type) {
            currentReportType = type;
            document.getElementById('reportFilterForm').action = REPORT_ROUTES[type];
            document.getElementById('reportFilterTitle').innerText = REPORT_TITLES[type];
            document.getElementById('studentIdWrap').style.display = (type === 'passlip') ? 'block' : 'none';

            resetStudentPicker('Select Category, Year and School to load students.');

            if (type === 'passlip') {
                maybeLoadStudents();
            }

            new bootstrap.Modal(document.getElementById('reportFilterModal')).show();
        }

        function getSelectedSchoolNumber() {
            if (PORTAL === 'bureau') {
                const el = document.getElementById('reportSchool');
                return el ? el.value : '';
            }
            return LOCKED_SCHOOL_NUMBER || '';
        }

        function setStudentHint(text) {
            document.getElementById('studentIdHint').textContent = text;
        }

        function resetStudentPicker(hintText) {
            document.getElementById('studentSearchInput').value = '';
            document.getElementById('studentIdSelect').value = '';
            hideStudentResults();
            allStudents = [];
            setStudentHint(hintText);
        }

        function hideStudentResults() {
            const box = document.getElementById('studentSearchResults');
            box.style.display = 'none';
            box.innerHTML = '';
        }

        function maybeLoadStudents() {
            if (currentReportType !== 'passlip') return;

            const category = document.getElementById('reportCategory').value;
            const year = document.getElementById('reportYear').value;
            const schoolNumber = getSelectedSchoolNumber();

            if (!category || !year || !schoolNumber) {
                resetStudentPicker('Select Category, Year and School to load students.');
                return;
            }

            setStudentHint('Loading students…');
            const token = ++studentsFetchToken;

            const url = new URL(STUDENTS_FOR_SCHOOL_URL, window.location.origin);
            url.searchParams.set('category', category);
            url.searchParams.set('year', year);
            url.searchParams.set('school_number', schoolNumber);

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to load students');
                    return response.json();
                })
                .then(students => {
                    if (token !== studentsFetchToken) return; // a newer request superseded this one
                    allStudents = Array.isArray(students) ? students : [];
                    setStudentHint(allStudents.length
                        ? `${allStudents.length} students loaded — type to search, or leave blank for the whole school.`
                        : 'No students found for this school/category/year.');
                })
                .catch(() => {
                    if (token !== studentsFetchToken) return;
                    allStudents = [];
                    setStudentHint('Could not load students — you can still generate the whole-school report.');
                });
        }

        function renderStudentResults(matches) {
            const box = document.getElementById('studentSearchResults');
            box.innerHTML = '';

            if (matches.length === 0) {
                box.style.display = 'none';
                return;
            }

            matches.slice(0, 50).forEach(s => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'list-group-item list-group-item-action';
                item.textContent = `${s.name} (${s.id})`;
                // mousedown fires before the input's blur event, so the click
                // registers before the results box gets hidden.
                item.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    document.getElementById('studentIdSelect').value = s.id;
                    document.getElementById('studentSearchInput').value = `${s.name} (${s.id})`;
                    hideStudentResults();
                });
                box.appendChild(item);
            });

            box.style.display = 'block';
        }

        document.getElementById('studentSearchInput').addEventListener('input', function () {
            const term = this.value.trim().toLowerCase();

            // Typing again after a selection means they want a different
            // student — clear the previously committed value.
            document.getElementById('studentIdSelect').value = '';

            if (term === '') {
                hideStudentResults();
                return;
            }

            const matches = allStudents.filter(s =>
                s.id.toLowerCase().includes(term) || s.name.toLowerCase().includes(term)
            );
            renderStudentResults(matches);
        });

        document.getElementById('studentSearchInput').addEventListener('focus', function () {
            if (this.value.trim() !== '' && allStudents.length) {
                this.dispatchEvent(new Event('input'));
            }
        });

        document.getElementById('studentSearchInput').addEventListener('blur', hideStudentResults);

        document.getElementById('reportCategory').addEventListener('change', maybeLoadStudents);
        document.getElementById('reportYear').addEventListener('change', maybeLoadStudents);
        @if($portal === 'bureau')
            document.getElementById('reportSchool').addEventListener('change', maybeLoadStudents);
        @endif
    </script>

@endsection