@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}
@stop

@section('content')

    <span class="admin_head">
        Manage Transaction Code
    </span>
    <br />
    <br />
    <div align="right">
        <button style="margin-right:20px; float:right;" onclick="loadPopup('/manage/transaction_code/add');" class="addButton">Add New Transaction Code</button>
        &nbsp;&nbsp;
    </div>
    <br />
    <div align="center" class="red">
        <b>
            @if (!empty($message))
                {{ $message }}
            @endif
        </b>
    </div>
    &nbsp;
    <b>Total Records: {{ $totalRec }}</b>
    <form name="sortfrm" action="/manage/transaction_code/add" method="post">
        <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
            <tr bgColor="#ffffff">
                <td  align="right" colspan="15" class="bp">

                    @if ($totalRec > $recDisp)
                        Pages:

                        @for ($pCount = 0; $pCount < $noPages; $pCount++)
                            @if ($indexVal == $pCount)
                                <strong>{{ $pCount + 1 }}</strong>
                            @else
                                <a href="#" onclick='setRouteParameters("/manage/transaction_code", "{\"page\": \"{{ $pCount }}\" }", "{{ csrf_token() }}"); return false;'>{{ $pCount + 1 }}</a>
                            @endif
                        @endfor
                    @endif
                </td>
            </tr>
            <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="10%">
                    TX Code
                </td>
                <td valign="top" class="col_head" width="30%">
                    Description
                </td>
                <td valign="top" class="col_head" width="30%">
                    Type
                </td>
                <td valign="top" class="col_head" width="10%">
                    Sort By
                </td>
                <td valign="top" class="col_head" width="10%">
                    Amount
                </td>
                <td valign="top" class="col_head" width="10%">
                    Action
                </td>
            </tr>

            @if (count($transactionsNum) == 0)
                <tr class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            @else
                @foreach ($transactions as $transaction)

                    @if ($transaction['status'] == 1)
                        <tr class="tr_active">
                    @else
                        <tr class="tr_inactive">
                    @endif
                    <td valign="top">
                        {{ $transaction['transaction_code'] }}
                    </td>
                    <td valign="top">
                        {{ substr($transaction['description'], 0, 25) }}
                    </td>
                    <td valign="top">

                        @if ($transaction['type'] == 1)
                            Medical Code
                        @elseif ($transaction['type'] == 2)
                            Patient Payment Code
                        @elseif ($transaction['type'] == 3)
                            Insurance Payment Code
                        @elseif ($transaction['type'] == 4)
                            Diagnostic Code
                        @elseif ($transaction['type'] == 5)
                            Modifier Code
                        @elseif ($transaction['type'] == 6)
                            Adjustment Code
                        @endif
                    </td>
                    <td valign="top" align="center">
                        <input type="text" name="sortby[]" value="{{ $transaction['sortby'] }}" class="tbox" style="width:30px"/>
                    </td>
                    <td valign="top" align="center">
                        {{ $transaction['amount'] }}
                    </td>
                    <td valign="top">
                        <a href="#" onclick="loadPopup('transaction_code/{{ $transaction['transaction_codeid'] }}/edit');" class="editlink" title="EDIT">
                            Edit
                        </a>
                    </td>
                @endforeach
                <tr>
                    <td valign="top" class="col_head" colspan="3">&nbsp;</td>
                    <td valign="top" class="col_head" colspan="2">
                        <input type="hidden" name="sortsub" value="1" />
                        <input type="submit" value="Change" class="button" />
                    </td>
                </tr>
            @endif
        </table>
    </form>

@stop
