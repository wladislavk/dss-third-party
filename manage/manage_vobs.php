<?php
include 'includes/constants.inc';
include "includes/top.htm";
include "admin/classes/Db.php";

$db = new Db();

if(isset($_GET['rid'])){
  $s = sprintf("UPDATE dental_insurance_preauth SET viewed=1 WHERE id=%s AND patient_id=%s AND doc_id=%s",$_REQUEST['rid'], $_REQUEST['pid'], $_SESSION['docid']);
  $db->query($s);
}elseif(isset($_GET['urid'])){
  $s = sprintf("UPDATE dental_insurance_preauth SET viewed=0 WHERE id=%s AND patient_id=%s AND doc_id=%s",$_REQUEST['urid'], $_REQUEST['pid'], $_SESSION['docid']);
  $db->query($s);
}elseif(isset($_GET['frid'])){
  $s = sprintf("UPDATE dental_faxes SET viewed=1 WHERE id=%s AND docid=%s",$_REQUEST['frid'], $_SESSION['docid']);
  $db->query($s);
}


function insert_preauth_row($patient_id) {
  if (empty($patient_id)) { return; }
  
  $sql = "SELECT "
       . "  p.patientid as 'patient_id', i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
       . "  p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
       . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
       . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
       . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
       . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
       . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "
       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
       . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
       . "  d.userid as 'doc_id' "
       . "FROM " 
       . "  dental_patients p "
       . "  JOIN dental_contact r ON p.referred_by = r.contactid  "
       . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
       . "  JOIN dental_users d ON p.docid = d.userid "
       . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
       . "  JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
       . "WHERE " 
       . "  p.patientid = $patient_id";
  
  $my_array = $db->getRow($sql);
//  print_r($my_array);exit;
  
  $sql = "INSERT INTO dental_insurance_preauth ("
       . "  patient_id, doc_id, ins_co, ins_rank, ins_phone, patient_ins_group_id, "
       . "  patient_ins_id, patient_firstname, patient_lastname, patient_add1, "
       . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
       . "  insured_first_name, insured_last_name, insured_dob, doc_npi, referring_doc_npi, "
       . "  trxn_code_amount, diagnosis_code, doc_medicare_npi, doc_tax_id_or_ssn, "
       . "  front_office_request_date, status "
       . ") VALUES ("
       . "  " . $my_array['patient_id'] . ", "
       . "  " . $my_array['doc_id'] . ", "
       . "  '" . $my_array['ins_co'] . "', "
       . "  '" . $my_array['ins_rank'] . "', "
       . "  '" . $my_array['ins_phone'] . "', "
       . "  '" . $my_array['patient_ins_group_id'] . "', "
       . "  '" . $my_array['patient_ins_id'] . "', "
       . "  '" . $my_array['patient_firstname'] . "', "
       . "  '" . $my_array['patient_lastname'] . "', "
       . "  '" . $my_array['patient_add1'] . "', "
       . "  '" . $my_array['patient_add2'] . "', "
       . "  '" . $my_array['patient_city'] . "', "
       . "  '" . $my_array['patient_state'] . "', "
       . "  '" . $my_array['patient_zip'] . "', "
       . "  '" . $my_array['patient_dob'] . "', "
       . "  '" . $my_array['insured_first_name'] . "', "
       . "  '" . $my_array['insured_last_name'] . "', "
       . "  '" . $my_array['insured_dob'] . "', "
       . "  '" . $my_array['doc_npi'] . "', "
       . "  '" . $my_array['referring_doc_npi'] . "', "
       . "  " . $my_array['trxn_code_amount'] . ", "
       . "  '" . $my_array['diagnosis_code'] . "', "
       . "  '" . $my_array['doc_medicare_npi'] . "', "
       . "  '" . $my_array['doc_tax_id_or_ssn'] . "', "
       . "  '" . date('Y-m-d H:i:s') . "', "
       . DSS_PREAUTH_PENDING
       . ")";
  //print_r($my_array);
  //print_r($sql);exit;
  $my = $db->query($sql);
}


$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;

if(isset($_REQUEST['sort']) && $_REQUEST['sort']!=''){
  switch($_REQUEST['sort']){
    case 'request_date':
	$sort = "preauth.front_office_request_date";
	break;
    case 'patient_name':
	$sort = "p.lastname";
	break;
    case 'status':
	$sort = 'preauth.status';
	break;
  }
}else{
  $_REQUEST['sort']='status';
  $_REQUEST['sortdir']='DESC';
  $sort = "preauth.status";
}
if(isset($_REQUEST['sortdir']) && $_REQUEST['sortdir']!=''){
  $dir = $_REQUEST['sortdir'];
}else{
  $dir = 'DESC';
}
	
$i_val = $index_val * $rec_disp;
$sql = "select preauth.id, p.firstname, p.lastname, preauth.viewed, preauth.front_office_request_date, preauth.patient_id, preauth.status, preauth.reject_reason from dental_insurance_preauth preauth JOIN dental_patients p ON p.patientid=preauth.patient_id WHERE preauth.doc_id = ".$_SESSION['docid']." ";
if(isset($_GET['status'])){
  $sql .= " AND preauth.status = '".mysql_real_escape_string($_GET['status'])."' ";
}
if(isset($_GET['viewed'])){
  if($_GET['viewed']==1){
  	$sql .= " AND preauth.viewed = '".mysql_real_escape_string($_GET['viewed'])."' ";
  }else{
	$sql .= " AND (preauth.viewed = '0' OR preauth.viewed IS NULL) ";
  }
}
  $sql .= "ORDER BY ".$sort." ".$dir;

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Verification of Benefits
</span>
<?php if(isset($_GET['viewed']) && $_GET['viewed']==0){ ?>
  <a href="manage_vobs.php?pid=<?php echo $_GET['pid'] ?>&sort=<?php echo $_REQUEST['sort']; ?>&sortdir=<?php echo $_REQUEST['sortdir']; ?>" style="float:right; margin-right:10px;" class="addButton">Show All</a>
<?php }else{ ?>
  <a href="manage_vobs.php?pid=<?php echo $_GET['pid'] ?>&viewed=0&sort=<?php echo $_REQUEST['sort']; ?>&sortdir=<?php echo $_REQUEST['sortdir']; ?>" style="float:right; margin-right:10px;" class="addButton">Show Unread</a>
<?php } ?>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?php echo$_SERVER['PHP_SELF']?>" method="post">
  <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<?php if($total_rec > $rec_disp) {?>
  	<TR bgColor="#ffffff">
  		<TD  align="right" colspan="15" class="bp">
  			Pages:
  			<?php
  				 paging($no_pages,$index_val,"sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']);
  			?>
  		</TD>
  	</TR>
	<?php }?>
  	<tr class="tr_bg_h">
  		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'request_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
  			<a href="manage_vobs.php?pid=<?php echo $_GET['pid'] ?>&sort=request_date&sortdir=<?php echo ($_REQUEST['sort']=='request_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Requested</a>
  		</td>
  		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
  			<a href="manage_vobs.php?pid=<?php echo $_GET['pid'] ?>&sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient Name</a>
  		</td>
  		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
  			<a href="manage_vobs.php?pid=<?php echo $_GET['pid'] ?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Status</a>	
  		</td>
  		<td valign="top" class="col_head" width="40%">
  			Comments
  		</td>
  		<td valign="top" class="col_head" width="15%">
  			Action
  		</td>
  	</tr>
	<?php if(count($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="4" align="center">
				No Records
			</td>
		</tr>
	<?php 
	}
	else
	{
    foreach ($my as $myarray) { ?>
		<tr class="<?php echo $tr_class;?> <?php echo ($myarray['viewed']||$myarray['status']==DSS_PREAUTH_PENDING)?'':'unviewed'; ?>">
			<td valign="top">
				<?php echo($myarray["front_office_request_date"]);?>&nbsp;
			</td>
			<td valign="top">
				<?php echo($myarray["firstname"]);?>&nbsp;
        <?php echo($myarray["lastname"]);?> 
			</td>
			<td valign="top" class="status_<?php echo $myarray['status']; ?>">
				<?php echo $dss_preauth_status_labels[$myarray["status"]];?>&nbsp;
			</td>
			<td>
				<?php if($myarray['status']==DSS_PREAUTH_REJECTED){ 
					echo $myarray['reject_reason'];
				} ?>
			</td>
			<td valign="top">
				<a href="manage_insurance.php?pid=<?php echo $myarray["patient_id"]; ?>&vob_id=<?php echo $myarray["id"]; ?>" class="editlink" title="EDIT">
					View
				</a>
				<br />
			<?php 
			if(!$myarray['viewed']){ ?>
        <a href="manage_vobs.php?pid=<?php echo $myarray["patient_id"]; ?>&rid=<?php echo $myarray["id"]; ?>" class="editlink" title="EDIT">
          Mark Read
        </a>
			<?php }else{ ?>
        <a href="manage_vobs.php?pid=<?php echo $myarray["patient_id"]; ?>&urid=<?php echo $myarray["id"]; ?>" class="editlink" title="EDIT">
          Mark Unread
        </a>
				<?php } 
				?>
			</td>
		</tr>
	<?php	}
	}?>
  </table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
