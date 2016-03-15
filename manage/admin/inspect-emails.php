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
    $db->query("TRUNCATE dental_email_log");
} elseif (!empty($_POST['older'])) {
    $db->query("DELETE FROM dental_email_log WHERE created_at < (NOW() - INTERVAL 2 WEEK)");
}

$page = array_get($_GET, 'page', 0);
$count = array_get($_GET, 'count', 100);

$page = intval($page);
$count = intval($count);

$page = $page >= 0 ? $page : 0;
$count = $count >= 5 ? $count : 100;

$offset = $page*$count;
$totalCount = $db->getColumn("SELECT COUNT(id) AS total FROM dental_email_log", 'total', 0);

$totalPages = ceil($totalCount/$count);

$results = $db->getResults("SELECT *
    FROM dental_email_log
    ORDER BY id DESC
    LIMIT $offset, $count");

array_walk($results, function(&$each){
    $parts = preg_split(
        '/[\r\n]{2}--ds3[a-z0-9]+[\r\n]Content-Type: *text\/html; *charset=UTF-8[\r\n]{2}/i', $each['body'], 2
    );

    $each['text'] = array_get($parts, 0, '');
    $each['html'] = array_get($parts, 1, '');
});

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
    <p class="lead text-center">There are no email logs.</p>
<?php } ?>

    <p class="text-right">Pages: <?php paging($totalPages, $page, "count=$count") ?></p>
<table class="table table-condensed table-bordered">
    <colgroup>
        <col width="15%" />
        <col width="10%" />
        <col width="25%" />
        <col width="25%" />
        <col width="25%" />
    </colgroup>
    <tbody>
        <?php foreach ($results as $email) { ?>
            <tr>
                <td rowspan="4">
                    <?= e($email['created_at']) ?>
                    <a href="#" title="Toggle email view" class="btn btn-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <th>From</th>
                <td colspan="3"><code><?= e($email['from']) ?></code></td>
            </tr>
            <tr>
                <th>To</th>
                <td colspan="3"><code><?= e($email['to']) ?></code></td>
            </tr>
            <tr>
                <th>Subject</th>
                <td colspan="3"><code><?= e($email['subject']) ?></code></td>
            </tr>
            <tr class="json hidden">
                <th>Headers</th>
                <td colspan="4"><pre class="on-demand"><?= e($email['headers']) ?></pre></td>
            </tr>
            <tr class="json hidden">
                <th>Full Body</th>
                <td colspan="4"><pre><?= e($email['body']) ?></pre></td>
            </tr>
            <tr class="json hidden">
                <th>Text Version</th>
                <td colspan="4"><pre><?= e($email['text']) ?></pre></td>
            </tr>
            <tr class="json hidden">
                <th>HTML Version</th>
                <td colspan="4"><?= $email['html'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php

require_once __DIR__ . '/includes/bottom.htm';
