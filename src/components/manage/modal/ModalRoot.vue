<template>
    <transition>
        <div id="modal" class="modal" v-show="popupEnabled">
            <div id="popupContact" v-bind:style="{ top: topPosition, left: leftPosition }">
                <a id="popupContactClose" v-on:click="disable()"><button>X</button></a>
                <div id="modal-content">
                    <component v-bind:is="currentView"></component>
                </div>
            </div>
            <div id="backgroundPopup" v-on:click="disable()"></div>
        </div>
    </transition>
</template>

<script src="./ModalRoot.js"></script>

<style src="../../assets/css/manage/popup.css" scoped></style>
