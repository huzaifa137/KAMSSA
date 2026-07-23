<?php $__env->startSection('content'); ?>
    <div class="side-app">

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        <?php echo $__env->make('layouts.iteb-grading-buttons', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-white" style="background-color:#06ad06;">
                        <h4 class="mb-0"><i class="fa fa-tasks me-2"></i> Subject Registration (Optional Subjects)</h4>
                    </div>

                    <div class="card-body bg-light">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-1"></i>
                            UCE and UACE students each sit their own combination of optional subjects.
                            Use this page to register — per student, per year — which subjects they actually did,
                            either by ticking them in the grid or by importing a filled-in Excel sheet.
                            This must be done <strong>before</strong> entering marks so that the marks-entry
                            screen only asks for the subjects each student is registered for.
                        </div>

                        <form id="selectForm" method="GET" action="<?php echo e(route('subject.registration.manage')); ?>">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label><strong>Select Year</strong></label>
                                <select name="year" class="form-control select2" required>
                                    <option value="">-- Select Year --</option>
                                    <?php for($year = 2025; $year <= 2030; $year++): ?>
                                        <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                    
                            <div class="col-md-3 mb-3">
                                <label><strong>Select Category</strong></label>
                                <select name="category" class="form-control select2" required>
                                    <option value="">-- Select Category --</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($code); ?>"><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                    
                            <!-- ✅ Wrapped the school select in the same grid class -->
                            <div class="col-md-6 mb-3">
                                <label><strong>Select School</strong></label>
                                <select name="school_number" class="form-control select2" required>
                                    <option value="">-- Select School --</option>
                                    <?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($house->Number); ?>"><?php echo e($house->House); ?> (<?php echo e($house->Number); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    
                        <div class="text-center mt-3">
                            <button type="submit" class="btn text-white px-5" style="background-color:#069912;">
                                <i class="fa fa-list-check me-2"></i> Open Registration Grid
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('selectForm').addEventListener('submit', function () {
            Swal.fire({
                title: 'Loading…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/itemGrading/subject-registration/select.blade.php ENDPATH**/ ?>