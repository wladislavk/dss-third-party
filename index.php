<?php namespace Ds3\Legacy; ?><? include"includes/top.htm";

$home_sql = "select * from homepage";
$home_my = mysql_query($home_sql);
$home_myarray = mysql_fetch_array($home_my);
?>  
	<table width="960" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top">
				<table width="960" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="620" valign="top">
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="618" height="268">
								<param name="movie" value="images/dental_7.swf">
								<param name="quality" value="high">
								<embed src="images/dental_7.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="618" height="268"></embed>
							</object>
						</td>
						<td width="340" align="right" valign="top">
							<table width="337" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="left" valign="top">
										<a href="about_sleep_apnea.php"><img src="images/tab1.jpg" width="341" height="88" border="0" /></a>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">
										<a href="pages.php?pid=6"><img src="images/tab2.jpg" width="341" height="93" border="0" /></a>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">
										<a href="pages.php?pid=4"><img src="images/tab3.jpg" width="341" height="97" border="0" /></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="3" valign="top" bgcolor="#145D97"></td>
		</tr>
		<tr>
			<td valign="top">
				<table width="960" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="340" valign="top" style="padding-top:5px;">
							<? include"includes/right.htm"?>
						</td>
						<td width="620" valign="top" style="padding-top:5px;">
							<?=html_entity_decode(st($home_myarray['description']));?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<? include"includes/bottom.htm"?>
