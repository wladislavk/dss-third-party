<template>
    <div>
        <table id="dashboard">
            <tr>
                <td valign="top" class="main_cell">
                    <div class="home_third first">
                        <dashboard-navigation></dashboard-navigation>
                    </div>
                    <div class="home_third">
                        <dashboard-notifications></dashboard-notifications>
                    </div>
                    <div class="home_third">
                        <h3>Tasks</h3>
                        <dashboard-task-menu></dashboard-task-menu>
                        <br /><br />
                        <dashboard-messages></dashboard-messages>
                    </div>
                </td>
            </tr>
        </table>

        <br /><br />
    </div>
</template>

<script src="./DashboardRoot.js"></script>

<style src="../../../assets/css/manage/dashboard/dashboard-root.css" scoped></style>
