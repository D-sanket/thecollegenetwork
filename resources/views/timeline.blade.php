@extends('master')

@section('title', 'Timeline')

@section('content')

	<form class="panel panel-default">
		<textarea name="post_text" autocomplete="off" placeholder="Type something here.." class="post-text panel-body"></textarea>
		<div class="panel-footer post-footer">
			<div class="post-extras col-sm-9">

			</div>
			<div class="post-actions col-sm-4 text-center">
				<a class="post-action privacy col-sm-3"><i class="mdi mdi-18px mdi-security-lock"></i> </a>
				<a class="post-action add-image col-sm-3"><i class="mdi mdi-18px mdi-image-plus"></i> </a>
				<a class="post-action tag col-sm-3"><i class="mdi mdi-18px mdi-tag"></i> </a>
				<a class="post-action post col-sm-3"><i class="mdi mdi-18px mdi-send"></i> </a>
			</div>
		</div>
	</form>

	<div class="post-container">

	</div>

	<script>

        fetchPosts(0, 10);

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
                        toast('Your status is live now.');
					}
					else{
                        toast('Sorry, something went wrong.');
					}
                },
				error: function (err) {
					if(err.status == 422){
					    toast('Status length should be between 5 & 1000 characters.')
					}
					else{
                        toast('Sorry, something went wrong.');
					}
                }
			});
        });

		function fetchPosts(offset, limit) {
            var data = {
                _token: '{{ csrf_token() }}',
				limit: limit,
				offset: offset
            };

            $.ajax({
                url: '/timeline/post/fetch',
                type: "POST",
                data: data,
                success: function (response) {
                    var posts = JSON.parse(response);

                    $.each(posts, function() {
						$('.post-container').append(makePost(this));
                    });
                },
                error: function (err) {
                    toast('Sorry, something went wrong.');
                }
            });
        }

        function makePost(post) {
			return "<div class='posts'>" +
				"<a href='/profile/"+post['reg_no']+"'class='author'>" +
				""+post['name']+"</a>" +
				"<div class='body'>"+post['text']+"</div>" +
				"<div class='actions'>" +
				"<a class='like' data-id='"+post['id']+"'> <i class='mdi mdi-18px mdi-thumb-up'></i> "+post['likes']+"</a> " +
				"<a class='comment' data-id='"+post['id']+"'> <i class='mdi mdi-18px mdi-comment'></i> "+post['comments']+"</a>" +
				"</div>" +
				"<div class='comments-container'></div> " +
				"</div>";
        }

	</script>
@endsection