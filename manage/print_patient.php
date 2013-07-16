<? include "admin/includes/main_include.php";

$sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and status='".$_GET['st']."' order by lastname, firstname";
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

if($_GET['st'] == 1) {
	$st_disp = 'Active';
} else {
	$st_disp = 'In-Active';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?> | <?=$st_disp;?> Patient</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body onLoad="window.print(); parent.disablePopup1();">
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 
	
<span class="admin_head">
	<?=$st_disp;?> Patient
</span>
<br />
<br />
&nbsp;

<b> Total Records: <?=$num_users;?></b>
<table width="98%" cellpadding="5" cellspacing="1" border="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="60%">
			Name
		</td>
		<td valign="top" class="col_head" width="20%">
			City
		</td>
		<td valign="top" class="col_head" width="20%">
			Home phone
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
			$tr_class = "tr_active";
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["lastname"]);?>&nbsp;
                    <?=st($myarray["middlename"]);?>,&nbsp;
                    <?=st($myarray["firstname"]);?> 
				</td>
                <td valign="top">
                	<?=st($myarray["city"]);?>&nbsp;
                </td>
                <td valign="top">
                	<?=st($myarray["home_phone"]);?>&nbsp;
                </td>
			</tr>
	<? 	}
	}?>
</table>

<br /><br />	

	</td>
</tr>
</table>
</body>
</html>