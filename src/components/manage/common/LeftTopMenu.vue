<template>
    <div class="left-top-menu">
        <div v-if="showOnlineCEAndSnoozleHelp">
            <a v-bind:href="legacyUrl + 'edx_login.php'" target="_blank" v-on:click="removeCECookies()">Online CE</a>
            <a v-bind:href="legacyUrl + 'help_login.php'" target="_blank" v-on:click="removeCECookies()">Snoozle/Help</a>
        </div>
        <a v-bind:href="legacyUrl + 'calendar.php'">Scheduler</a>
    </div>
</template>

<script src="./LeftTopMenu.js"></script>

<style src="../../../assets/css/manage/common/left-top-menu.css" scoped></style>
