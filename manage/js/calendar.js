
$(document).ready( function(){
  $('input.calendar').each(function(){
	var cid = $(this).attr("id");
	if(cid){
		Calendar.setup({
        		inputField : cid,
        		trigger    : cid,
			fdow	   : 0,
        		onSelect   : function() { this.hide() },
        		dateFormat : "%m/%d/%Y"
      		});
	}


  });

});
