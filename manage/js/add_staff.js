$('#producer').click(function(){
  if($(this).is(':checked')){
    $('.producer_field').show();
    if($('#producer_files').is(':checked')){
      $('.files_field').show();
    }
  }else{
    $('.producer_field').hide();
    $('.files_field').hide();
  }
});

$('#producer_files').click(function(){
  if($(this).is(':checked')){
    $('.files_field').show();
  }else{
    $('.files_field').hide();
  }
});

$(document).ready( function(){
  if($('#producer').is(':checked')){
    $('.producer_field').show();
    if($('#producer_files').is(':checked')){
      $('.files_field').show();
    }else{
      $('.files_field').hide();
    }
  }else{
    $('.producer_field').hide();
    $('.files_field').hide();
  }
});

function confirm_delete(logins)
{
  d = confirm('Are you sure you want to delete?');
  if(!d) {
    return false;
  }

  if(logins > 0) {
    alert('This user has previously accessed your software. In order to store a record of their activity this user will be marked as INACTIVE. INACTIVE users cannot access your software.');
  }
  return d;
}