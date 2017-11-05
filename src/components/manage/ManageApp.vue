<template>
    <div>
        <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td colspan="2" align="right"></td>
            </tr>
            <tr>
                <td valign="top" height="400">
                    <!-- @todo: re-enable the component after refactoring and testing -->
                    <!--<header-component></header-component>-->
                    <div id="contentMain">
                        <div style="clear:both;"></div>
                        <!-- @todo: re-enable the component after refactoring and testing -->
                        <!--<patient-data></patient-data>-->
                        <!-- Router content -->
                        <router-view></router-view>
                    </div>
                    <div class="footer-image"></div>
                </td>
            </tr>
          <!-- Stick Footer Section Here -->
        </table>
        <!-- @todo: re-enable the component after refactoring and testing -->
        <!--<logout-warning></logout-warning>-->
    </div>
</template>

<script src="./ManageApp.js"></script>

<style src="../../assets/css/manage/admin.css" scoped></style>
<style src="../../assets/css/manage/notifications.css" scoped></style>
<style src="../../assets/css/manage/search-hints.css" scoped></style>
<style src="../../assets/css/manage/top.css" scoped></style>
<style src="../../assets/css/manage/letter-form.css" scoped></style>
<style src="../../assets/css/manage/form.css" scoped></style>
<style src="../../../node_modules/sweetalert/dist/sweetalert.css" scoped></style>
<style src="../../../node_modules/mint-ui/lib/style.css" scoped></style>
