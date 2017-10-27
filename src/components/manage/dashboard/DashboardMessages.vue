<template>
    <div>
        <h3>Messages</h3>
        <div class="task_menu index_task">
            <ul>
                <li v-for="memo in memos" v-html="memo.memo"></li>
            </ul>
        </div>
    </div>
</template>

<script src="./DashboardMessages.js"></script>

<style src="../../../assets/css/manage/task-menu.css" scoped></style>
