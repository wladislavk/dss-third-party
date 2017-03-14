<template>
    <div>
        <span class="admin_head">{{ title }}</span>
        <br /><br /><br />

        <div v-if="message" align="center" class="red">
            <b>{{ message }}</b>
        </div>

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
                        <br />
                    </td>
                    <td valign="top">
                    </td>
                    <td valign="top">
                    </td>
                    <td valign="top">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./printReferredByContact.js"></script>
