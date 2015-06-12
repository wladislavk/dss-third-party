<?php namespace Ds3\Libraries\Legacy; ?><? 
include "admin/includes/main_include.php";

$mt_arr = explode(',',$_GET['mt']);


$pat_sql = "select * from dental_patients where patientid='".s_for($form_myarray['patientid'])."'";
$pat_my = mysqli_query($con, $pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

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
				Missing Tooth
			</span>
			
			<div align="right">
				<b>
				Patient: 
				&nbsp;&nbsp;
				<?=$name;?>
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				Exam Date: 
				&nbsp;&nbsp;
				<?=date('m/d/Y', strtotime(st($form_myarray['adddate'])));?>
				&nbsp;&nbsp;&nbsp;
				</b>
			</div>
			<br />

			<table width="80%" cellpadding="5" cellspacing="1" bgcolor="#FFFEC0" align="center" >
				<tr>
					<td valign="top" colspan="2" width="100%" >	
						<table width="80%" cellpadding="3" cellspacing="1" border="0">
							<tr>
							<? 
							for($i=1;$i<17;$i++)
							{
								if($i<10)
									$i = '0'.$i;
							?>
								<td valign="top">
									<? if(in_array($i,$mt_arr) ) 
									{ 
										?>
										
										<img src="missing_teeth/<?=$i;?>_red.gif" width="33" height="171" border="0" alt="<?=$i;?>" />
										<?
									}
									else
									{
										?>
										
										<img src="missing_teeth/<?=$i;?>.gif" width="33" height="171" border="0" alt="<?=$i;?>" />
										
										<?
									}?>
								</td>
							<? 
								$j++;
							}?>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td valign="top" colspan="2" width="100%" >	
						<table width="80%" cellpadding="3" cellspacing="1" border="0">
							<tr>
							<? 
							for($i=32;$i>=17;$i--)
							{
								if($i<10)
									$i = '0'.$i;
							?>
								<td valign="top">
									<? if(in_array($i,$mt_arr) ) 
									{ 
										?>
										<img src="missing_teeth/<?=$i;?>_red.gif" width="33" height="171" border="0" alt="<?=$i;?>" />
										<?
									}
									else
									{
										?>
										<img src="missing_teeth/<?=$i;?>.gif" width="33" height="171" border="0" alt="<?=$i;?>" />
										<?
									}?>
								</td>
							<? 
								$j++;
							}?>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<br />
			<div align="right" style="padding-right:20px;">
				<button onclick="Javascript: window.print();">
					Print
				</button>
			</div>
<br /><br />	

		</td>
	</tr>
</table>
    

</body>
</html>
