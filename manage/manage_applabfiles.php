<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from filemanager_al where id='".$_REQUEST["delid"]."'";
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
$sql = "select * from filemanager_al where docid='".$_SESSION['docid']."' order by name";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_contact=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup3.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Files
</span>
<br />
<br />
&nbsp;

<div align="right">
	<button onclick="Javascript: loadPopup('add_file.php?step=step1');" class="addButton">
		Add New File
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
		<td valign="top" class="col_head" width="70%">
			Size
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
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

				$tr_class = "tr_active";

			
			$name = st($myarray['name']);
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top" width="20%">
					<a href="download.php?id=<?php echo $myarray['id']; ?>">
          <?=$name;?>
          </a>
				</td>
				<td valign="top" width="70%">
					<?php echo round(($myarray["size"]/1024), 2) . " Kb"; ?>
				</td>
				<td valign="top" width="20%">
					
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</div>
</form>


<div id="popupContact" style="height:225px;width:394px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>