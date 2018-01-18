<template>
    <div>
        <div id="sort-devices-button" class="sort-devices-button">
            <a
                v-on:click.prevent="onDeviceSubmit()"
                href="#"
                class="addButton"
            >Sort Devices</a>
        </div>
        <div id="device-results-div" class="device-results-div">
            <ul id="results">
                <li
                    v-for="deviceResult in deviceGuideResults"
                    v-bind:class="{ 'box_go': deviceResult.image_path }"
                >
                    <div v-if="deviceResult.image_path" class="ico"><img v-bind:src="getLogo(deviceResult.image_path)" /></div>
                    <a
                        v-if="patientName"
                        v-on:click.prevent="updateDevice(deviceResult.id, deviceResult.name)"
                        href="#"
                    >{{ deviceResult.name }} ({{ deviceResult.value }})</a>
                    <span v-else>{{ deviceResult.name }} ({{ deviceResult.value }})</span>
                </li>
            </ul>
            <a v-on:click.prevent="onClickReset()" class="addButton" id="reset-link" href="#">Reset</a>
        </div>
    </div>
</template>

<script src="./DeviceResults.js"></script>

<style src="../../../../assets/css/manage/device-selector/device-results.css" scoped></style>
