<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";
include_once('includes/constants.inc');
include "includes/similar.php";
?>
<link rel="stylesheet" href="css/manage_display_similar.css" type="text/css" media="screen" />
<?php
 
//SQL to search for possible duplicates
$simsql = "(select count(*) FROM dental_patients dp WHERE dp.status=1 AND dp.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND 
		((dp.firstname=p.firstname AND dp.lastname=p.lastname) OR
		(dp.add1=p.add1 AND dp.city=p.city AND dp.state=p.state AND dp.zip=p.zip))
		)";


if(isset($_REQUEST['deleteid'])){
	$dsql = "DELETE FROM dental_patients WHERE docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND patientid='".mysqli_real_escape_string($con,$_REQUEST['deleteid'])."'";
	$db->query($dsql);?>  
	<script type="text/javascript">
	    alert("Duplicate patient removed.");
        window.location = "add_patient.php?ed=<?php echo $_REQUEST['useid']; ?>&preview=1&addtopat=1&pid=<?php echo $_REQUEST['useid']; ?>";
	</script>
<?php
}elseif(isset($_REQUEST['createid'])){?>
	<script type="text/javascript">
        window.location = "add_patient.php?pid=<?php echo $_REQUEST['createid']; ?>&ed=<?php echo $_REQUEST['createid']; ?>";
	</script>
<?php
}

$sql = "SELECT p.* FROM dental_patients p WHERE patientid='".mysqli_real_escape_string($con,$_REQUEST['pid'])."' AND docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND ".$simsql."!=0 ";
$sql .= "ORDER BY p.lastname ASC"; 
$myarray = $db->getRow($sql);?>

<span class="admin_head" style="float:left;">
	Warning: Possible Duplicate Patients
</span>
<br />
<br />
<div align="center" class="red" style="clear:both;padding:0 30px;">
	<b>Patient <?php echo $myarray['firstname']." ".$myarray['lastname'];?> may be a duplicate - please check the list of similar patients below. If patient is NOT a duplicate click "Create as New Patient" to add the patient to the software. If the patient IS a duplicate click "Use This Patient" next to the correct patient to use the original patient instead.</b>
	<!--<b>Patient <?php echo $myarray['firstname']." ".$myarray['lastname'];?> might be a duplicate.  Please check below and click Create to add the patient, or if the patient is a duplicate click Delete to remove the patient you just created and use the old patient instead.</b>-->
</div>
<br />
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?createid=<?php echo $myarray['patientid']; ?>" class="addButton" style="margin-left:30px;font-size:14px;">Create as New Patient</a>
<a href="#" onclick="loadPopup('add_patient.php?noheaders=1&readonly=1&pid=<?php echo $myarray['patientid']; ?>&ed=<?php echo $myarray['patientid']; ?>'); return false;" class="addButton" style="font-size:14px;" >View</a>

<br /><br />
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="25%">
			Patient Name
		</td>
		<td valign="top" class="col_head" width="40%">
			Address
		</td>
               <td valign="top" class="col_head" width="10%">
			Phone
                </td>
		<td valign="top" class="col_head" width="10%">
 			View
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
<?php
$sim = similar_patients($myarray['patientid']);
if(count($sim) > 0){ 
	foreach($sim as $s){ ?>
	<tr>
		<td valign="top">
			<?php echo st($s["name"]);?>
		</td>
		<td valign="top">
			<?php echo st($s["address"]); ?>
		</td>
		<td valign="top">
			<?php echo st($s["phone"]); ?>
		</td>
		<td valign="top">
			<a href="#" onclick="loadPopup('add_patient.php?noheaders=1&readonly=1&pid=<?php echo $s['id']; ?>&ed=<?php echo $s['id']; ?>'); return false;" class="addButton" style="margin-right:10px;float:right;font-size:14px;" >View</a>
		</td>
		<td valign="top">
			<a href="<?php echo $_SERVER['PHP_SELF']; ?>?useid=<?php echo $s['id']; ?>&deleteid=<?php echo $myarray['patientid']; ?>" class="addButton" style="margin-right:10px;float:right;font-size:14px;" >Use This Patient</a>
		</td>
	</tr>
<?php
	}
}?>
</table>
<?php include "includes/bottom.htm";?>
