<?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include_once('includes/constants.inc');
?>

<html>
    <body>

    <link rel="stylesheet" href="css/ledger.css" />

<?php if($_REQUEST['dailysub'] != 1 && $_REQUEST['monthlysub'] != 1 && $_REQUEST['weeklysub'] != 1 && $_REQUEST['rangesub'] != 1 && $_GET['pid'] == '') { ?>
        <script type="text/javascript">
            window.location = 'ledger.php';
        </script>
<?php
       die();
    }

    if(!isset($_REQUEST['sort'])){
        $_REQUEST['sort'] = 'service_date';
        $_REQUEST['sortdir'] = 'asc';
    }

    if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])){
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
    }elseif($_REQUEST['dailysub']){
        $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy'])); 
        $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
    }elseif($_REQUEST['weeklysub']){
        $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
        $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd']+6, $_REQUEST['d_yy']));
    }elseif($_REQUEST['monthlysub']){
        $start_date = date('Y-m-01', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
        $end_date = date('Y-m-t', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
    }elseif($_REQUEST['rangesub']){
        $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['s_d_mm'], $_REQUEST['s_d_dd'], $_REQUEST['s_d_yy']));
        $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['e_d_mm'], $_REQUEST['e_d_dd'], $_REQUEST['e_d_yy']));
    }else{
        $start_date = false;
        $end_date = false;
    }

    $rec_disp = 200;

    if($_REQUEST["page"] != "") {
        $index_val = $_REQUEST["page"];
    } else {
        $index_val = 0;
    }
    
    $i_val = $index_val * $rec_disp;

    if(isset($_GET['pid'])){
        $sql = "select * from dental_ledger where patientid='".$_GET['pid']."' "; 
    }else{
        $sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' ";
    }

    $sql .= " order by service_date";

    $total_rec = $db->getNumberRows($sql);
    $no_pages = $total_rec/$rec_disp;

    $sql .= " limit ".$i_val.",".$rec_disp.";";
    $my = $db->getResults($sql);
    $num_users = count($my);
?>
    <span class="admin_head">
        Ledger Report
            <?php if($_REQUEST['dailysub'] == 1) { ?>
                (<i><?php echo  date('m-d-Y', strtotime($start_date)); ?></i>)
            <?php }
                if($_REQUEST['weeklysub'] == 1 || $_REQUEST['rangesub'] == 1) {
            ?>
                (<i><?php echo  date('m-d-Y', strtotime($start_date))?> - <?php echo  date('m-d-Y', strtotime($end_date))?></i>)
            <?php }
                if($_REQUEST['monthlysub'] == 1) { 
            ?>
                (<i><?php echo  date('m-Y', strtotime($start_date)) ?></i>)
            <?php }
                if($_GET['pid'] <> '') {
            ?>
                (<i><?php echo $thename;?></i>)
            <?php } ?>
       Reconciliation 
    </span>
    <div>
        <br />
        <div align="center" class="red">
            <b><?php echo $_GET['msg'];?></b>
        </div>
        <table class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
            <tr class="tr_bg_h">
                <td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                    <a href="report_reconciliation.php?dailysub=<?php echo $_REQUEST['dailysub'];?>&monthlysub=<?php echo $_REQUEST['monthlysub'];?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo $_REQUEST['rangesub'];?>&weeklysub=<?php echo $_REQUEST['weeklysub'];?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=service_date&sortdir=<?php echo ($_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
                </td>
                <td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                    <a href="report_reconciliation.php?dailysub=<?php echo $_REQUEST['dailysub'];?>&monthlysub=<?php echo $_REQUEST['monthlysub'];?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo $_REQUEST['rangesub'];?>&weeklysub=<?php echo $_REQUEST['weeklysub'];?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=entry_date&sortdir=<?php echo ($_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
                </td>
                <td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                    <a href="report_reconciliation.php?dailysub=<?php echo $_REQUEST['dailysub'];?>&monthlysub=<?php echo $_REQUEST['monthlysub'];?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo $_REQUEST['rangesub'];?>&weeklysub=<?php echo $_REQUEST['weeklysub'];?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=patient&sortdir=<?php echo ($_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
                </td>
                <td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                    <a href="report_reconciliation.php?dailysub=<?php echo $_REQUEST['dailysub'];?>&monthlysub=<?php echo $_REQUEST['monthlysub'];?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo $_REQUEST['rangesub'];?>&weeklysub=<?php echo $_REQUEST['weeklysub'];?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=producer&sortdir=<?php echo ($_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer</a>
                </td>
                <td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
                    <a href="report_reconciliation.php?dailysub=<?php echo $_REQUEST['dailysub'];?>&monthlysub=<?php echo $_REQUEST['monthlysub'];?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo $_REQUEST['rangesub'];?>&weeklysub=<?php echo $_REQUEST['weeklysub'];?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
                </td>
                <td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                    <a href="report_reconciliation.php?dailysub=<?php echo $_REQUEST['dailysub'];?>&monthlysub=<?php echo $_REQUEST['monthlysub'];?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo $_REQUEST['rangesub'];?>&weeklysub=<?php echo $_REQUEST['weeklysub'];?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=paid_amount&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits</a>
                </td>
                <td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
                    <a href="report_reconciliation.php?dailysub=<?php echo $_REQUEST['dailysub'];?>&monthlysub=<?php echo $_REQUEST['monthlysub'];?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo $_REQUEST['rangesub'];?>&weeklysub=<?php echo $_REQUEST['weeklysub'];?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
                </td>
            </tr>
            <?php if($num_users == 0) { ?>
                <tr class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            <?php } else {
                $tot_charges = 0;
                $tot_credit = 0;
                if(isset($_GET['pid'])) {
                    $newquery = "SELECT dl.*, dp.firstname, dp.middlename, dp.lastname, p.name FROM dental_ledger as dl INNER JOIN dental_patients as dp ON dl.patientid = dp.patientid LEFT JOIN dental_users p ON p.userid=dl.producerid WHERE  dl.docid='".$_SESSION['docid']."' AND dl.patientid = '".$_GET['pid']."'";
                } else {
                    $newquery = "SELECT dl.*, dp.firstname, dp.middlename, dp.lastname, p.name FROM dental_ledger as dl INNER JOIN dental_patients as dp ON dl.patientid = dp.patientid LEFT JOIN dental_users p ON p.userid=dl.producerid WHERE  dl.docid='".$_SESSION['docid']."'";
                }

                if(isset($_GET['pid'])) {
                    $newquery = "SELECT * FROM dental_ledger WHERE  docid='".$_SESSION['docid']."' AND `patientid` = '".$_GET['pid']."'";
                }else{
                    $newquery = "SELECT * FROM dental_ledger WHERE `docid` = '".$_SESSION['docid']."'";
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

                $newquery = "select 
                            'ledger',
                            dl.ledgerid,
                            dl.service_date,
                            dl.entry_date,
                            CONCAT(p.first_name,' ',p.last_name) as name,
                            dl.description,
                            dl.amount,
                            sum(pay.amount) as paid_amount,
                            dl.status,
                            dl.patientid,
                            dl.primary_claim_id
                            from dental_ledger dl 
                            LEFT JOIN dental_users p ON dl.producerid=p.userid 
                            LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
                            where dl.docid='".$_SESSION['docid']."' ".$lpsql." ".$l_date." 
                            GROUP BY dl.ledgerid
                            UNION
                            select 
                            'note',
                            n.id,
                            n.service_date,
                            n.entry_date,
                            concat('Note - ', p.first_name, ' ', p.last_name),
                            n.note,
                            '',
                            '',
                            n.private,
                            n.patientid,
                            ''      
                            from dental_ledger_note n
                            LEFT JOIN dental_users p on n.producerid=p.userid
                            where n.docid='".$_SESSION['docid']."' AND (n.private IS NULL or n.private=0) ".$npsql." ".$n_date." 
                            UNION
                            select
                            'claim',
                            i.insuranceid,
                            i.adddate,
                            i.adddate,
                            'Claim',
                            'Insurance Claim',
                            (select sum(dl2.amount) FROM dental_ledger dl2
                            INNER JOIN dental_insurance i2 on dl2.primary_claim_id=i2.insuranceid
                            where i2.insuranceid=i.insuranceid),
                            sum(pay.amount),
                            i.status,
                            i.patientid,
                            ''
                            from dental_insurance i
                            LEFT JOIN dental_ledger dl ON dl.primary_claim_id=i.insuranceid
                            LEFT JOIN dental_ledger_payment pay on dl.ledgerid=pay.ledgerid
                            where i.docid='".$_SESSION['docid']."' ".$ipsql." ".$i_date." 
                            GROUP BY i.insuranceid
                            ";

                $newquery = "select 
                            'ledger',
                            dl.ledgerid,
                            dl.service_date,
                            dl.entry_date,
                            dl.amount,
                            dl.paid_amount,
                            dl.status, 
                            dl.description,
                            CONCAT(p.first_name,' ',p.last_name) as name,
                            pat.patientid,
                            pat.firstname, 
                            pat.lastname,
                            '' as payer,
                            '' as payment_type,
                            dl.primary_claim_id
                            from dental_ledger dl 
                            JOIN dental_patients as pat ON dl.patientid = pat.patientid
                            LEFT JOIN dental_users as p ON dl.producerid=p.userid 
                            where dl.docid='".$_SESSION['docid']."' ".$lpsql." 
                            ".$l_date."
                            UNION
                            select 
                            'ledger_payment',
                            dlp.id,
                            dlp.payment_date,
                            dlp.entry_date,
                            '',
                            dlp.amount,
                            '',
                            '',
                            CONCAT(p.first_name,' ',p.last_name),
                            pat.patientid,
                            pat.firstname,
                            pat.lastname,
                            dlp.payer,
                            dlp.payment_type,
                            ''
                            from dental_ledger dl 
                            JOIN dental_patients pat on dl.patientid = pat.patientid
                            LEFT JOIN dental_users p ON dl.producerid=p.userid 
                            LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                            where dl.docid='".$_SESSION['docid']."' ".$lpsql."
                            AND dlp.amount != 0
                            ".$p_date."
                            ";

                if($_REQUEST['dailysub'] || $_REQUEST['weeklysub'] || $_REQUEST['monthlysub'] || $_REQUEST['rangesub'])
                   //$newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";
    
                if(isset($_REQUEST['sort'])){
                    if($_REQUEST['sort']=='patient'){
                        $newquery .= " ORDER BY lastname ".$_REQUEST['sortdir'].", dp.firstname ".$_REQUEST['sortdir'];
                    }elseif($_REQUEST['sort']=='producer'){
                        $newquery .= " ORDER BY name ".$_REQUEST['sortdir'];
                    }else{
                        $newquery .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];   
                    }
                }

                $runquery = $db->getResults($newquery);
                if ($runquery) foreach ($runquery as $myarray) {
                    if($myarray['paid_amount'] > 0){
                        $pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";

                        $pat_myarray = $db->getRow($pat_sql);
                        $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
            
                        if($myarray["status"] == 1) {
                            $tr_class = "tr_active";
                        } else {
                            $tr_class = "tr_inactive";
                        }
                        $tr_class = "tr_active";
            ?>
                        <tr onclick="window.location = 'manage_ledger.php?pid=<?php echo  $myarray['patientid']; ?>'" class="clickable_row <?php echo $tr_class;?> <?php echo  $myarray['ledger']; ?>">
                            <td valign="top" width="10%">
                                <?php echo date('m-d-Y',strtotime(st($myarray["service_date"])));?>
                            </td>
                            <td valign="top" width="10%">
                                <?php echo date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
                            </td>
                            <td valign="top" width="10%">
                                <?php echo st($name);?>
                            </td>
                            <td valign="top" width="10%">
                                <?php echo st($myarray["name"]);?>
                            </td>
                            <td valign="top" width="30%">
                                <?php if($myarray['ledger'] == 'ledger_payment') { ?>
                                    <?php echo  $dss_trxn_payer_labels[$myarray['payer']]; ?> Payment - <?php echo  $dss_trxn_pymt_type_labels[$myarray['payment_type']]; ?>
                                <?php } else { ?>
                                    <?php echo st($myarray["description"]);?>
                                    <?php echo  ($myarray['primary_claim_id'])?" (".$myarray['primary_claim_id'].")":'';?>
                                <?php } ?>
                            </td>
                            <td valign="top" align="right" width="10%">
                                <?php if(st($myarray["paid_amount"]) <> 0) { ?>
                                    <?php echo number_format(st($myarray["paid_amount"]),2);?>
                                <?php 
                                    $tot_credit += st($myarray["paid_amount"]);
                                   }
                                ?>
                                &nbsp;
                            </td>
                            <td valign="top" width="5%">&nbsp;
                                <?php if($myarray[0] == 'ledger'){
                                    echo $dss_trxn_status_labels[$myarray["status"]];
                                }elseif($myarray[0] == 'claim'){
                                    echo $dss_claim_status_labels[$myarray["status"]];
                                }
                    }
                            ?>          
                            </td>
                        </tr>
    <?php 
                }
            }
    ?> 
                        <tr>
                            <td valign="top" colspan="5" align="right">
                                <b>Total</b>
                            </td>
                            <td valign="top" align="right">
                                <b>
                                <?php echo "$".number_format($tot_credit,2); ?>
                                &nbsp;
                                </b>
                            </td>
                            <td valign="top">&nbsp;</td>
                        </tr>
        </table>