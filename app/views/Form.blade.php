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
		<!--link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"-->
        <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
		<!-- Fonts from Font Awsome -->
		<link href="{{ asset('public/assets/css/font-awesome.min.css') }}" rel="stylesheet">
		<!-- CSS Animate -->
		<link href="{{ asset('public/assets/css/animate.css') }}" rel="stylesheet">
		<!-- Custom styles for this theme -->
		<!--link href="{{ asset('public/assets/css/main.css') }}" rel="stylesheet"-->
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
<body>    
<div class="container">
	<div class="col-md-12">	
	<div class="col-sm-4" style="margin:0 auto; float: none;">
		<br><br>
		<div class="panel panel-primary">
			<div class="panel-heading">
		       <div class="panel-title text-center"> <h3> </h3> </div>
			</div>
			<div class="panel-body">
		
				<form action="{{asset('')}}form/send" method="post">
					<input type="hidden" name="hub_id" value="<?=$hub_id;?>">
					<input type="hidden" name="user_id" value="<?=$user_id;?>">
					<div>
						<label for="channel_name" class="control-label">Your YouTube Channel</label>
					</div>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i> 
						</span>
	        			<input required="required" type="text" class="form-control" name="channel_name" id="channel_name" placeholder="eg: /nstvnet"> 
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon">
							 <i class="glyphicon glyphicon-user"></i> 
						</span>
	        			<input required="required" type="text" class="form-control" name="first_name" placeholder="First Name"> 
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon">
						 	<i class="glyphicon glyphicon-user"></i> 
						</span>
	        			<input required="required" type="text" class="form-control" name="last_name" placeholder="Last Name"> 
					</div>
					<br>
					<div class="control-group">
						<label for="channel_email" class="control-label" style="background-color:#E5E5E5"> Email address::</label>
						<div class="controls">
							<span class="help-block">To make it possible our entire validation, please enter the email address linked to your YouTube channel so we can make the whole process more quickly!</span>
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-addon"> <i class="glyphicon glyphicon-envelope"></i> </span>
	        			<input id="channel_email" required="required" type="email" class="form-control" required="required" name="channel_email" placeholder="Enter email"> 
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon"> <i class="glyphicon glyphicon-envelope"></i> </span>
	        			<input type="email" required="required" class="form-control" name="confirm_email" placeholder="Confirm email"> 
					</div>
					<br>
					<div class="control-group">
						<label for="paypal" class="control-label" style="background-color:#E5E5E5"> Payment info::</label>
						<div class="controls">
							<span class="help-block">Below enter your PayPal address so that we can make all payments!</span>	
							<div class="input-group">
								<span class="input-group-addon"> <i class="glyphicon glyphicon-user"></i> </span>
	        					<input type="text" class="form-control" id="paypal" name="paypal" placeholder="PayPal"> 
							</div>
							<span class="help-block">
								<b>
									<input type="checkbox" name="agree_views" value="aceppt">
									I agree that I have generated at least 15k monthly views.
								</b>
							</span>
							<span class="help-block">
								<b>
									<input type="checkbox" name="agree_copyright" value="aceppt2">
									You agree that your content is authored and not your own any Copyright notices in your channel.
								</b>
							</span>
						</div>
					</div>
					<div class="control-group">
						<span class="help-block">
							<b>
								<input type="checkbox" name="agree_quota" value="60">
								Agrees to receive a pre-determined quota under or verbally.
							</b>
						</span>
							<br>
							<?php echo Recaptchalib::recaptcha_get_html($publickey);?> 
							<br>
							<span class="help-block">When you submit your application, you will be redirected to the contract!</span>
							<!--<span class="help-block">By sending your request you accept our <a href="<?//=$hub->contract_url_form;?>" target="_blank">terms</a> partnership!</span> -->
							<input type="submit" name="register_submit" class="btn btn-primary btn-lg" value="Send">
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
    </div>

</body>
</html>  