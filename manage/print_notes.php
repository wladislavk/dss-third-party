<? 
session_start();
require_once('admin/includes/main_include.php');
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

$sql = "select * from dental_notes where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate";
$sql = "select n.*, CONCAT(u.first_name,' ',u.last_name) signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where status!=0 AND docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc
        ";

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
<body onload="Javascript: window.print(); ">

<br />
<span class="admin_head">
	Print Progress Notes
	-
	<i>
	<?=$name;?>
    </i>
</span>
<br />
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
                                                <tr>
                                                        <td valign="top" width="35%">
                                                                Procedure Date:
                                                                <span style="font-weight:normal;">
                                                                        <?=($myarray["procedure_date"]!='')?date('M d, Y',strtotime(st($myarray["procedure_date"]))):'';?>
                                                                </span> <br />
                                                                Entry Date:
                                                                <span style="font-weight:normal;">
                                                                        <?php
                                                                                $entry = ($myarray["parent_adddate"]!='')?$myarray["parent_adddate"]:$myarray["adddate"];
                                                                        ?>
                                                                        <?=date('M d, Y H:i',strtotime(st($entry)));?>
                                                                </span>

                                                        </td>
                                                        <td valign="top" width="35%">
                                                                Added By:
                                                                <span style="font-weight:normal;">
                                                                        <?=st($user_myarray["first_name"]." ".$user_myarray["last_name"]);?>
                                                                </span>
                                                        </td>
                                                        <td valign="top" width="30%">
                                                        <span id="note_edit_<?= $myarray['notesid'];?>">
                                                        <? if(st($myarray["signed_id"]) == '') { ?>
                                                                Status: <span style="font-size:14px;">Unsigned</span>
                                                                <a href="#" onclick="loadPopup('add_notes.php?pid=<?= $_GET['pid']; ?>&ed=<?= $myarray['notesid']; ?>')">Edit</a>
                                                                <?php if($myarray["docid"]==$_SESSION['userid']){ ?>
                                                                /
                                                                <a href="dss_summ.php?pid=<?= $_GET['pid']; ?>&sid=<?= $myarray['notesid'];?>&addtopat=1" onclick="return confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?');">Sign</a>
                                                                <?php } ?>
                                                        <? }else{ ?>
                                                                Signed By: <?= $myarray["signed_name"]; ?>
                                                                <br />
                                                                Signed On: <?= date('m/d/Y H:i a', strtotime($myarray["signed_on"])); ?>
                                                        <? } ?>
                                                        </span>
						        </td>
						</tr>
						<tr>
							<td valign="top" colspan="3">
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

<br /><br />
	
</body>
</html>
