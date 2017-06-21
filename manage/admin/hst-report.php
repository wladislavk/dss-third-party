<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/general.htm';

$isSuperAdmin = is_super($_SESSION['admin_access']);
$adminCompanyId = (int)$_SESSION['admincompanyid'];

$userId = (int)array_get($_GET, 'uid', 0);
$companyId = (int)array_get($_GET, 'cid', 0);
$groupedByCompany = (bool)array_get($_GET, 'grouped', false);

$doctorName = $db->getColumn("SELECT CONCAT(last_name, ', ', first_name) AS name
    FROM dental_users
    WHERE userid = '$userId'", 'name', '');
$companyName = $db->getColumn("SELECT name
    FROM companies
    WHERE id = '$companyId'", 'name', '');

$sortField = hstSortField(array_get($_GET, 'sort', 'company'));
$sortDir = hstSortDirection(array_get($_GET, 'dir', 'asc'));

$whereConditionals = hstConditionals($isSuperAdmin, $adminCompanyId, $companyId, $userId);
$groupBy = 'GROUP BY company.id, doctor.userid';
$sortBy = hstSortBy($sortField, $sortDir);

if ($groupedByCompany) {
    $groupBy = 'GROUP BY company.id';
}

$count = (int)array_get($_GET, 'count', 20);
$page = (int)array_get($_GET, 'page', 0);
$offset = $page*$count;

$interval_0_30 = hstInterval(0, 30);
$interval_30_60 = hstInterval(30, 60);
$interval_60_90 = hstInterval(60, 90);
$interval_90_0 = hstInterval(90, 0);

$sql = "SELECT
        company.id AS company_id,
        company.name AS company_name,
        doctor.userid AS doctor_id,
        CONCAT(doctor.last_name, ', ', doctor.first_name) AS doctor_name,
        $interval_0_30 AS '0-30',
        $interval_30_60 AS '31-60',
        $interval_60_90 AS '61-90',
        $interval_90_0 AS '90+',
        SUM(IF(hst.id, 1, 0)) AS 'lifetime'
    FROM dental_users doctor
        LEFT JOIN dental_hst hst ON hst.doc_id = doctor.userid
        LEFT JOIN companies company ON company.id = hst.company_id
    $whereConditionals
    $groupBy
    HAVING SUM(IF(hst.id, 1, 0)) > 0
    ";

$total = $db->getColumn("SELECT COUNT(company_id) AS total
    FROM ($sql) subquery", 'total', 0);

$sql = "$sql $sortBy
    LIMIT $offset, $count";

$results = $db->getResults($sql);

$queryString = '';
$sortQueryString = '?sort=%s&dir=%s';

$queryValues = array_only($_GET, ['page', 'count', 'grouped', 'cid', 'uid', 'sort', 'dir']);
$sortQueryValues = array_except($queryValues, ['sort', 'dir']);

if (count($queryValues)) {
    $queryString = '?' . http_build_query($queryValues);
}

if (count($sortQueryValues)) {
    $sortQueryString = '?' . http_build_query($sortQueryValues) . '&sort=%s&dir=%s';
}

$hiddenByGroup = '';

if ($groupedByCompany) {
    $hiddenByGroup = 'hidden';
}

?>
<script>
    $(document).ready(function(){
        try {
            setup_autocomplete('company_name', 'company_hints', 'cid', '', 'list_companies.php', 'contact', getParameterByName('pid'));
        } catch (e) {}
        setup_autocomplete('account_name', 'account_hints', 'uid', '', 'list_accounts.php', 'contact', getParameterByName('pid'));
    });
</script>
<div class="page-header">
    HST Report
</div>
<div align="center" class="red">
    <strong><?= e(array_get($_GET, 'msg', '')) ?></strong>
</div>

<div style="width:98%;margin:auto;">
    <form action="<?= $queryString ?>" method="get">
        <?php if ($isSuperAdmin) { ?>
            Company:
            <input type="text" id="company_name" onclick="updateval(this)" autocomplete="off" name="company_name"
                   value="<?= $companyName ?>" placeholder="Type company name" />
            <div id="company_hints" class="search_hints" style="display:none;">
                <ul id="company_list" class="search_list">
                    <li class="template" style="display:none">HST Company</li>
                </ul>
            </div>
            <input type="hidden" name="cid" id="cid" value="<?= $companyId ?>" />
        <?php } ?>

        Account:
        <input type="text" id="account_name" onclick="updateval(this)" autocomplete="off" name="account_name"
               value="<?= $doctorName ?>" placeholder="Type contact name" />
        <div id="account_hints" class="search_hints" style="display:none;">
            <ul id="account_list" class="search_list">
                <li class="template" style="display:none">Doe, John S</li>
            </ul>
        </div>
        <input type="hidden" name="uid" id="uid" value="<?= $userId ?>" />

        <input type="hidden" name="sort" value="<?= $sortField ?>" />
        <input type="hidden" name="dir" value="<?= $sortDir ?> "/>
        <input type="submit" value="Filter List" class="btn btn-primary">
        <input type="button" value="Reset" onclick="window.location='<?= $_SERVER['PHP_SELF'] ?>'"
               class="btn btn-primary">

        <?php if ($isSuperAdmin) { ?>
            <?php if ($groupedByCompany) { ?>
                <a class="btn btn-success pull-right" href="?grouped=0">List by Company and Doctor</a>
            <?php } else { ?>
                <a class="btn btn-success pull-right" href="?grouped=1">List by Company</a>
            <?php } ?>
        <?php } ?>
    </form>
</div>
<br>
<table class="table table-bordered table-hover">
    <colgroup>
        <?php if ($groupedByCompany) { ?>
            <col width="60%" />
        <?php } else { ?>
            <col width="30%" />
            <col width="30%" />
        <?php } ?>
        <col width="8%" />
        <col width="8%" />
        <col width="8%" />
        <col width="8%" />
        <col width="8%" />
    </colgroup>
    <thead>
        <?php if ($total && $total > $count) { ?>
            <tr bgColor="#ffffff">
                <td  align="right" colspan="15" class="bp">
                    Pages:
                    <?php paging(floor($total/$count), $page, $queryString); ?>
                </td>
            </tr>
        <?php } ?>
        <tr class="tr_bg_h">
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, 'company', $sortDir) ?>">
                <a href="<?= sprintf($sortQueryString, 'company', get_sort_dir($sortField, 'company', $sortDir))?>">HST Company</a>
            </th>
            <th valign="top" class="col_head <?= $hiddenByGroup ?> <?= get_sort_arrow_class($sortField, 'user', $sortDir) ?>">
                <a href="<?= sprintf($sortQueryString, 'user', get_sort_dir($sortField, 'user', $sortDir))?>">Doctor</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '0', $sortDir) ?>">
                <a href="<?= sprintf($sortQueryString, '0', get_sort_dir($sortField, '0', $sortDir))?>">0 - 30</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '30', $sortDir) ?>">
                <a href="<?= sprintf($sortQueryString, '30', get_sort_dir($sortField, '30', $sortDir))?>">31 - 60</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '60', $sortDir) ?>">
                <a href="<?= sprintf($sortQueryString, '60', get_sort_dir($sortField, '60', $sortDir))?>">61 - 90</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '90', $sortDir) ?>">
                <a href="<?= sprintf($sortQueryString, '90', get_sort_dir($sortField, '90', $sortDir))?>">90+</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, 'lifetime', $sortDir) ?>">
                <a href="<?= sprintf($sortQueryString, 'lifetime', get_sort_dir($sortField, 'lifetime', $sortDir))?>">Lifetime</a>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if (!count($results)) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="6" align="center">
                    No Records
                </td>
            </tr>
        <?php } ?>
        <?php foreach ($results as $each) { ?>
            <tr>
                <td valign="top">
                    <?php if ($each['company_id']) { ?>
                        <?= e($each['company_name']) ?>
                    <?php } else { ?>
                        <i>No company</i>
                    <?php } ?>
                </td>
                <td valign="top" class="<?= $hiddenByGroup ?>">
                    <a href="/manage/admin/view_user.php?ed=<?= $each['doctor_id'] ?>">
                        <?= e($each['doctor_name']) ?>
                    </a>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($each['0-30'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($each['31-60'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($each['61-90'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($each['90+'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($each['lifetime'], 0, '.', ',') ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php

require_once __DIR__ . '/includes/bottom.htm';


/**
 * Return a formatted WHERE string, "WHERE" included
 *
 * @param bool $isSuperAdmin
 * @param int  $adminCompanyId
 * @param int  $companyId
 * @param int  $userId
 * @return string
 */
function hstConditionals($isSuperAdmin, $adminCompanyId, $companyId, $userId)
{
    $conditionals = [];
    $whereConditionals = '';

    if (!$isSuperAdmin) {
        $conditionals[] = "hst.company_id = '$adminCompanyId'";
    }

    if ($companyId) {
        $conditionals[] = "hst.company_id = '$companyId'";
    }

    if ($userId) {
        $conditionals[] = "doctor.userid = '$userId'";
    }

    if (count($conditionals)) {
        $whereConditionals = 'WHERE (' . join(') AND (', $conditionals) . ')';
    }

    return $whereConditionals;
}

/**
 * Whitelist ORDER BY field name
 *
 * @param string $sortBy
 * @return string
 */
function hstSortField($sortBy) {
    $sortBy = strtolower($sortBy);

    if (in_array($sortBy, ['company', 'user', '0', '30', '60', '90', 'lifetime'])) {
        return $sortBy;
    }

    return 'company';
}

/**
 * Whitelist ORDER BY direction
 *
 * @param string $sortDir
 * @return string
 */
function hstSortDirection($sortDir) {
    $sortDir = strtolower($sortDir);

    if ($sortDir === 'desc') {
        return 'desc';
    }

    return 'asc';
}

/**
 * Generate SQL expression to determine if Add Date lies within a particular lapse
 *
 * @param string|int $lowerLimit
 * @param string|int $upperLimit
 * @return string
 */
function hstInterval($lowerLimit, $upperLimit) {
    $upperLimit = (int)$upperLimit;
    $lowerLimit = (int)$lowerLimit;

    $lessThan = '<';

    if (!$lowerLimit) {
        $lessThan = '<=';
    }

    if ($upperLimit) {
        return "SUM(
                CASE
                    WHEN hst.id IS NULL THEN 0
                    WHEN hst.adddate >= DATE_SUB(CURDATE(), INTERVAL $upperLimit DAY)
                            AND hst.adddate $lessThan DATE_SUB(CURDATE(), INTERVAL $lowerLimit DAY)
                        THEN 1
                    ELSE 0
                END
            )";
    }

    return "SUM(
            CASE
                WHEN hst.id IS NULL THEN 0
                WHEN hst.adddate $lessThan DATE_SUB(CURDATE(), INTERVAL $lowerLimit DAY)
                    THEN 1
                ELSE 0
            END
        )";
}

/**
 * Generate proper ORDER BY expression, "ORDER BY" included
 *
 * @param string $sortBy
 * @param string $direction
 * @return string
 */
function hstSortBy($sortBy, $direction) {
    $orderCompany = "company.name $direction";
    $orderUser = "doctor.last_name $direction, doctor.first_name $direction";

    if ($sortBy === 'company') {
        return "ORDER BY $orderCompany, $orderUser";
    }

    if ($sortBy === 'user') {
        return "ORDER BY $orderUser, $orderCompany";
    }

    if ($sortBy === 'lifetime') {
        return "ORDER BY SUM(IF(hst.id, 1, 0)) $direction, $orderCompany, $orderUser";
    }

    if (in_array($sortBy, ['0', '30', '60', '90'])) {
        $lowerLimit = (int)$sortBy;
        $upperLimit = $lowerLimit + 30;

        if ($upperLimit > 90) {
            $upperLimit = 0;
        }

        $interval = hstInterval($lowerLimit, $upperLimit);
        return "ORDER BY $interval $direction, $orderCompany, $orderUser";
    }

    return "ORDER BY $orderCompany, $orderUser";
}
