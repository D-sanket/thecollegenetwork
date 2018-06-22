<html>
<head>
	<title> Home | TheCollegeNetwork </title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
	@if(Auth::check())
		<div class="logout-btn">
			<a href="/auth/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
		</div>
	@endif
	<div class="container text-center">
		<div class="home-title">
			<a href="/"><h1 class="didot">The<span class="font-blue">Social</span>Network</h1></a>
		</div>
		@include('includes.success')
		<div class="row home-menu">
			<a href="/timeline" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Timeline
			</a>
			<a href="/friends" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Friends
			</a>
			@if(!Auth::check())
				<a href="/auth/login" class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4 jumbotron">
					Login/Register
				</a>
			@endif

		</div>
	</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
