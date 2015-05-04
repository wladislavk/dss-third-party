<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        {!! HTML::style('/css/3rdParty/jscal2.css') !!}
        {!! HTML::style('/css/3rdParty/border-radius.css') !!}
        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/3rdParty/jscal2.js') !!}
        {!! HTML::script('/js/3rdParty/en.js') !!}
        {!! HTML::script('/js/manage/validation.js') !!}
        {!! HTML::script('/js/manage/calendar.js') !!}
    </head>
    <body>

        @if (!empty($closePopup))
            <script>
                parent.disablePopup1();
                loc = parent.window.location.href;
                loc = loc.replace("#", "");
                parent.window.location = loc;
            </script>
        @endif

        <form name="notesfrm" action="/manage/task/add" method="post" >
            <input type="hidden" name="patientid" value="{{ $patientId or '' }}" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td class="cat_head" style="font-size:20px;">

                        @if (isset($patientId))
                            @if (!empty($patient->firstname) && !empty($patient->lastname))
                                Add a task about {{ $patient->firstname }} {{ $patient->lastname }}
                            @endif
                        @else
                            Add new task
                            @if (!empty($showBlock['newTask']))
                                {{ $showBlock['newTask'] }}
                            @endif
                        @endif

                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        <label>Task</label>
                        <span class="red">*</span>
                        <input style="width:500px;" type="text" name="task" value="{{ $task->task or '' }}" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        <label>Due Date</label>
                        <span class="red">*</span>
                        <input type="text" name="due_date" id="due_date" class="calendar" value="{{ !empty($task->due_date) ? date('m/d/Y', strtotime($task->due_date)) : date('m/d/Y') }}" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        <label>Assigned To:</label>
                        <span class="red">*</span>
                        <select name="responsibleid">

                            @if (count($users))
                                @foreach ($users as $user)
                                    <option value="{{ $user->userid }}" {{ ($user->userid == $responsibleId) ? 'selected="selected"' : '' }}>{{ $user->first_name . ' ' . $user->last_name }}</option>
                                @endforeach
                            @endif

                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        <label>Completed:</label>
                        <input type="checkbox" name="status" value="1" {{ (!empty($task->status) && $task->status == 1) ? 'checked="checked"' : '' }} />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">

                        @if (isset($id))
                            <input name="taskedit" value="1" type="hidden" />
                            <input name="task_id" value="{{ $id }}" type="hidden" />
                            <a href="manage_tasks.php?delid={{ $id }}" target="_parent" style="float:right;" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                        @else
                            <input name="taskadd" value="1" type="hidden" />
                        @endif
                        <input type="submit" class="addButton" value="Add Task" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
