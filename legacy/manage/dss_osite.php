<?php namespace Ds3\Libraries\Legacy; ?><?php 

if(isset($_POST['ositesubmit'])){
$query = "UPDATE dental_summary_view SET osite='".mysqli_real_escape_string($con, $_POST['ositenew'])."' WHERE patientid='".$_GET['pid']."';";
if(!mysqli_query($con, $query)){
echo "Could not add note! Please contact the system administrator or try again.";
}
}
?>
<form method="POST" action="#" style="width:100%;">
<?php
$query = "SELECT osite FROM dental_summary_view WHERE patientid='".$_GET['pid']."';";

$array = mysqli_query($con, $query);

while($notes = mysqli_fetch_array($array)){
echo "<input type=\"text\" name=\"ositenew\" value=\"".$array['osite']."\" id=\"osite\" />";
}

?>
<br />
<input type="submit" name="ositesubmit" value="Save Office Site">
</form>
