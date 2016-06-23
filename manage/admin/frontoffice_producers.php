<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/access.php';
require_once __DIR__ . '/includes/sescheck.php';

$canSee = is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access']);
$needsFilter = is_software($_SESSION['admin_access']);

if (!$canSee) { ?>
    <h2>You are not authorized to view this page.</h2>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$sortBy = array_get($_GET, 'sort');
$sortDir = strtolower(array_get($_GET, 'dir'));

$sortDir = $sortDir === 'desc' ? 'desc' : 'asc';
$sortLink = '?sort=%s&dir=%s';

switch ($sortBy) {
    case 'company':
        $order = "company.name $sortDir,
            doctor.last_name,
            doctor.first_name,
            staff.last_name,
            staff.first_name";
        break;
    case 'username':
        $order = "
            doctor.username $sortDir,
            doctor.last_name,
            doctor.first_name,
            staff.last_name,
            staff.first_name,
            company.name";
        break;
    case 'count':
    case 'doctor':
    default:
        $order = "doctor.last_name $sortDir,
            doctor.first_name $sortDir,
            staff.last_name,
            staff.first_name,
            company.name";
}

if ($needsFilter) {
    $companyId = intval($_SESSION['admincompanyid']);
    $andSoftwareCompanyConditional = "AND company.id = '$companyId'";
} else {
    $andSoftwareCompanyConditional = '';
}

$orderedProducerList = [];
$unorderedProducerList = $db->getResults("SELECT
        staff.userid,
        staff.username,
        staff.first_name,
        staff.last_name,
        company.name AS software_company,
        doctor.userid AS docid,
        doctor.username AS doc_username,
        doctor.first_name AS doc_first_name,
        doctor.last_name AS doc_last_name
    FROM dental_users staff
        LEFT JOIN dental_users doctor ON doctor.userid = staff.docid
        LEFT JOIN dental_user_company pivot ON staff.docid = pivot.userid
        LEFT JOIN companies company ON company.id = pivot.companyid
    WHERE staff.docid
        AND staff.producer = 1
        $andSoftwareCompanyConditional
    ORDER BY $order
    ");

foreach ($unorderedProducerList as $producer) {
    $currentDocId = $producer['docid'];

    if (!isset($orderedProducerList[$currentDocId])) {
        // Add the current doctor as the first element of the list
        $orderedProducerList[$currentDocId] = [
            [
                'userid' => $producer['docid'],
                'username' => $producer['doc_username'],
                'first_name' => $producer['doc_first_name'],
                'last_name' => $producer['doc_last_name'],
                'software_company' => $producer['software_company'],
                'docid' => $producer['docid'],
                'doc_username' => $producer['doc_username'],
                'doc_first_name' => $producer['doc_first_name'],
                'doc_last_name' => $producer['doc_last_name'],
            ]
        ];
    }

    $orderedProducerList[$currentDocId] []= $producer;
}

unset($unorderedProducerList);

if ($sortBy === 'count') {
    uasort($orderedProducerList, function ($a, $b) use ($sortDir) {
        $countA = count($a);
        $countB = count($b);

        if ($countA === $countB) {
            return 0;
        }

        $comparison = $countA < $countB ? -1 : 1;

        return $sortDir === 'asc' ? $comparison : -$comparison;
    });
}

require_once __DIR__ . '/includes/top.htm';

?>
<h2>Producer List - Accounts with More than One (1) Producer</h2>
<table class="table table-hover table-condensed">
    <thead>
        <tr>
            <th class="<?= get_sort_arrow_class($sortBy, 'doctor', $sortDir) ?>">
                <a href="<?= sprintf($sortLink, 'doctor', get_sort_dir($sortBy, 'doctor', $sortDir))?>">
                    Doctor Name
                </a>
            </th>
            <th class="<?= get_sort_arrow_class($sortBy, 'username', $sortDir) ?>">
                <a href="<?= sprintf($sortLink, 'username', get_sort_dir($sortBy, 'username', $sortDir))?>">
                    Doctor Userame
                </a>
            </th>
            <th class="<?= get_sort_arrow_class($sortBy, 'company', $sortDir) ?>">
                <a href="<?= sprintf($sortLink, 'company', get_sort_dir($sortBy, 'company', $sortDir))?>">
                    Software Company
                </a>
            </th>
            <th class="<?= get_sort_arrow_class($sortBy, 'count', $sortDir) ?>">
                <a href="<?= sprintf($sortLink, 'count', get_sort_dir($sortBy, 'count', $sortDir))?>">
                    # Producers
                </a>
            </th>
            <th>Producer Name</th>
            <th>Producer Username</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orderedProducerList as $docId=>$producerList) {
            $doctor = $producerList[0];
            $producerCount = count($producerList);
            $rowSpan = $producerCount + 1;

            ?>
            <tr>
                <td rowspan="<?= $rowSpan ?>">
                    <?= e("{$doctor['doc_last_name']}, {$doctor['doc_first_name']}") ?>
                </td>
                <td rowspan="<?= $rowSpan ?>">
                    <code><?= e($doctor['doc_username']) ?></code>
                </td>
                <td rowspan="<?= $rowSpan ?>">
                    <?= e($doctor['software_company']) ?>
                </td>
                <td rowspan="<?= $rowSpan ?>">
                    <?= $producerCount ?>
                </td>
            </tr>
            <?php foreach ($producerList as $producer) { ?>
                <tr>
                    <td>
                        <?= e("{$producer['last_name']}, {$producer['first_name']}") ?>
                    </td>
                    <td>
                        <code><?= e($producer['username']) ?></code>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
<?php

require_once __DIR__ . '/includes/bottom.htm';
