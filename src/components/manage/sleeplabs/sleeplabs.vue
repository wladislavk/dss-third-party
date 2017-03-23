<template>
    <div>
        <span class="admin_head">
            Manage Sleep Lab
        </span>
        <br /><br />
        <div align="right">
            <button v-on:click="loadPopup('add_sleeplab.php')" class="addButton">
                Add New Sleep Lab
            </button>
        </div>
        <div class="letter_select">
            <router-link
                v-for="letter in letters"
                :class="'letters ' + (letter == routeParameters.currentLetter ? 'selected_letter' : '')"
                :to="{
                    name: $route.name,
                    query: {
                        letter: letter,
                        sort: routeParameters.sortColumn,
                        sortdir: routeParameters.sortDirection
                    }
                }"
            >{{ letter }}</router-link>
        </div>
        <br />
        <div v-if="message" align="center" class="red">
            <b>{{ message }}</b>
        </div>
        <form name="sortfrm">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <tr v-if="sleeplabsTotalNumber > sleeplabsPerPage" bgColor="#ffffff">
                    <td  align="right" colspan="15" class="bp">
                        Pages:
                        <span v-for="index in totalPages" class="page_numbers">
                            <strong v-if="routeParameters.currentPageNumber == (index - 1)">{{ index }}</strong>
                            <router-link
                                v-else
                                :to="{
                                    name: $route.name,
                                    query: {
                                        page    : index - 1,
                                        letter  : routeParameters.currentLetter,
                                        sort    : routeParameters.sortColumn,
                                        sortdir : routeParameters.sortDirection,
                                    }
                                }"
                                class="fp"
                            >{{ index }}</router-link>
                        </span>
                    </td>
                </tr>
                <tr class="tr_bg_h">
                    <td
                        v-for="(settings, sort) in tableHeaders"
                        :class="'col_head ' + (routeParameters.sortColumn == sort ? 'arrow_' + routeParameters.sortDirection : '')"
                        valign="top"
                        :width="settings.width + '%'"
                    >
                        <router-link
                            v-if="settings.with_link"
                            :to="{
                                name: $route.name,
                                query: {
                                    sort: sort,
                                    sortdir: getCurrentDirection(sort)
                                }
                            }"
                        >{{ settings.title }}</router-link>
                        <template v-else>{{ settings.title }}</template>
                    </td>
                </tr>
                <tr v-if="sleeplabs.length == 0" class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
                <template v-else v-for="sleeplab in sleeplabs">
                    <tr :class="sleeplab.status == 1 ? 'tr_active' : 'tr_inactive'">
                        <td valign="top">
                            {{ sleeplab.company }}
                        </td>
                        <td valign="top">
                            {{ sleeplab.name }}
                        </td>
                        <td valign="top">
                            <a
                                href="#"
                                onclick="$('#pat_<?php echo $myarray["sleeplabid"];?>').toggle();return false;"
                            >{{ sleeplab.pat_num }}</a>
                        </td>
                        <td valign="top">
                            <a
                                href="#"
                                onclick="loadPopup('view_sleeplab.php?ed=<?php echo $myarray["sleeplabid"];?>')"
                                class="editlink"
                                title="EDIT"
                            >Quick View</a>
                            |
                            <a
                                href="Javascript:;"
                                onclick="Javascript: loadPopup('add_sleeplab.php?ed=<?php echo $myarray["sleeplabid"];?>');"
                                class="editlink"
                                title="EDIT"
                            >Edit</a>
                        </td>
                    </tr>
                    <tr :id="'pat_' + sleeplab.sleeplabid" style="display:none;">
                        <td colspan="4">
                            <h3>Patients</h3>
                            <template v-for="patient in sleeplab.patients">
                                <router-link
                                    :to="'dss_summ.php?sect=sleep&pid=' + patient.patientid"
                                >{{ patient.firstname }} {{ patient.lastname }}</router-link>
                                <br>
                            </template>
                        </td>
                    </tr>
                </template>
            </table>
        </form>
    </div>
</template>

<script src="./sleeplabs.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
