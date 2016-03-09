<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/../includes/constants.inc';
include_once __DIR__ . '/includes/main_include.php';
include_once __DIR__ . '/../includes/claim_functions.php';
include_once __DIR__ . '/includes/claim_functions.php';
include_once __DIR__ . '/includes/invoice_functions.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/access.php';
require_once __DIR__ . '/includes/webhook-json.php';

if (!is_super($_SESSION['admin_access'])) {
    header('Location: /manage/admin');
    trigger_error('Die called', E_USER_ERROR);
}

function jsonOutput ($output) {
    header('Content-Type: text/json');
    echo @json_encode($output);
    trigger_error('Die called', E_USER_ERROR);
}

function retrieveClaim () {
    $db = new Db();

    $docId = $db->getColumn("SELECT userid
        FROM dental_users
        WHERE username IN ('doc1f', 'doc1')
        LIMIT 1", 'userid');
    $patientId = $db->getColumn("SELECT patientid
        FROM dental_patients
        WHERE docid = '$docId'
            AND firstname = 'Test'
        LIMIT 1", 'patientid');

    $claimId = $db->getColumn("SELECT insuranceid
        FROM dental_insurance
        WHERE docid = '$docId'
            AND patientid = '$patientId'
            AND status = '0'
        LIMIT 1", 'insuranceid', 0);

    if (!$claimId) {
        $claimId = ClaimFormData::createEmptyPrimaryClaim($patientId, $docId);
    }

    $hasLedgerItems = $db->getColumn("SELECT COUNT(ledgerid) AS total
        FROM dental_ledger
        WHERE primary_claim_id = '$claimId'", 'total', 0);

    jsonOutput([
        'claimId' => $claimId,
        'docId' => $docId,
        'patientId' => $patientId,
        'hasLedgerItems' => $hasLedgerItems > 0
    ]);
}

if (isset($_POST['retrieve-claim'])) {
    retrieveClaim();
}

require_once __DIR__ . '/includes/top.htm';

?>
<style type="text/css">
    code { max-height: 200px; }
</style>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
<script>
    var webHooks = <?= webHookEvents() ?>,
        webHookList = {};

    webHooks.forEach(function(each){
        var eventType = each.event || each.status;

        if (!webHookList[eventType]) {
            webHookList[eventType] = [];
        }

        webHookList[eventType].push(each);
    });

    jQuery(function($){
        var claimId = 0,
            docId = 0,
            patientId = 0,
            hasLedgerItems = false,
            now = new Date(),
            today = [now.getDate(), now.getMonth() + 1, now.getFullYear()].join('/'),
            ledgerItem = {
                service_date: today,
                entry_date: today,
                producer: 0,
                procedure_code: 1,
                proccode: 66,
                amount: 5.55,
                status: 1
            };

        function setCookie (name, value, days) {
            var expires = '';

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));

                expires = "; expires=" + date.toGMTString();
            }

            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
        }

        function onError () {
            console.info(arguments);
        }

        function addWebHooks () {
            console.log('Add WebHooks');
        }

        function addLedgerItems () {
            if (hasLedgerItems) {
                setTimeout(addWebHooks, 100);
                return;
            }

            setCookie('tempforledgerentry', 1, 1);

            $.ajax({
                url: '/manage/insert_ledger_entries.php',
                type: 'post',
                data: { form: [ledgerItem], patientid: patientId },
                dataType: 'text',
                success: function(data){
                    setTimeout(addWebHooks, 100);
                },
                error: onError
            });
        }

        function retrieveClaim () {
            $.ajax({
                url: '/manage/admin/debug-webhook-handler.php',
                type: 'post',
                data: { 'retrieve-claim': true },
                dataType: 'json',
                success: function(data){
                    claimId = data.claimId;
                    docId = data.docId;
                    patientId = data.patientId;
                    hasLedgerItems = data.hasLedgerItems;

                    ledgerItem.producer = docId;

                    setTimeout(addLedgerItems, 100);
                },
                error: onError
            })
        }

        $('#setup').click(retrieveClaim);
    });
</script>
<button id="setup" class="btn btn-primary">Setup scenario</button>
<div class="row">
    <div class="col-md-5">5</div>
    <div class="col-md-7">
        <table class="table table-condensed table-hover table-striped">

        </table>
    </div>
</div>
