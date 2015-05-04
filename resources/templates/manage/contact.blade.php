@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('css/manage/popup.css') !!}
    {!! HTML::style('css/manage/manage.css') !!}

    {!! HTML::script('js/admin/popup.js') !!}
    {!! HTML::script('js/manage/manage_contact.js') !!}
@stop

@section('content')

<span class="admin_head">Manage Contact</span><br /><br />&nbsp;
<div style="margin-left:10px;margin-right:10px;">
    <form name="jump1" style="float:left; width:350px;">
        Filter by type:
        <select id="myjumpbox" name="myjumpbox" OnChange="redirectFromJumpBox('{!! csrf_token() !!}')">
            <option selected>Please Select...</option>
            <option value="">Display All</option>

            @if (!empty($contactTypes))    
                @foreach ($contactTypes as $cType)
                    <option value='{"contacttype": {!! $cType->contacttypeid or '' !!}}'>
                        {!! $cType->contacttype !!}
                    </option>
                @endforeach
            @endif

            <option value='{"status": 2}'>In-active</option>
        </select>
    </form>

    <br /><br />

    Search Contacts:
    <input type="text" id="contact_name" style="width:300px;" onclick="updateval(this)" autocomplete="off" name="contact_name" value="Type contact name" /><br />

    <div id="contact_hints" class="search_hints" style="display:none;">
        <ul id="contact_list" class="search_list">
            <li class="template" style="display:none">Doe, John S</li>
        </ul>
    </div>

    <button style="margin-right:10px; float:right;" onclick="loadPopup('/manage/contact/add')" class="addButton">
        Add New Contact
    </button>
    &nbsp;&nbsp;
</div>

<br />

<div align="center" class="red">
    <b>{!! $message !!}</b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr bgColor="#ffffff">
            <td colspan="2">
                <div class="letter_select">
                    
                    @if (!empty($letters))
                        @foreach ($letters as $let)
                            @if ($letter == $let)
                                <a class="selected_letter" href="#" onclick='setRouteParameters("/manage/contact", "{\"letter\": \"{!! $let !!}\", \"status\": \"{!! $status !!}\", \"sort\": \"{!! $sort !!}\", \"sortdir\": \"{!! $sortdir !!}\", \"contacttype\": \"{!! $contacttype !!}\"}", "{!! csrf_token() !!}"); return false;'>{!! $let !!}</a>
                            @else
                                <a href="#" onclick='setRouteParameters("/manage/contact", "{\"letter\": \"{!! $let !!}\", \"status\": \"{!! $status !!}\", \"sort\": \"{!! $sort !!}\", \"sortdir\": \"{!! $sortdir !!}\", \"contacttype\": \"{!! $contacttype !!}\"}", "{!! csrf_token() !!}"); return false;'>{!! $let !!}</a>
                            @endif
                        @endforeach
                    @endif

                    @if (!empty($letter))
                        <a href="#" onclick='setRouteParameters("/manage/contact", "{\"status\": \"{!! $status !!}\", \"sort\": \"{!! $sort !!}\", \"sortdir\": \"{!! $sortdir !!}\", \"contacttype\": \"{!! $contacttype !!}\"}", "{!! csrf_token() !!}"); return false;'>Show All</a>
                    @endif

                </div>
            </td>

            <td align="right" colspan="15" class="bp">
                @if ($totalRec > $numberOfRecordsDisplayed)
                    Pages:

                    @for ($pCount = 0; $pCount < $noPages; $pCount++)
                        @if ($indexPage == $pCount)
                            <strong>{!! $pCount + 1 !!}</strong>
                        @else
                            <a href="#" onclick='setRouteParameters("/manage/contact", "{\"page\": \"{!! $pCount !!}\", \"letter\": \"{!! $letter !!}\", \"status\": \"{!! $status !!}\", \"sort\": \"{!! $sort !!}\", \"sortdir\": \"{!! $sortdir !!}\", \"contacttype\": \"{!! $contacttype !!}\"}", "{!! csrf_token() !!}"); return false;' class="fp">
                            {!! $pCount + 1 !!}</a>
                        @endif
                    @endfor
                @endif
            </td>
        </tr>
        <tr class="tr_bg_h">
            <td valign="top" class="col_head  {!! (!empty($sort) && $sort == 'name') ? 'arrow_' . strtolower($sortdir) : '' !!}" width="20%">
                <a href="#" onclick='setRouteParameters("/manage/contact", "{\"sort\": \"name\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'name' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Name</a>
            </td>

            <td valign="top" class="col_head  {!! (!empty($sort) && $sort == 'company') ? 'arrow_' . strtolower($sortdir) : '' !!}" width="25%">
                <a href="#" onclick='setRouteParameters("/manage/contact", "{\"sort\": \"company\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'company' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Company</a>
            </td>

            <td valign="top" class="col_head  {!! (!empty($sort) && $sort == 'type') ? 'arrow_' . strtolower($sortdir) : '' !!}" width="25%">
                <a href="#" onclick='setRouteParameters("/manage/contact", "{\"sort\": \"type\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'type' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Contact Type</a>
            </td>
            <td valign="top" class="col_head" width="10%">
                Referrer
            </td>

            <td valign="top" class="col_head" width="10%">
                Patients
            </td>

            <td valign="top" class="col_head" width="20%">
                Action
            </td>

            @if (count($contacts) == 0)
                <tr class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            @else
                @foreach ($contacts as $contact)
                    @if ($contact->status == 1)
                        <tr class="tr_active">
                    @else
                        <tr class="tr_inactive">
                    @endif

                        <td valign="top" width="20%">
                            {!! $contact->lastname or '' !!} {!! $contact->middlename or '' !!}, {!! $contact->firstname or '' !!}
                        </td>
                        <td valign="top" width="25%">
                            {!! $contact->company !!}
                        </td>
                        <td valign="top" width="25%">
                            @if (!empty($contact->contacttypeid) && !empty($contactType[$contact->contacttypeid]))
                                {!! $contactType[$contact->contacttypeid] !!}
                            @else
                                Contact Type Not Set
                            @endif
                        </td>
                        <td valign="top" width="10%">
                            
                            @if (count($patientsInfo[$contact->contactid]['ref']))
                                <a href="#" onclick="$('#ref_pat_{!! $contact->contactid !!}').toggle(); return false;">{!! count($patientsInfo[$contact->contactid]['ref']) !!}</a>
                            @endif

                        </td>
                        <td valign="top" width="10%">
                            
                            @if (count($patientsInfo[$contact->contactid]['pat']))
                                <a href="#" onclick="$('#ref_pat_{!! $contact->contactid !!}').toggle(); return false;">{!! count($patientsInfo[$contact->contactid]['pat']) !!}</a>
                            @endif

                        </td>
                        <td valign="top" width="20%">
                            <div class="actions" style="display:none;">
                                <a href="#" onclick="loadPopup('/manage/contact/{!! $contact->contactid !!}/view'); return false;" class="editlink" title="EDIT">
                                    Quick View
                                </a>
                                |
                                <a href="#" onclick="loadPopup('/manage/contact/add/{!! $contact->contactid !!}')" class="editlink" title="EDIT">
                                    Edit 
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr id="ref_pat_{!! $contact->contactid !!}" style="display:none;">
                        <td colspan="2" valign="top">
                            <strong>REFERRED</strong><br />
                            
                            @if (count($patientsInfo[$contact->contactid]['ref']))
                                @foreach ($patientsInfo[$contact->contactid]['ref'] as $patient)
                                    <a href="#" onclick='setRouteParameters("/manage/patient/add{!! !empty($patient->patientid) ? '/' . $patient->patientid : '' !!}", "{\"ed\": \"{!! $patient->patientid or '' !!}\"}", "{!! csrf_token() !!}"); return false;'>{!! $patient->firstname !!} {!! $patient->lastname !!}<br />
                                @endforeach
                            @endif
                        </td>

                        <td colspan="4" valign="top">
                            <strong>PATIENTS</strong><br />

                            @if (count($patientsInfo[$contact->contactid]['pat']))
                                @foreach ($patientsInfo[$contact->contactid]['pat'] as $patient)
                                    <a href="#" onclick='setRouteParameters("/manage/patient/add{!! !empty($patient->patientid) ? '/' . $patient->patientid : '' !!}", "{\"ed\": \"{!! $patient->patientid or '' !!}\"}", "{!! csrf_token() !!}"); return false;'>{!! $patient->firstname !!} {!! $patient->lastname !!}<br />    
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