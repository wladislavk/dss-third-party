<template>
    <a
        v-show="showAll || linkNumber"
        v-bind:href="hasChildren ? '#' : (legacyUrl + linkUrl)"
        v-bind:class="'notification count_' + linkNumber + ' ' + (linkNumber === 0 ? countZeroClass : countNonZeroClass)"
    >
        <span class="count">{{ linkNumber }}</span>
        <span class="label">{{ linkLabel }}</span>
        <div class="arrow_right" v-if="hasChildren"></div>
    </a>
</template>

<script src="./NotificationLink.js"></script>

<style src="../../../assets/css/manage/dashboard/notification-link.css" scoped></style>
