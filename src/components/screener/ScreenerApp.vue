<template>
    <div>
        <div id="header">
            <div class="wrapper cf">
                <div class="logo fl">
                    <h1>Dental Sleep Solutions</h1>
                </div>
                <ul id="main_nav" class="fr">
                    <li class="nav_item lgutipT" title="start over" id="restart_nav" v-if="!this.isIntro">
                        <a href="#" v-on:click.prevent="onReset()" class="main_link">
                            <img class="img_holder" style="background-image: url(~assets/images/icons/refresh.png)" alt="" src="~assets/images/blank.gif" />
                            <span>Reset and Start Over</span>
                        </a>
                    </li>
                    <li class="nav_item lgutipT" title="Log Out">
                        <a href="#" v-on:click.prevent="onLogout()" class="main_link">
                            <img class="img_holder" style="background-image: url(~assets/images/icons/locked2.png)" alt="" src="~assets/images/blank.gif" />
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
    </div>
</template>

<script src="./ScreenerApp.js"></script>

<style src="../../assets/css/screener/lagu.css" scoped></style>
<style src="../../assets/css/screener/screener.css" scoped></style>
<!--[if IE]>
<style src="../../assets/css/screener/style_ie.css" scoped></style>
<![endif]-->
