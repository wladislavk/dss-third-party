<?php namespace Ds3\Libraries\Legacy;
include __DIR__ . '/includes/top.htm';
include __DIR__ . '/includes/similar.php';
include_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/screener-functions.php';
require_once __DIR__ . '/includes/hst_functions.php';

$coMorbidityLabels = coMorbidityLabels();
$coMorbidityWeights = coMorbidityWeights();

$docId = intval($_SESSION['docid']);
$userId = intval($_SESSION['userid']);

if (isset($db) && $db instanceof Db) {
    $isStaff = $userId == $docId ||
        $db->getColumn("SELECT sign_notes FROM dental_users where userid = '$userId'", 'sign_notes');
}

?>

<link rel="stylesheet" href="css/screener.css" />

<?php
if (!empty($_GET['create_for'])) {
    $patientId = createPatientFromScreener($_GET['create_for']);
    if ($patientId) { ?>
        <script>
            window.location = '/manage/add_patient.php?ed=<?= $patientId ?>&pid=<?= $patientId ?>';
        </script>
    <?php } else { ?>
        <script>
            alert('There was a problem creating the patient profile. Please make sure the link is valid and try again.');
            window.location = '/manage/manage_screeners.php';
        </script>
    <?php }

    trigger_error('Die called', E_USER_ERROR);
}

	if (isset($_REQUEST['delid'])) {
        if (isset($con)) {
            $deleteScreenerSql = "DELETE FROM dental_screener where docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."' AND id='".mysqli_real_escape_string($con,$_REQUEST['delid'])."'";
        }
	  $db->query($deleteScreenerSql);
	}

	if (isset($_REQUEST['hst'])) {
        $screenerSql = "SELECT * FROM dental_screener WHERE id='".mysqli_real_escape_string($con, $_REQUEST['hst'])."'";
        $screenerResult = $db->getRow($screenerSql);

        $hstSql = "SELECT * FROM dental_hst WHERE screener_id='".mysqli_real_escape_string($con, $screenerResult['id'])."'";
        $hstResult = $db->getRow($hstSql);

        $dateOfBirth = ($hstResult['patient_dob'] != '') ? date('m/d/Y', strtotime($hstResult['patient_dob'])) : '';

        $patientSql = "INSERT INTO dental_patients SET
                  docid='".mysqli_real_escape_string($con, $screenerResult['docid'])."',
                  firstname = '".mysqli_real_escape_string($con, $screenerResult['first_name'])."',
                  lastname = '".mysqli_real_escape_string($con, $screenerResult['last_name'])."',
                  cell_phone = '".mysqli_real_escape_string($con, $screenerResult['phone'])."',
                  email = '".mysqli_real_escape_string($con, $hstResult['patient_email'])."',
                  dob = '".mysqli_real_escape_string($con, $dateOfBirth)."',
                  status='1',
                  adddate = now(),
                  ip_address = '".$_SERVER['REMOTE_ADDR']."'";

        error_log($patientSql);
        $newPatientId = $db->getInsertId($patientSql);

        $updateHstSql = "UPDATE dental_hst SET
                  patient_id = '".$newPatientId."',
                  status='".DSS_HST_PENDING."'
                  WHERE screener_id=".mysqli_real_escape_string($con, $screenerResult['id']);

        $db->query($updateHstSql);

        $screener_sql = "UPDATE dental_screener SET
                       patient_id = '".$newPatientId."',
                       contacted = '1'
                       WHERE id=".mysqli_real_escape_string($con, $screenerResult['id']);

        $db->query($screener_sql);
        ?>
        <script>
            window.location = '/manage/hst_request.php?ed=<?= $newPatientId ?>&hst_co=<?= $hstResult['company_id'] ?>';
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }
?>
<link rel="stylesheet" type="text/css" href="css/manage_display_similar.css">
<?php
    $rec_disp = 20;

    if (!empty($_REQUEST["page"])) {
        $index_val = $_REQUEST["page"];
    } else {
        $index_val = 0;
    }

    $sort = "s.adddate";
    if (isset($_REQUEST['sort']) && $_REQUEST['sort'] != '') {
        switch ($_REQUEST['sort']) {
		    case 'patient':
		        $sort = "s.last_name";
		        break;
		    case 'user':
		        $sort = 'u.name';
		        break;
		    case 'phone':
		        $sort = 's.phone';
		        break;
        }
    } else {
        $_REQUEST['sort'] = 'adddate';
        $_REQUEST['sortdir'] = 'DESC';
    }

    $dir = 'DESC';
    if (isset($_REQUEST['sortdir']) && $_REQUEST['sortdir'] != '') {
        $dir = $_REQUEST['sortdir'];
    }
    $i_val = $index_val * $rec_disp;

    $mainScreenerSql = "SELECT
            s.*,
            u.name AS user_name,
            u.first_name AS user_first_name,
            u.last_name AS user_last_name,
            h.id AS hst_id,
            h.status AS hst_status
        FROM dental_screener s
            INNER JOIN dental_users u ON s.userid = u.userid
            LEFT JOIN dental_hst h ON h.screener_id = s.id
        WHERE s.docid = '".$_SESSION['docid']."'"
    ;

    $risk = '';
    if (isset($_GET['risk'])) {
        $risk = $_GET['risk'];
    }
    $contacted = '';
    if (isset($_GET['contacted'])) {
        $contacted = $_GET['contacted'];
    }
    $contactedRisk = '';
    if (isset($_GET['contacted_risk'])) {
        $contactedRisk = $_GET['contacted_risk'];
    }

    if ($risk) {
        $mainScreenerSql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysqli_real_escape_string($con, $risk)." ";
    }

    if ($contacted) {
        $mainScreenerSql .= " AND contacted = ".mysqli_real_escape_string($con, $contacted)." ";
	}

	if ($contactedRisk) {
        $mainScreenerSql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysqli_real_escape_string($con, $contactedRisk)." ";
        $mainScreenerSql .= " AND contacted = 0 ";
    }

	$mainScreenerSql .= "ORDER BY $sort $dir";

    $totalRecords = $db->getNumberRows($mainScreenerSql);

    $numberOfPages = $totalRecords / $rec_disp;

    $mainScreenerSql .= " LIMIT $i_val,$rec_disp";
    $doctorScreeners = $db->getResults($mainScreenerSql);
    $doctorScreenersNumber = count($doctorScreeners);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />

<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">Manage Patient Screeners</span>

<br /><br />&nbsp;<br />

<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<div style="margin-left:20px;margin-bottom:10px;">
	<?php if ($risk >= 10) { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?risk=10" class="addButton">Show High/Severe</a>
	<?php } ?>

	<?php if ($contacted == '0') { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?contacted=0" class="addButton">Show Not Contacted</a>
	<?php } ?>

	<?php if ($contactedRisk >= 10) { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?contacted_risk=10" class="addButton">Show High/Severe NOT Contacted</a>
	<?php } ?>
</div>

<div style="font-weight:bold; font-size: 14px; margin:0 auto; width: 300px; text-align:center;">
	<?php if ($risk >= 10) { ?>
		<p>Showing High/Severe Patients only</p>
	<?php } elseif ($contacted == '0') { ?>
		<p>Showing NOT contacted patients only</p>
	<?php } elseif ($contactedRisk >= 10) { ?>
	        <p>Showing High/Severe NOT contacted patients only</p>
	<?php } else { ?>
		<p>Showing ALL Patients</p>
	<?php } ?>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<?php
        if ($totalRecords > $rec_disp) { ?>
            <tr bgColor="#ffffff">
                <td align="right" colspan="15" class="bp">
                    Pages:
                    <?php
                    paging(
                        $numberOfPages,
                        $index_val,
                        "contacted=$contacted&contacted_risk=$contactedRisk&risk=$risk&sort=".(!empty($_GET['sort']) ? $_GET['sort'] : '')."&sortdir=".(!empty($_GET['sortdir']) ? $_GET['sortdir'] : '')
                    );
                    ?>
                </td>
            </tr>
            <?php
        } ?>
        <tr class="tr_bg_h">
            <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'adddate') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>" width="20%">
                <a href="manage_screeners.php?sort=adddate&sortdir=<?= ($_REQUEST['sort'] == 'adddate' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Date</a>
            </td>
            <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'patient') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>" width="25%">
                <a href="manage_screeners.php?sort=patient&sortdir=<?= ($_REQUEST['sort'] == 'patient' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Patient</a>
            </td>
            <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'phone') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>" width="13%">
                <a href="manage_screeners.php?sort=phone&sortdir=<?= ($_REQUEST['sort'] == 'phone' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Phone</a>
            </td>
            <td valign="top" class="col_head" width="10%">Risk</td>
            <td valign="top" class="col_head" width="10%">CPAP</td>
            <td valign="top" class="col_head" width="10%">Epworth</td>
            <td valign="top" class="col_head" width="10%">Results</td>
            <td valign="top" class="col_head" width="10%">HST</td>
            <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'user') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>" width="10%">
	            <a href="manage_screeners.php?sort=user&sortdir=<?= ($_REQUEST['sort'] == 'user' && $_REQUEST['sortdir'] == 'ASC') ? 'DESC' : 'ASC'; ?>">Screened By</a>
	        </td>
	        <td valign="top" class="col_head" width="10%">Contacted</td>
            <td valign="top" class="col_head">Edit</td>
        </tr>
        <?php
        if ($doctorScreenersNumber == 0) {
            ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="4" align="center">No Records</td>
            </tr>
            <?php
        } else {
            $epworth_labels[0] = 'No chance of dozing';
            $epworth_labels[1] = 'Slight chance of dozing';
            $epworth_labels[2] = 'Moderate chance of dozing';
            $epworth_labels[3] = 'High chance of dozing';

            $doctorIds = [];
            foreach ($doctorScreeners as $doctorScreener) {
                $doctorIds[] = (int)$doctorScreener['id'];
            }
            $doctorIdsString = '\'' . join('\', \'', $doctorIds) . '\'';
            $epworthSql = "
                SELECT se.response, e.epworth, se.screener_id
                FROM dental_screener_epworth se
                JOIN dental_epworth e ON se.epworth_id = e.epworthid
                WHERE se.response > 0
                AND se.screener_id IN ($doctorIdsString);"
            ;
            $epworthResult = $db->getResults($epworthSql);
            foreach ($doctorScreeners as $doctorScreener) :
                $epworthTotal = 0;
                if (count($epworthResult)) {
                    foreach ($epworthResult as $epworthRow) {
                        if ($epworthRow['screener_id'] == $doctorScreener['id']) {
                            $epworthTotal += $epworthRow['response'];
                        }
                    }
                }
                $surveyTotal =
                    $doctorScreener['breathing'] +
                    $doctorScreener['driving'] +
                    $doctorScreener['gasping'] +
                    $doctorScreener['sleepy'] +
                    $doctorScreener['snore'] +
                    $doctorScreener['weight_gain'] +
                    $doctorScreener['blood_pressure'] +
                    $doctorScreener['jerk'] +
                    $doctorScreener['burning'] +
                    $doctorScreener['headaches'] +
                    $doctorScreener['falling_asleep'] +
                    $doctorScreener['staying_asleep']
                ;

                /**
                 * Instead of relying on the field values, sum based on a lookup list.
                 *
                 * Due a mistake on a previous task, the DB values during certain period might be wrong.
                 */
                $sect3Total = coMorbiditySum($doctorScreener);

                $diagnosis = [];

                foreach ($coMorbidityLabels as $fieldName => $legend) {
                    if ($doctorScreener[$fieldName]) {
                        $diagnosis[] = $legend;
                    }
                }
                if ($surveyTotal > 15 || $epworthTotal > 18 || $sect3Total > 3) {
                    $riskLevel = 'severe';
                } elseif ($surveyTotal > 11 || $epworthTotal > 14 || $sect3Total > 2) {
                    $riskLevel = 'high';
                } elseif ($surveyTotal > 7 || $epworthTotal > 9 || $sect3Total > 1) {
                    $riskLevel = 'moderate';
                } else {
                    $riskLevel = 'low';
                }

                $canRequestHST = in_array($riskLevel, ['severe', 'high']);
                ?>
                <tr>
                    <td valign="top">
                        <?= date('m/d/Y h:i a', strtotime($doctorScreener["adddate"])); ?>
                    </td>
                    <td valign="top">
                        <?php if ($doctorScreener['patient_id']) { ?>
                            <a href="add_patient.php?ed=<?= $doctorScreener['patient_id']; ?>&pid=<?= $doctorScreener['patient_id']; ?>"><?= st($doctorScreener['first_name']); ?> <?= $doctorScreener['last_name']; ?></a>
                        <?php } else { ?>
                            <?= st($doctorScreener["first_name"]); ?> <?= $doctorScreener['last_name']; ?>
                        <?php } ?>
                    </td>
                    <td valign="top">
                        <?= st($doctorScreener["phone"]); ?>
                    </td>
                    <td valign="top" class="risk_<?= $riskLevel ?>">
                        <a href="#" onclick="$('#details_<?= $doctorScreener['id'] ?>').toggle(); return false;">
                            <?= ucfirst($riskLevel) ?>
                        </a>
                    </td>
                    <td valign="top">
                        <?= ($doctorScreener['rx_cpap'] > 0) ? 'Yes' : 'No'; ?>
                    </td>
                    <td valign="top"><?= $epworthTotal ?></td>
                    <td valign="top">
                        <a href="#" onclick="$('#details_<?= $doctorScreener['id']; ?>').toggle(); return false;" id="diagnosis_count_<?= $doctorScreener['id']; ?>">View</a>
                    </td>
                    <td valign="top">
                        <?php
                        if ($doctorScreener['hst_id']) {
                            if ($doctorScreener['hst_status'] == DSS_HST_REQUESTED && $canRequestHST) {
                                if ($isStaff) { ?>
                                    <a href="/manage/hst_request.php?hst_id=<?= $doctorScreener['hst_id']; ?>"
                                       onclick="return confirm('Click OK to initiate a Home Sleep Test request. The HST request must be electronically signed by an authorized provider before it can be transmitted. You can view and save/update the request on the next screen.');" title="Authorize HST">
                                        Authorize
                                    </a>
                                <?php
                                } else { ?>
                                    <a href="#" onclick="alert('You do not have sufficient permission to order a Home Sleep Test. Only a dentist may do this.');return false;" title="Authorize HST">
                                        Authorize
                                    </a>
                                <?php
                                }
                            } else {
                                if (isset($dss_hst_status_labels)) {
                                    echo $dss_hst_status_labels[$doctorScreener['hst_status']];
                                }
                            }
                        } elseif ($doctorScreener['patient_id'] && $isStaff && $canRequestHST) { ?>
                            <a href="/manage/hst_request.php?ed=<?= intval($doctorScreener['patient_id']) ?>&amp;hst_co=0" onclick="return confirm('Click OK to initiate a Home Sleep Test request. The HST request must be electronically signed by an authorized provider before it can be transmitted. You can view and save/update the request on the next screen.');" title="Request HST">
                                Request
                            </a>
                        <?php
                        } elseif (!$doctorScreener['patient_id'] && $canRequestHST) { ?>
                            <a href="/manage/manage_screeners.php?create_for=<?= intval($doctorScreener['id']) ?>" title="Create patient profile">
                                Create patient
                            </a>
                        <?php
                        } ?>
                    </td>
                    <td valign="top">
                        <?php
                        $parsedName = $doctorScreener['user_first_name'] . ' ' . $doctorScreener['user_last_name'];
                        if (strlen(trim($doctorScreener['user_name']))) {
                            $parsedName = $doctorScreener['user_name'];
                        }
                        ?>
                        <?= $parsedName; ?>
                    </td>
                    <td valign="top">
                        <input type="checkbox" class="contact_chbx" value="<?= $doctorScreener['id']; ?>" <?= ($doctorScreener['contacted'] == 1) ? 'checked="checked"' : '';?> />
                    </td>
                    <td>
                        <a href="manage_screeners.php?delid=<?= $doctorScreener['id']; ?>&page=<?= (!empty($_REQUEST['page']) ? $_REQUEST['page'] : ''); ?>" onclick="return confirm('Are you sure you want to delete this screener?');">Delete</a>
                    </td>
                </tr>
                <tr id="details_<?= $doctorScreener['id']; ?>" style="display:none;">
                    <td colspan="4" valign="top">
                        <strong>Epworth Sleepiness Score</strong><br />
                        <?php
                            if (count($epworthResult)) {
                                foreach ($epworthResult as $epworthRow) {
                                    if ($epworthRow['screener_id'] == $doctorScreener['id']) { ?>
                                        <?= $epworthRow['response'] ?> - <strong><?= $epworthRow['epworth']; ?></strong>
                                        <br/>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        <?= $epworthTotal ?> - Total
                    </td>
                    <td valign="top" colspan="6">
                        <strong>Health Symptoms</strong><br />
                        <?= ($doctorScreener['breathing'] > 0) ? 'Yes - <strong>Have you ever been told you stop breathing while asleep?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['driving'] > 0) ? 'Yes - <strong>Have you ever fallen asleep or nodded off while driving?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['gasping'] > 0) ? 'Yes - <strong>Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['sleepy'] > 0) ? 'Yes - <strong>Do you feel excessively sleepy during the day?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['snore'] > 0) ? 'Yes - <strong>Do you snore or have you ever been told that you snore?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['weight_gain'] > 0) ? 'Yes - <strong>Have you had weight gain and found it difficult to lose?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['blood_pressure'] > 0) ? 'Yes - <strong>Have you taken medication for, or been diagnosed with high blood pressure?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['jerk'] > 0) ? 'Yes - <strong>Do you kick or jerk your legs while sleeping?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['burning'] > 0) ? 'Yes - <strong>Do you feel burning, tingling or crawling sensations in your legs when you wake up?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['headaches'] > 0) ? 'Yes - <strong>Do you wake up with headaches during the night or in the morning?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['falling_asleep'] > 0) ? 'Yes - <strong>Do you have trouble falling asleep?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['staying_asleep'] > 0) ? 'Yes - <strong>Do you have trouble staying asleep once you fall asleep?</strong><br />' : ''; ?>
                        <?= ($doctorScreener['rx_cpap'] > 0) ? '<br /> Yes - <strong>Have you ever used CPAP before?</strong><br />' : ''; ?>

                        <br />
                        <strong>Co-morbidity</strong><br />
                        <?php
                        foreach ($diagnosis as $diagnosisPoint) {
                            ?>
                            <?= $diagnosisPoint ?><br />
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php
            endforeach;
        }
        ?>
    </table>
</form>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>

<div id="backgroundPopup"></div>
<br /><br />

<?php include __DIR__ . '/includes/bottom.htm'; ?>

<script src="js/manage_screeners.js" type="text/javascript"></script>
