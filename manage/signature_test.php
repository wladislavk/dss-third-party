<? 
include "includes/top.htm";
include_once "includes/constants.inc";

if(isset($_POST['sign_but'])){
require_once '3rdParty/thomasjbradley-signature-to-image/signature-to-image.php';

$json = $_POST['output'];
$img = sigJsonToImage($json);

$s = imagepng($img, 'q_file/signature.png');
imagedestroy($img);


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


<form method="post" action="" class="sigPad" style="margin-left:20px">
  <label for="name">Print your name</label>
  <input type="text" name="name" id="name" class="name">
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
  <button name="sign_but" type="submit">I accept the terms of this agreement.</button>
</form>





<?php
include 'includes/bottom.htm';
?>
