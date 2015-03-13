@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/index.css') !!}
    
    {!! HTML::script('/js/manage/sucker_tree_home.js') !!}
@stop

@section('content')

<table>
	<tr>
		<td valign="top" style="border-right:1px solid #00457c;width:980px;">
			<div class="home_third first">
				<h3>Navigation</h3>

				<div class="homesuckertreemenu">
					<ul id="homemenu">
						<li>
							<a href="#">Directory</a>

							<ul>
								<li><a href="contact">Contacts</a></li>
								<li><a href="referredby">Referral List</a></li>
								<li><a href="sleeplab">Sleep Labs</a></li>
								<li><a href="fcontact">Corporate Contacts</a></li>
							</ul>
						</li>

						<li>
							<a href="#">Reports</a>

							<ul>
								<li><a href="ledger_reportfull">Ledger</a></li>
								<li><a href="claims">Claims ({!! $numPendingClaims or '' !!})</a></li>
								<li><a href="performance">Performance</a></li>
								<li><a href="screeners/contacted/0">Pt. Screener</a></li>
								<li><a href='vobs'>VOB History</a></li>

								@if (!empty($showBlock['invoices']))
									<li><a href="invoice_history.php">Invoices</a></li>
								@endif

								<li><a href="manage_faxes.php">Fax History</a></li>
								<li><a href="manage_hst.php">Home Sleep Tests</a></li>
							</ul>
						</li>

						<li>
							<a class="menu_item" href="#">Admin</a>

							<ul>
								<li><a href="claim_setup">Claim Setup</a></li>
								<li><a href="profile">Profile</a></li>
								<li>
									<a href="#">Text</a>
									<ul>
										<li><a href="custom">Custom Text</a></li>
										<li><a href="custom_letters">Custom Letters</a></li>
									</ul>
								</li>
								<li><a href="change_list">Change List</a></li>

								@if (!empty($showBlock['transactionCode']))
									<li><a class="submenu_item" href="transaction_code">Transaction Code</a></li>
								@endif

								<li><a href="staff">Staff</a></li>
								<li>
									<a href="#">Scheduler</a>

									<ul>
										<li><a href="chairs">Resources</a></li>
										<li><a href="appts">Appointment Types</a></li>
									</ul>
								</li>
								<li><a href="export_md" onclick="return (prompt('Enter password')=='1234');">Export MD</a></li>
								<li>
									<a href="#">DSS Files</a>
									
									<ul>
										@foreach ($documentCategories as $documentCategorie)
											<li><a class="submenu_item" href="view_documents/cat/{!! $documentCategorie->categoryid !!}">{!! $documentCategorie->name !!}</a></li>
										@endforeach
									</ul>
								</li>
								<li><a href="locations">Manage Locations</a></li>
								<li><a href="data_import" onclick="return confirm('Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.');">Data Import</a></li>

								@if (!empty($showBlock['enrollments']))
									<li><a href="enrollment">Enrollments</a></li>
								@endif
							</ul>
						</li>

						<li><a href="/screener/auto_login">Pt. Screener App</a></li>
						<li><a href="user_forms">Forms</a></li>
						<li>
							<a href="#">Education</a>

							<ul>
								<li><a href="manual">Dental Sleep Solutions Procedures Manual</a></li>
								<li><a href="medicine_manual">Dental Sleep Medicine Manual</a></li>

								@if (!empty($showBlock['operationsManual']))
									<li><a href="operations_manual">DSS Franchise Operations Manual</a></li>
								@endif

								<li><a href="quick_facts">Quick Facts Reference</a></li>
								<li><a href="videos">Watch Videos</a></li> 

								@if (!empty($showBlock['edxLogin']))
									<li><a href="edx_login" target="_blank">Get C.E.</a></li>
								@endif
								<li><a href="edx_certificate">Certificates</a></li>
							</ul>
						</li>

						<li><a href="sw_tutorials">SW Tutorials</a></li>
						<li><a href="calendar">Scheduler</a></li>
						<li><a href="manage_patient">Manage Pts</a></li>
						<li><a href="#" onclick="loadPopup('includes/device_guide.php'); return false;">Device Selector</a></li>
					</ul>
				</div>
			</div>

			<div class="home_third">
				<h3>Notifications</h3>

				<div class="notsuckertreemenu">
					<ul id="notmenu">
						<li>
							<a href="#" class=" count_{!! $numPortal or '' !!} notification bad_count">{!! $numPortal or '' !!} Web Portal <div class="arrow_right"></div></a>
							<ul>
								<li>
									<a href="patient_contacts" class=" count_{!! $numPatientContacts or '' !!} notification bad_count">
										<span class="count">{!! $numPatientContacts or '' !!}</span>
										<span class="label">Pt Contacts</span>
									</a>
								</li>
								<li>
									<a href="patient_insurance" class=" count_{!! $numPatientInsurance or '' !!} notification bad_count">
										<span class="count">{!! $numPatientInsurance or '' !!}</span>
										<span class="label">Pt Insurance</span>
									</a>
								</li>
								<li>
									<a href="patient_changes" class=" count_{!! $numC or '' !!} notification bad_count">
										<span class="count">{!! $numC or '' !!}</span>
										<span class="label">Pt Changes</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				@if (!empty($useLetters))
					<a href="letters/status/pending" class=" count_{!! $numPendingLetters or '' !!} notification {!! ($numPendingLetters == 0) ? 'good_count' : 'bad_count' !!}">
						<span class="count">
							{!! $numPendingLetters or '' !!}
						</span>
						<span class="label">Letters</span>
					</a>
				@endif

				@if ($showBlock['unmailedLetters'])
					<a href="letters/status/sent/mailed/0" class=" count_{!! $numUnmailedLetters or '' !!} notification bad_count">
						<span class="count">{!! $numUnmailedLetters or '' !!}</span>
						<span class="label">Unmailed Letters</span>
					</a>
				@endif

				<a href="vobs/status/{!! $DSS_PREAUTH_COMPLETE or '' !!}/viewed/0" class=" count_{!! $numPreauth or '' !!} notification {!! ($numPreauth == 0) ? 'good_count' : 'great_count' !!}">
					<span class="count">{!! $numPreauth or '' !!}</span>
					<span class="label">VOBs</span>
				</a>

				<a href="hst/status/{!! $DSS_HST_COMPLETE or '' !!}/viewed/0" class=" count_{!! $numHst or '' !!} notification {!! ($numHst == 0) ? 'good_count' : 'great_count' !!}">
					<span class="count">{!! $numHst or '' !!}</span>
					<span class="label">HSTs</span>
				</a>

				<a href="hst/status/{!! $DSS_HST_REJECTED or '' !!}/viewed/0" class=" count_{!! $numRejectedHst or '' !!} notification {!! ($numRejectedHst == 0) ? 'good_count' : 'bad_count' !!}">
					<span class="count">{!! $numRejectedHst or '' !!}</span>
					<span class="label">Rejected HSTs</span>
				</a>

				<a href="hst/status/{!! $DSS_HST_REQUESTED or '' !!}/viewed/0" class=" count_{!! $numRequestedHst or '' !!} notification {!! ($numRequestedHst == 0) ? 'good_count' : 'bad_count' !!}">
					<span class="count">{!! $numRequestedHst or '' !!}</span>
					<span class="label">Unsent HSTs</span>
				</a>

				@if (!empty($showBlock['pendingNodssClaims']))
					<a href="claims" class="notification  count_{!! $numPendingNodssClaims or '' !!} {!! ($numPendingNodssClaims == 0) ? 'good_count' : 'bad_count' !!}">
						<span class="count">{!! $numPendingNodssClaims or '' !!}</span>
						<span class="label">Pending Claims</span>
					</a>
				@endif

				@if (!empty($showBlock['pendingClaims']))
					<a href="claims" class="notification count_{!! $numPendingClaims or '' !!} {!! ($numPendingClaims == 0) ? 'good_count' : 'bad_count' !!}">
						<span class="count">{!! $numPendingClaims or '' !!}</span>
						<span class="label">Pending Claims</span>
					</a>
				@endif

				@if (!empty($showBlock['unmailedClaims']))
					<a href="claims/unmailed/1" class="notification  count_{!! $numUnmailedClaims or '' !!} {!! ($numUnmailedClaims == 0) ? 'good_count' : 'bad_count' !!}">
						<span class="count">{!! $numUnmailedClaims or '' !!}</span>
						<span class="label">Unmailed Claims</span>
					</a>
				@endif

				<a href="rejected_claims" class=" count_{!! $numRejectedClaims or '' !!} notification {!! ($numRejectedClaims == 0) ? 'good_count' : 'bad_count' !!}">
					<span class="count">{!! $numRejectedClaims or '' !!}</span>
					<span class="label">Rejected Claims</span>
				</a>

				<a href="unsigned_notes" class=" count_{!! $numUnsigned or '' !!} notification {!! ($numUnsigned == 0) ? 'good_count' : 'bad_count' !!}">
					<span class="count">{!! $numUnsigned or '' !!}</span>
					<span class="label">Unsigned Notes</span>
				</a>

				<a href="vobs/status/{!! $DSS_PREAUTH_REJECTED or '' !!}/viewed/0" class=" count_{!! $numAlerts or '' !!} notification bad_count">
					<span class="count">{!! $numAlerts or '' !!}</span>
					<span class="label">Alerts</span>
				</a>

				<a href="faxes" class="notification  count_{!! $numFaxAlerts or '' !!} {!! ($numFaxAlerts == 0) ? 'good_count' : 'bad_count' !!}">
					<span class="count">{!! $numFaxAlerts or '' !!}</span>
					<span class="label">Failed Faxes</span>
				</a>

				<a href="pending_patient" class="notification  count_{!! $numPendingDuplicates or '' !!} {!! ($numPendingDuplicates == 0) ? 'good_count' : 'bad_count' !!}">
					<span class="count">{!! $numPendingDuplicates or '' !!}</span>
					<span class="label">Pending Duplicates</span>
				</a>

				<a href="email_bounces" class="notification  count_{!! $numBounce or '' !!} {!! ($numBounce == 0) ? 'good_count' : 'bad_count' !!}">
					<span class="count">{!! $numBounce or '' !!}</span>
					<span class="label">Email Bounces</span>
				</a>
			</div>

			<div class="home_third">
				<h3>Tasks</h3>

				<div class="task_menu index_task">
					<h4>My Tasks</h4>

					@if (count($overdueTasks))
						<h4 style="margin-bottom:0px;color:red;" class="task_od_header">Overdue</h4>

						<ul class="task_od_list">
							@foreach ($overdueTasks as $overdueTask)
								<li class="task_item task_{!! $overdueTask->id !!}" style="clear:both;">
									<div class="task_extra" id="task_extra_{!! $overdueTask->id !!}" >
										<a href="#" onclick="delete_task('{!! $overdueTask->id !!}')" class="task_delete"></a>
										<a href="#" onclick="loadPopup('add_task/id/{!! $overdueTask->id !!}')" class="task_edit">Edit</a>
									</div>

									<input type="checkbox" style="float:left; " class="task_status" value="{!! $overdueTask->id !!}" />
									
									<div style="float:left; width:170px;">{!! $overdueTask->task !!}
										@if ($overdueTask->firstname != '' && $overdueTask->lastname != '')
											(<a href="add_patient/ed/{!! $overdueTask->patientid !!}/preview/1/addtopat/1/pid/{!! $overdueTask->patientid !!}">{!! $overdueTask->firstname . ' ' . $overdueTask->lastname !!}</a>)
										@endif
									</div>
								</li>
							@endforeach
						</ul>
					@endif

					@if (count($todayTasks))
						<h4 style="margin-bottom:0px" class="task_tod_header">Today</h4>

						<ul class="task_tod_list">
							@foreach ($todayTasks as $todayTask)
								<li class="task_item task_{!! $todayTask->id !!}" style="clear:both;">
									<div class="task_extra" id="task_extra_{!! $todayTask->id !!}" >
										<a href="#" onclick="delete_task('{!! $todayTask->id !!}')" class="task_delete"></a>
										<a href="#" onclick="loadPopup('add_task/id/{!! $todayTask->id !!}')" class="task_edit">Edit</a>
									</div>

									<input type="checkbox" style="float:left; " class="task_status" value="{!! $todayTask->id !!}" />
									
									<div style="float:left; width:170px;">{!! $todayTask->task !!}
										@if ($todayTask->firstname != '' && $todayTask->lastname != '')
											(<a href="add_patient/ed/{!! $todayTask->patientid !!}/preview/1/addtopat/1/pid/{!! $todayTask->patientid !!}">{!! $todayTask->firstname . ' ' . $todayTask->lastname !!}</a>)
										@endif
									</div>
								</li>
							@endforeach
						</ul>
					@endif

					@if (count($tomorrowTasks))
						<h4 style="margin-bottom:0px" class="task_tom_header">Tomorrow</h4>

						<ul class="task_tom_list">
							@foreach ($tomorrowTasks as $tomorrowTask)
								<li class="task_item task_{!! $tomorrowTask->id !!}" style="clear:both;">
									<div class="task_extra" id="task_extra_{!! $tomorrowTask->id !!}" >
										<a href="#" onclick="delete_task('{!! $tomorrowTask->id !!}')" class="task_delete"></a>
										<a href="#" onclick="loadPopup('add_task/id/{!! $tomorrowTask->id !!}')" class="task_edit">Edit</a>
									</div>

									<input type="checkbox" style="float:left; " class="task_status" value="{!! $tomorrowTask->id !!}" />
									
									<div style="float:left; width:170px;">{!! $tomorrowTask->task !!}
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

						<ul class="task_tw_list">
							@foreach ($thisWeekTasks as $thisWeekTask)
								<li class="task_item task_{!! $thisWeekTask->id !!}" style="clear:both;">
									<div class="task_extra" id="task_extra_{!! $thisWeekTask->id !!}" >
										<a href="#" onclick="delete_task('{!! $thisWeekTask->id !!}')" class="task_delete"></a>
										<a href="#" onclick="loadPopup('add_task/id/{!! $thisWeekTask->id !!}')" class="task_edit">Edit</a>
									</div>

									<input type="checkbox" style="float:left; " class="task_status" value="{!! $thisWeekTask->id !!}" />
									
									<div style="float:left; width:170px;">{!! $thisWeekTask->task !!}
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

						<ul class="task_nw_list">
							@foreach ($nextWeekTasks as $nextWeekTask)
								<li class="task_item task_{!! $nextWeekTask->id !!}" style="clear:both;">
									<div class="task_extra" id="task_extra_{!! $nextWeekTask->id !!}" >
										<a href="#" onclick="delete_task('{!! $nextWeekTask->id !!}')" class="task_delete"></a>
										<a href="#" onclick="loadPopup('add_task/id/{!! $nextWeekTask->id !!}')" class="task_edit">Edit</a>
									</div>

									<input type="checkbox" style="float:left; " class="task_status" value="{!! $nextWeekTask->id !!}" />
									
									<div style="float:left; width:170px;">{!! $nextWeekTask->task !!}
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

						<ul class="task_lat_list">
							@foreach ($laterTasks as $laterTask)
								<li class="task_item task_{!! $laterTask->id !!}" style="clear:both;">
									<div class="task_extra" id="task_extra_{!! $laterTask->id !!}" >
										<a href="#" onclick="delete_task('{!! $laterTask->id !!}')" class="task_delete"></a>
										<a href="#" onclick="loadPopup('add_task/id/{!! $laterTask->id !!}')" class="task_edit">Edit</a>
									</div>

									<input type="checkbox" style="float:left; " class="task_status" value="{!! $laterTask->id !!}" />
									
									<div style="float:left; width:170px;">
										{!! date('M d', strtotime($laterTask->due_date)) !!}
										-
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

					<a href="tasks" class="button" style="padding:2px 10px;">View All</a>
				</div>

				<br /><br />

				@if (count($memoAdmins))
					<h3>Messages</h3>

					<div class="task_menu index_task">
						<ul>
							@foreach ($memoAdmins as $memoAdmin)
								<li>{!! $memoAdmin->memo !!}</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div> 
		</td>
	</tr>
</table>

<br /><br />

@stop