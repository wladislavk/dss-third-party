<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include "includes/sescheck.php";
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="js/masks.js"></script>
<?php
$db = new Db();

if (!empty($_POST["contactsub"]) && $_POST["contactsub"] == 1) {
    if ($_POST["ed"] != "") {
        $ed_sql = "update dental_locations set 
            location = '".$db->escape( $_POST["location"])."', 
            name = '".$db->escape( $_POST["name"])."',
            address = '".$db->escape( $_POST["address"])."',
            city = '".$db->escape( $_POST["city"])."',
            state = '".$db->escape( $_POST["state"])."',
            zip = '".$db->escape( $_POST["zip"])."',
            phone = '".$db->escape( num($_POST["phone"]))."',
            fax = '".$db->escape( num($_POST["fax"]))."'
            where id='".$_POST["ed"]."'";
        $db->query($ed_sql);

        $msg = "Edited Successfully"; ?>
        <script type="text/javascript">
            parent.window.location='manage_locations.php?docid=<?php echo  $_POST['docid']; ?>&msg=<?php echo $msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $ins_sql = "insert into dental_locations set location = '".s_for($_POST["location"])."',
            name = '".$db->escape( $_POST["name"])."',
            address = '".$db->escape( $_POST["address"])."',
            city = '".$db->escape( $_POST["city"])."',
            state = '".$db->escape( $_POST["state"])."',
            zip = '".$db->escape( $_POST["zip"])."',
            phone = '".$db->escape( num($_POST["phone"]))."',
            fax = '".$db->escape( num($_POST["fax"]))."',
            docid='".$_SESSION['docid']."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
        $db->query($ins_sql);
        $msg = "Added Successfully"; ?>
        <script type="text/javascript">
            parent.window.location = 'manage_locations.php?msg=<?php echo $msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
</head>
<body>
    <?php
    $thesql = "select * from dental_locations where id='".$_REQUEST["ed"]."'";
    $themyarray = $db->getRow($thesql);

    if (!empty($msg)) {
        $location = $_POST['location'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $phone = $_POST['phone'];
        $fax = $_POST['fax'];
    } else {
        $location = st($themyarray['location']);
        $name = st($themyarray['name']);
        $address = st($themyarray['address']);
        $city = st($themyarray['city']);
        $state = st($themyarray['state']);
        $zip = st($themyarray['zip']);
        $phone = st($themyarray['phone']);
        $fax = st($themyarray['fax']);
    }

    if ($themyarray["id"] != '') {
        $but_text = "Edit ";
    } else {
        $but_text = "Add ";
    }
    ?>
    <br /><br />
    <?php if (!empty($msg)) { ?>
        <div align="center" class="red">
            <?php echo $msg;?>
        </div>
    <?php } ?>
    <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return locationabc(this)">
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text ?> <?php echo (!empty($_GET['heading']) ? $_GET['heading'] : ''); ?> Location
               <?php if ($location != "") { ?>
                    &quot;<?php echo $location;?>&quot;
               <?php } ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="location" id="location" value="<?php echo $location; ?>" class="field text addr tbox" tabindex="1" style="width:300px;">
                                <label for="location">Practice Location</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="field text addr tbox" tabindex="1" style="width:300px;">
                                <label for="name">Doctor Name</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="address" id="address" value="<?php echo $address; ?>" class="field text addr tbox" tabindex="1" style="width:300px;">
                                <label for="address">Address</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="city" id="city" value="<?php echo $city; ?>" class="field text addr tbox" tabindex="1" style="width:300px;">
                                <label for="city">City</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="state" id="state" value="<?php echo $state; ?>" class="field text addr tbox" maxlength="2" tabindex="1" style="width:300px;">
                                <label for="state">State</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="zip" id="zip" value="<?php echo $zip; ?>" class="field text addr tbox" tabindex="1" style="width:300px;">
                                <label for="zip">Zip</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" class="extphonemask field text addr tbox" tabindex="1" style="width:300px;">
                                <label for="phone">Phone</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input type="text" name="fax" id="fax" value="<?php echo $fax; ?>" class="phonemask field text addr tbox" tabindex="1" style="width:300px;">
                                <label for="fax">Fax</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td  align="center">
                <span class="red">
                    * Required Fields
                </span><br />
                <input type="hidden" name="contactsub" value="1" />
                <input type="hidden" name="docid" value="<?php echo (!empty($_GET['docid']) ? $_GET['docid'] : ''); ?>" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" value=" <?php echo $but_text?> Location" class="button" />
                <?php if ($themyarray["id"] != '') { ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_locations.php?delid=<?php echo $themyarray["id"];?>'" onclick="return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                        Delete
                    </a>
                <?php } ?>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
