<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/jquery-ui-1.8.22.custom.min.js') !!}
        {!! HTML::script('/js/3rdParty/jquery.maskedinput-1.3.min.js') !!}
        {!! HTML::script('/js/manage/modal.js') !!}
        {!! HTML::script('/js/manage/staff.js') !!}
        {!! HTML::script('/js/manage/top.js') !!}
        {!! HTML::script('/js/manage/validation.js') !!}
        {!! HTML::script('/js/manage/masks.js') !!}
        {!! HTML::script('/js/manage/wufoo.js') !!}
        {!! HTML::script('js/admin/popup.js') !!}

        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}
        {!! HTML::style('/css/manage/modal.css') !!}
        {!! HTML::style('/css/manage/jquery-ui-1.8.22.custom.css') !!}

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

        <br />
        <br />

        @if (!empty($message))
            <div align="center" class="red">
                {!! $message !!}
            </div>
        @endif

        <form name="stafffrm" action="/manage/add_staff{!! !empty($getTypeUsers['userid']) ? '/' . $getTypeUsers['userid'] : '' !!}" method="post" onSubmit="return staffabc(this)">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <input type="hidden" name="add" value="1" />
                <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}">
                <tr>
                    <td colspan="2" class="cat_head">

                        @if (!empty($buttonText))
                            {!! $buttonText !!} Staff

                            @if (!empty($getTypeUsers['username']))
                                &quot;{!! $getTypeUsers['username'] !!}&quot;
                            @endif
                        @endif
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Username
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="username" value="{!! $getTypeUsers['username'] or '' !!}" class="tbox" />
                        <span class="red">*</span>
                    </td>
                </tr>

                @if (count($getTypeUsers) < 1)
                    <tr bgcolor="#FFFFFF">
                        <td valign="top" class="frmhead">
                            Password
                        </td>
                        <td valign="top" class="frmdata">
                            <input type="text" name="password" value="{!! $getTypeUsers['password'] or '' !!}" class="tbox" />
                            <span class="red">*</span>
                        </td>
                    </tr>
                @endif

                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        First Name
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="first_name" value="{!! $getTypeUsers['first_name'] or '' !!}" class="tbox" />
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Last Name
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="last_name" value="{!! $getTypeUsers['last_name'] or '' !!}" class="tbox" />
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Email
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="email" value="{!! $getTypeUsers['email'] or '' !!}" class="tbox" />
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        Dentist/Producer <div id="dp_info" class="info_but"></div>
                        <div id="dp_info_modal" class="info_modal" title="Dentist/Producer explanation">
                            Check this box if the user you are creating is a licensed dentist and requires the ability to bill MEDICAL procedures under their own name or NPI/TaxID number.
                        </div>
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" {!! (!empty($getTypeUsers['producer']) && $getTypeUsers['producer'] == 1) ? "checked" : '' !!} value="1" id="producer" name="producer" />
                    </td>
                </tr>
                <tr class="producer_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                       Producer bills insurance under their name?
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" {!! count($getTypeUsers['producer_files']) && $getTypeUsers['producer_files'] == 1 ? "checked" : '' !!} value="1" id="producer_files" name="producer_files" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor"#ffffff;">
                    <td colspan="2">
                        Fields left blank below will default to the standard billing settings for your office.
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        NPI
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="npi" value="{!! $getTypeUsers['npi'] or '' !!}" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Medicare Provider (NPI/DME) Number
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="medicare_npi" value="{!! $getTypeUsers['medicare_npi'] or '' !!}" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Medicare PTAN Number
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="medicare_ptan" value="{!! $getTypeUsers['medicare_ptan'] or '' !!}" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Tax ID or SSN
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="tax_id_or_ssn" value="{!! $getTypeUsers['tax_id_or_ssn'] or '' !!}" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        EIN or SSN
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" {!! (!empty($getTypeUsers['ein']) && $getTypeUsers['ein'] == 1) ? "checked" : '' !!} value="1" name="ein" /> EIN
                        <input type="checkbox" {!! (!empty($getTypeUsers['ssn']) && $getTypeUsers['ssn'] == 1) ? "checked" : '' !!} value="1" name="ssn" /> SSN
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Practice
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="practice" value="{!! $getTypeUsers['practice'] or '' !!}" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Address
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="address" class="tbox" id="address" value="{!! $getTypeUsers['address'] or '' !!}" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        City
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="city" type="text" value="{!! $getTypeUsers['city'] or '' !!}" name="city" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        State
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="state" type="text" value="{!! $getTypeUsers['state'] or '' !!}" name="state" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Zip
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="zip" type="text" name="zip" value="{!! $getTypeUsers['zip'] or '' !!}" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Phone
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="phone" type="text" name="phone" value="{!! $getTypeUsers['phone'] or '' !!}" class="tbox" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        Sign Progress Notes / Order HST? <div id="spn_info" class="info_but"></div>
                        <div id="spn_info_modal" class="info_modal" title="Sign Progress Notes explanation">
                            Check this box if this user is legally allowed to sign progress notes and/or order Home Sleep Tests (HST). In most cases, this means the user must be a licensed dentist. After checking this box, the user will be able to legally sign patient progress notes that will become permanently associated with patient charts, as well as submit Home Sleep Test (HST) order requests.
                        </div>
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" {!! (!empty($getTypeUsers['sign_notes']) && $getTypeUsers['sign_notes'] == 1) ? "checked" : '' !!} value="1" name="sign_notes" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                    Use Course?
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" {!! (!empty($getTypeUsers['use_course']) && $getTypeUsers['use_course'] == 1) ? "checked" : '' !!} value="1" name="use_course" />
                    </td>
                </tr>

                @if ($docId == $userId || $getTypeUsersId['manage_staff'] == 1)
                    <tr>
                        <td valign="top" class="frmhead">
                            Manage Staff/Codes? <div id="ms_info" class="info_but"></div>
                            <div id="ms_info_modal" class="info_modal" title="Manage Staff explanation">
                                Check this box if you want this user to be able to add or edit the staff in your account. User will also be able to add/edit insurance transaction codes and associated fees. You should ONLY check this box for office managers or other staff qualified to alter insurance codes and add or delete software accounts.
                            </div>
                        </td>
                        <td valign="top" class="frmdata">
                            <input type="checkbox" {!! (!empty($getTypeUsers['manage_staff']) && $getTypeUsers['manage_staff'] == 1) ? "checked" : '' !!} value="1" name="manage_staff" />
                        </td>
                    </tr>
                @endif

                <tr>
                    <td valign="top" class="frmhead">
                        Post Ledger Adjustments? <div id="pla_info" class="info_but"></div>
                        <div id="pla_info_modal" class="info_modal" title="Post Ledger Adjustments explanation">
                            Select this option if the user should be allowed to post adjustments to a patient ledger.  If this option is not checked, the user will still be able to see the patient ledger, but will not be able to post or edit any adjustments.
                        </div>
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" {!! (!empty($getTypeUsers['post_ledger_adjustments']) && $getTypeUsers['post_ledger_adjustments'] == 1) ? "checked" : '' !!} value="1" name="post_ledger_adjustments" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        Edit Ledger Entries? <div id="ele_info" class="info_but"></div>
                        <div id="ele_info_modal" class="info_modal" title="Edit Ledger Entries explanation">
                            Select this option if the user is allowed to edit (make changes to) ledger entries in a patient ledger.  If this option is not checked, the user will still be able to see the patient ledger, but will not be able to edit or change any type of ledger entry.
                        </div> 
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" {!! (!empty($getTypeUsers['edit_ledger_entries']) && $getTypeUsers['edit_ledger_entries'] == 1) ? "checked" : '' !!} value="1" name="edit_ledger_entries" />
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Status <div id="s_info" class="info_but"></div>
                        <div id="s_info_modal" class="info_modal" title="Status explanation">
                            Change the status of this user account here. ACTIVE staff will have full access to the software, INACTIVE staff are prohibited from accessing the software, but all their user activity will be stored for future review. If an employee has left your organization, or you want to prohibit an employee from accessing your software then choose INACTIVE.
                        </div>
                    </td>
                    <td valign="top" class="frmdata">
                        <select name="status" class="tbox">
                            <option value="1" {!! ($getTypeUsers['status'] == "1") ? "selected" : '' !!}>Active</option>
                            <option value="2" {!! ($getTypeUsers['status'] == "2") ? "selected" : '' !!}>In-Active</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td  colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="staffsub" value="1" />
                        <input type="hidden" name="ed" value="{!! !empty($getTypeUsers['userid']) !!}" />
                        <input type="hidden" name="logins" value="{!! !empty($getTypeLoginsNumber) or '' !!}" />
                        <input type="submit" value="{!! $buttonText !!} Staff" class="button" />

                        <script type="text/javascript">
                            var deleteId    = "{!! $getTypeUsers['userid'] or '' !!}";
                            var countLogins = "{!! !empty($getTypeLoginsNumber) or '' !!}";
                        </script>

                        @if ($getTypeUsers['userid'] != '')
                            <a style="float:right;" href="#" class="dellink" target="_parent" title="DELETE" id="dellink";>
                                Delete
                            </a>
                        @endif
                    </td>
                </tr>
            </table>
        </form>

    </body>
</html>
