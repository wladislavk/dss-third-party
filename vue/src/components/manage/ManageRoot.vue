<template>
    <div v-on:click="hideSearchHints()">
        <modal-root></modal-root>
        <router-view></router-view>
    </div>
</template>

<script src="./ManageRoot.js"></script>

<style src="../../assets/css/manage/main.css"></style>
