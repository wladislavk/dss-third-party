<?php namespace Ds3\Legacy; ?><?php 
	include "includes/top.htm";
	include_once('includes/patient_info.php');

	if ($patient_info) {
		if(isset($_REQUEST["delid"]) && $_REQUEST["delid"] != "") {
			$del_sql = "delete from dental_notes where notesid='".$_REQUEST["delid"]."'";
			
			$db->query($del_sql);
			$msg = "Deleted Successfully";
?>
			<script type="text/javascript">
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
			</script>
<?php
			die();
		}

		$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
		
		$pat_myarray = $db->getRow($pat_sql);
		$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
		if($pat_myarray['patientid'] == '') {
?>
			<script type="text/javascript">
				window.location = 'manage_patient.php';
			</script>
<?php
			die();
		}

		$rec_disp = 200;

		if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
			$index_val = $_REQUEST["page"];
		} else {
			$index_val = 0;
		}
	
		$i_val = $index_val * $rec_disp;
		$sql = "select n.*, u.name signed_name, p.adddate as parent_adddate from
	        (
	        select * from dental_notes where status!=0 AND docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate desc
	        ) as n
	        LEFT JOIN dental_users u on u.userid=n.signed_id
	        LEFT JOIN dental_notes p ON p.notesid = n.parentid
	        group by n.parentid
	        order by n.procedure_date DESC, n.adddate desc
	        ";

		$total_rec = $db->getNumberRows($sql);
		$no_pages = $total_rec/$rec_disp;

		$sql .= " limit ".$i_val.",".$rec_disp;
		$my = $db->getResults($sql);
		$num_users = count($my);
?>

		<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
		<script src="admin/popup/popup.js" type="text/javascript"></script>

		<span class="admin_head">
			Progress Notes
			-
			<i>
				<?php echo $name;?>
		    </i>
		</span>

		<div align="left">
			&nbsp;&nbsp;&nbsp;
			<a href="manage_patient.php" class="editlink" title="EDIT">
				<b>&lt;&lt;Back</b>
			</a>
		</div>

		<div align="right">
			<button onclick="Javascript: loadPopupClean('view_notes.php?pid=<?php echo $_GET['pid'];?>');" class="addButton">
				View All Notes
			</button>
			&nbsp;&nbsp;&nbsp;&nbsp;
			
			<button onclick="Javascript: loadPopup('add_notes.php?pid=<?php echo $_GET['pid'];?>');" class="addButton">
				Add New Progress Note
			</button>
			&nbsp;&nbsp;
		</div>
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
				<td valign="top" class="col_head" width="20%">
					Note Date
				</td>
                <td valign="top" class="col_head" width="20%">
                    Procedure Date
                </td>
				<td valign="top" class="col_head" width="40%">
					Added by
				</td>
				<td valign="top" class="col_head" width="20%">
					Action
				</td>
				<td valign="top" class="col_head" width="10">
					Status
				</td>
			</tr>
			<?php if($num_users == 0) { ?>
				<tr class="tr_bg">
					<td valign="top" class="col_head" colspan="10" align="center">
						No Records
					</td>
				</tr>
			<?php } else {
				$cur_bal = 0;
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
					<tr class="<?php echo $tr_class;?>" <?php if(st($myarray["edited"]) == 1) {?> style="" <?php }?>>
						<td valign="top">
		                	<?php echo date('M d, Y H:i',strtotime(st($myarray["adddate"])));?>
						</td>
                        <td valign="top">
                        	<?php echo ($myarray['procedure_date']!='')?date('M d, Y',strtotime($myarray["procedure_date"])):'';?>
                        </td>
						<td valign="top">
		                	<?php echo st($user_myarray["name"]);?>
						</td>
						<td valign="top">
							<a href="Javascript:;" onclick="Javascript: loadPopup('view_notes.php?ed=<?php echo $myarray["notesid"];?>&pid=<?php echo $_GET['pid'];?>');" class="editlink" title="View Detail">
								<img src="admin/images/b_browse.png" alt="EDIT" width="16" height="16" border="0" align="View Detail"/>
							</a>
							<?php if(date('m-d-Y') == date('m-d-Y',strtotime(st($myarray["adddate"])))) { ?>
								<a href="Javascript:;" onclick="Javascript: loadPopup('add_notes.php?ed=<?php echo $myarray["notesid"];?>&pid=<?php echo $_GET['pid'];?>');" class="editlink" title="EDIT">
									Edit 
								</a>
							<?php } ?>
		                    <a href="<?php echo $_SERVER['PHP_SELF']?>?delid=<?php echo $myarray["notesid"];?>&pid=<?php echo $_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
								Delete 
							</a>
						</td>
						<td valign="top">
							<?php echo ($myarray['status'])?"Open":"Closed"; ?>
						</td>
					</tr>
			<?php
				}
			}
			?>
		</table>

		<div id="popupContact" style="width:750px;height:450px;">
		    <a id="popupContactClose">
		    	<button>X</button>
		    </a>
		    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
		</div>

		<div id="backgroundPopup"></div>
		<div id="popupClean" style="height:550px; width:750px;">
		    <a id="popupCleanClose">
		    	<button>X</button>
		    </a>
		    <iframe id="aj_clean" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
		</div>

		<div id="backgroundPopupClean"></div>
		<br /><br />
<?php
	} else {  // end pt info check
		print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
	}
?>

<?php include "includes/bottom.htm";?>
