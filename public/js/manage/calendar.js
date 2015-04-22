
$(document).ready( function(){
  $('input.calendar').each(function(){
	var cid = $(this).attr("id");
	if(cid){
		Calendar.setup({
        		inputField : cid,
        		trigger    : cid,
			fdow	   : 0,
			align	   : "Bl////",
        		onSelect   : function() { this.hide() },
        		dateFormat : "%m/%d/%Y"
      		});
	}

  });
  $('input.calendar_top').each(function(){
        var cid = $(this).attr("id");
        if(cid){
                Calendar.setup({
                        inputField : cid,
                        trigger    : cid,
                        fdow       : 0,
                        align      : "T////",
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


  $('input.calendar_device_date').each(function(){
        var cid = $(this).attr("id");
        if(cid){
                Calendar.setup({
                        inputField : cid,
                        trigger    : cid,
                        fdow       : 0,
                        align      : "Bl///T/",
                        onSelect   : function() { this.hide(); update_dental_device_date(cid); },
                        dateFormat : "%m/%d/%Y"
                });
        }


  });

  //hack to force calendar on tabbing
  $('input.calendar').focus(function(){
    $(this).click();
  });

});

