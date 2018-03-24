<template>
    <div id="warn_logout" ref="warning-logout">
        <br /><br />

        <img src="../../../assets/images/logo.gif" /><br />
        <h1>Your screen has been locked for privacy due to inactivity.<br />Click to reopen your Dental Sleep Solutions software.</h1>
        <p style="color:#fff;font-size:20px;">Log out in <span id="logout_time_remaining" ref="logout-timer"></span>!</p>

        <br /><br />

        <a href="#" v-on:click.prevent="logout()">Logout</a>
        <a href="#" v-on:click.prevent="resetInterval">Stay logged in</a>
    </div>
</template>

<script src="./LogoutWarning.js"></script>
