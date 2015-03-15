<?php namespace Ds3\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if(!empty($_POST["catsub"]) && $_POST["catsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_support_categories set 
				title = '".mysqli_real_escape_string($con,$_POST["title"])."'
			where id='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_support_categories.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
		else
		{


			$ins_sql = "insert into dental_support_categories set 
				title = '".mysqli_real_escape_string($con,$_POST["title"])."', 
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);
                        $companyid = mysqli_insert_id($con);			

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_support_categories.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_support_categories where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$title = $_POST['title'];
	}
	else
	{
		$title = st($themyarray['title']);
		$but_text = "Add ";
	}
	
	if($themyarray["id"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<?php if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="userfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Support Category 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Title
            </td>
            <td valign="top" class="frmdata">
                <input id="title" type="text" name="title" value="<?php echo $title;?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="catsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" value="<?php echo $but_text?> Category" class="btn btn-primary">
                <?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_support_categories.php?delid=<?php echo $themyarray["id"];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
