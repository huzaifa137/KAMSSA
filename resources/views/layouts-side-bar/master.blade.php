<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<!-- Meta data -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta content="{{ $systemSettings->system_name ?? 'Iteb Academics' }}" name="description">
	<meta name="keywords"
		content="{{ $systemSettings->system_name ?? 'Iteb Academics' }}, school management system, student information system, online school platform, school ERP, digital classroom tools, school attendance tracking, exam management system, timetable scheduling, fees management system, parent-teacher communication, learning management system, education technology, school reporting tools, smart education software, school administration platform" />

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('layouts-side-bar.head')
</head>

<body class="app sidebar-mini light-mode default-sidebar">
	<!---Global-loader-->
	<div id="global-loader">
		<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
	</div>

	<div class="page">
		<div class="page-main">
			@include('layouts-side-bar.side-menu')
			<div class="app-content main-content">
				<div class="side-app">
					@include('layouts-side-bar.header')
					@yield('page-header')
					@yield('content')
					@include('layouts-side-bar.footer')
				</div><!-- End Page -->
				@include('layouts-side-bar.footer-scripts')
</body>

</html>