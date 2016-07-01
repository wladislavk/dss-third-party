<style>
    #modal-content {
        width  : 100%;
        height : 100%;
    }
</style>

<template>
    <div id="modal" class="modal">
        <div id="popupContact" style="width:750px;">
            <a id="popupContactClose" v-on:click="disable"><button>X</button></a>

            <div id="modal-content">
                <component :is="currentView"></component>
            </div>
        </div>

        <div id="backgroundPopup" v-on:click="disable"></div>
    </div>
</template>

<script>
    module.exports = {
        data: function() {
            return {
                popupStatus : 0, // 0 - disabled, 1 - enabled
                popupEdit   : false,
                currentView : 'empty'
            }
        },
        created: function() {
            window.addEventListener('keyup', this.onKeyUp);
        },
        beforeDestroy: function() {
            this.$off('keyup');
        },
        components: {
            'empty'  : { template: '' }
        },
        methods: {
            centering: function() {
                var windowWidth  = document.documentElement.clientWidth;
                var windowHeight = document.documentElement.clientHeight;
                var popupHeight  = $("#popupContact").height();
                var popupWidth   = $("#popupContact").width();
                var topPos       = (windowHeight / 2 - popupHeight / 2 + window.pageYOffset) + "px";
                var leftPos      = windowWidth / 2 - popupWidth / 2;
                if (leftPos < 0) {
                    leftPos = 10;
                }
                //centering
                $("#popupContact").css({
                    "position" : "absolute",
                    "top"      : topPos,
                    "left"     : leftPos 
                });
                //only need force for IE6
                $("#backgroundPopup").css({
                    "height": windowHeight
                });
            },
            display: function(component) {
                if (this.hasComponent(component)) {
                    this.centering();

                    // this.popupEdit = false;

                    this.currentView = component;
                    this.popupEdit   = true;

                    //loads popup only if it is disabled
                    if (this.popupStatus == 0) {
                        $("#backgroundPopup").css({
                            "opacity": "0.7"
                        });
                        $("#backgroundPopup").fadeIn("slow");
                        $("#popupContact").fadeIn("slow");

                        this.popupStatus = 1;
                    }
                }
            },
            disable: function() {
                //disables popup only if it is enabled
                if (this.popupStatus == 1) {
                    if (this.popupEdit) {
                        var answer = confirm("Are you sure you want to exit without saving?")
                    } else {
                        var answer = true;
                    }

                    if (answer) {
                        $("#backgroundPopup").fadeOut("slow");
                        $("#popupContact").fadeOut("slow");
                        this.popupStatus = 0;
                        this.currentView = 'empty';
                    }
                }
            },
            onKeyUp: function(e) {
                if (e.keyCode == 27 && this.popupStatus == 1) {
                    this.disable();
                }
            },
            hasComponent: function(component) {
                var existedComponents = Object.keys(this.$options.components.__proto__);

                if (existedComponents.indexOf(component) > -1) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
</script>