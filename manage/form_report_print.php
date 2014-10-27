<?php 
	include "admin/includes/main_include.php";

	if($_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1) {
?>
		<script type="text/javascript">
			window.location = 'patient_report.php';
		</script>
<?php
		die();
	}

	$rec_disp = 200;
	if($_REQUEST["page"] != "") {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
		
	$i_val = $index_val * $rec_disp;
	$sql = "select * from dental_forms where docid='".$_SESSION['docid']."' ";

	if($_POST['d_mm'] != '') {
		$from_date = $_POST['d_yy']."-".$_POST['d_mm']."-".$_POST['d_dd'];
		$sql .= " and adddate >= '".s_for($from_date)."' ";
	}

	if($_POST['d_mm1'] != '') {
		$to_date = $_POST['d_yy1']."-".$_POST['d_mm1']."-".$_POST['d_dd1'];
		$sql .= " and adddate <= '".s_for($to_date)."' ";
	}

	$sql .= " order by adddate";

	$total_rec = $db->getNumberRows($sql);
	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit ".$i_val.",".$rec_disp;

	$my = $db->getResults($sql);
	$num_users = count($my);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="keywords" content="<?php echo st($page_myarray['keywords']);?>" />
		<title><?php echo $sitename;?> | <?php echo $name;?> - Ledger Card</title>
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
	</head>

	<body onLoad="window.print(); window.close();">
	<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
	  	<tr bgcolor="#FFFFFF">
	    	<td colspan="2" > 
				<span class="admin_head">
					Form Report
				</span>
				<br /><br />
				<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" border="1" >
					<tr bgColor="#ffffff">
						<td  align="right" colspan="15" class="cat_head">
							<?php echo $total_rec;?> Form(s) found for 
							
							<?php if($_POST['d_mm'] <> '') { ?>
								&nbsp;&nbsp;
								<i>Date From :</i>
								<?php echo $_POST['d_mm'];?> - <?php echo $_POST['d_dd'];?> - <?php echo $_POST['d_yy'];?>
							<?php } ?>
							<?php if($_POST['d_mm1'] <> '') { ?>
								&nbsp;&nbsp;
								<i>Date To :</i>
								<?php echo $_POST['d_mm1'];?> - <?php echo $_POST['d_dd1'];?> - <?php echo $_POST['d_yy1'];?>
							<?php } ?>
						</td>        
					</tr>
					<?php if($total_rec > $rec_disp) { ?>
						<tr bgColor="#ffffff">
							<td  align="right" colspan="15" class="bp">
								Pages:
								<?php paging($no_pages,$index_val,""); ?>
							</td>        
						</tr>
					<?php } ?>
					<tr class="tr_bg_h">
						<td valign="top" class="col_head" width="30%">
							Date
						</td>
						<td valign="top" class="col_head" width="30%">
							Form ID
						</td>
						<td valign="top" class="col_head" width="40%">
							Patient Name
						</td>
					</tr>
					<?php if($num_users == 0) { ?>
						<tr class="tr_bg">
							<td valign="top" class="col_head" colspan="10" align="center">
								No Records
							</td>
						</tr>
					<?php
						} else {
							foreach ($my as $myarray) {
								$name = st($myarray['lastname']) . " " . st($myarray['middlename']) . " " . st($myarray['firstname']);
								$patient_sql = "select * from dental_patients where patientid='" . $myarray['patientid'] . "'";
								
								$patient_myarray = $db->getRow($patient_sql);
								$pat_name = st($patient_myarray['lastname']) . " " . st($patient_myarray['middlename']) . " " . st($patient_myarray['firstname']);
								if($myarray["status"] == 1) {
									$tr_class = "tr_active";
								} else {
									$tr_class = "tr_inactive";
								}
								$tr_class = "tr_active";
					?>
								<tr class="<?php echo $tr_class;?>">
									<td valign="top">
										<?php echo date('m-d-Y H:m',strtotime(st($myarray["adddate"])));?>
									</td>
									<td valign="top">
										<?php echo st($myarray["formid"]);?>
									</td>
									<td valign="top">
					                	<?php echo st($pat_name);?>
									</td>
								</tr>
					<?php
							}
						}
					?>
				</table>
				<br /><br />	
			</td>
		</tr>
	</table>
	</body>
</html>