<template>
    <div>
        <h4 v-if="tasks.length > 0" v-bind:id="(isPatient ? 'pat_' : '') + 'task_' + taskCode + '_header'" v-bind:class="'task_' + taskCode + '_header' + (redHeader ? ' task_header_red' : '')">{{ taskType }}</h4>
        <ul v-if="tasks.length > 0" v-bind:id="(isPatient ? 'pat_' : '') + 'task_' + taskCode + '_list'">
            <task-element
                v-for="task in tasks"
                v-bind:key="task.id"
                v-bind:task="task"
                v-bind:due-date="dueDate"
                v-bind:is-patient="isPatient"
            >
            </task-element>
        </ul>
    </div>
</template>

<script src="./TaskData.js"></script>

<style src="../../../assets/css/manage/tasks/task-data.css" scoped></style>
