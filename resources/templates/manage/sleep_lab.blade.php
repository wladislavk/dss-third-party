@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}
    {!! HTML::style('/css/manage/task.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}
@stop

@section('content')

<span class="admin_head">
    Manage Sleep Lab
</span>
<br /><br />&nbsp;

<div align="right">
    <button onclick="loadPopup('/manage/add_sleeplab');" class="addButton">Add New Sleep Lab</button>
    &nbsp;&nbsp;
</div>
<div class="letter_select">
    @foreach($letters as $let)
        {!! $let !!}
    @endforeach
</div><br />
<div align="center" class="red">
    <b>{!! $message !!}</b>
</div>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
            <td valign="top" class="col_head width="30%">
                Lab Name
            </td>
            
            <td valign="top" class="col_head width="40%">
                Name
            </td>

            <td valign="top" class="col_head" width="10%">
                # Patients
            </td>

            <td valign="top" class="col_head" width="20%">
                Action
            </td>
        </tr>
        @if (count($sleepLab) == 0)
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>   
        @else
            @foreach ($sleepLab as $sleepLabs)
                @if ($sleepLabs->status == 1) 
                    <tr_class = 'tr_active'>
                @else 
                    <tr_class = 'tr_inactive'>
                @endif
                    <td valign="top">
                        {!! sleepLabs->company !!}
                    </td>
                    <td valign="top">
                        {!! sleepLabs->salutation !!}.{!! sleepLabs->firstname !!} {!! sleepLabs->middlename !!} {!! sleepLabs->lastname !!}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
</form>
@stop