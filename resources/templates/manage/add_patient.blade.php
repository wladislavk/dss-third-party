@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('css/manage/add_patient.css') !!}
    {!! HTML::style('css/manage/popup.css') !!}

    {!! HTML::script('/js/manage/add_patient.js') !!}
    {!! HTML::script('/js/manage/preferred_contact.js') !!}
    {!! HTML::script('/js/manage/patient_dob.js') !!}
    {!! HTML::script('/js/manage/calendar1.js') !!}

    @if (!empty($showBlock['readOnly']))
        {!! HTML::script('/js/manage/readonly_add_patient.js') !!}
    @endif
@stop

@section('content')

<script>
    var patientId = '{!! $patientId or '' !!}';
    var insContactsJson = '{!! $insContactsJson or '' !!}';
</script>

@if (!empty($message))
    <div align="center" class="red">{!! $message !!}</div>
@endif

@if (!empty($notifications))
    @foreach ($notifications as $notification)
        <div id="not_{!! $notification->id !!}" class="warning {!! $notification->notification_type !!}">
            <span>{!! $notification->notification !!} {!! ($notification->notification_date) ? '- ' . date('m/d/Y h:i a', strtotime($notification->notification_date)) : '' !!}</span>
            <a href="#" class="close_but" onclick="remove_notification('{!! $notification->id !!}');return false;">X</a>
        </div>
    @endforeach
@endif

<form name="patientfrm" id="patientfrm" action="{!! $path !!}/{!! $patientId or '' !!}" method="post" onSubmit="return validate_add_patient(this);">
    <input type='hidden' name='add' value='1'>
    <table width="98%" style="margin-left:11px;" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td >
                <font style="color:#0a5da0; font-weight:bold; font-size:16px;">GENERAL INFORMATION</font>
            </td>
            <td  align="right">
                <input type="submit" style="float:right; margin-left: 5px;" value=" {!! $butText or '' !!} Patient" class="button" />

                @if (!empty($docPatientPortal) && !empty($patientInfo['use_patient_portal']))
                    @if (!empty($showBlock['buttonSendReg']))
                        <input type="submit" name="sendReg" value="Send Registration Email" class="button" />
                    @else
                        <input type="submit" name="sendRem" value="Send Reminder Email" class="button" />
                    @endif
                @endif

                @if (!empty($showBlock['orderHst']))
                    <a href="#" onclick="alert('Patient has existing HST with status {!! $patientInfo['pat_hst_status'] or '' !!}. Only one HST can be requested at a time.'); return false;" class="button">Order HST</a>
                @else
                    <input type="submit" name="sendHST" onclick="return confirm('By clicking OK, you certify that you have discussed HST protocols with this patient and are legally qualified to request a HST for this patient. Your digital signature will be attached to this submission. You will be notified by the HST company when the patient\'s HST is complete.');" value="Order HST" class="button" />
                @endif
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex"> 
                        <div id="profile_image" style="float:right; width:270px;">
                            <span style="float:right">
                            @if (!empty($showBlock['patientPhoto']))
                                <a href="#" onclick="loadPopup('/manage/add_image/4/patinfo/profile'{!! !empty($patientId) ? '/' . $patientId : '' !!}{!! !empty($sh) ? '/' . $sh : '' !!}); return false;">
                                    <img src="/img/add_patient_photo.png" />
                                </a>
                            @else
                                @foreach ($imageType4 as $image)
                                    <img src="/manage/display_file{!! !empty($image->image_file) ? '/' . $image->image_file : '' !!}" style='max-height:150px;max-width:200px;' style='float:right;' />
                                @endforeach
                            @endif
                        </div>
                        
                        <label class="desc" id="title0" for="Field0" style="float:left;">
                            Name
                            <span id="req_0" class="req">*</span>
                        </label>

                        <div style="float:left; clear:left;">
                            <span>
                                <select name="salutation" style="width:80px;" >
                                    <option value="Mr." {!! (!empty($patientInfo['salutation']) && $patientInfo['salutation'] == "Mr.") ? "selected" : '' !!}>Mr.</option>
                                    <option value="Mrs." {!! (!empty($patientInfo['salutation']) && $patientInfo['salutation'] == "Mrs.") ? "selected" : '' !!}>Mrs.</option>
                                    <option value="Ms." {!! (!empty($patientInfo['salutation']) && $patientInfo['salutation'] == "Ms.") ? "selected" : '' !!}>Ms.</option>
                                    <option value="Dr." {!! (!empty($patientInfo['salutation']) && $patientInfo['salutation'] == "Dr.") ? "selected" : '' !!}>Dr.</option>
                                </select>
                                <label for="salutation">Salutation</label>
                            </span>
                            <span>
                                <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="{!! $patientInfo['firstname'] or '' !!}" maxlength="255" style="width:150px;" />
                                <label for="firstname">First Name</label>
                            </span>
                            <span>
                                <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="{!! $patientInfo['lastname'] or '' !!}" maxlength="255" style="width:190px;" />
                                <label for="lastname">Last Name</label>
                            </span>
                            <span>
                                <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="{!! $patientInfo['middlename'] or '' !!}" style="width:30px;" maxlength="1" />
                                <label for="middlename">MI</label>
                            </span>
                            <span>
                                <input id="preferred_name" name="preferred_name" type="text" class="field text addr tbox" value="{!! $patientInfo['preferred_name'] or '' !!}" maxlength="255" style="width:150px" />
                                <label for="preferred_name">Preferred Name</label>
                            </span>
                        </div>
                        <div style="float:left">
                            <span>
                                <input id="home_phone" name="home_phone" type="text" class="phonemask field text addr tbox" value="{!! $patientInfo['home_phone'] or '' !!}"  maxlength="255" style="width:100px;" />
                                <label for="home_phone">Home Phone
                                    <span id="req_0" class="req">*</span>
                                </label>
                            </span>
                            <span>
                                <input id="cell_phone" name="cell_phone" type="text" class="phonemask field text addr tbox" value="{!! $patientInfo['cell_phone'] or '' !!}"  maxlength="255" style="width:100px;" />
                                <label for="cell_phone">Cell Phone</label>
                            </span>
                            <span>
                                <input id="work_phone" name="work_phone" type="text" class="extphonemask field text addr tbox" value="{!! $patientInfo['work_phone'] or '' !!}" maxlength="255" style="width:150px;" />
                                <label for="work_phone">Work Phone</label>
                            </span>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="{!! $patientInfo['email'] or '' !!}"  maxlength="255" style="width:275px;" />
                                <label for="email">Email/Pt. Portal Login</label>
                            </span>
                        </div>
                        <div style="clear:both">
                            <span style="width:140px;">
                                <select id="best_time" name="best_time">
                                    <option value="">Please Select</option>
                                    <option value="morning" {!! (!empty($patientInfo['best_time']) && $patientInfo['best_time'] == 'morning') ? 'selected' : '' !!}>Morning</option>
                                    <option value="midday" {!! (!empty($patientInfo['best_time']) && $patientInfo['best_time'] == 'midday') ? 'selected' : '' !!}>Mid-Day</option>
                                    <option value="evening" {!! (!empty($patientInfo['best_time']) && $patientInfo['best_time'] == 'evening') ? 'selected' : '' !!}>Evening</option>
                                </select>
                                <label for="best_time">Best time to contact</label>
                            </span>
                            <span style="width:150px;">
                                <select id="best_number" name="best_number">
                                    <option value="">Please Select</option>
                                    <option value="home" {!! (!empty($patientInfo['best_number']) && $patientInfo['best_number'] == 'home') ? 'selected' : '' !!}>Home Phone</option>
                                    <option value="work" {!! (!empty($patientInfo['best_number']) && $patientInfo['best_number'] == 'work') ? 'selected' : '' !!}>Work Phone</option>
                                    <option value="cell" {!! (!empty($patientInfo['best_number']) && $patientInfo['best_number'] == 'cell') ? 'selected' : '' !!}>Cell Phone</option>
                                </select>
                                <label for="best_number">Best number to contact</label>
                            </span>
                            <span style="width:160px;">
                                <select id="preferredcontact" name="preferredcontact" >
                                    <option value="paper" {!! (!empty($patientInfo['preferredcontact']) && $patientInfo['preferredcontact'] == 'paper') ? 'selected' : '' !!}>Paper Mail</option>
                                    <option value="email" {!! (!empty($patientInfo['preferredcontact']) && $patientInfo['preferredcontact'] == 'email') ? 'selected' : '' !!}>Email</option>
                                </select>
                                <label>Preferred Contact Method</label>
                            </span>

                            <div>Portal:
                                <span style="color:#933; float:none;">
                                    @if (!empty($showBlock['registrationStatus']))
                                        {!! $showBlock['registrationStatus'] !!}
                                    @endif
                                </span>
                                <br />
                                <input type="submit" name="sendPin" value="Patient can't receive text message?" class="button" />
                                
                                @if (!empty($registrationStatus) && $registrationStatus == 1)
                                    PIN Code: {!! $accessCode !!}
                                @endif

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
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="{!! $patientInfo['add1'] or '' !!}" style="width:225px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="{!! $patientInfo['add2'] or '' !!}" style="width:175px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="{!! $patientInfo['city'] or '' !!}" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" class="field text addr tbox" value="{!! $patientInfo['state'] or '' !!}" style="width:25px;" maxlength="2" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="{!! $patientInfo['zip'] or '' !!}" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip / Post Code </label>
                            </span>

                            @if (!empty($locations))
                                <span>
                                    <select name="location">
                                        <option value="">Select</option>

                                        @foreach ($locations as $loc)
                                            @if (!empty($patientInfo['location']) && $patientInfo['location'] == $loc->id || $loc->default_location == 1 && !isset($patientId))
                                                <option selected value="{!! $loc->id !!}">{!! $loc->location !!}</option>
                                            @else
                                                <option value="{!! $loc->id !!}">{!! $loc->location !!}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for"location">Office Site</label>
                                </span>
                            @endif
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
                                <input id="dob" name="dob" type="text" class="field text addr tbox calendar" value="{!! $patientInfo['dob'] or '' !!}" style="width:100px;" maxlength="255" onChange="validateDate('dob');"  value="example 11/11/1234" />
                                <span id="req_0" class="req">*</span>
                                <label for="dob">Birthday</label>
                            </span>
                            <span>
                                <select name="gender" id="gender" class="field text addr tbox" style="width:100px;" >
                                    <option value="">Select</option>
                                    <option value="Male" {!! (!empty($patientInfo['gender']) && $patientInfo['gender'] == 'Male') ? 'selected' : '' !!}>Male</option>
                                    <option value="Female" {!! (!empty($patientInfo['gender']) && $patientInfo['gender'] == 'Female') ? 'selected' : '' !!}>Female</option>
                                </select>
                                <span id="req_0" class="req">*</span>
                                <label for="gender">Gender</label>
                            </span>
                            <span style="width:150px">
                                <input id="ssn" name="ssn" type="text" class="ssnmask field text addr tbox" value="{!! $patientInfo['ssn'] or '' !!}"  maxlength="255" style="width:100px;" />
                                <label for="ssn">Social Security No.</label>
                            </span>
                            <span>
                                <select name="feet" id="feet" class="field text addr tbox" style="width:100px;" tabindex="5" onchange="cal_bmi();" >
                                    <option value="0">Feet</option>

                                    @for ($i = 1; $i < 9; $i++)
                                        <option value="{!! $i !!}" {!! (!empty($patientInfo['feet']) && $patientInfo['feet'] == $i) ? 'selected' : '' !!}>{!! $i !!}</option>
                                    @endfor

                                </select>
                                <label for="feet">Height: Feet</label>
                            </span>
                            <span>
                                <select name="inches" id="inches" class="field text addr tbox" style="width:100px;" tabindex="6" onchange="cal_bmi();">
                                    <option value="-1">Inches</option>

                                    @for ($i = 0; $i < 12; $i++)
                                        <option value="{!! $i !!}" {!! (isset($patientInfo['inches']) && $patientInfo['inches'] == "$i") ? 'selected' : '' !!}>{!! $i !!}</option>
                                    @endfor

                                </select>
                                <label for="inches">Inches</label>
                            </span>
                            <span>
                                <select name="weight" id="weight" class="field text addr tbox" style="width:100px;" tabindex="7" onchange="cal_bmi();">
                                    <option value="0">Weight</option>
                                        
                                    @for ($i = 80; $i <= 500; $i++)
                                        <option value="{!! $i !!}" {!! (!empty($patientInfo['weight']) && $patientInfo['weight'] == $i) ? 'selected' : '' !!}>{!! $i !!}</option>
                                    @endfor

                                </select>
                                <label for="inches">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            </span>
                            <span>
                                <span style="color:#000000; padding-top:2px;">BMI</span>
                                <input id="bmi" name="bmi" type="text" class="field text addr tbox" value="{!! $patientInfo['bmi'] or '' !!}" tabindex="8" maxlength="255" style="width:50px;" readonly="readonly" />
                            </span>
                            <span>
                                <label for="inches">
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
                                    <option value="Married" {!! (!empty($patientInfo['marital_status']) && $patientInfo['marital_status'] == 'Married') ? 'selected' : '' !!}>Married</option>
                                    <option value="Single" {!! (!empty($patientInfo['marital_status']) && $patientInfo['marital_status'] == 'Single') ? 'selected' : '' !!}>Single</option>
                                    <option value="Life Partner" {!! (!empty($patientInfo['marital_status']) && $patientInfo['marital_status'] == 'Life Partner') ? 'selected' : '' !!}>Life Partner</option>
                                    <option value="Minor" {!! (!empty($patientInfo['marital_status']) && $patientInfo['marital_status'] == 'Minor') ? 'selected' : '' !!}>Minor</option>
                                </select>
                                <label for="marital_status">Marital Status</label>
                            </span>
                            <span>
                                <input id="partner_name" name="partner_name" type="text" class="field text addr tbox" value="{!! $patientInfo['partner_name'] or '' !!}"  maxlength="255" />
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
                                <textarea name="patient_notes"  id="patient_notes" class="field text addr tbox" style="width:410px;" >{!! $patientInfo['patient_notes'] or '' !!}</textarea>
                                <label for="patient_notes">Patient Notes</label>
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
                        <label class="desc" id="title0" for="Field0">In case of an emergency</label>
                        <div>
                            <span>
                                <input id="emergency_name" name="emergency_name" type="text" class="field text addr tbox" value="{!! $patientInfo['emergency_name'] or '' !!}" maxlength="255" style="width:200px;" />
                                <label for="home_phone">Name</label>
                            </span>
                            <span>
                                <input id="emergency_relationship" name="emergency_relationship" type="text" class="field text addr tbox" value="{!! $patientInfo['emergency_relationship'] or '' !!}" maxlength="255" style="width:150px;" />
                                <label for="home_phone">Relationship</label>
                            </span>
                            <span>
                                <input id="emergency_number" name="emergency_number" type="text" class="extphonemask field text addr tbox" value="{!! $patientInfo['emergency_number'] or '' !!}" maxlength="255" style="width:150px;" />
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
                                <input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox calendar" value="{!! $patientInfo['copyreqdate'] or '' !!}"  style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" value="example 11/11/1234" />
                                <label>Date</label>
                            </div>
                            <div style="float:left;" id="referred_source_div">
                                <input name="referred_source_r" {!! (!empty($patientInfo['referred_source']) && ($patientInfo['referred_source'] == $DSS_REFERRED_PATIENT || $patientInfo['referred_source'] == $DSS_REFERRED_PHYSICIAN)) ? 'checked' : '' !!} type="radio" value="person" onclick="show_referredby('person', '')" /> Person
                                <input name="referred_source_r" {!! (!empty($patientInfo['referred_source']) && $patientInfo['referred_source'] == $DSS_REFERRED_MEDIA) ? 'checked' : '' !!} type="radio" value="{!! $DSS_REFERRED_MEDIA !!}" onclick="show_referredby('notes', {!! $DSS_REFERRED_MEDIA !!})" /> {!! $dssReferredLabels[$DSS_REFERRED_MEDIA] !!}
                                <input name="referred_source_r" {!! (!empty($patientInfo['referred_source']) && $patientInfo['referred_source'] == $DSS_REFERRED_FRANCHISE) ? 'checked' : '' !!} type="radio" value="{!! $DSS_REFERRED_FRANCHISE !!}" onclick="show_referredby('notes', {!! $DSS_REFERRED_FRANCHISE !!})" /> {!! $dssReferredLabels[$DSS_REFERRED_FRANCHISE] !!}
                                <input name="referred_source_r" {!! (!empty($patientInfo['referred_source']) && $patientInfo['referred_source'] == $DSS_REFERRED_DSSOFFICE) ? 'checked' : '' !!} type="radio" value="{!! $DSS_REFERRED_DSSOFFICE !!}" onclick="show_referredby('notes', {!! $DSS_REFERRED_DSSOFFICE !!})" /> {!! $dssReferredLabels[$DSS_REFERRED_DSSOFFICE] !!}
                                <input name="referred_source_r" {!! (!empty($patientInfo['referred_source']) && $patientInfo['referred_source'] == $DSS_REFERRED_OTHER) ? 'checked' : '' !!} type="radio" value="{!! $DSS_REFERRED_OTHER !!}" onclick="show_referredby('notes', {!! $DSS_REFERRED_OTHER !!})" /> {!! $dssReferredLabels[$DSS_REFERRED_OTHER] !!}
                            </div>
                            <div style="clear:both;float:left;">
                                <div id="referred_person" {!! (!empty($patientInfo['referred_source']) && $patientInfo['referred_source'] != $DSS_REFERRED_PATIENT && $patientInfo['referred_source'] != $DSS_REFERRED_PHYSICIAN ) ? 'style="display:none;margin-left:100px;"' : 'style="margin-left:100px"' !!}> 
                                    <input type="text" id="referredby_name" onclick="updateval(this)" autocomplete="off" name="referredby_name" value="{!! $referredName or 'Type referral name' !!}" style="width:300px;" />
                                    <input type="button" class="button" style="width:150px;" onclick='loadPopupRefer("/manage/add_contact", "{\"addtopat\": \"{!! $patientId or '' !!}\", \"from\": \"add_patient\"}", "{!! csrf_token() !!}");' value="+ Create New Contact" />
                                    <br />
                                    <div id="referredby_hints" class="search_hints" style="margin-top:20px; display:none;">
                                        <ul id="referredby_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="referred_notes" {!! (!empty($patientInfo['referred_source']) && $patientInfo['referred_source'] != $DSS_REFERRED_MEDIA && $patientInfo['referred_source'] != $DSS_REFERRED_FRANCHISE && $patientInfo['referred_source'] != $DSS_REFERRED_DSSOFFICE && $patientInfo['referred_source'] != $DSS_REFERRED_OTHER) ? 'style="display:none;margin-left:200px;"' : 'style="margin-left:200px;"' !!}>
                                    <textarea name="referred_notes" style="width:300px;">{!! $patientInfo['referred_notes'] or '' !!}</textarea>  
                                </div>
                                <input type="hidden" name="referred_by" id="referred_by" value="{!! $patientInfo['referred_by'] or '' !!}" />
                                <input type="hidden" name="referred_source" id="referred_source" value="{!! $patientInfo['referred_source'] or '' !!}" />
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
                        <label class="desc" id="title0" for="Field0">Employer Information</label>
                        <div>
                            <span>
                                <input id="employer" name="employer" type="text" class="field text addr tbox" value="{!! $patientInfo['employer'] or '' !!}" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Employer</label>
                            </span>
                            <span>
                                <input id="emp_phone" name="emp_phone" type="text" class="extphonemask field text addr tbox" value="{!! $patientInfo['emp_phone'] or '' !!}"  style="width:150px;" maxlength="255" />
                                <label for="state">&nbsp;&nbsp;Phone</label>
                            </span>
                            <span>
                                <input id="emp_fax" name="emp_fax" type="text" class="phonemask field text addr tbox" value="{!! $patientInfo['emp_fax'] or '' !!}"  style="width:120px;" maxlength="255" />
                                <label for="state">Fax</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="emp_add1" name="emp_add1" type="text" class="field text addr tbox" value="{!! $patientInfo['emp_add1'] or '' !!}" style="width:225px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="emp_add2" name="emp_add2" type="text" class="field text addr tbox" value="{!! $patientInfo['emp_add2'] or '' !!}" style="width:175px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                            <span>
                                <input id="emp_city" name="emp_city" type="text" class="field text addr tbox" value="{!! $patientInfo['emp_city'] or '' !!}" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="emp_state" name="emp_state" type="text" class="field text addr tbox" value="{!! $patientInfo['emp_state'] or '' !!}"  style="width:80px;" maxlength="255" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="emp_zip" name="emp_zip" type="text" class="field text addr tbox" value="{!! $patientInfo['emp_zip'] or '' !!}" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip Code </label>
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

        @if (!empty($showBlock['insuranceCo']))
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    Insurance Co.
                    <input type="text" id="ins_payer_name" onclick="updateval(this)" autocomplete="off" name="ins_payer_name" value="{!! !empty($patientInfo['p_m_eligible_payer_id']) ? $patinetInfo['p_m_eligible_payer_id'] . ' - ' . $patientInfo['p_m_eligible_payer_name'] : 'Type insurance payer name' !!}" style="width:300px;" />
                    <br />
                    <div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                        <ul id="ins_payer_list" class="search_list">
                            <li class="template" style="display:none"></li>
                        </ul>
                    </div>
                    <input type="hidden" name="p_m_eligible_payer" id="p_m_eligible_payer" value="{!! $patientInfo['p_m_eligible_payer_id'] or '' !!} - {!! $patientInfo['p_m_eligible_payer_name'] or '' !!}" />
                </td>
            </tr>
        @endif

        <tr> 
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex"> 
                        <label class="desc" id="title0" for="Field0">
                            Primary Medical &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            @if (!empty($exclusiveBilling))
                                {!! $nameBilling . ' filing insurance' !!}
                            @else
                                <a onclick="return false;" class="plain" title="Select YES if you would like {!! $nameBilling !!} to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended).">{!! $nameBilling !!} filing insurance?</a>
                                <input id="p_m_dss_file_yes" class="dss_file_radio" type="radio" name="p_m_dss_file" value="1" {!! (!empty($patientInfo['p_m_dss_file']) && $patientInfo['p_m_dss_file'] == '1') ? 'checked' : '' !!}>Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                <input  id="p_m_dss_file_no" type="radio" class="dss_file_radio" name="p_m_dss_file" value="2" {!! (!empty($patientInfo['p_m_dss_file']) && $patientInfo['p_m_dss_file'] == '2') ? 'checked' : '' !!}>No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @endif

                            <a onclick="return false" class="plain" title="Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO.">Insured Address same as Pt. address?</a>
                            <input type="radio" onclick="$('#p_m_address_fields').hide();" name="p_m_same_address" value="1" {!! (!empty($patientInfo['p_m_same_address']) && $patientInfo['p_m_same_address'] == '1') ? 'checked' : '' !!}> Yes
                            <input type="radio" onclick="$('#p_m_address_fields').show();" name="p_m_same_address" value="2" {!! (!empty($patientInfo['p_m_same_address']) && $patientInfo['p_m_same_address'] == '2') ? 'checked' : '' !!}> No
                        </label>
                        <div>
                            <span>
                                <select id="p_m_relation" name="p_m_relation" class="field text addr tbox" style="width:200px;">
                                    <option value="" {!! (!empty($patientInfo['p_m_relation']) && $patientInfo['p_m_relation'] == '') ? 'selected' : '' !!}>None</option>
                                    <option value="Self" {!! (!empty($patientInfo['p_m_relation']) && $patientInfo['p_m_relation'] == 'Self') ? 'selected' : '' !!}>Self</option>
                                    <option value="Spouse" {!! (!empty($patientInfo['p_m_relation']) && $patientInfo['p_m_relation'] == 'Spouse') ? 'selected' : '' !!}>Spouse</option>
                                    <option value="Child" {!! (!empty($patientInfo['p_m_relation']) && $patientInfo['p_m_relation'] == 'Child') ? 'selected' : '' !!}>Child</option>
                                    <option value="Other" {!! (!empty($patientInfo['p_m_relation']) && $patientInfo['p_m_relation'] == 'Other') ? 'selected' : '' !!}>Other</option>
                                </select>
                                <label for="work_phone">Relationship to insured party</label>
                            </span>
                            <span>
                                <input id="p_m_partyfname" name="p_m_partyfname" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_partyfname'] or '' !!}" maxlength="255" style="width:150px;" />
                                <input id="p_m_partymname" name="p_m_partymname" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_partymname'] or '' !!}" maxlength="255" style="width:50px;" />
                                <input id="p_m_partylname" name="p_m_partylname" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_partylname'] or '' !!}" maxlength="255" style="width:150px;" />
                                <label for="p_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
                            <span>
                                <input id="ins_dob" name="ins_dob" type="text" class="field text addr tbox calendar" value="{!! $patientInfo['ins_dob'] or '' !!}" maxlength="255" style="width:150px;" onChange="validateDate('ins_dob');" />
                                <label for="ins_dob">Insured Date of Birth</label>
                            </span>
                            <span>
                                <select name="p_m_gender" id="p_m_gender" class="field text addr tbox" style="width:100px;" >
                                    <option value="">Select</option>
                                    <option value="Male" {!! (!empty($patientInfo['p_m_gender']) && $patientInfo['p_m_gender'] == 'Male') ? 'selected' : '' !!}>Male</option>
                                    <option value="Female" {!! (!empty($patientInfo['p_m_gender']) && $patientInfo['p_m_gender'] == 'Female') ? 'selected' : '' !!}>Female</option>
                                </select>
                                <span id="req_0" class="req">*</span>
                                <label for="gender">Insured Gender</label>
                            </span>
                        </div>
                        <div></div>
                    </li>
                </ul>
                <ul id="p_m_address_fields" {!! (!empty($patientInfo['p_m_same_address']) && $patientInfo['p_m_same_address'] == "1") ? 'style="display:none;"'  :'' !!}>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input id="p_m_address" name="p_m_address" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_address'] or '' !!}" style="width:225px;"  maxlength="255"/>
                                <label for="add">Insured Address</label>
                            </span>
                            <span>
                                <input id="p_m_city" name="p_m_city" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_city'] or '' !!}" style="width:200px;" maxlength="255" />
                                <label for="city">Insured City</label>
                            </span>
                            <span>
                                <input id="p_m_state" name="p_m_state" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_state'] or '' !!}"  style="width:80px;" maxlength="255" />
                                <label for="state">Insured State</label>
                            </span>
                            <span>
                                <input id="p_m_zip" name="p_m_zip" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_zip'] or '' !!}" style="width:80px;" maxlength="255" />
                                <label for="zip">Insured Zip Code </label>
                            </span>
                        </div>
                        <div></div>
                    </li>    
                </ul>
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <select id="p_m_ins_type" name="p_m_ins_type" class="field text addr tbox" onchange="update_insurance_type()" maxlength="255" style="width:200px;" />
                                    <option value=""></option>
                                    <option value="1" {!! (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '1') ? 'selected' : '' !!}>Medicare</option>
                                    <option value="2" {!! (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '2') ? 'selected' : '' !!}>Medicaid</option>
                                    <option value="3" {!! (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '3') ? 'selected' : '' !!}>Tricare Champus</option>
                                    <option value="4" {!! (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '4') ? 'selected' : '' !!}>Champ VA</option>
                                    <option value="5" {!! (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '5') ? 'selected' : '' !!}>Group Health Plan</option>
                                    <option value="6" {!! (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '6') ? 'selected' : '' !!}>FECA BLKLUNG</option>
                                    <option value="7" {!! (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '7') ? 'selected' : '' !!}>Other</option>
                                </select>
                                <label for="home_phone">Insurance Type</label>
                            </span>
                            <span>
                                <input class="p_m_ins_ass" id="p_m_ins_ass_yes" type="radio" name="p_m_ins_ass" value="Yes" {!! (!empty($patientInfo['p_m_ins_ass']) && $patientInfo['p_m_ins_ass'] == 'Yes') ? 'checked' : '' !!}>Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="p_m_ins_ass pay_to_patient_radio" id="p_m_ins_ass_no" type="radio" name="p_m_ins_ass" value="No" {!! (!empty($patientInfo['p_m_ins_ass']) && $patientInfo['p_m_ins_ass'] == 'No') ? 'checked' : '' !!}>Payment to Patient
                            </span>
                            <span style="float:right">

                                @if (empty($showBlock['insuranceCardImage10']))
                                    <button id="p_m_ins_card" onclick="loadPopup('/manage/add_image/10/patinfo/0'{!! !empty($patientId) ? '/' . $patientId : '' !!}{!! !empty($sh) ? '/' . $sh : '' !!});return false;" class="addButton">
                                        + Add Insurance Card Image
                                    </button>
                                @else
                                    <button id="p_m_ins_card" onclick="window.open('/manage/display_file{!! !empty($image10->image_file) ? '/' . $image10->image_file : '' !!}','welcome','width=800,height=400,scrollbars=yes'); return false;" class="addButton">
                                        View Insurance Card Image
                                    </button>
                                @endif

                            </span>
                        </div>
                        <div></div>
                    </li>
                </ul>
                <ul>
                    <li id="foli8" class="complex"> 
                        <div>
                            <span>
                                <select id="p_m_ins_co" name="p_m_ins_co" class="field text addr tbox" maxlength="255" onchange="updateNumber('p_m_ins_phone');" style="width:200px;" />
                                    <option value="">Select Insurance Company</option>

                                    @if (!empty($insuranceContacts))
                                        @foreach ($insuranceContacts as $insuranceContact)
                                            <option value="{!! $insuranceContact->contactid !!}" {!! (!empty($patientInfo['p_m_ins_co']) && $patientInfo['p_m_ins_co'] == $insuranceContact->contactid) ? 'selected' : '' !!}>{!! $insuranceContact->company !!}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="p_m_ins_co">Insurance Co.</label><br />
                                <input type="button" class="button" style="width:215px;" onclick='loadPopupRefer("/manage/add_contact", "{\"from_id\": \"p_m_ins_co\", \"from\": \"add_patient\", \"ctype\": \"ins\", \"type\": \"11\", \"ctypeeq\": \"1\", \"activePat\": \"{!! $patientId or '' !!}\"}", "{!! csrf_token() !!}");' value="+ Create New Insurance Company" />
                            </span>
                            <span>
                                <input id="p_m_party" name="p_m_ins_id" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_ins_id'] or '' !!}" maxlength="255" style="width:190px;" />
                                <label for="home_phone">Insurance ID.</label>
                            </span>
                            <span>
                        
                                @if (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '1')
                                    <input id="p_m_ins_grp" name="p_m_ins_grp" type="text" class="field text addr tbox" value="NONE" readonly maxlength="255" style="width:100px;" />
                                @else
                                    <input id="p_m_ins_grp" name="p_m_ins_grp" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_ins_grp'] or '' !!}" maxlength="255" style="width:100px;" />
                                @endif

                                <label for="home_phone">Group #</label>
                            </span>
                            <span>

                                @if (!empty($patientInfo['p_m_ins_type']) && $patientInfo['p_m_ins_type'] == '1')
                                    <input id="p_m_ins_plan" name="p_m_ins_plan" type="text" class="field text addr tbox" readonly maxlength="255" style="width:200px;" />
                                @else
                                    <input id="p_m_ins_plan" name="p_m_ins_plan" type="text" class="field text addr tbox" value="{!! $patientInfo['p_m_ins_plan'] or '' !!}" maxlength="255" style="width:200px;" />
                                @endif

                                <label for="home_phone">Plan Name</label>
                            </span>
                            <span>
                                <textarea id="p_m_ins_phone" name="p_m_ins_phone" class="field text addr tbox" disabled="disabled" style="width:190px;height:60px;background:#ccc;"></textarea>
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
                                <input type="radio" value="Yes" {!! (isset($patientInfo['has_s_m_ins']) && $patientInfo['has_s_m_ins'] == "Yes") ? 'checked' : '' !!} name="s_m_ins" onclick="$('.s_m_ins_div').show();" /> Yes
                                <input type="radio" value="No" {!! (isset($patientInfo['has_s_m_ins']) && $patientInfo['has_s_m_ins'] != "Yes") ? 'checked' : '' !!} name="s_m_ins" onclick="$('.s_m_ins_div').hide(); $('#s_m_address_fields').hide(); clearInfo();" /> No
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>

        @if (!empty($showBlock['insuranceCo']))
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    Insurance Co.
                    <input type="text" id="s_m_ins_payer_name" onclick="updateval(this)" autocomplete="off" name="s_m_ins_payer_name" value="{!! !empty($patientInfo['s_m_eligible_payer_id']) ? $patientInfo['s_m_eligible_payer_id'] . ' - ' . $patientInfo['s_m_eligible_payer_name'] : 'Type insurance payer name' !!}" style="width:300px;" />
                    <br />
                    <div id="s_m_ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                        <ul id="s_m_ins_payer_list" class="search_list">
                            <li class="template" style="display:none"></li>
                        </ul>
                    </div>
                    <input type="hidden" name="s_m_eligible_payer" id="s_m_eligible_payer" value="{!! $patientInfo['s_m_eligible_payer_id'] or '' !!} - {!! $patientInfo['s_m_eligible_payer_name'] or '' !!}" />
                </td>
            </tr>
        @endif

        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex"> 
                        <label class="desc s_m_ins_div" id="title0" for="Field0"  {!! (!empty($patientInfo['has_s_m_ins']) && $patientInfo['has_s_m_ins'] != "Yes") ? 'style="display:none;"' : '' !!}>
                            Secondary Medical  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            @if (!empty($exclusiveBilling))
                                {!! $nameBilling . ' filing insurance' !!}
                            @else
                                <a onclick="return false;" class="plain" title="Select YES if you would like {!! $nameBilling !!} to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended).">{!! $nameBilling !!} filing insurance?</a>
                                <input id="s_m_dss_file_yes" type="radio" class="dss_file_radio" name="s_m_dss_file" value="1" {!! (!empty($patientInfo['s_m_dss_file']) && $patientInfo['s_m_dss_file'] == '1') ? 'checked' : '' !!}>Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                <input id="s_m_dss_file_no" type="radio" class="dss_file_radio" name="s_m_dss_file" value="2" {!! (!empty($patientInfo['s_m_dss_file']) && $patientInfo['s_m_dss_file'] == '2') ? 'checked' : '' !!}>No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @endif

                            <a onclick="return false" class="plain" title="Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO.">Insured Address same as Pt. address?</a>
                            <input type="radio" onclick="$('#s_m_address_fields').hide();" name="s_m_same_address" value="1" {!! (!empty($patientInfo['s_m_same_address']) && $patientInfo['s_m_same_address'] == '1') ? 'checked' : '' !!}> Yes
                            <input type="radio" onclick="$('#s_m_address_fields').show();" name="s_m_same_address" value="2" {!! (!empty($patientInfo['s_m_same_address']) && $patientInfo['s_m_same_address'] == '2') ? 'checked' : '' !!}> No
                        </label>
                        <div class="s_m_ins_div" {!! (!empty($patientInfo['has_s_m_ins']) && $patientInfo['has_s_m_ins'] != "Yes") ? 'style="display:none;"' : '' !!}>
                            <span>
                                <select id="s_m_relation" name="s_m_relation" class="field text addr tbox" style="width:200px;">
                                    <option value="" {!! (!empty($patientInfo['s_m_relation']) && $patientInfo['s_m_relation'] == '') ? 'selected' : '' !!}>None</option>
                                    <option value="Self" {!! (!empty($patientInfo['s_m_relation']) && $patientInfo['s_m_relation'] == 'Self') ? 'selected' : '' !!}>Self</option>
                                    <option value="Spouse" {!! (!empty($patientInfo['s_m_relation']) && $patientInfo['s_m_relation'] == 'Spouse') ? 'selected' : '' !!}>Spouse</option>
                                    <option value="Child" {!! (!empty($patientInfo['s_m_relation']) && $patientInfo['s_m_relation'] == 'Child') ? 'selected' : '' !!}>Child</option>
                                    <option value="Other" {!! (!empty($patientInfo['s_m_relation']) && $patientInfo['s_m_relation'] == 'Other') ? 'selected' : '' !!}>Other</option>
                                </select>
                                <label for="work_phone">Relationship to insured party</label>
                            </span>
                            <span>
                                <input id="s_m_partyfname" name="s_m_partyfname" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_partyfname'] or '' !!}" maxlength="255" style="width:150px;" />
                                <input id="s_m_partymname" name="s_m_partymname" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_partymname'] or '' !!}" maxlength="255" style="width:50px;" />
                                <input id="s_m_partylname" name="s_m_partylname" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_partylname'] or '' !!}" maxlength="255" style="width:150px;" />
                                <label for="s_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
                            <span>
                                <input id="ins2_dob" name="ins2_dob" type="text" class="field text addr tbox calendar" value="{!! $patientInfo['ins2_dob'] or '' !!}" maxlength="255" style="width:150px;" onChange="validateDate('ins2_dob');" />
                                <label for="ins2_dob">Insured Date of Birth</label>
                            </span>
                            <span>
                                <select name="s_m_gender" id="s_m_gender" class="field text addr tbox" style="width:100px;" >
                                    <option value="">Select</option>
                                    <option value="Male" {!! (!empty($patinetInfo['s_m_gender']) && $patinetInfo['s_m_gender'] == 'Male') ? 'selected' : '' !!}>Male</option>
                                    <option value="Female" {!! (!empty($patinetInfo['s_m_gender']) && $patinetInfo['s_m_gender'] == 'Female') ? 'selected' : '' !!}>Female</option>
                                </select>
                                <span id="req_0" class="req">*</span>
                                <label for="gender">Insured Gender</label>
                            </span>
                        </div>
                        <div></div>
                    </li>
                </ul>
                <ul id="s_m_address_fields" {!! ($patientInfo['s_m_same_address'] == "1" || !empty($patientInfo['has_s_m_ins']) && $patientInfo['has_s_m_ins'] != "Yes") ? 'style="display:none;"':''; !!}>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input id="s_m_address" name="s_m_address" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_address'] or '' !!}" style="width:225px;"  maxlength="255"/>
                                <label for="add">Insured Address</label>
                            </span>
                            <span>
                                <input id="s_m_city" name="s_m_city" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_city'] or '' !!}" style="width:200px;" maxlength="255" />
                                <label for="city">Insured City</label>
                            </span>
                            <span>
                                <input id="s_m_state" name="s_m_state" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_state'] or '' !!}"  style="width:80px;" maxlength="255" />
                                <label for="state">Insured State</label>
                            </span>
                            <span>
                                <input id="s_m_zip" name="s_m_zip" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_zip'] or '' !!}" style="width:80px;" maxlength="255" />
                                <label for="zip">Insured Zip Code </label>
                            </span>
                        </div>
                        <div></div>
                    </li>
                </ul>
                <ul>
                    <li id="foli8" class="complex">
                        <div  class="s_m_ins_div" {!! (!empty($patientInfo['has_s_m_ins']) && $patientInfo['has_s_m_ins'] != "Yes") ? 'style="display:none;"' : '' !!}>
                            <span>
                                <select id="s_m_ins_type" name="s_m_ins_type" onchange="checkMedicare()" class="field text addr tbox" maxlength="255" style="width:200px;" />
                                    <option value=""></option>
                                    <option value="1" {!! (!empty($patientInfo['s_m_ins_type']) && $patientInfo['s_m_ins_type'] == '1') ? 'selected' : '' !!}>Medicare</option>
                                    <option value="2" {!! (!empty($patientInfo['s_m_ins_type']) && $patientInfo['s_m_ins_type'] == '2') ? 'selected' : '' !!}>Medicaid</option>
                                    <option value="3" {!! (!empty($patientInfo['s_m_ins_type']) && $patientInfo['s_m_ins_type'] == '3') ? 'selected' : '' !!}>Tricare Champus</option>
                                    <option value="4" {!! (!empty($patientInfo['s_m_ins_type']) && $patientInfo['s_m_ins_type'] == '4') ? 'selected' : '' !!}>Champ VA</option>
                                    <option value="5" {!! (!empty($patientInfo['s_m_ins_type']) && $patientInfo['s_m_ins_type'] == '5') ? 'selected' : '' !!}>Group Health Plan</option>
                                    <option value="6" {!! (!empty($patientInfo['s_m_ins_type']) && $patientInfo['s_m_ins_type'] == '6') ? 'selected' : '' !!}>FECA BLKLUNG</option>
                                    <option value="7" {!! (!empty($patientInfo['s_m_ins_type']) && $patientInfo['s_m_ins_type'] == '7') ? 'selected' : '' !!}>Other</option>
                                </select>
                                <label for="s_m_ins_type">Insurance Type</label>
                            </span>
                            <span>
                                <input id="s_m_ins_ass_yes" type="radio" name="s_m_ins_ass" value="Yes" {!! (!empty($patientInfo['s_m_ins_ass']) && $patientInfo['s_m_ins_ass'] == 'Yes') ? 'checked' : '' !!}>Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;
                                <input id="s_m_ins_ass_no pay_to_patient_radio" type="radio" name="s_m_ins_ass" value="No" {!! (!empty($patientInfo['s_m_ins_ass']) && $patientInfo['s_m_ins_ass'] == 'No') ? 'checked' : '' !!}>Payment to Patient
                            </span>
                            <span style="float:right">

                                @if (empty($showBlock['insuranceCardImage12']))
                                    <button id="s_m_ins_card" onclick="loadPopup('/manage/add_image/12/patinfo/0'{!! !empty($patientId) ? '/' . $patientId : '' !!}{!! !empty($sh) ? '/' . $sh : '' !!});return false;" class="addButton">
                                        + Add Insurance Card Image
                                    </button>
                                @else
                                    <button id="s_m_ins_card" onclick="window.open('imageholder/{!! $image12->image_file !!}','welcome','width=800,height=400,scrollbars=yes'); return false;" class="addButton">
                                        View Insurance Card Image
                                    </button>
                                @endif

                            </span>
                        </div>
                        <div></div>
                    </li>
                </ul>
                <ul>
                    <li id="foli8" class="complex"> 
                        <div class="s_m_ins_div" {!! (!empty($patientInfo['has_s_m_ins']) && $patientInfo['has_s_m_ins'] != "Yes") ? 'style="display:none;"' : '' !!}>
                            <span>
                                <select id="s_m_ins_co" name="s_m_ins_co" class="field text addr tbox" maxlength="255" style="width:200px;" onchange="updateNumber2('s_m_ins_phone')" />
                                    <option value="">Select Insurance Company</option>

                                    @if (!empty($insuranceContacts))
                                        @foreach ($insuranceContacts as $insuranceContact)
                                            <option value="{!! $insuranceContact->contactid !!}" {!! (!empty($patientInfo['s_m_ins_co']) && $patientInfo['s_m_ins_co'] == $insuranceContact->contactid) ? 'selected' : '' !!}>{!! $insuranceContact->company !!}</option>
                                        @endforeach
                                    @endif

                                </select>
                                <label for="s_m_ins_co">Insurance Co.</label><br />
                                <input type="button" class="button" style="width:215px;" onclick='loadPopupRefer("/manage/add_contact", "{\"from_id\": \"s_m_ins_co\", \"from\": \"add_patient\", \"ctype\": \"ins\", \"type\": \"11\", \"ctypeeq\": \"1\", \"activePat\": \"{!! $patientId or '' !!}\"}", "{!! csrf_token() !!}");' value="+ Create New Insurance Company" />
                            </span>
                            <span>
                                <input id="s_m_party" name="s_m_ins_id" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_ins_id'] or '' !!}" maxlength="255" style="width:190px;" />
                                <label for="s_m_ins_id">Insurance ID.</label>
                            </span>
                            <span>
                                <input id="s_m_ins_grp" name="s_m_ins_grp" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_ins_grp'] or '' !!}" maxlength="255" style="width:100px;" />
                                <label for="s_m_ins_grp">Group #</label>
                            </span>
                            <span>
                                <input id="s_m_ins_plan" name="s_m_ins_plan" type="text" class="field text addr tbox" value="{!! $patientInfo['s_m_ins_plan'] or '' !!}" maxlength="255" style="width:200px;" />
                                <label for="s_m_ins_plan">Plan Name</label>
                            </span>
                            <span>
                                <textarea id="s_m_ins_phone" name="s_m_ins_phone" type="text" class="field text addr tbox" disabled="disabled" style="width:190px;height:60px;background:#ccc;"></textarea>
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
                                <input type="button" class="button" style="float:left; width:150px;" onclick='loadPopupRefer("/manage/add_contact", "{\"from\": \"add_patient\"}", "{!! csrf_token() !!}");' value="+ Create New Contact" />
                            </span>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Primary Care MD</label>
                                    <div id="docpcp_static_info" style="{!! (!empty($patientInfo['docpcp'])) ? '' : 'display:none' !!}">
                                        <span id="docpcp_name_static" style="width:300px;">{!! $docpcpName or '' !!}</span>
                                        <a href="#" onclick="loadPopup('view_contact{!! !empty($patientInfo['docpcp']) ? '/' . $patientInfo['docpcp'] : '' !!}');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docpcp_static_info').hide();$('#docpcp_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docpcp_name" style="width:300px;{!! (!empty($patientInfo['docpcp']) && $patientInfo['docpcp'] != '') ? 'display:none;' : '' !!}" onclick="updateval(this)" autocomplete="off" name="docpcp_name" value="{!! !empty($docpcpName) ? $docpcpName : 'Type contact name' !!}" />
                                    <br />
                                    <div id="docpcp_hints" class="search_hints" style="display:none;">
                                        <ul id="docpcp_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docpcp" id="docpcp" value="{!! $patientInfo['docpcp'] or '' !!}" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr height="35">
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">ENT</label>
                                    <div id="docent_static_info" style="{!! (!empty($patientInfo['docent'])) ? '' : 'display:none' !!}">
                                        <span id="docent_name_static" style="width:300px;">{!! $docentName or '' !!}</span>
                                        <a href="#" onclick="loadPopup('view_contact{!! !empty($patientInfo['docent']) ? '/' . $patientInfo['docent'] : '' !!}');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docent_static_info').hide();$('#docent_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docent_name" style="width:300px;{!! (!empty($patientInfo['docent'])) ? 'display:none' : '' !!}" onclick="updateval(this)" autocomplete="off" name="docent_name" value="{!! (!empty($patientInfo['docent'])) ? $docentName : 'Type contact name' !!}" />
                                    <br />
                                    <div id="docent_hints" class="search_hints" style="display:none;">
                                        <ul id="docent_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docent" id="docent" value="{!! $patientInfo['docent'] or '' !!}" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr height="35">
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Sleep MD</label>
                                    <div id="docsleep_static_info" style="{!! (!empty($patientInfo['docdentist'])) ? '' : 'display:none' !!}">
                                        <span id="docsleep_name_static" style="width:300px;">{!! $docsleepName or '' !!}</span>
                                        <a href="#" onclick="loadPopup('view_contact{!! !empty($patientInfo['docsleep']) ? '/' . $patientInfo['docsleep'] : '' !!}');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docsleep_static_info').hide();$('#docsleep_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docsleep_name" style="width:300px;{!! (!empty($patientInfo['docdentist'])) ? 'display:none' : '' !!}" onclick="updateval(this)" autocomplete="off" name="docsleep_name" value="{!! !empty($docsleepName) ? $docsleepName : 'Type contact name' !!}" />
                                    <br />
                                    <div id="docsleep_hints" class="search_hints" style="display:none;">
                                        <ul id="docsleep_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docsleep" id="docsleep" value="{!! $patientInfo['docsleep'] or '' !!}" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr height="35"> 
                        <td> 
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Dentist</label>
                                    <div id="docdentist_static_info" style="{!! !empty($patientInfo['docdentist']) ? '' : 'display:none' !!}">
                                        <span id="docdentist_name_static" style="width:300px;">{!! $docdentistName or '' !!}</span>
                                        <a href="#" onclick="loadPopup('view_contact{!! !empty($patientInfo['docdentist']) ? '/' . $patientInfo['docdentist'] : '' !!}');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docdentist_static_info').hide();$('#docdentist_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docdentist_name" style="width:300px;{!! !empty($patientInfo['docdentist']) ? 'display:none' : '' !!}" onclick="updateval(this)" autocomplete="off" name="docdentist_name" value="{!! !empty($docdentistName) ? $docdentistName : 'Type contact name' !!}" />
                                    <br />
                                        <div id="docdentist_hints" class="search_hints" style="display:none;">
                                            <ul id="docdentist_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
                                            </ul>
                                        </div>
                                    <input type="hidden" name="docdentist" id="docdentist" value="{!! $patientInfo['docdentist'] or '' !!}" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr height="35"> 
                        <td> 
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Other MD</label>
                                    <div id="docmdother_static_info" style="{!! !empty($patientInfo['docmdother']) ? '' : 'display:none;' !!}height:25px;">
                                        <span id="docmdother_name_static" style="width:300px;">{!! $docmdotherName or '' !!}</span>
                                        <a href="#" onclick="loadPopup('view_contact{!! !empty($patientInfo['docmdother']) ? '/' . $patientInfo['docmdother'] : '' !!}');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docmdother_static_info').hide();$('#docmdother_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docmdother_name" style="width:300px;{!! !empty($patientInfo['docmdother']) ? 'display:none' : '' !!}" onclick="updateval(this)" autocomplete="off" name="docmdother_name" value="{!! !empty($patientInfo['docmdother']) ? $docmdotherName : 'Type contact name' !!}" />
                                    
                                    @if ($patientInfo['docmdother2'] == '' || $patientInfo['docmdother3'] == '')
                                        <a href="#" id="add_new_md" onclick="add_md(); return false;"  style="clear:both" class="addButton">+ Add Additional MD</a>
                                    @endif
                                    
                                    <br />
                                    <div id="docmdother_hints" class="search_hints" style="display:none;">
                                        <ul id="docmdother_list" class="search_list">
                                                <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docmdother" id="docmdother" value="{!! $patientInfo['docmdother'] or '' !!}" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr height="35" id="docmdother2_tr" {!! empty($docmdother2) ? 'style="display:none;"' : '' !!}>
                        <td>
                            <ul>
                                <li  id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Other MD 2</label>
                                    <div id="docmdother2_static_info" style="{!! !empty($patientInfo['docmdother2']) ? '' : 'display:none' !!}">
                                        <span id="docmdother2_name_static" style="width:300px;">{!! $docmdother2Name or '' !!}</span>
                                        <a href="#" onclick="loadPopup('view_contact{!! !empty($patientInfo['docmdother2']) ? '/' . $patientInfo['docmdother2'] : '' !!}');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docmdother2_static_info').hide();$('#docmdother2_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docmdother2_name" style="width:300px;{!! !empty($patientInfo['docmdother2']) ? 'display:none' : '' !!}" onclick="updateval(this)" autocomplete="off" name="docmdother2_name" value="{!! !empty($patientInfo['docmdother2']) ? docmdother2Name : 'Type contact name' !!}" />
                                    <br />
                                    <div id="docmdother2_hints" class="search_hints" style="display:none;">
                                        <ul id="docmdother2_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docmdother2" id="docmdother2" value="{!! $patientInfo['docmdother2'] or '' !!}" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr height="35" id="docmdother3_tr" {!! empty($docmdother3) ? 'style="display:none;"' : '' !!}>
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Other MD 3</label>
                                    <div id="docmdother3_static_info" style="{!! !empty($patientInfo['docmdother3']) ? '' : 'display:none' !!}">
                                        <span id="docmdother3_name_static" style="width:300px;">{!! $docmdother3Name or '' !!}</span>
                                        <a href="#" onclick="loadPopup('view_contact{!! !empty($patientInfo['docmdother3']) ? '/' . $patientInfo['docmdother3'] : '' !!}');return false;" class="addButton">Quick View</a>                                     
                                        <a href="#" onclick="$('#docmdother3_static_info').hide();$('#docmdother3_name').show();return false;" class="addButton">Change Contact</a>                          
                                    </div>
                                    <input type="text" id="docmdother3_name" style="width:300px;{!! !empty($patientInfo['docmdother3']) ? 'display:none' : '' !!}" onclick="updateval(this)" autocomplete="off" name="docmdother3_name" value="{!! !empty($patientInfo['docmdother3']) ? $docmdother3Name : 'Type contact name' !!}" />
                                    <br />
                                    <div id="docmdother3_hints" class="search_hints" style="display:none;">
                                        <ul id="docmdother3_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docmdother3" id="docmdother3" value="{!! $patientInfo['docmdother3'] or '' !!}" />
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
                <select name="status" id="status" class="tbox" onchange="updatePPAlert()";>
                    <option value="1" {!! (!empty($patientInfo['status']) && $patientInfo['status'] == 1) ? 'selected' : '' !!}>Active</option>
                    <option value="2" {!! (!empty($patientInfo['status']) && $patientInfo['status'] == 2) ? 'selected' : '' !!}>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>

        @if (!empty($docPatientPortal))
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Portal Status<br />
                    <span id="ppAlert" style="font-weight:normal;font-size:12px; {!! (!empty($patientInfo['status']) && $patientInfo['status'] == 2) ? '' : 'display:none;' !!}">Patient is in-active and will not be able to access<br />Patient Portal regardless of the setting of this field.</span>
                </td>
                <td valign="top" class="frmdata">
                    <select name="use_patient_portal" class="tbox" >
                        <option value="1" {!! (!empty($patientInfo['use_patient_portal']) && $patientInfo['use_patient_portal'] == 1) ? 'selected' : '' !!}>Active</option>
                        <option value="0" {!! (!empty($patientInfo['use_patient_portal']) && $patientInfo['use_patient_portal'] == 0) ? 'selected' : '' !!}>In-Active</option>
                    </select>
                    <br />&nbsp;
                </td>
            </tr>
        @endif

        <tr>
            <td valign="top">

                @if (empty($showBlock['introLetter']))
                    <input id="introletter" name="introletter" type="checkbox" value="1"> Send Intro Letter to DSS patient
                @else
                    {!! $showBlock['introLetter'] !!}
                @endif

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <span class="red">
                    * Required Fields         
                </span><br />
                <input type="hidden" name="patientsub" value="1" />
                <input type="hidden" name="ed" value="{!! $patientRequestId !!}" />
                <input type="submit" value=" {!! $butText !!} Patient" class="button" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
</form>

@stop

@section('footer')
    @parent

    <div id="popupRefer" style="height:550px; width:750px;">
        <a id="popupReferClose">
            <button>X</button>
        </a>
        <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopupRef"></div>
@stop