<?php 
if (isset($_POST['newnotesubmit'])) {
    $query = "UPDATE dental_patients SET patient_notes='".mysql_real_escape_string($_POST['notecontent'])."' WHERE patientid='".$_GET['pid']."';";
    
    if (!$db->query($query)) {
        echo "Could not add note! Please contact the system administrator or try again.";
    }
}?>

<form method="POST" action="#" style="width:100%;">
<?php
$query = "SELECT patient_notes FROM dental_patients WHERE patientid='".$_GET['pid']."';";
$array = $db->getResults($query);

foreach ($array as $notes) { ?>
    <textarea name="notecontent" style="width:98%;" class="form-control" rows="3"><?php echo $notes['patient_notes'] ?></textarea>
<?php } ?>
    <br />
    <input type="submit" name="newnotesubmit" class="btn btn-info" value="Update Notes">
</form>
