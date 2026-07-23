

<?php $__env->startSection('content'); ?>
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .sbi-table th,
                .sbi-table td {
                    padding: 8px 10px;
                    border: 1px solid #e8e8e8;
                    text-align: center;
                    vertical-align: middle;
                }

                .sbi-table thead th {
                    background: #026837;
                    color: white;
                }

                .sbi-table tbody tr:nth-child(even) {
                    background: #fafafa;
                }

                .modal-header .close {
                    color: #fff;
                    font-size: 1.8rem;
                    font-weight: 300;
                    opacity: 0.9;
                    text-shadow: none;
                    transition: all 0.2s ease;
                }

                .modal-header .close:hover {
                    color: #fff;
                    opacity: 1;
                    transform: scale(1.15);
                }

                .toolbar-actions>* {
                    margin-right: 10px;
                }

                .toolbar-actions>*:last-child {
                    margin-right: 0;
                }

                .sbi-search-wrap {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    flex-wrap: wrap;
                }

                .sbi-search-box {
                    position: relative;
                    max-width: 320px;
                    width: 100%;
                }

                .sbi-search-icon {
                    position: absolute;
                    left: 14px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #9aa5a0;
                    font-size: 14px;
                    pointer-events: none;
                    transition: color 0.2s ease;
                }

                .sbi-search-input {
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

                .sbi-search-input::placeholder {
                    color: #a3aca8;
                }

                .sbi-search-input:focus {
                    border-color: #026837;
                    box-shadow: 0 0 0 3px rgba(2, 104, 55, 0.12);
                }

                .sbi-search-input:focus~.sbi-search-icon {
                    color: #026837;
                }

                .sbi-search-clear {
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

                .sbi-search-clear:hover {
                    background: #d33;
                    color: #fff;
                }

                .sbi-search-count {
                    font-size: 13px;
                    color: #6c7570;
                    font-weight: 500;
                }

                .sbi-search-input {
    width: 100%;
    padding: 10px 38px 10px 38px;
    border: 1.5px solid #026837;
    border-radius: 10px;
    font-size: 14px;
    color: #333;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(2, 104, 55, 0.12);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    outline: none;
}

.sbi-search-input::placeholder {
    color: #a3aca8;
}

.sbi-search-input:focus {
    border-color: #026837;
    box-shadow: 0 0 0 4px rgba(2, 104, 55, 0.18);
}

.sbi-search-input:focus~.sbi-search-icon {
    color: #026837;
}
            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#026837;">
                    <h4 class="mb-0">
                        <i class="fa fa-users me-2"></i>
                        <?php echo e($category); ?> Student Import — <?php echo e($schoolNumber); ?> (<?php echo e($schoolName); ?>) — <?php echo e($year); ?>

                    </h4>
                    <span class="badge bg-light text-dark">
                        <i class="fa fa-user-graduate me-1"></i> <?php echo e($studentRows->count()); ?> Students
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

                    
                    <div
                        class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4 p-3 bg-light rounded-3 shadow-sm">
                        
                        <a href="<?php echo e(route('student.bulk.import.index')); ?>"
                            class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                            <i class="fa fa-arrow-left me-2"></i> Change Year/Category/School
                        </a>

                        
                        <div class="d-flex flex-wrap gap-2 align-items-center toolbar-actions">
                            <a class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                href="<?php echo e(route('student.bulk.import.template', ['year' => $year, 'category' => $category, 'school_number' => $schoolNumber])); ?>">
                                <i class="fa fa-download me-2"></i> Download Template
                            </a>

                            <button type="button" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm"
                                data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fa fa-upload me-2"></i> Import Students
                            </button>

                            <?php if($studentRows->count() > 0): ?>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" id="clearAllBtn">
                                    <i class="fa fa-trash me-2"></i> Clear All
                                </button>
                            <?php endif; ?>

                            <?php if(in_array($category, ['UCE', 'UACE']) && $studentRows->count() > 0): ?>
                                <a class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm"
                                    style="background-color:#6a123f; border-color:#6a123f;"
                                    href="<?php echo e(route('subject.registration.manage', ['year' => $year, 'category' => $category, 'school_number' => $schoolNumber])); ?>">
                                    <i class="fa fa-list-check me-2"></i> Proceed to Subject Registration
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($studentRows->count() > 0): ?>
                        
                        <div class="sbi-search-wrap mb-3">
                            <div class="sbi-search-box">
                                <i class="fa fa-search sbi-search-icon"></i>
                                <input type="text" id="sbiSearch" class="sbi-search-input"
                                    placeholder="Search by name or Student ID...">
                                <button type="button" id="sbiSearchClear" class="sbi-search-clear" style="display:none;"
                                    aria-label="Clear search">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <span class="sbi-search-count" id="sbiSearchCount"></span>
                        </div>

                        <div class="table-responsive">
                            <table class="table sbi-table" id="sbiTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Auto Student ID</th>
                                        <th>Full Name</th>
                                        <th>Sex</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $studentRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td><?php echo e($student->Student_ID); ?></td>
                                            <td><?php echo e($student->Student_Name); ?></td>
                                            <td><?php echo e($student->StudentSex ?? '—'); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm sbi-edit-btn"
                                                    title="Edit this student's name and sex"
                                                    data-student-id="<?php echo e($student->Student_ID); ?>"
                                                    data-student-name="<?php echo e($student->Student_Name); ?>"
                                                    data-student-sex="<?php echo e($student->StudentSex); ?>">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                                <form method="POST"
                                                    action="<?php echo e(route('student.bulk.import.destroy.student', ['studentId' => $student->Student_ID])); ?>"
                                                    class="d-inline sbi-delete-form" data-student-id="<?php echo e($student->Student_ID); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                                                    <input type="hidden" name="category" value="<?php echo e($category); ?>">
                                                    <input type="hidden" name="school_id" value="<?php echo e($schoolId); ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        title="Delete this student and all of their records">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <i class="fa fa-info-circle me-2"></i> No students imported yet for this school/year/category.
                            Download the template, fill it in, and import it below.
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    
    <form method="POST" action="<?php echo e(route('student.bulk.import.destroy.all')); ?>" id="clearAllForm" class="d-none">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <input type="hidden" name="year" value="<?php echo e($year); ?>">
        <input type="hidden" name="category" value="<?php echo e($category); ?>">
        <input type="hidden" name="school_id" value="<?php echo e($schoolId); ?>">
    </form>

    
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('student.bulk.import.import')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="category" value="<?php echo e($category); ?>">
                    <input type="hidden" name="school_id" value="<?php echo e($schoolId); ?>">

                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title"><i class="fa fa-upload me-2"></i> Import Students</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">
                            Upload the filled-in Excel template. Student Name and Sex are required for each row;
                            everything else is optional. Student_ID is generated automatically, continuing from
                            the last number used for <?php echo e($schoolNumber); ?>-<?php echo e($category); ?>-*-<?php echo e($year); ?>.
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

    
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="editStudentForm" action="">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="category" value="<?php echo e($category); ?>">
                    <input type="hidden" name="school_id" value="<?php echo e($schoolId); ?>">

                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title"><i class="fa fa-pen me-2"></i> Edit Student — <span
                                id="editStudentIdLabel"></span></h5>
                        <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editStudentName" class="form-label">Student Full Name</label>
                            <input type="text" id="editStudentName" name="student_name" class="form-control" required
                                maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="editStudentSex" class="form-label">Sex</label>
                            <select id="editStudentSex" name="student_sex" class="form-control" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#026837;">
                            <i class="fa fa-check me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector('#importModal form').addEventListener('submit', function () {
            Swal.fire({
                title: 'Importing…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
        });

        // Populate and open the Edit modal with the clicked row's data.
        // Populate and open the Edit modal with the clicked row's data.
        document.querySelectorAll('.sbi-edit-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const studentId = btn.dataset.studentId;
                const form = document.getElementById('editStudentForm');
                form.action = '<?php echo e(url('/student-bulk-import/student')); ?>/' + encodeURIComponent(studentId);
                document.getElementById('editStudentIdLabel').textContent = studentId;
                document.getElementById('editStudentName').value = btn.dataset.studentName || '';
                document.getElementById('editStudentSex').value = btn.dataset.studentSex || 'Male';

                $('#editStudentModal').modal('show');
            });
        });


        // Show a spinner while the Edit Student form submits.
        document.getElementById('editStudentForm').addEventListener('submit', function () {
            Swal.fire({
                title: 'Saving changes…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
        });

        // Confirm before deleting a single student (this also removes their
        // subject registrations, marks, and results).
        document.querySelectorAll('.sbi-delete-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const studentId = form.dataset.studentId || 'this student';
                Swal.fire({
                    icon: 'warning',
                    title: 'Delete this student?',
                    html: `This will permanently remove <strong>${studentId}</strong> and all of their subject registrations, marks, and results. This cannot be undone.`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Confirm before wiping every student for this year/category/school.
        const clearAllBtn = document.getElementById('clearAllBtn');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Clear ALL students?',
                    html: `This will permanently delete <strong>every</strong> student imported for <?php echo e($category); ?> — <?php echo e($schoolNumber); ?> — <?php echo e($year); ?>, along with their subject registrations, marks, and results.<br><br>Use this if a template was imported twice or the wrong file was uploaded. This cannot be undone.`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, clear everything',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('clearAllForm').submit();
                    }
                });
            });
        }

        // Live search: filters visible rows by Student_ID or Name.
        const sbiSearch = document.getElementById('sbiSearch');
        if (sbiSearch) {
            sbiSearch.addEventListener('input', function () {
                const term = this.value.trim().toLowerCase();
                document.querySelectorAll('#sbiTable tbody tr').forEach(function (row) {
                    const studentId = row.children[1]?.textContent.toLowerCase() || '';
                    const name = row.children[2]?.textContent.toLowerCase() || '';
                    row.style.display = (studentId.includes(term) || name.includes(term)) ? '' : 'none';
                });
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/itemGrading/student-bulk-import/manage.blade.php ENDPATH**/ ?>