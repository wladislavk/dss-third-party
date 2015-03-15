<?php namespace Ds3\Legacy; ?><?php 
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
?>

<html>
    <head>
        <script type="text/javascript" src="/manage/js/insert_ledger_entries.js"></script>
    </head>

    <body>
        <?php
            $i = (!empty($_COOKIE['tempforledgerentry']) ? $_COOKIE['tempforledgerentry'] : '');
            $d = 1;

            if (!isset($sqlinsertqry)) {
                $sqlinsertqry = '';
            }

            $sqlinsertqry .= "INSERT INTO `dental_ledger_payment` (
                `ledgerid` ,
                `payment_date` ,
                `entry_date` ,
                `amount` ,
                `payment_type` ,
                `payer`
                ) VALUES ";

            if (!empty($_POST['form'])) foreach($_POST['form'] as $form){
                $sqlinsertqry .= "(".$_POST['ledgerid'].", '".date('Y-m-d', strtotime($form['service_date']))."', '".date('Y-m-d', strtotime($form['entry_date']))."', '".str_replace(',','',$form['amount'])."', '".$form['payment_type']."', '".$form['payer']."'),";
            }

            $sqlinsertqry = substr($sqlinsertqry, 0, -1).";";
            $insqry = $db->query($sqlinsertqry);
            if (!$insqry) {
        ?>
                <script type="text/javascript">
                    alert('Could not add ledger payments, please close this window and contact your system administrator');
                    eraseCookie('tempforledgerentry');
                </script>                               
                <?php echo  $sqlinsertqry; ?>
        <?php
            } else {
        ?>
                <script type="text/javascript">
                    eraseCookie('tempforledgerentry');
                    alert('Payment(s) successfully added!');
                    parent.window.location = parent.window.location;
                </script>
        <?php
            }
        ?>
