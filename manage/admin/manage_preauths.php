<? 
require_once('../includes/constants.inc');
include "includes/top.htm";

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

if ($_REQUEST['gen_preauth'] == 1) {
  insert_preauth_row($_REQUEST['patient_id']);
}

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
$sql = "select preauth.id, preauth.patient_firstname, preauth.patient_lastname, preauth.front_office_request_date, users.name as doc_name from dental_insurance_preauth preauth join dental_users users on preauth.doc_id = users.userid where preauth.status = 0 order by front_office_request_date";
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

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
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
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="15%">
			Requested
		</td>
		<td valign="top" class="col_head" width="35%">
			Patient Name
		</td>
		<td valign="top" class="col_head" width="35%">
			Franchisee Name
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
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["front_office_request_date"]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["patient_firstname"]);?>&nbsp;
                    <?=st($myarray["patient_lastname"]);?> 
				</td>
				<td valign="top">
					<?=st($myarray["doc_name"]);?>&nbsp;
				</td>
				<td valign="top">
					<a href="Javascript:;" onclick="Javascript: loadPopup('process_preauth.php?ed=<?=$myarray["id"];?>');" class="editlink" title="EDIT">
						Edit
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