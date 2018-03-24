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

if (!empty($_POST['truncate'])) {
    $db->query("TRUNCATE dental_sms_log");
} elseif (!empty($_POST['older'])) {
    $db->query("DELETE FROM dental_sms_log WHERE created_at < (NOW() - INTERVAL 2 WEEK)");
}

$page = array_get($_GET, 'page', 0);
$count = array_get($_GET, 'count', 100);

$page = intval($page);
$count = intval($count);

$page = $page >= 0 ? $page : 0;
$count = $count >= 5 ? $count : 100;

$offset = $page*$count;
$totalCount = $db->getColumn("SELECT COUNT(id) AS total FROM dental_sms_log", 'total', 0);

$totalPages = ceil($totalCount/$count);

$results = $db->getResults("SELECT *
    FROM dental_sms_log
    ORDER BY id DESC
    LIMIT $offset, $count");

require_once __DIR__ . '/includes/top.htm';

?>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
    <script>
        jQuery(function($){
            $('form [name=truncate]').click(function(){
                return confirm('Are you sure you want to remove ALL the logs?');
            });

            $('.table.table-condensed a').click(function() {
                var $this = $(this),
                    $tr = $this.closest('tr').nextUntil('tr.json').last().nextUntil('tr:not(.json)');

                if (!$tr.length) {
                    return false;
                }

                $tr.each(function(){
                    var $this = $(this);

                    if (!$this.is('.parsed')) {
                        $this.addClass('parsed').find('pre.on-demand').each(function () {
                            hljs.highlightBlock(this);
                        });
                    }
                });

                $tr.toggleClass('hidden');

                return false;
            });
        });
    </script>
    <form method="post">
        <input type="submit" class="btn btn-primary" name="older" value="Delete logs older than 2 weeks" />
        <input type="submit" class="btn btn-danger pull-right" name="truncate" value="Delete ALL logs" />
    </form>
    <p>&nbsp;</p>

<?php if (!$results) { ?>
    <p class="lead text-center">There are no SMS logs.</p>
<?php } ?>

    <p class="text-right">Pages: <?php paging($totalPages, $page, "count=$count") ?></p>
    <table class="table table-condensed table-bordered">
        <colgroup>
            <col width="15%" />
            <col width="12%" />
            <col width="12%" />
            <col width="12%" />
            <col width="10%" />
            <col width="20%" />
            <col width="20%" />
        </colgroup>
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>Twilio ID</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Text</th>
                <th>Error Message</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $sms) { ?>
            <tr>
                <td>
                    <?= e($sms['created_at']) ?>
                </td>
                <td>
                    <code><?= e($sms['sid']) ?></code>
                </td>
                <td>
                    <code><?= e($sms['from']) ?></code>
                </td>
                <td>
                    <code><?= e($sms['to']) ?></code>
                </td>
                <td>
                    <code><?= e($sms['status']) ?></code>
                </td>
                <td>
                    <?= e($sms['text']) ?>
                </td>
                <td>
                    <?= e($sms['message']) ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php

require_once __DIR__ . '/includes/bottom.htm';
