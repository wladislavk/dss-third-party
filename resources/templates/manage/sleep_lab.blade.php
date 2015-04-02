@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}
    {!! HTML::style('/css/manage/sleeplab.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}
@stop

@section('content')

<span class="admin_head">
    Manage Sleep Lab
</span>
<br /><br />&nbsp;

<div align="right">
    <button style="margin-right:20px; float:right;" onclick="loadPopup('/manage/add_sleeplab');" class="addButton">Add New Sleep Lab</button>
    &nbsp;&nbsp;
</div>
<div class="letter_select">
    @foreach($letters as $let)
        <a href="#" onclick='setRouteParameters("/manage/sleeplab", "{\"letter\": \"{!! $let !!}\", \"sort\": \"{!! $sort !!}\", \"sortdir\": \"{!! $sortdir !!}\" }", "{!! csrf_token() !!}"); return false;'>{!! $let !!}</a>
    @endforeach
</div><br />
<div align="center" class="red">
    <b>{!! $message !!}</b>
</div>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr bgColor="#ffffff">
            <td  align="right" colspan="15" class="bp">
                @if ($totalRec > $recDisp)
                    Pages:

                    @for ($pCount = 0; $pCount < $noPages; $pCount++)
                        @if ($indexVal == $pCount)
                            <strong>{!! $pCount + 1 !!}</strong>
                        @else
                            <a href="#" onclick='setRouteParameters("/manage/sleeplab", "{\"page\": \"{!! $pCount !!}\", \"letter\": \"{!! $letter !!}\", \"sort\": \"{!! $sort !!}\", \"sortdir\": \"{!! $sortdir !!}\" }", "{!! csrf_token() !!}"); return false;'>{!! $pCount + 1 !!}</a>
                        @endif
                    @endfor
                @endif
            </td>
        </tr>
        <tr class="tr_bg_h">
            <td valign="top" class="col_head" width="30%">
                <a href="#" onclick='setRouteParameters("/manage/sleeplab", "{\"sort\": \"lab\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'lab' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Lab Name</a>
            </td>
            <td valign="top" class="col_head" width="40%">
                <a href="#" onclick='setRouteParameters("/manage/sleeplab", "{\"sort\": \"name\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'name' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Name</a>
            </td>
            <td valign="top" class="col_head" width="10%">
                # Patients
            </td>
            <td valign="top" class="col_head" width="20%">
                Action
            </td>
        </tr>
        @if (count($sleepLabs) == 0)
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>   
        @else
            @foreach ($sleepLabs as $sleepLab)
                @if ($sleepLab->status == 1) 
                    <tr class = 'tr_active'>
                @else 
                    <tr class = 'tr_inactive'>
                @endif
                    <td valign="top">
                        {!! $sleepLab->company !!}
                    </td>
                    <td valign="top">
                        {!! $sleepLab->salutation !!} {!! $sleepLab->firstname !!} {!! $sleepLab->middlename !!} {!! $sleepLab->lastname !!}
                    </td>
                    <td valign="top">
                        <a href="#" onclick="$('#pat_{!! $sleepLab->sleeplabid !!}').toggle(); return false;">{!! count($patientsInfo[$sleepLab->sleeplabid]['pat']) !!}</a>
                    </td>
                    <td valign="top">
                        <a href="#" onclick="loadPopup('/manage/view_sleeplab/{!! $sleepLab->sleeplabid !!}'); return false;" class="editlink" title="EDIT">Quick View</a>
                        |
                        <a href="#" onclick="loadPopup('/manage/add_sleeplab/{!! $sleepLab->sleeplabid !!}')" class="editlink" title="EDIT">Edit</a>
                    </td>
                </tr>
                <tr id="pat_{!! $sleepLab->sleeplabid !!}" style="display:none;">
                    <td colspan="4">
                        <h3>Patients</h3>

                        @if (count($patientsInfo[$sleepLab->sleeplabid]['pat']))
                            @foreach ($patientsInfo[$sleepLab->sleeplabid]['pat'] as $patient)
                                <a href="/manage/dss_summ/{!! $patient->patientid !!}", "{\'ed\': \{!! $patient->patientid !!}", "{!! csrf_token() !!}; return false;">{!! $patient->firstname !!} {!! $patient->lastname !!}</a><br />
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
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
<br /><br />

@stop