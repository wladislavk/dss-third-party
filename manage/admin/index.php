<?php
//session_start();
include('includes/main_include.php');
include_once('includes/password.php');

if (isset($_POST["loginsub"])) {
    if ($_POST['security_code'] == $_SESSION['security_code']) {
        $salt_sql = "SELECT salt FROM admin WHERE username='".mysql_real_escape_string($_POST['username'])."' AND status=1";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);
        
        $pass = gen_password($_POST['password'], $salt_row['salt']);
        $check_sql = "SELECT a.*, ac.companyid  FROM admin a
            LEFT JOIN admin_company ac ON a.adminid = ac.adminid
            where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."'";
        
        $check_my = mysql_query($check_sql) or die(mysql_error().' | '.$check_sql);
        
        if (mysql_num_rows($check_my) == 1) {
            $check_myarray = mysql_fetch_array($check_my);
            
            $_SESSION['adminuserid']=$check_myarray['adminid'];
            $_SESSION['admin_access']=$check_myarray['admin_access'];
            $_SESSION['admincompanyid']=$check_myarray['companyid'];
            
            ?>
        <script type="text/javascript">
            window.location.replace('home.php');
        </script>
            <?php
            die();
        }
        else { ?>
        <script type="text/javascript">
            window.location.replace('index.php?msg=Wrong+username+or+password');
        </script>
            <?php
            die();
        }
    }
    else { ?>
        <script type="text/javascript">
            window.location.replace('index.php?msg=Incorrect+security+code');
        </script>
        <?php
        die();
    }
}

?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
    <div class="container">
        <div class="well">
            <h1>Dental Sleep Solutions</h1>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php if (isset($_GET['msg'])) { ?>
                <div class="alert alert-warning">
                    <strong><?= $_GET['msg'] ?></strong>
                </div>
                <?php } ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">Admin login</div>
                    <div class="panel-body">
                        <form name="loginfrm" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" onsubmit="return loginabc(this)" class="form-horizontal">
                            <div class="form-group">
                                <label for="username" class="col-md-3 control-label">Username</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <img src="../CaptchaSecurityImages.php?width=100&amp;height=40&amp;characters=5" width="100" height="40" alt="If you cannot see the captcha, reload the page please">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="captcha" class="col-md-3 control-label">Captcha</label>
                                <div class="col-md-9 text-center">
                                    <input type="text" class="form-control" name="security_code" id="captcha" placeholder="write the characters in the image">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3 ">
                                    <input type="submit" name="loginsub" value="Login" class="btn btn-success">
                                    <a href="/manage/admin/forgot_password.php" class="btn btn-default">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php require_once dirname(__FILE__) . '/includes/bottom.htm'; ?>
