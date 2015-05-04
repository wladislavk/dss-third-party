<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>{!! $siteName !!}</title>

        @section('references')
            <!-- ========================= Styles ========================= -->

            {!! HTML::style('css/manage/admin.css') !!}
            {!! HTML::style('css/manage/task.css') !!}
            {!! HTML::style('css/manage/notifications.css') !!}
            {!! HTML::style('css/manage/search-hints.css') !!}
            {!! HTML::style('css/manage/top.css') !!}
            {!! HTML::style('css/manage/letter-form.css') !!}
            {!! HTML::style('css/manage/form.css') !!}

            @if ($cssForPage2) 
                {!! HTML::style('css/manage/flowsheet_page_page2.css') !!}
            @else
                {!! HTML::style('css/manage/flowsheet_page.css') !!}
            @endif

            {!! HTML::style('css/admin/popup/popup.css') !!}

            <!-- ========================================================== -->

            <!-- ========================= Scripts ======================== -->

            {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
            {!! HTML::script('/js/jquery-ui-1.8.22.custom.min.js') !!}

            {!! HTML::script('/js/3rdParty/jquery.maskedinput-1.3.min.js') !!}
            {!! HTML::script('/js/3rdParty/jquery.tablesorter.min.js') !!}
            {!! HTML::script('/js/3rdParty/jquery.tablesorter.pager.js') !!}
            {!! HTML::script('/js/3rdParty/jquery.tablesorter.widgets.js') !!}

            {!! HTML::script('/js/manage/masks.js') !!}
            {!! HTML::script('/js/manage/calendar2.js') !!}

            @if (!empty($showBlock['timerLong']))
                {!! HTML::script('/js/manage/logout_timer_long.js') !!}
            @else
                {!! HTML::script('/js/manage/logout_timer.js') !!}
            @endif

            {!! HTML::script('/js/manage/jquery.cookie.js') !!}
            {!! HTML::script('/js/manage/ddlevelsmenu.js') !!}
            {!! HTML::script('/js/manage/validation.js') !!}
            {!! HTML::script('/js/manage/top.js') !!}
            {!! HTML::script('/js/manage/hideshow.js') !!}
            {!! HTML::script('/js/manage/wufoo.js') !!}
            {!! HTML::script('/js/manage/task.js') !!}
            {!! HTML::script('/js/manage/autocomplete.js') !!}
            {!! HTML::script('/js/manage/autocomplete_local.js') !!}
            {!! HTML::script('/js/admin/popup.js') !!}
            {!! HTML::script('/js/manage/bottom.js') !!}

            <!-- ========================================================== -->
        @show
    </head>

    <body onload="{!! $onClick !!}">
        <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td colspan="2" align="right" ></td>
            </tr>
            <tr>
                <td valign='top' height="400">
                    <div class="suckertreemenu2">
                        <ul id="topmenu2">
                            <li>
                                <a href="index"> Notifications ({!! $messageCount or '' !!})</a>
                            </li>

                            @if (!empty($numSupport))
                                <li id="header_support" class="pending">
                            @else
                                <li id="header_support">
                            @endif
                                <a href="support">Support ({!! $numSupport or '' !!})</a>
                            </li>

                            <li>
                                <a href="/manage/logout">Sign Out</a>
                            </li>
                        </ul>
                    </div>

                    <div id="task_menu" class="task_menu" style="margin-top:8px;float:right">
                        <span id="task_header">
                            My Tasks (<span id="task_count">{!! $numTasks or '' !!}</span>)
                        </span>

                        <div id="task_list" style="border: solid 1px #000; position: absolute; z-index:20;background:#fff;padding:10px;display:none;">
                               @if (count($overdueTasks))
                                   <h4 id="task_od_header" style="color:red;" class="task_od_header">Overdue</h4>
                                   <ul id="task_od_list">
                                       @foreach ($overdueTasks as $overdueTask)
                                        <li class="task_item task_{!! $overdueTask->id !!}" style="clear:both;">
                                            <div class="task_extra" id="task_extra_{!! $overdueTask->id !!}" >
                                                <a href="#" onclick="delete_task('{!! $overdueTask->id !!}')" class="task_delete"></a>
                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $overdueTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                            </div>

                                            <input type="checkbox" class="task_status" style="float:left;" value="{!! $overdueTask->id !!}" />

                                            <div style="float:left; width:170px;">
                                                {!! $overdueTask->task !!}

                                                @if ($overdueTask->firstname != '' && $overdueTask->lastname != '')
                                                    (<a href="add_patient/ed/{!! $overdueTask->patientid !!}/preview/1/addtopat/1/pid/{!! $overdueTask->patientid !!}">{!! $overdueTask->firstname . ' ' . $overdueTask->lastname !!}</a>)
                                                @endif
                                            </div>
                                        </li>
                                       @endforeach
                                   </ul>
                               @endif

                               @if (count($todayTasks))
                                <h4 id="task_tod_header" class="task_tod_header">Today</h4>
                                <ul id="task_tod_list">
                                    @foreach ($todayTasks as $todayTask)
                                        <li class="task_item task_{!! $todayTask->id !!}" style="clear:both;">
                                            <div class="task_extra" id="task_extra_{!! $todayTask->id !!}" >
                                                <a href="#" onclick="delete_task('{!! $todayTask->id !!}')" class="task_delete"></a>
                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $todayTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                            </div>

                                            <input type="checkbox" class="task_status" style="float:left;" value="{!! $todayTask->id !!}" />

                                            <div style="float:left; width:170px;">
                                                {!! $todayTask->task !!}

                                                @if ($todayTask->firstname != '' && $todayTask->lastname != '')
                                                    (<a href="add_patient/ed/{!! $todayTask->patientid !!}/preview/1/addtopat/1/pid/{!! $todayTask->patientid !!}">{!! $todayTask->firstname . ' ' . $todayTask->lastname !!}</a>)
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                               @endif

                               @if (count($tomorrowTasks))
                                <h4 id="task_tom_header" class="task_tom_header">Tomorrow</h4>
                                <ul id="task_tom_list">
                                    @foreach ($tomorrowTasks as $tomorrowTask)
                                        <li class="task_item task_{!! $tomorrowTask->id !!}" style="clear:both;">
                                            <div class="task_extra" id="task_extra_{!! $tomorrowTask->id !!}" >
                                                <a href="#" onclick="delete_task('{!! $tomorrowTask->id !!}')" class="task_delete"></a>
                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $tomorrowTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                            </div>

                                            <input type="checkbox" class="task_status" style="float:left;" value="{!! $tomorrowTask->id !!}" />

                                            <div style="float:left; width:170px;">
                                                {!! $tomorrowTask->task !!}

                                                @if ($tomorrowTask->firstname != '' && $tomorrowTask->lastname != '')
                                                    (<a href="add_patient/ed/{!! $tomorrowTask->patientid !!}/preview/1/addtopat/1/pid/{!! $tomorrowTask->patientid !!}">{!! $tomorrowTask->firstname . ' ' . $tomorrowTask->lastname !!}</a>)
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                               @endif

                               @if (count($thisWeekTasks))
                                <h4 id="task_tw_header" class="task_tw_header">This Week</h4>
                                <ul id="task_tw_list">
                                    @foreach ($thisWeekTasks as $thisWeekTask)
                                        <li class="task_item task_{!! $thisWeekTask->id !!}" style="clear:both;">
                                            <div class="task_extra" id="task_extra_{!! $thisWeekTask->id !!}" >
                                                <a href="#" onclick="delete_task('{!! $thisWeekTask->id !!}')" class="task_delete"></a>
                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $thisWeekTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                            </div>

                                            <input type="checkbox" class="task_status" style="float:left;" value="{!! $thisWeekTask->id !!}" />

                                            <div style="float:left; width:170px;">
                                                {!! $thisWeekTask->task !!}

                                                @if ($thisWeekTask->firstname != '' && $thisWeekTask->lastname != '')
                                                    (<a href="add_patient/ed/{!! $thisWeekTask->patientid !!}/preview/1/addtopat/1/pid/{!! $thisWeekTask->patientid !!}">{!! $thisWeekTask->firstname . ' ' . $thisWeekTask->lastname !!}</a>)
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                               @endif

                               @if (count($nextWeekTasks))
                                <h4 id="task_nw_header" class="task_nw_header">Next Week</h4>
                                <ul id="task_nw_list">
                                    @foreach ($nextWeekTasks as $nextWeekTask)
                                        <li class="task_item task_{!! $nextWeekTask->id !!}" style="clear:both;">
                                            <div class="task_extra" id="task_extra_{!! $nextWeekTask->id !!}" >
                                                <a href="#" onclick="delete_task('{!! $nextWeekTask->id !!}')" class="task_delete"></a>
                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $nextWeekTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                            </div>

                                            <input type="checkbox" class="task_status" style="float:left;" value="{!! $nextWeekTask->id !!}" />

                                            <div style="float:left; width:170px;">
                                                {!! $nextWeekTask->task !!}

                                                @if ($nextWeekTask->firstname != '' && $nextWeekTask->lastname != '')
                                                    (<a href="add_patient/ed/{!! $nextWeekTask->patientid !!}/preview/1/addtopat/1/pid/{!! $nextWeekTask->patientid !!}">{!! $nextWeekTask->firstname . ' ' . $nextWeekTask->lastname !!}</a>)
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                               @endif

                               @if (count($laterTasks))
                                <h4 id="task_lat_header" class="task_lat_header">Later</h4>
                                <ul id="task_lat_list">
                                    @foreach ($laterTasks as $laterTask)
                                        <li class="task_item task_{!! $laterTask->id !!}" style="clear:both;">
                                            <div class="task_extra" id="task_extra_{!! $laterTask->id !!}" >
                                                <a href="#" onclick="delete_task('{!! $laterTask->id !!}')" class="task_delete"></a>
                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $laterTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                            </div>

                                            <input type="checkbox" class="task_status" style="float:left;" value="{!! $laterTask->id !!}" />

                                            <div style="float:left; width:170px;">
                                                {!! $laterTask->task !!}

                                                @if ($laterTask->firstname != '' && $laterTask->lastname != '')
                                                    (<a href="add_patient/ed/{!! $laterTask->patientid !!}/preview/1/addtopat/1/pid/{!! $laterTask->patientid !!}">{!! $laterTask->firstname . ' ' . $laterTask->lastname !!}</a>)
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                               @endif

                               <br /><br />

                               <a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>
                           </div>
                       </div>

                       @if (!empty($showLinkOnlineCe))
                           <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="edx_login" target="_blank" >Online CE</a>
                        <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="help_login" target="_blank">Help</a>
                       @endif

                       <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="calendar">Scheduler</a>

                       <div style="height:89px; width:100%; background:url(/img/dss_01.png) #0b5c82 no-repeat top left;"> 
                        <div style="margin-top:10px; margin-left:20px; float:left;">
                            <a href="/manage/index" id="logo">Dashboard</a>
                        </div>

                        <div style="float:left; width:68%;">
                            <form>
                                <div id="patient_search_div">
                                    <input type="text" id="patient_search" value="Patient Search" name="q" autocomplete="off" /><br />
                                    <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">

                                    <div id="search_hints"  class="search_hints" style="display:none;">
                                        <ul id="patient_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                </div> 
                            </form>

                            <button onclick="window.location='add_patient'" style="padding: 3px; margin-top:27px;">+ Add Patient</button>
                            <button onclick="loadPopup('/manage/task/add{!! !empty($patientId) ? '/' . $patientId : '' !!}')" style="padding: 3px; margin-top:27px;">+ Add Task</button>
                        </div>

                        @if (!empty($logo))
                            <div style="float:right;margin:13px 15px 0 0;">
                                <img src="display_file/f/{!! $logo !!}" />
                            </div>
                        @endif

                        <div style="clear:both;"></div>
                    </div>

                    <div style="background:url(/img/dss_03.jpg) #0b5c82 repeat-y top left;width:100%;">
                        <div style="width:98.6%; background:#00457c;margin:0 auto;">
                            @if (!empty($patientId))
                                @if (!empty($theName) && strlen($theName) > 20)
                                    <div id="patient_name_div" style="font-size:14px">
                                @else
                                    <div id="patient_name_div">
                                @endif
                                
                                    <div id="patient_name_inner">

                                        @if (!empty($medicare)) 
                                            <img src="/img/medicare_logo_small.png" />
                                            <span class="medicare_name">
                                        @else
                                            <span class="name">
                                        @endif
                                            {!! $theName or '' !!}

                                            @if (!empty($premed) && $premed == 1 || !empty($premed) && $premed ==1)
                                                <a href="q_page3/pid/{!! $patientId or '' !!}" title="{!! $title !!}" style="font-weight:bold; font-size:18px; color:#FF0000;">*Med</a>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                @if (!empty($numPatientTasks))
                                    <div class="task_menu" id="pat_task_menu" style="float:left; margin:10px 0 0 10px;">
                                        <span id="pat_task_header" style="font-size:14px; font-weight:normal; color:#fff;">Tasks({!! $numPatientTasks !!})</span>

                                        <div class="task_list" id="pat_task_list" style="display:none;">
                                            @if (count($overdueTasks))
                                                <h4 id="pat_task_od_header" style="color:red" class="task_od_header">Overdue</h4>
                                                <ul id="pat_task_od_list">
                                                    @foreach ($overdueTasks as $overdueTask)
                                                        <li class="task_item task_{!! $overdueTask->id !!}" style="clear:both;">
                                                            <div class="task_extra" id="task_extra_{!! $overdueTask->id !!}" >
                                                                <a href="#" onclick="delete_task('{!! $overdueTask->id !!}')" class="task_delete"></a>
                                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $overdueTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                                            </div>

                                                            <input type="checkbox" class="task_status" value="{!! $overdueTask->id !!}" />

                                                            {!! $overdueTask->task !!}

                                                            @if ($overdueTask->firstname != '' && $overdueTask->lastname != '')
                                                                (<a href="add_patient/ed/{!! $overdueTask->patientid !!}/preview/1/addtopat/1/pid/{!! $overdueTask->patientid !!}">{!! $overdueTask->firstname . ' ' . $overdueTask->lastname !!}</a>)
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            @if (count($todayTasks))
                                                <h4 id="pat_task_tod_header" class="task_tod_header">Today</h4>
                                                <ul id="pat_task_tod_list">
                                                    @foreach ($todayTasks as $todayTask)
                                                        <li class="task_item task_{!! $todayTask->id !!}" style="clear:both;">
                                                            <div class="task_extra" id="task_extra_{!! $todayTask->id !!}" >
                                                                <a href="#" onclick="delete_task('{!! $todayTask->id !!}')" class="task_delete"></a>
                                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $todayTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                                            </div>

                                                            <input type="checkbox" class="task_status" value="{!! $todayTask->id !!}" />

                                                            {!! $todayTask->task !!}

                                                            @if ($todayTask->firstname != '' && $todayTask->lastname != '')
                                                                (<a href="add_patient/ed/{!! $todayTask->patientid !!}/preview/1/addtopat/1/pid/{!! $todayTask->patientid !!}">{!! $todayTask->firstname . ' ' . $todayTask->lastname !!}</a>)
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            @if (count($tomorrowTasks))
                                                <h4 id="pat_task_tom_header" class="task_tom_header">Tomorrow</h4>
                                                <ul id="pat_task_tom_list">
                                                    @foreach ($tomorrowTasks as $tomorrowTask)
                                                        <li class="task_item task_{!! $tomorrowTask->id !!}" style="clear:both;">
                                                            <div class="task_extra" id="task_extra_{!! $tomorrowTask->id !!}" >
                                                                <a href="#" onclick="delete_task('{!! $tomorrowTask->id !!}')" class="task_delete"></a>
                                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $tomorrowTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                                            </div>

                                                            <input type="checkbox" class="task_status" value="{!! $tomorrowTask->id !!}" />

                                                            {!! $tomorrowTask->task !!}

                                                            @if ($tomorrowTask->firstname != '' && $tomorrowTask->lastname != '')
                                                                (<a href="add_patient/ed/{!! $tomorrowTask->patientid !!}/preview/1/addtopat/1/pid/{!! $tomorrowTask->patientid !!}">{!! $tomorrowTask->firstname . ' ' . $tomorrowTask->lastname !!}</a>)
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            @if (count($futureTasks))
                                                <h4 id="pat_task_fut_header" class="task_fut_header">Future</h4>
                                                <ul id="pat_task_fut_list">
                                                    @foreach ($futureTasks as $futureTask)
                                                        <li class="task_item task_{!! $futureTask->id !!}" style="clear:both;">
                                                            <div class="task_extra" id="task_extra_{!! $futureTask->id !!}" >
                                                                <a href="#" onclick="delete_task('{!! $futureTask->id !!}')" class="task_delete"></a>
                                                                <a href="#" onclick='loadPopup("/manage/task/add", "{\"id\": {!! $futureTask->id !!}}", "{!! csrf_token() !!}"); return false;' class="task_edit">Edit</a>
                                                            </div>

                                                            <input type="checkbox" class="task_status" value="{!! $futureTask->id !!}" />

                                                            {!! $futureTask->task !!}

                                                            @if ($futureTask->firstname != '' && $futureTask->lastname != '')
                                                                (<a href="add_patient/ed/{!! $futureTask->patientid !!}/preview/1/addtopat/1/pid/{!! $futureTask->patientid !!}">{!! $futureTask->firstname . ' ' . $futureTask->lastname !!}</a>)
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if (!empty($patientId))
                                @if (!empty($hideWarnings))
                                    <a href="#" style="float:left; margin-left:10px;margin-top:8px;" class="button" id="show_patient_warnings" onclick="hideWarnings('hidePatWarnings', null, '{!! Session::get('_token') !!}');$('#patient_warnings').show();$('#show_patient_warnings').hide();$('#hide_patient_warnings').show();return false;">Show Warnings</a>
                                     <a href="#" style="float:left; margin-left:10px;margin-top:8px;display:none" class="button" id="hide_patient_warnings" onclick="hideWarnings('hidePatWarnings', {!! $patientId !!}, '{!! Session::get('_token') !!}');$('#patient_warnings').hide();$('#show_patient_warnings').show();$('#hide_patient_warnings').hide();return false;">Hide Warnings</a>
                                @else 
                                    <a href="#" style="float:left; margin-left:10px;margin-top:8px;display:none" class="button" id="show_patient_warnings" onclick="hideWarnings('hidePatWarnings', null, '{!! Session::get('_token') !!}');$('#patient_warnings').show();$('#show_patient_warnings').hide();$('#hide_patient_warnings').show();return false;">Show Warnings</a>
                                     <a href="#" style="float:left; margin-left:10px;margin-top:8px;" class="button" id="hide_patient_warnings" onclick="hideWarnings('hidePatWarnings', {!! $patientId !!}, '{!! Session::get('_token') !!}');$('#patient_warnings').hide();$('#show_patient_warnings').show();$('#hide_patient_warnings').hide();return false;">Hide Warnings</a>
                                @endif
                            @endif

                            <div class="suckertreemenu">
                                <span style="line-height:38px; margin-right:10px;font-size:20px; color:#fff; float:right;">
                                    Welcome {!! $username !!}
                                </span>
                            </div>

                            @if (!empty($patientId))
                                <div id="patient_nav">
                                    <ul>
                                        @if (!empty($path))
                                            <li>
                                                @if ($path == '/manage/flowsheet3')
                                                    <a class="nav_active" href="flowsheet3/pid/{!! $patientId !!}/addtopat/1">Tracker</a>
                                                @else
                                                    <a href="flowsheet3/pid/{!! $patientId !!}/addtopat/1">Tracker</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if ($path == '/manage/dss_summ')
                                                    <a class="nav_active" href="dss_summ/pid/{!! $patientId !!}/addtopat/1">Summary Sheet</a>
                                                @else
                                                    <a href="dss_summ/pid/{!! $patientId !!}/addtopat/1">Summary Sheet</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if ($path == '/manage/ledger')
                                                    <a class="nav_active" href="manage_ledger/pid/{!! $patientId !!}/addtopat/1">Ledger</a>
                                                @else
                                                    <a href="manage_ledger/pid/{!! $patientId !!}/addtopat/1">Ledger</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if ($path == '/manage/insurance')
                                                    <a class="nav_active" href="insurance/pid/{!! $patientId !!}/addtopat/1">Insurance</a>
                                                @else
                                                    <a href="insurance/pid/{!! $patientId !!}/addtopat/1">Insurance</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if ($path == '/manage/progress_notes')
                                                    <a class="nav_active" href="dss_summ/sect/notes/pid/{!! $patientId !!}/addtopat/1">Progress Notes</a>
                                                @else
                                                    <a href="dss_summ/sect/notes/pid/{!! $patientId !!}/addtopat/1">Progress Notes</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if ($path == '/manage/patient_letters')
                                                    <a class="nav_active" href="dss_summ/sect/letters/pid/{!! $patientId !!}/addtopat/1">Letters</a>
                                                @else
                                                    <a href="dss_summ/sect/letters/pid/{!! $patientId !!}/addtopat/1">Letters</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if ($path == '/manage/q_image')
                                                    <a class="nav_active" href="q_image/pid/{!! $patientId !!}">Images</a>
                                                @else
                                                    <a href="q_image/pid/{!! $patientId !!}">Images</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if ((str_contains($path, 'q_page') || str_contains($path, 'q_sleep')))
                                                    <a class="nav_active" href="q_page1/pid/{!! $patientId !!}/addtopat/1">Questionnaire</a>
                                                @else
                                                    <a href="q_page1/pid/{!! $patientId !!}/addtopat/1">Questionnaire</a>
                                                @endif
                                            </li>

                                            <li>
                                                @if (str_contains($path, 'ex_page'))
                                                    <a class="nav_active" href="ex_page4/pid/{!! $patientId !!}/addtopat/1">Clinical Exam</a>
                                                @else
                                                    <a href="ex_page4/pid/{!! $patientId !!}/addtopat/1">Clinical Exam</a>
                                                @endif
                                            </li>

                                            <li class="last">
                                                @if ($path == '/manage/patient/add')
                                                    <a class="nav_active" href="add_patient/ed/{!! $patientId !!}/preview/1/addtopat/1/pid/{!! $patientId !!}">Patient Info</a>
                                                @else
                                                    <a href="add_patient/ed/{!! $patientId !!}/preview/1/addtopat/1/pid/{!! $patientId !!}">Patient Info</a>
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <div style="clear:both;"></div>
                            @endif
                        </div>

                         <div style="clear:both;"></div>
                    </div>

                    <div style="background:url(/img/dss_03.jpg) repeat-y top left #FFFFFF;" id="contentMain">
                        <div style="clear:both;"></div>

                        @if (!empty($patientId))
                            <div style="margin-left:20px;float:left;width:400px;display:none;">
                                You are currently in a patient chart - 
                                <a href="patient" target="_self" style="font-weight:bold;">BACK TO PATIENT LIST</a>
                            </div>

                            <div style="float:right;width:300px;"></div>
                        @endif

                        <br />

                        @if (!empty($patientId))
                            @if (!empty($hideWarnings))
                                <div id="patient_warnings" style="display:none;">
                            @else
                                <div id="patient_warnings">
                            @endif

                                @if (!empty($showWarningProfile))
                                    <a class="warning" href="patient_changes/pid/{!! $patientId !!}">
                                        <span>Warning! Patient has updated their PROFILE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
                                    </a>
                                @endif

                                @if (!empty($showWarningQuestionnaire))
                                    <a class="warning" href="q_page1/pid/{!! $patientId !!}/addtopat/1" >
                                        <span>Warning! Patient has updated their QUESTIONNAIRE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
                                    </a>
                                @endif

                                @if (!empty($showWarningBounced))
                                    <a class="warning" href="add_patient/ed/{!! $patientId !!}/pid/{!! $patientId !!}/addtopat/1" >
                                        <span>Warning! Email sent to this patient has bounced. Please click to check patients email.</span>
                                    </a>
                                @endif

                                @if (count($rejectedInsurance))
                                    <span class="warning">Warning! Patient has the following rejected claims: <br />

                                        @foreach ($rejectedInsurance as $rejected)
                                            <a href="view_claim/claimid/{!! $rejected->insuranceid !!}/pid/{!! $patientId !!}">
                                                {!! $rejected->insuranceid !!} - {!! date('m/d/Y', strtotime($rejected->adddate)) !!}
                                            </a>
                                            <br />
                                        @endforeach

                                    </span>
                                @endif

                                @if (!empty($hstUncompleted))
                                    <span class="warning">Patient has the following Home Sleep Tests: <br />

                                        @foreach ($hstUncompleted as $hst)
                                            HST was requested {!! date('m/d/Y', strtotime($hst['adddate'])) !!}
                                            and is currently

                                            @if (!empty($DSS_HST_REJECTED) && $hst->status == $DSS_HST_REJECTED)
                                                <a href="hst/status/4/viewed/0">{!! $hstStatusLabel !!}</a>
                                            @else
                                                {!! $hstStatusLabel !!}
                                            @endif

                                            @if (!empty($DSS_HST_SCHEDULED) && $hst->status == $DSS_HST_SCHEDULED)
                                                - {!! $hst->office_notes !!}
                                            @endif

                                            @if (!empty($DSS_HST_REJECTED) && $hst->status == $DSS_HST_REJECTED)
                                                - {!! $hst->rejected_reason !!}
                                            @endif

                                            @if (!empty($DSS_HST_REJECTED) && $hst->status == $DSS_HST_SCHEDULED && $hst->rejecteddate != '')
                                                - {!! date('m/d/Y h:i a', strtotime($hst->rejecteddate)) !!}
                                            @endif

                                            @if (!empty($DSS_HST_REJECTED) && $hst->status == $DSS_HST_REJECTED)
                                                <br />
                                                <a href="hst/status/4/viewed/0">Click here</a> to remove this error
                                            @endif

                                            <br />
                                        @endforeach
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- ========================= Block for content ========================= -->

                        @yield('content')

                        <!-- ===================================================================== -->

                    </div>

                    <div style="margin:0 auto;background:url(/img/dss_05.png) no-repeat top left;width:980px; height:28px;">
                    </div>
                </td>
            </tr>
            <!-- Stick Footer Section Here -->
        </table>
        
        @section('footer')
            <div id="popupContact" style="width:750px;">
                <a id="popupContactClose"><button>X</button></a>

                <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </div>

            <div id="backgroundPopup"></div>

            <div id="warn_logout">
                <br /><br />

                <img src="/img/logo.gif" /><br />

                <h1>Your screen has been locked for privacy due to inactivity.<br />Click to reopen your Dental Sleep Solutions software.</h1>

                <p style="color:#fff;font-size:20px;">Log out in <span id="logout_time_remaining"></span>!</p>

                <br /><br />

                <a href="logout">Logout</a>
                <a href="#" onclick="reset_interval(0)">Stay logged in</a>
            </div>
        @show
    </body>
</html>