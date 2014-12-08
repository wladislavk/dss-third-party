<?php
  include_once 'includes/main_include.php';
  include_once '../includes/constants.inc';
  include_once '../3rdParty/stripe/lib/Stripe.php';
 $no_card = array(); 
  $sql = "SELECT du.*, c.name AS company_name, c.free_fax,
		plan.trial_period,
                (SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
		JOIN dental_plans plan ON plan.id=du.plan_id
                WHERE du.status=1 AND du.docid=0 AND 
		((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".mysqli_real_escape_string($con,DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) < DATE_SUB(now(), INTERVAL 1 MONTH) OR 
                	((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".mysqli_real_escape_string($con,DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) IS NULL AND DATE_ADD(du.adddate, INTERVAL plan.trial_period DAY) < now()))
			AND
(SELECT COUNT(*) as num_inv FROM dental_percase_invoice
                        WHERE docid=du.userid AND 
                                status = '".DSS_INVOICE_PENDING."') = 0";

/*
		(SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.percase_status = '".DSS_PERCASE_PENDING."') = 0 AND
                (SELECT COUNT(*) AS num_trxn FROM dental_claim_electronic e 
                        JOIN dental_insurance i ON i.insuranceid=e.claimid
                        JOIN dental_patients dp ON i.patientid=dp.patientid
                        WHERE 
                                i.docid=du.userid AND
                                e.percase_invoice IS NULL) = 0 AND
		(SELECT count(*) as total_faxes FROM dental_faxes f
        		WHERE 
                f.docid='".$_REQUEST['docid']."' AND
                f.status = '0') <=  c.free_fax AND
(SELECT count(*) as total_eligibility FROM dental_eligibility f
                        WHERE 
                f.docid='".$_REQUEST['docid']."' AND
                f.eligibility_invoice IS NULL) <= plan.free_eligibility AND
(SELECT count(*) as total_enrollment FROM dental_eligible_enrollment f
                        WHERE 
                f.docid='".$_REQUEST['docid']."' AND
                f.enrollment_invoice IS NULL) <= plan.free_enrollment AND
		(SELECT COUNT(*) FROM dental_insurance_preauth p
                JOIN dental_patients dp ON p.patient_id=dp.patientid
		        WHERE 
                p.doc_id='".$_REQUEST['docid']."' AND
                p.status = '".DSS_PREAUTH_COMPLETE."' AND
                p.invoice_status = '".DSS_PERCASE_PENDING."') = 0
                ";
*/
  if(isset($_GET['company']) && $_GET['company'] != ""){
        $sql .= " AND c.id='".mysqli_real_escape_string($con,$_GET['company'])."' ";
  }

  $q = mysqli_query($con,$sql);
  while($r = mysqli_fetch_assoc($q)){
	  $doc_sql = "SELECT p.monthly_fee, p.fax_fee, p.free_fax, u.name, u.user_type
                FROM dental_users u
                JOIN dental_user_company uc ON uc.userid = u.userid
                JOIN companies c ON uc.companyid = c.id
		JOIN dental_plans p ON p.id=u.plan_id
                WHERE u.userid='".mysqli_real_escape_string($con,$r['userid'])."'";
  	  $doc_q = mysqli_query($con,$doc_sql);
if(mysqli_num_rows($doc_q) == 0){
  //If no plan get company fees
  $doc_sql = "SELECT c.monthly_fee, c.fax_fee, c.free_fax, concat(u.first_name,' ',u.last_name) name, u.user_type
                FROM dental_users u
                JOIN dental_user_company uc ON uc.userid = u.userid
                JOIN companies c ON uc.companyid = c.id
                WHERE u.userid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
}

  	  $doc = mysqli_fetch_assoc($doc_q);
	if($r['last_monthly_fee_date']){
          $date = $r['last_monthly_fee_date'];
	  $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
	  $monthly_date = date ( 'Y-m-d' , $newdate );
        }elseif($r['registration_date']){
          $date = $r['registration_date'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'Y-m-d' , $newdate );
	}elseif(!empty($user['trial_period'])  && !empty($user['adddate'])){
          $date = $user['adddate'];
          $newdate = strtotime ( '+'.($user['trial_period']+1).' day' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'm/d/Y' , $newdate );
        }elseif($r['adddate']){
	  $date = $r['adddate'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'Y-m-d' , $newdate );
	}else{
	  $monthly_date = date('Y-m-d');
	}

	$in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address, monthly_fee_date, monthly_fee_amount) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$r['userid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysqli_real_escape_string($con,date('Y-m-d', strtotime($monthly_date)))."', '".mysqli_real_escape_string($con,$doc['monthly_fee'])."')";
	//echo($in_sql."<br /><br />");
	mysqli_query($con,$in_sql);
	$invoiceid = mysqli_insert_id($con);

	if(isset($_GET['bill']) && $_GET['bill']=="1"){
		if($r['cc_id']!=''){
		  bill_card($r['cc_id'] ,$doc['monthly_fee'], $r['userid'], $invoiceid);	
		}else{
                    $charge_sql = "INSERT INTO dental_charge SET
                        amount='".mysqli_real_escape_string($con,str_replace(',','',$doc['monthly_fee']))."',
                        userid='".mysqli_real_escape_string($con,(!empty($user['userid']) ? $user['userid'] : ''))."',
                        adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."',
                        charge_date=NOW(),
			invoice_id='".mysqli_real_escape_string($con,$invoiceid)."',
                        status='2',
                        adddate=NOW(),
                        ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
                        mysqli_query($con,$charge_sql);
		     $i_sql = "UPDATE dental_percase_invoice set status=2 WHERE id='".$invoiceid."'";
			mysqli_query($con,$i_sql);
 		  array_push($no_card, $r['first_name']." ".$r['last_name']);
		}
	}
/*
$fax_sql = "SELECT count(*) as total_faxes, MIN(sent_date) as start_date, MAX(sent_date) as end_date FROM dental_faxes f
        WHERE 
                f.docid='".$r['userid']."' AND
                f.status = '0'
";
$fax_q = mysqli_query($con,$fax_sql);
$fax = mysqli_fetch_assoc($fax_q);

if($fax['total_faxes'] > 0 ){
    $fax_start_date = ($fax['start_date'])?date('Y-m-d', strtotime($fax['start_date'])):'';
    $fax_end_date = ($fax['end_date'])?date('Y-m-d', strtotime($fax['end_date'])):'';

    $fax_in_sql = "INSERT INTO dental_fax_invoice SET
                invoice_id = '".mysqli_real_escape_string($con,$invoiceid)."',
                description = '".mysqli_real_escape_string($con,"Free Faxes – ". $fax['total_faxes']." at $0.00 each")."',
                start_date = '".mysqli_real_escape_string($con,$fax_start_date)."',
                end_date = '".mysqli_real_escape_string($con,$fax_end_date)."',
                amount = '0.00',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysqli_query($con,$fax_in_sql);
    $fax_invoice_id = mysqli_insert_id($con);

    $up_sql = "UPDATE dental_faxes SET
                status = '1',
                fax_invoice_id = '".$fax_invoice_id."' 
                WHERE status='0' AND docid='".mysqli_real_escape_string($con,$r['docid'])."'";
    mysqli_query($con,$up_sql);
}
*/
$_GET['invoice_id'] = $invoiceid;
$redirect = false;
include 'percase_invoice_pdf.php';
  }
$msg = mysqli_num_rows($q) . " invoices created.";
	if(count($no_card)==1){
                  ?>
                    <script type="text/javascript">
                      alert('<?php echo  implode($no_card); ?> does not have a credit card on record.');
                    </script>
                  <?php
	}elseif(count($no_card)>0){
                  ?>
                    <script type="text/javascript">
                      alert('<?php echo  implode($no_card, ', '); ?> do not have credit cards on record.');
                    </script>
                  <?php
	}
		?>


<script type="text/javascript">
  window.location = "manage_monthly_invoice.php?msg=<?php echo  $msg; ?>";
</script>


<?php

function bill_card($customerID, $amount, $userid, $invoiceid){
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
      "customer" => $customerID)
    );
} catch(Stripe_CardError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (Stripe_InvalidRequestError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (Stripe_AuthenticationError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (Stripe_ApiConnectionError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (Stripe_Error $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (Exception $e) {
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
			invoice_id='".mysqli_real_escape_string($con,$invoiceid)."',
			status='".$status."',
                        adddate=NOW(),
                        ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
        mysqli_query($con,$charge_sql);
  if($status==1){
    $invoice_sql = "UPDATE dental_percase_invoice SET
			status=1
			WHERE id='".mysqli_real_escape_string($con,$invoiceid)."'";
    mysqli_query($con,$invoice_sql);
  }
  return true;

}
