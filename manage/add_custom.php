<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

if($_POST["customsub"] == 1)
{
	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."' where customid='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_custom.php?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ins_sql = "insert into dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["status"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_custom.php?msg=<?=$msg;?>';
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

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
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
		$status = st($themyarray['status']);
		
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
    <form name="customfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return customabc(this)">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Custom Text
               <? if($title <> "") {?>
               		&quot;<?=$title;?>&quot;
               <? }?>
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
                            	 <input id="title" name="title" type="text" class="field text addr tbox" value="<?=$title;?>" tabindex="5" style="width:600px;" maxlength="255"/>
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
                            	<textarea name="description" id="description" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?=$description;?></textarea>
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
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
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
                <input type="hidden" name="ed" value="<?=$themyarray["customid"]?>" />
                <input type="submit" value=" <?=$but_text?> Custom Text" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>