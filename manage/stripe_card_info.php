<?php include_once('admin/includes/main_include.php'); ?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>

<h3>Credit Card Information</h3>

<?php
    include_once '3rdParty/stripe/lib/Stripe.php';

    $key_sql = "SELECT c.stripe_secret_key, u.cc_id, u.userid, c.id, c.name, u.email, CONCAT(u.first_name, ' ', u.last_name) user_name FROM companies c 
                JOIN dental_user_company uc
                ON c.id = uc.companyid
                JOIN dental_users u 
                ON u.userid = uc.userid
                WHERE u.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";

    $key_r = $db->getRow($key_sql);

    Stripe::setApiKey($key_r['stripe_secret_key']);

    if ($key_r['cc_id'] == '') {
        ?>No card on record.<?php
        ?> <a href="#" onclick="$('#card_form').show();$('#payment_proceed_add').show();$(this).hide();return false;" id="show_but">Add</a>

<?php
    }else{
        $customer = Stripe_Customer::retrieve($key_r['cc_id']);
        ?>Active card is <?php echo  $customer->active_card['type']; ?> ending in: <?php
        echo($customer->active_card['last4']);
        ?> <a href="#" onclick="$('#card_form').show();$('#payment_proceed_update').show();$(this).hide();return false;" id="show_but">Update</a>
<?php
    }
?>
    <div id="card_form" style="display:none;" class="clear">

    <div class="form_errors" style="display:none"></div>
    <input type="hidden" id="userid" name="userid" />
        <div class="sepH_b half">
            <label class="lbl_a"><strong>1.</strong> Card Number:</label>
            <input type="text" size="20" autocomplete="off" class="inpt_a ccmask card-number"/>
        </div>
        <div class="sepH_b half">
            <label class="lbl_a"><strong>2.</strong> Card CVC (security code):</label>
            <input class="inpt_a card-cvc cvcmask" id="card-cvc" name="card-cvc" type="text" />
        </div>
        <div class="sepH_b half clear">
            <label class="lbl_a"><strong>3.</strong> Expiration Month (MM):</label>
            <input class="inpt_a small card-expiry-month mmmask" id="card-expiry-month" name="card-expiry-month" type="text" />
        </div>
        <div class="sepH_b half">
            <label class="lbl_a"><strong>4.</strong> Expiration Year (YYYY):</label>
            <input class="inpt_a small card-expiry-year yyyymask" id="card-expiry-year" name="card-expiry-year" type="text" />
        </div>
        <div class="sepH_b half clear">
            <label class="lbl_a"><strong>5.</strong> Name on Card:</label>
            <input class="inpt_a card-name" id="card-name" name="card-name" type="text" />
        </div>
        <div class="sepH_b half">
            <label class="lbl_a"><strong>6.</strong> Card Zipcode:</label>
            <input class="inpt_a small card-zip zipmask" id="card-zip" name="card-zip" type="text" />
        </div>

<?php
        $sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
  
        $r = $db->getRow($sql);
        $manage_staff_value = 0;
        if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff']!=1) {
            $manage_staff_value = 1;
        }
?>

        <script>
            var manage_staff_value = <?php echo $manage_staff_value; ?>;
            var userid = <?php echo  addslashes($key_r['userid']); ?>;
            var user_name = "<?php echo  addslashes($key_r['user_name']); ?>";
            var email = "<?php echo  addslashes($key_r['email']); ?>";
            var id = "<?php echo  addslashes($key_r['id']); ?>";
            var name = "<?php echo  addslashes($key_r['name']); ?>";
            var cc_id = "<?php echo  addslashes($key_r['cc_id']); ?>";
        </script>

<?php
        if($key_r['cc_id'] == '') {
?>
            <div id="payment_proceed_add_buttons">
                <a href="#" onclick="add_cc(); return false;" style="display:none;" id="payment_proceed_add" class="addButton">Save</a>
<?php
        } else {
?>
                <div id="payment_proceed_update_buttons">
                    <a href="#" onclick="update_cc(); return false;" style="display:none;" id="payment_proceed_update" class="addButton">Update</a>
<?php } ?>
                    or <a href="#" onclick="$('#card_form').hide(); $('#show_but').show();return false;" id="payment_proceed_cancel" class="fr btn btn_dL">Cancel</a>
                </div>
                <div id="loader" style="display:none;">
                    <img src="images/DSS-ajax-animated_loading-gif.gif" />
                </div>
            </div>

            <div class="clear"></div>

<script type="text/javascript" src="/manage/js/stripe_card_info.js"></script>