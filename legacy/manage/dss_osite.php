<?php
namespace Ds3\Libraries\Legacy;

if (isset($_POST['ositesubmit'])) {
    $summaryIdSql = "SELECT summaryid FROM dental_summary_pivot WHERE patientid=".$_GET['pid'];
    $summaryIdResult = mysqli_query($con, $summaryIdSql);
    $summaryId = mysqli_fetch_field($summaryIdResult);
    $escapedOsite = mysqli_real_escape_string($con, $_POST['ositenew']);
    $query = "UPDATE dental_summary 
        SET osite='$escapedOsite' 
        WHERE summaryid=$summaryId";
    if (!mysqli_query($con, $query)) {
        echo "Could not add note! Please contact the system administrator or try again.";
    }
}
?>
<form method="POST" action="#" style="width:100%;">
    <?php
    $query = "SELECT osite FROM dental_summary_pivot WHERE patientid='".$_GET['pid']."';";
    $array = mysqli_query($con, $query);
    while ($notes = mysqli_fetch_array($array)) { ?>
        <input type="text" name="ositenew" value="<?= $array['osite'] ?>" id="osite" />
        <?php
    } ?>
<br />
<input type="submit" name="ositesubmit" value="Save Office Site">
</form>
