<?php namespace Ds3\Libraries\Legacy; ?><? 
include "includes/top.htm";
include "fckeditor/fckeditor.php";

if($_POST["homepagesub"] == 1)
{
	$ed_sql = "update homepage set description = '".s_for($_POST["description"])."'";
	mysqli_query($con, $ed_sql);
	
	//echo $ed_sql.mysqli_error($con);
	$msg = "Edited Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		window.location='manage_homepage.php?msg=<?=$msg;?>';
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$thesql = "select * from homepage";
$themy = mysqli_query($con, $thesql);
$themyarray = mysqli_fetch_array($themy);

$description = st($themyarray['description']);

$but_text = "Add ";

if($themyarray["homepageid"] != '')
{
	$but_text = "Edit ";
}
else
{
	$but_text = "Add ";
}
?>

<span class="admin_head">
	Manage Homepage
</span>
<br />
<br />

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<br />
<form name="homepagefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr bgcolor="#FFFFFF">
		<td valign="top" class="frmdata" colspan="2">
			<?php
				
				$oFCKeditor = new FCKeditor('description') ;
				
				$oFCKeditor->ToolbarSet = 'MyToolbar';
				$oFCKeditor->BasePath = 'fckeditor/';
				$oFCKeditor->Height = '350';
				
				$oFCKeditor->Value = html_entity_decode($description);
				
				$oFCKeditor->Create() ;
			?>		
		</td>
	</tr>
	<tr>
		<td  colspan="2" align="center">
			<input type="hidden" name="homepagesub" value="1" />
			<input type="hidden" name="ed" value="<?=$themyarray["homepageid"]?>" />
			<input type="submit" value=" <?=$but_text?> Homepage " class="button" />
		</td>
	</tr>
</table>
</form>

<br /><br />	
<? include "includes/bottom.htm";?>
