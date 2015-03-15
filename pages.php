<?php namespace Ds3\Legacy; ?><?php include 'includes/top.htm';?>
<table width="960" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="98" valign="top" class="head_bg1" style="padding-top:10px;">
			<table width="940" border="0" align="center" cellpadding="5" cellspacing="1">
				<tr>
					<td class="head_text">
						<?=st($page_myarray['title']);?>
					</td>
				</tr>
				<tr>
					<td class="linetile"></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="940" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="340" valign="top" style="padding-top:5px;">
									<? include"includes/right.htm"?>
								</td>
								<td width="620" valign="top" style="padding-top:5px; padding-left:10px;">
									<?=html_entity_decode(st($page_myarray['description']));?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include 'includes/bottom.htm';?>
