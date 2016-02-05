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
 * @return array
 */
function defaultClaimFields () {
    return [
        'insuranceid',
        'docid',
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
    $fields = ['insuranceid', 'status', 'status_label', 'userid', 'adddate', 'ip_address', 'adminid'];
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
    <table class="table table-bordered table-hover">
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

$claimId = intval($_GET['claim_id']);
$claimData = retrieveClaimData($claimId);
$claimHistory = retrieveClaimHistory($claimId);
$claimStatusHistory = retrieveClaimStatusHistory($claimId);

if (isset($_GET['dirty'])) {
    dd([
        '$claimId' => $claimId,
        '$claimData' => $claimData,
        '$claimHistory' => $claimHistory,
        '$claimStatusHistory' => $claimStatusHistory,
    ]);
}

require_once __DIR__ . '/includes/top.htm';

?>
<h1>
    Claim id: <code><?= $claimId ?></code>
</h1>
<?php

renderTableFromArray($claimData, 'Current data');
renderTableFromArray($claimHistory, 'History');
renderTableFromArray($claimStatusHistory, 'Status changes');

require_once __DIR__ . '/includes/bottom.htm';
