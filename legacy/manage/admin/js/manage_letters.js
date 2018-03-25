$('.mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    
    $.ajax({
        url: "../includes/letter_mail.php",
        type: "post",
        data: {lid: lid, mailed: c},
        success: function(data){
            var r = $.parseJSON(data);
            if(r.error){
            }else{
                //window.location.reload();
            }
        },
        failure: function(data){
            //alert('fail');
        }
    });
});