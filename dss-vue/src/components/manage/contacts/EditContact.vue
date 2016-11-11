<style src="../../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../assets/css/manage/edit_contact.css" scoped></style>

<template>
    <div id="edit-contact">
        <div v-if="message" align="center" class="red">
            {{ message }}
        </div>
        <form name="contactfrm" style="width:99%;">
            <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
                <tr>
                    <td colspan="2" class="cat_head">
                        <span v-if="componentParams.ctype == 'ins'">Add Insurance Company</span>
                        <span v-else>
                            {{ (contact.contactid && contact.contactid > 0) ? 'Edit' : 'Add' }} {{ componentParams.heading }} Contact
                            <template v-if="contact.firstname && contact.lastname">&quot;{{ getFullName(contact) }}&quot;</template>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                <div>
                                    <span>
                                        <select
                                            v-model="contact.contacttypeid"
                                            id="contacttypeid"
                                            name="contacttypeid"
                                            class="field text addr tbox"
                                            tabindex="20"
                                        >
                                            <option value="0" disabled selected>Select a contact type</option>
                                            <option
                                                v-for="type in activeNonCorporateContactTypes"
                                                :value="type.contacttypeid"
                                                {{ (type.contacttypeid == componentParams.type) ? 'selected' : '' }}
                                            >{{ type.contacttype }}</option>
                                        </select>
                                        <label for="contacttype">Contact Type</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <template v-if="contact.contacttypeid && contact.contacttypeid > 0">
                    <tr v-if="showName" class="content physician other">
                        <td valign="top" colspan="2" class="frmhead">
                            <ul>
                                <li id="foli8" class="complex">
                                    <label class="desc" id="title0" for="Field0">
                                        Name
                                        <span v-if="componentParams.ctype && componentParams.ctype != 'ins'" id="req_0" class="req">*</span>
                                    </label>
                                    <div>
                                        <span>
                                            <select
                                                v-model="contact.salutation"
                                                name="salutation"
                                                id="salutation"
                                                class="field text addr tbox"
                                                tabindex="1"
                                                style="width:80px;"
                                            >
                                                <option value=""></option>
                                                <option value="Dr.">Dr.</option>
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Miss.">Miss.</option>
                                            </select>
                                            <label for="salutation">Salutation</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.firstname"
                                                id="firstname"
                                                name="firstname"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="2"
                                                maxlength="255"
                                            />
                                            <label for="firstname">First Name</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.lastname"
                                                id="lastname"
                                                name="lastname"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="3"
                                                maxlength="255"
                                            />
                                            <label for="lastname">Last Name</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.middlename"
                                                id="middlename"
                                                name="middlename"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="4"
                                                style="width:50px;"
                                                maxlength="1"
                                            />
                                            <label for="middlename">Middle <br />Init</label>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="content physician insurance other"> 
                        <td valign="top" colspan="2" class="frmhead">
                            <ul>
                                <li id="foli8" class="complex"> 
                                    <label class="desc" id="title0" for="Field0">
                                        <span>
                                            <span style="color:#000000">Company
                                                <span v-if="componentParams.ctype == 'ins'" id="req_0" class="req">*</span>
                                            </span>
                                            <input
                                                v-model="contact.company"
                                                id="company"
                                                name="company"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="5"
                                                style="width:575px;"
                                                maxlength="255"
                                            />
                                        </span>
                                    </label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="content physician insurance other"> 
                        <td valign="top" colspan="2" class="frmhead">
                            <ul>
                                <li id="foli8" class="complex"> 
                                    <label class="desc" id="title0" for="Field0">
                                        Address
                                        <span id="req_0" class="req">*</span>
                                    </label>
                                    <div>
                                        <span>
                                            <input
                                                v-model="contact.add1"
                                                id="add1"
                                                name="add1"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="6"
                                                style="width:325px;"
                                                maxlength="255"
                                            />
                                            <label for="add1">Address1</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.add2"
                                                id="add2"
                                                name="add2"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="7"
                                                style="width:325px;"
                                                maxlength="255"
                                            />
                                            <label for="add2">Address2</label>
                                        </span>
                                    </div>
                                    <div>
                                        <span>
                                            <input
                                                v-model="contact.city"
                                                id="city"
                                                name="city"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="8"
                                                style="width:200px;"
                                                maxlength="255"
                                            />
                                            <label for="city">City</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.state"
                                                id="state"
                                                name="state"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="9"
                                                style="width:80px;"
                                                maxlength="255"
                                            />
                                            <label for="state">State</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.zip"
                                                id="zip"
                                                name="zip"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="10"
                                                style="width:80px;"
                                                maxlength="255"
                                            />
                                            <label for="zip">Zip / Post Code </label>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="content physician insurance other"> 
                        <td valign="top" colspan="2" class="frmhead">
                            <ul>
                                <li id="foli8" class="complex"> 
                                    <div>
                                        <span>
                                            <input
                                                v-model="contact.phone1"
                                                id="phone1"
                                                name="phone1"
                                                type="text"
                                                class="extphonemask field text addr tbox"
                                                tabindex="11"
                                                maxlength="255"
                                                style="width:200px;"
                                            />
                                            <label for="phone1">Phone 1</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.phone2"
                                                id="phone2"
                                                name="phone2"
                                                type="text"
                                                class="extphonemask field text addr tbox"
                                                tabindex="12"
                                                maxlength="255"
                                                style="width:200px;"
                                            />
                                            <label for="phone2">Phone 2</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.fax"
                                                id="fax"
                                                name="fax"
                                                v-el:fax
                                                type="text"
                                                class="phonemask field text addr tbox"
                                                tabindex="13"
                                                maxlength="255"
                                                style="width:200px;"
                                            />
                                            <label for="fax">Fax</label>
                                        </span>
                                    </div>
                                    <div>
                                        <span>
                                            <input
                                                v-model="contact.email"
                                                id="email"
                                                name="email"
                                                v-el:email
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="14"
                                                maxlength="255"
                                                style="width:325px;"
                                            />
                                            <label for="email">Email</label>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr v-if="showNationalProviderId" class="content physician"> 
                        <td valign="top" colspan="2" class="frmhead">
                            <ul>
                                <li id="foli8" class="complex"> 
                                    <div>
                                        <span style="font-size:10px;">These fields required for Medicare referring physicians.</span><br />
                                        <span>
                                            National Provider ID (NPI)
                                            <input
                                                v-model="contact.national_provider_id"
                                                id="national_provider_id"
                                                name="national_provider_id"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="15"
                                                maxlength="255"
                                                style="width:200px;"
                                            />
                                        </span>
                                    </div>
                                </li>
                                <li id="foli8" class="complex"> 
                                    <label class="desc" id="title0" for="Field0">Other ID For Claim Forms</label>
                                    <div>
                                        <span>
                                            <select
                                                id="qualifier"
                                                name="qualifier"
                                                class="field text addr tbox"
                                                tabindex="16"
                                            >
                                                <option value="0"></option>
                                                <option v-for="qualifier in activeQualifiers" :value="qualifier.qualifierid">
                                                    {{ qualifier.qualifier }}
                                                </option>
                                            </select>
                                            <label for="qualifier">Qualifier</label>
                                        </span>
                                        <span>
                                            <input
                                                v-model="contact.qualifierid"
                                                id="qualifierid"
                                                name="qualifierid"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="17"
                                                maxlength="255"
                                                style="width:200px;"
                                            />
                                            <label for="qualifierid">ID</label>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="content physician insurance other"> 
                        <td valign="top" colspan="2" class="frmhead">
                            <ul>
                                <li id="foli8" class="complex"> 
                                     <label class="desc" id="title0" for="Field0">
                                        Notes:
                                    </label>
                                    <div>
                                        <span class="full">
                                            <textarea
                                                v-model="contact.notes"
                                                name="notes"
                                                id="notes"
                                                class="field text addr tbox"
                                                tabindex="21"
                                                style="width:600px; height:150px;"
                                            ></textarea>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF" class="content physician insurance other">
                        <td valign="top" class="frmhead">
                            Preferred Contact Method
                        </td>
                        <td valign="top" class="frmdata">
                            <select
                                v-model="contact.preferredcontact"
                                v-on:change="onPreferredContactChange"
                                id="preferredcontact"
                                name="preferredcontact"
                                class="tbox"
                                tabindex="22"
                            >
                                <option value="" selected disabled>Select a method</option>
                                <option value="fax">Fax</option>
                                <option value="paper">Paper Mail</option>
                                <option value="email">Email</option>
                            </select>
                            <br />&nbsp;
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF" class="content physician insurance other">
                        <td valign="top" class="frmhead">
                            Status
                        </td>
                        <td valign="top" class="frmdata">
                            <select
                                v-model="contact.status"
                                name="status"
                                id="status"
                                class="tbox"
                                tabindex="22"
                            >
                                <option value="1">Active</option>
                                <option value="2">In-Active</option>
                            </select>
                            <br />&nbsp;
                        </td>
                    </tr>
                    <tr class="content physician insurance other">
                        <td  colspan="2" align="center">
                            <span class="red">
                                * Required Fields
                            </span><br />
                            <a
                                href="{{ googleLink ? googleLink : '#' }}"
                                id="google_link"
                                target="_blank"
                                style="float:left;"
                            >Google</a>
                            <input
                                v-on:click.prevent="onClickSubmit"
                                type="submit"
                                value="{{ (contact.contactid && contact.contactid > 0) ? 'Edit' : 'Add' }} Contact"
                                class="button"
                            />

                            <template v-if="contact.contactid > 0">
                                <a
                                    style="float:right;"
                                    href="duplicate_contact.php?winner={{ contact.contactid }}"
                                    title="Duplicate"
                                >Is This a Duplicate? </a>
                                <br />
                                <a
                                    v-if="pendingVOB.length"
                                    style="float:right;"
                                    href="#"
                                    v-on:click.prevent="onClickConfirm('delete-pending-vobs', contact.contactid)"
                                    class="dellink"
                                    title="DELETE"
                                >Delete</a>
                                <template v-else>
                                    <template v-if="contactSentLetters.length > 0">
                                        <a
                                            style="float:right;"
                                            href="#"
                                            v-on:click.prevent="onClickConfirm('inactive', contact.contactid)"
                                            class="dellink"
                                            title="DELETE"
                                        >
                                        <input
                                            v-on:click.prevent="onClickSubmit"
                                            type="submit"
                                            value="{{ (contact.contactid && contact.contactid > 0) ? 'Edit' : 'Add' }} Contact"
                                            class="button"
                                        />
                                        <a
                                            v-if="contact.contactid > 0"
                                            style="float:right;"
                                            href="#"
                                            v-on:click.prevent="onClickConfirm('delete', contact.contactid)"
                                            class="dellink"
                                            title="DELETE"
                                        >Delete </a>
                                        <template v-else>
                                            <a
                                                v-if="contactPendingLetters.length > 0"
                                                style="float:right;"
                                                href="#"
                                                v-on:click.prevent="onClickConfirm('delete-pending-letters', contact.contactid)"
                                                class="dellink"
                                                title="DELETE"
                                            >Delete </a>
                                            <a
                                                v-else
                                                style="float:right;"
                                                href="#"
                                                v-on:click.prevent="onClickConfirm('delete', contact.contactid)"
                                                class="dellink"
                                                title="DELETE"
                                            >Delete</a>
                                        </template>
                                    </template>
                                </template>
                            </template>
                        </td>
                    </tr>
                </template>
            </table>
        </form>
    </div>
</template>

<script>
    module.exports = require('./EditContact.js');
</script>
