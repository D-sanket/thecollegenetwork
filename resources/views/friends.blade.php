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

		@include('includes.friends.base', ['panel_title' => "Suggested friends", 'users' => \App\User::all()])
		@include('includes.friends.base', ['panel_title' => "Friend requests", 'users' => \App\User::all()])
		@include('includes.friends.base', ['panel_title' => "Friends", 'users' => \App\User::all()])
		@include('includes.friends.base', ['panel_title' => "Sent requests", 'users' => \App\User::all()])


</form>

<script>


	function AJAXify(elem, url, data, callback) {
		data._token = "{{ csrf_token() }}";
		elem.click(function () {
			alert(elem);
			$.ajax({
				url: url,
				type: "POST",
				data: data,
				success: function (response) {
					callback(response);
				},
				error: function (err) {
					alert(err.statusText);
				}
			});
		});
	}

	function deAJAXify(elem) {
		elem.click(function () {

		});
	}
</script>
@endsection