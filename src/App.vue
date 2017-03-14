<template>
  <div id="app">
    <manage-template v-if="$route.matched.some(record => record.meta.requiresManageTemplate)"></manage-template>
    <router-view v-else></router-view>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>
