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
            <tr
                v-else
                v-for="contact in contacts"
                class="{{ contact.status == 1 ? 'tr_active' : 'tr_inactive' }}"
            >
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
                        v-if="contact.patients"
                        href="#"
                        v-on:click.prevent="onClickPatientsByContact(contact.contactid)"
                    >{{ contact.patients.length }}</a>
                </td>
                <td valign="top" width="10%">
                    <?php echo ($num_pat) ? '<a href="#" onclick="$(\'#ref_pat_' . $myarray['contactid'] . '\').toggle();return false;">' . $num_pat . '</a>' : ''; ?>
                </td>
                <td valign="top" width="20%">
                    <div class="actions" style="display:none;">
                        <a
                            href="#"
                            onclick="loadPopup('view_contact.php?ed=<?php echo $myarray["contactid"];?>')"
                            class="editlink"
                            title="EDIT"
                        >Quick View</a> |
                        <a
                            href="#"
                            onclick="loadPopup('add_contact.php?ed=<?php echo $myarray["contactid"];?>')"
                            class="editlink"
                            title="EDIT"
                        >Edit</a>
                    </div>
                </td>
            </tr>
            <tr id="ref_pat_<?php echo  $myarray['contactid'];?>" style="display:none;">
                <td colspan="2" valign="top">
                    <strong>REFERRED</strong><br />
                    <a
                        v-if="$num_ref > 0"
                        v-for="ref in ref_q"
                        href="add_patient.php?pid=<?php echo $ref['patientid'];?>&ed=<?php echo  $ref['patientid'];?>"
                    >{{ ref.firstname }} {{ ref.lastname }}<br />
                </td>
                <td colspan="4" valign="top">
                    <strong>PATIENTS</strong><br />
                    <a
                        v-if="$num_pat > 0"
                        v-for="pat in pat_q"
                        href="add_patient.php?pid=<?php echo  $pat['patientid'];?>&ed=<?php echo  $pat['patientid'];?>"
                    >{{ pat.firstname }} {{ pat.lastname }}<br />
                </td>
            </tr>
        </table>
    </form>
</template>

<script src="js/manage_contact.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.actions').show();
    });
</script>

<script>
    module.exports = require('./contacts.js');
</script>
