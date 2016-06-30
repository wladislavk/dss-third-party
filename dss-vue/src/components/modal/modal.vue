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

    <button v-on:click="display('abc')">Popup</button>
</template>

<script>
    module.exports = {
        data: function() {
            return {
                //SETTING UP OUR POPUP
                //0 means disabled; 1 means enabled;
                popupStatus : 0,
                popupEdit   : false,
                currentView : 'test'
            }
        },
        created: function() {
            window.addEventListener('keyup', this.onKeyUp);
        },
        beforeDestroy: function() {
            this.$off('keyup');
        },
        components: {
            'test': {
                template: '<h1>Test</h1>'
            },
            'test1': {
                template: '<h1>Test1</h1>'
            }
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
            display: function(view) {
                this.centering();

                this.popupEdit = false;

                this.currentView = view;
                this.popupEdit = true;

                //loads popup only if it is disabled
                if (this.popupStatus == 0) {
                    $("#backgroundPopup").css({
                        "opacity": "0.7"
                    });
                    $("#backgroundPopup").fadeIn("slow");
                    $("#popupContact").fadeIn("slow");

                    this.popupStatus = 1;
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

                        $('#modal-content').empty();
                    }
                }
            },
            onKeyUp: function(e) {
                if (e.keyCode == 27 && this.popupStatus == 1) {
                    this.disable();
                }
            }
        }
    }
</script>