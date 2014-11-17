<?php include "includes/top.htm"; ?>

    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup.js" type="text/javascript"></script>

    <span class="admin_head">
        Day Sheet
    </span>
    <br />

    <div align="center" class="red">
        <b><?php echo isset($_GET['msg']) ? $_GET['msg'] : '';?></b>
    </div>

    <table class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
            <th class="col_head">Type</th>
            <th class="col_head">Production</th>
            <th class="col_head">Collections</th>
            <th class="col_head">Adjustments</th>
            <th class="col_head">A.R. Impact</th>
        </tr>
        <tr>
            <td>Services</td>
            <?php
                if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])){
                    $start_date = $_REQUEST['start_date'];
                    $end_date = $_REQUEST['end_date'];
                }elseif(isset($_REQUEST['dailysub'])){
                    $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
                    $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
                }elseif(isset($_REQUEST['weeklysub'])){
                    $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
                    $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd']+6, $_REQUEST['d_yy']));
                }elseif(isset($_REQUEST['monthlysub'])){
                    $start_date = date('Y-m-01', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
                    $end_date = date('Y-m-t', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
                }elseif(isset($_REQUEST['rangesub'])){
                    $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['s_d_mm'], $_REQUEST['s_d_dd'], $_REQUEST['s_d_yy']));
                    $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['e_d_mm'], $_REQUEST['e_d_dd'], $_REQUEST['e_d_yy']));
                }else{
                    $start_date = false;
                    $end_date = false;
                }


                if(isset($_GET['pid'])){
                    $lpsql = " AND dl.patientid = '".$_GET['pid']."'";
                    $npsql = " AND n.patientid = '".$_GET['pid']."'";
                    $ipsql = " AND i.patientid = '".$_GET['pid']."'";
                }else{
                    $ipsql = $lpsql = $npsql= "";
                }

                if($start_date){
                    $l_date = " AND dl.service_date BETWEEN '".$start_date."' AND '".$end_date."'";
                    $n_date = " AND n.entry_date BETWEEN '".$start_date."' AND '".$end_date."'";
                    $i_date = " AND i.adddate  BETWEEN '".$start_date."' AND '".$end_date."'";
                    $p_date = " AND dlp.payment_date BETWEEN '".$start_date."' AND '".$end_date."'";
                    $newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";
                }else{
                    $p_date = $i_date = $n_date = $l_date = '';
                }

                $sql = "select 
                        sum(dl.amount) amount
                        from dental_ledger dl 
                        JOIN dental_patients as pat ON dl.patientid = pat.patientid
                        LEFT JOIN dental_users as p ON dl.producerid=p.userid 
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql." 
                        ".$l_date."
                        ";

                $r = $db->getRow($sql);
            ?>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <td>---</td>
            <td>---</td>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
        </tr>
        <tr>
            <td>Credit Payments</td>
            <?php
                $impact = 0;
                $sql = "SELECT
                    sum(dlp.amount) amount
                    from dental_ledger dl 
                    LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                    where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                    AND dlp.amount != 0
                    AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PRIMARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_SECONDARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PATIENT).")
                    AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_CREDIT)."'
                    ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td></td>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <?php
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_WRITEOFF).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_DISCOUNT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_CREDIT)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <td>$<?php echo  number_format($impact,2); ?></td>
        </tr>
        <tr>
            <td>Debit Payments</td>
            <?php
                $impact = 0;
                $sql = "select
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PRIMARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_SECONDARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PATIENT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_DEBIT)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td></td>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <?php
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_WRITEOFF).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_DISCOUNT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_DEBIT)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <td>$<?php echo  number_format($impact,2); ?></td>
        </tr>
        <tr>
            <td>Check Payments</td>
            <?php
                $impact = 0;
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PRIMARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_SECONDARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PATIENT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_CHECK)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td></td>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <?php
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_WRITEOFF).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_DISCOUNT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_CHECK)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <td>$<?php echo  number_format($impact,2); ?></td>
        </tr>
        <tr>
            <td>Cash Payments</td>
            <?php
                $impact = 0;
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PRIMARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_SECONDARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PATIENT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_CASH)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td></td>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <?php
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_WRITEOFF).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_DISCOUNT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_CASH)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <td>$<?php echo  number_format($impact,2); ?></td>
        </tr>
        <tr>
            <td>Write Off</td>
            <?php
                $impact = 0;
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PRIMARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_SECONDARY).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_PATIENT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_WRITEOFF)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td></td>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <?php
                $sql = "SELECT
                        sum(dlp.amount) amount
                        from dental_ledger dl 
                        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                        AND dlp.amount != 0
                        AND dlp.payer IN (".mysqli_real_escape_string($con, DSS_TRXN_PAYER_WRITEOFF).",".mysqli_real_escape_string($con, DSS_TRXN_PAYER_DISCOUNT).")
                        AND dlp.payment_type='".mysqli_real_escape_string($con, DSS_TRXN_PYMT_WRITEOFF)."'
                        ".$p_date."";

                $r = $db->getRow($sql);
                $impact += $r['amount'];
            ?>
            <td>$<?php echo  number_format($r['amount'],2); ?></td>
            <td>$<?php echo  number_format($impact,2); ?></td>
        </tr>
    </table>

    <div id="popupContact" style="width:750px;">
        <a id="popupContactClose">
            <button>X</button>
        </a>
        <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopup"></div>

    <br /><br />    
<?php include "includes/bottom.htm";?>