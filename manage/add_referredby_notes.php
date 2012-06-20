<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
if($_POST["notesub"] == 1)
{
	$referredby_notes = $_POST['referredby_notes'];
	
		$up_sql = "update dental_contact set 
		referredby_notes = '".mysql_real_escape_string($referredby_notes)."'
	 	where contactid='".$_POST["rid"]."'";
		
		mysql_query($up_sql) or die($up_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_referredby.php?msg=<?=$msg;?>';
		</script>
		<?
		die();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/form.css" type="text/css" />
</head>
<body>
    <?
	
    $thesql = "select * from dental_contact where contactid='".$_REQUEST["rid"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	$referredby_notes = st($themyarray['referredby_notes']);
	
	?>
	
	<br /><br />
	
    <form name="notesfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               	Referred By Notes
            </td>
        </tr>
		<tr>
        	<td valign="top" class="frmdata">
				<textarea id="referredby_notes" name="referredby_notes" class="tbox" style="width:100%; height:200px;"><?=$referredby_notes;?></textarea>
            </td>
        </tr>
        
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="notesub" value="1" />
                <input type="hidden" name="rid" value="<?=$_REQUEST["rid"]?>" />
                <input type="submit" value=" Edit Notes" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
