@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}
    {!! HTML::style('/css/manage/manage.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}
@stop

@section('content')

    <span class="admin_head">
        Manage Corporate Contacts
    </span>
    <br />
    <br />
    &nbsp;
    <div align="center" class="red">
        <b>
            @if (!empty($message))
                {!! $message !!}
            @endif
        </b>
    </div>

    <form name="sortfrm" action="/manage/fcontact" method="post">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >

            @if ($totalRec > $recDisp)
                <tr bgColor="#ffffff">
                    <td  align="right" colspan="15" class="bp">
                        Pages:

                        @for ($pCount = 0; $pCount < $noPages; $pCount++)
                            @if ($indexVal == $pCount)
                                <strong>{!! $pCount + 1 !!}</strong>
                            @else
                                <a href="#" onclick='setRouteParameters("/manage/fcontact", "{\"page\": \"{!! $pCount !!}\", \"sort\": \"{!! $sort !!}\", \"sortdir\": \"{!! $sortdir !!}\", \"contacttype\": \"{!! $contacttype !!}\"}", "{!! csrf_token() !!}"); return false;' class="fp">
                                {!! $pCount + 1 !!}</a>
                            @endif
                        @endfor
                    </td>
                </tr>
            @endif
            <tr class="tr_bg_h">
                <td valign="top" class="col_head  {!! (!empty($sort) && $sort == 'company') ? 'arrow_' . strtolower($sortdir) : '' !!}" width="30%">
                    <a href="#" onclick='setRouteParameters("/manage/fcontact", "{\"sort\": \"company\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'company' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Company</a>
                </td>
                <td valign="top" class="col_head  {!! (!empty($sort) && $sort == 'type') ? 'arrow_' . strtolower($sortdir) : '' !!}" width="20%">
                    <a href="#" onclick='setRouteParameters("/manage/fcontact", "{\"sort\": \"type\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'type' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Type</a>
                </td>
                <td valign="top" class="col_head  {!! (!empty($sort) && $sort == 'name') ? 'arrow_' . strtolower($sortdir) : '' !!}" width="30%">
                    <a href="#" onclick='setRouteParameters("/manage/fcontact", "{\"sort\": \"name\", \"sortdir\": \"{!! (!empty($sort) && $sort == 'name' && $sortdir == 'ASC') ? 'DESC' : 'ASC' !!}\"}", "{!! csrf_token() !!}"); return false;'>Name</a>
                </td>
                <td valign="top" class="col_head" width="20%">
                    Action
                </td>
            </tr>

            @if (count($fcontacts) == 0)
                <tr class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            @else
                @foreach ($fcontacts as $fcontact)
                    @if ($fcontact->status == 1)
                        <tr class="tr_active">
                    @else
                        <tr class="tr_inactive">
                    @endif

                        <td valign="top">
                            {!! $fcontact->company !!}
                        </td>
                        <td valign="top">
                            @if (!empty($fcontact->contacttypeid) && !empty($contactType[$fcontact->contacttypeid]))
                                {!! $contactType[$fcontact->contacttypeid] !!}
                            @endif
                        </td>
                        <td valign="top">
                            {!! $fcontact->lastname or '' !!} {!! $fcontact->middlename or '' !!}, {!! $fcontact->firstname or '' !!}
                        </td>
                        <td valign="top">
                            <a href="#" onclick="loadPopup('/manage/view_contact/{!! $fcontact->contactid !!}/corporate=1'); return false;" class="editlink" title="EDIT">
                                Quick View
                            </a>
                            |
                            <a href="#" onclick="loadPopup('/manage/view_fcontact{!! !empty($fcontact->contactid) ? '/' . $fcontact->contactid : '' !!}'); return false;" class="editlink" title="EDIT">
                                View Full
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </form>
<br />

@stop
