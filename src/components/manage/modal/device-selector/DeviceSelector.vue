<template>
    <div id="device-selector" class="device-selector">
        <div class="instructions">
            <a
                v-show="!showInstructions"
                v-on:click.prevent="onClickInstructions"
                id="ins_show"
                href="#"
            >Instructions</a>
            <div v-show="showInstructions" id="instructions">
                <strong>Instructions</strong>
                <a v-on:click.prevent="onClickHide" href="#">hide</a>
                <ol>
                    <li v-for="item in instructions">{{ item }}</li>
                </ol>
            </div>
        </div>
        <h2 id="device-selector-title" class="device-selector-title">
          <span>Device C-Lect</span> <span v-if="patientName">for {{ patientName }}?</span></h2>
        <form id="device_form">
            <device-slider
                v-for="deviceGuideSetting in deviceGuideSettingOptions"
                v-bind:id="deviceGuideSetting.id"
                v-bind:name="deviceGuideSetting.name"
                v-bind:labels="deviceGuideSetting.labels"
                v-bind:checked-option="deviceGuideSetting.checkedOption"
                v-bind:key="deviceGuideSetting.id"
            ></device-slider>
        </form>
        <div id="sort-devices-button" class="sort-devices-button">
            <a
                v-on:click.prevent="onDeviceSubmit"
                href="#"
                class="addButton"
            >Sort Devices</a>
        </div>
        <device-results v-bind:patient-name="patientName"></device-results>
        <div style="clear: both;"></div>
    </div>
</template>

<script src="./DeviceSelector.js"></script>

<style src="../../../../assets/css/manage/device-selector/device-selector.css" scoped></style>
