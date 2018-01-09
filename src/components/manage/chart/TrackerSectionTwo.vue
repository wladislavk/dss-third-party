<template>
    <div id="sched_div" v-bind:class="{'current_step': !scheduledAppointment}">
        <div id="next_step_div">
            <label>Select Next Appointment</label>
            <select id="next_step" v-model="secondSchedule.segmentid">
                <option value="" class="empty-option">Select Next Step</option>
                <option
                    v-for="nextStep in nextSteps"
                    v-bind:value="nextStep.id"
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
</template>

<script src="./TrackerSectionTwo.js"></script>
