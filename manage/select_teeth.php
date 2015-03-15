<?php namespace Ds3\Libraries\Legacy; ?><?php
	include "admin/includes/main_include.php";

	if(!empty($_POST['selsub']) && $_POST['selsub'] == 1) {
		$per_teeth = $_POST['per_teeth'];
		$pri_teeth = $_POST['pri_teeth'];
		
		$t_text = '';
		if(is_array($pri_teeth)) {
			asort($pri_teeth);
			$t_text .= implode(', ',$pri_teeth);
		}
	
		if(is_array($per_teeth)) {
			if($t_text <> '' ) {
				$t_text .= ', ';
			}
			
			asort($per_teeth);
			$t_text .= implode(', ',$per_teeth);
		}
	
?>
		<script type="text/javascript">
			var old = parent.document.ex_page4frm.<?php echo $_GET['tx']?>.value;
			parent.document.ex_page4frm.<?php echo $_GET['tx']?>.value = '<?php echo $t_text;?>';
			if(old != '<?php echo  $t_text; ?>'){
				parent.edited = true;
			}

			parent.disablePopupRefClean();
			if("<?php echo  $_GET['tx']; ?>" == "missing"){
				parent.reloadPerio("<?php echo $t_text; ?>");
			}
		</script>
<?php
	}

	$mt_arr = explode(',',(!empty($_GET['fval']) ? $_GET['fval'] : ''));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="keywords" content="<?php echo st((!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : ''));?>" />
		<title><?php echo $sitename;?></title>
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
	</head>

	<body>
		<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
		    <tr bgcolor="#FFFFFF">
			    <td> 
					<br />
					<form name="selfrm" action="<?php echo $_SERVER['PHP_SELF']?>?tx=<?php echo (!empty($_GET['tx']) ? $_GET['tx'] : '');?>" method="post">
						<span class="admin_head">
							<?php echo ucwords((!empty($_GET['tx']) ? $_GET['tx'] : ''));?> Teeth # <input type="submit" value="save" />
						</span>
						<div style="clear:both"></div>
						<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
							<tr>
								<td valign="top" colspan="2" width="50%" >
						            <table width="80%" cellpadding="1" cellspacing="1" border="0">
						            	<tr class="tr_bg_h">
						                	<td valign="top" class="col_head" colspan="2" class="col_head">
					                    		Permanent Teeth
					                    	</td>
					                	</tr>
						                <?php 
											$j = 17;
											for($i = 1; $i < 17; $i++) {
												if($i < 10)
													$i = '0' . $i;
										?>
								                    <tr>	
								                        <td valign="top" width="50%" height="10">
								                        	<input type="checkbox" name="per_teeth[]" value="<?php echo $i?>" <?php if(in_array($i,$mt_arr)) { echo " checked";}?> />
								                            <?php echo $i;?>
								                        </td>
								                        <td valign="top" width="50%">
								                        	<input type="checkbox" name="per_teeth[]" value="<?php echo $j?>" <?php if(in_array($j,$mt_arr)) { echo " checked";}?> />
								                            <?php echo $j;?>
								                        </td>
								                    </tr>
						                <?php 
													$j++;
											}
										?>
					            	</table>
								</td>
								<td valign="top" colspan="2" width="50%">
					             	<table width="80%" cellpadding="3" cellspacing="1" border="0">
						            	<tr class="tr_bg_h">
						                	<td valign="top" class="col_head" colspan="2" class="col_head">
						                    	Primary Teeth
						                    </td>
						                </tr>
						                <?php 
											$j = "K";
											for($i = 'A'; $i < 'K'; $i++) {
										?>
							                    <tr bgcolor="#FFFFFF">	
							                        <td valign="top" width="50%">
							                        	<input type="checkbox" name="pri_teeth[]" value="<?php echo $i?>" <?php if(strpos((!empty($_GET['fval']) ? $_GET['fval'] : ''),$i) === false) {} else { echo " checked";}?> />
							                            <?php echo $i;?>
							                        </td>
							                        <td valign="top" width="50%">
							                        	<input type="checkbox" name="pri_teeth[]" value="<?php echo $j?>"  <?php if(strpos((!empty($_GET['fval']) ? $_GET['fval'] : ''),$j) === false) {} else { echo " checked";}?> />
							                            <?php echo $j;?>
							                        </td>
							                    </tr>
					                	<?php 
												$j++;
											}
										?>
					            	</table>
					            	<input type="hidden" name="selsub" value="1" />
								</td>
							</tr>
						</table>
					</form>

					<script type="text/javascript" src="/manage/js/select_teeth.js"></script>

					<br /><br />
				</td>
			</tr>
		</table>
	</body>
</html>
