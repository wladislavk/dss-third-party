<?php namespace Ds3\Legacy; ?><?php include '../manage/admin/includes/main_include.php'; ?>
<?php require_once("twilio/twilio.config.php");

$s = "SELECT dp.cell_phone, dp.email FROM dental_patients dp JOIN dental_users du on du.userid=dp.docid 
        WHERE dp.patientid='".mysql_real_escape_string($_GET['id'])."' AND
                dp.recover_hash='".mysql_real_escape_string($_GET['hash'])."' AND
                dp.use_patient_portal='1' AND
                du.use_patient_portal='1'";

$q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);
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
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/login_ie.css" />
<![endif]-->

<script type="text/javascript">

function send_text(but){
  but.disabled = true;
  $.ajax({
    url: 'includes/send_access_text.php',
    type: 'post',
    data: {id: <?= $_GET['id']; ?>, hash: '<?= $_GET['hash']; ?>'},
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){  
             $('#sent_text').html("We sent a text message to your phone number ending in -<?= substr($r['cell_phone'], strlen($r['cell_phone'])-2); ?>.  Please enter the code we sent you.").show('slow');
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
  send_text($('#access_but'));
});
</script>


<div id="login_container">
  <h1>Dental Sleep Solutions</h1>




  <div class="login_content" id="first2_sect">
     <h3>Enter your access code</h3>
        <button id="access_but" onclick="send_text(this)">Text Access Code</button>

     <p id="sent_text" class="error"><?= $error; ?></p>
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
    data: {email: e, code: c, p: p1},
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

