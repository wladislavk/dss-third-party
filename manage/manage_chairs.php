<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";

if(!empty($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_resources where docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND id='".$_REQUEST["delid"]."'";
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php
	die();
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_resources WHERE docid='".$_SESSION['docid']."' order by rank, name";
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
	Manage Resources
</span>
<br />
<br />
&nbsp;
<?php
$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
$r = $db->getRow($sql);
if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff'] == 1){ ?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_chair.php');" class="addButton">
		Add New Resource
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
			Resource Name
		</td>
		<td valign="top" class="col_head" width="20%">
			Resource Rank
		</td>
<?php /*		<td valign="top" class="col_head" width="60%">
			Name
		</td>
                <td valign="top" class="col_head" width="10%">
                        Producer
                </td>
*/
?>
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

			$tr_class = "tr_active";
/*			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
*/
		?>
	<tr class="<?php echo $tr_class;?>">
		<td valign="top">
			<?php echo st($myarray["name"]);?>
		</td>
		<td valign="top">
			<?php echo st($myarray["rank"]);?>
		</td>
<?php /*
				<td valign="top">
					<?php echo st($myarray["name"]);?>
				</td>
                                <td valign="top">
                                        <?php echo ($myarray["producer"]==1)?"X":''; ?>
                                </td>
*/ ?>
		<td valign="top">
		<?php
		$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
		$r = $db->getRow($sql);
		if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff'] == 1){ ?>
			<a href="Javascript:;"  onclick="Javascript: loadPopup('add_chair.php?ed=<?php echo $myarray["id"];?>');" class="editlink" title="EDIT">
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
