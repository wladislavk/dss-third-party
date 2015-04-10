<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>

        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/3rdParty/jquery.maskedinput-1.3.min.js') !!}
        {!! HTML::script('/js/manage/validation.js') !!}
        {!! HTML::script('/js/manage/masks.js') !!}
        {!! HTML::script('/js/manage/wufoo.js') !!}
        {!! HTML::script('/js/manage/preferred_contact.js') !!}
        {!! HTML::script('/js/manage/check_elements.js') !!}
    </head>
    <body onload="check();">
        <br /><br />
        @if (!empty($message))
            <div align="center" class="red">
                {!! $message !!}
            </div>
        @endif
        <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return contactabc(this)">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">
                        {!! $butText !!} Contact "{!! $fcontacts->firstname or '' !!} {!! $fcontacts->middlename or '' !!} {!! $fcontacts->lastname or '' !!}"
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
                                        <select name="salutation" id="salutation" class="field text addr tbox" tabindex="1" style="width:80px;" >
                                            <option value=""></option>
                                            <option value="Dr." {!! ($fcontacts->salutation == 'Dr.') ? " selected" : '' !!}>Dr.</option>
                                            <option value="Mr." {!! ($fcontacts->salutation == 'Mr.') ? " selected" : '' !!}>Mr.</option>
                                            <option value="Mrs." {!! ($fcontacts->salutation == 'Mrs.') ? " selected" : '' !!}>Mrs.</option>
                                            <option value="Miss." {!! ($fcontacts->salutation == 'Miss.') ? " selected" : '' !!}>Miss.</option>
                                        </select>
                                        <label for="salutation">Salutation</label>
                                    </span>
                                    <span>
                                        <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="{!! $fcontacts->firstname !!}" tabindex="2" maxlength="255" />
                                        <label for="firstname">First Name</label>
                                    </span>
                                    <span>
                                        <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="{!! $fcontacts->lastname !!}" tabindex="3" maxlength="255" />
                                        <label for="lastname">Last Name</label>
                                    </span>
                                    <span>
                                        <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="{!! $fcontacts->middlename !!}" tabindex="4" style="width:50px;" maxlength="1" />
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
                                        <input id="company" name="company" type="text" class="field text addr tbox" value="{!! $fcontacts->company !!}" tabindex="5" style="width:575px;" maxlength="255"/>
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
                                        <input id="add1" name="add1" type="text" class="field text addr tbox" value="{!! $fcontacts->add1 !!}" tabindex="6" style="width:325px;"  maxlength="255"/>
                                        <label for="add1">Address1</label>
                                    </span>
                                    <span>
                                        <input id="add2" name="add2" type="text" class="field text addr tbox" value="{!! $fcontacts->add2 !!}" tabindex="7" style="width:325px;" maxlength="255" />
                                        <label for="add2">Address2</label>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <input id="city" name="city" type="text" class="field text addr tbox" value="{!! $fcontacts->city !!}" tabindex="8" style="width:200px;" maxlength="255" />
                                        <label for="city">City</label>
                                    </span>
                                    <span>
                                        <input id="state" name="state" type="text" class="field text addr tbox" value="{!! $fcontacts->state !!}" tabindex="9" style="width:26px;" maxlength="2" />
                                        <label for="state">State</label>
                                    </span>
                                    <span>
                                        <input id="zip" name="zip" type="text" class="field text addr tbox" value="{!! $fcontacts->zip !!}" tabindex="10" style="width:80px;" maxlength="255" />
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
                                        <input id="phone1" name="phone1" type="text" class="field text addr tbox" value="{!! $fcontacts->phone1 !!}" tabindex="11" maxlength="255" style="width:200px;" />
                                        <label for="phone1">Phone 1</label>
                                    </span>
                                    <span>
                                        <input id="phone2" name="phone2" type="text" class="field text addr tbox" value="{!! $fcontacts->phone2 !!}" tabindex="12" maxlength="255" style="width:200px;" />
                                        <label for="phone2">Phone 2</label>
                                    </span>
                                    <span>
                                        <input id="fax" name="fax" type="text" class="field text addr tbox" value="{!! $fcontacts->fax !!}" tabindex="13" maxlength="255" style="width:200px;" />
                                        <label for="fax">Fax</label>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <input id="email" name="email" type="text" class="field text addr tbox" value="{!! $fcontacts->email !!}" tabindex="14" maxlength="255" style="width:325px;" />
                                        <label for="email">Email</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>

                </tr>
                <tr> 
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex"> 
                                <div>
                                    <span>
                                        <input id="greeting" name="greeting" type="text" class="field text addr tbox" value="{!! $fcontacts->greeting !!}" tabindex="18" maxlength="255" style="width:200px;" />
                                        <label for="greeting">Greeting</label>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <textarea name="sincerely" id="sincerely" class="field text addr tbox" tabindex="19">{!! $fcontacts->sincerely !!}</textarea>
                                        <label for="sincerely">Sincerely</label>
                                    </span>
                                    <span>
                                        <select id="contacttypeid" name="contacttypeid" class="field text addr tbox" tabindex="20">
                                            <option value="{!! $contactType['contacttype']!!}" selected=\"selected\">{!! $contactType['contacttype'] !!}</option>
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
                                        <textarea name="notes" id="notes" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;">{!! $fcontacts->notes !!}</textarea>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="contactsub" value="1" />
                        <input type="hidden" name="ed" value="{!! $fcontacts->contactid !!}" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
