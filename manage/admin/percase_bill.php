<?php
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
require_once '../includes/constants.inc';
require_once 'includes/access.php';
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="../js/masks.js"></script>
    <script type="text/javascript" src="../3rdParty/jquery.formatCurrency-1.4.0.pack.js"></script>
<?php
require_once '../3rdParty/stripe/lib/Stripe.php';
?><br /><br /><br /><?php
$id = $_GET['docid'];
$sql = "SELECT * FROM dental_users
	WHERE userid='".mysql_real_escape_string($id)."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if(isset($_POST['bill_submit'])){
  $customerID = $r['cc_id'];
  if($customerID!=''){
    $amount = $_POST['amount']*100;
    Stripe::setApiKey(DSS_STRIPE_SEC_KEY);

try{
    $charge = Stripe_Charge::create(array(
      "amount" => $amount, # $15.00 this time
      "currency" => "usd",
      "customer" => $customerID)
    );
} catch(Stripe_CardError $e) {
  // Since it's a decline, Stripe_CardError will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="parent.disablePopupClean()" class="addButton">Close</button><?php
  die();
} catch (Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
    ?><br /><br /><button onclick="parent.disablePopupClean()" class="addButton">Close</button><?php
  die();
} catch (Stripe_AuthenticationError $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
  return $e;
} catch (Stripe_ApiConnectionError $e) {
  // Network communication with Stripe failed
  return $e;
} catch (Stripe_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  return $e;
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  return $e;
}

  $stripe_charge = $charge->id;
  $stripe_customer = $charge->customer;
  $stripe_card_fingerprint = $charge->card->fingerprint;
  $charge_sql = "INSERT INTO dental_charge SET
			amount='".mysql_real_escape_string($_POST['amount'])."',
                        userid='".mysql_real_escape_string($id)."',
                        adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."',
                        charge_date=NOW(),
                        stripe_customer='".mysql_real_escape_string($stripe_customer)."',
                        stripe_charge='".mysql_real_escape_string($stripe_charge)."',
                        stripe_card_fingerprint='".mysql_real_escape_string($stripe_card_fingerprint)."',
                        adddate=NOW(),
                        ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";	
  	mysql_query($charge_sql); 
    ?><h3><?= $r['name']; ?> billed <?= $_POST['amount']; ?>.</h3><?php
     ?><button onclick="parent.disablePopupClean()" class="addButton">Close</button><?php
	die();
  }else{
    ?><h3>Not entered in Stripe.</h3><?php
     ?><button onclick="parent.disablePopupClean()" class="addButton">Close</button><?php
        die();

  }
}
?>
<form action="#" method="post" onsubmit="return confirm_charge();">
Amount to charge credit card for <?= $r['name']; ?> $<input type="text" id="amount" name="amount" />
<span id="amount_notification" style="color:#c33; font-size:12px;"></span>
<br /><br />

<input type="submit" name="bill_submit"  value="Bill Credit Card" />
</form>


<script type="text/javascript">
  function confirm_charge(){
    a = $('#amount').val();
    return confirm("Credit card for <?= $r['name']; ?> will be charged $"+a+". Proceed?");
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
