<? 
include "includes/top.htm";

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	View Manuals
</span>
<br />
<br />
<?php if(isset($_GET['msg'])){ ?>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<?php } ?>
 <style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
		 	Manual
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
		<?php if($_SESSION['user_type'] == DSS_USER_TYPE_FRANCHISEE){ ?>
			<tr class="tr_active">
				<td valign="top">
					DSS Franchisee Operations Manual	
				</td>
				<td valign="top">
					<a href="operations_manual.php" class="editlink" title="EDIT">
						View
					</a>
				</td>
			</tr>
		<?php } ?>
                        <tr class="tr_active">
                                <td valign="top">
					Dental Sleep Solutions Procedures Manual
                                </td>
                                <td valign="top">
                                        <a href="manual.php" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
