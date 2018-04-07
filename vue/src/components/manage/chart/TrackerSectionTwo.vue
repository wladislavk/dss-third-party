<template>
    <div id="sched_div" class="sched_div" v-bind:class="{'current_step': !currentScheduledDate}">
        <div id="next_step_div" class="next_step_div">
            <label>Select Next Appointment</label>
            <select
                id="next_step"
                class="next_step"
                v-model="currentSelectedStep"
                v-on:change="updateNextAppointment($event)"
            >
                <option v-bind:value="0" class="empty-option">SELECT NEXT STEP</option>
                <option v-for="nextStep in nextSteps" v-bind:value="nextStep.id">{{ nextStep.name }}</option>
            </select>
        </div>
        <div id="next_step_date_div" class="next_step_div">
            <label>Schedule On/After</label>
            <div class="datepicker-wrapper">
                <datepicker
                    name="next_step_date"
                    id="next_step_date"
                    input-class="flow_next_calendar"
                    format="MM/dd/yyyy"
                    v-bind:disabled-picker="isDisabled"
                    v-model="currentScheduledDate"
                    v-on:selected="updateScheduledDate($event)"
                ></datepicker>
            </div>
            <span class="next_step_until" id="next_step_until">{{ currentInterval }}</span>
        </div>
        <div id="tracker-notes-container" class="tracker-notes-container">
            <label>Notes</label>
            <input
                id="tracker-notes"
                class="tracker-notes"
                type="text"
                v-bind:value="currentTrackerNote"
                v-on:change="updateTrackerNotes($event)"
            />
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
