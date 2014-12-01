<?php 
	include "includes/top.htm";
	include_once "includes/constants.inc";
	include_once('includes/patient_info.php');

	if(isset($_REQUEST['yes_but']) && $_REQUEST["delid"] != "") {
		$del_sql = "delete from dental_ledger where primary_claim_id='".$_REQUEST["delid"]."'";
		
		$db->query($del_sql);
		$msg = "Deleted Successfully";
?>
		<script type="text/javascript">
			window.location = "manage_insurance.php?msg=<?php echo $msg?>&pid=<?php echo $_REQUEST['pid'];?>";
		</script>
<?php
		die();
	} elseif(isset($_REQUEST['no_but'])) {
        $up_sql = "update dental_ledger set primary_claim_id='0', status='0' where primary_claim_id='".$_REQUEST["delid"]."'";
        
        $db->query($up_sql);
?>
        <script type="text/javascript">
            window.location = "manage_insurance.php?msg=<?php echo $msg?>&pid=<?php echo $_REQUEST['pid'];?>";
        </script>
<?php
	    die();
	}
?>
	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<script src="admin/popup/popup.js" type="text/javascript"></script>

	<div style="margin-left:20px;">
		<form action="delete_insurance.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&delid=<?php echo (!empty($_REQUEST['delid']) ? $_REQUEST['delid'] : '');?>" method="post">
		    This claim will be deleted. Do you want to delete the corresponding ledger entries as well?
			<input type="submit" name="yes_but" value="Yes" />
			<input type="submit" name="no_but" value="No" />  
		</form>
	</div>

<?php include "includes/bottom.htm"; ?>