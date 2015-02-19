<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin </title>


   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
   <!-- END GLOBAL MANDATORY STYLES -->

   <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
  <!--- <link href="admin/template/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>---->  <!---displays momentary custom boxes on screen  --->
   <link href="/css/admin/template/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
   <link href="/css/admin/template/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
  <!-- <link href="admin/template/assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>--->
   <!-- END PAGE LEVEL PLUGIN STYLES -->

   <!-- BEGIN THEME STYLES -->
   <!--<link href="admin/template/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
   <link href="admin/template/assets/css/style.css" rel="stylesheet" type="text/css"/>
   <link href="admin/template/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>--->
   <link href="/css/admin/template/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="/css/admin/template/assets/css/components.css" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/css/layout.css" rel="stylesheet" type="text/css"/>
   <link href="/css/admin/template/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
   <link href="/cssadmin/template/assets/css/pages/tasks.css" rel="stylesheet" type="text/css"/>

   <link href="/css/admin/template/assets/css/custom.css" rel="stylesheet" type="text/css"/>
   <!-- END THEME STYLES -->
    <link type="text/css" rel="stylesheet" href="/manage/admin/css/bootstrap-datepicker.css">
    <link type="text/css" rel="stylesheet" href="/manage/admin/css/admin.css">

    <script type="text/javascript" src="/js/libs/jquery.js"></script>
    <script type="text/javascript" src="/manage/admin/script/validation.js"></script>
    <script type="text/javascript" src="/manage/admin/script/bootstrap-3.1.0.min.js"></script>
    <script type="text/javascript" src="/manage/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/manage/admin/script/bootstrap-filestyle.min.js"></script>
    <script type="text/javascript" src="/manage/3rdParty/jquery.tablesorter.min.js"></script>
    <!--<script type="text/javascript" src="/manage/admin/script/logout_timer.js"></script>-->
    <script type="text/javascript" src="/manage/script/autocomplete.js"></script>
    <script type="text/javascript" src="/manage/admin/script/reskin.js"></script>
    <script type="text/javascript" src="/manage/3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
     <script src="admin/template/assets/plugins/bootstrap-sessiontimeout/jquery.sessionTimeout.min.js" type="text/javascript"></script>
     <!--   <script type="text/javascript" src="/manage/admin/script/jquery.inputmask.js"></script>
    <script type="text/javascript" src="/manage/admin/script/masks.js"></script>-->

	<script type="text/javascript">
    $(document).ready(function(){
		/*
	modal_change = false;
    $('#popup-window').on('shown.bs.modal', function (e) {
      modal_change = false;
    });
    $('#popup-window').on('hide.bs.modal', function (e) {
      if(modal_change){
        return confirm('Are you sure you want to close this popup?');
      }
    });

	*/

    });
  </script>



    <script>
    function calendar2(){}
    </script>

</head>
<body class="lpage-header-fixed">

        <div class="page-header navbar navbar-fixed-top"><a href="/manage/admin/home.php">
            <h1 class="pull-left" style="color:#ffffff;font-size:17px; margin:12px;">Dental Sleep <span style="color:#187eb7;">Solutions</span></h1>
           </a>
           <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		<div class="menu-toggler sidebar-toggler">
		</div>
		<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<img src="admin/template/assets/img/menu-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
		<ul class="nav navbar-nav pull-right">

			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown dropdown-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<!--<img alt="" src="admin/template/assets/img/avatar1_small.jpg"/>--->
					<i class="fa fa-user"></i>
					<span class="username">
						Test Admin					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="extra_profile.html">
							<i class="fa fa-user"></i> My Profile
						</a>
					</li>

					<li>
						<a href="#">
							<i class="fa fa-tasks"></i> My Tasks
							<span class="badge badge-success">
								 7
							</span>
						</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="javascript:;" id="trigger_fullscreen">
							<i class="fa fa-arrows"></i> Full Screen
						</a>
					</li>
					<li>
						<a href="logout.php">
							<i class="fa fa-key"></i> Log Out
						</a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
	        <div class="clearfix"></div>
        </div>
<div class="page-container">


	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul data-slide-speed="200" data-auto-scroll="true" class="page-sidebar-menu">
				<!---<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM
					<form method="POST" action="extra_search.html" class="sidebar-search">
						<div class="form-container">
							<div class="input-box">
								<a class="remove" href="javascript:;">
								</a>
								<input type="text" placeholder="Search...">
								<input type="button" value=" " class="submit">
							</div>
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM
				</li>---->
				<li class="sidebar-search-wrapper hidden-xs">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search" action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
								<li class="start" >
					<a href="/manage/admin/manage_letters.php" >
						<i class="fa fa-envelope"></i>
						<span class="title" >
							LETTERS
							</span>
							<span class="badge badge-danger">116</span>

						<span class="selected">
						</span>
					</a>
				</li>
												<li>
					<a href="/manage/admin/manage_vobs.php?status=0">
						<i class="fa fa-hospital-o"></i>
						<span class="title">
							VOBs
							</span>
						<span class="badge badge-danger">4</span>

						<span class="selected">
						</span>
					</a>
				</li>


												<li  >
					<a href="/manage/admin/manage_hsts.php?status=1" >
						<i class="fa fa-user-md"></i>
						<span class="title" >
							HSTs
							</span>
							<span class="badge badge-danger">4</span>

						<span class="selected">
						</span>
					</a>
				</li>

				<li id="nn" >
					<a href="/manage/admin/manage_claims.php?status=0">
						<i class="fa fa-medkit"></i>
						<span class="title">
							CLAIMS </span>
							<span class="badge badge-danger">10</span>

						<span class="selected">
						</span>
					</a>
				</li>
												<li >
					<a href="/manage/admin/manage_new_patient_calls.php">
						<i class="fa fa-male"></i>
						<span class="title">
							NEW PATIENT CALLS
						</span>
						<span class="selected">
						</span>
					</a>
				</li>

				<li>
					<a href="javascript:;">
						<i class="fa fa-user"></i>
						<span class="title">
							Users
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Accounts
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
							<li>
									<a href="/manage/admin/companies" id="click_users_a">
										<i class="fa fa-user"></i>Companies
									</a>
							</li>
							<li>
									<a href="/manage/admin/backoffice/users">
										<i class="fa fa-user"></i> Backoffice Accounts
									</a>
							</li>
							<li>
									<a href="/manage/admin/users">
										<i class="fa fa-external-link"></i> User Accounts
									</a>
							</li>
							<li>
									<a href="/manage/admin/export_users.php">
										<i class="fa fa-bell"></i> Export Users
									</a>
							</li>

								<li>
									<a href="/manage/admin/export_users_emails.php">
										<i class="fa fa-bell"></i>Export Active User Emails
									</a>
								</li>
							<li>
									<a href="/manage/admin/insurance_officeally_select.php">
										<i class="fa fa-bell"></i>Export Pending Office Ally Claims
									</a>
								</li>
																<li>
									<a href="/manage/admin/accesscode">
										<i class="fa fa-bell"></i>Access Codes
									</a>
								</li>
								<li>
									<a href="/manage/admin/plan">
										<i class="fa fa-bell"></i>Plans
									</a>
								</li>
															</ul>
						</li>
						<li>
							<a href="/manage/admin/manage_patient.php">
								<i class="fa fa-folder-open"></i>
								Patient List (All)
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Account Analysis
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
																<li>
									<a href="/manage/admin/manage_percase_invoice.php">
										<i class="fa fa-user"></i>Invoicing
									</a>
								</li>


								<li>
									<a href="/manage/admin/manage_monthly_invoice.php">
										<i class="fa fa-bell"></i> Monthly Invoicing
									</a>
								</li>
                                                                <li>
                                                                        <a href="/manage/admin/manage_monthly_bo_invoice.php">
                                                                                <i class="fa fa-bell"></i> Monthly Backoffice Invoicing
                                                                        </a>
                                                                </li>

								<li>
									<a href="/manage/admin/manage_payment_errors.php">
										<i class="fa fa-bell"></i> Invoicing Payment Errors
									</a>
								</li>

								<li>
									<a href="/manage/admin/franchisee_faxes.php">
										<i class="fa fa-bell"></i>Fax Report
									</a>
								</li>
								<li>
									<a href="/manage/admin/client_tracking.php">
										<i class="fa fa-bell"></i>Client Tracking
									</a>
								</li>

								<li>
									<a href="/manage/admin/franchisee_monthly.php">
										<i class="fa fa-bell"></i>Monthly Report
									</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Insurance Codes
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
																<li>
									<a href="/manage/admin/manage_transaction_code.php">
										<i class="fa fa-user"></i>Default Codes (Global)
									</a>
								</li>
																<li>
									<a href="/manage/admin/manage_doctor_transaction_code_list.php">
										<i class="fa fa-bell"></i>User Codes (Individual)
									</a>
								</li>
								<li style="display:none;">
									<a href="/manage/admin/manage_doctor_transaction_code.php">
										<i class="fa fa-bell"></i>User Codes (Individual)
									</a>
								</li>

							</ul>
						</li>
						  						<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Note Text
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">


								<li>
									<a href="/manage/admin/manage_custom_text.php">
										<i class="fa fa-user"></i>Progress Default Text (Global)
									</a>
								</li>

								<li>
									<a href="/manage/admin/manage_doctor_custom_text_list.php">
										<i class="fa fa-bell"></i>Progress User Text (Individual)
									</a>
								</li>

								<li>
									<a href="/manage/admin/manage_claim_text.php">
										<i class="fa fa-bell"></i>Claim Default Text (Global)
									</a>
								</li>
                                                                <li>
                                                                        <a href="/manage/admin/manage_company_claim_text_list.php">
                                                                                <i class="fa fa-bell"></i>Claim Company Text (Individual)
                                                                        </a>
                                                                </li>
							  							</ul>
						</li>
												<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Password
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/changepassword.php">
										<i class="fa fa-user"></i>Change My Password
									</a>
								</li>
							</ul>
						</li>
						 						<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Security
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_log.php">
										<i class="fa fa-user"></i>Login Data
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_pages.php">
										<i class="fa fa-user"></i>Custom Pages
									</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="/manage/admin/email_bounce.php">
								<i class="fa fa-cogs"></i> Email Bounces
								<span class="arrow">
								</span>
							</a>
						</li>

					</ul>
				</li>

				<li>
					<a href="javascript:;">
						<i class="fa  fa-desktop"></i>
						<span class="title">
							SOFTWARE
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">

						<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Questionnaire Edits
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										Bmi/Symptoms
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_complaint.php">
												<i class="fa fa-remove"></i> Chief Complaint
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										Sleepiness test
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_epworth.php">
												<i class="fa fa-remove"></i> Epworth
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										Sleep Study / Cpap
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_intolerance.php">
												<i class="fa fa-remove"></i> Cpap Intolerance
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										Medical Hx
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_allergens.php">
												<i class="fa fa-remove"></i> Allergens
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_medications.php">
												<i class="fa fa-remove"></i> Medications
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_history.php">
												<i class="fa fa-remove"></i> Medical Hx
											</a>
										</li>
									</ul>
								</li>

							</ul>
						</li>
						<li>
							<a href="javascript:;">
								<i class="fa fa-cogs"></i> Clinical Exam Edits
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										Dental Exam
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_exam_teeth.php">
												<i class="fa fa-remove"></i> Teeth Examination
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										Vital Data / Tongue
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_tongue.php">
												<i class="fa fa-remove"></i> Tongue Evaluation
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										Airway Evaluation
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_maxilla.php">
												<i class="fa fa-remove"></i> Maxilla
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_mandible.php">
												<i class="fa fa-remove"></i> Mandible
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_soft_palate.php">
												<i class="fa fa-remove"></i> Soft Palate
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_uvula.php">
												<i class="fa fa-remove"></i> Uvula
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_gag_reflex.php">
												<i class="fa fa-remove"></i> Gag Reflex
											</a>
										</li>
										<li>
										<li><a href="/manage/admin/manage_nasal_passages.php">
												<i class="fa fa-remove"></i> Nasal Passages
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<i class="fa fa-user"></i>
										TMJ / ROM
										<span class="arrow">
										</span>
									</a>
									<ul class="sub-menu">
										<li>
										<a href="/manage/admin/manage_palpation.php">
												<i class="fa fa-remove"></i> Muscles & Palpation
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_joint_exam.php">
												<i class="fa fa-remove"></i> Joint Exam Type
											</a>
										</li>
										<li>
										<a href="/manage/admin/manage_joint.php">
												<i class="fa fa-remove"></i> Joint Exam
											</a>
										</li>
									</ul>
								</li>

							</ul>
						</li>


						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Contacts (Global List And Type)
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_contacttype.php">
										<i class="fa fa-user"></i> Contact Types
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_fcontact.php">
										<i class="fa fa-external-link"></i> Corporate Contacts (Global List)
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_doc_lab.php">
										<i class="fa fa-bell"></i> Dental Appliance Labs (Global List)
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_doc_insurance.php">
										<i class="fa fa-bell"></i> Insurance Info (Global List)
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Images
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_imagetype.php">
										<i class="fa fa-user"></i> Image Type (Global List)
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Letters
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_default_letters.php">
										<i class="fa fa-user"></i> Default Letters
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Home Page
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_change_list.php">
										<i class="fa fa-user"></i> Change List
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_doc_welcome.php">
										<i class="fa fa-external-link"></i> Welcome Screen Message (Global)
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_memos.php">
										<i class="fa fa-bell"></i> Memos
									</a>
								</li>
							</ul>
						</li>


						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Insurance Claim
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_ins_diagnosis.php">
										<i class="fa fa-user"></i> Insurance Diagnosis
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_place_service.php">
										<i class="fa fa-external-link"></i> Place Of Service
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_type_service.php">
										<i class="fa fa-bell"></i> Type Of Service
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_cpt_code.php">
										<i class="fa fa-bell"></i> Cpt Code
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_modifier_code.php">
										<i class="fa fa-bell"></i> Modifier Code
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Files
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_doc_categories.php">
										<i class="fa fa-user"></i> Dss Files For Franchisees (Global)
									</a>
								</li>
							</ul>
						</li>


						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Additional Items
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_ins_type.php">
										<i class="fa fa-user"></i> Insurance Type
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_diagnostic.php">
										<i class="fa fa-external-link"></i> Diagnostic Test
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_assessment.php">
										<i class="fa fa-bell"></i> Assessment
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_assess_addition.php">
										<i class="fa fa-bell"></i> Assessment Addition
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_consultation.php">
										<i class="fa fa-bell"></i> Consultation
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_evaluation_new.php">
										<i class="fa fa-bell"></i> Evaluation New
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_evaluation_est.php">
										<i class="fa fa-bell"></i> Evaluation Established
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_plan_text.php">
										<i class="fa fa-bell"></i> Plan / Progress Text
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Flowsheet
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_flowsheet_steps.php">
										<i class="fa fa-user"></i> Steps
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="javascript:;">
								<i class="fa fa-globe"></i> Dental Devices
								<span class="arrow">
								</span>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="/manage/admin/manage_device.php">
										<i class="fa fa-user"></i> Dental Device List
									</a>
								</li>
								<li>
									<a href="/manage/admin/manage_device_guide_settings.php">
										<i class="fa fa-user"></i> Settings
									</a>
								</li>
							</ul>
						</li>


						<li>
						<a href="/manage/admin/manage_claim_settings.php">
								<i class="fa fa-folder-open"></i>Claim Settings
							</a>
						</li>
						<li>
						<a href="/manage/admin/manage_claim_history.php">
								<i class="fa fa-folder-open"></i>Electronic Claim History
							</a>
						</li>
					</ul>
				</li>



			<li id="active_container">
				<a href="javascript:;">
					<i class="fa  fa-question"></i>
					<span class="title">
							TICKETS
					</span>
					<span class="badge badge-danger">21</span>
					<span class="arrow">
					</span>
				</a>
				<ul class="sub-menu">
					<li>
						<a href="/manage/admin/manage_support_tickets.php">
							<i class="fa fa-user"></i> Tickets
						</a>
					</li>

					<li>
						<a href="/manage/admin/manage_support_categories.php">
							<i class="fa fa-user"></i> Categories
						</a>
					</li>
				</ul>
			</li>


			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>


   <div class="page-content-wrapper">
       <div class="page-content" >


<div class="row1">  </div>

    <div style="margin-top: 50px;">
        @yield('content')
    </div>

<br /><br />
        </div>
        </div>
   </div>

<div class="page-footer">
	<div class="page-footer-inner">
		 &copy; dentalsleepsolutions.com
	</div>
	<div class="page-footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>

        <!--<div class="well text-center">
            &copy; dentalsleepsolutions.com
        </div>--->


    <div class="modal fade" id="go-to-sleep" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Inactivity</h4>
                </div>
                <div class="modal-body">
                    <div class="media">
                        <a class="pull-left" href="/manage/admin/home.php">
                            <img class="media-object" width="88" height="71" src="/manage/images/logo.gif" alt="Dental Sleep Solutions">
                        </a>
                        <div class="media-body lead">
                            Your screen has been locked for privacy due to inactivity.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-left">
                        Log out in <span id="sleep-time">0 minutes</span>!
                    </span>
                    <a href="/manage/admin/logout" class="btn btn-danger">Logout</a>
                    <a href="#" class="btn btn-default" data-dismiss="modal">Stay logged in</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="popup-window">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <iframe style="border:none;margin:0;padding:0;width:100%;height:540px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	<!--[if lt IE 9]>
	<script src="assets/plugins/respond.min.js"></script>
	<script src="assets/plugins/excanvas.min.js"></script>
	<![endif]-->

	<!--<script src="admin/template/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>-->
	<script src="admin/template/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- <script src="admin/template/assets/scripts/core/app.js" type="text/javascript"></script>-->
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="/js/libs/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<script src="/js/libs/jquery.cokie.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="/css/admin/template/assets/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
	<script src="/js/libs/moment.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script type="text/javascript" src="/manage/admin/script/bootstrap-datepicker.js"></script>
	<!---<script src="admin/template/assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>---><!---displays momentary custom boxes on screen  --->
	<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
	<script src="/css/admin/template/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jquery-easypiechart/jquery.easypiechart.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="/css/admin/template/assets/scripts/core/metronic.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/scripts/custom/layout.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/scripts/custom/quick-sidebar.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/scripts/custom/index.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/scripts/custom/tasks.js" type="text/javascript"></script>

	<script src="/css/admin/template/assets/plugins/jquery-idle-timeout/jquery.idletimeout.js" type="text/javascript"></script>
	<script src="/css/admin/template/assets/plugins/jquery-idle-timeout/jquery.idletimer.js" type="text/javascript"></script>

	<script src="/css/admin/template/assets/scripts/custom/ui-idletimeout.js"></script>

	<!-- END PAGE LEVEL SCRIPTS -->

	<script>
jQuery(document).ready(function() {
   //Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();
   Index.initDashboardDaterange();
   Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   //Index.initIntro();
   Tasks.initDashboardWidget();
});
</script>
	<!-- END JAVASCRIPTS -->

 <script type='text/javascript'>
    			var userid=7

	</script>
	<script type="text/javascript">

	jQuery(document).ready(function() {
	   Metronic.init();
	   UIIdleTimeout.init();


	   var queryst = window.location.search;
	   var addr="home.php";
	   var path_name=addr+queryst;
	   //alert(addr);
	   var redirUrl_path='extra_lock.php?id='+userid+'&&addr='+path_name;
	    $.idleTimeout('#idle-timeout-dialog', '.modal-content button:last', {
                idleAfter: 900, // 5 seconds 900
                timeout: 2100, //30 seconds to timeout 2100000
                pollingInterval: 5, // 5 seconds 900
                //keepAliveURL: 'demo/idletimeout_keepalive.php',
                serverResponseEquals: 'OK',
                onTimeout: function(){
                    window.location = 'logout.php';
                },
                onIdle: function(){
                    $('#idle-timeout-dialog').modal('show');
                    $countdown = $('#idle-timeout-counter');

                    $('#idle-timeout-dialog-keepalive').on('click', function () {
                        $('#idle-timeout-dialog').modal('hide');
                    });

                    $('#idle-timeout-dialog-logout').on('click', function () {
                        $('#idle-timeout-dialog').modal('hide');
                        $.idleTimeout.options.onTimeout.call(this);
                    });
                },
                onCountdown: function(counter){
                    $countdown.html(counter); // update the counter
                }
            });


	   // initialize session timeout settings
	   /*
	   $.sessionTimeout({
		title: 'Session Timeout Notification',
		message: 'Your session is about to expire.',
		keepAliveUrl: 'admin/template/demo/timeout-keep-alive.php',
		redirUrl:redirUrl_path,
		logoutUrl: 'index.php',
		warnAfter: 780000, //warn after 5 seconds
		redirAfter: 900000//redirect after 10 seconds

	   });
	   */

	});
	</script>

	<script>
		jQuery(document).ready(function(){
			//handles sidebar and content height
		var handleSidebarAndContentHeight = function () {
        var content = $('.page-content');
        var sidebar = $('.page-sidebar');
        var body = $('body');
        var height;

        if (body.hasClass("page-footer-fixed") === true && body.hasClass("page-sidebar-fixed") === false) {
            var available_height = Metronic.getViewPort().height - $('.page-footer').outerHeight() - $('.page-header').outerHeight();
            if (content.height() < available_height) {
                content.attr('style', 'min-height:' + available_height + 'px');
            }
        } else {
            if (body.hasClass('page-sidebar-fixed')) {
                height = _calculateFixedSidebarViewportHeight();
                if (body.hasClass('page-footer-fixed') === false) {
                    height = height - $('.page-footer').outerHeight();
                }
            } else {
                var headerHeight = $('.page-header').outerHeight();
                var footerHeight = $('.page-footer').outerHeight();

                if (Metronic.getViewPort().width < 992) {
                    height = Metronic.getViewPort().height - headerHeight - footerHeight;
                } else {
                    height = sidebar.height() + 20;
                }

                if ($(window).width() > 1024 && (height + headerHeight + footerHeight) < Metronic.getViewPort().height) {
                    height = Metronic.getViewPort().height - headerHeight - footerHeight;
                }
            }

            content.attr('style', 'min-height:' + height + 'px');
        }
    }

				//handles sidebar and content height



		var path=window.location.pathname;
		var query = window.location.search;
		var pathname=path+query;
			//alert(pathname);
			$('.page-sidebar-menu').find('li a[href$="' + pathname + '"]').parents('li').addClass('active').each(function(){
            var $this = $(this);
          	$this.parents('ul').parents('li').each(function(){

				   $(this).addClass('active');
				   $(this).find('a > span.arrow').addClass('open');
				   $(this).find('a > span.arrow').append('<span class="selected"></span>');
				   $(this).children().find('a > span.arrow').addClass('open');
				    handleSidebarAndContentHeight();

			});

		});

	});

	</script>


</body>
</html>
