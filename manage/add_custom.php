<?php namespace Ds3\Libraries\Legacy; ?><?php 
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");

    if(!empty($_POST["customsub"]) && $_POST["customsub"] == 1) {
    	if($_POST["ed"] != "") {
    		$ed_sql = "update dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."' where customid='".$_POST["ed"]."'";
    		
            $db->query($ed_sql);
    		$msg = "Edited Successfully";
?>
    		<script type="text/javascript">
    			parent.window.location = 'manage_custom.php?msg=<?php echo $msg;?>';
    		</script>
    		<?
    		trigger_error("Die called", E_USER_ERROR);
    	} else {
    		$ins_sql = "insert into dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["status"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
    		
            $db->query($ins_sql);
    		$msg = "Added Successfully";
?>
    		<script type="text/javascript">
    			parent.window.location = 'manage_custom.php?msg=<?php echo $msg;?>';
    		</script>
<?php
    		trigger_error("Die called", E_USER_ERROR);
    	}
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
        <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
        <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="script/validation.js"></script>
    </head>

    <body>
    <?php
        $thesql = "select * from dental_custom where customid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
    	
    	$themyarray = $db->getRow($thesql);
    	
    	if(!empty($msg)) {
    		$title = $_POST['title'];
    		$description = $_POST['description'];
    	} else {
    		$title = st($themyarray['title']);
    		$description = st($themyarray['description']);
    		$status = st($themyarray['status']);
    		$but_text = "Add ";
    	}
    	
    	if($themyarray["customid"] != '') {
    		$but_text = "Edit ";
    	} else {
    		$but_text = "Add ";
    	}
	?>
	<br /><br />
	<?php if(!empty($msg)) {?>
        <div align="center" class="red">
            <?php echo $msg;?>
        </div>
    <?php }?>
    <form name="customfrm" action="insert_custom.php?add=1" method="post" onSubmit="return customabc(this)">
        <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr>
                <td colspan="2" class="cat_head">
                   <?php echo $but_text?> Custom Text
                   <?php if($title <> "") {?>
                   		&quot;<?php echo $title;?>&quot;
                   <?php }?>
                </td>
            </tr>
            <tr> 
            	<td valign="top" colspan="2" class="frmhead">
                	<ul>
                		<li id="foli8" class="complex">	
                        	<label class="desc" id="title0" for="Field0">
                                Title:
                                <span id="req_0" class="req">*</span>
                           	</label>
                           	<div>
                                <span class="full">
                                	 <input id="title" name="title" type="text" class="field text addr tbox" value="<?php echo $title;?>" tabindex="5" style="width:600px;" maxlength="255"/>
                                </span>
                                <label>&nbsp;</label>
    						</div>
                        </li>
    				</ul>
                </td>
            </tr>
    		<tr> 
            	<td valign="top" colspan="2" class="frmhead">
                	<ul>
                		<li id="foli8" class="complex">	
                        	 <label class="desc" id="title0" for="Field0">
                                Description:
                                <span id="req_0" class="req">*</span>
                            </label>
                            <div>
                                <span class="full">
                                	<textarea name="description" id="description" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?php echo $description;?></textarea>
                                </span>
                                <label>&nbsp;</label>
                            </div>
                        </li>
    				</ul>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Status
                </td>
                <td valign="top" class="frmdata">
                	<select name="status" class="tbox" tabindex="22">
                    	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                    	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                    </select>
                    <br />&nbsp;
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="customsub" value="1" />
                    <input type="hidden" name="ed" value="<?php echo $themyarray["customid"]?>" />
                    <input type="submit" value=" <?php echo $but_text?> Custom Text" class="button" />
    		        <?php if($themyarray['customid']!=''){ ?>
                        <a style="float:right;" href="manage_custom.php?delid=<?php echo $themyarray["customid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE" target="_parent">
                            Delete 
                        </a>
    		        <?php } ?>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
