<?php session_start();

include 'includes/header.php';
//include 'includes/completed.php';
?>
<link rel="stylesheet" href="css/register.css" />
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/register_ie.css" />
<![endif]-->
<script type="text/javascript" src="js/new.js"></script>
<script type="text/javascript" src="js/patient_dob.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/register_masks.js"></script>
    <script type="text/javascript" src="lib/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="lib/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" /> 
        <script type="text/javascript">
                $(document).ready(function(){
                                //lga_fusionCharts.chart_k();
                                lga_wizard.init();

                        });
        </script>

  <?php
  //$p = mysql_fetch_assoc($q);
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
			<label class="lbl_a"><strong>2.</strong> First Name <span class="req">*</span></label>
			<input class="inpt_a validate" type="text" name="first_name" id="first_name" value="" />
		</div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>3.</strong> Last Name <span class="req">*</span></label>
                        <input class="inpt_a validate" type="text" name="last_name" id="last_name" value="" />
                </div>
                <div class="sepH_b">
                        <label class="lbl_a"><strong>4.</strong> Email: <span class="req">*</span></label><input class="inpt_a validate" type="text" id="email" name="email" value="" />
                </div>
                <div class="sepH_b clear">
                        <label class="lbl_a"><strong>5.</strong> Cell Phone: <span class="req">*</span></label><input class="inpt_a validate phonemask" type="text" id="cell_phone" name="cell_phone" value="" />
                </div>
     <div class="sepH_b clear">
        I accept the <a id="saas_agree_but" href="#saas_agree">user agreement</a> and <a id="hipaa_agree_but" href="#hipaa_agree">HIPAA agreement</a>
        <input type="checkbox"  class="validate" id="agreement" name="agreement" />
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

<div style="display:none">
<div id="saas_agree">
<h3>SAAS AGREEMENT</h3>

<h4>DENTAL SLEEP SOLUTIONS FRANCHISING LLC</h4><h4>SOFTWARE AS A SERVICE AGREEMENT </h4><p>THIS IS A LEGALLY BINDING AGREEMENT between Dental Sleep Solutions Franchising, LLC, a Florida Corporation ("we" or "us") and you, as a user of our on-line health record and patient management system (the "System").   The term "You" or "you" means the individual or entity who is using the Service under this Agreement.  BY CLICKING "CREATE ACCOUNT" OR THROUGH THE CONTINUED USE OF THE SYSTEM, YOU ARE UNDERTAKI
NG LEGAL OBLIGATIONS AND CONFERRING LEGAL RIGHTS.  Please read this agreement carefully, and do not click "Create Account" or continue use of the System unless you agree fully with its terms.  You and we are collectively referred to as the "Parties."</p>        <p>This Software as a Service Agreement (the "Agreement") is a legal agreement between you and Dental Sleep Solutions Franchising LLC, a Florida limited liability company ("Provider"), governing your
 use of the Dental Sleep Solutions Practice Manager software (the Software") as a hosted solution via Provider's web site (www.dentalsleepsolutions.com) (the "Service"). The term "You" or "you" means the individual or entity who is using the Service under this Agreement.  The term "use" means accessing, displaying, executing, loading or otherwise using the Service. </p>
        <p>Service License.  You are granted a nonexclusive, nontransferable, revocable, limited license to use the Service for your internal business purposes in accordance with this Agreement during the Term.</p>        <p>Scope of License.  This Agreement grants you up to ten (10) user accounts that will allow you to use the Service.  One (1) account will have administrative permissions, which will provide the user
 the ability to make global changes, such as password management and ledger/financial correction.  Up to nine (9) other accounts will have general use (non-administrative) permissions.  Any additional users are subject to additional fees, as determined by Provider.</p><p>Equipment.  You are responsible for and must provide all equipment, software (other than any software provided by Provider) and services necessary to use the Service.  The Software may currently be access
ed by any modern browser.  However, at some point in the future, Provider may elect to provide you with a custom browser to be installed on your computer in order to access the Software (the "Custom Browser"), for purposes of enhancing Software security.  You agree to promptly install any such Custom Browser on behalf of all users hereunder.</p><p>Privacy.  Provider will not sell, exchange, or release any confidential patient information you upload to the Service to a third party without your express permission, unless required by law or court or governmental order; provided that Provider may disclose such information to a third party to the extent necessary to perform Provider’s obligations under this Agreement and the Franchise Agreement (as defined below) (e.g. sending patient information to an insurer in connection with an insurance claim). Provider may contact you regarding account status and other matters relevant to the underlying Service and/or m
ay use your confidential information, including without limitation your patient treatment data statistics, for purposes of making suggestions and recommendations to you in connection with the relationship contemplated under the Franchise Agreement.  Both you and Provider agree to adhere to data security standards of the Health Insurance Portability and Accountability Act of 1996 ("HIPAA").</p><p>Endorsements.  All product and service marks contained on or associated with the Service that are not Provider marks are the trademarks of their respective owners. References to any names, marks, products
 or services of third parties or hypertext links to third party sites or information do not necessarily constitute or imply Provider's endorsement, sponsorship or recommendation of the third party, information, product or service. </p>        <p>Ownership.  You acknowledge and agree that the Provider company names and logos and all related product and service names, design marks and slogans (collectively, the "Marks"), and the Service, including all underlying software or other intellectual property are the property of Provider, its affiliates or its third party suppliers, as applicable.  You are not authorized to use any of the Marks in any advertising, publicity or any other commercial manner without the prior written consent of Provider, except as expressly set forth in the Franchise Agreement. Your use of the Service confers no title or own
ership in the Service, Software, Materials (as defined below) or Marks and is not a sale of any rights in the Service, Software, Materials or Marks.  All copyright, patent, trademark, trade secret and other intellectual property rights in the Software, Service, Materials and Marks remain in Provider or its third party suppliers, as the case may be.</p>
        <p>Usage Restrictions. You warrant that you will not access or use the Service in any unlawful manner, for any unlawful purpose or in violation of these terms and conditions or applicable laws, rules and regulations.  You agree that you will be responsible for all usage of the Service through your account, whether or not authorized by you.</p><p>Except to the extent permitted above, you may not: permit other individuals to use the Service; modify, translate, reverse engineer, decompile, disassemble, or create derivative works based on any product, service, information, content, software, message, advertisement or any other work found at, aggregated at, contained on, distributed through, linked to or from, downloaded to or from or in any other manner accessed from the Service, including without limitation any Custom Browser (the "Materials"); copy (including copying onto a bulletin board or similar system) the Service or Materials other than as specified herein; rent, lease, grant a security interest in, or otherwise transfer rights to the Service or Materials or remove any proprietary notices or labels on the Service and Materials. With regard to any Mate
rials in which Provider or any affiliate or third party supplier of Provider claims a proprietary interest and which are offered for downloading from the Service, you may download one copy of such Materials on any single computer for your personal or internal business use, provided you keep intact all copyright and other proprietary notices. </p><p>Your Risks.  Provider acts solely as an operator of the Service for your convenience, and use of the Service and any reliance by you upon any Materials, including any action taken by you because of such u
se or reliance, is at your sole risk.  Neither Provider nor any of its underlying suppliers, service providers, business partners, licensors, employees, distributors or agents is responsible or liable for, o
r makes any representations or warranties as to: <br />
A.      Any representations, promises, recommendations or inducements that may be made by or through any party (including vendors) found at, on, through or from the Service;<br />
B.      The timeliness, accuracy, reliability, completeness, legality, copyright compliance or decency of the Service or any Materials; <br />C.      Any inaccuracy, omission, error or delay in the Service or any Materials; <br />
D.      Nonperformance of or interruption in the Service or any Materials due to: (i) any act or omission by any disseminating party, (ii) any force majeure (i.e., flood; riot; labor dispute; accident; action of government; communications, transmissions or power failure; equipment, systems or software malfunctions) or any other cause beyond the control of any disseminating party or (iii) outages, transmission quality or malfunctions of telephone circuits or computer systems including but not limited to any defects or failures with respect to your software, computer systems or Internet access provider;<br />
E.      The quality of the Service or any Materials (including the results to be obtained from use of them); or <br />
F.      Any loss resulting from, arising out of or related to your access and/or use of or interaction with the Service or the Materials.</p>
<p>Remedies.  Your sole and exclusive remedy for any material failure or nonperformance of the Software shall be for Provider to use commercially reasonable efforts to adjust or repair the Software within a reasonable period of time, as determined by Provider.</p>
<p>LIMITATIONS OF LIABILITY.  TO THE MAXIMUM EXTENT PERMITTED BY LAW, UNDER NO CIRCUMSTANCES AND UNDER NO LEGAL THEORY, TORT, CONTRACT, OR OTHERWISE, SHALL Provider or any of its underlying SUPPLIERS, service providers, BUSINESS PARTNERS, information providers, licensors, employees, distributors or agents BE LIABLE TO YOU OR ANY OTHER PERSON FOR ANY MONEY DAMAGES, WHETHER DIRECT, INDIRECT, SPECIAL, INCIDENTAL, COVER, RELIANCE OR CONSEQUENTIAL DAMAGES, EVEN IF Provider or any of its underlying SUPPLIERS, service providers, BUSINESS PARTNERS, information providers, licensors, employees, distributors or agents SHALL HAVE BEEN INFORMED OF THE POSSIBILITY OF SUCH DAMAGES, OR FOR ANY CLAIM BY ANY OTHER PARTY.  IN THE EVENT THAT NOTWITHSTANDING THE FOREGOING, Provider or any of its underlying SUPPLIERS, service providers, BUSINESS PARTNERS, information providers, licensors, employees, distributors or agents IS FOUND LIABLE TO YOU FOR DAMAGES FROM ANY CAUSE WHATSOEVER, AND REGARDLESS OF THE FORM OF THE ACTION (WHETHER IN CONTRACT, TORT (INCLUDING NEGLIGENCE), PRODUCT LIABILITY OR OTHERWISE), the AGGREGATE LIABILITY OF SUCH PARTIES WILL BE LIMITED TO THE AMOUNT YOU PAID FOR THE SERVICE.  SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OR LIMITATION OF INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THIS LIMITATION AND EXCLUSION MAY NOT APPLY TO YOU. </p>
<p>DISCLAIMER.  EXCEPT AS EXPRESSLY SET FORTH HEREIN, THE SOFTWARE, SERVICE AND MATERIALS ARE PROVIDED "AS IS", AND PROVIDER HEREBY DISCLAIMS ALL WARRANTIES AND REPRESENTATIONS, EITHER EXPRESSED OR IMPLIED, WITH RESPECT TO THE SERVICE OR THE SOFTWARE, ITS QUALITY, PERFORMANCE, MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE OR NON-INFRINGEMENT.</p>
<p>Indemnification by You.  You shall indemnify and hold harmless Provider and any of its underlying suppliers, service providers, business partners, information providers, licensors, employees, distributors or agents from and against any and all claims, demands, actions, causes of action, suits, proceedings, losses, damages, costs, and expenses, including reasonable attorneys fees, arising from or relating to your use of the Service, or any act, error, or omission of you or any user of your account in connection therewith, including, but not limited to, matters relating to incorrect, incomplete, or misleading data or information; libel; invasion of privacy; infringement of a copyright, trade name, trademark, service mark, or other intellectual property; any defective product or any injury or damage to person or property caused by any products sold or otherwise distributed through or in connection with the Service; or violation of any applicable law.</p>
<p>Term and Termination.  The term of this Agreement (the "Term") shall be commensurate with the term of the Franchise Agreement between you and Provider, as such Agreement may be extended from time to time in accordance with its terms (the "Franchise Agreement").  Any expiration or termination of the Franchise Agreement for any reason shall automatically terminate this Agreement.  Notwithstanding the foregoing, Provider may terminate this Agreement immediately, with or without notice, if you breach any of the provisions of this Agreement.  Upon any such termination or expiration, you must discontinue all use of the Service, uninstall any Custom Browser, and immediately destroy the Materials together with all copies.  The provisions of this Agreement (other than your right to use the Service) shall survive termination or expiration of this Agreement. </p>
        <p>Export Controls.  None of the Service or underlying information or technology may be downloaded or otherwise exported or reexported (i) into (or to a national or resident of) Cuba, Iraq, Libya, Sudan, North Korea, Iran, Syria or any other country to which the U.S. has embargoed goods; or (ii) to anyone on the U.S. Treasury Department's list of Specially Designated Nationals or the U.S. Commerce Department's Table of Denial Orders. By using the Service, you are agreeing to the foregoing and you are representing and warranting that you are not located in, under the control of, or a national or resident of any such country or on any such list. In addition, you are responsible for complying with any local laws in your jurisdiction which may impact your right to import, export or use the Service, and you represent that you have complied with any regulations or registration procedures required by applicable law to make this license enforceable. </p>
        <p>General.  This Agreement constitutes the entire agreement between you and Provider with reference to this transaction.  This Agreement will be governed by the laws of the State of Florida, except for that body dealing with conflicts of law. In the event of any dispute involving this Agreement, Provider and you each consent to exclusive jurisdiction and venue in either the state or federal courts in the State of Florida and agree that the prevailing party shall be entitled to its reasonable attorney fees and costs.  In the event any provision of this Agreement shall be deemed unenforceable, void or invalid, such provision shall be modified so as to make it valid and enforceable, and as so modified the entire Agreement shall remain in full force and effect.  No decision, action or inaction by Provider shall be construed to be a waiver of any rights or remedies available to it.  This Agreement, and all rights and obligations of Provider hereunder, may be assigned by Provider in connection with any sale to a third party of the Software or Provider's business to which the Software relates.</p>
</div>
</div>

<div style="display:none">
<div id="hipaa_agree">
<h3>HIPAA AGREEMENT</h3>
<h4>Dental Sleep Solutions Franchising, LLC, User Agreement</h4>
<p>(Effective January 1, 2013)</p>
<p>THIS IS A LEGALLY BINDING AGREEMENT between Dental Sleep Solutions Franchising, LLC, a Florida Corporation ("we" or "us") and you, as a user of our on-line health record and patient management system (the "System").   The term "You" or "you" means the individual or entity who is using the Service under this Agreement.  BY CLICKING "CREATE ACCOUNT" OR THROUGH THE CONTINUED USE OF THE SYSTEM, YOU ARE UNDERTAKING LEGAL OBLIGATIONS AND CONFERRING LEGAL RIGHTS.  Please read this agreement carefully, and do not click "Create Account" or continue use of the System unless you agree fully with its terms.  You and we are collectively referred to as the "Parties."</p>
<p>THIS HIPAA PRIVACY COMPLIANCE AGREEMENT (hereinafter known as "Agreement") is made between YOU (hereinafter known as "Covered Entity") and DENTAL SLEEP SOLUTIONS FRANCHISING LLC, a Limited Liability Company, organized under the laws of the State of Florida (hereinafter known as "Business Associate"). Covered Entity and Business Associate shall collectively be known herein as "the Parties."</p>
<p>WHEREAS, Covered Entity is a health care provider whose activities are generally described as a Dental Practice;</p>
<p>WHEREAS, Business Associate is in the business of providing services to dental industry and its activities are generally described as Office Administration Support Services for the treatment of Snoring and Obstructive Sleep Apnea using Orthotic Appliance Therapy;</p>
<p>WHEREAS, Covered Entity wishes to commence a business relationship with Business Associate that shall be memorialized in a separate Franchise Agreement of even date herewith; and</p>
<p>WHEREAS, the nature of the prospective contractual relationship between Covered Entity and Business Associate may involve the exchange of Protected Health Information ("PHI") as that term is defined under the Health Insurance Portability and Accountability Act of 1996 ("HIPAA") as amended by Health Information Technology for Economic and Clinical Health Act of 2009 ("HITECH Act"), including all pertinent regulations issued by the Department of Health and Human Services ("HHS").</p>
<p>NOW, THEREFORE, the premises having been considered and with acknowledgment of the mutual promises and of other good and valuable consideration herein contained, the Parties, intending to be legally bound, hereby agree as follows:<br />
A. Definitions.<br />
1. Breach. "Breach" has the same meaning as this term has in §13400 of Health Information Technology for Economic and Clinical Health Act of 2009 ("HITECH Act").<br />
2. Business Associate. "Business Associate" shall mean DENTAL SLEEP SOLUTIONS FRANCHISING LLC.<br />
3. Covered Entity. "Covered Entity" shall mean YOU.<br />
4. Designated Record Set. "Designated Record Set" has the same meaning as this term has in 45 CFR §164.501.<br />
5. Individual. "Individual" has the same meaning as this term has in 45 CFR §164.501.<br />
6. Privacy Rule. "Privacy Rule" shall mean the Standards for Privacy of Individually Identifiable Health Information at 45 CFR Part 160 and Part 164, Subparts A and E., as amended by the HITECH Act.<br />
7. Protected Health Information. "Protected Health Information" (or "PHI") has the same meaning as this term has in 45 CFR §160.103 (as amended by the HITECH Act), limited to the information created or received by Business Associate from or on behalf of Covered Entity.<br />
8. Required By Law. "Required By Law" has the same meaning as this term has in 45 CFR §164.501.<br />
9. Secretary. "Secretary" shall mean the Secretary of the U.S. Department of Health and Human Services or his designate.<br />
10. Security Standards. "Security Standards" means the security standards for protection of PHI promulgated by the Secretary in Title 45 C.F.R.<br />
11. Unsecured Protected Health Information. "Unsecured Protected Health Information" shall mean Protected Health Information (PHI) that is not secured through the use of a technology or methodology specified by the Secretary in regulations or as otherwise defined in the §13402(h) of the HITECH Act.<br />
12. Any prospective amendment to the laws referenced in this definitional section prospectively amend this agreement to incorporate said changes by Congressional act or by regulation of the Secretary of HHS.<br />
B. Obligations and Activities of Business Associate.<br />
1. Business Associate agrees to not use or disclose Protected Health Information other than as permitted or required by the Agreement or as Required By Law.<br />
2. Business Associate agrees to employ administrative, physical, and technical safeguards meeting required Security Standards for business associates as Required By Law to prevent disclosure or use of PHI other than as allowed by this Agreement.<br />
3. Business Associate agrees to mitigate, to the extent practicable, any harmful effect that is known to Business Associate of a use or disclosure of PHI held by Business Associate in violation of the requirements of this Agreement.<br />
4. Business Associate agrees to report to Covered Entity any use or disclosure of the Protected Health Information not provided for by this Agreement of which it becomes aware.<br />
5. If a breach of unsecured protected health information occurs at or by Business Associate, the Business Associate must notify Covered Entity following the discovery of the breach without unreasonable delay and, in all cases, no later than sixty (60) days from the discovery of the breach. To the extent possible, the Business Associate should provide the Covered Entity with the identification of each individual affected by the breach as well as any information required to be provided by the Covered Entity in its notification to affected individuals. Business Associates shall comply with all regulations issued by HHS and applicable state agencies regarding breach notification to Covered Entity.<br />
6. Business Associate agrees to ensure that any agent, including a subcontractor, to whom it provides Protected Health Information received from, or created or received by Business Associate on behalf of Covered Entity agrees to the same restrictions and conditions that apply through this Agreement to Business Associate with respect to PHI.<br />
7. Business Associate agrees, at the request of Covered Entity, to provide Covered Entity (or a designate of Covered Entity) access to Protected Health Information in a Designated Record Set in prompt commercially reasonable manner in order to meet the requirements under 45 CFR §164.524.<br />
8. Business Associate agrees to make any amendment(s) to Protected Health Information in a Designated Record Set that the Covered Entity directs or agrees to pursuant to 45 CFR §164.526 at the request of Covered Entity or an Individual, in a prompt and commercially reasonable manner.<br />
9. Business Associate agrees to make internal practices, books, and records, including policies and procedures for safeguarding Protected Health Information, relating to the use and disclosure of Protected Health Information received from, or created or received by Business Associate on  behalf of, Covered Entity available to the Covered Entity, or to the Secretary (including official representatives of the Secretary), in a prompt commercially reasonable manner for purposes of determining Covered Entity's compliance with the Privacy Rule.<br />
10. Business Associate shall, upon request with reasonable notice, provide Covered Entity access to its premises for a review and demonstration of its internal practices and procedures for safeguarding PHI.<br />
11. Business Associate agrees to document such disclosures of Protected Health Information and information related to such disclosures as would be required for Covered Entity to respond to a request by an Individual for an accounting of disclosures of Protected Health Information in accordance with 45 CFR §164.528.<br />
12. Business Associate agrees to provide to Covered Entity or an Individual, in a prompt commercially reasonable manner, information collected in accordance with this Agreement, to permit Covered Entity to respond to a request by an Individual for an accounting of disclosures of Protected Health Information in accordance with 45 CFR §164.528.<br />
C. Permitted Uses and Disclosures by Business Associate.<br />
Except as otherwise limited in this Agreement, Business Associate may use or disclose Protected Health Information, as follows:<br />
1. On behalf of, Covered Entity, provided that such use or disclosure would not violate the Privacy Rule if done by Covered Entity.<br />
2. Except as otherwise limited in this Agreement, Business Associate may disclose Protected Health Information for the proper management and administration of the Business Associate, provided that disclosures are required by law, or Business Associate obtains reasonable assurances from the person to whom the information is disclosed that it will remain confidential and used or further disclosed only as required by law or for the purpose for which it was disclosed to the person, and the person notifies the Business Associate of any instances of which it is aware in which the confidentiality of the information has been breached.<br />
D. Obligations of Covered Entity.<br />
1. Covered Entity shall notify Business Associate of any limitation(s) in its notice of privacy practices of Covered Entity in accordance with 45 CFR §164.520, to the extent that such limitation may affect Business Associate's use or disclosure of Protected Health Information.<br />
2. Covered Entity shall notify Business Associate of any changes in, or revocation of, permission by Individual to use or disclose Protected Health Information, to the extent that such changes may affect Business Associate's use or disclosure of Protected Health Information.<br />
3. Covered Entity shall notify Business Associate of any restriction to the use or disclosure of Protected Health Information that Covered Entity has agreed to in accordance with 45 CFR §164.522, to the extent that such restriction may affect Business Associate's use or disclosure of Protected Health Information.<br />
4. Covered Entity shall not request Business Associate to use or disclose Protected Health Information in any manner that would not be permissible under the Privacy Rule if done by Covered  Entity. Nothing in this paragraph shall restrict the ability of Business Associate to use or disclose PHI as set forth in paragraph C.2. herein.<br />
E. Remedies in Event of Breach. <br />
Business Associate hereby recognizes that irreparable harm will result to Covered Entity, and to the business of Covered Entity, in the event of breach by Business Associate of any of the covenants and assurances contained in Paragraphs B or C of this agreement. As such, in the event of breach of any of the covenants and assurances contained in paragraphs B or C above, Covered Entity shall be entitled to enjoin and restrain Business Associate from any continued violation of Paragraphs B or C. Furthermore, in the event of breach of Paragraphs B or C by Business Associate, Covered Entity shall be entitled to reimbursement and indemnification from Business Associate for the Covered Entity's reasonable attorneys’ fees and expenses and costs that were reasonably incurred as a proximate result of the Business Associate's breach. The remedies contained in this paragraph E shall be in addition to (and not supersede) any action for damages and/or any other remedy Principal may have for breach of any part of this Agreement.<br />
F. Term and Termination.<br />
1. Term of Agreement. The Term of this Agreement shall be effective as of the date given at the top of Page 1 herein, and shall terminate when all of the Protected Health Information provided by Covered Entity to Business Associate, or created or received by Business Associate on behalf of Covered Entity, is destroyed or returned to Covered Entity, or, if it is infeasible to return or destroy Protected Health Information, protections are extended to such information, in accordance with the termination provisions in this Section.<br />
2. Termination for Cause. Upon Covered Entity's knowledge of a material breach by Business Associate, Covered Entity shall either:<br />
        a. Provide an opportunity for Business Associate to cure the breach or end the violation and terminate this Agreement if Business Associate does not cure the breach or end the violation within the time specified by Covered Entity;<br />
        b. Immediately terminate this Agreement if Business Associate has breached a material term of this Agreement and cure is not possible; or<br />
        c. If neither termination nor cure are feasible, Covered Entity shall report the violation to the Secretary.<br />
3. Effect of Termination.<br />
        a. Except as provided in paragraph E.3(b) of this section, upon termination of this Agreement, for any reason, Business Associate shall return or destroy all Protected Health Information received fro
m Covered Entity, or created or received by Business Associate on behalf of Covered Entity. This provision shall apply to Protected Health Information that is in the possession of subcontractors or agents of Business Associate. Business Associate shall retain no copies of the Protected Health Information.<br />        b. In the event that Business Associate determines that returning or destroying the Protected Health Information is infeasible, Business Associate shall provide to Covered Entity notification of the 
conditions that make return or destruction infeasible. Upon notification to Covered Entity that return or destruction of Protected Health Information is infeasible, Business Associate shall extend the protec
tions of this Agreement to such Protected Health Information and limit further uses and disclosures of such Protected Health Information to those purposes that make the return or destruction infeasible, for 
so long as Business Associate maintains such Protected Health Information.<br />
G. Miscellaneous Terms.<br />
        1. State Law. If state law applicable to the relationship between Business Associate and Covered Entity contains additional or more stringent requirements than federal law for Business Associates reg
arding any aspect of PHI privacy, then Business Associate agrees to comply with the higher standard contained in applicable state law.<br />
        2. Consideration. Business Associate recognizes that the promises it has made in this Agreement shall, henceforth, be detrimentally relied upon by Covered Entity in choosing to continue or commence a
 business relationship with Business Associate.<br />
3. Modification. This Agreement may only be modified through a writing signed by the Parties and, thus, no oral modification hereof shall be permitted. The Parties agree to take such action as is necessary t
o amend this Agreement from time to time as is necessary for Covered Entity to comply with the requirements of the Privacy Rule and the Health Insurance Portability and Accountability Act of 1996, as amended
.<br />
4. Notice to Covered Entity. Any notice required under this Agreement to be given Covered Entity shall be made via electronic communication based on the email address YOU provide.<br />
5. Notice to Business Associate. Any notice required under this Agreement to be given Business
Associate shall be made in writing to:<br />
Dental Sleep Solutions Franchising LLC, 3090 East Bay Drive, Suite 205, Holmes Beach, Florida 34217<br />
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {

        /* Using custom settings */
        
        $("a#saas_agree_but").fancybox({
                'hideOnContentClick': true
        });
        $("a#hipaa_agree_but").fancybox({
                'hideOnContentClick': true
        });
});
</script>

<?php //include 'includes/footer.php'; ?>
