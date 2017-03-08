<template>
    <div>
        <span class="admin_head">
            Manage Referred By
        </span>
        <br /><br />&nbsp;

        <div align="right">
            <button v-on:click="loadPopup('add_referredby.php')" class="addButton">
                Add New Referred By
            </button>
            &nbsp;&nbsp;
            <a href="manage_referredby_print.php" class="button">Print List</a>
            &nbsp;&nbsp;
        </div>

        <br />
        <div v-if="message" align="center" class="red">
            <b>{{ message }}</b>
        </div>

        <div id="pager" class="pager">
            <form>
                <img src="~assets/images/first.png" class="first">
                <img src="~assets/images/prev.png" class="prev">
                <input class="pagedisplay" style="width:75px;" type="text">
                <img src="~assets/images/next.png" class="next">
                <img src="~assets/images/last.png" class="last">
            </form>
        </div>

        <form name="sortfrm">
            <table id="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr class="tr_bg_h">
                    <th valign="top" class="col_head" width="20%">Name</th>
                    <th valign="top" class="col_head" width="20%">Physician Type</th>
                    <th valign="top" class="col_head" width="20%">Total Referrals</th>
                    <th valign="top" class="col_head">30 Days</th>
                    <th valign="top" class="col_head">60 Days</th>
                    <th valign="top" class="col_head">90 Days</th>
                    <th valign="top" class="col_head">90+ Days</th>
                    <th valign="top" class="col_head">Notes</th>
                    <th valign="top" class="col_head">Expand</th>
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
                            v-if="contact.referred_source == constants.DSS_REFERRED_PHYSICIAN"
                            v-on:click="loadPopup('view_contact.php?ed=' + contact.contactid)"
                            href="#"
                        >{{ contact.name }}</a>
                        <template v-else>{{ contact.name }}</template>
                    </td>
                    <td valign="top" width="30%">
                        {{ contact.contacttype }}
                    </td>
                    <td valign="top" width="10%">
                        <router-link
                            :to="'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >{{ contact.num_ref }}</router-link>
                    </td>
                    <td valign="top" width="10%">
                        <router-link
                            :to="'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref30">{{ contact.num_ref30 }}</span>
                        </router-link>
                    </td>
                    <td valign="top" width="10%">
                        <router-link
                            :to="'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref60">{{ contact.num_ref60 }}</span>
                        </router-link>
                    </td>
                    <td valign="top" width="10%">
                        <router-link
                            :to="'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref90">{{ contact.num_ref90 }}</span>
                        </router-link>
                    </td>
                    <td valign="top" width="10%">
                        <router-link
                            :to="'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                        >
                            <span class="num_ref90plus">{{ contact.num_ref90plus }}</span>
                        </router-link>
                    </td>
                    <td valign="top" width="10%">
                        <a
                            href="#"
                            v-on:click="loadPopup('add_referredby_notes.php?rid=' + contact.contactid)"
                            class="editlink"
                            :title="contact.referredby_notes ? contact.referredby_notes : 'No Notes'"
                        >
                            View
                        </a>
                    </td>
                    <td valign="top"> 
                        <router-link
                            :to="'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type"
                            class="editlink"
                            :title="contact.patients_list"
                        >
                            List
                        </router-link>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./referredby.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/manage.css" scoped></style>
