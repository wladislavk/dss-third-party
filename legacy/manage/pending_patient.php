<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once 'includes/constants.inc';
include "includes/similar.php";

$isSelectPatient = !empty($_GET['pid']);
$selectedPatient = intval($_GET['pid']);
?>
<link rel="stylesheet" href="css/pending.css?v=20170516<?= time() ?>" type="text/css" media="screen" />
<?php

//SQL to search for possible duplicates
$docId = intval($_SESSION['docid']);
$leftJoinDuplicates = "LEFT JOIN (
        SELECT COUNT(patientid) AS total, firstname, lastname
        FROM dental_patients
        WHERE docid = '$docId'
            AND status = 1
            AND (
                IFNULL(firstname, '') != ''
                OR IFNULL(lastname, '') != ''
            )
        GROUP BY firstname, lastname
    ) by_name
    ON by_name.firstname = p.firstname
        AND by_name.lastname = p.lastname
    LEFT JOIN (
        SELECT COUNT(patientid) AS total, add1, city, state, zip
        FROM dental_patients
        WHERE docid = '$docId'
            AND status = 1
            AND (
                IFNULL(add1, '') != ''
                OR IFNULL(city, '') != ''
                OR IFNULL(state, '') != ''
                OR IFNULL(zip, '') != ''
            )
        GROUP BY add1, city, state, zip
    ) by_address
    ON by_address.add1 = p.add1
        AND by_address.city = p.city
        AND by_address.state = p.state
        AND by_address.zip = p.zip
    ";
$sumTotalsConditional = 'IFNULL(by_name.total, 0) + IFNULL(by_address.total, 0)';

if(isset($_REQUEST['deleteid'])){
    $dsql = "DELETE FROM dental_patients WHERE docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."' AND patientid='".mysqli_real_escape_string($con, $_REQUEST['deleteid'])."'";
    $db->query($dsql);?>
<script type="text/javascript">
    window.location = "pending_patient.php";
</script>
<?php
}elseif(isset($_REQUEST['createid'])){
	$sql = "UPDATE dental_patients SET status= CASE status WHEN 4 THEN 2 ELSE 1 END WHERE docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."' AND patientid='".mysqli_real_escape_string($con, $_REQUEST['createid'])."'";
	$db->query($sql);
?>
<script type="text/javascript">
    window.location = "pending_patient.php";
</script>
<?php
}elseif(isset($_REQUEST['createtype'])){
	//createtype for duplicates or not
	if($_REQUEST['createtype']=='yes'){
        $sql3 = "SELECT p.patientid
            FROM dental_patients p
                $leftJoinDuplicates
            WHERE p.docid = '$docId'
                AND p.status = '3'
                AND $sumTotalsConditional > 0";
        $sql4 = "SELECT p.patientid
            FROM dental_patients p
                $leftJoinDuplicates
            WHERE p.docid = '$docId'
                AND p.status = '4'
                AND $sumTotalsConditional > 0";
	}elseif($_REQUEST['createtype']=='no'){
        $sql3 = "SELECT p.patientid
            FROM dental_patients p
                $leftJoinDuplicates
            WHERE p.docid = '$docId'
                AND p.status = '3'
                AND $sumTotalsConditional = 0";
        $sql4 = "SELECT p.patientid
            FROM dental_patients p
                $leftJoinDuplicates
            WHERE p.docid = '$docId'
                AND p.status = '4'
                AND $sumTotalsConditional = 0";
	}
    $q3 = $db->getResults($sql3);
    $ids3 = array_pluck($q3, 'patientid');
    $q4 = $db->getResults($sql4);
    $ids4 = array_pluck($q4, 'patientid');
	$s = "UPDATE dental_patients SET status=1 WHERE patientid IN('" . implode($ids3, "', '") . "')";
	$db->query($s);
	$s = "UPDATE dental_patients SET status=2 WHERE patientid IN('" . implode($ids4, "', '") . "')";
    $db->query($s);
?>
<script type="text/javascript">
    window.location = "pending_patient.php";
</script>
<?php

}elseif(isset($_REQUEST['deletetype'])){
        if($_REQUEST['deletetype']=='yes'){
            $sql = "SELECT p.patientid
                FROM dental_patients p
                    $leftJoinDuplicates
                WHERE p.docid = '$docId'
                    AND p.status IN (3, 4)
                    AND $sumTotalsConditional > 0";
        }elseif($_REQUEST['deletetype']=='no'){
            $sql = "SELECT p.patientid
                FROM dental_patients p
                    $leftJoinDuplicates
                WHERE p.docid = '$docId'
                    AND p.status IN (3, 4)
                    AND $sumTotalsConditional = 0";
        }
        $q = $db->getResults($sql);
        $ids = array_pluck($q, 'patientid');
        $s = "DELETE FROM dental_patients WHERE patientid IN('" . implode($ids, "', '") . "')";
        $db->query($s);
?>  
<script type="text/javascript">
    window.location = "pending_patient.php";
</script>
<?php
}
$sql = "SELECT p.*
    FROM dental_patients p
        $leftJoinDuplicates
    WHERE p.docid = '$docId'
        AND p.status = '3'
        AND $sumTotalsConditional > 0
    ";

if ($isSelectPatient) {
    $sql .= " ORDER BY IF(p.patientid = '$selectedPatient', 1, 0) DESC, p.lastname ASC, p.firstname ASC";
} else {
    $sql .= "ORDER BY p.lastname ASC";
}

$my = $db->getResults($sql);

$message = '';

if (!empty($_GET['msg'])) {
    $message = e($_GET['msg']);
    $json = json_decode($_GET['msg'], true);

    if (is_string($json)) {
        $message = e($json);
    }

    if (is_array($json)) {
        $message = '';

        array_walk_recursive($json, 'e');

        if (!empty($json['errors'])) {
            $message .= '<ul><li>' . join('</li><li>', $json['errors']) . '.</li></ul>';
        }

        if (!empty($json['inserted'])) {
            $message .= "{$json['inserted']} new patients.";
        }
    }
}
?>

<script src="js/pending.js" type="text/javascript"></script>

<button style="float:right;margin-right:20px;" onclick="return redirect('uploadcsv.php');" class="addButton">
      Upload Eaglesoft
</button>
<button style="float:right;margin-right:20px;" onclick="return redirect('uploadcsv_dw.php');" class="addButton">
      Upload Dental Writer
</button>

<br />
<span class="admin_head">
	Manage Pending Patients Possible Duplicates
</span>
<br />
<br />
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?deletetype=yes" style="margin-right:10px;float:right;" onclick="return confirm('Are you sure you want to delete all?');">Delete All</a>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?createtype=yes" style="margin-right:10px;float:right;">Create All</a>
<br />
<?php if ($message) { ?>
    <div align="center" class="red">
        <?= $message ?>
    </div>
<?php } ?>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="25%">
			Patient Name
		</td>
		<td valign="top" class="col_head" width="45%">
			Address
		</td>
        <td valign="top" class="col_head" width="15%">
            Phone
        </td>
        <td valign="top" class="col_head" width="45%">
            Similar Patients 
        </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<?php if(count($my) == 0)
	{ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="5" align="center">
			No Records
		</td>
	</tr>
	<?php 
	} else {
        foreach ($my as $myarray) {
			$sim = similar_patients($myarray['patientid']); ?>
	<tr class="<?php echo $tr_class;?> <?php echo ($myarray['viewed'])?'':'unviewed'; ?> <?= $selectedPatient == $myarray['patientid'] ? 'selected' : '' ?>">
		<td valign="top" <?= $isSelectPatient ? 'id="external-patient"' : '' ?>>
            <?php echo st($myarray["firstname"]);?>&nbsp;
            <?php echo st($myarray["lastname"]);?> 
		</td>
		<td valign="top">
            <?php echo st($myarray["add1"]); ?>
            <?php echo st($myarray["add2"]); ?>
            <?php echo st($myarray["city"]); ?>,
            <?php echo st($myarray["state"]); ?>
            <?php echo st($myarray["zip"]); ?>
		</td>
        <td valign="top">
            <?php echo st($myarray["phone"]); ?>
        </td>
		<td valign="top">
			<a href="#" onclick="$('.sim_<?php echo $myarray['patientid']; ?>').toggle();return false;"><?php echo count($sim); ?></a>
		</td>
		<td valign="top">
            <a href="#" onclick="$('.sim_<?php echo $myarray['patientid']; ?>').toggle();return false;">
                Merge
            </a>
            <a href="pending_patient.php?createid=<?php echo $myarray["patientid"]; ?>" class="editlink" title="EDIT">
			        Create
			</a> 
            <a href="pending_patient.php?deleteid=<?php echo $myarray["patientid"]; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $myarray['firstname']." ".$myarray['lastname']; ?>?')" class="editlink" title="EDIT">
                    Delete 
            </a>
		</td>
	</tr>
			<?php 
			if(count($sim) > 0){ 
			    foreach($sim as $s){ ?>
    <tr class="similar sim_<?php echo $myarray['patientid']; ?>">
        <td valign="top">
            <?php echo st($s["name"]);?>
        </td>
        <td valign="top">
            <?php echo st($s["address"]); ?>
        </td>
        <td valign="top">
            <?php echo st($s["phone"]); ?>
        </td>
        <td>
            <a href="/manage/patient_changes.php?pid=<?= intval($s['id']) ?>&amp;merge_id=<?= intval($myarray['patientid']) ?>">Merge</a>
        </td>
        <td valign="top">
        </td>
    </tr>
				<?php
			    }
			} 
        }
	}?>
</table>

<?php
$sql = "SELECT p.*
    FROM dental_patients p
        $leftJoinDuplicates
    WHERE p.docid = '$docId'
        AND p.status = '3'
        AND IFNULL(by_name.total, 0) + IFNULL(by_address.total, 0) = 0
    ";

if ($isSelectPatient) {
    $sql .= " ORDER BY IF(p.patientid = '$selectedPatient', 1, 0) DESC, p.lastname, p.firstname";
} else {
    $sql .= "ORDER BY p.lastname ASC";
}
$my = $db->getResults($sql);
?>
<span class="admin_head">
    Manage Pending Patients No Duplicates
</span>
<br />
<br />
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?deletetype=no" style="margin-right:10px;float:right;" onclick="return confirm('Are you sure you want to delete all?');">Delete All</a>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?createtype=no" style="margin-right:10px;float:right;">Create All</a>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <tr class="tr_bg_h">
        <td valign="top" class="col_head" width="25%">
            Patient Name
        </td>
        <td valign="top" class="col_head" width="45%">
            Address
        </td>
        <td valign="top" class="col_head" width="15%">
            Phone
        </td>
        <td valign="top" class="col_head" width="15%">
            Action
        </td>
    </tr>
        <?php if(count($my) == 0)
        { ?>
        <tr class="tr_bg">
            <td valign="top" class="col_head" colspan="4" align="center">
                No Records
            </td>
        </tr>
        <?php
        } else {
            foreach ($my as $myarray) { ?>
    <tr class="<?php echo $tr_class;?> <?php echo ($myarray['viewed'])?'':'unviewed'; ?> <?= $selectedPatient == $myarray['patientid'] ? 'selected' : '' ?>">
        <td valign="top" <?= $isSelectPatient ? 'id="external-patient"' : '' ?>>
            <?php echo st($myarray["firstname"]);?>&nbsp;
            <?php echo st($myarray["lastname"]);?>
        </td>
        <td valign="top">
            <?php echo st($myarray["add1"]); ?>
            <?php echo st($myarray["add2"]); ?>
            <?php echo st($myarray["city"]); ?>,
            <?php echo st($myarray["state"]); ?>
            <?php echo st($myarray["zip"]); ?>
        </td>
        <td valign="top">
            <?php echo st($myarray["phone"]); ?>
        </td>
        <td valign="top">
            <a href="pending_patient.php?createid=<?php echo $myarray["patientid"]; ?>" class="editlink" title="EDIT">
                Create
            </a>
            <a href="pending_patient.php?deleteid=<?php echo $myarray["patientid"]; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $myarray['firstname']." ".$myarray['lastname']; ?>?')" class="editlink" title="EDIT">
                Delete 
            </a>
        </td>
    </tr>
        <?      }
        }?>
</table>

<?php include "includes/bottom.htm";?>
