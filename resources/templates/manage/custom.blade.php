@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}
@stop

@section('content')

    <span class="admin_head">
        Manage Custom Text
    </span>
    <br />
    <br />
    &nbsp;

    <div align="right">
        <button style="margin-right:20px; float:right;" onclick="loadPopup('/manage/add_custom');" class="addButton">Add New Custom Text</button>
        &nbsp;&nbsp;
    </div>
    <br />

    <div align="center" class="red">
        <b>
            @if (!empty($message))
                {!! $message !!}
            @endif
        </b>
    </div>

    <form name="sortfrm" action="/manage/custom" method="post">
    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
            <tr bgColor="#ffffff">
                <td  align="right" colspan="15" class="bp">
                    @if ($totalRec > $recDisp)
                        Pages:

                        @for ($pCount = 0; $pCount < $noPages; $pCount++)
                            @if ($indexVal == $pCount)
                                <strong>{!! $pCount + 1 !!}</strong>
                            @else
                                <a href="#" onclick='setRouteParameters("/manage/custom", "{\"page\": \"{!! $pCount !!}\" }", "{!! csrf_token() !!}"); return false;'>{!! $pCount + 1 !!}</a>
                            @endif
                        @endfor
                    @endif
                </td>
            </tr>
            <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="80%">
                    Title
                </td>
                <td valign="top" class="col_head" width="20%">
                    Action
                </td>
            </tr>
        </table>
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 10px;" >

            @if (count($customsNum) == 0)
                <tr class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            @else
                @foreach ($customs as $custom)

                    @if ($custom['status'] == 1)
                        <tr class = 'tr_active'>
                    @else
                        <tr class = 'tr_inactive'>
                    @endif
                    <td valign="top" width="80%">
                        {!! $custom['title'] !!}
                    </td>
                    <td valign="top" width="20%">
                        <a href="#" onclick="loadPopup('/manage/add_custom/{!! $custom['customid'] !!}')" class="editlink" title="EDIT">Edit</a>
                    </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </form>

@stop
