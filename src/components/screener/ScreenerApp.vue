<template v-bind:key="$route.name">
    <div class="screener_body fixed">
        <div id="header">
            <div class="wrapper cf">
                <div class="logo fl">
                    <h1>Dental Sleep Solutions</h1>
                </div>
                <ul id="main_nav" class="fr">
                    <li class="nav_item lgutipT" title="start over" id="reset_nav" v-show="showReset">
                        <a href="#" v-on:click.prevent="onReset()" class="main_link" id="reset_link">
                            <img class="img_holder refresh_image" alt="Refresh" src="../../assets/images/blank.gif" />
                            <span>Reset and Start Over</span>
                        </a>
                    </li>
                    <li class="nav_item lgutipT" title="Log Out">
                        <a href="#" v-on:click.prevent="onLogout()" class="main_link" id="logout_link">
                            <img class="img_holder logout_image" alt="Logout" src="../../assets/images/blank.gif" />
                            <span>Log Out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="main">
            <div class="wrapper cf">
                <div class="cf brdrrad_a" id="main_section">
                    <router-view></router-view>
                    <div style="clear:both;"></div>
                </div>
            </div>

            <!-- footer section -->
            <div id="footer">
                <div class="wrapper">
                    <span class="fr">Copyright Dental Sleep Solutions {{ currentYear }}</span>
                </div>
            </div>
        </div>
        <fancybox-screener v-show="showFancybox"></fancybox-screener>
    </div>
</template>

<script src="./ScreenerApp.js"></script>

<style src="../../assets/css/screener/lagu.css"></style>
<style src="../../assets/css/screener/screener.css"></style>
<!--[if IE]>
<style src="../../assets/css/screener/style_ie.css"></style>
<![endif]-->
<style src="../../../static/third-party/jquery.fancybox.css"></style>
