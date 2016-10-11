<style src="../../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../../assets/css/manage/manage.css" scoped></style>
<style type="text/css" scoped>
    .name-empty { font-weight: normal; }
    .name { width: 20% }
    .company.type { width: 25% }
</style>

<template>
    <span class="admin_head">Manage Contact</span>
    <br /><br />&nbsp;
    <div style="margin-left:10px;margin-right:10px;">
        <form name="jump1" style="float:left; width:350px;">
            Filter by type:
            <select
                v-model="routeParameters.selectedContactType"
                v-on:change="onChangeContactType"
                name="myjumpbox"
            >
                <option selected>Please Select...</option>
                <option :value="0">Display All</option>
                <option
                    v-for="option in contactTypes"
                    :value="option.contacttypeid"
                >
                    {{ option.contacttype }}
                </option>
                <option :value="0" v-on:click="onClickInActive">In-active</option>
            </select>
        </form>
        <br /><br />
        Search Contacts:
        <input type="text" id="contact_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="contact_name" value="Type contact name" />
        <br />
        <div id="contact_hints" class="search_hints" style="display:none;">
            <ul id="contact_list" class="search_list">
                <li class="template" style="display:none">Doe, John S</li>
            </ul>
        </div>
        <button style="margin-right:10px; float:right;" onclick="loadPopup('add_contact.php')" class="addButton">
            Add New Contact
        </button>
        &nbsp;&nbsp;
    </div>
    <br />
    <div v-if="message" align="center" class="red">
        <b>{{ message }}</b>
    </div>
    <form name="sortfrm">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
            <tr bgColor="#ffffff">
                <td colspan="2">
                    <div class="letter_select">
                        <a
                            v-for="letter in letters"
                            v-bind:class="{ 'selected_letter': letter == routeParameters.currentLetter }"
                            v-link="{ name: $route.name,
                                query: {
                                    letter      : letter,
                                    status      : routeParameters.status,
                                    sort        : routeParameters.sortColumn,
                                    sortdir     : routeParameters.sortDirection,
                                    contacttype : routeParameters.selectedContactType
                                }
                            }"
                            class="letters"
                        >{{ letter }}</a>
                        <a
                            v-link="{ name: $route.name,
                                query: {
                                    status      : routeParameters.status,
                                    sort        : routeParameters.sortColumn,
                                    sortdir     : routeParameters.sortDirection,
                                    contacttype : routeParameters.selectedContactType
                                }
                            }"
                        >Show All</a>
                    </div>
                </td>
                <td
                    v-if="contactTotalNumber > contactsPerPage"
                    align="right"
                    colspan="15"
                    class="bp"
                >
                    Pages:
                    <span v-for="index in totalPages">
                        <strong v-if="routeParameters.currentPageNumber == index">{{ index + 1 }}</strong>
                        <a
                            v-else
                            v-link="{
                                name: $route.name,
                                query: {
                                    page        : index,
                                    letter      : routeParameters.currentLetter,
                                    sort        : routeParameters.sortColumn,
                                    sortdir     : routeParameters.sortDirection,
                                    contacttype : routeParameters.selectedContactType
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
                    class="col_head  {{ routeParameters.sortColumn == sort ? 'arrow_' + routeParameters.sortDirection : '' }} {{ sort }}"
                    valign="top"
                >
                    <a
                        v-link="{
                            name: $route.name,
                            query: {
                                letter: routeParameters.currentLetter,
                                sort: sort,
                                sortdir: getCurrentDirection(sort)
                            }
                        }"
                    >{{ label }}</a>
                </td>
                <td valign="top" class="col_head" width="10%">
                    Referrer
                </td>
                <td valign="top" class="col_head" width="10%">
                    Patients
                </td>
                <td valign="top" class="col_head" width="20%">
                    Action
                </td>
            </tr>
            <tr v-if="!contacts.length" class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>
            <tbody v-else v-for="contact in contacts">
                <tr class="{{ contact.status == 1 ? 'tr_active' : 'tr_inactive' }}">
                    <td valign="top" width="20%">
                        <i
                            v-if="!contact.firstname && !contact.middlename && !contact.lastname"
                            class="name-empty"
                        >Empty name</i>
                        <span v-else>
                                <i v-if="!contact.lastname" class="name-empty">Empty last name</i>
                                <template v-else>
                                    {{ contact.lastname }}{{ !contact.middlename ? ',' : '' }}
                                </template>

                                <template v-if="contact.middlename">{{ contact.middlename }},</template>

                                <i v-if="!contact.firstname" class="name-empty">empty first name</i>
                                <template v-else>{{ contact.firstname }}</template>
                        </span>
                    </td>
                    <td valign="top" width="25%">
                        {{ contact.company }}
                    </td>
                    <td valign="top" width="25%">
                        {{ getContactTypeLabel(contact.contacttypeid) }}
                    </td>
                    <td valign="top" width="10%">
                        <a
                            v-if="contact.referrers > 0"
                            href="#"
                            v-on:click.prevent="onClickPatients(contact.contactid)"
                        >{{ contact.referrers }}</a>
                    </td>
                    <td valign="top" width="10%">
                        <a
                            v-if="contact.patients > 0"
                            href="#"
                            v-on:click.prevent="onClickPatients(contact.contactid)"
                        >{{ contact.patients }}</a>
                    </td>
                    <td valign="top" width="20%">
                        <div v-show="showActions" class="actions">
                            <a
                                href="#"
                                onclick="loadPopup('view_contact.php?ed={{ contact.contactid }}')"
                                class="editlink"
                                title="EDIT"
                            >Quick View</a> |
                            <a
                                href="#"
                                onclick="loadPopup('add_contact.php?ed={{ contact.contactid }}')"
                                class="editlink"
                                title="EDIT"
                            >Edit</a>
                        </div>
                    </td>
                </tr>
                <tr
                    v-if="contact.referrers > 0 || contact.patients > 0"
                    id="ref_pat_{{ contact.contactid }}"
                    style="display: none"
                >
                    <td colspan="2" valign="top">
                        <strong>REFERRED</strong><br />
                        <a
                            v-if="contact.referrers > 0"
                            v-for="referrer in referrers[contact.contactid]"
                            href="add_patient.php?pid={{ referrer.patientid }}&ed={{ referrer.patientid }}"
                        >{{ ref.firstname }} {{ ref.lastname }}<br />
                    </td>
                    <td colspan="4" valign="top">
                        <strong>PATIENTS</strong><br />
                        <a
                            v-if="contact.patients > 0"
                            v-for="patient in patients[contact.contactid]"
                            href="add_patient.php?pid={{ patient.patientid }}&ed={{ patient.patientid }}"
                        >{{ pat.firstname }} {{ pat.lastname }}<br />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</template>

<script>
    module.exports = require('./contacts.js');
</script>
