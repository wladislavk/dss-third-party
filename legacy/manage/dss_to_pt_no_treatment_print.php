<?php
namespace Ds3\Libraries\Legacy;

include "admin/includes/main_include.php";

$db = new Db();

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_myarray = $db->getRow($pat_sql);

$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);
if ($pat_myarray['patientid'] == '') { ?>
    <script type="text/javascript">
        window.location = 'manage_patient.php';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$ref_sql = "select * from dental_q_recipients where patientid='".$_GET['pid']."'";

$ref_myarray = $db->getRow($ref_sql);
$referring_physician = st($ref_myarray['referring_physician']);
$a_arr = explode(' ', $referring_physician);

$q2_sql = "select * from dental_q_page2_pivot where patientid='".$_GET['pid']."'";

$q2_myarray = $db->getRow($q2_sql);
$confirmed_diagnosis = st($q2_myarray['confirmed_diagnosis']);
$custom_diagnosis = st($q2_myarray['custom_diagnosis']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="keywords" content="<?php echo st(!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : '');?>" />
        <title><?php echo $sitename;?> | <?php echo $name;?> - DSS to pt no treatment</title>
        <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript" src="script/validation.js"></script>
    </head>
    <body onLoad="window.print(); window.close();">
        <table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
            <tr bgcolor="#FFFFFF">
                <td colspan="2" >
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
                                    <?php echo $name; ?>
                                    <?php if (st($pat_myarray['add1']) != '') { ?>
                                        <br /><?php echo st($pat_myarray['add1']);?>
                                    <?php } ?>
                                    <?php if (st($pat_myarray['add2']) != '') { ?>
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
                                Thank you for taking the time to come in and consult with us regarding your diagnosis of <strong><?php echo $confirmed_diagnosis;?> <?php echo $custom_diagnosis;?></strong>. I hope that you found it was worth your time. We work very hard to be the best we can be.<br /><br />
                                I understand your concern about the cost and wanting to know what insurance will cover, but in the meantime, I am concerned that you are not treating your sleep disordered breathing problem!  <br /><br />
                                As you may very well be aware, this disease leads to increased risks for hypertension, heart attack, congestive heart failure, stroke, as well as an increased risk for falling asleep while driving.  All of which can be reversed by successful treatment!  <br /><br />
                                I look forward to working with you to help you sleep better and feel better.<br /><br />
                                Sincerely,
                                <br><br><br><br>
                                <strong><?php echo $_SESSION['name']?>, DDS</strong><br><br>
                                CC:  <strong><?php echo $a_arr[0];?></strong>
                                <br><br>
                            </td>
                        </tr>
                    </table>
                    <br /><br />
                </td>
            </tr>
        </table>
    </body>
</html>
