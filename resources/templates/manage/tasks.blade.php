@extends('manage.layouts.master')

@section('references')
    @parent

    {!! HTML::style('/css/manage/popup.css') !!}
    {!! HTML::style('/css/manage/task.css') !!}

    {!! HTML::script('/js/admin/popup.js') !!}
@stop

@section('content')

<span class="admin_head">
    Manage Tasks
</span>
<br /><br />&nbsp;
<button onclick="loadPopup('/manage/add_task');" class="addButton" style="float:right; margin-right: 10px;">Add Task</button>

@if (!empty($mine) && $mine == 1)
    <button onclick="window.location='/manage/tasks'" class="addButton" style="float:right; margin-right: 10px;">Show All</button>
@else
    <button onclick='setRouteParameters("/manage/tasks", "{\"mine\": 1}", "{{ csrf_token() }}"); return false;' class="addButton" style="float:right; margin-right: 10px;">Assigned to me</button>
@endif

<br />
<div align="center" class="red">
    <b>{{ $message or '' }}</b>
</div>
<span style="float:right; margin-right:20px;">
  Pages:

  @for ($pageCount = 0; $pageCount < $noPagesTop; $pageCount++)
    @if ($indexValTop == $pageCount)
        <strong>{{ $pageCount + 1 }}</strong>
    @else
        <a href="#" class="fp" onclick='setRouteParameters("/manage/tasks", "{\"page1\": \"{{ $pageCount }}\", \"page2\": 0, \"sort1\": \"{{ $sort1 or '' }}\", \"sortdir1\": \"{{ $sortdir1 or '' }}\", \"page2\": \"{{ $page2 or '' }}\", \"sort2\": \"{{ $sort2 or '' }}\", \"sortdir2\": \"{{ $sortdir2 or '' }}\"}", "{{ csrf_token() }}"); return false;'>
            {{ $pageCount + 1 }}
        </a>
    @endif
  @endfor

</span>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <tr class="tr_bg_h">
        <td width="2%" class="col_head">
        </td>
    <td valign="top" class="col_head  {{ ($sort1 == 'task') ? 'arrow_' . $sortdir1 : '' }}" width="45%">
        <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"page2\": 0, \"sort1\": \"task\", \"sortdir1\": \"{{ ($sort1 == "task" && $sortdir1 == "asc") ? "desc" : "asc" }}\", \"page2\": \"{{ $page2 or '' }}\", \"sort2\": \"{{ $sort2 or '' }}\", \"sortdir2\": \"{{ $sortdir2 or '' }}\"}", "{{ csrf_token() }}"); return false;'>Task</a>
    </td>
    <td valign="top" class="col_head  {{ ($sort1 == 'due_date') ? 'arrow_' . $sortdir1 : '' }}" width="20%">
        <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"sort2\": \"{{ $sort2 or '' }}\", \"sortdir2\": \"{{ $sortdir2 or '' }}\", \"page2\": \"{{ $page2 or '' }}\", \"sort1\": \"due_date\", \"sortdir1\": \"{{ ($sort1 == "due_date" && $sortdir1 == "asc") ? "desc" : "asc" }}\"}", "{{ csrf_token() }}"); return false;'>Due Date</a>
    </td>
    <td valign="top" class="col_head  {{ ($sort1 == 'responsible') ? 'arrow_' . $sortdir1 : '' }}" width="20%">
        <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"sort2\": \"{{ $sort2 or '' }}\", \"sortdir2\": \"{{ $sortdir2 or '' }}\", \"page2\": \"{{ $page2 or '' }}\", \"sort1\": \"responsible\", \"sortdir1\": \"{{ ($sort1 == "responsible" && $sortdir1 == "asc") ? "desc" : "asc" }}\"}", "{{ csrf_token() }}"); return false;'>Assigned To</a>
    </td>
        <td valign="top" class="col_head" width="15%">
            Action
        </td>
    </tr>

    @if (!count($topTasks))
        <tr class="tr_bg">
            <td valign="top" class="col_head" colspan="4" align="center">
                No Records
            </td>
        </tr>
    @else
        @foreach ($topTasks as $topTask)
            <tr class="{{ $topTask->type }} task_{{ $topTask->id }}" id="task_{{ $topTask->id }}">
                <td class="status_col">
                    <input type="checkbox" class="task_status" value="{{ $topTask->id }}" />
                </td>
                <td valign="top">
                    {{ $topTask->task or '' }}
                    @if (!empty($topTask->firstname) && !empty($topTask->lastname))
                        <a href="#" onclick='setRouteParameters("/manage/add_patient{{ !empty($topTask->patientid) ? '/' . $topTask->patientid : '' }}", "{\"ed\": \"{{ $topTask->patientid or '' }}\", \"preview\": 1, \"addtopat\": 1}", "{{ csrf_token() }}"); return false;'>({{ $topTask->firstname }} {{ $topTask->lastname }})</a>
                    @endif
                </td>
                <td class="due_date" valign="top">
                    @if ($topTask->type === 'expired')
                        Overdue
                    @elseif ($topTask->type === 'today')
                        Today
                    @elseif ($topTask->type === 'tomorrow')
                        Tomorrow
                    @else
                        {{ $topTask->type }}
                    @endif
                </td>
                <td valign="top">
                    {{ $topTask->full_name }}
                </td>
                <td valign="top">
                    <a href="#" onclick='loadPopup("/manage/add_task", "{\"id\": \"{{ $topTask->id }}\"}", "{{ csrf_token() }}"); return false;' class="editlink" title="EDIT">
                        Edit
                    </a>
                </td>
            </tr>
        @endforeach
    @endif

</table>
<br />
<span class="admin_head">Completed</span>
<span style="float:right; margin-right:20px;">
    Pages:

    @for ($pageCount = 0; $pageCount < $noPagesBottom; $pageCount++)
        @if ($indexValBottom == $pageCount)
            <strong>{{ $pageCount + 1 }}</strong>
        @else
            <a href="#" class="fp" onclick='setRouteParameters("/manage/tasks", "{\"page1\": 0, \"page2\": \"{{ $pageCount }}\", \"sort1\": \"{{ $sort1 or '' }}\", \"sortdir1\": \"{{ $sortdir1 or '' }}\", \"page1\": \"{{ $page1 or '' }}\", \"sort2\": \"{{ $sort2 or '' }}\", \"sortdir2\": \"{{ $sortdir2 or '' }}\"}", "{{ csrf_token() }}"); return false;'>
                {{ $pageCount + 1 }}
            </a>
        @endif
    @endfor

</span>
<table id="completed_tasks" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <tr class="tr_bg_h">
        <td valign="top" class="col_head  {{ ($sort2 == 'task') ? 'arrow_' . $sortdir2 : '' }}" width="45%">
            <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"page1\": \"{{ $page1 or '' }}\", \"sort1\": \"{{ $sort1 or '' }}\", \"sortdir1\": \"{{ $sortdir1 or '' }}\", \"page2\": \"{{ $page2 or '' }}\", \"sort2\": \"task\", \"sortdir2\": \"{{ ($sort2 == "task" && $sortdir2 == "asc") ? "desc" : "asc" }}\"}", "{{ csrf_token() }}"); return false;'>Task</a>
        </td>
        <td valign="top" class="col_head  {{ ($sort2 == 'due_date') ? 'arrow_' . $sortdir2 : '' }}" width="20%">
            <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"sort1\": \"{{ $sort1 or '' }}\", \"sortdir1\": \"{{ $sortdir1 or '' }}\", \"page1\": \"{{ $page1 or '' }}\", \"sort2\": \"due_date\", \"sortdir2\": \"{{ ($sort2 == "due_date" && $sortdir2 == "asc") ? "desc" : "asc" }}\"}", "{{ csrf_token() }}"); return false;'>Due Date</a>
        </td>
        <td valign="top" class="col_head  {{ ($sort2 == 'responsible') ? 'arrow_' . $sortdir2 : '' }}" width="20%">
            <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"sort1\": \"{{ $sort1 or '' }}\", \"sortdir1\": \"{{ $sortdir1 or '' }}\", \"page1\": \"{{ $page1 or '' }}\", \"sort2\": \"responsible\", \"sortdir2\": \"{{ ($sort2 == "responsible" && $sortdir2 == "asc") ? "desc" : "asc" }}\"}", "{{ csrf_token() }}"); return false;'>Assigned To</a>
        </td>
        <td valign="top" class="col_head" width="15%">
            Action
        </td>
    </tr>

    @if (!count($bottomTasks))
        <tr class="tr_bg">
            <td valign="top" class="col_head" colspan="4" align="center">
                No Records
            </td>
        </tr>
    @else
        @foreach ($bottomTasks as $bottomTask)
            <tr class="">
                <td valign="top">
                    {{ $bottomTask->task or '' }}&nbsp;
                    @if (!empty($bottomTask->firstname) && !empty($bottomTask->lastname))
                        <a href="#" onclick='setRouteParameters("/manage/add_patient{{ !empty($bottomTask->patientid) ? '/' . $bottomTask->patientid : '' }}", "{\"ed\": \"{{ $bottomTask->patientid or '' }}\", \"preview\": 1, \"addtopat\": 1}", "{{ csrf_token() }}"); return false;'>({{ $bottomTask->firstname }} {{ $bottomTask->lastname }})</a>
                    @endif
                </td>
                <td valign="top">
                    {{ date('m/d/Y', strtotime($bottomTask->due_date)) }}&nbsp;
                </td>
                <td valign="top">
                    {{ $bottomTask->full_name }}
                </td>
                <td valign="top">
                    <a href="#" onclick='loadPopup("/manage/add_task", "{\"id\": \"{{ $bottomTask->id }}\"}", "{{ csrf_token() }}"); return false;' class="editlink" title="EDIT">
                        Edit
                    </a>
                </td>
            </tr>
        @endforeach
    @endif

</table>

@stop
