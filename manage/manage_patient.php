
<?php 
include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');

if(isset($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_patients where patientid='".$_REQUEST["delid"]."'";
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

$rec_disp = 50;

if(isset($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'lastname';
  $_REQUEST['sortdir'] = 'ASC';
}

$sql = "SELECT "
		 . "  p.patientid, p.status, p.lastname, p.firstname, p.middlename, p.premedcheck, "
     . "  s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment, "
		 . "  pg2.date_scheduled as next_scheduled, "
		 . "  (SELECT pg2_info.date_completed FROM dental_flow_pg2_info pg2_info WHERE pg2_info.appointment_type=1 AND pg2_info.patientid = p.patientid ORDER BY pg2_info.date_completed DESC, pg2_info.id DESC LIMIT 1 ) as last_completed, "
                 . "  (SELECT pg2_info2.segmentid FROM dental_flow_pg2_info pg2_info2 WHERE pg2_info2.appointment_type=1 AND pg2_info2.patientid = p.patientid ORDER BY pg2_info2.date_completed DESC, pg2_info2.id DESC LIMIT 1 ) as last_segmentid, "
		 . "  ex.dentaldevice_date as delivery_date, s.vob, s.ledger, s.patient_info, dd.device, "
                 . " fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec, "
                 ." 
		CASE  
			WHEN la.amount IS NOT NULL THEN la.amount
			ELSE 0
		 END as ledger_amount, 
		 CASE 
			WHEN la2.amount IS NOT NULL THEN la2.amount
			ELSE 0
		 END as ledger2_amount,
		 CASE
			WHEN lp.amount IS NOT NULL THEN lp.amount
			ELSE 0
		 END as ledger_payment_amount,
		 CASE
			WHEN lp2.amount IS NOT NULL THEN lp2.amount
			ELSE 0
		 END as ledger2_payment_amount
"
		 . "FROM "
		 . "  dental_patients p  "
		 . "  LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
		 . "  LEFT JOIN dental_device d ON s.appliance = d.deviceid  "
		 . "  LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid " 
		 . "  LEFT JOIN dental_flow_pg2_info pg2 ON pg2.patientid=p.patientid AND pg2.appointment_type=0 "
		 . "  LEFT JOIN dental_ex_page5 ex ON ex.patientid = p.patientid "
		 . "  LEFT JOIN dental_device dd ON dd.deviceid = ex.dentaldevice " 
."
LEFT JOIN (select sum(dl.amount) as amount, patientid  from dental_ledger dl
                        where dl.docid='".$_SESSION['docid']."' 
                        and (dl.paid_amount IS NULL || dl.paid_amount = 0)
			group by patientid
                ) la ON la.patientid=p.patientid
LEFT JOIN (select sum(dl.amount) amount, patientid from dental_ledger dl
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."'
                        AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0) GROUP BY patientid) la2 ON la2.patientid=p.patientid
LEFT JOIN (select sum(dlp.amount) amount, patientid        from dental_ledger dl
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' 
                        AND dlp.amount != 0 GROUP BY patientid) lp ON lp.patientid = p.patientid
LEFT JOIN (select sum(dl.paid_amount)  amount, patientid       from dental_ledger dl
                        where dl.docid='".$_SESSION['docid']."'
                        AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0) group by patientid) lp2 ON lp2.patientid = p.patientid
"
		 . "WHERE "
		 . " p.docid='".$_SESSION['docid']."'";
if(isset($_GET['pid']))
{
	$sql .= " AND p.patientid = ".$_GET['pid'];
}
if(!isset($_GET['sh']))
{
        $sql .= " AND p.status = 1";
}elseif($_GET['sh'] == 1 )
{
	$sql .= " AND p.status = 1";
}elseif($_GET['sh'] == 2)
{
        $sql .= " AND (p.status = 1 OR p.status = 2)";
}elseif($_GET['sh'] == 3)
{
        $sql .= " AND p.status = 2";
}
if(isset($_GET['letter'])){
  $sql .= " AND p.lastname LIKE '".mysql_real_escape_string($_GET['letter'])."%' ";
}
if(isset($_REQUEST['sort'])){
  if ($_REQUEST['sort'] == 'lastname') {
  	$sql .= " ORDER BY p.lastname ".$_REQUEST['sortdir'].", p.firstname ".$_REQUEST['sortdir'];
  } elseif ($_REQUEST['sort'] == 'rxrec') {
        $sql .= " ORDER BY rxrec ".$_REQUEST['sortdir'].", lomnrec ".$_REQUEST['sortdir'];
  } elseif ($_REQUEST['sort'] == 'ledger') {
        $sql .= " ORDER BY (ledger_amount + ledger2_amount - ledger_payment_amount - ledger2_payment_amount) ".$_REQUEST['sortdir'];
  } else  {
	  $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
	}
}
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
<div style="clear: both">
<span class="admin_head">
	Manage Patient <?= (isset($patient_info))?$patient_info:''; ?>
	-
	<select name="show" onchange="Javascript: window.location ='<?=$_SERVER['PHP_SELF'];?>?sh='+this.value;">
		<option value="1">Active Patients</option>
		<option value="2" <? if(isset($_GET['sh'])){ if($_GET['sh'] == 2) echo " selected"; } ?> >All Patients</option>
                <option value="3" <? if(isset($_GET['sh'])){ if($_GET['sh'] == 3) echo " selected"; } ?> >In-active Patients</option>
	</select>

</span>
<!--<div align="right">
		<div style="float:left;margin-right:386px;width:140px;padding-left:4px;"><script type="text/javascript" language="JavaScript" src="script/find.js">
</script>
</div>

	<button onclick="Javascript: parent.location='add_patient.php';" class="addButton">
		Add New Patient
	</button>
	&nbsp;&nbsp;
	
	<button onclick="Javascript: loadPopup('print_patient.php?st=1');" class="addButton">
		Print Active Patient
	</button>
	&nbsp;&nbsp;
	
	<button onclick="Javascript: loadPopup('print_patient.php?st=2');" class="addButton">
		Print In-Active Patient
	</button>
	&nbsp;&nbsp;
</div>-->
<div class="letter_select">
<?php
  $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  foreach($letters as $let){
        ?><a <?= ($_GET['letter']==$let)?'class="selected_letter"':''; ?> href="manage_patient.php?letter=<?=$let;?>&sh=<?=$_GET['sh'];?>"><?=$let;?></a>
<?php
  }
if(isset($_GET['letter']) && $_GET['letter'] != ''){
?><a href="manage_patient.php?sh=<?=$_GET['sh'];?>">View All</a>
<?php } ?>

</div>
<br />
<?php
  if(isset($_GET['msg'])){
?>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<?php } ?>
<style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
</div>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post" style="clear: both">
<table id="patients" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"letter=".$_GET['letter']."&sh=".$_GET['sh']);
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'lastname')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=lastname&sortdir=<?php echo ($_REQUEST['sort']=='lastname'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Name</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.fspage1_complete')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.fspage1_complete&sortdir=<?php echo ($_REQUEST['sort']=='s.fspage1_complete'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ready for Tx</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'pg2.date_scheduled')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=pg2.date_scheduled&sortdir=<?php echo ($_REQUEST['sort']=='pg2.date_scheduled'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Next Visit</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'last_completed')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=last_completed&sortdir=<?php echo ($_REQUEST['sort']=='last_completed'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Last Visit</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'last_segmentid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=last_segmentid&sortdir=<?php echo ($_REQUEST['sort']=='last_segmentid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Last Treatment</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'device')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=device&sortdir=<?php echo ($_REQUEST['sort']=='device'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Appliance</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'delivery_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=delivery_date&sortdir=<?php echo ($_REQUEST['sort']=='delivery_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Appliance Since</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'xb')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=vob&sortdir=<?php echo ($_REQUEST['sort']=='vob'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">VOB</a>
		</td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'rxrec')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        <a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=rxrec&sortdir=<?php echo ($_REQUEST['sort']=='rxrec'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Rx./L.O.M.N.</a>
                </td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'ledger')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=ledger&sortdir=<?php echo ($_REQUEST['sort']=='ledger'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ledger</a>
		</td>
	</tr>
  <tr class="template" style="display:none;">
    <td class="patient_name">John Smith</td>
    <td class="flowsheet">No</td>
    <td class="next_visit">(4 days)</td>
    <td class="last_visit">1 yr 2 mo</td>
    <td class="last_treatment">Consult</td>
    <td class="appliance">TAP 3</td>
    <td class="appliance_since">63 days</td>
    <td class="vob">Complete</td>
    <td class="rxlomn">N/A</td>
    <td class="ledger">($435.75)</td>
  </tr>
<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="9" align="center">
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
		?>
			<tr class="<?=$tr_class;?> initial_list">
				<td valign="top">
					<a href="add_patient.php?pid=<?=$myarray["patientid"];?>&ed=<?=$myarray["patientid"];?>">
					<?=st($myarray["lastname"]);?>,&nbsp;
										<?=st($myarray["firstname"]); ?>&nbsp;
                    <?= (!empty($myarray["middlename"]) ? st($myarray["middlename"]) : ""); ?></a>
                    <?php
		$sqlq3 = "select other_allergens, allergenscheck from dental_q_page3 WHERE patientid=".mysql_real_escape_string($myarray['patientid']);
                    $myq3 = mysql_query($sqlq3);
                    $myq3array = mysql_fetch_assoc($myq3);
                    $allergen = $myq3array['allergenscheck'];

                    if($myarray["premedcheck"] == 1 || $allergen == 1){
                    echo "&nbsp;&nbsp;&nbsp;<font style=\"font-weight:bold; color:#FF0000;\">*Med</font>";
                    }
                    ?> 
				</td>
          <?php if($myarray['patient_info'] == 1){ ?>
				<td valign="top">
		<?php
		  $pat_sql = "SELECT * FROM dental_patients WHERE patientid='".$myarray['patientid']."'";
  $pat_q = mysql_query($pat_sql);
  $pat_r = mysql_fetch_assoc($pat_q);
  if($pat_r['p_m_dss_file']!='' && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE){
    $ins_error = false;
  }elseif($pat_r['p_m_dss_file']!=1){
    $ins_error = true;
  }else{
    $ins_error = false;
  }
$sleepstudies = "SELECT ss.completed FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        (ss.filename!='' AND ss.filename IS NOT NULL) AND ss.patiendid = '".$myarray['patientid']."';";

  $result = mysql_query($sleepstudies);
  $numsleepstudy = mysql_num_rows($result);
  if($numsleepstudy == 0){
    $study_error = true;
  }else{
    $study_error = false;
  }
?>
        	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>"><?= ((!$ins_error && !$study_error) ? "Yes" : "<span class=\"red\">No</span>"); ?></a>
        </td>
        <td valign="top">
        	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>"><?= format_date($myarray['next_scheduled']); ?></a>
        </td>
<?php
$segments = Array();
$segments[15] = "Baseline Sleep Test";
$segments[2] = "Consult";
$segments[4] = "Impressions";
$segments[7] = "Device Delivery";
$segments[8] = "Check / Follow Up";
$segments[10] = "Home Sleep Test";
$segments[3] = "Sleep Study";
$segments[11] = "Treatment Complete";
$segments[12] = "Annual Recall";
$segments[14] = "Not a Candidate";
$segments[5] = "Delaying Tx / Waiting";
$segments[9] = "Pt. Non-Compliant";
$segments[6] = "Refused Treatment";
$segments[13] = "Termination";
$segments[1] = "Initial Contact";

?>
        <td valign="top">
        	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>"><?= format_date($myarray['last_completed'], true); ?></a>
        </td>
        <td valign="top">
          <a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>"><?= ($myarray['last_segmentid'] == null ? 'N/A' : $segments[$myarray['last_segmentid']]); ?></a>
        </td>
				<td valign="top">
	       	<a href="dss_summ.php?pid=<?=$myarray["patientid"];?>"><?= $myarray['device']; ?></a>
        </td>
        <td valign="top">
	       	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>"><?= format_date($myarray['delivery_date'], true); ?></a>
	      </td>
        <td valign="top">
	       	<a href="manage_insurance.php?pid=<?=$myarray["patientid"];?>"><?= ($myarray['vob'] == null ? 'No' : ($myarray['vob']==1 ? "Yes": $dss_preauth_status_labels[$myarray['vob']])); ?></a>
        </td>
        <td valign="top">
                <a href="manage_insurance.php?pid=<?=$myarray["patientid"];?>">
			<?php 
			  if($myarray['lomnrec'] != null && $myarray['rxrec'] != null){
				?>Yes<?php
			  }elseif($myarray['rxrec']!=null && $myarray['lomnrec'] == null){
				?>Yes/No<?php
                          }elseif($myarray['lomnrec'] != null && $myarray['rxrec'] == null){
                                ?>No/Yes<?php
                          }else{ 
                                ?>No<?php
                          } 
                        ?>

		</a>
        </td>
        <td valign="top">
		<?php
$total = $myarray['ledger_amount'] + $myarray['ledger2_amount'] - $myarray['ledger_payment_amount'] - $myarray['ledger2_payment_amount'];
?>

	       	<a href="manage_ledger.php?pid=<?=$myarray["patientid"];?>"><?= ($myarray['ledger'] == null ? 'N/A' : format_ledger(number_format($total,0))); ?></a>
<?= $total1; ?>
        </td>
        <?php }else{ ?>

           <td colspan="9" align="center" class="pat_incomplete">-- Patient Incomplete --</td>

        <?php } ?> 
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
