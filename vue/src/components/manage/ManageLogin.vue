<template>
    <div id="root" class="root">
        <div id="login_container" class="login_container">
            <form name="loginfrm" id="loginForm">
                <table border="0" cellpadding="3" cellspacing="1" width="40%">
                    <tr>
                        <td colspan="2" class="t_head">Please Enter Your Login Information</td>
                    </tr>
                    <tr v-if="message">
                        <td colspan="2"><span class="red">{{ message }}</span></td>
                    </tr>
                    <tr>
                        <td class="t_data"><label for="username">User name</label></td>
                        <td class="t_data">
                            <input
                                id="username"
                                name="username"
                                type="text"
                                v-model="credentials.username"
                                v-focus="focusUser"
                                v-on:focus="focusUser = true"
                                v-on:blur="focusUser = false"
                                autofocus
                                v-on:change="setUsername($event)"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="t_data"><label for="password">Password</label></td>
                        <td class="t_data">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                v-model="credentials.password"
                                v-focus="focusPassword"
                                v-on:focus="focusPassword = true"
                                v-on:blur="focusPassword = false"
                                v-on:change="setPassword($event)"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" name="btnsubmit" id="btnsubmit" value=" Login " class="addButton" v-on:click.prevent="submitForm()">
                            <span class="registration_links">
                                <span class="root-text"><a v-legacy-href="'manage/register/new.php'">Register</a></span>
                                |
                                <span class="root-text"><a v-legacy-href="'manage/forgot_password.php'">Forgot Password</a></span>
                            </span>
                        </td>
                    </tr>
                </table>
                <span class="screener root-text">Looking for the screener? <router-link v-bind:to="{name: 'screener-root'}">Click Here</router-link></span>
            </form>
        </div>
        <site-seal></site-seal>
        <div class="clear"></div>
    </div>
</template>

<script src="./ManageLogin.js"></script>

<style lang="scss" scoped>
    @import "../../assets/css/manage/login.scss";
</style>
