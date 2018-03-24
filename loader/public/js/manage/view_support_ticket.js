function add_attachment(){
  var blank = $(".addattachment").filter(function() {
    return !this.value;
  }).length;
  if(blank > 0){
    alert('Please attach another file with the "Browse" button before adding another.');
    return false;
  }

  if($('.addattachment').length<3){  
    $('#attachments').append('<span><input type="file" name="attachment[]" id="attachment1" class="addattachment" style="height:auto;width:auto;" /> <a href="#" onclick="$(this).parent().remove();$(\'#add_attachment_but\').show();return false;">Remove</a></span>');
  }
  if($('.addattachment').length==3){
    $('#add_attachment_but').hide();
  }
}