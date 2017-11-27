<script src="/manage/3rdParty/JSCal/src/js/jscal2.js"></script>
<script src="/manage/3rdParty/JSCal/src/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/manage/3rdParty/JSCal/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/manage/3rdParty/JSCal/src/css/border-radius.css" />
<script type="text/javascript" src="/manage/js/calendar.js?v=<?= time() ?>"></script>
<?php
if(!empty($_POST["taskadd"]) && $_POST["taskadd"] == 1){
  $msg = "Task Added!";
} ?>
<template>
    <form name="notesfrm" method="post">
        <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr>
                <td class="cat_head">Add new task</td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label for="task">Task</label>
                    <span class="red">*</span>
                    <input class="wide-input" type="text" name="task" id="task" />
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label for="due_date">Due Date</label>
                    <span class="red">*</span>
                    <input type="text" name="due_date" id="due_date" class="calendar" value="date('m/d/Y')" />
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label for="responsibleid">Assigned To:</label>
                    <span class="red">*</span>
                    <select name="responsibleid" id="responsibleid" v-model="responsible">
                        <option v-for="user in userList" v-bind:value="user.id">{{ user.fullName }}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <label for="status">Completed:</label>
                    <input type="checkbox" value="1" name="status" id="status" v-model="status" />
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <input type="submit" class="add-button" value="Add Task" v-on:click.prevent="onSubmit()" />
                </td>
            </tr>
        </table>
    </form>
</template>

<script src="./AddTask.js"></script>

<style src="../../../assets/css/manage/tasks/add-task.css" scoped></style>
