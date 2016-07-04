<?php namespace Ds3\Libraries\Legacy; ?><?php

include_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
include_once '../includes/constants.inc';
include_once 'includes/access.php';

require_once dirname(__FILE__) . '/includes/popup_top.htm';

?>
<script type="text/javascript" src="/manage/3rdParty/jquery.formatCurrency-1.4.0.pack.js"></script>
<?php

require_once '../3rdParty/stripe/lib/Stripe.php';
$id = $_GET['docid'];
$sql = "SELECT * FROM dental_users
	WHERE userid='".mysqli_real_escape_string($con,$id)."'";
$q = mysqli_query($con,$sql);
$r = mysqli_fetch_assoc($q);

$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysqli_real_escape_string($con,$id)."'";
$key_q = mysqli_query($con,$key_sql);
$key_r= mysqli_fetch_assoc($key_q);

\Stripe::setApiKey($key_r['stripe_secret_key']);


$cards = \Stripe_Customer::retrieve($r['cc_id'])->cards->all();
$last4 = $cards['data'][0]['last4'];


if(isset($_POST['bill_submit'])){
  $customerID = $r['cc_id'];
  if($customerID!=''){
    $amount = (str_replace(',','',$_POST['amount'])*100);


try{
    $charge = \Stripe_Charge::create(array(
      "amount" => $amount, # $15.00 this time
      "currency" => "usd",
      "customer" => $customerID)
    );
} catch(\Stripe_CardError $e) {
  // Since it's a decline, Stripe_CardError will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (\Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (\Stripe_AuthenticationError $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo "Authentication Error. Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (\Stripe_ApiConnectionError $e) {
  // Network communication with Stripe failed
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (\Stripe_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);

}

  $stripe_charge = $charge->id;
  $stripe_customer = $charge->customer;
  $stripe_card_fingerprint = $charge->card->fingerprint;
  $charge_sql = "INSERT INTO dental_charge SET
			amount='".mysqli_real_escape_string($con,str_replace(',','',$_POST['amount']))."',
                        userid='".mysqli_real_escape_string($con,$id)."',
                        adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."',
                        charge_date=NOW(),
                        stripe_customer='".mysqli_real_escape_string($con,$stripe_customer)."',
                        stripe_charge='".mysqli_real_escape_string($con,$stripe_charge)."',
                        stripe_card_fingerprint='".mysqli_real_escape_string($con,$stripe_card_fingerprint)."',
			invoice_id='".mysqli_real_escape_string($con,(isset($_REQUEST['invoice']) && $_REQUEST['invoice']!='')?$_REQUEST['invoice']:'')."',
                        adddate=NOW(),
                        ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";	
  	mysqli_query($con,$charge_sql); 
  if(isset($_REQUEST['invoice']) && $_REQUEST['invoice']!=''){
    $i_sql = "UPDATE dental_percase_invoice SET status=1 WHERE id='".mysqli_real_escape_string($con,$_REQUEST['invoice'])."'";
    mysqli_query($con,$i_sql);
  }
    ?><h3><?= $r['first_name']; ?> <?= $r['last_name']; ?> billed <?= $_POST['amount']; ?>.</h3><?php
     ?><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
	trigger_error("Die called", E_USER_ERROR);
  }else{
    ?><h3>Not entered in Stripe.</h3><?php
     ?><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
        trigger_error("Die called", E_USER_ERROR);

  }
}

  if(isset($_GET['invoice']) && $_GET['invoice']!=''){
    $a_sql = "SELECT id, monthly_fee_amount, docid FROM dental_percase_invoice WHERE id='".mysqli_real_escape_string($con,$_GET['invoice'])."'";
    $a_q = mysqli_query($con,$a_sql);
    $myarray = mysqli_fetch_assoc($a_q);
    $total_charge = $myarray['monthly_fee_amount'];
$case_sql = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl                 JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$myarray['docid']."' AND
                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_percase_invoice_extra dl
         WHERE 
                dl.percase_invoice='".$myarray['id']."'
        UNION                   
SELECT CONCAT('Insurance Verification Services – ', patient_firstname, ' ', patient_lastname), invoice_date, '', invoice_amount, id FROM dental_insurance_preauth
        WHERE                   
                invoice_id='".$myarray['id']."'
        UNION                           
SELECT description,             
start_date, end_date, amount, id FROM dental_fax_invoice        WHERE
                invoice_id='".$myarray['id']."'";
$case_q = mysqli_query($con,$case_sql);
while($case_r = mysqli_fetch_assoc($case_q)){
$total_charge += $case_r['percase_amount'];
}
 
  }else{
    $total_charge= "";
  }
?>
        <div class="page-header">
            <h1>Charge <?= $r['first_name']; ?> <?=$r['last_name'];?></h1>
	</div> 

<form action="#" method="post" onsubmit="return confirm_charge();">
<?php  if(isset($_GET['invoice']) && $_GET['invoice']!=''){
  ?><input type="hidden" name="invoice" value="<?= $_GET['invoice']; ?>" /><?php
}
?>
            <div class="form-group">
                <label for="npi" class="col-md-3 control-label">Amount to charge credit card ending <?= $last4; ?></label>
                <div class="col-md-9">
			$<input type="text" id="amount" name="amount" value="<?=$total_charge;?>" />
		</div>
	    </div>
<span id="amount_notification" style="color:#c33; font-size:12px;"></span>

<input type="submit" id="bill_submit" name="bill_submit"  value="Charge Credit Card" class="btn btn-primary">
<div id="loading_image" style="display:none;"><img src="../images/DSS-ajax-animated_loading-gif.gif" /></div>
</form>
<script type="text/javascript">
  function confirm_charge(){
    $('#bill_submit').hide();
    $('#loading_image').show();
    a = $('#amount').val();
    if(a == '' || a < .5){
	alert('You must enter amount to be billed. Amount must be at least $0.50');
        $('#bill_submit').show();
    $('#loading_image').hide();
	return false;
    }
    rval =  confirm("Credit card for <?= $r['first_name']; ?> <?= $r['last_name']; ?> will be charged $"+a+". Proceed?");
    if(!rval){
      $('#bill_submit').show();
    $('#loading_image').hide();
    }
    return rval;
  }

  $(document).ready(function() {
    $("#amount").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||

	    (event.keyCode == 190 ||  event.keyCode == 110) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });

        $('.currency').blur(function()
        {
          $('.currency').formatCurrency({eventOnDecimalsEntered:true});
        });

			$('#amount').blur(function() {
				$('#amount_notification').html(null);
				$(this).formatCurrency({ colorize: true, positiveFormat: '%n', roundToDecimalPlace: 2 });
			})
			.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 17: break; // Ctrl
						case 18: break; // Alt
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ colorize: true, positiveFormat: '%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
			})
			.bind('decimalsEntered', function(e, cents) {
				if (String(cents).length > 2) {
					var errorMsg = 'Please do not enter more than 2 decimal places';
					$('#amount_notification').html(errorMsg);
					log('Event on decimals entered: ' + errorMsg);
				}
			});

	

});

</script>
