
@if(Session::has('message'))
	<div class="panel panel-success">
		<div class="panel-heading">
			{{ Session::get('message') }}
		</div>
	</div>
@endif