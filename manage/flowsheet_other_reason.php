<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	if(!empty($_POST["other_reason"]) && $_POST["other_reason"] == 1) {
		$ed_sql = "update dental_flow_pg2_info 
					set 
					description = '".s_for($_POST['reason'])."'
					where 
					id='".$_REQUEST['ed']."' AND patientid='".$_REQUEST['pid']."';";

		$db->query($ed_sql);	
?>	
		<script type="text/javascript">
			parent.disablePopup1();
		</script>	
<?php
		trigger_error("Die called", E_USER_ERROR);
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
			$thesql = "SELECT id, segmentid, description from dental_flow_pg2_info WHERE id='".(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '')."' AND patientid='".(!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '')."';";
			
			$segment = $db->getRow($thesql);
			if ($segment['segmentid'] == '5') {
				$segmenttype = "Delaying Treatment";
			} elseif ($segment['segmentid'] == '9') {
				$segmenttype = "Patient Non-Compliant";
			}	
		?>	
		<br /><br />
	    <form name="flowsheet_other_reason" action="/manage/flowsheet_other_reason.php?pid=<?php echo (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '')?>&ed=<?php echo (!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '')?>&sid=<?php echo (!empty($_REQUEST['sid']) ? $_REQUEST['sid'] : '')?>" method="post">
	    	<table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	    		<tr>
			      	<td colspan="2" class="cat_head">
			        	Reason for <?php echo (!empty($segmenttype) ? $segmenttype : ''); ?>
			        </td>
	      		</tr>
	      		<tr> 
	      			<td valign="top" colspan="2" class="frmhead">
	        			<textarea name="reason" id="reason" class="field text reason tbox" style="width:680px;" tabindex="1"><?php echo $segment['description']?></textarea>
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
