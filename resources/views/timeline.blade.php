@extends('master')

@section('title', 'Timeline')

@section('content')

	<form class="panel panel-default">
		<textarea name="post_text" autocomplete="off" placeholder="Type something here.." class="post-text panel-body"></textarea>
		<div class="panel-footer post-footer">
			<div class="post-extras col-xs-10">

			</div>
			<div class="post-actions col-xs-4 text-center">
				<a class="post-action tag col-xs-6"><i class="mdi mdi-18px mdi-tag"></i> </a>
				<a class="post-action post col-xs-6"><i class="mdi mdi-18px mdi-send"></i> </a>
			</div>
		</div>
	</form>

	<div class="post-container">

	</div>

	<script>

        var timeUpdateTimer = null;

        $(document).ready(function () {
            fetchPosts(0, 10);
        });

		$('.post-action.post').click(function () {
			var data = {
			    _token: '{{ csrf_token() }}',
				text: $('.post-text').val()
			};

			var p = $('.post-action.post').html();

			$.ajax({
				url: '/timeline/post/submit',
				type: "POST",
				data: data,
				beforeSend: function(){
				    loadStart($('.post-action.post'), true);
                    $('.post-action.post').find('.loader-container').addClass('scale')
				},
				success: function (response) {
					loadStop($('.post-action.post'), function () {
						$('.post-action.post').html(p);
                        if(response == ''){
                            $('.post-text').val('');
                            toast('Your status is live now.');
                        }
                        else{
                            toast('Sorry, something went wrong.');
                        }
                    });
                },
				error: function (err) {
                    $('.post-action.post').html(p);
					if(err.status == 422){
					    toast('Status length must be between 5 & 1000 characters.')
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
				beforeSend: function(){
					loadStart($('.post-container'));
				},
                success: function (response) {
                    loadStop($('.post-container'), function () {
                        var posts = JSON.parse(response);

                        $.each(posts, function(idx) {
                            $('.post-container').append(makePost(this));
                            var e = $('.post-container').children().last();
                            setTimeout(function () {
                                e.removeClass('scale-0');
                            }, idx*100);
                        });

                        $('.actions .comment').each(function () {
                            fetchComments($(this));
                        });

                        $('.posts .comment-box').each(function () {
                            $(this).keyup(function (e) {
                                if(e.keyCode == 13){
                                    comment($(this).parents('.posts'));
                                }
                            });
                        });

                        clearInterval(timeUpdateTimer);

                        timeUpdateTimer = setInterval(function () {
                            $('.posts').each(function () {
                                fetchTime($(this));
                            });
                        }, 60000);
                    });
                },
                error: function (err) {
                    toast('Sorry, something went wrong.');
                }
            });
        }



        function fetchTime(postElem){
            var data = {
                _token: '{{ csrf_token() }}',
                id: postElem.attr('data-id')
            };
            $.ajax({
                url: '/timeline/post/fetch/time',
                type: "POST",
                data: data,
                success: function (response){
                    postElem.find('.time').html(response);
                },
                error: function (err) {
                    toast('Sorry, something went wrong.');
                }
            });
		}

        function fetchComments(commentElem){
            var data = {
                _token: '{{ csrf_token() }}',
                id: commentElem.parents('.posts').attr('data-id')
            };

            loadStart(commentElem.parents('.posts').find('.comments-container'));

            $.ajax({
                url: '/timeline/post/fetch/comments',
                type: "POST",
                data: data,
                success: function (response){
                    loadStop(commentElem.parents('.posts').find('.comments-container'), function () {
                        var comments = JSON.parse(response);

                        $.each(comments, function() {
                            commentElem.parents('.posts').find('.comments-container').append(makeComment(this));
                            commentElem.parents('.posts').find('.comments-container').each(function (idx) {
                                var e = $(this).children().last();
                                setTimeout(function () {
                                    e.removeClass('scale-0');
                                }, (idx+1)*100);
                            });
                        });
                    });
                },
                error: function (err) {
                    loadStop(commentElem.parents('.posts').find('.comments-container'), function(){
                        toast('Sorry, something went wrong.'+err.status);
                    });
                }
            });
        }

        function comment(postElem) {
            var data = {
                _token: '{{ csrf_token() }}',
                id: postElem.attr('data-id'),
				text: postElem.find('.comment-box').val()
			};

            $.ajax({
                url: '/timeline/post/comment',
                type: "POST",
                data: data,
                success: function (response){
                    if(response['message'] ==  'error'){
                        toast('Sorry, something went wrong.');
					}
					else{
                        var countElem = postElem.find('.actions .comment .count');
                        countElem.html(parseInt(countElem.html())+1);
                        postElem.find('.comment-box').val('');
                        postElem.find('.comments-container').append(makeComment(response));

                        var e = postElem.find('.comments-container').children().last();
                        setTimeout(function () {
                            e.removeClass('scale-0');
                        }, 100);
					}
                },
                error: function (err) {
                    if(err.status == 422)
                        toast('Comment length must be between 1 & 1000 characters.');
                    else
	                    toast('Sorry, something went wrong.'+err.status);
                }
            });

        }

        function makePost(post) {
            return "<div class='posts col-xs-12 scale-0' data-id='"+post['id']+"'>" +
						"<div class='col-xs-2 dp-container'>" +
							"<img src='"+post['dp']+"' class='img-circle img-responsive'>"+
						"</div> " +
						"<div class='col-xs-10'> " +
							"<div class='main col-xs-12'>" +
								"<div class='head'>" +
									"<a href='/profile/"+post['reg_no']+"'class='author'>" +post['name']+"</a> " +
									"<span class='lighter'> posted an update</span> " +
									"<span class='pull-right lighter time'>"+post['updated_at']+"</span> " +
								"</div>" +
							"<div class='body'>"+post['text']+"</div>" +
							"<div class='actions'>" +
								"<a class='like' data-id='"+post['id']+"'> " +
									"<i class='mdi mdi-18px mdi-thumb-up'></i> " +
									"<span class='count'>"+post['likes']+"</span>" +
								"</a> " +
								"<a class='comment' data-id='"+post['id']+"'> " +
									"<i class='mdi mdi-18px mdi-comment'></i> " +
									"<span class='count'>"+post['comments']+"</span>" +
								"</a>" +
							"</div>" +
						"</div>" +
						"<div class='col-xs-12 col-xs-offset-1 prev-comments full-flex'><a>View previous comments</a></div> " +
						"<div class='col-xs-12 comments-container'></div> " +
							"<div class='comment-box-holder col-xs-12'>" +
								"<input type='text' class='form-control comment-box' placeholder='Type your comment here..'>" +
							"</div>" +
						"</div>" +
					"</div>";
        }

        function makeComment(obj) {
			return "<div class='col-xs-12 scale-0 comm'>" +
						"<div class='col-xs-2 comment-dp-container'>" +
			                "<img src='"+obj['dp']+"' class='img-circle img-responsive'>"+
						"</div> " +
						"<div class='col-xs-10'> " +
							"<div class='comment1'>" +
							"	<div class='comment1-header'>" +
							"		<a href='/profile/"+obj['user_reg_no']+"'>"+obj['user_name']+"</a>" +
							"		<span class='pull-right comment-time lighter'>"+obj['time']+"</span>" +
							"	</div>" +
							"	<div class='comment-text'> "+obj['text']+"</div>" +
							"</div>" +
						"</div>" +
					"</div>";
        }


	</script>
@endsection