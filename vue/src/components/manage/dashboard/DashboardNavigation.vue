<template>
    <div>
        <h3>Navigation</h3>
        <div class="homesuckertreemenu">
            <ul id="homemenu">
                <navigation-element
                    v-for="menuItem in menu"
                    v-if="resolveCondition(menuItem.shouldParse)"
                    v-bind:menu-item="menuItem"
                    v-bind:key="menuItem.name"
                ></navigation-element>
            </ul>
        </div>
    </div>
</template>

<script src="./DashboardNavigation.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/dashboard/dashboard-navigation.scss";
</style>
