<style src="../../../../assets/css/manage/admin.css" scoped></style>

<template>
    <div id="vobs">
        <span class="admin_head">Manage Verification of Benefits</span>
        <form name="sortfrm" method="post">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <!-- <tr v-if="patientsTotalNumber > patientsPerPage" bgColor="#ffffff">
                    <td  align="right" colspan="15" class="bp">
                        Pages:
                        <span v-for="index in totalPages">
                            <strong v-if="routeParameters.currentPageNumber == index">{{ index + 1 }}</strong>
                            <a
                                v-else
                                v-link="{
                                    name: $route.name,
                                    query: {
                                        page    : index,
                                        letter  : routeParameters.currentLetter,
                                        sort    : routeParameters.sortColumn,
                                        sortdir : routeParameters.sortDirection,
                                        sh      : routeParameters.selectedPatientType
                                    }
                                }"
                                class="fp"
                            >{{ index + 1 }}</a>
                        </span>
                    </td>
                </tr> -->
                <tr class="tr_bg_h">
                    <td
                        v-for="(sort, label) in tableHeaders"
                        class="col_head  {{ routeParameters.sortColumn == sort ? 'arrow_' + routeParameters.sortDirection : '' }}"
                        valign="top"
                        width="10%"
                    >
                        <a
                            v-link="{
                                name: $route.name,
                                query: {
                                    sort: sort,
                                    sortdir: getCurrentDirection(sort)
                                }
                            }"
                        >{{ label }}</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    module.exports = require('./vobs.js');
</script>