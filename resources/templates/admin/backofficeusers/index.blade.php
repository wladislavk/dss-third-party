@extends('layouts.admin.master')
@section('content')


  <div class="page-header">
  	Manage Backoffice Users
  </div>

  <div align="right">
  	<a href="/manage/admin/backoffice/users/new" class="btn btn-success">
  		Add New Backoffice User
  		<span class="glyphicon glyphicon-plus"></span>
  	</a>
  	&nbsp;&nbsp;
  </div>
  <br>
<table class="table table-bordered table-hover">
	<tbody><tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Username
		</td>
		<td valign="top" class="col_head" width="20%">
			Name
		</td>
				<td valign="top" class="col_head" width="20%">
			Company
		</td>
				<td valign="top" class="col_head" width="20%">
			Permissions
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
        @foreach($backOfficeUsers as $bouser)
        <tr>
            <td valign="top">{{ $bouser->username }}</td>
            <td valign="top">{{ $bouser->first_name }} {{ $bouser->last_name }}</td>
            <td valign="top"><a href="manage_backoffice.php?cid={{$bouser->company_id}}">{{ $bouser->company_name }}</a></td>
            <td valign="top">
            @if($bouser->admin_access)
                {{  \Ds3\Libraries\Constants::$dss_admin_access_labels[$bouser->admin_access] }}
            @endif
            </td>
            <td valign="top">
            <a href="/manage/admin/backoffice/users/{{$bouser->adminid}}/edit" title="" class="btn btn-primary btn-sm" data-original-title="Edit">
                Edit
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="/manage/admin/backoffice/users/{{$bouser->adminid}}/delete" title="" class="btn btn-danger btn-sm" data-original-title="delete" onclick="javascript:return confirm('Are you absolutely sure you want to delete?')">
                Delete
                <span class="glyphicon glyphicon-remove-sign"></span>
            </a>
	    </tr>
	    @endforeach
	</tbody>
</table>

  @stop

  @stop