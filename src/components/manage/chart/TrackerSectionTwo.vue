<template>
    <div id="sched_div" v-bind:class="{'current_step': !scheduledAppointment}">
        <div id="next_step_div">
            <label>Select Next Appointment</label>
            <select id="next_step" v-model="schedule.segmentid">
                <option value="" class="empty-option">Select Next Step</option>
                <option
                    v-for="nextStep in nextSteps"
                    v-bind:value="nextStep.id"
                >{{ nextStep.name }}</option>
            </select>
        </div>
        <div id="next_step_date_div">
            <label>Schedule On/After</label>
            <datepicker
                name="next_step_date"
                id="next_step_date"
                input-class="flow_next_calendar"
                format="MM/dd/yyyy"
                v-model="dateAfterSchedule"
            ></datepicker>
            <span id="next_step_until">{{ schedule.date_until }}</span>
        </div>
        <div id="tracker-notes-container">
            <label>Notes</label>
            <input id="tracker-notes" type="text" v-bind:value="trackerNotes" />
        </div>
        <div class="clear"></div>
    </div>
</template>

<script src="./TrackerSectionTwo.js"></script>

<style lang="scss" scoped>
  @import "../../../assets/css/manage/chart/tracker-section-two.scss";
</style>
