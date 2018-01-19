<template>
    <div>
        <span class="admin_head">Manage Referred By</span>
        <br /><br />&nbsp;

        <div align="right">
            <button v-on:click="onClickAddNewReferredBy" class="addButton">
                Add New Referred By
            </button>
            &nbsp;&nbsp;
            <router-link
                :to="{ name: 'print-referred-by-contact' }"
                class="button"
            >Print List</router-link>
            &nbsp;&nbsp;
        </div>

        <br />
        <div v-if="message" align="center" class="red">
            <b>{{ message }}</b>
        </div>

        <form name="sortfrm">
            <table id="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr v-if="contactsTotalNumber > contactsPerPage" bgColor="#ffffff">
                    <td  align="right" colspan="15" class="bp">
                        Pages:
                        <span v-for="index in totalPages" class="page_numbers">
                            <strong v-if="routeParameters.currentPageNumber == (index - 1)">{{ index }}</strong>
                            <router-link
                                v-else
                                :to="{
                                    name: $route.name,
                                    query: {
                                        page: index - 1,
                                        sort: routeParameters.sortColumn,
                                        sortdir: routeParameters.sortDirection
                                    }
                                }"
                                class="fp"
                            >{{ index }}</router-link>
                        </span>
                    </td>
                </tr>
                <tr class="tr_bg_h">
                    <th
                        v-for="(label, sort) in tableHeaders"
                        :class="'col_head ' + (routeParameters.sortColumn == sort ? 'arrow_' + routeParameters.sortDirection : '')"
                        valign="top"
                        :width="label.type == 'general' ? '20%' : ''"
                    >
                        <router-link
                            v-if="sort != 'notes' && sort != 'expand'"
                            :to="{
                                name: $route.name,
                                query: {
                                    sort: sort,
                                    sortdir: getCurrentDirection(sort)
                                }
                            }"
                        >
                            {{ label.title || label }}
                        </router-link>
                        <template v-else>{{ label }}</template>
                    </th>
                </tr>
                <tr v-if="contacts.length == 0" class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
                <tr
                    v-else
                    v-for="contact in contacts"
                    :data-contact-id="contact.contactid"
                    :data-contact-type="contact.referral_type"
                >
                    <td valign="top" width="20%">
                        <a
                            v-if="contact.referred_source == referredPhysician"
                            v-on:click.prevent="onClickViewContact(contact.contactid)"
                            href="#"
                        >{{ contact.name }}</a>
                        <template v-else>{{ contact.name }}</template>
                    </td>
                    <td valign="top" width="30%">{{ contact.contacttype }}</td>
                    <td valign="top" width="10%">
                        <a
                            v-bind:href="legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >{{ contact.num_ref }}</a>
                    </td>
                    <td valign="top" width="10%">
                        <a
                            v-bind:href="legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref30">{{ contact.num_ref30 }}</span>
                        </a>
                    </td>
                    <td valign="top" width="10%">
                        <a
                            v-bind:href="legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref60">{{ contact.num_ref60 }}</span>
                        </a>
                    </td>
                    <td valign="top" width="10%">
                        <a
                            v-bind:href="legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref90">{{ contact.num_ref90 }}</span>
                        </a>
                    </td>
                    <td valign="top" width="10%">
                        <a
                            v-bind:href="legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref90plus">{{ contact.num_ref90plus }}</span>
                        </a>
                    </td>
                    <td valign="top" width="10%">
                        <a
                            href="#"
                            v-on:click.prevent="onClickEditReferredByNotes(contact.contactid)"
                            class="editlink"
                            :title="contact.referredby_notes ? contact.referredby_notes : 'No Notes'"
                        >
                            View
                        </a>
                    </td>
                    <td valign="top">
                        <a
                            v-bind:href="legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                            :title="contact.patients_list"
                        >
                            List
                        </a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./referredby.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
<style lang="scss" scoped>
    @import "../../../assets/css/manage/manage.scss";
</style>
