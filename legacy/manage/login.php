<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/includes/dual_app.php';

dualAppRedirect('main');

include('admin/includes/main_include.php');
include('admin/includes/password.php');

$queryString = http_build_query($_GET);

$db = new Db();

if(!empty($_SESSION['loginid'])) {
    $cur_page_full =  $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
    $cur_ins_sql = "insert into dental_login_detail (loginid,userid,cur_page,adddate,ip_address) values('".$_SESSION['loginid']."','".$_SESSION['userid']."','".$cur_page_full."',now(),'".$_SERVER['REMOTE_ADDR']."')";
    $db->query($cur_ins_sql);
}

if(strpos($_SERVER['PHP_SELF'],'q_page') === false && strpos($_SERVER['PHP_SELF'],'ex_page') === false && strpos($_SERVER['PHP_SELF'],'q_sleep') === false && strpos($_SERVER['PHP_SELF'],'q_image') === false) {
    $unload = 0 ;
} else {
    $unload = 1 ;
}

if(isset($_POST["loginsub"]))
{
    $username = $db->escape($_POST['username']);
    $rawPassword = $_POST['password'];

    $salt = $db->getColumn("SELECT salt FROM dental_users WHERE username = '$username'", 'salt');
    $password = $db->escape(gen_password($rawPassword, $salt));

    $check_sql = "SELECT
            u.userid,
            u.username,
            u.name,
            u.first_name,
            u.last_name,
            u.user_access,
            u.status,
            d.status AS doctor_status,
            d.userid AS docid,
            u.user_type,
            uc.companyid
        FROM dental_users u
            LEFT JOIN dental_users d ON d.userid = (
                CASE u.docid
                    WHEN 0 THEN u.userid
                    ELSE u.docid
                END
            )
            LEFT JOIN dental_user_company uc ON uc.userid = (
                CASE u.docid
                    WHEN 0 THEN u.userid
                    ELSE u.docid
                END
            )
        WHERE u.username = '$username'
            AND u.password = '$password'
            AND u.status IN (1, 3)
            AND d.status IN (1, 3)";

    $check_myarray = $db->getRow($check_sql);

    if(!empty($check_myarray)) {
        if ($check_myarray['status'] == 3 || $check_myarray['doctor_status'] == 3) {
            $msg='This account has been suspended.';
        }else{
            $_SESSION['userid']=$check_myarray['userid'];
            $_SESSION['username']=$check_myarray['username'];
            $_SESSION['name']=$check_myarray['first_name']." ".$check_myarray['last_name'];
            $_SESSION['user_access']=$check_myarray['user_access'];
            $_SESSION['companyid']=$check_myarray['companyid'];
            $_SESSION['api_token'] = generateUserApiToken($username, $rawPassword);

            if($check_myarray['docid'] != 0) {
                $_SESSION['docid']=$check_myarray['docid'];
                $ut_sql = "SELECT user_type FROM dental_users WHERE userid='".$db->escape( $check_myarray['docid'])."'";
                $ut_r = $db->getRow($ut_sql);
                $_SESSION['user_type']=$ut_r['user_type'];
            } else {
                $_SESSION['docid']=$check_myarray['userid'];
                $_SESSION['user_type']=$check_myarray['user_type'];
            }

            $_SERVER['QUERY_STRING'];
            $ins_sql = "insert into dental_login (docid,userid,login_date,ip_address) values('".$_SESSION['docid']."','".$_SESSION['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
            $ins_id = $db->getInsertId($ins_sql);

            $_SESSION['loginid']=$ins_id;

            if (isset($_GET['goto'])) {
                $goTo = $_GET['goto'];

                if ($goTo[0] !== '/') {
                    $goTo = "/$goTo";
                }

                $goTo = preg_replace('@/\.\./@', '/', $goTo);
                header("Location: $goTo");
            } else {
                header('Location: /manage/');
            }
            trigger_error("Die called", E_USER_ERROR);
        }
    } else {
        $msg='Username or password not found. This account may be inactive.';
    }
}

if(!empty($_GET['msg'])) {
    $msg = $_GET['msg'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitename;?></title>
    <link href="css/login.css?v=20170331" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<!--[if lte IE 7]>
<div id="alert_container">
  This application does not support old versions of IE.<br />For best performance please use Chrome, Firefox or IE8+
</div>
<![endif]-->


<div id="login_container">
    <div id="form-container">
        <form name="loginfrm" id="loginForm" method="POST" action="/manage/login.php<?= $queryString ? "?$queryString" : '' ?>" onSubmit="return loginabc(this)">
            <table border="0" cellpadding="3" cellspacing="1" bgcolor="#00457C">
                <colgroup>
                    <col width="30%" />
                    <col width="70%" />
                </colgroup>
                <tr bgcolor="#FFFFFF">
                    <td colspan="2" class="t_head">
                       Please Enter Your Login Information
                    </td>
                </tr>
                <?php
                if(!empty($msg)){
                ?>
                    <tr bgcolor="#FFFFFF">
                        <td colspan="2" >
                            <span class="red">
                                <?= e($msg) ?>
                            </span>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr bgcolor="#FFFFFF">
                    <td class="t_data">
                        User name
                    </td>
                    <td class="t_data">
                        <input type="text" name="username" value="<?php echo (isset($_POST['username']))?$_POST['username']:''; ?>">
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td class="t_data">
                        Password
                    </td>
                    <td class="t_data">
                        <input type="password" name="password">
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td colspan="2" align="center" >
                        <input type="hidden" name="loginsub" value="1">
                        <input type="submit" name="btnsubmit" value=" Login " class="addButton">
                    <span style="float:right;">
                        <a href="/manage/register/new.php">Register</a>
                    |
                        <a href="forgot_password.php">Forgot Password</a>
                    </span>
                    </td>
                </tr>
            </table>
            <span style="float:right; margin-top:4px;" class="screener">Looking for the screener? <a href="../screener">Click Here</a></span>
            <span class="clear"></span>
        </form>
    </div>
</div>
<span style="clear:both;" id="siteseal">
    <script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
    <br/><a style="font-family: arial, sans-serif; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a>
</span>
<div style="clear:both;"></div>
</body>
</html>
