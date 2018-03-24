<template>
    <form name="notesfrm" method="post">
        <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr>
                <td class="cat_head">
                    <span>Add new task</span>
                    <span v-if="currentTask.patientName">({{ currentTask.patientName }})</span>
                </td>
            </tr>
            <tr id="validation-error" v-show="validationError">
                <td valign="top" class="frmhead">
                    <span class="red">{{ validationError }}</span>
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label for="task">Task</label>
                    <span class="red">*</span>
                    <input
                        class="wide-input"
                        type="text"
                        name="task"
                        id="task"
                        v-model="currentTask.task"
                        v-on:change="currentTask.task=$event.target.value"
                    />
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label>Due Date</label>
                    <span class="red">*</span>
                    <datepicker
                        name="due_date"
                        id="due_date"
                        input-class="calendar"
                        wrapper-class="calendar-wrapper"
                        format="MM/dd/yyyy"
                        v-model="currentTask.dueDate"
                    ></datepicker>
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label for="responsibleid">Assigned To:</label>
                    <span class="red">*</span>
                    <select name="responsibleid" id="responsibleid" v-model="currentTask.responsible">
                        <option v-for="user in userList" v-bind:value="user.id">{{ user.fullName }}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label for="status">Completed:</label>
                    <input type="checkbox" value="1" name="status" id="status" v-model="currentTask.status" />
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <a
                        href="#"
                        v-if="currentTask.id"
                        class="delete-task"
                        v-on:click.prevent="onDelete()"
                    >Delete</a>
                    <input type="submit" class="addButton" value="Add Task" v-on:click.prevent="onSubmit()" />
                </td>
            </tr>
        </table>
    </form>
</template>

<script src="./AddTask.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/modal/add-task.scss";
</style>
