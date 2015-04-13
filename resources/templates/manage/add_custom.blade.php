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
        <br /><br />
        <div align="center" class="red">
            @if (!empty($message))
                {!! $message !!}
            @endif
        </div>

        <form name="customfrm" action="/manage/add_custom{!! !empty($ed) ? '/' . $ed : '' !!}" method="post" onSubmit="return customabc(this)">
        <input type="hidden" name="add" value="1">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">
                        {!! $butText !!} Custom Text
                        @if (!empty($title))
                            &quot;{!! $title !!}&quot;
                        @endif
                    </td>
                </tr>

                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex"> 
                                <label class="desc" id="title0" for="Field0">
                                    Title:
                                    <span id="req_0" class="req">*</span>
                                </label>
                                <div>
                                    <span class="full">
                                         <input id="title" name="title" type="text" class="field text addr tbox" value="{!! $title or '' !!}" tabindex="5" style="width:600px;" maxlength="255"/>
                                    </span>
                                    <label>&nbsp;</label>
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
                                    Description:
                                    <span id="req_0" class="req">*</span>
                                </label>
                                <div>
                                    <span class="full">
                                        <textarea name="description" id="description" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;">{!! $description or '' !!}</textarea>
                                    </span>
                                    <label>&nbsp;</label>
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
                        <select name="status" class="tbox" tabindex="22">
                             <option value="1" {!! (!empty($status) && $status == "1") ? "selected" : '' !!}>Active</option>
                             <option value="2" {!! (!empty($status) && $status == "2") ? "selected" : '' !!}>In-Active</option>
                        </select>
                        <br />&nbsp;
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="customsub" value="1" />
                        <input type="hidden" name="ed" value="{!! $customid or '' !!}" />
                        <input type="submit" value="{!! $butText !!} Custom Text" class="button" />

                        @if (!empty($customid))
                            <a style="float:right;" href="/manage/custom/delid={!! $customid or '' !!}" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE" target="_parent">
                                Delete
                            </a>
                        @endif
                    </td>
                </tr>
            </table>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        </form>

    </body>
</html>
