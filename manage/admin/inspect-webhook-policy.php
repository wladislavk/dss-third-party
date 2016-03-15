<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/access.php';
require_once __DIR__ . '/../includes/constants.inc';

if (!is_super($_SESSION['admin_access'])) {
    header('Location: /manage/admin');
    trigger_error('Die called', E_USER_ERROR);
}

$page = array_get($_GET, 'page', 0);
$count = array_get($_GET, 'count', 100);

$page = intval($page);
$count = intval($count);

$page = $page >= 0 ? $page : 0;
$count = $count >= 5 ? $count : 100;

$offset = $page*$count;
$totalCount = $db->getColumn("SELECT COUNT(id) AS total FROM dental_webhook_policy_log", 'total', 0);

$totalPages = ceil($totalCount/$count);

$results = $db->getResults("SELECT log.*, claim.docid, doctor.username, claim.patientid
    FROM dental_webhook_policy_log log
        LEFT JOIN dental_insurance claim ON claim.insuranceid = log.claimid
        LEFT JOIN dental_users doctor ON doctor.userid = claim.docid
    ORDER BY id DESC
    LIMIT $offset, $count");

require_once __DIR__ . '/includes/top.htm';

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<style type="text/css">
    pre { max-height: 300px; }

    table { table-layout: fixed; }

    td[rowspan] {
        position: relative;
        overflow: auto;
    }

    td[rowspan] a.btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
    }
</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>

<p>
    Webhook events can reach DS3 out of order. The system will track these events and only allow certain status changes.
    For those statuses that don't follow the allowed flow, the system stores the following log.
</p>

<?php if (!$results) { ?>
    <p class="lead text-center">There are no email logs.</p>
<?php } ?>

<p class="text-right">Pages: <?php paging($totalPages, $page, "count=$count") ?></p>
<table class="table table-bordered table-condensed table-hover">
    <colgroup>
        <col width="15%" />
        <col width="8%" />
        <col width="17%" />
        <col width="17%" />
        <col width="17%" />
        <col width="26%" />
    </colgroup>
    <thead>
        <tr>
            <th>Event date</th>
            <th>Claim ID</th>
            <th>User</th>
            <th>Status at time of event</th>
            <th>Status not applied</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($results as $log) { ?>
        <tr>
            <td>
                <?= e($log['created_at']) ?>
            </td>
            <td>
                <code><?= $log['claimid'] ?></code>
            </td>
            <td>
                <code><?= e($log['username']) ?></code>
            </td>
            <td>
                <code><?= e($log['current_status']) ?></code>
            </td>
            <td>
                <code><?= e($log['rejected_status']) ?></code>
            </td>
            <td>
                <a class="btn btn-primary btn-xs" target="_blank"
                    href="/manage/admin/diagnose-claim.php?claim_id=<?= $log['claimid'] ?>&amp;timeline=on">
                    Claim Timeline
                    <i class="fa fa-external-link"></i>
                </a>
                <a class="btn btn-info btn-xs" target="_blank"
                    title="Login as <?= e($log['username']) ?> before seeing this claim"
                    href="/manage/view_claim.php?claimid=<?= $log['claimid'] ?>&amp;pid=<?= $log['patientid'] ?>">
                    Claim View
                    <i class="fa fa-external-link"></i>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php

require_once __DIR__ . '/includes/bottom.htm';
