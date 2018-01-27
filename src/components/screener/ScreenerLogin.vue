<template>
    <div class="login_body">
        <div id="login_container">
            <h1>Dental Sleep Solutions</h1>
            <div class="login_content" id="login_sect">
                <h2>Screener Tool</h2>
                <span class="error" v-if="loginError">Error! Wrong email address or password.</span>
                <form name="loginfrm">
                    <div class="field">
                        <label for="username">Username</label>
                        <input type="text" tabindex="1" id="username" name="username" v-model="username" />
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" tabindex="2" id="password" name="password" v-model="password" v-on:change="setPassword($event)" />
                    </div>
                    <div class="field">
                        <button type="submit" name="loginbut" id="loginbut" class="large" v-on:click.prevent="onSubmit()">Log In</button>
                    </div>
                </form>
            </div>
        </div>

        <div style="clear:both;"></div>
        <site-seal></site-seal>
        <div style="clear:both;"></div>
    </div>
</template>

<script src="./ScreenerLogin.js"></script>

<style lang="scss" scoped>
    @import "../../assets/css/screener/login.scss";
</style>
