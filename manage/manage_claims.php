<? 
include "includes/top.htm";
include_once "includes/constants.inc";
if(!isset($_GET['sort1'])){
$_GET['sort1']='oldest';
$_GET['dir1']='ASC';
}
if(!isset($_GET['sort2'])){
$_GET['sort2']='adddate';
$_GET['dir2']='ASC';
}
if(!isset($_GET['filter'])){
$_GET['filter']=100;
}

if(isset($_REQUEST["delid"]))
{
        $del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delid"]."'";
        mysql_query($del_sql);

        $msg= "Deleted Successfully";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
        </script>
        <?
        die();
}


$pend_sql = "select i.*, p.firstname, p.lastname,
	COALESCE(notes.num_notes, 0) num_notes,
        (SELECT e.adddate FROM dental_claim_electronic e WHERE e.claimid=i.insuranceid ORDER by e.adddate DESC LIMIT 1) electronic_adddate
 from dental_insurance i left join dental_patients p on i.patientid=p.patientid 
	LEFT JOIN (SELECT claim_id, count(*) num_notes FROM dental_claim_notes group by claim_id) notes ON notes.claim_id=i.insuranceid 
	where i.docid='".$_SESSION['docid']."' "; 
$pend_sql .= " AND (i.status IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_DISPUTE.", ".DSS_CLAIM_SEC_DISPUTE.", ".DSS_CLAIM_REJECTED.", ".DSS_CLAIM_SEC_REJECTED."))" ;
if(isset($_GET['sort2'])){
  if($_GET['sort2']=='patient'){
    $sort = "p.lastname ".$_GET['dir2'].", p.firstname ".$_GET['dir2'];
  }else{
    $sort = $_GET['sort2']." ".$_GET['dir2'];
  }

}
        if(isset($_GET['notes']) && $_GET['notes']==1){
          $pend_sql .= " AND num_notes > 0 ";
        }
$pend_sql .= " ORDER BY " . mysql_real_escape_string($sort);
$pend_my=mysql_query($pend_sql) or die(mysql_error());


	
$sql = "select i.*, p.firstname, p.lastname,
	COALESCE(notes.num_notes, 0) num_notes,
	(SELECT e.adddate FROM dental_claim_electronic e WHERE e.claimid=i.insuranceid ORDER by e.adddate DESC LIMIT 1) electronic_adddate
	from dental_insurance i left join dental_patients p on i.patientid=p.patientid 
	LEFT JOIN (SELECT claim_id, count(*) num_notes FROM dental_claim_notes group by claim_id) notes ON notes.claim_id=i.insuranceid 
	where i.docid='".$_SESSION['docid']."' ";
if($_SESSION['user_type']==DSS_USER_TYPE_SOFTWARE){
  $sql .= " AND i.status NOT  IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_DISPUTE.", ".DSS_CLAIM_SEC_DISPUTE.", ".DSS_CLAIM_REJECTED.", ".DSS_CLAIM_SEC_REJECTED.")";
}
if(isset($_GET['unpaid'])){
  $sql .= " AND i.status NOT IN  (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_REJECTED.", ".DSS_CLAIM_PAID_INSURANCE.", ".DSS_CLAIM_PAID_PATIENT.", ".DSS_CLAIM_PAID_SEC_INSURANCE.", ".DSS_CLAIM_PAID_SEC_PATIENT.") AND i.adddate < DATE_SUB(NOW(), INTERVAL ".mysql_real_escape_string($_GET['unpaid'])." day) ";
}
        if(isset($_GET['notes']) && $_GET['notes']==1){
          $sql .= " AND num_notes > 0 ";
        }
if(isset($_GET['unmailed'])){
  $sql .= " AND i.mailed_date IS NULL AND i.sec_mailed_date is NULL ";
}
if(isset($_GET['sort2'])){
  if($_GET['sort2']=='patient'){
    $sort = "p.lastname ".$_GET['dir2'].", p.firstname ".$_GET['dir2'];
  }else{
    $sort = $_GET['sort2']." ".$_GET['dir2'];
  }

}
$sql .= " ORDER BY " . mysql_real_escape_string($sort);
 
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Pending Claims 
</span>
<div style="float: right; margin-right: 20px;">
<?php if(!isset($_GET['notes'])){ ?>
<a href="manage_claims.php?notes=1" class="addButton">Show Claims w Notes</a>
<?php }

if(isset($_GET['notes'])){ ?>
  <a href="manage_claims.php" class="addButton">Show All</a>
<?php } ?>
</div>

<br />
&nbsp;&nbsp;

  
<br />
<?php
if(isset($_GET['msg'])){
?>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<?php
} 
?>
<table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?= ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
                </td>
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=patient&dir2=<?= ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
                </td>
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=status&dir2=<?= ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
                </td>
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=notes&dir2=<?= ($_GET['sort2']=='notes' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Notes</a>
                </td>
                <td valign="top" class="col_head" width="20%">
                        Action
                </td>
        </tr>
        <? if(mysql_num_rows($pend_my) == 0)
        { ?>
                <tr class="tr_bg">
                        <td valign="top" class="col_head" colspan="10" align="center">
                                No Records
                        </td>
                </tr>
        <?
        }
        else
        {
                while($pend_myarray = mysql_fetch_array($pend_my))
                {
                        if($pend_myarray["status"] == 1)
                        {
                                $tr_class = "tr_active";
                        }
                        else
                        {
                                $tr_class = "tr_inactive";
                        }
                        $tr_class = "tr_active";
                ?>
                        <tr class="<?=$tr_class;?> status_<?= $pend_myarray['status']; ?> claim">
                                <td valign="top">
<?=date('m-d-Y H:i',strtotime((($pend_myarray["electronic_adddate"]!='')?$pend_myarray["electronic_adddate"]:$pend_myarray["adddate"])));?>
                                </td>
                                <td valign="top">
                                        <?= $pend_myarray['firstname'].' '.$pend_myarray['lastname']; ?>
                                </td>
                                <td valign="top">
                                    <?=$dss_claim_status_labels[$pend_myarray['status']];?>
                                </td>
                                <td valign="top">
                                    <a href="view_claim.php?claimid=<?= $pend_myarray['insuranceid']; ?>&pid=<?= $pend_myarray['patientid']; ?>#notes">View (<?=$pend_myarray['num_notes'];?>)</a>
                                </td>
                                <td valign="top">
<a href="view_claim.php?claimid=<?=$pend_myarray["insuranceid"];?>&pid=<?= $pend_myarray['patientid']; ?>" class="editlink" title="EDIT">
                                                View 
                                        </a>


                                </td>
                        </tr>
        <?      }
        }?>
</table>


<br /><br /><br />

<?php if(isset($_GET['unmailed'])){ ?>
<span class="admin_head">Unmailed Claims</span>
<?php }else{ ?>
<span class="admin_head">Submitted Claims</span>
<?php } ?>
<?php
if(isset($_GET['unpaid'])){
?>
<span style="margin-left:10px">(Showing Unpaid Claims Greater than 30 Days Old)</span>
<? } ?>

<label style="margin-left:20px;">Filter by status</label> 
<select onchange="updateClaims(this.value)">
<option value="100"  <?= ($_GET['filter']== 100)?'selected="selected"':''; ?>>All</option>
<option value="<?= DSS_CLAIM_PAID_INSURANCE; ?>" <?= ($_GET['filter']== DSS_CLAIM_PAID_INSURANCE)?'selected="selected"':''; ?>><?= $dss_claim_status_labels[DSS_CLAIM_PAID_INSURANCE]; ?></option>
<option value="<?= DSS_CLAIM_SENT; ?>" <?= ($_GET['filter']== DSS_CLAIM_SENT)?'selected="selected"':''; ?>><?= $dss_claim_status_labels[DSS_CLAIM_SENT]; ?></option>
<option value="<?= DSS_CLAIM_DISPUTE; ?>" <?= ($_GET['filter']== DSS_CLAIM_DISPUTE)?'selected="selected"':''; ?>><?= $dss_claim_status_labels[DSS_CLAIM_DISPUTE]; ?></option>
<option value="<?= DSS_CLAIM_REJECTED; ?>" <?= ($_GET['filter']== DSS_CLAIM_REJECTED)?'selected="selected"':''; ?>><?= $dss_claim_status_labels[DSS_CLAIM_REJECTED]; ?></option>
</select>
<div style="float: right; margin-right: 20px;">
<?php if(!isset($_GET['notes'])){ ?>
<a href="manage_claims.php?notes=1" class="addButton">Show Claims w Notes</a>
<?php }

if(!isset($_GET['unpaid'])){ ?>
<a href="manage_claims.php?unpaid=30" class="addButton">Show Unpaid Claims 30 day+</a>
<?php }
if(!isset($_GET['unmailed'])){ ?>
<a href="manage_claims.php?unmailed=1" class="addButton">Show Unmailed Claims</a>
<?php }
if(isset($_GET['notes']) || isset($_GET['unmailed']) || isset($_GET['unpaid'])){ ?>
  <a href="manage_claims.php" class="addButton">Show All</a>
<?php } ?>
</div>
<script type="text/javascript">

function updateClaims(v){

window.location="?filter="+v+"&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=<?= $_GET['sort2']; ?>&dir2=<?= $_GET['dir2']; ?>";

}

$('document').ready( function(){
var v = '<?= $_GET['filter']; ?>';
if(v == '100'){
  $('.claim').show();
}else if(v == '<?= DSS_CLAIM_PENDING; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_PENDING; ?>').show();
  $('.status_<?= DSS_CLAIM_SEC_PENDING; ?>').show();
}else if(v == '<?= DSS_CLAIM_PAID_INSURANCE; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_PAID_INSURANCE; ?>').show();
  $('.status_<?= DSS_CLAIM_PAID_SEC_INSURANCE; ?>').show();
  $('.status_<?= DSS_CLAIM_PAID_PATIENT; ?>').show();
}else if(v == '<?= DSS_CLAIM_SENT; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_SENT; ?>').show();
  $('.status_<?= DSS_CLAIM_SEC_SENT; ?>').show();
}else if(v == '<?= DSS_CLAIM_DISPUTE; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_DISPUTE; ?>').show();
  $('.status_<?= DSS_CLAIM_SEC_DISPUTE; ?>').show();
}else if(v == '<?= DSS_CLAIM_REJECTED; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_REJECTED; ?>').show();
}

});
</script>

<insurance name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?= ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
			<a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?= ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
		</td>
		<td valign="top" class="col_head <?= ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
			<a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=patient&dir2=<?= ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
		</td>
		<td valign="top" class="col_head <?= ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
			<a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=status&dir2=<?= ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
		</td>
		<td valign="top" class="col_head <?= ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="10%">
			<a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=notes&dir2=<?= ($_GET['sort2']=='notes' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Notes</a>
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
		<td valign="top" class="col_head" width="10%">
			Mailed
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		$sec_status = array(DSS_CLAIM_SEC_SENT, DSS_CLAIM_SEC_DISPUTE, DSS_CLAIM_PAID_SEC_INSURANCE, DSS_CLAIM_PAID_SEC_PATIENT,DSS_CLAIM_SEC_PATIENT_DISPUTE, DSS_CLAIM_SEC_REJECTED);
		while($myarray = mysql_fetch_array($my))
		{
	if(in_array($myarray["status"], $sec_status)){
	  $is_secondary = true;
	}else{
	  $is_secondary = false;
 	}

			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
		?>
			<tr class="<?=$tr_class;?> status_<?= $myarray['status']; ?> claim">
				<td valign="top">
				
                	<?=date('m-d-Y H:i',strtotime((($myarray["electronic_adddate"]!='')?$myarray["electronic_adddate"]:$myarray["adddate"])));?>
				</td>
				<td valign="top">
					<?= $myarray['firstname'].' '.$myarray['lastname']; ?>	
				</td>
				<td valign="top">
				    <?=$dss_claim_status_labels[$myarray['status']];?>
				</td>
                                <td valign="top">
                                    <a href="view_claim.php?claimid=<?= $myarray['insuranceid']; ?>&pid=<?= $myarray['patientid']; ?>#notes">View (<?=$myarray['num_notes'];?>)</a>
                                </td>

				<td valign="top">
<a href="view_claim.php?claimid=<?=$myarray["insuranceid"];?>&pid=<?= $myarray['patientid']; ?>" class="editlink" title="EDIT">
                                                View 
                                        </a>
				|
				<a href="print_claim.php?insid=<?=$myarray["insuranceid"];?>&pid=<?= $myarray['patientid']; ?>" class="editlink" title="EDIT">
                                                Print
                                        </a>
				</td>
	                <?php if($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
		  <?php if($is_secondary){ ?>
                    <td><input type="checkbox" class="sec_mailed_chk" value="<?= $myarray['insuranceid']; ?>" <?= ($myarray['sec_mailed_date'] !='')?'checked="checked"':''; ?> /></td>
		  <?php }else{ ?>
                    <td><input type="checkbox" class="mailed_chk" value="<?= $myarray['insuranceid']; ?>" <?= ($myarray['mailed_date'] !='')?'checked="checked"':''; ?> /></td>
		  <?php } ?>
                <?php } ?>
                <?php if($_SESSION['user_type'] == DSS_USER_TYPE_FRANCHISEE) { ?>
                <td><?= ($myarray['mailed_date'] !='')?'X':''; ?></td>
                <?php } ?>
			</tr>
	<? 	}
	}?>
</table>
</insurance>

<br/><br/>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>

<script type="text/javascript">
  $('.mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    type = 'pri';
                                   $.ajax({
                                        url: "includes/claim_mail.php",
                                        type: "post",
                                        data: {lid: lid, mailed: c, type:type},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        //window.location.reload();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

  });
  $('.sec_mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    type = 'sec';
                                   $.ajax({
                                        url: "includes/claim_mail.php",
                                        type: "post",
                                        data: {lid: lid, mailed: c, type:type},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        //window.location.reload();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

  });

</script>
