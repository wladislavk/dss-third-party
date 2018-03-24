<template>
    <div id="device-selector" class="device-selector">
        <div class="instructions">
            <a
                v-show="!showInstructions"
                v-on:click.prevent="showInstructions = true"
                id="ins_show"
                href="#"
            >Instructions</a>
            <div v-show="showInstructions" id="instructions">
                <strong>Instructions</strong>
                <a v-on:click.prevent="showInstructions = false" href="#">hide</a>
                <ol>
                    <li>Evaluate pt for each category using sliding bar</li>
                    <li>Choose the three most important categories (if needed)</li>
                    <li>Click on Sort Devices</li>
                    <li>Click the device to add to Pt chart, or click "Reset" to start over.</li>
                </ol>
            </div>
        </div>
        <h2 id="device-selector-title" class="device-selector-title">
            <span>Device C-Lect</span><span v-if="patientName"> for {{ patientName }}?</span>
        </h2>
        <form id="device_form">
            <device-slider
                v-for="deviceGuideSetting in deviceGuideSettingOptions"
                v-bind:id="deviceGuideSetting.id"
                v-bind:name="deviceGuideSetting.name"
                v-bind:labels="deviceGuideSetting.labels"
                v-bind:checked="deviceGuideSetting.checked"
                v-bind:checked-option="deviceGuideSetting.checkedOption"
                v-bind:key="deviceGuideSetting.id"
            ></device-slider>
        </form>
        <device-results v-bind:patient-name="patientName"></device-results>
        <div style="clear: both;"></div>
    </div>
</template>

<script src="./DeviceSelector.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/modal/device-selector/device-selector-main.scss";
</style>
