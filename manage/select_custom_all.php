<?php 
	include "admin/includes/main_include.php";

	if($_POST['selsub'] == 1) {
?>
		<script type="text/javascript">
			parent.document.<?php echo $_GET['fr'];?>.<?php echo $_GET['tx'];?>.value = '<?php echo addslashes(preg_replace('/\r\n|\n\r/',' ', $_POST['description']));?>';
			parent.disablePopupRefClean();
		</script>
<?php
		die();
	}

	$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
	
	$my = $db->getResults($sql);
	$total_rec = count($my);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="keywords" content="<?php echo st($page_myarray['keywords']);?>" />
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
					<span class="admin_head">
						Select Custom Text
					</span>
					<br />&nbsp;

					<?php
						$title_arr = array();
						$desc_arr = array();

						if ($my) foreach ($my as $myarray) {
							$title_arr[] = st($myarray['title']);
							$desc_arr[] = st($myarray['description']);
						}

						$title_str = json_encode($title_arr);
						$desc_str = json_encode($desc_arr);
					?>

					<script type="text/javascript">
						var title_arr = <?php echo $title_str; ?>;
						var desc_arr = <?php echo $desc_str; ?>;
					</script>

					<script type="text/javascript" src="/manage/js/select_custom.js"></script>

					<form name="selfrm" action="<?php echo $_SERVER['PHP_SELF']?>?fr=<?php echo $_GET['fr'];?>&tx=<?php echo $_GET['tx'];?>" method="post" onSubmit="return selabc(this)">
						<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
							<tr class="tr_bg_h">
								<td valign="top" class="col_head" >
									Title: 
						            <select name="title" class="tbox" onChange="change_desc(this.value)">
						            	<option value="">Select</option>
						                <?php 
											$j = 0;
											if ($my) foreach ($my as $myarray) {
										?>
												<option value="<?php echo $j;?>">
							                    	<?php echo st($myarray['title']);?>
							                    </option>
										<?php 
												$j++;
											}
										?>
						            </select>
								</td>
							</tr>
						    <tr class="tr_bg_h">
								<td valign="top" class="col_data" >
						        	<textarea name="description" id="description" class="tbox" style="width:98%; height:150px;"></textarea>
								</td>
							</tr>
						    <tr class="tr_bg_h">
								<td valign="top" class="col_head" >
						        	<input type="hidden" name="selsub" value="1" />
						        	<input type="submit" name="selbtn" value="Insert into Form" />
								</td>
							</tr>
						</table>
					</form>
					<br /><br />
				</td>
			</tr>
		</table>
	</body>
</html>