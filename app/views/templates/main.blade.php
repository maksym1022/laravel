<!DOCTYPE HTML>
<!--[if lt IE 7]>      
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>         
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>         
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
	<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>NSTV Geliathus Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
		<!-- Bootstrap core CSS -->
		<link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
		<!-- Fonts from Font Awsome -->
		<link href="{{ asset('public/assets/css/font-awesome.min.css') }}" rel="stylesheet">
		<!-- CSS Animate -->
		<link href="{{ asset('public/assets/css/animate.css') }}" rel="stylesheet">
		<!-- Custom styles for this theme -->
		<link href="{{ asset('public/assets/css/main.css') }}" rel="stylesheet">
		<!-- Function Import -->
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href="https://ajax.googleapis.com/ajax/static/modules/gviz/1.0/core/tooltip.css" rel="stylesheet" type="text/css">
		<!--lib-->
		<script src="{{ asset('public/assets/js/jquery-1.10.2.min.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<!-- Function Import -->
        <script src="https://www.google.com/jsapi"></script>
		<!-- Feature detection -->
		<script src="{{ asset('public/assets/js/modernizr-2.6.2.min.js') }}"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="{{asset('public/assets/js/html5shiv.js') }}"></script>
		<script src="{{asset('public/assets/js/respond.min.js') }}"></script>
		<![endif]-->
	</head>
	<body class="animated fadeIn">
		<section id="container">
			<header id="header">
				<!--logo start-->
				<div class="brand">
					<a href="{{ asset('')}}" class="logo">
					<img src="{{asset('public/img/logo-white.png')}}" width="140" height="40" alt="NSTV Manager">
					</a>
				</div>
				<!--logo end-->
				<div class="user-nav">
					<ul>
						<li class="dropdown messages">
						<li class="profile-photo">
							<img src="{{Auth::user()->avatar}}" alt="" width="40" height="40" class="img-circle">
						</li>
						<li class="dropdown settings">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							{{ Auth::user()->username }} <i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu animated fadeInDown">
								<li>
									<a href="{{asset('users/edit/').'/'. Auth::user()->id }}"><i class="fa fa-user"></i> Edit Profile</a>
								</li>
								<li>
									<a href="{{ asset('logout/')}}"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</header>
			<!--sidebar left start-->
            @include('templates.sidebar')
			<!--sidebar left end-->
			<!--main content start-->
			<section class="main-content-wrapper">
				<section id="main-content">
					@yield('content')
				</section>
			</section>
			<!--main content end-->
			<!--sidebar right start-->
			<aside class="sidebarRight">
				<div id="rightside-navigation ">
					<div class="sidebar-heading"><i class="fa fa-user"></i> Contacts</div>
					<div class="sidebar-title">online</div>
					<div class="list-contacts">
						<a href="javascript:void(0)" class="list-item">
							<div class="list-item-image">
								<img src="{{url()}}/public/assets/img/avatar.gif" class="img-circle">
							</div>
							<div class="list-item-content">
								<h4>James Bagian</h4>
								<p>Los Angeles, CA</p>
							</div>
							<div class="item-status item-status-online"></div>
						</a>
						<a href="javascript:void(0)" class="list-item">
							<div class="list-item-image">
								<img src="{{url()}}/public/assets/img/avatar1.gif" class="img-circle">
							</div>
							<div class="list-item-content">
								<h4>Jeffrey Ashby</h4>
								<p>New York, NY</p>
							</div>
							<div class="item-status item-status-online"></div>
						</a>
						<a href="javascript:void(0)" class="list-item">
							<div class="list-item-image">
								<img src="{{url()}}/public/assets/img/avatar2.gif" class="img-circle">
							</div>
							<div class="list-item-content">
								<h4>John Douey</h4>
								<p>Dallas, TX</p>
							</div>
							<div class="item-status item-status-online"></div>
						</a>
						<a href="javascript:void(0)" class="list-item">
							<div class="list-item-image">
								<img src="{{url()}}/public/assets/img/avatar3.gif" class="img-circle">
							</div>
							<div class="list-item-content">
								<h4>Ellen Baker</h4>
								<p>London</p>
							</div>
							<div class="item-status item-status-away"></div>
						</a>
					</div>
					<div class="sidebar-title">offline</div>
					<div class="list-contacts">
						<a href="javascript:void(0)" class="list-item">
							<div class="list-item-image">
								<img src="{{url()}}/public/assets/img/avatar4.gif" class="img-circle">
							</div>
							<div class="list-item-content">
								<h4>Ivan Bella</h4>
								<p>Tokyo, Japan</p>
							</div>
							<div class="item-status"></div>
						</a>
						<a href="javascript:void(0)" class="list-item">
							<div class="list-item-image">
								<img src="{{url()}}/public/assets/img/avatar5.gif" class="img-circle">
							</div>
							<div class="list-item-content">
								<h4>Gerald Carr</h4>
								<p>Seattle, WA</p>
							</div>
							<div class="item-status"></div>
						</a>
						<a href="javascript:void(0)" class="list-item">
							<div class="list-item-image">
								<img src="{{url()}}/public/assets/img/avatar6.gif" class="img-circle">
							</div>
							<div class="list-item-content">
								<h4>Viktor Gorbatko</h4>
								<p>Palo Alto, CA</p>
							</div>
							<div class="item-status"></div>
						</a>
					</div>
				</div>
			</aside>
			<!--sidebar right end-->
		</section>
		<!--Global JS-->
		<script src="{{asset('public/assets')}}/plugins/waypoints/waypoints.min.js"></script>
		<script src="{{asset('public/assets')}}/js/application.js"></script>
	</body>
</html>
