<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php echo e($category === 'UACE' ? 'A Level Subject Performance' : ($category === 'PLE' ? 'PLE Subject Performance' : 'O Level Subject Performance')); ?>

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
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #fff;
            padding: 14mm 14mm;
        }

        .box {
            border: 2px solid #000;
            padding: 14px 22px 12px 22px;
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

        .box-title {
            text-align: center;
            font-weight: bold;
            font-size: 13.5px;
            margin: 6px 0 2px 0;
            letter-spacing: .5px;
        }

        .box-meta {
            text-align: center;
            font-size: 12.5px;
            margin-bottom: 14px;
        }

        table.perf-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        table.perf-table th,
        table.perf-table td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: center;
        }

        table.perf-table th.subj-col,
        table.perf-table td.subj-col {
            text-align: left;
        }

        table.perf-table th {
            font-weight: bold;
        }

        .box-footer {
            text-align: center;
            font-style: italic;
            font-size: 11px;
            margin-top: 16px;
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
            size: A4;
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

    <h1>
        KAMPALA INTEGRATED SECONDARY SCHOOLS'<br>
        EXAMINATION BUREAU <?php echo e($year); ?>

    </h1>
</div>


            <div class="box-title">
                <?php echo e($category === 'UACE' ? 'UACE MOCK SUBJECTSLIP' : ($category === 'PLE' ? 'PLE MOCK SUBJECTSLIP' : 'UCE MOCK SUBJECTSLIP')); ?>

            </div>
            <div class="box-meta">
                SCHOOL <?php echo e(strtoupper($schoolName)); ?> &nbsp; DISTRICT <?php echo e(strtoupper($schoolDistrict)); ?> &nbsp; TEST
                CENTER NO: NA
            </div>

            <table class="perf-table">
                <thead>
                    <tr>
                        <th class="subj-col">Subject</th>
                        <?php $__currentLoopData = $gradeScale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($g); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($showPassColumn): ?>
                            <th>% Pass</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="subj-col"><?php echo e($i + 1); ?>. <?php echo e($row['subject']->md_name); ?></td>
                            <?php $__currentLoopData = $gradeScale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e($row['tally'][$g] ?? 0); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($showPassColumn): ?>
                                <td><?php echo e(number_format($row['percent_pass'], 2)); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="box-footer">&quot;Quality assessment for reliable results&quot;</div>
        </div>
    </div>

</body>

</html><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/reports/mock-subjectslip.blade.php ENDPATH**/ ?>