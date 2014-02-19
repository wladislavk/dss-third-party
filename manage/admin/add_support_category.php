<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["catsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_support_categories set 
				title = '".mysql_real_escape_string($_POST["title"])."'
			where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_support_categories.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{


			$ins_sql = "insert into dental_support_categories set 
				title = '".mysql_real_escape_string($_POST["title"])."', 
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
                        $companyid = mysql_insert_id();			

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_support_categories.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_support_categories where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
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
	
	<? if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Support Category 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Title
            </td>
            <td valign="top" class="frmdata">
                <input id="title" type="text" name="title" value="<?=$title;?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="catsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value="<?=$but_text?> Category" class="btn btn-primary">
                <?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_support_categories.php?delid=<?=$themyarray["id"];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
