function delete_pending_letter(lid, type, rid, par){
    $.ajax({
        url: "includes/letter_delete.php",
        type: "post",
        data: {lid: lid, type: type, rid: rid, par: par},
        success: function(data){
            var r = $.parseJSON(data);
            if(!r.error){
				window.location.reload();
            }
        },
        failure: function(data){
        }
    });
}

$('.mailed_chk').click( function(){
  console.log('test');
  lid = $(this).val();
  c = $(this).is(':checked');
  $.ajax({
      url: "includes/letter_mail.php",
      type: "post",
      data: {lid: lid, mailed: c},
      success: function(data){
          var r = $.parseJSON(data);
      },
      failure: function(data){
      }
  });
});