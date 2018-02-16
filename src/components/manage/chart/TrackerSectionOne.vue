<template>
    <div id="treatment_list" v-bind:class="{'current_step': hasScheduledAppointment}">
        <div id="arrow_div" v-bind:style="{height: arrowHeight + 'px'}"></div>
        <ul class="treatment sect1">
            <tracker-step v-for="step in stepsFirst"
                v-bind:id="step.id"
                v-bind:name="step.name"
                v-bind:patient-id="patientId"
                v-bind:section="1"
                v-bind:completed="isCompleted(step)"
                v-bind:key="step.id"
            ></tracker-step>
        </ul>
        <ul class="treatment sect2">
            <tracker-step v-for="step in stepsSecond"
                v-bind:id="step.id"
                v-bind:name="step.name"
                v-bind:patient-id="patientId"
                v-bind:section="2"
                v-bind:completed="false"
                v-bind:key="step.id"
            ></tracker-step>
        </ul>
    </div>
</template>

<script src="./TrackerSectionOne.js"></script>
