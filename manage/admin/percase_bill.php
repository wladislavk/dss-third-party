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

    Stripe_Charge::create(array(
      "amount" => $amount, # $15.00 this time
      "currency" => "usd",
      "customer" => $customerID)
    );
    ?><h3>Billed <?= $_POST['amount']; ?>.</h3><?php
  }else{
    ?><h3>Not entered in Stripe.</h3><?php
  }
}
?>
<form action="#" method="post" onsubmit="return confirm_charge();">
Amount to charge credit card for <?= $r['name']; ?> $<input type="text" id="amount" name="amount" />
<br /><br />

<input type="submit" name="bill_submit"  value="Bill Credit Card" />
</form>


<script type="text/javascript">
  function confirm_charge(){
    a = $('#amount').val();
    return confirm("Credit card for <?= $r['name']; ?> will be charged $"+a+". Proceed?");
  }
</script>
