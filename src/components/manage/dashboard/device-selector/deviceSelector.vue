<template>
    <div id="device-selector">
        <div style="margin-left: 30px;">
            <a href="#" v-on:click.prevent="onClickInstructions" id="ins_show">Instructions</a>
            <div id="instructions" style="display:none;">
                <strong>Instructions</strong> <a href="#" v-on:click.prevent="onClickHide">hide</a>
                <ol>
                    <li>Evaluate pt for each category using sliding bar</li>
                    <li>Choose the three most important categories (if needed)</li>
                    <li>Click on Sort Devices</li>
                    <li>Click the device to add to Pt chart, or click "Reset" to start over.</li>
                </ol>
            </div>
        </div>

        <h2 style="margin-top:20px;">Device C-Lect for {{ currentPatient.firstname }} {{ currentPatient.lastname }}?</h2>

        <form v-bind:action="legacyUrl + 'device_guide_results.php'" method="post" id="device_form" style="border:solid 2px #cce3fc;padding:0 10px 0 25px; width:24%; margin-left:2%; float:left;">
            <input type="hidden" name="id" :value="$route.query.id" />
            <input type="hidden" name="pid" :value="$route.query.pid" />

            <div
                v-if="deviceGuideSettingOptions.length > 0"
                v-for="deviceGuideSetting in deviceGuideSettingOptions"
                class="setting"
                :id="'setting_' + deviceGuideSetting.id"
                style="padding: 5px 0;"
            >
                <strong style="padding: 5px 0;display:block;">{{ deviceGuideSetting.name }}</strong>
                <template v-if="deviceGuideSetting.setting_type == constants.DSS_DEVICE_SETTING_TYPE_RANGE">
                    <mt-range
                        v-model="deviceGuideSetting.checkedOption"
                        :min="0"
                        :max="deviceGuideSetting.number - 1"
                        class="slider"
                    ></mt-range>
                    <input
                        v-model="deviceGuideSetting.checkedImp"
                        type="checkbox"
                        class="imp_chk"
                        value="1"
                        :name="'setting_imp_' + deviceGuideSetting.id"
                        :id="'setting_imp_' + deviceGuideSetting.id"
                    />
                    <div style="clear:both;"></div>
                    <div
                        class="label"
                        :id="'label_' + deviceGuideSetting.id"
                        style="padding: 5px 0;display: block;"
                    >{{ deviceGuideSetting.labels[deviceGuideSetting.checkedOption] }}</div>
                </template>
                <template v-else>
                    <input
                        v-model="deviceGuideSetting.checked"
                        type="checkbox"
                        :name="'setting' + deviceGuideSetting.id"
                        value="1"
                    />
                </template>
            </div>
        </form>

        <div style="float:left; width: 13%; margin-left:2%;">
            <a
                href="#"
                v-on:click="onDeviceSubmit"
                style="border:1px solid #000; padding: 5px;"
                class="addButton"
            >Sort Devices</a>
        </div>

        <div style="float:left; width:50%;">
            <ul id="results" style="border:solid 2px #a7cefa;">
                <li
                    v-for="deviceResult in deviceGuideResults"
                    :class="{ 'box_go' : deviceResult.imagePath}"
                >
                    <div v-if="deviceResult.imagePath" class='ico'>
                        <img :src="deviceResult.imagePath" />
                    </div>
                    <a href="#" v-on:click.prevent="updateDevice(deviceResult.id, deviceResult.name)">
                        {{ deviceResult.name }} ({{ deviceResult.value }})
                    </a>
                </li>
            </ul>
            <a class="addButton" href="#" v-on:click.prevent="onClickReset">Reset</a>
        </div>
        <div style="clear: both;"></div>
    </div>
</template>

<script src="./deviceSelector.js"></script>

<style src="../../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../assets/css/manage/device_guide.css"></style>
