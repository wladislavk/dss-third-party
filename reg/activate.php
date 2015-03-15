<?php namespace Ds3\Legacy; ?><?php include '../manage/admin/includes/main_include.php'; ?>
<?php require_once("twilio/twilio.config.php");

$s = "SELECT dp.access_type, dp.email, dp.cell_phone, du.mailing_practice, du.mailing_phone, dp.docid FROM dental_patients dp JOIN dental_users du on du.userid=dp.docid 
	WHERE dp.patientid='".mysql_real_escape_string($_GET['id'])."' AND
		dp.recover_hash='".mysql_real_escape_string($_GET['hash'])."' AND
		dp.use_patient_portal='1' AND
		du.use_patient_portal='1'";
$q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);

$loc_sql = "SELECT location FROM dental_summary where patientid='".mysql_real_escape_string($_GET['id'])."'";
$loc_q = mysql_query($loc_sql);
$loc_r = mysql_fetch_assoc($loc_q);
if($loc_r['location'] != '' && $loc_r['location'] != '0'){
  $location_query = "SELECT * FROM dental_locations WHERE id='".mysql_real_escape_string($loc_r['location'])."' AND docid='".mysql_real_escape_string($r['docid'])."'";
}else{
  $location_query = "SELECT * FROM dental_locations WHERE default_location=1 AND docid='".mysql_real_escape_string($r['docid'])."'";
}
$location_result = mysql_query($location_query);
$location_info = mysql_fetch_assoc($location_result);

  $n = $location_info['phone'];
/*
                $recover_hash = substr(hash('sha256', $r['patientid'].$r['email'].rand()), 0, 7);
                $ins_sql = "UPDATE dental_patients set access_code='".$recover_hash."' WHERE patientid='".$r['patientid']."'";
                mysql_query($ins_sql);

        // iterate over all our friends. $number is a phone number above, and $name 
        // is the name next to it
        if($r['cell_phone']!='') {
    // instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
          // Send a new outgoing SMS 
          if($send_texts){
            $sms = $client->account->sms_messages->create(
              // the number we are sending from, must be a valid Twilio number
              $twilio_number,

              // the number we are sending to - Any phone number
              $r['cell_phone'],

              // the sms body 
              "Your access code is ".$recover_hash
            );
          }
        }
*/
      }else{
		?>
			<script type="text/javascript">
				window.location = 'login.php';
			</script>
		<?php
      }

?>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="lib/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="lib/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/login_ie.css" />
<![endif]-->

<script type="text/javascript">

function send_text(from, but){
  but.disabled = true;
  $('#text_instructions').hide('slow');
  $.ajax({
    url: 'includes/send_access_text.php',
    type: 'post',
    data: {id: <?= $_GET['id']; ?>, hash: '<?= $_GET['hash']; ?>'},
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){ 
	  if(from=="button"){
	    $('#sent_text').html("Text message sent! Please allow up to 1 minute to receive the message, then enter your access code on this page.")
	  }else{ 
            $('#sent_text').html("We sent a text message to your phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>.  Please enter the code we sent you.").show('slow');
	  }
        }else{
          if(r.error == "cell"){
                $('#sent_text').html("Error: Cell phone not found.").show('slow');   
          }else if(r.error == "limit"){
                $('#sent_text').html("Error: You have exceeded the maximum number of text message access code attempts for phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>. Please wait one hour and try again.").show('slow');   
          }else if(r.error == "inactive"){
                $('#sent_text').html("Error: Text feature disabled.").show('slow');   
          }else{
                $('#sent_text').html("Error.").show('slow');
          }
        }
      but.disabled = false;
    }
  });
}


<?php
  if($r['access_type']==1){
?>
$(document).ready(function(){
  send_text("load", false);
});
<?php } ?>
</script>


<div id="login_container" class="activate">
  <div class="logos">
    <div id="company_name"><?= $r['mailing_practice']; ?></div>
    <h1>Dental Sleep Solutions</h1>
  </div>

  <div class="login_content" id="first2_sect">
     <h3>Enter your access code</h3>
     <!--<p>We sent a text message to your phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>.  Please enter the code we sent you.</p>-->
     <p id="sent_text" class="error">
	<?php
  	  if($r['access_type']==2){
	?>

	Please enter the unique PIN access code you<br />received in the box below.
	<?php }else{ ?>
	<?= $error; ?>
	<?php } ?>
	</p>
     <p id="first2_error" class="error"></p>
     <div class="field">
       <label>Email Address</label>
<?php
  if($r['access_type']==2){
?>
       <span><a href="#" onclick="$('#text_instructions').show('slow');">Didn’t receive a PIN code?</a></span>
       <div style="display:none;" id="text_instructions">
          <p>
		Didn't receive a PIN access code from <?= $r['mailing_practice']; ?>? Don't worry. Just call the office at <?= format_phone($n); ?> and ask them to provide you the PIN again. Then enter your PIN below to register.
          </p>
       </div>
	<?php }else{ ?>
       <span><a href="#" onclick="$('#text_instructions').show('slow');">Didn't receive a text message?</a></span>
       <div style="display:none;" id="text_instructions">
          <p>
		Didn't receive a text message from us? Don't worry. Click "Text Access Code" and we'll send a new text message to your phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>.
	  </p>
          <button class="fr" onclick="send_text('button', this)">Text Access Code</button>
       </div>
	<?php } ?>
       <input value="<?= $r['email']; ?>" type="text" readonly="readonly" id="email" />
     </div>
     <div class="field">
       <label>Text Message or PIN Access Code</label>
       <input type="text" id="code" name="code" />
     </div>
     <div class="field">
       <label>New Password <span style="font-size:12px">(minimum 8 characters)</span></label>
       <input type="password" onkeyup="checkPass()" id="password1" name="password1" />
     </div>
     <div class="field">
       <label>Re-type Password</label>
       <input type="password" onkeyup="checkPass()" id="password2" name="password2" />
     </div>
     <div class="field half">
        I accept the <a id="user_agree_but" href="#user_agree">user agreement</a> 
	<input type="checkbox" id="agreement" name="agreement" />
     </div>
     <div class="field half">
       <button class="fr" onclick="createPassword()">Create</button>
     </div>
     <a href="login.php">&laquo; Return to Login Screen</a>
  </div>

</div>
<div style="clear:both;"></div>

<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>

<div style="display:none">
<div id="user_agree">
<h3>PATIENT AGREEMENT</h3>
<p>Dental Sleep Solutions Franchising, LLC ("DSS") provides this patient health record website, "dentalsleepsolutions.com/patient" (the "PHR"), as a service for patients and doctors within our DSS health record network. The PHR allows patients to communicate with their doctors and dentists ("Treatment Providers"), review their health information, and access additional services. By using this site, you agree to the following User Agreement. If you do not agree to the User Agreement, do not use the PHR website.</p> 
<h4>A Note about the PHR</h4>
<p>Use of the PHR is not a substitute for the advice of your personal physician or other qualified health care professional. Always seek the advice of your physician or other qualified health care professional with any questions you may have regarding medical symptoms or a medical condition. If you think you have a medical emergency, contact your doctor or call 911.</p>
<h4>Health Information</h4>
<p>Information that you place in the PHR will be made available to your Treatment Provider, and to anyone to whom your Treatment Provider provides access to your health record. It will become a part of your Treatment Provider's health record concerning you. DSS does not claim any rights to individually identifiable health information about you, and DSS does not control your Treatment Provider's use or disclosure of your health information. Your Treatment Provider should give you a notice of privacy practices that describes how he or she uses and discloses health information about you.</p> 
<p>You and your Treatment Provider control who has access to your PHR. Access to your PHR is obtained through passwords and other personal identifiers that we provide to your Treatment Provider, and that your Treatment Provider provides to you. We do not control the distribution of those passwords. We will give access to your PHR to anyone who logs on to it using the correct passwords or personal identification numbers. You should safeguard your passwords, personal identification numbers and other logon information carefully, and not share them with anyone else. If you believe someone has had unauthorized access to your PHR, please contact Support@DentalSleepSolutions.com.</p>
<p>We will provide personally identifiable information about you to individuals to whom your Treatment Provider asks us to give the information. For example, if your Treatment Provider wishes to obtain a consultation from another provider, he or she may ask us to give the consulting provider access to your health record, and we will do so. Your Treatment Provider's ability to disclose your health information for these and similar purposes is restricted by federal law, including the Health Information Portability and Accountability Act (HIPAA). If you wish to restrict the disclosures that your Treatment Provider makes of your health information, you should make a request directly to your Treatment Provider.</p> 
<p>We may also use your health information to operate our PHR service, and we may give it to our service providers to assist us in providing PHR services. We may disclose it if we are compelled to do so by law, including valid legal process.</p>
<p>Because your PHR is part of your Treatment Provider's health record about you, you cannot delete it. You may, however, terminate your access to it. Please contact Support@DentalSleepSolutions.com if you wish to do so.</p> 
<p>In order to maintain the security of your PHR, we may log access to it, and we may maintain the log until we determine it is no longer needed.</p>
<p>Except as provided above, we will not use or disclose individually identifiable information about you to any third parties.</p> 
<p>We may use health information you place in your PHR to create de-identified information (i.e., information that does not identify you), and we may use or disclose de-identified information without restriction.</p> 
<p>We use IP addresses to analyze trends, and gather broad demographic information for aggregate use.</p> 
<h4>Additional Information</h4>
<p>DSS may provide you with general health-related information and resources, including links to third-party sites that offer information. Any such information is intended for educational purposes only, and not for diagnosis or treatment. You should consult your Treatment Provider concerning any health condition you may have, and the appropriate treatment for your condition. DSS is not responsible for the completeness, accuracy or reliability of any health-related or other information on its Internet site.</p> 
<h4>Breach Notification</h4>
<p>In the event of a breach of the security of unsecured protected health information that we maintain concerning you, we will notify your physician in accordance with our obligations under federal and state law.</p> 
<h4>Your Intellectual Property Rights</h4>
<p>DSS does not claim any ownership in any of the content, including any text, data, information, images, photographs, music, sound, video, or other individually identifiable material, that you upload, transmit or store in your PHR account. DSS maintains the right to de-identify personal information placed on its Internet site, and to use, disclose, sell and otherwise commercialize de-identified information without restriction. De-identified information is information that does not identify any individual.</p> 
<h4>Requests for Information to DSS</h4>
<p>Upon request, DSS will provide you with an electronic copy of information that you have placed in our system in an electronic format that is accessible through commercially available hardware and software. You may need to purchase the hardware and software necessary to access the information.</p> 
<h4>Revisions, changes, and updates to Policy</h4>
<p>DSS may revise and update this Privacy Policy at any time, without notice to you. Revisions will apply to information placed in the system prior to the revision. Your continued usage of the PHR will mean you accept those changes. We encourage you to periodically reread this Privacy Policy, to see if there have been any changes to our policies that may affect you.</p> 
<h4>Links</h4>
<p>The PHR website provides links to other websites that are not owned or controlled by DSS. DSS is not responsible for the content, security or the privacy practices of these external sites. Please review the privacy statement and any terms of use of each website you visit.</p> 
<h4>Access, correction, and data integrity</h4> 
<p>Although DSS attempts to maintain the accuracy of the information featured on the PHR site, we make no guarantees as to its currency, completeness, or accuracy. The PHR may contain typographical errors, inaccuracies, or other errors or omissions. Requests to correct health information displayed within the PHR should be submitted directly to your Treatment Provider's office.</p> 
<h4>Use of Site by children</h4>
<p>We have no intention of accepting information from users under the age of 18. Please leave this site immediately if you under 18.</p> 
<h4>User participation in online services</h4>
<p>Patients may use the PHR to view certain information reported by their Treatment Provider's DSS medical records, including medical history, appointments, and other content.</p> 
<p>In addition, although this PHR displays certain information from your medical records, it does not necessarily display all information found in your medical history. If you think that your medical record information displayed on the PHR is inaccurate, you should contact your Treatment Provider's office. To request a complete copy of your medical record, please contact your Treatment Provider's office directly.</p> 
<p>DSS provides you with a number of interactive online services to help you better manage your health. These services include the ability to securely communicate and transmit requests to your Treatment Provider's offices. You agree that you will not upload or transmit any content that infringes upon, misappropriates or violates any rights of any party.</p> 
<p>In consideration of being allowed to use DSS's PHR services, you agree that the following actions shall constitute a breach of the User Agreement:</p> 
* signing on as or pretending to be another person <br />
* using secure messaging for any purpose in violation of local, state, national, international laws<br /> 
* transmitting material that infringes or violates the intellectual property rights of others or the privacy or publicity rights of others<br /> 
* transmitting material that is unlawful, obscene, defamatory, predatory of minors, threatening, harassing, abusive, slanderous, or hateful to any person 
* using interactive services in a way that is intended to harm, or a reasonable person would understand would likely result in harm, to the user or others<br /> 
* collecting information about others, including email addresses <br />
* intentionally distributing viruses or other harmful computer code <br />
* The use or proliferation of ad-blocking software or any other mechanism that distorts or otherwise alters advertisements within the PHR<br /> 
<p>DSS and its network of medical providers expressly reserve the right, in their sole discretion, to terminate a user's access to any PHR services and/or to any or all other areas of the PHR for any reason, at any time, without additional notice or warnings to the user. To deactivate your PHR account, please contact our support team at Support@DentalSleepSolutions.com.</p> 
<h4>Disclaimer</h4>
<p>THIS PHR AND ITS CONTENT AND ALL WEBSITE-RELATED SERVICES ARE PROVIDED "AS IS," WITH ALL FAULTS, WITH NO REPRESENTATIONS OR WARRANTIES OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE OR NON-INFRINGEMENT. YOU ASSUME TOTAL RESPONSIBILITY AND RISK FOR YOUR USE OF THIS SITE, ALL SITE-RELATED SERVICES, AND THIRD PARTY WEB SITES. NO ORAL OR WRITTEN INFORMATION OR ADVICE GIVEN BY DSS OR ITS AUTHORIZED REPRESENTATIVES SHALL CREATE A WARRANTY OF ANY KIND. ANY REFERENCES TO SPECIFIC PRODUCTS OR SERVICES ON THIS PHR DO NOT CONSTITUTE OR IMPLY A RECOMMENDATION OR ENDORSEMENT BY DSS UNLESS SPECIFICALLY STATED OTHERWISE.</p> 
<h4>Limitation of liability; choice of law</h4>
<p>DSS AND ITS AFFILIATES, SUPPLIERS, AND OTHER THIRD PARTIES MENTIONED OR LINKED TO ON THIS WEBSITE ARE NEITHER RESPONSIBLE NOR LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, CONSEQUENTIAL, SPECIAL, EXEMPLARY, PUNITIVE, OR OTHER DAMAGES (INCLUDING, WITHOUT LIMITATION, THOSE RESULTING FROM LOST PROFITS, LOST DATA, OR BUSINESS INTERRUPTION) ARISING OUT OF OR RELATING IN ANY WAY TO THE WEBSITE, SITE-RELATED SERVICES AND PRODUCTS, CONTENT OR INFORMATION CONTAINED WITHIN THE WEBSITE, AND/OR ANY THIRD PARTY WEBSITE, WHETHER BASED ON WARRANTY, CONTRACT, TORT, OR ANY OTHER LEGAL THEORY AND WHETHER OR NOT ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. YOUR SOLE REMEDY FOR DISSATISFACTION WITH THE WEBSITE, SITE-RELATED SERVICES, AND/OR THIRD PARTY WEBSITES IS TO STOP USING THE WEBSITE AND/OR THOSE SERVICES. APPLICABLE LAW MAY NOT ALLOW THE EXCLUSION OR LIMITATION OF INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE ABOVE LIMITATION OR EXCLUSION MAY NOT APPLY TO YOU. THESE TERMS AND CONDITIONS ARE GOVERNED BY FLORIDA LAW WITHOUT REGARD TO ITS PRINCIPLES OF CONFLICTS OF LAW. IF ANY VERSION OF THE UNIFORM COMPUTER INFORMATION TRANSACTIONS ACT (UCITA) IS ENACTED AS PART OF THE LAW OF FLORIDA, THAT STATUTE SHALL NOT GOVERN ANY ASPECT OF THESE TERMS AND CONDITIONS.</p> 
<h4>ARBITRATION</h4>
<p>ANY DISPUTE, CLAIM OR CONTROVERSY ARISING OUT OF OR RELATING TO THIS NOTICE OR THE BREACH, TERMINATION, ENFORCEMENT, INTERPRETATION OR VALIDITY THEREOF, INCLUDING THE DETERMINATION OF THE SCOPE OR APPLICABILITY OF THIS AGREEMENT TO ARBITRATE, OR TO YOUR USE OF THIS SITE OR THE SYSTEMS OR INFORMATION TO WHICH IT GIVES ACCESS, SHALL BE DETERMINED BY ARBITRATION IN HOLMES BEACH, FLORIDA, BEFORE A SINGLE ARBITRATORS. THE ARBITRATION SHALL BE ADMINISTERED BY JAMS PURSUANT TO ITS COMPREHENSIVE ARBITRATION RULES AND PROCEDURES. JUDGMENT ON THE AWARD MAY BE ENTERED IN ANY COURT HAVING JURISDICTION. THIS CLAUSE SHALL NOT PRECLUDE PARTIES FROM SEEKING PROVISIONAL REMEDIES IN AID OF ARBITRATION FROM A COURT OF APPROPRIATE JURISDICTION.</p> 
</div>
</div>

<script type="text/javascript">

$(document).ready(function() {

	/* Using custom settings */
	
	$("a#user_agree_but").fancybox({
		'hideOnContentClick': true
	});
});

function createPassword(){
  var e = $('#email').val();
  var c = $('#code').val();
  var p1 = $('#password1').val();
  var p2 = $('#password2').val();
  var agreement = $('#agreement').is(':checked');
  if(p1.length < 8){
    $('#first2_error').html("Password must be at least 8 characters in length.").show('slow');
  }else if(!agreement){
    $('#first2_error').html("User Agreement must be accepted.").show('slow');
  }else if(p1 == p2){
  $.ajax({
    url: 'includes/setup_user.php',
    type: 'post',
    data: {email: e, code: c, p: p1},
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){  
          window.location = "register.php"; 
        }else{
          if(r.error == "code"){
                $('#sent_text').html("Incorrect text message code!").show('slow');   
          }else{
                $('#sent_text').html("Error.").show('slow');
          }
        }
    }
  });
  }else{
                   $('#sent_text').html("Passwords don't match!").show('slow'); 
  }

}

function checkPass(){
  var p1 = $('#password1').val();
  var p2 = $('#password2').val();
if(p1.length < 8){
  $('#password1').addClass('pass_invalid');
  $('#password1').removeClass('pass_valid');
}else{
  $('#password1').addClass('pass_valid');
  $('#password1').removeClass('pass_invalid');
}
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
