<?php namespace Ds3\Legacy; ?><? include"includes/top1.htm";

$cat_sql = "select * from apnea_category where status=1 order by sortby";
$cat_my = mysql_query($cat_sql);

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
					
					
						<table width="935" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="270" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<? while($cat_myarray = mysql_fetch_array($cat_my))
										{
											$ap_sql = "select * from sleep_apnea where status=1 and categoryid='".$cat_myarray['categoryid']."' order by sortby";
											$ap_my = mysql_query($ap_sql) or die(mysql_error()." | ".$ap_sql);
											?>
											<tr>
												<td height="25" valign="top" class="suntab_head">
													<?=st($cat_myarray['category']);?>
												</td>
											</tr>
											<?	
											while($ap_myarray = mysql_fetch_array($ap_my))
											{
											?>
												<tr>
													<td height="25" valign="top" class="page3_bg2">
														<a href="about_sleep_apnea.php?said=<?=st($ap_myarray['sleep_apneaid'])?>#cont" id="page3_tabs" >
															<span <? if(st($sa_myarray['sleep_apneaid']) == st($ap_myarray['sleep_apneaid'])) {?> class="selected" <? }?>>
																<?=st($ap_myarray['title'])?>
															</span></a>
													</td>
												</tr>
												<tr>
													<td valign="top" class="" height="2"></td>
												</tr>
											<?	
											}
											?>
											<tr>
												<td height="25" valign="top" class="suntab_head">
													&nbsp;
												</td>
											</tr>
											<?
										}?>
									</table>
								</td>
								
								<td width="665" valign="top">
									<a name="cont"></a>
									<table width="640" border="0" align="right" cellpadding="5" cellspacing="1">
										<tr>
											<td width="19" valign="top"><img src="images/bullet_1.gif" width="19" height="13" /></td>
											<td width="618" valign="top" class="suntab_head">
												<?=st($sa_myarray['title']);?>
											</td>
										</tr>
										<tr>
											<td colspan="2" valign="top">
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
