<? 
include "includes/top.htm";
include_once "includes/constants.inc";

?>
<div style="clear:both;"></div>

<style type="text/css">
  .data{
    margin: 0 0 10px 30px;
    clear: both;
    display: block;
    height: 15px;
  }
  .data label{
    display: block;
    margin-right: 20px;
    float: left;
    width: 200px;
  }
  .data .value{
    display: block;
    float: left;
  }
</style>
<?php

if(isset($_REQUEST['start_date'])){
  $start_date = date('Y-m-d', strtotime($_REQUEST['start_date']));
  $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
}else{
  $start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-30, date('Y')));
  $end_date = date('Y-m-d');
}

  $sql = "SELECT du.* FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                WHERE du.userid='".mysql_real_escape_string($_SESSION['docid'])."' AND uc.companyid='".mysql_real_escape_string($_SESSION['companyid'])."'";
  $sql = "SELECT du.*, count(s.id) AS num_screened FROM dental_users du 
                LEFT JOIN dental_screener s ON du.userid = s.docid AND s.adddate BETWEEN '".$start_date."' AND '".$end_date."'
                WHERE du.userid='".mysql_real_escape_string($_SESSION['docid'])."' 
                GROUP BY du.userid
                ";

$my = mysql_query($sql);
$myarray = mysql_fetch_assoc($my);
?>

<span class="admin_head">
	Performance
</span>
<br /><br /><br />
<form method="post" style="margin-left: 20px;">
Start Date: <input type="text" id="start_date" name="start_date" class="calendar" value="<?= date('m/d/Y', strtotime($start_date)); ?>" />
End Date: <input type="text" id="end_date" name="end_date" class="calendar" value="<?= date('m/d/Y', strtotime($end_date)); ?>" />
<input type="submit" value="Filter" />
</form>

<br /><br />

<div class="data">
  <label>Username</label>
  <span class="value"><?= $myarray['username']; ?></span>
</div>

<?php

                $co_sql = "SELECT c.name FROM companies c 
                                JOIN dental_user_company uc ON uc.companyid = c.id
                                WHERE uc.userid='".$myarray['userid']."'";
                $co_q = mysql_query($co_sql);
                $co_r = mysql_fetch_assoc($co_q);
                $company = $co_r['name'];

                $screen_sql = "SELECT u.username, COUNT(s.id) AS num_screened FROM dental_screener s 
                JOIN dental_users u ON u.userid=s.userid
        WHERE 
                s.docid='".$myarray['userid']."' AND
                s.adddate BETWEEN '".$start_date."' AND '".$end_date."' 
                group by u.username
";
$screen_q = mysql_query($screen_sql);
$sleepstudies = "SELECT count(ss.id) as num_ss FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND p.docid = '".$myarray['userid']."'
                        AND str_to_date(ss.date, '%m/%d/%Y') BETWEEN '".$start_date."' AND '".$end_date."' 
                ;";
  $ss_q = mysql_query($sleepstudies);
  $ss = mysql_fetch_assoc($ss_q);


$consult_sql = "SELECT count(i.id) as num_consult FROM dental_flow_pg2_info i
                        JOIN dental_patients p ON p.patientid = i.patientid
                        WHERE i.segmentid=2
                                AND p.docid='".mysql_real_escape_string($myarray['userid'])."'
                                AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$consult_q = mysql_query($consult_sql);
$consult = mysql_fetch_assoc($consult_q);

$imp_sql = "SELECT count(i.id) as num_imp FROM dental_flow_pg2_info i
                        JOIN dental_patients p ON p.patientid = i.patientid
                        WHERE i.segmentid=4
                                AND p.docid='".mysql_real_escape_string($myarray['userid'])."'
                                AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$imp_q = mysql_query($imp_sql);
$imp = mysql_fetch_assoc($imp_q);

$letters_sql = "SELECT count(l.letterid) as num_sent FROM dental_letters l 
                        WHERE 
                                l.docid='".mysql_real_escape_string($myarray['userid'])."'
                                AND l.date_sent BETWEEN '".$start_date."' AND '".$end_date."'";
$letters_q = mysql_query($letters_sql);
$letters = mysql_fetch_assoc($letters_q);

$vob_sql = "SELECT count(p.id) as num_completed FROM dental_insurance_preauth p
                        WHERE 
                                p.doc_id='".mysql_real_escape_string($myarray['userid'])."'
                                AND p.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$vob_q = mysql_query($vob_sql);
$vob = mysql_fetch_assoc($vob_q);

$ins_sent_sql = "SELECT count(p.id) as num_completed FROM dental_insurance_preauth p
                        WHERE 
                                p.doc_id='".mysql_real_escape_string($myarray['userid'])."'
                                AND p.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$ins_sent_q = mysql_query($ins_sent_sql);
$ins_sent = mysql_fetch_assoc($ins_sent_q);

?>
<div class="data">
  <label>Company</label>
  <span class="value"><?= $company; ?></span>
</div>
<div class="data">      
  <label>Name</label>
  <span class="value"><?= $myarray['name']; ?></span>
</div>
<div class="data">      
  <label>Pt. Screened</label>
  <span class="value"><?= $myarray['num_screened']; ?></span>
</div>
<div class="data">      
  <label>By user</label>
  <span class="value"><?php
                                          while($screen = mysql_fetch_assoc($screen_q)){
                                            echo $screen['username']." - ".$screen['num_screened']."<br />";
                                          }
                                        ?>
</span>
</div>
<div class="data">      
  <label>Completed Sleep Studies</label>
  <span class="value"><?= $ss['num_ss']; ?></span>
</div>
<div class="data">      
  <label>Consult</label>
  <span class="value"><?= $consult['num_consult']; ?></span>
</div>
<div class="data">      
  <label>Impressions</label>
  <span class="value"><?= $imp['num_imp']; ?></span>
</div>
<div class="data">      
  <label>Letters Sent</label>
  <span class="value"><?= $letters['num_sent']; ?></span>
</div>
<div class="data">      
  <label>VOBs Completed</label>
  <span class="value"><?= $vob['num_completed']; ?></span>
</div>
<div class="data">      
  <label>Ins. Claims Sent</label>
  <span class="value"></span>
</div>
<div class="data">      
  <label>Ins. Claims Paid</label>
  <span class="value"></span>
</div>

<div style="clear:both;">&nbsp;</div>
<?php
include 'includes/bottom.htm';
?>
