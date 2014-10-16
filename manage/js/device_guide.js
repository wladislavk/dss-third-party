$('.imp_chk').click( function(){
	if($(this).is(':checked')){
		if($('.imp_chk:checked').length > 3){
		  $(this).prop("checked", false);
		}
	}
});

$('.device_submit').click(function(){
	$.ajax({
		url: "device_guide_results.php",
		type: "post",
		data: $('#device_form').serialize(),
		success: function(data){
			$('#results li').remove();
		  	var r = $.parseJSON(data);
			$.each( r,  function(i, v){
				if(v.image_path!=''){
					$('#results').append("<li class='box_go'><div class='ico'><img src='"+v.image_path+"' /></div><a href='#' onclick=\"update_device("+v.id+", '"+v.name+"');return false();\">"+v['name']+" ("+ v.value +")</a></li>");
				} else {
		      		$('#results').append("<li><a href='#' onclick=\"update_device("+v.id+", '"+v.name+"');return false();\">"+v['name']+" ("+ v.value +")</a></li>");
				}
			});

			if(r.error){
			} else {
			}
		},
		failure: function(data){
		  //alert('fail');
		}
	});
});

function reset_form()
{
    $(".setting").each(function(){
    	$(this).find(".slider").slider("value", $(this).find(".slider").slider("option", "min") );
    	$(this).find(".label").html( $(this).find('.label').attr('data-init'));
        $(this).find(".imp_chk").prop("checked", false);
    });

    $('#results li').remove();
}

function update_device(device, name)
{
	if(valId && valPid) {
	  if(confirm("Do you want to select " + name + " for " + firstname + " " + lastname)){
	    $.ajax({
	      url: "flow_device_update.php",
	      type: "post",
	      data: {id: valId, device: device, pid: valPid},
	      success: function(data){
	        var r = $.parseJSON(data);
	        if(r.error){
	        }else{
				parent.updateDentalDevice(valId, device)
				parent.disablePopupClean();
	        }
	      },
	      failure: function(data){
	        //alert('fail');
	      }
	    });
	  }
	}
}

function setSlider(labelArr, id, range_start, range_end, range_step) {
	var labelArr = labelArr.split(',');

	$( "#slider_" + id ).slider({
		value: range_start,
		min: range_start,
		max: range_end,
		step: range_step,
		slide: function( event, ui ) {
		  $( "#input_opt_" + id ).val( ui.value );
		  $("#label_" + id).html(labelArr[ui.value]);
		  $('#results li').remove();
		}
	});

	$( "#input_opt_" + id ).val($( "#slider_" + id ).slider( "value" ) );
	$("#label_" + id).html(labelArr[$( "#slider_" + id ).slider( "value" )]);
	$("#label_" + id).attr('data-init', labelArr[$( "#slider_" + id ).slider( "value" )]);
};