<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

if($_POST["other_reason"] == 1)
{
	$stepid_query = "SELECT stepid FROM dental_flow_pg2_info WHERE stepid = '".$_REQUEST['ed']."';";
	$stepid_res = mysql_query($stepid_query);
	$numrows = mysql_num_rows($stepid_res);
	if($numrows > 0)
	{
		$ed_sql = "update dental_flow_pg2_info 
		set 
		description = '".s_for($_POST['reason'])."'
		where 
		stepid='".$_REQUEST['ed']."' AND patientid='".$_REQUEST['pid']."';";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());	
	}
	else
	{
		$ins_sql = "insert into dental_flow_pg2_info
		set 
		patientid = '".s_for($_REQUEST['pid'])."',
		stepid = '".s_for($_REQUEST['ed'])."',
		segmentid = '".s_for($_REQUEST['sid'])."',
		description = '".s_for($_POST['reason'])."';";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
	}
	?>	
	<script type="text/javascript">
		parent.window.location='manage_flowsheet3.php?page=page2&pid=<?=$_GET["pid"]?>';		
	</script>	
	<?php
	die();
}

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

	<?php
  $thesql = "SELECT stepid, segmentid, description from dental_flow_pg2_info WHERE stepid='".$_REQUEST['ed']."' AND patientid='".$_REQUEST['pid']."';";
	$themy = mysql_query($thesql);
	$segment = mysql_fetch_array($themy);
	
	if ($segment['segmentid'] == '5') {
		$segmenttype = "Delaying Treatment";
	} elseif ($segment['segmentid'] == '9') {
		$segmenttype = "Patient Non-Compliant";
	}	
	?>	
	<br /><br />
    <form name="flowsheet_other_reason" action="/manage/flowsheet_other_reason.php?pid=<?=$_REQUEST['pid']?>&ed=<?=$_REQUEST['ed']?>&sid=<?=$_REQUEST['sid']?>" method="post">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    	<tr>
      	<td colspan="2" class="cat_head">
        	Reason for <?=$segmenttype?>
        </td>
      </tr>
      <tr> 
      	<td valign="top" colspan="2" class="frmhead">
        	<textarea name="reason" id="reason" class="field text reason tbox" style="width:680px;" tabindex="1"><?=$segment['description']?></textarea>
          <!--<label for="reason">Reason</label>-->
        </td>
      </tr>
      <tr>
      	<td  colspan="2" align="center">
        	<input type="hidden" name="other_reason" value="1" />
          <input type="submit" value="Submit Reason" class="button" />
        </td>
      </tr>
    </table>
    </form>
</body>
</html>
