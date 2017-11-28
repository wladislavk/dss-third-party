<template>
    <span class="left-top-menu">
        <span v-if="showOnlineCEAndSnoozleHelp">
            <a v-bind:href="legacyUrl + 'edx_login.php'" target="_blank" v-on:click="removeCECookies()">Online CE</a>
            <a v-bind:href="legacyUrl + 'help_login.php'" target="_blank" v-on:click="removeCECookies()">Snoozle/Help</a>
        </span>
        <a v-bind:href="legacyUrl + 'calendar.php'">Scheduler</a>
    </span>
</template>

<script src="./LeftTopMenu.js"></script>

<style src="../../../assets/css/manage/common/left-top-menu.css" scoped></style>
