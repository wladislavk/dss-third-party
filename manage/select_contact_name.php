<? 
include "admin/includes/main_include.php";

$rec_disp = 40;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_contact where docid='".$_SESSION['docid']."' order by lastname";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_contact=mysql_num_rows($my);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
	    <td> 
<br />
<span class="admin_head">
	Select Contact
</span>
<br />&nbsp;

<form name="selfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
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
		<td valign="top" class="col_head" width="20%">
			Company
		</td>
		<td valign="top" class="col_head" width="50%">
			Type
		</td>
		<td valign="top" class="col_head" width="10%">
			Select
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
			$contype_sql = "SELECT * FROM dental_contacttype where status=1 and contacttypeid='".s_for($myarray['contacttypeid'])."' ";
			$contype_my = mysql_query($contype_sql) or die($contype_sql." | ".mysql_error());
			$contype_myarray = mysql_fetch_array($contype_my);
			
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
				<td valign="top">
                	<?=$name;?>
				</td>
				<td valign="top">
					<?=st($myarray["company"]);?>
				</td>
				<td valign="top">
					<?=st($contype_myarray["contacttype"]);?>
				</td>
				<td valign="top" align="center">
					<input type="radio" name="sel_con" value="<?=st($name);?>" onclick="fill_up(this.value)" />
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>
<script type="text/javascript">
	function fill_up(fa)
	{
		parent.document.<?=$_GET['fr'];?>.<?=$_GET['tx'];?>.value = fa;
		parent.disablePopupRefClean();
	}
</script>

<br /><br />	

			</td>
		</tr>
	</table>
    

</body>
</html>
