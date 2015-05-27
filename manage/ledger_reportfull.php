<?php 
include "includes/top.htm";

$rec_disp = 200;

if(!empty($_REQUEST["page"]))
    $index_val = $_REQUEST["page"];
else
    $index_val = 0;
    
$i_val = $index_val * $rec_disp;

$sql = "select dl.*, p.name from dental_ledger AS dl LEFT JOIN dental_users as p ON dl.producerid=p.userid where dl.docid='".$_SESSION['docid']."'";

if (
    (empty($_POST['dailysub']) || $_POST['dailysub'] != 1) &&
    (empty($_POST['monthlysub']) && $_POST['monthlysub'] != 1)
) {
    $sessionDocId = intval($_SESSION['docid']);
    $sql = "
        SELECT
            'ledger'         AS ledger,
            dl.ledgerid      AS ledgerid,
            dl.service_date  AS service_date,
            dl.entry_date    AS entry_date,
            dl.amount        AS amount,
            dl.paid_amount   AS paid_amount,
            dl.status        AS status,
            dl.description   AS description,
            CONCAT(p.first_name, ' ', p.last_name) AS name,
            pat.patientid    AS patientid,
            pat.firstname    AS firstname,
            pat.lastname     AS lastname,
            ''               AS payer,
            ''               AS payment_type
        FROM dental_ledger dl
            JOIN dental_patients AS pat ON dl.patientid = pat.patientid
            LEFT JOIN dental_users AS p ON dl.producerid = p.userid
        WHERE dl.docid = $sessionDocId
            AND dl.service_date = CURDATE()
            AND (dl.paid_amount IS NULL || dl.paid_amount = 0)
        GROUP BY dl.ledgerid

    UNION

        SELECT
            'ledger_paid'    AS ledger,
            dl.ledgerid      AS ledgerid,
            dl.service_date  AS service_date,
            dl.entry_date    AS entry_date,
            dl.amount        AS amount,
            dl.paid_amount   AS paid_amount,
            dl.status        AS status,
            dl.description   AS description,
            CONCAT(p.first_name, ' ', p.last_name) AS name,
            pat.patientid    AS patientid,
            pat.firstname    AS firstname,
            pat.lastname     AS lastname,
            tc.type          AS payer,
            ''               AS payment_type
        FROM dental_ledger dl
            JOIN dental_patients AS pat ON dl.patientid = pat.patientid
            LEFT JOIN dental_users AS p ON dl.producerid = p.userid
            LEFT JOIN dental_transaction_code tc
                ON tc.transaction_code = dl.transaction_code
                AND tc.docid = $sessionDocId
        WHERE dl.docid = $sessionDocId
            AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
            AND dl.service_date = CURDATE()

    UNION

        SELECT
            'ledger_payment' AS ledger,
            dlp.id           AS ledgerid,
            dlp.payment_date AS service_date,
            dlp.entry_date   AS entry_date,
            ''               AS amount,
            dlp.amount       AS paid_amount,
            ''               AS status,
            ''               AS description,
            CONCAT(p.first_name ,' ', p.last_name) AS name,
            pat.patientid    AS patientid,
            pat.firstname    AS firstname,
            pat.lastname     AS lastname,
            dlp.payer        AS payer,
            dlp.payment_type AS payment_type
        FROM dental_ledger dl
            JOIN dental_patients pat ON dl.patientid = pat.patientid
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid = dl.ledgerid
        WHERE dl.docid = $sessionDocId
            AND dlp.amount != 0
            AND dlp.payment_date = CURDATE()
    ";
}

if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'service_date';
  $_REQUEST['sortdir'] = 'desc';
} 

if(isset($_REQUEST['sort'])){
  if($_REQUEST['sort']=='producer'){
    $sql .= " ORDER BY name ".$_REQUEST['sortdir'];
  }elseif($_REQUEST['sort']=='patient'){
    $sql .= " ORDER BY lastname ".$_REQUEST['sortdir'];
  }elseif($_REQUEST['sort']=='paid_amount'){
    $sql .= " ORDER BY paid_amount ".$_REQUEST['sortdir'];
  }else{
    $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
  }
}
$my = $db->getResults($sql);

/*
$sql .= " order by service_date";

$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;
*/

$num_users = count($my);

//echo $sql; 
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
    Today's Ledger Report
    <?php if(!empty($_POST['dailysub']) && $_POST['dailysub'] == 1){ ?>
        (<i><?php echo $_POST['d_mm']?>-<?php echo $_POST['d_dd']?>-<?php echo $_POST['d_yy']?></i>)
    <?php }
    
    if(!empty($_POST['monthlysub']) && $_POST['monthlysub'] == 1){ ?>
        (<i><?php echo $_POST['d_mm']?>-<?php echo $_POST['d_yy']?></i>)
    <?php }
    
    if(!empty($_GET['pid']))
    {?>
        (<i><?php echo $thename;?></i>)
    <?php }?>

    <?php if((empty($_POST['dailysub']) || $_POST['dailysub'] != 1) && (empty($_POST['monthlysub']) || $_POST['monthlysub'] != 1)){ ?>
       (<i><?php echo  date('m/d/Y'); ?></i>)
    <?php } ?>

</span>

<br />
<div align="right">
    <a href="report_claim_aging.php" class="addButton">
        Claim Aging
    </a>
&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="print_ledger_reportfull.php?dailysub=<?php echo (!empty($_POST['dailysub']) ? $_POST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_POST['monthlysub']) ? $_POST['monthlysub'] : '');?>&d_mm=<?php echo (!empty($_POST['d_mm']) ? $_POST['d_mm'] : '');?>&d_dd=<?php echo (!empty($_POST['d_dd']) ? $_POST['d_dd'] : '');?>&d_yy=<?php echo (!empty($_POST['d_yy']) ? $_POST['d_yy'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>" target="_blank" class="addButton">
        Print Ledger
    </a>
        &nbsp;&nbsp;&nbsp;&nbsp;
    <button onclick="Javascript:window.location='ledger.php';" class="addButton"> 
        Other Reports
    </button>
        &nbsp;&nbsp;&nbsp;&nbsp;
    <button onclick="Javascript:window.location='unpaid_patient.php';" class="addButton">
           Unpaid Pt. 
    </button>
        &nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <? if(!empty($total_rec) && $total_rec > $rec_disp) {?>
    <TR bgColor="#ffffff">
        <TD  align="right" colspan="15" class="bp">
            Pages:
            <?php
                paging($no_pages,$index_val,"");
            ?>
        </TD>        
    </TR>
    <?php }?>
    <tr class="tr_bg_h">
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
            <a href="ledger_reportfull.php?sort=service_date&sortdir=<?php echo ($_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
        </td>
        <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
            <a href="ledger_reportfull.php?sort=entry_date&sortdir=<?php echo ($_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
            <a href="ledger_reportfull.php?sort=patient&sortdir=<?php echo ($_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
            <a href="ledger_reportfull.php?sort=producer&sortdir=<?php echo ($_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
            <a href="ledger_reportfull.php?sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
            <a href="ledger_reportfull.php?sort=amount&sortdir=<?php echo ($_REQUEST['sort']=='amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Charges</a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
            <a href="ledger_reportfull.php?sort=paid_amount&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits</a>
        </td>
        <td valign="top" class="col_head" width="10%">
            Adjustments
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
            <a href="ledger_reportfull.php?sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
        </td>
    </tr>
    <?php if($num_users == 0)
    { ?>
    <tr class="tr_bg">
        <td valign="top" class="col_head" colspan="10" align="center">
            No Records
        </td>
    </tr>
    <?php
    }
    else
    {

        $tot_charges = 0;
        $tot_credit = 0;
        $tot_adj = 0;

        foreach ($my as $myarray) {

            $pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
            $pat_myarray = $db->getRow($pat_sql);
            
            $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
            
            if($myarray["status"] == 1)
            {
                $tr_class = "tr_active";
            }
            else
            {
                $tr_class = "tr_inactive";
            }
            $tr_class = "tr_active";
        ?>
    <tr class="<?php echo $tr_class;?>">
        <td valign="top" width="10%">
            <?php echo date('m-d-Y',strtotime(st($myarray["service_date"])));?>
        </td>
        <td valign="top" width="10%">
            <?php echo date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
        </td>
        <td valign="top" width="10%">
            <a href="manage_ledger.php?pid=<?php echo $myarray['patientid']; ?>&addtopat=1"><?php echo st((!empty($pat_myarray['lastname']) ? $pat_myarray['lastname'] : '').", ".(!empty($pat_myarray['firstname']) ? $pat_myarray['firstname'] : ''));?></a>
        </td>
        <td valign="top" width="10%">
            <?php echo st($myarray['name']);?>
        </td>
        <td valign="top" width="30%">
            <?php echo  (($myarray['ledger'] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; ?>
        <?php echo  (($myarray['ledger'] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; ?>
        <?php echo  (($myarray['ledger'] == 'ledger'))?$myarray["description"]:'';?>
        <?php echo $myarray["description"];?>
        </td>
        <td valign="top" align="right" width="10%">
        <?php

            if($myarray['ledger'] == 'ledger'){
                if($myarray["amount"] <> 0){
                    echo number_format($myarray["amount"],2);
                    $tot_charges += $myarray["amount"];
                }
            }
        ?>
            &nbsp;
        </td>
            <?php if($myarray['ledger'] == 'ledger_paid' && $myarray['payer']==DSS_TRXN_TYPE_ADJ){ ?>
        <td>
        </td>
            <?php
                if($myarray['ledger']!='claim'){
                $tot_adj += st($myarray["paid_amount"]);
                }
            } ?>
        <td valign="top" align="right" width="10%">
            <?php if(st($myarray["paid_amount"]) <> 0) {?>
                <?php echo number_format(st($myarray["paid_amount"]),2);?>
            <? 
            }?>
            &nbsp;
        </td>
            <?php if(!($myarray['ledger'] == 'ledger_paid' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){ 
                if($myarray['ledger']!='claim'){
                    $tot_credit += st($myarray["paid_amount"]);
                }
            ?>
        <td></td>
            <?php } ?>
        <td valign="top" width="5%">&nbsp;
            <?php if($myarray["status"] == 1){
                echo "Sent";
            }elseif($myarray["status"] == 2){
                echo "Filed";
            }else{
                echo "Pend";
            }
            //$tot_credit += st($myarray["paid_amount"]);
        }?>         
        </td>
    </tr>
    <?php } ?> 
      
    <tr>
        <td valign="top" colspan="5" align="right">
            <b>Totals</b>
        </td>
        <td valign="top" align="right">
        
        <?php
            if(isset($_GET['pid'])){
                $ledgerquery = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." AND `transaction_type` = 'Charge'";
                $ledgerquery2 = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." and `transaction_type`='Credit'";
            }else{
                $ledgerquery = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." AND `transaction_type` = 'Charge'";
                $ledgerquery2 = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." and `transaction_type`='Credit'";
            }

            $myarray = $db->getRow($ledgerquery);
            $myarray2 = $db->getRow($ledgerquery2);

            if (!isset($cur_bal)) {
                $cur_bal = 0;
            }

            if(st($myarray["amount"]) <> 0) {
                $cur_bal += st($myarray["amount"]);
            }

            $i = 0;

            if (!isset($ledgerres2)) {
                $ledgerres2 = array();
            }

            if($i < count($ledgerres2)){
                $cur_bal2 = $myarray2['paid_amount'];
            }
            $i++;

            if (!isset($cur_bal2)) {
                $cur_bal2 = 0;
            }

            $cur_balfinal = $cur_bal - $cur_bal2;
            ?>

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
                <?php echo "$".number_format($tot_adj,2);?>
                &nbsp;
            </b>
        </td>
        <td valign="top">&nbsp;
            
        </td>
    </tr>
    <tr>
        <td valign="top" colspan="5" align="right">
            <b>Balance</b>
        </td>
        <td align="right">
            <b>
                <?php echo "$".number_format(($tot_charges - $tot_credit - $tot_adj),2);?>
                &nbsp;
            </b>
        </td>
        <td colspan="2">
        </td>
    </tr>
</table>

<?php include 'ledger_summary_reportfull.php'; ?>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />    
<? include "includes/bottom.htm";?>
