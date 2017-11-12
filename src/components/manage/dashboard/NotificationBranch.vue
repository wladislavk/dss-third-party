<template>
    <div class="notsuckertreemenu">
        <ul id="notmenu">
            <li v-on:mouseover="showChildren()" v-on:mouseout="hideChildren()">
                <notification-link
                    v-bind:link-count="notification.number"
                    v-bind:link-label="notification.label"
                    v-bind:link-url="notification.link"
                    v-bind:count-zero-class="notification.countZero"
                    v-bind:count-non-zero-class="notification.countNonZero"
                    v-bind:has-children="true"
                    v-bind:key="notification.label"
                ></notification-link>
                <ul v-visible="childrenShown">
                    <li
                        v-for="notificationChild in notification.children"
                        v-if="resolveCondition(notificationChild.shouldParse)"
                    >
                        <notification-link
                            v-bind:link-count="notificationChild.number"
                            v-bind:link-label="notificationChild.label"
                            v-bind:link-url="notificationChild.link"
                            v-bind:count-zero-class="notificationChild.countZero"
                            v-bind:count-non-zero-class="notificationChild.countNonZero"
                            v-bind:show-all="showAll"
                            v-bind:key="notificationChild.label"
                        ></notification-link>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script src="./NotificationBranch.js"></script>

<style src="../../../assets/css/manage/dashboard/notification-branch.css" scoped></style>
