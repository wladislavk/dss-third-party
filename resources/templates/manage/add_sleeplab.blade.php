<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>

        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/3rdParty/jquery.maskedinput-1.3.min.js') !!}
        {!! HTML::script('/js/manage/top.js') !!}
        {!! HTML::script('/js/manage/validation.js') !!}
        {!! HTML::script('/js/manage/masks.js') !!}
        {!! HTML::script('/js/manage/wufoo.js') !!}
        {!! HTML::script('/js/manage/preferred_contact.js') !!}
        {!! HTML::script('/js/manage/contact.js') !!}
        {!! HTML::script('/js/manage/add_sleeplab.js') !!}
        {!! HTML::script('js/admin/popup.js') !!}
    </head>

    <body>

        @if (!empty($closePopup))
            <script>
                parent.disablePopup1();
                loc = parent.window.location.href;
                loc = loc.replace("#", "");
                parent.window.location = loc;
            </script>
        @endif

        <form name="sleeplabfrm" action="/manage/sleeplab/add{!! !empty($ed) ? '/' . $ed : '' !!}" method="post" onSubmit="return sleeplababc(this)">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">
                       {!! $buttonText !!} Sleep Lab
                       @if (!empty($firstname) && !empty($lastname))
                            "{!! $firstname !!} {!! $lastname !!}"
                       @endif
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                <label class="desc" id="title0" for="Field0">
                                    <span>
                                        <span style="color:#000000">Lab Name</span>
                                        <span id="req_0" class="req">*</span>
                                        <input id="company" name="company" type="text" class="field text addr tbox" value="{!! $company or '' !!}" tabindex="1" style="width:575px;" maxlength="255">
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
                                    Name
                                </label>
                                <div>
                                    <span>
                                        @if (!empty($salutation))
                                            <select name="salutation" id="salutation" class="field text addr tbox" tabindex="1" style="width:80px;">
                                                <option value=""></option>
                                                <option value="Dr." {!! ($salutation == 'Dr.') ? " selected" : '' !!}>Dr.</option>
                                                <option value="Mr." {!! ($salutation == 'Mr.') ? " selected" : '' !!}>Mr.</option>
                                                <option value="Mrs." {!! ($salutation == 'Mrs.') ? " selected" : '' !!}>Mrs.</option>
                                                <option value="Miss." {!! ($salutation == 'Miss.') ? " selected" : '' !!}>Miss.</option>
                                            </select>
                                        @else
                                            <select name="salutation" id="salutation" class="field text addr tbox" tabindex="1" style="width:80px;">
                                                <option value=""></option>
                                                <option value="Dr.">Dr.</option>
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Miss.">Miss.</option>
                                            </select>
                                        @endif
                                        <label for="salutation">Salutation</label>
                                    </span>
                                    <span>
                                        <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="{!! $firstname or '' !!}" tabindex="2" maxlength="255" />
                                        <label for="firstname">First Name</label>
                                    </span>
                                    <span>
                                        <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="{!! $lastname or '' !!}" tabindex="3" maxlength="255" />
                                        <label for="lastname">Last Name</label>
                                    </span>
                                    <span>
                                        <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="{!! $lastname or '' !!}" tabindex="4" style="width:50px;" maxlength="1" />
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
                                    Address
                                    <span id="req_0" class="req"> * </span>
                                </label>
                                <div>
                                    <span>
                                        <input id="add1" name="add1" type="text" class="field text addr tbox" value="{!! $add1 or '' !!}" tabindex="6" style="width:325px;"  maxlength="255"/>
                                        <label for="add1">Address1</label>
                                    </span>
                                    <span>
                                        <input id="add2" name="add2" type="text" class="field text addr tbox" value="{!! $add2 or '' !!}" tabindex="7" style="width:325px;" maxlength="255" />
                                        <label for="add2">Address2</label>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <input id="city" name="city" type="text" class="field text addr tbox" value="{!! $city or '' !!}" tabindex="8" style="width:200px;" maxlength="255" />
                                        <label for="city">City</label>
                                    </span>
                                    <span>
                                        <input id="state" name="state" type="text" class="field text addr tbox" value="{!! $state or '' !!}" tabindex="9" style="width:80px;" maxlength="255" />
                                        <label for="state">State</label>
                                    </span>
                                    <span>
                                        <input id="zip" name="zip" type="text" class="field text addr tbox" value="{!! $zip or '' !!}" tabindex="10" style="width:80px;" maxlength="255" />
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
                                        <input id="phone1" name="phone1" type="text" class="extphonemask field text addr tbox" value="{!! $phone1 or '' !!}" tabindex="11" maxlength="255" style="width:200px;" />
                                        <label for="phone1">Phone 1</label>
                                    </span>
                                    <span>
                                        <input id="phone2" name="phone2" type="text" class="extphonemask field text addr tbox" value="{!! $phone2 or '' !!}" tabindex="12" maxlength="255" style="width:200px;" />
                                        <label for="phone2">Phone 2</label>
                                    </span>
                                    <span>
                                        <input id="fax" name="fax" type="text" class="extphonemask field text addr tbox" value="{!! $fax or '' !!}" tabindex="13" maxlength="255" style="width:200px;" />
                                        <label for="fax">Fax</label>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <input id="email" name="email" type="text" class="field text addr tbox" value="{!! $email or '' !!}" tabindex="14" maxlength="255" style="width:325px;" />
                                        <label for="email">Email</label>
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
                                        <textarea name="notes" id="notes" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;">{!! $notes or '' !!}</textarea>
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
                        @if (!empty($status))
                            <select name="status" class="tbox" tabindex="22">
                                <option value="1" {!! ($status == 1) ? " selected" : '' !!}>Active</option>
                                <option value="2" {!! ($status == 2) ? " selected" : '' !!}>In-Active</option>
                            </select>
                        @else
                            <select name="status" class="tbox" tabindex="22">
                                <option value="1">Active</option>
                                <option value="2">In-Active</option>
                            </select>
                        @endif
                        <br />&nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="sleeplabsub" value="1" />
                        <input type="hidden" name="ed" value="{!! $ed !!}" />
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}" id="token">
                        <a href="#" id="google_link" target="_blank" style="float:left;" />
                            Google
                        </a>
                        <input type="submit" value="{!! $buttonText !!} Sleep Lab" class="button" />
                        <script type="text/javascript">
                            var delid = '{!! $ed or '' !!}';
                        </script>
                        <a style="float:right;" href="#" class="dellink" target="_parent" title="DELETE" id="dellink";>
                            Delete
                        </a>
                    </td>
                </tr>
            </table>
        </form>

    </body>
</html>
