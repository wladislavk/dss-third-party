<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/stripe-functions.php';
include_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
include_once '../includes/constants.inc';
include_once 'includes/access.php';

include_once dirname(__FILE__) . '/includes/popup_top.htm';
?>
<script type="text/javascript" src="/manage/3rdParty/jquery.formatCurrency-1.4.0.pack.js"></script>
<?php
$db = new Db();

$id = $_GET['docid'];
$sql = "SELECT * FROM dental_users WHERE userid='".$db->escape($id)."'";
$q = mysqli_query($con,$sql);
$r = mysqli_fetch_assoc($q);
$charge_sql = "SELECT * 
    FROM dental_charge
    WHERE userid='".$db->escape($_GET['docid'])."'
    AND id='".$db->escape($_GET['cid'])."'";
$charge_q = mysqli_query($con,$charge_sql);
$charge_r = mysqli_fetch_assoc($charge_q);

$key_r = getStripeRelatedUserData($_GET['docid']);
setupStripeConnection($key_r['stripe_secret_key']);
$customer = getStripeCustomer($key_r['cc_id']);
$card = getActiveStripeCard($customer);
$last4 = '';

if ($card) {
    $last4 = $card->last4;
}

if(isset($_POST['bill_submit'])){
    $charge = $_POST['cid'];
    if($charge!=''){
        $amount = (str_replace(',','',$_POST['amount'])*100);
        $csql = "SELECT * FROM dental_charge WHERE id='".$db->escape($charge)."'";
        $cq = mysqli_query($con,$csql);
        $cr = mysqli_fetch_assoc($cq);
        try{
            $refundDetails = [
                'charge' => $cr['stripe_charge'],
            ];
            if ($amount) {
                $refundDetails['amount'] = $amount;
            }
            $refund = \Stripe\Refund::create($refundDetails);
        } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, Stripe_CardError will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];
            echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";?>
            <br /><br />
            <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $body = $e->getJsonBody();
            $err  = $body['error'];
            echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue."; ?>
            <br /><br />
            <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            echo "Authentication Error. Please contact your Credit Card billing administrator to resolve this issue."; ?>
            <br /><br />
            <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $body = $e->getJsonBody();
            $err = $body['error'];
            echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue."; ?>
            <br /><br />
            <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $body = $e->getMessage();
            echo e($body).". Please contact your Credit Card billing administrator to resolve this issue."; ?>
            <br /><br />
            <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
        if (!$refund) {
            ?>
            The refund has failed. Please contact the system administrator to inform about the issue.
            <br /><br />
            <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
        $charge_sql = "INSERT INTO dental_refund SET
            amount='".$db->escape(str_replace(',','',$_POST['amount']))."',
            userid='".$db->escape($id)."',
            adminid='".$db->escape($_SESSION['adminuserid'])."',
            refund_date=NOW(),
            charge_id='".$db->escape($cr['id'])."',
            adddate=NOW(),
            ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        mysqli_query($con,$charge_sql); ?>
        <h3><?= $r['first_name']; ?> <?= $r['last_name']; ?> refunded <?= $_POST['amount']; ?>.</h3>
        <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }else{ ?>
        <h3>Not entered in Stripe.</h3>
        <button onclick="window.parent.refreshParent();" class="btn btn-success">Close</button>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}
?>
<div class="page-header">
    <h1>Refund <?= $r['first_name']; ?> <?=$r['last_name'];?></h1>
</div>

<form action="#" method="post" onsubmit="return confirm_charge();">
    <?php if(isset($_GET['cid']) && $_GET['cid']!=''){ ?>
        <input type="hidden" name="cid" value="<?= $_GET['cid']; ?>" />
    <?php } ?>
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
            } else {
                // Ensure that it is a number and stop the keypress
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault();
                }
            }
        });
        $('.currency').blur(function() {
            $('.currency').formatCurrency({eventOnDecimalsEntered:true});
        });
        $('#amount').blur(function() {
            $('#amount_notification').html(null);
            $(this).formatCurrency({ colorize: true, positiveFormat: '%n', roundToDecimalPlace: 2 });
        }).keyup(function(e) {
            var e = window.event || e;
            var keyUnicode = e.charCode || e.keyCode;
            if (e !== undefined) {
                switch (keyUnicode) {
                    case 16: // Shift
                    case 17: // Ctrl
                    case 18: // Alt
                    case 35: // End
                    case 36: // Home
                    case 37: // cursor left
                    case 38: // cursor up
                    case 39: // cursor right
                    case 40: // cursor down
                    case 78: // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                    case 110: // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                    case 190:
                    case 27:
                        this.value = '';
                        break; // Esc: clear entry
                    default:
                        $(this).formatCurrency({
                            colorize: true,
                            positiveFormat: '%n',
                            roundToDecimalPlace: -1,
                            eventOnDecimalsEntered: true
                        });
                }
            }
        }).bind('decimalsEntered', function(e, cents) {
            if (String(cents).length > 2) {
                var errorMsg = 'Please do not enter more than 2 decimal places';
                $('#amount_notification').html(errorMsg);
                log('Event on decimals entered: ' + errorMsg);
            }
        });
    });
</script>
