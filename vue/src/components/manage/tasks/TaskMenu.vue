<template>
    <div
        id="task_menu"
        class="task_menu task_menu_general"
        v-on:mouseenter="showTaskList = true"
        v-on:mouseleave="showTaskList = false"
    >
        <span id="task_header">My Tasks (<span id="task_count">{{ tasksNumber }}</span>)</span>
        <div v-show="showTaskList" id="task_list" class="task_list_general">
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
                v-bind:has-due-date="true"
                v-bind:is-patient="false"
            ></task-data>
            <br /><br />
            <a v-legacy-href="'manage/manage_tasks.php'" class="button task_view_all">View All</a>
        </div>
    </div>
</template>

<script src="./TaskMenu.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/tasks/task-menu.scss";
</style>
