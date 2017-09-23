<template>
    <div>
        <div id="login_container">
            <form name="loginfrm" id="loginForm" v-on:submit.prevent="submitForm">
                <table border="0" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
                    <tr bgcolor="#FFFFFF">
                        <td colspan="2" class="t_head">Please Enter Your Login Information</td>
                    </tr>
                    <tr v-if="message" bgcolor="#FFFFFF">
                        <td colspan="2"><span class="red">{{ message }}</span></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td class="t_data">User name</td>
                        <td class="t_data">
                            <input
                                type="text"
                                v-model="credentials.username"
                                ref="username"
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
                                ref="password"
                            >
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center">
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

        <site-seal></site-seal>
        <div style="clear:both;"></div>
    </div>
</template>

<script src="./login.js"></script>

<style src="../../../assets/css/manage/login.css" scoped></style>
