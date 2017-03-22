<template>
    <div>
        <br />
        <div v-if="message" align="center" class="red">
            {{ message }}
        </div>
        <form name="referredbyfrm">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">
                        {{ buttonText }} Referred By{{ contactFullName ? (' "' + contactFullName + '"') : '' }}
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex"> 
                                <label class="desc" id="title0" for="Field0">
                                    Name
                                    <span id="req_0" class="req">*</span>
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
                                            <option value="" disabled></option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Miss.">Miss.</option>
                                        </select>
                                        <label for="salutation">Salutation</label>
                                    </span>
                                    <span>
                                        <input
                                            v-model="contact.firstname"
                                            ref="firstname"
                                            id="firstname"
                                            name="firstname"
                                            type="text"
                                            class="field text addr tbox"
                                            tabindex="2"
                                            maxlength="255"
                                            placeholder="Firstname"
                                        />
                                        <label for="firstname">First Name</label>
                                    </span>
                                    <span>
                                        <input
                                            v-model="contact.lastname"
                                            ref="lastname"
                                            id="lastname"
                                            name="lastname"
                                            type="text"
                                            class="field text addr tbox"
                                            tabindex="3"
                                            maxlength="255"
                                            placeholder="Lastname"
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
                                            placeholder="Middle"
                                        />
                                        <label for="middlename">Middle <br />Init</label>
                                    </span>
                               </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr> 
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex"> 
                                <label class="desc" id="title0" for="Field0">
                                    <span>
                                        <span style="color:#000000">Company</span>
                                        <input
                                            v-model="contact.company"
                                            id="company"
                                            name="company"
                                            type="text"
                                            class="field text addr tbox"
                                            tabindex="5"
                                            style="width:575px;"
                                            maxlength="255"
                                            placeholder="Company"
                                        />
                                    </span>
                                </label>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr> 
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
                                            placeholder="1st Address"
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
                                            placeholder="2nd Address"
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
                                            placeholder="City"
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
                                            style="width:26px;"
                                            maxlength="2"
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
                                            placeholder="Zip Code"
                                        />
                                        <label for="zip">Zip / Post Code </label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr> 
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
                                            class="field text addr tbox"
                                            tabindex="11"
                                            maxlength="255"
                                            style="width:200px;"
                                            placeholder="1st Phone Number"
                                        />
                                        <label for="phone1">Phone 1</label>
                                    </span>
                                    <span>
                                        <input
                                            v-model="contact.phone2"
                                            id="phone2"
                                            name="phone2"
                                            type="text"
                                            class="field text addr tbox"
                                            tabindex="12"
                                            maxlength="255"
                                            style="width:200px;"
                                            placeholder="2nd Phone Number"
                                        />
                                        <label for="phone2">Phone 2</label>
                                    </span>
                                    <span>
                                        <input
                                            v-model="contact.fax"
                                            id="fax"
                                            name="fax"
                                            type="text"
                                            class="field text addr tbox"
                                            tabindex="13"
                                            maxlength="255"
                                            style="width:200px;"
                                            placeholder="Fax"
                                        />
                                        <label for="fax">Fax</label>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <input
                                            v-model="contact.email"
                                            ref="email"
                                            id="email"
                                            name="email"
                                            type="text"
                                            class="field text addr tbox"
                                            tabindex="14"
                                            maxlength="255"
                                            style="width:325px;"
                                            placeholder="Email"
                                        />
                                        <label for="email">Email</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <tr bgcolor="#FFFFFF">
                        <td valign="top" class="frmhead" width="30%">
                            Preferred Contact Method
                        </td>
                        <td valign="top" class="frmdata" width="70%">
                            <select
                                v-model="contact.preferredcontact"
                                id="preferredcontact"
                                name="preferredcontact"
                                class="tbox"
                                tabindex="22"
                            >
                                <option value="paper">Paper Mail</option>
                                <option value="fax">Fax</option>
                                <option value="email">Email</option>
                            </select>
                            <br />&nbsp;
                        </td>
                    </tr>
                    <tr> 
                        <td valign="top" colspan="2" class="frmhead">
                            <ul>
                                <li id="foli8" class="complex"> 
                                    <div>
                                        <span>
                                            National Provider ID
                                            <input
                                                v-model="contact.national_provider_id"
                                                id="national_provider_id"
                                                name="national_provider_id"
                                                type="text"
                                                class="field text addr tbox"
                                                tabindex="15"
                                                maxlength="255"
                                                style="width:200px;"
                                                placeholder="National Provider Id"
                                            />
                                        </span>
                                    </div>
                                </li>
                                <li id="foli8" class="complex"> 
                                    <label class="desc" id="title0" for="Field0">
                                        Other ID For Claim Forms
                                    </label>
                                    <div>
                                        <span>
                                            <select
                                                v-model="contact.qualifier"
                                                id="qualifier"
                                                name="qualifier"
                                                class="field text addr tbox"
                                                tabindex="16"
                                            >
                                                <option value="0" disabled></option>
                                                <option
                                                    v-for="qualifier in qualifiers"
                                                    :value="qualifier.qualifierid"
                                                >
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
                                                placeholder="Qualifier"
                                            />
                                            <label for="qualifierid">ID</label>
                                        </span>
                                    </div>
                               </li>     
                            </ul>
                        </td>
                    </tr>
                </tr>
                <tr>
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
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Status
                    </td>
                    <td valign="top" class="frmdata">
                        <select
                            v-model="contact.status"
                            name="status"
                            class="tbox"
                            tabindex="22"
                        >
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
                        </select>
                        <br />&nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input
                            v-on:click.prevent="onSubmit"
                            type="submit"
                            :value="buttonText + ' Referred By'"
                            class="button"
                        />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./editReferredByContacts.js"></script>

<style src="../../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../../assets/css/manage/form.css" scoped></style>
