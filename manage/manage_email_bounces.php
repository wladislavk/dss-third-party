<? 
require_once('includes/constants.inc');
include "includes/top.htm";

if(isset($_GET['rid'])){
$s = sprintf("UPDATE dental_patients SET email_bounce=0 WHERE patientid=%s AND docid=%s",$_REQUEST['rid'], $_SESSION['docid']);
mysql_query($s);
}

$rec_disp = 20;
$sql = "SELECT * from dental_patients where email_bounce=1 ORDER BY lastname ASC, firstname ASC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
  Manage Email Bounces
</span>
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head"> 
			Patient Name
		</td>
		<td valign="top" class="col_head">
			Email
		</td>
		<td valign="top" class="col_head">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="3" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
		?>
			<tr> 
				<td valign="top">
					<?=st($myarray["firstname"]);?>&nbsp;
                    <?=st($myarray["lastname"]);?> 
				</td>
				<td valign="top" class="status_<?= $myarray['status']; ?>">
					<?= $myarray["email"];?>&nbsp;
				</td>
				<td valign="top">
                                        <a href="manage_email_bounces.php?rid=<?= $myarray["patientid"]; ?>" class="editlink" title="EDIT">
                                                Remove 
                                        </a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
