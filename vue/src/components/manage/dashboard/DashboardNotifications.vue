<template>
    <div>
        <h3>Notifications</h3>
        <template v-for="notification in notifications" v-if="resolveCondition(notification.shouldParse)">
            <notification-branch
                v-if="notification.hasOwnProperty('children') && notification.children.length"
                v-bind:notification="notification"
                v-bind:show-all="showAll"
            ></notification-branch>
            <notification-link
                v-else
                v-bind:link-count="notification.number"
                v-bind:link-label="notification.label"
                v-bind:link-url="notification.link"
                v-bind:count-zero-class="notification.countZero"
                v-bind:count-non-zero-class="notification.countNonZero"
                v-bind:show-all="showAll"
                v-bind:key="notification.label"
            ></notification-link>
        </template>
        <a href="#" v-show="!showAll" v-on:click.prevent="showAllNotifications()" id="not_show_all">Show All</a>
        <a href="#" v-show="showAll" v-on:click.prevent="showActiveNotifications()" id="not_show_active">Show Active</a>
    </div>
</template>

<script src="./DashboardNotifications.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/dashboard/dashboard-notifications.scss";
</style>
