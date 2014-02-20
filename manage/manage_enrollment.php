<? 
include "includes/top.htm";
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Enrollment
</span>
<br />
<br />
&nbsp;

<div style="margin-left:10px;margin-right:10px;">
	<button style="margin-right:10px; float:right;" onclick="loadPopup('add_enrollment.php')" class="addButton">
		Add New Enrollment
	</button>
	&nbsp;&nbsp;
</div>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
  <thead>
    <tr class="tr_bg_h">
      <th>Payer</th>
      <th>Status</th>
      <th>Response</th>	  
  </thead>
		<?php
		while($myarray = mysql_fetch_array($my))
		{
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top" width="20%">
					<?=$myarray['payer_id']?>
				</td>
				<td valign="top" width="25%">
					<?=st($myarray["status"]);?>
				</td>
				<td valign="top" width="10%">
                   			<?= $myarray["response"]; ?> 
				</td>
			</tr>
	<? 	}
	?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
<div id="popupRefer" style="height:550px; width:750px;">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>
<br /><br />	
<? include "includes/bottom.htm";?>
