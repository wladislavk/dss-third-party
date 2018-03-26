<template>
    <div>
        <div id="fancybox-overlay" style="background-color: rgb(119, 119, 119); opacity: 0; cursor: auto; height: 559px;"></div>
        <div id="fancybox-wrap" style="width: 320px; height: auto; top: 241px; left: 495px;">
            <div id="fancybox-outer">
                <div class="fancybox-bg" id="fancybox-bg-n"></div>
                <div class="fancybox-bg" id="fancybox-bg-ne"></div>
                <div class="fancybox-bg" id="fancybox-bg-e"></div>
                <div class="fancybox-bg" id="fancybox-bg-se"></div>
                <div class="fancybox-bg" id="fancybox-bg-s"></div>
                <div class="fancybox-bg" id="fancybox-bg-sw"></div>
                <div class="fancybox-bg" id="fancybox-bg-w"></div>
                <div class="fancybox-bg" id="fancybox-bg-nw"></div>
                <div id="fancybox-content" style="border-width: 10px; width: 300px; height: 150px;">
                    <div style="width:300px;height:150px;overflow: auto;position:relative;">
                        <div id="regModal">
                            <h4 class="sepH_a">Survey Complete</h4>
                            <p class="sepH_c">Thank you for completing the survey. Please return this device to our staff or let them know you have completed the survey.</p>
                            <a href="#" v-on:click.prevent="closeAndReset()" id="finish_ok" class="btn btn_d">OK</a>
                        </div>
                    </div>
                </div>
                <a href="#" id="fancybox-close" style="display: inline;" v-on:click.prevent="closeFancybox()"></a>
            </div>
        </div>
    </div>
</template>

<script src="./FancyboxScreener.js"></script>
