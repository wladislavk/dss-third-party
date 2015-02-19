@extends('layouts.admin.master')

@section('content')


    <div class="page-header">
        Manage Access Codes
    </div>
    <div align="right">
    	<a class="btn btn-success" href="/manage/admin/accesscode/new">Add New Access Code<span class="glyphicon glyphicon-plus"></span></a>
    	&nbsp;&nbsp;
    </div>

    <strong>Total Records: {{ $accessCodes->count() }}</strong>

    <table class="table table-bordered table-hover">
    		<tbody>
    		<tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">Access Code</td>
                <td valign="top" class="col_head" width="60%">Notes</td>
                <td valign="top" class="col_head" width="10%"># Users</td>
                <td valign="top" class="col_head" width="10%">Plan</td>
                <td valign="top" class="col_head" width="20%">Action</td>
    	    </tr>
            @foreach($accessCodes as $code)
    		<tr class=@if($code->status == 2) {{ "warning" }} @endif>
    		    <td valign="top">{{ $code->access_code }}</td>
                <td valign="top">{{ $code->notes }}</td>
                <td valign="top" align="center"><a href="#" onclick="$('.users_{{ $code->id }}').toggle();">{{ $code->users()->count() }}</a>
                </td><td valign="top">{{ $code->getPlan($code->plan_id)->name }}</td>
                <td valign="top">
                    <a href="/manage/admin/accesscode/{{$code->id}}/edit" title="" class="btn btn-primary btn-sm" data-original-title="Edit">Edit
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="/manage/admin/accesscode/{{$code->id}}/delete" title="" class="btn btn-danger btn-sm float-right"
                        data-original-title="Edit" onclick="javascript:return confirm('Are you absolutely sure you want to delete?')">Delete
                        <span class="glyphicon glyphicon-remove-sign"></span>
                    </a>
                </td>
            </tr>
            @foreach($code->users()->get() as $user)
            <tr class="users_{{$code->id}}" style="display:none;">
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->created_at }}</td>
                <td></td>
                <td></td>
            </tr>
            @endforeach

            @endforeach

			</tbody>
			</table>
    {!! $accessCodes->render() !!}
@stop

@stop
