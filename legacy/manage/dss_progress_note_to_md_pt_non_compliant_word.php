<?php
namespace Ds3\Libraries\Legacy;

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=dss_progress_note_to_md_pt_non_compliant_".date('m-d-Y').".doc");
header("Pragma: no-cache");
header("Expires: 0");

include "admin/includes/main_include.php";

$db = new Db();

$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$pat_myarray = $db->getRow($pat_sql);

$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

if($pat_myarray['patientid'] == ''){?>
    <script type="text/javascript">
        window.location = 'manage_patient.php';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$ref_sql = "select * from dental_q_recipients where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$ref_myarray = $db->getRow($ref_sql);

$referring_physician = st($ref_myarray['referring_physician']);

$a_arr = explode(' ',$referring_physician);

if(st($pat_myarray['dob']) != '' ){
    $dob_y = date('Y',strtotime(st($pat_myarray['dob'])));
    $cur_y = date('Y');
    $age = $cur_y - $dob_y;
} else {
    $age = 'N/A';
}

$q3_sql = "select * from dental_q_page3_pivot where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$q3_myarray = $db->getRow($q3_sql);

$history = st($q3_myarray['history']);
$medications = st($q3_myarray['medications']);

$history_arr = explode('~',$history);
$history_disp = '';
foreach($history_arr as $val){
    if(trim($val) != ""){
        $his_sql = "select * from dental_history where historyid='".trim($val)."' and status=1 ";
        $his_myarray = $db->getRow($his_sql);

        if(st($his_myarray['history']) != ''){
            if($history_disp != '')
                $history_disp .= ' and ';
            $history_disp .= st($his_myarray['history']);
        }
    }
}

$medications_arr = explode('~',$medications);
$medications_disp = '';
foreach($medications_arr as $val){
    if(trim($val) != ""){
        $medications_sql = "select * from dental_medications where medicationsid='".trim($val)."' and status=1 ";
        $medications_myarray = $db->getRow($medications_sql);

        if(st($medications_myarray['medications']) != '') {
            if($medications_disp != '') {
                $medications_disp .= ', ';
            }
            $medications_disp .= st($medications_myarray['medications']);
        }
    }
}

$q2_sql = "select * from dental_q_page2_pivot where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$q2_myarray = $db->getRow($q2_sql);

$sleep_center_name = st($q2_myarray['sleep_center_name']);
$sleep_study_on = st($q2_myarray['sleep_study_on']);
$confirmed_diagnosis = st($q2_myarray['confirmed_diagnosis']);
$rdi = st($q2_myarray['rdi']);
$ahi = st($q2_myarray['ahi']);
$type_study = st($q2_myarray['type_study']);
$custom_diagnosis = st($q2_myarray['custom_diagnosis']);

$sleeplab_sql = "select * from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."'";
$sleeplab_myarray = $db->getRow($sleeplab_sql);

$sleeplab_name = st($sleeplab_myarray['company']);

$sum_sql = "select * from dental_summary_pivot where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$sum_myarray = $db->getRow($sum_sql);

$sti_o2_1 = st($sum_myarray['sti_o2_1']);

if(st($pat_myarray['gender']) == 'Female'){
    $h_h =  "Her";
    $s_h =  "She";
    $h_h1 =  "her";
} else {
    $h_h =  "His";
    $s_h =  "He";
    $h_h1 =  "him";
}?>

<br />
<span class="admin_head">
    DSS progress note to MD pt non compliant
</span>
<br />
<br /><br>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
    <tr>
        <td valign="top">

<?php date('F d, Y')?><br><br>

<strong>
    <?php nl2br($referring_physician);?>
</strong><br><br>

Re: <strong><?php echo $name?></strong> <br>
DOB: <strong><?php st($pat_myarray['dob'])?></strong><br><br>

Dear Dr. <strong><?php $a_arr[0];?></strong>,<br><br>

I write regarding our mutual Patient, <strong><?php echo $name;?></strong>.  As you recall, Patient is a <strong><?php echo $age;?></strong> year old <strong><?php $pat_myarray['gender']?></strong> with a PMH that includes <strong><?php echo $history_disp;?></strong>.  <strong><?php echo $h_h;?></strong> medications include <strong><?php echo $medications_disp?></strong>.  Patient had a <strong>sleep test <?php echo $type_study;?></strong> done at the <strong><?php $sleeplab_name?></strong> on <strong><?php echo date('F d, Y',strtotime($sleep_study_on))?></strong> which showed an AHI of <strong><?php echo $ahi?></strong> <?php if($rdi != '') {?>, RDI of <strong><?php $rdi?></strong> <?php }?> and low O2 of <strong><?php echo $sti_o2_1;?></strong>; <strong><?php echo $s_h;?></strong> was diagnosed with <strong><?php echo $confirmed_diagnosis;?> <?php echo $custom_diagnosis;?></strong>.  You referred <strong><?php echo $h_h1;?></strong> to me for treatment with a dental sleep device.<br><br>

We delivered a <strong>???</strong> dental device on <strong>???</strong>.  <br><br>

I regret to inform you that she has become non compliant with dental device therapy due to <strong>???</strong>.<br><br>

I am referring <?php echo $h_h1?> back to you to discuss other treatment alternatives.  Thank you again for the opportunity to participate in Patient�s therapy; please know that we will do our best to follow through with all patients to ensure successful treatment.<br><br>

Sincerely,<br><br><br><br>

<strong><?php $_SESSION['name']?>, DDS</strong><br><br>

CC: <strong><?php echo $name;?></strong>
<br><br>

        </td>
    </tr>
</table>
