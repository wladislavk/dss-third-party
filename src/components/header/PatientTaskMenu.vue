<template>
    <div
        v-on:mouseleave="onMouseLeavePatientTaskMenu"
        v-if="$route.query.pid && headerInfo.patientTaskNumber > 0"
        class="task_menu task_menu_patient"
        id="pat_task_menu"
    >
        <span
            v-on:mouseover="onMouseOverPatientTaskHeader"
            id="pat_task_header"
            class="task_header_patient"
        >Tasks({{ headerInfo.patientTaskNumber }})</span>
        <div class="task_list" id="pat_task_list">
            <task-data
                v-bind:tasks="overdueTasks"
                task-code="od"
                task-type="Overdue"
                v-bind:red-header="true"
                v-bind:is-patient="true"
            ></task-data>
            <task-data
                v-bind:tasks="todayTasks"
                task-code="tod"
                task-type="Today"
                v-bind:is-patient="true"
            ></task-data>
            <task-data
                v-bind:tasks="tomorrowTasks"
                task-code="tom"
                task-type="Tomorrow"
                v-bind:is-patient="true"
            ></task-data>
            <task-data
                v-bind:tasks="futureTasks"
                task-code="fut"
                task-type="Future"
                v-bind:is-patient="true"
            ></task-data>
        </div>
    </div>
</template>

<script src="./PatientTaskMenu.js"></script>

<style src="../../assets/css/manage/task.css" scoped></style>
