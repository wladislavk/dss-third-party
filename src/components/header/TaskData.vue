<template>
    <div>
        <h4 v-if="tasks.length > 0" v-bind:id="(isPatient ? 'pat_' : '') + 'task_' + taskCode + '_header'" v-bind:class="'task_' + taskCode + '_header' + (redHeader ? ' task_header_red' : '')">{{ taskType }}</h4>
        <ul v-if="tasks.length > 0" v-bind:id="(isPatient ? 'pat_' : '') + 'task_' + taskCode + '_list'">
            <li
                v-on:mouseenter="onMouseEnterTaskItem"
                v-on:mouseleave="onMouseLeaveTaskItem"
                v-for="task in tasks"
                v-bind:class="'task_item task_' + task.id"
            >
                <div class="task_extra" v-bind:id="'task_extra_' + task.id" >
                    <a href="#" v-on:click="onClickDeleteTask(task.id, $event)" class="task_delete"></a>
                    <a href="#" v-bind:replace-onlick="'loadPopup ' + legacyUrl + 'add_task.php?id=' + task.id" class="task_edit">Edit</a>
                </div>
                <input
                    v-on:click="onClickTaskStatus"
                    type="checkbox"
                    v-bind:class="'task_status' + (isPatient ? '' : ' task_status_general')"
                    v-bind:value="task.id"
                />
                <div v-bind:class="isPatient ? 'task_content_patient' : 'task_content_general'">
                    <span v-if="dueDate">{{ task.due_date | moment("MM DD") }} - </span>
                    {{ task.task }}
                    <span v-if="task.firstname && task.lastname">
                        <span v-if="!isPatient">(</span><a v-bind:href="legacyUrl + 'add_patient.php?ed=' + task.patientid + '&addtopat=1&pid=' + task.patientid">{{ task.firstname }} {{ task.lastname }}</a><span v-if="!isPatient">)</span>
                    </span>
                </div>
            </li>
        </ul>
    </div>
</template>

<script src="./TaskData.js"></script>

<style src="../../assets/css/manage/task-data.css" scoped></style>
