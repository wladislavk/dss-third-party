<? 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}

$sql = "select * from dental_notes where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' ";

if($_GET['ed'] <> '')
{
	$sql .= " and notesid = '".$_GET['ed']."' ";
}
$sql .= " order by adddate DESC";
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<br />
<span class="admin_head">
	View Progress Notes
	-
	<i>
	<?=$name;?>
    </i>
</span>

<? if($_GET['ed'] == '') {?>
<br />
<div align="right">
	<button onClick="Javascript: window.open('print_notes.php?pid=<?=$_GET['pid'];?>','Print_Notes','width=800,height=500',scrollbars=1);" class="addButton">
		Print Progress Note
	</button>
	&nbsp;&nbsp;
</div>
<? }?>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="15%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="right" >
	<tr>
		<td valign="top" bgcolor="#FF9999">
		&nbsp;&nbsp;&nbsp;
		</td>
		<td valign="top">
			&nbsp;&nbsp;
			<b>Edited Note</b>
		</td>
	</tr>
</table>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
			$tr_class = "tr_active";
			
			$user_sql = "SELECT * FROM dental_users where userid='".st($myarray["userid"])."'";
			$user_my = mysql_query($user_sql);
			$user_myarray = mysql_fetch_array($user_my);
		?>
			<tr class="<?=$tr_class;?>" <? if(st($myarray["edited"]) == 1) {?> style="background-color:#FF9999" <? }?>>
				<td valign="top">
					<table width="100%" cellpadding="2" cellspacing="1" border="0">
						<tr>
							<td valign="top" width="50%">
								Note Date: 
								<span style="font-weight:normal;">
									<?=date('M d, Y H:i',strtotime(st($myarray["adddate"])));?>
								</span>
							</td>
							<td valign="top">
								Added By: 
								<span style="font-weight:normal;">
									<?=st($user_myarray["name"]);?>
								</span>
							</td>
						</tr>
						<tr>
							<td valign="top" colspan="2">
								<hr size="1" />
								<span style="font-weight:normal;">
									<?=nl2br(st($myarray["notes"]));?>
								</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
	
</body>
</html>
