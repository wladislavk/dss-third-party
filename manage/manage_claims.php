<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include_once "includes/constants.inc";

$specialFilter = '';

if (isset($_GET['filed_by'])) {
    switch ($_GET['filed_by']) {
        case 'back':
        case 'both':
            $specialFilter = $_GET['filed_by'];
            break;
    }
}

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
    trigger_error("Die called", E_USER_ERROR);
}

/**
 * @see DSS-142
 * @see CS-73
 *
 * Filter BO claims by actionable claims.
 * This query might appear at some other places, please search this "@see DSS-142" tag.
 *
 * The old logic checks the p_m_dss_file and s_m_dss_file columns, which are copies of the options set from the
 * patient's table. This logic does not really set if the claim is filed in the BO.
 *
 * The legacy values are: YES = 1, NO = 2. Thus, if the option is NOT 1 THEN the value is NOT YES.
 *
 * The new indicator will only be the p_m_dss_file column. To avoid conflicts with the previous set of values, the
 * YES indicator will be 3.
 */
$frontOfficeClaimsConditional = frontOfficeClaimsConditional();
$backOfficeClaimsConditional = backOfficeClaimsConditional();
$filedByBackOfficeConditional = filedByBackOfficeConditional();

switch ($specialFilter) {
    case 'both':
        $whichOfficeConditional = '(TRUE)';
        break;
    case 'back':
        $whichOfficeConditional = $backOfficeClaimsConditional;
        break;
    default:
        $whichOfficeConditional = $frontOfficeClaimsConditional;
}

$pend_sql = "SELECT
        claim.*,
        p.firstname,
        p.lastname,
        p.p_m_dss_file,
        p.docid,
        COALESCE(notes.num_notes, 0) num_notes,
        (
            SELECT e.adddate
            FROM dental_claim_electronic e
            WHERE e.claimid = claim.insuranceid
            ORDER by e.adddate DESC
            LIMIT 1
        ) AS electronic_adddate,
        $backOfficeClaimsConditional AS belongs_to_bo
    FROM dental_insurance claim
        LEFT JOIN dental_patients p ON claim.patientid = p.patientid
        JOIN dental_users users ON claim.docid = users.userid
        LEFT JOIN companies c ON c.id = users.billing_company_id
        LEFT JOIN (
            SELECT claim_id, COUNT(id) num_notes
            FROM dental_claim_notes
            GROUP BY claim_id
        ) notes ON notes.claim_id = claim.insuranceid
    WHERE claim.docid = '{$_SESSION['docid']}'
        AND $whichOfficeConditional
        ";

$pend_sql .= "
        AND (
            claim.status IN (" . $db->escapeList(ClaimFormData::statusListByName('actionable')) . ")
        )
        ";

if (isset($_GET['sort2'])) {
    if ($_GET['sort2'] == 'patient') {
        $sort = "p.lastname ".$_GET['dir2'].", p.firstname ".$_GET['dir2'];
    } else {
        $sort = $_GET['sort2']." ".$_GET['dir2'];
    }
}

if (isset($_GET['notes']) && $_GET['notes'] == 1) {
    $pend_sql .= " AND num_notes > 0 ";
}

$pend_sql .= " ORDER BY " . $db->escape($sort);
$pend_my = $db->getResults($pend_sql);

/**
 * @see DSS-142
 * @see CS-73
 *
 * Filter BO claims by actionable claims.
 * This query might appear at some other places, please search this "@see DSS-142" tag.
 *
 * The old logic checks the p_m_dss_file and s_m_dss_file columns, which are copies of the options set from the
 * patient's table. This logic does not really set if the claim is filed in the BO.
 *
 * The legacy values are: YES = 1, NO = 2. Thus, if the option is NOT 1 THEN the value is NOT YES.
 *
 * The new indicator will only be the p_m_dss_file column. To avoid conflicts with the previous set of values, the
 * YES indicator will be 3.
 */
$sql = "SELECT
        claim.*,
        p.firstname,
        p.lastname,
        COALESCE(notes.num_notes, 0) AS num_notes,
        (
            SELECT e.adddate
            FROM dental_claim_electronic e
            WHERE e.claimid = claim.insuranceid
            ORDER by e.adddate DESC
            LIMIT 1
        ) AS electronic_adddate,
        $backOfficeClaimsConditional AS belongs_to_bo
    FROM dental_insurance claim
        LEFT JOIN dental_patients p ON claim.patientid = p.patientid
        JOIN dental_users users ON claim.docid = users.userid
        LEFT JOIN companies c ON c.id = users.billing_company_id
        LEFT JOIN (
            SELECT claim_id, COUNT(id) AS num_notes
            FROM dental_claim_notes
            GROUP BY claim_id
        ) notes ON notes.claim_id = claim.insuranceid
    WHERE claim.docid = '{$_SESSION['docid']}'
        AND $whichOfficeConditional
        ";

if ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) {
    $sql .= "
        AND claim.status NOT IN (" . $db->escapeList(ClaimFormData::statusListByName('actionable')) . ")
        ";
}

if (isset($_GET['unpaid'])) {
    $sql .= "
        AND claim.status NOT IN  (
            '" . DSS_CLAIM_PENDING . "',
            '" . DSS_CLAIM_SEC_PENDING . "',
            '" . DSS_CLAIM_REJECTED . "',
            '" . DSS_CLAIM_PAID_INSURANCE . "',
            '" . DSS_CLAIM_PAID_PATIENT . "',
            '" . DSS_CLAIM_PAID_SEC_INSURANCE . "',
            '" . DSS_CLAIM_PAID_SEC_PATIENT . "'
        )
        AND claim.adddate < DATE_SUB(NOW(), INTERVAL " . intval($_GET['unpaid']) . " day)
        ";
}

if (isset($_GET['notes']) && $_GET['notes'] == 1) {
    $sql .= " AND num_notes > 0 ";
}

if (isset($_GET['unmailed'])) {
    $sql .= " AND claim.mailed_date IS NULL AND claim.sec_mailed_date is NULL ";
}

if (isset($_GET['sort2'])) {
    if ($_GET['sort2'] == 'patient') {
        $sort = "p.lastname ".$_GET['dir2'].", p.firstname ".$_GET['dir2'];
    } else {
        $sort = $_GET['sort2']." ".$_GET['dir2'];
    }
}

$sql .= " ORDER BY " . $db->escape($sort);
$my = $db->getResults($sql);

?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<style type="text/css">
    #contentMain > br:first-of-type {
        display: none;
    }
    #patient_nav {
        width: 98.6%;
        margin: auto;
        padding-top: 10px;
        margin-bottom: 10px;
    }
</style>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<div id="patient_nav">
    <ul>
        <li>
            <a class="<?= !$specialFilter ? 'nav_active' : '' ?>" href="/manage/manage_claims.php">FO Claims</a>
        </li>
        <li>
            <a class="<?= $specialFilter == 'back' ? 'nav_active' : '' ?>" href="/manage/manage_claims.php?filed_by=back">BO Claims</a>
        </li>
        <li>
            <a class="<?= $specialFilter == 'both' ? 'nav_active' : '' ?>" href="/manage/manage_claims.php?filed_by=both">Both</a>
        </li>
    </ul>
</div>

<span class="admin_head">
  Pending Claims 
</span>
<div style="float: right; margin-right: 20px;">
  <?php if(!isset($_GET['notes'])){ ?>
    <a href="manage_claims.php?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>notes=1" class="addButton">Show Claims w Notes</a>
  <?php }

  if(isset($_GET['notes'])){ ?>
    <a href="manage_claims.php<?= $specialFilter ? "?filed_by=$specialFilter" : '' ?>" class="addButton">Show All</a>
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
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
            <a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?php echo ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
           <a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=patient&dir2=<?php echo ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="30%">
           <a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=status&dir2=<?php echo ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="30%">
            <a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=notes&dir2=<?php echo ($_GET['sort2']=='notes' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Notes</a>
        </td>
        <td valign="top" class="col_head" width="15%">
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
            $tr_class = $pend_myarray['belongs_to_bo'] ? 'tr_inactive' : 'tr_active';
        ?>
    <tr class="<?php echo $tr_class;?> status_<?php echo $pend_myarray['status']; ?> claim"
        <?= $pend_myarray['belongs_to_bo'] ? 'title="This claim is handled by BO"' : '' ?>>
        <td valign="top">
            <?php echo date('m-d-Y H:i',strtotime((($pend_myarray["electronic_adddate"]!='')?$pend_myarray["electronic_adddate"]:$pend_myarray["adddate"])));?>
        </td>
        <td valign="top">
            <?php echo $pend_myarray['firstname'].' '.$pend_myarray['lastname']; ?>
        </td>
        <td valign="top">
            <?php echo $dss_claim_status_labels[$pend_myarray['status']];?>
            <?php
            if($pend_myarray['p_m_dss_file']!=2){
                $b_sql = "SELECT c.name, c.exclusive FROM companies c JOIN dental_users u ON c.id=u.billing_company_id WHERE u.userid='".mysqli_real_escape_string($con,$pend_myarray['docid'])."'";
                $b_q = $db->getRow($b_sql);
                if(!empty($b_q)){
                    $b_r = $b_q;
                    $exclusive_billing = $b_r['exclusive'];
                    $billing_co = $b_r['name'];
                }else{
                    $exclusive_billing = 0;
                    $billing_co = "DSS";
                }
                echo "(".$billing_co." filing)";
            }
            ?>
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
    <a href="manage_claims.php?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>notes=1" class="addButton">Show Claims w Notes</a>
<?php }
if(!isset($_GET['unpaid'])){ ?>
    <a href="manage_claims.php?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>unpaid=30" class="addButton">Show Unpaid Claims 30 day+</a>
<?php }
if(!isset($_GET['unmailed'])){ ?>
    <a href="manage_claims.php?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>unmailed=1" class="addButton">Show Unmailed Claims</a>
<?php }
if(isset($_GET['notes']) || isset($_GET['unmailed']) || isset($_GET['unpaid'])){ ?>
    <a href="manage_claims.php<?= $specialFilter ? "?filed_by=$specialFilter" : '' ?>" class="addButton">Show All</a>
<?php } ?>
</div>

<script type="text/javascript">

function updateClaims(v){
  window.location="?<?= $specialFilter ? "filed_by=$specialFilter&" : '' ?>filter="+v+"&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=<?php echo $_GET['sort2']; ?>&dir2=<?php echo $_GET['dir2']; ?>";
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

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
      <tr class="tr_bg_h">
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
      		<a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?php echo ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
      	</td>
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
      		<a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=patient&dir2=<?php echo ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
      	</td>
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
      		<a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=status&dir2=<?php echo ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
      	</td>
      	<td valign="top" class="col_head <?php echo ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="10%">
      		<a href="?<?= $specialFilter ? "filed_by=$specialFilter&amp;" : '' ?>filter=<?php echo $_GET['filter']; ?>&sort1=<?php echo $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=notes&dir2=<?php echo ($_GET['sort2']=='notes' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Notes</a>
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

                $tr_class = $myarray['belongs_to_bo'] ? 'tr_inactive' : 'tr_active';
      ?>
      <tr class="<?php echo $tr_class;?> status_<?php echo $myarray['status']; ?> claim"
          <?= $myarray['belongs_to_bo'] ? 'title="This claim is handled by BO"' : '' ?>>
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
              <input type="checkbox" <?= $myarray['belongs_to_bo'] ? 'disabled' : '' ?>
                  class="sec_mailed_chk <?= $myarray['belongs_to_bo'] ? 'filed-by-bo' : '' ?>"
                  value="<?php echo $myarray['insuranceid']; ?>" <?php echo ($myarray['sec_mailed_date'] !='')?'checked="checked"':''; ?> />
          </td>
          <?php }else{ ?>
          <td>
              <input type="checkbox" <?= $myarray['belongs_to_bo'] ? 'disabled' : '' ?>
                  class="mailed_chk <?= $myarray['belongs_to_bo'] ? 'filed-by-bo' : '' ?>"
                  value="<?php echo $myarray['insuranceid']; ?>" <?php echo ($myarray['mailed_date'] !='')?'checked="checked"':''; ?> />
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
</form>

<br/><br/>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>

<script type="text/javascript">
  $('.mailed_chk:not(.filed-by-bo)').click( function(){
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
  $('.sec_mailed_chk:not(.filed-by-bo)').click( function(){
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
