<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/access.php';

if (!is_super($_SESSION['admin_access'])) {
    header('Location: /manage/admin');
    trigger_error('Die called', E_USER_ERROR);
}

/**
 * @param int $number
 * @return string
 */
function toOrdinal ($number) {
    $ends = ['th', 'st', 'nd', 'rd'];
    $lastDigit = $number%10;

    if (($lastDigit >= 1) && ($lastDigit <= 3)) {
        return $number . $ends[$lastDigit];
    }

    return $number . 'th';
}

/**
 * @return array
 */
function defaultClaimFields () {
    return [
        'insuranceid',
        'docid',
        'userid',
        'patientid',
        'status',
        'status_label',
        'observations',
        'primary_claim_id',
        'p_m_dss_file',
        's_m_dss_file',
        'adddate'
    ];
}

/**
 * @return array
 */
function specialClaimFields () {
    return [
        'status_label' => "CASE status
                WHEN 0 THEN 'PENDING'
                WHEN 1 THEN 'SENT'
                WHEN 2 THEN 'DISPUTE'
                WHEN 3 THEN 'PAID_INSURANCE'
                WHEN 4 THEN 'REJECTED'
                WHEN 5 THEN 'PAID_PATIENT'
                WHEN 6 THEN 'SEC_PENDING'
                WHEN 7 THEN 'SEC_SENT'
                WHEN 8 THEN 'SEC_DISPUTE'
                WHEN 9 THEN 'PAID_SEC_INSURANCE'
                WHEN 10 THEN 'PATIENT_DISPUTE'
                WHEN 11 THEN 'PAID_SEC_PATIENT'
                WHEN 12 THEN 'SEC_PATIENT_DISPUTE'
                WHEN 13 THEN 'SEC_REJECTED'
                WHEN 14 THEN 'EFILE_ACCEPTED'
                WHEN 15 THEN 'SEC_EFILE_ACCEPTED'
                ELSE 'Unkown'
            END",
        'observations' => "CASE TRUE
                WHEN status IN (0, 1, 2, 3, 4, 5, 10, 14) AND COALESCE(primary_claim_id, 0) != 0
                    THEN 'Status mismatch: claim is secondary'
                WHEN status NOT IN (0, 1, 2, 3, 4, 5, 10, 14) AND COALESCE(primary_claim_id, 0) = 0
                    THEN 'Status mismatch: claim is primary'
                ELSE ''
            END"
    ];
}

/**
 * @param int    $claimId
 * @param array  $fieldList
 * @param bool   $overrideFields
 * @param array  $specialList
 * @param bool   $overrideSpecial
 * @param string $targetTable
 * @param array  $orderBy
 * @return array
 */
function retrieveClaimRelatedData (
        $claimId,
        Array $fieldList=[],
        $overrideFields=false,
        Array $specialList=[],
        $overrideSpecial=false,
        $targetTable='dental_insurance',
        $orderBy=['id' => 'DESC']
    ) {
    $db = new Db();

    $claimId = intval($claimId);

    $fieldList = $overrideFields ? $fieldList : array_merge(defaultClaimFields(), $fieldList);
    $specialList = $overrideSpecial ? $specialList : array_merge(specialClaimFields(), $specialList);

    array_walk($fieldList, function(&$fieldName)use($specialList){
        if (!array_key_exists($fieldName, $specialList)) {
            return;
        }

        $fieldName = "{$specialList[$fieldName]} AS $fieldName";
    });

    $fieldList = join(', ', $fieldList);

    $orderByClause = '';

    if ($orderBy) {
        array_walk($orderBy, function(&$direction, $field){
            $direction = "$field $direction";
        });

        $orderByClause = 'ORDER BY ' . join(', ', $orderBy);
    }

    return $db->getResults("SELECT $fieldList
        FROM $targetTable
        WHERE insuranceid = '$claimId'
        $orderByClause");
}

/**
 * @param int   $claimId
 * @param array $fieldList
 * @param array $specialList
 * @return array
 */
function retrieveClaimHistory ($claimId, Array $fieldList=[], Array $specialList=[]) {
    array_unshift($fieldList, 'updated_at');
    return retrieveClaimRelatedData($claimId, $fieldList, false, $specialList, false, 'dental_insurance_history');
}

/**
 * @param $claimId
 * @return array
 */
function retrieveClaimStatusHistory ($claimId) {
    $fields = ['id', 'insuranceid', 'status', 'status_label', 'userid', 'adddate', 'ip_address', 'adminid'];
    return retrieveClaimRelatedData($claimId, $fields, true, [], false, 'dental_insurance_status_history');
}

/**
 * @param int   $claimId
 * @param array $fieldList
 * @param array $specialList
 * @return array
 */
function retrieveClaimData ($claimId, Array $fieldList=[], Array $specialList=[]) {
    return retrieveClaimRelatedData(
        $claimId, $fieldList, false, $specialList, false, 'dental_insurance', ['insuranceid' => 'DESC']
    );
}

/**
 * Auxiliary function to list the refernces from within a list of responses
 *
 * @param array $eligibleResponses
 * @return array
 */
function retrieveEligibleReferences (Array $eligibleResponses) {
    $references = array_pluck($eligibleResponses, 'reference_id');
    $references = array_unique($references);
    $references = array_filter($references);
    $references = array_values($references);

    return $references;
}

/**
 * Retrieve Eligible responses from when e-filing
 *
 * @param int $claimId
 * @return array
 */
function retrieveEligibleResponses ($claimId) {
    $db = new Db();
    $claimId = intval($claimId);

    return $db->getResults("SELECT id, claimid, response, adddate, ip_address, reference_id
        FROM dental_claim_electronic
        WHERE claimid
            AND claimid = '$claimId'
        ORDER BY id ASC");
}

/**
 * Retrieve Eligible events associated to a claim, through the reference_id
 *
 * @param array $eligibleReferences
 * @return array
 */
function retrieveEligibleEvents (Array $eligibleReferences) {
    if (!$eligibleReferences) {
        return [];
    }

    $db = new Db();
    $eligibleReferences = $db->escapeList($eligibleReferences);

    return $db->getResults("SELECT *
        FROM dental_eligible_response
        WHERE LENGTH(reference_id)
            AND reference_id IN ($eligibleReferences)
        ORDER BY id DESC");
}

function retrieveBOFlagHistory ($claimId) {
    $db = new Db();
    $claimId = intval($claimId);

    return $db->getResults("SELECT *
        FROM dental_insurance_bo_status
        WHERE insuranceid = '$claimId'
        ORDER BY id DESC");
}

/**
 * @param array  $rows
 * @param string $title
 */
function renderTableFromArray (Array $rows, $title='Unnamed data') {
    ?>
    <h2><?= e($title) ?></h2>
    <?php

    if (!$rows) { ?>
        <p class="lead text-center"><?= e($title) ?> is empty</p>
        <?php

        return;
    }

    $header = array_keys($rows[0]);
    ob_start();
    ?>
    <tr>
        <th><?= join('</th><th>', $header) ?></th>
    </tr>
    <?php
    $headerRow = ob_get_clean();

    ?>
    <table class="table table-striped table-hover">
        <thead>
            <?= $headerRow ?>
        </thead>
        <tbody>
            <?php foreach ($rows as $n=>$row) { ?>
                <tr>
                    <td><?= join('</td><td>', $row) ?></td>
                </tr>
                <?= !(($n + 1) % 20) ? $headerRow : '' ?>
            <?php } ?>
        </tbody>
    </table>
    <?php
}

$isQuickOutput = isset($_GET['dirty']);
$isTimeLine = isset($_GET['timeline']);

$claimId = intval($_GET['claim_id']);
$claimData = retrieveClaimData($claimId);
$claimBOFlagHistory = retrieveBOFlagHistory($claimId);
$claimStatusHistory = retrieveClaimStatusHistory($claimId);

if ($isTimeLine) {
    $claimHistory = retrieveClaimHistory($claimId, array_merge(['id'], defaultClaimFields()));
} else {
    $claimHistory = retrieveClaimHistory($claimId);
}

$eligibleResponses = retrieveEligibleResponses($claimId);
$eligibleReferences = retrieveEligibleReferences($eligibleResponses);
$eligibleEvents = retrieveEligibleEvents($eligibleReferences);

$timeLine = [];

if ($isTimeLine) {
    $timeLine []= [
        'event_date' => $claimData[0]['adddate'],
        'event_type' => 'Creation',
        'event_data' => $claimData[0]
    ];

    foreach ($claimBOFlagHistory as $each) {
        $timeLine []= [
            'event_date' => $each['adddate'],
            'event_type' => 'BO Flag Change',
            'event_data' => $each['p_m_dss_file']
        ];
    }

    foreach ($claimHistory as $each) {
        $timeLine []= [
            'event_date' => $each['updated_at'],
            'event_type' => 'Claim Change',
            'event_data' => $each,
        ];
    }

    foreach ($claimStatusHistory as $each) {
        $timeLine []= [
            'event_date' => $each['adddate'],
            'event_type' => 'Status Change',
            'event_data' => $each,
        ];
    }

    foreach ($eligibleEvents as $each) {
        $eligibleId = array_search($each['reference_id'], $eligibleReferences);
        $ordinalEligibleId = $eligibleId === false ?  'no' : toOrdinal($eligibleId + 1);

        $each['ordinal'] = "$ordinalEligibleId ID";

        $timeLine []= [
            'event_date' => $each['adddate'],
            'event_type' => 'Eligible Event',
            'event_data' => $each,
        ];
    }

    foreach ($eligibleResponses as $each) {
        $eligibleId = array_search($each['reference_id'], $eligibleReferences);
        $ordinalEligibleId = $eligibleId === false ?  'no' : toOrdinal($eligibleId + 1);

        $each['ordinal'] = "$ordinalEligibleId ID";

        $timeLine []= [
            'event_date' => $each['adddate'],
            'event_type' => 'Eligible Response',
            'event_data' => $each,
        ];
    }

    usort($timeLine, function ($a, $b) {
        $aTime = strtotime($a['event_date']);
        $bTime = strtotime($b['event_date']);

        if ($aTime != $bTime) {
            return ($aTime > $bTime ? -1 : 1);
        }

        $aType = preg_replace('/ \(.+?\)$/', '', $a['event_type']);
        $bType = preg_replace('/ \(.+?\)$/', '', $b['event_type']);

        if ($aType === $bType) {
            return ($a['event_data']['id'] > $b['event_data']['id'] ? -1 : 1);
        }

        switch ($aType) {
            case 'Status Change':
                $aType = 0;
                break;
            case 'Eligible Response':
                $aType = 1;
                break;
            case 'Claim Change':
                $aType = 2;
                break;
            case 'Eligible Event':
                $aType = 3;
                break;
            default:
                $aType = 4;
        }

        switch ($bType) {
            case 'Status Change':
                $bType = 0;
                break;
            case 'Eligible Response':
                $bType = 1;
                break;
            case 'Claim Change':
                $bType = 2;
                break;
            case 'Eligible Event':
                $bType = 3;
                break;
            default:
                $bType = 4;
        }

        return ($aType > $bType ? -1 : 1);
    });

    array_walk($timeLine, function (&$each) {
        $each['event_date'] = str_replace(' ', '&nbsp;', $each['event_date']);
        $each['event_type'] = str_replace(' ', '&nbsp;', $each['event_type']);

        if (is_array($each['event_data'])) {
            $eventData = $each['event_data'];
            $extraDetails = [];

            if (!empty($eventData['ordinal'])) {
                $each['event_type'] .= '<code class="pull-right">' . $eventData['ordinal'] . '</code>';
            }

            if (!empty($eventData['userid'])) {
                $extraDetails []= "userid: {$eventData['userid']}";
            }

            if (!empty($eventData['adminid'])) {
                $extraDetails []= "adminid: {$eventData['adminid']}";
            }

            $extraDetails = $extraDetails ?
                ' <code class="pull-right">' . join('</code> <code class="pull-right">', $extraDetails) . '</code>' :
                '';

            if (isset($each['event_data']['response'])) {
                $each['event_data'] = $each['event_data']['response'];
            } elseif (isset($each['event_data']['status_label'])) {
                $each['event_data'] = $each['event_data']['status_label'];
            } else {
                $each['event_data'] = json_encode($each['event_data']);
            }

            $each['event_data'] .= $extraDetails;
        }
    });
}

if ($isQuickOutput) {
    dd([
        '$claimId' => $claimId,
        '$claimData' => $claimData,
        '$claimBOFlagHistory' => $claimBOFlagHistory,
        '$claimHistory' => $claimHistory,
        '$claimStatusHistory' => $claimStatusHistory,
        '$timeLine' => $timeLine,
    ]);
}

require_once __DIR__ . '/includes/top.htm';

?>
<style type="text/css">
    code { max-height: 200px; }
</style>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
<script>
    jQuery(function($){
        $('#eligible-events > table, h2:contains(Timeline) ~ table').find(' > tbody > tr > td:nth-child(3)')
        .each(function(){
            var $this = $(this),
                text = $this.text().trim(),
                json = text,
                $code;

            if ($this.find('code').length || !text) {
                return;
            }

            $code = $('<code>', { class: 'json' });

            try {
                var parsedJson = JSON.parse(text);
                json = JSON.stringify(parsedJson, null, 2);
            } catch (e) { /* empty */}

            $code.text(json);
            $this.empty().append($code);

            hljs.highlightBlock($code[0]);

            if ($code.find('span').length) {
                $code.attr('title', 'double click to expand/toggle').dblclick(function(){
                    if ($code.closest('pre').length) {
                        $code.unwrap();
                    } else {
                        $code.wrap('<pre>', {});
                    }
                });
            } else {
                $this.text(text);
            }
        });
    });
</script>
<form>
    <label for="claim_id">Claim ID</label>
    <input class="form-control input-sm input-inline" id="claim_id" name="claim_id" value="<?= $claimId ?>" />
    <input type="checkbox" id="dirty" name="dirty" <?= $isQuickOutput ? 'checked' : '' ?> />
    <label for="dirty">Show quick, debug output</label>
    <input type="checkbox" id="timeline" name="timeline" <?= $isTimeLine ? 'checked' : '' ?> />
    <label for="timeline">Show as timeline</label>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>
<h1>
    Claim id: <code><?= $claimId ?></code>
    &mdash;
    Eligible ids:
    <?= $eligibleReferences ? '<code>' . join(' ', array_flatten($eligibleReferences)) . '</code>' : 'none found' ?>
</h1>
<a class="btn btn-primary" role="button" data-toggle="collapse" href="#eligible-events">
    Toggle Eligible events
</a>
<div class="collapse" id="eligible-events">
    <?php renderTableFromArray($eligibleEvents, 'Eligible events') ?>
    <?php renderTableFromArray($eligibleResponses, 'Eligible responses (from e-filing)') ?>
</div>
<?php

if ($isTimeLine) {
    renderTableFromArray($timeLine, 'Timeline');
} else {
    renderTableFromArray($claimData, 'Current data');
    renderTableFromArray($claimBOFlagHistory, 'FO/BO flag changes (by admins)');
    renderTableFromArray($claimHistory, 'History');
    renderTableFromArray($claimStatusHistory, 'Status changes');
}

require_once __DIR__ . '/includes/bottom.htm';
