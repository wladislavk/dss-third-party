
function display_content(){
  $('.content').hide();
  t = $('#contacttypeid option:selected').val();
  pt = $('#physician_types').val();
  pta = pt.split(',');
  if($.inArray(t, pta)!=-1){
    $('#salutation option[value="Dr."]').prop('selected', true)
    $('tr.content.physician').show();
  }else if(t==11){
    $('tr.content.insurance').show();
  }else if(t!=''){
    $('tr.content.other').show();
  }
}


$('#contacttypeid').change(function(){
  display_content();
}).change();

