<?php namespace Ds3\Libraries\Legacy; ?><?
include "admin/includes/config.php";

$page_sql = "select * from p_pages where status=1 and  p_pageid='".s_for($_GET['pid'])."'";
$page_my = mysqli_query($con, $page_sql);
$page_myarray = mysqli_fetch_array($page_my);

$top_image = st($page_myarray['top_image']);
$page_title = st($page_myarray['title']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$site_name;?> <? if($page_title <> '' ) echo " | ".$page_title;?></title>
<link href="css/popup.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<table width="520" border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left" valign="top" class="page3_popbg_1" style="padding:5px;">
				<table width="98%" border="0" align="center" cellpadding="7" cellspacing="1" class="page3_popbg_2">
					<tr>
						<td align="left" valign="top" class="page3_bg1">
							<span class=""><?=st($page_myarray['title']);?></span>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top"  class="p_align">
							<?=html_entity_decode(st($page_myarray['description']));?>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
