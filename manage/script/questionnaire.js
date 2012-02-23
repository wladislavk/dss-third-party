function updateQuestionnaire(table, pid, field, val){
  $.ajax({
    url: 'includes/updateQuestionnaire.php',
    type: 'post',
    data: 'table='+table+'&field='+field+'&pid='+pid+'&val='+val,
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){
	  $('#'+field).val(val);
	  $('#'+field).removeClass('edits');
	  $('#patient_'+field).html('Updated');
	  $('#patient_'+field).delay(2000).hide(1000);	
        }else{
	  alert('error');
        }
    }
  });

}
