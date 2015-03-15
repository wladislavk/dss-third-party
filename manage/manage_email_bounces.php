<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";
include_once('includes/constants.inc');

if(isset($_GET['rid'])){
	$s = sprintf("UPDATE dental_patients SET email_bounce=0 WHERE patientid=%s AND docid=%s",$_REQUEST['rid'], $_SESSION['docid']);
	$db->query($s);
}

$rec_disp = 20;
$sql = "SELECT * from dental_patients where email_bounce=1 AND docid=".mysqli_real_escape_string($con,$_SESSION['docid'])." ORDER BY lastname ASC, firstname ASC";
$total_rec = $db->getNumberRows($sql);
$my = $db->getResults($sql);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Email Bounces
</span>
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>


<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<tr class="tr_bg_h">
			<td valign="top" class="col_head"> 
				Patient Name
			</td>
			<td valign="top" class="col_head">
				Problem Email Address
			</td>
			<td valign="top" class="col_head">
				Action
			</td>
		</tr>
<?php 
if(count($my) == 0){ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="3" align="center">
				No Records
			</td>
		</tr>
		<?php 
} else {
	foreach ($my as $myarray) {?>
		<tr> 
			<td valign="top">
				<a href="add_patient.php?pid=<?php echo $myarray["patientid"]; ?>&ed=<?php echo $myarray["patientid"]; ?>">
					<?php echo st($myarray["firstname"]);?>&nbsp;
					<?php echo st($myarray["lastname"]);?> 
				</a>
			</td>
			<td valign="top" class="status_<?php echo $myarray['status']; ?>">
				<?php echo $myarray["email"];?>&nbsp;
			</td>
			<td valign="top">
				<a href="manage_email_bounces.php?rid=<?php echo $myarray["patientid"]; ?>" class="editlink" title="EDIT">
					Remove 
				</a>
			</td>
		</tr>
<?php
	}
}?>
	</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
