<?php
    use App\Models\StudentBasic;
    use App\Http\Controllers\Helper;

    // Shared between the bureau (ItebController) and the school portal
    // (SchoolsController). $portal is only ever passed by the school side;
    // default to 'bureau' so the existing admin flow is untouched.
    $portal = $portal ?? 'bureau';
    $isSchoolPortal = $portal === 'school';
?>

<?php $__env->startSection('content'); ?>
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .gr-hero {
                    background: linear-gradient(135deg, #0b6b3a 0%, #0f8a4d 100%);
                    border-radius: 14px;
                    color: #fff;
                    padding: 24px 28px;
                    margin-bottom: 22px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    flex-wrap: wrap;
                    gap: 14px;
                }

                .gr-hero h3 {
                    font-weight: 700;
                    margin-bottom: 4px;
                }

                .gr-hero p {
                    opacity: .9;
                    margin-bottom: 0;
                }

                .gr-hero .gr-level-badge {
                    background: rgba(255, 255, 255, .16);
                    border: 1px solid rgba(255, 255, 255, .3);
                    border-radius: 50px;
                    padding: 6px 16px;
                    font-weight: 600;
                    font-size: .85rem;
                }

                .gr-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                }

                .gr-btn {
                    border: none;
                    border-radius: 50px;
                    padding: 0.5rem 1.1rem;
                    font-weight: 600;
                    font-size: .85rem;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    color: #fff;
                    transition: all .15s ease;
                }

                .gr-btn:hover {
                    transform: translateY(-2px);
                    color: #fff;
                }

                .gr-btn-pdf {
                    background: linear-gradient(135deg, #c0392b, #922b21);
                }

                .gr-btn-print {
                    background: linear-gradient(135deg, #1c6fd6, #0d4ea3);
                }

                .gr-btn-csv {
                    background: linear-gradient(135deg, #0f8a4d, #0b6b3a);
                }

                .gr-btn-save {
                    background: linear-gradient(135deg, #e08e0b, #b56d02);
                }

                .gr-btn-back {
                    background: #6c757d;
                }

                .gr-stat {
                    border: 1px solid #e7ebf0;
                    border-radius: 16px;
                    background: #fff;
                    padding: 18px 20px;
                    height: 100%;
                }

                .gr-stat .gr-number {
                    font-size: 1.7rem;
                    font-weight: 700;
                    color: #1e293b;
                    line-height: 1.15;
                }

                .gr-stat .gr-label {
                    font-size: .78rem;
                    text-transform: uppercase;
                    letter-spacing: .04em;
                    color: #6b7785;
                    font-weight: 600;
                    margin-top: 4px;
                }

                .gr-stat.accent-blue {
                    border-top: 3px solid #1c6fd6;
                }

                .gr-stat.accent-green {
                    border-top: 3px solid #0f8a4d;
                }

                .gr-stat.accent-amber {
                    border-top: 3px solid #e08e0b;
                }

                .gr-stat.accent-red {
                    border-top: 3px solid #c0392b;
                }

                .gr-card {
                    border: 1px solid #e7ebf0;
                    border-radius: 16px;
                    background: #fff;
                    overflow: hidden;
                    margin-bottom: 22px;
                }

                .gr-card .gr-card-header {
                    padding: 16px 22px;
                    border-bottom: 1px solid #e7ebf0;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 10px;
                    flex-wrap: wrap;
                }

                .gr-card .gr-card-header h5 {
                    margin: 0;
                    font-weight: 700;
                    color: #1e293b;
                    font-size: 1.02rem;
                }

                .gr-card .gr-card-body {
                    padding: 22px;
                }

                .gr-dist-row {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 7px 0;
                    border-bottom: 1px solid #f1f3f5;
                }

                .gr-dist-row:last-child {
                    border-bottom: none;
                }

                .gr-dist-label {
                    width: 130px;
                    min-width: 130px;
                    font-weight: 600;
                    font-size: .85rem;
                    color: #1e293b;
                }

                .gr-dist-bar-track {
                    flex: 1;
                    height: 8px;
                    background: #f1f3f5;
                    border-radius: 6px;
                    overflow: hidden;
                }

                .gr-dist-bar-fill {
                    height: 100%;
                    background: linear-gradient(90deg, #0f8a4d, #0b6b3a);
                    border-radius: 6px;
                }

                .gr-dist-count {
                    width: 70px;
                    text-align: right;
                    font-size: .8rem;
                    color: #6b7785;
                    white-space: nowrap;
                }

                #resultsTable thead th {
                    background: #287C44;
                    color: white;
                    font-size: .8rem;
                    text-transform: uppercase;
                    letter-spacing: .03em;
                    white-space: nowrap;
                    border-bottom: 2px solid #e7ebf0;
                }

                #resultsTable thead th.sortable {
                    cursor: pointer;
                    user-select: none;
                }

                #resultsTable thead th.sortable i {
                    opacity: .4;
                    margin-left: 4px;
                }

                #resultsTable thead th.sortable.active i {
                    opacity: 1;
                }

                #resultsTable tbody tr:hover {
                    background: #f8fafc;
                }

                .gr-search-wrap {
                    position: relative;
                    max-width: 320px;
                }

                .gr-search-wrap i {
                    position: absolute;
                    left: 12px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #9aa5b1;
                }

                .gr-search-wrap input {
                    padding-left: 34px;
                    border-radius: 50px;
                }

                .gr-empty-row td {
                    text-align: center;
                    padding: 30px;
                    color: #6b7785;
                }
            </style>

            
            <div class="gr-hero">
                <div>
                    <h3><i class="fas fa-star me-2"></i>Grading Results</h3>
                    <p><?php echo e($schoolName); ?> &middot; <?php echo e($category); ?> &middot; <?php echo e($year); ?></p>
                </div>
                <?php if($level): ?>
                    <div class="gr-level-badge">Level <?php echo e($level); ?></div>
                <?php endif; ?>
            </div>

            
            <div class="gr-actions mb-4">
                <button type="button" class="gr-btn gr-btn-pdf" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
                <button type="button" class="gr-btn gr-btn-print" onclick="printResults()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="gr-btn gr-btn-csv" onclick="exportToExcel()">
                    <i class="fas fa-file-csv"></i> Export CSV
                </button>
                <?php if (! ($isSchoolPortal)): ?>
                    <button type="button" class="gr-btn gr-btn-save" onclick="saveResults()">
                        <i class="fas fa-save"></i> Save Results
                    </button>
                <?php endif; ?>
                <a href="<?php echo e($isSchoolPortal ? route('school.dashboard') : route('iteb.grading.summary')); ?>"
                    class="gr-btn gr-btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Filters
                </a>
            </div>

            
            <div class="row g-3 mb-2">
                <div class="col-6 col-md-3">
                    <div class="gr-stat accent-blue">
                        <div class="gr-number"><?php echo e($statistics['count']); ?></div>
                        <div class="gr-label">Total Students</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="gr-stat accent-green">
                        <div class="gr-number"><?php echo e($statistics['average']); ?>%</div>
                        <div class="gr-label">Average</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="gr-stat accent-amber">
                        <div class="gr-number"><?php echo e($statistics['highest']); ?>%</div>
                        <div class="gr-label">Highest Score</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="gr-stat accent-red">
                        <div class="gr-number"><?php echo e($statistics['lowest']); ?>%</div>
                        <div class="gr-label">Lowest Score</div>
                    </div>
                </div>
            </div>

            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="gr-card mb-3 mb-md-0">
                        <div class="gr-card-header">
                            <h5><i class="fas fa-chart-simple me-2 text-success"></i> Grade Distribution</h5>
                        </div>
                        <div class="gr-card-body">
                            <?php $__empty_1 = true; $__currentLoopData = $statistics['grade_distribution']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php $pct = $statistics['count'] > 0 ? round(($count / $statistics['count']) * 100, 1) : 0; ?>
                                <div class="gr-dist-row">
                                    <div class="gr-dist-label"><?php echo e($grade); ?></div>
                                    <div class="gr-dist-bar-track">
                                        <div class="gr-dist-bar-fill" style="width: <?php echo e($pct); ?>%"></div>
                                    </div>
                                    <div class="gr-dist-count"><?php echo e($count); ?> (<?php echo e($pct); ?>%)</div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted mb-0">No grade data.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="gr-card">
                        <div class="gr-card-header">
                            <h5><i class="fas fa-layer-group me-2 text-success"></i> Classification Distribution</h5>
                        </div>
                        <div class="gr-card-body">
                            <?php $__empty_1 = true; $__currentLoopData = array_reverse($statistics['class_distribution'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php $pct = $statistics['count'] > 0 ? round(($count / $statistics['count']) * 100, 1) : 0; ?>
                                <div class="gr-dist-row">
                                    <div class="gr-dist-label"><?php echo e($class); ?></div>
                                    <div class="gr-dist-bar-track">
                                        <div class="gr-dist-bar-fill" style="width: <?php echo e($pct); ?>%"></div>
                                    </div>
                                    <div class="gr-dist-count"><?php echo e($count); ?> (<?php echo e($pct); ?>%)</div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted mb-0">No classification data.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="gr-card mt-4">
                <div class="gr-card-header">
                    <h5><i class="fas fa-table-list me-2 text-success"></i> Student Results</h5>
                    <div class="gr-search-wrap">
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" id="tableSearch" class="form-control form-control-sm"
                            placeholder="Search students…" autocomplete="off">
                    </div>
                </div>
                <div class="gr-card-body">
                    <form id="saveResultsForm" method="POST" action="<?php echo e(route('iteb.save.grading')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="year" value="<?php echo e($year); ?>">
                        <input type="hidden" name="category" value="<?php echo e($category); ?>">
                        <input type="hidden" name="school_number" value="<?php echo e($schoolNumber); ?>">
                        <input type="hidden" name="level" value="<?php echo e($level); ?>">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="resultsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Index Number</th>
                                        <th>Student Name</th>
                                        <th>School</th>
                                        <th>Gender</th>
                                        <th class="sortable" data-sort="percentage">Percentage <i class="fas fa-sort"></i>
                                        </th>
                                        <th class="sortable" data-sort="grade">Grade <i class="fas fa-sort"></i></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studentId => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php $studentSex = StudentBasic::where('Student_ID', $studentId)->value('StudentSex'); ?>
                                        <tr data-percentage="<?php echo e($result['percentage']); ?>" data-grade="<?php echo e($result['grade']); ?>">
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td>
                                                <?php echo e($studentId); ?>

                                                <input type="hidden" name="results[<?php echo e($studentId); ?>][total_marks]"
                                                    value="<?php echo e($result['total_marks']); ?>">
                                                <input type="hidden" name="results[<?php echo e($studentId); ?>][percentage]"
                                                    value="<?php echo e($result['percentage']); ?>">
                                                <input type="hidden" name="results[<?php echo e($studentId); ?>][grade]"
                                                    value="<?php echo e($result['grade']); ?>">
                                                <input type="hidden" name="results[<?php echo e($studentId); ?>][classification]"
                                                    value="<?php echo e($result['classification']); ?>">
                                            </td>
                                            <td><?php echo e(Helper::parseStudentId($studentId, 'student')); ?></td>
                                            <td><?php echo e(Helper::parseStudentId($studentId, 'school')); ?></td>
                                            <td class="text-center">
                                                <?php if(strtolower($studentSex ?? '') == 'male'): ?>
                                                    <span class="badge bg-info text-white">&#9794; Male</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger text-white">&#9792; Female</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge
                                                                    <?php if($result['percentage'] >= 80): ?> bg-success
                                                                    <?php elseif($result['percentage'] >= 70): ?> bg-primary text-white
                                                                    <?php elseif($result['percentage'] >= 60): ?> bg-info
                                                                    <?php elseif($result['percentage'] >= 50): ?> bg-warning
                                                                    <?php else: ?> bg-danger text-white <?php endif; ?>">
                                                    <?php echo e($result['percentage']); ?>%
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?php echo e($result['grade']); ?></strong>
                                                <small class="d-block text-muted"><?php echo e($result['grade_comment']); ?></small>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info view-details"
                                                    data-student-id="<?php echo e($studentId); ?>"
                                                    data-marks-details='<?php echo e(json_encode($result['marks_details'])); ?>'
                                                    data-total-marks="<?php echo e($result['total_marks']); ?>"
                                                    data-total-possible="<?php echo e($result['total_possible']); ?>"
                                                    data-percentage="<?php echo e($result['percentage']); ?>"
                                                    data-grade="<?php echo e($result['grade']); ?>"
                                                    data-grade-comment="<?php echo e($result['grade_comment']); ?>"
                                                    data-classification="<?php echo e($result['classification']); ?>"
                                                    data-classification-comment="<?php echo e($result['classification_comment']); ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr class="gr-empty-row">
                                            <td colspan="8"><i class="fas fa-inbox me-2"></i>No students found for this
                                                selection.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

    </div>
    </div>

    
    <div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="studentDetailsModalLabel">Student Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body" id="modalContent">Loading...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const GR_META = {
            schoolName: <?php echo json_encode($schoolName, 15, 512) ?>,
            category: <?php echo json_encode($category, 15, 512) ?>,
            year: <?php echo json_encode($year, 15, 512) ?>,
            level: <?php echo json_encode($level, 15, 512) ?>,
            schoolNumber: <?php echo json_encode($schoolNumber, 15, 512) ?>,
        };

        const GR_RESULTS = {
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studentId => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo json_encode((string) $studentId, 15, 512) ?>: {
                    total_marks: <?php echo e((int) $result['total_marks']); ?>,
                    total_possible: <?php echo e((int) $result['total_possible']); ?>,
                    percentage: <?php echo e((float) $result['percentage']); ?>,
                    grade: <?php echo json_encode($result['grade'], 15, 512) ?>,
                    grade_comment: <?php echo json_encode($result['grade_comment'], 15, 512) ?>,
                    classification: <?php echo json_encode($result['classification'], 15, 512) ?>,
                    classification_comment: <?php echo json_encode($result['classification_comment'], 15, 512) ?>,
                    marks_details: <?php echo json_encode($result['marks_details'], 15, 512) ?>,
                },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                };

        // -------------------------
        // Live table search
        // -------------------------
        document.getElementById('tableSearch').addEventListener('input', function () {
            const term = this.value.trim().toLowerCase();
            document.querySelectorAll('#resultsTable tbody tr').forEach(row => {
                if (row.classList.contains('gr-empty-row')) return;
                row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
            });
        });

        // -------------------------
        // Click-to-sort (Percentage / Grade columns)
        // -------------------------
        document.querySelectorAll('#resultsTable thead th.sortable').forEach(th => {
            let ascending = false;
            th.addEventListener('click', function () {
                const key = th.dataset.sort;
                const tbody = document.querySelector('#resultsTable tbody');
                const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.classList.contains('gr-empty-row'));

                ascending = !ascending;
                rows.sort((a, b) => {
                    let va = a.dataset[key], vb = b.dataset[key];
                    if (key === 'percentage') { va = parseFloat(va); vb = parseFloat(vb); }
                    if (va < vb) return ascending ? -1 : 1;
                    if (va > vb) return ascending ? 1 : -1;
                    return 0;
                });

                rows.forEach(r => tbody.appendChild(r));

                document.querySelectorAll('#resultsTable thead th.sortable').forEach(h => h.classList.remove('active'));
                th.classList.add('active');
                th.querySelector('i').className = ascending ? 'fas fa-sort-up' : 'fas fa-sort-down';
            });
        });

        // -------------------------
        // Student details modal
        // -------------------------
        document.querySelectorAll('.view-details').forEach(btn => {
            btn.addEventListener('click', function () {
                const studentId = this.dataset.studentId;
                let marksDetails = [];
                try { marksDetails = JSON.parse(this.dataset.marksDetails || '[]'); } catch (e) { marksDetails = []; }

                const totalMarks = this.dataset.totalMarks;
                const totalPossible = this.dataset.totalPossible;
                const percentage = this.dataset.percentage;
                const grade = this.dataset.grade;
                const gradeComment = this.dataset.gradeComment;
                const classification = this.dataset.classification;
                const classificationComment = this.dataset.classificationComment;

                let rowsHtml = '<tr><td colspan="2" class="text-center text-muted">No subject marks available</td></tr>';
                if (marksDetails && marksDetails.length > 0) {
                    rowsHtml = marksDetails.map(m =>
                        `<tr><td>${m.subject_name || 'Unknown Subject'}</td><td>${m.mark ?? 'N/A'}</td></tr>`
                    ).join('');
                }

                document.getElementById('studentDetailsModalLabel').textContent = `Student Details — ${studentId}`;
                document.getElementById('modalContent').innerHTML = `
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr><th style="width:30%" class="text-dark">Total Marks</th><td>${totalMarks} / ${totalPossible}</td></tr>
                                    <tr><th class="text-dark">Percentage</th><td>${percentage}%</td></tr>
                                    <tr><th class="text-dark">Grade</th><td>${grade}</td></tr>
                                    <tr><th class="text-dark">Grade Comment</th><td>${gradeComment || 'N/A'}</td></tr>
                                    <tr><th class="text-dark">Classification</th><td>${classification}</td></tr>
                                    <tr><th class="text-dark">Classification Comment</th><td>${classificationComment || 'N/A'}</td></tr>
                                </table>
                            </div>
                            <h6 class="mt-3">Subject Marks</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light"><tr><th>Subject</th><th>Mark</th></tr></thead>
                                    <tbody>${rowsHtml}</tbody>
                                </table>
                            </div>
                        `;

                $('#studentDetailsModal').modal('show');


            });
        });

        // -------------------------
        // Export: CSV
        // -------------------------
        function exportToExcel() {
            const rows = [['#', 'Index Number', 'Student Name', 'School', 'Gender', 'Percentage', 'Grade']];

            document.querySelectorAll('#resultsTable tbody tr').forEach((row) => {
                if (row.classList.contains('gr-empty-row') || row.style.display === 'none') return;
                const cells = row.querySelectorAll('td');
                if (cells.length < 7) return;
                rows.push([
                    cells[0].textContent.trim(),
                    cells[1].childNodes[0].textContent.trim(),
                    cells[2].textContent.trim(),
                    cells[3].textContent.trim(),
                    cells[4].textContent.trim(),
                    cells[5].textContent.trim(),
                    cells[6].textContent.trim().split('\n')[0].trim(),
                ]);
            });

            const csv = rows.map(r => r.map(cell => {
                const val = String(cell).replace(/\s+/g, ' ').trim();
                return (val.includes(',') || val.includes('"')) ? `"${val.replace(/"/g, '""')}"` : val;
            }).join(',')).join('\n');

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const dateStr = new Date().toISOString().slice(0, 10);
            link.href = URL.createObjectURL(blob);
            link.download = `Grading_Results_${GR_META.schoolName}_${GR_META.category}_${GR_META.year}_${dateStr}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire({ icon: 'success', title: 'Export Successful!', text: 'Your CSV file has been downloaded.', timer: 2000, showConfirmButton: false });
        }

        // -------------------------
        // Export: PDF (server-rendered)
        // -------------------------
        function exportToPDF() {
            Swal.fire({
                title: 'Generating PDF...',
                text: 'Please wait while we prepare your document.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo e(route("iteb.grading.results.pdf")); ?>';
            form.target = '_blank';

            const fields = {
                _token: '<?php echo e(csrf_token()); ?>',
                year: GR_META.year,
                category: GR_META.category,
                school_number: GR_META.schoolNumber,
                level: GR_META.level,
                school_name: GR_META.schoolName,
                results_data: JSON.stringify(GR_RESULTS),
            };

            Object.entries(fields).forEach(([name, value]) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            setTimeout(() => {
                Swal.close();
                Swal.fire({ icon: 'success', title: 'PDF Generated!', text: 'Your PDF has been downloaded.', timer: 2000, showConfirmButton: false });
            }, 2000);
        }

        // -------------------------
        // Print
        // -------------------------
        function printResults() {
            const printWindow = window.open('', '_blank');
            const table = document.getElementById('resultsTable');
            const clonedTable = table.cloneNode(true);

            const headerRow = clonedTable.querySelector('thead tr');
            if (headerRow) headerRow.removeChild(headerRow.lastElementChild);
            clonedTable.querySelectorAll('tbody tr').forEach(row => {
                if (row.lastElementChild) row.removeChild(row.lastElementChild);
            });

            printWindow.document.write(`
                        <html>
                        <head>
                            <title>Grading Results - ${GR_META.schoolName} - ${GR_META.category} - ${GR_META.year}</title>
                            <style>
                                body { font-family: Arial, sans-serif; padding: 20px; color: #1e293b; }
                                .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #287C44; }
                                .header h2 { color: #287C44; margin-bottom: 10px; }
                                .header p { color: #64748b; margin: 5px 0; }
                                table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
                                th { background: #287C44; color: white; padding: 12px 8px; text-align: left; font-weight: 600; }
                                td { padding: 10px 8px; border-bottom: 1px solid #e2e8f0; }
                                tr:nth-child(even) { background: #f8fafc; }
                                .footer { margin-top: 30px; text-align: center; color: #64748b; font-size: 12px; }
                            </style>
                        </head>
                        <body>
                            <div class="header">
                                <h2>Grading Results</h2>
                                <p><strong>School:</strong> ${GR_META.schoolName} | <strong>Category:</strong> ${GR_META.category} | <strong>Year:</strong> ${GR_META.year} | <strong>Level:</strong> ${GR_META.level || 'N/A'}</p>
                                <p><strong>Generated on:</strong> ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}</p>
                            </div>
                            ${clonedTable.outerHTML}
                            <div class="footer"><p>This is a computer-generated document. No signature is required.</p></div>
                            <script>
                                window.onload = function () {
                                    window.print();
                                    window.onafterprint = function () { window.close(); };
                                };
                            <\/script>
                        </body>
                        </html>
                    `);
            printWindow.document.close();
        }

        // -------------------------
        // Save results (bureau only — not rendered on the school portal)
        // -------------------------
        window.saveResults = function () {
            if (!confirm('Are you sure you want to save these grading results?')) return;

            const form = document.getElementById('saveResultsForm');
            const formData = new FormData(form);

            fetch('<?php echo e(route('iteb.save.grading')); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Saved!', text: data.message, confirmButtonText: 'OK' })
                            .then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error!', text: data.message });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'An error occurred while saving results.' });
                });
        };
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/itemGrading/grading-results.blade.php ENDPATH**/ ?>