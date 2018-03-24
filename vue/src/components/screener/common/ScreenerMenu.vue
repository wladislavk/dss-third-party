<template>
    <ul id="main_nav" class="main_nav fr">
        <li class="nav_item lgutipT" title="start over" id="reset_nav" v-show="showReset">
            <a href="#" v-on:click.prevent="onReset()" class="main_link" id="reset_link">
                <img class="img_holder refresh_image" alt="Refresh" src="../../../assets/images/blank.gif" />
                <span>Reset and Start Over</span>
            </a>
        </li>
        <li class="nav_item lgutipT" title="Log Out">
            <a href="#" v-on:click.prevent="onLogout()" class="main_link" id="logout_link">
                <img class="img_holder logout_image" alt="Logout" src="../../../assets/images/blank.gif" />
                <span>Log Out</span>
            </a>
        </li>
    </ul>
</template>

<script src="./ScreenerMenu.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/common/menu.scss";
</style>
