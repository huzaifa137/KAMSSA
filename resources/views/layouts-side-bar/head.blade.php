<!-- Title -->
<title>{{ $systemSettings->system_name ?? 'Iteb Academics' }}</title>
<!--Favicon -->
<link rel="icon" href="{{ URL::asset('assets/images/brand/favicon.ico') }}" type="image/x-icon" />
<!-- Bootstrap css -->
<link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />
<!-- Style css -->
<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
<!-- Dark css -->
<link href="{{URL::asset('assets/css/dark.css')}}" rel="stylesheet" />
<!-- Skins css -->
<link href="{{URL::asset('assets/css/skins.css')}}" rel="stylesheet" />
<!-- Animate css -->
<link href="{{URL::asset('assets/css/animated.css')}}" rel="stylesheet" />
<!--Sidemenu css -->
<link id="theme" href="{{URL::asset('assets/css/sidemenu.css')}}" rel="stylesheet">
<!-- P-scroll bar css-->
<link href="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />
<!-- Prism Css -->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Icons css-->
<link href="{{URL::asset('assets/plugins/web-fonts/icons.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/web-fonts/plugin.css')}}" rel="stylesheet" />
<!-- Select2 css -->
<link href="http://127.0.0.1:8000/assets/plugins/select2/select2.min.css" rel="stylesheet" />

@yield('css')