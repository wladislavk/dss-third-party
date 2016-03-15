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

function retrieveClaim ($claimId) {
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

    $andClaimConditional = $claimId ? "AND insuranceid = '$claimId'" : "AND status = '0'";

    $claimId = $db->getColumn("SELECT insuranceid
        FROM dental_insurance
        WHERE docid = '$docId'
            AND patientid = '$patientId'
            $andClaimConditional
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
            'reference' => "ECLAIM-$claimId-" . uniqid(),
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
    retrieveClaim($_POST['claim-id']);
}

if (isset($_POST['set-reference'])) {
    setReference($_POST['claim-id'], $_POST['reference-id']);
}

require_once __DIR__ . '/includes/top.htm';

?>
<style type="text/css">
    table.webhook-list {
        table-layout: fixed;
    }

    pre {
        max-height: 200px;
        overflow: auto;
    }

    #model-menu, #model-tab {
        display: none;
    }

    #webhook-tabs, #webhook-menu {
        max-height: 700px;
        overflow: auto;
    }
</style>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
<script>
    function setCookie (name, value, days) {
        var expires = '';

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));

            expires = "; expires=" + date.toGMTString();
        }

        document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    }

    function pad (number, positions) {
        positions = positions || 2;
        return ['000000', number].join('').substr(-positions);
    }

    function niceTime () {
        var now = new Date(),
            time = [pad(now.getHours()), pad(now.getMinutes()), pad(now.getSeconds())].join(':');

        return time + '.' + pad(now.getMilliseconds(), 3);
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
        debugLog('Starting...');
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
            debugLog('Event sent: "' + (webHook.event || webHook.status || 'unnamed') + '"');

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

    function printClaim () {
        debugLog('Printing claim to change status to Sent...');

        $.ajax({
            url: '/manage/insurance_v2.php?insid=' + claim.id + '&pid=' + patient.id,
            type: 'post',
            data: { insurancesub: 1, ex_pagebtn: 1 },
            success: onFinish,
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
            success: onFinish,
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
            onFinish();
            return;
        }

        debugLog('Claim ID ' + claim.id + ' has no ledger transactions, adding one...');
        setCookie('tempforledgerentry', 1, 1);

        $.ajax({
            url: '/manage/insert_ledger_entries.php',
            type: 'post',
            data: { form: [ledgerItem], patientid: patient.id },
            dataType: 'text',
            success: onFinish,
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
            data: { 'retrieve-claim': true, 'claim-id': $('#claim-id').val() },
            dataType: 'json',
            success: function(data){
                claim = data.claim;
                doctor = data.doctor;
                patient = data.patient;

                $('#claim-id').val(claim.id);

                debugLog('<a href="/manage/admin/diagnose-claim.php?claim_id=' +
                    claim.id +
                    '&amp;timeline=on" target="_blank">Claim ID ' +
                    claim.id +
                    ' Timeline <i class="fa fa-external-link"></i></a>');

                debugLog('<a href="/manage/manage_ledger.php?pid=' + patient.id + '" target="_blank">' +
                    'View Ledger <i class="fa fa-external-link"></i></a>');

                debugLog('<a href="/manage/view_claim.php?claimid=' + claim.id + '&pid=' + patient.id +
                    '" target="_blank">View Claim <i class="fa fa-external-link"></i></a>');

                queued(loginAs)();
            },
            error: onError
        })
    }

    var webHookList = <?= webHookEvents() ?>;

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

    jQuery(function($){
        var $menu = $('ul#webhook-menu'),
            $modelItem = $menu.find('#model-menu'),
            $tabs = $('div#webhook-tabs')
            $modelTab = $tabs.find('#model-tab');

        for (var eventType in webHookList) {
            var $newItem = $modelItem.clone();
            $newItem.removeAttr('id').find('a').attr('href', '#tab-' + eventType).text(eventType);
            $menu.append($newItem);

            var $newTab = $modelTab.clone();
            $newTab.attr('id', 'tab-' + eventType);
            $tabs.append($newTab);

            var $table = $newTab.find('table');

            for (var n in webHookList[eventType]) {
                var name = eventType + '-' + n,
                    $row = $('<tr>' +
                        '<td>' +
                            '<a href="#' + name + '" name="' + name + '" class="interaction-lock" ' +
                                'data-event-type="' + eventType + '" data-id="' + n + '" ' +
                                'title="Send this webhook">' +
                                '<i class="fa fa-upload" />' +
                            '</a>' +
                        '</td>' +
                        '<td><code /></td><td><pre/></td>' +
                    '</tr>');

                $row.find('code').text(eventType);
                $row.find('pre').text(JSON.stringify(webHookList[eventType][n], null, 2));

                $table.append($row);
            }
        }

        $menu.find('>li:eq(1)').addClass('active');
        $tabs.find('>div:eq(1)').addClass('active');

        $('#setup').click(function(){
            onStart();
            queued(retrieveClaimRelatedData)();
        });

        $('#send').click(function(){
            onStart();
            queued(prepareEForm)();
        });

        $('#print').click(function(){
            onStart();
            queued(printClaim)();
        });

        $tabs.find('a[name]').click(function(){
            var $this = $(this),
                eventType = $this.data('event-type'),
                n = $this.data('id');

            sendWebHook(webHookList[eventType][n]);
            return false;
        });
    });
</script>
<a class="btn btn-primary" data-toggle="collapse" href="#frontend-explanation">
    Usage explanation
</a>
<a class="btn btn-info pull-right" data-toggle="collapse" href="#backend-explanation">
    Inner workings explanation
</a>
<a class="btn btn-primary" data-toggle="collapse" href="#flow-guide">
    List of Eligible status changes
</a>
<div class="collapse lead" id="frontend-explanation">
    <ol>
        <li>Select a <code>claimId</code> (or leave the field and the script will select/generate one automatically)</li>
        <li>Click "Prepare scenario" to retrieve all the information needed</li>
        <li>Click "E-File claim" if the claim has not been sent before (required to have a valid Reference ID in the DB)</li>
        <li>Click "Print claim" to set the claim status as Sent (only if required)</li>
        <li>Click on any of the claim events at the bottom, to simulate an Eligible event, for this claim</li>
        <li>
            The Reference ID will be set dynamically for each claim/session pair. Reload the page and remember your
            claimId to send events with different Reference ID to the same claim
        </li>
    </ol>
</div>
<div class="collapse lead" id="backend-explanation">
    <p>This script will retrieve (or generate) a claim to post Eligible events.</p>
    <p>
        <strong>Important:</strong> The script uses "login as", thus any FO session will be overwritten with
        the new permissions.
    </p>
    <p>The restrictiones are the following:</p>
    <ul>
        <li>The doctor that will appear as the creator will be <code>doc1f</code> or <code>doc1</code></li>
        <li>The patient will be the first doctor's patient whose first name is <code>Test</code></li>
        <li>
            If <strong>no</strong> claim id is specified, the script will try to retrieve the first Primary Pending claim for those
            given <code>docId</code> and <code>patientId</code>
        </li>
        <li>
            If a claim id is specified, the script will try to retrieve it, only if the corresponding
            <code>docId</code> and <code>patientId</code> match
        </li>
        <li>A new claim will be created if no claim is found in the previous steps</li>
        <li>If the returned claim has no ledger transactions, the script will attempt to add one transaction</li>
        <li>
            Transactions <strong>may not link</strong> to the returned claim, and will link to the most recent
            Primary Pending claim instead
        </li>
    </ul>
</div>
<div class="collapse" id="flow-guide">
    <ul>
        <li><code>claim_created</code>: Claim passed Eligible's validator.</li>
        <li><code>claim_submitted</code>: Claim passed Payer's validator.</li>
        <li><code>claim_received</code>: Claim received by Payer.</li>
        <li><code>claim_rejected</code>: Claim reviewed and rejected by Payer.</li>
        <li><code>claim_accepted</code>: Adjudication process starts.</li>
        <li><code>claim_paid</code>: Adjudication complete, claim paid.</li>
        <li><code>claim_denied</code>: Adjudication complete, claim denied.</li>
        <li><code>claim_pended</code>: Adjudication not complete, claim requires new information.</li>
    </ul>
</div>
<pre id="debug-log"></pre>
<input type="text" id="claim-id" class="form-control input-sm input-inline" name="claim-id" value="0"
    title="Claim to retrieve, zero to generate as needed" />
<button id="setup" class="btn btn-danger interaction-lock">Prepare scenario</button>
<button id="send" class="btn btn-primary interaction-lock">E-File claim</button>
<button id="print" class="btn btn-primary interaction-lock" title="Send Print action to change the status to Sent">
    Print claim
</button>
<h2 class="lead">Events</h2>
<div class="row">
    <ul id="webhook-menu" class="nav nav-tabs col-md-2" role="tablist">
        <li id="model-menu" role="presentation"><a href="#tab-model" role="tab" data-toggle="tab"></a></li>
    </ul>
    <div id="webhook-tabs" class="tab-content col-md-10">
        <div id="model-tab" role="tabpanel" class="tab-pane">
            <table class="table table-striped table-condensed table-hover webhook-list">
                <colgroup>
                    <col width="40px" />
                    <col width="150px" />
                    <col />
                </colgroup>
            </table>
        </div>
    </div>
</div>
<?php

require_once __DIR__ . '/includes/bottom.htm';
