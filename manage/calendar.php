<?php 
//session_start();
//require_once 'admin/includes/config.php';

include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
?>
	<script src="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js' type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_tooltip.js' type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" media="screen" title="no title" charset="utf-8">
<div style="clear: both">
<span class="admin_head">
	Calendar
</span>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<style type="text/css" media="screen">
	.dhx_scale_hour_main {
		float: left;
		text-align: right;
		font-size: 16px;
		font-weight: bold;
	}
	.dhx_scale_hour_minute_cont {
		float: left;
		position: relative;
		text-align: right;
	}
	.dhx_scale_hour_minute_top, .dhx_scale_hour_minute_bottom {
		font-size: 10px;
		padding-right: 5px;
	}
	.dhx_scale_hour_sep {
		position: absolute;
		height: 1px;
		background-color: #8C929A;
		right: 0;
		top: 20px;
		width: 20px;
	}
		
</style>

<script type="text/javascript" charset="utf-8">
	function initCal() {
		scheduler.config.multi_day = true;
		scheduler.config.xml_date="%Y-%m-%d %h:%i %A";
		scheduler.config.hour_date="%h:%i%A";
		scheduler.templates.tooltip_date_format=scheduler.date.date_to_str("%H:%i %m-%d-%Y");
		scheduler.config.mark_now = true;
		scheduler.config.details_on_create = true;
		scheduler.config.scroll_hour = 8;
		scheduler.locale.labels.timeline_tab = "Timeline"
		scheduler.locale.labels.section_custom="Producer";
		scheduler.locale.labels.section_category = "Type";
                scheduler.locale.labels.section_producer = "Producer";
		scheduler.locale.labels.workweek_tab = "W-Week"
		scheduler.templates.hour_scale = function(date){
            		var hour = date.getHours();
            		var top = '00';
            		var bottom = '30';
            		if(hour==0)
                		top = 'AM';
            		if(hour==12)
                		top = 'PM';
            		hour =  ((date.getHours()+11)%12)+1;
            		var html = '';
            		var section_width = Math.floor(scheduler.xy.scale_width/2);
            		var minute_height = Math.floor(scheduler.config.hour_size_px/2);
            		html += "<div class='dhx_scale_hour_main' style='width: "+section_width+"px; height:"+(minute_height*2)+"px;'>"+hour+"</div><div class='dhx_scale_hour_minute_cont' style='width: "+section_width+"px;'>";
            		html += "<div class='dhx_scale_hour_minute_top' style='height:"+minute_height+"px; line-height:"+minute_height+"px;'>"+top+"</div><div class='dhx_scale_hour_minute_bottom' style='height:"+minute_height+"px; line-height:"+minute_height+"px;'>"+bottom+"</div>";
            		html += "<div class='dhx_scale_hour_sep'></div></div>";
            		return html;		
		};
            	var category = [
                	{ key: '', label: 'General' },
               	 	{ key: 'follow_up', label: 'Follow-up' },
                	{ key: 'sleep_test', label: 'Sleep Test' },
                	{ key: 'impressions', label: 'Impressions' },
                        { key: 'new_patient', label: 'New Pt' }
            	];
		var producer = [
			<?php
			$p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
			$p_query = mysql_query($p_sql);
			while($p = mysql_fetch_array($p_query)){
				?>{ key: '<?= $p['userid']; ?>', label: '<?= $p['name']; ?>'},<?php
			}

			?>
			{ key: '', label: 'None' }
		];
		scheduler.createTimelineView({
			name:	"timeline",
			x_unit:	"minute",
			x_date:	"%H:%i",
			x_step:	30,
			x_size: 24,
			x_start: 16,
			x_length:	48,
			y_unit:	producer,
			y_property:	"producer",
			render:"bar"
		});
		scheduler.attachEvent("onTemplatesReady",function(){
			//work week
			scheduler.date.workweek_start = scheduler.date.week_start;
			scheduler.templates.workweek_date = scheduler.templates.week_date;
			scheduler.templates.workweek_scale_date = scheduler.templates.week_scale_date;
			scheduler.date.add_workweek=function(date,inc){ return scheduler.date.add(date,inc*7,"day"); }
			scheduler.date.get_workweek_end=function(date){ return scheduler.date.add(date,5,"day"); }
			
		});
		scheduler.config.lightbox.sections=[	
			{name:"description", height:130, map_to:"text", type:"textarea" , focus:true},
			{name:"category", height:20, type:"select", options: category, map_to:"category" },
                        {name:"producer", height:20, type:"select", options: producer, map_to:"producer" },
			{name:"time", height:72, type:"time", map_to:"auto"}
		]
                scheduler.init('scheduler_here',null,"workweek");

		<?php
		$sql = "SELECT * from dental_calendar WHERE docid='".$_SESSION['docid']."'";
		$q = mysql_query($sql);
		while($r = mysql_fetch_assoc($q)){
			?>scheduler.addEvent({
				start_date: "<?= date('d-m-Y H:i', strtotime($r['start_date'])); ?>",
				end_date: "<?= date('d-m-Y H:i', strtotime($r['end_date'])); ?>",
				text: "<?= $r['description']; ?>",
				category: "<?= $r['category']; ?>",
				producer: "<?= $r['producer_id']; ?>",
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
                    var cat = event_object.category;
		    var pi = event_object.producer;
		    var e_id = event_id;
                                  $.ajax({
                                        url: "includes/calendar_add_event.php",
                                        type: "post",
                                        data: {id: e_id, start_date: sd, end_date: ed, description: de, category: cat, producer: pi},
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
		    var cat = event_object.category;
		    var pi = event_object.producer;
		    var t_id = event_object.table_id
                    var e_id = event_id;
                                  $.ajax({
                                        url: "includes/calendar_update_event.php",
                                        type: "post",
                                        data: {e_id: e_id, t_id: t_id, start_date: sd, end_date: ed, description: de, category: cat, producer: pi},
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
                        <div class="dhx_cal_tab" name="timeline_tab" style="right:335px;"></div>
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
