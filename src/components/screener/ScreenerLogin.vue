<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="keywords" content="" />
    <title>Dental Sleep Solutions</title>
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="/manage/admin/script/validation.js"></script>
</head>
<body>
if(mysqli_num_rows($check_my) == 1) {
<script type="text/javascript">
  window.location.replace('index.php')
</script>
}else{
<script type="text/javascript">
  window.location.replace('login.php?msg=Wrong username or password')
</script>
<div id="login_container">
    <h1>Dental Sleep Solutions</h1>
    <div class="login_content" id="login_sect">
        <h2>Screener Tool</h2>
        <?php if($login_error){ ?>
        <span class="error">Error! Wrong email address or password.</span>
        <?php } ?>
        <?php if($_GET['activated']==1){ ?>
        <span class="success">Account created! Please login below.</span>
        <?php } ?>
        <form name="loginfrm" method="post" action="/" onsubmit="return loginabc(this)">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" tabindex="1" id="username" name="username" />
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" tabindex="2" id="password" name="password" />
            </div>
            <div class="field">
                <input type="hidden" name="loginsub" value="1">
                <button type="submit" name="loginbut" class="large">Log In</button>
            </div>
        </form>
    </div>
</div>

<div style="clear:both;"></div>
<span id="siteseal">
    <script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
    <br />
    <a style="font-family: Arial, sans-serif; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a>
</span>
<div style="clear:both;"></div>
</body>
</html>
