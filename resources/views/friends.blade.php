@extends('master')

@section('title', 'Friends')

@section('content')
	<form class="">
		<div class="form-group">
			<label class="sr-only" for="search">Find friends</label>
			<div class="input-group">
				<div class="input-group-addon"><i class="mdi mdi-account-search-outline mdi-18px"></i> </div>
				<input type="text" class="form-control" id="search" placeholder="name or registration number..">
			</div>
		</div>

	</form>

	@if($users = DB::table('users')->where('reg_no', '!=', Auth::user()->reg_no)->limit(3)->get())
		<div class="panel panel-default">
			<div class="panel-heading">
				Suggested friends
			</div>
			<div class="panel-body suggested-friends">
				@foreach($users as $user)

					<div class="col-xs-4 col-lg-3" style="display: inline-block; float: left">
						<div class="panel panel-default user-thumbnail">
							<a  href="/profile/{{ $user->reg_no }}" class="panel-body">
								<img src="/images/dwnld.jpg" class="img-responsive">
							</a>
							<a href="/profile/{{ $user->reg_no }}">
								<div class="panel-footer">
									{{ $user->firstname }} {{ $user->lastname }}
								</div>
							</a>
						</div>
					</div>
				@endforeach

			</div>
		</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">Friends</div>
		<div class="panel-body">

		</div>
	</div>
@endsection