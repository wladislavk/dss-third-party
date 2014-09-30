function updateField(f, v){
  if(v=='doc'){
    $('#doc_'+f).addClass('selected');
    $('#pat_'+f).removeClass('selected');
    $('#doc_'+f+'_extra').addClass('selected');
    $('#pat_'+f+'_extra').removeClass('selected');
    $('#value_'+f).val($('#doc_'+f).val());
  }else if(v=='pat'){
    $('#pat_'+f).addClass('selected');
    $('#doc_'+f).removeClass('selected');
    $('#pat_'+f+'_extra').addClass('selected');
    $('#doc_'+f+'_extra').removeClass('selected');
    $('#value_'+f).val($('#pat_'+f).val());
  }
    $('#accepted_'+f).val(v);
}

function updateAll(v){
  $('.change_row').each(function(){
    $(this).find('.doc_field').removeClass('selected');
    $(this).find('.pat_field').removeClass('selected');
    $(this).find('.doc_field_extra').removeClass('selected');
    $(this).find('.pat_field_extra').removeClass('selected');
    $(this).find('.'+v+'_field').addClass('selected');
    $(this).find('.'+v+'_field_extra').addClass('selected');
    val = $(this).find('.'+v+'_field').val();
    $(this).find('.value').val(val);
    $(this).find('.accepted').val(v);
  });
}