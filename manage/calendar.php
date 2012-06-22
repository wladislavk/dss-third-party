<?php 
//session_start();
//require_once 'admin/includes/config.php';

include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
?>
	<script src="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js' type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" media="screen" title="no title" charset="utf-8">
<div style="clear: both">
<span class="admin_head">
	Calendar
</span>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<script type="text/javascript" charset="utf-8">
	function initCal() {
		scheduler.config.multi_day = true;
		scheduler.config.xml_date="%Y-%m-%d %h:%i %A";
		scheduler.config.hour_date="%h:%i%A";
		scheduler.config.scroll_hour = 8;
		scheduler.locale.labels.workweek_tab = "W-Week"
		scheduler.attachEvent("onTemplatesReady",function(){
			//work week
			scheduler.date.workweek_start = scheduler.date.week_start;
			scheduler.templates.workweek_date = scheduler.templates.week_date;
			scheduler.templates.workweek_scale_date = scheduler.templates.week_scale_date;
			scheduler.date.add_workweek=function(date,inc){ return scheduler.date.add(date,inc*7,"day"); }
			scheduler.date.get_workweek_end=function(date){ return scheduler.date.add(date,5,"day"); }
			
		});
                scheduler.init('scheduler_here',null,"workweek");

		<?php
		$sql = "SELECT * from dental_calendar WHERE docid='".$_SESSION['docid']."'";
		$q = mysql_query($sql);
		while($r = mysql_fetch_assoc($q)){
			?>scheduler.addEvent({
				start_date: "<?= date('d-m-Y H:i', strtotime($r['start_date'])); ?>",
				end_date: "<?= date('d-m-Y H:i', strtotime($r['end_date'])); ?>",
				text: "<?= $r['description']; ?>",
				id: "<?= $r['event_id']; ?>",
				table_id: "<?= $r['id']; ?>"
			});<?php
		}
		?>
		//scheduler.load("../common/events2010.xml");
		scheduler.attachEvent("onEventAdded", function(event_id,event_object){
		    var sd = event_object.start_date;
			sd = sd.getFullYear()+'-'+(sd.getMonth()+1)+'-'+sd.getDate()+' '+sd.getHours()+':'+sd.getMinutes();
		    var ed = event_object.end_date;
			ed = ed.getFullYear()+'-'+(ed.getMonth()+1)+'-'+ed.getDate()+' '+ed.getHours()+':'+ed.getMinutes();
		    var de = event_object.text;
		    var e_id = event_id;
                                  $.ajax({
                                        url: "includes/calendar_add_event.php",
                                        type: "post",
                                        data: {id: e_id, start_date: sd, end_date: ed, description: de},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

                    //any custom logic here
          	});		
                scheduler.attachEvent("onEventChanged", function(event_id,event_object){
                    var sd = event_object.start_date;
                        sd = sd.getFullYear()+'-'+(sd.getMonth()+1)+'-'+sd.getDate()+' '+sd.getHours()+':'+sd.getMinutes();
                    var ed = event_object.end_date;
                        ed = ed.getFullYear()+'-'+(ed.getMonth()+1)+'-'+ed.getDate()+' '+ed.getHours()+':'+ed.getMinutes();
                    var de = event_object.text;
		    var t_id = event_object.table_id
                    var e_id = event_id;
                                  $.ajax({
                                        url: "includes/calendar_update_event.php",
                                        type: "post",
                                        data: {e_id: e_id, t_id: t_id, start_date: sd, end_date: ed, description: de},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

                    //any custom logic here
                }); 
                scheduler.attachEvent("onEventDeleted", function(event_id,event_object){
                    var e_id = event_id;
                                  $.ajax({
                                        url: "includes/calendar_delete_event.php",
                                        type: "post",
                                        data: {e_id: e_id},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

                    //any custom logic here
                });
	}

function show_minical(){
      if (scheduler.isCalendarVisible())
         scheduler.destroyCalendar();
      else
         scheduler.renderCalendar({
            position:"dhx_minical_icon",
            date:scheduler._date,
            navigation:true,
            handler:function(date,calendar){
               scheduler.setCurrentView(date);
               scheduler.destroyCalendar()
            }
         });
   }
$(document).ready(function(){
  initCal();
});
</script>

	<div id="scheduler_here" class="dhx_cal_container" style='width:960px; height:600px; margin-left:10px;'>
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>
			<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
			<div class="dhx_cal_tab" name="workweek_tab" style="right:270px;"></div>
			<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>
	</div>

<div style="clear:both;"></div>
<br /><br />	
<? include "includes/bottom.htm";?>
