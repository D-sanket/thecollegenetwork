@extends('master')

@section('title', 'Friends')

@section('content')
	<form class="">
		<div class="form-group">
			<label class="sr-only" for="search">Find friends</label>
			<div class="input-group">
				<div class="input-group-addon"><i class="mdi mdi-account-search-outline mdi-18px"></i> </div>
				<input autocomplete="off" type="text" class="form-control" id="search" placeholder="name or registration number..">
			</div>
		</div>

	</form>

	<div class="panel panel-default">
		<div class="panel-heading"> Search results </div>
		<div class="panel-body results">

		</div>
	</div>

		@include('includes.friends.base', ['panel_title' => "Suggested friends", 'users' => Illuminate\Support\Facades\Auth::user()->getSuggestions()])
		@include('includes.friends.base', ['panel_title' => "Friend requests", 'users' => Illuminate\Support\Facades\Auth::user()->friendRequests()])
		@include('includes.friends.base', ['panel_title' => "Friends", 'users' => Illuminate\Support\Facades\Auth::user()->friends()])
		@include('includes.friends.base', ['panel_title' => "Sent requests", 'users' => Illuminate\Support\Facades\Auth::user()->sentRequests()])


<script>

    cancellify();
	friendify();
	unfriendify();
	rejectify();
	acceptify();

	var timeout = null;

	$('#search').keyup(function () {
	    $('.results').html('Searching..');
	    clearTimeout(timeout);
	    if($('#search').val().length > 0) {
            timeout = setTimeout(function () {
                fetchResults($('#search').val());
            }, 500);
        }
        else{
            $('.results').html('');
		}
    });

	function fetchResults(q) {
	    var data = {};
        data._token = "{{ csrf_token() }}";
        data.q = q;
        $.ajax({
            url: '/friends/search',
            type: "POST",
            data: data,
            success: function (response) {
                var links = response.split(',');
                $('.results').html(links);
            },
            error: function (err) {

            }
        });
    }

    function friendify() {
        $('.action.add-friend').each(function () {
            var self = $(this);
            AJAXify(self, '/friends/add/'+self.attr('data-id'), {}, function (response) {
                if(response == ''){
                    self.html("Cancel request <i class='mdi mdi-18px mdi-account-remove'></i>").removeClass('add-friend').addClass('cancel');
					 cancellify();
                }
            });
        });
    }

    function cancellify() {
        $('.action.cancel').each(function () {
            var self = $(this);
            AJAXify(self, '/friends/cancel/'+self.attr('data-id'), {}, function (response) {
                if(response == ''){
                    self.html("Add friend <i class='mdi mdi-18px mdi-account-plus'></i>").removeClass('cancel').addClass('add-friend');
					friendify();
                }
            });
        });
    }

    function unfriendify() {
        $('.action.unfriend').each(function () {
            var self = $(this);
            AJAXify(self, '/friends/unfriend/'+self.attr('data-id'), {}, function (response) {
                if(response == ''){
                    self.html("Add friend <i class='mdi mdi-18px mdi-account-plus'></i>").removeClass('unfriend').addClass('add-friend');
                    friendify();
                }
            });
        });
    }

    function rejectify() {
        $('.action.reject').each(function () {
            var self = $(this);
            AJAXify(self, '/friends/reject/'+self.attr('data-id'), {}, function (response) {
                if(response == ''){
                    self.html("Add friend <i class='mdi mdi-18px mdi-account-plus'></i>").removeClass('reject').addClass('add-friend');
                    friendify();
                    self.parent().find('.accept').remove();
                }
            });
        });
    }

    function acceptify() {
        $('.action.accept').each(function () {
            var self = $(this);
            AJAXify(self, '/friends/accept/'+self.attr('data-id'), {}, function (response) {
                if(response == ''){
                    self.html("Unfriend <i class='mdi mdi-18px mdi-account-minus'></i>").removeClass('add-friend').addClass('unfriend');
                    unfriendify();
                    self.parent().find('.reject').remove();
                }
            });
        });
    }




	function AJAXify(elem, url, data, callback) {
		data._token = "{{ csrf_token() }}";
		elem.click(function () {
			$.ajax({
				url: url,
				type: "POST",
				data: data,
				success: function (response) {
					callback(response);
				},
				error: function (err) {

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