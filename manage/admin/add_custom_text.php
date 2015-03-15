<?php namespace Ds3\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["custom_textsub"]) && $_POST["custom_textsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_custom set 
			title = '".s_for($_POST["title"])."', 
			description = '".s_for($_POST["description"])."' 
			where customid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);
			
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_custom_text.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_custom SET
			title='".mysqli_real_escape_string($con,$_POST["title"])."', 
			description = '".mysqli_real_escape_string($con,$_POST["description"])."', 
			adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', 
			default_text = 1";
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_custom_text.php?msg=<?php echo $msg;?>';
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
	
	<?php if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="transaction_codefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return check_add();">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Custom Text 
               <?php if($title <> "") {?>
               		&quot;<?php echo $title;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Title
            </td>
            <td valign="top" class="frmdata">
                <input type="text" id="title" name="title" value="<?php echo $title?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
            	<textarea class="form-control" name="description" style="width:100%;"><?php echo $description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="custom_textsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["customid"]?>" />
                <input type="submit" value="<?php echo $but_text?> Custom Text" class="btn btn-primary">
		<?php if($themyarray["customid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_custom_text.php?delid=<?php echo $themyarray["customid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>

            </td>
        </tr>
    </table>
    </form>
<script type="text/javascript">
  function check_add(){
    if($('#title').val()==""){
      alert('Title is required');
      return false;
    }
    return true;
  }
</script>  
</body>
</html>
