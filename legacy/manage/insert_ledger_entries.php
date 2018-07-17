<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include_once 'includes/constants.inc';
include "includes/sescheck.php";
include_once 'includes/claim_functions.php';
include_once 'admin/includes/invoice_functions.php';
require_once ROOT_DIR . '/manage/admin/includes/claim_functions.php';
?>
<html>
<head>
    <script type="text/javascript" src="/manage/js/insert_ledger_entries.js"></script>
</head>
<body>
<br /><br />
<?php
$i = (!empty($_COOKIE['tempforledgerentry']) ? $_COOKIE['tempforledgerentry'] : '');
$d = 1;

$db = new Db();

if ( !empty($_POST['form']) ) {
    foreach($_POST['form'] as $form) {
        $insertMedicalCode = $form['procedure_code'] == '1' && $form['service_date'] != '' && $form['amount'] != '';
        $medicalCodeColumnsWithComma = $insertMedicalCode ? ', `modcode`, `modcode2`, `placeofservice`' : '';
        $sqlinsertqry = "INSERT INTO `dental_ledger` (`ledgerid` ,
                                                        `patientid` ,
                                                        `service_date` ,
                                                        `entry_date` ,
                                                        `description` ,
                                                        `producer` ,
                                                        `amount` ,
                                                        `transaction_type` ,
                                                        `paid_amount` ,
                                                        `userid` ,
                                                        `docid` ,
                                                        `status` ,
                                                        `adddate` ,
                                                        `ip_address` ,
                                                        `transaction_code`,
                                                        `producerid`,
                                                        `primary_claim_id`
                                                        $medicalCodeColumnsWithComma
                                                        ) VALUES ";

        if ($form['status'] == DSS_TRXN_PENDING) {
            $new_status = DSS_TRXN_PENDING;
        } else {
            $new_status = $form['status'];
        }

        if ($form['status'] == 1) {
            $pf_sql = "SELECT producer_files FROM dental_users WHERE userid='".$db->escape( $form['producer'])."'";

            $pf = $db->getRow($pf_sql);
            if ($pf['producer_files'] == '1') {
                $claim_producer = $form['producer'];
            } else {
                $claim_producer = $_SESSION['docid'];
            }

            $s = "SELECT insuranceid from dental_insurance where producer='".$claim_producer."' AND patientid='".$db->escape( $_POST['patientid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";

            $q = $db->getResults($s);
            $n = count($q);
            if ($n > 0) {
                $r = $q[0];
                $claim_id = $r['insuranceid'];
            } else {
                $claim_id = ClaimFormData::createPrimaryClaim($_POST['patientid'], $claim_producer);
            }
        } else {
            $claim_id = '';
        }

        // Prepare to insert transaction code modifiers
        $descsql = "SELECT
                code.description,
                code.transaction_code,
                code.amount_adjust,
                code.modifier_code_1,
                code.modifier_code_2,
                place.place_service
            FROM dental_transaction_code code
                LEFT JOIN dental_place_service place ON place.place_serviceid = code.place
            WHERE code.transaction_codeid = '{$form['proccode']}' LIMIT 1;";

        $txcode = $db->getRow($descsql);
        if ($txcode['amount_adjust'] == DSS_AMOUNT_ADJUST_NEGATIVE) {
            $amount = -1 * abs($form['amount']);
        } elseif ($txcode['amount_adjust'] == DSS_AMOUNT_ADJUST_POSITIVE) {
            $amount = abs($form['amount']);
        } else {
            $amount = $form['amount'];
        }

        $patientId = (int)$_POST['patientid'];
        $userId = (int)$_SESSION['userid'];
        $docId = (int)$_SESSION['docid'];
        $remoteIp = $db->escape($_SERVER['REMOTE_ADDR']);
        $transactionCode = $db->escape($txcode['transaction_code']);
        $transactionDescription = $db->escape($txcode['description']);

        if ($d <= $i) {
            $form_claim_id = 0;
            if ($form['status'] == 1) {
                $form_claim_id = (int)$claim_id;
            }
            $amount = (float)str_replace(',', '', $amount);
            $values = [
                'ledgerid' => 'NULL',
                'patientid' => $patientId,
                'service_date' => "'" . date('Y-m-d', strtotime($form['service_date'])) . "'",
                'entry_date' => "'" . date('Y-m-d', strtotime($form['entry_date'])) . "'",
                'description' => "'$transactionDescription'",
                'producer' => 'NULL',
                'amount' => 'NULL',
                'transaction_type' => 'None',
                'paid_amount' => 'NULL',
                'userid' => $userId,
                'docid' => $docId,
                'status' => "'" . $db->escape($new_status) . "'",
                'adddate' => "'" . date('Y-m-d') . "'",
                'ip_address' => "'$remoteIp'",
                'transaction_code' => "'$transactionCode'",
                'producerid' => (int)$form['producer'],
                'primary_claim_id' => $form_claim_id,
            ];
            // This particular insertion requires extra column values
            if ($insertMedicalCode) {
                $values = array_merge($values, [
                    'transaction_type' => 'Charge',
                    'amount' => $amount,
                    'adddate' => "'" . date('Y-m-d', strtotime($form['entry_date'])) . "'",
                    'modcode' => "'" . $db->escape($txcode['modifier_code_1']) . "'",
                    'modcode2' => "'" . $db->escape($txcode['modifier_code_2']) . "'",
                    'placeofservice' => "'" . $db->escape($txcode['place_service']) . "'",
                ]);
                $query_ins = join(', ', $values);
            } elseif ($form['procedure_code'] == '2' && $form['service_date'] != '' && $form['amount'] != '' || $form['procedure_code'] == '3' && $form['service_date'] != '' && $form['amount'] != '') {
                $values = array_merge($values, [
                    'transaction_type' => 'Credit',
                    'paid_amount' => $amount,
                ]);
                $query_ins = join(', ', $values);
            } elseif ($form['procedure_code'] == '6' && $form['proccode'] == '100' && $form['service_date'] != '' && $form['amount'] != '') {
                $values = array_merge($values, [
                    'transaction_type' => 'Debit-Prod Adj',
                    'paid_amount' => $amount,
                ]);
                $query_ins = join(', ', $values);
            } elseif ($form['procedure_code'] == '6' && $form['proccode'] != '100' && $form['service_date'] != '' && $form['amount'] != '') {
                $values = array_merge($values, [
                    'transaction_type' => 'Credit-Coll Adj',
                    'paid_amount' => $amount,
                ]);
                $query_ins = join(', ', $values);
            } elseif ($form['service_date'] != '' && $form['amount'] != '' ) {
                $query_ins = join(', ', $values);
            }

            if (!empty($query_ins)) {
                $sqlinsertqry .= $query_ins;
                $ins_id = $db->getInsertId($sqlinsertqry);
                if (strtolower($txcode['transaction_code']) == 'e0486') {
                    invoice_add_e0486('1', $_SESSION['docid'], $ins_id);
                }
            }
        }
    }
}

claim_history_update((!empty($claim_id) ? $claim_id : ''), $_SESSION['userid'], '');

if (empty($ins_id)) {
    ?>
    <script type="text/javascript">
        alert('Could not add ledger entries, please close this window and contact your system administrator');
        eraseCookie('tempforledgerentry');
        parent.window.location = parent.window.location;
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        eraseCookie('tempforledgerentry');
        alert('Transaction(s) successfully added!');
        parent.window.location = parent.window.location;
    </script>
    <?php
}
?>
</body>
</html>
