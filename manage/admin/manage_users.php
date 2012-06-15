<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_users where userid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
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
$sql = "select * from dental_users where user_access=2 order by username";
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
	Manage Users
</span>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_users.php');" class="addButton">
		Add New User
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
		<td valign="top" class="col_head" width="20%">
			Letterhead
		</td>       
		<td valign="top" class="col_head" width="10%">
			Login As
		</td>
		<td valign="top" class="col_head" width="10">
			Locations
		</td>
		<td valign="top" class="col_head" width="10%">
			Contact
		</td>
		<td valign="top" class="col_head" width="10%">
			Staff
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
			$staff_sql = "select count(userid) as staff_count from dental_users where docid='".st($myarray['userid'])."' and user_access=1";
			$staff_my = mysql_query($staff_sql) or die(mysql_error()." | ".$staff_sql);
			$staff_myarray = mysql_fetch_array($staff_my);
			
			$con_sql = "select count(contactid) as con_count from dental_contact where docid='".st($myarray['userid'])."'";
			$con_my = mysql_query($con_sql) or die(mysql_error()." | ".$con_sql);
			$con_myarray = mysql_fetch_array($con_my);

                        $loc_sql = "select count(id) as loc_count from dental_locations where docid='".st($myarray['userid'])."'";
                        $loc_my = mysql_query($loc_sql) or die(mysql_error()." | ".$loc_sql);
                        $loc_myarray = mysql_fetch_array($loc_my);
			
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
				<td valign="top">
					<a href="/manage/admin/letterhead.php?uid=<?=st($myarray["userid"]);?>">Update Images</a>
				</td>
				
				<td valign="top">
					<form action="login_as.php" method="post" target="Doctor_Login">
						<input type="hidden" name="username" value="<?=st($myarray["username"]);?>">
						<input type="hidden" name="password" value="<?=st($myarray["password"]);?>">
			            <input type="hidden" name="loginsub" value="1">
			            <input type="submit" name="btnsubmit" value=" Login " class="addButton">			
					</form>
				</td>
			           <td valign="top" align="center">
                    <a href="manage_locations.php?docid=<?=$myarray["userid"];?>" class="dellink" title="locations">
                        <?=st($loc_myarray['loc_count']);?></a>
                                </td>	
                
				<td valign="top" align="center">
                    <a href="manage_contact.php?docid=<?=$myarray["userid"];?>" class="dellink" title="contacts">
                    	<?=st($con_myarray['con_count']);?></a>
				</td>	
                
				<td valign="top" align="center">
					<a href="manage_staff.php?docid=<?=$myarray["userid"];?>" class="dellink" title="staff">
                    	<?=st($staff_myarray['staff_count']);?></a>
				</td>	
						
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_users.php?ed=<?=$myarray["userid"];?>');" class="editlink" title="EDIT">
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
