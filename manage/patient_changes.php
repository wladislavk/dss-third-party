<?php
namespace Ds3\Libraries\Legacy;

use function in_array;

require_once __DIR__ . '/includes/top.htm';

$docId = intval($_SESSION['docid']);
$patientId = intval($_GET['pid']);
$mergeId = isset($_GET['merge_id']) ? intval($_GET['merge_id']) : 0;
$fromExternal = !empty($_GET['external']);

$psql = "SELECT *
    FROM dental_patients
    WHERE patientid = '$patientId'
        ANd docid = '$docId'";
$p = $db->getRow($psql);

if ($fromExternal) {
    $sql = "SELECT ep.*
        FROM dental_external_patients ep
            JOIN dental_patients p ON p.patientid = ep.patient_id
        WHERE ep.patient_id = '$patientId'
            AND ep.dirty = 1
            AND p.docid = '$docId'
        LIMIT 1
    ";
} else if ($mergeId) {
    $sql = "SELECT *
        FROM dental_patients
        WHERE patientid = '$mergeId'
            AND docid = '$docId'
            AND status NOT IN (1, 2)";
} else {
    $sql = "SELECT *
        FROM dental_patients
        WHERE parent_patientid = '$patientId'";
}

$c = $db->getRow($sql);

$fields = array();
$fields['firstname'] = "First Name";
$fields['middlename'] = "Middle Name";
$fields['lastname'] = "Last Name";
$fields['preferred_name'] = "Preferred Name";
$fields['email'] = "email";
$fields['home_phone'] = "Home Phone";
$fields['work_phone'] = "Work Phone";
$fields['cell_phone'] = "Cell Phone";
$fields['add1'] = "Address 1";
$fields['add2'] = "Address 2";
$fields['city'] = "City";
$fields['state'] = "State";
$fields['zip'] = "Zip";

$fields['dob'] = "Date of Birth";
$fields['gender'] = "Gender";
$fields['marital_status'] = "Marital Status";
$fields['ssn'] = "Social Security #";
$fields['preferredcontact'] = "Preferred Contact";
$fields['feet'] = "Height Feet";
$fields['inches'] = "Height Inches";
$fields['weight'] = "Weight";
$fields['bmi'] = "BMI";
$fields['emergency_name'] = "Emergency Name";
$fields['emergency_relationship'] = "Emergency Relationship";
$fields['emergency_number'] = "Emergency Number";
$fields['p_m_relation'] = "Relationship to Insured";
$fields['p_m_partyfname'] = "Insured First Name";
$fields['p_m_partymname'] = "Insured Middle Name";
$fields['p_m_partylname'] = "Insured Last Name";
$fields['p_m_gender'] = "Insured Gender";
$fields['p_m_relation'] = "Relationship to Insured";
$fields['ins_dob'] = "Insured Date of Birth";
//$fields['p_m_ins_co'] = "Insurance Company";
$fields['p_m_ins_id'] = "Insurance ID";
$fields['p_m_ins_grp'] = "Insurance Group";
$fields['p_m_ins_plan'] = "Insurance Plan";
$fields['p_m_ins_type'] = "Insurance Type";

$fields['has_s_m_ins'] = "Has Secondary Insurance?";
$fields['s_m_relation'] = "2nd Relationship to Insured";
$fields['s_m_partyfname'] = "2nd Insured First Name";
$fields['s_m_partymname'] = "2nd Insured Middle Name";
$fields['s_m_partylname'] = "2nd Insured Last Name";
$fields['s_m_gender'] = "2nd Insured Gender";
$fields['s_m_relation'] = "Relationship to 2nd Insured";
$fields['ins2_dob'] = "2nd Insured Date of Birth";
//$fields['s_m_ins_co'] = "2nd Insurance Company";
$fields['s_m_ins_id'] = "2nd Insurance ID";
$fields['s_m_ins_grp'] = "2nd Insurance Group";
$fields['s_m_ins_plan'] = "2nd Insurance Plan";
$fields['s_m_ins_type'] = "2nd Insurance Type";
$fields['employer'] = "Employer";
$fields['emp_add1'] = "Employer Address 1";
$fields['emp_add2'] = "Employer Address 2";
$fields['emp_city'] = "Employer City";
$fields['emp_state'] = "Employer State";
$fields['emp_zip'] = "Employer Zip";
$fields['emp_phone'] = "Employer Phone";
$fields['emp_fax'] = "Employer Fax";

$fields['docsleep'] = "Sleep MD";
$fields['docpcp'] = "Primary Care Physician";
$fields['docdentist'] = "Dentist";
$fields['docent'] = "ENT";
$fields['docmdother'] = "Other MD";
$doc_fields = array('docsleep', 'docpcp', 'docdentist', 'docent', 'docmdother');

$validKeys = array_keys(array_intersect_key($p, $c, $fields));
$fields = array_only($fields, $validKeys);
$p = array_only($p, $validKeys);
$c = array_only($c, $validKeys);

$emailsToUpdate = [];
$emailsInUse = [];

/**
 * Normalize dates, external data uses Y-m-d H-i-s, internal data uses m/d/Y
 */
foreach (['p', 'c'] as $which) {
    if (isset(${$which}['email'])) {
        $email = trim(${$which}['email']);

        if (strlen($email)) {
            $emailsToUpdate[] = $email;
        }
    }

    foreach (['dob', 'ins_dob', 'ins2_dob'] as $field) {
        if (!isset(${$which}[$field])) {
            continue;
        }

        $dateTime = strtotime(${$which}[$field]);

        if ($dateTime) {
            ${$which}[$field] = date('m/d/Y', $dateTime);
        }
    }

    foreach (['gender', 'p_m_gender', 's_m_gender'] as $field) {
        if (!isset(${$which}[$field])) {
            continue;
        }

        $gender = strtolower(${$which}[$field]);

        switch ($gender) {
            case 'm':
            case 'male':
                $gender = 'Male';
                break;
            case 'f':
            case 'female':
                $gender = 'Female';
                break;
            default:
                $gender = '';
        }

        ${$which}[$field] = $gender;
    }

    foreach (['p_m_relation', 's_m_relation'] as $field) {
        if (!isset(${$which}[$field])) {
            continue;
        }

        $relationship = strtolower(${$which}[$field]);

        switch ($relationship) {
            case 'self':
            case 'spouse':
            case 'child':
            case 'other':
                $relationship = ucfirst($relationship);
                break;
            default:
                $relationship = '';
        }

        ${$which}[$field] = $relationship;
    }

    foreach (['marital_status'] as $field) {
        if (!isset(${$which}[$field])) {
            continue;
        }

        $status = strtolower(${$which}[$field]);

        switch ($status) {
            case 'married':
            case '1':
                $status = 'Married';
                break;
            case 'single':
            case '2':
                $status = 'Single';
                break;
            case 'life partner':
            case '3':
                $status = 'Life Partner';
                break;
            case 'minor':
            case '4':
                $status = 'Minor';
                break;
            default:
                $status = '';
        }

        ${$which}[$field] = $status;
    }
}

if (count($emailsToUpdate)) {
    $escapedEmails = $db->escapeList($emailsToUpdate);
    $andExcludeMergeId = $mergeId ? "AND patientid != '$mergeId'" : '';

    $emailsInUse = $db->getResults("SELECT email
        FROM dental_patients
        WHERE patientid != '$patientId'
            AND parent_patientid != '$patientId'
            $andExcludeMergeId
            AND email IN ($escapedEmails)");
    $emailsInUse = array_pluck($emailsInUse, 'email');
}

$num_changes = count(array_diff_assoc($p, $c));

/**************************************
** SUBMITTING
***************************************/
if(isset($_POST['submit'])){
    linkRequestData('dental_patients', $_POST['patientid']);

    $patientId = $_POST['patientid'];
    $mergeId = isset($_POST['merge_id']) ? intval($_POST['merge_id']) : 0;

    $validMerge = true;

    if ($fromExternal) {
        $verification = $db->getRow("SELECT COUNT(p.patientid)
            FROM dental_patients p
                LEFT JOIN dental_external_patients ep ON ep.patient_id = p.patientid
            WHERE (
                    p.patientid = '$patientId'
                    OR ep.patient_id = '$patientId'
                )
                AND p.docid = '$docId'", 'total');
        $validMerge = $verification > 1;
    } else if ($mergeId) {
        $verification = $db->getRow("SELECT COUNT(p.patientid)
            FROM dental_patients p
            WHERE p.patientid IN ('$patientId', '$mergeId')
                AND p.docid = '$docId'
                AND IF(p.patientid = '$patientId', p.status IN (1, 2), TRUE)
                AND IF(p.patientid = '$mergeId', p.status NOT IN (1, 2), TRUE)
                ", 'total');
        $validMerge = $verification > 1;
    }

    if (!$validMerge) { ?>
        <script>
            <?php if ($fromExternal) { ?>
                alert('There is no external data to merge with this patient profile.');
            <?php } else { ?>
                alert('At least one of the two patient profiles does not belong to the Doctor account and the merge cannot be processed.');
            <?php } ?>
            window.location = window.location;
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }

    $doctorFields = [];
    $patientFields = [];
    $completed = true;

    foreach ($fields as $field => $label) {
        $value = $_POST["value_$field"];

        /**
         * Email is in use, don't update it
         */
        if ($field === 'email' && in_array(trim($value), $emailsInUse)) {
            continue;
        }

        switch ($field) {
            case 'home_phone':
            case 'cell_phone':
            case 'work_phone':
            case 'emp_phone':
            case 'emergency_number':
            case 'emp_fax':
                $value = num($value);
                break;
            case 'ssn':
                $value = num($value, false);
                break;
            case 'dob':
            case 'ins_dob':
            case 'ins2_dob':
                /**
                 * Normalize dates, external data uses Y-m-d H-i-s, internal data uses m/d/Y
                 */
                $dateTime = strtotime($value);

                if ($dateTime) {
                    $value = date('m/d/Y', $dateTime);
                }
        }

        if ($_POST['accepted_' . $field] == 'doc') {
            $doctorFields[$field] = $value;
        } elseif ($_POST['accepted_' . $field] == 'pat') {
            $patientFields[$field] = $value;
        } elseif ($_POST['accepted_' . $field] != 'none') {
            $completed = false;
        }
    }

    $doctorFields = array_only($doctorFields, $validKeys);
    $patientFields = array_only($patientFields, $validKeys);

    /**
     * Accept doctor changes, copy regular patient data into child profile, or external profile
     */
    if ($doctorFields) {
        $doctorFields = $db->escapeAssignmentList($doctorFields);

        if ($fromExternal) {
            $db->query("UPDATE dental_external_patients
                SET $doctorFields
                WHERE patient_id = '$patientId'");
        } else if ($mergeId) {
            /**
             * Merge profiles: updating profile to be merged should not be allowed
             */
        } else {
            $db->query("UPDATE dental_patients
                SET $doctorFields
                WHERE parent_patientid = '$patientId'");
        }
    }

    if ($patientFields) {
        $patientFields = $db->escapeAssignmentList($patientFields);
        $db->query("UPDATE dental_patients
            SET $patientFields
            WHERE patientid = '$patientId'");
    }

    if ($completed) {
        if ($fromExternal) {
            $db->query("UPDATE dental_external_patients
                SET dirty = FALSE
                WHERE patient_id = '$patientId'");
        } else {
            if ($mergeId) {
                $db->query("DELETE FROM dental_patients
                    WHERE patientid = '$mergeId'");
            } else {
                $db->query("DELETE FROM dental_patients
                    WHERE parent_patientid = '$patientId'");
            }
        }
    }

    ?>
    <script type="text/javascript">
        parent.window.location = parent.window.location;
    </script>
<?php } ?>
<link rel="stylesheet" type="text/css" href="css/patient_changes.css">
<?php if ($fromExternal) { ?>
    <div style="margin: 0 11px;">
        <h2>External Data Sync</h2>
        <p>
            Select the data you wish to accept and update (External Data), or keep unchanged (Your Data).
            You do not need to select all values.  When finished, click Submit to save your changes.
        </p>
    </div>
<?php } ?>
<?php if ($c) { ?>
<form action="patient_changes.php?pid=<?= $patientId ?><?= $mergeId ? "&amp;merge_id=$mergeId" : '' ?><?= $fromExternal ? '&amp;external=1' : '' ?>" method="post">
<table>
  <tr>
    <th style>Field</th>
    <th>
        <input type="button" value="Select All" onclick="updateAll('doc');return false;" />
        <br />
        <?= $mergeId ? 'Patient to keep' : 'Your Data' ?>
    </th>
    <th></th>
    <th>
        <input type="button" value="Select All" onclick="updateAll('pat');return false;" />
        <br />
        <?= $mergeId ? 'Patient to merge' : ($fromExternal ? 'External Data' : 'Patient Data') ?>
    </th>
  </tr>
</table>
<div>
<table>
<?php foreach ($fields as $field => $label) {
    $isSame = trim($p[$field]) == trim($c[$field]);
    ?>
    <tr class="<?= $isSame ? 'duplicate' : 'change_row' ?>">
        <td style="display:none;">
            <input type="hidden" id="accepted_<?= $field ?>" name="accepted_<?= $field ?>" <?= $isSame ? 'value="none"' : 'class="accepted"' ?> />
            <input type="hidden" id="value_<?= $field ?>" name="value_<?= $field ?>" <?= $isSame ? '' : 'class="value"' ?> />
        </td>
        <?php if (in_array($field, $doc_fields)) { ?>
            <td>
                <?= $label ?>:
            </td>
            <td>
                <?php
                $docsql = "SELECT firstname, lastname from dental_contact WHERE contactid='".$p[$field]."'";
                $docr = $db->getRow($docsql);
                ?>
                <input readonly type="text" class="doc_field_extra" id="doc_<?= $field; ?>_extra" name="doc_<?= $field; ?>_extra" value="<?= $docr['firstname']." " .$docr['lastname']; ?>" />
                <input type="hidden" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" />
            </td>
            <td>
                <?php printSelectionButtons($field, !!$mergeId) ?>
            </td>
            <td>
                <?php
                $docsql = "SELECT firstname, lastname from dental_contact WHERE contactid='".$c[$field]."'";
                $docr = $db->getRow($docsql);
                ?>
                <input readonly type="text" class="pat_field_extra" id="pat_<?= $field; ?>_extra" name="pat_<?= $field; ?>_extra" value="<?= $docr['firstname']." " .$docr['lastname']; ?>" />
                <input type="hidden" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" />
            </td>
        <?php } elseif ($field == 'p_m_ins_co' || $field == 's_m_ins_co') { ?>
            <td>
                <?= $label; ?>:
            </td>
            <td>
                <?php
                $docsql = "SELECT company from dental_contact WHERE contactid='".$p[$field]."'";
                $docr = $db->getRow($docsql);
                ?>
                <input readonly type="text" class="doc_field_extra" id="doc_<?= $field; ?>_extra" name="doc_<?= $field; ?>_extra" value="<?= $docr['company']; ?>" />
                <input type="hidden" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" />
            </td>
            <td>
                <?php printSelectionButtons($field, !!$mergeId) ?>
            </td>
            <td>
                <?php
                $docsql = "SELECT company from dental_contact WHERE contactid='".$c[$field]."'";
                $docr = $db->getRow($docsql);
                ?>
                <input readonly type="text" class="pat_field_extra" id="pat_<?= $field; ?>_extra" name="pat_<?= $field; ?>_extra" value="<?= $docr['company']; ?>" />
                <input type="hidden" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" />
            </td>
        <?php } elseif ($field == 'p_m_ins_type' || $field == 's_m_ins_type') { ?>
            <td>
                <?= $label; ?>:
            </td>
            <?php
                switch($p[$field]){
                    case 1:
                        $val = 'Medicare';
                        break;
                    case 2:
                        $val = 'Medicaid';
                        break;
                    case 3:
                        $val = 'Tricare Champus';
                        break;
                    case 4:
                        $val = 'Champ VA';
                        break;
                    case 5:
                        $val = 'Group Health Plan';
                        break;
                    case 6:
                        $val = 'FECA BLKLUNG';
                        break;
                    case 7:
                        $val = 'Other';
                        break;
                    default:
                        $val = '';
                        break;
                }
            ?>
            <td>
                <input readonly type="text" class="doc_field_extra" id="doc_<?= $field; ?>_extra" name="doc_<?= $field; ?>_extra" value="<?= $val; ?>" />
                <input type="hidden" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" />
            </td>
            <td>
                <?php printSelectionButtons($field, !!$mergeId) ?>
            </td>
            <td>
                <?php
                switch($c[$field]){
                    case 1:
                        $val = 'Medicare';
                        break;
                    case 2:
                        $val = 'Medicaid';
                        break;
                    case 3:
                        $val = 'Tricare Champus';
                        break;
                    case 4:
                        $val = 'Champ VA';
                        break;
                    case 5:
                        $val = 'Group Health Plan';
                        break;
                    case 6:
                        $val = 'FECA BLKLUNG';
                        break;
                    case 7:
                        $val = 'Other';
                        break;
                    default:
                        $val = '';
                        break;
                }
                ?>
                <input readonly type="text" class="pat_field_extra" id="pat_<?= $field; ?>_extra" name="pat_<?= $field; ?>_extra" value="<?= $val; ?>" />
                <input type="hidden" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" />
            </td>
        <?php } else if ($field === 'email') { ?>
            <td><?= $label; ?>:</td>
            <td>
                <?php if (in_array(trim($p[$field]), $emailsInUse)) { ?>
                    <input readonly type="text" value="<?= $p[$field]; ?>" disabled title="This email is already taken by another patient" />
                <?php } else { ?>
                    <input readonly type="text" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" />
                <?php } ?>
            </td>
            <td>
                <?php printSelectionButtons(
                    $field, in_array(trim($p[$field]), $emailsInUse), in_array(trim($c[$field]), $emailsInUse)
                ) ?>
            </td>
            <td>
                <?php if (in_array(trim($c[$field]), $emailsInUse)) { ?>
                    <input readonly type="text" value="<?= $c[$field]; ?>" disabled title="This email is already taken by another patient" />
                <?php } else { ?>
                    <input readonly type="text" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" />
                <?php } ?>
            </td>
        <?php } else { ?>
            <td><?= $label; ?>:</td>
            <td>
                <input readonly type="text" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" />
            </td>
            <td>
                <?php printSelectionButtons($field) ?>
            </td>
            <td>
                <input readonly type="text" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" />
            </td>
        <?php } ?>
    </tr>
<?php } ?>
</table>
</div>
<input type="submit" name="submit"  style="float:right; margin-right:30px;" value="Submit" />
<input type="hidden" name="patientid" value="<?= $patientId ?>" />
</form>
<?php } ?>
<br /><br />
<script src="js/patient_changes.js" type="text/javascript"></script>
<?php

require_once __DIR__ . '/patient_contacts.php';
require_once __DIR__ . '/patient_insurance.php';

if ($num_changes == 0) {
    if ($mergeId) {
        $db->query("UPDATE dental_external_patients
            SET patient_id = '$patientId'
            WHERE patient_id = '$mergeId'");
        $db->query("DELETE FROM dental_patients
            WHERE patientid = '$mergeId'");

        $message = 'Patient profiles have been merged';
    } else if ($fromExternal) {
        $db->query("UPDATE dental_external_patients
            SET dirty = FALSE
            WHERE patient_id = '$patientId'");

        $message = 'External data is synced with your data';
    } else {
        $db->query("DELETE FROM dental_patients
            WHERE parent_patientid = '$patientId'");

        $message = 'Patient Portal data is synced with your data';
    }

    ?>
    <script type="text/javascript">
        alert(<?= json_encode($message) ?>);
        window.location = "add_patient.php?ed=<?= $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?= $_GET['pid']; ?>";
    </script>
    <?php
}

require_once __DIR__ . '/includes/bottom.htm';

function printSelectionButtons ($field, $disableLeftSide=false, $disableRightSide=false) {
    foreach (['l' => 'doc', 'r' => 'pat'] as $side=>$target) {
        $disabled = ($side === 'l' && $disableLeftSide) || ($side === 'r' && $disableRightSide);
        ?>
        <input type="button" class="button1" value="&<?= $side ?>aquo;" <?= $disabled ? 'disabled' : '' ?>
               onclick="updateField(<?= e(json_encode($field)) ?>, '<?= $target ?>');return false;" />
    <?php }
}
