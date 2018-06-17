@extends('master')

@section('title', 'Register')

@section('content')

	<div class="col-sm-12 col-md-6 col-sm-offset-2 col-md-offset-1 login-panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="glyphicon glyphicon-user"></span> Register <a href="/" class="pull-right didot" style="color: #2196f3;">TheCollegeNetwork</a>
			</div>
			<div class="panel-body">
				@include('includes.success')
				@include('includes.errors')
				<form method="post">
					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
						<label for="email">College email</label>
						<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
					</div>
					<div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
						<label for="firstname">First name</label>
						<input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}">
					</div>
					<div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
						<label for="lastname">Last name</label>
						<input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}">
					</div>
					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" value="">
					</div>
					<div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
						<label for="confirm_password">Confirm password</label>
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
					</div>
					<div class="form-group">
						<label for="course_year">Select course year</label>
						<select class="form-control" id="course_year" name="course_year">
							<option value="1">1st year</option>
							<option value="2">2nd year</option>
							<option value="3">3rd year</option>
							<option value="4">4th year</option>
						</select>
					</div>

					@csrf

					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
				<div class="text-center">
					Already registered? <a href="/auth/login"> Login now </a>
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
