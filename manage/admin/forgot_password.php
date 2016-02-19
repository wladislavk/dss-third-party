<?php namespace Ds3\Libraries\Legacy; ?><?
session_start();
include('includes/main_include.php');
include_once('includes/password.php');
include_once '../includes/constants.inc';
if($_POST["emailsub"] == 1)
{
        $check_sql = "SELECT adminid, username, email FROM admin WHERE email='".mysqli_real_escape_string($con, $_POST['email'])."'";
        $check_my = mysqli_query($con, $check_sql);
	//echo $check_sql;
        if(mysqli_num_rows($check_my) >= 1)
        {
                $check_myarray = mysqli_fetch_array($check_my);

                /*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
                mysqli_query($con, $ins_sql);*/
                $recover_hash = hash('sha256', $check_myarray['adminid'].$_POST['email'].rand());
                $ins_sql = "UPDATE admin set recover_hash='".$recover_hash."', recover_time=NOW() WHERE adminid='".$check_myarray['adminid']."'";
                mysqli_query($con, $ins_sql);

                $headers = 'From: SWsupport@dentalsleepsolutions.com' . "\r\n" .
			'Content-type: text/html' ."\r\n" .
                    'Reply-To: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Password Reset";
                $message = "Please use this link to reset your password.
<br /><br />
<a href=\"http://".$_SERVER['HTTP_HOST']."/manage/admin/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash."\">
http://".$_SERVER['HTTP_HOST']."/manage/admin/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash."
</a>";
$message .= "<br /><br />";
$message .= DSS_EMAIL_FOOTER;
                //$ins_id = mysqli_insert_id($con);
                $msg = mail($check_myarray['email'], $subject, $message, $headers);

                ?>
                <script type="text/javascript">
                        //alert("<?= $msg; ?>");
                        window.location.replace('index.php?msg=Email sent');
                </script>
                <?
                trigger_error("Die called", E_USER_ERROR);
        }
        else
        {
                $msg='Email address not found';
                ?>
                <script type="text/javascript">
                        window.location.replace('forgot_password.php?msg=<?=$msg;?>');
                </script>
                <?
                trigger_error("Die called", E_USER_ERROR);
        }
}

?>

<?php require_once dirname(__FILE__) . '/includes/login_top.htm'; ?>

<!-- BEGIN LOGO -->
<div class="logo">
    <h1  style="color:#ffffff;font-size:30px; margin:9px;">Dental Sleep <span style="color:#187eb7;">Solutions</span></h1>
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
