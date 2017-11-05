<template>
    <div>
        <div v-if="showOnlineCEAndSnoozleHelp">
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'edx_login.php'" target="_blank">Online CE</a>
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'help_login.php'" target="_blank">Snoozle/Help</a>
            <!-- @todo: check why onclick calls are needed -->
            <!--
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'edx_login.php'" target="_blank" onclick="removeCECookies()">Online CE</a>
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'help_login.php'" target="_blank" onclick="removeCECookies()">Snoozle/Help</a>
            -->
        </div>
        <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'calendar.php'">Scheduler</a>
    </div>
</template>

<script src="./LeftTopMenu.js"></script>
