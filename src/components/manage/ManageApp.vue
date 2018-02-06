<template>
    <div>
        <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td colspan="2" align="right"></td>
            </tr>
            <tr>
                <td valign="top" height="400">
                    <common-header></common-header>
                    <div id="contentMain" class="content-main">
                        <div class="clear"></div>
                        <router-view></router-view>
                    </div>
                    <common-footer></common-footer>
                </td>
            </tr>
        </table>
        <!-- @todo: re-enable the component after refactoring and testing -->
        <!--<logout-warning></logout-warning>-->
    </div>
</template>

<script src="./ManageApp.js"></script>

<style lang="scss" scoped>
    @import "../../assets/css/manage/app.scss";
</style>
