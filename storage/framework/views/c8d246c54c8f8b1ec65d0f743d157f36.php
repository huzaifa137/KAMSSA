<?php $__env->startSection('content'); ?>
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .sm-tabs {
                    display: flex;
                    gap: 6px;
                    margin-bottom: 1rem;
                    flex-wrap: wrap;
                }

                .sm-tab {
                    border: none;
                    padding: 8px 20px;
                    border-radius: 6px 6px 0 0;
                    font-weight: 600;
                    color: #fff;
                    opacity: 0.6;
                    cursor: pointer;
                }

                .sm-tab.active {
                    opacity: 1;
                }

                .sm-tab.UCE {
                    background-color: #17a2b8;
                }

                .sm-tab.UACE {
                    background-color: #c2185b;
                }

                .sm-table th,
                .sm-table td {
                    padding: 8px 10px;
                    border: 1px solid #e8e8e8;
                    text-align: center;
                    vertical-align: middle;
                }

                .sm-table thead th {
                    background: #026837;
                    color: white;
                }

                .sm-table tbody tr:nth-child(even) {
                    background: #fafafa;
                }

                .sm-table tbody tr.inactive-row {
                    opacity: 0.55;
                }

                .status-pill {
                    padding: 3px 10px;
                    border-radius: 12px;
                    font-size: 0.75rem;
                    font-weight: 600;
                    color: #fff;
                }

                .status-pill.compulsory {
                    background-color: #6a123f;
                }

                .status-pill.optional {
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

                .sm-actions-cell {
    white-space: nowrap;
}

.sm-actions {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.sm-actions .btn {
    flex-shrink: 0;
}

#subjectMaxScoresContainer > div {
    margin-right: 14px;
    margin-bottom: 10px;
}

#subjectMaxScoresContainer > div:last-child {
    margin-right: 0;
}

            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#026837;">
                    <h4 class="mb-0">
                        <i class="fa fa-book me-2"></i> UCE / UACE Subject Management
                    </h4>
                   <a href="<?php echo e(route('subject.registration.index')); ?>" 
   class="btn btn-sm btn-outline-light px-4 py-2 rounded-pill shadow-sm" 
   style="border-color: rgb(255, 255, 255); background: rgb(255, 255, 255); backdrop-filter: blur(4px);">
    <i class="fa fa-list-check me-2"></i> 
    <span class="fw-semibold">Subject Registration</span>
    <i class="fa fa-arrow-right ms-2" style="font-size: 0.75rem;"></i>
</a>
                </div>

                <div class="card-body">

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            <?php if(session('success')): ?>
                                Swal.fire({ icon: 'success', title: 'Success!', text: <?php echo json_encode(session('success'), 15, 512) ?>, confirmButtonColor: '#026837' });
                            <?php endif; ?>

                            <?php if($errors->any()): ?>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please check the form',
                                    html: `<?php echo implode('<br>', $errors->all()); ?>`,
                                    confirmButtonColor: '#d33'
                                });
                            <?php endif; ?>
                        });
                    </script>

                    <p class="text-muted small">
                        This is the master list of subjects for UCE and UACE. Subjects marked
                        <span class="status-pill compulsory">Compulsory</span> are auto-registered for every
                        student. Subjects marked <span class="status-pill optional">Optional</span> only get
                        registered when a student is ticked for them under Subject Registration. Deactivating a
                        subject hides it from new registrations and the Excel template/import, without touching
                        marks or registrations already recorded.
                    </p>

                    
                    <div class="sm-tabs">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="sm-tab <?php echo e($code); ?> <?php echo e($loop->first ? 'active' : ''); ?>"
                                data-target="panel-<?php echo e($code); ?>" onclick="smShowTab('<?php echo e($code); ?>')">
                                <?php echo e($label); ?>

                                <span class="badge bg-light text-dark ms-1"><?php echo e($subjects[$code]->count()); ?></span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div id="panel-<?php echo e($code); ?>" class="sm-panel" style="<?php echo e($loop->first ? '' : 'display:none;'); ?>">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="text-muted small">
                                    <i class="fa fa-circle" style="color:#6a123f;font-size:8px;"></i> Compulsory &nbsp;
                                    <i class="fa fa-circle" style="color:#17a2b8;font-size:8px;"></i> Optional &nbsp;
                                    <i class="fa fa-circle" style="color:#a71d2a;font-size:8px;"></i> Inactive (dimmed)
                                </div>
                                <button type="button" class="btn btn-sm text-white" style="background-color:#026837;"
                                    onclick="smOpenAddModal('<?php echo e($code); ?>')">
                                    <i class="fa fa-plus me-1"></i> Add <?php echo e($label); ?> Subject
                                </button>
                            </div>

                            <?php if($subjects[$code]->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table sm-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Subject Name</th>
                                                <th>Type</th>
                                                <th>Papers</th>
                                                <th>Active?</th>
                                                <th>Registrations</th>
                                                <th>Marks Recorded</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $subjects[$code]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="<?php echo e($subject->is_active ? '' : 'inactive-row'); ?>">
                                                    <td><?php echo e($index + 1); ?></td>
                                                    <td><?php echo e($subject->md_code); ?></td>
                                                    <td class="text-start"><?php echo e($subject->md_name); ?></td>
                                                    <td>
                                                        <span
                                                            class="status-pill <?php echo e($subject->md_misc1 === 'Compulsory' ? 'compulsory' : 'optional'); ?>">
                                                            <?php echo e($subject->md_misc1); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if($subject->total_papers > 1): ?>
                                                            <span class="badge bg-info text-white"><?php echo e($subject->total_papers); ?> papers</span>
                                                            <?php
                                                                $nonDefault = $subject->paper_max_scores->filter(fn($v) => (float) $v !== 100.0);
                                                            ?>
                                                            <?php if($nonDefault->isNotEmpty()): ?>
                                                                <small class="d-block text-muted">
                                                                    <?php $__currentLoopData = $subject->paper_max_scores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paperNum => $max): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        P<?php echo e($paperNum); ?>/<?php echo e(rtrim(rtrim(number_format($max, 2, '.', ''), '0'), '.')); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </small>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">1 paper</span>
                                                            <?php $singleMax = $subject->paper_max_scores[1] ?? 100; ?>
                                                            <?php if((float) $singleMax !== 100.0): ?>
                                                                <small class="d-block text-muted">out of <?php echo e(rtrim(rtrim(number_format($singleMax, 2, '.', ''), '0'), '.')); ?></small>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="active-pill <?php echo e($subject->is_active ? 'active' : 'inactive'); ?>">
                                                            <?php echo e($subject->is_active ? 'Active' : 'Inactive'); ?>

                                                        </span>
                                                    </td>
                                                    <td><?php echo e($subject->registration_count); ?></td>
                                                    <td><?php echo e($subject->mark_count); ?></td>
                                                    <td class="sm-actions-cell">
    <div class="sm-actions">
        <button type="button" class="btn btn-outline-dark btn-sm"
            title="Edit"
            onclick="smOpenEditModal(<?php echo e($subject->md_id); ?>, '<?php echo e($code); ?>', '<?php echo e(addslashes($subject->md_code)); ?>', '<?php echo e(addslashes($subject->md_name)); ?>', '<?php echo e($subject->md_misc1); ?>', <?php echo e($subject->total_papers); ?>, <?php echo e($subject->paper_max_scores->isEmpty() ? '{}' : $subject->paper_max_scores->toJson()); ?>)">
            <i class="fa fa-pen"></i>
        </button>

        <button type="button"
            class="btn btn-sm <?php echo e($subject->is_active ? 'btn-outline-secondary' : 'btn-outline-success'); ?>"
            title="<?php echo e($subject->is_active ? 'Deactivate' : 'Activate'); ?>"
            onclick="smToggleStatus(<?php echo e($subject->md_id); ?>, this)">
            <i class="fa <?php echo e($subject->is_active ? 'fa-eye-slash' : 'fa-eye'); ?>"></i>
        </button>

        <button type="button" class="btn btn-outline-danger btn-sm"
            title="Delete"
            onclick="smDeleteSubject(<?php echo e($subject->md_id); ?>, '<?php echo e(addslashes($subject->md_name)); ?>', <?php echo e($subject->registration_count); ?>, <?php echo e($subject->mark_count); ?>, this)">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning text-center">
                                    <i class="fa fa-info-circle me-2"></i> No <?php echo e($label); ?> subjects yet. Click
                                    "Add <?php echo e($label); ?> Subject" above to create the first one.
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="subjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="subjectForm" action="<?php echo e(route('subject.management.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_method" id="subjectFormMethod" value="POST">
                    <input type="hidden" name="category" id="subjectCategory" value="">

<div class="modal-header text-white" style="background-color:#026837;">
    <h5 class="modal-title" id="subjectModalTitle"><i class="fa fa-plus me-2"></i> Add Subject
    </h5>
    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" id="subjectCategoryDisplay" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject Code</label>
                            <input type="text" name="code" id="subjectCode" class="form-control"
                                placeholder="e.g. MAT, PHY, HIST" maxlength="15" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <input type="text" name="name" id="subjectName" class="form-control"
                                placeholder="e.g. Mathematics" maxlength="150" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="status" id="subjectStatus" class="form-control" required>
                                <option value="Compulsory">Compulsory (auto-registered for every student)</option>
                                <option value="Optional">Optional (student must be ticked for it)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Number of Papers</label>
                            <input type="number" name="total_papers" id="subjectTotalPapers" class="form-control"
                                min="1" max="10" value="1" required onchange="smRenderPaperMaxScores()"
                                onkeyup="smRenderPaperMaxScores()">
                            <small class="text-muted">
                                e.g. Mathematics = 1, but if it has P1 &amp; P2 set this to 2. Fine Art with 5
                                papers → set to 5. Marks entry will show one box per paper, and the final score
                                is the average of all papers.
                            </small>
                        </div>
                        <div class="mb-3" id="subjectMaxScoresWrap">
                            <label class="form-label">Each Paper Is Marked Out Of</label>
                            <div id="subjectMaxScoresContainer" class="d-flex flex-wrap gap-3"></div>
                            <small class="text-muted">
                                Defaults to 100. If a paper isn't marked out of 100 (e.g. Physics P2 out of 40),
                                set its real maximum here — marks entry will convert whatever is entered onto a
                                0-100 scale automatically before averaging.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#026837;">
                            <i class="fa fa-check me-1"></i> Save
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

    <script>
        const smCategoryLabels = <?php echo json_encode($categories, 15, 512) ?>;


        // ── Tab switching ──────────────────────────────────────────────
        function smShowTab(code) {
            document.querySelectorAll('.sm-panel').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.sm-tab').forEach(el => el.classList.remove('active'));
            document.getElementById('panel-' + code).style.display = '';
            document.querySelector('.sm-tab.' + code).classList.add('active');
        }

        // ── Per-paper max score inputs ──────────────────────────────────
        let smCurrentMaxScores = {};

        function smRenderPaperMaxScores() {
            const total = parseInt(document.getElementById('subjectTotalPapers').value, 10) || 1;
            const container = document.getElementById('subjectMaxScoresContainer');
            const wrap = document.getElementById('subjectMaxScoresWrap');

            if (total <= 1) {
                // Single-paper subjects can still be marked out of something
                // other than 100 (e.g. a subject entirely out of 50).
                container.innerHTML = `
                    <div style="min-width:110px;">
                        <input type="number" name="max_scores[1]" class="form-control" min="1" max="1000"
                            value="${smCurrentMaxScores[1] || 100}">
                        <small class="text-danger d-block text-center fw-bold">Out of</small>
                    </div>`;
                return;
            }

            let html = '';
            for (let p = 1; p <= total; p++) {
                html += `
                    <div style="min-width:90px;">
                        <input type="number" name="max_scores[${p}]" class="form-control" min="1" max="1000"
                            value="${smCurrentMaxScores[p] || 100}">
                        <small class="text-muted d-block text-center">P${p} out of</small>
                    </div>`;
            }
            container.innerHTML = html;
        }

        // ── Add modal ──────────────────────────────────────────────────
function smOpenAddModal(category) {
    document.getElementById('subjectModalTitle').innerHTML = '<i class="fa fa-plus me-2"></i> Add ' + smCategoryLabels[category] + ' Subject';
    document.getElementById('subjectForm').action = "<?php echo e(route('subject.management.store')); ?>";
    document.getElementById('subjectFormMethod').value = 'POST';
    document.getElementById('subjectCategory').value = category;
    document.getElementById('subjectCategoryDisplay').value = smCategoryLabels[category];
    document.getElementById('subjectCode').value = '';
    document.getElementById('subjectName').value = '';
    document.getElementById('subjectStatus').value = 'Compulsory';
    document.getElementById('subjectTotalPapers').value = 1;
    smCurrentMaxScores = {};
    smRenderPaperMaxScores();
    $('#subjectModal').modal('show');
}

function smOpenEditModal(id, category, code, name, status, totalPapers, maxScores) {
    document.getElementById('subjectModalTitle').innerHTML = '<i class="fa fa-pen me-2"></i> Edit Subject';
    document.getElementById('subjectForm').action = "<?php echo e(url('subject-management')); ?>/" + id;
    document.getElementById('subjectFormMethod').value = 'PUT';
    document.getElementById('subjectCategory').value = category;
    document.getElementById('subjectCategoryDisplay').value = smCategoryLabels[category] + ' (fixed — create a new subject to move category)';
    document.getElementById('subjectCode').value = code;
    document.getElementById('subjectName').value = name;
    document.getElementById('subjectStatus').value = status;
    document.getElementById('subjectTotalPapers').value = totalPapers || 1;
    smCurrentMaxScores = maxScores || {};
    smRenderPaperMaxScores();
    $('#subjectModal').modal('show');
}

        // ── Toggle active/inactive ───────────────────────────────────
        function smToggleStatus(id, btn) {
            fetch("<?php echo e(url('subject-management')); ?>/" + id + "/toggle-status", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                }
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

        // ── Delete ─────────────────────────────────────────────────────
        function smDeleteSubject(id, name, registrationCount, markCount, btn) {
            if (registrationCount > 0 || markCount > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cannot delete "' + name + '"',
                    html: 'This subject already has <strong>' + registrationCount + '</strong> student registration(s) and <strong>' + markCount + '</strong> mark(s) recorded against it.<br><br>Deactivate it instead to keep historic records intact.',
                    confirmButtonColor: '#026837'
                });
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Delete "' + name + '"?',
                text: 'This cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                confirmButtonColor: '#d33',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (!result.isConfirmed) return;

                fetch("<?php echo e(url('subject-management')); ?>/" + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    }
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/itemGrading/subject-management/index.blade.php ENDPATH**/ ?>