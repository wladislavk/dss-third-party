<template>
    <span class="left-top-menu">
        <span v-if="showOnlineCEAndSnoozleHelp">
            <a v-legacy-href="'manage/edx_login.php'" target="_blank" v-on:click="removeCECookies()">Online CE</a>
            <a v-legacy-href="'manage/help_login.php'" target="_blank" v-on:click="removeCECookies()">Snoozle/Help</a>
        </span>
        <a v-legacy-href="'manage/calendar.php'">Scheduler</a>
    </span>
</template>

<script src="./LeftTopMenu.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/common/left-top-menu.scss";
</style>
