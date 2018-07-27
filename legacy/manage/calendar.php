<?php
namespace Ds3\Libraries\Legacy;

define('DSS_SCHEDULER_PRODUCERS', 0);
define('DSS_SCHEDULER_RESOURCES', 1);
define('DSS_SCHEDULER_PATIENTS', 2);
define('DSS_SCHEDULER_APPOINTMENT_TYPES', 3);

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/formatters.php';

$schedulerProducers = schedulerProducers($_SESSION['docid']);
$schedulerResources = schedulerResources($_SESSION['docid']);
$schedulerPatients = schedulerPatients($_SESSION['docid']);
$schedulerAppointmentTypes = schedulerAppointmentTypes($_SESSION['docid']);
?>
<script src="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.js?t=20131129" type="text/javascript" charset="utf-8"></script>
<script src="3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_recurring.js?t=20131129" type="text/javascript" charset="utf-8"></script>
<script src="3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_editors.js?t=20131129" type="text/javascript" charset="utf-8"></script>
<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_timeline.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_tooltip.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_units.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<script src='3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_pdf.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<script src='3rdParty/dhtmlxCombo/codebase/dhtmlxcombo.js?t=20131129' type="text/javascript" charset="utf-8"></script>
<script src="3rdParty/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_limit.js?t=20131129"></script>
<link rel="stylesheet" href="3rdParty/dhtmlxScheduler/codebase/dhtmlxscheduler.css?t=20131129" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/calendar.css?t=20131129" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" type="text/css" href="3rdParty/dhtmlxCombo/codebase/dhtmlxcombo.css?t=20131129">

<div style="clear: both">
<br />
<div align="center" class="red">
    <b>
        <?php
        if(!empty($_GET['msg'])) {
            echo $_GET['msg'];
        }
        ?>
    </b>
</div>

<style type="text/css" media="screen">
    <?php foreach ($schedulerAppointmentTypes as $appt_t_r) {
        $str = strtolower($appt_t_r['name']);
        $str = html_entity_decode($str);
        $str = preg_replace('/[^a-z0-9]/i', '', $str);
        ?>
        .dhx_cal_event.event_<?php echo $str; ?> div{
            background-color: #<?php echo $appt_t_r['color']; ?> !important;
        }
    <?php } ?>
</style>

<script type="text/javascript" charset="utf-8">
    var indexedCategories = <?= safeJsonEncode(indexBy($schedulerAppointmentTypes, 'classname')) ?>;
    var indexedProducers = <?= safeJsonEncode(indexBy($schedulerProducers, 'userid')) ?>;
    var indexedResources = <?= safeJsonEncode(indexBy($schedulerResources, 'id')) ?>;
    var indexedPatients = <?= safeJsonEncode(indexBy($schedulerPatients, 'patientid')) ?>;

    function initCal() {
        dhtmlXTooltip.config.timeout_to_display = 500;
        dhtmlXTooltip.config.timeout_to_hide = 100;
        scheduler.config.multi_day = true;
        scheduler.config.xml_date="%Y-%m-%d %H:%i:%s";
        scheduler.config.hour_date="%h:%i%A";
        scheduler.config.hour_size_px = 44;
        scheduler.templates.tooltip_date_format=scheduler.date.date_to_str("%h:%i%A %m-%d-%Y");
        scheduler.config.mark_now = true;
        scheduler.config.details_on_create = true;
        scheduler.config.details_on_dblclick=true;
        scheduler.config.scroll_hour = 8;
        scheduler.config.start_on_monday = false;
        scheduler.config.separate_short_events = true;
        scheduler.config.show_loading = true;
        scheduler.locale.labels.chairs_tab = "Resources";
        scheduler.locale.labels.timeline_tab = "Timeline";
        scheduler.locale.labels.section_custom="Producer";
        scheduler.locale.labels.section_custom="Resource";
        scheduler.locale.labels.section_category = "Appt. Type";
        scheduler.locale.labels.section_producer = "Producer";
        scheduler.locale.labels.section_resource = "Resource";
        scheduler.locale.labels.section_patient = "Patient";
        scheduler.locale.labels.workweek_tab = "W-Week";

        scheduler.templates.event_text = function(start_date, end_date, event){
            var ret = '';
            var comma = false;
            if(event.patient && event.patient != 0 && event.patientfn && event.patientln){
                ret += event.patientfn + " " + event.patientln;
                comma = true;
            }
            if(event.eventtype){
                if(comma){
                    ret += ", ";
                }
                ret += event.eventtype;
                comma = true;
            }
            if(event.title){
                if(comma){
                    ret += ", ";
                }
                ret += event.title;
            }
            if(ret){
                return ret;
            }else{
                return event.text;
            }
        };

        scheduler.templates.event_class = function(start, end, event){
            if (event.category) { // if event has subject property then special class should be assigned
                return "event_" + event.category.replace(/[^a-z0-9]+/ig, '');
            }

            return "event_general"; // default return
        };

        scheduler.templates.tooltip_text = function(start,end,event) {
            var cat, prod, resource, patient,
                pat = 'None',
                phone = { home: '', cell: '', work: '' };

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

            if (indexedCategories.hasOwnProperty(event.category)) {
                cat = indexedCategories[event.category].name || '';
            }

            if (indexedProducers.hasOwnProperty(event.producer)) {
                prod = indexedProducers[event.producer].full_name || '';
            }

            if (indexedResources.hasOwnProperty(event.resource)) {
                resource = indexedResources[event.resource].name || '';
            }

            if (indexedPatients.hasOwnProperty(event.patient)) {
                patient = indexedPatients[event.patient];
                pat = patient.full_name || '';
                phone = {
                    home: patient.home_phone || '',
                    cell: patient.cell_phone || '',
                    work: patient.work_phone || ''
                };
            }

            return "<b>Event:</b> "+event.text+"<br/>" +
                "<b>Appt Type:</b> "+cat+"<br/>" +
                "<b>Producer:</b> "+prod+"<br/>" +
                "<b>Resource:</b> " + resource + "<br/>" +
                "<b>Patient:</b> "+pat+"<br/>" +
                (phone.home.length ? "<b>Pt Home:</b> "+phone.home+"<br/>" : "") +
                (phone.cell.length ? "<b>Pt Cell:</b> "+phone.cell+"<br/>" : "") +
                (phone.work.length ? "<b>Pt Work:</b> "+phone.work+"<br/>" : "") +
                "<b>Start Date:</b> "+scheduler.templates.tooltip_date_format(start)+"<br/>" +
                "<b>End Date:</b> "+scheduler.templates.tooltip_date_format(end);
        };

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

        var category = <?= safeJsonEncode(keyLabelMap($schedulerAppointmentTypes, 'classname', 'name')) ?>;
        var producer = <?= safeJsonEncode(keyLabelMap($schedulerProducers, 'userid', 'full_name')) ?>;
        var resource = <?= safeJsonEncode(keyLabelMap($schedulerResources, 'id', 'name')) ?>;
        var patient = <?= safeJsonEncode(keyLabelMap(
            filterInactivePatients($schedulerPatients), 'patientid', 'full_name'
        )) ?>;

        patient.push({
            key: '',
            label: 'None'
        });

        var prod_list = <?= safeJsonEncode(keyLabelMap($schedulerProducers, 'userid', 'full_name')) ?>;
        var chairs_list = <?= safeJsonEncode(keyLabelMap($schedulerResources, 'id', 'name')) ?>;

        scheduler.createUnitsView({
            name: "timeline",
            property: "producer",
            list: prod_list
        });

        scheduler.createUnitsView({
            name: "chairs",
            property: "resource",
            list: chairs_list
        });

        scheduler.attachEvent("onTemplatesReady",function(){
            //work week
            scheduler.date.workweek_start = function(date){ return scheduler.date.add(scheduler.date.week_start(date), 1, "day"); };
            scheduler.templates.workweek_date = scheduler.templates.week_date;
            scheduler.templates.workweek_scale_date = scheduler.templates.week_scale_date;
            scheduler.date.add_workweek=function(date,inc){ return scheduler.date.add(date,inc*7,"day"); };
            scheduler.date.get_workweek_end=function(date){ return scheduler.date.add(date,5,"day"); };
        });

        scheduler.config.lightbox.sections=[
            {name:"description", height:130, map_to:"text", type:"textarea" , focus:true},
            {name:"recurring", height:130, map_to:"rec_type", type:"recurring", button: "recurring"},
            {name:"category", height:20, type:"select", options: category, map_to:"category" },
            {name:"producer", height:20, type:"select", options: producer, map_to:"producer" },
            {name:"resource", height:20, type:"select", options: resource, map_to:"resource" },
            {name:"patient", map_to:"patient", height:20, type:"combo", options: patient, filtering: true,image_path: "/manage/3rdParty/dhtmlxCombo/codebase/imgs/" },
            {name:"time", height:72, type:"time", map_to:"auto"}
        ];
        scheduler.init('scheduler_here',null,"workweek");
        scheduler._els["dhx_cal_data"][0].scrollTop = scheduler.config.hour_size_px*8;

        function _lookup_ptname(id, callback){
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
                failure: function(data){}
            });
        }

        function _lookup_eventtype(id, callback){
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
                failure: function(data){}
            });
        }

        scheduler.init('scheduler_here',null,"chairs");
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
                    _lookup_ptname(r.eventid, _add_event_ptname);
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
            function _add_event_ptname(r){
                event_object.patientfn = r.firstname;
                event_object.patientln = r.lastname;
                event_object.title = event_object.text;
                scheduler.updateEvent(event_object.id);
            }

            function _add_event_type(r){
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
            function _add_event_ptname(r){
                event_object.patientfn = r.firstname;
                event_object.patientln = r.lastname;
                event_object.title = event_object.text;
                scheduler.updateEvent(event_object.id);
            }

            function _add_event_type(r){
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

        scheduler.setLoadMode('month');
        scheduler.load('/manage/calendar-events.php', 'json');
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

    $(document).ready( function(){
        var event = null,
            eventId = getParameterByName('eid'),
            intervalId = 0,
            retryCount = 0,
            retryLimit = 100;

        initCal();

        if (!eventId) {
            return;
        }

        event = scheduler.getEvent(eventId);

        if (event) {
            return;
        }

        function eventWatchDog () {
            var event = scheduler.getEvent(eventId);

            if (event) {
                clearInterval(intervalId);

                scheduler.showEvent(eventId, 'day');
                scheduler.select(eventId);
            }

            retryCount++;

            if (retryCount >= retryLimit) {
                clearInterval(intervalId);
            }
        }

        $.get('/manage/calendar-events.php?eid=' + eventId, function(eventData){
            if (!$.isArray(eventData) || !eventData.length || !eventData[0].start_date) {
                return;
            }

            var eventDate = eventData[0].start_date.match(/^(\d{4})-(\d{2})-(\d{2})/);

            scheduler.setCurrentView(new Date(eventDate[1], +eventDate[2] - 1, eventDate[3]), 'day');
            intervalId = setInterval(eventWatchDog, 1000);
        });
    });
</script>

<span class="admin_head" style="width:38%;">
    Calendar
</span>

<form method="get" id="cal_search" action="calendar_pat.php" style="width:48%;float:left;">
    <input type="text" id="pat_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="pat_name" value="<?php echo (!empty($pat_name))?$pat_name:'Search Calendar'; ?>" />
    <br />
    <div id="pat_hints" class="search_hints" style="display:none;">
        <ul id="pat_list" class="search_list">
            <li class="template" style="display:none">Doe, John S</li>
        </ul>
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
<?php

require_once __DIR__ . '/includes/bottom.htm';

function schedulerResults($docId, $queryType)
{
    $db = new Db();
    $docId = (int)$docId;

    $constQueries = [
        DSS_SCHEDULER_PRODUCERS => "SELECT userid, first_name, last_name, name, CONCAT(first_name, ' ', last_name) AS full_name
            FROM dental_users
            WHERE userid = '$docId'
                OR (docid = '$docId' AND producer = 1)",
        DSS_SCHEDULER_RESOURCES => "SELECT id, name
            FROM dental_resources
            WHERE docid = '$docId'
            ORDER BY rank, name ASC",
        DSS_SCHEDULER_PATIENTS => "SELECT
                patientid,
                firstname,
                lastname,
                home_phone,
                cell_phone,
                work_phone,
                CONCAT(firstname, ' ', lastname) AS full_name,
                status
            FROM dental_patients
            WHERE docid = '$docId'
            ORDER BY lastname, firstname",
        DSS_SCHEDULER_APPOINTMENT_TYPES => "SELECT name, color, classname
            FROM dental_appt_types
            WHERE docid = '$docId'
            ORDER BY name ASC",
    ];

    if (!array_key_exists($queryType, $constQueries)) {
        return [];
    }

    $result = $db->getResults($constQueries[$queryType]);
    return $result;
}

function schedulerProducers($docId)
{
    return schedulerResults($docId, DSS_SCHEDULER_PRODUCERS);
}

function schedulerResources($docId)
{
    return schedulerResults($docId, DSS_SCHEDULER_RESOURCES);
}

function schedulerPatients($docId)
{
    return schedulerResults($docId, DSS_SCHEDULER_PATIENTS);
}

function schedulerAppointmentTypes($docId)
{
    return schedulerResults($docId, DSS_SCHEDULER_APPOINTMENT_TYPES);
}

function indexBy(array $array, $field)
{
    $keys = array_pluck($array, $field);
    return array_combine($keys, $array);
}

function keyLabelMap(array $array, $key, $label)
{
    $map = array_map(function ($each) use ($key, $label) {
        $selectedKey = '';
        $selectedLabel = '';

        if (isset($each[$key])) {
            $selectedKey = $each[$key];
        }

        if (isset($each[$label])) {
            $selectedLabel = $each[$label];
        }

        return [
            'key' => $selectedKey,
            'label' => $selectedLabel,
        ];
    }, $array);

    return $map;
}

function filterInactivePatients(array $patientList)
{
    $filtered = array_filter($patientList, function ($each) {
        if (!is_array($each) || !isset($each['status'])) {
            return false;
        }

        return (int)$each['status'] === 1;
    });

    $filtered = array_values($filtered);
    return $filtered;
}
