<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_contact where contactid='".$_REQUEST["delid"]."'";
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
$contact_type_holder = $_GET['contacttype'];
if(isset($contact_type_holder)){
$sql = "select * from dental_contact where docid='".$_SESSION['docid']."' and contacttypeid='11' order by lastname";
}else{
$sql = "select * from dental_contact where docid='".$_SESSION['docid']."' and contacttypeid='11' order by lastname";
}


$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_contact=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Contact
</span>
<br />
<br />
&nbsp;

<div style="margin-left:10px;margin-right:10px;">
<?php 
$ctype_sql = "select * from dental_contacttype where status=1 order by sortby";
$ctype_my = mysql_query($ctype_sql);
?>
<style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
<form name="jump1" style="float:left; width:350px;">
Filter by type: <select name="myjumpbox"
 OnChange="location.href=jump1.myjumpbox.options[selectedIndex].value">
     <option selected>Please Select...</option>
     <option value="manage_contact.php">Display All</option>
      <? while($ctype_myarray = mysql_fetch_array($ctype_my))
									{?>
                                    	<option value="manage_contact.php?contacttype=<?=st($ctype_myarray['contacttypeid']);?>">
                                        	<?=st($ctype_myarray['contacttype']);?>
                                        </option>
                    <?php } ?>
</select>
</form>

	<button style="margin-right:10px; float:right;" onclick="window.location.href='add_contact_insurance.php'" class="addButton">
		Add New Contact
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
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
			Name
		</td>
		<td valign="top" class="col_head" width="40%">
			Company
		</td>
		<td valign="top" class="col_head" width="30%">
			Contact Type
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	 </table>
	<div style="overflow:auto; height:400px; overflow-x:hidden; overflow-y:scroll;">
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 10px;" >
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
			
			$name = st($myarray['lastname'])." ".st($myarray['middlename']).", ".st($myarray['firstname']);
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top" width="20%">
					<?=$name;?>
				</td>
				<td valign="top" width="40%">
					<?=st($myarray["company"]);?>
				</td>
				<td valign="top" width="30%">
				<?php if($myarray["contacttypeid"] == '6'){echo "Attorney";} ?>
				<?php if($myarray["contacttypeid"] == '7'){echo "Consult";} ?>
				<?php if($myarray["contacttypeid"] == '8'){echo "Guardian";} ?>
				<?php if($myarray["contacttypeid"] == '9'){echo "Hospital";} ?>
				<?php if($myarray["contacttypeid"] == '10'){echo "Independent Medical Exam";} ?>
				<?php if($myarray["contacttypeid"] == '11'){echo "Insurance";} ?>
				<?php if($myarray["contacttypeid"] == '13'){echo "Parent";} ?>
				<?php if($myarray["contacttypeid"] == '14'){echo "Patient";} ?>
				<?php if($myarray["contacttypeid"] == '15'){echo "Provider";} ?>
				<?php if($myarray["contacttypeid"] == '16'){echo "Recall";} ?>
				<?php if($myarray["contacttypeid"] == '17'){echo "Referred From";} ?>
				<?php if($myarray["contacttypeid"] == '18'){echo "Refered To";} ?>
				<?php if($myarray["contacttypeid"] == '19'){echo "Unknown";} ?>
				<?php if($myarray["contacttypeid"] == '12'){echo "Other";} ?>
				<?php if($myarray["contacttypeid"] == '0'){echo "Type Not Set";} ?>
	      </td>
				<td valign="top" width="20%">
					<a href="add_contact_insurance.php?ed=<?=$myarray["contactid"];?>" class="editlink" title="EDIT">
						Edit 
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["contactid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</div>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>