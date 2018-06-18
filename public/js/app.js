

function loadModal(title, url, data) {
    $("#myModal").modal();
    $(".modal-header > h4").html(title);
    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        success: function (response) {
            $(".modal-body").html(response);
        },
        error: function (err) {
            alert("Error : "+err.statusText);
        }
    });
}