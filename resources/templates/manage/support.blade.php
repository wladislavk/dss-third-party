@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/support.css') !!}
@stop

@section('content')

<button style="margin-right:10px; float:right;" onclick="loadPopup('/manage/add_ticket')" class="addButton">
    Add New Ticket
</button>
<br />
<span class="admin_head">Open Tickets</span>
<div id="pager" class="pager">
    <form>
        <img src="/img/first.png" class="first">
        <img src="/img/prev.png" class="prev">
        <input class="pagedisplay" style="width:75px;" type="text">
        <img src="/img/next.png" class="next">
        <img src="/img/last.png" class="last">
    </form>
</div>
<table id="sort_table" width="98%" cellpadding="5" cellspacing="1" align="center">
    <thead>
        <tr class="tr_bg_h">
            <th class="col_head" width="23%">Title</th>
            <th class="col_head" width="33%">Body</th>
            <th class="col_head" width="14%">Company</th>
            <th class="col_head" width="9%">Date</th>
            <th class="col_head" width="8%">Status</th>
            <th class="col_head" width="13%">Action</th>
        </tr>
    </thead>
    <tbody>

        @if (count($openTickets))
            @foreach ($openTickets as $openTicket)
                <tr class="{!! (($openTicket->viewed == '0' && $openTicket->create_type == '0') || $openTicket->response_viewed == '0') ? 'unviewed' : '' !!}"> 
                    <td>{!! $openTicket->title !!}</td>
                    <td>{!! substr($openTicket->body, 0, 50) !!}</td>

                    @if (!empty($openTicket->company_name))
                        <td>{!! $openTicket->company_name !!}</td>
                    @else
                        <td>Dental Sleep Solutions</td>
                    @endif

                    <td>{!! Carbon\Carbon::parse($openTicket->latest)->format('m/d/Y') !!}</td>
                    <td>{!! $dssTicketStatusLabels[$openTicket->status] !!}</td>
                    <td>
                        <a href="/manage/view_support_ticket/{!! $openTicket->id !!}">View</a>

                        @if (!empty($openTicket->attachment) || !empty($openTicket->response_attachment) || !empty($openTicket->ticket_attachment))
                            <span class="attachment"></span>
                        @endif

                        @if ((!empty($openTicket->ticket_read) && $openTicket->response_viewed != '0') || $openTicket->response_viewed == '1')
                            | <a href="#" onclick='setRouteParameters("/manage/support", "{\"rid\": \"{!! $openTicket->id !!}\"}", "{!! csrf_token() !!}"); return false;'>Mark Unread</a>
                        @endif

                        @if (($openTicket->create_type === 0 && $openTicket->viewed != '1') || $openTicket->response_viewed === '0')
                            | <a href="#" onclick='setRouteParameters("/manage/support", "{\"urid\": \"{!! $openTicket->id !!}\"}", "{!! csrf_token() !!}"); return false;'>Mark Read</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>

<br />
<span class="admin_head">Closed Tickets</span>
<div id="pager2" class="pager">
    <form>
        <img src="/img/first.png" class="first">
        <img src="/img/prev.png" class="prev">
        <input class="pagedisplay" style="width:75px;" type="text">
        <img src="/img/next.png" class="next">
        <img src="/img/last.png" class="last">
    </form>
</div>
<table id="sort_table2" width="98%" cellpadding="5" cellspacing="1" align="center">
    <thead>
        <tr class="tr_bg_h">
            <th class="col_head" width="23%">Title</th>
            <th class="col_head" width="33%">Body</th>
            <th class="col_head" width="14%">Company</th>
            <th class="col_head" width="9%">Date</th>
            <th class="col_head" width="8%">Status</th>
            <th class="col_head" width="13%">Action</th>
        </tr>
    </thead>
    <tbody>

        @if (count($closedTickets))
            @foreach ($closedTickets as $closedTicket)
                <tr> 
                    <td>{!! $closedTicket->title !!}</td>
                    <td>{!! substr($closedTicket->body, 0, 50) !!}</td>

                    @if (!empty($closedTicket->company_name))
                        <td>{!! $closedTicket->company_name !!}</td>
                    @else
                        <td>Dental Sleep Solutions</td>
                    @endif

                    <td>{!! Carbon\Carbon::parse($closedTicket->latest)->format('m/d/Y') !!}</td>
                    <td>{!! $dssTicketStatusLabels[$closedTicket->status] !!}</td>
                    <td>
                        <a href="/manage/view_support_ticket/{!! $closedTicket->id !!}">View</a>
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>

@stop