<? 
require_once('includes/constants.inc');
include "includes/top.htm";
include "includes/similar.php";
?>
<style type="text/css">
.similar{ display:none; }
</style>
<?php
 
$simsql = "(select count(*) FROM dental_patients dp WHERE dp.status=1 AND dp.docid='".mysql_real_escape_string($_SESSION['docid'])."' AND 
		((dp.firstname=p.firstname AND dp.lastname=p.lastname) OR
		(dp.add1=p.add1 AND dp.city=p.city AND dp.state=p.state AND dp.zip=p.zip))
		)";


if(isset($_REQUEST['deleteid'])){
$dsql = "DELETE FROM dental_patients WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."' AND patientid='".mysql_real_escape_string($_REQUEST['deleteid'])."'";
mysql_query($dsql);
?>  <script type="text/javascript">
        window.location = "pending_patient.php";
  </script>
<?php
}elseif(isset($_REQUEST['createid'])){
	$sql = "UPDATE dental_patients SET status=1 WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."' AND patientid='".mysql_real_escape_string($_REQUEST['createid'])."'";
	mysql_query($sql);
?>  <script type="text/javascript">        window.location = "pending_patient.php";
  </script>
<?php

}elseif(isset($_REQUEST['createtype'])){
	if($_REQUEST['createtype']=='yes'){
$sql = "SELECT p.patientid FROM dental_patients p WHERE status='2' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND ".$simsql."!=0";
	}elseif($_REQUEST['createtype']=='no'){
$sql = "SELECT p.patientid FROM dental_patients p WHERE status='2' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND ".$simsql."=0";
	}
        $q = mysql_query($sql);
	$ids = array();
	while($r = mysql_fetch_assoc($q)){
		array_push($ids, $r['patientid']);
	}
	$s = "UPDATE dental_patients SET status=1 WHERE patientid IN(".implode($ids, ',').")";
	mysql_query($s);
?>  <script type="text/javascript">
        window.location = "pending_patient.php";
  </script>
<?php

}elseif(isset($_REQUEST['deletetype'])){
        if($_REQUEST['deletetype']=='yes'){
$sql = "SELECT p.patientid FROM dental_patients p WHERE status='2' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND ".$simsql."!=0";
        }elseif($_REQUEST['deletetype']=='no'){
$sql = "SELECT p.patientid FROM dental_patients p WHERE status='2' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND ".$simsql."=0";
        }
        $q = mysql_query($sql);
        $ids = array();
        while($r = mysql_fetch_assoc($q)){
                array_push($ids, $r['patientid']);
        }
        $s = "DELETE FROM dental_patients WHERE patientid IN(".implode($ids, ',').")";
        mysql_query($s);
?>  <script type="text/javascript">
        window.location = "pending_patient.php";
  </script>
<?php

}


	
$sql = "SELECT p.* FROM dental_patients p WHERE status='2' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND ".$simsql."!=0 ";
  $sql .= "ORDER BY p.lastname ASC"; 
$my = mysql_query($sql);
$my=mysql_query($sql) or die(mysql_error());

?>

        <button style="float:right;margin-right:20px;" onclick="javascript: window.location = 'uploadcsv.php';" class="addButton">
              Upload 
        </button>
<br />
<span class="admin_head">
	Manage Pending Patients Possible Duplicates
</span>
<br />
<br />
<a href="<?= $_SERVER['PHP_SELF']; ?>?deletetype=yes" style="margin-right:10px;float:right;" onclick="return confirm('Are you sure you want to delete all?');">Delete All</a>
<a href="<?= $_SERVER['PHP_SELF']; ?>?createtype=yes" style="margin-right:10px;float:right;">Create All</a>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
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
                <td valign="top" class="col_head" width="45%">
			Similar Doctors
                </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="4" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
			$sim = similar_patients($myarray['patientid']);
		?>
			<tr class="<?=$tr_class;?> <?= ($myarray['viewed'])?'':'unviewed'; ?>">
				<td valign="top">
					<?=st($myarray["firstname"]);?>&nbsp;
                    			<?=st($myarray["lastname"]);?> 
				</td>
				<td valign="top">
					<?= st($myarray["add1"]); ?>
                                        <?= st($myarray["add2"]); ?>
                                        <?= st($myarray["city"]); ?>,
                                        <?= st($myarray["state"]); ?>
                                        <?= st($myarray["zip"]); ?>
				</td>
                                <td valign="top">
					<?= st($myarray["phone"]); ?>
                                </td>
				<td valign="top">
					<a href="#" onclick="$('.sim_<?= $myarray['patientid']; ?>').toggle();return false;"><?= count($sim); ?></a>
				</td>
				<td valign="top">
					<a href="pending_patient.php?createid=<?= $myarray["patientid"]; ?>" class="editlink" title="EDIT">
					        Create
					</a> 
                                        <a href="pending_patient.php?deleteid=<?= $myarray["patientid"]; ?>" onclick="return confirm('Are you sure you want to delete <?= $myarray['firstname']." ".$myarray['lastname']; ?>?')" class="editlink" title="EDIT">
                                                Delete 
                                        </a>

				</td>
			</tr>
			<?php 
			if(count($sim) > 0){ 
			    foreach($sim as $s){ ?>
				<tr class="similar sim_<?= $myarray['patientid']; ?>">
                                <td valign="top">
                                        <?=st($s["name"]);?>
                                </td>
                                <td valign="top">
                                        <?= st($s["address"]); ?>
                                </td>
                                <td valign="top">
                                        <?= st($s["phone"]); ?>
                                </td>
				<td>
				</td>
				<td valign="top">
				</td>
				</tr>
				<?php
			    }
			}  ?>
	<? 	}
	}?>
</table>

<?php
$sql = "SELECT p.* FROM dental_patients p WHERE status='2' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND ".$simsql."=0 ";
  $sql .= "ORDER BY p.lastname ASC";
$my = mysql_query($sql);
$my=mysql_query($sql) or die(mysql_error());

?>
<span class="admin_head">
        Manage Pending Patients No Duplicates
</span>
<br />
<br />
<a href="<?= $_SERVER['PHP_SELF']; ?>?deletetype=no" style="margin-right:10px;float:right;" onclick="return confirm('Are you sure you want to delete all?');">Delete All</a>
<a href="<?= $_SERVER['PHP_SELF']; ?>?createtype=no" style="margin-right:10px;float:right;">Create All</a>


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
        <? if(mysql_num_rows($my) == 0)
        { ?>
                <tr class="tr_bg">
                        <td valign="top" class="col_head" colspan="4" align="center">
                                No Records
                        </td>
                </tr>
        <?
        }
        else
        {
                while($myarray = mysql_fetch_array($my))
                {
                        $sim = similar_doctors($myarray['patientid']);
                ?>
                        <tr class="<?=$tr_class;?> <?= ($myarray['viewed'])?'':'unviewed'; ?>">
                                <td valign="top">
                                        <?=st($myarray["firstname"]);?>&nbsp;
                                        <?=st($myarray["lastname"]);?>
                                </td>
                                <td valign="top">
                                        <?= st($myarray["add1"]); ?>
                                        <?= st($myarray["add2"]); ?>
                                        <?= st($myarray["city"]); ?>,
                                        <?= st($myarray["state"]); ?>
                                        <?= st($myarray["zip"]); ?>
                                </td>
                                <td valign="top">
                                        <?= st($myarray["phone"]); ?>
                                </td>
                                <td valign="top">
                                        <a href="pending_patient.php?createid=<?= $myarray["patientid"]; ?>" class="editlink" title="EDIT">
                                                Create
                                        </a>
                                        <a href="pending_patient.php?deleteid=<?= $myarray["patientid"]; ?>" onclick="return confirm('Are you sure you want to delete <?= $myarray['firstname']." ".$myarray['lastname']; ?>?')" class="editlink" title="EDIT">
                                                Delete 
                                        </a>

                                </td>
                        </tr>
        <?      }
        }?>
</table>








<? include "includes/bottom.htm";?>
