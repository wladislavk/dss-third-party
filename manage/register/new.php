<?php session_start();

include 'includes/header.php';
include 'includes/completed.php';
?>
<link rel="stylesheet" href="css/register.css" />
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/register_ie.css" />
<![endif]-->
<script type="text/javascript" src="js/new.js"></script>
<script type="text/javascript" src="js/patient_dob.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/register_masks.js"></script>
        <script type="text/javascript">
                $(document).ready(function(){
                                //lga_fusionCharts.chart_k();
                                lga_wizard.init();

                        });
        </script>

  <?php
  $p = mysql_fetch_assoc($q);
  $c_sql = "SELECT c.id, c.name, c.stripe_publishable_key from companies c 
			WHERE c.default_new = 1"; 
  $c_q = mysql_query($c_sql);
  $c_r = mysql_fetch_assoc($c_q);
?>
				<div id="content_wrapper">
					<div id="main_content" class="cf">

						<h2 class="sepH_c">Step-by-Step User Registration</h2>
	<form action="register.php" id="register_form" method="post">
							<ul id="status" class="cf">
							<?php $pagenum = 1; ?>
								<li class="active"><span class="large"><?= $pagenum++; ?>. Contact Info</span></li>
								<li><span class="large"><?= $pagenum++; ?>. Payment Info</span></li>
							</ul>
							<div id="register" class="wizard" style="height:1400px;">
								<div class="items formEl_a">
									<div class="page">
										<div class="pageInside">
											<div class="cf">
												<div class="dp25">
													<h3 class="sepH_a">Contact Information</h3>
													<p class="s_color"></p>
												</div>
												<div class="dp75">
													<div>
			<input type="hidden" name="companyid" value="<?= $c_r['id']; ?>" />
														<div id="welcome_errors" class="form_errors" style="display:none"></div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>1.</strong> Registration Code <span class="req">*</span></label>
                        <input class="inpt_a validate" type="password" name="code" id="code" value="" />
                </div>
		<div class="sepH_b">
			<label class="lbl_a"><strong>2.</strong> Name <span class="req">*</span></label>
			<input class="inpt_a validate" type="text" name="name" id="name" value="" />
		</div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>3.</strong> Email: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="email" name="email" value="" />
                </div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>4.</strong> Cell Phone: <span class="req">*</span></label><input class="inpt_a validate phonemask" type="text" id="cell_phone" name="cell_phone" value="" />
                </div>
														<div class="cf">
<a href="javascript:void(0)" class="fr next btn btn_dL">Proceed &raquo;</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

                                                                        <div class="page">
                                                                                <div class="pageInside">
                                                                                        <div class="cf">
                                                                                                <div class="dp25">
                                                                                                        <h3 class="sepH_a">Payment Information</h3>
                                                                                                        <p class="s_color">Please enter the credit card billing information to be associated with this account. You must supply a valid card in order to create your account.</p>
                                                                                                </div>
                                                                                                <div class="dp75">
                                                                                                        <div>
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

<div id="loader" style="display:none;">
<img src="../images/DSS-ajax-animated_loading-gif.gif" />
</div>

                                                                                                                <div class="cf">
                                                                                                                        <a href="javascript:void(0)" class="fl prev btn btn_aL">&laquo; Back</a>

<a href="#" onclick="add_cc(); return false;" id="payment_proceed" class="fr btn btn_dL">Proceed &raquo;</a>
<div id="loader" style="display:none;">
<img src="../images/DSS-ajax-animated_loading-gif.gif" />
</div>

                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                        </div>




<div class="page" id="confirmation">
										<div class="pageInside">
											<div class="last sepH_c">
												<p  class="sepH_b">Congratulations! A registration email has been sent to the email address <span id="email_add"></span>. Please continue the registration by clicking the link in that email.</p>

											<div class="cf">
                                                                                                <a href="../index.php" class="fr btn btn_dL">Finished</a>
											</div>
										</div>
									</div>
								</div>
			</div></div>
	</form>  

<div style="clear:both;"></div>
<script type="text/javascript">
$(document).ready(function(){
$(".chzn-select").chosen({no_results_text: "No results matched"});
});

function cancel(n){
  $('#pc_'+n+'_input_div').hide();
  $('#pc_'+n+'_person').show();
  $('#pc_'+n+'_input_div input').val('');
}


function checkPass(){
  var p1 = $('#password').val();
  var p2 = $('#password2').val();
if(p1!='' || p2!=''){
if(p1!=p2){
  $('#password2').addClass('pass_invalid');
  $('#password2').removeClass('pass_valid');
}else{
  $('#password2').addClass('pass_valid');
  $('#password2').removeClass('pass_invalid');
}
}else{
  $('#password2').removeClass('pass_valid');
  $('#password2').removeClass('pass_invalid');  
}

}

</script>
  <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
  <!-- jQuery is used only for this example; it isn't required to use Stripe -->
  <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
  <script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey('<?= $c_r['stripe_publishable_key']; ?>');

    function stripeResponseHandler(status, response) {
console.log(response);
      if (response.error) {
        // Show the errors on the form
//console.log(response.error);
	alert(response.error.message);
             $('#loader').hide();
             $('#payment_proceed').show();
        //$('.payment-errors').text(response.error.message);
        //$('.submit-button').prop('disabled', false);
      } else {
	var address = '';

        var token = response.id;
	$.ajax({
          url: "includes/update_token.php",
          type: "get",
          data: {id: $("#userid").val(), name: $('#name').val(), address: address, email: $("#email").val(), token: token},
          success: function(data){
	    console.log(data);
            $('#loader').hide();      
	    $('#payment_proceed').show();
	/*
            $('.card-number').val('');
            $('.card-cvc').val('');
            $('.card-expiry-month').val('');
            $('.card-expiry-year').val('');
            $('a.next').click();
*/
          },
          failure: function(data){
	     alert('f - '+data);
	     $('#loader').hide();
	     $('#payment_proceed').show();
             //alert('fail');
          }
        });
      }
	             $('#loader').hide();
             $('#payment_proceed').show();
    }

      function add_cc(){
        if($('.card-number').val()=='' || $('.card-cvc').val()=='' || $('.card-expiry-month').val().length!=2 || $('.card-expiry-year').val().length!=4 || $('.card-name').val()=='' || $('.card-zip').val().length!=5){
	  alert('Please enter valid information for all fields');
	  return false;
	}
        $('#loader').show();
	$('#payment_proceed').hide();
	$.ajax({
          url: "includes/update_token_new.php",
          type: "post",
          data: {id: $("#userid").val(), 
		name: $('#name').val(), 
		email: $("#email").val(),
		cnumber: $('.card-number').val(),
		cname: $('.card-name').val(),
		exp_month: $('.card-expiry-month').val(),
		exp_year: $('.card-expiry-year').val(),
		cvc: $('.card-cvc').val(),
		zip: $('.card-zip').val(),
                companyid: "<?= addslashes($c_r['id']); ?>", 
                company: "<?= addslashes($c_r['name']); ?>"
	  },
          success: function(data){
            var r = $.parseJSON(data);
            if(r.error){
              $('#loader').hide();      
              $('#payment_proceed').show();
	      alert(r.error.message);
	    }else{
              $('.card-number').val('');
              $('.card-cvc').val('');
              $('.card-expiry-month').val('');
              $('.card-expiry-year').val('');
	      $("#email_add").text($("#email").val());
              $('a.next').click();
	    }
          },
          failure: function(data){
             //alert('f - '+data);
             $('#loader').hide();
             $('#payment_proceed').show();
             //alert('fail');
          }
        });

	/*
        // Disable the submit button to prevent repeated clicks
        Stripe.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val(),
	  name: $('.card-name').val(),
	  address_zip: $('.card-zip').val()
        }, stripeResponseHandler);
	*/
        // Prevent the form from submitting with the default action
        return false;
      }
  </script>


<?php include 'includes/footer.php'; ?>
