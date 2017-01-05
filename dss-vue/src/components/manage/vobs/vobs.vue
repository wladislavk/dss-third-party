<style src="../../../../assets/css/manage/admin.css" scoped></style>

<template>
    <div id="vobs">
        <span class="admin_head">Manage Verification of Benefits</span>
        <a
            v-link="{
                name: $route.name,
                query: {
                    pid: routeParameters.patientId
                }
            }"
        >
            {{ label }}
        </a>
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
                        >
                            {{ label }}
                        </a>
                    </td>
                </tr>
                <tr class="template">
                    <td>2011-06-08 15:13:31</td>
                    <td>TEST LASTNAME</td>
                    <td>Rejected </td>
                    <td>No dob</td>
                    <td>
                        <!-- <a
                            v-link="{
                                path: '/manage/insurance',
                                query: {
                                    pid: routeParameters.patientId,
                                    vob_id: vob.id
                                }
                            }"
                        > -->
                            View
                        <!-- </a> -->
                        <br />
                        <a
                            v-link="{
                                name: $route.name,
                                query: {
                                    pid: routeParameters.patientId,
                                    rid: routeParameters.readId
                                }
                            }"
                            v-if="vob.viewed"
                        >
                            Mark Unread
                        </a>
                        <a
                            v-link="{
                                name: $route.name,
                                query: {
                                    pid: routeParameters.patientId,
                                    urid: routeParameters.unreadId
                                }
                            }"
                            v-else
                        >
                            Mark Read
                        </a>
                    </td>
                </tr>
                <tr v-if="!vobs.length" class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    module.exports = require('./vobs.js');
</script>