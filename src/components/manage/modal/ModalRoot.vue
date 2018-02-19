<template>
    <transition>
        <div id="modal" class="modal" v-show="popupEnabled">
            <div id="popupContact" class="popup-contact" v-bind:style="{'top': topPosition, 'left': leftPosition}">
                <a id="popupContactClose" class="close" v-on:click="disable()"><button>X</button></a>
                <div
                    id="modal-content"
                    v-bind:class="{'modal-content-white': currentProperties.white, 'modal-content': !currentProperties.white}"
                >
                    <component v-bind:is="currentView" v-bind="currentProperties"></component>
                </div>
            </div>
            <div id="backgroundPopup" class="background-popup" v-on:click="disable()"></div>
        </div>
    </transition>
</template>

<script src="./ModalRoot.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/calendar.scss";
</style>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/modal/root.scss";
</style>
