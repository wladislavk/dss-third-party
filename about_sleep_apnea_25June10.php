<? include"includes/top1.htm";

$all_sql = "select * from sleep_apnea where status=1 order by sortby";
$all_my = mysql_query($all_sql);
?>   

<table width="960" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="98" valign="top" class="head_bg1" style="padding-top:10px;">
			<table width="940" border="0" align="center" cellpadding="5" cellspacing="1">
				<tr>
					<td class="head_text">
						About Sleep Apnea
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
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td valign="top" class="green_pageshead_1">&nbsp;</td>
										</tr>
										<? while($all_myarray = mysql_fetch_array($all_my))
										{?>
										<tr>
											<td valign="top" class="page3_bg2" style="padding-left:3px;">
												<a href="about_sleep_apnea.php?said=<?=st($all_myarray['sleep_apneaid'])?>#cont" id="greenpage3_tabs" >
													<span <? if(st($sa_myarray['sleep_apneaid']) == st($all_myarray['sleep_apneaid'])) {?> class="selected" <? }?>>
														<?=st($all_myarray['title'])?>
													</span></a>
											</td>
										</tr>
										<tr>
											<td valign="top" class="page3_bg2 line"></td>
										</tr>
										<? }?>
									</table>
								</td>
								<td width="620" valign="top" style="padding-top:5px; padding-left:10px;">
									
									<a name="cont"></a>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" >
										<tr>
											<td valign="top" class="green_pageshead_1">
												<?=st($sa_myarray['title']);?>
											</td>
										</tr>
										<tr>
											<td valign="top" class="page3_bg2">
											
												<?=html_entity_decode(st($sa_myarray['description']));?>
												
											</td>
										</tr>
									</table>
			
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<? include"includes/bottom.htm"?>