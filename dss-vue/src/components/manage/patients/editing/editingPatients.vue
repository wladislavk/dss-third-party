<style src="../../../../../assets/css/manage/admin.css" scoped></style>
<!-- <style src="../../../../../assets/css/manage/task.css" scoped></style> -->
<!-- <style src="../../../../../assets/css/manage/notifications.css" scoped></style> -->
<!-- <style src="../../../../../assets/css/manage/search-hints.css" scoped></style> -->
<!-- <style src="../../../../../assets/css/manage/top.css" scoped></style> -->
<!-- <style src="../../../../../assets/css/manage/letter-form.css" scoped></style> -->
<style src="../../../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../../assets/css/manage/add_patient.css" scoped></style>

<template>
    <div v-if="message" align="center" class="red">
        {{ message }}
    </div>
    <div
        v-if="patientNotifications"
        v-for="notification in patientNotifications"
        id="not_{{ notification.id }}" class="warning {{ notification.notification_type }}">
        <span>{{ notofication.notification }} {{ notification.notification_date }}</span>
        <a
            href="#"
            class="close_but"
            onclick="remove_notification('{{ notification.id }}');return false;"
        >X</a>
    </div>
    <form
        name="patientfrm"
        id="patientfrm"
        onSubmit="return validate_add_patient(this);"
    >
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
                        type="submit"
                        style="float:right; margin-left: 5px;"
                        :value="buttonText + 'Patient'"
                        class="button"
                    />
                    <template v-if="showSendingEmails">
                        <input
                            v-if="patient.registration_status == 1 || patient.registration_status == 0"
                            type="submit"
                            name="sendReg"
                            value="Send Registration Email"
                            class="button"
                        />
                        <input
                            v-else
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
                            type="submit"
                            name="sendHST"
                            onclick="return confirm('Click OK to initiate a Home Sleep Test request. The HST request must be electronically signed by an authorized provider before it can be transmitted. You can view and save/update the request on the next screen.');"
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
                                        v-if="!profilePhoto.image_file"
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
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Dr.">Dr.</option>
                                    </select>
                                    <label for="salutation">Salutation</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.firstname"
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
                                        v-on:change="onChangePhone"
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
                                        v-on:change="onChangePhone"
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
                                        v-on:change="onChangePhone"
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
                                        <option value="paper">Paper Mail</option>
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
                                        id="dob"
                                        name="dob"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        style="width:100px;"
                                        maxlength="255"
                                        onChange="validateDate('dob');"
                                    />
                                    <span id="req_0" class="req">*</span>
                                    <label for="dob">Birthday</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.gender"
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
                                        v-on:change="onChangeSsn"
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
                                    >No
                                </span>
                                <textarea
                                    v-model="patient.alert_text"
                                    :class="{
                                        'show-alert-text' : patient.display_alert,
                                        'hide-alert-text' : !patient.display_alert
                                    }"
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
                                        v-on:change="onChangePhone"
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
                                        v-model="patient.referred_source_r"
                                        name="referred_source_r"
                                        {{ (patient.referred_source == consts.DSS_REFERRED_PATIENT ||
                                            patient.referred_source == consts.DSS_REFERRED_PHYSICIAN) ? 'checked="checked"' : '' }}
                                        type="radio"
                                        value="person"
                                        onclick="show_referredby('person', '')"
                                    /> Person
                                    <input
                                        v-model="patient.referred_source_r"
                                        name="referred_source_r"
                                        {{ (patient.referred_source == consts.DSS_REFERRED_MEDIA) ? 'checked="checked"' : '' }}
                                        type="radio"
                                        :value="consts.DSS_REFERRED_MEDIA"
                                        onclick="show_referredby('notes', <?php echo DSS_REFERRED_MEDIA; ?>)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_MEDIA] }}
                                    <input
                                        v-model="patient.referred_source_r"
                                        name="referred_source_r"
                                        {{ (patient.referred_source == consts.DSS_REFERRED_FRANCHISE) ? 'checked="checked"' : '' }}
                                        type="radio"
                                        :value="consts.DSS_REFERRED_FRANCHISE"
                                        onclick="show_referredby('notes',<?php echo DSS_REFERRED_FRANCHISE; ?>)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_FRANCHISE] }}
                                    <input
                                        v-model="patient.referred_source_r"
                                        name="referred_source_r"
                                        {{ (patient.referred_source == consts.DSS_REFERRED_DSSOFFICE) ? 'checked="checked"' : '' }}
                                        type="radio"
                                        :value="consts.DSS_REFERRED_DSSOFFICE"
                                        onclick="show_referredby('notes',<?php echo DSS_REFERRED_DSSOFFICE; ?>)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_DSSOFFICE] }}
                                    <input
                                        v-model="patient.referred_source_r"
                                        name="referred_source_r"
                                        {{ (patient.referred_source == consts.DSS_REFERRED_OTHER) ? 'checked="checked"' : '' }}
                                        type="radio"
                                        :value="consts.DSS_REFERRED_OTHER"
                                        onclick="show_referredby('notes',<?php echo DSS_REFERRED_OTHER; ?>)"
                                    /> {{ consts.dssReferredLabels[consts.DSS_REFERRED_OTHER] }}
                                </div>
                                <div style="clear:both;float:left;">
                                    <div
                                        id="referred_person"
                                        {{ (patient.referred_source != consts.DSS_REFERRED_PATIENT &&
                                            patient.referred_source != consts.DSS_REFERRED_PHYSICIAN) ?
                                            'style="display:none;margin-left:100px;"' :
                                            'style="margin-left:100px"' }}
                                    >
                                        <input
                                            v-model="patient.referredby_name"
                                            type="text"
                                            id="referredby_name"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="referredby_name"
                                            :value="patient.referredby_name ? patient.referredby_name : 'Type referral name'"
                                            style="width:300px;"
                                        />
                                        <input
                                            type="button"
                                            class="button"
                                            style="width:150px;"
                                            onclick="loadPopupRefer('add_contact.php?addtopat=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&from=add_patient');"
                                            value="+ Create New Contact"
                                        />
                                        <br />
                                        <div id="referredby_hints" class="search_hints" style="margin-top:20px; display:none;">
                                            <ul id="referredby_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
                                            </ul>
                                        </div>
                                        <div
                                            id="referred_notes"
                                            {{ (patient.referred_source != consts.DSS_REFERRED_MEDIA &&
                                                patient.referred_source != consts.DSS_REFERRED_FRANCHISE &&
                                                patient.referred_source != consts.DSS_REFERRED_DSSOFFICE &&
                                                patient.referred_source != consts.DSS_REFERRED_OTHER) ?
                                                'style="display:none;margin-left:200px;"' :
                                                'style="margin-left:200px;"' }}
                                        >
                                            <textarea
                                                v-model="patient.referred_notes"
                                                name="referred_notes"
                                                style="width:300px;"
                                            ></textarea>
                                        </div>
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
                            v-model="patient.ins_payer_name"
                            type="text"
                            id="ins_payer_name"
                            onclick="updateval(this)"
                            autocomplete="off"
                            name="ins_payer_name"
                            :value="eligiblePayerId ? (eligiblePayerId + ' - ' + eligiblePayerName) : 'Type insurance payer name'"
                            style="width:300px;"
                        />
                        <br />
                        <div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                            <ul id="ins_payer_list" class="search_list">
                                <li class="template" style="display:none"></li>
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
                                <template v-if="billingCompany.exclusive">
                                    {{ billingCompany.name + ' filing insurance' }}
                                </template>
                                <a
                                    v-else
                                    onclick="return false;"
                                    class="plain"
                                    title="Select YES if you would like {{ billingCompany.name }} to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended)."
                                >{{ billingCompany.name }} filing insurance?</a>
                                <input
                                    v-model="patient.p_m_dss_file_yes"
                                    id="p_m_dss_file_yes"
                                    class="dss_file_radio"
                                    type="radio"
                                    name="p_m_dss_file"
                                    value="1"
                                >Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                <input
                                    v-model="patient.p_m_dss_file_yes"
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
                                        v-on:change="onChangeRelations('primary_insurance')"
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
                                        id="ins_dob"
                                        name="ins_dob"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        maxlength="255"
                                        style="width:150px;"
                                        onChange="validateDate('ins_dob');"
                                    />
                                    <label for="ins_dob">Insured Date of Birth</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.ins_dob"
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
                        id="p_m_address_fields"
                        {{ (patient.p_m_same_address == "1") ? 'style="display:none;"' : '' }}
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
                                        v-model="patient.p_m_zip"
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
                                        id="p_m_ins_co"
                                        name="p_m_ins_co"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        onchange="updateNumber('p_m_ins_phone');"
                                        style="width:200px;"
                                    >
                                        <option value="" selected disabled>Select Insurance Company</option>
                                        <option
                                            v-if="insuranceContacts.length"
                                            v-for="contact in insuranceContacts"
                                            :value="contact.contactid"
                                        >{{ contact.company }}</option>
                                    </select>
                                    <label for="p_m_ins_co">Insurance Co.</label><br />
                                    <input
                                        type="button"
                                        class="button"
                                        style="width:215px;"
                                        onclick="loadPopupRefer('add_contact.php?from=add_patient&from_id=p_m_ins_co&ctype=ins<?php if(isset($_GET['pid'])){echo "&pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>');"
                                        value="+ Create New Insurance Company"
                                    />
                                </span>
                                <span>
                                    <input
                                        v-model="patient.p_m_party"
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
                                        v-model="patient.p_m_ins_phone"
                                        id="p_m_ins_phone"
                                        name="p_m_ins_phone"
                                        class="field text addr tbox"
                                        disabled="disabled"
                                        style="width:190px;height:60px;background:#ccc;"
                                    ></textarea>
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
                                        v-model="patient.s_m_ins"
                                        type="radio"
                                        value="Yes"
                                        {{ (patient.has_s_m_ins == "Yes") ? 'checked="checked"' : '' }}
                                        name="s_m_ins"
                                        onclick="$('.s_m_ins_div').show();"
                                    /> Yes
                                    <input
                                        v-model="patient.s_m_ins"
                                        type="radio"
                                        value="No"
                                        {{ (patient.has_s_m_ins != "Yes") ? 'checked="checked"':'' }}
                                        name="s_m_ins"
                                        onclick="$('.s_m_ins_div').hide(); $('#s_m_address_fields').hide(); clearInfo();"
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
                            v-model="patient.s_m_ins_payer_name"
                            type="text"
                            id="s_m_ins_payer_name"
                            onclick="updateval(this)"
                            autocomplete="off"
                            name="s_m_ins_payer_name"
                            :value="patient.s_m_eligible_payer_id ?
                                    (patient.s_m_eligible_payer_id + ' - ' + patient.s_m_eligible_payer_name) :
                                    'Type insurance payer name'"
                            style="width:300px;"
                        />
                        <br />
                        <div id="s_m_ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                            <ul id="s_m_ins_payer_list" class="search_list">
                                <li class="template" style="display:none"></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </template>
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex"> 
                            <label
                                class="desc s_m_ins_div"
                                id="title0"
                                for="Field0"
                                {{ patient.has_s_m_ins != "Yes" ? 'style="display:none;"' : '' }}
                            >
                                Secondary Medical  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <template v-if="billingCompany.exclusive">
                                    {{ billingCompany.name + ' filing insurance' }}
                                </template>
                                <a
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
                                    v-model="s_m_same_address"
                                    type="radio"
                                    onclick="$('#s_m_address_fields').hide();"
                                    name="s_m_same_address"
                                    value="1"
                                > Yes
                                <input
                                    v-model="s_m_same_address"
                                    type="radio"
                                    onclick="$('#s_m_address_fields').show();"
                                    name="s_m_same_address"
                                    value="2"
                                > No
                            </label>
                            <div
                                class="s_m_ins_div"
                                {{ patient.has_s_m_ins != "Yes" ? 'style="display:none;"' : '' }}
                            >
                                <span>
                                    <select
                                        v-model="patient.s_m_relation"
                                        v-on:change="onChangeRelations('secondary_insurance')"
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
                                        id="s_m_partylname"
                                        name="s_m_partylname"
                                        type="text"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="s_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                                </span>
                                <span>
                                    <input
                                        v-model="patient.ins2_dob"
                                        id="ins2_dob"
                                        name="ins2_dob"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        maxlength="255"
                                        style="width:150px;"
                                        onChange="validateDate('ins2_dob');"
                                    />
                                    <label for="ins2_dob">Insured Date of Birth</label>
                                </span>
                                <span>
                                    <select
                                        v-model="patient.s_m_gender"
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
                        id="s_m_address_fields"
                        {{ (patient.s_m_same_address == "1" ||
                            patient.has_s_m_ins != "Yes") ?
                            'style="display:none;"' : ''}}
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
                            <div
                                class="s_m_ins_div"
                                {{ (patient.has_s_m_ins != "Yes") ? 'style="display:none;"' : '' }}
                            >
                                <span>
                                    <select
                                        v-model="patient.s_m_ins_type"
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
                            <div class="s_m_ins_div" <?php echo ($has_s_m_ins != "Yes")?'style="display:none;"':''; ?>>
                                <span>
                                    <select
                                        v-model="patient.s_m_ins_co"
                                        id="s_m_ins_co"
                                        name="s_m_ins_co"
                                        class="field text addr tbox"
                                        maxlength="255"
                                        style="width:200px;"
                                        onchange="updateNumber2('s_m_ins_phone')"
                                    >
                                        <option value="" selected disabled>Select Insurance Company</option>
                                        <option
                                            v-if="insuranceContacts.length > 0"
                                            v-for="contact in insuranceContacts"
                                            :value="contact.contactid"
                                        >{{ contact.company }}</option>
                                    </select>
                                    <label for="s_m_ins_co">Insurance Co.</label><br />
                                    <input
                                        type="button"
                                        class="button"
                                        style="width:215px;"
                                        onclick="loadPopupRefer('add_contact.php?from=add_patient&from_id=s_m_ins_co&ctype=ins<?php if(isset($_GET['pid'])){echo "&pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>');"
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
                                        v-model="patient.s_m_ins_phone"
                                        id="s_m_ins_phone"
                                        name="s_m_ins_phone"
                                        type="text"
                                        class="field text addr tbox"
                                        disabled="disabled"
                                        style="width:190px;height:60px;background:#ccc;"
                                    ></textarea>
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
                                            id="docpcp_static_info"
                                            :style="patient.docpcp != '' ? '' : 'display:none'"
                                        >
                                            <span id="docpcp_name_static" style="width:300px;">{{ formedFullNames.docpcp_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docpcp;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                onclick="$('#docpcp_static_info').hide();$('#docpcp_name').show();return false;"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-model="formedFullNames.docpcp_name"
                                            type="text"
                                            id="docpcp_name"
                                            style="width:300px;<?php echo ($docpcp!='')?'display:none;':'';?>"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="docpcp_name"
                                            :value="patient.docpcp != '' ? formedFullNames.docpcp_name : 'Type contact name'"
                                        />
                                        <br />
                                        <div id="docpcp_hints" class="search_hints" style="display:none;">
                                            <ul id="docpcp_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
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
                                            id="docent_static_info"
                                            :style="patient.docent != '' ? '' : 'display:none'"
                                        >
                                            <span id="docent_name_static" style="width:300px;">{{ formedFullNames.docent_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docent;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                onclick="$('#docent_static_info').hide();$('#docent_name').show();return false;"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-model="formedFullNames.docent_name"
                                            type="text"
                                            id="docent_name"
                                            style="width:300px;<?php echo ($docent!='')?'display:none':''; ?>"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="docent_name"
                                            :value="patient.docent != '' ? formedFullNames.docent_name : 'Type contact name'"
                                        />
                                        <br />
                                        <div id="docent_hints" class="search_hints" style="display:none;">
                                            <ul id="docent_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
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
                                            id="docsleep_static_info"
                                            :style="patient.docsleep != '' ? '' : 'display:none'"
                                        >
                                            <span id="docsleep_name_static" style="width:300px;">{{ formedFullNames.docsleep_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docsleep;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                onclick="$('#docsleep_static_info').hide();$('#docsleep_name').show();return false;"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-model="formedFullNames.docsleep_name"
                                            type="text"
                                            id="docsleep_name"
                                            style="width:300px;<?php echo ($docsleep!='')?'display:none':''; ?>"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="docsleep_name"
                                            :value="patient.docsleep ? formedFullNames.docsleep_name : 'Type contact name'"
                                        />
                                        <br />
                                        <div id="docsleep_hints" class="search_hints" style="display:none;">
                                            <ul id="docsleep_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
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
                                            id="docdentist_static_info"
                                            :style="patient.docdentist != '' ? '' : 'display:none'"
                                        >
                                            <span id="docdentist_name_static" style="width:300px;">{{ formedFullNames.docdentist_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docdentist;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                onclick="$('#docdentist_static_info').hide();$('#docdentist_name').show();return false;"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-model="formedFullNames.docdentist_name"
                                            type="text"
                                            id="docdentist_name"
                                            style="width:300px;<?php echo ($docdentist!='')?'display:none':''; ?>"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="docdentist_name"
                                            :value="patient.docdentist != '' ? formedFullNames.docdentist_name : 'Type contact name'"
                                        />
                                        <br />
                                        <div id="docdentist_hints" class="search_hints" style="display:none;">
                                            <ul id="docdentist_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
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
                                            id="docmdother_static_info"
                                            style="height:25px;"
                                            :style="patient.docmdother != '' ? '' : 'display:none;'"
                                        >
                                            <span id="docmdother_name_static" style="width:300px;">{{ formedFullNames.docmdother_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                onclick="$('#docmdother_static_info').hide();$('#docmdother_name').show();return false;"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-model="formedFullNames.docmdother_name"
                                            type="text"
                                            id="docmdother_name"
                                            style="width:300px;<?php echo ($docmdother!='')?'display:none':''; ?>"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="docmdother_name"
                                            :value="patient.docmdother != '' ? formedFullNames.docmdother_name : 'Type contact name'"
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
                                        <div id="docmdother_hints" class="search_hints" style="display:none;">
                                            <ul id="docmdother_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr
                            height="35"
                            id="docmdother2_tr"
                            :style="patient.docmdother2 != '' ? '' : 'display:none'"
                        >
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Other MD 2</label>
                                        <div
                                            id="docmdother2_static_info"
                                            :style="patient.docmdother2 != '' ? '' : 'display:none'"
                                        >
                                            <span id="docmdother2_name_static" style="width:300px;">{{ formedFullNames.docmdother2_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother2;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                onclick="$('#docmdother2_static_info').hide();$('#docmdother2_name').show();return false;"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-model="formedFullNames.docmdother2_name"
                                            type="text"
                                            id="docmdother2_name"
                                            style="width:300px;<?php echo ($docmdother2!='')?'display:none':''; ?>"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="docmdother2_name"
                                            value="{{ patient.docmdother2 != '' ? formedFullNames.docmdother2_name : 'Type contact name' }}"
                                        />
                                        <br />
                                        <div id="docmdother2_hints" class="search_hints" style="display:none;">
                                            <ul id="docmdother2_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr
                            height="35"
                            id="docmdother3_tr"
                            :style="patient.docmdother3 != '' ? '' : 'display:none'"
                        >
                            <td>
                                <ul>
                                    <li id="foli8" class="complex">
                                        <label style="display: block; float: left; width: 110px;">Other MD 3</label>
                                        <div
                                            id="docmdother3_static_info"
                                            :style="patient.docmdother3 != '' ? '' : 'display:none'"
                                        >
                                            <span id="docmdother3_name_static" style="width:300px;">{{ formedFullNames.docmdother3_name }}</span>
                                            <a
                                                href="#"
                                                onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother3;?>');return false;"
                                                class="addButton"
                                            >Quick View</a>
                                            <a
                                                href="#"
                                                onclick="$('#docmdother3_static_info').hide();$('#docmdother3_name').show();return false;"
                                                class="addButton"
                                            >Change Contact</a>
                                        </div>
                                        <input
                                            v-model="formedFullNames.docmdother3_name"
                                            type="text"
                                            id="docmdother3_name"
                                            style="width:300px;<?php echo ($docmdother3!='')?'display:none':''; ?>"
                                            onclick="updateval(this)"
                                            autocomplete="off"
                                            name="docmdother3_name"
                                            value="{{ patient.docmdother3 != '' ? formedFullNames.docmdother3_name : 'Type contact name' }}"
                                        />
                                        <br />
                                        <div id="docmdother3_hints" class="search_hints" style="display:none;">
                                            <ul id="docmdother3_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
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
                        onchange="updatePPAlert()";
                    >
                        <option value="1">Active</option>
                        <option value="2">In-Active</option>
                    </select>
                    <br />&nbsp;
                </td>
            </tr>
            <template v-if="headerInfo.docInfo.doc_patient_portal">
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Portal Status
                        <br />
                        <span
                            id="ppAlert"
                            style="font-weight:normal;font-size:12px; {{ patient.status == 2 ? '' : 'display:none;' }}"
                        >Patient is in-active and will not be able to access<br />Patient Portal regardless of the setting of this field.</span>
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
                    <input
                        v-if="!introLetter"
                        id="introletter"
                        name="introletter"
                        type="checkbox"
                        value="1"
                    > Send Intro Letter to DSS patient
                    <template v-else>
                        DSS Intro Letter Sent to Patient {{ introLetter.date_generated }}
                    </template>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <span class="red">
                      * Required Fields
                    </span><br />
                    <input
                        type="submit"
                        :value="buttonText + 'Patient'"
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
