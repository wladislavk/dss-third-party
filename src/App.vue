<template>
  <div id="app">
    <manage-template v-if="$route.matched.some(record => record.meta.requiresManageTemplate)"></manage-template>
    <router-view v-else></router-view>
  </div>
</template>

<script src="./App.js"></script>

<style src="assets/css/manage/main.css"></style>
