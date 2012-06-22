<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
if($_POST["contactsub"] == 1)
{

	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_locations set location = '".s_for($_POST["location"])."' where id='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_locations.php?docid=<?= $_POST['docid']; ?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
	
		$ins_sql = "insert into dental_locations set location = '".s_for($_POST["location"])."', docid='".$_POST['docid']."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		
		$msg = "Added Successfully";
		
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_locations.php?docid=<?= $_POST['docid']; ?>&msg=<?=$msg;?>';
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
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../script/validation.js"></script>

<link rel="stylesheet" href="../css/form.css" type="text/css" />
<script type="text/javascript" src="../script/wufoo.js"></script>
</head>
<body>

    <?
    $thesql = "select * from dental_locations where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$location = $_POST['location'];
	}
	else
	{
		$location = st($themyarray['location']);
		
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
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> <?php echo $_GET['heading']; ?> Location 
               <? if($location <> "") {?>
               		&quot;<?=$location;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr>
        	<td valign="top" class="frmhead">
				<ul>        
                    <li id="foli8" class="complex">	
                        <div>
                        	<span>
                            	<input type="text" name="location" id="location" value="<?= $location; ?>" class="field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="location">Location</label>
                            </span>
                       </div>   
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td  align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="contactsub" value="1" />
		<input type="hidden" name="docid" value="<?= $_GET['docid']; ?>" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Location" class="button" />
		<?php  if($themyarray["id"] != ''){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_locations.php?delid=<?=$themyarray["id"];?>&docid=<?=$_GET['docid']?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                Delete
                                        </a>
                 <?php } ?>
            </td>
        </tr>
    </table>
    </form>





      </div>
<div style="margin:0 auto;background:url(images/dss_05.png) no-repeat top left;width:980px; height:28px;"> </div>
  </td>
</tr>
<!-- Stick Footer Section Here -->
</table>
</body>
</html>
