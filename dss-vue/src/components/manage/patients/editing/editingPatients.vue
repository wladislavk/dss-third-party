<style>
    <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
    <link href="css/task.css" rel="stylesheet" type="text/css" />
    <link href="css/notifications.css" rel="stylesheet" type="text/css" />
    <link href="css/search-hints.css" rel="stylesheet" type="text/css">
    <link href="css/top.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/letter-form.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link rel="stylesheet" href="css/add_patient.css?v=<?= time() ?>" type="text/css" media="screen" />
</style>

<template>
    <div
        v-if="patientNotifications"
        v-for="notification in patientNotifications"
        id="not_{{ notification.id }}" class="warning {{ notification.notification_type }}">
        <span>{{ notofication.notification }} {{ notification.notification_date }}</span>
        <a
            href="#"
            class="close_but"
            onclick="remove_notification('<?php echo $not['id']; ?>');return false;"
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
                        value=" <?php echo $but_text?> Patient"
                        class="button"
                    />
                    <template v-if="$doc_patient_portal && $use_patient_portal">
                        <input
                            v-if="$themyarray['registration_status']==1 || $themyarray['registration_status']==0"
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
                    <template v-if="count($bu_q) > 0">
                        <a
                            v-if="!empty($pat_hst_num_uncompleted) && $pat_hst_num_uncompleted > 0"
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
                                        v-if="$num_face==0"
                                        href="#"
                                        onclick="loadPopup('add_image.php?pid=<?= $patientId ?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:'';?>&it=4&return=patinfo&return_field=profile');return false;"
                                    >
                                        <img src="images/add_patient_photo.png" />
                                    </a>
                                    <template v-else>
                                        <img
                                            v-for="image in $itype_my"
                                            src="display_file.php?f={{ image.image_file }}"
                                            style="max-height:150px;max-width:200px;"
                                            style="float:right;"
                                        />
                                    </template>
                                </span>
                            </div>
                            <label class="desc" id="title0" for="Field0" style="float:left;">
                                Name
                                <span id="req_0" class="req">*</span>
                            </label>
                            <div style="float:left; clear:left;">
                                <span>
                                    <select name="salutation" style="width:80px;" >
                                        <option value="Mr." <?php if($salutation == "Mr."){echo "selected='selected'";} ?>>Mr.</option>
                                        <option value="Mrs." <?php if($salutation == "Mrs."){echo "selected='selected'";} ?>>Mrs.</option>
                                        <option value="Ms." <?php if($salutation == "Ms."){echo "selected='selected'";} ?>>Ms.</option>
                                        <option value="Dr." <?php if($salutation == "Dr."){echo "selected='selected'";} ?>>Dr.</option>
                                    </select>
                                    <label for="salutation">Salutation</label>
                                </span>
                                <span>
                                    <input
                                        id="firstname"
                                        name="firstname"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $firstname?>"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="firstname">First Name</label>
                                </span>
                                <span>
                                    <input
                                        id="lastname"
                                        name="lastname"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $lastname?>"
                                        maxlength="255"
                                        style="width:190px;"
                                    />
                                    <label for="lastname">Last Name</label>
                                </span>
                                <span>
                                    <input
                                        id="middlename"
                                        name="middlename"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $middlename?>"
                                        style="width:30px;"
                                        maxlength="1"
                                    />
                                    <label for="middlename">MI</label>
                                </span>
                                <span>
                                    <input
                                        id="preferred_name"
                                        name="preferred_name"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $preferred_name?>"
                                        maxlength="255"
                                        style="width:150px"
                                    />
                                    <label for="preferred_name">Preferred Name</label>
                                </span>
                            </div>
                            <div style="float:left">
                                <span>
                                    <input
                                        id="home_phone"
                                        name="home_phone"
                                        type="text"
                                        class="phonemask field text addr tbox"
                                        value="<?php echo $home_phone?>"
                                        maxlength="255"
                                        style="width:100px;"
                                    />
                                    <label for="home_phone">
                                        Home Phone
                                        <span id="req_0" class="req">*</span>
                                    </label>
                                </span>
                                <span>
                                    <input
                                        id="cell_phone"
                                        name="cell_phone"
                                        type="text"
                                        class="phonemask field text addr tbox"
                                        value="<?php echo $cell_phone?>"
                                        maxlength="255"
                                        style="width:100px;"
                                    />
                                    <label for="cell_phone">Cell Phone</label>
                                </span>
                                <span>
                                    <input
                                        id="work_phone"
                                        name="work_phone"
                                        type="text"
                                        class="extphonemask field text addr tbox"
                                        value="<?php echo $work_phone?>"
                                        maxlength="255"
                                        style="width:150px;"
                                    />
                                    <label for="work_phone">Work Phone</label>
                                </span>
                                <span>
                                    <input
                                        id="email"
                                        name="email"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $email?>"
                                        maxlength="255"
                                        style="width:275px;"
                                    />
                                    <label for="email">Email/Pt. Portal Login</label>
                                </span>
                            </div>
                            <div style="clear:both">
                                <span style="width:140px;">
                                    <select id="best_time" name="best_time">
                                        <option value="">Please Select</option>
                                        <option value="morning" <?php echo ($best_time=='morning')?'selected="selected"':''; ?>>Morning</option>
                                        <option value="midday" <?php echo ($best_time=='midday')?'selected="selected"':''; ?>>Mid-Day</option>
                                        <option value="evening" <?php echo ($best_time=='evening')?'selected="selected"':''; ?>>Evening</option>
                                    </select>
                                    <label for="best_time">Best time to contact</label>
                                </span>
                                <span style="width:150px;">
                                    <select id="best_number" name="best_number">
                                        <option value="">Please Select</option>
                                        <option value="home" <?php echo ($best_number=='home')?'selected="selected"':''; ?>>Home Phone</option>
                                        <option value="work" <?php echo ($best_number=='work')?'selected="selected"':''; ?>>Work Phone</option>
                                        <option value="cell" <?php echo ($best_number=='cell')?'selected="selected"':''; ?>>Cell Phone</option>
                                    </select>
                                    <label for="best_number">Best number to contact</label>
                                </span>
                                <span style="width:160px;">
                                    <select id="preferredcontact" name="preferredcontact" >
                                        <option value="paper" <?php if($preferredcontact == 'paper') echo " selected";?>>Paper Mail</option>
                                        <option value="email" <?php if($preferredcontact == 'email') echo " selected";?>>Email</option>
                                    </select>
                                    <label>Preferred Contact Method</label>
                                </span>
                                <div>Portal:
                                    <span style="color:#933; float:none;">
                                    </span>
                                    <br />
                                    <input
                                        type="submit"
                                        name="sendPin"
                                        value="Patient can't receive text message?"
                                        class="button"
                                    />
                                    <template v-if="$themyarray['registration_status']==1">
                                        PIN Code: <?php echo $themyarray['access_code']; ?> 
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
                                        id="add1"
                                        name="add1"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $add1?>"
                                        style="width:225px;"
                                        maxlength="255"
                                    />
                                    <label for="add1">Address1</label>
                                </span>
                                <span>
                                    <input
                                        id="add2"
                                        name="add2"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $add2?>"
                                        style="width:175px;"
                                        maxlength="255"
                                    />
                                    <label for="add2">Address2</label>
                                </span>
                                <span>
                                    <input
                                        id="city"
                                        name="city"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $city?>"
                                        style="width:200px;"
                                        maxlength="255"
                                    />
                                    <label for="city">City</label>
                                </span>
                                <span>
                                    <input
                                        id="state"
                                        name="state"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $state?>"
                                        style="width:25px;"
                                        maxlength="2"
                                    />
                                    <label for="state">State</label>
                                </span>
                                <span>
                                    <input
                                        id="zip"
                                        name="zip"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $zip?>"
                                        style="width:80px;"
                                        maxlength="255"
                                    />
                                    <label for="zip">Zip / Post Code </label>
                                </span>
                                <span v-if="$num_loc >= 1">
                                    <select name="location">
                                        <option value="">Select</option>
                                        <option
                                            v-for="location in $loc_q"
                                            {{ ($location == location.id || (location.default_location == 1 && !isset($_GET['pid']))) ? 'selected="selected"' : '' }}
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
                                        id="dob"
                                        name="dob"
                                        type="text"
                                        class="field text addr tbox calendar"
                                        value="<?php echo $dob?>"
                                        style="width:100px;"
                                        maxlength="255"
                                        onChange="validateDate('dob');"
                                        value="example 11/11/1234"
                                    />
                                    <span id="req_0" class="req">*</span>
                                    <label for="dob">Birthday</label>
                                </span>
                                <span>
                                    <select
                                        name="gender"
                                        id="gender"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                    >
                                        <option value="">Select</option>
                                        <option value="Male" <?php if($gender == 'Male') echo " selected";?>>Male</option>
                                        <option value="Female" <?php if($gender == 'Female') echo " selected";?>>Female</option>
                                    </select>
                                    <span id="req_0" class="req">*</span>
                                    <label for="gender">Gender</label>
                                </span>
                                <span style="width:150px">
                                    <input
                                        id="ssn"
                                        name="ssn"
                                        type="text"
                                        class="ssnmask field text addr tbox"
                                        value="<?php echo $ssn?>"
                                        maxlength="255"
                                        style="width:100px;"
                                    />
                                    <label for="ssn">Social Security No.</label>
                                </span>
                                <span>
                                    <select
                                        name="feet"
                                        id="feet"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                        tabindex="5"
                                        onchange="cal_bmi();"
                                    >
                                        <option value="0">Feet</option>
                                        <option
                                            v-for="1 in 9"
                                            :value="i"
                                            {{ ($feet == $i) ? 'selected' : '' }}
                                        >{{ i }}</option>
                                    </select>
                                    <label for="feet">Height: Feet</label>
                                </span>
                                <span>
                                    <select
                                        name="inches"
                                        id="inches"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                        tabindex="6"
                                        onchange="cal_bmi();"
                                    >
                                        <option value="-1">Inches</option>
                                        <option
                                            v-for="0 in 12"
                                            :value="i"
                                            {{ ($inches!='' && $inches == $i) ? 'selected' : '' }}
                                        >{{ i }}</option>
                                    </select>
                                    <label for="inches">Inches</label>
                                </span>
                                <span>
                                    <select
                                        name="weight"
                                        id="weight"
                                        class="field text addr tbox"
                                        style="width:100px;"
                                        tabindex="7"
                                        onchange="cal_bmi();"
                                    >
                                        <option value="0">Weight</option>
                                        <option
                                            v-for="80 in 500"
                                            :value="i"
                                            {{ ($weight == $i) ? 'selected' : '' }}
                                        >{{ i }}</option>
                                    </select>
                                    <label for="weight">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                </span>
                                <span style="color:#000000; padding-top:2px;">BMI</span>
                                    <input
                                        id="bmi"
                                        name="bmi"
                                        type="text"
                                        class="field text addr tbox"
                                        value="<?php echo $bmi?>"
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
                                    <select name="marital_status" id="marital_status" class="field text addr tbox" style="width:130px;" >
                                        <option value="">Select</option>
                                        <option value="Married" <?php if($marital_status == 'Married') echo " selected";?>>Married</option>
                                        <option value="Single" <?php if($marital_status == 'Single') echo " selected";?>>Single</option>
                                        <option value="Life Partner" <?php if($marital_status == 'Life Partner') echo " selected";?>>Life Partner</option>
                                        <option value="Minor" <?php if($marital_status == 'Minor') echo " selected";?>>Minor</option>
                                    </select>
                <label for="marital_status">Marital Status</label>
                </span>
                <span>
                <input id="partner_name" name="partner_name" type="text" class="field text addr tbox" value="<?php echo $partner_name?>"  maxlength="255" />
                <label for="partner_name">Partner/Guardian Name</label>
                </span>
                </div>
                </li>
                </ul>
                </td>
                <td valign="top" class="frmhead">
                <ul>
                <li id="foli8" class="complex"> 
                <!--<label class="desc" id="title0" for="Field0">
                Optional Fields (not used in letters)
                </label>-->
                <div>
                <span>
                <textarea name="patient_notes"  id="patient_notes" class="field text addr tbox" style="width:410px;" ><?php echo $patient_notes;?></textarea>
                <label for="patient_notes">Patient Notes</label>
                </span>
                </div>
                <div class="alert-text">
                <span>
                <label for="alert_text" style="display: inline">Patient alert (display text notification at top of chart)?</label>
                <input type="radio" name="display_alert" value="1" onclick="$('#alert_text').show()" <?php echo ($display_alert) ? 'checked="checked"' : ''; ?>>Yes
                <input type="radio" name="display_alert" value="0" onclick="$('#alert_text').hide()" <?php echo (!$display_alert) ? 'checked="checked"' : ''; ?>>No
                </span>
                <textarea name="alert_text" id="alert_text" <?php echo ($display_alert) ? 'class="show-alert-text"' : 'class="hide-alert-text"'; ?>><?php echo $alert_text; ?></textarea>
                </div>
                </li>
                </ul>
                </td>
                </tr>
        </table>
    </form>
</template>

<script type="text/javascript" src="js/add_patient.js?v=<?= time() ?>"></script>
<script type="text/javascript" src="script/logout_timer.js"></script>
<script src="script/autocomplete.js?v=20160719" type="text/javascript"></script>
<script src="script/autocomplete_local.js?v=20160719" type="text/javascript"></script>
<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<script type="text/javascript" src="/manage/js/patient_dob.js"></script>
<script type="text/javascript" src="/manage/js/add_patient.js?v=<?= time() ?>"></script>

<script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
<script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>

<script>
    module.exports = require('./editingPatients.js');
</script>
