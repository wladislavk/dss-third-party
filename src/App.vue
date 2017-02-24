<template>
  <div id="app">
    <manage-template v-if="$route.meta.auth"></manage-template>
    <router-view v-else></router-view>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>
