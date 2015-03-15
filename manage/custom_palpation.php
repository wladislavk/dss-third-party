<?php namespace Ds3\Legacy; ?><?php include "admin/includes/main_include.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="keywords" content="<?php echo st(!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : '');?>" />
		<title><?php echo $sitename;?></title>
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
	</head>

	<body>
	<?php 
		if(!empty($_REQUEST["delid"])) {
			$del_sql = "delete from dental_palpation where palpationid='" . $_REQUEST["delid"] . "'";
			
			$db->query($del_sql);
			$msg = "Deleted Successfully";
	?>
			<script type="text/javascript">
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
			</script>
	<?php
			die();
		}

		$rec_disp = 20;

		if(!empty($_REQUEST["page"])) {
			$index_val = $_REQUEST["page"];
		} else {
			$index_val = 0;
		}
			
		$i_val = $index_val * $rec_disp;
		$sql = "select * from dental_palpation order by sortby";

		$total_rec = $db->getNumberRows($sql);
		$no_pages = $total_rec/$rec_disp;
		$sql .= " limit ".$i_val.",".$rec_disp;

		$my = $db->getResults($sql);
		$num_users = count($my);

		if(!empty($_POST['sortsub']) && $_POST['sortsub'] == 1) {
			foreach($_POST['sortby'] as $val) {
				$smyarray = $my[0];
				if($val == '' || is_numeric($val) === false) {
					$val = 999;
				}
				$up_sort_sql = "update dental_palpation set sortby='".s_for($val)."' where palpationid='".$smyarray["palpationid"]."'";
				
				$db->query($up_sort_sql);
			}
			$msg = "Sort By Changed Successfully";
	?>
			<script type="text/javascript">
				window.location.replace("<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>");
				disablePopupRefClean();
			</script>
	<?php
			die();
		}
	?>

	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<script src="admin/popup/popup1.js" type="text/javascript"></script>

	<span class="admin_head">
		Customize Palpation
	</span>
	<br /><br />
	<div align="right">
		<button onclick="Javascript: loadPopup('add_palpation.php');" class="addButton">
			Add New Palpation
		</button>
		&nbsp;&nbsp;
	</div>
	<br />
	<div align="center" class="red">
		<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
	</div>

	&nbsp;
	<b>Total Records: <?php echo $total_rec;?></b>
	<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<?php if($total_rec > $rec_disp) {?>
			<tr bgColor="#ffffff">
				<td  align="right" colspan="15" class="bp">
					Pages:
					<?php
						paging($no_pages,$index_val,"");
					?>
				</td>        
			</tr>
		<?php } ?>
		<tr class="tr_bg_h">
			<td valign="top" class="col_head" width="80%">
				Palpation		
			</td>
			<td valign="top" class="col_head" width="10%">
				Sort By 
			</td>
			<td valign="top" class="col_head" width="20%">
				Action
			</td>
		</tr>
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
		?>
					<tr class="<?php echo $tr_class;?>">
						<td valign="top">
							<?php echo st($myarray["palpation"]);?>
						</td>
						<td valign="top" align="center">
							<input type="text" name="sortby[]" value="<?php echo st($myarray['sortby'])?>" class="tbox" style="width:30px"/>
						</td>			
						<td valign="top">
							<a href="Javascript:;"  onclick="Javascript: loadPopup('add_palpation.php?ed=<?php echo $myarray["palpationid"];?>');" class="editlink" title="EDIT">
								Edit 
							</a>	                    
		                    <a href="<?php echo $_SERVER['PHP_SELF']?>?delid=<?php echo $myarray["palpationid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
								Delete 
							</a>
						</td>
					</tr>
		<?php
				}
		?>
				<tr>
					<td valign="top" class="col_head" colspan="1">&nbsp;</td>
					<td valign="top" class="col_head" colspan="4">
						<input type="hidden" name="sortsub" value="1" />
						<input type="submit" value=" Change " class="button" />
					</td>
				</tr>
		<?php
			}
		?>
		</table>
	</form>

	<div id="popupContact">
	    <a id="popupContactClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopup"></div>

	<br /><br />

	</body>
</html>
