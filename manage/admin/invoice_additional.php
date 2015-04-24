<?php 
include "includes/top.htm";
  include_once '../3rdParty/stripe/lib/Stripe.php';
include '../includes/calendarinc.php';
include 'includes/invoice_functions.php';

  if(isset($_GET['show']) && $_GET['show']=='1'){
  $sql = "SELECT du.*, c.name AS company_name, plan.free_fax, plan.free_eligibility, plan.free_enrollment,
                plan.trial_period, 
                (SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
                JOIN dental_plans plan ON plan.id = du.plan_id
                WHERE du.status=1 AND du.docid=0
		AND du.userid='".mysqli_real_escape_string($con,$_GET['docid'])."'
 ";


  }else{
  $sql = "SELECT du.*, c.name AS company_name, plan.free_fax, plan.free_eligibility, plan.free_enrollment,
		plan.trial_period, 
                (SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
		JOIN dental_plans plan ON plan.id = du.plan_id
                WHERE du.status=1 AND du.docid=0
AND 
                ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".mysqli_real_escape_string($con,DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) < DATE_SUB(now(), INTERVAL 1 MONTH) OR 
                        ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".mysqli_real_escape_string($con,DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) IS NULL AND DATE_ADD(du.adddate, INTERVAL plan.trial_period DAY) < now()))
 ";


/*
        $sql = "SELECT du.*, c.name AS company_name, c.id AS company_id, p.name as plan_name,
		pi.id as invoice_id,
                (SELECT COUNT(i.id) FROM dental_percase_invoice i WHERE i.docid=du.userid) AS num_invoices,
                (SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.percase_status = '".DSS_PERCASE_PENDING."') AS num_case, 
                (SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.service_date > DATE_SUB(now(), INTERVAL 30 DAY)) as num_case30,
                (SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM dental_users du
                        JOIN dental_percase_invoice pi ON pi.docid=du.userid 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
                JOIN dental_plans p ON p.id=du.plan_id
                WHERE pi.status='".DSS_INVOICE_PENDING."' ";
*/
  if(isset($_GET['company']) && $_GET['company'] != ""){
    	$sql .= " AND c.id='".mysqli_real_escape_string($con,$_GET['company'])."' ";
  }
  if(isset($_GET['uid']) && $_GET['uid'] != ""){
        $sql .= " AND du.userid > '".mysqli_real_escape_string($con,$_GET['uid'])."' ";
  }
  if(isset($_GET['show']) && $_GET['show']=='all'){
   	$sql .= " ORDER BY du.userid ASC ";
  }else{
	$sql .= " AND 
		(SELECT COUNT(*) as num_inv FROM dental_percase_invoice
			WHERE docid=du.userid AND 
				status = '".DSS_INVOICE_PENDING."')
		!= 0
		ORDER BY du.userid ASC
		";
		/*
                ((SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.percase_status = '".DSS_PERCASE_PENDING."') != 0 OR 
		(SELECT COUNT(*) AS num_trxn FROM dental_claim_electronic e 
			JOIN dental_insurance i ON i.insuranceid=e.claimid
                        JOIN dental_patients dp ON i.patientid=dp.patientid
                        WHERE 
                                i.docid=du.userid AND
                                e.percase_invoice IS NULL) != 0 OR
                (SELECT count(*) as total_faxes FROM dental_faxes f
                        WHERE 
                f.docid='".$_REQUEST['docid']."' AND
                f.status = '0') >  plan.free_fax OR
(SELECT count(*) as total_eligibility FROM dental_eligibility f
                        WHERE 
                f.userid='".$_REQUEST['docid']."' AND
                f.eligibility_invoice_id IS NULL) > plan.free_eligibility OR
(SELECT count(*) as total_enrollment FROM dental_eligible_enrollment f
                        WHERE 
                f.user_id='".$_REQUEST['docid']."' AND
                f.enrollment_invoice_id IS NULL) >  plan.free_enrollment OR
                (SELECT COUNT(*) FROM dental_insurance_preauth p
                JOIN dental_patients dp ON p.patient_id=dp.patientid
                        WHERE 
                p.doc_id='".$_REQUEST['docid']."' AND
		p.status = '".DSS_PREAUTH_COMPLETE."' AND
                p.invoice_status = '".DSS_PERCASE_PENDING."') != 0
		)
		ORDER BY du.userid ASC
                ";
		*/
  }
}
$count_q = mysqli_query($con,$sql);
$num_docs = mysqli_num_rows($count_q);

$sql .= " limit 1";
$q = mysqli_query($con,$sql);
$count_invoices = (isset($_GET['ci']) && $_GET['ci']!='')?$_GET['ci']:$num_docs;
$count_current = (isset($_GET['cc']) && $_GET['cc']!='')?$_GET['cc']:1;
if($num_docs == 0){
  ?>
    <script type="text/javascript">
      window.location = "manage_monthly_invoice.php";
    </script>
  <?php
}
$user = mysqli_fetch_assoc($q);

$s = "SELECT id FROM dental_percase_invoice WHERE docid='".$user['userid']."' AND status='".DSS_INVOICE_PENDING."' AND invoice_type=1";
$q = mysqli_query($con,$s);
if(mysqli_num_rows($q) > 0){
$r = mysqli_fetch_assoc($q);
$invoice_id = $r['id'];
$efile_sql = "SELECT dp.firstname, dp.lastname, e.id, e.adddate FROM 
                dental_claim_electronic e
                JOIN dental_insurance i ON i.insuranceid=e.claimid
                JOIN dental_patients dp ON i.patientid=dp.patientid
        WHERE 
                i.docid='".$user['userid']."' 
		and e.percase_invoice = '".$invoice_id."'
";
$efile_q = mysqli_query($con,$efile_sql);
	
$fax_sql = "SELECT count(*) as total_faxes, MIN(sent_date) as start_date, MAX(sent_date) as end_date, f.fax_invoice_id FROM dental_faxes f
		JOIN dental_fax_invoice fi ON fi.id = f.fax_invoice_id
        WHERE 
                f.docid='".$user['userid']."' AND
                fi.invoice_id = '".$invoice_id."'
";
$fax_q = mysqli_query($con,$fax_sql);
$fax = mysqli_fetch_assoc($fax_q);


$ec_sql = "SELECT count(*) as total_ec, MIN(e.adddate) as start_date, MAX(e.adddate) as end_date FROM dental_eligibility e
	JOIN dental_eligibility_invoice ei ON ei.id = e.eligibility_invoice_id
        WHERE 
                e.userid='".$user['userid']."'
		and ei.invoice_id = '".$invoice_id."'
";
$ec_q = mysqli_query($con,$ec_sql);
$ec = mysqli_fetch_assoc($ec_q);

$enroll_sql = "SELECT count(*) as total_enrollments, MIN(e.adddate) as start_date, MAX(e.adddate) as end_date FROM dental_eligible_enrollment e
		JOIN dental_enrollment_invoice ei on ei.id = e.enrollment_invoice_id
        WHERE 
                e.user_id='".$user['userid']."'
		and ei.invoice_id = '".$invoice_id."'
";
$enroll_q = mysqli_query($con,$enroll_sql);
$enroll = mysqli_fetch_assoc($enroll_q);
}

$producer_sql = "SELECT count(*) as total_producers FROM dental_users u
                WHERE u.docid = '".mysqli_real_escape_string($con,(!empty($user['id']) ? $user['id'] : ''))."'
                        and u.status = 1 and u.producer=1";
$producer_q = mysqli_query($con,$producer_sql);


if(isset($_POST['submit'])){


  $doc_sql = "SELECT p.monthly_fee, p.producer_fee, p.fax_fee, p.free_fax, p.claim_fee, p.free_claim, p.eligibility_fee, p.free_eligibility, p.efile_fee, p.free_efile, p.enrollment_fee, p.free_enrollment, vob_fee, free_vob, CONCAT(u.first_name,' ',u.last_name) as name, u.user_type, c.name as company_name, p.name as plan_name
                FROM dental_users u
                JOIN dental_user_company uc ON uc.userid = u.userid
                JOIN companies c ON uc.companyid = c.id
                JOIN dental_plans p ON p.id=u.plan_id
                WHERE u.userid='".mysqli_real_escape_string($con, $user['userid'])."'";
  $doc_q = mysqli_query($con, $doc_sql);
if(mysqli_num_rows($doc_q) == 0){
  //If no plan get company fees
  $doc_sql = "SELECT c.monthly_fee, c.fax_fee, c.free_fax, concat(u.first_name,' ',u.last_name) name, u.user_type, c.name as company_name, p.name as plan_name
                FROM dental_users u
                JOIN dental_user_company uc ON uc.userid = u.userid
                JOIN companies c ON uc.companyid = c.id
                WHERE u.userid='".mysqli_real_escape_string($con, $_REQUEST['docid'])."'";
  $doc_q = mysqli_query($con, $doc_sql);

}

  $doc = mysqli_fetch_assoc($doc_q);



  if(mysqli_num_rows($q) > 0){

      $in_sql = "update dental_percase_invoice SET
			adminid = '".$_SESSION['adminuserid']."',
			due_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['due_date'])))."',
			status = '0' ";
	if(isset($_POST['amount_monthly'])){
			$in_sql .= ", monthly_fee_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['monthly_date'])))."',
			monthly_fee_amount = '".mysqli_real_escape_string($con,$_POST['amount_monthly'])."' "; 
	  $total_amount = $_POST['amount_monthly'];
        }
        if(isset($_POST['producer_amount'])){
                        $in_sql .= ", producer_fee_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['producer_date'])))."',
                        producer_fee_amount = '".mysqli_real_escape_string($con,$_POST['producer_amount'])."' ";
          $total_amount = $_POST['producer_monthly'];
        }
 	$in_sql .= " WHERE id = '".$invoice_id."'";
    mysqli_query($con,$in_sql);

  while($efile = mysqli_fetch_assoc($efile_q)){
    $id = $efile['id'];
    if(isset($_POST['adddate_'.$id])){
      $up_sql = "UPDATE dental_claim_electronic SET " .
        " percase_date = '".date('Y-m-d', strtotime($_POST['adddate_'.$id]))."', " .
        " percase_name = '".mysqli_real_escape_string($con,$_POST['name_'.$id])."', " .
        " percase_amount = '".mysqli_real_escape_string($con,$_POST['amount_'.$id])."', " .
        " percase_status = '".DSS_PERCASE_INVOICED."' " .
        " WHERE id = '".$id."'";
      mysqli_query($con,$up_sql);
    }else{
      invoice_add_efile('1',$user['userid'],$id);
    }
  }

  if(isset($_POST['free_fax_desc'])){
    $fax_start_date = ($_POST['free_fax_start_date'])?date('Y-m-d', strtotime($_POST['fax_start_date'])):'';
    $fax_end_date = ($_POST['free_fax_end_date'])?date('Y-m-d', strtotime($_POST['fax_end_date'])):'';

    $in_sql = "INSERT into dental_fax_invoice SET
		invoice_id = '".$invoice_id."', 
                description = '".mysqli_real_escape_string($con,$_POST['free_fax_desc'])."',
                start_date = '".mysqli_real_escape_string($con,$free_fax_start_date)."',
                end_date = '".mysqli_real_escape_string($con,$free_fax_end_date)."',
                amount = '".mysqli_real_escape_string($con,$_POST['free_fax_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysqli_query($con,$in_sql);
    $fax_invoice_id = mysqli_insert_id($con);
	$total_amount += $_POST['free_fax_amount'];
    $up_sql = "UPDATE dental_faxes SET
                status = '1'
                WHERE status='0' AND docid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
    mysqli_query($con,$up_sql);
  }

  if(isset($_POST['fax_desc'])){
    $fax_start_date = ($_POST['fax_start_date'])?date('Y-m-d', strtotime($_POST['fax_start_date'])):''; 
    $fax_end_date = ($_POST['fax_end_date'])?date('Y-m-d', strtotime($_POST['fax_end_date'])):'';

    $in_sql = "UPDATE dental_fax_invoice SET
		description = '".mysqli_real_escape_string($con,$_POST['fax_desc'])."',
                start_date = '".mysqli_real_escape_string($con,$fax_start_date)."',
                end_date = '".mysqli_real_escape_string($con,$fax_end_date)."',
                amount = '".mysqli_real_escape_string($con,$_POST['fax_amount'])."'
		WHERE invoice_id = '".$invoice_id."'";
    mysqli_query($con,$in_sql);
    $fax_invoice_id = mysqli_insert_id($con);
    $total_amount += $_POST['fax_amount'];

    $up_sql = "UPDATE dental_faxes SET
		status = '1'
		WHERE fax_invoice_id = '".$fax['fax_invoice_id']."' AND docid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
    mysqli_query($con,$up_sql);
  }elseif(!isset($_POST['free_fax_desc']) || (isset($_POST['free_fax_desc']) && (intval($fax['total_faxes']) - intval($doc['free_fax']) > 0))){
    $i_id = invoice_find('1',$user['userid']);
    $up_sql = "UPDATE dental_fax_invoice SET
		invoice_id = '".mysqli_real_escape_string($con,$i_id)."'
		WHERE invoice_id = '".$invoice_id."'
        AND id != '".mysqli_real_escape_string($con, $fax_invoice_id)."'"; //DO NOT UPDATE FREE FAX INVOICE
    mysqli_query($con,$up_sql);
    
  }
  if(isset($_POST['free_ec_desc'])){
    $ec_start_date = ($_POST['free_ec_start_date'])?date('Y-m-d', strtotime($_POST['ec_start_date'])):'';
    $ec_end_date = ($_POST['free_ec_end_date'])?date('Y-m-d', strtotime($_POST['ec_end_date'])):'';

    $in_sql = "INSERT INTO dental_eligibility_invoice SET
                invoice_id = '".mysqli_real_escape_string($con,$invoice_id)."',
                description = '".mysqli_real_escape_string($con,$_POST['free_ec_desc'])."',
                start_date = '".mysqli_real_escape_string($con,$free_ec_start_date)."',
                end_date = '".mysqli_real_escape_string($con,$free_ec_end_date)."',
                amount = '".mysqli_real_escape_string($con,$_POST['free_ec_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysqli_query($con,$in_sql);
    $ec_invoice_id = mysqli_insert_id($con);

    $up_sql = "UPDATE dental_eligibility SET
                eligibility_invoice_id = '".$ec_invoice_id."' 
                WHERE eligibility_invoice_id IS NULL AND userid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
    mysqli_query($con,$up_sql);
  }

  if(isset($_POST['ec_desc'])){
    $ec_start_date = ($_POST['ec_start_date'])?date('Y-m-d', strtotime($_POST['ec_start_date'])):'';
    $ec_end_date = ($_POST['ec_end_date'])?date('Y-m-d', strtotime($_POST['ec_end_date'])):'';

    $in_sql = "update dental_eligibility_invoice SET
                description = '".mysqli_real_escape_string($con,$_POST['ec_desc'])."',
                start_date = '".mysqli_real_escape_string($con,$ec_start_date)."',
                end_date = '".mysqli_real_escape_string($con,$ec_end_date)."',
                amount = '".mysqli_real_escape_string($con,$_POST['ec_amount'])."'
		WHERE invoice_id ='".$invoice_id."'";
    mysqli_query($con,$in_sql);
    $ec_invoice_id = mysqli_insert_id($con);
    $up_sql = "UPDATE dental_eligibility SET
                eligibility_invoice_id = '".$ec_invoice_id."' 
                WHERE eligibility_invoice_id IS NULL AND userid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
    //mysqli_query($con,$up_sql);
  }else{
    $i_id = invoice_find('1',$user['userid']);
    $up_sql = "UPDATE dental_eligibility_invoice SET
                invoice_id = '".mysqli_real_escape_string($con,$i_id)."'
                WHERE invoice_id = '".$invoice_id."'";
    mysqli_query($con,$up_sql);
    
  }






  if(isset($_POST['free_enrollment_desc'])){
    $enrollment_start_date = ($_POST['free_enrollment_start_date'])?date('Y-m-d', strtotime($_POST['free_enrollment_start_date'])):'';
    $enrollment_end_date = ($_POST['free_enrollment_end_date'])?date('Y-m-d', strtotime($_POST['free_enrollment_end_date'])):'';

    $in_sql = "INSERT INTO dental_enrollment_invoice SET
                invoice_id = '".mysqli_real_escape_string($con,$invoice_id)."',
                description = '".mysqli_real_escape_string($con,$_POST['free_enrollment_desc'])."',
                start_date = '".mysqli_real_escape_string($con,$free_enrollment_start_date)."',
                end_date = '".mysqli_real_escape_string($con,$free_enrollment_end_date)."',
                amount = '".mysqli_real_escape_string($con,$_POST['free_enrollment_amount'])."',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysqli_query($con,$in_sql);
    $enrollment_invoice_id = mysqli_insert_id($con);

    $up_sql = "UPDATE dental_eligible_enrollment SET
                fax_invoice_id = '".$enrollment_invoice_id."' 
                WHERE enrollment_invoice_id IS NULL AND user_id='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
    mysqli_query($con,$up_sql);
  }


  if(isset($_POST['enrollment_desc'])){
    $enrollment_start_date = ($_POST['enrollment_start_date'])?date('Y-m-d', strtotime($_POST['enrollment_start_date'])):'';
    $enrollment_end_date = ($_POST['enrollment_end_date'])?date('Y-m-d', strtotime($_POST['enrollment_end_date'])):'';

    $in_sql = "update dental_enrollment_invoice SET
                description = '".mysqli_real_escape_string($con,$_POST['enrollment_desc'])."',
                start_date = '".mysqli_real_escape_string($con,$enrollment_start_date)."',
                end_date = '".mysqli_real_escape_string($con,$enrollment_end_date)."',
                amount = '".mysqli_real_escape_string($con,$_POST['enrollment_amount'])."'
		WHERE invoice_id='".$invoice_id."'";
    mysqli_query($con,$in_sql);
    $enrollment_invoice_id = mysqli_insert_id($con);

    $up_sql = "UPDATE dental_eligible_enrollment SET
                enrollment_invoice_id = '".$enrollment_invoice_id."' 
                WHERE enrollment_invoice_id is NULL AND user_id='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
    mysqli_query($con,$up_sql);
  }else{
    $i_id = invoice_find('1',$user['userid']);
    $up_sql = "UPDATE dental_enrollment_invoice SET
                invoice_id = '".mysqli_real_escape_string($con,$i_id)."'
                WHERE invoice_id = '".$invoice_id."'";
    mysqli_query($con,$up_sql);
    
  }

  
}else{
      $in_sql = "insert into dental_percase_invoice SET
                        adminid = '".$_SESSION['adminuserid']."',
                        docid = '".$_POST['docid']."',
			due_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['due_date'])))."',
                        status = '0',
                        adddate = now(),
                        ip_address = '".$_SERVER['REMOTE_ADDR']."' ";
        if(isset($_POST['amount_monthly'])){
                        $in_sql .= ", monthly_fee_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['monthly_date'])))."',
                        monthly_fee_amount = '".mysqli_real_escape_string($con,$_POST['amount_monthly'])."' ";
          $total_amount = $_POST['amount_monthly'];
        }
        if(isset($_POST['producer_amount'])){
                        $in_sql .= ", producer_fee_desc = '".mysqli_real_escape_string($con,$_POST['producer_desc'])."', producer_fee_date = '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['producer_date'])))."',
                        producer_fee_amount = '".mysqli_real_escape_string($con,$_POST['producer_amount'])."' ";
          $total_amount += $_POST['producer_amount'];
        }

    mysqli_query($con,$in_sql);
    $invoice_id = mysqli_insert_id($con);

}

  $num_extra = $_POST['extra_total'];
  for($i=1;$i<=$num_extra;$i++){
    if(isset($_POST['extra_name_'.$i])){
	$name = $_POST['extra_name_'.$i];
        $service_date = $_POST['extra_service_date_'.$i];
	$service_date = ($service_date!='')?date('Y-m-d', strtotime($service_date)):'';
	$amount = $_POST['extra_amount_'.$i];
	$sql = "INSERT INTO dental_percase_invoice_extra SET" .
        " percase_date = '".$service_date."', " .
        " percase_name = '".mysqli_real_escape_string($con,$name)."', " .
        " percase_amount = '".mysqli_real_escape_string($con,$amount)."', " .
        " percase_status = '".DSS_PERCASE_INVOICED."', " .
        " percase_invoice = '".$invoice_id."', " .
	" adddate = NOW(), " .
  	" ip_address = '".$_SERVER['REMOTE_ADDR']."'";
      mysqli_query($con,$sql);
      $total_amount += $amount;
    }
  }


        if(isset($_GET['bill']) && $_GET['bill']=="1"){
                if($user['cc_id']!=''){
                  bill_card($user['cc_id'] ,$total_amount, $user['userid'], $invoice_id);
                }else{
		    $charge_sql = "INSERT INTO dental_charge SET
                        amount='".mysqli_real_escape_string($con,str_replace(',','',$total_amount))."',
                        userid='".mysqli_real_escape_string($con,$user['userid'])."',
                        adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."',
                        charge_date=NOW(),
                        status='2',
                        adddate=NOW(),
                        ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
        		mysqli_query($con,$charge_sql);
                     $i_sql = "UPDATE dental_percase_invoice set status=2 WHERE id='".$invoice_id."'";
                        mysqli_query($con,$i_sql);
                  ?>
                    <script type="text/javascript">
                      alert('<?php echo  $user['first_name']." ".$user['last_name']; ?> does not have a credit card on record.');
                    </script>
                  <?php
                }

        }


  $_GET['invoice_id'] = $invoice_id;
  $redirect = false;
  include 'percase_invoice_pdf.php';
  if(isset($_GET['show']) && $_GET['show']=='1'){
  ?>
  <script type="text/javascript">
    window.location = 'manage_percase_invoice_history.php?docid=<?php echo $_GET['docid'];?>';
  </script>
  <?php
  }else{
  ?>
  <script type="text/javascript">
    window.location = 'invoice_additional.php?show=<?php echo $_GET['show'];?>&bill=<?php echo  $_GET['bill']; ?><?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>&uid=<?php echo  $user['userid']; ?>&cc=<?php echo  ($count_current+1); ?>&ci=<?php echo  $count_invoices; ?>';
    //window.location = 'percase_invoice_pdf.php?invoice_id=<?php echo  $invoiceid; ?>';
  </script>
  <?php
  }
}

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<?php
  $doc_sql = "SELECT p.monthly_fee, p.producer_fee, p.fax_fee, p.free_fax, p.claim_fee, p.free_claim, p.eligibility_fee, p.free_eligibility, p.efile_fee, p.free_efile, p.enrollment_fee, p.free_enrollment, vob_fee, free_vob, CONCAT(u.first_name,' ',u.last_name) as name, u.user_type, c.name as company_name, p.name as plan_name
		FROM dental_users u
		JOIN dental_user_company uc ON uc.userid = u.userid
		JOIN companies c ON uc.companyid = c.id
		JOIN dental_plans p ON p.id=u.plan_id
		WHERE u.userid='".mysqli_real_escape_string($con,$user['userid'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
if(mysqli_num_rows($doc_q) == 0){
  //If no plan get company fees
  $doc_sql = "SELECT c.monthly_fee, c.fax_fee, c.free_fax, concat(u.first_name,' ',u.last_name) name, u.user_type, c.name as company_name, p.name as plan_name
                FROM dental_users u
                JOIN dental_user_company uc ON uc.userid = u.userid
                JOIN companies c ON uc.companyid = c.id
                WHERE u.userid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
  $doc_q = mysqli_query($con,$doc_sql);

}

  $doc = mysqli_fetch_assoc($doc_q);

        if($user['last_monthly_fee_date']){
          $date = $user['last_monthly_fee_date'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }elseif($user['registration_date']){
          $date = $user['registration_date'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }elseif($user['trial_period'] !=''  && $user['adddate']){
          $date = $user['adddate'];
          $newdate = strtotime ( '+'.($user['trial_period']+1).' day' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }elseif($user['adddate']){
          $date = $user['adddate'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }else{
          $monthly_date = date('m/d/Y');
        }


?>
<div class="page-header">
	<h2>Invoicing <small>- <?php echo  $doc['name']; ?>	
        - <?php echo  $doc['company_name']; ?>
        - Plan: <?php echo  $doc['plan_name']; ?>
</small></h2></div>

<?php if(!empty($_GET['msg'])) {?>
<div class="alert alert-danger text-center">
    <?php echo $_GET['msg'];?>
</div>
<?php } ?>

<div class="panel panel-default">
    <div class="panel-body">
        <h3><?php echo  $count_current; ?> of <?php echo  $count_invoices; ?></h3>
        <form name="sortfrm" id="invoice" action="<?php echo $_SERVER['PHP_SELF']?>?show=<?php echo (!empty($_GET['show']) ? $_GET['show'] : ''); ?>&company=<?php echo (!empty($_GET['company']) ? $_GET['company'] : '');?>&bill=<?php echo (!empty($_GET['bill']) ? $_GET['bill'] : '');?>&docid=<?php echo  (!empty($_GET['docid']) ? $_GET['docid'] : ''); ?>&uid=<?php echo (!empty($_GET['uid']) ? $_GET['uid'] : '');?>&cc=<?php echo  ($count_current); ?>&ci=<?php echo  $count_invoices; ?>" method="post">
            <input type="hidden" name="docid" value="<?php echo $user["userid"];?>">
<div class="input-group date pull-right">
Invoice Due Date:
<input type="text" name="due_date" id="due_date" class="form-control text-center datepicker" value="<?php echo   date('m/d/Y'); ?>" />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
</div>
<div class="clearfix"></div>

            <table id="invoice_table" class="table table-bordered table-hover">
                <tr>
                    <th></th>
            		<th width="40%">
            			Patient Name		
            		</th>
            		<th width="27%">
            			Service Date	
            		</th>
            		<th width="27%">
            			Amount		
            		</th>
            	</tr>
                <tr id="model-row" class="hidden">
                    <td>
                        <a href="#" class="btn btn-danger remove-single hidden">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="extra_name_{row}" placeholder="Service Name" class="form-control">
                    </td>
                    <td>
                        <div class="input-append datepicker input-group date">
                            <input type="text" id="extra_service_date_{row}" class="form-control text-center" name="extra_service_date_{row}" value="<?php echo  date('m/d/Y') ?>">
                            <span class="input-group-addon add-on">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="extra_amount_{row}" value="195.00">
                        </div>
                    </td>
                </tr>
                <tr id="month_row">
                    <td>
                        <a href="#" title="Remove from invoice" class="btn btn-danger remove-single hidden">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                    <td>
                        MONTHLY FEE
                    </td>
                    <td>
                        <div class="input-append datepicker input-group date">
                            <input type="text" id="monthly_date" name="monthly_date" class="form-control text-center" value="<?php echo $monthly_date;?>">
                            <span class="input-group-addon add-on">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="amount_monthly" value="<?php echo  $doc['monthly_fee']; ?>">
                        </div>
                    </td>
                </tr>


                <?php $producer_r = mysqli_fetch_assoc($producer_q); ?>
		<?php if($producer_r['total_producers']>0){ ?>
                <tr id="user_row">
                    <td>
                        <a href="#" class="btn btn-danger remove-single hidden">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="producer_desc" value="Producers – <?php echo  $producer_r['total_producers']." at $".$doc['producer_fee']." each "; ?>" class="form-control">
                    </td>
                    <td>
                        <div class="input-group input-append date datepicker">
                            <input type="text" id="producer_date" class="form-control text-center" name="producer_date" value="<?php echo date('m/d/Y');?>">
                            <span class="add-on input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="producer_amount" value="<?php echo  $users_r['total_producers']*$doc['producer_fee']; ?>">
                        </div>
                    </td>
                </tr>
		<?php } ?>
                <?php if (!empty($case_q)) while ($case = mysqli_fetch_array($case_q)) { ?>
                <tr id="case_row_<?php echo  $case['ledgerid'] ?>">
                    <td>
                        <a href="#" title="Remove from invoice" class="btn btn-danger remove-single hidden">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="name_<?php echo  $case['ledgerid'] ?>" value="<?php echo st($case["firstname"]." ".$case["lastname"]);?>" class="form-control">
                    </td>
                    <td>
                        <div class="input-append datepicker input-group date">
                            <input type="text" id="service_date_<?php echo  $case['ledgerid'] ?>" class="form-control text-center" name="service_date_<?php echo  $case['ledgerid'] ?>" value="<?php echo date('m/d/Y', strtotime(st($case["service_date"])));?>">
                            <span class="input-group-addon add-on">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="amount_<?php echo  $case['ledgerid'] ?>" value="195.00">
                        </div>
                    </td>
                </tr>
	           <?php } ?>


		<?php $free_efile = 1; ?>
                <?php while ($efile = mysqli_fetch_array($efile_q)) { ?>
                <tr id="efile_row_<?php echo  $efile['id'] ?>">
                    <td>
                        <a href="#" title="Remove from invoice" class="btn btn-danger remove-single hidden">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="name_<?php echo  $efile['id'] ?>" value="E-File: <?php echo st($efile["firstname"]." ".$efile["lastname"]);?>" class="form-control">
                    </td>
                    <td>
                        <div class="input-append datepicker input-group date">
                            <input type="text" id="adddate_<?php echo  $efile['id'] ?>" class="form-control text-center" name="adddate_<?php echo  $efile['id'] ?>" value="<?php echo date('m/d/Y', strtotime(st($efile["adddate"])));?>">
                            <span class="input-group-addon add-on">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
			    <?php if($free_efile <= $doc['free_efile']){
				$efile_fee = '0.00';
				$free_efile++;
			    }else{
				$efile_fee = $doc['efile_fee'];
			    }
			    ?>
                            <input type="text" class="amount form-control" name="amount_<?php echo  $efile['id'] ?>" value="<?php echo  $efile_fee; ?>">
                        </div>
                    </td>
                </tr>
                   <?php } ?>



            <?php if ($doc['user_type']==DSS_USER_TYPE_SOFTWARE) { ?>
                <?php if (!empty($vob_q)) while ($vob = mysqli_fetch_array($vob_q)) { ?>
                <tr id="vob_row_<?php echo  $vob['id'] ?>">
                    <td>
                        <a href="#" title="Remove from invoice" class="btn btn-danger remove-single hidden">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                    <td>
                        Insurance Verification Services – <?php echo  $vob['patient_firstname']." ".$vob['patient_lastname']; ?>
                    </td>
                    <td>
                        <div class="input-append datepicker input-group date">
                            <input type="text" name="vob_date_completed_<?php echo  $vob['id'] ?>" id="vob_date_completed_<?php echo  $vob['id'] ?>" class="form-control text-center" value="<?php echo date('m/d/Y', strtotime(st($vob["date_completed"])));?>">
                            <span class="input-group-addon add-on">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="vob_amount_<?php echo  $vob['id'] ?>" value="<?php echo  $vob['invoice_amount']; ?>">
                        </div>
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>
            
            <?php if ($fax['total_faxes'] > 0) { ?>
                <?php
                
                $bill_faxes = intval($fax['total_faxes']) - intval($doc['free_fax']);
                
                if ($doc['free_fax'] > $fax['total_faxes']) {
                    $free_fax = $fax['total_faxes'];
                }
                else {
                    $free_fax = $doc['free_fax'];
                }
                
                ?>
                <tr id="free_fax_row" class="fax">
                    <td>
                        <a href="#" title="Remove from invoice" class="btn btn-danger remove-fax hidden">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="free_fax_desc" value="Free Faxes – <?php echo  $free_fax." at $0.00 each "; ?>" style="width:100%;" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="free_fax_start_date" class="datepicker date form-control text-center" name="free_fax_start_date" value="<?php echo date('m/d/Y', strtotime(st($fax["start_date"])));?>">
                            <span class="input-group-addon">to</span>
                            <input type="text" id="free_fax_end_date" class="datepicker date form-control text-center" name="free_fax_end_date" value="<?php echo date('m/d/Y', strtotime(st($fax["end_date"])));?>">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="free_fax_amount" value="0.00">
                        </div>
                    </td>
                </tr>
                <?php if ($bill_faxes > 0) { ?>
                <tr id="fax_row" class="fax">
                    <td>
                        <a href="#" class="btn btn-danger remove-fax hidden">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="fax_desc" value="Faxes – <?php echo  $bill_faxes." at $".$doc['fax_fee']." each "; ?>" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="fax_start_date" class="datepicker date form-control text-center" name="fax_start_date" value="<?php echo date('m/d/Y', strtotime(st($fax["start_date"])));?>">
                            <span class="input-group-addon">to</span>
                            <input type="text" id="fax_end_date" class="datepicker date form-control text-center" name="fax_end_date" value="<?php echo date('m/d/Y', strtotime(st($fax["end_date"])));?>">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="fax_amount" value="<?php echo  $bill_faxes*$doc['fax_fee']; ?>">
                        </div>
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>




            <?php if ($ec['total_ec'] > 0) { ?>
                <?php

                $bill_ec = intval($ec['total_ec']) - intval($doc['free_eligibility']);

                if ($doc['free_eligibility'] > $ec['total_ec']) {
                    $free_ec = $ec['total_ec'];
                }
                else {
                    $free_ec = $doc['free_eligibility'];
                }

                ?>
                <tr id="free_ec_row" class="eligibility">
                    <td>
                        <a href="#" title="Remove from invoice" class="btn btn-danger remove-eligibility hidden">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="free_ec_desc" value="Free Eligibility Check – <?php echo  $free_ec." at $0.00 each "; ?>" style="width:100%;" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="free_ec_start_date" class="datepicker date form-control text-center" name="free_ec_start_date" value="<?php echo date('m/d/Y', strtotime(st($ec["start_date"])));?>">
                            <span class="input-group-addon">to</span>
                            <input type="text" id="free_ec_end_date" class="datepicker date form-control text-center" name="free_ec_end_date" value="<?php echo date('m/d/Y', strtotime(st($ec["end_date"])));?>">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="free_ec_amount" value="0.00">
                        </div>
                    </td>
                </tr>
                <?php if ($bill_ec > 0) { ?>
                <tr id="ec_row">
                    <td>
                        <a href="#" class="btn btn-danger remove-eligibility hidden">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="ec_desc" value="Eligibility Checks – <?php echo  $bill_ec." at $".$doc['eligibility_fee']." each "; ?>" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="ec_start_date" class="datepicker date form-control text-center" name="ec_start_date" value="<?php echo date('m/d/Y', strtotime(st($ec["start_date"])));?>">
                            <span class="input-group-addon">to</span>
                            <input type="text" id="ec_end_date" class="datepicker date form-control text-center" name="ec_end_date" value="<?php echo date('m/d/Y', strtotime(st($ec["end_date"])));?>">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="ec_amount" value="<?php echo  $bill_ec*$doc['eligibility_fee']; ?>">
                        </div>
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>









            <?php if ($enroll['total_enrollments'] > 0) { ?>
                <?php

                $bill_en = intval($enroll['total_enrollments']) - intval($doc['free_enrollment']);

                if ($doc['free_enrollment'] > $enroll['total_enrollments']) {
                    $free_en = $enroll['total_enrollments'];
                }
                else {
                    $free_en = $doc['free_enrollment'];
                }

                ?>
                <tr id="free_enrollment_row" class="enrollment">
                    <td>
                        <a href="#" title="Remove from invoice" class="btn btn-danger remove-enrollment hidden">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="free_enrollment_desc" value="Free Enrollments – <?php echo  $free_en." at $0.00 each "; ?>" style="width:100%;" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="free_enrollment_start_date" class="datepicker date form-control text-center" name="free_enrollment_start_date" value="<?php echo date('m/d/Y', strtotime(st($enroll["start_date"])));?>">
                            <span class="input-group-addon">to</span>
                            <input type="text" id="free_enrollment_end_date" class="datepicker date form-control text-center" name="free_enrollment_end_date" value="<?php echo date('m/d/Y', strtotime(st($enroll["end_date"])));?>">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="free_enrollment_amount" value="0.00">
                        </div>
                    </td>
                </tr>
                <?php if ($bill_en > 0) { ?>
                <tr id="enrollment_row" class="enrollment">
                    <td>
                        <a href="#" class="btn btn-danger remove-enrollment hidden">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" name="enrollment_desc" value="Enrollments – <?php echo  $bill_en." at $".$doc['enrollment_fee']." each "; ?>" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="enrollment_start_date" class="datepicker date form-control text-center" name="enrollment_start_date" value="<?php echo date('m/d/Y', strtotime(st($enroll["start_date"])));?>">
                            <span class="input-group-addon">to</span>
                            <input type="text" id="enrollment_end_date" class="datepicker date form-control text-center" name="enrollment_end_date" value="<?php echo date('m/d/Y', strtotime(st($enroll["end_date"])));?>">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="amount form-control" name="enrollment_amount" value="<?php echo  $bill_en*$doc['enrollment_fee']; ?>">
                        </div>
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>












                <tr id="total_row">
                    <td>
                        <a href="#" class="btn btn-success" title="Add Entry">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </td>
                    <td valign="top" colspan="2">
                        <strong class="pull-right">Total</strong>
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="extra_total" id="extra_total" value="0">
                        <strong id="total">$<?php echo  number_format((mysqli_num_rows($case_q)*195)+695,2); ?></strong>
                    </td>
                </tr>
            </table>
            <div class="text-center">
                <a href="manage_monthly_invoice.php" class="btn btn-danger">Cancel</a>
                <a href="invoice_additional.php?show=<?php echo (!empty($_GET['show']) ? $_GET['show'] : '');?>&bill=<?php echo  (!empty($_GET['bill']) ? $_GET['bill'] : ''); ?><?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>&uid=<?php echo  $user['userid']; ?>&cc=<?php echo  ($count_current+1); ?>&ci=<?php echo  $count_invoices; ?>" class="btn btn-default">Skip</a>
                <input type="submit" name="submit" value="Create Invoice" class="btn btn-success pull-right">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var row_count = 1;
    
    $('#invoice_table').on('mouseenter', 'tr', function() {
        $(this).find('.btn.btn-danger').removeClass('hidden');
	//$(this).find('.btn.btn-danger').trigger('mouseenter');
    });
    $('#invoice_table').on('mouseleave', 'tr', function() {
        $(this).find('.btn.btn-danger').addClass('hidden');
	//$(this).find('.btn.btn-danger').trigger('mouseleave');
    });
    
    $('#invoice_table').on('click', '.btn.btn-danger.remove-single', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        calcTotal();
        return false;
    });

    $('#invoice_table').on('click', '.btn.btn-danger.remove-fax', function(e) {
        e.preventDefault();
	if(confirm('This will remove all faxes from this invoice.')){
          $('tr.fax').remove();
           calcTotal();
	}
        return false;
    });

    $('#invoice_table').on('click', '.btn.btn-danger.remove-eligibility', function(e) {
        e.preventDefault();
        if(confirm('This will remove all eligibility checks from this invoice.')){
          $('tr.eligibility').remove();
           calcTotal();
        }
        return false;
    });

    $('#invoice_table').on('click', '.btn.btn-danger.remove-enrollment', function(e) {
        e.preventDefault();
        if(confirm('This will remove all enrollments from this invoice.')){
          $('tr.enrollment').remove();
           calcTotal();
        }
        return false;
    });
    
    $('#invoice_table').on('change keyup', '.amount', function() {
        calcTotal();
    });
    
    $('#invoice_table .btn.btn-success').on('click', function(e) {
        e.preventDefault();
        
        var row = '<tr id="extra_row_{row}">' + $('#model-row').html() + '</tr>';
        
        row = $(row.replace(/\{row\}/g, row_count));
        row.insertBefore('#total_row');
        row.find('.date').datepicker();
        
        $('#extra_total').val(row_count);
        row_count++;
        calcTotal();
        return false;
    });
});

function calcTotal () {
    var a = 0;
    
    $('.amount:visible').each(function(){
        a += Number($(this).val());
    });
    
    a = a.toFixed(2);
    
    $('#total').html('$' + a);
}

calcTotal();

//START OF FEATURE TO CHECK AND MAKE SURE ITEMS HAVENT ALREADY BEEN BILLED
function check_billed () {
    var f = $('#invoice').serialize();
    
    $.ajax({
        url: '/manage/includes/check_billed.php',
        type: 'post',
        data: f,
        success: function(data){
            alert(data);
            var r = $.parseJSON(data);
            
            if (r.error) {}
            else {}
        },
        error: function(data){
            //alert('fail');
        }
    });
    
    return false;
}
</script>
<?php include "includes/bottom.htm";?>


<?php

function bill_card ($customerID, $amount, $userid, $invoiceid) {
  if($amount==0){
    ?>
    <script type="text/javascript">
      alert('Cannot post $0.00 charge to Stripe.');
    </script>
    <?php
  }else{
    $key_sql = "SELECT stripe_secret_key FROM companies c
        JOIN dental_user_company uc
        ON c.id = uc.companyid
        WHERE uc.userid='".mysqli_real_escape_string($con,$userid)."'";
    
    $key_q = mysqli_query($con,$key_sql);
    $key_r= mysqli_fetch_assoc($key_q);
    
    Stripe::setApiKey($key_r['stripe_secret_key']);
    $status = 1;
    
    try{
        $charge = Stripe_Charge::create(array(
            "amount" => ($amount*100), # $15.00 this time
            "currency" => "usd",
            "customer" => $customerID
        ));
    }
    catch (Stripe_CardError $e) {
        $invoice_sql = "UPDATE dental_percase_invoice SET
            status=2
            WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
        
        mysqli_query($con,$invoice_sql);
        $status = 2;
    }
    catch (Stripe_InvalidRequestError $e) {
        $invoice_sql = "UPDATE dental_percase_invoice SET
            status=2
            WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
        
        mysqli_query($con,$invoice_sql);
        $status = 2;
    }
    catch (Stripe_AuthenticationError $e) {
        $invoice_sql = "UPDATE dental_percase_invoice SET
            status=2
            WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
        
        mysqli_query($con,$invoice_sql);
        $status = 2;
    }
    catch (Stripe_ApiConnectionError $e) {
        $invoice_sql = "UPDATE dental_percase_invoice SET
            status=2
            WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
        
        mysqli_query($con,$invoice_sql);
        $status = 2;
    }
    catch (Stripe_Error $e) {
        $invoice_sql = "UPDATE dental_percase_invoice SET
            status=2
            WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
        
        mysqli_query($con,$invoice_sql);
        $status = 2;
    }
    catch (Exception $e) {
        $invoice_sql = "UPDATE dental_percase_invoice SET
            status=2
            WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
        
        mysqli_query($con,$invoice_sql);
        $status = 2;
    }

    $stripe_charge = $charge->id;
    $stripe_customer = $charge->customer;
    $stripe_card_fingerprint = $charge->card->fingerprint;
    $charge_sql = "INSERT INTO dental_charge SET
        amount='".mysqli_real_escape_string($con,str_replace(',','',$amount))."',
        userid='".mysqli_real_escape_string($con,$userid)."',
        adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."',
        charge_date=NOW(),
        stripe_customer='".mysqli_real_escape_string($con,$stripe_customer)."',
        stripe_charge='".mysqli_real_escape_string($con,$stripe_charge)."',
        stripe_card_fingerprint='".mysqli_real_escape_string($con,$stripe_card_fingerprint)."',
        status='".mysqli_real_escape_string($con,$status)."',
        adddate=NOW(),
        ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
    
    mysqli_query($con,$charge_sql);
    
    if ($status == 1) {
        $invoice_sql = "UPDATE dental_percase_invoice SET
            status=1
            WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
        
        mysqli_query($con,$invoice_sql);
    }
    
  }
    return true;
}
