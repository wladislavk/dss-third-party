<?php namespace Ds3\Libraries\Legacy; ?><?php 
    include_once('admin/includes/main_include.php');
    include_once('includes/constants.inc');
    include("includes/sescheck.php");
    include_once('includes/authorization_functions.php');
    include_once('includes/claim_functions.php');
    include_once('admin/includes/invoice_functions.php');
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
    if( authorize((!empty($_POST['username']) ? $_POST['username'] : ''), (!empty($_POST['password']) ? $_POST['password'] : ''), DSS_USER_TYPE_ADMIN))
    {
        if ( !empty($_POST['form']) )
        {
            foreach($_POST['form'] as $form)
            {
                $insertMedicalCode = $form['procedure_code'] == '1' &&
                    $form['service_date'] != '' && $form['amount'] != '';

                $medicalCodeColumnsWithComma = $insertMedicalCode ? ', `modcode`, `modcode2`, `placeofservice`' : '';

                $sqlinsertqry = "INSERT INTO `dental_ledger` (  `ledgerid` ,
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

                if ($form['status']==DSS_TRXN_PENDING) 
                { 
                    $new_status = DSS_TRXN_PENDING;
                } else 
                {
                    $new_status = $form['status'];
                }

                if( $form['status']==1 )
                {
                    $pf_sql = "SELECT producer_files FROM dental_users WHERE userid='".mysqli_real_escape_string($con, $form['producer'])."'";
                        
                    $pf = $db->getRow($pf_sql);
                    if($pf['producer_files'] == '1') 
                    {
                        $claim_producer = $form['producer'];
                    } else 
                    {
                        $claim_producer = $_SESSION['docid'];
                    }

                    $s = "SELECT insuranceid from dental_insurance where producer='".$claim_producer."' AND patientid='".mysqli_real_escape_string($con, $_POST['patientid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
                        
                    $q = $db->getResults($s);
                    $n = count($q);
                    if($n > 0) 
                    {
                        $r = $q[0];
                        $claim_id = $r['insuranceid'];
                    } else
                    {
                        $claim_id = ClaimFormData::createPrimaryClaim($_POST['patientid'], $claim_producer);
                    }
                } else
                {
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
                if( $txcode['amount_adjust'] == DSS_AMOUNT_ADJUST_NEGATIVE )
                {
                    $amount = -1 * abs($form['amount']);
                } elseif($txcode['amount_adjust'] == DSS_AMOUNT_ADJUST_POSITIVE) 
                {
                    $amount = abs($form['amount']);
                } else 
                {
                    $amount = $form['amount'];
                }

                $_POST['patientid'] = mysqli_real_escape_string($con, $_POST['patientid']);
                $_SESSION['userid'] = mysqli_real_escape_string($con, $_SESSION['userid']);
                $_SESSION['docid'] = mysqli_real_escape_string($con, $_SESSION['docid']);
                $_SERVER['REMOTE_ADDR'] = mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR']);
                $txcode['transaction_code'] = mysqli_real_escape_string($con, $txcode['transaction_code']);
                $txcode['description'] = mysqli_real_escape_string($con, $txcode['description']);

                if($d <= $i)
                {
                    if($form['status']==1) 
                    {
                        $form_claim_id = $claim_id;
                    } else 
                    {
                        $form_claim_id = '';
                    }


                    // This particular insertion requires extra column values
                    if ($insertMedicalCode) {
                        $query_ins = "( NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, '".str_replace(',','', $amount)."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."', '{$txcode['modifier_code_1']}', '{$txcode['modifier_code_2']}', '{$txcode['place_service']}')";
                    } elseif( $form['procedure_code'] == '2' && $form['service_date'] != '' && $form['amount'] != '' || $form['procedure_code'] == '3' && $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."')";
                    } elseif( $form['procedure_code'] == '6' && $form['proccode'] == '100' && $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                )";
                    } elseif( $form['procedure_code'] == '6' && $form['proccode'] != '100' && $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                )";
                    } elseif( $form['service_date'] != '' && $form['amount'] != '' )
                    {
                        $query_ins = "(
                            NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                )";
                    }

                    if( !empty($query_ins) ) {
                        $sqlinsertqry .= $query_ins;
                        $ins_id = $db->getInsertId($sqlinsertqry);
                        if (strtolower($txcode['transaction_code']) == 'e0486') {
                            invoice_add_e0486('1', $_SESSION['docid'], $ins_id, DSS_INVOICE_TYPE_BC_FO);
                        }
                    }
                } elseif( $d == $i )
                {
                    $descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_code='".$form['proccode']."' LIMIT 1;";
                        
                    $descquery = $db->getResults($descsql);
                    if ($descquery) 
                    {
                        foreach ($descquery as $txcode)
                        {
                            if( $form['procedure_code'] == '1' && $form['service_date'] != '' && $form['amount'] != '' ) 
                            {
                                $service_date = $form['service_date'];
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($service_date))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, '".str_replace(',','', $amount)."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['procedure_code'] == '2' && $form['service_date'] != '' && $form['amount'] != '' || $form['procedure_code'] == '3' && $form['service_date'] != '' && $form['amount'] != '' )
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['procedure_code'] == '6' && $form['proccode'] == '100' && $form['service_date'] != '' && $form['amount'] != '' )
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['procedure_code'] == '6' && $form['proccode'] != '100' && $form['service_date'] != '' && $form['amount'] != '')
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".str_replace(',','', $amount)."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            } elseif( $form['service_date'] != '' && $form['amount'] != '' )
                            {
                                $sqlinsertqry .= "(
                                    NULL , '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$new_status."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form['producer']."', '".$form_claim_id."'
                                    )";
                            }
                            $d++;
                        }
                    }
                }
            }
        }
	            
        claim_history_update((!empty($claim_id) ? $claim_id : ''), $_SESSION['userid'], '');

        if( empty($ins_id) )
        {
?>
<script type="text/javascript">
    alert('Could not add ledger entries, please close this window and contact your system administrator');
    eraseCookie('tempforledgerentry');
    parent.window.location = parent.window.location;
</script>
<?php
        } else 
        {
?>
<script type="text/javascript">
    eraseCookie('tempforledgerentry');
    alert('Transaction(s) successfully added!');
    parent.window.location = parent.window.location;
</script>
<?php
        }
    } else 
    { 
        //NOT AUTHORIZED
?>
<script type="text/javascript">
    alert('YOU ARE NOT AUTHORIZED TO COMPLETE THIS REQUEST');
    history.go(-1);
</script>
<?php
    }
?>
</body>
</html>
