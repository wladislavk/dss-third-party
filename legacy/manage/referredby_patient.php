<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ .  '/includes/top.htm';

$docId = intval($_SESSION['docid']);
$referralId = intval($_GET['rid']);
$referralType = intval($_GET['rsource']);

$referralTypePhysician = DSS_REFERRED_PHYSICIAN;
$referralTypePatient = DSS_REFERRED_PATIENT;

if ($referralType == $referralTypePhysician) {
    $referralQuery = "SELECT
            dc.contactid,
            dc.salutation,
            dc.firstname,
            dc.middlename,
            dc.lastname,
            p.referred_source,
            dc.referredby_notes,
            COUNT(p.patientid) AS num_ref,
            GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list,
            '$referralTypePhysician' AS referral_type,
            ct.contacttype
        FROM dental_contact dc
            INNER JOIN dental_contacttype ct ON ct.contacttypeid = dc.contacttypeid
            INNER JOIN dental_patients p ON dc.contactid = p.referred_by
        WHERE dc.docid = '$docId'
            AND p.referred_source = '$referralTypePhysician'
            AND dc.contactid = '$referralId'";
} else {
    $referralQuery = "SELECT
            dp.patientid AS contactid,
            dp.salutation,
            dp.firstname,
            dp.middlename,
            dp.lastname,
            p.referred_source,
            '' AS referred_notes,
            COUNT(p.patientid) AS num_ref,
            GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list,
            '$referralTypePatient' AS referral_type,
            'Patient' AS contacttype
        FROM dental_patients dp
            INNER JOIN dental_patients p ON dp.patientid = p.referred_by
        WHERE p.docid = '$docId'
            AND p.referred_source = '$referralTypePatient'
            AND dp.patientid = '$referralId'";
}

$referralData = $db->getRow($referralQuery);

	$name = st($referralData['salutation'])." ".st($referralData['firstname'])." ".st($referralData['middlename'])." ".st($referralData['lastname']);
	$rec_disp = 20;

	if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
	
	$i_val = $index_val * $rec_disp;
	$sql = "SELECT *
        FROM dental_patients
        WHERE docid = '$docId'
            AND referred_by = '$referralId'
            AND referred_source = '$referralType'
        ORDER BY adddate DESC";
	
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
		<?= $referralData['contacttype'] ?>
	</span>
	<br>
	&nbsp;&nbsp;
	<a href="manage_referredby.php" class="button" style="float:right;margin-right:20px;" title="EDIT">
		Return to Referrals</a>
	<br /><br />

	<div align="center" class="red">
		<b><?php echo isset($_GET['msg']) ? $_GET['msg'] : '';?></b>
	</div>

	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<?php if($total_rec > $rec_disp) { ?>
			<tr bgColor="#ffffff">
				<td  align="right" colspan="15" class="bp">
					Pages:
					<?php paging($no_pages, $index_val, "rid=$referralId&amp;rsource=$referralType") ?>
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
