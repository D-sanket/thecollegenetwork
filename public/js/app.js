

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
            toast('Sorry, something went wrong.');
        }
    });
}

var toastTimeout = null, toastTextTimeout = null;

function toast(msg) {
    $('.toast').html(msg).addClass('active');
    clearTimeout(toastTimeout);
    clearTimeout(toastTextTimeout);
    toastTimeout = setTimeout(function () {
        $('.toast').removeClass('active');

        toastTextTimeout = setTimeout(function () {
            $('.toast').html('');
        }, 550);
    }, 3000);
}

function loadStart(elem, small) {
    if(small) {
        elem.html($('.loader-container.hide.no-padding').clone().removeClass('hide')).addClass('full-flex');
    }
    else{
        elem.html($('.loader-container.hide.with-padding').clone().removeClass('hide')).addClass('full-flex');
    }
}

function loadStop(elem, callback){
    elem.find('.loader-container').addClass('fade');
    setTimeout(function () {elem.removeClass('full-flex');
        elem.find('.loader-container').remove();
        callback();
    }, 550);
}
