<?php include '../manage/admin/includes/config.php'; ?>
<?php require_once("twilio/twilio.config.php");

$s = "SELECT * FROM dental_patients WHERE patientid='".mysql_real_escape_string($_GET['id'])."' AND
	recover_hash='".mysql_real_escape_string($_GET['hash'])."'";
$q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);
	
                mysql_query("UPDATE dental_patients SET recover_hash='' WHERE patientid='".$r['patientid']."'");

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
      }else{
	?>
		<script type="text/javascript">
			window.location = "index.php";
		</script>
	<?php
      }

?>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<link href="css/login.css" rel="stylesheet" type="text/css" />


<div id="login_container">
  <h1>Dental Sleep Solutions</h1>




  <div class="login_content" id="first2_sect">
     <h3>Enter your access code</h3>
     <p>We sent a text message to your phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>.  Please enter the code we sent you.</p>
     <p id="first2_error" class="error"><?= $error; ?></p>
     <div class="field">
       <label>Email Address</label>
       <input value="<?= $r['email']; ?>" type="text" readonly="readonly" id="email" />
     </div>
     <div class="field">
       <label>Access Code</label>
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
    data: 'email='+e+'&code='+c+'&p='+p1,
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){  
          window.location = "login.php"; 
        }else{
          if(r.error == "code"){
                $('#first2_error').html("Access code is incorrect.  Please try again.").show('slow');   
          }else{
                $('#first2_error').html("Error.").show('slow');
          }
        }
    }
  });
  }else{
                   $('#first2_error').html("The passwords you entered don't match. Please re-enter your password.").show('slow'); 
  }

}

function checkPass(){
  var p1 = $('#password1').val();
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

