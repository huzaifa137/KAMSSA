<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
	<!-- Meta data -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta content="{{ $systemSettings->system_name ?? 'Iteb Academics' }}" name="description">
	<meta name="keywords"
		content="{{ $systemSettings->system_name ?? 'Iteb Academics' }}, school management system, student information system, online school platform, school ERP, digital classroom tools, school attendance tracking, exam management system, timetable scheduling, fees management system, parent-teacher communication, learning management system, education technology, school reporting tools, smart education software, school administration platform" />
	@include('layouts-side-bar.custom-head')
</head>

<body class="h-100vh light-mode">
	@yield('content')
	@include('layouts-side-bar.custom-footer-scripts')
</body>

</html>