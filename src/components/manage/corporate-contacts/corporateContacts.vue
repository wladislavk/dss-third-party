<template>
    <div>
        <span class="admin_head">
            Manage Corporate Contacts
        </span>
        <br /><br /><br />
        <div v-if="message" align="center" class="red">
            <b>{{ message }}</b>
        </div>
        <form name="sortfrm">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <tr v-if="contactsTotalNumber > contactsPerPage" bgColor="#ffffff">
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
                                        sort    : routeParameters.sortColumn || undefined,
                                        sortdir : routeParameters.sortDirection
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
                <tr v-if="contacts.length == 0" class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
                <tr
                    v-else
                    v-for="contact in contacts"
                    :class="contact.status == 1 ? 'tr_active' : 'tr_inactive'"
                >
                    <td valign="top" >
                        {{ contact.company }}
                    </td>
                    <td valign="top" >
                        {{ contact.contacttype }}
                    </td>
                    <td valign="top">
                        {{ contact.name }}
                    </td>
                    <td valign="top">
                        <a
                            href="#"
                            v-on:click.prevent="onClickQuickView(contact.contactid)"
                            class="editlink"
                            title="Edit"
                        >Quick View</a> |
                        <a
                            href="#"
                            v-on:click.prevent="onClickViewFull(contact.contactid)"
                            class="editlink"
                            title="Edit"
                        >View Full</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./corporateContacts.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/manage.css" scoped></style>
