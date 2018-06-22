<html>
<head>
	<title> Auth | TheCollegeNetwork </title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="container text-center">
	<div class="home-title">
		<a href="/"><h1 class="didot">The<span class="font-blue">Social</span>Network</h1></a>
	</div>
	@yield('content')
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
