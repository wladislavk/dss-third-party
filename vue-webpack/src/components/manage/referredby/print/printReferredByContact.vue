<template>
    <div>
        <span class="admin_head">{{ title }}</span>
        <br /><br /><br />

        <form name="sortfrm">
            <table width="98%" cellpadding="5" cellspacing="0" border="1" bgcolor="#FFFFFF" align="center" >
                <tr class="tr_bg_h">
                    <td
                        v-for="(meta, sort) in tableHeaders"
                        :class="'col_head ' + (routeParameters.sortColumn == sort ? 'arrow_' + routeParameters.sortDirection : '')"
                        valign="top"
                        :width="meta.width + '%'"
                    >
                        {{ meta.title }}
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
                    :class="contact.status == 1 ? 'tr_active' : 'tr_inactive'">
                    <td valign="top">
                        {{ contact.name }}
                    </td>
                    <td valign="top">
                        {{ contact.contacttype }}
                    </td>
                    <td valign="top">
                        {{ contact.num_ref }}
                    </td>
                    <td valign="top">
                        <template v-for="contact30 in contact.num_ref30">
                            {{ contact30.firstname }} {{ contact30.lastname + (contact30.copyreqdate ? ' - ' : '') }}{{ contact30.copyreqdate | moment("MM/DD/YYYY") }}<br>
                        </template>
                    </td>
                    <td valign="top">
                        <template v-for="contact60 in contact.num_ref60">
                            {{ contact60.firstname }} {{ contact60.lastname + (contact60.copyreqdate ? ' - ' : '') }}{{ contact60.copyreqdate | moment("MM/DD/YYYY") }}<br>
                        </template>
                    </td>
                    <td valign="top">
                        <template v-for="contact90 in contact.num_ref90">
                            {{ contact90.firstname }} {{ contact90.lastname + (contact90.copyreqdate ? ' - ' : '') }}{{ contact90.copyreqdate | moment("MM/DD/YYYY") }}<br>
                        </template>
                    </td>
                    <td valign="top">
                        <template v-for="contact90plus in contact.num_ref90plus">
                            {{ contact90plus.firstname }} {{ contact90plus.lastname + (contact90plus.copyreqdate ? ' - ' : '') }}{{ contact90plus.copyreqdate | moment("MM/DD/YYYY") }}<br>
                        </template>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./printReferredByContact.js"></script>
