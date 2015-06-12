<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
include_once '../includes/constants.inc';
include_once 'includes/access.php';
?>
<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<?php
include_once '../3rdParty/stripe/lib/Stripe.php';
$id = $_GET['docid'];
$sql = "SELECT * FROM dental_users
	WHERE userid='".mysqli_real_escape_string($con,$id)."'";
$q = mysqli_query($con,$sql);
$r = mysqli_fetch_assoc($q);
  $charge_sql = "SELECT * FROM dental_charge
                        WHERE userid='".mysqli_real_escape_string($con,$_GET['docid'])."'
				AND id='".mysqli_real_escape_string($con,$_GET['cid'])."'";
$charge_q = mysqli_query($con,$charge_sql);
$charge_r = mysqli_fetch_assoc($charge_q);
$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysqli_real_escape_string($con,$id)."'";
$key_q = mysqli_query($con,$key_sql);
$key_r= mysqli_fetch_assoc($key_q);
\Stripe::setApiKey($key_r['stripe_secret_key']);
\Stripe::setApiVersion("2014-06-17");


$cards = \Stripe_Customer::retrieve($r['cc_id'])->cards->all();
$last4 = $cards['data'][0]['last4'];


if(isset($_POST['bill_submit'])){
  $charge = $_POST['cid'];
  if($charge!=''){
    $amount = (str_replace(',','',$_POST['amount'])*100);

    $csql = "SELECT * FROM dental_charge WHERE id='".mysqli_real_escape_string($con,$charge)."'";
    $cq = mysqli_query($con,$csql);
    $cr = mysqli_fetch_assoc($cq);
try{
    $charge = \Stripe_Charge::retrieve($cr['stripe_charge']);
    if ($amount) {
        $charge->refunds->create(array('amount' => $amount));
    } else {
        $charge->refunds->create();
    }
} catch(\Stripe_CardError $e) {
  // Since it's a decline, Stripe_CardError will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $body['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (\Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $body['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
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
  echo $body['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (\Stripe_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $body['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $body['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  trigger_error("Die called", E_USER_ERROR);

}

  $charge_sql = "INSERT INTO dental_refund SET
			amount='".mysqli_real_escape_string($con,str_replace(',','',$_POST['amount']))."',
                        userid='".mysqli_real_escape_string($con,$id)."',
                        adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."',
                        refund_date=NOW(),
                        charge_id='".mysqli_real_escape_string($con,$cr['id'])."',
                        adddate=NOW(),
                        ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";	
  	mysqli_query($con,$charge_sql); 
    ?><h3><?= $r['first_name']; ?> <?= $r['last_name']; ?> refunded <?= $_POST['amount']; ?>.</h3><?php
     ?><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
	trigger_error("Die called", E_USER_ERROR);
  }else{
    ?><h3>Not entered in Stripe.</h3><?php
     ?><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
        trigger_error("Die called", E_USER_ERROR);

  }
}

?>
        <div class="page-header">
            <h1>Refund <?= $r['first_name']; ?> <?=$r['last_name'];?></h1>
	</div> 

<form action="#" method="post" onsubmit="return confirm_charge();">
<?php  if(isset($_GET['cid']) && $_GET['cid']!=''){
  ?><input type="hidden" name="cid" value="<?= $_GET['cid']; ?>" /><?php
}
?>
            <div class="form-group">
                <label for="npi" class="col-md-3 control-label">Amount to refund credit card ending <?= $last4; ?> for $<?= $charge_r['amount']; ?> on <?=date('m/d/Y g:i a', strtotime($charge_r['adddate']));?></label>
                <div class="col-md-9">
			$<input type="text" id="amount" name="amount" value="<?=(!empty($total_charge) ? $total_charge : '');?>" />
		</div>
	    </div>
<span id="amount_notification" style="color:#c33; font-size:12px;"></span>

<input type="submit" id="bill_submit" name="bill_submit"  value="Refund Credit Card" class="btn btn-primary">
<div id="loading_image" style="display:none;"><img src="../images/DSS-ajax-animated_loading-gif.gif" /></div>
</form>
<script type="text/javascript">
  function confirm_charge(){
    $('#bill_submit').hide();
    $('#loading_image').show();
    a = $('#amount').val();
    if(a == '' || a < .5){
	alert('You must enter amount to be refunded. Amount must be at least $0.50');
        $('#bill_submit').show();
    $('#loading_image').hide();
	return false;
    }
    rval =  confirm("Credit card for <?= $r['first_name']; ?> <?= $r['last_name']; ?> will be refunded $"+a+". Proceed?");
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
