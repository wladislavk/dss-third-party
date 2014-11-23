<?php 
include_once "admin/includes/main_include.php";
include_once 'includes/constants.inc';
$sql = "select 
		dc.contactid,
		dc.salutation,
		dc.firstname,
		dc.middlename,
		dc.lastname, 
		p.referred_source,
		count(p.patientid) as num_ref, 
		(SELECT count(*) FROM dental_patients p30 WHERE p30.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p30.referred_by AND STR_TO_DATE(p30.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) as num_ref30,
                (SELECT count(*) FROM dental_patients p60 WHERE p60.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p60.referred_by AND STR_TO_DATE(p60.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as num_ref60,
                (SELECT count(*) FROM dental_patients p90 WHERE p90.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p90.referred_by AND STR_TO_DATE(p90.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)) as num_ref90,
                (SELECT count(*) FROM dental_patients p90plus WHERE p90plus.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p90plus.referred_by AND STR_TO_DATE(p90plus.copyreqdate, '%m/%d/%Y') < DATE_SUB(CURDATE(), INTERVAL 90 DAY)) as num_ref90plus,

		'".DSS_REFERRED_PHYSICIAN."' as referral_type,
		ct.contacttype
	from dental_contact dc 
		INNER JOIN dental_contacttype ct ON ct.contacttypeid = dc.contacttypeid
		INNER JOIN dental_patients p on dc.contactid=p.referred_by
	where dc.docid='".$_SESSION['docid']."'
		AND p.referred_source=".DSS_REFERRED_PHYSICIAN."
		GROUP BY dc.contactid
  UNION
	select
		dp.patientid,
		dp.salutation,
		dp.firstname,
		dp.middlename,
		dp.lastname,
		p.referred_source,
		count(p.patientid),
                (SELECT count(*) FROM dental_patients p30 WHERE p30.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p30.referred_by AND STR_TO_DATE(p30.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) as num_ref30,
                (SELECT count(*) FROM dental_patients p60 WHERE p60.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p60.referred_by AND STR_TO_DATE(p60.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as num_ref60,
                (SELECT count(*) FROM dental_patients p90 WHERE p90.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p90.referred_by AND STR_TO_DATE(p90.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)) as num_ref90,
                (SELECT count(*) FROM dental_patients p90plus WHERE p90plus.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p90plus.referred_by AND STR_TO_DATE(p90plus.copyreqdate, '%m/%d/%Y') < DATE_SUB(CURDATE(), INTERVAL 90 DAY)) as num_ref90plus,
		'".DSS_REFERRED_PATIENT."',
		'Patient'
	from dental_patients dp
		INNER JOIN dental_patients p ON dp.patientid=p.referred_by
	where p.docid='".$_SESSION['docid']."'
                AND p.referred_source=".DSS_REFERRED_PATIENT."
		GROUP BY dp.patientid
";
if (!empty($_GET['sort'])) {
	switch($_GET['sort']){
	  case 'type':
	    $sql .= " ORDER BY referral_type ".$_GET['sortdir'];
	    break;
	  case 'total':
	    $sql .= " ORDER BY num_ref ".$_GET['sortdir'];
	    break;
	  case 'thirty':
	    $sql .= " ORDER BY num_ref30 ".$_GET['sortdir'];
	    break;
	  case 'sixty':
	    $sql .= " ORDER BY num_ref60 ".$_GET['sortdir'];
	    break;
	  case 'ninty':
	    $sql .= " ORDER BY num_ref90 ".$_GET['sortdir'];
	    break;
	  case 'nintyplus':
	    $sql .= " ORDER BY num_ref90plus ".$_GET['sortdir'];
	    break;
	  default:
	    $sql .= " ORDER BY lastname ".$_GET['sortdir'].", firstname ".$_GET['sortdir'];
	    break;
	}
}

$my = $db->getResults($sql);
$total_rec = count($my);
$num_referredby = count($my);?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Referral Source Printout - <?php echo date('m/d/Y'); ?> 
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table width="98%" cellpadding="5" cellspacing="0" border="1" bgcolor="#FFFFFF" align="center" >
		<tr class="tr_bg_h">
			<td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			Name
			</td>
			<td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'type')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			Physician Type
			</td>
			<td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'total')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			Total Referrals
			</td>
			<td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'thirty')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
				30 Days
			</td>
			<td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'sixty')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
				60 Days
			</td>
			<td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'ninty')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
				90 Days
			</td>
			<td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'ninty')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
				90+ Days
			</td>
		</tr>
<?php 
if($total_rec == 0){ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>SELECT count(*) FROM dental_patients p30 WHERE p30.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p30.referred_by AND STR_TO_DATE(p30.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()
<?php 
} else {
	foreach ($my as $myarray) {
		$pat_sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and referred_by='".(!empty($myarray["referredbyid"]) ? $myarray["referredbyid"] : '')."'";
		$pat_my = $db->getRow($pat_sql);
		
		if(!empty($myarray["status"]) && $myarray["status"] == 1){
			$tr_class = "tr_active";
		} else {
			$tr_class = "tr_inactive";
		}
		
		$name = st($myarray['salutation'])." ".st($myarray['firstname'])." ".st($myarray['middlename'])." ".st($myarray['lastname']);?>
		<tr class="<?php echo $tr_class;?>">
			<td valign="top">
				<?php echo $name;?>
			</td>
			<td valign="top">
				<?php echo st($myarray['contacttype']);?>
			</td>
			<td valign="top">
				<?php echo $myarray['num_ref'];?>
			</td>
			<td valign="top">
<?php
		if($myarray['referral_type']==DSS_REFERRED_PHYSICIAN){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PHYSICIAN." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()";
		}elseif($myarray['referral_type']==DSS_REFERRED_PHYSICIAN){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PATIENT." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()";
		}
		$ref_q = $db->getResults($ref_sql);
		if ($ref_q) foreach ($ref_q as $ref) {
			echo $ref['firstname'].' '.$ref['lastname'];
			echo ($ref['copyreqdate'])?' - '. date('m/d/Y', strtotime($ref['copyreqdate'])):'';?>
				<br />
<?php
		}?>
				&nbsp;
			</td>
			<td valign="top">
<?php
		if($myarray['referral_type']==DSS_REFERRED_PHYSICIAN){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PHYSICIAN." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
		}elseif($myarray['referral_type']==DSS_REFERRED_PATIENT){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PATIENT." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
		}
		$ref_q = $db->getResults($ref_sql);
		if(count($ref_q)>0){
			foreach ($ref_q as $ref) {                       
				echo $ref['firstname'].' '.$ref['lastname'];
				echo ($ref['copyreqdate'])?' - '. date('m/d/Y', strtotime($ref['copyreqdate'])):'';?>
				<br />
<?php
			}
		}else{?>
				&nbsp;
<?php 
		} ?>
			</td>
			<td valign="top">
<?php
		if($myarray['referral_type']==DSS_REFERRED_PHYSICIAN){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PHYSICIAN." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)";
		}elseif($myarray['referral_type']==DSS_REFERRED_PATIENT){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PATIENT." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)";
		}
			$ref_q = $db->getResults($ref_sql);
		if(count($ref_q)>0){
			foreach ($ref_q as $ref) {
				echo $ref['firstname'].' '.$ref['lastname'];
				echo ($ref['copyreqdate'])?' - '. date('m/d/Y', strtotime($ref['copyreqdate'])):'';?>
				<br />
<?php
			}
		}else{?>
				&nbsp;
<?php 
		} ?>
			</td>
			<td valign="top">
<?php
		if($myarray['referral_type']==DSS_REFERRED_PHYSICIAN){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PHYSICIAN." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') < DATE_SUB(CURDATE(), INTERVAL 90 DAY)";
		}elseif($myarray['referral_type']==DSS_REFERRED_PATIENT){
			$ref_sql = "SELECT * FROM dental_patients p WHERE p.referred_source=".DSS_REFERRED_PATIENT." AND p.referred_by = '".$myarray['contactid']."' AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') < DATE_SUB(CURDATE(), INTERVAL 90 DAY)";
		}
			$ref_q = $db->getResults($ref_sql);
		if(count($ref_q)>0){
			foreach ($ref_q as $ref) {
				echo $ref['firstname'].' '.$ref['lastname'];
				echo ($ref['copyreqdate'])?' - '. date('m/d/Y', strtotime($ref['copyreqdate'])):'';?>
				<br />
<?php
			}
		}else{?>
				&nbsp;
<?php 
		} ?>
			</td>
		</tr>
<?php 	
	}
}?>
	</table>
</form>


