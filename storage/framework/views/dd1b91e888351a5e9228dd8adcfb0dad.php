<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<!-- Meta data -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta content="Iteb Academics" name="description">
	<meta name="keywords"
		content="Iteb Academics, school management system, student information system, online school platform, school ERP, digital classroom tools, school attendance tracking, exam management system, timetable scheduling, fees management system, parent-teacher communication, learning management system, education technology, school reporting tools, smart education software, school administration platform" />

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<?php echo $__env->make('layouts-side-bar.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="app sidebar-mini light-mode default-sidebar">
	<!---Global-loader-->
	<div id="global-loader">
		<img src="<?php echo e(URL::asset('assets/images/svgs/loader.svg')); ?>" alt="loader">
	</div>

	<div class="page">
		<div class="page-main">
			<?php echo $__env->make('layouts-side-bar.side-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<div class="app-content main-content">
				<div class="side-app">
					<?php echo $__env->make('layouts-side-bar.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php echo $__env->yieldContent('page-header'); ?>
					<?php echo $__env->yieldContent('content'); ?>
					<?php echo $__env->make('layouts-side-bar.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				</div><!-- End Page -->
				<?php echo $__env->make('layouts-side-bar.footer-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\Users\USER\Desktop\huzaiphar\ple-examination-boards-updated\resources\views/layouts-side-bar/master.blade.php ENDPATH**/ ?>