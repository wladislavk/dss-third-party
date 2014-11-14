<?php  
include "admin/includes/main_include.php";

if(isset($_POST['dailysub']) && $_POST['dailysub'] != 1 && isset($_POST['monthlysub']) && $_POST['monthlysub'] != 1)
{?>
	<script type="text/javascript">
		window.location = 'patient_report.php';
	</script>
	<?php 
	die();
}

$sql = "select * from dental_patients where docid='".$_SESSION['docid']."' ";

if($_POST['d_mm'] != ''){
	$from_date = $_POST['d_yy']."-".$_POST['d_mm']."-".$_POST['d_dd'];
	$sql .= " and adddate >= '".s_for($from_date)."' ";
}

if($_POST['d_mm1'] != ''){
	$to_date = $_POST['d_yy1']."-".$_POST['d_mm1']."-".$_POST['d_dd1'];
	$sql .= " and adddate <= '".s_for($to_date)."' ";
}

if($_POST['referred_by'] != ''){
	$sql .= " and referred_by = '".s_for($_POST['referred_by'])."' ";
}

$sql .= " order by lastname";
$my = $db->getResults($sql);

//echo $sql; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?php echo (isset($page_myarray['keywords'])) ? st($page_myarray['keywords']) : '';?>" />
<title><?php echo $sitename;?> | <?php echo (isset($name)) ? $name . ' - ' : '';?>Ledger Card</title>
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
			<?php echo count($my)?> Patient(s) found for 
			
			<?php  
			if($_POST['d_mm'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date From :</i>
			<?php 
				echo $_POST['d_mm'] . ' - ' . $_POST['d_dd'] . ' - ' . $_POST['d_yy'];
			}
			if($_POST['d_mm1'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date To :</i>
			<?php 
				echo $_POST['d_mm1'] . ' - ' . $_POST['d_dd1'] . ' - ' . $_POST['d_yy1'];
			}
			if($_POST['referred_by'] <> '') {
				$referredby_sql = "select * from dental_contact where contactid='".$_POST['referred_by']."'";
				$referredby_myarray = $db->getRow($referredby_sql);
				$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			?>
				&nbsp;&nbsp;
				<i>Referred By :</i>
				<?php echo $ref_name;?>
			<?php  
			}?>
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
	<?php  if(count($my) == 0){ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php  
	} else {
		foreach ($my as $myarray) {
			$name = st($myarray['lastname'])." ".st($myarray['middlename'])." ".st($myarray['firstname']);
			
			$referredby_sql = "select * from dental_contact where contactid='".$myarray['referred_by']."'";
			$referredby_myarray = $db->getRow($referredby_sql);
			$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			
			if($myarray["status"] == 1){
				$tr_class = "tr_active";
			} else {
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
                	<?php echo st($name);?>
				</td>
				<td valign="top">
					<?php echo $ref_name;?>
				</td>
				<td valign="top">
                	<?php echo date('m-d-Y H:m',strtotime(st($myarray["adddate"])));?>
				</td>
			</tr>
	<?php  	}
	}?>
</table>


<br /><br />	

</td>
</tr>
</table>
</body>
</html>
