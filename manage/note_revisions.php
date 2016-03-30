<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	$sql = "select * from dental_notes where docid='".$_SESSION['docid']."' ";
	$sql .= " and parentid = '".(!empty($_GET['nid']) ? $_GET['nid'] : '')."' ";
	$sql .= " order by adddate DESC";
	$my = $db->getResults($sql);
	$num_users = count($my);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="css/form.css" type="text/css" />
		<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
		<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
		<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="script/validation.js"></script>
	</head>
	<body>
		<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
		<script src="admin/popup/popup.js" type="text/javascript"></script>
		<br />

		<span class="admin_head" style="color:#fff">
			View Progress Notes
		</span>
		<br />
		<div align="center" class="red">
			<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
		</div>

		<table width="15%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="right" >
			<tr>
				<td valign="top" bgcolor="#FF9999">
				&nbsp;&nbsp;&nbsp;
				</td>
				<td valign="top">
					&nbsp;&nbsp;
					<b>Edited Note</b>
				</td>
			</tr>
		</table>

		<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
			<?php if($num_users == 0) { ?>
				<tr class="tr_bg">
					<td valign="top" class="col_head" colspan="10" align="center">
						No Records
					</td>
				</tr>
			<?php } else {
				foreach ($my as $myarray) {
					if($myarray["status"] == 1) {
						$tr_class = "tr_active";
					} else {
						$tr_class = "tr_inactive";
					}

					$tr_class = "tr_active";
					$user_sql = "SELECT * FROM dental_users where userid='".st($myarray["userid"])."'";
					
					$user_myarray = $db->getRow($user_sql);
			?>
					<tr class="<?php echo $tr_class;?>" <?php if(st($myarray["edited"]) == 1) {?> style="background-color:#FF9999" <?php }?>>
						<td valign="top">
							<table width="100%" cellpadding="2" cellspacing="1" border="0">
								<tr>
									<td valign="top" width="50%">
										Entry Date: 
										<span style="font-weight:normal;">
											<?php echo date('M d, Y H:i',strtotime(st($myarray["adddate"])));?>
										</span>
                                        Procedure Date:
                                        <span style="font-weight:normal;">
                                            <?php echo ($myarray["procedure_date"]!='')?date('M d, Y',strtotime(st($myarray["procedure_date"]))):'';?>
                                        </span>
									</td>
									<td valign="top">
										Added By: 
										<span style="font-weight:normal;">
											<?php echo st($user_myarray["name"]);?>
										</span>
									</td>
								</tr>
								<tr>
									<td valign="top" colspan="2">
										<hr size="1" />
										<span style="font-weight:normal;">
											<?php echo nl2br(st($myarray["notes"]));?>
										</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
			<?php 
				}
			}
			?>
		</table>

	<div id="popupContact" style="width:750px;">
	    <a id="popupContactClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>

	<div id="backgroundPopup"></div>

	<br /><br />
	
	</body>
</html>
