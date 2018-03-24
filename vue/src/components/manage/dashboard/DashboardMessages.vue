<template>
    <div>
        <h3>Messages</h3>
        <div class="task_menu index_task">
            <ul>
                <li v-for="memo in memos" v-html="memo.memo" v-bind:key="memo.id"></li>
            </ul>
        </div>
    </div>
</template>

<script src="./DashboardMessages.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/tasks/task-menu.scss";
</style>
