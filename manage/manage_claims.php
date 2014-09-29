<?php
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
    $db->query($del_sql);

    $msg= "Deleted Successfully";
    ?>
    <script type="text/javascript">
            //alert("Deleted Successfully");
            window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
    </script>
    <?php
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
$pend_my = $db->getResults($pend_sql);

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
 
$my = $db->getResults($sql);

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
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
            <a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?php echo ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
           <a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=patient&dir2=<?php echo ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
           <a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=status&dir2=<?php echo ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
            <a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=notes&dir2=<?php echo ($_GET['sort2']=='notes' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Notes</a>
        </td>
        <td valign="top" class="col_head" width="20%">
            Action
        </td>
    </tr>
    <?php if(count($pend_my) == 0)
    { ?>
    <tr class="tr_bg">
        <td valign="top" class="col_head" colspan="10" align="center">
            No Records
        </td>
    </tr>
    <?php
    }
    else
    {
        foreach ($pend_my as $pend_myarray) {

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
    <tr class="<?php echo $tr_class;?> status_<?php echo $pend_myarray['status']; ?> claim">
        <td valign="top">
            <?php echo date('m-d-Y H:i',strtotime((($pend_myarray["electronic_adddate"]!='')?$pend_myarray["electronic_adddate"]:$pend_myarray["adddate"])));?>
        </td>
        <td valign="top">
            <?php echo $pend_myarray['firstname'].' '.$pend_myarray['lastname']; ?>
        </td>
        <td valign="top">
            <?php echo $dss_claim_status_labels[$pend_myarray['status']];?>
        </td>
        <td valign="top">
            <a href="view_claim.php?claimid=<?php echo $pend_myarray['insuranceid']; ?>&pid=<?php echo $pend_myarray['patientid']; ?>#notes">View (<?php echo $pend_myarray['num_notes'];?>)</a>
        </td>
        <td valign="top">
            <a href="view_claim.php?claimid=<?php echo $pend_myarray["insuranceid"];?>&pid=<?php echo $pend_myarray['patientid']; ?>" class="editlink" title="EDIT">
            View 
            </a>
        </td>
    </tr>
    <?php }
    }?>
</table>

<br /><br /><br />

<?php if(isset($_GET['unmailed'])){ ?>
    <span class="admin_head">Unmailed Claims</span>
<?php }else{ ?>
    <span class="admin_head">Submitted Claims</span>
<?php } 
if(isset($_GET['unpaid'])){ ?>
    <span style="margin-left:10px">(Showing Unpaid Claims Greater than 30 Days Old)</span>
<?php } ?>

<label style="margin-left:20px;">Filter by status</label> 
<select onchange="updateClaims(this.value)">
    <option value="100"  <?php echo ($_GET['filter']== 100)?'selected="selected"':''; ?>>All</option>
    <option value="<?php echo DSS_CLAIM_PAID_INSURANCE; ?>" <?php echo ($_GET['filter']== DSS_CLAIM_PAID_INSURANCE)?'selected="selected"':''; ?>><?php echo $dss_claim_status_labels[DSS_CLAIM_PAID_INSURANCE]; ?></option>
    <option value="<?php echo DSS_CLAIM_SENT; ?>" <?php echo ($_GET['filter']== DSS_CLAIM_SENT)?'selected="selected"':''; ?>><?php echo $dss_claim_status_labels[DSS_CLAIM_SENT]; ?></option>
    <option value="<?php echo DSS_CLAIM_DISPUTE; ?>" <?php echo ($_GET['filter']== DSS_CLAIM_DISPUTE)?'selected="selected"':''; ?>><?php echo $dss_claim_status_labels[DSS_CLAIM_DISPUTE]; ?></option>
    <option value="<?php echo DSS_CLAIM_REJECTED; ?>" <?php echo ($_GET['filter']== DSS_CLAIM_REJECTED)?'selected="selected"':''; ?>><?php echo $dss_claim_status_labels[DSS_CLAIM_REJECTED]; ?></option>
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
  window.location="?filter="+v+"&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=<?php echo $_GET['sort2']; ?>&dir2=<?php echo $_GET['dir2']; ?>";
}

$('document').ready( function(){
var v = '<?php echo $_GET['filter']; ?>';
if(v == '100'){
  $('.claim').show();
}else if(v == '<?php echo DSS_CLAIM_PENDING; ?>'){
  $('.claim').hide();
  $('.status_<?php echo DSS_CLAIM_PENDING; ?>').show();
  $('.status_<?php echo DSS_CLAIM_SEC_PENDING; ?>').show();
}else if(v == '<?php echo DSS_CLAIM_PAID_INSURANCE; ?>'){
  $('.claim').hide();
  $('.status_<?php echo DSS_CLAIM_PAID_INSURANCE; ?>').show();
  $('.status_<?php echo DSS_CLAIM_PAID_SEC_INSURANCE; ?>').show();
  $('.status_<?php echo DSS_CLAIM_PAID_PATIENT; ?>').show();
}else if(v == '<?php echo DSS_CLAIM_SENT; ?>'){
  $('.claim').hide();
  $('.status_<?php echo DSS_CLAIM_SENT; ?>').show();
  $('.status_<?php echo DSS_CLAIM_SEC_SENT; ?>').show();
}else if(v == '<?php echo DSS_CLAIM_DISPUTE; ?>'){
  $('.claim').hide();
  $('.status_<?php echo DSS_CLAIM_DISPUTE; ?>').show();
  $('.status_<?php echo DSS_CLAIM_SEC_DISPUTE; ?>').show();
}else if(v == '<?php echo DSS_CLAIM_REJECTED; ?>'){
  $('.claim').hide();
  $('.status_<?php echo DSS_CLAIM_REJECTED; ?>').show();
}

});
</script>

<insurance name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
      <tr class="tr_bg_h">
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
      		<a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?php echo ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
      	</td>
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
      		<a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=patient&dir2=<?php echo ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
      	</td>
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
      		<a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=status&dir2=<?php echo ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
      	</td>
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="10%">
      		<a href="?filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=notes&dir2=<?php echo ($_GET['sort2']=='notes' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Notes</a>
      	</td>
      	<td valign="top" class="col_head" width="20%">
      		Action
      	</td>
      	<td valign="top" class="col_head" width="10%">
      		Mailed
      	</td>
      </tr>
      <?php if(count($my) == 0){ ?>
      <tr class="tr_bg">
          <td valign="top" class="col_head" colspan="10" align="center">
              No Records
          </td>
      </tr>
      <?php 
      }
      else
      {
      		$sec_status = array(DSS_CLAIM_SEC_SENT, DSS_CLAIM_SEC_DISPUTE, DSS_CLAIM_PAID_SEC_INSURANCE, DSS_CLAIM_PAID_SEC_PATIENT,DSS_CLAIM_SEC_PATIENT_DISPUTE, DSS_CLAIM_SEC_REJECTED);
      		foreach ($my as $myarray) {

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
      <tr class="<?php echo $tr_class;?> status_<?php echo $myarray['status']; ?> claim">
          <td valign="top">
              <?php echo date('m-d-Y H:i',strtotime((($myarray["electronic_adddate"]!='')?$myarray["electronic_adddate"]:$myarray["adddate"])));?>
          </td>
          <td valign="top">
              <?php echo $myarray['firstname'].' '.$myarray['lastname']; ?>	
          </td>
          <td valign="top">
              <?php echo $dss_claim_status_labels[$myarray['status']];?>
          </td>
          <td valign="top">
              <a href="view_claim.php?claimid=<?php echo $myarray['insuranceid']; ?>&pid=<?php echo $myarray['patientid']; ?>#notes">View (<?php echo $myarray['num_notes'];?>)</a>
          </td>
          <td valign="top">
              <a href="view_claim.php?claimid=<?php echo $myarray["insuranceid"];?>&pid=<?php echo $myarray['patientid']; ?>" class="editlink" title="EDIT">
                  View 
              </a>
              |
              <a href="print_claim.php?insid=<?php echo $myarray["insuranceid"];?>&pid=<?php echo $myarray['patientid']; ?>" class="editlink" title="EDIT">
                  Print
              </a>
          </td>
          <?php if($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { 
              if($is_secondary){ ?>
          <td>
              <input type="checkbox" class="sec_mailed_chk" value="<?php echo $myarray['insuranceid']; ?>" <?php echo ($myarray['sec_mailed_date'] !='')?'checked="checked"':''; ?> />
          </td>
          <?php }else{ ?>
          <td>
              <input type="checkbox" class="mailed_chk" value="<?php echo $myarray['insuranceid']; ?>" <?php echo ($myarray['mailed_date'] !='')?'checked="checked"':''; ?> />
          </td>
          <?php } 
          } ?>
          <?php if($_SESSION['user_type'] == DSS_USER_TYPE_FRANCHISEE) { ?>
          <td>
              <?php echo ($myarray['mailed_date'] !='')?'X':''; ?>
          </td>
          <?php } ?>
      </tr>
      <?php 	}
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
