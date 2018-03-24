<template>
    <div id="sched_div" class="sched_div" v-bind:class="{'current_step': !hasScheduledAppointment}">
        <div id="next_step_div" class="next_step_div">
            <label>Select Next Appointment</label>
            <select id="next_step" class="next_step">
                <option value="" class="empty-option">SELECT NEXT STEP</option>
                <option
                    v-for="nextStep in nextSteps"
                    v-bind:value="nextStep.id"
                    v-bind:selected="futureAppointment.segmentId"
                >{{ nextStep.name }}</option>
            </select>
        </div>
        <div id="next_step_date_div" class="next_step_div">
            <label>Schedule On/After</label>
            <datepicker
                name="next_step_date"
                id="next_step_date"
                input-class="flow_next_calendar"
                format="MM/dd/yyyy"
                v-model="dateAfterSchedule"
            ></datepicker>
            <span id="next_step_until">{{ futureAppointment.dateUntil }}</span>
        </div>
        <div id="tracker-notes-container" class="tracker-notes-container">
            <label>Notes</label>
            <input id="tracker-notes" class="tracker-notes" type="text" v-bind:value="trackerNotes" />
        </div>
        <div class="clear"></div>
    </div>
</template>

<script src="./TrackerSectionTwo.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/chart/tracker-section-two.scss";
</style>

<style lang="scss">
    @import "../../../assets/css/manage/chart/chart-calendar.scss";
</style>
