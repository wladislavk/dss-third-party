<template>
    <div class="suckertreemenu2">
        <ul id="topmenu2">
            <li>
                <router-link v-bind:to="{name: 'dashboard'}">Notifications({{ notificationsNumber }})</router-link>
            </li>
            <li class="header_support" id="header_support" v-bind:class="{'pending': supportTicketsNumber}">
                <a v-legacy-href="'manage/support.php'">
                    Support <span v-if="supportTicketsNumber">({{ supportTicketsNumber }})</span>
                </a>
            </li>
            <li>
                <a href="#" id="logout" v-on:click.prevent="logout()">Sign Out</a>
            </li>
        </ul>
    </div>
</template>

<script src="./RightTopMenu.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/common/right-top-menu.scss";
</style>
