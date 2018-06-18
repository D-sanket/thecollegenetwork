<div class="">
	<img id="preview" src="{{ asset('images/defaultcover.jpg') }}" class="img-responsive img-thumbnail">
</div>
<form id="upload-form" method="post" onsubmit="event.preventDefault()">
	<br/>
	<div class="form-group">
		<label for="file">Select file to upload </label>
		<input class="form-control-file" type="file" name="file" id="file">
	</div>
	@csrf
	<input type="submit" id="upload-btn" class="btn btn-primary" name="submit" value="Upload">
</form>

<script>
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
            },
            error: function(data){
                alert('Error');
            },
		});
    });
</script>