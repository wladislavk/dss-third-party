<? 
require_once('includes/constants.inc');
include "includes/top.htm";

if(isset($_GET['rid'])){
$s = sprintf("UPDATE dental_insurance_preauth SET viewed=1 WHERE id=%s AND patient_id=%s AND doc_id=%s",$_REQUEST['rid'], $_REQUEST['pid'], $_SESSION['docid']);
mysql_query($s);
}elseif(isset($_GET['urid'])){
$s = sprintf("UPDATE dental_insurance_preauth SET viewed=0 WHERE id=%s AND patient_id=%s AND doc_id=%s",$_REQUEST['urid'], $_REQUEST['pid'], $_SESSION['docid']);
mysql_query($s);
}elseif(isset($_GET['frid'])){
$s = sprintf("UPDATE dental_faxes SET viewed=1 WHERE id=%s AND docid=%s",$_REQUEST['frid'], $_SESSION['docid']);
mysql_query($s);
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
  
  $my = mysql_query($sql);
  $my_array = mysql_fetch_array($my);
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
  $my = mysql_query($sql);
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
$sql = "select preauth.id, p.firstname, p.lastname, preauth.viewed, preauth.front_office_request_date, preauth.patient_id, preauth.status from dental_insurance_preauth preauth JOIN dental_patients p ON p.patientid=preauth.patient_id WHERE preauth.doc_id = ".$_SESSION['docid']." ";
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
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Verification of Benefits
</span>
<?php if(isset($_GET['viewed']) && $_GET['viewed']==0){ ?>
<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&sort=<?php echo $_REQUEST['sort']; ?>&sortdir=<?php echo $_REQUEST['sortdir']; ?>" style="float:right; margin-right:10px;" class="addButton">Show All</a>
<?php }else{ ?>
<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&viewed=0&sort=<?php echo $_REQUEST['sort']; ?>&sortdir=<?php echo $_REQUEST['sortdir']; ?>" style="float:right; margin-right:10px;" class="addButton">Show Unread</a>
<?php } ?>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']);
			?>
		</TD>
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'request_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&sort=request_date&sortdir=<?php echo ($_REQUEST['sort']=='request_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Requested</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="35%">
			<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient Name</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="35%">
			<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Status</a>	
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="4" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
		?>
			<tr class="<?=$tr_class;?> <?= ($myarray['viewed']||$myarray['status']==DSS_PREAUTH_PENDING)?'':'unviewed'; ?>">
				<td valign="top">
					<?=st($myarray["front_office_request_date"]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["firstname"]);?>&nbsp;
                    <?=st($myarray["lastname"]);?> 
				</td>
				<td valign="top" class="status_<?= $myarray['status']; ?>">
					<?= $dss_preauth_status_labels[$myarray["status"]];?>&nbsp;
				</td>
				<td valign="top">
					<a href="manage_insurance.php?pid=<?= $myarray["patient_id"]; ?>&vob_id=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
						View
					</a>
					<br />
					<?php 
					if(!$myarray['viewed']){ ?>
                                        <a href="manage_vobs.php?pid=<?= $myarray["patient_id"]; ?>&rid=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
                                                Mark Read
                                        </a>
					<?php }else{ ?>
                                        <a href="manage_vobs.php?pid=<?= $myarray["patient_id"]; ?>&urid=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
                                                Mark Unread
                                        </a>
					<?php } 
					?>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<?php



//$sql = "SELECT * FROM dental_faxes WHERE sfax_completed=1 AND sfax_status=2 AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND 
$sql = "SELECT f.*,
        CONCAT(p.firstname,' ',p.lastname) as patient_name,
        l.template_type,
        l.templateid,
        l.pdf_path,
        l.status as letter_status,
	ec.description AS error_description,
	ec.resolution AS error_resolution
         FROM dental_faxes f 
        LEFT JOIN dental_patients p ON p.patientid = f.patientid
        LEFT JOIN dental_letters l ON l.letterid = f.letterid
	LEFT JOIN dental_fax_error_codes ec ON ec.error_code = f.sfax_error_code
        WHERE f.docid='".mysql_real_escape_string($_SESSION['docid'])."' AND
	sfax_completed=1 AND sfax_status=2 AND
	viewed = 0";
  $sql .= " ORDER BY adddate DESC";
$my = mysql_query($sql);
if(mysql_num_rows($my)){
?>
<a name="fax"></a>
<br /><br />
<span class="admin_head">Manage Faxes - Fax Errors</span>
<br />
<br />
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="15%">
			Date Sent
                </td>
                <td valign="top" class="col_head" width="15%">
                        To
                </td>
                <td valign="top" class="col_head" width="15%">
                        Patient
                </td>
                <td valign="top" class="col_head" width="15%">
                        Correspondance
                </td>
                <td valign="top" class="col_head" width="15%">
                        Error
                </td>
                <td valign="top" class="col_head" width="15%">
                        Action
                </td>
        </tr>
        <? if(mysql_num_rows($my) == 0)
        { ?>
                <tr class="tr_bg">
                        <td valign="top" class="col_head" colspan="4" align="center">
                                No Records
                        </td>
                </tr>
        <?
        }
        else
        {
                while($myarray = mysql_fetch_array($my))
                {
if($myarray['template_type']=='0'){
  $template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$myarray['templateid'].";";
}else{
  $template_query = "SELECT name FROM dental_letter_templates_custom WHERE id = ".$myarray['templateid'].";";
}
$template_result = mysql_query($template_query);
$title = mysql_result($template_result, 0);
        
        ?>
                        <tr>
                                <td valign="top">
                                        <?=st($myarray["adddate"]);?>&nbsp;
                                </td>
                                <td valign="top">
                                        <a href="#" onclick="loadPopup('add_contact.php?ed=<?= $myarray['contactid']; ?>'); return false;"><?= $myarray["to_name"]; ?></a> <?=format_phone($myarray["to_number"]);?>
                                </td>
                                <td valign="top">
                                        <a href="dss_summ.php?sect=letters&pid=<?= $myarray['patientid']; ?>"><?= $myarray['patient_name']; ?></a>
                                </td>
                                <td valign="top">
                                        <?php if($myarray['pdf_path'] && $myarray['letter_status']!=DSS_LETTER_PENDING){ ?>
                                          <a href="letterpdfs/<?= $myarray['pdf_path']; ?>"><?= $title; ?></a>
                                        <?php }else{ ?>
                                          <a href="edit_letter.php?pid=<?=$myarray['patientid'];?>&lid=<?= $myarray['letterid']; ?>"><?= $title; ?></a>
                                        <?php } ?>
                                </td>

                                <td valign="top">
					<?= st($myarray["error_description"]); ?> - <?= st($myarray["error_resolution"]); ?>
                                </td>
                                <td valign="top">
                                        <?php if($myarray['pdf_path'] && $myarray['letter_status']!=DSS_LETTER_PENDING){ ?>
                                          <a href="letterpdfs/<?= $myarray['pdf_path']; ?>">View Letter</a>
                                        <?php }else{ ?>
                                          <a href="edit_letter.php?pid=<?=$myarray['patientid'];?>&lid=<?= $myarray['letterid']; ?>">View Letter</a>
                                        <?php } ?>
                                </td>
                        </tr>
        <?      }
        }?>
</table>
</form>

<?php } ?>




<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
