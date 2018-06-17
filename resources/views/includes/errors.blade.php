@if($errors->count() > 0)
	<div class="panel-group">
		@foreach($errors->all() as $error)
			<div class="panel panel-danger">
				<div class="panel-heading">
					{{ $error }}
				</div>
			</div>
		@endforeach
	</div>
@endif