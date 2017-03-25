<?php
namespace Ds3\Libraries\Legacy;

include_once('admin/includes/main_include.php');
include_once('admin/includes/password.php');

if (isset($_POST['recoversub']) && $_POST['recoversub'] == 1) {
    if (empty($_POST['password1'])) {
        $msg = 'The password cannot be empty';
    } elseif ($_POST['password1'] == $_POST['password2']) {
        $salt = create_salt();
        $pass = gen_password($_POST['password1'], $salt);
        $up_sql = "UPDATE dental_users SET password='".mysqli_real_escape_string($con, $pass)."', salt='".$salt."', recover_hash='' WHERE userid = '".mysqli_real_escape_string($con, $_POST['userid'])."' AND recover_hash='".mysqli_real_escape_string($con, $_POST['hash'])."'";

        $db->query($up_sql);?>
        <script type="text/javascript">
            window.location.replace('login.php?msg=Password reset');
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    } else {
        $msg = "The password and the verification don't match";
    }
} else {
    $username = $db->escape($_GET['un']);
    $recoverHash = $db->escape($_GET['rh']);
    $validInterval = 'DATE_ADD(recover_time, INTERVAL 1 HOUR)';

    $check_sql = "SELECT
            userid,
            recover_time,
            $validInterval AS expiration_date,
            NOW() <= $validInterval AS valid
        FROM dental_users
        WHERE username = '$username'
            AND recover_hash = '$recoverHash'";

    $check_myarray = $db->getRow($check_sql);

    if (empty($check_myarray['valid'])) {
        if ($check_myarray) {
            $msg = 'Reset link expired' .
                ($check_myarray['expiration_date'] ? ' on ' . $check_myarray['expiration_date'] : '');
        } else {
            $msg = 'Unable to find user with a matching recovery hash';
        }

        ?>
        <script type="text/javascript">
            window.location.replace('forgot_password.php?msg=<?= urlencode($msg) ?>');
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }
}

if (!empty($_GET['msg'])) {
    $msg = empty($msg) ? $_GET['msg'] : "{$msg}. {$_GET['msg']}";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?= e($sitename) ?> &mdash; Password Reset</title>
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
</head>
<body>
<div id="login_container">
    <FORM name="loginfrm" method="post">
        <input type="hidden" name="recoversub" value="1">
        <input type="hidden" name="hash" value="<?= e($_GET['rh']) ?>" />
        <input type="hidden" name="userid" value="<?= e($check_myarray ? $check_myarray['userid'] : '') ?>" />
        <table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
            <tr bgcolor="#FFFFFF">
                <td colspan="2" class="t_head">
                    Password Reset
                    <?php if (!empty($_GET['un'])) { ?>
                        <small>for user <?= e($_GET['un']) ?></small>
                    <?php } ?>
                </td>
            </tr>
            <?php if (!empty($msg)) { ?>
                <tr bgcolor="#FFFFFF">
                    <td colspan="2" >
                    <span class="red">
                        <?= e($msg) ?>
                    </span>
                    </td>
                </tr>
            <?php } ?>
            <tr bgcolor="#FFFFFF">
                <td class="t_data">
                    Password
                </td>
                <td class="t_data">
                    <input type="password" name="password1" />
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td class="t_data">
                    Re-type password
                </td>
                <td class="t_data">
                    <input type="password" name="password2" />
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td colspan="2" align="center">
                    <input type="submit" name="btnsubmit" value="Reset Password" class="addButton">
                </td>
            </tr>
        </table>
    </FORM>
</div>
