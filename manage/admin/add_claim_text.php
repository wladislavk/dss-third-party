<?php namespace Ds3\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["custom_textsub"]) && $_POST["custom_textsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_claim_text set 
			title = '".s_for($_POST["title"])."', 
			description = '".s_for($_POST["description"])."' 
			where id='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_claim_text.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_claim_text SET
			title='".mysqli_real_escape_string($con,$_POST["title"])."', 
			description = '".mysqli_real_escape_string($con,$_POST["description"])."', 
			default_text = 1,
			adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'
			";
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_claim_text.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
    <?
    $thesql = "select * from dental_claim_text where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
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
	
	if($themyarray["id"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
        <div class="page-header">
            <h1>
               <?php echo $but_text?> Custom Text
               <?php if($title <> "") {?>
                        &quot;<?php echo $title;?>&quot;
               <?php }?>
	    </h1>
        </div>

	<?php if(!empty($msg)) {?>
    <div align="center" class="red">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="transaction_codefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" >

            <div class="form-group">
                <label for="npi" class="col-md-3 control-label">Title</label>
                <div class="col-md-9">
                <input type="text" name="title" value="<?php echo $title?>" class="tbox" /> 
                <span class="red">*</span>				
		</div>
	     </div>
            <div class="form-group">
                <label for="npi" class="col-md-3 control-label">Description</label>
                <div class="col-md-9">
            	<textarea class="tbox" name="description" style="width:100%;"><?php echo $description;?></textarea>
		</div>
	    </div>
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="custom_textsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" value=" <?php echo $but_text?> Claim Text" class="btn btn-primary" />
		<?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_claim_text.php?delid=<?php echo $themyarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="btn btn-danger" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>

    </form>
  
</body>
</html>
