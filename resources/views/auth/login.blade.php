@extends('auth.main')

@section('title', 'Login')

@section('content')

	<div class="col-sm-12 col-md-6 col-sm-offset-3 login-panel text-left">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="glyphicon glyphicon-log-in"></span> Login
			</div>
			<div class="panel-body">
				@include('includes.success')
				@include('includes.errors')
				<form method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password">
					</div>
					<div class="checkbox">
						<label><input type="checkbox" name=""> Remember me</label>
					</div>
					@csrf
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
				<div class="text-center">
					Not registered yet? <a href="/auth/register"> Register now </a>
				</div>
			</div>
		</div>
	</div>


@endsection
