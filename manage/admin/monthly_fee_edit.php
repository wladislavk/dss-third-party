<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["compsub"] == 1)
{
			$ed_sql = "update companies set 
				monthly_fee = '".mysql_real_escape_string($_POST["monthly_fee"])."',
				fax_fee = '".mysql_real_escape_string($_POST["fax_fee"])."',
				free_fax = '".mysql_real_escape_string($_POST["free_fax"])."'
			where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());


			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_percase_invoice.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

    <?
    $thesql = "select * from companies where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $themyarray['name'];
		$monthly_fee = $_POST['monthly_fee'];
		$fax_fee = $_POST['fax_fee'];
		$free_fax = $_POST['free_fax'];
	}
	else
	{
		$name = st($themyarray['name']);
		$monthly_fee = st($themyarray['monthly_fee']);
		$fax_fee = st($themyarray['fax_fee']);
		$free_fax = st($themyarray['free_fax']);
	}
	
		$but_text = "Edit ";
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table class="table table-bordered">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Fees 
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Monthly Fee
            </td>
            <td valign="top" class="frmdata">
                <input id="monthly_fee" type="text" name="monthly_fee" value="<?=$monthly_fee;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Fax Fee
            </td>
            <td valign="top" class="frmdata">
                <input id="fax_fee" type="text" name="fax_fee" value="<?=$fax_fee;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Free Fax
            </td>
            <td valign="top" class="frmdata">
                <input id="free_fax" type="text" name="free_fax" value="<?=$free_fax;?>" class="tbox" />
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="compsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Fees" class="btn btn-warning">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
