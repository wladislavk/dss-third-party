<?php
  require_once 'includes/config.php';
  require_once '../includes/constants.inc';
  require_once '../3rdParty/stripe/lib/Stripe.php';
 $no_card = array(); 
  $sql = "SELECT du.*, c.name AS company_name, c.free_fax,
                (SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
                WHERE du.docid=0 AND 
		((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) < DATE_SUB(now(), INTERVAL 1 MONTH) OR 
                	((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) IS NULL AND du.adddate < DATE_SUB(now(), INTERVAL 1 MONTH)))
			AND
		(SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.percase_status = '".DSS_PERCASE_PENDING."') = 0 AND
		(SELECT count(*) as total_faxes FROM dental_faxes f
        		WHERE 
                f.docid='".$_REQUEST['docid']."' AND
                f.status = '0') <=  c.free_fax AND
		(SELECT COUNT(*) FROM dental_insurance_preauth p
                JOIN dental_patients dp ON p.patient_id=dp.patientid
		        WHERE 
                p.doc_id='".$_REQUEST['docid']."' AND
                p.invoice_status = '".DSS_PERCASE_PENDING."') = 0
                ";
  if(isset($_GET['company']) && $_GET['company'] != ""){
        $sql .= " AND c.id='".mysql_real_escape_string($_GET['company'])."' ";
  }

  $q = mysql_query($sql)  or die(mysql_error());
  while($r = mysql_fetch_assoc($q)){
	  $doc_sql = "SELECT c.monthly_fee, c.fax_fee, c.free_fax, u.name, u.user_type
                FROM dental_users u
                JOIN dental_user_company uc ON uc.userid = u.userid
                JOIN companies c ON uc.companyid = c.id
                WHERE u.userid='".mysql_real_escape_string($r['userid'])."'";
  	  $doc_q = mysql_query($doc_sql);
  	  $doc = mysql_fetch_assoc($doc_q);
	if($r['last_monthly_fee_date']){
          $date = $r['last_monthly_fee_date'];
	  $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
	  $monthly_date = date ( 'Y-m-d' , $newdate );
        }elseif($r['registration_date']){
          $date = $r['registration_date'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'Y-m-d' , $newdate );
	}elseif($r['adddate']){
	  $date = $r['adddate'];
          $newdate = strtotime ( '+1 month' , strtotime ( $date ) ) ;
          $monthly_date = date ( 'Y-m-d' , $newdate );
	}else{
	  $monthly_date = date('Y-m-d');
	}

	$in_sql = "INSERT INTO dental_percase_invoice (adminid, docid, adddate, ip_address, monthly_fee_date, monthly_fee_amount) " .
                " VALUES (".$_SESSION['adminuserid'].", ".$r['userid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string(date('Y-m-d', strtotime($monthly_date)))."', '".mysql_real_escape_string($doc['monthly_fee'])."')";
	//echo($in_sql."<br /><br />");
	mysql_query($in_sql);
	$invoiceid = mysql_insert_id();

	if(isset($_GET['bill']) && $_GET['bill']=="1"){
		if($r['cc_id']!=''){
		  bill_card($r['cc_id'] ,$doc['monthly_fee'], $r['userid'], $invoiceid);	
		}else{
                    $charge_sql = "INSERT INTO dental_charge SET
                        amount='".mysql_real_escape_string(str_replace(',','',$doc['monthly_fee']))."',
                        userid='".mysql_real_escape_string($user['userid'])."',
                        adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."',
                        charge_date=NOW(),
			invoice_id='".mysql_real_escape_string($invoiceid)."',
                        status='2',
                        adddate=NOW(),
                        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
                        mysql_query($charge_sql);
		     $i_sql = "UPDATE dental_percase_invoice set status=2 WHERE id='".$invoiceid."'";
			mysql_query($i_sql);
 		  array_push($no_card, $r['first_name']." ".$r['last_name']);
		}
	}

$fax_sql = "SELECT count(*) as total_faxes, MIN(sent_date) as start_date, MAX(sent_date) as end_date FROM dental_faxes f
        WHERE 
                f.docid='".$r['userid']."' AND
                f.status = '0'
";
$fax_q = mysql_query($fax_sql);
$fax = mysql_fetch_assoc($fax_q);

if($fax['total_faxes'] > 0 ){
    $fax_start_date = ($fax['start_date'])?date('Y-m-d', strtotime($fax['start_date'])):'';
    $fax_end_date = ($fax['end_date'])?date('Y-m-d', strtotime($fax['end_date'])):'';

    $fax_in_sql = "INSERT INTO dental_fax_invoice SET
                invoice_id = '".mysql_real_escape_string($invoiceid)."',
                description = '".mysql_real_escape_string("Free Faxes – ". $fax['total_faxes']." at $0.00 each")."',
                start_date = '".mysql_real_escape_string($fax_start_date)."',
                end_date = '".mysql_real_escape_string($fax_end_date)."',
                amount = '0.00',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
    mysql_query($fax_in_sql);
    $fax_invoice_id = mysql_insert_id();

    $up_sql = "UPDATE dental_faxes SET
                status = '1',
                fax_invoice_id = '".$fax_invoice_id."' 
                WHERE status='0' AND docid='".mysql_real_escape_string($r['docid'])."'";
    mysql_query($up_sql);
}
$_GET['invoice_id'] = $invoiceid;
$redirect = false;
include 'percase_invoice_pdf.php';
  }
$msg = mysql_num_rows($q) . " invoices created.";
	if(count($no_card)==1){
                  ?>
                    <script type="text/javascript">
                      alert('<?= implode($no_card); ?> does not have a credit card on record.');
                    </script>
                  <?php
	}elseif(count($no_card)>0){
                  ?>
                    <script type="text/javascript">
                      alert('<?= implode($no_card, ', '); ?> do not have credit cards on record.');
                    </script>
                  <?php
	}
		?>


<script type="text/javascript">
  window.location = "manage_monthly_invoice.php?msg=<?= $msg; ?>";
</script>


<?php

function bill_card($customerID, $amount, $userid, $invoiceid){
$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysql_real_escape_string($userid)."'";
$key_q = mysql_query($key_sql);
$key_r= mysql_fetch_assoc($key_q);
Stripe::setApiKey($key_r['stripe_secret_key']);
$status = 1;

try{
    $charge = Stripe_Charge::create(array(
      "amount" => $amount, # $15.00 this time
      "currency" => "usd",
      "customer" => $customerID)
    );
} catch(Stripe_CardError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_InvalidRequestError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_AuthenticationError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_ApiConnectionError $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Stripe_Error $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
} catch (Exception $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".mysql_real_escape_string($invoiceid)."'";
  mysql_query($invoice_sql);
  $status = 2;
}

  $stripe_charge = $charge->id;
  $stripe_customer = $charge->customer;
  $stripe_card_fingerprint = $charge->card->fingerprint;
  $charge_sql = "INSERT INTO dental_charge SET
                        amount='".mysql_real_escape_string(str_replace(',','',$amount))."',
                        userid='".mysql_real_escape_string($userid)."',
                        adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."',
                        charge_date=NOW(),
                        stripe_customer='".mysql_real_escape_string($stripe_customer)."',
                        stripe_charge='".mysql_real_escape_string($stripe_charge)."',
                        stripe_card_fingerprint='".mysql_real_escape_string($stripe_card_fingerprint)."',
			invoice_id='".mysql_real_escape_string($invoiceid)."',
			status='".$status."',
                        adddate=NOW(),
                        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
        mysql_query($charge_sql);
  if($status==1){
    $invoice_sql = "UPDATE dental_percase_invoice SET
			status=1
			WHERE id='".mysql_real_escape_string($invoiceid)."'";
    mysql_query($invoice_sql);
  }
  return true;

}
