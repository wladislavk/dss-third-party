<?php
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
include("includes/sescheck.php");
require_once('includes/general_functions.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body class="solid">

<?php
$psql = "SELECT * FROM dental_patients WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
$pq = mysql_query($psql);
$p = mysql_fetch_assoc($pq);

$csql = "SELECT * FROM dental_patients WHERE parent_patientid='".mysql_real_escape_string($_GET['pid'])."'";
$cq = mysql_query($csql);
$c = mysql_fetch_assoc($cq);

$fields = array();
$fields['firstname'] = "First Name";
$fields['middlename'] = "Middle Name";
$fields['lastname'] = "Last Name";
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
$fields['patient_notes'] = "Patient Notes";
$fields['preferredcontact'] = "Preferred Contact";
$fields['emergency_name'] = "Emergency Name";
$fields['emergency_relationship'] = "Emergency Relationship";
$fields['emergency_number'] = "Emergency Number";
$fields['p_m_relation'] = "Relationship to Insured";
$fields['p_m_partyfname'] = "Insured First Name";
$fields['p_m_partymname'] = "Insured Middle Name";
$fields['p_m_partylname'] = "Insured Last Name";
$fields['ins_dob'] = "Insured Date of Birth";
$fields['p_m_ins_co'] = "Insurance Company";
$fields['p_m_ins_id'] = "Insurance ID";
$fields['p_m_ins_grp'] = "Insurance Group";
$fields['p_m_ins_plan'] = "Insurance Plan";
$fields['p_m_ins_type'] = "Insurance Type";

$fields['s_m_relation'] = "2nd Relationship to Insured";
$fields['s_m_partyfname'] = "2nd Insured First Name";
$fields['s_m_partymname'] = "2nd Insured Middle Name";
$fields['s_m_partylname'] = "2nd Insured Last Name";
$fields['ins2_dob'] = "2nd Insured Date of Birth";
$fields['s_m_ins_co'] = "2nd Insurance Company";
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

/**************************************
** SUBMITTING
***************************************/
if(isset($_POST['submit'])){
$docchange = $patchange = false;
$completed = true;
$docsql = $patsql = "UPDATE dental_patients SET ";
foreach($fields as $field => $label){
  if($_POST['accepted_'.$field]=='doc'){
  	if($docchange){ $docsql .= ", "; }
	if($field=='home_phone' || $field=='cell_phone' || $field=='work_phone' || $field=='emp_phone' || $field=='emergency_number' || $field=='emp_fax' ){
                $docsql .= $field . " = '" . mysql_real_escape_string(num($_POST['value_'.$field]))."'";
	}elseif($field=='ssn'){
                $docsql .= $field . " = '" . mysql_real_escape_string(num($_POST['value_'.$field], false))."'";
        }else{
  		$docsql .= $field . " = '" . mysql_real_escape_string($_POST['value_'.$field])."'";
	}
	$docchange = true;
  }elseif($_POST['accepted_'.$field]=='pat'){
	if($field == "email"){ sendUpdatedEmail($_POST['patientid'], $_POST['pat_email'], $_POST['doc_email']); }
        if($patchange){ $patsql .= ", "; }
        if($field=='home_phone' || $field=='cell_phone' || $field=='work_phone' || $field=='emp_phone' || $field=='emergency_number' || $field=='emp_fax' ){
                $patsql .= $field . " = '" . mysql_real_escape_string(num($_POST['value_'.$field]))."'";
        }elseif($field=='ssn'){
                $patsql .= $field . " = '" . mysql_real_escape_string(num($_POST['value_'.$field], false))."'";
        }else{
         	$patsql .= $field . " = '" . mysql_real_escape_string($_POST['value_'.$field])."'";
	}
	$patchange = true;
  }elseif($_POST['accepted_'.$field]!='none'){
    $completed = false;
  }
}
$docsql .= " WHERE parent_patientid='".mysql_real_escape_string($_POST['patientid'])."'";
$patsql .= " WHERE patientid='".mysql_real_escape_string($_POST['patientid'])."'";
if($docchange){ mysql_query($docsql); }
if($patchange){ mysql_query($patsql); }
if($completed){ mysql_query("DELETE FROM dental_patients WHERE parent_patientid='".mysql_real_escape_string($_POST['patientid'])."'"); }
?>
<script type="text/javascript">
parent.window.location = parent.window.location;
</script>
<?php
}
?>
<style type="text/css">
.duplicate{ display:none; }
table {  width: 700px; margin:0 auto; }
table, td{ color:#fff;}
input.selected { background-color:#0f3; border:solid 1px #0f3;}
input.button1 { font-size:20px; background:#fff; }
</style>
<form action="patient_changes.php" method="post">
<table>
  <tr>
    <th style>Field</th>
    <th><input type="button" value="Select All" onclick="updateAll('doc');return false;" /><br />Your Data</th>
    <th></th>
    <th><input type="button" value="Select All" onclick="updateAll('pat');return false;" /><br />Patient Data</th>
  </tr>
</table>
<div style="overflow:auto; height:300px;">
<table >
<?php
  foreach($fields as $field => $label){
    if(trim($p[$field])==trim($c[$field])){ 
      ?><tr class="duplicate">
    	<input type="hidden" id="accepted_<?= $field; ?>" name="accepted_<?= $field; ?>" value="none" />
    	<input type="hidden" id="value_<?= $field; ?>" name="value_<?= $field; ?>" />
	<?php
    }else{
      ?><tr class="change_row">
	<input type="hidden" class="accepted" id="accepted_<?= $field; ?>"  name="accepted_<?= $field; ?>" />
    	<input type="hidden" class="value" id="value_<?= $field; ?>"  name="value_<?= $field; ?>" />
	<?php
    }

    if(in_array($field, $doc_fields)){ ?>
    <td><?= $label; ?>:</td>
	<?php 
		$docsql = "SELECT firstname, lastname from dental_contact WHERE contactid='".$p[$field]."'";
		$docq = mysql_query($docsql);
		$docr = mysql_fetch_assoc($docq);
	?>
    <td><input type="text" class="doc_field_extra" id="doc_<?= $field; ?>_extra" name="doc_<?= $field; ?>_extra" value="<?= $docr['firstname']." " .$docr['lastname']; ?>" />
	<input type="hidden" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" /></td>
    <td><input type="button" class="button1" value="&laquo;" onclick="updateField('<?= $field; ?>', 'doc');return false;" />
        <input type="button" class="button1" value="&raquo;" onclick="updateField('<?= $field; ?>', 'pat');return false;" /></td>
        <?php 
                $docsql = "SELECT firstname, lastname from dental_contact WHERE contactid='".$c[$field]."'";
                $docq = mysql_query($docsql);
                $docr = mysql_fetch_assoc($docq);
        ?>

    <td><input type="text" class="pat_field_extra" id="pat_<?= $field; ?>_extra" name="pat_<?= $field; ?>_extra" value="<?= $docr['firstname']." " .$docr['lastname']; ?>" />
	<input type="hidden" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" /></td>
	<?php
    }else{
  ?>
    <td><?= $label; ?>:</td>
    <td><input type="text" class="doc_field" id="doc_<?= $field; ?>" name="doc_<?= $field; ?>" value="<?= $p[$field]; ?>" /></td>
    <td><input type="button" class="button1" value="&laquo;" onclick="updateField('<?= $field; ?>', 'doc');return false;" />
	<input type="button" class="button1" value="&raquo;" onclick="updateField('<?= $field; ?>', 'pat');return false;" /></td>
    <td><input type="text" class="pat_field" id="pat_<?= $field; ?>" name="pat_<?= $field; ?>" value="<?= $c[$field]; ?>" /></td>
  <?php } ?>
  </tr>
<?php } ?>
</table>
</div>
<input type="submit" name="submit" value="Submit" />
<input type="hidden" name="patientid" value="<?= $_GET['pid']; ?>" />
</form>

<script type="text/javascript">
function updateField(f, v){
  if(v=='doc'){
    $('#doc_'+f).addClass('selected');
    $('#pat_'+f).removeClass('selected');
    $('#doc_'+f+'_extra').addClass('selected');
    $('#pat_'+f+'_extra').removeClass('selected');
    $('#value_'+f).val($('#doc_'+f).val());
  }else if(v=='pat'){
    $('#pat_'+f).addClass('selected');
    $('#doc_'+f).removeClass('selected');
    $('#pat_'+f+'_extra').addClass('selected');
    $('#doc_'+f+'_extra').removeClass('selected');
    $('#value_'+f).val($('#pat_'+f).val());
  }
    $('#accepted_'+f).val(v);
}
function updateAll(v){
  $('.change_row').each(function(){
    $(this).find('.doc_field').removeClass('selected');
    $(this).find('.pat_field').removeClass('selected');
    $(this).find('.'+v+'_field').addClass('selected');
    val = $(this).find('.'+v+'_field').val();
    $(this).find('.value').val(val);
    $(this).find('.accepted').val(v);
  });
}
</script>


</body>
</html>
