

<?php $__env->startSection('content'); ?>
    <div class="side-app">
        <div class="container-fluid mt-3">

    <style>
    .sr-table-wrap {
        overflow-x: auto;
        max-width: 100%;
    }

    .sr-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .sr-table th,
    .sr-table td {
        padding: 8px 10px;
        border: 1px solid #e8e8e8;
        text-align: center;
        vertical-align: middle;
    }

    .sr-table thead th {
        background: #026837;
        color: white;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .sr-table th.subject-col {
        min-width: 90px;
        max-width: 120px;
        white-space: normal;
    }

    .sr-table th.subject-compulsory {
        background: #038f16;
    }

    .sr-table td.sticky-col,
    .sr-table th.sticky-col {
        position: sticky;
        left: 0;
        background: #fff;
        z-index: 1;
        text-align: left;
    }

    .sr-table thead th.sticky-col {
        background: #025c30;
        z-index: 3;
    }

    .sr-table tbody tr:nth-child(even) td.sticky-col {
        background: #fafafa;
    }

    .subject-check {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .subject-check:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .compulsory-tag {
        font-size: 0.65rem;
        display: block;
        opacity: 0.85;
    }

    .toolbar-actions > * {
        margin-right: 10px;
    }

    .toolbar-actions > *:last-child {
        margin-right: 0;
    }

    /* Search bar — matches bulk import page */
    .sr-search-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .sr-search-box {
        position: relative;
        max-width: 320px;
        width: 100%;
    }

    .sr-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa5a0;
        font-size: 14px;
        pointer-events: none;
        transition: color 0.2s ease;
    }

    .sr-search-input {
        width: 100%;
        padding: 10px 38px 10px 38px;
        border: 1.5px solid #e2e8e5;
        border-radius: 10px;
        font-size: 14px;
        color: #333;
        background: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        outline: none;
    }

    .sr-search-input::placeholder {
        color: #a3aca8;
    }

    .sr-search-input:focus {
        border-color: #026837;
        box-shadow: 0 0 0 3px rgba(2, 104, 55, 0.12);
    }

    .sr-search-input:focus ~ .sr-search-icon {
        color: #026837;
    }

    .sr-search-clear {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: #eef1f0;
        color: #666;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
        padding: 0;
    }

    .sr-search-clear:hover {
        background: #d33;
        color: #fff;
    }

    .sr-search-count {
        font-size: 13px;
        color: #6c7570;
        font-weight: 500;
        white-space: nowrap;
    }

    #srNoResults {
        display: none;
    }

    /* Compulsory subjects are hidden by default; toggled via #srToggleCompulsoryBtn */
    .sr-table.hide-compulsory .compulsory-col {
        display: none;
    }
</style>

<div class="card shadow-lg border-0">
    <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
        style="background-color:#026837;">
        <h4 class="mb-0">
            <i class="fa fa-list-check me-2"></i>
            <?php echo e($category); ?> Subject Registration — <?php echo e($schoolNumber); ?> (<?php echo e($schoolName); ?>) — <?php echo e($year); ?>

        </h4>
        <span class="badge bg-light text-dark">
            <i class="fa fa-users me-1"></i> <?php echo e($students->count()); ?> Students
        </span>
    </div>

                <div class="card-body">

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            <?php if(session('success')): ?>
                                Swal.fire({ icon: 'success', title: 'Success!', text: <?php echo json_encode(session('success'), 15, 512) ?>, confirmButtonColor: '#026837' });
                            <?php endif; ?>

                            <?php if(session('import_skipped') && count(session('import_skipped'))): ?>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Some rows were skipped',
                                    html: `<ul style="text-align:left;"><?php echo collect(session('import_skipped'))->map(fn($m) => '<li>' . e($m) . '</li>')->join(''); ?></ul>`,
                                    confirmButtonColor: '#026837'
                                });
                            <?php endif; ?>

                            <?php if($errors->any()): ?>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Import Error',
                                    html: `<?php echo implode('<br>', $errors->all()); ?>`,
                                    confirmButtonColor: '#d33'
                                });
                            <?php endif; ?>
                        });
                    </script>


<div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4 p-3 bg-light rounded-3 shadow-sm">
    <div class="text-muted small">
        <i class="fa fa-circle" style="color:#026837;font-size:8px;"></i> Compulsory (auto-registered) &nbsp;
        <i class="fa fa-square" style="color:#bd059e;font-size:8px;"></i> Optional (tick what each student sat)
    </div>

    <div class="sr-search-wrap">
        <div class="sr-search-box">
            <i class="fa fa-search sr-search-icon"></i>
            <input type="text" id="srStudentSearchInput" class="sr-search-input"
                placeholder="Search by student name or ID...">
            <button type="button" id="srSearchClear" class="sr-search-clear" style="display:none;" aria-label="Clear search">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <span class="sr-search-count" id="srSearchCount"></span>
    </div>

    <div class="d-flex flex-wrap gap-2 align-items-center toolbar-actions">
        <a class="btn btn-outline-dark btn-sm rounded-pill px-3"
            href="<?php echo e(route('subject.registration.template', ['year' => $year, 'category' => $category, 'school_number' => $schoolNumber])); ?>">
            <i class="fa fa-download me-2"></i> Download Excel Template
        </a>

        <button type="button" class="btn btn-sm text-white rounded-pill px-4 shadow-sm" style="background-color:#026837;"
            data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fa fa-upload me-2"></i> Import Filled Template
        </button>

        <button type="button" id="srToggleCompulsoryBtn" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fa fa-eye me-2"></i> <span id="srToggleCompulsoryLabel">Show Compulsory Subjects</span>
        </button>
    </div>
</div>

                    <?php if($students->count() > 0): ?>
                        <div class="sr-table-wrap">
                            <?php
                                $compulsorySubjects = $subjects->where('md_misc1', 'Compulsory');
                                $optionalSubjects = $subjects->where('md_misc1', '!=', 'Compulsory');
                            ?>
                            <table class="sr-table hide-compulsory" id="srTable">
                                <thead>
                                    <tr>
                                        <th class="sticky-col" style="left:0;">#</th>
                                        <th class="sticky-col" style="text-align:center;">Auto Student ID</th>
                                        <th class="sticky-col" style="text-align:center;">Student Full Name</th>
                                        <?php $__currentLoopData = $compulsorySubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="subject-col subject-compulsory compulsory-col">
                                                <?php echo e($subject->md_name); ?>

                                                <span class="compulsory-tag"><?php echo e($subject->md_misc1); ?></span>
                                            </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($category === 'UACE'): ?>
                                            <th class="subject-col" style="min-width:170px;">
                                                Combination
                                                <span class="compulsory-tag">Optional (principal subjects)</span>
                                            </th>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $optionalSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th class="subject-col">
                                                    <?php echo e($subject->md_name); ?>

                                                    <span class="compulsory-tag"><?php echo e($subject->md_misc1); ?></span>
                                                </th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $studentId = $student->Student_ID;
                                            $registeredIds = $registrations->get($studentId, collect());
                                        ?>
                                        <tr data-search="<?php echo e(strtolower($studentId . ' ' . ($names[$studentId] ?? ''))); ?>">
                                            <td class="sticky-col" style="left:0;"><?php echo e($index + 1); ?></td>
                                            <td class="sticky-col" style="left:40px;"><?php echo e($studentId); ?></td>
                                            <td class="sticky-col" style="left:180px;"><?php echo e($names[$studentId] ?? '—'); ?></td>
                                            <?php $__currentLoopData = $compulsorySubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="compulsory-col">
                                                    <input type="checkbox" class="subject-check"
                                                        data-student="<?php echo e($studentId); ?>"
                                                        data-subject="<?php echo e($subject->md_id); ?>"
                                                        checked disabled>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($category === 'UACE'): ?>
                                                <td>
                                                    <select class="form-control form-select-sm combination-select"
                                                        data-student="<?php echo e($studentId); ?>" style="min-width:150px; white-space:normal;">
                                                        <option value="">— Select —</option>
                                                        <?php $__currentLoopData = $combinationsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $combination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($combination->id); ?>"
                                                                <?php echo e(($studentCombinations[$studentId] ?? null) == $combination->id ? 'selected' : ''); ?>>
                                                                <?php echo e($combination->code); ?> — <?php echo e($combination->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </td>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $optionalSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td>
                                                        <input type="checkbox" class="subject-check"
                                                            data-student="<?php echo e($studentId); ?>"
                                                            data-subject="<?php echo e($subject->md_id); ?>"
                                                            <?php echo e($registeredIds->has($subject->md_id) ? 'checked' : ''); ?>>
                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div id="srNoResults" class="alert alert-warning text-center mt-3">
                                <i class="fa fa-circle-exclamation me-2"></i> No students match your search.
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger text-center">
                            <i class="fa fa-exclamation-triangle me-2"></i> No students found for this school/year/category.
                            Make sure students have been registered first.
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('subject.registration.import')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="category" value="<?php echo e($category); ?>">
                    <input type="hidden" name="school_number" value="<?php echo e($schoolNumber); ?>">

                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title"><i class="fa fa-upload me-2"></i> Import Subject Registrations</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">
                            <?php if($category === 'UACE'): ?>
                                Upload the same Excel file you downloaded. It has one <strong>Combination</strong>
                                column — enter each student's combination code (e.g. <strong>PCM</strong>) from the
                                dropdown list in the sheet. Compulsory subjects like General Paper aren't on the
                                sheet; they're registered automatically for every student.
                            <?php else: ?>
                                Upload the same Excel file you downloaded. It only lists <strong>optional</strong>
                                subjects — mark each one <strong>YES</strong> or <strong>NO</strong> from the
                                dropdown for every student. Compulsory subjects aren't on the sheet at all; they're
                                registered automatically for every student.
                            <?php endif; ?>
                        </p>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#026837;">
                            <i class="fa fa-check me-1"></i> Import
                        </button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $(document).on('change', '.subject-check', function () {
                const checkbox = $(this);
                const checked = checkbox.is(':checked');

                $.ajax({
                    url: '<?php echo e(route('subject.registration.toggle')); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        student_id: checkbox.data('student'),
                        subject_id: checkbox.data('subject'),
                        year: '<?php echo e($year); ?>',
                        category: '<?php echo e($category); ?>',
                        checked: checked ? 1 : 0,
                    },
                    error: function (xhr) {
                        checkbox.prop('checked', !checked); // revert on failure
                        Swal.fire({
                            icon: 'error',
                            title: 'Could not update',
                            text: xhr.responseJSON?.message || 'Please try again.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });

            $(document).on('change', '.combination-select', function () {
                const select = $(this);
                const previousValue = select.data('previous-value') ?? '';
                const newValue = select.val();

                select.prop('disabled', true);

                $.ajax({
                    url: '<?php echo e(route('subject.registration.set.combination')); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        student_id: select.data('student'),
                        combination_id: newValue,
                        year: '<?php echo e($year); ?>',
                        category: '<?php echo e($category); ?>',
                        school_number: '<?php echo e($schoolNumber); ?>',
                    },
                    success: function () {
                        select.data('previous-value', newValue);
                    },
                    error: function (xhr) {
                        select.val(previousValue); // revert on failure
                        Swal.fire({
                            icon: 'error',
                            title: 'Could not update combination',
                            text: xhr.responseJSON?.message || 'Please try again.',
                            confirmButtonColor: '#d33'
                        });
                    },
                    complete: function () {
                        select.prop('disabled', false);
                    }
                });
            });

            $('.combination-select').each(function () {
                $(this).data('previous-value', $(this).val());
            });

            document.querySelector('#importModal form').addEventListener('submit', function () {
                Swal.fire({
                    title: 'Importing…',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => Swal.showLoading()
                });
            });

            // Live search: filter table rows by student name or ID
            $('#srStudentSearchInput').on('keyup', function () {
                const value = $(this).val().toLowerCase().trim();
                let visibleCount = 0;

                $('#srTable tbody tr').each(function () {
                    const haystack = $(this).data('search') || '';
                    const isMatch = String(haystack).indexOf(value) > -1;
                    $(this).toggle(isMatch);
                    if (isMatch) visibleCount++;
                });

                $('#srNoResults').toggle(visibleCount === 0);
            });


            // Live search: filter table rows by student name or ID
const srSearchInput = document.getElementById('srStudentSearchInput');
const srSearchClear = document.getElementById('srSearchClear');
const srSearchCount = document.getElementById('srSearchCount');
const srTotalRows = document.querySelectorAll('#srTable tbody tr').length;

function srUpdateCount(visibleCount, term) {
    if (!srSearchCount) return;
    srSearchCount.textContent = term === '' ? '' : `${visibleCount} of ${srTotalRows} match${srTotalRows === 1 ? '' : 'es'}`;
}

if (srSearchInput) {
    srSearchInput.addEventListener('keyup', function () {
        const value = this.value.toLowerCase().trim();
        let visibleCount = 0;

        document.querySelectorAll('#srTable tbody tr').forEach(function (row) {
            const haystack = row.dataset.search || '';
            const isMatch = haystack.indexOf(value) > -1;
            row.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        document.getElementById('srNoResults').style.display = visibleCount === 0 ? 'block' : 'none';
        srSearchClear.style.display = value === '' ? 'none' : 'flex';
        srUpdateCount(visibleCount, value);
    });
}

if (srSearchClear) {
    srSearchClear.addEventListener('click', function () {
        srSearchInput.value = '';
        srSearchInput.dispatchEvent(new Event('keyup'));
        srSearchInput.focus();
    });
}

// Show/Hide compulsory subject columns (hidden by default)
const srToggleBtn = document.getElementById('srToggleCompulsoryBtn');
if (srToggleBtn) {
    srToggleBtn.addEventListener('click', function () {
        const srTable = document.getElementById('srTable');
        const nowHidden = srTable.classList.toggle('hide-compulsory');
        const label = document.getElementById('srToggleCompulsoryLabel');
        const icon = srToggleBtn.querySelector('i');

        label.textContent = nowHidden ? 'Show Compulsory Subjects' : 'Hide Compulsory Subjects';
        icon.className = nowHidden ? 'fa fa-eye me-2' : 'fa fa-eye-slash me-2';
    });
}
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/itemGrading/subject-registration/manage.blade.php ENDPATH**/ ?>