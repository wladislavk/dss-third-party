<template>
    <a
        href="#"
        class="next btn btn_d"
        v-bind:class="resultingClass"
        v-bind:id="resultingId"
        v-on:click.prevent="onSubmit()"
    >{{ linkText }}</a>
</template>

<script src="./ScreenerNavigation.js"></script>

<style lang="scss" scoped>
  @import "../../../assets/css/screener/common/navigation.scss";
</style>
