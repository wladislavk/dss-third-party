<?php namespace Ds3\Legacy; ?><? 
include "includes/top.htm";
?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Legal Documents	
</span>
<br />
<br />
&nbsp;
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<div class="fullwidth">
<?php include 'legal_hipaa.php';
include 'legal_user.php'; ?>
</div>

<div id="popupContact" style="width:750px;height:460px">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>



