<?php
namespace Ds3\Libraries\Legacy;

include_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once 'includes/password.php';
include_once '../includes/general_functions.php';
include_once 'includes/edx_functions.php';
include_once '../includes/help_functions.php';

require_once __DIR__ . '/includes/access.php';

$isBillingAdmin = is_billing($_SESSION['admin_access']);
$canEdit = !$isBillingAdmin;

if (!empty($_POST["staffsub"]) && $_POST["staffsub"] == 1) {
    if (!$canEdit) { ?>
        <script>
            alert('You are not authorized to edit or create users.');
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }

    $sel_check = "select * from dental_users where username = '".s_for($_POST["username"])."' and userid != '".s_for($_POST['ed'])."'";
    $query_check = mysqli_query($con, $sel_check);
    $sel_check2 = "select * from dental_users where email = '".s_for($_POST["email"])."' and userid != '".s_for($_POST['ed'])."'";
    $query_check2 = mysqli_query($con, $sel_check2);

    if (mysqli_num_rows($query_check) > 0) {
        $msg="Username already exist. So please give another Username.";
        ?>
        <script type="text/javascript">
            alert("<?=$msg;?>");
            window.location="#add";
        </script>
        <?php
    } elseif (mysqli_num_rows($query_check2) > 0) {
        $msg="Email already exist. So please give another Email.";
        ?>
        <script type="text/javascript">
            alert("<?=$msg;?>");
            window.location="#add";
        </script>
        <?php
    } else {
        if (
            empty($_POST['username']) ||
            empty($_POST['first_name']) ||
            empty($_POST['last_name']) ||
            empty($_POST['email']) ||
            empty($_POST['status'])
        ) { ?>
            <script>
                alert('Some required fields are missing');
                window.history.back();
            </script>
            <?php
            trigger_error('Die called', E_USER_ERROR);
        }

        if ($_POST["ed"] != "") {
            $p = ($_POST['producer'] == 1) ? 1 : 0;
            $pf = ($_POST['producer_files'] == 1) ? 1 : 0;
            $n = ($_POST['sign_notes'] == 1) ? 1 : 0;
            $c = ($_POST['use_course'] == 1) ? 1 : 0;
            $ein = ($_POST['ein'] == 1) ? 1 : 0;
            $ssn = ($_POST['ssn'] == 1) ? 1 : 0;
            $ed_sql = "update dental_users set 
                user_access=1, 
                docid='".$_GET['docid']."', 
                first_name = '".s_for($_POST["first_name"])."', 
                last_name = '".s_for($_POST["last_name"])."',
                email = '".s_for($_POST["email"])."', 
                phone = '".s_for(num($_POST["phone"]))."', 
                status = '".s_for($_POST["status"])."', 
                producer=".$p.", 
                producer_files = ".$pf.",
                npi = '".s_for($_POST["npi"])."',
                medicare_npi = '".s_for($_POST["medicare_npi"])."',
                medicare_ptan = '".s_for($_POST["medicare_ptan"])."',
                tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."',
                ein = '".s_for($ein)."',
                ssn = '".s_for($ssn)."',
                practice = '".s_for($_POST["practice"])."',
                address = '".s_for($_POST["address"])."',
                city = '".s_for($_POST["city"])."',
                state = '".s_for($_POST["state"])."',
                zip = '".s_for($_POST["zip"])."',
                use_course = '".$c."',
                sign_notes=".$n." where userid='".$_POST["ed"]."'";
            mysqli_query($con, $ed_sql);

            edx_user_update($_POST['ed'], $edx_con);
            help_user_update($_POST['ed']);

            $msg = "Edited Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_staff.php?msg=<?=$msg;?>&docid=<?=$_GET['docid'];?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            if (
                !strlen($_POST['password']) ||
                !strlen($_POST['password2']) ||
                $_POST['password'] !== $_POST['password2']
            ) { ?>
                <script>
                    alert('The password differs from its verification.');
                    window.history.back();
                </script>
                <?php
                trigger_error('Die called', E_USER_ERROR);
            }
            $salt = create_salt();
            $password = gen_password($_POST['password'], $salt);

            $p = (!empty($_POST['producer']) && $_POST['producer'] == 1) ? 1 : 0;
            $pf = (!empty($_POST['producer_files']) && $_POST['producer_files'] == 1) ? 1 : 0;
            $n = (!empty($_POST['sign_notes']) && $_POST['sign_notes'] == 1) ? 1 : 0;
            $c = (!empty($_POST['use_course']) && $_POST['use_course'] == 1) ? 1 : 0;
            $ein = (!empty($_POST['ein']) && $_POST['ein'] == 1) ? 1 : 0;
            $ssn = (!empty($_POST['ssn']) && $_POST['ssn'] == 1) ? 1 : 0;

            $ins_sql = "insert into dental_users set
                user_access=1,
                docid='".$_GET['docid']."',
                username = '".s_for($_POST["username"])."',
                password = '".$db->escape($password)."',
                salt='".$salt."',
                first_name = '".s_for($_POST["first_name"])."', 
                last_name = '".s_for($_POST["last_name"])."',
                name = '".s_for(trim($_POST["first_name"] . ' ' . $_POST["last_name"]))."',
                email = '".s_for($_POST["email"])."',
                phone = '".s_for(num($_POST["phone"]))."',
                status = '".s_for($_POST["status"])."',
                adddate=now(),
                ip_address='".$_SERVER['REMOTE_ADDR']."',
                producer=".$p.",
                producer_files = ".$pf.",
                npi = '".s_for($_POST["npi"])."',
                medicare_npi = '".s_for($_POST["medicare_npi"])."',
                medicare_ptan = '".s_for($_POST["medicare_ptan"])."',
                tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."',
                ein = '".s_for($ein)."',
                ssn = '".s_for($ssn)."',
                practice = '".s_for($_POST["practice"])."',
                address = '".s_for($_POST["address"])."',
                city = '".s_for($_POST["city"])."',
                state = '".s_for($_POST["state"])."',
                zip = '".s_for($_POST["zip"])."',
                use_course = ".$c.",
                sign_notes=".$n;
            mysqli_query($con,$ins_sql);
            $userid = mysqli_insert_id($con);
            edx_user_update($userid, (!empty($edx_con) ? $edx_con : ''));
            help_user_update($userid);

            $docname_sql = "SELECT name from dental_users WHERE userid='".$db->escape($_GET['docid'])."'";
            $docname_q = mysqli_query($con,$docname_sql);
            $docname_r = mysqli_fetch_assoc($docname_q);
            $docname = $docname_r['name'];
            $co_sql = "SELECT c.id, c.name from companies c
                JOIN dental_user_company uc ON c.id = uc.companyid
                JOIN dental_users u ON u.userid = uc.userid
                WHERE u.userid='".$db->escape($_GET['docid'])."'";
            $co_q = mysqli_query($con,$co_sql);
            $co_r = mysqli_fetch_assoc($co_q);
            $cid = $co_r['id'];
            $cname = $co_r['name'];
            $msg = "Added Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_staff.php?msg=<?=$msg;?>&docid=<?=$_GET['docid'];?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
    }
}

include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

<?php
$thesql = "select * from dental_users where userid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
$themy = mysqli_query($con,$thesql);
$themyarray = mysqli_fetch_array($themy);

if (!empty($msg)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];
    $producer = (!empty($_POST['producer']) ? $_POST['producer'] : '');
    $producer_files = (!empty($_POST['producer_files']) ? $_POST['producer_files'] : '');
    $npi = $_POST['npi'];
    $medicare_npi = $_POST['medicare_npi'];
    $medicare_ptan = $_POST['medicare_ptan'];
    $tax_id_or_ssn = $_POST['tax_id_or_ssn'];
    $ein = (!empty($_POST['ein']) ? $_POST['ein'] : '');
    $ssn = (!empty($_POST['ssn']) ? $_POST['ssn'] : '');
    $practice = $_POST['practice'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $use_course = (!empty($_POST['use_course']) ? $_POST['use_course'] : '');
    $sign_notes = (!empty($_POST['sign_notes']) ? $_POST['sign_notes'] : '');
} else {
    $username = st($themyarray['username']);
    $password = st($themyarray['password']);
    $first_name = st($themyarray['first_name']);
    $last_name = st($themyarray['last_name']);
    $email = st($themyarray['email']);
    $address = st($themyarray['address']);
    $phone = st($themyarray['phone']);
    $status = st($themyarray['status']);
    $producer = st($themyarray['producer']);
    $producer_files = st($themyarray['producer_files']);
    $npi = st($themyarray['npi']);
    $medicare_npi = st($themyarray['medicare_npi']);
    $medicare_ptan = st($themyarray['medicare_ptan']);
    $tax_id_or_ssn = st($themyarray['tax_id_or_ssn']);
    $ein = st($themyarray['ein']);
    $ssn = st($themyarray['ssn']);
    $practice = st($themyarray['practice']);
    $address = st($themyarray['address']);
    $city = st($themyarray['city']);
    $state = st($themyarray['state']);
    $zip = st($themyarray['zip']);
    $phone = st($themyarray['phone']);
    $use_course = st($themyarray['use_course']);
    $sign_notes = st($themyarray['sign_notes']);
    $but_text = "Add ";
}

if ($themyarray["userid"] != '') {
    $but_text = "Edit ";
} else {
    $but_text = "Add ";
} ?>
<br /><br />
<?php
if (!empty($msg)) { ?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php
} ?>
<form name="stafffrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&docid=<?=$_GET['docid'];?>" method="post" onSubmit="return staffabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
                <?=$but_text?> Staff
                <?php if ($username != "") { ?>
                    &quot;<?=$username;?>&quot;
                <?php } ?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Username
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="username" value="<?=$username?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <?php if ($themyarray["userid"] == '') { ?>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Password
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="password" value="<?=$password;?>" class="form-control" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Verify Password
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="password2" value="<?=$password2;?>" class="form-control" />
                    <span class="red">*</span>
                </td>
            </tr>
        <?php } ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="first_name" value="<?=$first_name;?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="last_name" value="<?=$last_name;?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Email
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="email" value="<?=$email;?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
                <select name="status" class="form-control">
                    <option value="1" <?php if ($status == 1) echo " selected"; ?>>Active</option>
                    <option value="2" <?php if ($status == 2) echo " selected"; ?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Producer
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($producer == 1) ? 'checked="checked"' : ''; ?> value="1" id="producer" name="producer" />
            </td>
        </tr>
        <tr class="producer_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Producer bills insurance under their name?
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($producer_files == 1) ? 'checked="checked"' : ''; ?> value="1" id="producer_files" name="producer_files" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#ffffff">
            <td colspan="2">
                Fields left blank below will default to the standard billing settings for your office.
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                NPI
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="npi" value="<?=$npi;?>" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Medicare Provider (NPI/DME) Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="medicare_npi" value="<?=$medicare_npi;?>" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Medicare PTAN Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="medicare_ptan" value="<?=$medicare_ptan;?>" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Tax ID or SSN
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="tax_id_or_ssn" value="<?=$tax_id_or_ssn;?>" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                EIN or SSN
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($ein==1)?'checked="checked"':''; ?> value="1" name="ein" /> EIN
                <input type="checkbox" <?= ($ssn==1)?'checked="checked"':''; ?> value="1" name="ssn" /> SSN
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Practice
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="practice" value="<?=$practice;?>" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="address" class="form-control" id="address" value="<?= $address; ?>" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                City
            </td>
            <td valign="top" class="frmdata">
                <input id="city" type="text" value="<?php echo $city;?>" name="city" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                State
            </td>
            <td valign="top" class="frmdata">
                <input id="state" type="text" value="<?php echo $state;?>" name="state" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Zip
            </td>
            <td valign="top" class="frmdata">
                <input id="zip" type="text" name="zip" value="<?php echo $zip;?>" class="form-control" />
            </td>
        </tr>
        <tr class="files_field" bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Phone
            </td>
            <td valign="top" class="frmdata">
                <input id="phone" type="text" name="phone" value="<?=$phone;?>" class="form-control" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Sign Progress Notes?
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($sign_notes == 1) ? 'checked="checked"' : ''; ?> value="1" name="sign_notes" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Course Active?
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" <?= ($use_course == 1) ? 'checked="checked"' : ''; ?> value="1" name="use_course" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <span class="red">
                    * Required Fields
                </span><br />
                <input type="hidden" name="staffsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["userid"]?>" />
                <input type="submit" value="<?=$but_text?> Staff" class="btn btn-primary">
                <?php if ($themyarray["userid"] != '') { ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_staff.php?delid=<?=$themyarray["userid"];?>&docid=<?=$_GET['docid'];?>'" onclick="return confirm('Do Your Really want to Delete?.');" class="btn btn-danger pull-right" title="DELETE">
                        Delete
                    </a>
                <?php } ?>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    $('#producer').click(function () {
        if ($(this).is(':checked')) {
            $('.producer_field').show();
            if ($('#producer_files').is(':checked')) {
                $('.files_field').show();
            }
        } else {
            $('.producer_field').hide();
            $('.files_field').hide();
        }
    });
    $('#producer_files').click(function () {
        if ($(this).is(':checked')) {
            $('.files_field').show();
        } else {
            $('.files_field').hide();
        }
    });

    if ($('#producer').is(':checked')) {
        $('.producer_field').show();
        if ($('#producer_files').is(':checked')) {
            $('.files_field').show();
        } else {
            $('.files_field').hide();
        }
    } else {
        $('.producer_field').hide();
        $('.files_field').hide();
    }

    function check_add() {
        $('form[name=stafffrm]').find('input:not(:checkbox), select').each(function () {
            if ($(this).val() == '') {
                alert('All fields are required.');
                return false;
          }
      });

      if ($('[name=password]').length && ($('[name=password]').val() !== $('[name=password2]').val())) {
          alert('The password must match its verification.');
          return false;
      }
      return true;
    }

    jQuery(function ($) {
        <?php if (!$canEdit) { ?>
            $('form[name=stafffrm]').find('input, select, button').prop('disabled', true);
        <?php } ?>
        $('form[name=stafffrm]').submit(function (event) {
            return check_add();
        });
    }(jQuery));
</script>

</body>
</html>
