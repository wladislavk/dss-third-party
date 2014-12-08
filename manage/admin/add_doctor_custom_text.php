<?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["custom_textsub"]) && $_POST["custom_textsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_custom set 
			title = '".mysqli_real_escape_string($con,$_POST["title"])."', 
			description = '".mysqli_real_escape_string($con,$_POST["description"])."'
			where customid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_doctor_custom_text.php?docid=<?= $_GET['docid']; ?>&msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_custom set 
			title = '".mysqli_real_escape_string($con,$_POST["title"])."',
			description = '".mysqli_real_escape_string($con,$_POST["description"])."',
			adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', docid=".$_GET['docid'];
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_doctor_custom_text.php?docid=<?= $_GET['docid']; ?>&msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_custom where customid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$title = $_POST['title'];
		$description = $_POST['description'];
	}
	else
	{
		$title = st($themyarray['title']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["customid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="transaction_codefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&docid=<?= $_GET['docid']; ?>" method="post">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Custom Text 
               <? if($title <> "") {?>
               		&quot;<?=$title;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Title
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="title" value="<?=$title?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
            	<textarea class="form-control" name="description" style="width:100%;"><?=$description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="custom_textsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["customid"]?>" />
                <input type="submit" value="<?=$but_text?> Custom Text" class="btn btn-primary">
		<?php if($themyarray["customid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_doctor_custom_text.php?delid=<?=$themyarray["customid"];?>&docid=<?= $_GET['docid']; ?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
  
</body>
</html>
