<?php
namespace Ds3\Libraries\Legacy;
include "includes/header.php";
include 'includes/questionnaire_sections.php';
?>
<link rel="stylesheet" href="css/questionnaire.css" />
<?php
if ($_POST['q_sleepsub'] == 1) {
    $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
    $epworth_my = mysqli_query($con, $epworth_sql);

    $epworth_arr = '';

    while ($epworth_myarray = mysqli_fetch_array($epworth_my)) {
        if ($_POST['epworth_'.$epworth_myarray['epworthid']] != '') {
            $epworth_arr .= $epworth_myarray['epworthid'].'|'.$_POST['epworth_'.$epworth_myarray['epworthid']].'~';
        }
    }

    $analysis = $_POST['analysis'];
    $snore_1 = $_POST['snore_1'];
    $snore_2 = $_POST['snore_2'];
    $snore_3 = $_POST['snore_3'];
    $snore_4 = $_POST['snore_4'];
    $snore_5 = $_POST['snore_5'];
    $tot_score = $_POST['tot_score'];

    $newEss = $db->escape( $_POST['epTot']);
    $newTss = s_for($tot_score);

    if ($_POST['ed'] == '') {
        $ins_sql = "insert into dental_q_sleep set 
            patientid = '".s_for($_SESSION['pid'])."',
            epworthid = '".s_for($epworth_arr)."',
            analysis = '".s_for($analysis)."',
            adddate = now(),
            ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
        mysqli_query($con, $ins_sql) or trigger_error($ins_sql." | ".mysqli_error($con), E_USER_ERROR);

        $ins_sql = "insert into dental_thorton set 
            patientid = '".s_for($_SESSION['pid'])."',
            snore_1 = '".s_for($snore_1)."',
            snore_2 = '".s_for($snore_2)."',
            snore_3 = '".s_for($snore_3)."',
            snore_4 = '".s_for($snore_4)."',
            snore_5 = '".s_for($snore_5)."',
            tot_score = '".s_for($tot_score)."',
            adddate = now(),
            ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
        mysqli_query($con, $ins_sql) or trigger_error($ins_sql." | ".mysqli_error($con), E_USER_ERROR);

        $exist_sql = "SELECT q_page1id FROM dental_q_page1_pivot WHERE patientid='".$db->escape( $_SESSION['pid'])."'";
        $exist_q = mysqli_query($con, $exist_sql);
        if (mysqli_num_rows($exist_q) == 0) {
            $ed_sql = "insert into dental_q_page1 set
                ess='$newEss',
                tss='$newTss',
                patientid='".$_SESSION['pid']."'";
            mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
        } else {
            $qPage1Id = mysqli_fetch_field($exist_q);
            $ed_sql = "update dental_q_page1 set
                ess='$newEss',
                tss='$newTss'
                WHERE q_page1id=$qPage1Id";
            mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
        }
        mysqli_query($con, "UPDATE dental_patients SET sleep_status=1 WHERE patientid='".$db->escape( $_SESSION['pid'])."'");
        mysqli_query($con, "UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".$db->escape( $_SESSION['pid'])."'");
        $msg = "Added Successfully";
        ?>
        <script type="text/javascript">
            window.location='<?=$_POST['goto_p']; ?>?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $ed_sql = "update dental_q_sleep set 
            epworthid = '".s_for($epworth_arr)."',
            analysis = '".s_for($analysis)."'
            where q_sleepid = '".s_for($_POST['ed'])."'";
		mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);

        $ed_sql = " update dental_thorton set 
            snore_1 = '".s_for($snore_1)."',
            snore_2 = '".s_for($snore_2)."',
            snore_3 = '".s_for($snore_3)."',
            snore_4 = '".s_for($snore_4)."',
            snore_5 = '".s_for($snore_5)."',
            tot_score = '".s_for($tot_score)."'
            where thortonid = '".s_for($_POST['ted'])."'";
        mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);

        $exist_sql = "SELECT q_page1id FROM dental_q_page1_pivot WHERE patientid='".$db->escape( $_SESSION['pid'])."'";
        $exist_q = mysqli_query($con, $exist_sql);
        if (mysqli_num_rows($exist_q) == 0) {
            $ed_sql = "insert into dental_q_page1 set
                ess='$newEss',
                tss='$newTss',
                patientid='".$_SESSION['pid']."'";
            mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
        } else {
            $qPage1Id = mysqli_fetch_field($exist_q);
            $ed_sql = "update dental_q_page1 set
                ess='$newEss',
                tss='$newTss'
                WHERE q_page1id=$qPage1Id";
    		mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
    	}
        mysqli_query($con, "UPDATE dental_patients SET sleep_status=1 WHERE patientid='".$db->escape( $_SESSION['pid'])."'");
        mysqli_query($con, "UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".$db->escape( $_SESSION['pid'])."'");
        $msg = " Edited Successfully";
        ?>
        <script type="text/javascript">
            window.location='<?= $_POST['goto_p']; ?>?msg=<?=$msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}

require_once __DIR__ . '/includes/questionnaire_header.php';
$comp = questionnaireCompletedSections($_SESSION['pid']);

if ($comp['epworth'] == 0) {
    $sql = "select * from dental_thorton_pivot where patientid='".$_SESSION['pid']."'";
    $my = mysqli_query($con, $sql);
    $myarray = mysqli_fetch_array($my);

    $thortonid = st($myarray['thortonid']);
    $snore_1 = st($myarray['snore_1']);
    $snore_2 = st($myarray['snore_2']);
    $snore_3 = st($myarray['snore_3']);
    $snore_4 = st($myarray['snore_4']);
    $snore_5 = st($myarray['snore_5']);
    $tot_score = st($myarray['tot_score']);

    $pat_sql = "select * from dental_patients where patientid='".s_for($_SESSION['pid'])."'";
    $pat_my = mysqli_query($con, $pat_sql);
    $pat_myarray = mysqli_fetch_array($pat_my);

    $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

    if ($pat_myarray['patientid'] == '') { ?>
        <script type="text/javascript">
            window.location = '/reg/login.php';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $sql = "select * from dental_q_sleep_pivot where patientid='".$_SESSION['pid']."'";
    $my = mysqli_query($con, $sql);
    $myarray = mysqli_fetch_array($my);

    $q_sleepid = st($myarray['q_sleepid']);
    $epworthid = st($myarray['epworthid']);
    $analysis = st($myarray['analysis']);

    if ($epworthid != '') {
        $epworth_arr1 = split('~',$epworthid);

        foreach ($epworth_arr1 as $i => $val) {
            $epworth_arr2 = explode('|', $val);
            $epid[$i] = $epworth_arr2[0];
            $epseq[$i] = $epworth_arr2[1];
        }
    }
    ?>
    <div align="center" class="red">
        <b><?php echo $_GET['msg'];?></b>
    </div>

    <form id="q_sleepfrm" class="q_form" name="q_sleepfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
        <input type="hidden" name="q_sleepsub" value="1" />
        <input type="hidden" name="ed" value="<?=$q_sleepid;?>" />
        <input type="hidden" id="goto_p" name="goto_p" value="treatments.php" />

        <div class="formEl_a">
        <h3>Epworth Sleep Questionnaire</h3>
        <div class="legend">
            Using the following scale, choose the most appropriate number for each situation.
            <br />
            <strong>0</strong> = No chance of dozing<br />
            <strong>1</strong> = Slight chance of dozing<br />
            <strong>2</strong> = Moderate chance of dozing<br />
            <strong>3</strong> = High chance of dozing<br />
        </div>
        <?php
        $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
        $epworth_my = mysqli_query($con, $epworth_sql);
        $epworth_number = mysqli_num_rows($epworth_my);
        ?>
        <script type="text/javascript">
            function cal_analaysis(fa) {
                var an_tot = 0;
                an_tot += parseInt($('#epworth_1').val());
                an_tot += parseInt($('#epworth_2').val());
                an_tot += parseInt($('#epworth_3').val());
                an_tot += parseInt($('#epworth_4').val());
                an_tot += parseInt($('#epworth_5').val());
                an_tot += parseInt($('#epworth_6').val());
                an_tot += parseInt($('#epworth_7').val());
                an_tot += parseInt($('#epworth_8').val());
                if (an_tot < 8) {
                    an_text = 'The Epworth Sleepiness Scale score was ' + an_tot + ',  which indicates a normal amount of sleepiness.';
                }
                if (an_tot >= 8 && an_tot < 10) {
                    an_text = 'The Epworth Sleepiness Scale score was ' + an_tot + ',  which indicates a average amount of sleepiness.';
                }
                if (an_tot >= 10 && an_tot < 16) {
                    an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which may indicate excessive sleepiness depending on the situation. The patient may want to seek medical attention.';
                }
                if (an_tot >= 16 ) {
                    an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which indicates excessive sleepiness and medical attention should be sought.';
                }
                document.q_sleepfrm.analysis.value = an_text;
                document.q_sleepfrm.epTot.value = an_tot;
            }
        </script>
        <?php
        while ($epworth_myarray = mysqli_fetch_array($epworth_my)) {
            if (@array_search($epworth_myarray['epworthid'],$epid) === false) {
                $chk = '';
            } else {
                $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
            } ?>
            <div class="sepH_b half">
                <label class="lbl_in"><?=st($epworth_myarray['epworth']);?></label>
                <select id="epworth_<?=st($epworth_myarray['epworthid']);?>" name="epworth_<?=st($epworth_myarray['epworthid']);?>" class="inpt_in" onchange="cal_analaysis(this.value);">
                    <option value="0" <?php if ($chk == '0') echo " selected";?>>0</option>
                    <option value="1" <?php if ($chk == 1) echo " selected";?>>1</option>
                    <option value="2" <?php if ($chk == 2) echo " selected";?>>2</option>
                    <option value="3" <?php if ($chk == 3) echo " selected";?>>3</option>
                </select>
            </div>
            <?
        } ?>
        <h5 class="clear">Analysis</h5>
        <textarea name="analysis" class="field text addr tbox" style="width:650px; height:100px;"><?=$analysis;?></textarea>
        <input type="hidden" name="epTot" />
        <script type="text/javascript">
            cal_analaysis(0);
        </script>
        <br /><br />
        <h3>Thornton Snoring Scale</h3>
        <script type="text/javascript">
            function cal_snore() {
                var fa = document.q_sleepfrm;
                var tot = parseInt(fa.snore_1.value) + parseInt(fa.snore_2.value) + parseInt(fa.snore_3.value) + parseInt(fa.snore_4.value) + parseInt(fa.snore_5.value);
                fa.tot_score.value = tot;
            }
        </script>

        <input type="hidden" name="thortonsub" value="1" />
        <input type="hidden" name="ted" value="<?=$thortonid;?>" />
        <div class="legend">
            Using the following scale, choose the most appropriate number for each situation.
            <br />
            <strong>0</strong> = Never<br />
            <strong>1</strong> = Infrequently (1 night per week)<br />
            <strong>2</strong> = Frequently (2-3 nights per week)<br />
            <strong>3</strong> = Most of the time (4 or more nights)<br />
        </div>
        <div class="sepH_b half">
            <label class="lbl_in">1. My snoring affects my relationship with my partner:</label>
            <select name="snore_1" onchange="cal_snore()" class="inpt_in">
                <option value="0" <?php if ($snore_1 == 0) echo " selected";?>>0</option>
                <option value="1" <?php if ($snore_1 == 1) echo " selected";?>>1</option>
                <option value="2" <?php if ($snore_1 == 2) echo " selected";?>>2</option>
                <option value="3" <?php if ($snore_1 == 3) echo " selected";?>>3</option>
            </select>
        </div>
        <div class="sepH_b half">
            <label class="lbl_in">2. My snoring causes my partner to be irritable or tired:</label>
            <select name="snore_2" onchange="cal_snore()" class="inpt_in">
                <option value="0" <?php if ($snore_2 == 0) echo " selected";?>>0</option>
                <option value="1" <?php if ($snore_2 == 1) echo " selected";?>>1</option>
                <option value="2" <?php if ($snore_2 == 2) echo " selected";?>>2</option>
                <option value="3" <?php if ($snore_2 == 3) echo " selected";?>>3</option>
            </select>
        </div>
        <div class="sepH_b half">
            <label class="lbl_in">3. My snoring requires us to sleep in separate rooms:</label>
            <select name="snore_3" onchange="cal_snore()" class="inpt_in">
                <option value="0" <?php if ($snore_3 == 0) echo " selected";?>>0</option>
                <option value="1" <?php if ($snore_3 == 1) echo " selected";?>>1</option>
                <option value="2" <?php if ($snore_3 == 2) echo " selected";?>>2</option>
                <option value="3" <?php if ($snore_3 == 3) echo " selected";?>>3</option>
            </select>
        </div>
        <div class="sepH_b half">
            <label class="lbl_in">4. My snoring is loud:</label>
            <select name="snore_4" onchange="cal_snore()" class="inpt_in">
                <option value="0" <?php if ($snore_4 == 0) echo " selected";?>>0</option>
                <option value="1" <?php if ($snore_4 == 1) echo " selected";?>>1</option>
                <option value="2" <?php if ($snore_4 == 2) echo " selected";?>>2</option>
                <option value="3" <?php if ($snore_4 == 3) echo " selected";?>>3</option>
            </select>
        </div>
        <div class="sepH_b half">
            <label class="lbl_in">5. My snoring affects people when I am sleeping away from home:</label>
            <select name="snore_5" onchange="cal_snore()" class="inpt_in">
                <option value="0" <?php if ($snore_5 == 0) echo " selected";?>>0</option>
                <option value="1" <?php if ($snore_5 == 1) echo " selected";?>>1</option>
                <option value="2" <?php if ($snore_5 == 2) echo " selected";?>>2</option>
                <option value="3" <?php if ($snore_5 == 3) echo " selected";?>>3</option>
            </select>
        </div>
        <h5 class="clear">Your Score:</h5>
        <input type="text" name="tot_score" value="<?= $tot_score; ?>" class="tbox" style="width:80px;" readonly="readonly" >
        <b>A score of 5 or greater indicates your snoring may be significantly affecting your quality of life.  </b>
        <script type="text/javascript">
            $('document').ready(function () {
                cal_snore();
            });
        </script>
        <p class="confirm_text">Thank you for completing the Epworth/Thorton Questionnaire! Please click the box below to confirm and record your answers. </p>
        <div align="right">
            <input type="submit" name="q_pagebtn" class="next btn btn_d" value="Save and Proceed" />
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>
    <?php
} else {
    show_section_completed($_SESSION['pid']);
}
require_once __DIR__ . '/../manage/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<?php include "includes/footer.php";?>
