<? 
include "includes/top.htm";
include_once "includes/constants.inc";
require_once('includes/patient_info.php');

if(isset($_REQUEST['yes_but']) && $_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_ledger where primary_claim_id='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="manage_insurance.php?msg=<?=$msg?>&pid=<?=$_REQUEST['pid'];?>";
	</script>
	<?
	die();
}elseif(isset($_REQUEST['no_but'])){

        $up_sql = "update dental_ledger set primary_claim_id='0', status='0' where primary_claim_id='".$_REQUEST["delid"]."'";
        mysql_query($up_sql);

        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="manage_insurance.php?msg=<?=$msg?>&pid=<?=$_REQUEST['pid'];?>";
        </script>
        <?
        die();
}
?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<div style="margin-left:20px;">
<form action="delete_insurance.php?pid=<?=$_GET['pid'];?>&delid=<?=$_REQUEST['delid'];?>" method="post">
    This claim will be deleted. Do you want to delete the corresponding ledger entries as well?
<input type="submit" name="yes_but" value="Yes" />
<input type="submit" name="no_but" value="No" />  
</form>
</div>

<? include "includes/bottom.htm";?>
