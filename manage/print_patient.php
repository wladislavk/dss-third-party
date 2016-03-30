<?php namespace Ds3\Libraries\Legacy; ?><?php
	include "admin/includes/main_include.php";

	$sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and status='".$_GET['st']."' order by lastname, firstname";
	
	$my = $db->getResults($sql);
	$num_users = count($my);
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
		<meta name="keywords" content="<?php echo isset($page_myarray['keywords']) ? st($page_myarray['keywords']) : '';?>" />
		<title><?php echo $sitename;?> | <?php echo $st_disp;?> Patient</title>
		<link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
		<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
		<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="script/validation.js"></script>
	</head>

	<body onLoad="window.print(); parent.disablePopup1();">
		<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
			<tr bgcolor="#FFFFFF">
				<td colspan="2" >
					<span class="admin_head">
						<?php echo $st_disp;?> Patient
					</span>
					<br /><br />
					&nbsp;
					<b> Total Records: <?php echo $num_users;?></b>
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
						<?php if($num_users == 0) { ?>
							<tr class="tr_bg">
								<td valign="top" class="col_head" colspan="10" align="center">
									No Records
								</td>
							</tr>
						<?php } else {
							foreach ($my as $myarray) {
								$tr_class = "tr_active";
						?>
								<tr class="<?php echo $tr_class;?>">
									<td valign="top">
										<?php echo st($myarray["lastname"]);?>&nbsp;
					                    <?php echo st($myarray["middlename"]);?>,&nbsp;
					                    <?php echo st($myarray["firstname"]);?> 
									</td>
					                <td valign="top">
					                	<?php echo st($myarray["city"]);?>&nbsp;
					                </td>
					                <td valign="top">
					                	<?php echo st($myarray["home_phone"]);?>&nbsp;
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
