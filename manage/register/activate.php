<?php include '../admin/includes/config.php'; ?>
<?php require_once("../../reg/twilio/twilio.config.php");

$status_sql = "SELECT status FROM dental_users where userid='".mysql_real_escape_string($_GET['id'])."'";
$status_q = mysql_query($status_sql);
$status_r = mysql_fetch_assoc($status_q);
if($status_r['status']==1){
  ?>
  <script type="text/javascript">
    window.location = "../login.php";
  </script>
  <?php
  die();
}

$s = "SELECT du.email, du.phone FROM dental_users du 
	WHERE du.userid='".mysql_real_escape_string($_GET['id'])."' AND
		du.recover_hash='".mysql_real_escape_string($_GET['hash'])."' AND
		du.status='2'";
$q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);
      }else{
		?>
		<h3 style="font-family:Helvetica, Arial, sans-serif;">We are unable to find the page you attempted to access. Please contact Dental Sleep Solutions&reg; for assistance.</h3>
		<?php
		die();
      }

?>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<link href="css/login.css" rel="stylesheet" type="text/css" />
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
            $('#sent_text').html("We sent a text message to your phone number ending in -<?= substr($r['phone'], strlen($r['phone'])-2); ?>.  Please enter the code we sent you.").show('slow');
	  }
        }else{
          if(r.error == "cell"){
                $('#sent_text').html("Error: Cell phone not found.").show('slow');   
          }else if(r.error == "limit"){
                $('#sent_text').html("Error: You have exceeded the maximum number of text message access code attempts for phone number ending in -<?= substr($r['phone'], strlen($r['phone'])-2); ?>. Please wait one hour and try again.").show('slow');   
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
     <!--<p>We sent a text message to your phone number ending in -<?= substr($r['phone'], strlen($r['phone'])-2); ?>.  Please enter the code we sent you.</p>-->
     <p id="sent_text" class="error"><?= $error; ?></p>
     <div class="field">
       <label>Email Address</label>
       <span><a href="#" onclick="$('#text_instructions').show('slow');">Didn't receive a text message?</a></span>
       <div style="display:none;" id="text_instructions">
          <p>
		Didn't receive a text message from us? Don't worry. Click here and we'll send a new text message to your phone number ending in -<?= substr($r['phone'], strlen($r['phone'])-2); ?>.
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
       <button onclick="register()">Register</button>
     </div>
  </div>

</div>
<div style="clear:both;"></div>

<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>

<script type="text/javascript">

function register(){
  var e = $('#email').val();
  var c = $('#code').val();
  $.ajax({
    url: 'includes/setup_register.php',
    type: 'post',
    data: {email: e, code: c },
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

}
</script>
