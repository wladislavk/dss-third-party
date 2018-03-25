<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/jquery-ui-1.8.22.custom.min.js') !!}
        {!! HTML::script('/js/manage/add_chairs.js') !!}
        {!! HTML::script('/js/manage/modal.js') !!}
        {!! HTML::script('/js/manage/top.js') !!}

        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}

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

        <form name="stafffrm" action="/manage/add_chairs{{ !empty($ed) ? '/' . $ed : '' }}" method="post" onSubmit="return staffabc(this)">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <tr>
                    <td colspan="2" class="cat_head">
                        {{ $buttonText }} Resource

                        @if (!empty($name))
                            &quot;{{ $name }}&quot;
                        @endif
                    </td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Resource Name
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="name" value="{{ $name or '' }}" class="tbox" />
                        <span class="red">*</span>
                    </td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Resource Rank
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="rank" value="{{ $rank or '' }}" class="tbox" />
                        <span class="red">*</span>
                    </td>
                </tr>

                <tr>
                    <td  colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="staffsub" value="1" />
                        <input type="hidden" name="ed" value="{{ $ed or '' }}" />
                        <input type="submit" value="{{ $buttonText }} Resource" class="button" />
                        <script type="text/javascript">
                            var deleteId    = '{{ $ed or '' }}';
                            var countLogins = "{{ $countLogins or '' }}";
                        </script>

                        @if (!empty($ed))
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
