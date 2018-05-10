<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once('includes/patient_info.php');

$baseTable = 'dental_ex_page5_view';
$baseSearch = [
    'patientid' => '$patientId',
    'docid' => '$docId'
];

/**
 * Define $patientId, $docId, $userId, $adminId
 * Define $isHistoricView, $historyId, $snapshotDate
 * Define $historyTable, $sourceTable
 * Define $isCreateNew, $isBackupTable
 *
 * Backup tables as needed
 */
require_once __DIR__ . '/includes/form-backup-setup.php';

if (empty($patient_info)) { ?>
    <div style="width: 65%; margin: auto;">
        Patient information incomplete -- Please complete the required fields in Patient info section to enable this page.
    </div>
    <?php

    include "includes/bottom.htm";
    trigger_error('Die called', E_USER_ERROR);
}

if (!$isHistoricView && !empty($_POST['ex_page5sub']) && $_POST['ex_page5sub'] == 1) {
			$additional_paragraph_pal = $_POST['additional_paragraph_pal'];
			$caries = (!empty($_POST['caries']) ? $_POST['caries'] : '');
			$joint_exam = $_POST['joint_exam'];
			$i_opening_from = $_POST['i_opening_from'];
			$i_opening_to = (!empty($_POST['i_opening_to']) ? $_POST['i_opening_to'] : '');
			$i_opening_equal = (!empty($_POST['i_opening_equal']) ? $_POST['i_opening_equal'] : '');
			$protrusion_from = $_POST['protrusion_from'];
			$protrusion_to = $_POST['protrusion_to'];
			if($protrusion_from !='' && $protrusion_to != ''){
			  $protrusion_equal = abs($protrusion_to-$protrusion_from);
			}else{
			  $protrusion_equal = $_POST['protrusion_equal'];
			}
	
			$l_lateral_from = $_POST['l_lateral_from'];
			$l_lateral_to = (!empty($_POST['l_lateral_to']) ? $_POST['l_lateral_to'] : '');
			$l_lateral_equal = (!empty($_POST['l_lateral_equal']) ? $_POST['l_lateral_equal'] : '');
			$r_lateral_from = $_POST['r_lateral_from'];
			$r_lateral_to = (!empty($_POST['r_lateral_to']) ? $_POST['r_lateral_to'] : '');
			$r_lateral_equal = (!empty($_POST['r_lateral_equal']) ? $_POST['r_lateral_equal'] : '');
			$deviation_from = (!empty($_POST['deviation_from']) ? $_POST['deviation_from'] : '');
			$deviation_to = (!empty($_POST['deviation_to']) ? $_POST['deviation_to'] : '');
			$deviation_equal = (!empty($_POST['deviation_equal']) ? $_POST['deviation_equal'] : '');
			$deflection_from = $_POST['deflection_from'];
			$deflection_to = (!empty($_POST['deflection_to']) ? $_POST['deflection_to'] : '');
			$deflection_equal = (!empty($_POST['deflection_equal']) ? $_POST['deflection_equal'] : '');
			$range_normal = (!empty($_POST['range_normal']) ? $_POST['range_normal'] : '');
			$normal = (!empty($_POST['normal'])) ? $_POST['normal'] : '';
			$other_range_motion = (!empty($_POST['other_range_motion']) ? $_POST['other_range_motion'] : '');
			$additional_paragraph_rm = $_POST['additional_paragraph_rm'];
			$deviation_r_l = $_POST['deviation_r_l'];
			$deflection_r_l = $_POST['deflection_r_l'];
			
			$palpation_sql = "select * from dental_palpation where status=1 order by sortby";
			
			$palpation_my = $db->getResults($palpation_sql);
			$pal_arr = '';
			$palR_arr = '';
			if ($palpation_my) foreach ($palpation_my as $palpation_myarray)
			{
				if($_POST['palpation_'.$palpation_myarray['palpationid']] <> '')
				{
					$pal_arr .= $palpation_myarray['palpationid'].'|'.$_POST['palpation_'.$palpation_myarray['palpationid']].'~';
				}
				
				if($_POST['palpationR_'.$palpation_myarray['palpationid']] <> '')
				{
					$palR_arr .= $palpation_myarray['palpationid'].'|'.$_POST['palpationR_'.$palpation_myarray['palpationid']].'~';
				}
			}
			
			$joint_sql = "select * from dental_joint where status=1 order by sortby";
			
			$joint_my = $db->getResults($joint_sql);
			$joi_arr = '';
			if ($joint_my) foreach ($joint_my as $joint_myarray)
			{
				if($_POST['joint_'.$joint_myarray['jointid']] <> '')
				{
					$joi_arr .= $joint_myarray['jointid'].'|'.$_POST['joint_'.$joint_myarray['jointid']].'~';
				}
			}
			
			$join_exam_arr = '';
			if(is_array($joint_exam))
			{
				if (!isset($joint_exam_arr)) {
					$joint_exam_arr = "";
				}

				foreach($joint_exam as $val)
				{
					if(trim($val) <> '')
						$joint_exam_arr .= trim($val).'~';
				}
			}
			if($joint_exam_arr != '')
				$joint_exam_arr = '~'.$joint_exam_arr;

			$sql = "select * from dental_summary_view where patientid='".$_GET['pid']."'";
			$num = $db->getNumberRows($sql);

	        if($num==0)
	        {
                $ins_sql = " insert into dental_summary set 
                patientid = '".s_for($_GET['pid'])."',
                initial_device_titration_1 = '".s_for($_POST['initial_device_titration_1'])."',
                initial_device_titration_equal_h = '".s_for($_POST['initial_device_titration_equal_h'])."',
                initial_device_titration_equal_v = '".s_for($_POST['initial_device_titration_equal_v'])."',
                optimum_echovision_ver = '".s_for($_POST['optimum_echovision_ver'])."',
                optimum_echovision_hor = '".s_for($_POST['optimum_echovision_hor'])."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
                
                $db->query($ins_sql);
	        }else{
                $ed_sql = "update dental_summary_view set 
                initial_device_titration_1 = '".s_for($_POST['initial_device_titration_1'])."',
                initial_device_titration_equal_h = '".s_for(!empty($_POST['initial_device_titration_equal_h']) ? $_POST['initial_device_titration_equal_h'] : '')."',
                initial_device_titration_equal_v = '".s_for($_POST['initial_device_titration_equal_v'])."',
                optimum_echovision_ver = '".s_for($_POST['optimum_echovision_ver'])."',
                optimum_echovision_hor = '".s_for($_POST['optimum_echovision_hor'])."'
                 where patientid = '".s_for($_GET['pid'])."'";
                
                $db->query($ed_sql);
	        }

			if($_POST['ed'] == '') {
				$ins_sql = " insert into dental_ex_page5 set 
				patientid = '".s_for($_GET['pid'])."',
				palpationid = '".s_for($pal_arr)."',
				palpationRid = '".s_for($palR_arr)."',
				additional_paragraph_pal = '".s_for($additional_paragraph_pal)."',
				joint_exam = '".s_for($joint_exam_arr)."',
				jointid = '".s_for($joi_arr)."',
				i_opening_from = '".s_for($i_opening_from)."',
				i_opening_to = '".s_for($i_opening_to)."',
				i_opening_equal = '".s_for($i_opening_equal)."',
				protrusion_from = '".s_for($protrusion_from)."',
				protrusion_to = '".s_for($protrusion_to)."',
				protrusion_equal = '".s_for($protrusion_equal)."',
				l_lateral_from = '".s_for($l_lateral_from)."',
				l_lateral_to = '".s_for($l_lateral_to)."',
				l_lateral_equal = '".s_for($l_lateral_equal)."',
				r_lateral_from = '".s_for($r_lateral_from)."',
				r_lateral_to = '".s_for($r_lateral_to)."',
				r_lateral_equal = '".s_for($r_lateral_equal)."',
				deviation_from = '".s_for($deviation_from)."',
				deviation_to = '".s_for($deviation_to)."',
				deviation_equal = '".s_for($deviation_equal)."',
				deflection_from = '".s_for($deflection_from)."',
				deflection_to = '".s_for($deflection_to)."',
				deflection_equal = '".s_for($deflection_equal)."',
				range_normal = '".s_for($range_normal)."',
				normal = '".s_for($normal)."',
				other_range_motion = '".s_for($other_range_motion)."',
				additional_paragraph_rm = '".s_for($additional_paragraph_rm)."',
				deviation_r_l = '".s_for($deviation_r_l)."',
				deflection_r_l = '".s_for($deflection_r_l)."',
				userid = '".s_for($_SESSION['userid'])."',
				docid = '".s_for($_SESSION['docid'])."',
				adddate = now(),
				ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
				
				$db->query($ins_sql);
				
				$msg = "Added Successfully";
		        if(isset($_POST['ex_pagebtn_proceed'])){
?>
	                <script type="text/javascript">
                        window.location='ex_page4.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
	                </script>
<?php
		        } else {
?>
					<script type="text/javascript">
						window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
					</script>
<?php
				}
				trigger_error("Die called", E_USER_ERROR);
			} else {
				$ed_sql = " update dental_ex_page5_view set 
				palpationid = '".s_for($pal_arr)."',
				palpationRid = '".s_for($palR_arr)."',
				additional_paragraph_pal = '".s_for($additional_paragraph_pal)."',
				joint_exam = '".s_for($joint_exam_arr)."',
				jointid = '".s_for($joi_arr)."',
				i_opening_from = '".s_for($i_opening_from)."',
				i_opening_to = '".s_for($i_opening_to)."',
				i_opening_equal = '".s_for($i_opening_equal)."',
				protrusion_from = '".s_for($protrusion_from)."',
				protrusion_to = '".s_for($protrusion_to)."',
				protrusion_equal = '".s_for($protrusion_equal)."',
				l_lateral_from = '".s_for($l_lateral_from)."',
				l_lateral_to = '".s_for($l_lateral_to)."',
				l_lateral_equal = '".s_for($l_lateral_equal)."',
				r_lateral_from = '".s_for($r_lateral_from)."',
				r_lateral_to = '".s_for($r_lateral_to)."',
				r_lateral_equal = '".s_for($r_lateral_equal)."',
				deviation_from = '".s_for($deviation_from)."',
				deviation_to = '".s_for($deviation_to)."',
				deviation_equal = '".s_for($deviation_equal)."',
				deflection_from = '".s_for($deflection_from)."',
				deflection_to = '".s_for($deflection_to)."',
				deflection_equal = '".s_for($deflection_equal)."',
				range_normal = '".s_for($range_normal)."',
				normal = '".s_for($normal)."',
				other_range_motion = '".s_for($other_range_motion)."',
				additional_paragraph_rm = '".s_for($additional_paragraph_rm)."',
				deviation_r_l = '".s_for($deviation_r_l)."',
				deflection_r_l = '".s_for($deflection_r_l)."'
				where ex_page5id = '".s_for($_POST['ed'])."'";
		
				$db->query($ed_sql);
				
				$msg = "Edited Successfully";
		        if(isset($_POST['ex_pagebtn_proceed'])){
?>
	                <script type="text/javascript">
                        window.location='ex_page4.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
	                </script>
<?php
		        } else {
?>
					<script type="text/javascript">
						window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
					</script>
<?php
				}
				trigger_error("Die called", E_USER_ERROR);
			}
		}

		$sqls = "select * from dental_summary_view where patientid='".$_GET['pid']."'";

		$myarrays = $db->getRow($sqls);
		$initial_device_titration_1 = $myarrays['initial_device_titration_1'];
		$initial_device_titration_equal_h = $myarrays['initial_device_titration_equal_h'];
		$initial_device_titration_equal_v = $myarrays['initial_device_titration_equal_v'];
		$optimum_echovision_ver = $myarrays['optimum_echovision_ver'];
		$optimum_echovision_hor = $myarrays['optimum_echovision_hor'];

		$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
		
		$pat_myarray = $db->getRow($pat_sql);
		$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

		if($pat_myarray['patientid'] == '')
		{
?>
			<script type="text/javascript">
				window.location = 'manage_patient.php';
			</script>
<?php
			trigger_error("Die called", E_USER_ERROR);
		}

$sql = "SELECT *
    FROM $sourceTable
    WHERE patientid = '$patientId'
        $andHistoryIdConditional
        $andNullConditional";
		
		$myarray = $db->getRow($sql);
		$ex_page5id = st($myarray['ex_page5id']);
		$palpationid = st($myarray['palpationid']);
		$palpationRid = st($myarray['palpationRid']);
		$additional_paragraph_pal = st($myarray['additional_paragraph_pal']);
		$joint_exam = st($myarray['joint_exam']);
		$jointid = st($myarray['jointid']);
		$i_opening_from = st($myarray['i_opening_from']);
		$i_opening_to = st($myarray['i_opening_to']);
		$i_opening_equal = st($myarray['i_opening_equal']);
		$protrusion_from = st($myarray['protrusion_from']);
		$protrusion_to = st($myarray['protrusion_to']);
		$protrusion_equal = st($myarray['protrusion_equal']);
		$l_lateral_from = st($myarray['l_lateral_from']);
		$l_lateral_to = st($myarray['l_lateral_to']);
		$l_lateral_equal = st($myarray['l_lateral_equal']);
		$r_lateral_from = st($myarray['r_lateral_from']);
		$r_lateral_to = st($myarray['r_lateral_to']);
		$r_lateral_equal = st($myarray['r_lateral_equal']);
		$deviation_from = st($myarray['deviation_from']);
		$deviation_to = st($myarray['deviation_to']);
		$deviation_equal = st($myarray['deviation_equal']);
		$deflection_from = st($myarray['deflection_from']);
		$deflection_to = st($myarray['deflection_to']);
		$deflection_equal = st($myarray['deflection_equal']);
		$range_normal = st($myarray['range_normal']);
		$normal = st($myarray['normal']);
		$other_range_motion = st($myarray['other_range_motion']);
		$additional_paragraph_rm = st($myarray['additional_paragraph_rm']);
		$deviation_r_l = st($myarray['deviation_r_l']);
		$deflection_r_l = st($myarray['deflection_r_l']);

		if($palpationid <> '')
		{	
			$pal_arr1 = explode('~',$palpationid);
			
			foreach($pal_arr1 as $i => $val)
			{
				$pal_arr2 = explode('|',$val);
				
				$palid[$i] = $pal_arr2[0];
				$palseq[$i] = isset($pal_arr2[1]) ? $pal_arr2[1] : '';
			}
		}

$selectedPalpations = [];
$explodedPalpations = [
    'left' => explode('~', $palpationid),
    'right' => explode('~', $palpationRid)
];

foreach ($explodedPalpations as $side=>$list) {
    foreach ($list as $pair) {
        // Add extra separators to avoid empty array elements
        list($index, $value) = explode('|', "$pair|");
        array_set($selectedPalpations, "$index.$side", $value);
    }
}

		if($jointid <> '')
		{	
			$jo_arr1 = explode('~',$jointid);
			
			foreach($jo_arr1 as $i => $val)
			{
				$jo_arr2 = explode('|',$val);
				
				$joid[$i] = $jo_arr2[0];
				$joseq[$i] = (!empty($jo_arr2[1]) ? $jo_arr2[1] : '');
			}
		}

$palpationValues = [
    0 => [
        'label' => 0,
        'class' => 'ex_p5_0',
    ],
    1 => [
        'label' => 1,
        'class' => 'ex_p5_1',
    ],
    2 => [
        'label' => 2,
        'class' => 'ex_p5_2',
    ],
    3 => [
        'label' => 3,
        'class' => 'ex_p5_3',
    ],
];

$stages = [
    'early' => 'Early',
    'middle' => 'Middle',
    'late' => 'Late',
];

$soundValues = [
    'L' => 'L',
    'R' => 'R',
    'B' => 'B',
    'WNL' => 'WNL'
];

$palpations = $db->getResults("SELECT *
    FROM dental_palpation
    WHERE `status` = 1
    ORDER BY sortby");
$maxRows = ceil(count($palpations)/2);

$jointExams = $db->getResults("SELECT *
    FROM dental_joint_exam
    WHERE `status` = 1
    ORDER BY sortby");

$joints = $db->getResults("SELECT *
    FROM dental_joint
    WHERE `status` = 1
    ORDER BY sortby");

?>
	<script>
		var jointExamTypes = <?= json_encode($jointExams) ?>;
		var jointSoundTypes = <?= json_encode($joints) ?>;
	</script>
	<script type="text/javascript" src="js/ex_page5.js"></script>
	<script type="text/javascript" src="/manage/js/summ_summ_check.js"></script>
	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen"/>
	<script src="admin/popup/popup1.js" type="text/javascript"></script>

	<link rel="stylesheet" href="css/form.css" type="text/css" />
	<style>
		input.error {
            color: red;
		}
	</style>

	<a name="top"></a>
	&nbsp;&nbsp;

	<?php include("includes/form_top.htm");?>

	<br /><br>
	<div align="center" class="red">
		<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
	</div>

<form id="tmj-rom" class="ex_form vue-module" name="ex_page5frm"
      v-bind:raw-joint-exams="<?= e(json_encode($jointExams)) ?>"
      action="?pid=<?= intval($_GET['pid']) ?><?= $isHistoricView ? "&history_id=$historyId" : '' ?>"
      method="post">
    <input type="hidden" name="patient_id" value="<?= $patientId ?>" />
    <input type="hidden" name="history_id" value="<?= $historyId ?>" />
    <input type="hidden" name="create_new" value="<?= $isCreateNew ?>" />
		<div style="float:right;">
        <button class="save-action hidden"
                title="Save a copy of the last saved values"
                v-bind:disabled="backupInProgress ? true : false"
                v-on:click.prevent="backup">
            <span v-show="!backupInProgress">Archive page</span>
            <span v-show="backupInProgress">Archiving... <img src="/manage/images/loading.gif" alt=""></span>
        </button>
        <button class="save-action" v-on:click.prevent="resetData">Undo Changes</button>
        <button class="save-action" v-on:click.prevent="save">Save</button>
        <button class="save-action" v-on:click.prevent="saveAndProceed">Save And Proceed</button>
        &nbsp;&nbsp;&nbsp;
    </div>
    <div is="errors-display" v-bind:errors="errors"></div>
		<table style="clear:both;" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
			<tr>
		        <td valign="top" class="frmhead">
		        	<ul>
		                <li id="foli8" class="complex">
		                    <label class="desc" id="title0" for="Field0">
		                      	Muscles & manual palpation
		                    </label>
							<br />
		                    <div is="muscle-palpation-selector"
                                 v-bind:setter.sync="dynamic.musclePalpationDefaults"
                                 v-bind:getter.sync="dynamic.musclePalpation"
                                 v-bind:stop-callbacks="<?= $historyId ? 'true' : 'false' ?>"
                                 v-bind:doc-id="<?= $docId ?>"></div>
                    		<br />
                    </li>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            Additional paragraph
                            /
                            <button v-on:click.prevent="loadCustomText('additional_paragraph_pal')">
                                Custom text
                            </button>
                        </label>
                        <div>
                            <span>
                                <textarea class="field text addr tbox" style="width:650px; height:100px;"
                                    name="additional_paragraph_pal"
                                    v-model="form.additional_paragraph_pal"><?= e($additional_paragraph_pal) ?></textarea>
                            </span>
                        </div>
                		<br />
                    </li>
                </ul>
            </td>
		    </tr>
		    <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">Joint sounds</label>
                        <div>
                            <span style="width:350px;">
                                Examination type:
                            </span>
                            <span>L = Left, R = Right, B = Both, WNL = Within normal limits</span>
                            <a href="#" class="button form-backup-disable"
                               v-on:click.prevent="setJointSoundsCallback()">Set all to WNL</a>
                        </div>
                        <table width="100%" cellpadding="3" cellspacing="1">
                            <tr>
                                <td valign="top" width="40%">
                                    <?php foreach ($jointExams as $current) { ?>
                                        <input type="checkbox" style="width:auto;"
                                            id="joint_type_<?= $current['joint_examid'] ?>"
                                            name="joint_exam[<?= $current['joint_examid'] ?>]"
                                            v-model="dynamic.jointExams[<?= $current['joint_examid'] ?>]"
                                            v-bind:true-value="1" v-bind:false-value="0" />
                                        &nbsp;&nbsp;
                                        <label for="joint_type_<?= $current['joint_examid'] ?>">
                                            <?= e($current['joint_exam']) ?>
                                        </label>
                                        <br/>
                                    <?php } ?>
                                </td>
                                <td valign="top">
                                    <table width="100%" cellpadding="3" cellspacing="1">
                                        <?php foreach ($joints as $current) { ?>
                                            <tr>
                                                <td valign="top" width="40%">
                                                    <span>
                                                        <?= e($current['joint']) ?>
                                                    </span>
                                                </td>
                                                <td valign="top">
                                                    <select class="field text addr tbox" style="width:60px;"
                                                        name="joint_<?= $current['jointid'] ?>"
                                                        v-model="dynamic.jointSounds[<?= $current['jointid'] ?>].position">
                                                        <option value=""></option>
                                                        <?= dropdown($soundValues) ?>
                                                    </select>
                                                    <?php if (in_array($current['joint'], ['Closing click', 'Opening click'])) { ?>
                                                        <select style="width:65px;"
                                                            name="jointid_stages[<?= $current['jointid'] ?>]"
                                                            v-model="dynamic.jointSounds[<?= $current['jointid'] ?>].stage">
                                                            <option></option>
                                                            <?= dropdown($stages) ?>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <table width="100%" cellpadding="3" cellspacing="1">
                            <colgroup>
                                <col width="27%"/>
                                <col width="20%"/>
                                <col width="6%"/>
                                <col width="27%"/>
                                <col width="20%"/>
                            </colgroup>
                            <tr>
                                <th colspan="5">
                                    <label class="desc">
                                        Range of motion
                                    </label>
                                </th>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <span>
                                    Interincisal opening
                                    </span>
                                </td>
                                <td valign="top">
                                    <span>
                                        <input type="text" class="field text addr tbox" style="width:50px;"
                                            name="i_opening_from"
                                            v-model="form.i_opening_from" />mm
                                    </span>
                                </td>
                                <td></td>
                                <td colspan="2" valign="top">
                                    <span>
                                        Best eccovision
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <span>Protrusive range (min to max)</span>
                                </td>
                                <td valign="top">
                                    <input type="text" class="field text addr tbox" style="width:50px;"
                                        name="protrusion_from"
                                        v-model="form.protrusion_from" />
                                    to
                                    <input type="text" class="field text addr tbox" style="width:50px;"
                                        name="protrusion_to"
                                        v-model="form.protrusion_to" />
                                </td>
                                <td></td>
                                <td valign="top">
                                    <span style="padding-left:30px">Horizontal</span>
                                </td>
                                <td valign="top">
                                    <input type="text" size="5"
                                        name="optimum_echovision_hor"
                                        v-model="eccovisionHorizontal" />mm
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <span>
                                        Protrusion total (automatically calculated from above)
                                    </span>
                                </td>
                                <td valign="top">
                                    <span>
                                        <input type="text" class="field text addr tbox" readonly style="width:50px;"
                                            v-bind:class="[protrusionRange < 0 ? 'error' : '']"
                                            v-bind:title="[protrusionRange < 0 ? 'The start of the range cannot be higher than the end' : '']"
                                            name="protrusion_equal"
                                            v-model="protrusionRange" />mm
                                    </span>
                                </td>
                                <td></td>
                                <td valign="top">
                                    <span style="padding-left:30px">Vertical</span>
                                </td>
                                <td valign="top">
                                    <input type="text" size="5"
                                        name="optimum_echovision_ver"
                                        v-model="eccovisionVertical" />mm
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <span>
                                        Left lateral excursion
                                    </span>
                                </td>
                                <td valign="top">
                                    <span>
                                        <input type="text" class="field text addr tbox" style="width:50px;"
                                            name="l_lateral_from"
                                            v-model="form.l_lateral_from" />mm
                                    </span>
                                </td>
                                <td></td>
                                <td colspan="2" valign="top">
                                    <span>
                                        Initial device setting
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <span>
                                        Right lateral excursion
                                    </span>
                                </td>
                                <td valign="top">
                                    <span>
                                        <input type="text" class="field text addr tbox" style="width:50px;"
                                            name="r_lateral_from"
                                            v-model="form.r_lateral_from" />mm
                                    </span>
                                </td>
                                <td></td>
                                <td valign="top">
                                    <span style="padding-left:30px">
                                        Incisal edge position (George/Pro gauge setting)
                                    </span>
                                </td>
                                <td valign="top">
                                    <input type="text" size="5"
                                        v-on:change="checkIncisal"
                                        name="initial_device_titration_1"
                                        v-model="deviceSettingsIncisal" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <span>
                                        Deviation
                                    </span>
                                    &nbsp;&nbsp;
                                    <select class="field text addr tbox" style="width:60px;"
                                        name="deviation_r_l"
                                        v-model="form.deviation_r_l">
                                        <option></option>
                                        <option>WNL</option>
                                        <option>Right</option>
                                        <option>Left</option>
                                    </select>
                                </td>
                                <td valign="top">
                                    <span>
                                        <input type="text" class="field text addr tbox" style="width:50px;"
                                            name="deviation_from"
                                            v-model="form.deviation_from" />mm
                                    </span>
                                </td>
                                <td></td>
                                <td valign="top">
                                    <span style="padding-left:30px">Vertical</span>
                                </td>
                                <td valign="top">
                                    <input type="text" size="5"
                                        name="optimum_echovision_ver"
                                        v-model="deviceSettingsVertical" />mm
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <span>
                                        Deflection
                                    </span>
                                    &nbsp;
                                    <select class="field text addr tbox" style="width:60px;"
                                        name="deflection_r_l"
                                        v-model="form.deflection_r_l">
                                        <option></option>
                                        <option>WNL</option>
                                        <option>Right</option>
                                        <option>Left</option>
                                    </select>
                                </td>
                                <td valign="top">
                                    <span>
                                        <input type="text" class="field text addr tbox" style="width:50px;"
                                            name="deflection_from"
                                            v-model="form.deflection_from" />mm
                                    </span>
                                </td>
                                <td></td>
                                <td valign="top"></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td valign="top" colspan="2">
                                    NOTE: (Normal range of motion has been noted Vertical 40 - 50mm, Lateral 12mm,
                                    Protrusive 9mm)
                                </td>
                            </tr>
                        </table>
                        <br/>
                    </li>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            Additional paragraph
                            /
                            <button v-on:click.prevent="loadCustomText('additional_paragraph_rm')">
                                Custom text
                            </button>
                        </label>
                        <div>
                            <span>
                                <textarea class="field text addr tbox" style="width:650px; height:100px;"
                                    name="additional_paragraph_rm"
                                    v-model="form.additional_paragraph_rm"><?= e($additional_paragraph_rm) ?></textarea>
                            </span>
                        </div>
                        <br/>
                    </li>
                </ul>
            </td>
        </tr>
    </table>
    <div style="float:right;">
        <button class="save-action hidden"
                title="Save a copy of the last saved values"
                v-bind:disabled="backupInProgress ? true : false"
                v-on:click.prevent="backup">
            <span v-show="!backupInProgress">Archive page</span>
            <span v-show="backupInProgress">Archiving... <img src="/manage/images/loading.gif" alt=""></span>
        </button>
        <button class="save-action" v-on:click.prevent="resetData">Undo Changes</button>
        <button class="save-action" v-on:click.prevent="save">Save</button>
        <button class="save-action" v-on:click.prevent="saveAndProceed">Save And Proceed</button>
        &nbsp;&nbsp;&nbsp;
    </div>
</form>

	<br />
		<?php include("includes/form_bottom.htm");?>
	<br />
	<div id="popupRefer" style="width:750px;">
	    <a id="popupReferClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopupRef"></div>
	<div id="popupContact" style="width:750px;">
	    <a id="popupContactClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopup"></div>
	<div id="popupContact1" style="width:750px;">
	    <a id="popupContactClose1">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop1" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopup1"></div>
	<br /><br />	
<?php include __DIR__ . '/includes/vue-setup.htm'; ?>
<link rel="stylesheet" href="/assets/css/components/muscle-palpation-selector.css" />
<script type="text/javascript" src="/assets/app/components/muscle-palpation-selector.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/patient/exams/tmj-rom.js?v=20180406"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<?php

<?php include "includes/bottom.htm";?>
