<style src="../../../../../assets/css/manage/admin.css" scoped></style>
<!-- <style src="../../../../../assets/css/manage/task.css" scoped></style> -->
<!-- <style src="../../../../../assets/css/manage/notifications.css" scoped></style> -->
<style src="../../../../../assets/css/manage/search-hints.css" scoped></style>
<!-- <style src="../../../../../assets/css/manage/top.css" scoped></style> -->
<!-- <style src="../../../../../assets/css/manage/letter-form.css" scoped></style> -->
<style src="../../../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../../assets/css/manage/add_patient.css" scoped></style>

<template>
    <div v-if="message" align="center" class="red">
        {{ message }}
    </div>
    <div
        v-for="notification in patientNotifications"
        id="not_{{ notification.id }}" class="warning {{ notification.notification_type }}">
        <span>{{ notofication.notification }} {{ notification.notification_date }}</span>
        <a
            href="#"
            class="close_but"
            onclick="remove_notification('{{ notification.id }}');return false;"
        >X</a>
    </div>
    <form name="patientfrm" id="patientfrm">
        <table
            width="98%"
            style="margin-left:11px;"
            cellpadding="5"
            cellspacing="1"
            bgcolor="#FFFFFF"
            align="center"
        >
            <tr>
                <td>
                    <font style="color:#0a5da0; font-weight:bold; font-size:16px;">GENERAL INFORMATION</font>
                </td>
                <td align="right">
                    <input
                        v-on:click.prevent="submitAddingOrEditingPatient"
                        :value="buttonText + 'Patient'"
                        type="submit"
                        style="float:right; margin-left: 5px;"
                        class="button"
                    />
                    <template v-if="showSendingEmails">
                        <input
                            v-if="patient.registration_status == 1 || patient.registration_status == 0"
                            v-on:click="submitSendingRegistrationEmail"
                            type="submit"
                            name="sendReg"
                            value="Send Registration Email"
                            class="button"
                        />
                        <input
                            v-else
                            v-on:click.prevent="submitSendingReminderEmail"
                            type="submit"
                            name="sendRem"
                            value="Send Reminder Email"
                            class="button"
                        />
                    </template>
                    <template v-if="homeSleepTestCompanies.length > 0">
                        <a
                            v-if="uncompletedHomeSleepTests.length > 0"
                            href="#"
                            onclick="alert('Patient has existing HST with status <?php echo $pat_hst_status; ?>. Only one HST can be requested at a time.'); return false;"
                            class="button"
                        >Order HST</a>
                        <input
                            v-else
                            v-on:click.prevent="submitSendingHst"
                            type="submit"
                            name="sendHST"
                            value="Order HST"
                            class="button"
                        />
                    </template>
                </td>
            </tr>
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex"> 
                            <div id="profile_image" style="float:right; width:270px;">
                                <span style="float:right">
                                    <a
                                        v-if="!profilePhoto"
                                        href="#"
                                        onclick="loadPopup('add_image.php?pid=<?= $patientId ?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:'';?>&it=4&return=patinfo&return_field=profile');return false;"
                                    >
                                        <img src="assets/images/add_patient_photo.png" />
                                    </a>
                                    <img
                                        v-else
                                        :src="profilePhoto.image_file"
                                        style="max-height:150px;max-width:200px;"
                                        style="float:right;"
                                    />
                                </span>
                            </div>
                            <label class="desc" id="title0" for="Field0" style="float:left;">
                                Name
                                <span id="req_0" class="req">*</span>
                            </label>
                            <div style="float:left; clear:left;">
                                <span>
                                    <select
                                        v-model="patient.salutation"
                                        name="salutation"
                                        style="width:80px;"
                                    >
                                        <option value="Mr." selected>Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Dr.">Dr.</option>
                                    </select>
                                    <label for="salutation">Salutation</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.firstname"
                                        v-el:firstname
                                        id="firstname"
                                        name="firstname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="firstname">First Name</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.lastname"
                                        v-el:lastname
                                        id="lastname"
                                        name="lastname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:190px;"
                                    />
                                    <label for="lastname">Last Name</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.middlename"
                                        id="middlename"
                                        name="middlename"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:30px;"
                                        maxlength="1"
                                    />
                                    <label for="middlename">MI</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.preferred_name"
                                        id="preferred_name"
                                        name="preferred_name"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px"
                                    />
                                    <label for="preferred_name">Preferred Name</label>
                                </span>
                            </div>
                            <div style="float:left">
                                <span>
                                    <input
                                        v-model="patient.home_phone"
                                        id="home_phone"
                                        name="home_phone"
                                        type="text"
                                        class="phonemask field text addr tbox"
                                        maxlength="14"
                                        style="width:100px;"
                                    />
                                    <label for="home_phone">
                                        Home Phone
                                        <span id="req_0" class="req">*</span>
                                    </label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.cell_phone"
                                        v-el:cell_phone
                                        id="cell_phone"
                                        name="cell_phone"
                                        type="text"
                                        class="phonemask field text addr tbox"
                                        maxlength="14"
                                        style="width:100px;"
                                    />
                                    <label for="cell_phone">Cell Phone</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.work_phone"
                                        id="work_phone"
                                        name="work_phone"
                                        type="text"
                                        class="extphonemask field text addr tbox"
                                        maxlength="14"
                                        style="width:150px;"
                                    />
                                    <label for="work_phone">Work Phone</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.email"
                                        v-el:email
                                        id="email"
                                        name="email"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:275px;"
                                    />
                                    <label for="email">Email/Pt. Portal Login</label>
                                </span>
                            </div>
                            <div style="clear:both">
                                <span style="width:140px;">
                                    <select
                                        v-model="patient.best_time"
                                        id="best_time"
                                        name="best_time"
                                    >
                                        <option value="" selected disabled>Please Select</option>
                                        <option value="morning">Morning</option>
                                        <option value="midday">Mid-Day</option>
                                        <option value="evening">Evening</option>
                                    </select>
                                    <label for="best_time">Best time to contact</label>
                                </span>
                                <span style="width:150px;">
                                    <select
                                        v-model="patient.best_number"
                                        id="best_number"
                                        name="best_number"
                                    >
                                        <option value="" selected disabled>Please Select</option>
                                        <option value="home">Home Phone</option>
                                        <option value="work">Work Phone</option>
                                        <option value="cell">Cell Phone</option>
                                    </select>
                                    <label for="best_number">Best number to contact</label>
                                </span>
                                <span style="width:160px;">
                                    <select
                                        v-model="patient.preferredcontact"
                                        id="preferredcontact"
                                        name="preferredcontact"
                                    >
                                        <option value="paper" selected>Paper Mail</option>
                                        <option value="email">Email</option>
                                    </select>
                                    <label>Preferred Contact Method</label>
                                </span>
                                <div>Portal:
                                    <span style="color:#933; float:none;">
                                        {{ portalStatus }}
                                    </span>
                                    <br />
                                    <input
                                        v-on:click.prevent="submitSendingPinCode"
                                        type="submit"
                                        name="sendPin"
                                        value="Patient can't receive text message?"
                                        class="button"
                                    />
                                    <template v-if="patient.registration_status == 1">
                                        PIN Code: {{ patient.access_code }}
                                    </template>
                                </div>
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
                                Address
                                <span id="req_0" class="req">*</span>
                            </label>
                            <div>
                                <span>
                                    <input
                                        v-model="patient.add1"
                                        v-el:add1
                                        id="add1"
                                        name="add1"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:225px;"
                                        maxlength="255"
                                    />
                                    <label for="add1">Address1</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.add2"
                                        id="add2"
                                        name="add2"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:175px;"
                                        maxlength="255"
                                    />
                                    <label for="add2">Address2</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.city"
                                        v-el:city
                                        id="city"
                                        name="city"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:200px;"
                                        maxlength="255"
                                    />
                                    <label for="city">City</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.state"
                                        v-el:state
                                        id="state"
                                        name="state"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:25px;"
                                        maxlength="2"
                                    />
                                    <label for="state">State</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.zip"
                                        v-el:zip
                                        id="zip"
                                        name="zip"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:80px;"
                                        maxlength="255"
                                    />
                                    <label for="zip">Zip / Post Code </label>
                                </span>
                                <span v-if="docLocations.length >= 1">
                                    <select
                                        v-model="patientLocation"
                                        name="location"
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option
                                            v-for="location in docLocations"
                                            {{ (patientLocation == location.id || (location.default_location == 1 && !routeParameters.patientId)) ? 'selected="selected"' : '' }}
                                            :value="location.id"
                                        >{{ location.location }}</option>
                                    </select>
                                    <label for"location">Office Site</label>
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
                                        v-model="patient.dob"
                                        v-el:dob
                                        id="dob"
                                        name="dob"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        style="width:100px;"
                                        maxlength="255"
                                    />
                                    <span id="req_0" class="req">*</span>
                                    <label for="dob">Birthday</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.gender"
                                        v-el:gender
                                        name="gender"
                                        id="gender"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span id="req_0" class="req">*</span>
                                    <label for="gender">Gender</label>
                                </span>
                                <span style="width:150px">
                                    <input
                                        v-model="patient.ssn"
                                        id="ssn"
                                        name="ssn"
                                        type="text"
                                        class="ssnmask field text addr tbox"
                                        maxlength="11"
                                        style="width:100px;"
                                    />
                                    <label for="ssn">Social Security No.</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.feet"
                                        name="feet"
                                        id="feet"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                        tabindex="5"
                                        onchange="cal_bmi();"
                                    >
                                        <option value="0" selected disabled>Feet</option>
                                        <option
                                            v-for="i in 9"
                                            :value="i"
                                        >{{ i }}</option>
                                    </select>
                                    <label for="feet">Height: Feet</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.inches"
                                        name="inches"
                                        id="inches"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                        tabindex="6"
                                        onchange="cal_bmi();"
                                    >
                                        <option value="-1" selected disabled>Inches</option>
                                        <option
                                            v-for="i in inches"
                                            :value="i"
                                        >{{ i }}</option>
                                    </select>
                                    <label for="inches">Inches</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.weight"
                                        name="weight"
                                        id="weight"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                        tabindex="7"
                                        onchange="cal_bmi();"
                                    >
                                        <option value="0" selected disabled>Weight</option>
                                        <option
                                            v-for="i in weight"
                                            :value="i"
                                        >{{ i }}</option>
                                    </select>
                                    <label for="weight">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                </span>
                                <span>
                                    <span style="color:#000000; padding-top:2px;">BMI</span>
                                    <input
                                        v-model="patient.bmi"
                                        id="bmi"
                                        name="bmi"
                                        type="text"
                                        class="field text addr tbox"
                                        tabindex="8"
                                        maxlength="255"
                                        style="width:50px;"
                                        readonly="readonly"
                                    />
                                </span>
                                <span>
                                    <label for="bmi">
                                        &lt; 18.5 is Underweight
                                        <br />
                                        &nbsp;&nbsp;&nbsp;
                                        18.5 - 24.9 is Normal
                                        <br />
                                        &nbsp;&nbsp;&nbsp;
                                        25 - 29.9 is Overweight
                                        <br />
                                        &gt; 30 is Obese
                                    </label>
                                </span>
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="frmhead">
                    <ul>
                        <li>
                            <div>
                                <span>
                                    <select
                                        v-model="patient.marital_status"
                                        name="marital_status"
                                        id="marital_status"
                                        class="field text addr tbox"
                                        style="width:130px;"
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Married">Married</option>
                                        <option value="Single">Single</option>
                                        <option value="Life Partner">Life Partner</option>
                                        <option value="Minor">Minor</option>
                                    </select>
                                    <label for="marital_status">Marital Status</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.partner_name"
                                        id="partner_name"
                                        name="partner_name"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                    />
                                    <label for="partner_name">Partner/Guardian Name</label>
                                </span>
                            </div>
                        </li>
                    </ul>
                </td>
                <td valign="top" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex">
                            <div>
                                <span>
                                    <textarea
                                        v-model="patient.patient_notes"
                                        name="patient_notes"
                                        id="patient_notes"
                                        class="field text addr tbox"
                                        style="width:410px;"
                                    >{{ $patient_notes }}</textarea>
                                    <label for="patient_notes">Patient Notes</label>
                                </span>
                            </div>
                            <div class="alert-text">
                                <span>
                                    <label for="alert_text" style="display: inline">Patient alert (display text notification at top of chart)?</label>
                                    <input
                                        v-model="patient.display_alert"
                                        type="radio"
                                        name="display_alert"
                                        value="1"
                                    >Yes
                                    <input
                                        v-model="patient.display_alert"
                                        type="radio"
                                        name="display_alert"
                                        value="0"
                                        checked
                                    >No
                                </span>
                                <textarea
                                    v-show="patient.display_alert == 1"
                                    v-model="patient.alert_text"
                                    name="alert_text"
                                    id="alert_text"
                                >{{ $alert_text }}</textarea>
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
                                In case of an emergency
                            </label>
                            <div>
                                <span>
                                    <input
                                        v-model="patient.emergency_name"
                                        id="emergency_name"
                                        name="emergency_name"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:200px;"
                                    />
                                    <label for="emergency_name">Name</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emergency_relationship"
                                        id="emergency_relationship"
                                        name="emergency_relationship"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="emergency_relationship">Relationship</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emergency_number"
                                        id="emergency_number"
                                        name="emergency_number"
                                        type="text"
                                        class="extphonemask field text addr tbox"
                                        maxlength="14"
                                        style="width:150px;"
                                    />
                                    <label for="emergency_number">Number</label>
                                </span>
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <font style="color:#0a5da0; font-weight:bold; font-size:16px;">REFERRED BY</font>
                </td>
            </tr>
            <tr> 
                <td valign="top" colspan="2" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex"> 
                            <label class="desc" id="title0" for="Field0">&nbsp;</label>
                            <div>
                                <div style="float:left;">
                                    <input
                                        v-model="patient.copyreqdate"
                                        id="copyreqdate"
                                        name="copyreqdate"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        style="width:100px;"
                                        maxlength="255"
                                        onChange="validateDate('copyreqdate');"
                                    />
                                    <label>Date</label>
                                </div>
                                <div style="float:left;" id="referred_source_div">
                                    <input
                                        v-model="patient.referred_source"
                                        :checked="patient.referred_source == consts.DSS_REFERRED_PHYSICIAN"
                                        :value="consts.DSS_REFERRED_PATIENT"
                                        type="radio"
                                        v-on:click="showReferredBy('person', '')"
                                    /> Person
                                    <input
                                        v-model="patient.referred_source"
                                        :value="consts.DSS_REFERRED_MEDIA"
                                        type="radio"
                                        v-on:click="showReferredBy('notes', consts.DSS_REFERRED_MEDIA)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_MEDIA] }}
                                    <input
                                        v-model="patient.referred_source"
                                        :value="consts.DSS_REFERRED_FRANCHISE"
                                        type="radio"
                                        v-on:click="showReferredBy('notes', consts.DSS_REFERRED_FRANCHISE)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_FRANCHISE] }}
                                    <input
                                        v-model="patient.referred_source"
                                        :value="consts.DSS_REFERRED_DSSOFFICE"
                                        type="radio"
                                        v-on:click="showReferredBy('notes', consts.DSS_REFERRED_DSSOFFICE)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_DSSOFFICE] }}
                                    <input
                                        v-model="patient.referred_source"
                                        :value="consts.DSS_REFERRED_OTHER"
                                        type="radio"
                                        v-on:click="showReferredBy('notes', consts.DSS_REFERRED_OTHER)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_OTHER] }}
                                </div>
                                <div style="clear:both;float:left;">
                                    <div
                                        v-if="showReferredPerson"
                                        id="referred_person"
                                        style="margin-left:100px;"
                                    >
                                        <input
                                            v-model="formedFullNames.referred_name"
                                            v-on:keyup="onKeyUpSearchReferrers"
                                            v-el:referred_by_name
                                            type="text"
                                            id="referredby_name"
                                            autocomplete="off"
                                            name="referredby_name"
                                            style="width:300px;"
                                            placeholder="Type referral name"
                                        />
                                        <input
                                            type="button"
                                            class="button"
                                            style="width:150px;"
                                            onclick="loadPopupRefer('add_contact.php?addtopat={{ routeParameters.patientId }}&from=add_patient');"
                                            value="+ Create New Contact"
                                        />
                                        <br />
                                        <div
                                            v-show="foundReferrersByName.length > 0"
                                            id="referredby_hints"
                                            class="search_hints"
                                            style="margin-top:20px;"
                                        >
                                            <ul id="referredby_list" class="search_list">
                                                <li
                                                    v-for="contact in foundReferrersByName"
                                                    class="json_patient"
                                                    v-on:click="setReferredBy(contact.id, contact.source)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div
                                        v-if="showReferredNotes"
                                        id="referred_notes"
                                        style="margin-left:200px;"
                                    >
                                        <textarea
                                            v-model="patient.referred_notes"
                                            name="referred_notes"
                                            style="width:300px;"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <font style="color:#0a5da0; font-weight:bold; font-size:16px;">EMPLOYER</font>
                </td>
            </tr>
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex">
                            <label class="desc" id="title0" for="Field0">
                                Employer Information
                            </label>
                            <div>
                                <span>
                                    <input
                                        v-model="patient.employer"
                                        id="employer"
                                        name="employer"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:325px;"
                                        maxlength="255"
                                    />
                                    <label for="employer">Employer</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emp_phone"
                                        id="emp_phone"
                                        name="emp_phone"
                                        type="text"
                                        class="extphonemask field text addr tbox"
                                        style="width:150px;"
                                        maxlength="255"
                                    />
                                    <label for="emp_phone">&nbsp;&nbsp;Phone</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emp_fax"
                                        id="emp_fax"
                                        name="emp_fax"
                                        type="text"
                                        class="phonemask field text addr tbox"
                                        style="width:120px;"
                                        maxlength="255"
                                    />
                                    <label for="emp_fax">Fax</label>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <input
                                        v-model="patient.emp_add1"
                                        id="emp_add1"
                                        name="emp_add1"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:225px;"
                                        maxlength="255"
                                    />
                                    <label for="emp_add1">Address1</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emp_add2"
                                        id="emp_add2"
                                        name="emp_add2"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:175px;"
                                        maxlength="255"
                                    />
                                    <label for="emp_add2">Address2</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emp_city"
                                        id="emp_city"
                                        name="emp_city"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:200px;"
                                        maxlength="255"
                                    />
                                    <label for="emp_city">City</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emp_state"
                                        id="emp_state"
                                        name="emp_state"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:80px;"
                                        maxlength="255"
                                    />
                                    <label for="emp_state">State</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.emp_zip"
                                        id="emp_zip"
                                        name="emp_zip"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:80px;"
                                        maxlength="255"
                                    />
                                    <label for="emp_zip">Zip Code </label>
                                </span>
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <a name="p_m_ins"></a>
                    <font style="color:#0a5da0; font-weight:bold; font-size:16px;">INSURANCE</font>
                </td>
            </tr>
            <template v-if="headerInfo.docInfo.use_eligible_api == 1">
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        Insurance Co.
                        <input
                            v-model="formedFullNames.ins_payer_name"
                            v-on:keyup="onKeyUpSearchEligiblePayers('primary')"
                            v-el:ins-payer-name
                            type="text"
                            id="ins_payer_name"
                            autocomplete="off"
                            name="ins_payer_name"
                            style="width:300px;"
                            placeholder="Type insurance payer name"
                        />
                        <br />
                        <div
                            v-show="eligiblePayers.length > 0"
                            id="ins_payer_hints"
                            class="search_hints"
                            style="margin-top:20px;"
                        >
                            <ul id="ins_payer_list" class="search_list">
                                <li
                                    v-for="payer in eligiblePayers"
                                    class="json_patient"
                                    v-on:click="setEligiblePayer(payer.id, payer.name, 'primary')"
                                >{{ payer.id + ' - ' + payer.name}}</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </template>
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex">
                            <label class="desc" id="title0" for="Field0">
                                Primary Medical &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <template v-if="+billingCompany.exclusive">
                                    {{ billingCompany.name + ' filing insurance' }}
                                </template>
                                <a
                                    v-else
                                    class="plain"
                                    title="Select YES if you would like {{ billingCompany.name }} to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended)."
                                >{{ billingCompany.name }} filing insurance?</a>
                                <input
                                    v-model="patient.p_m_dss_file"
                                    id="p_m_dss_file_yes"
                                    class="dss_file_radio"
                                    type="radio"
                                    name="p_m_dss_file"
                                    value="1"
                                >Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                <input
                                    v-model="patient.p_m_dss_file"
                                    id="p_m_dss_file_no"
                                    type="radio"
                                    class="dss_file_radio"
                                    name="p_m_dss_file"
                                    value="2"
                                >No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a
                                    onclick="return false"
                                    class="plain"
                                    title="Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO."
                                >Insured Address same as Pt. address?</a>
                                <input
                                    v-model="patient.p_m_same_address"
                                    type="radio"
                                    onclick="$('#p_m_address_fields').hide();"
                                    name="p_m_same_address"
                                    value="1"
                                    checked
                                > Yes
                                <input
                                    v-model="patient.p_m_same_address"
                                    type="radio"
                                    onclick="$('#p_m_address_fields').show();"
                                    name="p_m_same_address"
                                    value="2"
                                > No
                            </label>
                            <div>
                                <span>
                                    <select
                                        v-model="patient.p_m_relation"
                                        v-on:change="handleChangingInsuranceInfo, onChangeRelations('primary_insurance')"
                                        v-el:p_m_relation
                                        id="p_m_relation"
                                        name="p_m_relation"
                                        class="field text addr tbox"
                                        style="width:200px;"
                                    >
                                        <option value="" selected disabled>None</option>
                                        <option value="Self">Self</option>
                                        <option value="Spouse">Spouse</option>
                                        <option value="Child">Child</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label for="work_phone">Relationship to insured party</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_partyfname"
                                        v-on:change="handleChangingInsuranceInfo"
                                        v-el:p_m_partyfname
                                        id="p_m_partyfname"
                                        name="p_m_partyfname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <input
                                        v-model="patient.p_m_partymname"
                                        id="p_m_partymname"
                                        name="p_m_partymname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:50px;"
                                    />
                                    <input
                                        v-model="patient.p_m_partylname"
                                        v-on:change="handleChangingInsuranceInfo"
                                        v-el:p_m_partylname
                                        id="p_m_partylname"
                                        name="p_m_partylname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="p_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.ins_dob"
                                        v-on:change="handleChangingInsuranceInfo, validateDate(patient.ins_dob)"
                                        v-el:ins_dob
                                        id="ins_dob"
                                        name="ins_dob"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="ins_dob">Insured Date of Birth</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.p_m_gender"
                                        v-el:p_m_gender
                                        name="p_m_gender"
                                        id="p_m_gender"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span id="req_0" class="req">*</span>
                                    <label for="p_m_gender">Insured Gender</label>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                    <ul
                        v-show="patient.p_m_same_address == 2"
                        id="p_m_address_fields"
                    >
                        <li id="foli8" class="complex">
                            <div>
                                <span>
                                    <input
                                        v-model="patient.p_m_address"
                                        id="p_m_address"
                                        name="p_m_address"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:225px;"
                                        maxlength="255"
                                    />
                                    <label for="p_m_address">Insured Address</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_city"
                                        id="p_m_city"
                                        name="p_m_city"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:200px;"
                                        maxlength="255"
                                    />
                                    <label for="p_m_city">Insured City</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_state"
                                        id="p_m_state"
                                        name="p_m_state"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:80px;"
                                        maxlength="2"
                                    />
                                    <label for="p_m_state">Insured State</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_zip"
                                        id="p_m_zip"
                                        name="p_m_zip"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:80px;"
                                        maxlength="255"
                                    />
                                    <label for="p_m_zip">Insured Zip Code </label>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                    <ul>
                        <li id="foli8" class="complex">
                            <div>
                                <span>
                                    <select
                                        v-model="patient.p_m_ins_type"
                                        v-on:change="handleChangingInsuranceInfo"
                                        v-el:p_m_ins_type
                                        id="p_m_ins_type"
                                        name="p_m_ins_type"
                                        class="field text addr tbox"
                                        onchange="update_insurance_type()"
                                        maxlength="255"
                                        style="width:200px;"
                                    >
                                        <option value="" selected disabled>Insurance Type</option>
                                        <option value="1">Medicare</option>
                                        <option value="2">Medicaid</option>
                                        <option value="3">Tricare Champus</option>
                                        <option value="4">Champ VA</option>
                                        <option value="5">Group Health Plan</option>
                                        <option value="6">FECA BLKLUNG</option>
                                        <option value="7">Other</option>
                                    </select>
                                    <label for="p_m_ins_type">Insurance Type</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_ins_ass"
                                        class="p_m_ins_ass"
                                        id="p_m_ins_ass_yes"
                                        type="radio"
                                        name="p_m_ins_ass"
                                        value="Yes"
                                    >Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input
                                        v-model="patient.p_m_ins_ass"
                                        class="p_m_ins_ass pay_to_patient_radio"
                                        id="p_m_ins_ass_no"
                                        type="radio"
                                        name="p_m_ins_ass"
                                        value="No"
                                    >Payment to Patient
                                </span>
                                <span style="float:right">
                                    <button
                                        v-if="!insuranceCardImage"
                                        id="p_m_ins_card"
                                        onclick="Javascript: loadPopup('add_image.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:'';?>&it=10&return=patinfo');return false;"
                                        class="addButton"
                                    >
                                        + Add Insurance Card Image
                                    </button>
                                    <button
                                        v-else
                                        id="p_m_ins_card"
                                        onclick="window.open('display_file.php?f=<?= rawurlencode($image['image_file']) ?>','welcome','width=800,height=400,scrollbars=yes'); return false;"
                                        class="addButton"
                                    >
                                        View Insurance Card Image
                                    </button>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                    <ul>
                        <li id="foli8" class="complex"> 
                            <div>
                                <span>
                                    <select
                                        v-model="patient.p_m_ins_co"
                                        v-el:p_m_ins_co
                                        v-on:change="handleChangingInsuranceInfo, updateNumber('p_m_ins_phone')"
                                        id="p_m_ins_co"
                                        name="p_m_ins_co"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:200px;"
                                    >
                                        <option value="" selected disabled>Select Insurance Company</option>
                                        <option
                                            v-for="contact in insuranceContacts"
                                            :value="contact.contactid"
                                        >{{ contact.company }}</option>
                                    </select>
                                    <label for="p_m_ins_co">Insurance Co.</label><br />
                                    <input
                                        type="button"
                                        class="button"
                                        style="width:215px;"
                                        v-on:click="onClickCreatingNewInsuranceCompany('p_m_ins_co')"
                                        value="+ Create New Insurance Company"
                                    />
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_ins_id"
                                        v-on:change="handleChangingInsuranceInfo"
                                        v-el:p_m_party
                                        id="p_m_party"
                                        name="p_m_ins_id"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:190px;"
                                    />
                                    <label for="p_m_ins_id">Insurance ID.</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_ins_grp"
                                        v-on:change="handleChangingInsuranceInfo"
                                        v-el:p_m_ins_grp
                                        id="p_m_ins_grp"
                                        name="p_m_ins_grp"
                                        type="text"
                                        class="field text addr tbox"
                                        {{ (patient.p_m_ins_type == '1') ? 'value="NONE" readonly="readonly"' : '' }}
                                        maxlength="255"
                                        style="width:100px;"
                                    />
                                    <label for="p_m_ins_grp">Group #</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_ins_plan"
                                        v-on:change="handleChangingInsuranceInfo"
                                        v-el:p_m_ins_plan
                                        id="p_m_ins_plan"
                                        name="p_m_ins_plan"
                                        type="text"
                                        class="field text addr tbox"
                                        {{ (patient.p_m_ins_type == '1') ? 'readonly="readonly"' : '' }}
                                        maxlength="255"
                                        style="width:200px;"
                                    />
                                    <label for="p_m_ins_plan">Plan Name</label>
                                </span>
                                <span>
                                    <textarea
                                        id="p_m_ins_phone"
                                        name="p_m_ins_phone"
                                        class="field text addr tbox"
                                        disabled="disabled"
                                        style="width:190px;height:60px;background:#ccc;"
                                    >{{ insCompanyContactInfo }}</textarea>
                                    <label for="p_m_ins_phone">Address</label>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex"> 
                            <div style="height:40px;display:block;">
                                <span>
                                    <label style="display:inline;">Does patient have secondary insurance?</label>
                                    <input
                                        v-model="patient.has_s_m_ins"
                                        type="radio"
                                        value="Yes"
                                        name="s_m_ins"
                                    /> Yes
                                    <input
                                        v-model="patient.has_s_m_ins"
                                        type="radio"
                                        value="No"
                                        name="s_m_ins"
                                        checked
                                    /> No
                                </span>
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
            <template v-if="headerInfo.docInfo.use_eligible_api == 1">
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        Insurance Co.
                        <input
                            v-model="formedFullNames.s_m_ins_payer_name"
                            v-on:keyup="onKeyUpSearchEligiblePayers('secondary')"
                            v-el:secondary-ins-payer-name
                            type="text"
                            id="s_m_ins_payer_name"
                            autocomplete="off"
                            name="s_m_ins_payer_name"
                            style="width:300px;"
                            placeholder="Type insurance payer name"
                        />
                        <br />
                        <div
                            v-show="secondaryEligiblePayers.length > 0"
                            id="s_m_ins_payer_hints"
                            class="search_hints"
                            style="margin-top:20px;"
                        >
                            <ul id="s_m_ins_payer_list" class="search_list">
                                <li
                                    v-for="payer in secondaryEligiblePayers"
                                    class="json_patient"
                                    v-on:click="setEligiblePayer(payer.id, payer.name, 'secondary')"
                                >{{ payer.id + ' - ' + payer.name}}</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </template>
            <tr v-show="patient.has_s_m_ins == 'Yes'">
                <td valign="top" colspan="2" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex"> 
                            <label class="desc s_m_ins_div" id="title0" for="Field0">
                                Secondary Medical  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <template v-if="+billingCompany.exclusive">
                                    {{ billingCompany.name + ' filing insurance' }}
                                </template>
                                <a
                                    v-else
                                    onclick="return false;"
                                    class="plain"
                                    title="Select YES if you would like {{ billingCompany.name }} to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended)."
                                >{{ billingCompany.name }} filing insurance?</a>
                                <input
                                    v-model="patient.dss_file_radio"
                                    id="s_m_dss_file_yes"
                                    type="radio"
                                    class="dss_file_radio"
                                    name="s_m_dss_file"
                                    value="1"
                                >Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                <input
                                    v-model="patient.dss_file_radio"
                                    id="s_m_dss_file_no"
                                    type="radio"
                                    class="dss_file_radio"
                                    name="s_m_dss_file"
                                    value="2"
                                >No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a
                                    onclick="return false"
                                    class="plain"
                                    title="Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO."
                                >Insured Address same as Pt. address?</a>
                                <input
                                    v-model="patient.s_m_same_address"
                                    type="radio"
                                    name="s_m_same_address"
                                    value="1"
                                > Yes
                                <input
                                    v-model="patient.s_m_same_address"
                                    type="radio"
                                    name="s_m_same_address"
                                    value="2"
                                > No
                            </label>
                            <div class="s_m_ins_div">
                                <span>
                                    <select
                                        v-model="patient.s_m_relation"
                                        v-on:change="onChangeRelations('secondary_insurance')"
                                        v-el:s_m_relation
                                        id="s_m_relation"
                                        name="s_m_relation"
                                        class="field text addr tbox"
                                        style="width:200px;"
                                    >
                                        <option value="" selected disabled>None</option>
                                        <option value="Self">Self</option>
                                        <option value="Spouse">Spouse</option>
                                        <option value="Child">Child</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label for="s_m_relation">Relationship to insured party</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_partyfname"
                                        v-el:s_m_partyfname
                                        id="s_m_partyfname" 
                                        name="s_m_partyfname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <input
                                        v-model="patient.s_m_partymname"
                                        id="s_m_partymname"
                                        name="s_m_partymname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:50px;"
                                    />
                                    <input
                                        v-model="patient.s_m_partylname"
                                        v-el:s_m_partylname
                                        id="s_m_partylname"
                                        name="s_m_partylname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="s_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.ins2_dob"
                                        v-el:ins2_dob
                                        v-on:change="validateDate(patient.ins2_dob)"
                                        id="ins2_dob"
                                        name="ins2_dob"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="ins2_dob">Insured Date of Birth</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.s_m_gender"
                                        v-el:s_m_gender
                                        name="s_m_gender"
                                        id="s_m_gender"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span id="req_0" class="req">*</span>
                                    <label for="s_m_gender">Insured Gender</label>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                    <ul
                        v-show="patient.s_m_same_address == 2"
                        id="s_m_address_fields"
                    >
                        <li id="foli8" class="complex">
                            <div>
                                <span>
                                    <input
                                        v-model="patient.s_m_address"
                                        id="s_m_address"
                                        name="s_m_address"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:225px;"
                                        maxlength="255"
                                    />
                                    <label for="s_m_address">Insured Address</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_city"
                                        id="s_m_city"
                                        name="s_m_city"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:200px;"
                                        maxlength="255"
                                    />
                                    <label for="s_m_city">Insured City</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_state"
                                        id="s_m_state"
                                        name="s_m_state"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:80px;"
                                        maxlength="2"
                                    />
                                    <label for="s_m_state">Insured State</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_zip"
                                        id="s_m_zip"
                                        name="s_m_zip"
                                        type="text"
                                        class="field text addr tbox"
                                        style="width:80px;"
                                        maxlength="255"
                                    />
                                    <label for="s_m_zip">Insured Zip Code </label>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                    <ul>
                        <li id="foli8" class="complex">
                            <div class="s_m_ins_div">
                                <span>
                                    <select
                                        v-model="patient.s_m_ins_type"
                                        v-el:s_m_ins_type
                                        id="s_m_ins_type"
                                        name="s_m_ins_type"
                                        onchange="checkMedicare()" 
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:200px;"
                                    >
                                        <option value="" selected disabled></option>
                                        <option value="1">Medicare</option>
                                        <option value="2">Medicaid</option>
                                        <option value="3">Tricare Champus</option>
                                        <option value="4">Champ VA</option>
                                        <option value="5">Group Health Plan</option>
                                        <option value="6">FECA BLKLUNG</option>
                                        <option value="7">Other</option>
                                    </select>
                                    <label for="s_m_ins_type">Insurance Type</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_ins_ass"
                                        v-el:s_m_ins_ass
                                        id="s_m_ins_ass_yes"
                                        type="radio"
                                        name="s_m_ins_ass"
                                        value="Yes"
                                    >Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input
                                        v-model="patient.s_m_ins_ass"
                                        id="s_m_ins_ass_no pay_to_patient_radio"
                                        type="radio"
                                        name="s_m_ins_ass"
                                        value="No"
                                    >Payment to Patient
                                </span>
                                <span style="float:right">
                                    <button
                                        v-if="!insuranceCardImage"
                                        id="s_m_ins_card"
                                        onclick="Javascript: loadPopup('add_image.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:'';?>&it=12&return=patinfo');return false;"
                                        class="addButton"
                                    >
                                        + Add Insurance Card Image
                                    </button>
                                    <button
                                        v-else
                                        id="s_m_ins_card"
                                        onclick="window.open('display_file.php?f=<?= rawurlencode($image['image_file']) ?>','welcome','width=800,height=400,scrollbars=yes'); return false;"
                                        class="addButton"
                                    >
                                        View Insurance Card Image
                                    </button>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                    <ul>
                        <li id="foli8" class="complex">
                            <div class="s_m_ins_div">
                                <span>
                                    <select
                                        v-model="patient.s_m_ins_co"
                                        v-el:s_m_ins_co
                                        id="s_m_ins_co"
                                        name="s_m_ins_co"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:200px;"
                                        onchange="updateNumber2('s_m_ins_phone')"
                                    >
                                        <option value="" selected disabled>Select Insurance Company</option>
                                        <option
                                            v-for="contact in insuranceContacts"
                                            :value="contact.contactid"
                                        >{{ contact.company }}</option>
                                    </select>
                                    <label for="s_m_ins_co">Insurance Co.</label><br />
                                    <input
                                        type="button"
                                        class="button"
                                        style="width:215px;"
                                        v-on:click="onClickCreatingNewInsuranceCompany('s_m_ins_co')"
                                        value="+ Create New Insurance Company"
                                    />
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_ins_id"
                                        id="s_m_party"
                                        name="s_m_ins_id"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:190px;"
                                    />
                                    <label for="s_m_ins_id">Insurance ID.</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_ins_grp"
                                        v-el:s_m_ins_grp
                                        id="s_m_ins_grp"
                                        name="s_m_ins_grp"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:100px;"
                                    />
                                    <label for="s_m_ins_grp">Group #</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.s_m_ins_plan"
                                        v-el:s_m_ins_plan
                                        id="s_m_ins_plan"
                                        name="s_m_ins_plan"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:200px;"
                                    />
                                    <label for="s_m_ins_plan">Plan Name</label>
                                </span>
                                <span>
                                    <textarea
                                        id="s_m_ins_phone"
                                        name="s_m_ins_phone"
                                        type="text"
                                        class="field text addr tbox"
                                        disabled="disabled"
                                        style="width:190px;height:60px;background:#ccc;"
                                    >{{ secondaryInsCompanyContactInfo }}</textarea>
                                    <label for="s_m_ins_phone">Address</label>
                                </span>
                            </div>
                            <div></div>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <font style="color:#0a5da0; font-weight:bold; font-size:16px;">CONTACT SECTION</font>
                </td>
            </tr>
            <tr>
                <td class="frmhead" colspan="2">
                    <table id="contactmds" style="float:left;">
                        <tr height="35">
                            <td>
                                <span style="padding-left:10px; float:left;">Add medical contacts so they can receive correspondence about this patient.</span>
                                <span style="float:left; margin-left:20px;">
                                    <input
                                        type="button"
                                        class="button"
                                        style="float:left; width:150px;"
                                        onclick="loadPopupRefer('add_contact.php?addtopat=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&from=add_patient');"
                                        value="+ Create New Contact" 
                                    />
                                </span>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Primary Care MD</label>
                                        <div
                                            v-show="patient.docpcp != ''"
                                            id="docpcp_static_info"
                                        >
                                            <span
                                                v-if="patient.docpcp != ''"
                                                id="docpcp_name_static"
                                                style="width:300px;"
                                            >{{ formedFullNames.docpcp_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docpcp;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                v-on:click.prevent="patient.docpcp = ''"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-if="patient.docpcp == ''"
                                            v-model="formedFullNames.docpcp_name"
                                            v-on:keyup="onKeyUpSearchContacts('docpcp')"
                                            v-el:docpcp_name
                                            type="text"
                                            id="docpcp_name"
                                            style="width:300px;"
                                            autocomplete="off"
                                            name="docpcp_name"
                                            placeholder="Type contact name"
                                        />
                                        <br />
                                        <div
                                            v-show="foundPrimaryCareMdByName.length > 0"
                                            id="docpcp_hints"
                                            class="search_hints"
                                        >
                                            <ul id="docpcp_list" class="search_list">
                                                <li
                                                    v-for="contact in foundPrimaryCareMdByName"
                                                    class="json_patient"
                                                    v-on:click="setContact('docpcp', contact.id)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr height="35">
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">ENT</label>
                                        <div
                                            v-show="patient.docent != ''"
                                            id="docent_static_info"
                                        >
                                            <span
                                                v-if="patient.docent != ''"
                                                id="docent_name_static"
                                                style="width:300px;"
                                            >{{ formedFullNames.docent_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docent;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                v-on:click.prevent="patient.docent = ''"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-if="patient.docent == ''"
                                            v-model="formedFullNames.docent_name"
                                            v-on:keyup="onKeyUpSearchContacts('docent')"
                                            v-el:docent_name
                                            type="text"
                                            id="docent_name"
                                            style="width:300px;"
                                            autocomplete="off"
                                            name="docent_name"
                                            placeholder="Type contact name"
                                        />
                                        <br />
                                        <div
                                            v-show="foundEntByName.length > 0"
                                            id="docent_hints"
                                            class="search_hints"
                                        >
                                            <ul id="docent_list" class="search_list">
                                                <li
                                                    v-for="contact in foundEntByName"
                                                    class="json_patient"
                                                    v-on:click="setContact('docent', contact.id)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr height="35">
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Sleep MD</label>
                                        <div
                                            v-show="patient.docsleep != ''"
                                            id="docsleep_static_info"
                                        >
                                            <span
                                                v-if="patient.docsleep != ''"
                                                id="docsleep_name_static"
                                                style="width:300px;"
                                            >{{ formedFullNames.docsleep_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docsleep;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                v-on:click.prevent="patient.docsleep = ''"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-if="patient.docsleep == ''"
                                            v-model="formedFullNames.docsleep_name"
                                            v-on:keyup="onKeyUpSearchContacts('docsleep')"
                                            v-el:docsleep_name
                                            type="text"
                                            id="docsleep_name"
                                            style="width:300px;"
                                            autocomplete="off"
                                            name="docsleep_name"
                                            placeholder="Type contact name"
                                        />
                                        <br />
                                        <div
                                            v-show="foundSleepMdByName.length > 0"
                                            id="docsleep_hints"
                                            class="search_hints"
                                        >
                                            <ul id="docsleep_list" class="search_list">
                                                <li
                                                    v-for="contact in foundSleepMdByName"
                                                    class="json_patient"
                                                    v-on:click="setContact('docsleep', contact.id)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr height="35"> 
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Dentist</label>
                                        <div
                                            v-show="patient.docdentist != ''"
                                            id="docdentist_static_info"
                                        >
                                            <span
                                                v-if="patient.docdentist != ''"
                                                id="docdentist_name_static"
                                                style="width:300px;"
                                            >{{ formedFullNames.docdentist_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docdentist;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                v-on:click.prevent="patient.docdentist = ''"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-if="patient.docdentist == ''"
                                            v-model="formedFullNames.docdentist_name"
                                            v-on:keyup="onKeyUpSearchContacts('docdentist')"
                                            v-el:docdentist_name
                                            type="text"
                                            id="docdentist_name"
                                            style="width:300px;"
                                            autocomplete="off"
                                            name="docdentist_name"
                                            placeholder="Type contact name"
                                        />
                                        <br />
                                        <div
                                            v-show="foundDentistContactsByName.length > 0"
                                            id="docdentist_hints"
                                            class="search_hints"
                                        >
                                            <ul id="docdentist_list" class="search_list">
                                                <li
                                                    v-for="contact in foundDentistContactsByName"
                                                    class="json_patient"
                                                    v-on:click="setContact('docdentist', contact.id)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr height="35">
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Other MD</label>
                                        <div
                                            v-show="patient.docmdother != ''"
                                            id="docmdother_static_info"
                                            style="height:25px;"
                                        >
                                            <span
                                                v-if="patient.docmdother != ''"
                                                id="docmdother_name_static"
                                                style="width:300px;"
                                            >{{ formedFullNames.docmdother_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                v-on:click.prevent="patient.docmdother = ''"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-if="patient.docmdother == ''"
                                            v-model="formedFullNames.docmdother_name"
                                            v-on:keyup="onKeyUpSearchContacts('docmdother')"
                                            v-el:docmdother_name
                                            type="text"
                                            id="docmdother_name"
                                            style="width:300px;"
                                            autocomplete="off"
                                            name="docmdother_name"
                                            placeholder='Type contact name'
                                        />
                                        <a
                                            v-if="patient.docmdother2 == '' || patient.docmdother3 == ''"
                                            href="#"
                                            id="add_new_md"
                                            onclick="add_md(); return false;"
                                            style="clear:both"
                                            class="addButton"
                                        >+ Add Additional MD</a>
                                        <br />
                                        <div
                                            v-show="foundOtherMdByName.length > 0"
                                            id="docmdother_hints"
                                            class="search_hints"
                                        >
                                            <ul id="docmdother_list" class="search_list">
                                                <li
                                                    v-for="contact in foundOtherMdByName"
                                                    class="json_patient"
                                                    v-on:click="setContact('docmdother', contact.id)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr
                            v-show="patient.docmdother2 != ''"
                            height="35"
                            id="docmdother2_tr"
                        >
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Other MD 2</label>
                                        <div
                                            v-show="patient.docmdother2 != ''"
                                            id="docmdother2_static_info"
                                        >
                                            <span
                                                v-if="patient.docmdother2 != ''"
                                                id="docmdother2_name_static"
                                                style="width:300px;"
                                            >{{ formedFullNames.docmdother2_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother2;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                v-on:click.prevent="patient.docmdother2 = ''"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-if="patient.docmdother2 == ''"
                                            v-model="formedFullNames.docmdother2_name"
                                            v-on:keyup="onKeyUpSearchContacts('docmdother2')"
                                            type="text"
                                            id="docmdother2_name"
                                            style="width:300px;"
                                            autocomplete="off"
                                            name="docmdother2_name"
                                            placeholder="Type contact name"
                                        />
                                        <br />
                                        <div
                                            v-show="foundOtherMd2ByName.length > 0"
                                            id="docmdother2_hints"
                                            class="search_hints"
                                        >
                                            <ul id="docmdother2_list" class="search_list">
                                                <li
                                                    v-for="contact in foundOtherMd2ByName"
                                                    class="json_patient"
                                                    v-on:click="setContact('docmdother2', contact.id)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr
                            v-show="patient.docmdother3 != ''"
                            height="35"
                            id="docmdother3_tr"
                        >
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Other MD 3</label>
                                        <div
                                            v-show="patient.docmdother3 != ''"
                                            id="docmdother3_static_info"
                                        >
                                            <span
                                                v-if="patient.docmdother3 != ''"
                                                id="docmdother3_name_static"
                                                style="width:300px;"
                                            >{{ formedFullNames.docmdother3_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother3;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                v-on:click.prevent="patient.docmdother3 = ''"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-if="patient.docmdother3 == ''"
                                            v-model="formedFullNames.docmdother3_name"
                                            v-on:keyup="onKeyUpSearchContacts('docmdother3')"
                                            type="text"
                                            id="docmdother3_name"
                                            style="width:300px;"
                                            autocomplete="off"
                                            name="docmdother3_name"
                                            placeholder="Type contact name"
                                        />
                                        <br />
                                        <div
                                            v-show="foundOtherMd3ByName.length > 0"
                                            id="docmdother3_hints"
                                            class="search_hints"
                                        >
                                            <ul id="docmdother3_list" class="search_list">
                                                <li
                                                    v-for="contact in foundOtherMd3ByName"
                                                    class="json_patient"
                                                    v-on:click="setContact('docmdother3', contact.id)"
                                                >{{ contact.name }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Patient Status
                </td>
                <td valign="top" class="frmdata">
                    <select
                        v-model="patient.status"
                        name="status"
                        id="status"
                        class="tbox"
                    >
                        <option value="1">Active</option>
                        <option value="2">In-Active</option>
                    </select>
                    <br />&nbsp;
                </td>
            </tr>
            <template v-if="headerInfo.docInfo.use_patient_portal">
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Portal Status
                        <br />
                        <span
                            v-show="patient.status == 2"
                            id="ppAlert"
                            style="font-weight:normal;font-size:12px;"
                        >Patient is in-active and will not be able to access<br />Patient Portal regardless of the setting of this field.
                        </span>
                    </td>
                    <td valign="top" class="frmdata">
                        <select
                            v-model="patient.use_patient_portal"
                            name="use_patient_portal"
                            class="tbox"
                        >
                          <option value="1">Active</option>
                          <option value="0">In-Active</option>
                        </select>
                        <br />&nbsp;
                    </td>
                </tr>
            </template>
            <tr>
                <td valign="top">
                    <template v-if="!introLetter">
                        <input
                            id="introletter"
                            name="introletter"
                            type="checkbox"
                            value="1"
                        > Send Intro Letter to DSS patient
                    </template>
                    <template v-else>
                        DSS Intro Letter Sent to Patient {{ introLetter.generated_date }}
                    </template>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <span class="red">
                      * Required Fields
                    </span><br />
                    <input
                        v-on:click.prevent="submitAddingOrEditingPatient"
                        :value="buttonText + 'Patient'"
                        type="submit"
                        class="button"
                    />
                </td>
            </tr>
        </table>
    </form>
</template>

<!-- <script type="text/javascript" src="js/add_patient.js?v=<?= time() ?>"></script> -->

<script>
    module.exports = require('./editingPatients.js');
</script>
