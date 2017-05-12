<template>
    <div id="vobs">
        <span class="admin_head">Manage Verification of Benefits</span>
        <router-link
            :to="{
                name: $route.name,
                query: {
                    pid     : routeParameters.patientId,
                    sort    : routeParameters.sortColumn,
                    sortdir : routeParameters.sortDirection,
                    viewed  : routeParameters.viewed == 0 ? null : 0
                }
            }"
            style="float:right; margin-right:10px;" 
            class="addButton"
        >
            {{ routeParameters.viewed == 0 ? 'Show All' : 'Show Unread' }}
        </router-link>
        <br /><br /><br />
        <div align="center" class="red">
            <b>{{ message }}</b>
        </div>
        <form name="sortfrm" method="post">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <tr v-if="totalVobs > vobsPerPage" bgColor="#ffffff">
                    <td align="right" colspan="15" class="bp">
                        Pages:
                        <span v-for="index in totalPages" class="page_numbers">
                            <strong v-if="routeParameters.currentPageNumber == (index - 1)">{{ index }}</strong>
                            <router-link
                                v-else
                                :to="{
                                    name: $route.name,
                                    query: {
                                        page    : index - 1,
                                        sort    : routeParameters.sortColumn,
                                        sortdir : routeParameters.sortDirection,
                                        viewed  : routeParameters.viewed
                                    }
                                }"
                                class="fp"
                            >{{ index }}</router-link>
                        </span>
                    </td>
                </tr>
                <tr class="tr_bg_h">
                    <td
                        v-for="(label, sort) in tableHeaders"
                        :class="'col_head ' + (routeParameters.sortColumn == sort ? 'arrow_' + routeParameters.sortDirection : '')"
                        valign="top"
                        :width="sort == 'comments' ? '40%' : '15%'"
                    >
                        <router-link
                            v-if="sort != 'comments' && sort != 'action'"
                            :to="{
                                name: $route.name,
                                query: {
                                    sort: sort,
                                    sortdir: getCurrentDirection(sort)
                                }
                            }"
                        >
                            {{ label }}
                        </router-link>
                        <template v-else>{{ label }}</template>
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
                    :class="{ unviewed: !(vob.viewed == 1 || vob.status == constants.DSS_PREAUTH_PENDING) }"
                >
                    <td valign="top">
                        {{ vob.front_office_request_date }}
                    </td>
                    <td valign="top">
                        {{ vob.firstname }} {{ vob.lastname }}
                    </td>
                    <td valign="top" :class="'status_' + vob.status">
                        {{ constants.dssPreauthStatusLabels[vob.status] }}
                    </td>
                    <td valign="top">
                        {{ vob.status == constants.DSS_PREAUTH_REJECTED ? vob.reject_reason : '' }}
                    </td>
                    <td valign="top">
                        <router-link
                            :to="{
                                path: '/manage/insurance',
                                query: {
                                    pid    : routeParameters.patientId,
                                    vob_id : vob.id
                                }
                            }"
                            class="editlink"
                            title="EDIT"
                        >
                            View
                        </router-link>
                        <br />
                        <a
                            href="#"
                            v-on:click.prevent="setViewStatus(vob)"
                            class="editlink"
                            title="EDIT"
                        >
                            {{ vob.viewed == 1 ? 'Mark Unread' : 'Mark Read' }}
                        </a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./vobs.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/manage.css" scoped></style>
