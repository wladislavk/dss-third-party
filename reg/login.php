<?php namespace Ds3\Legacy; ?><?php session_start(); ?>
<?php include '../manage/admin/includes/main_include.php'; ?>
<?php include '../manage/admin/includes/password.php';
?>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/login_ie.css" />
<![endif]-->
<?php
$e = '';
if(isset($_POST['loginbut'])){
        $salt_sql = "SELECT salt FROM dental_patients WHERE email='".mysql_real_escape_string($_POST['login'])."' AND (parent_patientid IS NULL OR parent_patientid=0 OR parent_patientid='')";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);
        $pass = gen_password($_POST['password'], $salt_row['salt']);

        $check_sql = "SELECT dp.patientid, dp.email, dp.registered, du.use_patient_portal  FROM dental_patients dp INNER JOIN dental_users du ON du.userid = dp.docid where dp.status='1' && du.use_patient_portal=1 AND dp.use_patient_portal =1 AND dp.email='".mysql_real_escape_string($_POST['login'])."' and dp.password='".$pass."' ";
        $check_my = mysql_query($check_sql);
  if(mysql_num_rows($check_my) > 0){
                session_register("pid");
    $p = mysql_fetch_assoc($check_my);
                $_SESSION['pid']=$p['patientid'];
    if($p['registered'] == 1){
    ?>  
      <script type="text/javascript">
        window.location = 'index.php';
      </script>
    <?php
    }else{
    ?>  
      <script type="text/javascript">
        window.location = 'register.php';
      </script>
    <?php
    }
  }else{
    $login_error = true;
  }
  
}

?>
<div id="login_container">
  <h1>Dental Sleep Solutions</h1>
  <div class="login_content" id="login_sect">
    <h2>Patient Login</h2>
    <?php if($login_error){ ?>
      <span class="error">
	Error! Wrong email address or password.
      </span>
    <?php } ?>
    <?php if($_GET['activated']==1){ ?>
      <span class="success">
        Account created! Please login below.
      </span>

    <?php } ?>
      <FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>

    <div class="field">
      <label>Email Address</label>
      <span><a href="javascript:showSect('email');">Forgot Email</a></span>
      <input type="text" tabindex="1" name="login" value="<?=$_GET['email'];?>">
    </div>

    <div class="field">
      <label>Password</label>
      <span><a href="javascript:showSect('password');">Forgot Password</a></span>
      <input type="password" tabindex="2" name="password">
    </div>

    <div class="field">
      <button type="submit" name="loginbut" class="large">Log In</button>
      <button onclick="showSect('first1');return false;" class="fr">First time user?</button>
    </div>
	</form>
  </div>

  <div class="login_content" id="email_sect" style="display:none;">
     <h3>Forgot your email?</h3>
     <p>Can't remember the email address you used to register? Just contact the office of your Dental Sleep Solutions&reg; dentist and we'll be happy to remind you over the phone.</p>
     <div class="field">
       <button type="button" onclick="window.location='http://dentalsleepsolutions.com/pages.php?pid=1'" name="loginbut">Click here to find your dentist's phone number.</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="password_sect" style="display:none;">
     <h3>Reset Password</h3>
     <p>Enter the email address you provided us, and we'll email instructions to help reset your password.</p>
     <p id="reset_error" class="error"></p>
     <div class="field">
       <label>Email Address</label>
       <input type="text" name="email_reset" id="email_reset" />
     </div>
     <div class="field">
       <button onclick="sendInstructions('reset', this)" name="passwordbut">Send Password</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="password_sent_sect" style="display:none;">
     <h3>Password Sent!</h3>
     <p>Instructions for resetting your password have been sent to <span id="sent_email"></span> and should arrive in the next several minutes.  Just follow the instructions in that email to log in.</p>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="first1_sect" style="display:none;">
     <h3>Setup Account</h3>
     <p>Enter the email address you provided us, and we'll send you instructions to complete activation.</p>
     <p id="first1_error" class="error"></p>
     <div class="field">
       <label>Email Address</label>
       <input type="text" id="email_activate" name="email_activate" />
     </div>
     <div class="field">
       <button onclick="sendInstructions('activate', this)">Send Instructions</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="first2_sect" style="display:none;">
     <h3>Email Sent</h3>
     <p id="email_sent_text"></p>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="existing_sect" style="display:none;">
     <h3>Account Already Created</h3>
     <p>The account associated with email address <span id="existing_email"></span> has already been activated.  To log in just use the password you created.  What do you want to do?</p>
     <p id="first2_error" class="error"></p>
     <div class="field">
       <button onclick="showSect('login');">Log Me In</button>
     </div>
     <div class="field">
       <button onclick="showSect('password');">I forgot my password</button>
     </div>
  </div>

</div>
<script type="text/javascript">

$('#email_code').keyup(function(){
	$('#first1_error').hide('slow');
});

function showSect(s){
  $('.error').html('');
  $('.login_content').hide();
  $('#'+s+'_sect').show();
}

function sendInstructions(type, but){
  but.disabled = true;
  if(type == 'activate'){
    var e = $('#email_activate').val();
  }else{
    var e = $('#email_reset').val();
  }
  if(e == ''){
    $('#first1_error').html("You must enter an email address.").show('slow');
    $('#reset_error').html("You must enter an email address.").show('slow');
    but.disabled = false;
  }else{ 
   $.ajax({
    url: 'includes/send_instructions.php',
    type: 'post',
    //data: 'email='+e+'&type='+type,
    data: {email: e, type: type},
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){  
	  if(type == 'activate'){
	    txt = "An email has been sent to "+e+" with instructions to complete the process."
	  }else{
 	    txt = "An email has been sent to "+e+" with instructions to complete the password reset process. Please allow 1-2 minutes to receive this email."
	  }
          $('#email_sent_text').html(txt);
          showSect('first2');
        }else{
          if(r.error == "existing"){
                $('.existing_email').html(e);
                showSect('existing');
          }else if(r.error == "email"){
                $('#first1_error').html("Email address not found.").show('slow');
                $('#reset_error').html("Email address not found.").show('slow');
          }else if(r.error == "restricted"){
                $('#first1_error').html("User cannot be activated").show('slow');
                $('#reset_error').html("User cannot be activated.").show('slow');
           }else{
                $('#first1_error').html("Error finding email.").show('slow');   
                $('#reset_error').html("Error finding email.").show('slow');
          }
        }
	but.disabled = false;
    }
   });
  }
}

function sendAccessCode(){
  var e = $('#email_code').val();
  if(e == ''){
    $('#first1_error').html("You must enter an email address.").show('slow');
  }else{ 
   $.ajax({
    url: 'includes/send_access.php',
    type: 'post',
    data: {email: e},
    success: function( data ) {
	var r = $.parseJSON(data);
	if(r.success){	
	  $('#code_email').val(e);
	  $('#access_phone').html(r.phone);
          showSect('first2');
	}else{
	  if(r.error == "existing"){
		$('#existing_email').html(e);
		showSect('existing');
          }else if(r.error == "email"){
		$('#first1_error').html("Email address not found.").show('slow');
	  }else{
		$('#first1_error').html("Error finding email.").show('slow');	
	  }
	}
    }
   });
  }
}

function createPassword(){
  var e = $('#email_code').val();
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
          showSect('first2');
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

function recover_password(){
  var e = $('#password_email').val();
  $.ajax({
    url: 'includes/recover_password.php',
    type: 'post',
    data: {email: e},
    success: function( data ) {
        var r = $.parseJSON(data);
        if(r.success){  
	  $('#sent_email').html(e);
          showSect('password_sent');
        }else{
          if(r.error == "email"){
                $('#password_error').html("Email address not found.").show('slow');   
          }else{
                $('#password_error').html("Error.").show('slow');
          }
        }
    }
  });

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
<div style="clear:both;"></div>

<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>

