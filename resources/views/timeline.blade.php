@extends('master')

@section('title', 'Timeline')

@section('content')

	<form class="panel panel-default">
		<textarea name="post_text" autocomplete="off" placeholder="Type something here.." class="post-text panel-body"></textarea>
		<div class="panel-footer post-footer">
			<div class="post-extras col-sm-9">

			</div>
			<div class="post-actions col-sm-3 text-center">
				<a class="post-action add-image col-sm-4"><i class="mdi mdi-18px mdi-image-plus"></i> </a>
				<a class="post-action tag col-sm-4"><i class="mdi mdi-18px mdi-tag"></i> </a>
				<a class="post-action post col-sm-4"><i class="mdi mdi-18px mdi-send"></i> </a>
			</div>
		</div>
	</form>

	<script>

		$('.post-action.post').click(function () {
			var data = {
			    _token: '{{ csrf_token() }}',
				text: $('.post-text').val()
			};

			$.ajax({
				url: '/timeline/post/submit',
				type: "POST",
				data: data,
				success: function (response) {
					if(response == ''){
                        $('.post-text').val('');
					}
                },
				error: function (err) {
					alert('Error : '+err.statusText);
                }
			});
        });

		function fetchPosts(offset, limit) {
            var data = {
                _token: '{{ csrf_token() }}',
				offset: offset,
				limit: limit
            };

            $.ajax({
                url: '/timeline/post/getposts',
                type: "POST",
                data: data,
                success: function (response) {

                },
                error: function (err) {
                    alert('Error : '+err.statusText);
                }
            });
        }

	</script>
@endsection