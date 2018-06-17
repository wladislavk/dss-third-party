<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/general.htm';

$claimId = intval($_GET['insid']);

$is_front_office = false;
$is_back_office = true;

$mark_as_viewed = false;
$header_class = '';
$table_style = 'class="table table-hover table-bordered table-condensed hidden"';

$multipleViews = true;

$reports = $db->getResults("SELECT payment_id, adddate
    FROM dental_payment_reports
    WHERE claimid = '$claimId'
    ORDER BY adddate DESC");

?>
<script>
    $(document).ready(function() {
        $('.table.table-striped a').click(function () {
            var $this = $(this),
                $table = $this.closest('tr').find('table:first');

            if (!$table.length) {
                return false;
            }

            $table.toggleClass('hidden');
            return false;
        });
    });
</script>
<div class="page-header">
    <h1>
        Payment reports associated to claim ID <code><?= $claimId ?></code>
    </h1>
</div>
<?php if ($reports) { ?>
    <table class="table table-striped">
        <tr>
            <th>Date</th>
            <th>Report</th>
        </tr>
        <?php
        foreach ($reports as $each) {
            $reportId = intval($each['payment_id']); ?>
            <tr>
                <td>
                    <?= e($each['adddate']) ?>
                    <a href="#" title="Toggle report view" class="btn btn-success btn-sm pull-right">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
                <td><?php include __DIR__ . '/includes/payment-report.inc'; ?></td>
            </tr>
        <?php } ?>
    <table>
<?php } else { ?>
    <p class="text-center">
        No payment reports found.
    </p>
<?php }

require_once __DIR__ . '/includes/bottom.htm';
