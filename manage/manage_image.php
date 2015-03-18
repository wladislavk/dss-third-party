<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include "includes/top.htm";

	if(isset($_REQUEST["delid"]) && $_REQUEST["delid"] != "") {
		$del_sql = "delete from dental_contact where userid='".$_REQUEST["delid"]."'";
		
		$db->query($del_sql);
		$msg= "Deleted Successfully";
?>
		<script type="text/javascript">
			window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}

	$rec_disp = 20;

	if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
		
	$i_val = $index_val * $rec_disp;
	$sql = "select * from dental_contact where docid='".$_SESSION['docid']."' order by lastname";
	
	$total_rec = $db->getNumberRows($sql);
	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit ".$i_val.",".$rec_disp;
	$my = $db->getResults($sql);
	$num_contact = count($my);
?>

	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<script src="admin/popup/popup.js" type="text/javascript"></script>

	<span class="admin_head">
		Manage Contact
	</span>
	<br /><br />
	&nbsp;
	<div align="right">
		<button onclick="Javascript: loadPopup('add_contact.php');" class="addButton">
			Add New Contact
		</button>
		&nbsp;&nbsp;
	</div>
	<br />
	<div align="center" class="red">
		<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
	</div>
	<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
		<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
			<?php if($total_rec > $rec_disp) { ?>
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
				<td valign="top" class="col_head" width="20%">
					Name
				</td>
				<td valign="top" class="col_head" width="70%">
					Company
				</td>
				<td valign="top" class="col_head" width="20%">
					Action
				</td>
			</tr>
			<?php if($num_contact == 0) { ?>
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
			
					$name = st($myarray['lastname'])." ".st($myarray['middlename']).", ".st($myarray['firstname']);
			?>
					<tr class="<?php echo $tr_class;?>">
						<td valign="top">
							<?php echo $name;?>
						</td>
						<td valign="top">
							<?php echo st($myarray["company"]);?>
						</td>
						<td valign="top">
							<a href="Javascript:;"  onclick="Javascript: loadPopup('add_contact.php?ed=<?php echo $myarray["contactid"];?>');" class="editlink" title="EDIT">
								Edit 
							</a>
		                    <a href="<?php echo $_SERVER['PHP_SELF']?>?delid=<?php echo $myarray["contactid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
								Delete 
							</a>
						</td>
					</tr>
			<?php 
				}
			}
			?>
		</table>
	</form>

	<div id="popupContact" style="width:750px;">
	    <a id="popupContactClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	
	<div id="backgroundPopup"></div>

	<br /><br />	
<?php include "includes/bottom.htm";?>
