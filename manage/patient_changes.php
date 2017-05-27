<?php
namespace Ds3\Libraries\Legacy;

use function in_array;

require_once __DIR__ . '/includes/top.htm';

$patientId = intval($_GET['pid']);
$fromExternal = !empty($_GET['external']);

$psql = "SELECT *
    FROM dental_patients
    WHERE patientid = '$patientId'";
$p = $db->getRow($psql);

if ($fromExternal) {
    $sql = "SELECT *
        FROM dental_external_patients
        WHERE patient_id = '$patientId'
            AND dirty = 1
        LIMIT 1
    ";
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
}

$escapedEmails = $db->escapeList($emailsToUpdate);
$emailsInUse = $db->getResults("SELECT email
    FROM dental_patients
    WHERE patientid != '$patientId'
        AND email IN ($escapedEmails)");
$emailsInUse = array_pluck($emailsInUse, 'email');

$num_changes = count(array_diff_assoc($p, $c));

/**************************************
** SUBMITTING
***************************************/
if(isset($_POST['submit'])){
    linkRequestData('dental_patients', $_POST['patientid']);

    $patientId = $_POST['patientid'];

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
            $db->query("DELETE FROM dental_patients
            WHERE parent_patientid = '$patientId'");
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
<form action="patient_changes.php?pid=<?= $patientId ?><?= $fromExternal ? '&amp;external=1' : '' ?>" method="post">
<table>
  <tr>
    <th style>Field</th>
    <th><input type="button" value="Select All" onclick="updateAll('doc');return false;" /><br />Your Data</th>
    <th></th>
    <th><input type="button" value="Select All" onclick="updateAll('pat');return false;" /><br /><?= $fromExternal ? 'External' : 'Patient' ?> Data</th>
  </tr>
</table>
<div> 
<table >
<?php foreach ($fields as $field => $label) {
    $isSame = trim($p[$field]) == trim($c[$field]);
    ?>
    <tr class="<?= $isSame ? 'duplicate' : 'change_row' ?>">
        <input type="hidden" id="accepted_<?= $field ?>" name="accepted_<?= $field ?>" <?= $isSame ? 'value="none"' : 'class="accepted"' ?> />
        <input type="hidden" id="value_<?= $field ?>" name="value_<?= $field ?>" <?= $isSame ? '' : 'class="value"' ?> />
        <?php if (in_array($field, $doc_fields)) { ?>
            <td>
                <?= $label ?>:
            </td>
            <?php
                $docsql = "SELECT firstname, lastname from dental_contact WHERE contactid='".$p[$field]."'";
                $docr = $db->getRow($docsql);
            ?>
            <td>
                <input readonly type="text" class="doc_field_extra" id="doc_<?= $field; ?>_extra" name="doc_<?= $field; ?>_extra" value="<?= $docr['firstname']." " .$docr['lastname']; ?>" />
                <input type="hidden" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" />
            </td>
            <td>
                <input type="button" class="button1" value="&laquo;" onclick="updateField('<?= $field; ?>', 'doc');return false;" />
                <input type="button" class="button1" value="&raquo;" onclick="updateField('<?= $field; ?>', 'pat');return false;" />
            </td>
            <?php
                $docsql = "SELECT firstname, lastname from dental_contact WHERE contactid='".$c[$field]."'";
                $docr = $db->getRow($docsql);
            ?>
            <td>
                <input readonly type="text" class="pat_field_extra" id="pat_<?= $field; ?>_extra" name="pat_<?= $field; ?>_extra" value="<?= $docr['firstname']." " .$docr['lastname']; ?>" />
                <input type="hidden" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" />
            </td>
        <?php } elseif ($field == 'p_m_ins_co' || $field == 's_m_ins_co') { ?>
            <td>
                <?= $label; ?>:</td>
            <?php
                $docsql = "SELECT company from dental_contact WHERE contactid='".$p[$field]."'";
                $docr = $db->getRow($docsql);
            ?>
            <td><input readonly type="text" class="doc_field_extra" id="doc_<?= $field; ?>_extra" name="doc_<?= $field; ?>_extra" value="<?= $docr['company']; ?>" />
                <input type="hidden" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" />
            </td>
            <td><input type="button" class="button1" value="&laquo;" onclick="updateField('<?= $field; ?>', 'doc');return false;" />
                <input type="button" class="button1" value="&raquo;" onclick="updateField('<?= $field; ?>', 'pat');return false;" />
            </td>
            <?php
                $docsql = "SELECT company from dental_contact WHERE contactid='".$c[$field]."'";
                $docr = $db->getRow($docsql);
            ?>
            <td>
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
                <input type="button" class="button1" value="&laquo;" onclick="updateField('<?= $field; ?>', 'doc');return false;" />
                <input type="button" class="button1" value="&raquo;" onclick="updateField('<?= $field; ?>', 'pat');return false;" />
            </td>
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
            <td>
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
                <?php if (in_array(trim($p[$field]), $emailsInUse)) { ?>
                    <input type="button" class="button1" value="&laquo;" onclick="return false;" disabled title="This email is already taken by another patient" />
                <?php } else { ?>
                    <input type="button" class="button1" value="&laquo;" onclick="updateField('<?= $field; ?>', 'doc');return false;" />
                <?php } ?>
                <?php if (in_array(trim($c[$field]), $emailsInUse)) { ?>
                    <input type="button" class="button1" value="&raquo;" onclick="return false;" disabled title="This email is already taken by another patient" />
                <?php } else { ?>
                    <input type="button" class="button1" value="&raquo;" onclick="updateField('<?= $field; ?>', 'pat');return false;" />
                <?php } ?>
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
                <input type="button" class="button1" value="&laquo;" onclick="updateField('<?= $field; ?>', 'doc');return false;" />
                <input type="button" class="button1" value="&raquo;" onclick="updateField('<?= $field; ?>', 'pat');return false;" />
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
    if ($fromExternal) {
        $db->query("UPDATE dental_external_patients
            SET dirty = FALSE
            WHERE patient_id = '$patientId'");
    } else {
        $db->query("DELETE FROM dental_patients
            WHERE parent_patientid = '$patientId'");
    }

    ?>
    <script type="text/javascript">
      alert("<?= $fromExternal ? 'External' : 'Patient Portal'?> data is synced with your data");
      window.location = "add_patient.php?ed=<?= $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?= $_GET['pid']; ?>";
    </script>
    <?php
}

require_once __DIR__ . '/includes/bottom.htm';
