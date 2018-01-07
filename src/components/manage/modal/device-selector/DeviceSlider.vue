<template>
    <div v-bind:id="'setting_' + id" class="setting">
        <strong class="device-guide-setting-name">{{ name }}</strong>
        <div class="slider-wrapper">
            <vue-slider
                ref="slider"
                v-model="checkedOptionData"
                width="80%"
                v-bind:tooltip="false"
                v-bind:lazy="true"
                v-bind:piecewise="true"
                v-bind:data="labels"
                v-on:callback="moveSlider($event)"
            ></vue-slider>
            <input
                type="checkbox"
                v-bind:id="'setting_imp_' + id"
                v-bind:name="'setting_imp_' + id"
                v-bind:checked="checked"
                v-on:change="checkSetting($event)"
                class="imp_chk"
                value="1"
            />
        </div>
        <div
            v-bind:id="'label_' + id"
            class="label"
        >{{ checkedOptionName }}</div>
    </div>
</template>

<script src="./DeviceSlider.js"></script>

<style src="../../../../assets/css/manage/device-selector/device-slider.css" scoped></style>
