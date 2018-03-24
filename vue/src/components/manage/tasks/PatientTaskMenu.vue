<template>
    <div
        v-on:mouseenter="showTaskList = true"
        v-on:mouseleave="showTaskList = false"
        v-show="tasksNumber"
        class="task_menu task_menu_patient"
        id="pat_task_menu"
    >
        <span
            id="pat_task_header"
            class="task_header_patient"
        >Tasks({{ tasksNumber }})</span>
        <div v-show="showTaskList" class="task_list" id="pat_task_list">
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

<style lang="scss" scoped>
    @import "../../../assets/css/manage/tasks/task-menu.scss";
</style>
