<?php namespace Ds3\Libraries\Legacy; ?><?php
	include "includes/top.htm";
?>
<!--
	<script type="text/javascript">
		window.location = "manage_patient.php";
	</script>
-->
<?php
	//die();
	if(isset($_REQUEST["delid"]) && $_REQUEST["delid"] != "") {
		$del_sql = "delete from dental_forms where formid='".$_REQUEST["delid"]."'";
		
		$db->query($del_sql);
		$msg= "Deleted Successfully";
?>
		<script type="text/javascript">
			window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
		</script>
<?php
		die();
	}

	$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
	
	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
	if($pat_myarray['patientid'] == '') {
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		die();
	}

	$rec_disp = 20;
	if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
	
	$i_val = $index_val * $rec_disp;
	$sql = "select * from dental_forms where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate";

	$total_rec = $db->getNumberRows($sql);
	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit ".$i_val.",".$rec_disp;
	$my = $db->getResults($sql);
	$num_users = count($my);
?>

	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<script src="admin/popup/popup.js" type="text/javascript"></script>

	<span class="admin_head">
		Manage Exam
		-
	    Patient <i><?php echo $name;?></i>
	</span>
	<br />
	&nbsp;&nbsp;
	<a href="manage_patient.php" class="editlink" title="EDIT">
		<b>&lt;&lt;Back</b>
	</a>
	<br />

	<?php if($num_users == 0) { ?>
		<div align="right">
			<button onclick="Javascript: window.location = 'add_form.php?pid=<?php echo $_GET['pid'];?>';" class="addButton">
				Add New Exam
			</button>
			&nbsp;&nbsp;
		</div>
	<?php } ?>
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
						<?
							 paging($no_pages,$index_val,"");
						?>
					</td>        
				</tr>
			<?php } ?>
			<tr class="tr_bg_h">
				<td valign="top" class="col_head" width="20%">
					Date
				</td>
				<td valign="top" class="col_head" width="40%">
					Type
				</td>
				<td valign="top" class="col_head" width="10%">
					ID
				</td>
				<td valign="top" class="col_head" width="10%">
					DSS Summary
				</td>
				<td valign="top" class="col_head" width="10%">
					Letters
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
					if(isset($myarray["status"]) && $myarray["status"] == 1) {
						$tr_class = "tr_active";
					} else {
						$tr_class = "tr_inactive";
					}
					$tr_class = "tr_active";
			?>
					<tr class="<?php echo $tr_class;?>">
						<td valign="top">
		                	<?php echo date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
						</td>
		                <td valign="top">
		                	Dental Sleep Dentistry Questionaire/Exam
		                </td>
		                <td valign="top">
		                	<?php echo st($myarray["formid"]);?>
		                </td>
						<td valign="top">
		                	<a href="dss_summary.php?pid=<?php echo $_GET['pid'];?>" class="dellink" title="DELETE">
								Manage
							</a>
		                </td>
						<td valign="top">
		                	<a href="dss_letters.php?pid=<?php echo $_GET['pid'];?>" class="dellink" title="DELETE">
								Manage
							</a>
		                </td>
						<td valign="top">
							<a href="q_page1.php?pid=<?php echo $_GET['pid'];?>" class="editlink" title="EDIT">
								Edit 
							</a>
		                    
		                    <a href="<?php echo $_SERVER['PHP_SELF']?>?delid=<?php echo $myarray["formid"];?>&pid=<?php echo $_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
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
