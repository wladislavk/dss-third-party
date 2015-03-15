<?php namespace Ds3\Legacy; ?><?php 

if(isset($_POST['ositesubmit'])){
$query = "UPDATE dental_summary SET osite='".mysql_real_escape_string($_POST['ositenew'])."' WHERE patientid='".$_GET['pid']."';";
if(!mysql_query($query)){
echo "Could not add note! Please contact the system administrator or try again.";
}
}
?>
<form method="POST" action="#" style="width:100%;">
<?php
$query = "SELECT osite FROM dental_summary WHERE patientid='".$_GET['pid']."';";

$array = mysql_query($query);

while($notes = mysql_fetch_array($array)){
echo "<input type=\"text\" name=\"ositenew\" value=\"".$array['osite']."\" id=\"osite\" />";
}

?>
<br />
<input type="submit" name="ositesubmit" value="Save Office Site">
</form>
