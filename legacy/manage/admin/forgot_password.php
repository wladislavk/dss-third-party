<?php
namespace Ds3\Libraries\Legacy;

session_start();

include('includes/main_include.php');
include_once('includes/password.php');
include_once '../includes/constants.inc';

$db = new Db();

if ($_POST["emailsub"] == 1) {
    $validInterval = 'DATE_ADD(recover_time, INTERVAL 1 HOUR)';
    $check_sql = "SELECT
            adminid, username, email,
            first_name, last_name,
            recover_hash,
            NOW() <= $validInterval AS valid
        FROM admin
        WHERE email = '" . $db->escape($_POST['email']) . "'";
    $check_myarray = $db->getRow($check_sql);

    if ($check_myarray) {
        if (!$check_myarray['valid']) {
            $recover_hash = hash('sha256', $check_myarray['adminid'] . $check_myarray['email'] . rand());
            $check_myarray['recover_hash'] = $recover_hash;
            $db->query("UPDATE admin
                SET recover_hash = '$recover_hash', recover_time = NOW()
                WHERE adminid = '" . intval($check_myarray['adminid']) . "'");
        }

        $from = 'Dental Sleep Solutions Support <SWsupport@dentalsleepsolutions.com>';
        $to = $check_myarray['email'];
        $subject = "Dental Sleep Solutions Password Reset";
        $template = getTemplate('admin/reset-password');

        /**
         * Use a central email function, to log activity
         */
        sendEmail($from, $to, $subject, $template, $check_myarray);

        ?>
        <script type="text/javascript">
            window.location.replace('index.php?msg=Email sent');
        </script>
    <?php } else {
        $msg='Email address not found';
        ?>
        <script type="text/javascript">
            window.location.replace('forgot_password.php?msg=<?=$msg;?>');
        </script>
    <?php }

    trigger_error("Die called", E_USER_ERROR);
}
?>
<?php require_once dirname(__FILE__) . '/includes/login_top.htm'; ?>
<!-- BEGIN LOGO -->
<div class="logo">
    <h1 style="color:#ffffff;font-size:30px; margin:9px;">Dental Sleep <span style="color:#187eb7;">Solutions</span></h1>
</div>
<!-- END LOGO -->

<div class="content">
    <?php if($_GET['msg'] != '') { ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php } ?>
    <form name="loginfrm" method="post" action="<?=$_SERVER['PHP_SELF']?>" class="form-horizontal">
        <h3 class="form-title">Password Recovery</h3>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix" />
            </div>
        </div>
        <div class="form-actions" style="margin-left:-35px;">
            <input type="hidden" name="emailsub" value="1" />
            <button type="submit" class="btn blue pull-right" name="btnsubmit">Recover Password
                <i class="m-icon-swapright m-icon-white"></i>
            </button>
            <div class="clearfix"></div>
        </div>
    </form>
</div>
<div class="copyright"><?= date('Y') ?> &copy; dentalsleepsolutions.com</div>
