<template>
    <select
        class="dentaldevice form-control"
        v-bind:id="'dentaldevice_' + elementId"
        v-model="currentDeviceId"
        v-on:change="updateDeviceId($event)"
    >
        <option value=""></option>
        <option v-for="device in devices" v-bind:value="device.id">{{ device.device }}</option>
    </select>
</template>

<script src="./DeviceRow.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/chart/summary-rows/device-row.scss";
</style>
