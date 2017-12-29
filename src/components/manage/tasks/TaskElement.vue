<template>
    <li
        v-on:mouseenter="onMouseEnterTaskItem()"
        v-on:mouseleave="onMouseLeaveTaskItem()"
        v-bind:class="'task_item task_' + task.id"
    >
        <div class="task_extra" v-bind:id="'task_extra_' + task.id" v-show="isVisible">
            <a href="#" v-on:click.prevent="onClickDeleteTask()" class="task_delete"></a>
            <a href="#" v-on:click.prevent="onClickTaskPopup(task.id)" class="task_edit">Edit</a>
        </div>
        <input
            v-on:click="onClickTaskStatus($event)"
            type="checkbox"
            v-bind:id="'task_checkbox_' + task.id"
            v-bind:class="'task_status' + (isPatient ? '' : ' task_status_general')"
            v-bind:value="task.id"
        />
        <div v-bind:class="'task_content ' + (isPatient ? 'task_content_patient' : 'task_content_general')">
            <span class="task_due_date" v-if="dueDate && task.due_date">{{ task.due_date | moment("MM DD") }} - </span>
            {{ task.task }}
            <span class="task_name" v-if="task.firstname && task.lastname">
                (<a class="task_name_link" v-legacy-href="'manage/add_patient.php?ed=' + task.patientid + '&addtopat=1&pid=' + task.patientid">{{ task.firstname }} {{ task.lastname }}</a>)
            </span>
        </div>
    </li>
</template>

<script src="./TaskElement.js"></script>

<style src="../../../assets/css/manage/tasks/task-element.css" scoped></style>
