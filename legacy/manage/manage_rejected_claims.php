<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/constants.inc';

$db = new Db();

$specialFilter = '';
$isDefaultFilter = false;

if (isset($_GET['filed_by'])) {
    switch ($_GET['filed_by']) {
        case 'back':
        case 'both':
            $specialFilter = $_GET['filed_by'];
            break;
    }
}

if(!isset($_GET['sort1'])){
    $isDefaultFilter = true;
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
if (isset($_GET['sort2'])) {
    if ($_GET['sort2'] == 'patient') {
        $sort = "p.lastname ".$_GET['dir2'].", p.firstname ".$_GET['dir2'];
    } else {
        $sort = $_GET['sort2']." ".$_GET['dir2'];
    }
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

$sql = "SELECT
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

$sql .= "
        AND (
            claim.status IN (" . $db->escapeList(ClaimFormData::statusListByName('rejected')) . ")
        )
        ";

if ($isDefaultFilter) {
    $sort = " claim.adddate DESC, p.lastname ASC, p.firstname ASC";
} elseif (isset($_GET['sort2'])) {
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
	<script src="admin/popup/popup.js" type="text/javascript"></script>
<style type="text/css">
    #contentMain > br:first-of-type {
        display: none;
    }
    #patient_nav {
        width: 98.6%;
        margin: auto;
        padding-top: 15px;
        margin-bottom: 15px;
    }
    #patient_nav > ul > li:last-child {
        padding-right: 15px;
        float: right;
    }
    #patient_nav > ul > li:last-child mark {
        background-color: #b7b7b7;
    }
</style>
<div id="patient_nav">
    <ul>
        <li>
            <a class="<?= !$specialFilter ? 'nav_active' : '' ?>" href="/manage/manage_rejected_claims.php">
                My Claims
            </a>
        </li>
        <li>
            <a class="<?= $specialFilter == 'back' ? 'nav_active' : '' ?>" href="/manage/manage_rejected_claims.php?filed_by=back">
                External Billing Claims
            </a>
        </li>
        <li>
            <a class="<?= $specialFilter == 'both' ? 'nav_active' : '' ?>" href="/manage/manage_rejected_claims.php?filed_by=both">
                All Claims
            </a>
        </li>
        <li>Note: Claims sent via <mark>3rd party billing service</mark> are visible in "External Billing Claims"</li>
    </ul>
</div>
	<br />
<?php
	if (isset($_GET['msg'])) {
?>
		<div align="center" class="red">
			<b><? echo $_GET['msg'];?></b>
		</div>
<?php
	} 
?>

<span class="admin_head">Rejected Claims</span>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?php echo  (!empty($_GET['sort2']) && $_GET['sort2'] == 'adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
			<a href="?filter=<?php echo  (!empty($_GET['filter']) ? $_GET['filter'] : ''); ?>&sort1=<?php echo  (!empty($_GET['sort1']) ? $_GET['sort1'] : ''); ?>&dir1=<?php echo (!empty($_GET['dir1']) ? $_GET['dir1'] : ''); ?>&sort2=adddate&dir2=<?php echo  (!empty($_GET['sort2']) && $_GET['sort2']=='adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
		</td>
		<td valign="top" class="col_head <?php echo  (!empty($_GET['sort2']) && $_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
			<a href="?filter=<?php echo  (!empty($_GET['filter']) ? $_GET['filter'] : ''); ?>&sort1=<?php echo  (!empty($_GET['sort1']) ? $_GET['sort1'] : ''); ?>&dir1=<?php echo (!empty($_GET['dir1']) ? $_GET['dir1'] : ''); ?>&sort2=patient&dir2=<?php echo  (!empty($_GET['sort2']) && $_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
		</td>
		<td valign="top" class="col_head <?php echo  (!empty($_GET['sort2']) && $_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
			<a href="?filter=<?php echo  (!empty($_GET['filter']) ? $_GET['filter'] : ''); ?>&sort1=<?php echo  (!empty($_GET['sort1']) ? $_GET['sort1'] : ''); ?>&dir1=<?php echo (!empty($_GET['dir1']) ? $_GET['dir1'] : ''); ?>&sort2=status&dir2=<?php echo  (!empty($_GET['sort2']) && $_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<?php if (count($my) == 0) { ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php }	else {
			foreach ($my as $myarray) {
				if ($myarray["status"] == 1) {
					$tr_class = "tr_active";
				} else {
					$tr_class = "tr_inactive";
				}

				$tr_class = "tr_active";

				$e_sql = "SELECT * FROM dental_claim_electronic where claimid='".$myarray['insuranceid']."' ORDER BY adddate DESC LIMIT 1";
				$e_r = $db->getRow($e_sql);
				$last_date = ($e_r['adddate']!='')?$e_r['adddate']:$myarray['adddate'];
	?>
				<tr class="<?php echo $tr_class;?> status_<?php echo  $myarray['status']; ?> claim">
					<td valign="top">
	                	<?php echo date('m-d-Y H:i',strtotime(st($last_date)));?>
					</td>
					<td valign="top">
						<?php echo  $myarray['firstname'].' '.$myarray['lastname']; ?>	
					</td>
					<td valign="top">
					    <?php echo $dss_claim_status_labels[$myarray['status']];?>
					</td>
					<td valign="top">
						<a href="view_claim.php?claimid=<?php echo $myarray["insuranceid"];?>&pid=<?php echo  $myarray['patientid']; ?>" class="editlink" title="EDIT">
                        Fix 
                        </a>
					</td>
				</tr>
				<tr>
					<td colspan="4">
			    		<?php 
							$e_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysqli_real_escape_string($con,$myarray['insuranceid'])."' ORDER BY adddate DESC LIMIT 1";
							$e_q = $db->getResults($e_sql);
							foreach ($e_q as $electronic) {
								$r = json_decode($electronic['response']);
								$errors = $r->{"errors"};

								foreach($errors as $error){
								  echo $error->{"message"}."<br />";
								}

								$r_sql = "SELECT * FROM dental_eligible_response WHERE reference_id !='' AND reference_id='".mysqli_real_escape_string($con,$electronic['reference_id'])."'";
								$r_q = $db->getResults($r_sql);

								if ($r_q) foreach($r_q as $response){
									$r = json_decode($response['response']);
									$acknowledgements = $r->{"acknowledgements"};
                                    foreach ($acknowledgements as $acknowledgement) {
                                        $codes = $acknowledgement->{"details"}->{"codes"};
                                        echo $codes->{"category_code"}." - ";
                                        echo $codes->{"category_label"}."<br />";
                                        echo $codes->{"status_code"}." - ";
                                        echo $codes->{"status_label"};
                                   }
								}
							}
						?>
					</td>
				</tr>
	<?php	}
		}
	?>
</table>
</form>

<br/><br/>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose">
    	<button>X</button>
    </a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />

<?php include "includes/bottom.htm";?>

<script type="text/javascript" src="js/manage_rejected_claims.js"></script>
