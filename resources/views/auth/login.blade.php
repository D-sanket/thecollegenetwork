@extends('master')

@section('title', 'Login')

@section('content')

	<div class="col-sm-12 col-md-6 col-sm-offset-2 col-md-offset-1 login-panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="glyphicon glyphicon-log-in"></span> Login <a href="/" class="pull-right didot" style="color: #2196f3;">TheCollegeNetwork</a>
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

	<style>
		.sidenav{
			transform: scaleX(0);
		}
	</style>

@endsection
