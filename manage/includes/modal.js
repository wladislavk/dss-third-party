$(document).ready(function(){

$(".info_modal").dialog({
  resizable: true,
  autoOpen:false,
  modal: true,
  width:400,
  height:200,
  buttons: {
    'Close': function() {
      $(this).dialog('close');
    } // end continue button
  }//end buttons

});//end dialog


$('.info_but').click(function(){
  id = $(this).attr('id');
  $('#'+id+"_modal").dialog('open');
});

}); //end ready event


