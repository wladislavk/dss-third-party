<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");

if($_POST["custom_textsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_custom set 
			title = '".mysql_real_escape_string($_POST["title"])."', 
			description = '".mysql_real_escape_string($_POST["description"])."'
			where customid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
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
			title = '".mysql_real_escape_string($_POST["title"])."',
			description = '".mysql_real_escape_string($_POST["description"])."',
			adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', docid=".$_GET['docid'];
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

    <?
    $thesql = "select * from dental_custom where customid='".$_REQUEST["ed"]."'";
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
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="transaction_codefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&docid=<?= $_GET['docid']; ?>" method="post">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
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
                <input type="text" name="title" value="<?=$title?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
            	<textarea class="tbox" name="description" style="width:100%;"><?=$description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="custom_textsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["customid"]?>" />
                <input type="submit" value=" <?=$but_text?> Custom Text" class="button" />
		<?php if($themyarray["customid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_doctor_custom_text.php?delid=<?=$themyarray["customid"];?>&docid=<?= $_GET['docid']; ?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
  
</body>
</html>
