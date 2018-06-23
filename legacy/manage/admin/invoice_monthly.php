<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/stripe-functions.php';
include_once 'includes/main_include.php';
include_once '../includes/constants.inc';

$no_card = [];
$sql = "SELECT du.*, 
    c.name AS company_name, 
    c.free_fax,
    plan.trial_period,
    (SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
    FROM dental_users du 
    JOIN dental_user_company uc ON uc.userid = du.userid
    JOIN companies c ON c.id=uc.companyid
    JOIN dental_plans plan ON plan.id=du.plan_id
    WHERE du.status=1 AND du.docid=0 
    AND 
        ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".$db->escape(DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) < DATE_SUB(now(), INTERVAL 1 MONTH) OR 
        ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".$db->escape(DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) IS NULL AND DATE_ADD(du.adddate, INTERVAL plan.trial_period DAY) < now()))
    AND (SELECT COUNT(*) as num_inv FROM dental_percase_invoice WHERE docid=du.userid AND status = '".DSS_INVOICE_PENDING."') = 0";

if(isset($_GET['company']) && $_GET['company'] != ""){
    $sql .= " AND c.id='".$db->escape($_GET['company'])."' ";
}

$q = mysqli_query($con,$sql);
while($r = mysqli_fetch_assoc($q)){
    $doc_sql = "SELECT p.monthly_fee, p.fax_fee, p.free_fax, u.name, u.user_type
        FROM dental_users u
        JOIN dental_user_company uc ON uc.userid = u.userid
        JOIN companies c ON uc.companyid = c.id
        JOIN dental_plans p ON p.id=u.plan_id
        WHERE u.userid='".$db->escape($r['userid'])."'";
    $doc_q = mysqli_query($con,$doc_sql);
    if(mysqli_num_rows($doc_q) == 0){
        //If no plan get company fees
        $doc_sql = "SELECT c.monthly_fee, c.fax_fee, c.free_fax, concat(u.first_name,' ',u.last_name) name, u.user_type
            FROM dental_users u
            JOIN dental_user_company uc ON uc.userid = u.userid
            JOIN companies c ON uc.companyid = c.id
            WHERE u.userid='".$db->escape($_REQUEST['docid'])."'";
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
                " VALUES (".$_SESSION['adminuserid'].", ".$r['userid'].", NOW(), '".$_SERVER['REMOTE_ADDR']."', '".$db->escape(date('Y-m-d', strtotime($monthly_date)))."', '".$db->escape($doc['monthly_fee'])."')";
	mysqli_query($con,$in_sql);
	$invoiceid = mysqli_insert_id($con);

	if(isset($_GET['bill']) && $_GET['bill']=="1"){
		if($r['cc_id']!=''){
		  bill_card($r['cc_id'] ,$doc['monthly_fee'], $r['userid'], $invoiceid);	
		}else{
                    $charge_sql = "INSERT INTO dental_charge SET
                        amount='".$db->escape(str_replace(',','',$doc['monthly_fee']))."',
                        userid='".$db->escape((!empty($user['userid']) ? $user['userid'] : ''))."',
                        adminid='".$db->escape($_SESSION['adminuserid'])."',
                        charge_date=NOW(),
			invoice_id='".$db->escape($invoiceid)."',
                        status='2',
                        adddate=NOW(),
                        ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'";
                        mysqli_query($con,$charge_sql);
		     $i_sql = "UPDATE dental_percase_invoice set status=2 WHERE id='".$invoiceid."'";
			mysqli_query($con,$i_sql);
 		  array_push($no_card, $r['first_name']." ".$r['last_name']);
		}
	}
$_GET['invoice_id'] = $invoiceid;
$redirect = false;
include 'percase_invoice_pdf.php';
  }
$msg = mysqli_num_rows($q) . " invoices created.";
	if (count($no_card)==1) { ?>
        <script type="text/javascript">
            alert('<?php echo  implode($no_card); ?> does not have a credit card on record.');
        </script>
        <?php
	} elseif(count($no_card)>0) {
	    ?>
        <script type="text/javascript">
            alert('<?php echo  implode($no_card, ', '); ?> do not have credit cards on record.');
        </script>
        <?php
	} ?>
<script type="text/javascript">
  window.location = "manage_monthly_invoice.php?msg=<?php echo  $msg; ?>";
</script>
<?php
function bill_card($customerID, $amount, $userid, $invoiceid)
{
  if($amount==0){
    ?>
    <script type="text/javascript">
      alert('Cannot post $0.00 charge to Stripe.');
    </script>
    <?php
  }else{
$key_r = getStripeRelatedUserData($userid);
setupStripeConnection($key_r['stripe_secret_key']);
$status = 1;

try{
    $charge = \Stripe\Charge::create(array(
      "amount" => ($amount*100), # $15.00 this time
      "currency" => "usd",
      "customer" => $customerID)
    );
} catch(\Stripe\Error\Card $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".$db->escape($invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (\Stripe\Error\InvalidRequest $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".$db->escape($invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (\Stripe\Error\Authentication $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".$db->escape($invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (\Stripe\Error\ApiConnection $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".$db->escape($invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
} catch (\Exception $e) {
  $invoice_sql = "UPDATE dental_percase_invoice SET
                        status=2
                        WHERE id='".$db->escape($invoiceid)."'";
  mysqli_query($con,$invoice_sql);
  $status = 2;
}

  $stripe_charge = $charge->id;
  $stripe_customer = $charge->customer;
  $stripe_card_fingerprint = $charge->source->fingerprint;
  $charge_sql = "INSERT INTO dental_charge SET
                        amount='".$db->escape(str_replace(',','',$amount))."',
                        userid='".$db->escape($userid)."',
                        adminid='".$db->escape($_SESSION['adminuserid'])."',
                        charge_date=NOW(),
                        stripe_customer='".$db->escape($stripe_customer)."',
                        stripe_charge='".$db->escape($stripe_charge)."',
                        stripe_card_fingerprint='".$db->escape($stripe_card_fingerprint)."',
			invoice_id='".$db->escape($invoiceid)."',
			status='".$status."',
                        adddate=NOW(),
                        ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        mysqli_query($con,$charge_sql);
  if($status==1){
    $invoice_sql = "UPDATE dental_percase_invoice SET
			status=1
			WHERE id='".$db->escape($invoiceid)."'";
    mysqli_query($con,$invoice_sql);
  }

}
  return true;

}
