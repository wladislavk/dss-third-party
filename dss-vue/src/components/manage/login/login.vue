<style src="./login.css"></style>

<template>
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
</template>

<script src="../../../../assets/js/tracekit/tracekit.js"></script>
<script src="../../../../assets/js/tracekit/tracekit.handler.js"></script>
<script src="../../../../assets/js/jquery-1.6.2.min.js"></script>
<script src="../../../../assets/js/manage/validation.js"></script>

<script>
    module.exports = require('./login.js');
</script>