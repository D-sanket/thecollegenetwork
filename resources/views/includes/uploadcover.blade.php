<div class="">
	<img id="preview" src="{{ asset('images/defaultcover.jpg') }}" class="img-responsive img-thumbnail">
</div>
<form id="upload-form" enctype="multipart/form-data" method="post" onsubmit="event.preventDefault()">
	<br/>
	<div class="form-group">
		<label for="file">Select file to upload </label>
		<input class="form-control-file" type="file" name="file" id="file">
	</div>
	@csrf
	<input type="submit" id="upload-btn" class="btn btn-primary" name="submit" value="Upload">
	<br/><br/>
	<div class="alert alert-danger upload-form-error">
		Something went wrong.
	</div>
</form>

<script>
	$('.upload-form-error').slideUp(0);

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#file").change(function() {
        readURL(this);
    });

	$("#upload-btn").click(function (){
		$.ajax({
			url: '/profile/upload/cover/up',
			type: "POST",
			data: new FormData($("#upload-form")[0]),
			cache:false,
			contentType: false,
			processData: false,
			success:function(response){
                $(".cover > img").attr('src', response);
                $('.modal').modal('hide');
            },
            error: function(err){
                $('.upload-form-error').slideDown(300, function () {
					setTimeout(function () {
                        $('.upload-form-error').slideUp(300);
                    }, 3000);
                });
            },
		});
    });
</script>