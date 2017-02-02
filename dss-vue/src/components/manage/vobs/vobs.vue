<style src="../../../../assets/css/manage/admin.css" scoped></style>

<template>
    <div id="vobs">
        <span class="admin_head">Manage Verification of Benefits</span>
        <a
            v-if="routeParameters.viewed == 0"
            v-link="{
                name: $route.name,
                query: {
                    pid     : routeParameters.patientId,
                    sort    : routeParameters.sortColumn,
                    sortdir : routeParameters.sortDirection,
                    viewed  : 1
                }
            }"
            style="float:right; margin-right:10px;" 
            class="addButton"
        >
            Show All
        </a>
        <a
            v-else
            v-link="{
                name: $route.name,
                query: {
                    pid     : routeParameters.patientId,
                    sort    : routeParameters.sortColumn,
                    sortdir : routeParameters.sortDirection,
                    viewed  : 0
                }
            }"
            style="float:right; margin-right:10px;" 
            class="addButton"
        >
            Show Unread
        </a>
        <form name="sortfrm" method="post">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <tr v-if="vobsTotalNumber > vobsPerPage" bgColor="#ffffff">
                    <td align="right" colspan="15" class="bp">
                        Pages:
                        <span v-for="index in totalPages">
                            <strong v-if="routeParameters.currentPageNumber == index">{{ index + 1 }}</strong>
                            <a
                                v-else
                                v-link="{
                                    name: $route.name,
                                    query: {
                                        page    : index,
                                        sort    : routeParameters.sortColumn,
                                        sortdir : routeParameters.sortDirection,
                                        viewed  : routeParameters.viewed
                                    }
                                }"
                                class="fp"
                            >{{ index + 1 }}</a>
                        </span>
                    </td>
                </tr>
                <tr class="tr_bg_h">
                    <td
                        v-for="(sort, label) in tableHeaders"
                        class="col_head  {{ routeParameters.sortColumn == sort || 
                        (routeParameters.sortColumn == 'p.lastname' && sort == 'patient_name') 
                        ? 'arrow_' + routeParameters.sortDirection : '' }}"
                        valign="top"
                        width="10%"
                    >
                        <a
                            v-if="label != 'Comments' || label != 'Action'"
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
                <tr v-if="!vobs.length" class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
                <tr
                    v-else
                    v-for="vob in vobs"
                    class="{{ vob.viewed || vob.status == DSS_PREAUTH_PENDING ? '' : 'unviewed' }}"
                >
                    <td valign="top">
                        {{ vob.front_office_request_date }}
                    </td>
                    <td valign="top">
                        {{ vob.firstname }} {{ vob.lastname }}
                    </td>
                    <td valign="top" class="status_{{ vob.status }}">
                        {{ constants.dssPreauthStatusLabels[vob.status] }}
                    </td>
                    <td valign="top">
                        {{ vob.status == DSS_PREAUTH_REJECTED ? vob.reject.reason : '' }}
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'insurance',
                                query: {
                                    pid: routeParameters.patientId,
                                    vob_id: vob.id
                                }
                            }"
                        >
                            View
                        </a>
                        <br />
                        <a
                            @click="updateVob('viewed', 0, vob.id, vob.patient_id)"
                            v-if="vob.viewed"
                        >
                            Mark Unread
                        </a>
                        <a
                            @click="updateVob('viewed', 1, vob.id, vob.patient_id)"
                            v-else
                        >
                            Mark Read
                        </a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    module.exports = require('./vobs.js');
</script>