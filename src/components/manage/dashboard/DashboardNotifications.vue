<template>
    <div>
        <h3>Notifications</h3>
        <template v-for="notification in notifications" v-if="resolveCondition(notification.if)">
            <div class="notsuckertreemenu" v-if="notification.hasOwnProperty('children') && notification.children.length">
                <ul id="notmenu">
                    <li>
                        <notification-link
                            v-bind:link-count="notification.number"
                            v-bind:link-label="notification.label"
                            v-bind:link-url="notification.link"
                            v-bind:count-zero-class="notification.countZero"
                            v-bind:count-non-zero-class="notification.countNonZero"
                            v-bind:has-children="true"
                        ></notification-link>
                        <ul>
                            <li
                                v-for="notificationChild in notification.children"
                                v-if="resolveCondition(notificationChild.if)"
                            >
                                <notification-link
                                    v-bind:link-count="notificationChild.number"
                                    v-bind:link-label="notificationChild.label"
                                    v-bind:link-url="notificationChild.link"
                                    v-bind:count-zero-class="notificationChild.countZero"
                                    v-bind:count-non-zero-class="notificationChild.countNonZero"
                                    v-bind:show-all="showAll"
                                ></notification-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <notification-link
                v-else
                v-bind:link-count="notification.number"
                v-bind:link-label="notification.label"
                v-bind:link-url="notification.link"
                v-bind:count-zero-class="notification.countZero"
                v-bind:count-non-zero-class="notification.countNonZero"
                v-bind:show-all="showAll"
            ></notification-link>
        </template>

        <a href="#" v-show="!showAll" v-on:click.prevent="showAllNotifications()" id="not_show_all">Show All</a>
        <a href="#" v-show="showAll" v-on:click.prevent="showActiveNotifications()" id="not_show_active">Show Active</a>
    </div>
</template>

<script src="./DashboardNotifications.js"></script>

<style src="../../../assets/css/manage/homesuckertreemenu.css" scoped></style>
