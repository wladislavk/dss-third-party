<h3>Credit Card Information</h3>
<?php

require_once '3rdParty/stripe/lib/Stripe.php';

$key_sql = "SELECT c.stripe_secret_key, u.cc_id, u.userid, c.id, c.name, u.email, CONCAT(u.first_name, ' ', u.last_name) user_name FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
		JOIN dental_users u 
			ON u.userid = uc.userid
                 WHERE u.userid='".mysql_real_escape_string($_SESSION['docid'])."'";
$key_q = mysql_query($key_sql);
$key_r= mysql_fetch_assoc($key_q);

Stripe::setApiKey($key_r['stripe_secret_key']);

if($key_r['cc_id'] == ''){

?>No card on record.<?php
?> <a href="#" onclick="$('#card_form').show();$('#payment_proceed_add').show();$(this).hide();return false;" id="show_but">Add</a><?php


}else{
$customer = Stripe_Customer::retrieve($key_r['cc_id']);

?>Active card is <?= $customer->active_card['type']; ?> ending in: <?php
echo($customer->active_card['last4']);
?> <a href="#" onclick="$('#card_form').show();$('#payment_proceed_update').show();$(this).hide();return false;" id="show_but">Update</a><?php

}
?>
<div id="card_form" style="display:none;" class="clear">

<div class="form_errors" style="display:none"></div>
<input type="hidden" id="userid" name="userid" />

                <div class="sepH_b half">
                        <label class="lbl_a"><strong>1.</strong> Card Number:</label><input type="text" size="20" autocomplete="off" class="inpt_a ccmask card-number"/>
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>2.</strong> Card CVC (security code):</label><input class="inpt_a card-cvc cvcmask" id="card-cvc" name="card-cvc" type="text" />
                </div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>3.</strong> Expiration Month (MM):</label><input class="inpt_a small card-expiry-month mmmask" id="card-expiry-month" name="card-expiry-month" type="text" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>4.</strong> Expiration Year (YYYY):</label><input class="inpt_a small card-expiry-year yyyymask" id="card-expiry-year" name="card-expiry-year" type="text" />
                </div>
                <div class="sepH_b half clear">
                        <label class="lbl_a"><strong>5.</strong> Name on Card:</label><input class="inpt_a card-name" id="card-name" name="card-name" type="text" />
                </div>
                <div class="sepH_b half">
                        <label class="lbl_a"><strong>6.</strong> Card Zipcode:</label><input class="inpt_a small card-zip zipmask" id="card-zip" name="card-zip" type="text" />
                </div>
<?php
if($key_r['cc_id'] == ''){
?>
<div id="payment_proceed_add_buttons">
<a href="#" onclick="add_cc(); return false;" style="display:none;" id="payment_proceed_add" class="addButton">Save</a>
<?php
}else{
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
<?php

?>

<script type="text/javascript">

      function add_cc(){
    <?php
$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
 if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff']!=1){ ?>
    alert('You do not have permission to edit the practice profile.  Only users with sufficient permission may do so.  Please contact your office manager to resolve this issue.');
    return false;
  <?php } ?>

        if($('.card-number').val()=='' || $('.card-cvc').val()=='' || $('.card-expiry-month').val().length!=2 || $('.card-expiry-year').val().length!=4 || $('.card-name').val()=='' || $('.card-zip').val().length!=5){
          alert('Please enter valid information for all fields');
          return false;
        }
        $('#loader').show();
$('#payment_proceed_add_buttons').hide();

        $.ajax({
          url: "includes/stripe_token_new.php",
          type: "post",
          data: {id: <?= addslashes($key_r['userid']); ?>, 
                name: "<?= addslashes($key_r['user_name']); ?>", 
                email: "<?= addslashes($key_r['email']); ?>",
                cnumber: $('.card-number').val(),
                cname: $('.card-name').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val(),
                cvc: $('.card-cvc').val(),
                zip: $('.card-zip').val(),
                companyid: "<?= addslashes($key_r['id']); ?>", 
                company: "<?= addslashes($key_r['name']); ?>"
          },
          success: function(data){
            var r = $.parseJSON(data);
		//alert(data);
            if(r.error){
              $('#loader').hide();      
              //$('#payment_proceed').show();
              alert(r.error.message);
$('#payment_proceed_add_buttons').show();

            }else{
              $('.card-number').val('');
              $('.card-cvc').val('');
              $('.card-expiry-month').val('');
              $('.card-expiry-year').val('');
              //$("#email_add").text($("#email").val());
              //$('a.next').click();
	      window.location = 'manage_profile.php';
            }
          },
          failure: function(data){
             //alert('f - '+data);
             $('#loader').hide();
             //$('#payment_proceed').show();
             //alert('fail');
          }
        });
        return false;
      }


      function update_cc(){
    <?php
$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
 if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff']!=1){ ?>
    alert('You do not have permission to edit the practice profile.  Only users with sufficient permission may do so.  Please contact your office manager to resolve this issue.');
    return false;
  <?php } ?>

        if($('.card-number').val()=='' || $('.card-cvc').val()=='' || $('.card-expiry-month').val().length!=2 || $('.card-expiry-year').val().length!=4 || $('.card-name').val()=='' || $('.card-zip').val().length!=5){
          alert('Please enter valid information for all fields');
          return false;
        }
        $('#loader').show();
$('#payment_proceed_update_buttons').hide();
        //$('#payment_proceed').hide();
        $.ajax({
          url: "includes/stripe_token_update.php",
          type: "post",
          data: {id: <?= addslashes($key_r['userid']); ?>, 
		token: "<?= addslashes($key_r['cc_id']); ?>",
                name: "<?= addslashes($key_r['user_name']); ?>", 
                email: "<?= addslashes($key_r['email']); ?>",
                cnumber: $('.card-number').val(),
                cname: $('.card-name').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val(),
                cvc: $('.card-cvc').val(),
                zip: $('.card-zip').val(),
                companyid: "<?= addslashes($key_r['id']); ?>", 
                company: "<?= addslashes($key_r['name']); ?>"
          },
          success: function(data){
            var r = $.parseJSON(data);
              //  alert(data);
            if(r.error){
              $('#loader').hide();      
              //$('#payment_proceed').show();
              alert(r.error.message);
		$('#payment_proceed_update_buttons').show();
            }else{
              $('.card-number').val('');
              $('.card-cvc').val('');
              $('.card-expiry-month').val('');
              $('.card-expiry-year').val('');
              //$("#email_add").text($("#email").val());
              //$('a.next').click();
              window.location = 'manage_profile.php';
            }
          },
          failure: function(data){
             //alert('f - '+data);
             $('#loader').hide();
             //$('#payment_proceed').show();
             //alert('fail');
          }
        });
        return false;
      }





  </script>

