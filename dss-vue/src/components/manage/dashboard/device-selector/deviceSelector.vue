<style src="../../../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../../assets/css/manage/device_guide.css" scoped></style>

<template>
    <div style="margin-left: 30px;">
        <a href="#" onclick="$('#instructions').show('200');$(this).hide();return false;" id="ins_show">Instructions</a>
        <div id="instructions" style="display:none;">
            <strong>Instructions</strong> <a href="#" onclick="$('#instructions').hide('200');$('#ins_show').show();">hide</a>
            <ol>
                <li>Evaluate pt for each category using sliding bar</li>
                <li>Choose the three most important categories (if needed)</li>
                <li>Click on Sort Devices</li>
                <li>Click the device to add to Pt chart, or click "Reset" to start over.</li>
            </ol>
        </div>
    </div>

    <h2 style="margin-top:20px;">Device C-Lect for {{ currentPatient.firstname + ' ' + currentPatient.lastname }}?</h2>

    <form action="device_guide_results.php" method="post" id="device_form" style="border:solid 2px #cce3fc;padding:0 10px 0 25px; width:24%; margin-left:2%; float:left;">
        <input type="hidden" name="id" value="{{ $route.query.id }}" />
        <input type="hidden" name="pid" value="{{ $route.query.pid }}" />

        <div
            v-if="deviceGuideSettings.length > 0"
            v-for="deviceGuideSetting in deviceGuideSettings"
            class="setting"
            id="setting_{{ deviceGuideSetting.id }}"
            style="padding: 5px 0;"
        >
            <strong style="padding: 5px 0;display:block;">{{ deviceGuideSetting.name }}</strong>
            <template v-if="deviceGuideSetting.setting_type == constants.DSS_DEVICE_SETTING_TYPE_RANGE">
                <div class="slider" id="slider_{{ deviceGuideSetting.id }}"></div>
                <input type="checkbox" class="imp_chk" value="1" name="setting_imp_{{ deviceGuideSetting.id }}" id="setting_imp_{{ deviceGuideSetting.id }}" />
                <div class="label" id="label_{{ deviceGuideSetting.id }}" style="padding: 5px 0;display: block;"></div>
                <input type="hidden" name="setting{{ deviceGuideSetting.id }}" id="input_opt_{{ deviceGuideSetting.id }}" />
            </template>
            <template v-else>
                <input type="checkbox" name="setting{{ deviceGuideSetting.id }}" value="1" />
            </template>
        </div>
    </form>

    <div style="float:left; width: 13%; margin-left:2%;">
        <a href="#" style="border:1px solid #000; padding: 5px;" class="device_submit addButton">Sort Devices</a>
    </div>

    <div style="float:left; width:50%;">
        <ul id="results" style="border:solid 2px #a7cefa;">
        </ul>
        <a href="#" class="addButton" onclick="reset_form();return false;">Reset</a>
    </div>
</template>

<script>
    module.exports = require('./deviceSelector.js');
</script>