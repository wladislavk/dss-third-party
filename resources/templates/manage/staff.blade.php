@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}
    {!! HTML::style('/css/manage/manage.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}

@stop

@section('content')

    <span class="admin_head">
        Manage Staff
    </span>
    <br />
    <br />
    &nbsp;

    @if ($docId == $userId || $getTypeUsersId['manage_staff'] == 1)
        <div align="right">
            <button style="margin-right:20px; float:right;" onclick="loadPopup('/manage/staff/add');" class="addButton">Add New Staff</button>
            &nbsp;&nbsp;
        </div>
    @endif
    <br />
    <div align="center" class="red">
        <b>

            @if (!empty($message))
                {!! $message !!}
            @endif
        </b>
    </div>
    <form name="sortfrm" action="/manage/staff" method="post">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr bgColor="#ffffff">
                <td  align="right" colspan="15" class="bp">

                    @if ($totalRecords > $numberOfRecordsDisplayed)
                        Pages:

                        @for ($pCount = 0; $pCount < $noPages; $pCount++)

                            @if ($indexPage == $pCount)
                                <strong>{!! $pCount + 1 !!}</strong>
                            @else
                                <a href="#" onclick='setRouteParameters("/manage/staff", "{\"pageNumber\": \"{!! $pCount !!}\" }", "{!! csrf_token() !!}"); return false;'>{!! $pCount + 1 !!}</a>
                            @endif
                        @endfor
                    @endif
                </td>
            </tr>
            <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                    Username
                </td>
                <td valign="top" class="col_head" width="60%">
                    Name
                </td>
                <td valign="top" class="col_head" width="10%">
                    Producer
                </td>
                <td valign="top" class="col_head" width="20%">
                    Action
                </td>
            </tr>

            @if ($totalRecords == 0)
                <tr class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            @else
                @foreach ($getTypeUsers as $getTypeUser)

                    @if ($getTypeUser['status'] == 1)
                        <tr class="tr_active">
                    @else
                        <tr class="tr_inactive">
                    @endif
                    <td valign="top">
                        {!! $getTypeUser['username'] !!}
                    </td>
                    <td valign="top">
                        {!! $getTypeUser['first_name'] !!} {!! $getTypeUser['last_name'] !!}
                    </td>
                    <td valign="top">
                        {!! $getTypeUser['producer'] == 1 ? "X" : '' !!}
                    </td>
                    <td valign="top">

                        @if ($docId == $userId || $getTypeUsersId['manage_staff'] == 1)
                            <a href="#" onclick="loadPopup('staff/{!! $getTypeUser['userid'] !!}/edit');" class="editlink" title="EDIT">
                                Edit
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
        </table>
    </form>

@stop
