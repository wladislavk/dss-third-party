<?php include '../manage/admin/includes/config.php'; ?>
<?php require_once("twilio/twilio.config.php");

$s = "SELECT dp.email, dp.cell_phone FROM dental_patients dp JOIN dental_users du on du.userid=dp.docid 
	WHERE dp.patientid='".mysql_real_escape_string($_GET['id'])."' AND
		dp.recover_hash='".mysql_real_escape_string($_GET['hash'])."' AND
		dp.use_patient_portal='1' AND
		du.use_patient_portal='1'";
$q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);
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
<link href="css/login.css" rel="stylesheet" type="text/css" />
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

$(document).ready(function(){
  send_text("load", false);
});
</script>

<div id="login_container">
  <h1>Dental Sleep Solutions</h1>




  <div class="login_content" id="first2_sect">
     <h3>Enter your access code</h3>
     <!--<p>We sent a text message to your phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>.  Please enter the code we sent you.</p>-->
     <p id="sent_text" class="error"><?= $error; ?></p>
     <div class="field">
       <label>Email Address</label>
       <span><a href="#" onclick="$('#text_instructions').show('slow');">Didn't receive a text message?</a></span>
       <div style="display:none;" id="text_instructions">
          <p>
		Didn't receive a text message from us? Don't worry. Click here and we'll send a new text message to your phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>.
	  </p>
          <button class="fr" onclick="send_text('button', this)">Text Access Code</button>
       </div>
       <input value="<?= $r['email']; ?>" type="text" readonly="readonly" id="email" />
     </div>
     <div class="field">
       <label>Text Message Access Code</label>
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
     <div class="field">
       <button onclick="createPassword()">Create</button>
     </div>
     <a href="login.php">&laquo; Return to Login Screen</a>
  </div>

</div>
<div style="clear:both;"></div>

<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>


<script type="text/javascript">

function createPassword(){
  var e = $('#email').val();
  var c = $('#code').val();
  var p1 = $('#password1').val();
  var p2 = $('#password2').val();
  if(p1.length < 8){
    $('#first2_error').html("Password must be at least 8 characters in length.").show('slow');
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

