<template>
    <div id="modal" class="modal">
        <div id="popupContact" v-bind:style="{ top: topPosition, left: leftPosition }">
            <a id="popupContactClose" v-on:click="disable()"><button>X</button></a>

            <div id="modal-content">
                <component :is="currentView"></component>
            </div>
        </div>

        <div id="backgroundPopup" v-on:click="disable()"></div>
    </div>
</template>

<script src="./modal.js"></script>

<style src="../../assets/css/manage/popup.css" scoped></style>
