<?php session_start(); ?>
<?php include '../manage/admin/includes/config.php'; ?>
<?php include '../manage/admin/includes/password.php';
?>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<?php
$e = '';
if(isset($_POST['loginbut'])){
        $salt_sql = "SELECT salt FROM dental_patients WHERE email='".mysql_real_escape_string($_POST['login'])."'";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);
        $pass = gen_password($_POST['password'], $salt_row['salt']);

        $check_sql = "SELECT patientid, email, registered  FROM dental_patients where email='".mysql_real_escape_string($_POST['login'])."' and password='".$pass."' ";
        $check_my = mysql_query($check_sql);
  if(mysql_num_rows($check_my) > 0){
                session_register("pid");
    $p = mysql_fetch_assoc($check_my);
                $_SESSION['pid']=$p['patientid'];
    if($p['registered'] == 1){
    ?>  
      <script type="text/javascript">
        window.location = 'home.php';
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
    $e = "Invalid login information";
  }
  
}

?>
<div id="login_container">
  <h1>Dental Sleep Solutions</h1>
  <div class="login_content" id="login_sect">
    <h2>Patient Login</h2>
      <FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>

    <div class="field">
      <label>Email Address</label>
      <span><a href="javascript:showSect('email');">Forgot Email</a></span>
      <input type="text" name="login">
    </div>

    <div class="field">
      <label>Password</label>
      <span><a href="javascript:showSect('password');">Forgot Password</a></span>
      <input type="password" name="password">
    </div>

    <div class="field">
      <button type="submit" name="loginbut">Log In</button>
      <button onclick="showSect('first1');return false;" class="fr">First time?</button>
    </div>
	</form>
  </div>

  <div class="login_content" id="email_sect" style="display:none;">
     <h3>Forgot your email?</h3>
     <p>Can't remember the email address you used to register? Just contact the office of your Dental Sleep Solutions&reg; dentist and we'll be happy to remind you over the phone.</p>
     <div class="field">
       <button type="button" name="loginbut">Click here to find your dentist's phone number.</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="password_sect" style="display:none;">
     <h3>Reset Password</h3>
     <p>Enter the email address you provided us, and we'll email instructions to help reset your password.</p>
     <div class="field">
       <label>Email Address</label>
       <input type="text" name="email" />
     </div>
     <div class="field">
       <button type="submit" name="passwordbut">Send Password</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="first1_sect" style="display:none;">
     <h3>Setup Account</h3>
     <p>Enter the email address you provided us, and we'll text you an access code to enter on the next screen.</p>
     <p id="first1_error" class="error"></p>
     <div class="field">
       <label>Email Address</label>
       <input type="text" id="email_code" name="email_code" />
     </div>
     <div class="field">
       <button onclick="sendAccessCode()">Send Code</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

  <div class="login_content" id="first2_sect" style="display:none;">
     <h3>Enter code</h3>
     <p>Enter the access code we texted you.</p>
     <p id="first2_error" class="error"></p>
     <div class="field">
       <label>Access Code</label>
       <input type="password" id="code" name="code" />
     </div>
     <div class="field">
       <label>New Password</label>
       <input type="password" onkeyup="checkPass()" id="password1" name="password1" />
     </div>
     <div class="field">
       <label>Re-type Password</label>
       <input type="password" onkeyup="checkPass()" id="password2" name="password2" />
     </div>
     <div class="field">
       <button onclick="createPassword()">Create</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

</div>
<script type="text/javascript">

$('#email_code').keyup(function(){
	$('#first1_error').hide('slow');
});

function showSect(s){
  $('.login_content').hide();
  $('#'+s+'_sect').show();
}

function sendAccessCode(){
  var e = $('#email_code').val();
  $.ajax({
    url: 'includes/send_access.php',
    type: 'post',
    data: 'email='+e,
    success: function( data ) {
	var r = $.parseJSON(data);
	if(r.success){	
          showSect('first2');
	}else{
	  if(r.error == "email"){
		$('#first1_error').html("The entered email address is not associated with any accounts.").show('slow');
	  }else{
		$('#first1_error').html("Error finding email.").show('slow');	
	  }
	}
    }
  });
}

function createPassword(){
  var e = $('#email_code').val();
  var c = $('#code').val();
  var p1 = $('#password1').val();
  var p2 = $('#password2').val();
  if(p1 == p2){
  $.ajax({
    url: 'includes/setup_user.php',
    type: 'post',
    data: 'email='+e+'&code='+c+'&p='+p1,
    success: function( data ) {
	var r = $.parseJSON(data);
        if(r.success){  
          showSect('first2');
        }else{
          if(r.error == "code"){
		$('#first2_error').html("Incorrect access code entered.").show('slow');	
          }else{
		$('#first2_error').html("Error.").show('slow');
	  }
	}
    }
  });
  }else{
                   $('#first2_error').html("Passwords do not match.").show('slow'); 
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
<div style="clear:both;"></div>

<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>

