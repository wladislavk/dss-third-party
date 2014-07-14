<?php
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
require_once '../includes/constants.inc';
require_once 'includes/access.php';
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<?php
require_once '../3rdParty/stripe/lib/Stripe.php';
$id = $_GET['docid'];
$sql = "SELECT * FROM dental_users
	WHERE userid='".mysql_real_escape_string($id)."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);

$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysql_real_escape_string($id)."'";
$key_q = mysql_query($key_sql);
$key_r= mysql_fetch_assoc($key_q);

Stripe::setApiKey($key_r['stripe_secret_key']);


$cards = Stripe_Customer::retrieve($r['cc_id'])->cards->all();
$last4 = $cards['data'][0]['last4'];


if(isset($_POST['bill_submit'])){
  $charge = $_POST['cid'];
  if($charge!=''){
    $amount = (str_replace(',','',$_POST['amount'])*100);

    $csql = "SELECT * FROM dental_charges WHERE id='".mysql_real_escape_string($charge)."'";
    $cq = mysql_query($csql);
    $cr = mysql_fetch_assoc($csql);

try{
    $charge = Stripe_Charge::retrieve($cr['stripe_charge']);
    $charge->refunds->create(array(
      "amount" => $amount, # $15.00 this time
      "currency" => "usd",
      "customer" => $customerID)
    );
} catch(Stripe_CardError $e) {
  // Since it's a decline, Stripe_CardError will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  die();
} catch (Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  die();
} catch (Stripe_AuthenticationError $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo "Authentication Error. Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  die();
} catch (Stripe_ApiConnectionError $e) {
  // Network communication with Stripe failed
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  die();
} catch (Stripe_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  die();
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
  die();

}

  $charge_sql = "INSERT INTO dental_refund SET
			amount='".mysql_real_escape_string(str_replace(',','',$_POST['amount']))."',
                        userid='".mysql_real_escape_string($id)."',
                        adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."',
                        refund_date=NOW(),
                        charge_id='".mysql_real_escape_string($cr['id'])."',
                        adddate=NOW(),
                        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";	
  	mysql_query($charge_sql); 
    ?><h3><?= $r['first_name']; ?> <?= $r['last_name']; ?> refunded <?= $_POST['amount']; ?>.</h3><?php
     ?><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
	die();
  }else{
    ?><h3>Not entered in Stripe.</h3><?php
     ?><button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button><?php
        die();

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
                <label for="npi" class="col-md-3 control-label">Amount to refund credit card ending <?= $last4; ?></label>
                <div class="col-md-9">
			$<input type="text" id="amount" name="amount" value="<?=$total_charge;?>" />
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
