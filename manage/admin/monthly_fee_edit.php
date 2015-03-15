<?php namespace Ds3\Libraries\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if(!empty($_POST["compsub"]) && $_POST["compsub"] == 1)
{
			$ed_sql = "update companies set 
				monthly_fee = '".mysqli_real_escape_string($con,$_POST["monthly_fee"])."',
				fax_fee = '".mysqli_real_escape_string($con,$_POST["fax_fee"])."',
				free_fax = '".mysqli_real_escape_string($con,$_POST["free_fax"])."'
			where id='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);;

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_percase_invoice.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
}

?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from companies where id='".$_REQUEST["ed"]."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
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
	
	<?php if(!empty($msg)) {?>
    <div align="center" class="red">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="userfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Fees 
               <?php if($name <> "") {?>
               		&quot;<?php echo $name;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Monthly Fee
            </td>
            <td valign="top" class="frmdata">
                <input id="monthly_fee" type="text" name="monthly_fee" value="<?php echo $monthly_fee;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Fax Fee
            </td>
            <td valign="top" class="frmdata">
                <input id="fax_fee" type="text" name="fax_fee" value="<?php echo $fax_fee;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Free Fax
            </td>
            <td valign="top" class="frmdata">
                <input id="free_fax" type="text" name="free_fax" value="<?php echo $free_fax;?>" class="tbox" />
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="compsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" value=" <?php echo $but_text?> Fees" class="btn btn-warning">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
