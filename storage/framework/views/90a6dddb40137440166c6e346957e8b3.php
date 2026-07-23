
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-p1B9XJvxXlJ0sFh1ExAmH4y3L1kGk+x+r6Gx7q6v5+PgfKhnYzOZ3xGlKEX2eVZCMu1k7r1R7pLLj5p2lP2vXw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php $__env->startSection('content'); ?>
    <div class="side-app">

        <?php 
                    $user = DB::table('users')->where('id', Session('LoggedAdmin'))->first();
            ?>

        <?php if($user->system_role != "marks_entrant"): ?>
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card bg-primary">
                        <div class="card-header">
                            <?php echo $__env->make('layouts.iteb-grading-buttons', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Filter Class Allocation</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form id="filterForm" method="GET" action="<?php echo e(route('class.allocation.filter')); ?>">
                            <div class="row">

                                <!-- Year Dropdown -->
                                <div class="col-md-2 mb-3">
                                    <label><strong>Select Year</strong></label>
                                    <select name="year" class="form-control select2" required>
                                        <option value="">-- Select Year --</option>
                                        <?php for($year = 2025; $year <= 2030; $year++): ?>
                                            <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <!-- Category Dropdown -->
                                <div class="col-md-2 mb-3">
                                    <label><strong>Select Category</strong></label>
                                    <select name="category" class="form-control select2" required>
                                        <option value="">-- Select Category --</option>
                                        <option value="UCE">O-LEVEL (UCE)</option>
                                        <option value="UACE">A-LEVEL (UACE)</option>
                                        <!-- <option value="PLE">Primary - PLE</option> -->
                                    </select>
                                </div>

                                <!-- School Dropdown (Wider) -->
                                <div class="col-md-8 mb-3">
                                    <label><strong>Select School</strong></label>
                                    <select name="school_number" class="form-control select2" required>
                                        <option value="">-- Select School --</option>
                                        <?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($house->Number); ?>">
                                                <?php echo e($house->House); ?> (<?php echo e($house->Number); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                            </div>


                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fa fa-database me-2"></i> Fetch Records
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('filterForm').addEventListener('submit', function () {

            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we fetch the records.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/itemGrading/enterMarks.blade.php ENDPATH**/ ?>