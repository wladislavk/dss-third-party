<?php namespace Ds3\Legacy; ?><?
include_once "includes/top.htm";

include_once 'includes/patient_nav.php';
include_once '../includes/general_functions.php';
?>

<style type="text/css">

.space{ margin-top:20px; }

</style>

<?php

$sql = "SELECT * FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
$q = mysqli_query($con,$sql);
$pat = mysqli_fetch_assoc($q);

$p_sql = "SELECT * FROM dental_contact where contactid='".mysqli_real_escape_string($con,$pat['p_m_ins_co'])."'";
$p_q = mysqli_query($con,$p_sql);
$p_ins = mysqli_fetch_assoc($p_q);

$s_sql = "SELECT * FROM dental_contact where contactid='".mysqli_real_escape_string($con,$pat['s_m_ins_co'])."'";
$s_q = mysqli_query($con,$s_sql);
$s_ins = mysqli_fetch_assoc($s_q);
?>
<div class="field">
  <label>Generated on:</label>
  <span class="data"><?php echo  date('m/d/Y'); ?></span>
</div>

<div class="field">
  <label>Patient Name:</label>
  <span class="data"><?php echo  $pat['salutation']." ".$pat['firstname']." ".$pat['lastname']; ?></span>
</div>

<div class="field">
  <label>Home phone:</label>
  <span class="data"><?php echo  format_phone($pat['home_phone']); ?></span>
</div>

<div class="field">
  <label>Cell phone:</label>
  <span class="data"><?php echo  format_phone($pat['cell_phone']); ?></span>
</div>

<div class="field">
  <label>Work phone:</label>
  <span class="data"><?php echo  format_phone($pat['work_phone']); ?></span>
</div>

<div class="field">
  <label>Email:</label>
  <span class="data"><?php echo  $pat['email']; ?></span>
</div>


<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $pat['add1']." ".$pat['add2']."<br />".$pat['city'].", ".$pat['state']." ".$pat['zip']; ?></span>
</div>

<div class="field">
  <label>DOB:</label>
  <span class="data"><?php echo  $pat['dob']; ?></span>
</div>
<div class="field">
  <label>Gender:</label>
  <span class="data"><?php echo  $pat['gender']; ?></span>
</div>
<div class="field">
  <label>SS#:</label>
  <span class="data"><?php echo  $pat['ssn']; ?></span>
</div>
<div class="field">
  <label>Marital Status:</label>
  <span class="data"><?php echo  (!empty($pat['martial_status']) ? $pat['martial_status'] : ''); ?></span>
</div>
<div class="field">
  <label>Partner/Guardian Name:</label>
  <span class="data"><?php echo  $pat['partner_name']; ?></span>
</div>

<div class="field">
  <label>Height:</label>
  <span class="data"><?php echo  $pat['feet']; ?> ft <?php echo  $pat['inches']; ?> in</span>
</div>
<div class="field">
  <label>Weight:</label>
  <span class="data"><?php echo  $pat['weight']; ?></span>
</div>
<div class="field">
  <label>BMI:</label>
  <span class="data"><?php echo  $pat['bmi']; ?></span>
</div>

<div class="field">
  <label>Employer:</label>
  <span class="data"><?php echo  $pat['employer']; ?></span>
</div>
<div class="field">
  <label>Employer Phone:</label>
  <span class="data"><?php echo  $pat['emp_phone']; ?></span>
</div>
<div class="field">
  <label>Employer Fax:</label>
  <span class="data"><?php echo  $pat['emp_fax']; ?></span>
</div>
<div class="field">
  <label>Employer Address:</label>
  <span class="data"><?php echo  $pat['emp_add1']; ?> <?php echo  $pat['emp_add2']; ?><br /><?php echo  $pat['emp_city']; ?>, <?php echo  $pat['emp_state']; ?> <?php echo  $pat['emp_zip']; ?></span>
</div>

INSURANCE:

<div class="field">
  <label>Relationship to insured:</label>
  <span class="data"><?php echo  (!empty($pat['p_m_relationship']) ? $pat['p_m_relationship'] : ''); ?></span>
</div>
<div class="field">
  <label>Insured Name: </label>
  <span class="data"><?php echo  $pat['p_m_partyfname']." ".$pat['p_m_partymname']." ".$pat['p_m_partylname']; ?></span>
</div>
<div class="field">
  <label>Insured DOB:</label>
  <span class="data"><?php echo  $pat['ins_dob']; ?></span>
</div>
<div class="field">
  <label>Insurance Type:</label>
  <span class="data"><?php echo  $pat['p_m_ins_type']; ?></span>
</div>
<div class="field">
  <label>Accept Assignment OR Payment to Patient</label>
  <span class="data"><?php echo  $pat['p_m_ins_ass']; ?></span>
</div>

<div class="field">
  <label>Insurance Company:</label>
  <span class="data"><?php echo  $p_ins['company']; ?></span>
</div>
<div class="field">
  <label>Insurance Address:</label>
  <span class="data"><?php echo  $p_ins['add1']." ".$p_ins['add2']."<br />".$p_ins['city'].", ".$p_ins['state']." ".$p_ins['zip']; ?></span>
</div>

<div class="field">
  <label>Ins ID:</label>
  <span class="data"><?php echo  $pat['p_m_ins_id']; ?></span>
</div>
<div class="field">
  <label>Ins Group Number:</label>
  <span class="data"><?php echo  $pat['p_m_ins_grp']; ?></span>
</div>
<div class="field">
  <label>Ins Plan Name:</label>
  <span class="data"><?php echo  $pat['p_m_ins_plan']; ?></span>
</div>

Does the patient have Secondary Insurance? <?php echo  $pat['has_s_m_ins']; ?> 
<?php
  if($pat['has_s_m_ins']=='Yes'){ ?>
<div class="field">
  <label>Relationship to insured:</label>
  <span class="data"><?php echo  $pat['s_m_relationship']; ?></span>
</div>
<div class="field">
  <label>Insured Name: </label>
  <span class="data"><?php echo  $pat['s_m_partyfname']." ".$pat['s_m_partymname']." ".$pat['s_m_partylname']; ?></span>
</div>
<div class="field">
  <label>Insured DOB:</label>
  <span class="data"><?php echo  $pat['ins2_dob']; ?></span>
</div>
<div class="field">
  <label>Insurance Type:</label>
  <span class="data"><?php echo  $pat['s_m_ins_type']; ?></span>
</div>
<div class="field">
  <label>Accept Assignment OR Payment to Patient</label>
  <span class="data"><?php echo  $pat['s_m_ins_ass']; ?></span>
</div>

<div class="field">
  <label>Insurance Company:</label>
  <span class="data"><?php echo  $s_ins['company']; ?></span>
</div>
<div class="field">
  <label>Insurance Address:</label>
  <span class="data"><?php echo  $s_ins['add1']." ".$s_ins['add2']."<br />".$s_ins['city'].", ".$s_ins['state']." ".$s_ins['zip']; ?></span>
</div>

<div class="field">
  <label>Ins ID:</label>
  <span class="data"><?php echo  $pat['s_m_ins_id']; ?></span>
</div>
<div class="field">
  <label>Ins Group Number:</label>
  <span class="data"><?php echo  $pat['s_m_ins_grp']; ?></span>
</div>
<div class="field">
  <label>Ins Plan Name:</label>
  <span class="data"><?php echo  $pat['s_m_ins_plan']; ?></span>
</div>


  <?php } ?>

<div class="space">Medical Contacts:</div>
<?php if($pat['docpcp']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysqli_real_escape_string($con,$pat['docpcp'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
  $doc = mysqli_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Primary Care MD:</label>
  <span class="data"><?php echo  $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $doc['add1']." ".$doc['add2']; ?><br /><?php echo  $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?php echo  format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?php echo  format_phone($doc['fax']); ?></span>
</div>

<?php } ?>

<?php if($pat['docent']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysqli_real_escape_string($con,$pat['docent'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
  $doc = mysqli_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>ENT:</label>
  <span class="data"><?php echo  $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $doc['add1']." ".$doc['add2']; ?><br /><?php echo  $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?php echo  format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?php echo  format_phone($doc['fax']); ?></span>
</div>

<?php } ?>

<?php if($pat['docsleep']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysqli_real_escape_string($con,$pat['docsleep'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
  $doc = mysqli_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Sleep MD:</label>
  <span class="data"><?php echo  $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $doc['add1']." ".$doc['add2']; ?><br /><?php echo  $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?php echo  format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?php echo  format_phone($doc['fax']); ?></span>
</div>

<?php } ?>

<?php if($pat['docdentist']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysqli_real_escape_string($con,$pat['docdentist'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
  $doc = mysqli_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Dentist:</label>
  <span class="data"><?php echo  $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $doc['add1']." ".$doc['add2']; ?><br /><?php echo  $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?php echo  format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?php echo  format_phone($doc['fax']); ?></span>
</div>

<?php } ?>
<?php if($pat['docmdother']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysqli_real_escape_string($con,$pat['docmdother'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
  $doc = mysqli_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Other MD:</label>
  <span class="data"><?php echo  $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $doc['add1']." ".$doc['add2']; ?><br /><?php echo  $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?php echo  format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?php echo  format_phone($doc['fax']); ?></span>
</div>

<?php } ?>
<?php if($pat['docmdother2']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysqli_real_escape_string($con,$pat['docmdother2'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
  $doc = mysqli_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Other MD 2:</label>
  <span class="data"><?php echo  $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $doc['add1']." ".$doc['add2']; ?><br /><?php echo  $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?php echo  format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?php echo  format_phone($doc['fax']); ?></span>
</div>

<?php } ?>
<?php if($pat['docmdother3']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysqli_real_escape_string($con,$pat['docmdother3'])."'";
  $doc_q = mysqli_query($con,$doc_sql);
  $doc = mysqli_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Other MD 3:</label>
  <span class="data"><?php echo  $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?php echo  $doc['add1']." ".$doc['add2']; ?><br /><?php echo  $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?php echo  format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?php echo  format_phone($doc['fax']); ?></span>
</div>

<?php } ?>

<!--  PART 2 -->


<?php
$sql = "select * from dental_q_sleep where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$q_sleepid = st($myarray['q_sleepid']);
$epworthid = st($myarray['epworthid']);
$analysis = st($myarray['analysis']);

if($epworthid <> '')
{
        $epworth_arr1 = explode('~',$epworthid);

        foreach($epworth_arr1 as $i => $val)
        {
                $epworth_arr2 = explode('|',$val);

                $epid[$i] = $epworth_arr2[0];
                $epseq[$i] = (!empty($epworth_arr2[1]) ? $epworth_arr2[1] : '');
        }
}
?>
<span class="admin_head">
Epworth Sleep Questionnaire
</span>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr>
                <td valign="top" colspan="2" >
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        0 = No chance of dozing<br />
                        1 = Slight chance of dozing<br />
                        2 = Moderate chance of dozing<br />
                        3 = High chance of dozing<br />
                </td>
        </tr>
                    <?
                                        $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
                                        $epworth_my = mysqli_query($con,$epworth_sql);
                                        $epworth_number = mysqli_num_rows($epworth_my);
                                        ?>

                    <?
                                        while($epworth_myarray = mysqli_fetch_array($epworth_my))
                                        {
                                                if(@array_search($epworth_myarray['epworthid'],$epid) === false)
                                                {
                                                        $chk = '';
                                                }
                                                else
                                                {
                                                        $chk = (!empty($epseq[@array_search($epworth_myarray['epworthid'],$epid)]) ? $epseq[@array_search($epworth_myarray['epworthid'],$epid)] : '');
                                                }

                                        ?>
                            <tr>
                <td valign="top" width="60%" class="frmhead">
                        <?php echo st($epworth_myarray['epworth']);?><br />&nbsp;
                </td>
                <td valign="top" class="frmdata">
                                <select id="epworth_<?php echo st($epworth_myarray['epworthid']);?>" name="epworth_<?php echo st($epworth_myarray['epworthid']);?>" class="field text addr tbox" style="width:125px;" onchange="cal_analaysis(this.value);">
                                <option value="0" <? if($chk == '0') echo " selected";?>>0</option>
                                <option value="1" <? if($chk == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($chk == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($chk == 3) echo " selected";?>>3</option>
                            </select>
                        </td>
                    </tr>
                    <? }?>
                    <tr>
                        <td colspan="2">
                                <span style="color:#000000; padding-top:0px;">
                                Analysis
                            </span>
                            <br />
                            <textarea name="analysis" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $analysis;?></textarea>
                        </td>
                    </tr>
</table>


<?php
$sql = "select * from dental_thorton where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$thortonid = st($myarray['thortonid']);
$snore_1 = st($myarray['snore_1']);
$snore_2 = st($myarray['snore_2']);
$snore_3 = st($myarray['snore_3']);
$snore_4 = st($myarray['snore_4']);
$snore_5 = st($myarray['snore_5']);
$tot_score = $snore_1+$snore_2+$snore_3+$snore_4+$snore_5;
?>
<span class="admin_head">
        Thornton Snoring Scale
</span>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr>
                <td valign="top" colspan="2" >
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        0 = Never<br />
                        1 = Infrequently (1 night per week)<br />
                        2 = Frequently (2-3 nights per week)<br />
                        3 = Most of the time (4 or more nights)<br />
                </td>
        </tr>
        <tr>
                <td valign="top" width="60%" class="frmhead">
                        1. My snoring affects my relationship with my partner:
                </td>
                <td valign="top" class="frmdata">
                        <select name="snore_1" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
                                <option value="0" <? if($snore_1 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_1 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_1 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_1 == 3) echo " selected";?>>3</option>
                        </select>
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                        2. My snoring causes my partner to be irritable or tired:
                </td>
                <td valign="top" class="frmdata">
                        <select name="snore_2" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
                                <option value="0" <? if($snore_2 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_2 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_2 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_2 == 3) echo " selected";?>>3</option>
                        </select>
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                        3. My snoring requires us to sleep in separate rooms:
                </td>
                <td valign="top" class="frmdata">
                        <select name="snore_3" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
                                <option value="0" <? if($snore_3 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_3 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_3 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_3 == 3) echo " selected";?>>3</option>
                        </select>
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                        4. My snoring is loud:
                </td>
                <td valign="top" class="frmdata">
                        <select name="snore_4" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
                                <option value="0" <? if($snore_4 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_4 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_4 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_4 == 3) echo " selected";?>>3</option>
                        </select>
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                        5. My snoring affects people when I am sleeping away from home:
                </td>
                <td valign="top" class="frmdata">
                        <select name="snore_5" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
                                <option value="0" <? if($snore_5 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_5 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_5 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_5 == 3) echo " selected";?>>3</option>
                        </select>
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                        Your Score:
                </td>
                <td valign="top" class="frmdata">
                        <input type="text" name="tot_score" value="<?php echo  $tot_score;?>" class="tbox" style="width:80px;" readonly="readonly" >
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmdata" colspan="2" style="text-align:right;">
                        <b>A score of 5 or greater indicates your snoring may be significantly affecting your quality of life.  </b>
                </td>
        </tr>
</table>

<?php
$sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$q_page1id = st($myarray['q_page1id']);
$exam_date = st($myarray['exam_date']);
$ess = st($myarray['ess']);
$tss = st($myarray['tss']);
$chief_complaint_text = st($myarray['chief_complaint_text']);
$complaintid = st($myarray['complaintid']);
$other_complaint = st($myarray['other_complaint']);
?>
<h4>Complaints</h4>
<div class="box">
<strong>Reason for seeking tx:</strong>
<?php
$c_sql = "SELECT chief_complaint_text from dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
$c_q = mysqli_query($con,$c_sql);
$c_r = mysqli_fetch_assoc($c_q);
echo $c_r['chief_complaint_text'];
if($complaintid <> '')
{
        $comp_arr1 = explode('~',$complaintid);

        foreach($comp_arr1 as $i => $val)
        {
                $comp_arr2 = explode('|',$val);

                $compid[$i] = $comp_arr2[0];
                $compseq[$i] = (!empty($comp_arr2[1]) ? $comp_arr2[1] : '');
        }
}

?>
<br /><br />

<?php if(!empty($complaintid) || !empty($compid) && in_array('0', $compid)){ ?>
<strong>Other Complaints</strong>
<ul>
                <?php if($complaintid != ''){ ?>
                    <?
                                        $complaint_sql = "select * from dental_complaint where status=1 order by sortby";
                                        $complaint_my = mysqli_query($con,$complaint_sql);
                                        $complaint_number = mysqli_num_rows($complaint_my);
                                        while($complaint_myarray = mysqli_fetch_array($complaint_my))
                                        {
                                                if(@array_search($complaint_myarray['complaintid'],$compid) === false)
                                                {
                                                        $chk = '';

                                                }
                                                else
                                                {
                                                   #     $chk = ($compseq[@array_search($complaint_myarray['complaintid'],$compid)])?1:0;
                                                        ?><li><?php echo  $complaint_myarray['complaint']; ?></li><?php
                                                }
                                        }
?>
<?php } ?>
<?php if($other_complaint != '' && in_array('0', $compid)){ ?>
<li><?php echo  $other_complaint; ?></li>
<?php } ?>
</ul>
<?php } ?>

<strong>Bed Partner:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (!empty($bed_time_partner) ? $bed_time_partner : '') ?><br />
                        &nbsp;&nbsp;
      <strong>Same room:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (!empty($sleep_same_room) ? $sleep_same_room : ''); ?><br />
                                <?php if(!empty($quit_breathing)){ ?>
                                        How many times per night does your bedtime partner notice you quit breathing?
                                            <?php echo  $quit_breathing;?>
                                <? } ?>


</div>



<h4>CPAP</h4>
<div class="box">

        <?php
          $pat_sql = "select cpap from dental_q_page2 where patientid='".s_for($_GET['pid'])."'";
          $pat_my = mysqli_query($con,$pat_sql);
          $pat_myarray = mysqli_fetch_array($pat_my);
          if($pat_myarray['cpap']=="No"){

            ?>Patient has not previously attempted CPAP therapy.<?php

          }else{
        //echo $pat_myarray['cpap'];
        ?>
    <label>
<br />
    <span style="font-weight:bold;">Problems w/ CPAP</span><br />
        <?php echo (!empty($problem_cpap));?>
      </label>

     <?php } ?>

<?php
$sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$q_page2id = st($myarray['q_page2id']);
$polysomnographic = st($myarray['polysomnographic']);
$sleep_center_name_text = st($myarray['sleep_center_name_text']);
$sleep_study_on = st($myarray['sleep_study_on']);
$confirmed_diagnosis = st($myarray['confirmed_diagnosis']);
$rdi = st($myarray['rdi']);
$ahi = st($myarray['ahi']);
$cpap = st($myarray['cpap']);
$cur_cpap = st($myarray['cur_cpap']);
$intolerance = st($myarray['intolerance']);
$other_intolerance = st($myarray['other_intolerance']);
$other = st($myarray['other']);
$affidavit = st($myarray['affidavit']);
$type_study = st($myarray['type_study']);
$nights_wear_cpap = st($myarray['nights_wear_cpap']);
$percent_night_cpap = st($myarray['percent_night_cpap']);
$custom_diagnosis = st($myarray['custom_diagnosis']);
$sleep_study_by = st($myarray['sleep_study_by']);
$triedquittried = st($myarray['triedquittried']);
$timesovertime = st($myarray['timesovertime']);

if($cpap == '')
        $cpap = 'No';
?>
                                <?php if($polysomnographic != ''){ ?>
                    <div>
                        <span>
                                                        <strong>Have you had a sleep study</strong>

<?php echo  ($polysomnographic == '1')?'Yes':'No'; ?>
<?php if($polysomnographic == '1'){ ?>
                                <?php if($sleep_center_name_text != ''){ ?>
                            <strong>At</strong> <?php echo $sleep_center_name_text;?>
                                <? } ?>
                                <?php if($sleep_study_on != ''){ ?>
                            <strong>Date</strong>
                            <?php echo $sleep_study_on;?>
                                <? } ?>
<?php } ?>
                        </span>
                    </div>
                <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        CPAP Intolerance
                    </label>
                                <?php if($cpap != ''){ ?>
                    <div>
                        <span>
                                <strong>Have you tried CPAP?</strong>
                            <?php echo  $cpap;?>
                </span>
                        </div>
                                <? } ?>
                                <?php if($cur_cpap != ''){  ?>
                    <div class="cpap_options">
                        <span>
                                <strong>Are you currently using CPAP?</strong>
                            <?php echo  $cur_cpap;?>
                        </span>
                        </div>

                                <? } ?>
                                <?php if($nights_wear_cpap != ''){ ?>
                                        <div class="cpap_options2">                        <span>
                                                        <strong>If currently using CPAP, how many nights / week do you wear it?</strong> <?php echo $nights_wear_cpap;?>
                                                        <br />&nbsp;
                                                </span>
                                        </div>
                                <? } ?>
                                                                                            <?php if($percent_night_cpap != ''){ ?>
                                        <div class="cpap_options2">
                        <span>
                                                        <strong>How many hours each night do you wear it?</strong> <?php echo $percent_night_cpap;?>

                                                        <br />&nbsp;
                                                </span>
                                        </div>
                                <? } ?>
                                <?php if($intolerance != ''){ ?>
                        <div id="cpap_options" class="cpap_options">
                        <span>
                                <strong>What are your chief complaints about CPAP?</strong>

                            <br />
                            <?
                                                        $intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
                                                        $intolerance_my = mysqli_query($con,$intolerance_sql);

                                                        while($intolerance_myarray = mysqli_fetch_array($intolerance_my))
                                                        {
                                                        ?>
                                                                <? if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { ?>
<?php echo st($intolerance_myarray['intolerance']);?><br />
<?php }?>
                                                        <?
                                                        }
                                                        ?>
                        </span>
                                        </div>
                                <? } ?>
                                <?php if($other_intolerance != ''){ ?>
                    <br />
                    <div class="cpap_options">
                        <span class="cpap_other_text">
                                <span style="color:#000000; padding-top:0px;">
                                <strong>Other Items</strong><br />
                            </span>
                            <?php echo $other_intolerance;?>
                                                        <br />&nbsp;
                        </span>
                    </div>
                                <? } ?>





</div>



<? include '../summ_sleep.php'; ?>

<h3 class="sect_header" style="clear:both;">Previous Treatments</h3>
<div class="box">

<?php

$sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$other_therapy = st($myarray['other_therapy']);
$dd_wearing = st($myarray['dd_wearing']);
$dd_prev = st($myarray['dd_prev']);
$dd_otc = st($myarray['dd_otc']);
$dd_fab = st($myarray['dd_fab']);
$dd_who = st($myarray['dd_who']);
$dd_experience = st($myarray['dd_experience']);
$surgery = st($myarray['surgery']);

if($dd_wearing == '' &&
  $dd_prev == '' &&
  $dd_otc == '' &&
  $dd_fab == '' &&
  $dd_who == '' &&
  $dd_experience == '' &&
  $surgery == '' &&
  $other_therapy == ''){
?>
<p>No previous treatments documented.</p>

<?php
}else{
?>
                    <label class="desc" id="title0" for="Field0">
                        Dental Devices
                    </label>
                                <?php if($dd_wearing != ''){ ?>
                    <div>
                        <span>
                                Are you currently wearing a dental device?
                                <?php echo  $dd_wearing; ?>
                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_prev != ''){ ?>
                    <div>
                        <span>
                                Have you previously tried a dental device?
                                <?php echo  $dd_prev; ?>
                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_otc != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Was it over-the-counter (OTC)?
                                <?php echo  $dd_otc; ?>
                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_fab != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Was it fabricated by a dentist?
                                <?php echo  $dd_fab; ?>
                        <span>
                    </div>
                                <? } ?>
                                <?php if($dd_who != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Who: <?php echo  $dd_who; ?>
                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_experience != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Describe your experience<br />
                                <?php echo  $dd_experience; ?>
                        </span>
                    </div>
                                <? } ?>
                    <label class="desc" id="title0" for="Field0">
                        Surgery
                    </label>
                                <?php if($surgery != ''){ ?>
                    <div>
                        <span>
                                Have you had surgery for snoring or sleep apnea?
                                <?php echo  $surgery; ?>
                        </span>                    </div>
                                <? } ?>
                                <?php
                  $s_sql = "SELECT * FROM dental_q_page2_surgery WHERE patientid='".mysqli_real_escape_string($con,$_REQUEST['pid'])."'";
                  $s_q = mysqli_query($con,$s_sql);
                  $s_num = mysqli_num_rows($s_q);
                                if($s_num != 0){ ?>
                    <div class="s_options">
                        <span>
Please list any nose, palatal, throat, tongue, or jaw surgeries you have had.  (each is individual text field in SW)
        <table id="surgery_table">
        <tr><th>Date</th><th>Surgeon</th><th>Surgery</th><th></th></tr>
                <?php
                  $s_count = 0;
                  while($s_row = mysqli_fetch_assoc($s_q)){
                ?>
          <tr id="surgery_row_<?php echo  $s_count; ?>">
                <td><?php echo  $s_row['surgery_date']; ?></td>
                <td><?php echo  $s_row['surgeon']; ?></td>
                <td><?php echo  $s_row['surgery']; ?></td>
          </tr>
                <?php
                        $s_count++;
                        }
                ?>
        </table>
                        </span>
                    </div>
                <?php } ?>

        <?php if($other_therapy != ''){ ?>
                    <label class="desc" id="title0" for="Field0">
                        OTHER ATTEMPTED THERAPIES
                    </label>
                    <div>
                        <span>
                                <?php echo $other_therapy;?>
                        </span>
                        </div>
        <? } ?>
<?php } ?>
</div>



<?php

$sql = "select * from dental_q_page3 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$q_page3id = st($myarray['q_page3id']);
$allergens = st($myarray['allergens']);
$other_allergens = st($myarray['other_allergens']);
$medications = st($myarray['medications']);
$other_medications = st($myarray['other_medications']);
$history = st($myarray['history']);
$other_history = st($myarray['other_history']);
$dental_health = st($myarray['dental_health']);
$injurytohead = st($myarray['injurytohead']);
        $injurytoface = st($myarray['injurytoface']);
        $injurytoneck = st($myarray['injurytoneck']);
        $injurytoteeth = st($myarray['injurytoteeth']);
        $injurytomouth = st($myarray['injurytomouth']);
        $drymouth = st($myarray['drymouth']);
$removable = st($myarray['removable']);
$year_completed = st($myarray['year_completed']);
$tmj = st($myarray['tmj']);
$gum_problems = st($myarray['gum_problems']);
$dental_pain = st($myarray['dental_pain']);
$dental_pain_describe = st($myarray['dental_pain_describe']);
$completed_future = st($myarray['completed_future']);
$clinch_grind = st($myarray['clinch_grind']);
$wisdom_extraction = st($myarray['wisdom_extraction']);
$jawjointsurgery = st($myarray['jawjointsurgery']);
$no_allergens = st($myarray['no_allergens']);
$no_medications = st($myarray['no_medications']);
$no_history = st($myarray['no_history']);
$orthodontics = st($myarray['orthodontics']);
$psql = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
$pmy = mysqli_query($con,$psql);
$pmyarray = mysqli_fetch_array($pmy);
$premedcheck = st($pmyarray["premedcheck"]);
$allergenscheck = st($myarray["allergenscheck"]);
$medicationscheck = st($myarray["medicationscheck"]);
$historycheck = st($myarray["historycheck"]);
$premeddet = st($pmyarray["premed"]);
$family_hd = st($myarray["family_hd"]);

$family_bp = st($myarray["family_bp"]);
$family_dia = st($myarray["family_dia"]);
$family_sd = st($myarray["family_sd"]);
$alcohol = st($myarray['alcohol']);
$sedative = st($myarray['sedative']);
$caffeine = st($myarray['caffeine']);
$smoke = st($myarray['smoke']);
$smoke_packs = st($myarray['smoke_packs']);
$tobacco = st($myarray['tobacco']);
$additional_paragraph = st($myarray['additional_paragraph']);
        $wisdom_extraction_text = $myarray['wisdom_extraction_text'];
        $removable_text  = $myarray['removable_text'];
        $dentures  = $myarray['dentures'];
        $dentures_text  = $myarray['dentures_text'];
        $tmj_cp  = $myarray['tmj_cp'];
        $tmj_cp_text  = $myarray['tmj_cp_text'];
        $tmj_pain  = $myarray['tmj_pain'];
        $tmj_pain_text  = $myarray['tmj_pain_text'];
        $tmj_surgery  = $myarray['tmj_surgery'];
        $tmj_surgery_text  = $myarray['tmj_surgery_text'];
        $injury  = $myarray['injury'];
        $injury_text  = $myarray['injury_text'];
        $gum_prob  = $myarray['gum_prob'];
        $gum_prob_text  = $myarray['gum_prob_text'];
        $gum_surgery  = $myarray['gum_surgery'];
        $gum_surgery_text  = $myarray['gum_surgery_text'];
        $clinch_grind_text  = $myarray['clinch_grind_text'];
        $future_dental_det = $myarray['future_dental_det'];
        $drymouth_text = $myarray['drymouth_text'];

?>
<h3 class="sect_header">Medications / Allergies</h3>
<div class="box">
                <?php if($premedcheck!=''){ ?>
                <label class="desc" id="title0" for="Field0" style="width:90%;">
                            Premedication
                            <span id="req_0" class="req">*</span>
                                <?php echo  ($premedcheck)?"- Yes":"- No";?>
                        </label>
                        <div>
                          <?php if($premeddet != ''){ ?>
                            <span id="pm_det" <?php if($premedcheck == 0 && (!$showEdits || $premedcheck==$dpp_row['premedcheck'])){ echo 'style="display:none;"';} ?>>
                                <?php echo $premeddet;?>
                            </span>
                          <?php } ?>
                       </div>
                <?php } ?>
                          <?php if($allergenscheck != ''){ ?>
                    <label class="desc" id="title0" for="Field0" style="width:90%">
                        Allergens <?php echo  ($allergenscheck)?"- Yes":"- No"; ?>
                    </label>
                    <div>
                        <span>
                          <?php if($other_allergens != ''){ ?>
                            <span id="a_det" <?php if($allergenscheck == 0 && (!$showEdits || $allergenscheck==$dpp_row['allergenscheck'])){ echo 'style="display:none;"';} ?>>
                                <?php echo $other_allergens;?>
                            </span>
                          <?php } ?>
                        </span>
                    </div>
                          <?php } ?>

                          <?php if($medicationscheck != ''){ ?>
                    <label class="desc" id="title0" for="Field0" style="width:90%">
                        Current Medications <?php echo  ($medicationscheck)?"- Yes":"- No"; ?>
                    </label>
                    <div>
                        <span>
                          <?php if($other_medications != ''){ ?>
                        <span id="m_det" <?php if($medicationscheck == 0 && (!$showEdits || $medicationscheck==$dpp_row['medicationscheck'])){ echo 'style="display:none;"';} ?>>
                                <?php echo $other_medications;?>
                        </span>
                          <?php } ?>
                        </span>
                    </div>
                          <?php } ?>
</div>

<h3 class="sect_header">Health History</h3>
<div class="box">
                          <?php if($other_history != ''){ ?>
                    <label class="desc" id="title0" for="Field0" style="width:90%;">
                        Medical History
                    </label>
                    <div>
                        <span>
                             <span id="h_det" >
                                <?php echo $other_history;?>
                             </span>
                        </span>
                    </div>
                          <?php } ?>
                        <br />

                    <label class="desc" id="title0" for="Field0">
                        Dental History
                    </label>
                        <table width="90%">
                <?php if($dental_health != ''){ ?>
                    <tr>
                      <td>How would you describe your dental health?</td>
                                <td><?php echo  $dental_health;?></td>
                        <td></td>
                    </tr>
                <?php } ?>
                <?php if($wisdom_extraction == 'Yes' || $wisdom_extraction_text != ''){ ?>
                                        <tr>
                                                        <td>Have you ever had teeth extracted?</td>

                                                 <td><?php echo  $wisdom_extraction;?></td>
                                                        <td id="wisdom_extraction_extra">Please describe: <?php echo  $wisdom_extraction_text; ?>
                                                </td>
                                        </tr>
                <?php } ?>
                <?php if($removable == 'Yes' || $removable_text != ''){ ?>
                                        <tr>
                                                        <td>Do you wear removable partials?</td>

                                                        <td><?php echo  $removable;?></td>
                                                        <td id="removable_extra">Please describe: <?php echo  $removable_text; ?>
</td>
                                        </tr>
                <?php } ?>
                <?php if($dentures == 'Yes' || $dentures_text != ''){ ?>
                                       <tr>
                                                        <td>Do you wear dentures?</td>

                                                        <td><?php echo  $dentures; ?></td>

                                                        <td id="dentures_extra">Please describe: <?php echo  $dentures_text; ?>

                                                </td>
                                        </tr>
                <?php } ?>
                <?php if($orthodontics == 'Yes' || $year_completed != ''){ ?>

                                        <tr>
                                                        <td>Have you worn orthodontics (braces)?</td>

                                                        <td><?php echo  $orthodontics;?></td>

                                                        <td id="orthodontics_extra">Year completed: <?php echo $year_completed;?>
                                                </td>
                                        </tr>
                <?php } ?>
                <?php if($tmj_cp == 'Yes' || $tmj_cp_text != ''){ ?>
                                        <tr>
                                                        <td>Does your TMJ (jaw joint) click or pop?</td>
                                                        <td><?php echo  $tmj_cp;?></td>

                                                        <td id="tmj_cp_extra">Please describe: <?php echo  $tmj_cp_text; ?>

                                                </td>
                                        </tr>
                <?php } ?>
                <?php if($tmj_pain == 'Yes' || $tmj_pain_text != ''){ ?>
                                        <tr>
                                                        <td>Do you have pain in this joint?</td>
                                                        <td><?php echo  $tmj_pain;?></td>

                                                        <td id="tmj_pain_extra">Please describe: <?php echo  $tmj_pain_text; ?>
                                                </td>
                                        </tr>

                <?php } ?>
                <?php if($tmj_surgery == 'Yes' || $tmj_surgery_text != ''){ ?>
                                        <tr>
                                                        <td>Have you had TMJ (jaw joint) surgery?</td>
                                                        <td><?php echo  $tmj_surgery;?></td>
                                                        <td id="tmj_surgery_extra">Please describe: <?php echo  $tmj_surgery_text; ?>
</td>

                                        </tr>
                <?php } ?>
                <?php if($gum_prob == 'Yes' || $gum_prob_text != ''){ ?>
                                        <tr>
                                                        <td>Have you ever had gum problems?</td>
                                                        <td><?php echo  $gum_prob;?></td>

                                                        <td id="gum_prob_extra">Please describe: <?php echo  $gum_prob_text; ?>
                                                </td>
                                        </tr>
                <?php } ?>
                <?php if($gum_surgery == 'Yes' || $gum_surgery_text != ''){ ?>

                                        <tr>
                                                        <td>Have you ever had gum surgery?</td>

                                                        <td><?php echo  $gum_surgery; ?></td>
                                                        <td id="gum_surgery_extra">Please describe: <?php echo  $gum_surgery_text; ?>
                                                </td>
                                        </tr>

                <?php } ?>
                <?php if($drymouth == 'Yes' || $drymouth_text != ''){ ?>

                                        <tr>
                                                        <td>Do you have morning dry mouth?</td>

                                                        <td><?php echo  $drymouth;?></td>
                                                        <td id="drymouth_extra">Please describe: <?php echo  $drymouth_text; ?>
                                                </td>
                                        </tr>
                <?php } ?>
                <?php if($injury == 'Yes' || $injury_text != ''){ ?>

                                 <tr>
                                                        <td>Have you ever had injury to your head, face, neck, mouth, or teeth?</td>

                                                        <td><?php echo  $injury; ?></td>
                                                        <td id="injury_extra">Please describe: <?php echo  $injury_text; ?>
                                                </td>
                                        </tr>
                <?php } ?>
                <?php if($completed_future == 'Yes' || $future_dental_det != ''){ ?>
                                        <tr>
                                                        <td>Are you planning to have dental work done in the near future?</td>


                                                        <td><?php echo $completed_future;?></td>

<td id="completed_future_extra">Please describe: <?php echo  $future_dental_det; ?>
</td>
                                        </tr>
                <?php } ?>
                <?php if(!empty($clinch_teeth) && $clinch_teeth == 'Yes' || $clinch_grind_text != ''){ ?>
                                        <tr>
                                                        <td>Do you clinch or grind your teeth?</td>

                                                        <td><?php echo  $clinch_grind; ?></td>

                                                        <td id="clinch_grind_extra">Please describe: <?php echo  $clinch_grind_text; ?>
                                                </td>
                                        </tr>
                <?php } ?>
</table>
<label class="desc" id="title0" for="Field0">
                        Family History
                    </label>
                <?php if($family_hd == 'Yes'){ ?>
                    <div>
                        <span class="full">
                                <label>Have genetic members of your family had Heart Disease?</label>
                                <?php echo  $family_hd; ?>

                        </span>
                    </div>
                <?php } ?>
                <?php if($family_bp == 'Yes'){ ?>
                    <div>
                        <span>
                                <label>High Blood Pressure?</label>
                                 <?php echo  $family_bp; ?>
                        </span>
                    </div>
                <?php } ?>
                <?php if($family_dia == 'Yes'){ ?>
                    <div>
                        <span>
                             <label>Diabetes?</label>
                             <?php echo  $family_dia; ?>
                                        </span>
                </div>
                <?php } ?>
                <?php if($family_sd == 'Yes'){ ?>
                <div>
                        <span>
                                <label>Have any genetic members of your family been diagnosed or treated for a sleep disorder?</label>
                                <?php echo  $family_sd; ?>
                        </span>

                </div>
                <?php } ?>

                <label class="desc" id="title0" for="Field0">
                        SOCIAL HISTORY
                    </label>
                <?php if($alcohol != ''){ ?>
                                Alcohol consumption: How often do you consume alcohol within 2-3 hours of bedtime?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo  $alcohol;?>
                            <br /><br />
                <?php } ?>
                <?php if($sedative != ''){ ?>
                            Sedative Consumption: How often do you take sedatives within 2-3 hours of bedtime?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo  $sedative;?>
                            <br /><br />
                <?php } ?>
                <?php if($caffeine != ''){ ?>

                            Caffeine consumption: How often do you consume caffeine within 2-3 hours of bedtime?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo  $caffeine;?>
                            <br /><br />
                <?php } ?>
                <?php if($smoke != ''){ ?>
                            Do you Smoke?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo  $smoke;?>


                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div id="smoke">If Yes, number of packs per day
                            <?php echo $smoke_packs?>

                            </div>
                            <br /><br />
                <?php } ?>
                <?php if($tobacco != ''){ ?>
                            Do you use Chewing Tobacco?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo  $tobacco;?>

                        </span>
                <br /><br />
                <?php } ?>
                <?php if($additional_paragraph != ''){ ?>
                <div>
                        <span>
                                Additional Paragraph<br />
                            <textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $additional_paragraph;?></textarea>

                        </span>
                    </div>
                <?php } ?>
</div>





<?php include "includes/bottom.htm"; ?>
