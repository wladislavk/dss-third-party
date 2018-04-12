<template>
    <span>
        <!-- @todo: after the migration replace "currentDelayReason" with "delayReason" -->
        <select
            class="form-control"
            v-bind:class="reasonData.className"
            v-bind:id="reasonData.className + '_' + elementId"
            v-bind:name="'data[' + elementId + '][' + reasonData.className + ']'"
            v-model="currentReason"
            v-on:change="updateReason($event)"
        >
            <option v-for="reasonType in reasonData.types" v-bind:value="reasonType.value">{{ reasonType.text }}</option>
        </select>
        <a
            href="#"
            v-show="reason === 'other'"
            v-bind:id="'reason_btn' + elementId"
            v-on:click.prevent="openFlowsheetModal()"
        >Show Reason</a>
    </span>
</template>

<script src="./ReasonRow.js"></script>
