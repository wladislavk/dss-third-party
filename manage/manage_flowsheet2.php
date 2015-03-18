<?php namespace Ds3\Libraries\Legacy; ?><? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

if($_POST["flowsheetsub"] == 1)
{
	$inquiry_call_comp = $_POST['inquiry_call_comp'];
	$send_np = $_POST['send_np'];
	$send_np_comp = $_POST['send_np_comp'];
	$acquire_ss_apt = $_POST['acquire_ss_apt'];
	$acquire_ss_comp = $_POST['acquire_ss_comp'];
	$pt_not_ss = $_POST['pt_not_ss'];
	$ss_date_requested = $_POST['ss_date_requested'];
	$ss_date_received = $_POST['ss_date_received'];
	$date_referred = $_POST['date_referred'];
	$dss_dentists = $_POST['dss_dentists'];
	$ss_requested_apt = $_POST['ss_requested_apt'];
	$ss_requested_comp = $_POST['ss_requested_comp'];
	$ss_received_apt = $_POST['ss_received_apt'];
	$ss_received_comp = $_POST['ss_received_comp'];
	$consultation_apt = $_POST['consultation_apt'];
	$consultation_comp = $_POST['consultation_comp'];
	$m_insurance_date = $_POST['m_insurance_date'];
	$select_type = $_POST['select_type'];
	$exam_impressions_apt = $_POST['exam_impressions_apt'];
	$exam_impressions_comp = $_POST['exam_impressions_comp'];
	$dsr_prepared = $_POST['dsr_prepared'];
	$dsr_sent = $_POST['dsr_sent'];
	$delivery_device_apt = $_POST['delivery_device_apt'];
	$delivery_device_comp = $_POST['delivery_device_comp'];
	$dsr_date_delivered = $_POST['dsr_date_delivered'];
	$ltr_phy_prepared = $_POST['ltr_phy_prepared'];
	$ltr_phy_sent = $_POST['ltr_phy_sent'];
	$first_check_apt = $_POST['first_check_apt'];
	$first_check_comp = $_POST['first_check_comp'];
	$add_check_apt = $_POST['add_check_apt'];
	$add_check_comp = $_POST['add_check_comp'];
	$home_sleep_apt = $_POST['home_sleep_apt'];
	$home_sleep_comp = $_POST['home_sleep_comp'];
	$further_checks_apt = $_POST['further_checks_apt'];
	$further_checks_comp = $_POST['further_checks_comp'];
	$comp_treatment_date = $_POST['comp_treatment_date'];
	$portable_date_comp = $_POST['portable_date_comp'];
	$treatment_success = $_POST['treatment_success'];
	$ltr_doc_ss_date_prepared = $_POST['ltr_doc_ss_date_prepared'];
	$ltr_doc_ss_date_sent = $_POST['ltr_doc_ss_date_sent'];
	$annual_exam_apt = $_POST['annual_exam_apt'];
	$annual_exam_comp = $_POST['annual_exam_comp'];
	$ltr_doc_pt_date_prepared = $_POST['ltr_doc_pt_date_prepared'];
	$ltr_doc_pt_date_sent = $_POST['ltr_doc_pt_date_sent'];
	$ambulatory_ss_apt = $_POST['ambulatory_ss_apt'];
	$ambulatory_ss_comp = $_POST['ambulatory_ss_comp'];
	$diag_s_md_sent = $_POST['diag_s_md_sent'];
	$diag_s_md_received = $_POST['diag_s_md_received'];
	$psg_apt = $_POST['psg_apt'];
	$psg_comp = $_POST['psg_comp'];
	$sleep_lab = $_POST['sleep_lab'];
	$lomn = $_POST['lomn'];
	$rxfrommd = $_POST['rxfrommd'];
	$not_candidate = $_POST['not_candidate'];
	$financial_restraints = $_POST['financial_restraints'];
	$pt_needing_dental_work = $_POST['pt_needing_dental_work'];
	$inadequate_dentition = $_POST['inadequate_dentition'];
	$pt_not_ds_other = $_POST['pt_not_ds_other'];
	$ltr_pp_date_prepared = $_POST['ltr_pp_date_prepared'];
	$ltr_pp_date_sent = $_POST['ltr_pp_date_sent'];
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_flowsheet_new set 
		patientid = '".s_for($_GET['pid'])."',
		inquiry_call_comp = '".s_for($inquiry_call_comp)."',
		send_np = '".s_for($send_np)."',
		send_np_comp = '".s_for($send_np_comp)."',
		acquire_ss_apt = '".s_for($acquire_ss_apt)."',
		acquire_ss_comp = '".s_for($acquire_ss_comp)."',
		pt_not_ss = '".s_for($pt_not_ss)."',
		ss_date_requested = '".s_for($ss_date_requested)."',
		ss_date_received = '".s_for($ss_date_received)."',
		date_referred = '".s_for($date_referred)."',
		dss_dentists = '".s_for($dss_dentists)."',
		ss_requested_apt = '".s_for($ss_requested_apt)."',
		ss_requested_comp = '".s_for($ss_requested_comp)."',
		ss_received_apt = '".s_for($ss_received_apt)."',
		ss_received_comp = '".s_for($ss_received_comp)."',
		consultation_apt = '".s_for($consultation_apt)."',
		m_insurance_date = '".s_for($m_insurance_date)."',
		select_type = '".s_for($select_type)."',
		exam_impressions_apt = '".s_for($exam_impressions_apt)."',
		exam_impressions_comp = '".s_for($exam_impressions_comp)."',
		dsr_prepared = '".s_for($dsr_prepared)."',
		dsr_sent = '".s_for($dsr_sent)."',
		delivery_device_apt = '".s_for($delivery_device_apt)."',
		delivery_device_comp = '".s_for($delivery_device_comp)."',
		dsr_date_delivered = '".s_for($dsr_date_delivered)."',
		ltr_phy_prepared = '".s_for($ltr_phy_prepared)."',
		ltr_phy_sent = '".s_for($ltr_phy_sent)."',
		first_check_apt = '".s_for($first_check_apt)."',
		first_check_comp = '".s_for($first_check_comp)."',
		add_check_apt = '".s_for($add_check_apt)."',
		add_check_comp = '".s_for($add_check_comp)."',
		home_sleep_apt = '".s_for($home_sleep_apt)."',
		home_sleep_comp = '".s_for($home_sleep_comp)."',
		further_checks_apt = '".s_for($further_checks_apt)."',
		further_checks_comp = '".s_for($further_checks_comp)."',
		comp_treatment_date = '".s_for($comp_treatment_date)."',
		portable_date_comp = '".s_for($portable_date_comp)."',
		treatment_success = '".s_for($treatment_success)."',
		ltr_doc_ss_date_prepared = '".s_for($ltr_doc_ss_date_prepared)."',
		ltr_doc_ss_date_sent = '".s_for($ltr_doc_ss_date_sent)."',
		annual_exam_apt = '".s_for($annual_exam_apt)."',
		annual_exam_comp = '".s_for($annual_exam_comp)."',
		ltr_doc_pt_date_prepared = '".s_for($ltr_doc_pt_date_prepared)."',
		ltr_doc_pt_date_sent = '".s_for($ltr_doc_pt_date_sent)."',
		ambulatory_ss_apt = '".s_for($ambulatory_ss_apt)."',
		ambulatory_ss_comp = '".s_for($ambulatory_ss_comp)."',
		diag_s_md_sent = '".s_for($diag_s_md_sent)."',
		diag_s_md_received = '".s_for($diag_s_md_received)."',
		psg_apt = '".s_for($psg_apt)."',
		psg_comp = '".s_for($psg_comp)."',
		sleep_lab = '".s_for($sleep_lab)."',
		lomn = '".s_for($lomn)."',
		rxfrommd = '".s_for($rxfrommd)."',
		not_candidate = '".s_for($not_candidate)."',
		financial_restraints = '".s_for($financial_restraints)."',
		pt_needing_dental_work = '".s_for($pt_needing_dental_work)."',
		inadequate_dentition = '".s_for($inadequate_dentition)."',
		pt_not_ds_other = '".s_for($pt_not_ds_other)."',
		ltr_pp_date_prepared = '".s_for($ltr_pp_date_prepared)."',
		ltr_pp_date_sent = '".s_for($ltr_pp_date_sent)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or trigger_error($ins_sql." | ".mysql_error(), E_USER_ERROR);
		
		$msg = "Added Successfully - Please complete step 1 in the flowsheet \"INQUIRY CALL\"";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>';
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
	else
	{
	$patientid = $_GET['pid'];
	$getcstep_query = "SELECT step,sstep FROM dental_flowsheet_new WHERE patientid =".$patientid;
	
	$getcstep_array = mysql_query($getcstep_query);
	
	while($getcstep = mysql_fetch_array($getcstep_array)){
    $stepq = $getcstep['step'];
    $sstepq = $getcstep['sstep'];
  }
	
	
	
	if(isset($_POST['step0']) || $stepq == 1){
  $step = 1;
  }
  if(isset($_POST['step1']) || $stepq == 2){
  $step = 2;
  }
  if(isset($_POST['step2']) || $stepq == 3){
  $step = 3;
  }
  if(isset($_POST['step3']) || $stepq == 4){
  $step = 4;
  }
  if(isset($_POST['step4']) || $stepq == 5){
  $step = 5;
  }
  
  
  if(isset($_POST['ssstep50']) || $sstepq == 51){
  $sstep = 51;
  }
  if(isset($_POST['sstep51']) || $sstepq == 52){
  $sstep = 52;
  }
  if(isset($_POST['sstep52']) || $sstepq == 53){
  $sstep = 53;
  }
  if(isset($_POST['sstep53']) || $sstepq == 54){
  $sstep = 54;
  }
  if(isset($_POST['sstep54']) || $sstepq == 55){
  $sstep = 55;
  }
  if(isset($_POST['sstep50']) || $sstepq == 56){
  $sstep = 56;
  }
  if(isset($_POST['sstep56']) || $sstepq == 57){
  $sstep = 57;
  }
  if(isset($_POST['sstep57']) || $sstepq == 58){
  $sstep = 58;
  }
  if(isset($_POST['sstep58']) || $sstepq == 59){
  $sstep = 59;
  }

		$up_sql = "update dental_flowsheet_new set 
		patientid = '".s_for($_GET['pid'])."',
		inquiry_call_comp = '".s_for($inquiry_call_comp)."',
		send_np = '".s_for($send_np)."',
		send_np_comp = '".s_for($send_np_comp)."',
		acquire_ss_apt = '".s_for($acquire_ss_apt)."',
		acquire_ss_comp = '".s_for($acquire_ss_comp)."',
		pt_not_ss = '".s_for($pt_not_ss)."',
		ss_date_requested = '".s_for($ss_date_requested)."',
		ss_date_received = '".s_for($ss_date_received)."',
		date_referred = '".s_for($date_referred)."',
		dss_dentists = '".s_for($dss_dentists)."',
		ss_requested_apt = '".s_for($ss_requested_apt)."',
		ss_requested_comp = '".s_for($ss_requested_comp)."',
		ss_received_apt = '".s_for($ss_received_apt)."',
		ss_received_comp = '".s_for($ss_received_comp)."',
		consultation_apt = '".s_for($consultation_apt)."',
		m_insurance_date = '".s_for($m_insurance_date)."',
		select_type = '".s_for($select_type)."',
		exam_impressions_apt = '".s_for($exam_impressions_apt)."',
		exam_impressions_comp = '".s_for($exam_impressions_comp)."',
		dsr_prepared = '".s_for($dsr_prepared)."',
		dsr_sent = '".s_for($dsr_sent)."',
		delivery_device_apt = '".s_for($delivery_device_apt)."',
		delivery_device_comp = '".s_for($delivery_device_comp)."',
		dsr_date_delivered = '".s_for($dsr_date_delivered)."',
		ltr_phy_prepared = '".s_for($ltr_phy_prepared)."',
		ltr_phy_sent = '".s_for($ltr_phy_sent)."',
		first_check_apt = '".s_for($first_check_apt)."',
		first_check_comp = '".s_for($first_check_comp)."',
		add_check_apt = '".s_for($add_check_apt)."',
		add_check_comp = '".s_for($add_check_comp)."',
		home_sleep_apt = '".s_for($home_sleep_apt)."',
		home_sleep_comp = '".s_for($home_sleep_comp)."',
		further_checks_apt = '".s_for($further_checks_apt)."',
		further_checks_comp = '".s_for($further_checks_comp)."',
		comp_treatment_date = '".s_for($comp_treatment_date)."',
		portable_date_comp = '".s_for($portable_date_comp)."',
		treatment_success = '".s_for($treatment_success)."',
		ltr_doc_ss_date_prepared = '".s_for($ltr_doc_ss_date_prepared)."',
		ltr_doc_ss_date_sent = '".s_for($ltr_doc_ss_date_sent)."',
		annual_exam_apt = '".s_for($annual_exam_apt)."',
		annual_exam_comp = '".s_for($annual_exam_comp)."',
		ltr_doc_pt_date_prepared = '".s_for($ltr_doc_pt_date_prepared)."',
		ltr_doc_pt_date_sent = '".s_for($ltr_doc_pt_date_sent)."',
		ambulatory_ss_apt = '".s_for($ambulatory_ss_apt)."',
		ambulatory_ss_comp = '".s_for($ambulatory_ss_comp)."',
		diag_s_md_sent = '".s_for($diag_s_md_sent)."',
		diag_s_md_received = '".s_for($diag_s_md_received)."',
		psg_apt = '".s_for($psg_apt)."',
		psg_comp = '".s_for($psg_comp)."',
		sleep_lab = '".s_for($sleep_lab)."',
		lomn = '".s_for($lomn)."',
		rxfrommd = '".s_for($rxfrommd)."',
		not_candidate = '".s_for($not_candidate)."',
		financial_restraints = '".s_for($financial_restraints)."',
		pt_needing_dental_work = '".s_for($pt_needing_dental_work)."',
		inadequate_dentition = '".s_for($inadequate_dentition)."',
		pt_not_ds_other = '".s_for($pt_not_ds_other)."',
		ltr_pp_date_prepared = '".s_for($ltr_pp_date_prepared)."',
		ltr_pp_date_sent = '".s_for($ltr_pp_date_sent)."',
		userid = '".s_for($_SESSION['userid'])."',
		sstep = '".$sstep."',
		step = '".$step."' where flowsheetid='".$_POST["ed"]."'";
		
		mysql_query($up_sql) or trigger_error($up_sql." | ".mysql_error(), E_USER_ERROR);
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>&pid=<?=$_GET['pid'];?>';
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$sql = "select * from dental_flowsheet_new where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate";
$my = mysql_query($sql) or trigger_error(mysql_error(), E_USER_ERROR);
$myarray = mysql_fetch_array($my);

$flowsheetid = st($myarray['flowsheetid']);
$inquiry_call_comp = st($myarray['inquiry_call_comp']);
$send_np = st($myarray['send_np']);
$send_np_comp = st($myarray['send_np_comp']);
$acquire_ss_apt = st($myarray['acquire_ss_apt']);
$acquire_ss_comp = st($myarray['acquire_ss_comp']);
$pt_not_ss = st($myarray['pt_not_ss']);
$ss_date_requested = st($myarray['ss_date_requested']);
$ss_date_received = st($myarray['ss_date_received']);
$date_referred = st($myarray['date_referred']);
$dss_dentists = st($myarray['dss_dentists']);
$ss_requested_apt = st($myarray['ss_requested_apt']);
$ss_requested_comp = st($myarray['ss_requested_comp']);
$ss_received_apt = st($myarray['ss_received_apt']);
$ss_received_comp = st($myarray['ss_received_comp']);
$consultation_apt = st($myarray['consultation_apt']);
$consultation_comp = st($myarray['consultation_comp']);
$m_insurance_date = st($myarray['m_insurance_date']);
$select_type = st($myarray['select_type']);
$exam_impressions_apt = st($myarray['exam_impressions_apt']);
$exam_impressions_comp = st($myarray['exam_impressions_comp']);
$dsr_prepared = st($myarray['dsr_prepared']);
$dsr_sent = st($myarray['dsr_sent']);
$delivery_device_apt = st($myarray['delivery_device_apt']);
$delivery_device_comp = st($myarray['delivery_device_comp']);
$dsr_date_delivered = st($myarray['dsr_date_delivered']);
$ltr_phy_prepared = st($myarray['ltr_phy_prepared']);
$ltr_phy_sent = st($myarray['ltr_phy_sent']);
$first_check_apt = st($myarray['first_check_apt']);
$first_check_comp = st($myarray['first_check_comp']);
$add_check_apt = st($myarray['add_check_apt']);
$add_check_comp = st($myarray['add_check_comp']);
$home_sleep_apt = st($myarray['home_sleep_apt']);
$home_sleep_comp = st($myarray['home_sleep_comp']);
$further_checks_apt = st($myarray['further_checks_apt']);
$further_checks_comp = st($myarray['further_checks_comp']);
$comp_treatment_comp = st($myarray['comp_treatment_comp']);
$portable_date_comp = st($myarray['portable_date_comp']);
$treatment_success = st($myarray['treatment_success']);
$ltr_doc_ss_date_prepared = st($myarray['ltr_doc_ss_date_prepared']);
$ltr_doc_ss_date_sent = st($myarray['ltr_doc_ss_date_sent']);
$annual_exam_apt = st($myarray['annual_exam_apt']);
$annual_exam_comp = st($myarray['annual_exam_comp']);
$ltr_doc_pt_date_prepared = st($myarray['ltr_doc_pt_date_prepared']);
$ltr_doc_pt_date_sent = st($myarray['ltr_doc_pt_date_sent']);
$ambulatory_ss_apt = st($myarray['ambulatory_ss_apt']);
$ambulatory_ss_comp = st($myarray['ambulatory_ss_comp']);
$diag_s_md_sent = st($myarray['diag_s_md_sent']);
$diag_s_md_received = st($myarray['diag_s_md_received']);
$psg_apt = st($myarray['psg_apt']);
$psg_comp = st($myarray['psg_comp']);
$sleep_lab = st($myarray['sleep_lab']);
$lomn = st($myarray['lomn']);
$rxfrommd = st($myarray['rxfrommd']);
$not_candidate = st($myarray['not_candidate']);
$financial_restraints = st($myarray['financial_restraints']);
$pt_needing_dental_work = st($myarray['pt_needing_dental_work']);
$inadequate_dentition = st($myarray['inadequate_dentition']);
$pt_not_ds_other = st($myarray['pt_not_ds_other']);
$ltr_pp_date_prepared = st($myarray['ltr_pp_date_prepared']);
$ltr_pp_date_sent = st($myarray['ltr_pp_date_sent']);
$but_text = "Add ";
$fstep = $myarray['step'];
$sstep = $myarray['sstep'];

if($myarray["flowsheetid"] != '')
{
	$but_text = "Edit ";
}
else
{
	$but_text = "Add ";
}
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>

<span class="admin_head">
	Manage Flow Sheet
	-
    Patient <i><?=$name;?></i>
</span>
<br />

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>



<div style="width:620px;float:left;">
<form name="flowsheetfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&pid=<?=$_GET['pid']?>" method="post" style="width:620px;">
<table width="100%" cellspacing="1" cellpadding="5" bgcolor="#ffffff" float="left" style="margin-left: 20px;">
	<tr>
		<td colspan="2" class="cat_head">
		   <?=$but_text?> Flow Sheet
		</td>
	</tr>

	
  
				 
					 
					 
					 
					 
					 
	    
  	
	
	<tr>
		<td  colspan="2" align="center">
			<span class="red">
				* Required Fields
			</span><br />
			<input type="hidden" name="flowsheetsub" value="1" />
			<input type="hidden" name="ed" value="<?=$flowsheetid?>" />
			<input type="submit" value=" <?=$but_text?> Flow Sheet" class="button" />
		</td>
	</tr>
	
	
	
	
	
	
	
	
	


	<tr> 
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
					<label class="desc" id="title0" for="Field0">
						<?php if($fstep == 5){echo "<font style=\"color:#FF0000;\">";} ?>Consultation Appointment<?php if($fstep == 5){echo "</font>";} ?>
					</label>
					<div>
						<span class="left">
							<input id="consultation_apt" name="consultation_apt" type="text" class="field text addr tbox" value="<?=$consultation_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal12.popup();"/>
							<a href="javascript:cal12.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="consultation_comp" name="consultation_comp" type="text" class="field text addr tbox" value="<?=$consultation_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal13.popup();" />
							<a href="javascript:cal13.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
					</div>
					
					<label class="desc" id="title0" for="Field0">
						Medical insurance obtained
					</label>
					<div>
						<span class="left">
							<input id="m_insurance_date" name="m_insurance_date" type="text" class="field text addr tbox" value="<?=$m_insurance_date?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal73.popup();"/>
							<a href="javascript:cal73.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Scanned into file</label>
						</span>
						<span class="left">
							<input id="lomn" name="lomn" type="text" class="field text addr tbox" value="<?=$lomn?>" style="width:150px;" maxlength="255" />
							
							<label for="add1">LOMN</label>
						</span>
						<span class="left">
							<input id="rxfrommd" name="rxfrommd" type="text" class="field text addr tbox" value="<?=$rxfrommd?>" style="width:150px;" maxlength="255" />
						
							<label for="add1">Rx from MD</label>
						</span>
						
					</div>
					
					<div>
						<span class="left">
							<select name="select_type" class="field text addr tbox" onchange="t_type()">
								<option value="Beginning Treatment" <? if($select_type == 'Beginning Treatment') echo " selected";?>>
									Beginning Treatment
								</option>
								<option value="Need ambulatory sleep study" <? if($select_type == 'Need ambulatory sleep study') echo " selected";?>>
									Need ambulatory sleep study
								</option>
								<option value="Need PSG sleep study" <? if($select_type == 'Need PSG sleep study') echo " selected";?>>
									Need PSG sleep study
								</option>
								<option value="Patient not doing device" <? if($select_type == 'Patient not doing device') echo " selected";?>>
									Patient not doing device
								</option>
							</select>
						</span>
					</div>
					
				</li>
			</ul>
			<div style="float:right;">Step Complete<input name="step5" type="checkbox"<?php if($fstep > 5){?> DISABLED<?php } ?>></div>
		</td>
	</tr>

	
	
	
	
	
	
	
	
	
	
	
		<tr id="beginning_section" style="display:none;">
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
				

					<label class="desc" id="title0" for="Field0">
						Exam/Impressions
					</label>
					<div>
						<span class="left">
							<input id="exam_impressions_apt" name="exam_impressions_apt" type="text" class="field text addr tbox" value="<?=$exam_impressions_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal16.popup();"/>
							<a href="javascript:cal16.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="exam_impressions_comp" name="exam_impressions_comp" type="text" class="field text addr tbox" value="<?=$exam_impressions_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal17.popup();" />
							<a href="javascript:cal17.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep50" type="checkbox"<?php if($sstep > 50){?> DISABLED<?php } ?>></div>
					</div>

	
	
	
	
	
	
	

					<label class="desc" id="title0" for="Field0">
						Dental Sleep Report
					</label>
					<div>
						<span class="left">
							<input id="dsr_prepared" name="dsr_prepared" type="text" class="field text addr tbox" value="<?=$dsr_prepared?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal74.popup();"/>
							<a href="javascript:cal74.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">DSR prepared </label>
						</span>
						<span class="right">
							<input id="dsr_sent" name="dsr_sent" type="text" class="field text addr tbox" value="<?=$dsr_sent?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal75.popup();" />
							<a href="javascript:cal75.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">DSR sent</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep51" type="checkbox"<?php if($sstep > 51){?> DISABLED<?php } ?>></div>
					</div>

	
	
	
	
	
	
	
	
	
	
	
	
	
					<hr size="1" />
					
					<label class="desc" id="title0" for="Field0">
						Delivery of Device
					</label>
					<div>
						<span class="left">
							<input id="delivery_device_apt" name="delivery_device_apt" type="text" class="field text addr tbox" value="<?=$delivery_device_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal22.popup();"/>
							<a href="javascript:cal22.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="delivery_device_comp" name="delivery_device_comp" type="text" class="field text addr tbox" value="<?=$delivery_device_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal23.popup();" />
							<a href="javascript:cal23.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
					</div>
					
					
					<label class="desc" id="title0" for="Field0">
						Dental Sleep Report delivered to patient
					</label>
					<div>
						<span class="left">
							<input id="dsr_date_delivered" name="dsr_date_delivered" type="text" class="field text addr tbox" value="<?=$dsr_date_delivered?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal76.popup();"/>
							<a href="javascript:cal76.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Date Delivered</label>
						</span>
					</div>

					<label class="desc" id="title0" for="Field0">
						Letters to physicians/Dentists
					</label>
					<div>
						<span class="left">
							<input id="ltr_phy_prepared" name="ltr_phy_prepared" type="text" class="field text addr tbox" value="<?=$ltr_phy_prepared?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal77.popup();"/>
							<a href="javascript:cal77.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">letters prepared</label>
						</span>
						<span class="right">
							<input id="ltr_phy_sent" name="ltr_phy_sent" type="text" class="field text addr tbox" value="<?=$ltr_phy_sent?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal78.popup();" />
							<a href="javascript:cal78.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">letters sent</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep52" type="checkbox"<?php if($sstep > 52){?> DISABLED<?php } ?>></div>
					</div>

	
	
	
	
	
	
	
	
	
	
	
	
	
					<hr size="1" />
					
					
					<label class="desc" id="title0" for="Field0">
						First check
					</label>
					<div>
						<span class="left">
							<input id="first_check_apt" name="first_check_apt" type="text" class="field text addr tbox" value="<?=$first_check_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal28.popup();"/>
							<a href="javascript:cal28.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="first_check_comp" name="first_check_comp" type="text" class="field text addr tbox" value="<?=$first_check_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal29.popup();" />
							<a href="javascript:cal29.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep53" type="checkbox"<?php if($sstep > 53){?> DISABLED<?php } ?>></div>
					</div>
	
					<hr size="1" />
					
					
					<label class="desc" id="title0" for="Field0">
						Additional checks
					</label>
					<div>
						<span class="left">
							<input id="add_check_apt" name="add_check_apt" type="text" class="field text addr tbox" value="<?=$add_check_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal30.popup();"/>
							<a href="javascript:cal30.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="add_check_comp" name="add_check_comp" type="text" class="field text addr tbox" value="<?=$add_check_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal31.popup();" />
							<a href="javascript:cal30.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep54" type="checkbox"<?php if($sstep > 54){?> DISABLED<?php } ?>></div>
					</div>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

					<hr size="1" />
					
					
					<label class="desc" id="title0" for="Field0">
						Home sleep recorder
					</label>
					<div>
						<span class="left">
							<input id="home_sleep_apt" name="home_sleep_apt" type="text" class="field text addr tbox" value="<?=$home_sleep_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal32.popup();"/>
							<a href="javascript:cal32.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="home_sleep_comp" name="home_sleep_comp" type="text" class="field text addr tbox" value="<?=$home_sleep_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal33.popup();" />
							<a href="javascript:cal33.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep55" type="checkbox"<?php if($sstep > 55){?> DISABLED<?php } ?>></div>
					</div>

	
	
	
	
	
	
	
	
	
	
	
	
	

					<hr size="1" />
					
					
					<label class="desc" id="title0" for="Field0">
						Possible further checks
					</label>
					<div>
						<span class="left">
							<input id="further_checks_apt" name="further_checks_apt" type="text" class="field text addr tbox" value="<?=$further_checks_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal34.popup();"/>
							<a href="javascript:cal34.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="further_checks_comp" name="further_checks_comp" type="text" class="field text addr tbox" value="<?=$further_checks_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal35.popup();" />
							<a href="javascript:cal35.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep56" type="checkbox"<?php if($sstep > 56){?> DISABLED<?php } ?>></div>
					</div>


					<hr size="1" />
					
					
					<label class="desc" id="title0" for="Field0">
						Patient completed treatment
					</label>
					<div>
						<span class="left">
							<input id="comp_treatment_date" name="comp_treatment_date" type="text" class="field text addr tbox" value="<?=$comp_treatment_date?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal79.popup();"/>
							<a href="javascript:cal79.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Date Completed</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep57" type="checkbox"<?php if($sstep > 57){?> DISABLED<?php } ?>></div>
					</div>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

					
					
					<label class="desc" id="title0" for="Field0">
						Letter sent to doctors with copy of sleep study
					</label>
					<div>
						<span class="left">
							<input id="ltr_doc_ss_date_prepared" name="ltr_doc_ss_date_prepared" type="text" class="field text addr tbox" value="<?=$ltr_doc_ss_date_prepared?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal81.popup();"/>
							<a href="javascript:cal81.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Date prepared</label>
						</span>
						<span class="right">
							<input id="ltr_doc_ss_date_sent" name="ltr_doc_ss_date_sent" type="text" class="field text addr tbox" value="<?=$ltr_doc_ss_date_sent?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal82.popup();" />
							<a href="javascript:cal82.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Date sent</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep58" type="checkbox"<?php if($sstep > 58){?> DISABLED<?php } ?>></div>
					</div>

					<hr size="1" />
					
										
					
					<label class="desc" id="title0" for="Field0">
						Annual examination
					</label>
					<div>
						<span class="left">
							<input id="annual_exam_apt" name="annual_exam_apt" type="text" class="field text addr tbox" value="<?=$annual_exam_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal40.popup();"/>
							<a href="javascript:cal40.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="annual_exam_comp" name="annual_exam_comp" type="text" class="field text addr tbox" value="<?=$annual_exam_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal41.popup();" />
							<a href="javascript:cal41.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
					</div>
										
					
					<label class="desc" id="title0" for="Field0">
						Letters to doctors and patient
					</label>
					<div>
						<span class="left">
							<input id="ltr_doc_pt_date_prepared" name="ltr_doc_pt_date_prepared" type="text" class="field text addr tbox" value="<?=$ltr_doc_pt_date_prepared?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal87.popup();"/>
							<a href="javascript:cal87.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Date prepared </label>
						</span>
						<span class="right">
							<input id="ltr_doc_pt_date_sent" name="ltr_doc_pt_date_sent" type="text" class="field text addr tbox" value="<?=$ltr_doc_pt_date_sent?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal88.popup();" />
							<a href="javascript:cal88.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Date Sent</label>
						</span>
						<div style="float:right;">Step Complete<input name="sstep59" type="checkbox"<?php if($sstep > 59){?> DISABLED<?php } ?>></div>
					</div>

				</li>
			</ul>
		</td>
	</tr>
	
	<tr id="ambulatory_section" style="display:none;"> 
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
					<label class="desc" id="title0" for="Field0">
						Ambulatory Sleep Study
					</label>
					<div>
						<span class="left">
							<input id="ambulatory_ss_apt" name="ambulatory_ss_apt" type="text" class="field text addr tbox" value="<?=$ambulatory_ss_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal46.popup();"/>
							<a href="javascript:cal46.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="ambulatory_ss_comp" name="ambulatory_ss_comp" type="text" class="field text addr tbox" value="<?=$ambulatory_ss_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal47.popup();" />
							<a href="javascript:cal47.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
					</div>
					
					
					<label class="desc" id="title0" for="Field0">
						Diagnosis received from Sleep MD
					</label>
					<div>
						<span class="left">
							<input id="diag_s_md_sent" name="diag_s_md_sent" type="text" class="field text addr tbox" value="<?=$diag_s_md_sent?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal83.popup();"/>
							<a href="javascript:cal83.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Study sent to MD </label>
						</span>
						<span class="right">
							<input id="diag_s_md_received" name="diag_s_md_received" type="text" class="field text addr tbox" value="<?=$diag_s_md_received?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal84.popup();" />
							<a href="javascript:cal84.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Diagnosis received</label>
						</span>
					</div>
					
					<!--<div>
						<span class="left">
							<select name="select_type1" class="field text addr tbox" onchange="t_type1()">
								<option value=""></option>
								<option value="Beginning Treatment">
									Beginning Treatment
								</option>
								<option value="Need PSG sleep study" >
									Need PSG sleep study
								</option>
								<option value="Patient not doing device" >
									Patient not doing device
								</option>
							</select>
						</span>
					</div> -->
					
				</li>
			</ul>
		</td>
	</tr>
	
	<tr id="psg_section" style="display:none;"> 
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
					<label class="desc" id="title0" for="Field0">
						PSG
					</label>
					<div>
						<span class="left">
							<input id="psg_apt" name="psg_apt" type="text" class="field text addr tbox" value="<?=$psg_apt?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal50.popup();"/>
							<a href="javascript:cal50.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Appointment Date </label>
						</span>
						<span class="right">
							<input id="psg_comp" name="psg_comp" type="text" class="field text addr tbox" value="<?=$psg_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal51.popup();" />
							<a href="javascript:cal51.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
					</div>
					<label class="desc" id="title0" for="Field0">
						Sleep Lab
					</label>
					<div>
						<span class="left">
							<? 
							$slab_sql = "select * from dental_sleeplab where docid='".$_SESSION['docid']."' order by company";
							$s_my = mysql_query($slab_sql) or trigger_error(mysql_error()." | ".$slab_sql, E_USER_ERROR);
							?>
								
							<select name="sleep_lab" class="field text addr tbox">
								<option value=""></option>
								<? while($s_myarray = mysql_fetch_array($s_my))
								{?>
									<option value="<?=$s_myarray["sleeplabid"];?>" <? if($sleep_lab == $s_myarray["sleeplabid"]) { echo "selected";}?>>
										<?=$s_myarray["company"];?>
									</option>
								<?
								}?>
							</select>
						</span>
					</div>
				</li>
			</ul>
		</td>
	</tr>
	
	<tr id="not_patient_section" style="display:none;"> 
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
					<label class="desc" id="title0" for="Field0">
						Patient not doing dental sleep treatment
					</label>
					<div>
						<span class="full">
							<input type="checkbox" name="not_candidate" value="1" <? if($not_candidate == 1) echo " checked";?> class="field text addr tbox" style="width:30px;" />
							Not candidate
							<br /><br>		
							
							<input type="checkbox" name="financial_restraints" value="1" <? if($financial_restraints == 1) echo " checked";?> class="field text addr tbox" style="width:30px;" />
							Financial restraints
							<br /><br>		
							
							<input type="checkbox" name="pt_needing_dental_work" value="1" <? if($pt_needing_dental_work == 1) echo " checked";?> class="field text addr tbox" style="width:30px;" />
							Pt needing dental work
							<br /><br>		
							
							<input type="checkbox" name="inadequate_dentition" value="1" <? if($inadequate_dentition == 1) echo " checked";?> class="field text addr tbox" style="width:30px;" />
							Inadequate dentition
							<br /><br>		
							
							Other: <input id="pt_not_ds_other" name="pt_not_ds_other" type="text" class="field text addr tbox" value="<?=$pt_not_ds_other?>" style="width:150px;" maxlength="255" />
						</span>
					</div>
					
					<hr size="1" >
					<label class="desc" id="title0" for="Field0">
						Letters to patient and Physicians
					</label>
					<div>
						<span class="left">
							<input id="ltr_pp_date_prepared" name="ltr_pp_date_prepared" type="text" class="field text addr tbox" value="<?=$ltr_pp_date_prepared?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal85.popup();"/>
							<a href="javascript:cal85.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Date prepared</label>
						</span>
						<span class="right">
							<input id="ltr_pp_date_sent" name="ltr_pp_date_sent" type="text" class="field text addr tbox" value="<?=$ltr_pp_date_sent?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal86.popup();" />
							<a href="javascript:cal86.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Date sent</label>
						</span>
					</div>
					
				</li>
			</ul>
		</td>
	</tr>
	
	
	
	
	</table>
	
	
	<p>&nbsp;</p>
	
	<table width="100%" cellspacing="1" cellpadding="5" bgcolor="#ffffff" float="left" style="margin-left: 20px;">
	

	
	<tr> 
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
					<label class="desc" id="title0" for="Field0">
						<?php if($fstep == 4){echo "<font style=\"color:#FF0000;\">";} ?>Referral to DSS Dentist<?php if($fstep == 4){echo "</font>";} ?>
					</label>
					<div>
						<span class="left">
							<input id="date_referred" name="date_referred" type="text" class="field text addr tbox" value="<?=$date_referred?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal72.popup();"/>
							<a href="javascript:cal72.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add1">Date referred</label>
						</span>
						<span class="right">
							<? 
							$doc_sql = "select * from dental_users where user_access=2 order by name";
							$doc_my = mysql_query($doc_sql);
							?>
							<select name="dss_dentists" class="field text addr tbox"  style="width:250px;">
								<option value=""></option>
								<? while($doc_myarray = mysql_fetch_array($doc_my))
								{?>
									<option value="<?=st($doc_myarray['userid'])?>" <? if(st($doc_myarray['userid']) == $dss_dentists) { echo " selected";}?>>
										<?=st($doc_myarray['name'])?>
									</option>
								<?
								}?>
							</select>
							<label for="add2">DSS dentists</label>
						</span>
					</div>
				</li>
			</ul>
			<div style="float:right;">Step Complete<input name="step4" type="checkbox"<?php if($fstep > 4){?> DISABLED<?php } ?>></div>
		</td>
	</tr>
	

	
	

  <tr> 
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
					<label class="desc" id="title0" for="Field0">
						<?php if($fstep == 1){echo "<font style=\"color:#FF0000;\">";} ?>Send NP Forms<?php if($fstep == 1){echo "</font>";} ?>
					</label>
					<div>
						<span class="left">
							<select name="send_np" class="field text addr tbox">
								<option value=""></option>
								<option value="faxed" <? if($send_np == 'faxed') echo " selected";?>>
									faxed
								</option>
								<option value="mail" <? if($send_np == 'mail') echo " selected";?>>
									mail
								</option>
								<option value="email" <? if($send_np == 'email') echo " selected";?>>
									email
								</option>
								<option value="internet" <? if($send_np == 'internet') echo " selected";?>>
									internet 
								</option>
							</select>
							<label for="add1">&nbsp;</label>
						</span>
						<span class="right">
							<input id="send_np_comp" name="send_np_comp" type="text" class="field text addr tbox" value="<?=$send_np_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal3.popup();" />
							<a href="javascript:cal3.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
					</div>
				</li>
			</ul>
			<div style="float:right;">Step Complete<input name="step1" type="checkbox"<?php if($fstep > 1){?> DISABLED<?php } ?>></div>
		</td>
	</tr>
	

	
	
	
	
	
	
	
		<tr> 
		<td valign="top" colspan="2" class="frmhead">
			<ul>
				<li id="foli8" class="complex">	
					<label class="desc" id="title0" for="Field0">
						<?php if($fstep == 0){echo "<font style=\"color:#FF0000;\">";} ?>Inquiry Call<?php if($fstep == 0){echo "</font>";} ?>
					</label>
					<div>
						<span class="left">
							<input id="inquiry_call_comp" name="inquiry_call_comp" type="text" class="field text addr tbox" value="<?=$inquiry_call_comp?>" style="width:150px;" maxlength="255" readonly="readonly" onclick="javascript:cal1.popup();" />
							<a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
							<label for="add2">Completed Date</label>
						</span>
					</div>
				</li>
			</ul>
			<div style="float:right;">Step Complete<input name="step0" type="checkbox"<?php if($fstep > 0){?> DISABLED<?php } ?>></div>
		</td>

	</tr>
</table>
</form>
</div>
<div style="float:right;padding-right:20px;width:300px;">
                         LETTERS
</div>

<div style="clear:both;"></div>
<script type="text/javascript">
try
  {
	t_type();
	pt_1();
</script>


<script language="JavaScript">

	var cal1 = new calendar2(document.forms['flowsheetfrm'].elements['inquiry_call_comp']);

  </script>


 <script language="JavaScript">
	
	var cal3 = new calendar2(document.forms['flowsheetfrm'].elements['send_np_comp']);
	
	  </script>


 <script language="JavaScript">
	
	   var cal72 = new calendar2(document.forms['flowsheetfrm'].elements['date_referred']);

    </script>


 <script language="JavaScript">

	
	
	var cal12 = new calendar2(document.forms['flowsheetfrm'].elements['consultation_apt']);
	
	var cal13 = new calendar2(document.forms['flowsheetfrm'].elements['consultation_comp']);
	var cal73 = new calendar2(document.forms['flowsheetfrm'].elements['m_insurance_date']);
	
	  </script>


 <script language="JavaScript">
 	var cal16 = new calendar2(document.forms['flowsheetfrm'].elements['exam_impressions_apt']);
	
	var cal17 = new calendar2(document.forms['flowsheetfrm'].elements['exam_impressions_comp']);
	
	var cal22 = new calendar2(document.forms['flowsheetfrm'].elements['delivery_device_apt']);
	
	var cal23 = new calendar2(document.forms['flowsheetfrm'].elements['delivery_device_comp']);
		
	var cal28 = new calendar2(document.forms['flowsheetfrm'].elements['first_check_apt']);
	
	var cal29 = new calendar2(document.forms['flowsheetfrm'].elements['first_check_comp']);
	
	var cal30 = new calendar2(document.forms['flowsheetfrm'].elements['add_check_apt']);

	var cal31 = new calendar2(document.forms['flowsheetfrm'].elements['add_check_comp']);
	
	var cal32 = new calendar2(document.forms['flowsheetfrm'].elements['home_sleep_apt']);
	
	var cal33 = new calendar2(document.forms['flowsheetfrm'].elements['home_sleep_comp']);
	
	var cal34 = new calendar2(document.forms['flowsheetfrm'].elements['further_checks_apt']);
	
	var cal35 = new calendar2(document.forms['flowsheetfrm'].elements['further_checks_comp']);
	
	var cal40 = new calendar2(document.forms['flowsheetfrm'].elements['annual_exam_apt']);

	var cal41 = new calendar2(document.forms['flowsheetfrm'].elements['annual_exam_comp']);
	
	var cal46 = new calendar2(document.forms['flowsheetfrm'].elements['ambulatory_ss_apt']);
	
	var cal47 = new calendar2(document.forms['flowsheetfrm'].elements['ambulatory_ss_comp']);
	
	var cal50 = new calendar2(document.forms['flowsheetfrm'].elements['psg_apt']);
	
	var cal51 = new calendar2(document.forms['flowsheetfrm'].elements['psg_comp']);
	
	
	
	
	var cal74 = new calendar2(document.forms['flowsheetfrm'].elements['dsr_prepared']);
	
	var cal75 = new calendar2(document.forms['flowsheetfrm'].elements['dsr_sent']);
	
	var cal76 = new calendar2(document.forms['flowsheetfrm'].elements['dsr_date_delivered']);
	
	var cal77 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_phy_prepared']);
	
	var cal78 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_phy_sent']);
	
	var cal79 = new calendar2(document.forms['flowsheetfrm'].elements['comp_treatment_date']);
	
	var cal80 = new calendar2(document.forms['flowsheetfrm'].elements['portable_date_comp']);
	
	var cal81 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_doc_ss_date_prepared']);
	
	var cal82 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_doc_ss_date_sent']);
	
	var cal83 = new calendar2(document.forms['flowsheetfrm'].elements['diag_s_md_sent']);
	
	var cal84 = new calendar2(document.forms['flowsheetfrm'].elements['diag_s_md_received']);
	
	var cal85 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_pp_date_prepared']);
	
	var cal86 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_pp_date_sent']);
	
	var cal87 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_doc_pt_date_prepared']);
	
	var cal88 = new calendar2(document.forms['flowsheetfrm'].elements['ltr_doc_pt_date_sent']);
}catch(err)
{
}	
</script>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
