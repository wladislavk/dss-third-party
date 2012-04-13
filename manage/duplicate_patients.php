<? 
require_once('includes/constants.inc');
include "includes/top.htm";
include "includes/similar.php";
?>
<style type="text/css">
.similar{ display:none; }
</style>
<?php
 
//SQL to search for possible duplicates
$simsql = "(select count(*) FROM dental_patients dp WHERE dp.status=1 AND dp.docid='".mysql_real_escape_string($_SESSION['docid'])."' AND 
		((dp.firstname=p.firstname AND dp.lastname=p.lastname) OR
		(dp.add1=p.add1 AND dp.city=p.city AND dp.state=p.state AND dp.zip=p.zip))
		)";


if(isset($_REQUEST['deleteid'])){
$dsql = "DELETE FROM dental_patients WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."' AND patientid='".mysql_real_escape_string($_REQUEST['deleteid'])."'";
mysql_query($dsql);
?>  <script type="text/javascript">
        window.location = "manage_patient.php";
  </script>
<?php
}elseif(isset($_REQUEST['createid'])){
?>  <script type="text/javascript">
        window.location = "add_patient.php?pid=<?= $_REQUEST['createid']; ?>&ed=<?= $_REQUEST['createid']; ?>";
  </script>
<?php

}

	
$sql = "SELECT p.* FROM dental_patients p WHERE patientid='".mysql_real_escape_string($_REQUEST['pid'])."' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND ".$simsql."!=0 ";
  $sql .= "ORDER BY p.lastname ASC"; 
$my = mysql_query($sql);
$myarray = mysql_fetch_assoc($my);
?>
<span class="admin_head" style="float:left;">
	Warning: Possible Duplicates Patients
</span>
<a href="<?= $_SERVER['PHP_SELF']; ?>?deleteid=<?= $myarray['patientid']; ?>" class="addButton" style="margin-right:10px;float:right;font-size:14px;" onclick="return confirm('Are you sure you want to delete patient?');">Delete</a>
<a href="<?= $_SERVER['PHP_SELF']; ?>?createid=<?= $myarray['patientid']; ?>" class="addButton" style="margin-right:10px;float:right;font-size:14px;">Create</a>
<br />
<br />
<div align="center" class="red" style="clear:both;">
	<b>Patient <? echo $myarray['firstname']." ".$myarray['lastname'];?> may be a duplicate - please check the list of similar patients below. If patient is NOT a duplicate click "Create" to add the patient to the software. If the patient IS a duplicate click "Delete" to remove the patient you just created and use the original patient listed below instead.</b>
	<!--<b>Patient <? echo $myarray['firstname']." ".$myarray['lastname'];?> might be a duplicate.  Please check below and click Create to add the patient, or if the patient is a duplicate click Delete to remove the patient you just created and use the old patient instead.</b>-->
</div>


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
		<?php
			$sim = similar_patients($myarray['patientid']);
			if(count($sim) > 0){ 
			    foreach($sim as $s){ ?>
				<tr>
                                <td valign="top">
                                        <?=st($s["name"]);?>
                                </td>
                                <td valign="top">
                                        <?= st($s["address"]); ?>
                                </td>
                                <td valign="top">
                                        <?= st($s["phone"]); ?>
                                </td>
				<td valign="top">
				</td>
				</tr>
				<?php
			    }
			}  ?>
</table>



<? include "includes/bottom.htm";?>
