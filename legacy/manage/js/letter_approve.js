function reload_parent()
{
    parent.disablePopup();
}

function send_letter(id, reload, page)
{
    $.ajax({
        url: "includes/letter_send.php",
        type: "post",
        data: {id: id},
        success: function(data){
            if (!reload) {
                parent.window.location = page;
            } else {
                parent.window.location.href = parent.window.location.protocol + '//' +
                    parent.window.location.host +
                    parent.window.location.pathname +
                    parent.window.location.search;
            }
        },
        failure: function(data){
            //alert('fail');
        }
    });
}