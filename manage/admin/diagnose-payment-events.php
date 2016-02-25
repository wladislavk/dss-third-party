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

function getPaymentAmountFromEligibleResponse (\stdClass $event) {
    if (!is_object($event)) {
        return null;
    }

    $report = [
        'Reference ID' => object_get($event, 'reference_id'),
        'Payment Trace ID' => object_get($event, 'details.financials.payment_trace_number'),
        'Payment Total' => object_get($event, 'details.financials.total_payment_amount'),

        'Claim ID' => object_get($event, 'details.claim.control_number'),
        'Claim Amt Billed' => object_get($event, 'details.claim.amount.billed'),
        'Claim Amt Paid' => object_get($event, 'details.claim.amount.paid'),
        'Claim Amt Pt Resp' => object_get($event, 'details.claim.amount.patient_responsibility'),
        'Claim Amt Total Coverage' => object_get($event, 'details.claim.amount.total_coverage'),

        'Service Lines' => []
    ];

    foreach (object_get($event, 'details.claim.service_lines') as $transaction) {
        $report['Service Lines'] []= [
            'Procedure Code' => object_get($transaction, 'procedure_code'),
            'Amt Billed' => object_get($transaction, 'amount.billed'),
            'Amt Paid' => object_get($transaction, 'amount.paid'),
            'Total Coverage' => object_get($transaction, 'total_coverage'),
            'Adjustments' => object_get($transaction, 'adjustments'),
        ];
    }

    return $report;
}

function getPaymentsArray ($limit=50) {
    $db = new Db();
    $limit = intval($limit);
    $limit = $limit > 5 ? $limit : 50;

    $results = [];
    $unparsedResults = $db->getResults("SELECT eligible.response
        FROM dental_eligible_response eligible
            JOIN dental_claim_electronic eclaim ON eclaim.reference_id = eligible.reference_id
        WHERE LENGTH(eligible.reference_id)
            AND eligible.event_type = 'payment_report'
        ORDER BY eligible.id DESC
        LIMIT $limit");

    foreach ($unparsedResults as $json) {
        $results []= json_decode($json['response']);
    }

    return $results;
}

function getReferencedClaims (Array $referenceIds) {
    $db = new Db();

    $referenceIds = $db->escapeList($referenceIds);

    if (!$referenceIds) {
        return [];
    }

    $referencedClaims = [];
    $unorderedReferencedClaims = $db->getResults("SELECT
            eligible.reference_id, GROUP_CONCAT(claim.insuranceid SEPARATOR ', ') AS claims
        FROM dental_claim_electronic eligible
            LEFT JOIN dental_insurance claim ON claim.insuranceid = eligible.claimid
        WHERE eligible.reference_id IN ($referenceIds)
        GROUP BY eligible.reference_id");

    foreach ($unorderedReferencedClaims as $each) {
        $referencedClaims [$each['reference_id']] = $each['claims'];
    }

    return $referencedClaims;
}

$getGrouped = !empty($_GET['grouped']);
$limit = !empty($_GET['limit']) ? intval($_GET['limit']) : 50;

$results = [];
$referenceIds = [];
$jsonArray = getPaymentsArray($limit);

foreach ($jsonArray as $json) {
    $amount = getPaymentAmountFromEligibleResponse($json);
    $referenceIds []= $amount['Reference ID'];

    if ($getGrouped) {
        $paymentTraceId = $amount['Payment Trace ID'];

        if (!isset($results[$paymentTraceId])) {
            $results[$paymentTraceId] = [];
        }

        $results[$paymentTraceId] []= [$json, $amount];
    } else {
        $results []= [$json, $amount];
    }
}

$referencedClaims = getReferencedClaims($referenceIds);

require_once __DIR__ . '/includes/top.htm';

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<style type="text/css">
    pre { max-height: 300px; }
</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
<script>
    jQuery(function($){
        $('pre:not(.on-demand)').each(function(index, target){
            setTimeout(function(){ hljs.highlightBlock(target); }, index*500);
        });

        $('a').click(function(){
            var $this = $(this),
                $tr = $this.closest('tr').next('tr.json');

            if (!$tr.length) {
                return false;
            }

            if (!$tr.is('.parsed')) {
                $tr.addClass('parsed').find('pre').each(function(){
                    hljs.highlightBlock(this);
                });
            }

            $tr.toggleClass('hidden');

            return false;
        });
    });
</script>
<form>
    <label>
        <input type="checkbox" name="grouped" <?= $getGrouped ? 'checked' : '' ?> />
        Group by Payment Trace ID
    </label>
    <input type="submit" />
</form>
<?php if ($getGrouped) { ?>
    <?php foreach ($results as $paymentTraceId=>$grouped) { ?>
        <hr />
        <p class="lead"><?= e($paymentTraceId) ?></p>

        <table class="table table-condensed table-bordered">
            <thead>
            <tr>
                <th></th>
                <th width="12%">Reference ID</th>
                <th width="12%">Payment Trace ID</th>
                <th width="12%">Payment Total</th>
                <th width="12%">Claim ID</th>
                <th width="12%">Claim Amt Billed</th>
                <th width="12%">Claim Amt Paid</th>
                <th width="12%">Claim Amt Pt Resp</th>
                <th width="12%">Claim Amt Total Coverage</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($grouped as $result) {
                $report = $result[1];

                $lines = $report['Service Lines'];
                $referenceId = $report['Reference ID'];
                $linkedClaims = array_key_exists($referenceId, $referencedClaims) ?
                    $referencedClaims[$referenceId] : '';

                unset($report['Service Lines']);

                ?>
                <tr>
                    <td><a href="#" title="Toggle JSON">#</a></td>
                    <td <?= $linkedClaims ? 'title="Linked claim ids: ' . $linkedClaims . '"' : '' ?>>
                        <?php if ($linkedClaims) { ?>
                            <code><?= e($referenceId) ?></code>
                        <?php } else { ?>
                            <?= e($referenceId) ?>
                        <?php } ?>
                    </td>
                    <td><code><?= e($report['Payment Trace ID']) ?></code></td>
                    <td><code><?= e($report['Payment Total']) ?></code></td>
                    <td><code><?= e($report['Claim ID']) ?></code></td>
                    <td><code><?= e($report['Claim Amt Billed']) ?></code></td>
                    <td><code><?= e($report['Claim Amt Paid']) ?></code></td>
                    <td><code><?= e($report['Claim Amt Pt Resp']) ?></code></td>
                    <td><code><?= e($report['Claim Amt Total Coverage']) ?></code></td>
                </tr>
                <tr class="json hidden">
                    <td></td>
                    <td width="48%" colspan="4">
                        <pre class="on-demand"><code><?= e(json_encode($result[0], JSON_PRETTY_PRINT)) ?></code></pre>
                    </td>
                    <td colspan="4">
                        <pre class="on-demand"><code><?= e(json_encode($lines, JSON_PRETTY_PRINT)) ?></code></pre>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } ?>
<?php } else { ?>
    <table class="table table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th>Payment Report from Eligible</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $result) { ?>
            <tr>
                <td width="50%">
                    <pre><code><?= e(json_encode($result[0], JSON_PRETTY_PRINT)) ?></code></pre>
                </td>
                <td>
                    <pre><code><?= e(json_encode($result[1], JSON_PRETTY_PRINT)) ?></code></pre>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>
