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

    $docData = $db->getRow("SELECT userid, username, password
        FROM dental_users
        WHERE username IN ('doc1f', 'doc1')
        LIMIT 1");

    $docId = $docData['userid'];

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

    $ledgerItems = $db->getColumn("SELECT COUNT(ledgerid) AS total
        FROM dental_ledger
        WHERE primary_claim_id = '$claimId'", 'total', 0);

    jsonOutput([
        'claim' => [
            'id' => $claimId,
            'reference' => "ECLAIM-$claimId",
            'items' => $ledgerItems,
        ],
        'doctor' => [
            'id' => $docId,
            'username' => $docData['username'],
            'hash' => $docData['password'],
        ],
        'patient' => [
            'id' => $patientId,
        ],
    ]);
}

function setReference ($claimId, $referenceId) {
    $db = new Db();

    $claimId = intval($claimId);
    $referenceId = $db->escape($referenceId);

    $db->query("UPDATE dental_claim_electronic
        SET reference_id = '$referenceId'
        WHERE claimid = '$claimId'
            AND (reference_id IS NULL OR reference_id = '')");

    $referenceId = $db->getColumn("SELECT reference_id
        FROM dental_claim_electronic
        WHERE claimid = '$claimId'
        ORDER BY id DESC
        LIMIT 1", 'reference_id');

    jsonOutput(['reference' => $referenceId]);
}

if (isset($_POST['retrieve-claim'])) {
    retrieveClaim();
}

if (isset($_POST['set-reference'])) {
    setReference($_POST['claim-id'], $_POST['reference-id']);
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
        var claim = { id: 0, items: 0 },
            doctor = { id: 0, username: '', hash: '' },
            patient = { id: 0 },
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
            },
            queueCall = [];

        function setCookie (name, value, days) {
            var expires = '';

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));

                expires = "; expires=" + date.toGMTString();
            }

            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
        }

        function niceTime () {
            var now = new Date(),
                time = [now.getHours(), now.getMinutes(), now.getSeconds()].join(':');

            time = time.replace(/(^|:)(\d)(:|$)/g, '$1Z$2$3').replace('Z', 0);
            return time + '.' + ('000' + now.getMilliseconds()).substr(-3);
        }

        function queued (callable, timeout) {
            timeout = timeout || 300;

            return function () {
                setTimeout(callable, timeout);
            }
        }

        function debugLog (message, reset) {
            var $log = $('#debug-log');

            if (reset) {
                $log.text('');
            }

            $log.prepend('[' + niceTime() + '] ' + message + '\n');
        }


        function onStart () {
            debugLog('Starting...', true);
            $('.interaction-lock').prop('disabled', true);
        }

        function onError () {
            debugLog('Last step failed.');
            $('.interaction-lock').prop('disabled', false);
        }

        function onFinish () {
            debugLog('Finished.');
            $('.interaction-lock').prop('disabled', false);
        }

        function sendWebHook (webHook, delay) {
            setTimeout(function() {
                debugLog('Sending ' + (webHook.event || webHook.status || 'unnamed') + ' event...');

                webHook.reference_id = claim.reference;

                $.ajax({
                    url: '/manage/eligible_webhook.php',
                    data: JSON.stringify(webHook),
                    type: 'post',
                    processData: false,
                    contentType: 'application/json'
                });
            }, delay*1234);
        }

        function sendWebHooks (webHookList, onComplete) {
            if (!webHookList.length) {
                debugLog('Webhook list is empty');
                return;
            }

            console.info(webHookList);

            var lastAction = onComplete,
                currentAction, n;

            for (n = 0; n < webHookList.length; n++) {
                sendWebHook(webHookList[n], n);
            }

            setTimeout(onFinish, n*1234);
        }

        function addWebHooks () {
            debugLog('Add WebHooks');

            sendWebHooks([
                webHookList['claim_submitted'][0],
                webHookList['claim_received'][0],
                webHookList['claim_accepted'][0],
                webHookList['accepted'][0],
                webHookList['claim_denied'][0],
                webHookList['payment_report'][0]
            ], onFinish);
        }

        function printClaim () {
            debugLog('Printing claim to change status to Sent...');

            $.ajax({
                url: '/manage/insurance_v2.php?insid=' + claim.id + '&pid=' + patient.id,
                type: 'post',
                data: { insurancesub: 1, ex_pagebtn: 1 },
                success: queued(addWebHooks),
                error: onError
            });
        }

        function fakeReferenceId () {
            debugLog('Assume Eligible rejection, set a valid Reference ID...');

            $.ajax({
                url: '/manage/admin/debug-webhook-handler.php',
                type: 'post',
                dataType: 'json',
                data: { 'set-reference': 1, 'claim-id': claim.id, 'reference-id': claim.reference },
                success: queued(printClaim),
                error: onError
            })
        }

        function submitClaim () {
            debugLog('Submitting to Eligible, adding delay of 5 seconds...');

            var $form = $('iframe#submission-form').contents().find('form#claim-form');

            if (!$form.length) {
                onError();
                return;
            }

            $form.find('button.form-submit').click();
            queued(fakeReferenceId, 5000)();
        }

        function prepareEForm () {
            debugLog('Preparing E-Form for submission...');

            var $iframe = $('iframe#submission-form'),
                runOnce = 1;

            $iframe.remove();

            $iframe = $('<iframe>', {
                id: 'submission-form',
                style: 'width:1px;height:1px;',
                src: '/manage/insurance_eligible.php?insid=' + claim.id + '&pid=' + patient.id + '&v=' + Math.random()
            }).load(queued(function(){
                if (runOnce) {
                    runOnce--;
                    submitClaim();
                }
            }, 2000)).appendTo('body');
        }

        function addLedgerItems () {
            if (+claim.items > 0) {
                debugLog('Claim ID ' + claim.id + ' has ' + claim.items + ' ledger transactions...');
                queued(prepareEForm)();
                return;
            }

            debugLog('Claim ID ' + claim.id + ' has no ledger transactions, adding one...');
            setCookie('tempforledgerentry', 1, 1);

            $.ajax({
                url: '/manage/insert_ledger_entries.php',
                type: 'post',
                data: { form: [ledgerItem], patientid: patient.id },
                dataType: 'text',
                success: queued(prepareEForm),
                error: onError
            });
        }

        function loginAs () {
            debugLog('Logging in as "' + doctor.username + '"...');

            $.ajax({
                url: '/manage/admin/login_as.php',
                type: 'post',
                data: { username: doctor.username, password: doctor.hash, loginsub: 1 },
                success: queued(addLedgerItems),
                error: onError
            })
        }

        function retrieveClaimRelatedData () {
            debugLog('Preparing (or retrieving) a pending claim for testing...');

            $.ajax({
                url: '/manage/admin/debug-webhook-handler.php',
                type: 'post',
                data: { 'retrieve-claim': true },
                dataType: 'json',
                success: function(data){
                    claim = data.claim;
                    doctor = data.doctor;
                    patient = data.patient;

                    debugLog('<a href="/manage/admin/diagnose-claim.php?claim_id=' +
                        claim.id +
                        '&amp;timeline=on" target="_blank">Claim ID ' +
                        claim.id +
                        ' Timeline <i class="fa fa-external-link"></i></a>');

                    queued(loginAs)();
                },
                error: onError
            })
        }

        $('#setup').click(function(){
            onStart();
            queued(retrieveClaimRelatedData)();
        });
    });
</script>
<pre id="debug-log"></pre>
<button id="setup" class="btn btn-primary interaction-lock">Run scenario</button>
<div class="row">
    <div class="col-md-5">5</div>
    <div class="col-md-7">
        <table class="table table-condensed table-hover table-striped">

        </table>
    </div>
</div>
<?php

require_once __DIR__ . '/includes/bottom.htm';
