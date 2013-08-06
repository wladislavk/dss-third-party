<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$l_sql = "SELECT * from dental_login WHERE userid='".mysql_real_escape_string($_REQUEST['delid'])."'";
  	$l_q = mysql_query($l_sql);
  	$logins = mysql_num_rows($l_q);

	if($logins == 0){

	  $u_sql = "SELECT username FROM dental_users where userid='".mysql_real_escape_string($_REQUEST['delid'])."'";
	  $u_q = mysql_query($u_sql);
	  $user = mysql_fetch_assoc($u_q);
          $nv_sql = "SELECT n.nid, n.vid, u.uid FROM node n
                        JOIN users u ON n.uid = u.uid
                        WHERE n.type='profile' AND u.name='".$user['username']."'";
          $nv_q = mysql_query($nv_sql, $course_con);
          $nv_r = mysql_fetch_assoc($nv_q);
	  $uid = $nv_r['uid'];
          $nid = $nv_r['nid'];
          $vid = $nv_r['vid'];
	  
	  $d_sql = "DELETE FROM content_type_profile
			WHERE
				nid='".mysql_real_escape_string($nid)."' AND
				vid='".mysql_real_escape_string($vid)."'";
	  mysql_query($d_sql, $course_con);

	  $d_sql = "DELETE FROM node WHERE uid='".mysql_real_escape_string($uid)."' AND type='profile'";
	  mysql_query($d_sql, $course_con);  
	  
          $d_sql = "DELETE FROM users WHERE uid='".mysql_real_escape_string($uid)."'";
          mysql_query($d_sql, $course_con);
 
	  $del_sql = "delete from dental_users where userid='".$_REQUEST["delid"]."'";
	}else{
          $del_sql = "update dental_users set status=2 where userid='".$_REQUEST["delid"]."'";
	}
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
$sql = "select * from dental_users where user_access=1 and docid='".$_SESSION['docid']."' order by username";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Staff
</span>
<br />
<br />
&nbsp;
<?php
$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff'] == 1){
?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_staff.php');" class="addButton">
		Add New Staff
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
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
					<?=st($myarray["first_name"]);?>
					<?=st($myarray["last_name"]);?>
				</td>
                                <td valign="top">
                                        <?= ($myarray["producer"]==1)?"X":''; ?>
                                </td>
				<td valign="top">
<?php
$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff'] == 1){
?>

					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_staff.php?ed=<?=$myarray["userid"];?>');" class="editlink" title="EDIT">
						Edit 
					</a>
<?php } ?>                    
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
