<? 
include "admin/includes/config.php";

if($_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1)
{?>
	<script type="text/javascript">
		window.location = 'patient_report.php';
	</script>
	<?
	die();
}

$sql = "select * from dental_patients where docid='".$_SESSION['docid']."' ";

if($_POST['d_mm'] != '')
{
	$from_date = $_POST['d_yy']."-".$_POST['d_mm']."-".$_POST['d_dd'];
	$sql .= " and adddate >= '".s_for($from_date)."' ";
}

if($_POST['d_mm1'] != '')
{
	$to_date = $_POST['d_yy1']."-".$_POST['d_mm1']."-".$_POST['d_dd1'];
	$sql .= " and adddate <= '".s_for($to_date)."' ";
}

if($_POST['referred_by'] != '')
{
	$sql .= " and referred_by = '".s_for($_POST['referred_by'])."' ";
}

$sql .= " order by lastname";
$my=mysql_query($sql) or die(mysql_error());

//echo $sql; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?> | <?=$name;?> - Ledger Card</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body onLoad="window.print(); window.close();">
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 

<span class="admin_head">
	Patient Report
</span>
<div>

<br /><br />

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" border="1" >
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="cat_head">
			<?=mysql_num_rows($my)?> Patient(s) found for 
			
			<? if($_POST['d_mm'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date From :</i>
				<?=$_POST['d_mm'];?> - <?=$_POST['d_dd'];?> - <?=$_POST['d_yy'];?>
			<? }?>
			<? if($_POST['d_mm1'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date To :</i>
				<?=$_POST['d_mm1'];?> - <?=$_POST['d_dd1'];?> - <?=$_POST['d_yy1'];?>
			<? }?>
			<? if($_POST['referred_by'] <> '') {
				$referredby_sql = "select * from dental_referredby where referredbyid='".$_POST['referred_by']."'";
				$referredby_my = mysql_query($referredby_sql) or die(mysql_error()." | ".$referredby_sql);
				$referredby_myarray = mysql_fetch_array($referredby_my);
				$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			?>
				&nbsp;&nbsp;
				<i>Referred By :</i>
				<?=$ref_name;?>
			<? }?>
		</TD>        
	</TR>
	
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="40%">
			Name
		</td>
		<td valign="top" class="col_head" width="30%">
			Referred By
		</td>
		<td valign="top" class="col_head" width="30%">
			Added Date
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
			$name = st($myarray['lastname'])." ".st($myarray['middlename'])." ".st($myarray['firstname']);
			
			$referredby_sql = "select * from dental_referredby where referredbyid='".$myarray['referred_by']."'";
			$referredby_my = mysql_query($referredby_sql) or die(mysql_error()." | ".$referredby_sql);
			$referredby_myarray = mysql_fetch_array($referredby_my);
			
			$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
                	<?=st($name);?>
				</td>
				<td valign="top">
					<?=$ref_name;?>
				</td>
				<td valign="top">
                	<?=date('m-d-Y H:m',strtotime(st($myarray["adddate"])));?>
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