<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include "includes/sescheck.php";
include "includes/top.htm";

$db = new Db();

if ($_POST["contactsub"] == 1) {
    if ($_POST["ed"] != "") {
        $ed_sql = "update dental_contact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '11', notes = '".s_for($_POST["notes"])."', status = '".s_for($_POST["status"])."' where contactid='".$_POST["ed"]."'";
        $db->query($ed_sql);
        $msg = "Edited Successfully";
        ?>
        <script type="text/javascript">
            parent.window.location='manage_contact.php?msg=<?php echo $msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $ins_sql = "insert into dental_contact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '11', notes = '".s_for($_POST["notes"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["status"])."', adddate=now(), ip_address='".$_SERVER['REMOTE_ADDR']."'";
        $db->query($ins_sql);
        $msg = "Added Successfully";
        if (isset($_GET['activePat'])) { ?>
            <script type="text/javascript">
                <?php echo "window.location.href='add_patient_to.php?ed=".$_GET['activePat']."'"; ?>
            </script>
            <?php
        } else { ?>
            <script type="text/javascript">
                parent.window.location='manage_contact.php?msg=<?php echo $msg;?>';
            </script>
            <?php
        }
        trigger_error("Die called", E_USER_ERROR);
    }
} ?>
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
<body width="98%">
<?php
$thesql = "select * from dental_contact where contactid='".$_REQUEST["ed"]."'";
$themyarray = $db->getRow($thesql);

if ($msg != '') {
    $salutation = $_POST['salutation'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $company = $_POST['company'];
    $add1 = $_POST['add1'];
    $add2= $_POST['add2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $national_provider_id = $_POST['national_provider_id'];
    $qualifierid = $_POST['qualifierid'];
    $notes = $_POST['notes'];
} else {
    $salutation = st($themyarray['salutation']);
    $firstname = st($themyarray['firstname']);
    $middlename = st($themyarray['middlename']);
    $lastname = st($themyarray['lastname']);
    $company = st($themyarray['company']);
    $add1 = st($themyarray['add1']);
    $add2 = st($themyarray['add2']);
    $city = st($themyarray['city']);
    $state = st($themyarray['state']);
    $zip = st($themyarray['zip']);
    $phone1 = st($themyarray['phone1']);
    $phone2 = st($themyarray['phone2']);
    $fax = st($themyarray['fax']);
    $email = st($themyarray['email']);
    $national_provider_id = st($themyarray['national_provider_id']);
    $qualifierid = st($themyarray['qualifierid']);
    $notes = st($themyarray['notes']);
    $name = st($themyarray['firstname'])." ".st($themyarray['middlename'])." ".st($themyarray['lastname']);
}

if ($themyarray["contactid"] != '') {
    $but_text = "Edit ";
} else {
    $but_text = "Add ";
}
?>
<br /><br />
<?php if ($msg != '') { ?>
    <div align="center" class="red">
        <?php echo $msg;?>
    </div>
<?php } ?>
<form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&activePat=<?php echo $_GET['activePat']; ?>" method="post" onSubmit="return contactabc(this)" style="width:99%;">
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text ?> <?php echo $_GET['heading']; ?> Contact
               <?php if ($name != "") { ?>
                    &quot;<?php echo $name;?>&quot;
               <?php } ?>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            Name
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                            <span>
                                <select name="salutation" id="salutation" class="field text addr tbox" tabindex="1" style="width:80px;" >
                                    <option value=""></option>
                                    <option value="Dr." <?php if ($salutation == 'Dr.') echo " selected";?>>Dr.</option>
                                    <option value="Mr." <?php if ($salutation == 'Mr.') echo " selected";?>>Mr.</option>
                                    <option value="Mrs." <?php if ($salutation == 'Mrs.') echo " selected";?>>Mrs.</option>
                                    <option value="Ms." <?php if ($salutation == 'Miss.' || $salutation == 'Ms.') echo " selected";?>>Ms.</option>
                                </select>
                                <label for="salutation">Salutation</label>
                            </span>
                            <span>
                                <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="<?php echo $firstname?>" tabindex="2" maxlength="255" />
                                <label for="firstname">First Name</label>
                            </span>
                            <span>
                                <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="<?php echo $lastname?>" tabindex="3" maxlength="255" />
                                <label for="lastname">Last Name</label>
                            </span>
                            <span>
                                <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="<?php echo $middlename?>" tabindex="4" style="width:50px;" maxlength="1" />
                                <label for="middlename">Middle <br />Init</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            <span>
                            <span style="color:#000000">Company</span>
                            <input id="company" name="company" type="text" class="field text addr tbox" value="<?php echo $company;?>" tabindex="5" style="width:575px;"  maxlength="255"/>
                            </span>
                        </label>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            Address
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                            <span>
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="<?php echo $add1?>" tabindex="6" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="<?php echo $add2?>" tabindex="7" style="width:325px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="<?php echo $city?>" tabindex="8" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" autocomplete="off" class="field text addr tbox" value="<?php echo $state?>" tabindex="9" style="width:80px;" maxlength="255" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="<?php echo $zip?>" tabindex="10" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip / Post Code </label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input id="phone1" name="phone1" type="text" class="field text addr tbox" value="<?php echo $phone1?>" tabindex="11" maxlength="255" style="width:200px;" />
                                <label for="phone1">Phone 1</label>
                            </span>
                            <span>
                                <input id="phone2" name="phone2" type="text" class="field text addr tbox" value="<?php echo $phone2?>" tabindex="12" maxlength="255" style="width:200px;" />
                                <label for="phone2">Phone 2</label>
                            </span>
                            <span>
                                <input id="fax" name="fax" type="text" class="field text addr tbox" value="<?php echo $fax?>" tabindex="13" maxlength="255" style="width:200px;" />
                                <label for="fax">Fax</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="<?php echo $email?>" tabindex="14" maxlength="255" style="width:325px;" />
                                <label for="email">Email</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                National Provider ID
                                <input id="national_provider_id" name="national_provider_id" type="text" class="field text addr tbox" value="<?php echo $national_provider_id?>" tabindex="15" maxlength="255" style="width:200px;" />
                            </span>
                        </div>
                    </li>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            Other ID For Claim Forms
                        </label>
                        <div>
                            <span>
                                <?php
                                    $qualifier_sql = "select * from dental_qualifier where status=1 order by sortby";
                                    $qualifier_my = $db->getResults($qualifier_sql);
                                ?>
                                <select id="qualifier" name="qualifier" class="field text addr tbox" tabindex="16">
                                    <option value="0"></option>
                                    <?php if ($qualifier_my) {
                                        foreach ($qualifier_my as $qualifier_myarray) { ?>
                                            <option value="<?php echo st($qualifier_myarray['qualifierid']);?>">
                                                <?php echo st($qualifier_myarray['qualifier']);?>
                                            </option>
                                            <?php
                                        }
                                    } ?>
                                </select>
                                <label for="qualifier">Qualifier</label>
                            </span>
                            <span>
                                <input id="qualifierid" name="qualifierid" type="text" class="field text addr tbox" value="<?php echo $qualifierid?>" tabindex="17" maxlength="255" style="width:200px;" />
                                <label for="qualifierid">ID</label>
                            </span>
                        </div>
                   </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <?php
                                if (isset($_GET['ed'])) {
                                    $ctype_sqlmy = "select * from dental_contact where contactid='".$_GET['ed']."' LIMIT 1;";
                                    $ctid = $db->getRow($ctype_sqlmy);
                                }
                                $ctype_sql = "select * from dental_contacttype where status=1 AND corporate='0' order by sortby";
                                $ctype_my = $db->getResults($ctype_sql);
                                ?>
                                <select id="contacttypeid" name="contacttypeid" class="field text addr tbox" tabindex="20">
                                    <?php
                                    if ($ctype_my) {
                                        foreach ($ctype_my as $ctype_myarray) { ?>
                                            <option <?php if ($ctype_myarray['contacttypeid'] == $ctid['contacttypeid']) { echo " selected='selected'";} ?> <?php if($ctype_myarray['contacttypeid'] == $_GET['type']){ echo " selected='selected'";} ?> <?php if (isset($_GET['ctypeeq']) && $ctype_myarray['contacttypeid'] == '11') { echo " selected='selected'";} ?> value="<?php echo st($ctype_myarray['contacttypeid']);?>">
                                                <?php echo st($ctype_myarray['contacttype']);?>
                                            </option>
                                            <?php
                                        }
                                    } ?>
                                </select>
                                <label for="contacttype">Contact Type</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr> 
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            Notes:
                        </label>
                        <div>
                            <span class="full">
                                <textarea name="notes" id="notes" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?php echo $notes?></textarea>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
                <select name="status" class="tbox" tabindex="22">
                    <option value="1" <?php if ($status == 1) echo " selected";?>>Active</option>
                    <option value="2" <?php if ($status == 2) echo " selected";?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields
                </span><br />
                <input type="hidden" name="contactsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["contactid"]?>" />
                <input type="submit" value=" <?php echo $but_text?> Contact" class="button" />
            </td>
        </tr>
    </table>
</form>

<div style="margin:0 auto;background:url(images/dss_05.png) no-repeat top left;width:980px; height:28px;"> </div>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose">+
        <button>X</button>
    </a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
<script type="text/javascript">
    var cal1 = new calendar2(document.getElementById('ins_dob'));
    var cal2 = new calendar2(document.getElementById('ins2_dob'));
    var cal3 = new calendar2(document.getElementById('dob'));
</script>
</body>
</html>
