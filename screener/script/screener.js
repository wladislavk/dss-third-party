
function submit_screener(){
  first_name = $('#first_name').val();
alert(first_name);













}


function next_sect(sect){
  $('.sect').hide();
  $('#sect'+sect).show();
}


$(document).ready( function(){
  next_sect(1);
});
