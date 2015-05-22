@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}
    {!! HTML::style('/css/manage/manage.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}

@stop

@section('content')

    <span class="admin_head">
        Manage Resources
    </span>

    <br />
    <br />
    &nbsp;

    <div align="right">
        <button style="margin-right:20px; float:right;" onclick="loadPopup('/manage/chairs/add');" class="addButton">
            Add New Resource
        </button>

        &nbsp;
        &nbsp;
    </div>
    <br />

    <div align="center" class="red">
        <b>

            @if (!empty($message))
                {{ $message }}
            @endif
        </b>
    </div>

    <form name="sortfrm" action="/manage/chairs" method="post">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">

            @if ($totalRecords > $numberOfRecordsDisplayed)
                <tr bgColor="#ffffff">
                    <td  align="right" colspan="15" class="bp">
                        Pages:

                        @for ($pCount = 0; $pCount < $noPages; $pCount++)

                            @if ($indexPage == $pCount)
                                <strong>{{ $pCount + 1 }}</strong>
                            @else
                                <a href="#" onclick='setRouteParameters("/manage/chairs", "{\"pageNumber\": \"{{ $pCount }}\" }}", "{{ csrf_token() }}"); return false;'>{{ $pCount + 1 }}</a>
                            @endif
                        @endfor
                    </td>
                </tr>
            @endif

            <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                    Resource Name
                </td>
                <td valign="top" class="col_head" width="20%">
                    Resource Rank
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
                @foreach ($resources as $resource)
                    <tr class="tr_active">
                        <td valign="top">
                            {{ $resource['name'] }}
                        </td>
                        <td valign="top">
                            {{ $resource['rank'] }}
                        </td>
                        <td valign="top">

                            @if ($docId == $userId || $users['manage_staff'] == 1)
                                <a href="#" onclick="loadPopup('chairs/{{ $resource['id'] }}/edit');" class="editlink" title="EDIT">
                                    Edit
                                </a>
                            @endif
                        </td>
                @endforeach
            @endif

        </table>
    </form>

@stop
