<?php namespace Ds3\Libraries\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");
include "fckeditor/fckeditor.php";

if(!empty($_POST["pagesub"]) && $_POST["pagesub"] == 1)
{
	$sel_check = "select * from dental_pages where title = '".s_for($_POST["title"])."' and pageid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con,$sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Title already exist. So please give another Title.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_pages set title = '".s_for($_POST["title"])."', keywords = '".s_for($_POST["keywords"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."' where pageid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_pages.php?msg=<?=$msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into dental_pages set title = '".s_for($_POST["title"])."', keywords = '".s_for($_POST["keywords"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_pages.php?msg=<?=$msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_pages where pageid='".(!empty($_REQUEST["ed"]))."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$title = $_POST['title'];
		$description = $_POST['description'];
		$keywords = $_POST['keywords'];
		$status = $_POST['status'];
	}
	else
	{
		$title = st($themyarray['title']);
		$description = st($themyarray['description']);
		$keywords = $themyarray['keywords'];
		$status = st($themyarray['status']);
		$but_text = "Add ";
	}
	
	if($themyarray["pageid"] != '')
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
    <form name="pagefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return pageabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Page
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
                Keywords
            </td>
            <td valign="top" class="frmdata">
                <textarea name="keywords" rows="2" cols="29"><?=$keywords?></textarea>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" colspan="2">
                Description
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmdata" colspan="2">
                <?php
                    
                    $oFCKeditor = new FCKeditor('description') ;
                    
                    $oFCKeditor->ToolbarSet = 'MyToolbar';
                    $oFCKeditor->BasePath = 'fckeditor/';
                    
                    $oFCKeditor->Value = html_entity_decode($description);
                    
                    $oFCKeditor->Create() ;
                ?>	
                
            </td>
        </tr>
         <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="pagesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["pageid"]?>" />
                <input type="submit" value="<?=$but_text?> Page " class="btn btn-primary">
		<?php if($themyarray["pageid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_pages.php?delid=<?=$themyarray["pageid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
