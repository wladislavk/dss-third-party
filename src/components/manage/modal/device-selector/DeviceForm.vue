<template>
    <form id="device_form">
        <div
            v-for="deviceGuideSetting in deviceGuideSettingOptions"
            v-bind:id="'setting_' + deviceGuideSetting.id"
            class="setting"
        >
            <strong class="device-guide-setting-name">{{ deviceGuideSetting.name }}</strong>
            <template v-if="isSettingTypeRange(deviceGuideSetting.setting_type)">
                <div v-bind:id="getSliderDivId(deviceGuideSetting.id)" class="slider"></div>
                <input
                    v-bind:id="'setting_imp_' + deviceGuideSetting.id"
                    v-bind:name="'setting_imp_' + deviceGuideSetting.id"
                    v-bind:checked="deviceGuideSetting.checkedImp == 1"
                    v-on:change="updateGuideSettingStatus($event, deviceGuideSetting.id)"
                    type="checkbox"
                    class="imp_chk"
                    value="1"
                />
                <div
                    v-bind:id="'label_' + deviceGuideSetting.id"
                    class="label"
                >{{ deviceGuideSetting.labels[deviceGuideSetting.checkedOption] }}</div>
            </template>
            <template v-else>
                <input
                    v-bind:name="'setting' + deviceGuideSetting.id"
                    v-model="deviceGuideSetting.checked"
                    type="checkbox"
                    value="1"
                />
            </template>
        </div>
    </form>
</template>

<script src="./DeviceForm.js"></script>

<style src="assets/css/manage/device-selector/device-form.css" scoped></style>
