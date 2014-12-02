<?php
	include "includes/top.htm";

	if (!empty($_POST['dailysub']) && $_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1) {
?>
		<script type="text/javascript">
			window.location = 'patient_report.php';
		</script>
<?php
		die();
	}

	$rec_disp = 200;
	if(!empty($_REQUEST["page"])) {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
	$i_val = $index_val * $rec_disp;
	$sql = "select * from dental_forms where docid='".$_SESSION['docid']."' ";
	if(!empty($_POST['d_mm'])) {
		$from_date = $_POST['d_yy']."-".$_POST['d_mm']."-".$_POST['d_dd'];
		$sql .= " and adddate >= '".s_for($from_date)."' ";
	}
	if(!empty($_POST['d_mm1'])) {
		$to_date = $_POST['d_yy1']."-".$_POST['d_mm1']."-".$_POST['d_dd1'];
		$sql .= " and adddate <= '".s_for($to_date)."' ";
	}

	$sql .= " order by adddate";
	
	$total_rec = $db->getNumberRows($sql);
	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit ".$i_val.",".$rec_disp;
	$my = $db->getResults($sql);
	$num_users = count($my);
?>

	<span class="admin_head">
		Form Report
	</span>
	<div>
		&nbsp;&nbsp;
		<a href="form_report.php" class="editlink" title="EDIT">
			<b>&lt;&lt;Back</b>
		</a>
	</div>
	<br />
	<div align="right">
		<form name="formreportfrm" action="form_report_print.php" method="post" target="_blank">
			<input type="hidden" name="d_mm" value="<?php echo (!empty($_POST['d_mm']) ? $_POST['d_mm'] : '')?>" />
			<input type="hidden" name="d_dd" value="<?php echo (!empty($_POST['d_dd']) ? $_POST['d_dd'] : '')?>" />
			<input type="hidden" name="d_yy" value="<?php echo (!empty($_POST['d_yy']) ? $_POST['d_yy'] : '')?>" />
			<input type="hidden" name="d_mm1" value="<?php echo (!empty($_POST['d_mm1']) ? $_POST['d_mm1'] : '')?>" />
			<input type="hidden" name="d_dd1" value="<?php echo (!empty($_POST['d_dd1']) ? $_POST['d_dd1'] : '')?>" />
			<input type="hidden" name="d_yy1" value="<?php echo (!empty($_POST['d_yy1']) ? $_POST['d_yy1'] : '')?>" />
			<input type="hidden" name="monthlysub" value="1" />
			<input type="submit" class="addButton" value="Print Report" />
			&nbsp;&nbsp;
		</form>
	</div>
	<br />
	<div align="center" class="red">
		<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
	</div>
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<tr bgColor="#ffffff">
			<td align="right" colspan="15" class="cat_head">
				<?php echo $total_rec;?> Form(s) found for 
				
				<?php if(!empty($_POST['d_mm'])) { ?>
					&nbsp;&nbsp;
					<i>Date From :</i>
					<?php echo $_POST['d_mm'];?> - <?php echo $_POST['d_dd'];?> - <?php echo $_POST['d_yy'];?>
				<?php } ?>
				<?php if(!empty($_POST['d_mm1'])) { ?>
					&nbsp;&nbsp;
					<i>Date To :</i>
					<?php echo $_POST['d_mm1'];?> - <?php echo $_POST['d_dd1'];?> - <?php echo $_POST['d_yy1'];?>
				<?php } ?>
			</td>        
		</tr>
		<?php if($total_rec > $rec_disp) { ?>
			<tr bgColor="#ffffff">
				<td  align="right" colspan="15" class="bp">
					Pages:
					<?php paging($no_pages,$index_val,""); ?>
				</td>        
			</tr>
		<?php } ?>
		<tr class="tr_bg_h">
			<td valign="top" class="col_head" width="30%">
				Date
			</td>
			<td valign="top" class="col_head" width="30%">
				Form ID
			</td>
			<td valign="top" class="col_head" width="40%">
				Patient Name
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
					$name = st(!empty($myarray['lastname']) ? $myarray['lastname'] : '')." ".st(!empty($myarray['middlename']) ? $myarray['middlename'] : '')." ".st(!empty($myarray['firstname']) ? $myarray['firstname'] : '');
					$patient_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
					
					$patient_myarray = $db->getRow($patient_sql);
					$pat_name = st($patient_myarray['lastname'])." ".st($patient_myarray['middlename'])." ".st($patient_myarray['firstname']);	
					if(!empty($myarray["status"]) && $myarray["status"] == 1) {
						$tr_class = "tr_active";
					} else {
						$tr_class = "tr_inactive";
					}
					$tr_class = "tr_active";
		?>
					<tr class="<?php echo $tr_class;?>">
						<td valign="top">
							<?php echo date('m-d-Y H:m',strtotime(st($myarray["adddate"])));?>
						</td>
						<td valign="top">
							<?php echo st($myarray["formid"]);?>
						</td>
						<td valign="top">
		                	<?php echo st($pat_name);?>
						</td>
					</tr>
		<?php
				}
			}
		?>
	</table>
	<br /><br />

<?php include "includes/bottom.htm";?>