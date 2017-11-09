<template>
    <div id="device-selector">
        <div style="margin-left: 30px;">
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
        <h2 id="device-selector-title">{{ deviceSelectorTitle }}</h2>
        <form
            v-bind:action="legacyUrl + 'device_guide_results.php'"
            method="post"
            id="device_form"
        >
            <!-- TODO: need remove hidden fields when `device_guide_results` is migrated -->
            <input v-bind:value="$route.query.id" type="hidden" name="id">
            <input v-bind:value="$route.query.pid" type="hidden" name="pid">
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
        <div id="sort-devices-button">
            <a
                v-on:click.prevent="onDeviceSubmit"
                href="#"
                class="addButton"
            >Sort Devices</a>
        </div>
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
        <div style="clear: both;"></div>
    </div>
</template>

<script src="./DeviceSelector.js"></script>

<style src="jquery-ui/themes/ui-lightness/jquery-ui.css"></style>
<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/form.css" scoped></style>
<style src="../../../assets/css/manage/device_guide.css" scoped></style>

