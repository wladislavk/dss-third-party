<?php namespace Ds3\Legacy; ?><?php 
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
if(!empty($_POST["notesub"]) && $_POST["notesub"] == 1){
	$referredby_notes = $_POST['referredby_notes'];

	$up_sql = "update dental_contact set 
				referredby_notes = '".mysqli_real_escape_string($con,$referredby_notes)."'
				where contactid='".$_POST["rid"]."'";

	$db->query($up_sql);

	$msg = "Edited Successfully";?>
	<script type="text/javascript">
		//alert("<?php echo $msg;?>");
		parent.window.location='manage_referredby.php?msg=<?php echo $msg;?>';
	</script>
<?php
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
<?php
	
$thesql = "select * from dental_contact where contactid='".(!empty($_REQUEST["rid"]) ? $_REQUEST["rid"] : '')."'";
$themyarray = $db->getRow($thesql);

$referredby_notes = st($themyarray['referredby_notes']);?>
	
<br /><br />
	
<form name="notesfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               	Referred By Notes
            </td>
        </tr>
		<tr>
        	<td valign="top" class="frmdata">
				<textarea id="referredby_notes" name="referredby_notes" class="tbox" style="width:100%; height:200px;"><?php echo $referredby_notes;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="notesub" value="1" />
                <input type="hidden" name="rid" value="<?php echo (!empty($_REQUEST["rid"]) ? $_REQUEST["rid"] : '')?>" />
                <input type="submit" value=" Edit Notes" class="button" />
            </td>
        </tr>
    </table>
</form>
</body>
</html>
