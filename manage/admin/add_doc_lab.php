<?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");
include "fckeditor/fckeditor.php";

if(!empty($_POST["doc_labub"]) && $_POST["doc_labub"] == 1)
{
	if(s_for($_POST["sortby"]) == '' || is_numeric(s_for($_POST["sortby"])) === false)
	{
		$sby = 999;
	}
	else
	{
		$sby = s_for($_POST["sortby"]);
	}
	
	$doc_id = '';
	if(!empty($_POST['docid']) && count($_POST['docid']) <> 0)
	{
		$doc_arr = '~';
		foreach($_POST['docid'] as $doc_val)
		{
			if($doc_val <> '')
			{
				$doc_arr .= $doc_val.'~';
			}
		}
	}
	if(!empty($doc_arr) && $doc_arr != '~')
		$doc_id = $doc_arr;
		
		
	
	if(!empty($_POST['remove_video']) && $_POST['remove_video'] == 1)
	{
		$banner1 = '';
		@unlink("../video_file/".$_POST['video_file_old']);
	}
	else
	{
		if($_FILES["video_file"]["name"] <> '')
		{
			$fname = $_FILES["video_file"]["name"];
			$lastdot = strrpos($fname,".");
			$name = substr($fname,0,$lastdot);
			$extension = substr($fname,$lastdot+1);
			$banner1 = $name.'_'.date('dmy_Hi');
			$banner1 = str_replace(" ","_",$banner1);
			$banner1 = str_replace(".","_",$banner1);
			$banner1 .= ".".$extension;
			
			@move_uploaded_file($_FILES["video_file"]["tmp_name"],"../video_file/".$banner1);
			@chmod("../video_file/".$banner1,0777);
			
			if($_POST['video_file_old'] <> '')
			{
				@unlink("../video_file/".$_POST['video_file_old']);
			}
		}
		else
		{
			$banner1 = $_POST['video_file_old'];
		}
	}
	
	if(!empty($_POST['remove_doc']) && $_POST['remove_doc'] == 1)
	{
		$banner2 = '';
		@unlink("../doc_file/".$_POST['doc_file_old']);
	}
	else
	{
		if($_FILES["doc_file"]["name"] <> '')
		{
			$fname = $_FILES["doc_file"]["name"];
			$lastdot = strrpos($fname,".");
			$name = substr($fname,0,$lastdot);
			$extension = substr($fname,$lastdot+1);
			$banner2 = $name.'_'.date('dmy_Hi');
			$banner2 = str_replace(" ","_",$banner2);
			$banner2 = str_replace(".","_",$banner2);
			$banner2 .= ".".$extension;
			
			@move_uploaded_file($_FILES["doc_file"]["tmp_name"],"../doc_file/".$banner2);
			@chmod("../doc_file/".$banner2,0777);
			
			if($_POST['doc_file_old'] <> '')
			{
				@unlink("../doc_file/".$_POST['doc_file_old']);
			}
		}
		else
		{
			$banner2 = $_POST['doc_file_old'];
		}
	}
	
	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_doc_lab set title = '".s_for($_POST["title"])."', docid = '".s_for($doc_id)."', description = '".s_for($_POST["description"])."', video_file = '".s_for($banner1)."', doc_file = '".s_for($banner2)."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."' where doc_labid='".$_POST["ed"]."'";
		mysqli_query($con,$ed_sql);
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_doc_lab.php?msg=<?php echo $msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ins_sql = "insert into dental_doc_lab set title = '".s_for($_POST["title"])."', docid = '".s_for($doc_id)."', description = '".s_for($_POST["description"])."', video_file = '".s_for($banner1)."', doc_file = '".s_for($banner2)."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($con,$ins_sql);
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_doc_lab.php?msg=<?php echo $msg;?>';
		</script>
		<?
		die();
	}
}

?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_doc_lab where doc_labid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);

	$title = st($themyarray['title']);
	$description = st($themyarray['description']);
	$video_file = $themyarray['video_file'];
	$doc_file = $themyarray['doc_file'];
	$status = st($themyarray['status']);
	$sortby = st($themyarray['sortby']);
	$but_text = "Add ";
	$docid = st($themyarray['docid']);
	
	if(empty($show_to) && empty($docid))
	{
		$show_to = 0;
	}
	else
	{
		$show_to = 1;
	}
	
	
	if($themyarray["doc_labid"] != '')
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
    <form name="doc_labfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return doc_lababc(this)" enctype="multipart/form-data">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Dental Appliance Lab Info
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
                <input type="text" name="title" value="<?php echo $title?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
				Video File
            </td>
            <td valign="top" class="frmdata">
				<?php if($video_file <> '') {?>
					<a href="preview.php?fn=<?php echo $video_file;?>" target="_blank">
						<b>Preview</b></a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="remove_video" value="1" />
					<br />
				<?php }?>
				<input type="file" name="video_file" value="" size="26" />
				<input type="hidden" name="video_file_old" value="<?php echo $video_file;?>" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
				Material File
            </td>
            <td valign="top" class="frmdata">
				<?php if($doc_file <> '') {?>
					<a href="../doc_file/<?php echo $doc_file;?>" target="_blank">
						<b>Preview</b></a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="remove_doc" value="1" />
					<br />
				<?php }?>
				<input type="file" name="doc_file" value="" size="26" />
				<input type="hidden" name="doc_file_old" value="<?php echo $doc_file;?>" />
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
                    $oFCKeditor->Height = '300';
                    
                    $oFCKeditor->Value = html_entity_decode($description);
                    
                    $oFCKeditor->Create() ;
                ?>	
                
            </td>
        </tr>
		<tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Show to 
            </td>
            <td valign="top" class="frmdata">
            	<?php 
				$doc_sql = "select * from dental_users where status=1 and docid=0 order by username";
				$doc_my = mysqli_query($con,$doc_sql);
				?>
            	<input type="radio" name="show_to" value="0" <?php if($show_to == 0) echo " checked";?> />
                <b>ALL Doctors</b>
                
                <br />
                ------------ <b>OR</b> -----------
                <br />
                <input type="radio" name="show_to" value="1" <?php if($show_to == 1) echo " checked";?> />
                <b>Select Doctor from the List</b>
                <br />
                
                <select name="docid[]" multiple="multiple" size="5" class="form-control">
                	<?php while($doc_myarray = mysqli_fetch_array($doc_my))
					{?>
                    	<option value="<?php echo st($doc_myarray['userid'])?>"  <?php if(strpos($docid,'~'.st($doc_myarray['userid']).'~') === false){ } else { echo " selected";}?>>
                        	<?php echo st($doc_myarray['username'])?>
                        </option>
                    <?php }?>
                </select>
                <br />
                (Press Ctrl for Multiple Selection)
            </td>
        </tr>
		 <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?php echo $sortby;?>" class="form-control" style="width:30px"/>		
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control">
                	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="doc_labub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["doc_labid"]?>" />
                <input type="submit" value="<?php echo $but_text?> Dental Appliance Lab Info " class="btn btn-primary">
		<?php if($themyarray["doc_labid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_doc_lab.php?delid=<?php echo $themyarray["doc_labid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
