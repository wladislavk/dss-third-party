<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once 'includes/edx_functions.php';
include_once 'includes/help_functions.php';

$userId = intval($_SESSION['userid']);
$isMainAccount = $_SESSION['docid'] == $_SESSION['userid'];
$isStaff = $db->getColumn("SELECT manage_staff FROM dental_users WHERE userid = '$userId'", 'manage_staff') == 1;

if(!empty($_REQUEST["delid"]))
{
	$l_sql = "SELECT * from dental_login WHERE userid='".$db->escape($_REQUEST['delid'])."'";
  	$logins = $db->getNumberRows($l_sql);

	if($logins == 0){
		edx_user_delete($_REQUEST['delid'], $edx_con);
		$del_sql = "delete from dental_users where userid='".$_REQUEST["delid"]."'";
	}else{
		$del_sql = "update dental_users set status=2 where userid='".$_REQUEST["delid"]."'";
	}
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"])) {
    $index_val = $_REQUEST["page"];
} else {
    $index_val = 0;
}

$i_val = $index_val * $rec_disp;
$sql = "select * from dental_users where user_access=1 and docid='".$_SESSION['docid']."' order by username";
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_users = count($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Staff
</span>
<br />
<br />
&nbsp;
<?php

if ($isMainAccount || $isStaff) { ?>
<div align="right">
	<button onclick="loadPopup('add_staff.php');" class="addButton">
		Add New Staff
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Username
		</td>
		<td valign="top" class="col_head" width="60%">
			Name
		</td>
		<td valign="top" class="col_head" width="10%">
			Producer
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<?php if($num_users == 0){ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="10" align="center">
			No Records
		</td>
	</tr>
	<?php 
	}
	else
	{
		foreach ($my as $myarray) {

			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
		?>
	<tr class="<?php echo $tr_class;?>">
		<td valign="top">
			<?php echo st($myarray["username"]);?>
		</td>
		<td valign="top">
			<?php echo st($myarray["first_name"]);?>
			<?php echo st($myarray["last_name"]);?>
		</td>
		<td valign="top">
			<?php echo ($myarray["producer"]==1)?"X":''; ?>
		</td>
		<td valign="top">
		<?php

		if ($isMainAccount || $isStaff || ($_SESSION['userid'] == $myarray['userid'])) { ?>
			<a href="Javascript:;"  onclick="loadPopup('add_staff.php?ed=<?php echo $myarray["userid"];?>');" class="editlink" title="EDIT">
				Edit 
			</a>
		<?php } ?>
		</td>
	</tr>
	<?php 	}
	}?>
</table>
</form>

<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php include "includes/bottom.htm";?>
