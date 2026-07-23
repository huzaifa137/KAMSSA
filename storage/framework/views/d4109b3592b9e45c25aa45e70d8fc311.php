<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php echo e($category === 'UACE' ? 'A Level Student Report' : ($category === 'PLE' ? 'PLE Student Report' : 'O Level Student Report')); ?>

    </title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            background: #e9e9e9;
        }

        .toolbar {
            padding: 14px 18px;
        }

        .toolbar button {
            background: #0b6b3a;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .sheet {
            width: 297mm;
            min-height: 210mm;
            margin: 0 auto;
            background: #fff;
            padding: 12mm 14mm;
        }

        .box {
            border: 2px solid #000;
            padding: 14px 20px 12px 20px;
        }

        .box-header {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 14px;
            position: relative;
        }

        .box-header .logo-circle {
            position: absolute;
            left: 0;
            top: -2px;
            width: 60px;
            height: 60px;
            border: none;
            border-radius: 0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box-header .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }


        .box-header h1 {
            font-size: 19px;
            font-weight: bold;
            text-align: center;
            margin: 2px 0;
            line-height: 1.3;
        }

        .box-meta {
            text-align: center;
            font-size: 12.5px;
            margin: 4px 0 2px 0;
        }

        .box-title {
            text-align: center;
            font-weight: bold;
            font-size: 13.5px;
            margin: 2px 0 12px 0;
            letter-spacing: .5px;
        }

        table.analysed-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table.analysed-table th,
        table.analysed-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }

        table.analysed-table th.name-col,
        table.analysed-table td.name-col {
            text-align: left;
            white-space: nowrap;
        }

        table.analysed-table th {
            font-weight: bold;
        }

        .box-footer {
            text-align: center;
            font-style: italic;
            font-size: 11px;
            margin-top: 14px;
        }

        @media print {
            body {
                background: #fff;
            }

            .toolbar {
                display: none;
            }

            .sheet {
                margin: 0;
                width: auto;
                min-height: auto;
            }
        }

        @page {
            size: A4 landscape;
            margin: 8mm;
        }
    </style>
</head>

<body>

    <div class="toolbar">
        <button onclick="window.print()"><i class="fa fa-print"></i> Print</button>
    </div>

    <div class="sheet">
        <div class="box">
            <div class="box-header">
                <div class="logo-circle">
                    <img src="<?php echo e(asset('assets/images/brand/uplogolight.png')); ?>" alt="KAMSSA Logo">
                </div>

                <h1>KAMPALA INTEGRATED SECONDARY SCHOOLS'<br>EXAMINATION BUREAU <?php echo e($year); ?></h1>
            </div>

            <div class="box-meta"><?php echo e(strtoupper($schoolName)); ?> &nbsp; <?php echo e(strtoupper($schoolDistrict)); ?> &nbsp; NA</div>
            <div class="box-title">
                <?php echo e($category === 'UACE' ? 'UACE MOCK ANALYSED REPORT' : ($category === 'PLE' ? 'PLE MOCK ANALYSED REPORT' : 'UCE MOCK ANALYSED REPORT')); ?>

            </div>

            <table class="analysed-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="name-col">Name</th>
                        <th>Index No</th>
                        <?php if($category === 'UACE'): ?>
                            <th>Combination</th>
                        <?php endif; ?>
                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($subject->md_name); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category === 'UACE'): ?>
                            <th>Points</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td class="name-col"><?php echo e(strtoupper($student['name'])); ?></td>
                            <td>NA</td>
                            <?php if($category === 'UACE'): ?>
                                <td><?php echo e($student['combination_code'] ?? 'NA'); ?></td>
                            <?php endif; ?>
                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e($student['grades'][$subject->md_id] ?? ''); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($category === 'UACE'): ?>
                                <td><?php echo e($student['points']); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="box-footer">&quot;Quality assessment for reliable results&quot;</div>
        </div>
    </div>

</body>

</html><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/reports/mock-analysed.blade.php ENDPATH**/ ?>