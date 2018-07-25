<template>
    <li
        v-on:mouseenter="onMouseEnterTaskItem()"
        v-on:mouseleave="onMouseLeaveTaskItem()"
        v-bind:class="'task_item task_' + taskId"
    >
        <div class="task_extra" v-bind:id="'task_extra_' + taskId" v-show="isVisible">
            <a href="#" v-on:click.prevent="onClickDeleteTask()" class="task_delete"></a>
            <a href="#" v-on:click.prevent="onClickTaskPopup()" class="task_edit">Edit</a>
        </div>
        <input
            v-on:click="onClickTaskStatus($event)"
            type="checkbox"
            v-bind:id="'task_checkbox_' + taskId"
            v-bind:class="'task_status' + (isPatient ? '' : ' task_status_general')"
            v-bind:value="taskId"
        />
        <div v-bind:class="'task_content ' + (isPatient ? 'task_content_patient' : 'task_content_general')">
            <span class="task_due_date" v-if="dueDate && hasDueDate">{{ dueDate | moment("MM DD") }} - </span>
            {{ task }}
            <span class="task_name" v-if="firstName && lastName">
                (<a class="task_name_link" v-legacy-href="'manage/add_patient.php?ed=' + patientId + '&addtopat=1&pid=' + patientId">{{ firstName }} {{ lastName }}</a>)
            </span>
        </div>
    </li>
</template>

<script src="./TaskElement.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/tasks/task-element.scss";
</style>
