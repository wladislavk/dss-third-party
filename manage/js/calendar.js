
$(document).ready( function(){
  $('input.calendar').each(function(){
	var cid = $(this).attr("id");
	if(cid){
		Calendar.setup({
        		inputField : cid,
        		trigger    : cid,
			fdow	   : 0,
			align	   : "Bl///T/",
        		onSelect   : function() { this.hide() },
        		dateFormat : "%m/%d/%Y"
      		});
	}


  });

  $('input.flow_next_calendar').each(function(){
        var cid = $(this).attr("id");
        if(cid){
                Calendar.setup({
                        inputField : cid,
                        trigger    : cid,
                        fdow       : 0,
                        align      : "Bl///T/",
                        onSelect   : function() { this.hide(); update_next_sched(cid); },
                        dateFormat : "%m/%d/%Y"
                });
        }


  });

  $('input.flow_comp_calendar').each(function(){
        var cid = $(this).attr("id");
        if(cid){
                Calendar.setup({
                        inputField : cid,
                        trigger    : cid,
                        fdow       : 0,
                        align      : "Bl///T/",
                        onSelect   : function() { this.hide(); update_completed_date(cid); },
                        dateFormat : "%m/%d/%Y"
                });
        }


  });

  $('input.flow_device_calendar').each(function(){
        var cid = $(this).attr("id");
        if(cid){
                Calendar.setup({
                        inputField : cid,
                        trigger    : cid,
                        fdow       : 0,
                        align      : "Bl///T/",
                        onSelect   : function() { this.hide(); update_device_date(cid); },
                        dateFormat : "%m/%d/%Y"
                });
        }


  });


});

