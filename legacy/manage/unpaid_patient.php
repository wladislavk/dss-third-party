<?php
namespace Ds3\Libraries\Legacy;

if (!isset($_GET['print'])) {
    include "includes/top.htm";
} else {
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include_once('includes/constants.inc');
    include_once('admin/includes/access.php');
    ?>
    <html>
    <body>
    <?php
}

$rec_disp = 200;

if(!empty($_REQUEST["page"])) {
    $index_val = $_REQUEST["page"];
} else {
    $index_val = 0;
}

$db = new Db();

$docId = intval($_SESSION['docid']);
$dbType = $db->escape( DSS_TRXN_TYPE_ADJ);

$sql = "SELECT
        SUM(dl.amount) AS amount, SUM(dl.paid_amount) AS paid_amount,
        a.amount AS adjusted_amount,
        p.firstname, p.lastname, p.patientid
    FROM dental_ledger dl
        JOIN dental_patients p ON p.patientid=dl.patientid
        LEFT JOIN dental_transaction_code tc ON (tc.transaction_code = dl.transaction_code AND tc.docid=$docId)
        LEFT JOIN (
            SELECT patientid, SUM(paid_amount) amount
            FROM dental_ledger
                LEFT JOIN dental_transaction_code tc2 ON
                    (tc2.transaction_code = dental_ledger.transaction_code AND tc2.docid=$docId)
           WHERE tc2.type='$dbType'
           GROUP BY patientid
        ) a ON a.patientid=dl.patientid
    WHERE dl.docid=$docId AND (tc.type != '$dbType' OR tc.type IS NULL)
    GROUP BY dl.patientid
    ORDER BY p.lastname ASC";
$my = $db->getResults($sql);

$num_users = count($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
    Unpaid Patient Report
    (<i><?php echo date('m/d/Y'); ?></i>)
</span>
<div align="right">
    <button onclick="window.location='ledger_reportfull.php';" class="addButton">
       Daily Ledger
    </button>
    &nbsp;&nbsp;
    <button onclick="window.location='unpaid_patient.php?print';" class="addButton">
        Print
    </button>
    &nbsp;&nbsp;
    <button onclick="window.location='ledger_unpaid_statements.php';" class="addButton">
        Print All Statements
    </button>
    &nbsp;&nbsp;
</div>
<br />
<br />
<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <?php if(!empty($total_rec) && $total_rec > $rec_disp) {?>
    <tr bgColor="#ffffff">
        <td align="right" colspan="15" class="bp">
            Pages:
            <?php paging($no_pages,$index_val,""); ?>
        </td>
    </tr>
    <?php }?>
    <tr class="tr_bg_h">
        <td valign="top" class="col_head">
            Patient
        </td>
        <td valign="top" class="col_head" width="10%">
            0 Days
        </td>
        <td valign="top" class="col_head" width="10%">
            30 Days
        </td>
        <td valign="top" class="col_head" width="10%">
            60 Days
        </td>
        <td valign="top" class="col_head" width="10%">
            90 Days
        </td>
        <td valign="top" class="col_head" width="10 %">
          120+ Days
        </td>
        <td valign="top" class="col_head" width="10%">
            Charges
        </td>
        <td valign="top" class="col_head"  width="10%">
            Credits
        </td>
        <td valign="top" class="col_head" width="10%">
            Adjustments
        </td>
        <td valign="top" class="col_head"  width="10%">
            Pt. Balance
        </td>
    </tr>
    <?php if ($num_users == 0) { ?>
        <tr class="tr_bg">
            <td valign="top" class="col_head" colspan="10" align="center">
                No Records
            </td>
        </tr>
        <?php
    } else {
        $tot_charges = 0;
        $tot_credit = 0;
        $tot_adjusted = 0;
        $charges_cur = 0;
        $charges_30 = 0;
        $charges_60 = 0;
        $charges_90 = 0;
        $charges_120 = 0;

    if (count($my)) {
        foreach ($my as $myarray) {
            $pay_sql = "SELECT sum(pay.amount) as paid_amount
                FROM dental_ledger dl
                JOIN dental_patients p ON p.patientid=dl.patientid
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid
                WHERE dl.docid='".$_SESSION['docid']."'
                AND p.patientid='".$myarray['patientid']."'
                GROUP BY dl.patientid";
            $pay_r = $db->getRow($pay_sql);

            $paid_amount = $myarray['paid_amount'] + $pay_r['paid_amount'];
            if (round($myarray['amount'], 2) != round($paid_amount + $myarray['adjusted_amount'], 2)) {
                $pat_credits_total = $paid_amount + $myarray['adjusted_amount'];
                $seg_sql = "SELECT
                    sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount,
                    p.firstname, p.lastname, p.patientid
                    FROM dental_ledger dl
                    JOIN dental_patients p ON p.patientid=dl.patientid
                    WHERE dl.docid='".$_SESSION['docid']."'
                    AND p.patientid='".$myarray['patientid']."'
                    AND dl.service_date > DATE_SUB(NOW(), INTERVAL 30 day)
                    GROUP BY dl.patientid";
                $seg_q = mysqli_query($con, $seg_sql);
                $seq_r = mysqli_fetch_assoc($seg_q);

                $pat_cur_owed = $seq_r['amount'];

                $seg_sql = "SELECT
                    sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount,
                    p.firstname, p.lastname, p.patientid
                    FROM dental_ledger dl
                    JOIN dental_patients p ON p.patientid=dl.patientid
                    WHERE dl.docid='".$_SESSION['docid']."'
                    AND p.patientid='".$myarray['patientid']."'
                    AND dl.service_date <= DATE_SUB(NOW(), INTERVAL 30 day)
                    AND dl.service_date > DATE_SUB(NOW(), INTERVAL 60 day)
                    GROUP BY dl.patientid";
                $seq_r = $db->getRow($seg_sql);

                $pat_30_owed = $seq_r['amount'];

                $seg_sql = "SELECT
                    sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount,
                    p.firstname, p.lastname, p.patientid
                    FROM dental_ledger dl
                    JOIN dental_patients p ON p.patientid=dl.patientid
                    WHERE dl.docid='".$_SESSION['docid']."'
                    AND p.patientid='".$myarray['patientid']."'
                    AND dl.service_date <= DATE_SUB(NOW(), INTERVAL 60 day)
                    AND dl.service_date > DATE_SUB(NOW(), INTERVAL 90 day)
                    GROUP BY dl.patientid";
                $seq_r = $db->getRow($seg_sql);

                $pat_60_owed = $seq_r['amount'];

                $seg_sql = "SELECT
                    sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount,
                    p.firstname, p.lastname, p.patientid
                    FROM dental_ledger dl
                    JOIN dental_patients p ON p.patientid=dl.patientid
                    WHERE dl.docid='".$_SESSION['docid']."'
                    AND p.patientid='".$myarray['patientid']."'
                    AND dl.service_date <= DATE_SUB(NOW(), INTERVAL 90 day)
                    AND dl.service_date > DATE_SUB(NOW(), INTERVAL 120 day)
                    GROUP BY dl.patientid";
                $seq_r = $db->getRow($seg_sql);

                $pat_90_owed = $seq_r['amount'];

                $seg_sql = "SELECT
                    sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount,
                    p.firstname, p.lastname, p.patientid
                    FROM dental_ledger dl
                    JOIN dental_patients p ON p.patientid=dl.patientid
                    WHERE dl.docid='".$_SESSION['docid']."'
                    AND p.patientid='".$myarray['patientid']."'
                    AND dl.service_date < DATE_SUB(NOW(), INTERVAL 120 day)
                    GROUP BY dl.patientid";
                $seq_r = $db->getRow($seg_sql);

                $pat_120_owed = $seq_r['amount'];
                $pat_credits = $pat_credits_total;
                $pat_90 = $pat_90_owed;
                $pat_60 = $pat_60_owed;
                $pat_30 = $pat_30_owed;
                $pat_cur = $pat_cur_owed;

                if ($pat_120_owed > $pat_credits){ //patient paid less than their 120+ day total
                    $pat_120 = $pat_120_owed - $pat_credits;
                } else {
                    if ($pat_90_owed == 0 AND $pat_60_owed == 0 AND $pat_30_owed == 0 AND $pat_cur_owed == 0){ //no charges after 120 days
                        $pat_120 = $pat_120_owed - $pat_credits;
                    } else {
                        $pat_credits = $pat_credits - $pat_120_owed;
                        $pat_120 = 0;
                        if ($pat_90_owed > $pat_credits){  //patient paid less than their 90 day total
                            $pat_90 = $pat_90_owed - $pat_credits;
                        } else {
                            if ($pat_60_owed == 0 AND $pat_30_owed == 0 AND $pat_cur_owed == 0){ // no charges after 90 days
                                $pat_90 = $pat_90_owed - $pat_credits;
                            } else {
                                $pat_credits = $pat_credits - $pat_90_owed;
                                $pat_90 = 0;
                                if ($pat_60_owed > $pat_credits){  //patient paid less than their 60 day total
                                    $pat_60 = $pat_60_owed - $pat_credits;
                                } else {
                                    if ($pat_30_owed == 0 AND $pat_cur_owed == 0){// no charges after 60 days
                                        $pat_60 = $pat_60_owed - $pat_credits;
                                    } else {
                                        $pat_credits = $pat_credits - $pat_60_owed;
                                        $pat_60 = 0;
                                        if ($pat_30_owed > $pat_credits){ //patient paid less than their 30 day total
                                            $pat_30 = $pat_30_owed - $pat_credits;
                                        } else {
                                            if ($pat_cur_owed == 0){ // no charges after 30 days
                                                $pat_30 = $pat_30_owed - $pat_credits;
                                            } else {
                                                $pat_credits = $pat_credits - $pat_30_owed;
                                                $pat_30 = 0;
                                                $pat_cur = $pat_cur_owed - $pat_credits;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $charges_cur += $pat_cur;
                $charges_30 += $pat_30;
                $charges_60 += $pat_60;
                $charges_90 += $pat_90;
                $charges_120 += $pat_120;

                $tr_class = "tr_active";
                ?>
                <tr class="<?=$tr_class;?>">
                    <td valign="top">
                        <a href="manage_ledger.php?addtopat=1&pid=<?=$myarray['patientid'];?>"><?=st($myarray['lastname'].", ".$myarray['firstname']);?> (Click to View)</a>
                    </td>
                    <td>
                        <?php echo "$".number_format($pat_cur,2); ?>
                    </td>
                    <td>
                        <?php echo "$".number_format($pat_30,2); ?>
                    </td>
                    <td>
                        <?php echo "$".number_format($pat_60,2); ?>
                    </td>
                    <td>
                        <?php echo "$".number_format($pat_90,2); ?>
                    </td>
                    <td>
                        <?php echo "$".number_format($pat_120,2); ?>
                    </td>
                    <td align="right" width="10%">
                        <?php
                        echo "$".number_format($myarray["amount"],2);
                        $tot_charges += $myarray["amount"];
                        ?>
                        &nbsp;
                    </td>
                    <td align="right">
                        <?php if(st($paid_amount) != 0) { ?>
                            <?=number_format(st($paid_amount),2);?>
                            <?php
                            $tot_credit += st($paid_amount);
                        } ?>
                        &nbsp;
                    </td>
                    <td align="right">
                        <?php if(st($myarray['adjusted_amount']) <> 0) {?>
                            <?=number_format(st($myarray['adjusted_amount']),2);?>
                            <?php
                            $tot_adjusted += st($myarray['adjusted_amount']);
                        } ?>
                    </td>
                    <td>
                        &nbsp;
                        <?php if ($myarray["amount"] > ($paid_amount + $myarray['adjusted_amount'])) { ?>
                            <?= number_format(($myarray["amount"]-$paid_amount-$myarray['adjusted_amount']),2); ?>
                        <?php } elseif($myarray["amount"] < $paid_amount) { ?>
                            <span style="color:#070;">(<?= number_format((abs($myarray["amount"]-$paid_amount-$myarray['adjusted_amount'])),2); ?>)</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
        }
    }
    }
  ?>
    <tr>
      <td valign="top" align="left">
        <b>Totals</b>
      </td>
                        <td valign="top" align="left">
                                <b>
                                <?php echo "$".number_format($charges_cur,2); ?>
                                &nbsp;
                                </b>
                        </td>
                        <td valign="top" align="left">
                                <b>
                                <?php echo "$".number_format($charges_30,2);?>
                                &nbsp;
                                </b>
                        </td>
                        <td valign="top" align="left">
                                <b>
                                <?php echo "$".number_format($charges_60,2); ?>
                                &nbsp;
                                </b>
                        </td>
                        <td valign="top" align="left">
                                <b>
                                <?php echo "$".number_format($charges_90,2);?>
                                &nbsp;
                                </b>
                        </td>
                        <td valign="top" align="left">
                                <b>
                                <?php echo "$".number_format($charges_120,2);?>
                                &nbsp;
                                </b>
                        </td>
      <td valign="top" align="right">
        <b>
            <?php echo "$".number_format($tot_charges,2); ?>
            &nbsp;
        </b>
        </td>
        <td valign="top" align="right">
            <b>
                <?php echo "$".number_format($tot_credit,2);?>
                &nbsp;
            </b>
        </td>
        <td valign="top" align="right">
            <b>
                <?php echo "$".number_format($tot_adjusted,2);?>
                &nbsp;
            </b>
        </td>
        <td valign="top">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td valign="top" colspan="7" align="right">
            <b>Balance</b>
        </td>
        <td align="right">
            <b>
                <?php echo "$".number_format(($tot_charges - $tot_credit - $tot_adjusted),2);?>
                &nbsp;
            </b>
        </td>
        <td colspan="2"> </td>
    </tr>
</table>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php if (!isset($_GET['print'])) {
    include "includes/bottom.htm";
} ?>
