<?php 
//session_start();
//require_once 'admin/includes/main_include.php';

include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
?>
	<script src="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.js?t=20131129" type="text/javascript" charset="utf-8"></script>
	<script src="3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_recurring.js?t=20131129" type="text/javascript" charset="utf-8"></script>
	<script src="3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_editors.js?t=20131129" type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_timeline.js?t=20131129' type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_tooltip.js?t=20131129' type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js?t=20131129' type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_units.js?t=20131129' type="text/javascript" charset="utf-8"></script>
	<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_pdf.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<?php
/*
*/?>



<?php /*        <script src='3rdParty/dhtmlxCombo/codebase/dhtmlxcommon.js' type="text/javascript" charset="utf-8"></script> */ ?>

        <script src='3rdParty/dhtmlxCombo/codebase/dhtmlxcombo.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<script src="3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_limit.js?t=20131129"></script>
	<link rel="stylesheet" href="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.css?t=20131129" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/calendar.css?t=20131129" type="text/css" media="screen" title="no title" charset="utf-8">
<?php /*        <link rel="stylesheet" href="3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_ext.css" type="text/css" media="screen" title="no title" charset="utf-8"> */ ?>
 	<link rel="stylesheet" type="text/css" href="3rdParty/dhtmlxCombo/codebase/dhtmlxcombo.css?t=20131129">
<div style="clear: both">

<br />
<div align="center" class="red">
	<b><? if(!empty($_GET['msg'])) {echo $_GET['msg'];} ?></b>
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
	/*.dhx_cal_event.event_general div{ background-color: #FFF9CF !important; }
	.dhx_cal_event.event_follow_up div{ background-color: #D6CFFF !important; } 
	.dhx_cal_event.event_sleep_test div{ background-color: #CFF5FF !important; }
	.dhx_cal_event.event_impressions div {background-color: #DFFFCF !important; }
	.dhx_cal_event.event_new_patient div{background-color: #FFCFCF !important; }
        .dhx_cal_event.event_deliver_device div{background-color: #FBA16C !important; }
	*/
<?php
	$appt_t_sql = "select * from dental_appt_types WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
	$appt_t_qu = mysql_query($appt_t_sql);
	while($appt_t_r = mysql_fetch_array($appt_t_qu))
	{
		$str = str_replace('&amp;_','',str_replace('.','',str_replace('/','',str_replace(' ', '_', strtolower($appt_t_r['name'])))));
		?>.dhx_cal_event.event_<?php print $str; ?> div{ background-color: #<?php print $appt_t_r['color']; ?> !important; }
	<?}
	
?>
		
</style>
<script type="text/javascript" charset="utf-8">
	function initCal() {
		scheduler.config.multi_day = true;
		scheduler.config.xml_date="%Y-%m-%d %h:%i %A";
		scheduler.config.hour_date="%h:%i%A";
		scheduler.config.hour_size_px = 44;
		scheduler.templates.tooltip_date_format=scheduler.date.date_to_str("%H:%i %m-%d-%Y");
		scheduler.config.mark_now = true;
		scheduler.config.details_on_create = true;
		scheduler.config.details_on_dblclick=true;
		scheduler.config.scroll_hour = 8;
		scheduler.config.start_on_monday = false;
		scheduler.config.separate_short_events = true;
		scheduler.locale.labels.chairs_tab = "Resources"
		scheduler.locale.labels.timeline_tab = "Timeline"
		scheduler.locale.labels.section_custom="Producer";
		scheduler.locale.labels.section_custom="Resource";
		scheduler.locale.labels.section_category = "Appt. Type";
                scheduler.locale.labels.section_producer = "Producer";
                scheduler.locale.labels.section_resource = "Resource";
		scheduler.locale.labels.section_patient = "Patient";
		scheduler.locale.labels.workweek_tab = "W-Week";
/*scheduler.attachEvent("onXLE", function () {
    scheduler.config.export_.pdf_mode = "fullcolor";
});*/

		scheduler.templates.event_text = function(start_date, end_date, event){
			var ret = '';
			var comma = false;
			if(event.patient && event.patient != 0 && event.patientfn && event.patientln)
			{
				ret += event.patientfn + " " + event.patientln;
				comma = true;
			}
			if(event.eventtype)
			{
				if(comma)
				{
					ret += ", ";
				}
				ret += event.eventtype;
				comma = true;
			}
			if(event.title)
			{
				if(comma)
				{
					ret += ", ";
				}
				ret += event.title;
			}
			if(ret)
			{
				return ret;
			}
			else
			{
				return event.text;
			}
		};
                scheduler.templates.event_class=function(start, end, event){


                  if(event.category) // if event has subject property then special class should be assigned
                    return "event_"+event.category.replace('&_','');

                  return "event_general"; // default return

            	};
		scheduler.templates.tooltip_text = function(start,end,event) {
			switch(event.category){
				case 'follow_up':
					cat = 'Follow-up';
					break;
				case 'deliver_device':
					cat = 'Deliver Device';
					break;	
				case 'sleep_test':
					cat = 'Sleep Test';
					break;
				case 'impressions':
					cat = 'Impressions';
					break;
				case 'new_patient':
					cat = 'New Pt';
					break;
				default:
					cat = 'General';
					break;
			}
			switch(event.producer){
				<?php
				$p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
                        	$p_query = mysql_query($p_sql);
                        	while($p = mysql_fetch_array($p_query)){
                                	?>case '<?= $p['userid']; ?>':
						prod = '<?= addslashes($p['first_name']." ".$p['last_name']); ?>';
						break;
					<?php
                        	}
				?>
			}
			switch(event.resource){
				<?php
				$p_sql = "SELECT * FROM dental_resources WHERE docid=".$_SESSION['docid']." order by rank, name asc";
                        	$p_query = mysql_query($p_sql);
                        	while($p = mysql_fetch_array($p_query)){
                                	?>case '<?= $p['id']; ?>':
						resource = '<?= addslashes($p['name']); ?>';
						break;
					<?php
                        	}
				?>
			}
			switch(event.patient){
                                <?php
                                $p_sql = "SELECT * FROM dental_patients WHERE docid=".$_SESSION['docid'];
                                $p_query = mysql_query($p_sql);
                                while($p = mysql_fetch_array($p_query)){
                                        ?>case '<?= $p['patientid']; ?>':
                                                pat = '<?= addslashes($p['firstname'])." ".addslashes($p['lastname']); ?>';
                                                break;
                                        <?php
                                }
                                ?>
                                default:
                                        pat = 'None';
                                        break;
                        }
			return "<b>Event:</b> "+event.text+"<br/><b>Appt Type:</b> "+cat+"<br/><b>Producer:</b> "+prod+"<br/><b>Resource:</b> " + resource + "<br/><b>Patient:</b> "+pat+"<br/><b>Start date:</b> "+scheduler.templates.tooltip_date_format(start)+"<br/><b>End date:</b> "+scheduler.templates.tooltip_date_format(end);
		}
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
			<?php
			$p_sql = "SELECT * FROM dental_appt_types where docid='".mysql_real_escape_string($_SESSION['docid'])."' order by name asc";
			$p_query = mysql_query($p_sql);
			while($p = mysql_fetch_array($p_query)){
				?>{ key: '<?= $p['classname']; ?>', label: '<?= $p['name']; ?>'},<?php
			}
			?>
            	];
		var producer = [
			<?php
			$p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
			$p_query = mysql_query($p_sql);
			while($p = mysql_fetch_array($p_query)){
				?>{ key: '<?= $p['userid']; ?>', label: '<?= $p['first_name'].' '.$p['last_name']; ?>'},<?php
			}

			?>
		];
		var resource = [
			<?php
			$p_sql = "SELECT * FROM dental_resources WHERE docid=".$_SESSION['docid']." order by rank, name asc";
			$p_query = mysql_query($p_sql);
			while($p = mysql_fetch_array($p_query)){
				?>{ key: '<?= $p['id']; ?>', label: '<?= $p['name']; ?>'},<?php
			}

			?>
		];
		var patient = [
                        <?php
                        $p_sql = "SELECT * FROM dental_patients WHERE docid=".$_SESSION['docid']." AND status=1";
                        $p_query = mysql_query($p_sql);
                        while($p = mysql_fetch_array($p_query)){
                                ?>{ key: '<?= $p['patientid']; ?>', label: '<?= addslashes($p['firstname'])." ".addslashes($p['lastname']); ?>'},<?php
                        }

                        ?>
			{ key: '', label: 'None' }

                ];
		var prod_list = [
			<?php
				$p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
				$p_query = mysql_query($p_sql);
				while($p = mysql_fetch_array($p_query)){
					?>{ key: <?= $p['userid']; ?>, label: '<?= $p['name']; ?>'},<?php
				}
			?>
		];
		scheduler.createUnitsView({
			name: "timeline",
			property: "producer",
			list: prod_list
		});
/*
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
*/
		var chairs_list = [
			<?php
				$chair_sql = "select * from dental_resources WHERE docid=".$_SESSION['docid']." order by rank, name asc";
				$chair_qu = mysql_query($chair_sql);
				while($chair_r = mysql_fetch_array($chair_qu))
				{
					?>{ key:<? print $chair_r['id']; ?>, label:<? print '"' . $chair_r['name'] . '"'; ?>},
				<?}
			?>
		];
		scheduler.createUnitsView({
			name: "chairs",
			property: "resource",
			list: chairs_list
		});
/*		scheduler.createTimelineView({
			name:	"chairs",
			x_unit:	"minute",
			x_date:	"%H:%i",
			x_step:	30,
			x_size: 24,
			x_start: 16,
			x_length: 48,
			y_unit:	resource,
			y_property:	"resource",
			render:"bar"
		});
*/
		scheduler.attachEvent("onTemplatesReady",function(){
			//work week
			scheduler.date.workweek_start = function(date){ return scheduler.date.add(scheduler.date.week_start(date), 1, "day"); }
			scheduler.templates.workweek_date = scheduler.templates.week_date;
			scheduler.templates.workweek_scale_date = scheduler.templates.week_scale_date;
			scheduler.date.add_workweek=function(date,inc){ return scheduler.date.add(date,inc*7,"day"); }
			scheduler.date.get_workweek_end=function(date){ return scheduler.date.add(date,5,"day"); }
			
		});
		scheduler.config.lightbox.sections=[	
			{name:"description", height:130, map_to:"text", type:"textarea" , focus:true},
			{name:"recurring", height:130, map_to:"rec_type", type:"recurring", button: "recurring"},
			{name:"category", height:20, type:"select", options: category, map_to:"category" },
                        {name:"producer", height:20, type:"select", options: producer, map_to:"producer" },
                        {name:"resource", height:20, type:"select", options: resource, map_to:"resource" },
			{name:"patient", map_to:"patient", height:20, type:"combo", options: patient, filtering: true,image_path: "/manage/3rdParty/dhtmlxCombo/codebase/imgs/" },
			{name:"time", height:72, type:"time", map_to:"auto"}
		]
                scheduler.init('scheduler_here',null,"workweek");
		scheduler._els["dhx_cal_data"][0].scrollTop = scheduler.config.hour_size_px*8;
		<?php
		//$sql = "SELECT * from dental_calendar WHERE docid='".$_SESSION['docid']." order by id asc'";
		$sql = "SELECT dc.*, dp.*, dt.name as etype from dental_calendar as dc left join dental_patients as dp on dc.patientid = dp.patientid inner join dental_appt_types as dt on dc.category = dt.classname WHERE dc.docid='".$_SESSION['docid']."' and dt.docid='".$_SESSION['docid']."' order by dc.id asc";
		$q = mysql_query($sql);
		while($r = mysql_fetch_assoc($q)){
			?>scheduler.addEvent({
				start_date: "<?= date('d-m-Y H:i', strtotime($r['start_date'])); ?>",
				end_date: "<?= date('d-m-Y H:i', strtotime($r['end_date'])); ?>",
				text: "<?= str_replace("\n", " ", addslashes($r['description'])); ?>",
				title: "<?= str_replace("\n", " ", addslashes($r['description'])); ?>",
				rec_type: "<?= str_replace("\n", " ", addslashes($r['rec_type'])); ?>",
				rec_pattern: "<?= str_replace("\n", " ", addslashes($r['rec_pattern'])); ?>",
				event_length: "<?= $r['event_length']; ?>",
				event_pid: "<?= $r['event_pid']; ?>",
				category: "<?= $r['category']; ?>",
				producer: "<?= $r['producer_id']; ?>",
				resource: "<?= $r['res_id']; ?>",
				patient: "<?= $r['patientid']; ?>",
				id: "<?= $r['event_id']; ?>",
				table_id: "<?= $r['id']; ?>",
				patientfn: "<?= $r['firstname']; ?>",
				patientln: "<?= $r['lastname']; ?>",
				eventtype: "<?= $r['etype']; ?>",
			});<?php
		}
		?>
	function _lookup_ptname(id, callback)
	{
		$.ajax({
			url: "includes/calendar_check_ptname.php",
			type: "post",
			data: {id: id},
			success: function(data){
				var r = $.parseJSON(data);
				callback(r);
				if(r.error){
				}else{
				}
			},
			failure: function(data){},
		});
	}
	function _lookup_eventtype(id, callback)
	{
		$.ajax({
			url: "includes/calendar_check_eventtype.php",
			type: "post",
			data: {id: id},
			success: function(data){
				var r = $.parseJSON(data);
				callback(r);
				if(r.error){
				}else{
				}
			},
			failure: function(data){},
		});
	}

                scheduler.init('scheduler_here',null,"chairs");
		//scheduler.load("../common/events2010.xml");
		scheduler.attachEvent("onEventAdded", function(event_id,event_object){
		    var sd = event_object.start_date;
			sd = sd.getFullYear()+'-'+(sd.getMonth()+1)+'-'+sd.getDate()+' '+sd.getHours()+':'+sd.getMinutes();
		    var ed = event_object.end_date;
			ed = ed.getFullYear()+'-'+(ed.getMonth()+1)+'-'+ed.getDate()+' '+ed.getHours()+':'+ed.getMinutes();
		    var de = event_object.text;
                    var cat = event_object.category;
		    var pi = event_object.producer;
		    var pid = event_object.patient;
			var ri = event_object.resource;
			var rec_type = event_object.rec_type;
			var rec_pattern = event_object.rec_pattern;
			var elength = event_object.event_length;
			var epid = event_object.event_pid;

		    var e_id = event_id;

                                  $.ajax({
                                        url: "includes/calendar_add_event.php",
                                        type: "post",
                                        data: {id: e_id, start_date: sd, end_date: ed, description: de, category: cat, producer: pi, patient: pid, rec_type: rec_type, rec_pattern: rec_pattern, epid: epid, elength: elength, resource: ri},
                                        success: function(data){
                                                var r = $.parseJSON(data);
						_lookup_ptname(r.eventid, _add_event_ptname)
						_lookup_eventtype(r.eventid, _add_event_type);
                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail 314');
                                        }
                                  });

                    //any custom logic here
			function _add_event_ptname(r)
			{
				event_object.patientfn = r.firstname; 
				event_object.patientln = r.lastname;
				event_object.title = event_object.text;
				scheduler.updateEvent(event_object.id);
			}
			function _add_event_type(r)
			{
				event_object.eventtype = r.etype;
				scheduler.updateEvent(event_object.id);
			}
          	});		
                scheduler.attachEvent("onEventChanged", function(event_id,event_object){
                    var sd = event_object.start_date;
                        sd = sd.getFullYear()+'-'+(sd.getMonth()+1)+'-'+sd.getDate()+' '+sd.getHours()+':'+sd.getMinutes();
                    var ed = event_object.end_date;
                        ed = ed.getFullYear()+'-'+(ed.getMonth()+1)+'-'+ed.getDate()+' '+ed.getHours()+':'+ed.getMinutes();
                    var de = event_object.text;
		    var cat = event_object.category;
		    var pi = event_object.producer;
		    var pid = event_object.patient;

			var ri = event_object.resource;

			var rec_type = event_object.rec_type;
			var rec_pattern = event_object.rec_pattern;
			var elength = event_object.event_length;
			var epid = event_object.event_pid;

		    var t_id = event_object.table_id;
                    var e_id = event_id;
                                  $.ajax({
                                        url: "includes/calendar_update_event.php",
                                        type: "post",
                                        data: {e_id: e_id, t_id: t_id, start_date: sd, end_date: ed, description: de, category: cat, producer: pi, patient: pid, rec_type: rec_type, rec_pattern: rec_pattern, epid: epid, elength: elength, resource: ri},
                                        success: function(data){
                                                var r = $.parseJSON(data);
						_lookup_ptname(r.eventid, _add_event_ptname);
						_lookup_eventtype(r.eventid, _add_event_type);
                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail 345');
                                        }
                                  });

                    //any custom logic here
			function _add_event_ptname(r)
			{
				event_object.patientfn = r.firstname; 
				event_object.patientln = r.lastname;
				event_object.title = event_object.text;
				scheduler.updateEvent(event_object.id);
			}
			function _add_event_type(r)
			{
				event_object.eventtype = r.etype;
				scheduler.updateEvent(event_object.id);
			}

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
                                                //alert('fail 364');
                                        }
                                  });

                    //any custom logic here
                });
        scheduler.attachEvent("onEventSave", function (id, data, is_new_event) {
            if (is_new_event && !data.patient) {
                return confirm('There is no patient associated with this appointment. Save anyway?');
            }
            return true;
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
  <?php if(isset($_GET['eid']) && $_GET['eid']!=''){ ?>
    scheduler.showEvent(<?= $_GET['eid'];?>,"day");
    scheduler.select(<?= $_GET['eid'];?>);
  <?php } ?>
});
</script>

<span class="admin_head" style="width:38%;">
        Calendar
</span>

<form method="get" id="cal_search" action="calendar_pat.php" style="width:48%;float:left;">
                                        <input type="text" id="pat_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="pat_name" value="<?= ($pat_name!='')?$pat_name:'Search Calendar'; ?>" />
<br />        <div id="pat_hints" class="search_hints" style="display:none;">
                <ul id="pat_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('pat_name', 'pat_hints', 'pid', '', 'list_patients_basic.php');
});
$('#cal_search .json_patient').live('click', function(){
  $('#cal_search').submit();
});

</script>
                                        </div>
<input type="hidden" name="pid" id="pid" />

</form>




<div class="dhx_cal_tab pdf_link" style="float:right;margin-right:10px;">
<a name="print" value="Print" href="#"
onclick="if(scheduler._mode == 'timeline'){ alert('This view cannot be printed to PDF, please try another view.'); }else{scheduler.toPDF('3rdParty/pdfgen/generate.php', 'fullcolor');}" 
style="text-decoration: none !important; border: none; height: 15px;">Print</a>
</div>

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
                        <div class="dhx_cal_tab" name="chairs_tab" style="right:415px;"></div>
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
