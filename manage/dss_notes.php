<?php 

if(isset($_POST['newnotesubmit'])){
$query = "UPDATE dental_patients SET patient_notes='".mysql_real_escape_string($_POST['notecontent'])."' WHERE patientid='".$_GET['pid']."';";
if(!mysql_query($query)){
echo "Could not add note! Please contact the system administrator or try again.";
}
}
?>
<form method="POST" action="#" style="width:100%;">
<?php
$query = "SELECT patient_notes FROM dental_patients WHERE patientid='".$_GET['pid']."';";

$array = mysql_query($query);

while($notes = mysql_fetch_array($array)){
echo " <textarea name=\"notecontent\" id=\"notecontent\" cols=\"110\" rows=\"3\">".$notes['patient_notes']."</textarea>";
}

?>
<br />
<input type="submit" name="newnotesubmit" value="Update Notes">
</form>
