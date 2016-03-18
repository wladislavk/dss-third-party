<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/general.htm';
require_once __DIR__ . '/includes/access.php';

$isSaveStudy = !empty($_POST['hst_id']);
$errorMessages = [];

// If Content-Length is set, and is bigger than 1 MB but there are no files, then we assume a failed upload
if (!empty($_SERVER['CONTENT_LENGTH']) && ($_SERVER['CONTENT_LENGTH'] >= 1024*1024) && !$_FILES) {
    error_log('Max file size exceeded AND PHP didn\'t populate FILES global variable, and POST might be corrupt');
    $errorMessages []= $maxFileSizeExceeded;

    // Abort any action
    $isSaveStudy = false;
}

if ($isSaveStudy) {
    $hstId = intval($_POST['hst_id']);
    $hstData = $db->getRow("SELECT * FROM dental_hst WHERE id = '$hstId'");

    if (!$hstData) { ?>
        <script type="text/javascript">
            window.location = '/manage/admin/manage_hsts.php?msg=<?= rawurlencode('The requested HST does not exist or has been deleted.') ?>';
        </script>
        <?php

        trigger_error('Die called', E_USER_ERROR);
    }

    //SAVE SLEEP TEST
    if ($_POST['status'] == DSS_HST_COMPLETE) {
        $sleepStudyIds = [];

        $patientId = intval($hstData['patient_id']);
        $docId = $db->getColumn("SELECT docid FROM dental_patients WHERE patientid = '$patientId'", 'docid', 0);

        foreach ($_POST['studies'] as $index=>$study) {
            $studyId = intval($study['id']);
            unset($study['id']);

            $uploadedFile = "ss_file_$index";

            $previousFile = $db->getRow("SELECT filename, image_id from dental_summ_sleeplab WHERE id = '$studyId'");
            $previousFile = $previousFile ?: [];

            $banner1 = $previousFile['filename'];
            $imageId = $previousFile['image_id'];

            if (isset($_FILES[$uploadedFile])) {
                $errorNo = $_FILES[$uploadedFile]['error'];

                if (isFaultyUpload($errorNo)) {
                    error_log("SS file upload error [{$errorNo}]: {$dss_file_upload_errors[$errorNo]}");
                    $errorMessages []= $maxFileSizeExceeded;
                } elseif (!$errorNo && !strlen(trim($_FILES[$uploadedFile]['name']))) {
                    error_log('SS file upload error: The file upload misses the filename');
                    $errorMessages []= $noFileName;
                } elseif (!$errorNo) {
                    $fname = $_FILES[$uploadedFile]['name'];
                    $lastdot = strrpos($fname, '.');

                    $name = substr($fname, 0, $lastdot);
                    $extension = substr($fname, $lastdot + 1);

                    $name = preg_replace('/[^a-z0-9_]+/i', '-', $name);
                    $extension = preg_replace('/[^a-z0-9_]+/i', '', $extension);

                    $banner1 = $name . '_' . date('dmy_Hi');
                    $banner1 .= '.' . $extension;

                    $uploaded = uploadImage($_FILES[$uploadedFile], '../../../../shared/q_file/' . $banner1);

                    if ($uploaded) {
                        if ($imageId) {
                            $imageData = $db->escapeAssignmentList([
                                'image_file' => $banner1,
                            ]);

                            $db->query("UPDATE dental_q_image SET $imageData
                                WHERE imageid = '$imageId'
                                    AND patientid = '$patientId'");

                            if (file_exists('../../../../shared/q_file/' . $banner1)) {
                                unlink('../../../../shared/q_file/' . $banner1);
                            }
                        } else {
                            $imageData = $db->escapeAssignmentList([
                                'patientid' => $patientId,
                                'title' => "{$study['sleeptesttype']} {$study['date']}",
                                'imagetypeid' => 1,
                                'image_file' => $banner1,
                                'userid' => $docId,
                                'docid' => $docId,
                                'ip_address' => $_SERVER['REMOTE_ADDR']
                            ]);

                            $imageId = $db->getInsertId("INSERT INTO dental_q_image SET $imageData, adddate = NOW()");
                        }
                    } else {
                        error_log('SS file upload save error. The error could be caused by an invalid filetype. ' . json_encode($_FILES));
                        $errorMessages []= $maxFileSizeExceeded;
                        $banner1 = '';
                    }
                }
            }

            /**
             * @see DSS-365
             *
             * This column name has a typo
             */
            $study['patiendid'] = $patientId;
            $study['filename'] = $banner1;
            $study['image_id'] = $imageId;

            $study = $db->escapeAssignmentList($study);

            if ($studyId) {
                $db->query("UPDATE dental_summ_sleeplab SET $study WHERE id = '$studyId'");
            } else {
                $studyId = $db->getInsertId("INSERT INTO dental_summ_sleeplab SET $study");
            }

            if ($studyId) {
                $sleepStudyIds []= $studyId;
            }
        }

        if ($sleepStudyIds) {
            $db->query("DELETE FROM dental_hst_sleeplab WHERE hst_id = '$hstId'");
            $db->query("INSERT INTO dental_hst_sleeplab (hst_id, sleep_id)
                VALUES ('$hstId', '" . join("'), ('$hstId', '", $sleepStudyIds) . "')");
        }
    }

    $hstData = $db->escapeAssignmentList([
        'office_notes' => $_POST['office_notes'],
        'rejected_reason' => $_POST['rejected_reason'],
        'sleep_study_id' => 0,
        'status' => $_POST['status'],
    ]);

    $andTimestamps = '';

    if ($hstData['status'] != $_POST['status']) {
        $andTimestamps .= ', updatedate = NOW()';

        if ($_POST['status'] == DSS_HST_REJECTED) {
            $andTimestamps .= ', rejecteddate = NOW()';
        }
    }

    $db->query("UPDATE dental_hst SET $hstData $andTimestamps WHERE id = '$hstId'");

    $msg = 'HST Updated Successfully';
    $status = !empty($_POST['ret_status']) ? '&status=' . rawurlencode($_POST['ret_status']) . '&from=view' : '';

    if (!$errorMessages) { ?>
        <script type='text/javascript'>
            parent.window.location = 'manage_hsts.php?msg=<?= $msg ?><?= $status ?>';
        </script>
        <?php

        trigger_error('Die called', E_USER_ERROR);
    }
}

$hstId = intval($_REQUEST['ed']);
$hstData = $db->getRow("SELECT * FROM dental_hst WHERE id = '$hstId'");

if (!$hstData) { ?>
    <script type="text/javascript">
        window.location = '/manage/admin/manage_hsts.php?msg=<?= rawurlencode('The requested HST does not exist or has been deleted.') ?>';
    </script>
    <?php

    trigger_error('Die called', E_USER_ERROR);
}

$patientData = $db->getRow("SELECT * FROM dental_patients WHERE patientid = '{$hstData['patient_id']}'");
$patientData = $patientData ?: [];

$doctorData = $db->getRow("SELECT * FROM dental_users WHERE userid = '{$patientData['docid']}'");
$doctorData = $doctorData ?: [];

/**
 * @see DSS-365
 *
 * Copy/paste here and in /manage/admin/view_hst_sleep_study.php
 */
$hstNights = intval($hstData['hst_nights']);
$sleepStudies = $db->getResults("SELECT *
    FROM dental_summ_sleeplab
    WHERE id IN (
        SELECT sleep_study_id
        FROM dental_hst
        WHERE id = '$hstId'

        UNION

        SELECT sleep_id
        FROM dental_hst_sleeplab
        WHERE hst_id = '$hstId'
    )
    ORDER BY id DESC");

/**
 * Empty case, to always show a studies table
 */
if (count($sleepStudies) < $hstNights) {
    $sleepStudies = array_merge($sleepStudies, array_fill(0, $hstNights - count($sleepStudies), []));
}

$showNights = count($sleepStudies) > 1 || $hstData['hst_type'] != 2;

if ($errorMessages) {
    $msg .= '<ul><li>' . join('</li><li>', $errorMessages) . '</li></ul>';
}

?>
<style>
.readonly {
  background-color: #cccccc;
}

.sub-question {
  border: 1px black solid;
  margin-top: 10px;
  margin-left: 20px;
  padding: 10px;
  display: none;
}

.question-indent {
  margin-top: 10px;
  margin-left: 20px;
}
</style>
<script language="javascript" type="text/javascript" src="script/preauth_validation.js"></script>
<script language="javascript" type="text/javascript" src="script/preauth_form_logic.js"></script>

<p class="text-center page-header lead">
    HST Request &mdash;
    Account: <code><?= e($doctorData['username']) ?></code>
    Name: <code><?= e($doctorData['first_name'] . ' ' . $doctorData['last_name']) ?></code>
    Patient: <code><?= e($patientData['firstname'] . ' ' . $patientData['lastname']) ?></code>
    Requested: <code><?= e($hstData['adddate']) ?></code>
</p>
<a href="/manage/admin/hst_request.php?hst_id=<?= $hstData['id'] ?><?=
        isset($_REQUEST['ret_status']) ? '&amp;status=' . e($_REQUEST['ret_status']) : ''
    ?>" title="View HST Form" class="btn btn-primary btn-sm">
    HST Form
    <span class="glyphicon glyphicon-eye-open"></span>
</a>

	<br /><br />
	
	<?php if(!empty($msg)) {?>
    <div align="center" class="text-danger">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="preauth_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <table class="table table-bordered table-hover">
        <tr>
            <td class="cat_head" width="30%">
               HST for <?= $hstData['patient_firstname']; ?> <?= $hstData['patient_lastname']; ?> 
            </td>
	    <td class="cat_head" width="35%">
		HST
	    </td>
	    <td class="cat_head" width="35%">
 		Patient
	    </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance Company
            </td>
            <td valign="top" class="frmdata">
	  <select name="ins_co_id" class="readonly form-control input-sm input-inline" onclick="return false;" readonly>
          <option value="">Select Insurance Company</option>
<?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$hstData['doc_id']."'";
                            $ins_contact_qry_run = mysqli_query($con,$ins_contact_qry);
                            while($ins_contact_res = mysqli_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($hstData['ins_co_id'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>;
                                
                                <?php } ?>
</select>
                <span class="text-danger">*</span>
            </td>
            <td valign="top" class="frmdata">
          <select name="pat_ins_co_id" class="readonly form-control input-sm input-inline" onclick="return false;" readonly>
<?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$hstData['doc_id']."'";
                            $ins_contact_qry_run = mysqli_query($con,$ins_contact_qry);
                            while($ins_contact_res = mysqli_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($patientData['p_m_ins_co'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>;

                                <?php } ?>
</select>
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_firstname" value="<?=$hstData['patient_firstname']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_firstname" value="<?=$patientData['firstname']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_lastname" value="<?=$hstData['patient_lastname']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_lastname" value="<?=$patientData['lastname']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add1" value="<?=$hstData['patient_add1'];?>"
                       class="tbox readonly form-control input-sm input-inline"readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_add1" value="<?=$patientData['add1'];?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address 2
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add2" value="<?=$hstData['patient_add2'];?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_add2" value="<?=$patientData['add2'];?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$hstData['patient_city']?>" name="patient_city"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$patientData['city']?>" name="pat_patient_city"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$hstData['patient_state']?>" name="patient_state"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$patientData['state']?>" name="pat_patient_state"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_zip" value="<?= $hstData['patient_zip']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_zip" value="<?= $patientData['zip']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Home Phone
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_home_phone" value="<?= $hstData['patient_home_phone']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_home_phone" value="<?= $patientData['home_phone']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Cell Phone
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_cell_phone" value="<?= $hstData['patient_cell_phone']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_cell_phone" value="<?= $patientData['cell_phone']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Work Phone
            </td>
            <td valign="top" class="frmdata">
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_work_phone" value="<?= $patientData['work_phone']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Email
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_email" value="<?= $hstData['patient_email']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_email" value="<?= $patientData['email']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Group Insurance #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_group_id" value="<?=$hstData['patient_ins_group_id']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_ins_group_id" value="<?=$patientData['p_m_ins_grp']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance ID #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_id" value="<?=$hstData['patient_ins_id']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_ins_id" value="<?=$patientData['p_m_ins_id']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_dob" value="<?=$hstData['patient_dob']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_dob" value="<?=$patientData['dob']?>"
                    class="tbox readonly form-control input-sm input-inline" readonly />
                <span class="text-danger">*</span>
            </td>

        </tr>
        <tr>
            <td valign="top" class="frmhead" width="30%">
                Notes to Office
            </td>
            <td valign="top" class="frmdata">
                <textarea name="office_notes" class="form-control input-sm"><?= $hstData['office_notes']; ?></textarea>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Status
            </td>
            <td valign="top" class="frmdata">
                <select id="status" name="status" class="tbox form-control input-sm input-inline">
			<option value="<?= DSS_HST_PENDING; ?>" <?= ($hstData['status']==DSS_HST_PENDING)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_PENDING]; ?></option>
			<option value="<?= DSS_HST_CONTACTED; ?>" <?= ($hstData['status']==DSS_HST_CONTACTED)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_CONTACTED]; ?></option>
                        <option value="<?= DSS_HST_SCHEDULED; ?>" <?= ($hstData['status']==DSS_HST_SCHEDULED)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_SCHEDULED]; ?></option>
                        <option value="<?= DSS_HST_COMPLETE; ?>" <?= ($hstData['status']==DSS_HST_COMPLETE)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_COMPLETE]; ?></option>
                        <option value="<?= DSS_HST_REJECTED; ?>" <?= ($hstData['status']==DSS_HST_REJECTED)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_REJECTED]; ?></option>
                <span class="text-danger">*</span>
            </td>
        </tr>
        <tr class="status_<?= DSS_HST_REJECTED; ?> status">
            <td valign="top" class="frmhead" width="30%">
                Rejected Reason
            </td>
            <td valign="top" class="frmdata">
                <textarea name="rejected_reason" class="form-control input-sm"><?= $hstData['rejected_reason']; ?></textarea>
            </td>
        </tr>
        <tr class="status_<?= DSS_HST_COMPLETE; ?> status">
            <td valign="top" class="frmhead" width="30%">
                HST
                <?= $hstData['hst_type'] == 2 ? 'with PAP' : '' ?>
                <?= $hstData['hst_type'] == 3 ? 'with OAT (titration)' : '' ?>
                <?= $showNights ? ' - ' . count($sleepStudies) . ' Night Study' : '' ?>
            </td>
            <td valign="top" colspan="2" class="frmdata">
                <?php include_once __DIR__ . '/view_hst_sleep_study.php'; ?>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="text-danger">
                    * Required Fields
                </span><br />
		<?php
		if(isset($_REQUEST['ret_status']) && $_REQUEST['ret_status'] != ''){
		?><input type="hidden" name="ret_status" value="<?= $_REQUEST['ret_status'] ?>"/><?php
		}
		?>
                <input type="hidden" name="hst_id" value="<?= $_REQUEST['ed'] ?>"/>
                <?php if ($hstData['status'] >= 0) { ?>
                  <input type="submit" value="Save HST" <?= ($hstData['status']==DSS_HST_REQUESTED)?'onclick="alert(\'HST must be authorized by user before edits are permitted.\');return false;"':''; ?> class="btn btn-primary">
                <?php } ?>
	  </td><td align="right">
            </td>
        </tr>
    </table>
    </form>
<?php

if ($hstData['status'] != DSS_HST_REQUESTED) {
    $patientName = $hstData['patient_firstname'] . ' ' . $hstData['patient_lastname'];
    $patientDOB = $hstData['patient_dob'] ? date('m/d/Y', strtotime($hstData['patient_dob'])) : 'unknown';
    $authorizedDate = $hstData['authorizeddate'] ? date('m/d/Y', strtotime($hstData['authorizeddate'])) : 'unknown';
    $authorizedName = $db->getColumn("SELECT CONCAT(first_name, ' ', last_name) AS name
        FROM dental_users
        WHERE userid = '{$hstData['authorized_id']}'", 'name');

    ?>
    <h1>Home Sleep Test Request</h1>
    <h3>Patient: <?= e($patientName ?: 'NOT SPECIFIED') ?></h3>
    <h3>DOB: <?= $patientDOB ?: 'NOT SPECIFIED' ?></h3>
    <h3>Requested by: <?= e($authorizedName ?: 'NOT SPECIFIED') ?></h3>
    <p>&nbsp;</p>
    <p>Dr. <?= e($authorizedName ?: 'NOT SPECIFIED') ?> has electronically requested a Home Sleep Test for
        <?= e($patientName ?: 'NOT SPECIFIED') ?> for Obstructive Sleep Apnea (OSA).</p>
    <p>Authorized on: <?= $authorizedDate ?: 'NOT SPECIFIED' ?></p>
<?php } ?>
  <script type="text/javascript">
    $('#status').change( function() {
      s = $(this).val();
      $('.status').hide();
      $('.status_'+s).show();
    });

    $(document).ready(function(){
      $('.status').hide();
      $('.status_<?=$hstData['status'];?>').show();
    });
  </script>
<?php include 'includes/bottom.htm'; ?>
