@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/manage_display_similar.css') !!}    
@stop

@section('content')

@if (!empty($deleteId))
    <script>
        alert('Duplicate patient removed.');
    </script>
@endif

<span class="admin_head" style="float:left;">
    Warning: Possible Duplicate Patients
</span>
<br /><br />
<div align="center" class="red" style="clear:both;padding:0 30px;">
    <b>Patient {!! $duplicate->firstname or '' !!} {!! $duplicate->lastname or '' !!} may be a duplicate - please check the list of similar patients below. If patient is NOT a duplicate click "Create as New Patient" to add the patient to the software. If the patient IS a duplicate click "Use This Patient" next to the correct patient to use the original patient instead.</b>
</div>
<br />
<form method='POST' action='{!! $link !!}'>
    <a href="#" class="addButton" style="margin-left:30px;font-size:14px;" onClick="$('form').submit();">Create as New Patient</a>

    <a href="#" onclick="loadPopup('add_patient/noheaders/1/readonly/1/pid/{!! $duplicate->patientid or '' !!}/ed/{!! $duplicate->patientid or '' !!}'); return false;" class="addButton" style="font-size:14px;" >View</a>
    <input type='hidden' name='createid' value='{!! $duplicate->patientid or '' !!}'>

    <br /><br />
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
            <td valign="top" class="col_head" width="25%">
                Patient Name
            </td>
            <td valign="top" class="col_head" width="40%">
                Address
            </td>
            <td valign="top" class="col_head" width="10%">
                Phone
            </td>
            <td valign="top" class="col_head" width="10%">
                View
            </td>
            <td valign="top" class="col_head" width="15%">
                Action
            </td>
        </tr>

        @if (count($similarPatients))
            @foreach ($similarPatients as $similarPatient)
                <tr>
                    <td valign="top">
                        {!! $similarPatient->name or '' !!}
                    </td>
                    <td valign="top">
                        {!! $similarPatient->address or '' !!}
                    </td>
                    <td valign="top">
                        {!! $similarPatient->phone or '' !!}
                    </td>
                    <td valign="top">
                        <a href="#" onclick="loadPopup('add_patient/noheaders/1/readonly/1/pid/{!! $similarPatient->id or '' !!}/ed/{!! $similarPatient->id or '' !!}'); return false;" class="addButton" style="margin-right:10px;float:right;font-size:14px;" >View</a>
                    </td>
                    <td valign="top">
                        <a href="#" onClick="$('form').submit();" class="addButton" style="margin-right:10px;float:right;font-size:14px;" >Use This Patient</a>
                    </td>
                </tr>
                <input type="hidden" name="useid" value="{!! $similarPatient->id or '' !!}">
                <input type="hidden" name="deleteid" value="{!! $duplicate->patientid !!}">
            @endforeach
        @endif

    </table>
</form>

@stop