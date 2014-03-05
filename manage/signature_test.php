<? 

if(isset($_POST['sign_but'])){
require_once '3rdParty/thomasjbradley-signature-to-image/signature-to-image.php';

$json = $_POST['output'];
$s = "INSERT INTO dental_user_signatures SET
	signature_json='".mysql_real_escape_string($json)."',
	user_id='".mysql_real_escape_string($_SESSION['userid'])."',
	adddate=now(),
	ip_address='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
mysql_query($s) or die(mysql_error());
$signature_id = mysql_insert_id();
$img = sigJsonToImage($json);
$file = "signature_".$_SESSION['userid']."_".$signature_id.".png";
$s = imagepng($img, '../../../shared/q_file/'.$file);
imagedestroy($img);
/*$s = "UPDATE dental_users SET
	signature_file='".mysql_real_escape_string($file)."',
	signature_json='".mysql_real_escape_string($json)."'
     WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
mysql_query($s);
*/
}
?>
<div style="clear:both;"></div>

<!--[if lt IE 9]><script src="flashcanvas.js"></script><![endif]-->
<script src="3rdParty/thomasjbradley-signature-pad/build/jquery.signaturepad.min.js"></script>
<script src="3rdParty/thomasjbradley-signature-pad/build/json2.min.js"></script>

<link rel="stylesheet" href="3rdParty/thomasjbradley-signature-pad/build/jquery.signaturepad.css">
<script type="text/javascript">
$(document).ready(function () {
  $('.sigPad').signaturePad({drawOnly:true});
});
</script>
<br /><div class="fullwidth">
<?php
$sign_sql = "SELECT * FROM dental_user_signatures WHERE user_id='".mysql_real_escape_string($_SESSION['userid'])."' ORDER BY adddate DESC LIMIT 1";
$sign_q = mysql_query($sign_sql);
$sign = mysql_fetch_assoc($sign_q);
if(file_exists('../../../shared/q_file/signature_'.$_SESSION['userid'].'_'.$sign['id'].'.png')){ ?>
  <img src='display_file.php?f=signature_<?=$_SESSION['userid'];?>_<?=$sign['id'];?>.png' />
  <a href="#" onclick="$('#update_signature').show();return false;">Update Signature</a>
  <div id="update_signature" style="display:none;">
<?php }else{ ?>
<div>
<?php } ?>
<form method="post" action="" class="sigPad" style="margin-left:20px">
  <p class="typeItDesc">Review your signature</p>
  <p class="drawItDesc">Draw your signature</p>
  <ul class="sigNav">
    <li class="clearButton"><a href="#clear">Clear</a></li>
  </ul>
  <div class="sig sigWrapper">
    <div class="typed"></div>
    <canvas class="pad" width="198" height="55"></canvas>
    <input type="hidden" name="output" class="output">
  </div>
  <button name="sign_but" type="submit">Save Signature</button>
<?php if(file_exists('../../../shared/q_file/signature_'.$_SESSION['userid'].'.png')){ ?>
  <button onclick="$('#update_signature').hide();return false;">Cancel</button>
<?php } ?>
</form>
</div>
</div>
