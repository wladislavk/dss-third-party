<template>
    <div>
        <span class="admin_head">Manage Contact</span>
        <br /><br />&nbsp;
        <div style="margin-left:10px;margin-right:10px;">
            <form name="jump1" style="float:left; width:350px;">
                Filter by type:
                <select
                    v-model="routeParameters.selectedContactType"
                    v-on:change="onChangeContactType"
                >
                    <option value="0">Display All</option>
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
            <input
                v-model="requiredContactName"
                v-on:keyup="onKeyUpSearchContacts"
                placeholder="Type contact name"
                id="contact_name"
                style="width:300px;"
                autocomplete="off"
            />
            <br />
            <div v-show="foundContactsByName.length > 0" id="contact_hints" class="search_hints">
                <ul id="contact_list" class="search_list">
                    <li
                        v-for="contact in foundContactsByName"
                        class="json_patient"
                        v-on:click="loadPopup('view_contact.php?ed=' + contact.id)"
                    >{{ contact.name }}</li>
                </ul>
            </div>
            <button
                style="margin-right:10px; float:right;"
                v-on:click.prevent="onClickAddNewContact"
                class="addButton"
            >Add New Contact</button>
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
                            <router-link
                                v-for="letter in letters"
                                :key="letter.id"
                                :class="{ 'selected_letter': letter === routeParameters.currentLetter }"
                                :to="{
                                  name: $route.name,
                                  query: {
                                    letter: letter,
                                    status: routeParameters.status,
                                    sort: routeParameters.sortColumn,
                                    sortdir: routeParameters.sortDirection,
                                    contacttype: routeParameters.selectedContactType
                                  }
                                }"
                                class="letters"
                            >{{ letter }}</router-link>
                            <router-link
                                v-if="routeParameters.currentLetter"
                                :to="{
                                  name: $route.name,
                                  query: {
                                    status: routeParameters.status,
                                    sort: routeParameters.sortColumn,
                                    sortdir: routeParameters.sortDirection,
                                    contacttype: routeParameters.selectedContactType
                                  }
                                }"
                            >Show All</router-link>
                        </div>
                    </td>
                    <td
                        v-if="contactsTotalNumber > contactsPerPage"
                        align="right"
                        colspan="15"
                        class="bp"
                    >
                        Pages:
                        <span v-for="index in totalPages" class="page_numbers">
                            <strong v-if="routeParameters.currentPageNumber === (index - 1)">{{ index }}</strong>
                            <router-link
                                v-else
                                :to="{
                                  name: $route.name,
                                  query: {
                                    page: index - 1,
                                    letter: routeParameters.currentLetter,
                                    sort: routeParameters.sortColumn,
                                    sortdir: routeParameters.sortDirection,
                                    contacttype: routeParameters.selectedContactType
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
                        :class="'col_head ' + (routeParameters.sortColumn === sort ? 'arrow_' + routeParameters.sortDirection : '') + ' ' + sort"
                        valign="top"
                    >
                        <router-link
                            :to="{
                              name: $route.name,
                              query: {
                                letter: routeParameters.currentLetter,
                                sort: sort,
                                sortdir: getCurrentDirection(sort)
                              }
                            }"
                        >{{ label }}</router-link>
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
                    <tr :class="contact.status === 1 ? 'tr_active' : 'tr_inactive'">
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
                            {{ contact.contacttype ? contact.contacttype : 'Contact Type Not Set' }}
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
                                    v-on:click.prevent="onClickQuickView(contact.contactid)"
                                    class="editlink"
                                    title="EDIT"
                                >Quick View</a> |
                                <a
                                    href="#"
                                    v-on:click.prevent="onClickEditContact(contact.contactid)"
                                    class="editlink"
                                    title="EDIT"
                                >Edit</a>
                            </div>
                        </td>
                    </tr>
                    <tr
                        v-if="contact.referrers > 0 || contact.patients > 0"
                        :id="'ref_pat_' + contact.contactid"
                        style="display: none"
                    >
                        <td colspan="2" valign="top">
                            <strong>REFERRED</strong><br />
                            <template
                                v-for="referrer in contact.referrers_data"
                            >
                                <a v-bind:href="legacyUrl + 'add_patient.php?pid=' + referrer.patientid + '&ed=' + referrer.patientid">{{ referrer.firstname }} {{ referrer.lastname }}</a><br />
                            </template>
                        </td>
                        <td colspan="4" valign="top">
                            <strong>PATIENTS</strong><br />
                            <template v-for="patient in contact.patients_data">
                                <a v-bind:href="legacyUrl + 'add_patient.php?pid=' + patient.patientid  + '&ed=' + patient.patientid">{{ patient.firstname }} {{ patient.lastname }}</a><br />
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</template>

<script src="./contacts.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/manage.scss";
    @import "../../../assets/css/manage/admin.scss";
</style>
<style type="text/css" scoped>
.name-empty {
  font-weight: normal;
}
.name {
  width: 20%;
}
.company.type {
  width: 25%;
}
</style>
