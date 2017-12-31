<template>
    <h2 style="margin-top:20px;">What device will you make for {{ firstName }} {{ lastName }}?</h2>
    <a v-legacy-href="'manage/device_guide.php?pid=' + this.patientId + '&id=' + this.flowId">Help me decide</a>
    <form action="#">
        Device
        <select name="dentaldevice" style="width:250px" v-model="dentalDevice">
            <option value=""></option>
            <option v-for="device in devices" v-bind:value="device.deviceid">{{ device.device }}</option>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="selectDevice()" />
    </form>
</template>

<script src="./ImpressionDevice.js"></script>
