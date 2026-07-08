<?php
// Removed: use App\Http\Controllers\Controller; $controller = new Controller(); (unnecessary instantiation)
use App\Http\Controllers\Helper; // Keep if Helper::recordMdname is still used or for other helpers
?>


<?php $__env->startSection('css'); ?>
    
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Student Dashboard -->
    <div class="side-app">

        <div class="card shadow-sm border-0">
            <div class="card-header  text-white d-flex justify-content-between align-items-center"
                style="background-color: #026837;">
                <h5 class="mb-0">All Schools</h5>

                    <!-- <a href="<?php echo e(route('school.create-school')); ?>" class="btn btn-sm" style="background-color: #c51619;"> -->
                    <a href="<?php echo e(route('houses.create')); ?>" class="btn btn-sm" style="background-color: #c51619;">
                        <span class="rounded-circle bg-white d-inline-flex align-items-center justify-content-center me-1"
                            style="width: 20px; height: 20px;">
                            <i class="fas fa-plus" style="font-size: 12px;"></i>
                        </span>
                        <span class="text-white">Add School</span>
                    </a>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="schoolsTable" class="table table-striped table-bordered align-middle">
                        <thead class="custom-header">
                            <tr>
                                <th>No</th>
                                <th style="text-align: left;">School Name</th>
                                <!-- <th style="text-align: left;">School AR</th> -->
                                <th style="text-align: left;">School Code</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                                $statusConfig = [
                                    10 => [
                                        'label' => 'Active',
                                        'class' => 'text-success',
                                        'icon' => 'fas fa-check-circle',
                                    ],
                                    0 => ['label' => 'Banned', 'class' => 'text-danger', 'icon' => 'fas fa-ban'],
                                    8 => ['label' => 'Locked', 'class' => 'text-warning', 'icon' => 'fas fa-lock'],
                                    9 => [
                                        'label' => 'Suspended',
                                        'class' => 'text-secondary',
                                        'icon' => 'fas fa-user-slash',
                                    ],
                                    1 => [
                                        'label' => 'Pending Activation',
                                        'class' => 'text-secondary',
                                        'icon' => 'fas fa-clock',
                                    ],
                                ];
                            ?>

                            <?php $__empty_1 = true; $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-bold" style="width: 1px;"><?php echo e($key + 1); ?></td>
                                    <td class="fw-bold" style="text-align: left;"><?php echo e($school->House); ?></td>
                                    <!-- <td class="fw-bold" style="text-align: left;"><?php echo e($school->House_AR); ?></td> -->
                                    <td class="fw-bold" style="text-align: left;"><?php echo e($school->Number); ?></td>
                                    <td>
                                        <?php
                                            $status = $statusConfig[$school->school_status] ?? [
                                                'label' => 'Active',
                                                'class' => 'text-success',
                                                'icon' => 'fas fa-check-circle',
                                            ];
                                        ?>
                                        <span class="<?php echo e($status['class']); ?>">
                                            <i class="<?php echo e($status['icon']); ?>"></i> <?php echo e($status['label']); ?>

                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">

                                            <a href="<?php echo e(url('profile.individual.school', $school->id)); ?>"
                                                class="btn btn-sm btn-outline-info disabled" title="View School Profile"
                                                style="margin-right:6px;">
                                                <i class="fas fa-university"></i>
                                            </a>

                                            

                                            

                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-secondary btn-change-school-status disabled"
                                                data-id="<?php echo e($school->id); ?>" data-status="<?php echo e($school->school_status); ?>"
                                                title="Change Status" style="margin-right:6px;">
                                                <i class="fas fa-sync-alt"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-primary btn-edit disabled"
                                                data-id="<?php echo e($school->id); ?>"
                                                data-edit-url="<?php echo e(url('edit.school', $school->id)); ?>" title="Edit"
                                                style="margin-right:6px;">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-danger btn-delete disabled"
                                                data-id="<?php echo e($school->id); ?>" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No schools found.
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>

                    <!-- Change School Status Modal -->
                    <div class="modal fade" id="changeSchoolStatusModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="changeSchoolStatusForm">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Change School Status</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="schoolStatusId">
                                        <div class="form-group">
                                            <label for="newSchoolStatus">Select New Status</label>
                                            <select id="newSchoolStatus" class="form-control select2">
                                                <option value="1">Pending Activation</option>
                                                <option value="10">Active</option>
                                                <option value="0">Banned</option>
                                                <option value="8">Locked</option>
                                                <option value="9">Suspended</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-rotate me-1"></i>
                                            Change Status
                                        </button>

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fa-solid fa-xmark me-1"></i>
                                            Cancel
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
    </div>
    </div>
    </div>

    <style>
        . tbody tr:hover {
            background-color: #f8f9fa !important;
        }

        .dataTables_filter input {
            border-radius: 6px;
            padding: 6px 10px;
            border: 1px solid #ccc;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.35rem 0.65rem;
            margin: 0 2px;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 5px;
            padding: 4px 8px;
        }

        .dt-buttons .btn {
            margin-right: 6px;
            margin-bottom: 10px;
        }
    </style>

    
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    
    

    
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#schoolsTable').DataTable({
                responsive: false, // Ensure this is compatible with your CSS/layout
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                dom: 'frtip', // Defines table controls (Filter, Row length, Table, Info, Paging)
                columnDefs: [{
                        orderable: false,
                        targets: [1, 4, 4] // Adjust these target indices if columns change
                    },
                    {
                        className: 'text-center',
                        targets: '_all'
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search schools..."
                }
            });

            // Delete functionality
            $('#schoolsTable tbody').on('click', '.btn-delete', function() {
                var schoolId = $(this).data('id');
                var row = table.row($(this).parents('tr'));

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/school/' + schoolId,
                            type: 'DELETE',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                row.remove()
                                    .draw(); // Remove row from DataTable and redraw

                                Swal.fire(
                                    'Deleted!',
                                    'School has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong deleting the school.',
                                    'error'
                                );
                            }
                            // error: function(data) {
                            // $('body').html(data.responseText);
                            // }
                        });
                    }
                });
            });

            // Edit functionality
            $('#schoolsTable tbody').on('click', '.btn-edit', function() {
                var editUrl = $(this).data('edit-url');

                Swal.fire({
                    title: 'Edit School?',
                    text: "You are about to edit this school.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = editUrl;
                    }
                });
            });
        });

        $(document).ready(function() {
            // Open modal with current school status
            $('.btn-change-school-status').on('click', function() {
                const schoolId = $(this).data('id');
                const currentStatus = $(this).data('status');

                $('#schoolStatusId').val(schoolId);

                const $select = $('#newSchoolStatus');
                $select.val(currentStatus); // Set value (in case browser already supports it)

                // Reorder options dynamically
                const currentOption = $select.find('option[value="' + currentStatus + '"]');
                if (currentOption.length) {
                    $select.prepend(currentOption); // Move to top
                }

                $('#changeSchoolStatusModal').modal('show');
            });


            // Submit status change with confirmation
            $('#changeSchoolStatusForm').on('submit', function(e) {
                e.preventDefault();
                const schoolId = $('#schoolStatusId').val();
                const newStatus = $('#newSchoolStatus').val();

                $('#changeSchoolStatusModal').modal('hide');

                setTimeout(() => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will update the school's status.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/schools/${schoolId}/change-status`,
                                type: 'POST',
                                data: {
                                    _token: '<?php echo e(csrf_token()); ?>',
                                    status: newStatus
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Updated!',
                                        text: response.message ||
                                            'School status updated.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    // Reload to update UI
                                    location.reload();
                                },
                                // error: function (xhr) {
                                //     Swal.fire('Error', 'Failed to change status.', 'error');
                                // }
                                error: function(data) {
                                    $('body').html(data.responseText);
                                }
                            });
                        }
                    });
                }, 300);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\huzaiphar\ple-examination-boards-updated\resources\views/School/all-schools.blade.php ENDPATH**/ ?>