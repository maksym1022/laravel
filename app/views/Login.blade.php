<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NSTV Gryffindor Dashboard</title>
    <meta name="description" content="">
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
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <!-- Feature detection -->
    <script src="{{ asset('public/assets/js/modernizr-2.6.2.min.js') }}"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{asset('public/assets/js/html5shiv.js') }}"></script>
    <script src="{{asset('public/assets/js/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body class="animated fadeIn">
    <section id="login-container">

        <div class="row">
            <div class="col-md-3" id="login-wrapper">
                <div class="panel panel-primary animated flipInY">
                    <div class="panel-heading">
                        <h3 class="panel-title">     
                           Sign In
                        </h3>      
                    </div>
                    <div class="panel-body">
                       <p> Login to access your account.</p>
                       {{ $errors->first("password") }}<br />
                        <form method="post" class="form-horizontal" action="{{asset('')}}login" role="form">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                            <div class="form-group">
                               <div class="col-md-12">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                                    <i class="fa fa-lock"></i>
                                </div>
                            </div>
                            <div class="form-group">
                               <div class="col-md-12">
                               		<button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--Global JS-->
    <script src="{{ asset('public/assets/')}}js/jquery-1.10.2.min.js"></script>
    <script src="{{ asset('public/assets/')}}plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/assets/')}}plugins/waypoints/waypoints.min.js"></script>
    <script src="{{ asset('public/assets/')}}plugins/nanoScroller/jquery.nanoscroller.min.js"></script>
    <script src="{{ asset('public/assets/')}}js/application.js"></script>
    </body>

</html>
