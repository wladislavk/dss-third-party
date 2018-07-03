<?php
namespace Ds3\Libraries\Legacy;

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=dss_to_pt_yearly_follow_up_".date('m-d-Y').".doc");
header("Pragma: no-cache");
header("Expires: 0");

include "admin/includes/main_include.php";

$db = new Db();

$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";

$pat_myarray = $db->getRow($pat_sql);
$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);
if($pat_myarray['patientid'] == '') {
?>
    <script type="text/javascript">
        window.location = 'manage_patient.php';
    </script>
<?php
    trigger_error("Die called", E_USER_ERROR);
}
?>
<br />
<span class="admin_head">
    DSS to pt no treatment
</span>
<br /><br>
<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
    <tr>
        <td valign="top">
            <?php echo date('F d, Y')?><br><br>
            <strong>
            <?php echo $name;?>
            <?php if(st($pat_myarray['add1']) != '') { ?>
                <br /><?php echo st($pat_myarray['add1']);?>
            <?php } ?>

            <?php if(st($pat_myarray['add2']) != '') { ?>
                <br /><?php echo st($pat_myarray['add2']);?>
            <?php } ?>
            &nbsp;
            <?php echo st($pat_myarray['city']);?>
            &nbsp;
            <?php echo st($pat_myarray['state']);?>
            &nbsp;
            <?php echo st($pat_myarray['zip']);?>
            </strong>
            <br><br>
            Dear <strong><?php echo st($pat_myarray['firstname']);?></strong>,<br><br>

            Can you believe it was a year ago that we fabricated your <strong>???</strong> dental sleep device?  We hope that you are continuing to do well.

            Please take time to contact our office and schedule your yearly recall.  It is important that we evaluate your device for proper fit and discuss your continued treatment regimen.

            As you may very well be aware, this disease leads to increased risks for hypertension, heart attack, congestive heart failure, stroke, as well as an increased risk for falling asleep while driving.  All of which can be reversed by successful treatment!

            We look forward to seeing you soon.
            <br /><br />
            Sincerely,
            <br><br><br><br>
            <strong><?php echo $_SESSION['name']?>, DDS</strong><br><br>
            <br><br>
        </td>
    </tr>
</table>
