<html>
<head>
	<title> Home | TheCollegeNetwork </title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
	<div class="container text-center">
		<div class="home-title">
			<a href="/"><h1 class="didot">The<span class="font-pink-dark">College</span>Network</h1></a>
		</div>
		<div class="row home-menu">
			<a href="/timeline" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Timeline
			</a>
			<a href="/attendance" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Attendance
			</a>
			<a href="/results" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Results
			</a>
			<a href="/friends" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Friends
			</a>
			<a href="/clubs" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Clubs & Circles
			</a>
			<a href="/feedback" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Feedback & Complaints
			</a>
			<a href="/appointments" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Appointments & Permissions
			</a>
			<a href="/track" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Track a friend
			</a>
			<a href="/confessions" class="col-xs-12 col-sm-6 col-md-4 jumbotron">
				Confessions
			</a>
			@if(!Auth::check())
				<a href="/auth/login" class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4 jumbotron">
					Login/Register
				</a>
			@endif
			<a href="/help" class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4 jumbotron">
				Help
			</a>


		</div>
	</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>