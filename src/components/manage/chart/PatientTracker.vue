<template>
    <div class="tracker-div">
        <template v-if="isHstCompany">
            <a
                href="#"
                class="button"
                v-on:click.prevent="orderHst()"
                v-if="uncompletedHsts"
            >Order HST</a>
            <a
                href="#"
                class="button"
                v-on:click.prevent="requestHst()"
                v-else
            >Request HST</a>
        </template>
        <a
            v-legacy-href="'calendar_pat.php?pid=' + patientId"
            class="button"
        >View Calendar Appts</a>
    </div>
    <div id="treatment_div">
        <h3>1) What did you do today?*</h3>
        <div id="treatment_list" v-bind:class="{'current_step': scheduledAppointment}">
            <div id="arrow_div" v-bind:style="{height: arrowHeight}"></div>
            <ul class="treatment sect1">
                <li v-for="step in stepsFirst" v-bind:class="getFirstStepClass(step)">
                    <a v-if="step.id === 1" v-bind:id="'completed_' + step.id" class="completed_today">{{ step.name }}</a>
                    <span v-else>{{ step.name }}</span>
                </li>
            </ul>
            <ul class="treatment sect2">
                <li v-for="step in stepsSecond" v-bind:class="getSecondStepClass(step)">
                    <a v-bind:id="'completed_' + step.id" class="completed_today">{{ step.name }}</a>
                </li>
            </ul>
        </div>
        <span class="sub_text">*Click a treatment above to add it to the Treatment Summary</span>
    </div>
    <div id="step2">
        <h3>2) What will you do next?*</h3>
        <div id="sched_div" v-bind:class="{'current_step': !scheduledAppointment}">
            <div id="next_step_div">
                <label>Select Next Appointment</label>
                <select id="next_step">
                    <option value="" class="empty-option">Select Next Step</option>
                    <option
                        v-for="nextStep in nextSteps"
                        v-bind:value="nextStep.id"
                        v-model="secondSchedule.segmentid"
                    >{{ nextStep.name }}</option>
                </select>
            </div>
            <div id="next_step_date_div">
                <label>Schedule On/After</label>
                <input
                    id="next_step_date"
                    class="flow_next_calendar"
                    type="text"
                    v-bind:value="dateAfterSchedule"
                />
                <span id="next_step_until">{{ secondSchedule.date_until }}</span>
            </div>
            <div id="tracker-notes-container">
                <label>Notes</label>
                <input id="tracker-notes" type="text" v-bind:value="trackerNotes" />
            </div>
            <div class="clear"></div>
        </div>
        <span class="sub_text">*After Step 1, choose the next patient treatment and date</span>
        <h3>Treatment Summary</h3>
        <div id="appt_summ" class="appt_summ">
            <appointment-summary v-bind:patient-id="patientId"></appointment-summary>
        </div>
    </div>
    <div style="clear:both;"></div>
</template>

<script src="./PatientTracker.js"></script>

<style src="../../../assets/css/manage/patient-tracker.css" scoped></style>
