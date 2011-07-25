<?php
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once('../includes/general_functions.php');

function save_image($field = null, $fieldname = null) {
	$folder = $_SERVER['DOCUMENT_ROOT'].'/manage/admin/letterhead/';
	if ((array_search($_FILES[$fieldname]["type"], $dss_image_file_types) !== false) ) {
		$sql = "select ".st($field)." from dental_users where userid = '".s_for($_POST['uid'])."';";
		$result = mysql_query($sql);
		$my = mysql_fetch_array($result);
		$imgname = $my[$field]; 

		if($_FILES[$fieldname]["name"] <> '') {
			$fname = $_FILES[$fieldname]["name"];
			$lastdot = strrpos($fname,".");
			$name = substr($fname,0,$lastdot);
			$extension = substr($fname,$lastdot+1);
			$banner1 = $name.'_'.date('dmy_Hi');
			$banner1 = str_replace(" ","_",$banner1);
			$banner1 = str_replace(".","_",$banner1);
			$banner1 .= ".".$extension;
			$uploaded = uploadImage($_FILES[$fieldname], $folder.$banner1);
			if($imgname <> '') {
				@unlink($folder.$imgname);
			}
		} else {
			$banner1 = $imgname;
		}
		
		if($uploaded) {
			$ed_sql = " update dental_users set 
			".st($field)." = '".s_for($banner1)."'
			where userid = '".s_for($_POST['uid'])."'";
			
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());				

			return true;
		} else {
			return "File is too large for $field<br />";
		}
	} else {
		return "Invalid file type for $field<br />";
	}
}

// Handle POST

if($_POST["submit_letterhead"]) {
	$result1 = $result2 = $result3 = $result4 = null; 

	if ($_FILES['emailheaderimg']["name"]) $result1 = save_image('email_header', 'emailheaderimg');
	if ($_FILES['emailfooterimg']["name"]) $result2 = save_image('email_footer', 'emailfooterimg');
	if ($_FILES['faxheaderimg']["name"]) $result3 = save_image('fax_header', 'faxheaderimg');
	if ($_FILES['faxfooterimg']["name"]) $result4 = save_image('fax_footer', 'faxfooterimg');

  if ($result1 !== true) { 
		$msg = $result1;
	} else {
		$msg = "Email Header uploaded sucessfully<br />";
	}
  if ($result2 !== true) {
		$msg .= $result2;
	} else {
		$msg .= "Email Footer uploaded successfully<br />";
	}
  if ($result3 !== true) {
		$msg .= $result3;
	} else {
 		$msg .= "Fax Header uploaded successfully<br />";
	}
  if ($result4 !== true) {
		$msg .= $result4;
	} else {
		$msg .= "Fax Footer uploaded successully<br />";
	}
}

// Query Database for User Information

$sql = "SELECT name FROM dental_users WHERE user_access = '2' AND userid = '".st($_GET['uid'])."';";
$result = mysql_query($sql);
$my = mysql_fetch_array($result);
$docname = $my['name']; 

// Query Database for Images

$sql = "SELECT email_header, email_footer, fax_header, fax_footer FROM dental_users WHERE userid = '".st($_GET['uid'])."';"; 
$result = mysql_query($sql);
$my = mysql_fetch_array($result);
$email_header_imgname = $my['email_header'];
$email_footer_imgname = $my['email_footer'];
$fax_header_imgname = $my['fax_header'];
$fax_footer_imgname = $my['fax_footer'];

?>

<script type="text/javascript">
	$(document).ready(function() {
		$('.toggle_but').click(function() {
			var r = confirm("Do you want to replace the image on file? This cannot be undone.");
			if (r == true) {
				var prefix = $(this).attr('id');
				$('#'+prefix+'view').css("display", "none");
				$('#'+prefix).css("display", "none");
				$('#'+prefix+'img').css("display", "inline");
			}
		});
	});
</script>

<span class="admin_head">
	Update Letterhead for <?= $docname ?>
</span>

<div><?php print $msg; ?></div>

<form name="letterhead" action="<?=$_SERVER['PHP_SELF'];?>?uid=<?=$_GET['uid'];?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="uid" value="<?=$_GET['uid'];?>" />
<table>
<tr>
	<td colspan="2"><h2>Email Images</h2></td>
</tr>
<tr>
	<td><h3>Email Header</h3></td>
	<td>
		<?php if (empty($email_header_imgname)): ?>
		<input id="emailheaderimg" name="emailheaderimg" type="file" size="4" />
		<?php else: ?>
		<input type="button" id="email_header_view" value="View" title="View" onClick="window.open('/manage/admin/letterhead/<?= $email_header_imgname ?>','windowname1','width=860, height=790,scrollbars=yes');return false;" />
		<input type="button" class="toggle_but" id="emailheader" value="Edit" title="Edit" />
		<input id="emailheaderimg" style="display:none;" name="emailheaderimg" type="file" size="4" />
		<?php endif; ?>
	</td>
<tr>
	<td><h3>Email Footer</h3></td>
	<td>
		<?php if (empty($email_footer_imgname)): ?>
		<input id="emailfooterimg" name="emailfooterimg" type="file" size="4" />
		<?php else: ?>
		<input type="button" id="email_footer_view" value="View" title="View" onClick="window.open('/manage/admin/letterhead/<?= $email_footer_imgname ?>','windowname1','width=860, height=790,scrollbars=yes');return false;" />
		<input type="button" class="toggle_but" id="emailfooter" value="Edit" title="Edit" />
		<input id="emailfooterimg" style="display:none;" name="emailfooterimg" type="file" size="4" />
		<?php endif; ?>
	</td>
</tr>
<tr>
	<td colspan="2"><h2>Fax Images</h2></td>
</tr>
<tr>
	<td><h3>Fax Header</h3></td>
	<td>
		<?php if (empty($fax_header_imgname)): ?>
		<input id="faxheaderimg" name="faxheaderimg" type="file" size="4" />
		<?php else: ?>
		<input type="button" id="fax_header_view" value="View" title="View" onClick="window.open('/manage/admin/letterhead/<?= $fax_header_imgname ?>','windowname1','width=860, height=790,scrollbars=yes');return false;" />
		<input type="button" class="toggle_but" id="faxheader" value="Edit" title="Edit" />
		<input id="faxheaderimg" style="display:none;" name="faxheaderimg" type="file" size="4" />
		<?php endif; ?>
	</td>
</tr>
<tr>
	<td><h3>Fax Footer</h3></td>
	<td>
		<?php if (empty($fax_footer_imgname)): ?>
		<input id="faxfooterimg" name="faxfooterimg" type="file" size="4" />
		<?php else: ?>
		<input type="button" id="fax_footer_view" value="View" title="View" onClick="window.open('/manage/admin/letterhead/<?= $fax_footer_imgname ?>','windowname1','width=860, height=790,scrollbars=yes');return false;" />
		<input type="button" class="toggle_but" id="faxfooter" value="Edit" title="Edit" />
		<input id="faxfooterimg" style="display:none;" name="faxfooterimg" type="file" size="4" />
		<?php endif; ?>
	</td>
</tr>
<tr>
	<td><input name="submit_letterhead" type="submit" value="Submit" /></td>
</tr>
</table>
</form>

<?php
include "includes/bottom.htm";
?>
