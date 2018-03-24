<template>
    <div class="main-template" v-on:click="hideSearchHints()">
        <modal-root></modal-root>
        <router-view></router-view>
    </div>
</template>

<script src="./ManageRoot.js"></script>

<style lang="scss" scoped>
    @import "../../assets/css/manage/main.scss";
</style>
