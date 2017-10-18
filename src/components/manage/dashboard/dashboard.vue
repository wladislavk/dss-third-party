<template>
    <div>
        <header-component></header-component>
        <table id="dashboard">
            <tr>
                <td valign="top" style="border-right:1px solid #00457c;width:980px;">
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

<script src="./dashboard.js"></script>

<style src="../../../assets/css/manage/index.css" scoped></style>
<style src="../../../assets/css/manage/admin.css" scoped></style>
