<template>
    <form action="#">
        <h2>What device will you make for {{ patientName }}?</h2>
        <a v-legacy-href="'manage/device_guide.php?pid=' + this.patientId + '&id=' + this.flowId">Help me decide</a>
        Device
        <select name="dentaldevice" v-on:change="setDevice($event)">
            <option value=""></option>
            <option v-for="device in devices" v-bind:value="device.id">{{ device.device }}</option>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="selectDevice()" />
    </form>
</template>

<script src="./ImpressionDevice.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/modal/impression-device.scss";
</style>
