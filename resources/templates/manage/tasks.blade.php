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
    <button onclick='setRouteParameters("/manage/tasks", "{\"mine\": 1}", "{!! csrf_token() !!}"); return false;' class="addButton" style="float:right; margin-right: 10px;">Assigned to me</button>
@endif

<br />
<div align="center" class="red">
    <b>{!! $message or '' !!}</b>
</div>
<span style="float:right; margin-right:20px;">
  Pages:
  <?php paging1($no_pages,$index_val,"sort1=".(!empty($_GET['sort1']) ? $_GET['sort1'] : '')."&sortdir1=".(!empty($_GET['sortdir1']) ? $_GET['sortdir1'] : '')."&page2=".(!empty($_GET['page2']) ? $_GET['page2'] : '')."&sort2=".(!empty($_GET['sort2']) ? $_GET['sort2'] : '')."&sortdir2=".(!empty($_GET['sortdir2']) ? $_GET['sortdir2'] : ''));?>

  @for ($pageCount = 0; $pageCount < $noPagesTop; $pageCount++)
    @if ($indexValTop == $pageCount)
        <strong>{!! $pageCount + 1 !!}</strong>
    @else
        <a href="#" class="fp" onclick='setRouteParameters("/manage/tasks", "{\"page1\": {!! $pageCount !!}, \"page2\": 0, \"sort1\": {!! $sort1 or '' !!}, \"sortdir1\": {!! $sortdir1 or '' !!}, \"page2\": {!! $page2 or '' !!}, \"sort2\": {!! $sort2 or '' !!}, \"sortdir2\": {!! $sortdir2 or '' !!}}", "{!! csrf_token() !!}"); return false;'>
            {!! $pageCount + 1 !!}
        </a>
    @endif
  @endfor
</span>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <tr class="tr_bg_h">
        <td width="2%" class="col_head">
        </td>
    <td valign="top" class="col_head  {!! ($sort1 == 'task') ? 'arrow_' . $sortdir1 : '' !!}" width="45%">
        <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"page2\": 0, \"sort1\": \"task\", \"sortdir1\": {!! ($sort1 == "task" && $sortdir1 == "asc") ? "desc" : "asc" !!}, \"page2\": {!! $page2 or '' !!}, \"sort2\": {!! $sort2 or '' !!}, \"sortdir2\": {!! $sortdir2 or '' !!}}", "{!! csrf_token() !!}"); return false;'>Task</a>
    </td>
    <td valign="top" class="col_head  {!! ($sort1 == 'due_date') ? 'arrow_' . $sortdir1 : '' !!}" width="20%">
        <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"sort2\": {!! $sort2 or '' !!}, \"sortdir2\": {!! $sortdir2 or '' !!}, \"page2\": {!! $page2 or '' !!}, \"sort1\": \"due_date\", \"sortdir1\": {!! ($sort1 == "due_date" && $sortdir1 == "asc") ? "desc" : "asc" !!}}", "{!! csrf_token() !!}"); return false;'>Due Date</a>
    </td>
    <td valign="top" class="col_head  {!! ($sort1 == 'responsible') ? 'arrow_' . $sortdir1 : '' !!}" width="20%">
        <a href="#" onclick='setRouteParameters("/manage/tasks", "{\"sort2\": {!! $sort2 or '' !!}, \"sortdir2\": {!! $sortdir2 or '' !!}, \"page2\": {!! $page2 or '' !!}, \"sort1\": \"responsible\", \"sortdir1\": {!! ($sort1 == "responsible" && $sortdir1 == "asc") ? "desc" : "asc" !!}}", "{!! csrf_token() !!}"); return false;'>Assigned To</a>
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
            
        @endforeach
    @endif

@stop