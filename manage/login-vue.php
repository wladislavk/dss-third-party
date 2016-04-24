<?php namespace Ds3\Libraries\Legacy; ?><?php
include('admin/includes/main_include.php');
include('admin/includes/password.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $sitename;?></title>
        <link href="css/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
        <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
        <script type="text/javascript" src="admin/script/jquery-2.2.3.min.js"></script>
        <script type="text/javascript" src="script/validation.js"></script>

        <script src="/assets/vendor/vue/vue.js" type="text/javascript"></script>
        <script src="/assets/vendor/vue/vue-resource.min.js" type="text/javascript"></script>
    </head>
    <body>

        <!--[if lte IE 7]>
        <div id="alert_container">
            This application does not support old versions of IE.<br />For best performance please use Chrome, Firefox or IE8+
        </div>
        <![endif]-->

        <div id="login_container">
            <form name="loginfrm" id="loginForm" v-on="submit: submitForm">
                <table border="0" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
                    <tr bgcolor="#FFFFFF">
                        <td colspan="2" class="t_head">
                            Please Enter Your Login Information
                        </td>
                    </tr>
                    <tr v-if="message" bgcolor="#FFFFFF">
                        <td colspan="2" >
                            <span class="red">{{ message }}</span>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td class="t_data">User name</td>
                        <td class="t_data">
                            <input
                                type="text"
                                v-model="credentials.username"
                                v-el="username"
                                autofocus
                            >
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td class="t_data">Password</td>
                        <td class="t_data">
                            <input
                                type="password"
                                v-model="credentials.password"
                                v-el="password"
                            >
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center" >
                            <input type="hidden" name="loginsub" value="1">
                            <input type="hidden" id="dom-api-token" value="<?php echo apiToken() ?>" v-model="token">
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
            </form>
        </div>
        <span style="clear:both;" id="siteseal">
            <script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
            <br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a>
        </span>
        <div style="clear:both;"></div>

        <script>
            var apiRoot = "<?php echo /*json_encode(config('app.apiUrl'))*/'http://ds3.api:81/' ?>";
        </script>
        <script src="/assets/app/login.js" type="text/javascript"></script>
    </body>
</html>
