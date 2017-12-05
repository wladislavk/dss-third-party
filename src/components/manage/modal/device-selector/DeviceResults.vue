<template>
    <div id="device-results-div">
        <ul>
            <li
                v-for="deviceResult in deviceGuideResults"
                v-bind:class="{ 'box_go': deviceResult.imagePath }"
            >
                <div v-if="deviceResult.imagePath" class='ico'>
                    <img v-bind:src="deviceResult.imagePath" />
                </div>
                <a
                    v-on:click.prevent="updateDevice(deviceResult.id, deviceResult.name)"
                    href="#"
                >
                    {{ deviceResult.name }} ({{ deviceResult.value }})
                </a>
            </li>
        </ul>
        <a v-on:click.prevent="onClickReset" class="addButton" href="#">Reset</a>
    </div>
</template>

<script src="./DeviceResults.js"></script>

<style src="assets/css/manage/admin.css" scoped></style>
<style src="assets/css/manage/device-selector/device-results.css"></style>
