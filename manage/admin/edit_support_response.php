<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["ressub"] == 1)
{
			$ed_sql = "update dental_support_responses set 
				body = '".mysql_real_escape_string($_POST["body"])."'
			where id='".$_POST["id"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='view_support_ticket.php?ed=<?=$_GET['ed'];?>&msg=<?=$msg;?>';
			</script>
			<?
			die();
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_support_responses where id='".$_REQUEST["id"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?ed=<?= $_GET['ed']; ?>" method="post" >
    <table class="table table-bordered table-hover">
        <tr>
            <td class="cat_head">
               <?=$but_text?> Support Response
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmdata">
                <textarea id="body" name="body" ><?=$themyarray['body'];?></textarea>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr>
            <td  align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="ressub" value="1" />
                <input type="hidden" name="id" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" Update Response " class="btn btn-warning">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
