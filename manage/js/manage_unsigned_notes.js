$(document).ready(function(){
    $(".patient_header").bind("mousemove", function(event) {
        $(this).find("div.tooltip").css({
            top: event.pageY + 10 + "px",
            left: event.pageX + 5 + "px"
        }).show();
    }).bind("mouseout", function() {
        $("div.tooltip").hide();
    });
});

function sign_notes(pid) {
    if(!confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?')){
        return false;
    }
    sign_arr = new Array();
    i=0;

    $('.sign_chbx:checked').each(function(){
        sign_arr[i++] = $(this).val();
    });

    $.ajax({
        url: "includes/sign_notes.php",
        type: "post",
        data: {ids: sign_arr.join(',')},
        success: function(data){
                var r = $.parseJSON(data);
                if(r.error) {
                } else {
                    $('.sign_chbx:checked').each(function(){
                        id = $(this).val();
                        $('#note_'+id).remove();
                    });
                }
        }
    });
}