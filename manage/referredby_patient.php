<?php 
	include "includes/top.htm";

	if($_GET['rsource'] == DSS_REFERRED_PHYSICIAN) {
		$ref_sql = "select * from dental_contact where docid='".$_SESSION['docid']."' and contactid='".s_for($_GET['rid'])."'";
	}elseif($_GET['rsource']==DSS_REFERRED_PATIENT){
		$ref_sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['rid'])."'";
	}

	$ref_myarray = $db->getRow($ref_sql);
	$name = st($ref_myarray['salutation'])." ".st($ref_myarray['firstname'])." ".st($ref_myarray['middlename'])." ".st($ref_myarray['lastname']);
	$rec_disp = 20;

	if($_REQUEST["page"] != "") {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
	
	$i_val = $index_val * $rec_disp;
	$sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and referred_by='".s_for($_GET['rid'])."' AND referred_source='".s_for($_GET['rsource'])."' order by adddate desc";
	
	$total_rec = $db->getNumberRows($sql);
	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit ".$i_val.",".$rec_disp;
	$my = $db->getResults($sql);
	$num_referredby = count($my);
?>
	<span class="admin_head">
		Referral List for:
	    <i><?php echo $name;?></i>
		-
		<?php if($_GET['rsource'] == DSS_REFERRED_PATIENT) { ?>
			Patient
		<?php } elseif($_GET['rsource'] == DSS_REFERRED_PHYSICIAN) {
			$c_sql = "SELECT contacttype FROM dental_contacttype
					  WHERE contacttypeid='".mysqli_real_escape_string($con, $ref_myarray['contacttypeid'])."'";
			
			$c_r = $db->getRow($c_sql);
			echo $c_r['contacttype'];
		} ?>
	</span>
	<br>
	&nbsp;&nbsp;
	<a href="manage_referredby.php" class="button" style="float:right;margin-right:20px;" title="EDIT">
		Return to Referrals</a>
	<br /><br />

	<div align="center" class="red">
		<b><?php echo $_GET['msg'];?></b>
	</div>

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
			<td valign="top" class="col_head" width="40%">
				Name
			</td>
			<td valign="top" class="col_head" width="60%">
				Add Date
			</td>
		</tr>
	<?php if($num_referredby == 0) { ?>
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
			
			$name = st($myarray['salutation'])." ".st($myarray['firstname'])." ".st($myarray['middlename'])." ".st($myarray['lastname']);
	?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<a href="dss_summ.php?pid=<?php echo  $myarray['patientid']; ?>&addtopat=1"><?php echo $name;?></a>
				</td>
				<td valign="top">
					<?php echo date('M d,Y H:i',strtotime(st($myarray["adddate"])));?>
				</td>
			</tr>
	<?php
		}
	}
	?>
	</table>

<br /><br />

<?php include "includes/bottom.htm"; ?>