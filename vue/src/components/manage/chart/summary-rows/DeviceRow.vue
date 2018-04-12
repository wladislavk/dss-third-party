<template>
    <select
        class="dentaldevice form-control"
        v-bind:id="'dentaldevice_' + elementId"
        v-model="defaultDeviceId"
        v-on:change="updateDeviceId($event)"
    >
        <option value=""></option>
        <option v-for="device in devices" v-bind:value="device.id">{{ device.device }}</option>
    </select>
</template>

<script src="./DeviceRow.js"></script>
