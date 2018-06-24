<html>
<head>
	<title> @yield('title') | TheCollegeNetwork </title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
	<link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{ asset('js/app.js') }}"></script>
</head>
<body>

	<div class="row">

		@include('includes.nav')
		<div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-4 col-lg-offset-3 main">
			<div>@yield('content')</div>
		</div>

		@include('includes.rightnav')

		@include('includes.modal')

		@include('includes.toast')

		@include('includes.loader')

	</div>



<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>