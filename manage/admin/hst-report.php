<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/general.htm';

$db = new Db();
$isSuperAdmin = is_super($_SESSION['admin_access']);

$userId = (int)array_get($_GET, 'uid', 0);
$companyId = (int)array_get($_GET, 'cid', 0);
$groupedByCompany = !array_get($_GET, 'detailed', false);

$doctorName = $db->getColumn("SELECT CONCAT(last_name, ', ', first_name) AS name
    FROM dental_users
    WHERE userid = '$userId'", 'name', '');
$companyName = $db->getColumn("SELECT name
    FROM companies
    WHERE id = '$companyId'", 'name', '');

$fullResults = hstQuery($_GET);
$total = $fullResults['total'];
$results = $fullResults['results'];
$sortField = $fullResults['sortField'];
$sortDir = $fullResults['sortDir'];
$count = $fullResults['count'];
$page = $fullResults['page'];
$customDateRange = $fullResults['customDateRange'];
$validCustomDates = $fullResults['validCustomDates'];

$completedResults = hstQuery($_GET, [DSS_HST_COMPLETE]);
$completedResults = $completedResults['results'];
$completedResults = array_combine(
    array_pluck($completedResults, 'company_id'),
    $completedResults
);

$queryValues = array_only($_GET, ['page', 'count', 'detailed', 'cid', 'uid', 'from', 'to', 'sort', 'dir']);
$hiddenByGroup = '';

if ($groupedByCompany) {
    $hiddenByGroup = 'hidden';
}

$msg = array_get($_GET, 'msg', '');

if ($customDateRange && !$validCustomDates) {
    $msg .= ' The date format from one of the date filters is invalid.';
}

$lastRange = 'lifetime';
$rangeLabel = 'Lifetime';

if ($customDateRange && $validCustomDates) {
    $lastRange = 'custom_range';
    $rangeLabel = 'Custom Range';
}

?>
<script>
    $(document).ready(function(){
        try {
            setup_autocomplete('company_name', 'company_hints', 'cid', '', 'list_companies.php', 'contact', getParameterByName('pid'));
        } catch (e) {}
        setup_autocomplete('account_name', 'account_hints', 'uid', '', 'list_accounts.php', 'contact', getParameterByName('pid'));

        $(document).ready(function(){
            var $header = $('table.table thead tr.tr_bg_h'),
                $navbar = $('form.navbar-form'),
                $window = $(window),
                heightOffset = 0;

            if ($navbar.length) {
                heightOffset = $navbar.outerHeight()
                    + parseInt($navbar.css('marginTop'))
                    + parseInt($navbar.css('marginBottom'))
                ;
            }

            $header.each(function(){
                var $this = $(this),
                    $clone = $this.clone();

                $clone
                    .find('th')
                    .each(function(index){
                        $(this).width(
                            $this
                                .find('th:eq(' + index + ')')
                                .outerWidth()
                        );
                    })
                ;

                $clone
                    .addClass('fixed-header')
                    .css({
                        position: 'fixed',
                        top: heightOffset,
                        backgroundColor: '#fff',
                        borderBottom: '1px solid #ddd',
                        display: 'none'
                    })
                    .insertBefore($this)
                ;
            });

            function onChange () {
                $header.each(function(){
                    var $this = $(this),
                        $table = $this.closest('table'),
                        $fixed = $this.closest('table').find('.fixed-header');

                    if (!$fixed.length) {
                        return;
                    }

                    $fixed.toggle(
                        // The window scrolled past the header
                        ($this.offset().top - heightOffset <= $window.scrollTop())
                        &&
                        // The window has not scrolled past the table
                        ($table.offset().top - heightOffset + $table.outerHeight() - $this.outerHeight() > $window.scrollTop())
                    );
                });
            }

            $window.bind('resize scroll', onChange);
            onChange();
        });
    });
</script>
<div class="page-header">
    HST Report
</div>
<div class="text-center bg-danger text-danger">
    <p><?= e($msg) ?></p>
</div>

<div style="width:98%;margin:auto;">
    <form action="<?= queryString($queryValues, '') ?>" method="get" class="form form-inline">
        <?php if ($isSuperAdmin) { ?>
            Company:
            <input type="text" id="company_name" class="form-control"
                   onclick="updateval(this)" autocomplete="off" name="company_name"
                   value="<?= $companyName ?>" placeholder="Type company name" />
            <div id="company_hints" class="search_hints" style="display:none;">
                <ul id="company_list" class="search_list">
                    <li class="template" style="display:none">HST Company</li>
                </ul>
            </div>
            <input type="hidden" name="cid" id="cid" value="<?= $companyId ?>" />
        <?php } ?>
        &nbsp;
        Account:
        <input type="text" id="account_name" class="form-control"
               onclick="updateval(this)" autocomplete="off" name="account_name"
               value="<?= $doctorName ?>" placeholder="Type contact name" />
        <div id="account_hints" class="search_hints" style="display:none;">
            <ul id="account_list" class="search_list">
                <li class="template" style="display:none">Doe, John S</li>
            </ul>
        </div>
        <input type="hidden" name="uid" id="uid" value="<?= $userId ?>" />
        &nbsp;
        From:
        <span>
            <input type="text" class="form-control date datepicker" data-date-format="mm/dd/yyyy"
                   name="from" placeholder="mm/dd/yyyy" value="<?= e(array_get($_GET, 'from')) ?>" size="12" />
        </span>
        &nbsp;
        To:
        <span>
            <input type="text" class="form-control date datepicker" data-date-format="mm/dd/yyyy"
                   name="to" placeholder="mm/dd/yyyy" value="<?= e(array_get($_GET, 'to')) ?>" size="12" />
        </span>
        &nbsp;
        <input type="hidden" name="sort" value="<?= $sortField ?>" />
        <input type="hidden" name="dir" value="<?= $sortDir ?>"/>
        <input type="submit" value="Filter List" class="btn btn-primary">
        <input type="button" value="Reset" onclick="window.location='<?= $_SERVER['PHP_SELF'] ?>'"
               class="btn btn-primary">

        <?php if ($isSuperAdmin) { ?>
            &nbsp;
            <?php if ($groupedByCompany) { ?>
                <a class="btn btn-success pull-right" href="<?= queryString($queryValues, '', ['detailed' => 1]) ?>">List by Company and Doctor</a>
            <?php } else { ?>
                <a class="btn btn-success pull-right" href="<?= queryString($queryValues, '', ['detailed' => 1]) ?>">List by Company</a>
            <?php } ?>
        <?php } ?>
    </form>
</div>
<br>
<table class="table table-bordered table-hover table-striped">
    <colgroup>
        <?php if ($groupedByCompany) { ?>
            <col width="52%" />
        <?php } else { ?>
            <col width="26%" />
            <col width="26%" />
        <?php } ?>
        <col width="8%" />
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
                    <?php hstPaging($queryValues, $total, $count, $page); ?>
                </td>
            </tr>
        <?php } ?>
        <tr class="tr_bg_h">
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, 'company', $sortDir) ?>">
                <a href="<?= queryString($queryValues, 'company') ?>">HST Company</a>
            </th>
            <th valign="top" class="col_head <?= $hiddenByGroup ?> <?= get_sort_arrow_class($sortField, 'user', $sortDir) ?>">
                <a href="<?= queryString($queryValues, 'user') ?>">Doctor</a>
            </th>
            <th class="col_head">
                Status
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '0', $sortDir) ?>">
                <a href="<?= queryString($queryValues, '0') ?>">0 - 30</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '30', $sortDir) ?>">
                <a href="<?= queryString($queryValues, '30') ?>">31 - 60</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '60', $sortDir) ?>">
                <a href="<?= queryString($queryValues, '60') ?>">61 - 90</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, '90', $sortDir) ?>">
                <a href="<?= queryString($queryValues, '90') ?>">90+</a>
            </th>
            <th valign="top" class="col_head <?= get_sort_arrow_class($sortField, $lastRange, $sortDir) ?>">
                <a href="<?= queryString($queryValues, $lastRange) ?>">
                    <?= e($rangeLabel) ?>
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="hidden"><td colspan="15"></tr>
        <?php if (!count($results)) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="6" align="center">
                    No Records
                </td>
            </tr>
        <?php } ?>
        <?php foreach ($results as $each) {
            $alternate = [];

            if (isset($completedResults[$each['company_id']])) {
                $alternate = $completedResults[$each['company_id']];
            }

            ?>
            <tr>
                <td valign="top" rowspan="2">
                    <?php if ($each['company_id']) { ?>
                        <?= e($each['company_name']) ?>
                    <?php } else { ?>
                        <i>No company</i>
                    <?php } ?>
                </td>
                <td valign="top" class="<?= $hiddenByGroup ?>" rowspan="2">
                    <a href="/manage/admin/view_user.php?ed=<?= $each['doctor_id'] ?>">
                        <?= e($each['doctor_name']) ?>
                    </a>
                </td>
                <td valign="top" class="text-right">
                    Any
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
                    <?php if ($customDateRange && $validCustomDates) { ?>
                        <?= number_format($each['custom_range'], 0, '.', ',') ?>
                    <?php } else { ?>
                        <?= number_format($each['lifetime'], 0, '.', ',') ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td valign="top" class="text-right">
                    Completed
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($alternate['0-30'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($alternate['31-60'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($alternate['61-90'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?= number_format($alternate['90+'], 0, '.', ',') ?>
                </td>
                <td valign="top" class="text-right">
                    <?php if ($customDateRange && $validCustomDates) { ?>
                        <?= number_format($alternate['custom_range'], 0, '.', ',') ?>
                    <?php } else { ?>
                        <?= number_format($alternate['lifetime'], 0, '.', ',') ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php

require_once __DIR__ . '/includes/bottom.htm';


/**
 * Perform the main query
 *
 * @param array $options
 * @param array $statuses
 * @return array
 */
function hstQuery(array $options, array $statuses = [])
{
    $db = new Db();
    $isSuperAdmin = is_super($_SESSION['admin_access']);
    $adminCompanyId = (int)$_SESSION['admincompanyid'];

    $userId = (int)array_get($options, 'uid', 0);
    $companyId = (int)array_get($options, 'cid', 0);
    $groupedByCompany = (bool)array_get($options, 'grouped', false);

    $sortField = hstSortField(array_get($options, 'sort', 'company'));
    $sortDir = hstSortDirection(array_get($options, 'dir', 'asc'));

    $customDateRange = false;
    $validCustomDates = false;
    $lastDateRange = [
        'upper' => 90,
        'lower' => 0,
    ];

    if (!empty($options['from']) || !empty($options['to'])) {
        $customDateRange = true;

        $now = new \DateTime();
        $lowerLimit = hstDayDiff($options['from'], $now);
        $upperLimit = hstDayDiff($options['to'], $now);

        $validCustomDates = !is_null($upperLimit) && !is_null($lowerLimit);

        if ($validCustomDates) {
            $lastDateRange = [
                'upper' => $upperLimit,
                'lower' => $lowerLimit,
            ];
        }
    }

    $whereConditionals = hstConditionals($isSuperAdmin, $adminCompanyId, $companyId, $userId, $statuses);
    $groupBy = 'GROUP BY company.id, doctor.userid';
    $sortBy = hstSortBy($sortField, $sortDir, $lastDateRange);

    if ($groupedByCompany) {
        $groupBy = 'GROUP BY company.id';
    }

    $count = (int)array_get($options, 'count', 20);
    $page = (int)array_get($options, 'page', 0);
    $offset = $page*$count;

    $interval_0_30 = hstInterval(0, 30);
    $interval_30_60 = hstInterval(30, 60);
    $interval_60_90 = hstInterval(60, 90);
    $interval_90_0 = hstInterval(90, 0);
    $customInterval = hstInterval($lastDateRange['upper'], $lastDateRange['lower']);

    $sql = "SELECT
            company.id AS company_id,
            company.name AS company_name,
            doctor.userid AS doctor_id,
            CONCAT(doctor.last_name, ', ', doctor.first_name) AS doctor_name,
            $interval_0_30 AS `0-30`,
            $interval_30_60 AS `31-60`,
            $interval_60_90 AS `61-90`,
            $interval_90_0 AS `90+`,
            $customInterval AS `custom_range`,
            SUM(IF(hst.id, 1, 0)) AS `lifetime`
        FROM dental_users doctor
            LEFT JOIN dental_hst hst ON hst.doc_id = doctor.userid
            LEFT JOIN companies company ON company.id = hst.company_id
        $whereConditionals
        $groupBy
        HAVING SUM(IF(hst.id, 1, 0)) > 0
    ";

    $total = $db->getColumn("SELECT COUNT(IFNULL(company_id, 0)) AS total
        FROM ($sql) subquery", 'total', 0);

    $sql = "$sql $sortBy
        LIMIT $offset, $count";

    $results = $db->getResults($sql);

    return [
        'total' => $total,
        'results' => $results,
        'sortField' => $sortField,
        'sortDir' => $sortDir,
        'count' => $count,
        'page' => $page,
        'customDateRange' => $customDateRange,
        'validCustomDates' => $validCustomDates,
    ];
}

/**
 * @param string    $stringDate
 * @param \DateTime $referenceDate
 * @return int|null
 */
function hstDayDiff($stringDate, \DateTime $referenceDate)
{
    if ($stringDate === '') {
        return 0;
    }

    try {
        $date = \DateTime::createFromFormat('m/d/Y', $stringDate);
        return +$date->diff($referenceDate)
            ->format('%a')
        ;
    } catch (\Exception $e) {
        return null;
    }
}

/**
 * Return a formatted WHERE string, "WHERE" included
 *
 * @param bool  $isSuperAdmin
 * @param int   $adminCompanyId
 * @param int   $companyId
 * @param int   $userId
 * @param array $statuses
 * @return string
 */
function hstConditionals($isSuperAdmin, $adminCompanyId, $companyId, $userId, array $statuses = [])
{
    $db = new Db();
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

    if (count($statuses)) {
        $statuses = $db->escapeList($statuses);
        $conditionals[] = "hst.status IN ($statuses)";
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

    if (in_array($sortBy, ['company', 'user', '0', '30', '60', '90', 'lifetime', 'custom_range'])) {
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
 * @param array  $customLimit
 * @return string
 */
function hstSortBy($sortBy, $direction, array $customLimit = []) {
    $orderCompany = "company.name $direction";
    $orderUser = "doctor.last_name $direction, doctor.first_name $direction";

    if ($sortBy === 'company') {
        return "ORDER BY $orderCompany, $orderUser";
    }

    if ($sortBy === 'user') {
        return "ORDER BY $orderUser, $orderCompany";
    }

    if ($sortBy === 'lifetime' || $sortBy === 'custom_range') {
        return "ORDER BY `$sortBy` $direction, $orderCompany, $orderUser";
    }

    if (in_array($sortBy, ['0', '30', '60'], true)) {
        $limit = (int)$sortBy;
        $offset = 1;

        if ($limit === 0) {
            $offset = 0;
        }

        $interval = ($limit + $offset) . '-' . ($limit + 30);
        return "ORDER BY `$interval` $direction, $orderCompany, $orderUser";
    }

    if ($sortBy === '90') {
        return "ORDER BY `90+` $direction, $orderCompany, $orderUser";
    }

    return "ORDER BY $orderCompany, $orderUser";
}

/**
 * Generate a query string for sorting
 *
 * @param array  $queryValues
 * @param string $currentField
 * @param array  $replacementValues
 * @return string
 */
function queryString(array $queryValues, $currentField, array $replacementValues = [])
{
    $queryValues += $replacementValues;
    
    if ($currentField !== '') {
        $currentDir = get_sort_dir($currentField, $queryValues['sort'], $queryValues['dir']);
        $queryValues['sort'] = $currentField;
        $queryValues['dir'] = $currentDir;
    }
    
    return '?' . http_build_query($queryValues);
}

/**
 * @param array $queryValues
 * @param int   $total
 * @param int   $count
 * @param int   $page
 */
function hstPaging(array $queryValues, $total, $count, $page)
{
    unset($queryValues['page']);
    $queryString = http_build_query($queryValues);
    paging(floor($total/$count), $page, $queryString);
}