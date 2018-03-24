function sign_notes(){
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
            if(r.error){
            }else{
                $('.sign_chbx:checked').each(function(){
                    id = $(this).val();
                    $('#note_'+id).css('backgroundColor', '');
                    $('#note_edit_'+id).remove();
                });
            }
        },
        failure: function(data){
            //alert('fail');
        }
    });
}