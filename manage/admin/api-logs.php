<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/edx_functions.php';

$isSuperAdmin = is_super($_SESSION['admin_access']);
$logs = $db->getResults('SELECT *
    FROM dental_api_logs
    ORDER BY id DESC');

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
        $('code.on-demand').each(function () {
            hljs.highlightBlock(this);
        });
    });
</script>

<div class="page-header">
    Raw API Logs
</div>
<?php if ($logs) { ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Method</th>
                <th>Path</th>
                <th>Payload</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log) { ?>
                <tr>
                    <td><?= e($log['method']) ?></td>
                    <td><?= e($log['route']) ?></td>
                    <td><code class="on-demand"><?= e($log['payload']) ?></code></td>
                    <td><?= e($log['created_at']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="text-center">Empty logs</p>
<?php }

require_once __DIR__ . '/includes/bottom.htm';
