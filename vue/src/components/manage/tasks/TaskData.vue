<template>
    <div>
        <h4 v-if="tasks.length > 0" v-bind:id="(isPatient ? 'pat_' : '') + 'task_' + taskCode + '_header'" v-bind:class="'task_' + taskCode + '_header' + (redHeader ? ' task_header_red' : '')">{{ taskType }}</h4>
        <ul v-if="tasks.length > 0" v-bind:id="(isPatient ? 'pat_' : '') + 'task_' + taskCode + '_list'">
            <task-element
                v-for="task in tasks"
                v-bind:key="task.id"
                v-bind:task-id="task.id"
                v-bind:task="task.task"
                v-bind:due-date="getDueDate(task.due_date)"
                v-bind:has-due-date="hasDueDate"
                v-bind:first-name="task.firstname"
                v-bind:last-name="task.lastname"
                v-bind:patient-id="task.patientid"
                v-bind:is-patient="isPatient"
            ></task-element>
        </ul>
    </div>
</template>

<script src="./TaskData.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/tasks/task-data.scss";
</style>
