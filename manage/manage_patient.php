<?php namespace Ds3\Libraries\Legacy; ?><?php
include('includes/top.htm');
// include('includes/constants.inc');
include('includes/formatters.php');

if(isset($_REQUEST["delid"])) {
    $del_sql = "delete from dental_patients where patientid='".$_REQUEST["delid"]."'";
    $db->query($del_sql);

    $msg= "Deleted Successfully";

    header("Location: " . $_SERVER['PHP_SELF'] . "?msg=" . $msg);
    trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 30;

if(isset($_REQUEST["page"]))
    $index_val = $_REQUEST["page"];
else
    $index_val = 0;

$i_val = $index_val * $rec_disp;

if(!isset($_REQUEST['sort']) || $_REQUEST['sort'] == ''){
    $_REQUEST['sort'] = 'lastname';
    $_REQUEST['sortdir'] = 'ASC';
}

$docId = intval($_SESSION['docid']);

$sql = '';

$sql_sort = "SELECT p.patientid, p.status, p.lastname, p.firstname, p.middlename, p.premedcheck, p.p_m_dss_file,
                    s.vob, s.ledger, s.patient_info FROM dental_patients p
             LEFT JOIN dental_patient_summary s ON p.patientid = s.pid ";

$sql_count = "SELECT count(*) as total_rec FROM dental_patients p";

$sql .= " WHERE p.docid='$docId'";
if(isset($_GET['pid'])) {
    $sql .= " AND p.patientid = ".$_GET['pid'];
}
if(!isset($_GET['sh']) || $_GET['sh']=='') {
    $sql .= " AND p.status = 1";
}
elseif($_GET['sh'] == 1 ) {
    $sql .= " AND p.status = 1";
}
elseif($_GET['sh'] == 2) {
    $sql .= " AND (p.status = 1 OR p.status = 2)";
}
elseif($_GET['sh'] == 3) {
    $sql .= " AND p.status = 2";
}
if(isset($_GET['letter'])) {
    $sql .= " AND p.lastname LIKE '".mysqli_real_escape_string($con, $_GET['letter'])."%' ";
}
if(isset($_REQUEST['sort'])) {
    if ($_REQUEST['sort'] == 'lastname') {
        $sql .= " ORDER BY p.lastname ".$_REQUEST['sortdir'].", p.firstname ".$_REQUEST['sortdir'];
    } elseif ($_REQUEST['sort'] == 'ledger') {
        //$sql .= " ORDER BY (ledger_amount + ledger2_amount - ledger_payment_amount - ledger2_payment_amount) ".$_REQUEST['sortdir'];
    } else  {
        //$sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
    }
}

$sql_sort .= $sql;
$sql_count .= $sql;

$total_rec = $db->getRow($sql_count)['total_rec'];

$no_pages = $total_rec/$rec_disp;

$sql_sort .= " limit ". $i_val.",".$rec_disp;
$my=$db->getResults($sql_sort);
$num_users=count($my);


?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage_patient.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
<div style="clear: both">
<span class="admin_head">
	Manage Patient <?php echo (isset($patient_info))?$patient_info:''; ?>
    -
	<select name="show" onchange="Javascript: window.location ='<?php echo $_SERVER['PHP_SELF'];?>?sh='+this.value;">
        <option value="1">Active Patients</option>
        <option value="2" <?php if(isset($_GET['sh'])){ if($_GET['sh'] == 2) echo " selected"; } ?> >All Patients</option>
        <option value="3" <?php if(isset($_GET['sh'])){ if($_GET['sh'] == 3) echo " selected"; } ?> >In-active Patients</option>
    </select>
</span>
    <!--<div align="right">
            <div style="float:left;margin-right:386px;width:140px;padding-left:4px;"><script type="text/javascript" language="JavaScript" src="script/find.js">
    </script>
    </div>

        <button onclick="Javascript: parent.location='add_patient.php';" class="addButton">
            Add New Patient
        </button>
        &nbsp;&nbsp;

        <button onclick="Javascript: loadPopup('print_patient.php?st=1');" class="addButton">
            Print Active Patient
        </button>
        &nbsp;&nbsp;

        <button onclick="Javascript: loadPopup('print_patient.php?st=2');" class="addButton">
            Print In-Active Patient
        </button>
        &nbsp;&nbsp;
    </div>-->
    <div class="letter_select">
        <?php
        $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        foreach($letters as $let){
            $class = (isset($_GET['letter']) && $_GET['letter']==$let) ? 'class="selected_letter"' : '';
            $sh = isset($_GET['sh']) ? $_GET['sh'] : '';
            echo '<a ' . $class . 'href="manage_patient.php?letter=' . $let . '&sh=' . $sh . '">' . $let . '</a> ';
        }
        if(isset($_GET['letter']) && $_GET['letter'] != ''){
            echo '<a href="manage_patient.php?sh=' . $_GET['sh'] . '">View All</a>';
        }
        ?>
    </div>
    </br>
    <?php
    if(isset($_GET['msg'])){
        ?>
        <div align="center" class="red">
            <b><?php echo $_GET['msg'];?></b>
        </div>
        <?php
    } ?>

</div>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" style="clear: both">
    <table id="patients" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <?php if($total_rec > $rec_disp) {?>
            <TR bgColor="#ffffff">
                <TD  align="right" colspan="15" class="bp">
                    Pages:
                    <?php
                    $letter = isset($_GET['letter']) ? $_GET['letter'] : '';
                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                    $sortdir = isset($_GET['sortdir']) ? $_GET['sortdir'] : '';
                    $sh = isset($_GET['sh']) ? $_GET['sh'] : '';
                    paging($no_pages,$index_val,"letter=". $letter ."&sort=". $sort ."&sortdir=". $sortdir ."&sh=". $sh );
                    ?>
                </TD>
            </TR>
        <?php }?>
        <tr class="tr_bg_h">
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'lastname')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=lastname&sortdir=<?php echo ($_REQUEST['sort']=='lastname'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Name</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'ready')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=ready&sortdir=<?php echo ($_REQUEST['sort']=='ready'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ready for Tx</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'pg2.date_scheduled')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=pg2.date_scheduled&sortdir=<?php echo ($_REQUEST['sort']=='pg2.date_scheduled'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Next Visit</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'last_completed')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=last_completed&sortdir=<?php echo ($_REQUEST['sort']=='last_completed'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Last Visit</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'last_segmentid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=last_segmentid&sortdir=<?php echo ($_REQUEST['sort']=='last_segmentid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Last Treatment</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'device')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=device&sortdir=<?php echo ($_REQUEST['sort']=='device'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Appliance</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'delivery_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=delivery_date&sortdir=<?php echo ($_REQUEST['sort']=='delivery_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Appliance Since</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'xb')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=vob&sortdir=<?php echo ($_REQUEST['sort']=='vob'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">VOB</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'rxlomn_order')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=rxlomn_order&sortdir=<?php echo ($_REQUEST['sort']=='rxlomn_order'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Rx./L.O.M.N.</a>
            </td>
            <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'ledger')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                <a href="manage_patient.php?<?php echo isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=ledger&sortdir=<?php echo ($_REQUEST['sort']=='ledger'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ledger</a>
            </td>
        </tr>
        <tr class="template" style="display:none;">
            <td class="patient_name">John Smith</td>
            <td class="flowsheet">No</td>
            <td class="next_visit">(4 days)</td>
            <td class="last_visit">1 yr 2 mo</td>
            <td class="last_treatment">Consult</td>
            <td class="appliance">TAP 3</td>
            <td class="appliance_since">63 days</td>
            <td class="vob">Complete</td>
            <td class="rxlomn">N/A</td>
            <td class="ledger">($435.75)</td>
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
            foreach ($my as $myarray)
            {
                $tr_class = $myarray['status'] == 1 ? "tr_active" : "tr_inactive";

                // No need this query - merged this query to the main query
                /*$summ_sql = "SELECT s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment, s.vob, s.ledger, s.patient_info
					FROM dental_patient_summary s WHERE s.pid='".mysqli_real_escape_string($con, $myarray["patientid"])."' LIMIT 1";
                $summ = $db->getRow($summ_sql);*/

                $patientid = mysqli_real_escape_string($con, $myarray['patientid']);

                $query = "SELECT
                        dp.p_m_dss_file,
                        dq3.allergenscheck,
                        pg2_info1.date_completed,
                        pg2_info1.segmentid,
                        (
                            SELECT date_scheduled
                            FROM dental_flow_pg2_info
                            WHERE appointment_type = 0 AND patientid = '$patientid'
                            LIMIT 1
                        ) AS date_scheduled,
                        exp5.dentaldevice,
                        exp5.dentaldevice_date,
                        exp5.device,
                        fpg.rxlomnrec,
                        fpg.lomnrec,
                        fpg.rxrec,
                        (
                            SELECT SUM(dl.amount) AS amount1
                            FROM dental_ledger dl
                            WHERE dl.docid = '$docId'
                                AND (dl.paid_amount IS NULL || dl.paid_amount = 0)
                                AND dl.patientid = '$patientid'
                            LIMIT 1
                        ) AS amount1,
                        dl2.amount2,
                        (
                            SELECT SUM(dlp.amount) amount3
                            FROM dental_ledger dl
                                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                            WHERE dl.docid='$docId'
                                AND dlp.amount IS NOT NULL
                                AND dlp.amount != 0
                                AND dl.patientid = '$patientid'
                            LIMIT 1
                        ) AS amount3,
                        dl2.amount4,
                        (
                            SELECT COUNT(*) as numsleepstudy
                            FROM dental_summ_sleeplab ss
                                JOIN dental_patients p on ss.patiendid=p.patientid
                            WHERE (
                                    p.p_m_ins_type != '1'
                                    OR (
                                        (ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '')
                                        AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != '')
                                    )
                                )
                                AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '')
                                AND (ss.filename!='' AND ss.filename IS NOT NULL)
                                AND ss.patiendid = '$patientid'
                        ) AS numsleepstudy
                    FROM dental_patients dp
                        LEFT JOIN dental_q_page3 dq3 ON dq3.patientid = dp.patientid
                        LEFT JOIN (
                            SELECT pg2_info.patientid, pg2_info.date_completed, pg2_info.segmentid
                            FROM dental_flow_pg2_info pg2_info
                            WHERE pg2_info.appointment_type=1 AND pg2_info.patientid = '$patientid'
                            ORDER BY pg2_info.date_completed DESC, pg2_info.id DESC
                            LIMIT 1
                        ) pg2_info1 ON 1
                        LEFT JOIN (
                            SELECT exp5.dentaldevice, exp5.dentaldevice_date, dd.device
                            FROM dental_ex_page5 exp5
                                LEFT JOIN dental_device dd ON dd.deviceid=exp5.dentaldevice
                            WHERE patientid = '$patientid'
                            LIMIT 1
                        ) exp5 ON 1
                        LEFT JOIN dental_flow_pg1 fpg ON fpg.pid=dq3.patientid
                        LEFT JOIN (
                            SELECT SUM(dl.amount) amount2, SUM(dl.paid_amount) amount4
                            FROM dental_ledger dl
                                LEFT JOIN dental_ledger_payment pay ON pay.ledgerid=dl.ledgerid
                            WHERE dl.docid = '$docId'
                                AND dl.paid_amount IS NOT NULL AND dl.paid_amount != 0
                                AND dl.patientid='$patientid'
                            LIMIT 1
                        ) dl2 ON 1
                    WHERE dp.patientid = '$patientid'
                    LIMIT 1";

                $additionalData = $db->getRow($query);

                ?>
                <tr class="<?php echo $tr_class;?> initial_list">
                    <td valign="top">
                        <a href="add_patient.php?pid=<?php echo $myarray["patientid"];?>&ed=<?php echo $myarray["patientid"];?>">
                            <?php
                            echo st($myarray["lastname"]) . ',&nbsp;
									' . st($myarray["firstname"]) . '&nbsp;
									' . (!empty($myarray["middlename"]) ? st($myarray["middlename"]) : "") . '</a>';


                            $allergen = $additionalData['allergenscheck'];

                            if($myarray["premedcheck"] == 1 || $allergen == 1) {
                                echo "&nbsp;&nbsp;&nbsp;<font style=\"font-weight:bold; color:#FF0000;\">*Med</font>";
                            }
                            ?>
                    </td>
                    <?php
                    if( $myarray['patient_info'] == 1 )
                    {
                        $last_completed = $additionalData['date_completed'];
                        $last_segmentid = $additionalData['segmentid'];
                        $next_scheduled = $additionalData['date_scheduled'];
                        $delivery_date = $additionalData['dentaldevice_date'];
                        $device = $additionalData['device'];

                        ?>

                        <td valign="top">
                            <?php

                            if($additionalData['p_m_dss_file']!='' && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE){
                                $ins_error = false;
                            }elseif($additionalData['p_m_dss_file']!=1){
                                $ins_error = true;
                            }else{
                                $ins_error = false;
                            }

                            $numsleepstudy = $additionalData['numsleepstudy'];

                            if($numsleepstudy == 0){
                                $study_error = true;
                            }else{
                                $study_error = false;
                            }
                            ?>
                            <a href="manage_flowsheet3.php?pid=<?php echo $myarray["patientid"];?>"><?php echo ((!$ins_error && !$study_error) ? "Yes" : "<span class=\"red\">No</span>"); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?php echo $myarray["patientid"];?>"><?php echo format_date($next_scheduled); ?></a>
                        </td>
                        <?php
                        $segments = array();
                        $segments[15] = "Baseline Sleep Test";
                        $segments[2] = "Consult";
                        $segments[4] = "Impressions";
                        $segments[7] = "Device Delivery";
                        $segments[8] = "Check / Follow Up";
                        $segments[10] = "Home Sleep Test";
                        $segments[3] = "Sleep Study";
                        $segments[11] = "Treatment Complete";
                        $segments[12] = "Annual Recall";
                        $segments[14] = "Not a Candidate";
                        $segments[5] = "Delaying Tx / Waiting";
                        $segments[9] = "Pt. Non-Compliant";
                        $segments[6] = "Refused Treatment";
                        $segments[13] = "Termination";
                        $segments[1] = "Initial Contact";
                        ?>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?php echo $myarray["patientid"];?>"><?php echo format_date($last_completed, true); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?php echo $myarray["patientid"];?>"><?php echo ($last_segmentid == null ? 'N/A' : $segments[$last_segmentid]); ?></a>
                        </td>
                        <td valign="top">
                            <a href="dss_summ.php?pid=<?php echo $myarray["patientid"];?>"><?php echo $device; ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_flowsheet3.php?pid=<?php echo $myarray["patientid"];?>"><?php echo format_date($delivery_date, true); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_insurance.php?pid=<?php echo $myarray["patientid"];?>"><?php echo ($myarray['vob'] == null ? 'No' : ($myarray['vob']==1 ? "Yes": $dss_preauth_status_labels[$myarray['vob']])); ?></a>
                        </td>
                        <td valign="top">
                            <a href="manage_insurance.php?pid=<?php echo $myarray["patientid"];?>">
                                <?php
                                if( $additionalData['rxlomnrec'] != null  || ( $additionalData['lomnrec'] != null && $additionalData['rxrec'] != null) ) {
                                    echo 'Yes';
                                } elseif( $additionalData['rxrec']!=null && $additionalData['lomnrec'] == null ) {
                                    echo 'Yes/No';
                                } elseif( $additionalData['lomnrec'] != null && $additionalData['rxrec'] == null ) {
                                    echo 'No/Yes';
                                } else {
                                    echo 'No';
                                }
                                ?>
                            </a>
                        </td>
                        <td valign="top">
                            <?php
                            $total = $additionalData['amount1'] + $additionalData['amount2'] - $additionalData['amount3'] - $additionalData['amount4'];
                            ?>
                            <a href="manage_ledger.php?pid=<?php echo $myarray["patientid"];?>"><?php echo ($myarray['ledger'] == null ? 'N/A' : format_ledger(number_format($total,0))); ?></a>
                            <?php
                            echo isset($total1) ? $total1 : '';
                            ?>
                        </td>
                        <?php
                    }else{
                        ?>
                        <td colspan="9" align="center" class="pat_incomplete">-- Patient Incomplete --</td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        }?>
    </table>
</form>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php include "includes/bottom.htm";?>
