@extends('master')

@section('title')
	{{ $user->name() }}
@endsection

@section('content')
	<div class="cover">
		<img src="{{ asset($user->cover()) }}" class="img-responsive">
		@if(Auth::user() == $user)
			<div class="cover-bg">
				<div class="col-sm-6 col-sm-offset-6 text-center">
					<h4><i class="mdi mdi-image-plus"></i> Click to change</h4>
				</div>
			</div>
		@endif

	</div>
	<div class="dp-name">
		<img src="{{ asset($user->dp()) }}" class="img-responsive img-circle">
		<div class="dp-bg">

		</div>

		<span class="name"><h3>{{ $user->name() }}</h3>
		@if(Auth::user() == $user)
			<a class="edit-profile-btn" data-toggle="collapse" data-target="#edit">Edit profile</a> </span>
		@endif

	</div>

	<div id="edit" class="collapse  profile-edit-box">
		skas
	</div>
	
	<script>
		$(".cover-bg").click(function () {
			loadModal('Upload cover', '/profile/upload/cover', { _token: '{{ csrf_token() }}'});

        });


	</script>
@endsection