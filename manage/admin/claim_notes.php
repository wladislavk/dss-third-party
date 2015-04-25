<?php namespace Ds3\Libraries\Legacy; ?><?php

include 'includes/top.htm';
include_once '../includes/constants.inc';


$c_sql = "SELECT CONCAT(p.firstname,' ', p.lastname) pat_name, CONCAT(u.first_name, ' ',u.last_name) doc_name 
                FROM dental_insurance i
                JOIN dental_patients p ON i.patientid=p.patientid
                JOIN dental_users u ON u.userid=p.docid
		WHERE i.insuranceid='".mysqli_real_escape_string($con,$_GET['id'])."'";
$c_q = mysqli_query($con,$c_sql);
$c = mysqli_fetch_assoc($c_q);


?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/support.css" type="text/css" />

<span class="admin_head">
	Claim Notes - Pt: <?php echo  $c['pat_name']; ?> - Claim: <?php echo  $_GET['id']; ?> - Account: <?php echo  $c['doc_name']; ?>
<?php




 $n_sql = "SELECT n.*,
	CASE
	  WHEN create_type='0'
	    THEN CONCAT(a.first_name, ' ', a.last_name)
	  ELSE
	    CONCAT(u.first_name, ' ', u.last_name)
	  END as creator_name
	 FROM dental_claim_notes n 
	left join dental_users u ON n.creator_id = u.userid
	left join admin a ON n.creator_id = a.adminid
	where n.claim_id='".mysqli_real_escape_string($con,$_GET['id'])."'
	ORDER BY adddate ASC";
 $n_q = mysqli_query($con,$n_sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
?>
</span>
<br /><br />

<br /><br />
<div align="center" class="red">
	<?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?>
</div>
<div align="right">
	<button onclick="loadPopup('add_claim_note.php?claim_id=<?php echo  $_GET['id']; ?>&pid=<?php echo  $_GET['pid'];?>');return false;" class="btn btn-success"> Add Note <span class="glyphicon glyphicon-plus"></span> </button>	
	<button onclick="window.location='insurance_claim_v2.php?insid=<?php echo  $_GET['id']; ?>&pid=<?php echo  $_GET['pid'];?>';return false;" class="btn btn-success"> View Claim <span class="glyphicon glyphicon-view"></span> </button>	
</div>
<?php
 while($r = mysqli_fetch_assoc($n_q)){
?>

   <div class="panel <?php echo  ($r['create_type']==0)?"panel-info":"panel-success"; ?>" >
	<div class="panel-heading"><?php echo  $r['creator_name']; ?> on <?php echo  $r['adddate']; ?>
   <?php
        if($r['create_type']=='0' && $r['creator_id']==$_SESSION['adminuserid']){ ?>    <a href="#" onclick="loadPopup('add_claim_note.php?claim_id=<?php echo $_GET['id'];?>&pid=<?php echo $_GET['pid'];?>&nid=<?php echo $r['id'];?>');return false;" class="btn btn-default">Edit Note <span class="glyphicon glyphicon-pencil"></span>
</a>
        <?php } ?>
</div>
	<div class="panel-body">
     <?php echo  $r['note']; ?>
<?php
        $a_sql = "SELECT * FROM dental_claim_note_attachment WHERE note_id='".mysqli_real_escape_string($con,$r['id'])."'";
        $a_q = mysqli_query($con,$a_sql);
        while($a=mysqli_fetch_assoc($a_q)){
        ?> | <a href="display_file.php?f=<?php echo  $a['filename']; ?>" target="_blank">View Attachment</a><?php
        }
?>
    </div>
  </div>





  <?php } ?>

<div style="clear:both;"></div>
<?php
$status_sql = "SELECT status, primary_claim_id FROM dental_insurance
                WHERE insuranceid='".mysqli_real_escape_string($con,$_GET['id'])."'";
$status_q = mysqli_query($con,$status_sql);
$status_r = mysqli_fetch_assoc($status_q);
$status = $status_r['status'];
$is_sent = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? true : false;
$is_pending = ($status == DSS_CLAIM_PENDING || $status == DSS_CLAIM_SEC_PENDING) ? true : false;
$is_pri_pending = ($status == DSS_CLAIM_PENDING) ? true : false;
$is_sec_pending = ($status == DSS_CLAIM_SEC_PENDING) ? true : false;
$is_disputed = ($status == DSS_CLAIM_DISPUTE || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_PATIENT_DISPUTE || $status == DSS_CLAIM_SEC_PATIENT_DISPUTE) ? true : false;
$is_rejected = ($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED) ? true : false;
$is_secondary = ($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_SENT || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_SEC_REJECTED);

//currently if secondary it just pulls info from primary
//Need to change eventually to pull info from secondary
if($status_r['primary_claim_id']){
    $sql = "select * from dental_insurance where primary_claim_id='".$status_r['primary_claim_id']."' and patientid='".$_GET['pid']."'";
}else{
    $sql = "select * from dental_insurance where insuranceid='".$_GET['id']."' and patientid='".$_GET['pid']."'";
}
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con,$pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);
$docid = $pat_myarray['docid'];
if($is_pri_pending){
// Load patient info from dental_patients table using pid on query string
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con,$pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
$insurancetype = st($pat_myarray['p_m_ins_type']);
$other_insurancetype = $pat_myarray['s_m_ins_type'];
$insured_firstname = st($pat_myarray['p_m_partyfname']);
$insured_lastname = st($pat_myarray['p_m_partylname']);
$insured_middle = st($pat_myarray['p_m_partymname']);
$other_insured_firstname = st($pat_myarray['s_m_partyfname']);
$other_insured_lastname = st($pat_myarray['s_m_partylname']);
$other_insured_middle = st($pat_myarray['s_m_partymname']);
$insured_id_number = st($pat_myarray['p_m_ins_id']);
$insured_dob = st($pat_myarray['ins_dob']);
$p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
$other_insured_dob = st($pat_myarray['ins2_dob']);
$insured_insurance_plan = st($pat_myarray['p_m_ins_plan']);
$other_insured_insurance_plan = st($pat_myarray['s_m_ins_plan']);
$insured_policy_group_feca = st($pat_myarray['p_m_ins_grp']);
$other_insured_policy_group_feca = st($pat_myarray['s_m_ins_grp']);
$referredby = st($pat_myarray['referred_by']);
$referred_source = st($pat_myarray['referred_source']);
$docid = $pat_myarray['docid'];
}

if(!$is_pri_pending){
$pica1 = st($myarray['pica1']);
$pica2 = st($myarray['pica2']);
$pica3 = st($myarray['pica3']);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$patient_lastname = st($myarray['patient_lastname']);
$patient_firstname = st($myarray['patient_firstname']);
$patient_middle = st($myarray['patient_middle']);
$patient_dob = st($myarray['patient_dob']);
$patient_sex = st($myarray['patient_sex']);
  $insurancetype = st($myarray['insurance_type']);
  $other_insurancetype = $myarray['other_insurance_type'];
  $other_insured_firstname = st($myarray['other_insured_firstname']);
  $other_insured_lastname = st($myarray['other_insured_lastname']);
  $other_insured_middle = st($myarray['other_insured_middle']);
  $other_insured_dob = st($myarray['other_insured_dob']);
  $other_insured_sex = st($myarray['other_insured_sex']);
  $other_insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
  $other_insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
  $insured_id_number = st($myarray['insured_id_number']);
  $insured_firstname = st($myarray['insured_firstname']);
  $insured_middle = st($myarray['insured_middle']);
  $insured_lastname = st($myarray['insured_lastname']);
  $insured_dob = st($myarray['insured_dob']);
  $insured_insurance_plan = st($myarray['insured_insurance_plan']);
  $insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
  $insured_address = st($myarray['insured_address']);
  $insured_city = st($myarray['insured_city']);
  $insured_state = st($myarray['insured_state']);
  $insured_zip = st($myarray['insured_zip']);
  $insured_phone_code = st($myarray['insured_phone_code']);
  $insured_phone = st($myarray['insured_phone']);
  $insured_sex = st($myarray['insured_sex']);

  $other_insured_id_number = st($myarray['other_insured_id_number']);
  $other_insured_firstname = st($myarray['other_insured_firstname']);
  $other_insured_middle = st($myarray['other_insured_middle']);
  $other_insured_lastname = st($myarray['other_insured_lastname']);
  $other_insured_dob = st($myarray['other_insured_dob']);
  $other_insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
  $other_insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
  $other_insured_address = st($myarray['other_insured_address']);
  $other_insured_city = st($myarray['other_insured_city']);
  $other_insured_state = st($myarray['other_insured_state']);
  $other_insured_zip = st($myarray['other_insured_zip']);
  $other_insured_phone_code = st(!empty($myarray['other_insured_phone_code']) ? $myarray['other_insured_phone_code'] : '');
  $other_insured_phone = st(!empty($myarray['other_insured_phone']) ? $myarray['other_insured_phone'] : '');
  $other_insured_sex = st($myarray['other_insured_sex']);

  $patient_relation_insured = st($myarray['patient_relation_insured']);
$patient_address = st($myarray['patient_address']);
$patient_city = st($myarray['patient_city']);
$patient_state = st($myarray['patient_state']);
$patient_status = st($myarray['patient_status']);
$patient_status_array = explode('~',$patient_status);
$patient_zip = st($myarray['patient_zip']);
$patient_phone_code = st($myarray['patient_phone_code']);
$patient_phone = st($myarray['patient_phone']);
$total_charge = st($myarray['total_charge']);
$amount_paid = st($myarray['amount_paid']);
$balance_due = st($myarray['balance_due']);
$service_facility_info_name = st($myarray['service_facility_info_name']);
$service_facility_info_address = st($myarray['service_facility_info_address']);
$service_facility_info_city = st($myarray['service_facility_info_city']);
$service_info_a = st($myarray['service_info_a']);
$service_info_dd = st($myarray['service_info_dd']);
$service_info_b_other = st($myarray['service_info_b_other']);
$billing_provider_phone_code = st($myarray['billing_provider_phone_code']);
$billing_provider_phone = st($myarray['billing_provider_phone']);
$billing_provider_name = st($myarray['billing_provider_name']);
$billing_provider_address = st($myarray['billing_provider_address']);
$billing_provider_city = st($myarray['billing_provider_city']);
$billing_provider_a = st($myarray['billing_provider_a']);
$billing_provider_dd = st($myarray['billing_provider_dd']);
$billing_provider_b_other = st($myarray['billing_provider_b_other']);
}


if($is_pri_pending){
  $insured_sex = $pat_myarray['p_m_gender'];
  $other_insured_sex = $pat_myarray['s_m_gender'];
  $patient_sex = $pat_myarray['gender'];
  $patient_firstname = $pat_myarray['firstname'];
        $patient_lastname = $pat_myarray['lastname'];
        $patient_middle = $pat_myarray['middlename'];
        $patient_firstname = $pat_myarray['firstname'];
        $patient_address = $pat_myarray['add1'];
        $patient_city = $pat_myarray['city'];
        $patient_state = $pat_myarray['state'];
        $patient_zip = $pat_myarray['zip'];
        $patient_dob = $pat_myarray['dob'];
        if($pat_myarray['p_m_ins_ass']=='Yes'){
          $insured_signature = 1;
        }
        $patient_signature = 1;
        $signature_physician = "Signature on File";
        $patient_signed_date = date('m/d/Y', strtotime($pat_myarray['adddate']));
        $physician_signed_date = date('m/d/Y');
        $patient_phone_code = $pat_myarray['home_phone'];
        $patient_phone = $pat_myarray['home_phone'];
        $insured_phone_code = $pat_myarray['home_phone'];
        $insured_phone = $pat_myarray['home_phone'];
        $patient_status = $pat_myarray['marital_status'];
        $insured_id_number = $pat_myarray['p_m_ins_id'];
        $insured_address = $myarray['insured_address'];
        $insured_city = $myarray['insured_city'];
        $insured_state = $myarray['insured_state'];
        $insured_zip = $myarray['insured_zip'];
        $other_insured_id_number = $pat_myarray['s_m_ins_id'];
        $other_insured_address = $myarray['other_insured_address'];
        $other_insured_city = $myarray['other_insured_city'];
        $other_insured_state = $myarray['other_insured_state'];
        $other_insured_zip = $myarray['other_insured_zip'];
        $insured_dob = $pat_myarray['ins_dob'];
        $patient_relation_insured = $pat_myarray['p_m_relation'];
}
$total_charge = st($myarray['total_charge']);
?>

                                                                <?php
        $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,$_GET['id'])."'";
        $prod_q = mysqli_query($con,$prod_s);
        $prod_r = mysqli_fetch_assoc($prod_q);
        $claim_producer = $prod_r['producer'];

                      $getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
                      $userquery = mysqli_query($con,$getuserinfo);
                      if($userinfo = mysqli_fetch_array($userquery)){
                        $phone = $userinfo['phone'];
			$doc = $userinfo['first_name']." ".$userinfo['last_name'];
                        $practice = $userinfo['practice'];
                        $address = $userinfo['address'];
                        $city = $userinfo['city'];
                        $state = $userinfo['state'];
                        $zip = $userinfo['zip'];
                        $npi = $userinfo['npi'];
                        $medicare_npi = $userinfo['medicare_npi'];
                        $medicare_ptan = $userinfo['medicare_ptan'];
                      }
                      $getdocinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".$docid."'";
                      $docquery = mysqli_query($con,$getdocinfo);
                      $docinfo = mysqli_fetch_array($docquery);
                        if(empty($phone)){ $phone = $docinfo['phone']; }
                        if(empty($doc)){ $doc = $docinfo['first_name']." ".$docinfo['last_name']; }
                        if(empty($practice)){ $practice = $docinfo['practice']; }
                        if(empty($address)){ $address = $docinfo['address']; }
                        if(empty($city)){ $city = $docinfo['city']; }
                        if(empty($state)){ $state = $docinfo['state']; }
                        if(empty($zip)){ $zip = $docinfo['zip']; }
                        if(empty($npi)){ $npi = $docinfo['npi']; }
                        if(empty($medicare_npi)){ $medicare_npi = $docinfo['medicare_npi']; }
                        if(empty($medicare_ptan)){ $medicare_ptan = $docinfo['medicare_ptan']; }

                        if($docinfo['use_service_npi']==1){
                          $service_npi = $docinfo['service_npi'];
			  $service_doc = $docinfo['first_name']." ".$docinfo['last_name'];
                          $service_practice = $docinfo['service_name'];
                          $service_address = $docinfo['service_address'];
                          $service_city = $docinfo['service_city'];
                          $service_state = $docinfo['service_state'];
                          $service_zip = $docinfo['service_zip'];
                          $service_medicare_npi = $docinfo['service_medicare_npi'];
                        }else{
                          $service_npi = $npi;
			  $service_doc = $doc;
                          $service_practice = $practice;
                          $service_address = $address;
                          $service_city = $city;
                          $service_state = $state;
                          $service_zip = $zip;
                          $service_medicare_npi = $medicare_npi;
                        }

                                                                                                if($userinfo['tax_id_or_ssn'] != ''){ 
                                                                                                        $tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
                                                                                                  }else{
                                                                                                        $tax_id_or_ssn = $docinfo['tax_id_or_ssn'];
                                                                                                  }

        $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['p_m_ins_co'])."'";
        $inscoarray = mysqli_query($con,$inscoquery);
        $inscoinfo = mysqli_fetch_array($inscoarray);

  $sql = "SELECT "
       . "  ledger.*, ";if($is_pending){
  $sql .= "trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_2 as modcode2, trxn_code.days_units as daysorunits, ";
}
if($insurancetype == '1'){
        $sql .= " user.medicare_npi ";
}else{
        $sql .= " user.npi ";
}
  $sql .= "  as 'provider_id', ps.place_service as 'place', ps2.description AS place_description "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_users user ON user.userid = ledger.docid "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
       . "  LEFT JOIN dental_place_service ps2 ON ledger.placeofservice = ps2.place_service "
       . "WHERE "
       . "  ledger.primary_claim_id = " . $_GET['id'] . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = '" . $docid . "' "
       . "  AND trxn_code.docid = '" . $docid . "' "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
$query = mysqli_query($con,$sql);
$array = mysqli_fetch_array($query);
if ($is_pending) {

  // get total_charge
  if($is_pri_pending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysqli_query($con,$sql);
    if ($charge_my && (mysqli_num_rows($charge_my) > 0)) {
      $charge_row = mysqli_fetch_array($charge_my);
      $total_charge = $charge_row['total_charge'];
    }
  }
  // get amount paid
  $sql = "SELECT "
       . "  SUM(ledger.paid_amount) as 'amount_paid' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type IN (" . DSS_TRXN_TYPE_PATIENT . "," . DSS_TRXN_TYPE_INS . "," . DSS_TRXN_TYPE_ADJ . ") "
       . "ORDER BY "
       . "  ledger.service_date ASC";
  if(!empty($_GET['instype']) && $_GET['instype']==2 && $status == DSS_CLAIM_SEC_PENDING){
    $sql = "SELECT
                sum(dlp.amount) as amount_paid
        from dental_ledger dl
                LEFT JOIN dental_users p ON dl.producerid=p.userid
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$docid."' and dl.patientid='".s_for($_GET['pid'])."'
                        AND primary_claim_id=".$_GET['insid']."
                        AND dlp.amount != 0
                        AND dlp.payer = 0
        ";
  }
  $paid_my = mysqli_query($con,$sql);
  if ($paid_my && (mysqli_num_rows($paid_my) > 0)) {
    $paid_row = mysqli_fetch_array($paid_my);
    $amount_paid = $paid_row['amount_paid'];
  }

  // re-calculate balance due
  $balance_due = $total_charge - $amount_paid;

  // format calculations
  $total_charge += 0.0;
  $total_charge = number_format($total_charge, 2, '.','');
  $amount_paid = number_format($amount_paid, 2, '.','');
  $balance_due = number_format($balance_due, 2, '.','');

}
?>


<div style="display:block; float:left; width:48%;">
<h3>Primary</h3>
<ul>
  <li><label>Insurance Co.:</label><span class="value"><?php echo $inscoinfo['company']; ?></span></li>
  <li><label>Insurance Addr:</label><span class="value"><?php echo $inscoinfo['add1']." ".$inscoinfo['add2']." ".$inscoinfo['city']." ".$inscoinfo['state']." ".$inscoinfo['zip']; ?></span></li>
  <li><label>Insurance Phone: </label> <span class="value"><?php echo $inscoinfo['phone1']; ?></span></li>
  <li><label>Insurance Fax: </label> <span class="value"><?php echo $inscoinfo['fax']; ?></span></li>
</ul>

<ul>
  <li><label>Doc Name:</label><span class="value"><?php echo  $service_doc; ?></span></li>
  <li><label>Doc Practice:</label><span class="value"><?php echo  $service_practice; ?></span></li>
  <li><label>Doc Addr:</label><span class="value"><?php echo  $service_address." " .$service_city." ".$service_state." ".$service_zip; ?></span></li>
  <li><label>Doc Tax ID:</label><span class="value"><?php echo $docinfo['tax_id_or_ssn'];?></span></li>
  <li><label>Doc NPI:</label><span class="value"><?php echo  $service_npi; ?></span></li>
</ul>

<ul>
  <li><label>Billing Name:</label> <span class="value"><?php echo  $practice; ?></span></li>
  <li><label>Billing Addr:</label> <span class="value"><?php echo $address; ?> <?php echo $city;?>, <?php echo $state;?> <?php echo $zip;?></span></li>
  <li><label>Billing Tax ID:</label> <span class="value"><?php echo  $tax_id_or_ssn; ?></span></li>
  <li><label>Billing NPI:</label> <span class="value"><?php echo  ($insurancetype == '1')?$medicare_npi:$npi; ?></span></li>
  <li><label>Medicare Billing NPI:</label> <span class="value"><?php echo  $medicare_npi; ?></span></li>
  <li><label>Medicare PTAN:</label> <span class="value"><?php echo  $medicare_ptan; ?></span></li>
</ul>

<ul>
  <li><label>Pt Name:</label> <span class="value"><?php echo  $patient_firstname. " ".$patient_lastname; ?></span></li>
  <li><label>Pt DOB:</label> <span class="value"><?php echo  date('Y-m-d', strtotime(str_replace('-','/',$patient_dob))); ?></span></li>
  <li><label>Pt Sex:</label> <span class="value"><?php echo  $patient_sex; ?></span></li>
  <li><label>Pt Addr:</label> <span class="value"><?php echo  $patient_address." ".$patient_city." ".$patient_state." ".$patient_zip; ?></span></li>
  <li><label>Pt Ins ID:</label> <span class="value"><?php echo  $insured_id_number; ?></span></li>
  <li><label>Pt Group #:</label> <span class="value"><?php echo  $insured_policy_group_feca; ?></span></li>
  <li><label>Pt Phone:</label> <span class="value"><?php echo  $patient_phone_code ." ".$patient_phone; ?></span></li>
  <li><label>Pt Relation to Insd:</label> <span class="value"><?php echo  $patient_relation_insured; ?></span></li>
</ul>

<ul>
  <li><label>Insured Name:</label> <span class="value"><?php echo  $insured_firstname." ".$insured_lastname;?></span></li>
  <li><label>Insured DOB:</label> <span class="value"><?php echo  $insured_dob; ?></span></li>
  <li><label>Insured Sex:</label> <span class="value"><?php echo  $insured_sex; ?></span></li>
  <li><label>Insured Addr:</label> <span class="value"><?php echo  $insured_address." ".$insured_city." ".$insured_state." ".$insured_zip; ?></span></li>
  <li><label>Insured Ins ID:</label> <span class="value"><?php echo  $insured_id_number; ?></span></li>
  <li><label>Insured Group #:</label> <span class="value"><?php echo  $insured_policy_group_feca; ?></span></li>
  <li><label>Insured Phone:</label> <span class="value"><?php echo  $insured_phone; ?></span></li>
</ul>

<ul>
  <li><label>Claim Date of Service: </label> <span class="value"><?php echo date('m-d-Y', strtotime($array['service_date'])); ?></span></li>
  <li><label>Total Claim Amt: </label> <span class="value"><?php echo  $total_charge; ?></span></li>
</ul>
</div>




<div style="display:block; float:left; width:48%;">
<h3>Secondary</h3>
<?php
  if(!empty($pat_myarray['has_s_m_ins']) && $pat_myarray['has_s_m_ins']!='Yes'){
?>
  None
  <?php
  } else {
    $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['s_m_ins_co'])."'";
    $inscoarray = mysql_query($inscoquery);
    $inscoinfo = mysql_fetch_array($inscoarray);
  ?>
<ul>
  <li><label>Insurance Co.:</label><span class="value"><?php echo $inscoinfo['company']; ?></span></li>
  <li><label>Insurance Addr:</label><span class="value"><?php echo $inscoinfo['add1']." ".$inscoinfo['add2']." ".$inscoinfo['city']." ".$inscoinfo['state']." ".$inscoinfo['zip']; ?></span></li>
  <li><label>Insurance Phone: </label> <span class="value"><?php echo $inscoinfo['phone1']; ?></span></li>
  <li><label>Insurance Fax: </label> <span class="value"><?php echo $inscoinfo['fax']; ?></span></li>
</ul>

<ul>
  <li><label>Doc Name:</label><span class="value"><?php echo  $service_doc; ?></span></li>
  <li><label>Doc Practice:</label><span class="value"><?php echo  $service_practice; ?></span></li>
  <li><label>Doc Addr:</label><span class="value"><?php echo  $service_address." " .$service_city." ".$service_state." ".$service_zip; ?></span></li>
  <li><label>Doc Tax ID:</label><span class="value"><?php echo $docinfo['tax_id_or_ssn'];?></span></li>
  <li><label>Doc NPI:</label><span class="value"><?php echo  $service_npi; ?></span></li>
</ul>

<ul>
  <li><label>Billing Name:</label> <span class="value"><?php echo  $practice; ?></span></li>
  <li><label>Billing Addr:</label> <span class="value"><?php echo $address; ?> <?php echo $city;?>, <?php echo $state;?> <?php echo $zip;?></span></li>
  <li><label>Billing Tax ID:</label> <span class="value"><?php echo  $tax_id_or_ssn; ?></span></li>
  <li><label>Billing NPI:</label> <span class="value"><?php echo  ($insurancetype == '1')?$medicare_npi:$npi; ?></span></li>
</ul>

<ul>
  <li><label>Pt Name:</label> <span class="value"><?php echo  $patient_firstname. " ".$patient_lastname; ?></span></li>
  <li><label>Pt DOB:</label> <span class="value"><?php echo  date('d-m-Y', strtotime(str_replace('-','/',$patient_dob))); ?></span></li>
  <li><label>Pt Sex:</label> <span class="value"><?php echo  $patient_sex; ?></span></li>
  <li><label>Pt Addr:</label> <span class="value"><?php echo  $patient_address." ".$patient_city." ".$patient_state." ".$patient_zip; ?></span></li>
  <li><label>Pt Ins ID:</label> <span class="value"><?php echo  $other_insured_id_number; ?></span></li>
  <li><label>Pt Group #:</label> <span class="value"><?php echo  $other_insured_policy_group_feca; ?></span></li>
  <li><label>Pt Phone:</label> <span class="value"><?php echo  $patient_phone_code ." ".$patient_phone; ?></span></li>
  <li><label>Pt Relation to Insd:</label> <span class="value"><?php echo  $other_patient_relation_insured; ?></span></li>
</ul>

<ul>
  <li><label>Insured Name:</label> <span class="value"><?php echo  $other_insured_firstname." ".$other_insured_lastname;?></span></li>
  <li><label>Insured DOB:</label> <span class="value"><?php echo  date('Y-m-d', strtotime(str_replace('-','/',$other_insured_dob))); ?></span></li>
  <li><label>Insured Sex:</label> <span class="value"><?php echo  $other_insured_sex; ?></span></li>
  <li><label>Insured Addr:</label> <span class="value"><?php echo  $other_insured_address." ".$other_insured_city." ".$other_insured_state." ".$other_insured_zip; ?></span></li>
  <li><label>Insured Ins ID:</label> <span class="value"><?php echo  $other_insured_id_number; ?></span></li>
  <li><label>Insured Group #:</label> <span class="value"><?php echo  $other_insured_policy_group_feca; ?></span></li>
  <li><label>Insured Phone:</label> <span class="value"><?php echo  (!empty($other_insured_phone) ? $other_insured_phone : ''); ?></span></li>
</ul>

<ul>
  <li><label>Claim Date of Service: </label><span class="value"><?php echo date('m-d-Y', strtotime($array['service_date'])); ?></span></li>
  <li><label>Total Claim Amt: </label> <span class="value"><?php echo  ($total_charge!='')?$total_charge:'0.00'; ?></span></li>
</ul>
<?php } ?>
</div>


<div style="clear:both;"></div>

<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<?php include 'includes/bottom.htm';?>
