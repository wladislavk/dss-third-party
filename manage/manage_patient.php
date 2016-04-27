<?php namespace Ds3\Libraries\Legacy; ?><?php
include('includes/top.htm');
// include('includes/constants.inc');
include('includes/formatters.php');

$docId = intval($_SESSION['docid']);

if (isset($_REQUEST["delid"])) {
    $patientId = intval($_POST['delid']);
    $db->query("DELETE FROM dental_patients
        WHERE patientid = '$patientId'
            AND docid = '$docId'");

    $msg = "Deleted Successfully";

    header("Location: " . $_SERVER['PHP_SELF'] . "?msg=" . $msg);
    trigger_error("Die called", E_USER_ERROR);
}

$count = 30;
$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 0;

$patientId = intval($_GET['pid']);
$sortColumn = $_REQUEST['sort'];
$sortDir = strtolower($_REQUEST['sortdir']) === 'desc' ? 'DESC' : 'ASC';

$conditionals = [
    "p.docid = '$docId'"
];

if ($patientId) {
    $conditionals []= "p.patientid = '$patientId'";
}

switch (intval($_GET['sh'])) {
    case 0:
    case 1:
        $conditionals []= 'p.status = 1';
        break;
    case 2:
        $conditionals []= '(p.status = 1 OR p.status = 2)';
        break;
    case 3:
        $conditionals []= 'p.status = 2';
}

if (isset($_GET['letter']) && strlen($_GET['letter'])) {
    $conditionals []= "p.lastname LIKE '" . $db->escape($_GET['letter']) . "%'";
}

$queries = findPatients($sortColumn, $conditionals, $sortDir, $page, $count);

$sortColumn = $queries['filter'];
$patients = $queries['results'];
$totalCount = $queries['count'];
$totalPages = $totalCount/$count;

/**
 * @see DSS-434
 *
 * Original, full query, ahead
switch ($sortColumn) {
    default:
    case 'name':
        $auxiliaryOrder = false;
        $orderBy = "p.lastname $sortDir, p.firstname $sortDir";
        break;
    case 'tx':
        $orderBy = "(insurance_no_error AND numsleepstudy > 0) $sortDir";
        break;
    case 'next-visit':
        $orderBy = "date_scheduled $sortDir";
        break;
    case 'last-visit':
        $orderBy = "date_completed $sortDir";
        break;
    case 'last-treatment':
        $orderBy = "segmentid $sortDir";
        break;
    case 'appliance':
        $orderBy = "device $sortDir";
        break;
    case 'appliance-since':
        $orderBy = "dentaldevice_date $sortDir";
        break;
    case 'vob':
        $orderBy = "sm.vob $sortDir";
        break;
    case 'rx-lomn':
        $orderBy = "rx_lomn $sortDir";
        break;
    case 'ledger':
        $orderBy = "ledger IS NOT NULL $sortDir, total $sortDir";
}

if ($auxiliaryOrder) {
    $orderBy = "patient_info DESC, $orderBy, p.lastname ASC, p.firstname ASC";
}

$conditionals = join(' AND ', $conditionals);

$totalCount = $db->getColumn("SELECT COUNT(p.patientid) AS total FROM dental_patients p WHERE $conditionals", 'total');
$totalPages = $totalCount/$count;

$patientsQuery = "SELECT
        allergens_check.allergenscheck,
        (
            (
                '{$_SESSION['user_type']}' = '$userTypeSoftware'
                AND COALESCE(p.p_m_dss_file, 0) != 0
            )
            OR COALESCE(p.p_m_dss_file, 0) = 1
        ) AS insurance_no_error,
        (
            SELECT COUNT(id)
            FROM dental_summ_sleeplab sleep_lab
            WHERE
                sleep_lab.patiendid = p.patientid
                AND COALESCE(sleep_lab.diagnosis, '') != ''
                AND COALESCE(sleep_lab.filename, '') != ''
                AND (
                    p.p_m_ins_type != '1'
                    OR (
                        COALESCE(sleep_lab.diagnosising_doc, '') != ''
                        AND COALESCE(sleep_lab.diagnosising_npi, '') != ''
                    )
                )
        ) AS numsleepstudy,
        summary.vob,
        summary.ledger AS ledger,
        summary.patient_info AS patient_info,
        next_visit.date_scheduled AS date_scheduled,
        last_dates.date_completed AS date_completed,
        last_dates.segmentid AS segmentid,
        device.device AS device,
        device_date.dentaldevice_date AS dentaldevice_date,
        CASE
            WHEN LENGTH(COALESCE(rx_lomn.rxlomnrec, ''))
                OR (
                    LENGTH(COALESCE(rx_lomn.lomnrec, '')) AND LENGTH(COALESCE(rx_lomn.rxrec, ''))
                ) THEN 3
            WHEN LENGTH(COALESCE(rx_lomn.rxrec, '')) THEN 2
            WHEN LENGTH(COALESCE(rx_lomn.lomnrec, '')) THEN 1
            ELSE 0
        END AS rx_lomn,
        (
            COALESCE(
                (
                    SELECT SUM(COALESCE(first.amount, 0)) AS total
                    FROM dental_ledger first
                    WHERE first.docid = p.docid
                        AND first.patientid = p.patientid
                        AND COALESCE(first.paid_amount, 0) = 0
                ), 0
            )
            + COALESCE(
                (
                    SELECT SUM(COALESCE(second.amount, 0)) - SUM(COALESCE(second.paid_amount, 0))
                    FROM dental_ledger second
                    WHERE second.docid = p.docid
                        AND second.patientid = p.patientid
                        AND second.paid_amount != 0
                ), 0
            )
            - COALESCE(
                (
                    SELECT -SUM(COALESCE(third_payment.amount, 0))
                    FROM dental_ledger third
                        LEFT JOIN dental_ledger_payment third_payment ON third_payment.ledgerid = third.ledgerid
                    WHERE third.docid = p.docid
                        AND third.patientid = p.patientid
                        AND third_payment.amount != 0
                ), 0
            )
        ) AS total,
        p.*
    FROM dental_patients p
        LEFT JOIN (
            SELECT patientid, MAX(q_page3id) AS max_id
            FROM dental_q_page3
            GROUP BY patientid
        ) allergens_check_pivot ON allergens_check_pivot.patientid = p.patientid
        LEFT JOIN dental_q_page3 allergens_check ON allergens_check.q_page3id = allergens_check_pivot.max_id
        
        LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid
        
        LEFT JOIN (
            SELECT pid AS patientid, MAX(id) AS max_id
            FROM dental_flow_pg1
            GROUP BY pid
        ) rx_lomn_pivot ON rx_lomn_pivot.patientid = p.patientid
        LEFT JOIN dental_flow_pg1 rx_lomn ON rx_lomn.id = rx_lomn_pivot.max_id
        
        LEFT JOIN (
            SELECT patientid, MAX(id) AS max_id
            FROM dental_flow_pg2_info
            WHERE appointment_type = 0
            GROUP BY patientid
        ) next_visit_pivot ON next_visit_pivot.patientid = p.patientid
        LEFT JOIN dental_flow_pg2_info next_visit ON next_visit.id = next_visit_pivot.max_id
        
        LEFT JOIN (
            SELECT base_last_dates.patientid, MAX(base_last_dates.id) AS max_id, base_last_dates.segmentid
            FROM dental_flow_pg2_info base_last_dates
            INNER JOIN (
                SELECT patientid, max(date_completed) AS max_date
                FROM dental_flow_pg2_info
                GROUP BY patientid
            ) pivot_last_dates ON pivot_last_dates.patientid = base_last_dates.patientid
                AND pivot_last_dates.max_date = base_last_dates.date_completed
            GROUP BY base_last_dates.patientid
        ) last_dates_pivot ON last_dates_pivot.patientid = p.patientid
        LEFT JOIN dental_flow_pg2_info last_dates ON last_dates.id = last_dates_pivot.max_id
        
        LEFT JOIN (
            SELECT patientid, dentaldevice, MAX(ex_page5id) AS max_id
            FROM dental_ex_page5
            GROUP BY patientid
        ) device_pivot ON device_pivot.patientid = p.patientid
        LEFT JOIN dental_ex_page5 device_date ON device_date.ex_page5id = device_pivot.max_id
        LEFT JOIN dental_device device ON device.deviceid = device_pivot.dentaldevice
    
    WHERE $conditionals
    ORDER BY $orderBy
    LIMIT $offset, $count";

$patients = $db->getResults($patientsQuery);
*/

$headers = [
    'name' => 'Name',
    'tx' => 'Ready for Tx',
    'next-visit' => 'Next Visit',
    'last-visit' => 'Last Visit',
    'last-treatment' => 'Last Treatment',
    'appliance' => 'Appliance',
    'appliance-since' => 'Appliance Since',
    'vob' => 'VOB',
    'rx-lomn' => 'Rx./L.O.M.N.',
    'ledger' => 'Ledger'
];

$segments = [
    1 => 'Initial Contact',
    2 => 'Consult',
    3 => 'Sleep Study',
    4 => 'Impressions',
    5 => 'Delaying Tx / Waiting',
    6 => 'Refused Treatment',
    7 => 'Device Delivery',
    8 => 'Check / Follow Up',
    9 => 'Pt. Non-Compliant',
    10 => 'Home Sleep Test',
    11 => 'Treatment Complete',
    12 => 'Annual Recall',
    13 => 'Termination',
    14 => 'Not a Candidate',
    15 => 'Baseline Sleep Test',
];

$letters = range('A', 'Z');

?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage_patient.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
<div style="clear: both">
<span class="admin_head">
	Manage Patient <?php echo (isset($patient_info))?$patient_info:''; ?>
    -
	<select name="show" onchange="Javascript: window.location ='<?php echo $_SERVER['PHP_SELF'];?>?sh='+this.value;">
        <option value="1">Active Patients</option>
        <option value="2" <?php if(isset($_GET['sh'])){ if($_GET['sh'] == 2) echo " selected"; } ?> >All Patients</option>
        <option value="3" <?php if(isset($_GET['sh'])){ if($_GET['sh'] == 3) echo " selected"; } ?> >In-active Patients</option>
    </select>
</span>
    <div class="letter_select">
        <?php

        foreach ($letters as $let) {
            $class = (isset($_GET['letter']) && $_GET['letter']==$let) ? 'class="selected_letter"' : '';
            $sh = isset($_GET['sh']) ? $_GET['sh'] : '';
            echo '<a ' . $class . 'href="?letter=' . $let . '&sh=' . $sh . '">' . $let . '</a> ';
        }

        if (isset($_GET['letter']) && $_GET['letter'] != '') {
            echo '<a href="?sh=' . $_GET['sh'] . '">View All</a>';
        }

        ?>
    </div>
    </br>
    <?php
    if(isset($_GET['msg'])){
        ?>
        <div align="center" class="red">
            <b><?php echo $_GET['msg'];?></b>
        </div>
        <?php
    } ?>

</div>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" style="clear: both">
    <table id="patients" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <?php if ($totalCount > $count) { ?>
            <tr bgColor="#ffffff">
                <td  align="right" colspan="15" class="bp">
                    Pages:
                    <?php

                    $letter = isset($_GET['letter']) ? $_GET['letter'] : '';
                    $sh = isset($_GET['sh']) ? $_GET['sh'] : '';
                    paging($totalPages, $page, "letter=". $letter ."&sort=". $sortColumn ."&sortdir=". $sortDir ."&sh=". $sh );
                    ?>
                </td>
            </tr>
        <?php } ?>
        <tr class="tr_bg_h">
            <?php foreach ($headers as $sort=>$label) {
                if ($sortColumn === $sort) {
                    $currentDir = strtolower($sortDir) === 'asc' ? 'DESC' : 'ASC';
                } else {
                    $currentDir = $sort === 'name' ? 'ASC' : 'DESC';
                }

                ?>
                <td valign="top" class="col_head  <?= $sortColumn == $sort ? 'arrow_' . strtolower($sortDir) : '' ?>" width="10%">
                    <a href="?<?= $patientId ? "pid=$patientId&" : '' ?>sort=<?= rawurlencode($sort) ?>&sortdir=<?= $currentDir ?>">
                        <?= e($label) ?>
                    </a>
                </td>
            <?php } ?>
        </tr>
        <tr class="template" style="display:none;">
            <td class="patient_name">John Smith</td>
            <td class="flowsheet">No</td>
            <td class="next_visit">(4 days)</td>
            <td class="last_visit">1 yr 2 mo</td>
            <td class="last_treatment">Consult</td>
            <td class="appliance">TAP 3</td>
            <td class="appliance_since">63 days</td>
            <td class="vob">Complete</td>
            <td class="rxlomn">N/A</td>
            <td class="ledger">($435.75)</td>
        </tr>
        <?php if (!count($patients)) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>
        <?php } else {
            foreach ($patients as $myarray) {
                $tr_class = $myarray['status'] == 1 ? "tr_active" : "tr_inactive";
                ?>
                <tr class="<?php echo $tr_class;?> initial_list">
                    <td valign="top">
                        <a href="add_patient.php?pid=<?= $patientId ?>&ed=<?= $patientId ?>">
                            <?= e($myarray['lastname']) ?>,&nbsp;
                            <?= e($myarray['firstname']) ?>&nbsp;
                            <?= e($myarray['middlename']) ?>
                        </a>
                        <?php if ($myarray["premedcheck"] == 1 || $myarray['allergenscheck'] == 1) { ?>
                            &nbsp;&nbsp;&nbsp;<span style="font-weight:bold; color:#ff0000;">*Med</span>
                        <?php }?>
                    </td>
                    <?php if ($myarray['patient_info'] != 1) { ?>
                        <td colspan="9" align="center" class="pat_incomplete">-- Patient Incomplete --</td>
                    <?php } else {
                        $next_scheduled = $myarray['date_scheduled'];
                        $last_completed = $myarray['date_completed'];
                        $last_segmentid = $myarray['segmentid'];
                        $delivery_date = $myarray['dentaldevice_date'];
                        $device = $myarray['device'];

                        ?>
                        <td valign="top">
                            <?php

                            $ins_error = !$myarray['insurance_no_error'];
                            $study_error = $myarray['numsleepstudy'] == 0;

                            ?>
                            <a href="manage_flowsheet3.php?pid=<?= $patientId ?>"><?php echo ((!$ins_error && !$study_error) ? "Yes" : "<span class=\"red\">No</span>"); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?= $patientId ?>"><?php echo format_date($next_scheduled); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?= $patientId ?>"><?php echo format_date($last_completed, true); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?= $patientId ?>"><?php echo ($last_segmentid == null ? 'N/A' : $segments[$last_segmentid]); ?></a>
                        </td>
                        <td valign="top">
                            <a href="dss_summ.php?pid=<?= $patientId ?>"><?php echo $device; ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?= $patientId ?>"><?php echo format_date($delivery_date, true); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_insurance.php?pid=<?= $patientId ?>"><?php echo ($myarray['vob'] == null ? 'No' : ($myarray['vob']==1 ? "Yes": $dss_preauth_status_labels[$myarray['vob']])); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_insurance.php?pid=<?= $patientId ?>">
                                <?php if ($myarray['rx_lomn'] == 3) { ?>
                                    Yes
                                <?php } elseif ($myarray['rx_lomn'] == 2) { ?>
                                    Yes/No
                                <?php } elseif ($myarray['rx_lomn'] == 1) { ?>
                                    No/Yes
                                <?php } else { ?>
                                    No
                                <?php } ?>
                            </a>
                        </td>
                        <td valign="top">
                            <a href="manage_ledger.php?pid=<?= $patientId ?>">
                                <?= $myarray['ledger'] == null ? 'N/A' : format_ledger(number_format($myarray['total'], 0)) ?>
                            </a>
                        </td>
                    <?php } ?>
                </tr>
                <?php
            }
        }?>
    </table>
</form>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php

include "includes/bottom.htm";

function itemSelector (Array $array, $section='all') {
    if ($section === 'all') {
        return $array;
    }

    if ($section{0} === '^') {
        $section = substr($section, 1);
        unset($array[$section]);
        return $array;
    }

    return array_get($array, $section);
}

function querySections ($section='all') {
    $userTypeSoftware = DSS_USER_TYPE_SOFTWARE;
    
    $querySections = [
        'name' => [
            'order' => "p.lastname %DIR%, p.firstname %DIR%",
        ],
        'tx' => [
            'select' => "(
                (
                    '{$_SESSION['user_type']}' = '$userTypeSoftware'
                    AND COALESCE(p.p_m_dss_file, 0) != 0
                )
                OR COALESCE(p.p_m_dss_file, 0) = 1
            ) AS insurance_no_error,
            (
                SELECT COUNT(id)
                FROM dental_summ_sleeplab sleep_lab
                WHERE sleep_lab.patiendid = p.patientid
                    AND COALESCE(sleep_lab.filename, '') != ''
                    AND COALESCE(sleep_lab.diagnosis, '') != ''
                    AND (
                        p.p_m_ins_type != '1'
                        OR (
                            COALESCE(sleep_lab.diagnosising_doc, '') != ''
                            AND COALESCE(sleep_lab.diagnosising_npi, '') != ''
                        )
                    )
            ) AS numsleepstudy",
            'order' => "(insurance_no_error AND numsleepstudy > 0) %DIR%",
        ],
        'next-visit' => [
            'select' => 'next_visit.date_scheduled AS date_scheduled',
            'join' => 'next-visit',
            'order' => "date_scheduled %DIR%",
        ],
        'last-visit' => [
            'select' => 'last_dates.date_completed AS date_completed',
            'join' => 'last-dates',
            'order' => "date_completed %DIR%",
        ],
        'last-treatment' => [
            'select' => 'last_dates.segmentid AS segmentid',
            'join' => 'last-dates',
            'order' => "segmentid %DIR%",
        ],
        'appliance' => [
            'select' => 'device.device AS device',
            'join' => 'device',
            'order' => "device %DIR%",
        ],
        'appliance-since' => [
            'select' => 'device_date.dentaldevice_date AS dentaldevice_date',
            'join' => 'device',
            'order' => "dentaldevice_date %DIR%",
        ],
        'vob' => [
            'select' => 'summary.vob AS vob',
            'join' => 'summary',
            'order' => "vob %DIR%",
        ],
        'rx-lomn' => [
            'select' => "CASE
                WHEN LENGTH(COALESCE(rx_lomn.rxlomnrec, ''))
                    OR (
                        LENGTH(COALESCE(rx_lomn.lomnrec, '')) AND LENGTH(COALESCE(rx_lomn.rxrec, ''))
                    ) THEN 3
                WHEN LENGTH(COALESCE(rx_lomn.rxrec, '')) THEN 2
                WHEN LENGTH(COALESCE(rx_lomn.lomnrec, '')) THEN 1
                ELSE 0
            END AS rx_lomn",
            'join' => 'rx-lomn',
            'order' => "rx_lomn %DIR%",
        ],
        'ledger' => [
            'select' => '(
                COALESCE(
                    (
                        SELECT SUM(COALESCE(first.amount, 0)) AS total
                        FROM dental_ledger first
                        WHERE first.docid = p.docid
                            AND first.patientid = p.patientid
                            AND COALESCE(first.paid_amount, 0) = 0
                    ), 0
                )
                + COALESCE(
                    (
                        SELECT SUM(COALESCE(second.amount, 0)) - SUM(COALESCE(second.paid_amount, 0))
                        FROM dental_ledger second
                        WHERE second.docid = p.docid
                            AND second.patientid = p.patientid
                            AND second.paid_amount != 0
                    ), 0
                )
                - COALESCE(
                    (
                        SELECT SUM(COALESCE(third_payment.amount, 0))
                        FROM dental_ledger third
                            LEFT JOIN dental_ledger_payment third_payment ON third_payment.ledgerid = third.ledgerid
                        WHERE third.docid = p.docid
                            AND third.patientid = p.patientid
                            AND third_payment.amount != 0
                    ), 0
                )
            ) AS total',
            'order' => "ledger IS NOT NULL %DIR%, total %DIR%",
        ],
    ];

    return itemSelector($querySections, $section);
}

function joinList ($section='all') {
    $joinSections = [
        'allergens-check' => 'LEFT JOIN (
            SELECT patientid, MAX(q_page3id) AS max_id
            FROM dental_q_page3
            GROUP BY patientid
        ) allergens_check_pivot ON allergens_check_pivot.patientid = p.patientid
        LEFT JOIN dental_q_page3 allergens_check ON allergens_check.q_page3id = allergens_check_pivot.max_id',
        'summary' => 'LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid',
        'rx-lomn' => 'LEFT JOIN (
            SELECT pid AS patientid, MAX(id) AS max_id
            FROM dental_flow_pg1
            GROUP BY pid
        ) rx_lomn_pivot ON rx_lomn_pivot.patientid = p.patientid
        LEFT JOIN dental_flow_pg1 rx_lomn ON rx_lomn.id = rx_lomn_pivot.max_id',
        'next-visit' => 'LEFT JOIN (
            SELECT patientid, MAX(id) AS max_id
            FROM dental_flow_pg2_info
            WHERE appointment_type = 0
            GROUP BY patientid
        ) next_visit_pivot ON next_visit_pivot.patientid = p.patientid
        LEFT JOIN dental_flow_pg2_info next_visit ON next_visit.id = next_visit_pivot.max_id',
        'last-dates' => 'LEFT JOIN (
            SELECT base_last_dates.patientid, MAX(base_last_dates.id) AS max_id, base_last_dates.segmentid
            FROM dental_flow_pg2_info base_last_dates
                INNER JOIN (
                    SELECT patientid, max(date_completed) AS max_date
                    FROM dental_flow_pg2_info
                    GROUP BY patientid
                ) pivot_last_dates ON pivot_last_dates.patientid = base_last_dates.patientid
                    AND pivot_last_dates.max_date = base_last_dates.date_completed
            GROUP BY base_last_dates.patientid
        ) last_dates_pivot ON last_dates_pivot.patientid = p.patientid
        LEFT JOIN dental_flow_pg2_info last_dates ON last_dates.id = last_dates_pivot.max_id',
        'device' => 'LEFT JOIN (
            SELECT patientid, dentaldevice, MAX(ex_page5id) AS max_id
            FROM dental_ex_page5
            GROUP BY patientid
        ) device_pivot ON device_pivot.patientid = p.patientid
        LEFT JOIN dental_ex_page5 device_date ON device_date.ex_page5id = device_pivot.max_id
        LEFT JOIN dental_device device ON device.deviceid = device_pivot.dentaldevice',
    ];

    return itemSelector($joinSections, $section);
}

function findPatients ($filter, Array $conditionalList=[], $sortDir, $page=0, $count=30) {
    $db = new Db();

    $sections = querySections();
    $joins = joinList();

    $filter = array_key_exists($filter, $sections) ? $filter : 'name';
    $section = $sections[$filter];
    unset($sections[$filter]);

    $selectList = [
        'p.patientid',
        'summary.vob',
        'summary.ledger AS ledger',
        'summary.patient_info AS patient_info',
    ];
    $tableList = [
        'dental_patients p'
    ];
    $joinList = [
        'summary'
    ];

    $orderBy = $section['order'];
    $orderBy = $filter === 'name' ? $orderBy : "patient_info DESC, $orderBy, p.lastname ASC, p.firstname ASC";
    $orderBy = str_replace('%DIR%', $sortDir, $orderBy);

    if (isset($section['select'])) {
        $selectList []= $section['select'];
    }

    if (isset($section['join'])) {
        $joinList []= $section['join'];
    }

    foreach ($joinList as $name) {
        $tableList []= array_get($joins, $name);
        unset($joins[$name]);
    }

    $selections = join(', ', $selectList);
    $tables = join(' ', $tableList);
    $conditionals = $conditionalList ? join("\nAND ", $conditionalList) : '1=1';

    $page = intval($page);
    $count = intval($count);
    $offset = $page*$count;

    $countQuery = "SELECT COUNT(p.patientid) AS total FROM $tables WHERE $conditionals";
    $countResult = $db->getColumn($countQuery, 'total');

    $orderQuery = "SELECT $selections FROM $tables WHERE $conditionals ORDER BY $orderBy LIMIT $offset, $count";
    $orderResults = $db->getResults($orderQuery);

    $selectList = array_merge($selectList, array_filter(array_pluck($sections, 'select')), ['p.*']);
    $tableList = array_merge($tableList, $joins);

    if ($orderResults) {
        $patientIds = array_pluck($orderResults, 'patientid');
        $patientIds = $db->escapeList($patientIds);

        array_unshift($conditionalList, "p.patientid IN ($patientIds)");
    }

    $selections = join(",\n", $selectList);
    $tables = join("\n", $tableList);
    $conditionals = $conditionalList ? join("\nAND ", $conditionalList) : '1=1';

    /**
     * Given that $orderResults already sliced the results, we don't use any offset here
     */
    $resultsQuery = "SELECT $selections FROM $tables WHERE $conditionals ORDER BY $orderBy LIMIT 0, $count";
    $results = $db->getResults($resultsQuery);

    return [
        'filter' => $filter,
        'queries' => [
            'count' => $countQuery,
            'order' => $orderQuery,
            'results' => $resultsQuery
        ],
        'count' => $countResult,
        'order' => $orderResults,
        'results' => $results
    ];
}

