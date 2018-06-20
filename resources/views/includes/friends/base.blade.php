
<div class="panel panel-default">
	<div class="panel-heading">
		{{ $panel_title }}
	</div>
	<div class="panel-body">
		@if(count($users) == 0)
			Nothing to show.
		@endif
		@foreach($users as $user)
			<div class="col-xs-12 col-sm-6">
				<div class="user-panel col-xs-12">
					<div class="col-xs-3">
						<img src="{{ $user->dp() }}" class="img-responsive">
					</div>
					<div class="col-xs-9">
						<a href="/profile/{{ $user->reg_no }}">{{ $user->firstname }} {{ $user->lastname }}</a> <br/>
						{!! Auth::user()->friendsBtnFor($user->id) !!}
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>