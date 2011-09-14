<? 
include "includes/top.htm";
include_once "includes/constants.inc";
require_once('includes/patient_info.php');
if ($patient_info) {

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
	die();
}


if(isset($_REQUEST['vob_id'])){

$s = sprintf("UPDATE dental_insurance_preauth SET viewed=1 WHERE id=%s AND patient_id=%s AND doc_id=%s AND status=1",$_REQUEST['vob_id'], $_REQUEST['pid'], $_SESSION['docid']);
mysql_query($s);
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
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_insurance where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate";
$sqlid = "select card from dental_insurance where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' LIMIT 1";

$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$myid=mysql_query($sqlid) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Insurance
	-
    Patient <i><?=$name;?></i>
</span>
<br />
&nbsp;&nbsp;
<a href="manage_patient.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br />

<div align="right">
	<button onclick="Javascript: loadPopup('add_patient.php?ed=<?=$_GET['pid'];?>');" class="addButton">
		View Patient Info
	</button>
	
	<?php 
  while($myinsid = mysql_fetch_array($myid)){
  if($myinsid['card'] == '1'){
  ?>
  <button onclick="Javascript: loadPopup('insurance_id.php?pid=<?=$_GET['pid'];?>');" class="addButton">
		View Insurance Card
	</button>
	 <?php }elseif($myinsid['card'] == '0'){ ?>
	<button onclick="Javascript: loadPopup('insurance_id.php?pid=<?=$_GET['pid'];?>');" class="addButton">
		Add Insurance Card
	</button>
  <?php }} ?>
  
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<insurance name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
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
		<td valign="top" class="col_head" width="60%">
			Date
		</td>
		<td valign="top" class="col_head" width="20%">
			Status
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
                	<?=date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
				</td>
				<td valign="top">
				    <?=$dss_claim_status_labels[$myarray['status']];?>
				</td>
				<td valign="top">
					<a href="insurance.php?insid=<?=$myarray["insuranceid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
						Edit 
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["insuranceid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	  <? } ?>
	<? } ?>
  <?php
    // Display a placeholder row for any ledger trxns that need added to a new claim
    $sql = "SELECT "
         . "  ledger.* "
         . "FROM "
         . "  dental_ledger ledger "
         . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
         . "  JOIN dental_users user ON user.userid = ledger.docid "
         . "WHERE "
         . "  ledger.status = " . DSS_TRXN_PENDING . " "
         . "  AND ledger.patientid = " . $_GET['pid'] . " "
         . "  AND ledger.docid = " . $_SESSION['docid'] . " "
         . "  AND trxn_code.docid = " . $_SESSION['docid'] . " "
         . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " ";
    $query = mysql_query($sql);
    $num_trxns = mysql_num_rows($query);
    $row_text = ($num_trxns == 1) ? "is 1 ledger transaction" : "are $num_trxns ledger transactions";
  ?>
  <tr class="<?=$tr_class;?>">
    <td>There <?=$row_text?> ready to be added to a new claim.</td>
    <td>n/a</td>
    <td>
      <?php if ($num_trxns > 0) { ?>
        <button onclick="Javascript: window.location = 'insurance.php?pid=<?=$_GET['pid'];?>';" class="addButton">
		  Add New Claim
	    </button>
      <?php } ?>
    </td>
  </tr>
</table>
</insurance>

<br/><br/>

<?php
$sql = "SELECT "
     . "  * "
     . "FROM "
     . "  dental_insurance_preauth "
     . "WHERE "
     . "  patient_id = " . $_GET['pid'] . " "
     . "ORDER BY "
     . "  front_office_request_date DESC "
     . "LIMIT 1";
$my = mysql_query($sql) or die(mysql_error());
?>
<div style="margin:auto; width:98%">
  <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" >
    <tr class="tr_bg_h">
      <th colspan="2" valign="top" class="col_head">
        Patient Verification of Benefits Information
      </th>
    </tr>
    <?php
  $sql2 = "SELECT p_m_ins_type FROM dental_patients p WHERE p.patientid=".$_GET['pid']." LIMIT 1";
  $my2 = mysql_query($sql2);
  $row2 = mysql_fetch_array($my2);
  if($row2['p_m_ins_type']==1){
    ?>
      <tr class="tr_bg">
	<td valign="top" align="center">
	  VOB CANNOT BE REQUESTED - patient has Medicare Insurance. You can change patient's insurance type in the Patient Info section.
 	</td>
      </tr>
      <?php } ?>
	<? if (mysql_num_rows($my) == 0) { ?>
      <tr class="tr_bg">
        <td valign="top" align="center">
          No verification of benefits on record.
        </td>
      </tr>
	<?php } else { ?> 
      <?php while ($preauth = mysql_fetch_array($my)) { ?>

	<?php if($preauth['status']==DSS_PREAUTH_PENDING){ ?>

      <tr class="tr_bg">
        <td valign="top" align="center">
		Verification of benefits request was submitted <?= date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and is currently pending.
        </td>
      </tr>



	<?php } elseif ($preauth['status']==DSS_PREAUTH_COMPLETE) { ?>
        <tr class="tr_bg">
          <td valign="top" colspan="2" align="center">
		    Verification of benefits completed on <?= date('m/d/Y', strtotime($preauth['date_completed'])); ?>.<br/>
		    Pays for replacement device every <?=$preauth['how_often'];?> years.
          </td>
        </tr>
        <tr class="tr_bg">
          <td>Benefits</td>
          <td>
            <?php $out_checked = ($preauth['network_benefits'] == '1') ? 'X' : '&nbsp;&nbsp;'; ?>
            <?php $in_checked  = ($preauth['network_benefits'] != '1') ? 'X' : '&nbsp;&nbsp;'; ?>
            (<?= $out_checked ?>) Out of network<br/>
            (<?= $in_checked ?>) In Network
          </td>
        </tr>
        <tr class="tr_bg">
          <td>What is the patient's annual deductible?</td>
          <td>$<?= $preauth['patient_deductible'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Amount met?</td>
          <td>$<?= $preauth['patient_amount_met'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Amount left to meet?</td>
          <td>$<?= $preauth['patient_amount_left_to_meet'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>What is the family deductible?</td>
          <td>$<?= $preauth['family_deductible'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Family amount met?</td>
          <td>$<?= $preauth['family_amount_met'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>When does the deductible reset?</td>
          <td><?= $preauth['deductible_reset_date'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Has patient's out of pocket expense been met?</td>
          <td><?= ($preauth['out_of_pocket_met'] == '0') ? 'No' : 'Yes' ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Insurance plan notes</td>
          <td><?= $preauth['code_covered_notes']; ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Out-of-network notes</td>
          <td><?= $preauth['hmo_auth_notes']; ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Device amount?</td>
          <td>$<?= $preauth['trxn_code_amount'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Expected insurance payment?</td>
          <td>$<?= $preauth['expected_insurance_payment'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Expected patient payment?</td>
          <td>$<?= $preauth['expected_patient_payment'] ?></td>
        </tr>
	<?php } ?>
      <?php } ?>
    <?php } ?>
		<tr>
			<td>New verification of benefits can be requested on Patient Flow Sheet.</td>
		</tr>
  </table>
</div>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}
?>

<? include "includes/bottom.htm";?>
