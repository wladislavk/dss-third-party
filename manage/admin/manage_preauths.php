<? 
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

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
       . "  JOIN dental_referredby r ON p.referred_by = r.referredbyid  "
       . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
       . "  JOIN dental_users d ON p.docid = d.userid "
       . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
       . "  JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
       . "WHERE " 
       . "  p.patientid = $patient_id";
  
  $my = mysql_query($sql);
  $my_array = mysql_fetch_array($my);
  
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
  $my = mysql_query($sql);
}

if ($_REQUEST['gen_preauth'] == 1) {
  insert_preauth_row($_REQUEST['patient_id']);
}

define('SORT_BY_DATE', 0);
define('SORT_BY_STATUS', 1);
define('SORT_BY_PATIENT', 2);
define('SORT_BY_FRANCHISEE', 3);
define('SORT_BY_USER', 4);

$sort_dir = strtolower($_REQUEST['sort_dir']);
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;
$sort_by_sql = '';
switch ($sort_by) {
  case SORT_BY_DATE:
    $sort_by_sql = "preauth.front_office_request_date $sort_dir";
    break;
  case SORT_BY_PATIENT:
    $sort_by_sql = "preauth.patient_lastname $sort_dir, preauth.patient_firstname $sort_dir";
    break;
  case SORT_BY_FRANCHISEE:
    $sort_by_sql = "doc_name $sort_dir";
    break;
  case SORT_BY_USER:
    $sort_by_sql = "user_name $sort_dir";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "preauth.status $sort_dir, preauth.front_office_request_date $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_insurance_preauth where id='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT "
     . "  preauth.id, preauth.patient_firstname, preauth.patient_lastname, "
     . "  preauth.front_office_request_date, users.name as doc_name, preauth.status, "
     . "  DATEDIFF(NOW(), preauth.front_office_request_date) as days_pending, "
     . "  users2.name as user_name "
     . "FROM "
     . "  dental_insurance_preauth preauth "
     . "  JOIN dental_users users ON preauth.doc_id = users.userid "
     . "  JOIN dental_users users2 ON preauth.userid = users2.userid ";

// filter based on select lists above table
if ((isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) || !empty($_REQUEST['fid'])) {
    $sql .= "WHERE ";
    
    if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
        $sql .= "  preauth.status = " . $_REQUEST['status'] . " ";
    }
    
    if (!empty($_REQUEST['fid'])) {
        if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
            $sql .= "  AND ";
        }
        $sql .= "  users.userid = " . $_REQUEST['fid'] . " ";
    }
    
    if (!empty($_REQUEST['pid'])) {
        $sql .= "AND preauth.patient_id = " . $_REQUEST['pid'] . " ";
    }
}


$sql .= "ORDER BY " . $sort_by_sql;
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
	Manage Pre-Authorizations
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>


<!--
<div style="border:1px black solid;width:60%;margin:auto;padding:10px">
<form name="insert_form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
  <div>
    For dev/testing purposes only. Enter a valid patient id and then submit.
    A pre-auth request will be generated for them (provided there is valid data in the database).
    This testing won't be necessary once the pre-auth button is added to the flowsheet pg1.
    I usually use Suzie Test (pid 16).
  </div><br/>
  <input type="text" name="patient_id"/>
  <input type="hidden" name="page" value="<?=$_REQUEST["page"]?>"/>
  <input type="hidden" name="gen_preauth" value="1"/>
  <input type="submit"/>
</form>
</div><br/>
-->

<div style="width:98%;margin:auto;">
  <form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="get">
    Status:
    <select name="status">
      <?php $pending_selected = ($status == DSS_PREAUTH_PENDING) ? 'selected' : ''; ?>
      <?php $complete_selected = ($status == DSS_PREAUTH_COMPLETE) ? 'selected' : ''; ?>
      <option value="">Any</option>
      <option value="<?=DSS_PREAUTH_PENDING?>" <?=$pending_selected?>><?=$dss_preauth_status_labels[DSS_PREAUTH_PENDING]?></option>
      <option value="<?=DSS_PREAUTH_COMPLETE?>" <?=$complete_selected?>><?=$dss_preauth_status_labels[DSS_PREAUTH_COMPLETE]?></option>
    </select>
    &nbsp;&nbsp;&nbsp;

    Franchisees:
    <select name="fid">
      <option value="">Any</option>
      <?php $franchisees = get_franchisees(); ?>
      <?php while ($row = mysql_fetch_array($franchisees)) { ?>
        <?php $selected = ($row['userid'] == $_REQUEST['fid']) ? 'selected' : ''; ?>
        <option value="<?= $row['userid'] ?>" <?= $selected ?>>[<?= $row['userid'] ?>] <?= $row['name'] ?></option>
      <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;

    <?php if (!empty($_REQUEST['fid'])) { ?>
      Patients:
      <select name="pid">
        <option value="">Any</option>
        <?php $patients = get_patients($_REQUEST['fid']); ?>
        <?php while ($row = mysql_fetch_array($patients)) { ?>
          <?php $selected = ($row['patientid'] == $_REQUEST['pid']) ? 'selected' : ''; ?>
          <option value="<?= $row['patientid'] ?>" <?= $selected ?>>[<?= $row['patientid'] ?>] <?= $row['lastname'] ?>, <?= $row['firstname'] ?></option>
        <?php } ?>
      </select>
      &nbsp;&nbsp;&nbsp;
    <?php } ?>
    
    <input type="hidden" name="sort_by" value="<?=$sort_by?>"/>
    <input type="hidden" name="sort_dir" value="<?=$sort_dir?>"/>
    <input type="submit" value="Filter List"/>
    <input type="button" value="Reset" onclick="window.location='<?=$_SERVER['PHP_SELF']?>'"/>
  </form>
</div>

<form name="pagefrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>
	</TR>
	<? }?>
	<?php
    $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $_REQUEST['fid'] . "&pid=" . $_REQUEST['pid']
             . "&status=" . $_REQUEST['status'] . "&sort_by=%s&sort_dir=%s";
    ?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_DATE, $sort_dir) ?>" width="15%">
			<a href="<?=sprintf($sort_qs, SORT_BY_DATE, get_sort_dir($sort_by, SORT_BY_DATE, $sort_dir))?>">Requested</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_STATUS, $sort_dir) ?>" width="10%">
			<a href="<?=sprintf($sort_qs, SORT_BY_STATUS, get_sort_dir($sort_by, SORT_BY_STATUS, $sort_dir))?>">Status</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_PATIENT, $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, SORT_BY_PATIENT, get_sort_dir($sort_by, SORT_BY_PATIENT, $sort_dir))?>">Patient Name</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_FRANCHISEE, $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, SORT_BY_FRANCHISEE, get_sort_dir($sort_by, SORT_BY_FRANCHISEE, $sort_dir))?>">Franchisee</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_USER, $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, SORT_BY_USER, get_sort_dir($sort_by, SORT_BY_USER, $sort_dir))?>">User</a>
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="6" align="center">
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
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["front_office_request_date"]);?>&nbsp;
				</td>
				<?php $status_color = ($myarray["status"] == DSS_PREAUTH_PENDING) ? "yellow" : "green"; ?>
				<?php $status_color = ($myarray["status"] == DSS_PREAUTH_PENDING && $myarray['days_pending'] > 7) ? "red" : $status_color; ?>
				<?php $status_text = ($myarray["status"] == DSS_PREAUTH_PENDING) ? "black" : "white"; ?>
				<td valign="top" style="background-color:<?= $status_color ?>; color: <?= $status_text ?>;">
					<?=st($dss_preauth_status_labels[$myarray["status"]]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["patient_lastname"]);?>, <?=st($myarray["patient_firstname"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["doc_name"]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["user_name"]);?>&nbsp;
				</td>
				<td valign="top">
				    <?php $link_label = ($myarray["status"] == DSS_PREAUTH_PENDING) ? 'Edit' : 'View'; ?>
					<a href="Javascript:;" onclick="Javascript: loadPopup('process_preauth.php?ed=<?=$myarray["id"];?>');" class="editlink" title="EDIT">
						<?= $link_label ?>
					</a>
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						Delete
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>