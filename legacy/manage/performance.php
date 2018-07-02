<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once "includes/constants.inc";
?>
<link rel="stylesheet" type="text/css" href="css/performance.css">

<div style="clear:both;"></div>
<?php

if (isset($_REQUEST['start_date'])) {
    $start_date = date('Y-m-d', strtotime($_REQUEST['start_date']));
    $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
} else {
    $start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-30, date('Y')));
    $end_date = date('Y-m-d');
}

$db = new Db();

$sql = "SELECT du.*, count(s.id) AS num_screened 
    FROM dental_users du 
    LEFT JOIN dental_screener s ON du.userid = s.docid AND s.adddate BETWEEN '" . $start_date . "' AND '" . $end_date . "'
    WHERE du.userid='" . $db->escape( $_SESSION['docid']) . "' 
    GROUP BY du.userid";
$myarray = $db->getRow($sql);
?>

<span class="admin_head">
    Performance
</span>
<br /><br /><br />

<form method="post" style="margin-left: 20px;">
    Start Date:
    <input type="text" id="start_date" name="start_date" class="calendar" value="<?php echo  date('m/d/Y', strtotime($start_date)); ?>" />
    End Date:
    <input type="text" id="end_date" name="end_date" class="calendar" value="<?php echo  date('m/d/Y', strtotime($end_date)); ?>" />
    <input type="submit" value="Filter" />
</form>

<br /><br />

<div class="half">
    <h3>Number of Consults/Impressions</h3>
    <?php include 'report_treatment_summary.php'; ?>
</div>
<div class="half">
  <h3>Patients Screened</h3>
  <?php include 'report_patients_screened.php'; ?>
</div>
<div class="half clear">
    <h3>Letters Sent</h3>
    <?php include 'report_letter_count.php'; ?>
</div>
<div class="half clear" >
    <h3>Date Range Ledger Report Cumulative Totals</h3>
    <?php include 'report_ledger_totals.php'; ?>
</div>
<div class="half">
    <h3>Date Range Ledger Report Daily</h3>
    <?php include 'report_ledger_daily.php'; ?>
</div>
<div class="data">
    <label>Username</label>
    <span class="value"><?php echo  $myarray['username']; ?></span>
</div>
<?php
$co_sql = "SELECT c.name 
    FROM companies c 
    JOIN dental_user_company uc ON uc.companyid = c.id
    WHERE uc.userid='".$myarray['userid']."'";
$co_r = $db->getRow($co_sql);

$company = $co_r['name'];

$screen_sql = "SELECT u.username, COUNT(s.id) AS num_screened 
    FROM dental_screener s 
    JOIN dental_users u ON u.userid=s.userid
    WHERE s.docid='".$myarray['userid']."' 
    AND s.adddate BETWEEN '".$start_date."' AND '".$end_date."' 
    group by u.username
";
$screen_q = $db->getResults($screen_sql);

$sleepstudies = "SELECT count(ss.id) as num_ss
    FROM dental_summ_sleeplab ss
    JOIN dental_patients p on ss.patiendid = p.patientid
    WHERE (
        p.p_m_ins_type != '1'
        OR (
            COALESCE(ss.diagnosising_doc, '') != ''
            AND COALESCE(ss.diagnosising_npi, '') != ''
        )
    )
    AND COALESCE(ss.diagnosis, '') != ''
    AND ss.completed = 'Yes'
    AND ss.filename IS NOT NULL
    AND p.docid = '".$myarray['userid']."'
    AND COALESCE(
        STR_TO_DATE(ss.date, '%m/%d/%Y'),
        STR_TO_DATE(ss.date, '%m/%d/%y'),
        STR_TO_DATE(ss.date, '%Y%m%d'),
        STR_TO_DATE(ss.date, '%m-%d-%Y'),
        STR_TO_DATE(ss.date, '%m-%d-%y'),
        STR_TO_DATE(ss.date, '%m%d%Y'),
        STR_TO_DATE(ss.date, '%m%d%y')
    ) BETWEEN '$start_date' AND '$end_date'
";
$ss = $db->getRow($sleepstudies);

$consult_sql = "SELECT count(i.id) as num_consult 
    FROM dental_flow_pg2_info i
    JOIN dental_patients p ON p.patientid = i.patientid
    WHERE i.segmentid=2
    AND p.docid='".$db->escape( $myarray['userid'])."'
    AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$consult = $db->getRow($consult_sql);

$imp_sql = "SELECT count(i.id) as num_imp 
    FROM dental_flow_pg2_info i
    JOIN dental_patients p ON p.patientid = i.patientid
    WHERE i.segmentid=4
    AND p.docid='".$db->escape( $myarray['userid'])."'
    AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$imp = $db->getRow($imp_sql);

$letters_sql = "SELECT count(l.letterid) as num_sent 
    FROM dental_letters l 
    WHERE l.docid='".$db->escape( $myarray['userid'])."'
    AND l.date_sent BETWEEN '".$start_date."' AND '".$end_date."'";
$letters = $db->getRow($letters_sql);

$vob_sql = "SELECT count(p.id) as num_completed 
    FROM dental_insurance_preauth p
    WHERE p.doc_id='".$db->escape( $myarray['userid'])."'
    AND p.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$vob = $db->getRow($vob_sql);
?>
<div class="data">
    <label>Company</label>
    <span class="value"><?php echo  $company; ?></span>
</div>
<div class="data">
    <label>Name</label>
    <span class="value"><?php echo  $myarray['name']; ?></span>
</div>
<div class="data">
    <label>Pt. Screened</label>
    <span class="value"><?php echo  $myarray['num_screened']; ?></span>
</div>
<div class="data">
    <label>By user</label>
    <span class="value">
        <?php
        if (count($screen_q)) {
            foreach ($screen_q as $screen) {
                echo $screen['username']." - ".$screen['num_screened']."<br />";
            }
        }
        ?>
    </span>
</div>
<div class="data">
    <label>Completed Sleep Studies</label>
    <span class="value"><?php echo  $ss['num_ss']; ?></span>
</div>
<div class="data">
    <label>Consult</label>
    <span class="value"><?php echo  $consult['num_consult']; ?></span>
</div>
<div class="data">
    <label>Impressions</label>
    <span class="value"><?php echo  $imp['num_imp']; ?></span>
</div>
<div class="data">
    <label>Letters Sent</label>
    <span class="value"><?php echo  $letters['num_sent']; ?></span>
</div>
<div class="data">
    <label>VOBs Completed</label>
    <span class="value"><?php echo  $vob['num_completed']; ?></span>
</div>
<div class="data">
    <label>Ins. Claims Sent</label>
    <span class="value"></span>
</div>
<div class="data">
    <label>Ins. Claims Paid</label>
    <span class="value"></span>
</div>
<?php
if($start_date){
    $l_date = " AND dl.service_date BETWEEN '".$start_date."' AND '".$end_date."'";
    $p_date = " AND dlp.payment_date BETWEEN '".$start_date."' AND '".$end_date."'";
} else {
    $p_date = $l_date = '';
}
?>
<?php include 'ledger_summary_report.php'; ?>
<div style="clear:both;">&nbsp;</div>
<?php
include 'includes/bottom.htm';
?>
