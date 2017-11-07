<template>
    <div class="suckertreemenu2">
        <ul id="topmenu2">
            <li>
                <router-link v-bind:to="{name: 'dashboard'}">Notifications({{ notificationsNumber }})</router-link>
            </li>
            <li class="header_support" v-bind:class="{'pending': supportTicketsNumber}">
                <a v-bind:href="legacyUrl + 'support.php'">
                    Support&nbsp;
                    <span v-if="supportTicketsNumber">({{ supportTicketsNumber }})</span>
                </a>
            </li>
            <li>
                <a href="#" v-on:click.prevent="logout()">Sign Out</a>
            </li>
        </ul>
    </div>
</template>

<script src="./RightTopMenu.js"></script>

<style src="../../../assets/css/manage/common/right-top-menu.css" scoped></style>
