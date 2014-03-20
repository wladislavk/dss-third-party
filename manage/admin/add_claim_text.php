<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["custom_textsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_claim_text set 
			title = '".s_for($_POST["title"])."', 
			description = '".s_for($_POST["description"])."' 
			where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_claim_text.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_claim_text SET
			title='".mysql_real_escape_string($_POST["title"])."', 
			description = '".mysql_real_escape_string($_POST["description"])."', 
			adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'
			";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_claim_text.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
    <?
    $thesql = "select * from dental_claim_text where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
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
               <?=$but_text?> Custom Text
               <? if($title <> "") {?>
                        &quot;<?=$title;?>&quot;
               <? }?>
	    </h1>
        </div>

	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="transaction_codefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >

            <div class="form-group">
                <label for="npi" class="col-md-3 control-label">Title</label>
                <div class="col-md-9">
                <input type="text" name="title" value="<?=$title?>" class="tbox" /> 
                <span class="red">*</span>				
		</div>
	     </div>
            <div class="form-group">
                <label for="npi" class="col-md-3 control-label">Description</label>
                <div class="col-md-9">
            	<textarea class="tbox" name="description" style="width:100%;"><?=$description;?></textarea>
		</div>
	    </div>
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="custom_textsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Claim Text" class="btn btn-primary" />
		<?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_claim_text.php?delid=<?=$themyarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="btn btn-danger" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>

    </form>
  
</body>
</html>
