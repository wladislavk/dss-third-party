@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}
    {!! HTML::style('/css/manage/support.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}
    {!! HTML::script('/js/manage/view_support_ticket.js') !!}
@stop

@section('content')

@if (!empty($showAlert))
    <script>
        alert("This ticket was closed and has now been reopened. We will respond promptly to your inquiry. Thank you!");
    </script>
@endif

<a href="/manage/support" style="float:right; margin-right:20px;" class="button">Return to support</a>

<div style="width:96%; margin:0 auto;">
    <div id="support_ticket">
        <span class="admin_head">
            {!! $ticket->title or '' !!} - {!! $companyName !!}
        </span>
        <br />
        <br />
        <div class="response_type_{!! !empty($ticket->create_type) ? $ticket->create_type : '' !!}">
            {!! $ticket->body or '' !!}
            @if (!empty($ticket->attachment))
                | <a href="/manage/display_file/{!! $ticket->attachment !!}" target="_blank">View Attachment</a>
            @endif

            @if (count($attachments))
                @foreach ($attachments as $attachment)
                    | <a href="/manage/display_file/{!! $attachment->filename !!}" target="_blank">View Attachment</a>
                @endforeach
            @endif

            <div class="info">
                {!! $name !!}
                {!! Carbon\Carbon::parse($ticket->adddate)->format('m/d/Y h:i:s a') !!}
            </div>
        </div>
    </div>
    <div id="support_responses">

        @if (count($responses))
            @foreach ($responses as $response)
                <div class="response_type_{!! $response->response_type !!}">
                    {!! $response->body !!}
                    @if (!empty($response->attachment))
                        | <a href="/manage/display_file/{!! $response->attachment !!}" target="_blank">View Attachment</a>
                    @endif

                    @if (count($response->attachments))
                        @foreach ($response->attachments as $attachment)
                            | <a href="/manage/display_file/{!! $attachment->filename !!}" target="_blank">View Attachment</a>
                        @endforeach
                    @endif

                    <div class="info">
                        {!! $response->name !!}
                        {!! $response->add_date !!}
                    </div>
                </div>
            @endforeach
        @endif

        <div style="clear:both;"></div>
    </div>
    <div id="respond">
        <h4>Respond</h4>
        <form action="/manage/view_support_ticket/{!! $id !!}" method="post"  enctype="multipart/form-data">
            <textarea name="body" style="width: 400px; height:100px;"></textarea><br />
            <input type="submit" name="respond" value="Submit Response" style="float:left;"/>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div style="width:300px;">
                <div id="attachments">
                    <span>
                        <input type="file" name="attachment[]" id="attachment1" class="addattachment" onchange="$('#add_attachment_but').show();" style="height:auto;width:auto;" />
                        <a href="#" onclick="$(this).parent().remove();$('#add_attachment_but').show();return false;">Remove</a>
                    </span>
                </div>
                <a href="#" id="add_attachment_but" onclick="add_attachment(); return false;" style="display:none;" class="button">Add Additional</a>
                <div style="float:right;">

                    @if (!empty($ticketStatus))
                        <input type="checkbox" value="2" name="close" /> Close Ticket<br />
                    @else
                        <input type="hidden" value="1" name="reopen" />
                    @endif

                </div>
            </div>
        </form>
    </div>
</div>
<br /><br />

@stop