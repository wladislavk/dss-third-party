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
        {!! HTML::script('/js/manage/add_transaction_code.js') !!}
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

        <br />
        <br />

        @if (!empty($message))
            {!! $message !!}
        @endif

        <form name="transaction_codefrm" action="/manage/transaction_code/add" method="post" onSubmit="return transaction_codeabc(this)">
            <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}">
            <input type="hidden" name="add" value="1">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">

                        @if (!empty($butText))
                            {!! $butText !!} Transaction Code

                            @if (!empty($transactionsNum['transaction_code']))
                                &quot;{!! $transactionsNum['transaction_code'] !!}&quot;
                            @endif
                        @endif
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Transaction Code
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="transaction_code" value="{!! $transactionsNum['transaction_code'] or '' !!}" class="tbox" />
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Transaction Type
                    </td>
                    <td valign="top" class="frmdata">
                        <select name="type" class="tbox" />
                            <option value="1" <?php if(!empty($type) && $type == "1"){echo " selected='selected'";} ?>> Medical Code </option>
                            <option value="2" {!! (!empty($transactionsNum['type']) && $transactionsNum['type'] == "2") ? "selected" : '' !!}> Patient Payment Code </option>
                            <option value="3" {!! (!empty($transactionsNum['type']) && $transactionsNum['type'] == "3") ? "selected" : '' !!}> Insurance Payment Code </option>
                            <option value="4" {!! (!empty($transactionsNum['type']) && $transactionsNum['type'] == "4") ? "selected" : '' !!}> Diagnostic Code </option>
                            <option value="5" {!! (!empty($transactionsNum['type']) && $transactionsNum['type'] == "5") ? "selected" : '' !!}> Modifier Code </option>
                            <option value="6" {!! (!empty($transactionsNum['type']) && $transactionsNum['type'] == "6") ? "selected" : '' !!}> Adjustment Code </option>
                        </select>
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Place
                    </td>
                    <td valign="top" class="frmdata">
                        <select name="place" class="tbox" />
                            <option value=""></option>

                            @if (count($placeServices))
                                @foreach ($placeServices as $placeService)
                                    <option value="{!! $placeService->place_serviceid or '' !!}" {!! (!empty($transactionsNum['place']) && $transactionsNum['place'] == $placeService->place_serviceid) ? "selected" : '' !!}>
                                        {!! $placeService->place_service or '' !!} {!! $placeService->description or '' !!}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                       Default Modifier Code 1
                    </td>
                    <td valign="top" class="frmdata">
                        <select name="modifier_code_1" class="tbox" />
                            <option value=""></option>
                            
                            @if (count($modifierCodes))
                                @foreach ($modifierCodes as $modifierCode)
                                    <option value="{!! $modifierCode->modifier_code or '' !!}" {!! (!empty($transactionsNum['modifier_code_1']) && $transactionsNum['modifier_code_1'] == $modifierCode->modifier_code) ? "selected" : '' !!}>
                                        {!! $modifierCode->modifier_code !!} {!! $modifierCode->description !!}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Default Modifier Code 2
                    </td>
                    <td valign="top" class="frmdata">
                        <select name="modifier_code_2" class="tbox" />
                            <option value=""></option>

                                @if (count($modifierCodes))
                                    @foreach ($modifierCodes as $modifierCode)
                                        <option value="{!! $modifierCode->modifier_code or '' !!}" {!! (!empty($transactionsNum['modifier_code_2']) && $transactionsNum['modifier_code_2'] == $modifierCode->modifier_code) ? "selected" : '' !!}>
                                        {!! $modifierCode->modifier_code !!} {!! $modifierCode->description !!}
                                    </option>
                                    @endforeach
                                @endif
                        </select>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                       Default Days/Units
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="days_units" value="{!! $transactionsNum['days_units'] or '' !!}" class="tbox singlenumber" style="width:30px"/>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Sort By
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="sortby" value="{!! $transactionsNum['sortby'] or '' !!}" class="tbox" style="width:30px"/>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                       Price
                    </td>
                    <td valign="top" class="frmdata">
                        $<input type="text" name="amount" value="{!! $transactionsNum['amount'] or '' !!}" class="tbox" style="width:100px"/>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Status
                    </td>
                    <td valign="top" class="frmdata">
                        <select name="status" class="tbox">
                            <option value="1" {!! (!empty($transactionsNum['status']) && $transactionsNum['status'] == "1") ? "selected" : '' !!}>Active</option>
                            <option value="2" {!! (!empty($transactionsNum['status']) && $transactionsNum['status'] == "2") ? "selected" : '' !!}>In-Active</option>
                        </select>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Amount Adjustment
                    </td>
                    <td valign="top" class="frmdata">
                        <select name="amount_adjust" class="tbox">
                            <option value="DSS_AMOUNT_ADJUST_USER" {!! (!empty($transactionsNum['amount_adjust']) && $transactionsNum['amount_adjust'] == DSS_AMOUNT_ADJUST_USER) ? "selected" : '' !!}>{!! $dssAmountAdjustUser !!}</option>
                            <option value="DSS_AMOUNT_ADJUST_NEGATIVE" {!! (!empty($transactionsNum['amount_adjust']) && $transactionsNum['amount_adjust'] == DSS_AMOUNT_ADJUST_NEGATIVE) ? "selected" : '' !!}>{!! $dssAmountAdjustNegative !!}</option>
                            <option value="DSS_AMOUNT_ADJUST_POSITIVE" {!! (!empty($transactionsNum['amount_adjust']) && $transactionsNum['amount_adjust'] == DSS_AMOUNT_ADJUST_POSITIVE) ? "selected" : '' !!}>{!! $dssAmountAdjustPositive !!}</option>
                        </select>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Description
                    </td>
                    <td valign="top" class="frmdata">
                        <textarea class="tbox" name="description" style="width:100%;">{!! $transactionsNum['description'] or '' !!}</textarea>
                    </td>
                </tr>
                <tr>
                    <td  colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="transaction_codesub" value="1" />
                        <input type="hidden" name="ed" value="{!! $transactionsNum['transaction_codeid'] or '' !!}" />
                        <input type="submit" value="{!! $butText or '' !!} Transaction Code" class="button" />

                        <script type="text/javascript">
                            var delid = '{!! $transactionsNum['transaction_codeid'] or '' !!}';
                        </script>
                        
                        @if (count($transactionsNum))
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
