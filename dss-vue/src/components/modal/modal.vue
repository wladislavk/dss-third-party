<style>
    #modal-content {
        width  : 100%;
        height : 100%;
    }
</style>

<template>
    <div id="modal" class="modal">
        <div id="popupContact" style="width:750px;">
            <a id="popupContactClose"><button>X</button></a>

            <div id="modal-content"></div>
        </div>

        <div id="backgroundPopup"></div>
    </div>
</template>

<script>
    //SETTING UP OUR POPUP
    //0 means disabled; 1 means enabled;
    var popupStatus = 0;
    var popupEdit = false;
    var close = false;

    (function centerPopup(){
        //request data for centering
        var windowWidth  = document.documentElement.clientWidth;
        var windowHeight = document.documentElement.clientHeight;
        var popupHeight  = $("#popupContact").height();
        var popupWidth   = $("#popupContact").width();
        var topPos       = (windowHeight / 2-popupHeight / 2 + window.pageYOffset) + "px";
        var leftPos      = windowWidth / 2-popupWidth / 2;
        if (leftPos < 0) {
            leftPos = 10;
        }
        //centering
        $("#popupContact").css({
            "position": "absolute",
            "top": topPos,
            "left": leftPos 
        });
        //only need force for IE6
        $("#backgroundPopup").css({
            "height": windowHeight
        });
    })();

    function loadPopup(){
        popupEdit = false;

        $('#modal-content').append('<h1>Test</h1>');
        popupEdit = true;

        //loads popup only if it is disabled
        if(popupStatus == 0){
            $("#backgroundPopup").css({
                "opacity": "0.7"
            });
            $("#backgroundPopup").fadeIn("slow");
            $("#popupContact").fadeIn("slow");
            popupStatus = 1;
        }
    }

    loadPopup();
</script>