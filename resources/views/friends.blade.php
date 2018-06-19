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

	@if($users = Auth::user()->getSuggestions()->limit(6)->get())
		<div class="panel panel-default">
			<div class="panel-heading">
				Suggested friends
			</div>
			<div class="panel-body suggested-friends">
				@foreach($users as $user)
					<div  class="col-xs-12 col-sm-6 user-panel">
						<div class="col-xs-12">
							<img src="{{ $user->dp() }}" class="img-responsive">
							<div>
								<div class="name">
									<a href="/profile/{{ $user->reg_no }}">
										{{ $user->firstname }} {{ $user->lastname }}
									</a>
								</div>
								<div>
									<a class="action add" data-id="{{ $user->id }}"> Add</a>
									<a class="action">Block</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach

			</div>
		</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">Friend requests</div>
		<div class="panel-body friend-requests">
			@if($users = Auth::user()->friendRequests())
				@if($users->count() == 0)
					<div class="alert alert-default">You have no friend requests.</div>
				@endif
				@foreach($users as $user)
					<div  class="col-xs-12 col-sm-6 user-panel">
						<div class="col-xs-12">
							<img src="{{ $user->dp() }}" class="img-responsive">
							<div>
								<div class="name">
									<a href="/profile/{{ $user->reg_no }}">
										{{ $user->firstname }} {{ $user->lastname }}
									</a>
								</div>
								<div>
									<a class="action accept" data-id="{{ $user->id }}">Accept</a>
									<a class="action">Block</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			@endif
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Sent requests</div>
		<div class="panel-body friend-requests">
			@if($reqs = Auth::user()->sentRequests)
				@if($reqs->count() == 0)
					<div class="alert alert-default">You sent no friend requests.</div>
				@endif
				@foreach($reqs as $req)
					@if($user = App\User::where('id', $req->to)->first())
							<div  class="col-xs-12 col-sm-6 user-panel">
								<div class="col-xs-12">
									<img src="{{ $user->dp() }}" class="img-responsive">
									<div>
										<div class="name">
											<a href="/profile/{{ $user->reg_no }}">
												{{ $user->firstname }} {{ $user->lastname }}
											</a>
										</div>
										<div>
											<a class="action cancel" data-id="{{ $user->id }}">Cancel</a>
										</div>
									</div>
								</div>
							</div>
					@endif
				@endforeach
			@endif
		</div>
	</div>

	<script>
		$("a.action.add").click(function () {
		   var id = $(this).attr('data-id');
		   var elem = $(this);
			$.ajax({
				url: '/friends/add/'+id,
				type: "POST",
				data: { _token: '{{ \Illuminate\Support\Facades\Session::token() }}', id: id },
				success: function (response) {
					elem.html('<i class="mdi mdi-18px mdi-check"></i>Sent');
                },
				error: function (err) {
					alert(err.statusText);
                }
			});
        });

        $("a.action.cancel").click(function () {
            var id = $(this).attr('data-id');
            var elem = $(this);
            $.ajax({
                url: '/friends/cancel/'+id,
                type: "POST",
                data: { _token: '{{ \Illuminate\Support\Facades\Session::token() }}', id: id },
                success: function (response) {
                    elem.html('Cancelled');
                },
                error: function (err) {
                    alert(err.statusText);
                }
            });
        });
	</script>
@endsection