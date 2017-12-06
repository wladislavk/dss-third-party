<template>
    <div id="device-selector">
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
        <h2 id="device-selector-title">{{ `Device C-Lect for ${patientName}?` }}</h2>
        <device-form></device-form>
        <div id="sort-devices-button">
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

<style src="jquery-ui/themes/ui-lightness/jquery-ui.css"></style>
<style src="assets/css/manage/admin.css" scoped></style>
<style src="assets/css/manage/form.css" scoped></style>
<style src="assets/css/manage/device-selector/device-guide.css" scoped></style>

