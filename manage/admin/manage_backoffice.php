<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && is_admin($_SESSION['admin_access']))
{
	$del_sql = "delete from admin where adminid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);

	mysql_query("DELETE FROM admin_company WHERE adminid='".$_REQUEST["delid"]."'");
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){
  $sql = "select a.*, c.id as company_id, c.name as company_name
	 from admin a
	LEFT join admin_company ac ON a.adminid=ac.adminid
	LEFT JOIN companies c ON ac.companyid=c.id";
  if(isset($_GET['cid'])){
    $sql .= " WHERE c.id=".mysql_real_escape_string($_GET['cid'])." ";
  }
}elseif(is_admin($_SESSION['admin_access'])){
  $sql = "select a.*, c.id as company_id, c.name as company_name
         from admin a
        LEFT join admin_company ac ON a.adminid=ac.adminid
        LEFT JOIN companies c ON ac.companyid=c.id";
    $sql .= " WHERE c.id=".mysql_real_escape_string($_SESSION['companyid'])." ";
}
$sql .= " order by admin_access ASC, username ASC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Backoffice Users
</span>
<br />
<br />
<?php
  if(isset($_GET['cid'])){
?>
<div style="float:left; margin-left:20px;">
        <a href="manage_backoffice.php" class="addButton">
                View All 
        </a>
        &nbsp;&nbsp;
</div>
<?php
  }
?>

<div align="right">
	<button onclick="Javascript: loadPopup('add_backoffice_users.php');" class="addButton">
		Add New Backoffice User
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Username	
		</td>
		<td valign="top" class="col_head" width="20%">
			Name
		</td>
		<?php if(is_super($_SESSION['admin_access'])){ ?>
		<td valign="top" class="col_head" width="20%">
			Company
		</td>
		<?php } ?>
		<td valign="top" class="col_head" width="20%">
			Permissions
		</td>
		<td valign="top" class="col_head" width="10%">
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
			if($myarray["admin_access"] == 1)
			{
				$tr_class = "tr_super";
			}
			elseif($myarray["admin_access"] == 2)
			{
				$tr_class = "tr_admin";
			}
                        else
                        {
                                $tr_class = "tr_basic";
                        }

		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
				                <?php if(is_super($_SESSION['admin_access'])){ ?>
				<td valign="top">
					<a href="manage_backoffice.php?cid=<?= $myarray["company_id"]; ?>"><?= $myarray["company_name"]; ?></a>
				</td>
						<?php } ?>
                                <td valign="top">               
					<?= $dss_admin_access_labels[$myarray["admin_access"]]; ?>
                                </td>		
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_backoffice_users.php?ed=<?=$myarray["adminid"];?>');" class="editlink" title="EDIT">
						Edit
					</a>
                    
				</td>
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
