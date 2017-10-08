<template>
    <div id="index_task_list" class="task_menu index_task">
        <h4>My Tasks</h4>
        <task-data
            v-bind:tasks="overdueTasks"
            task-code="od"
            task-type="Overdue"
            v-bind:red-header="true"
            v-bind:is-patient="false"
        ></task-data>
        <task-data
            v-bind:tasks="todayTasks"
            task-code="tod"
            task-type="Today"
            v-bind:is-patient="false"
        ></task-data>
        <task-data
            v-bind:tasks="tomorrowTasks"
            task-code="tom"
            task-type="Tomorrow"
            v-bind:is-patient="false"
        ></task-data>
        <task-data
            v-bind:tasks="thisWeekTasks"
            task-code="tw"
            task-type="This Week"
            v-bind:is-patient="false"
        ></task-data>
        <task-data
            v-bind:tasks="nextWeekTasks"
            task-code="nw"
            task-type="Next Week"
            v-bind:is-patient="false"
        ></task-data>
        <task-data
            v-bind:tasks="laterTasks"
            task-code="lat"
            task-type="Later"
            v-bind:due-date="true"
            v-bind:is-patient="false"
        ></task-data>

        <br /><br />

        <a v-bind:href="legacyUrl + 'manage_tasks.php'" class="button task_view_all">View All</a>
    </div>
</template>

<script src="./TaskMenu.js"></script>

<style src="../../assets/css/manage/task-menu.css" scoped></style>
