
<div class="panel panel-default">
	<div class="panel-heading">
		{{ $panel_title }}
	</div>
	<div class="panel-body">
		@yield('panel-users')

		@foreach($users as $user)
			<div class="user-panel col-xs-12 col-sm-6">
				<div class="col-xs-4">
					<img src="{{ $user->dp() }}" class="img-responsive">
				</div>
				<div class="col-xs-8">
					{{ $user->firstname }}
				</div>
			</div>
		@endforeach
	</div>
</div>