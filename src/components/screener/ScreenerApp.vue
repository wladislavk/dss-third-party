<template v-bind:key="$route.name">
    <div class="screener_body fixed">
        <div id="header" class="header">
            <div class="wrapper cf">
                <div class="logo fl">
                    <h1>Dental Sleep Solutions</h1>
                </div>
                <screener-menu></screener-menu>
            </div>
        </div>
        <div id="main">
            <div class="wrapper cf">
                <div class="cf brdrrad_a main_section" id="main_section">
                    <router-view></router-view>
                    <div class="clear"></div>
                </div>
            </div>
            <screener-footer></screener-footer>
        </div>
        <fancybox-screener v-show="showFancybox"></fancybox-screener>
    </div>
</template>

<script src="./ScreenerApp.js"></script>

<style lang="scss" scoped>
    @import "../../assets/css/screener/app.scss";
</style>
