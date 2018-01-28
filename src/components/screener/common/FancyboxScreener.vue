<template>
    <div>
        <div id="fancybox-overlay" class="overlay"></div>
        <div id="fancybox-wrap" class="wrap">
            <div id="fancybox-outer" class="content-outer">
                <div class="fancybox-bg" id="fancybox-bg-n"></div>
                <div class="fancybox-bg" id="fancybox-bg-ne"></div>
                <div class="fancybox-bg" id="fancybox-bg-e"></div>
                <div class="fancybox-bg" id="fancybox-bg-se"></div>
                <div class="fancybox-bg" id="fancybox-bg-s"></div>
                <div class="fancybox-bg" id="fancybox-bg-sw"></div>
                <div class="fancybox-bg" id="fancybox-bg-w"></div>
                <div class="fancybox-bg" id="fancybox-bg-nw"></div>
                <div id="fancybox-content" class="content">
                    <div class="content-inner">
                        <div id="regModal">
                            <h4 class="sepH_a">Survey Complete</h4>
                            <p class="sepH_c">Thank you for completing the survey. Please return this device to our staff or let them know you have completed the survey.</p>
                            <a href="#" v-on:click.prevent="closeAndReset()" id="finish_ok" class="btn btn_d">OK</a>
                        </div>
                    </div>
                </div>
                <a href="#" id="fancybox-close" class="close-button" v-on:click.prevent="closeFancybox()"></a>
            </div>
        </div>
    </div>
</template>

<script src="./FancyboxScreener.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/common/fancybox.scss";
</style>
