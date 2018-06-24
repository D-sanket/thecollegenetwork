@extends('master')

@section('title', 'Timeline')

@section('content')

	<form class="panel panel-default poster">
		<textarea name="post_text" autocomplete="off" placeholder="Type something here.." class="post-text panel-body"></textarea>
		<div class="panel-footer post-footer">
			<div class="post-extras col-xs-10 col-sm-11">

			</div>
			<div class="post-actions col-xs-2 col-sm-1 text-center">
				<!--a class="post-action tag col-xs-6"><i class="mdi mdi-18px mdi-tag"></i> </a-->
				<a class="post-action post col-xs-12 text-center"><i class="mdi mdi-18px mdi-send"></i> </a>
			</div>
		</div>
	</form>

	<div class="post-container col-xs-12">

	</div>

	<script>

        var timeUpdateTimer = null;
        var postOffset = 0;
        var postLimit = 10;
        var scrollEnable = false;
        var scrollLimit = -window.innerHeight;
        var fetching = true;

        $(window).scroll(function() {
            var element = $('.posts').last();
            var top_of_element = element.offset().top;
            var bottom_of_element = element.offset().top + element.outerHeight();
            var bottom_of_screen = $(window).scrollTop() + window.innerHeight;
            var top_of_screen = $(window).scrollTop();

            if((bottom_of_screen > top_of_element + element.height()) && (top_of_screen < bottom_of_element)){
                if(!fetching){
                    //toast(postOffset);
                    fetching = true;
                    fetchPosts(postOffset, postLimit);
				}
            }
            else {
                // The element is not visible, do something else
            }
        });

        $(document).ready(function () {
            fetchPosts(0, 10);
            //scrollLimit += $('.poster').height();
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
                        if(response['message'] == ''){
                            $('.post-text').val('');
                            toast('Your status is live now.');
                            fetchOnePost(response['id']);
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

		function fetchOnePost(id) {
            var data = {
                _token: '{{ csrf_token() }}',
				id: id
            };
            $.ajax({
                url: '/timeline/post/fetch/'+id,
                type: "POST",
                data: data,
                beforeSend: function(){
                    loadStart($('.post-container').children().eq(0), true, 'prev');

                },
                success: function (response) {
					if(response == ''){

					}
					else{
					    var post = makePost(response);
                        loadStop($('.post-container').children().eq(0), function () {
							$(post).insertBefore($('.post-container').children().eq(0));
                            $('.post-container').append(makePost(this));
                            var e = $('.post-container').children().eq(0);
                            setTimeout(function () {
                                postOffset++;
                                scrollLimit = $('.post-container').height();
                                e.removeClass('scale-0');
                                setTimeUpdater();

                                $('.posts .delete').each(function () {
                                    $(this).click(function () {
                                        deletePost($(this).parents('.posts').attr('data-id'));
                                    });
                                });
                            }, 100);
                        }, 'prev');
					}
                },
                error: function (err) {
					toast('Sorry, something went wrong.');
                }
            });

        }

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
					loadStart($('.post-container'), false, 'next');
				},
                success: function (response) {
                    loadStop($('.post-container'), function () {
                        var obj = JSON.parse(response);

                        var message = obj['message'];
                        var posts = obj['data'];

                        if(message == 'no-more-posts'){
                            toast('No more posts.');
                            return;
						}

                        setTimeout(function () {
							fetching = false;
                        }, 1500);

                        $.each(posts, function(idx) {
                            postOffset++;
                            var newPost = makePost(this);

                            $('.post-container').append(newPost);
                            var e = $('.post-container').children().last();
                            setTimeout(function () {
                                e.removeClass('scale-0');

                                e.find('.actions .comment').each(function () {
                                    fetchComments($(this), 0, 2, function(commentElem, response){
                                        var comments = JSON.parse(response);

                                        $.each(comments, function() {
                                            commentElem.parents('.posts').find('.comments-container').append(makeComment(this));
                                            commentElem.parents('.posts').find('.comments-container').each(function (idx) {
                                                var e = $(this).children().last();
                                                setTimeout(function () {
                                                    e.removeClass('scale-0');
                                                    $('.comm .delete-comment').each(function () {
                                                        $(this).click(function () {
                                                            deleteComment($(this).parents('.comm').attr('data-id'));
                                                        });
                                                    });
                                                }, (idx+1)*100);
                                            });
                                        });
                                    });
                                });
                            }, (idx+1)*100);
                        });

                        $('.prev-comments').each(function () {
                            $(this).click(function () {
                                fetchPrevComments($(this));
                            });
                        });

                        $('.posts .delete').each(function () {
                            $(this).click(function () {
                                deletePost($(this).parents('.posts').attr('data-id'));
                            });
                        });

                        $('.actions .block').each(function () {
                            $(this).click(function () {
								var id = $(this).attr('data-id');
								var username = $(this).parents('.posts').find('.author').html();
								$.ajax({
									url: '/friends/block/'+id,
									type: "POST",
									data: { _token: "{{ csrf_token() }}" },
									success: function (response) {
										if(response == ''){
										    toast('You blocked '+username);
                                            postOffset = 0;
                                            postLimit = 10;
                                            $('.post-container').html('');
										    fetchPosts(0, 10);
										}
										else{
										    toast('Sorry, something went wrong.');
										}
									},
									error: function (err) {
										toast('Sorry, something went wrong.'+err.status);
									}
								});
                            });
                        });

                        $('.actions .unfriend').each(function () {
                            $(this).click(function () {
                                var id = $(this).attr('data-id');
                                var username = $(this).parents('.posts').find('.author').html();
                                $.ajax({
                                    url: '/friends/unfriend/'+id,
                                    type: "POST",
                                    data: { _token: "{{ csrf_token() }}" },
                                    success: function (response) {
                                        if(response == ''){
                                            toast('You are no longer friends with '+username);
                                            postOffset = 0;
                                            postLimit = 10;
                                            $('.post-container').html('');
                                            fetchPosts(0, 10);
                                        }
                                        else{
                                            toast('Sorry, something went wrong.');
                                        }
                                    },
                                    error: function (err) {
                                        toast('Sorry, something went wrong.'+err.status);
                                    }
                                });
                            });
                        });

                        $('.actions .like').each(function () {
                            $(this).click(function () {
                                var id = $(this).parents('.posts').attr('data-id');
                                like(id);
                            });
                        });

                        $('.posts .comment-box').each(function () {
                            $(this).keyup(function (e) {
                                if(e.keyCode == 13){
                                    comment($(this).parents('.posts'));
                                }
                            });
                        });
						setTimeUpdater();

                    }, 'next');

                },
                error: function (err) {
                    toast('Sorry, something went wrong.');
                }
            });
        }

        function setTimeUpdater() {

            clearInterval(timeUpdateTimer);

            timeUpdateTimer = setInterval(function () {
                $('.posts').each(function () {
                    fetchTime($(this));
                });
            }, 60000);
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

		function fetchPrevComments(elem) {
			var offset = elem.attr('data-offset');
			var limit = elem.attr('data-limit');

			//toast('Fetching '+limit+' comments from '+offset);

			fetchComments(elem.parents('.posts').find('.actions .comment'), offset, limit, function (commentElem, response) {
                var comments = JSON.parse(response);
                var count = 0;

                $.each(comments, function() {
					var self = this;
					if(count == 0) {
                        setTimeout(function () {
                            $(makeComment(self)).insertBefore(commentElem.parents('.posts').find('.comments-container').children().eq(0));
                            var e = commentElem.parents('.posts').find('.comments-container').children().first();

                            setTimeout(function () {
                                e.removeClass('scale-0');
                            }, 100);
                        }, 100);
					}
					else{
                        $(makeComment(self)).insertBefore(commentElem.parents('.posts').find('.comments-container').children().eq(0));
                        var e = commentElem.parents('.posts').find('.comments-container').children().first();
                        setTimeout(function () {
                            e.removeClass('scale-0');
                        }, 100);
					}
					count++;
                });

                elem.attr('data-offset', parseInt(elem.attr('data-offset')) + parseInt(elem.attr('data-limit')));

                if(count < 2){
                    toast('No more comments.');
                    elem.slideUp(300);
                    setTimeout(function () {
						elem.remove();
                    }, 300);
				}

            }, 'prev');
        }

        function fetchComments(commentElem, offset, limit, callback, type){
            var data = {
                _token: '{{ csrf_token() }}',
                id: commentElem.parents('.posts').attr('data-id'),
				offset: offset == undefined ? 0 : offset,
				limit: limit == undefined ? 2 : limit
            };

            loadStart(commentElem.parents('.posts').find('.comments-container'), undefined, type);

            $.ajax({
                url: '/timeline/post/fetch/comments',
                type: "POST",
                data: data,
                success: function (response){
                    loadStop(commentElem.parents('.posts').find('.comments-container'), function () {
                        callback(commentElem, response);
                    }, type);
                },
                error: function (err) {
                    loadStop(commentElem.parents('.posts').find('.comments-container'), function(){
                        toast('Sorry, something went wrong.'+err.status);
                    }, type);
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
                            $('.comm .delete-comment').each(function () {
                                $(this).click(function () {
                                    deleteComment($(this).parents('.comm').attr('data-id'));
                                });
                            });
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

        function like(id) {
            var data = {
                _token: '{{ csrf_token() }}',
                id: id,
            };

            $.ajax({
                url: '/timeline/post/like',
                type: "POST",
                data: data,
                success: function (response){
                    if(response ==  'error'){
                        toast('Sorry, something went wrong.');
                    }
                    else{
                        toast(response);
                        var likeCountElem = $('.posts[data-id='+id+']').find('.actions .like .count');
						 if(response == 'Liked')
                             likeCountElem.html(parseInt(likeCountElem.html())+1);
						 else
                             likeCountElem.html(parseInt(likeCountElem.html())-1);
                    }
                },
                error: function (err) {
					toast('Sorry, something went wrong.'+err.status);
                }
            });
        }

        function deletePost(id) {
            var data = {
                _token: '{{ csrf_token() }}',
                id: id,
            };

            $.ajax({
                url: '/timeline/post/delete',
                type: "POST",
                data: data,
                success: function (response){
                    if(response ==  'error'){
                        toast('Sorry, something went wrong.');
                    }
                    else{
                        $('.posts[data-id='+id+']').addClass('scale-0');

                        setTimeout(function () {
                            $('.posts[data-id='+id+']').remove();
                        }, 350);
                    }
                },
                error: function (err) {
                    toast('Sorry, something went wrong.'+err.status);
                }
            });
        }

        function deleteComment(id) {
            var data = {
                _token: '{{ csrf_token() }}',
                id: id,
            };

            $.ajax({
                url: '/timeline/post/deletecomment',
                type: "POST",
                data: data,
                success: function (response){
                    if(response ==  'error'){
                        toast('Sorry, something went wrong.');
                    }
                    else{
                        $('.comm[data-id='+id+']').addClass('scale-0');
                        setTimeout(function () {
                            var count = $('.comm[data-id='+id+']').parents('.posts').find('.comment .count');
                            count.html(parseInt(count.html())-1);
                            $('.comm[data-id='+id+']').remove();
                        }, 350);
                    }
                },
                error: function (err) {
                    //toast('Sorry, something went wrong.'+err.status);
                }
            });
        }

        function makePost(post) {
            return "<div class='posts col-xs-12 scale-0' data-id='"+post['id']+"'>" +
						"<div class='hidden-xs col-sm-2 dp-container'>" +
							"<img src='"+post['dp']+"' class='img-circle img-responsive'>"+
						"</div> " +
						"<div class='col-xs-12 col-sm-10'> " +
							"<div class='main col-xs-12'>" +
								"<div class='head'>" +
									"<a href='/profile/"+post['reg_no']+"'class='author'>" +post['name']+"</a> " +
									"<span class='lighter'> posted an update</span> " +
									"<span class='pull-right lighter time'> &nbsp;"+post['updated_at']+"</span> "+
									((post['delete'] === 'no') ? '' : "<a class='pull-right delete'> <i class='mdi mdi-18px mdi-delete'></i> · </a> · ")+
								"</div>" +
							"<div class='body'>"+post['text']+"</div>" +
							"<div class='actions'>" +
								"<a class='like col-xs-3 col-sm-2' data-id='"+post['id']+"'> " +
									"<span class='count'>"+post['likes']+"</span>" +
                					" <i class='mdi mdi-18px mdi-thumb-up'></i> " +
								"</a> " +
								"<a class='comment col-xs-3 col-sm-2' data-id='"+post['id']+"'> " +
									"<span class='count'>"+post['comments']+"</span>" +
                					" <i class='mdi mdi-18px mdi-comment'></i> " +
								"</a>" +
								((post['block'] === 'no') ? '' :
												"<a class='block col-xs-3 col-sm-2' data-id='"+post['block']+"'> " +
													"<i class='mdi mdi-18px mdi-account-off'></i>" +
												"</a>" )+
                				((post['unfriend'] === 'no') ? '' : "<a class='unfriend col-xs-3 col-sm-2' data-id='"+post['unfriend']+"'> " +
									"<i class='mdi mdi-18px mdi-account-minus'></i>" +
								"</a>" )+
							"</div>" +
						"</div>" +
                		(post['comments'] > 2 ? "<div class='col-xs-12 col-xs-offset-1 prev-comments full-flex' data-offset='2' data-limit='2'><a>View previous comments</a></div> " : '') +
						"<div class='col-xs-12 comments-container'></div> " +
							"<div class='comment-box-holder col-xs-12'>" +
								"<input type='text' class='form-control comment-box' placeholder='Type your comment here..'>" +
							"</div>" +
						"</div>" +
					"</div>";
        }

        function makeComment(obj) {
			return "<div class='col-xs-12 scale-0 comm' data-id='"+obj['id']+"'>" +
						"<div class='hidden-xs col-sm-2 comment-dp-container'>" +
			                "<img src='"+obj['dp']+"' class='img-circle img-responsive'>"+
						"</div> " +
						"<div class='col-xs-12 col-sm-10'> " +
							"<div class='comment1'>" +
							"	<div class='comment1-header'>" +
							"		<a href='/profile/"+obj['user_reg_no']+"'>"+obj['user_name']+"</a>" +
							"		·&nbsp;<span class='pull-right comment-time lighter'>"+obj['time']+"</span>" +
							(obj['delete'] === 'no' ? '' : "<a class='pull-right delete-comment'><i class='mdi mdi-18px mdi-delete'></i>&nbsp;</a>" )+
							"	</div>" +
							"	<div class='comment-text'> "+obj['text']+"</div>" +
							"</div>" +
						"</div>" +
					"</div>";
        }


	</script>
@endsection