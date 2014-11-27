<?php
include_once "admin/includes/main_include.php";

if(!empty($_POST['missingsub']) && $_POST['missingsub'] == 1)
{
	$rec = '~';
	$rec1 = '~';
	$pck = '~';
	$pck1 = '~';
	$mob = '~';
	
	for($i=1;$i<17;$i++)
	{
		if($i<10)
			$i = '0'.$i;
									
		$rec .= $_POST['rec_'.$i.'_1'].'~'.$_POST['rec_'.$i.'_2'].'~'.$_POST['rec_'.$i.'_3'].'~';
		$rec1 .= $_POST['rec1_'.$i.'_1'].'~'.$_POST['rec1_'.$i.'_2'].'~'.$_POST['rec1_'.$i.'_3'].'~';
		$pck .= $_POST['pck_'.$i.'_1'].'~'.$_POST['pck_'.$i.'_2'].'~'.$_POST['pck_'.$i.'_3'].'~';
		$pck1 .= $_POST['pck1_'.$i.'_1'].'~'.$_POST['pck1_'.$i.'_2'].'~'.$_POST['pck1_'.$i.'_3'].'~';
		$mob .= $_POST['mob_'.$i].'~';
	}
	
	for($i=32;$i>=17;$i--)
	{
		$rec .= $_POST['rec_'.$i.'_1'].'~'.$_POST['rec_'.$i.'_2'].'~'.$_POST['rec_'.$i.'_3'].'~';
		$rec1 .= $_POST['rec1_'.$i.'_1'].'~'.$_POST['rec1_'.$i.'_2'].'~'.$_POST['rec1_'.$i.'_3'].'~';
		$pck .= $_POST['pck_'.$i.'_1'].'~'.$_POST['pck_'.$i.'_2'].'~'.$_POST['pck_'.$i.'_3'].'~';
		$pck1 .= $_POST['pck1_'.$i.'_1'].'~'.$_POST['pck1_'.$i.'_2'].'~'.$_POST['pck1_'.$i.'_3'].'~';
		$mob .= $_POST['mob_'.$i].'~';
	}
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_missing set 
						patientid = '".s_for($_GET['pid'])."',
						rec = '".s_for($rec)."',
						pck = '".s_for($pck)."',
						mob = '".s_for($mob)."',
						rec1 = '".s_for($rec1)."',
						pck1 = '".s_for($pck1)."',
						s1 = '".s_for($_POST['s1'])."',
						s2 = '".s_for($_POST['s2'])."',
						s3 = '".s_for($_POST['s3'])."',
						s4 = '".s_for($_POST['s4'])."',
						s5 = '".s_for($_POST['s5'])."',
						s6 = '".s_for($_POST['s6'])."',
						userid = '".s_for($_SESSION['userid'])."',
						docid = '".s_for($_SESSION['docid'])."',
						adddate = now(),
						ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		$db->query($ins_sql);
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			window.location='<?php echo $_SERVER['PHP_SELF']?>?pid=<?php echo $_GET['pid']?>&mt=<?php echo $_GET['mt']?>&msg=<?php echo $msg;?>';
		</script>
		<?php
		die();
	}else{
		$ed_sql = " update dental_missing set 
						rec = '".s_for($rec)."',
						pck = '".s_for($pck)."',
						mob = '".s_for($mob)."',
						rec1 = '".s_for($rec1)."',
						pck1 = '".s_for($pck1)."',
						s1 = '".s_for($_POST['s1'])."',
						s2 = '".s_for($_POST['s2'])."',
						s3 = '".s_for($_POST['s3'])."',
						s4 = '".s_for($_POST['s4'])."',
						s5 = '".s_for($_POST['s5'])."',
						s6 = '".s_for($_POST['s6'])."'
						where missingid = '".s_for($_POST['ed'])."'";
		
		$db->query($ed_sql);
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			window.location='<?php echo $_SERVER['PHP_SELF']?>?pid=<?php echo $_GET['pid']?>&mt=<?php echo $_GET['mt']?>&msg=<?php echo $msg;?>';
		</script>
		<?php
		die();
	}
	
}

$mt_arr = explode(',',$_GET['mt']);

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_myarray = $db->getRow($pat_sql);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);


$sql = "select * from dental_missing where patientid='".$_GET['pid']."'";
$myarray = $db->getRow($sql);

$missingid = st($myarray['missingid']);
$pck = st($myarray['pck']);
$rec = st($myarray['rec']);
$mob = st($myarray['mob']);
$pck1 = st($myarray['pck1']);
$rec1 = st($myarray['rec1']);
$s1 = st($myarray['s1']);
$s2 = st($myarray['s2']);
$s3 = st($myarray['s3']);
$s4 = st($myarray['s4']);
$s5 = st($myarray['s5']);
$s6 = st($myarray['s6']);

$rec_arr = explode('~',$rec);
$rec1_arr = explode('~',$rec1);
$pck_arr = explode('~',$pck);
$pck1_arr = explode('~',$pck1);
$mob_arr = explode('~',$mob);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="<?php echo st(!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : '');?>" />
	<title><?php echo $sitename;?></title>
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript" src="script/validation.js"></script>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
	  <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
	  <script type="text/javascript" src="js/missing_teeth_form.js"></script>
</head>
<body>

<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
	    <td> 
			<br />
			<span class="admin_head">
				Perio Charting
			</span>
			
			<div align="right">
				<b>
					Patient: 
					&nbsp;&nbsp;
					<?php echo $name;?>
					
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					Exam Date: 
					&nbsp;&nbsp;
					<?php echo date('m/d/Y', strtotime(st(!empty($form_myarray['adddate']) ? $form_myarray['adddate'] : '')));?>
					&nbsp;&nbsp;&nbsp;
				</b>
			</div>
			<br />
			
			<div align="center" class="red">
				<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
			</div>
			<form name="missingfrm" id="missingfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>&mt=<?php echo $_GET['mt']?>" method="post" >
				<input type="hidden" name="missingsub" value="1" />
				<input type="hidden" name="ed" value="<?php echo $missingid;?>" />
				<table cellpadding="5" cellspacing="1" align="center" >
					<tr>
						<td valign="top" colspan="2" width="100%" >	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Di :</b>
							Distal
							&nbsp;&nbsp;&nbsp;
							<b>Bu :</b>
							Buccal
							&nbsp;&nbsp;&nbsp;
							<b>Li :</b>
							Lingual
							&nbsp;&nbsp;&nbsp;
							<b>Me :</b>
							Mesial
							<table cellpadding="3" cellspacing="1" border="0">
								<tr>
									<td valign="top" align="center">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td valign="top" align="center" style="padding-top:35px;">
													<b>Pck</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Rec</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:70px;">
													<b>Mob</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Pck</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Rec</b>
												</td>
											</tr>
										</table>
									</td>
							<?php
								$rec_c = 0;
								$rec1_c = 0;
								$pck_c = 0;
								$pck1_c = 0;
								$mob_c = 0;
														
								for($i=1;$i<17;$i++){
									if($i<10)
										$i = '0'.$i;
									if($i%2 == 0)
										$st = ' bgcolor="#FFFEC0"';
									else
										$st = ' bgcolor="#CCCCCC"';
									$miss=0;?>

									<td valign="top" align="center" <?php echo $st?>>
									<?php 
										if(in_array($i,$mt_arr)) { 
											$miss=1;	
										}?>

										<b><?php echo $i;?></b>
										<table width="60" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td valign="top" align="center">
												<?php $pck_c++;?>
													Di
													Bu
													Me
													<br />
													<input type="text" maxlength="1" tabindex="<?php echo $pck_c; ?>" name="pck_<?php echo $i?>_1" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck_arr[$pck_c];?>">
												<?php $pck_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck_c; ?>" name="pck_<?php echo $i?>_2" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck_arr[$pck_c];?>">
												<?php $pck_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck_c; ?>" name="pck_<?php echo $i?>_3" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck_arr[$pck_c];?>">
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $rec_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $rec_c+192; ?>" name="rec_<?php echo $i?>_1" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec_arr[$rec_c];?>">
												<?php $rec_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $rec_c+192; ?>" name="rec_<?php echo $i?>_2" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec_arr[$rec_c];?>">
												<?php $rec_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $rec_c+192; ?>" name="rec_<?php echo $i?>_3" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec_arr[$rec_c];?>">
												</td>
											</tr>
											
											<tr>
												<td id="missing_cell_<?php echo $i;?>" valign="top" align="center">
												<?php if($miss == 1) {?>
													<img class="tooth_image" id="missing_<?php echo $i;?>" src="missing_teeth/<?php echo $i;?>_red.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />	
												<?php }else{?>
													<img id="missing_<?php echo $i;?>" src="missing_teeth/<?php echo $i;?>.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />
												<?php }?>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $mob_c++;?>
													<input type="text" maxlength="2" tabindex="<?php echo $mob_c+384; ?>" name="mob_<?php echo $i?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $mob_arr[$mob_c];?>">
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $pck1_c++;?>
													<input type="text" maxlength="2" name="pck1_<?php echo $i?>_1" tabindex="<?php echo $pck1_c+48; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck1_arr[$pck1_c];?>">
												<?php $pck1_c++;?>
													<input type="text" maxlength="2" name="pck1_<?php echo $i?>_2" tabindex="<?php echo $pck1_c+48; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck1_arr[$pck1_c];?>">
												<?php $pck1_c++;?>
													<input type="text" maxlength="2" name="pck1_<?php echo $i?>_3" tabindex="<?php echo $pck1_c+48; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck1_arr[$pck1_c];?>">
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $rec1_c++;?>
													<input type="text" maxlength="2" name="rec1_<?php echo $i?>_1" tabindex="<?php echo $rec1_c+240; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec1_arr[$rec1_c];?>">
												<?php $rec1_c++;?>
													<input type="text" maxlength="2" name="rec1_<?php echo $i?>_2" tabindex="<?php echo $rec1_c+240; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec1_arr[$rec1_c];?>">
												<?php $rec1_c++;?>
													<input type="text" maxlength="2" name="rec1_<?php echo $i?>_3" tabindex="<?php echo $rec1_c+240; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec1_arr[$rec1_c];?>">
													<br />
													Di
													Li
													Me
												</td>
											</tr>
											
											<tr>
												<td valign="top" align="center">
												<?php if($miss == 1) {?>
													<img src="missing_teeth/<?php echo $i;?>_red.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />	
												<?php }else{ ?>
													<img src="missing_teeth/<?php echo $i;?>.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />
												<?php }?>
												</td>
											</tr>
										</table>
									</td>
								<?php
								}?>	
									<td valign="top" align="center">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td valign="top" align="center" style="padding-top:35px;">
													<b>Pck</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Rec</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:70px;">
													<b>Mob</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Pck</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Rec</b>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="top" colspan="2" width="100%" >	
							<table width="80%" cellpadding="3" cellspacing="1" border="0">
								<tr>
									<td valign="top" align="center">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td valign="top" align="center" style="padding-top:75px;">
													<b>Rec</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Pck</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:15px;">
													<b>Mob</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:65px;">
													<b>Rec</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Pck</b>
												</td>
											</tr>
										</table>
									</td>
							<?php
								for($i=32;$i>=17;$i--){
									if($i<10)
										$i = '0'.$i;
									if($i%2 == 0)
										$st = ' bgcolor="#FFFEC0"';
									else
										$st = ' bgcolor="#CCCCCC"';
										
									$miss = 0;?>

									<td valign="top" align="center" <?php echo $st;?>>
									<?php if(in_array($i,$mt_arr)){ 
											$miss=1;	
										}?>
										<table width="60" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td valign="top" align="center">
												<?php if($miss == 1) {?>
													<img src="missing_teeth/<?php echo $i;?>_red.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />	
												<?php }else{?>
													<img src="missing_teeth/<?php echo $i;?>.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />
												<?php }?>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
													Di
													Li
													Me
													<br />
												<?php $rec_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $rec_c+288; ?>" name="rec_<?php echo $i?>_1" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec_arr[$rec_c];?>">
												<?php $rec_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $rec_c+288; ?>" name="rec_<?php echo $i?>_2" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec_arr[$rec_c];?>">
												<?php $rec_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $rec_c+288; ?>" name="rec_<?php echo $i?>_3" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec_arr[$rec_c];?>">
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $pck_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck_c+96; ?>" name="pck_<?php echo $i?>_1" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck_arr[$pck_c];?>">
												<?php $pck_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck_c+96; ?>" name="pck_<?php echo $i?>_2" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck_arr[$pck_c];?>">
												<?php $pck_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck_c+96; ?>" name="pck_<?php echo $i?>_3" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck_arr[$pck_c];?>">
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $mob_c++;?>
													<input type="text"  tabindex="<?php echo $mob_c+384; ?>" maxlength="1" name="mob_<?php echo $i?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $mob_arr[$mob_c];?>">
												</td>
											</tr>
											
											<tr>
												<td valign="top" align="center">
												<?php if($miss == 1) {?>
													<img src="missing_teeth/<?php echo $i;?>_red.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />	
												<?php }else{?>
													<img src="missing_teeth/<?php echo $i;?>.png" width="33" height="60" border="0" alt="<?php echo $i;?>" />
												<?php }?>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $rec1_c++;?>
													<input type="text" maxlength="1" name="rec1_<?php echo $i?>_1" tabindex="<?php echo $rec1_c+240; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec1_arr[$rec1_c];?>">
												<?php $rec1_c++;?>
													<input type="text" maxlength="1" name="rec1_<?php echo $i?>_2" tabindex="<?php echo $rec1_c+240; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec1_arr[$rec1_c];?>">
												<?php $rec1_c++;?>
													<input type="text" maxlength="1" name="rec1_<?php echo $i?>_3" tabindex="<?php echo $rec1_c+240; ?>" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $rec1_arr[$rec1_c];?>">
												</td>
											</tr>
											<tr>
												<td valign="top" align="center">
												<?php $pck1_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck1_c+48; ?>" name="pck1_<?php echo $i?>_1" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck1_arr[$pck1_c];?>">
												<?php $pck1_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck1_c+48; ?>" name="pck1_<?php echo $i?>_2" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck1_arr[$pck1_c];?>">
												<?php $pck1_c++;?>
													<input type="text" maxlength="1" tabindex="<?php echo $pck1_c+48; ?>" name="pck1_<?php echo $i?>_3" style="width:14px" <? if($miss == 1) echo " disabled";?> value="<?php echo $pck1_arr[$pck1_c];?>">
													<br />
													Di
													Bu
													Me
												</td>
											</tr>
										</table>
										<b><?php echo $i;?></b>
									</td>
								<?php
								}?>
									<td valign="top" align="center">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td valign="top" align="center" style="padding-top:75px;">
													<b>Rec</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Pck</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:15px;">
													<b>Mob</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:65px;">
													<b>Rec</b>
												</td>
											</tr>
											<tr>
												<td valign="top" align="center" style="padding-top:5px;">
													<b>Pck</b>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<br />
				<span class="admin_head">
					Periodontal Screening and Recording
				</span>	
				<table cellpadding="5" cellspacing="1">
					<tr>
						<td valign="top" colspan="2" align="center" >	
							<input  tabindex="417" type="text" maxlength="1" name="s1" style="width:15px" value="<?php echo $s1;?>">
							<br />
							<b>S1</b>
						</td>
						<td valign="top" colspan="2" align="center" >	
							<input tabindex="418" type="text" maxlength="1" name="s2" style="width:15px" value="<?php echo $s2;?>">
							<br />
							<b>S2</b>
						</td>
						<td valign="top" colspan="2" align="center" >	
							<input tabindex="419" type="text" maxlength="1" name="s3" style="width:15px" value="<?php echo $s3;?>">
							<br />
							<b>S3</b>
						</td>
					</tr>
					<tr>
						<td valign="top" colspan="2" align="center" >
							<input tabindex="422" type="text" maxlength="1" name="s6" style="width:15px" value="<?php echo $s6;?>">
							<br />
							<b>S6</b>
						</td>
						<td valign="top" colspan="2" align="center" >	
							<input tabindex="421" type="text" maxlength="1" name="s5" style="width:15px" value="<?php echo $s5;?>">
							<br />
							<b>S5</b>
						</td>
						<td valign="top" colspan="2" align="center" >
							<input tabindex="420" type="text" maxlength="1" name="s4" style="width:15px" value="<?php echo $s4;?>">
							<br />
							<b>S4</b>
						</td>
					</tr>
				</table>
						
				<br />
				<div align="left">
					<table width="100%" cellpadding="3" border="0" align="center">
						<tr>
							<td valign="top" width="33%" align="left">
								&nbsp;&nbsp;&nbsp;
							</td>
							<td valign="top" width="33%" align="left">
								&nbsp;&nbsp;&nbsp;
								<input type="submit" name="q_pagebtn" value="Save" />
							</td>
							<td valign="top" width="33%" align="right">
								&nbsp;&nbsp;&nbsp;
							</td>
						</tr>
					</table>
				</div>	
			</form>		
			<br /><br />	
		</td>
	</tr>
</table>
</body>
</html>