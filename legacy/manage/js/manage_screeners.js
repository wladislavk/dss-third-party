$('.contact_chbx').click(function(){
  c = ($(this).is(':checked'))?1:0;
  id = $(this).val();
  
  $.ajax({
    url: "includes/screener_contact.php",
    type: "post",
    data: {id: id, c: c},
    success: function(data){
          var r = $.parseJSON(data);

          if (r.error) {
          } else {
          }
    }
  });
});