<template>
    <div>
        <br />
        <div v-if="message" align="center" class="red">
            {{ message }}
        </div>
        <form name="contactfrm" v-on:submit="contactabc()">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">
                       {{ 'Contact' + (contact.name ? ' "' + contact.name + '"': '') }}
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
                                            <option value=""></option>
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
                                        >
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
                <tr></tr>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                <div>
                                    <span>
                                        <input
                                            v-model="contact.greeting"
                                            id="greeting"
                                            name="greeting"
                                            type="text"
                                            class="field text addr tbox"
                                            tabindex="18"
                                            maxlength="255"
                                            style="width:200px;"
                                        />
                                        <label for="greeting">Greeting</label>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <textarea
                                            v-model="contact.sincerely"
                                            name="sincerely"
                                            id="sincerely"
                                            class="field text addr tbox"
                                            tabindex="19"
                                        ></textarea>
                                        <label for="sincerely">Sincerely</label>
                                    </span>
                                    <span>
                                        <select
                                            v-model="contact.contacttypeid"
                                            id="contacttypeid"
                                            name="contacttypeid"
                                            class="field text addr tbox"
                                            tabindex="20"
                                        >
                                            <option value="0"></option>
                                            <option
                                                v-for="type in contactTypes"
                                                :value="type.contacttypeid"
                                            >
                                                {{ type.contacttype }}
                                            </option>
                                        </select>
                                        <label for="contacttype">Contact Type</label>
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
                                    Notes:
                                </label>
                                <div>
                                    <span class="full">
                                        <textarea
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
                <tr>
                    <td  colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./viewCorporateContact.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/form.scss";
    @import "../../../../assets/css/manage/admin.scss";
</style>
