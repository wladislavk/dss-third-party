@extends('layouts.admin.master')

@section('content')

    <div class="col-md-12">
        <h3 class="page-title">Home</h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>Home</li>
        </ul>
    </div>

    <div class="page-header">
        Manage Plans
    </div>

    <div align="right">
        <a href="/manage/admin/plan/new" class="btn btn-success">
            Add New Plan
            <span class="glyphicon glyphicon-plus">
        </span></a>
        &nbsp;&nbsp;
    </div>

    <b>Total Records: {{ $plans->count() }}</b>

    <table class="table table-bordered table-hover">
        <tbody>
        <tr class="tr_bg_h">
            <td valign="top" class="col_head" width="20%">Name</td>
            <td valign="top" class="col_head" width="10%">Monthly Fee</td>
            <td valign="top" class="col_head" width="10%">Trial Period</td>
            <td valign="top" class="col_head" width="10%">Fax Fee</td>
            <td valign="top" class="col_head" width="10%">Free Fax</td>
            <td valign="top" class="col_head" width="10%">Users</td>
            <td valign="top" class="col_head" width="10%">Action</td>
        </tr>
        @foreach($plans as $plan)
            <tr class="">
                <td valign="top">{{ $plan->name }}</td>
                <td valign="top">{{ $plan->monthly_fee }}</td>
                <td valign="top">{{ $plan->trial_period }}</td>
                <td valign="top">{{ $plan->fax_fee }}</td>
                <td valign="top">{{ $plan->free_fax }}</td>
                @if($plan->users()->count())
                    <td valign="top"><a href="" onclick="$('#pat_{{ $plan->id }}').toggle();return false;">{{ $plan->users()->count() }}</a></td>
                @else
                    <td>{{ "0" }}</td>
                @endif
                <td valign="top">
                    <a href="/manage/admin/plan/{{$plan->id}}/edit" title="" class="btn btn-primary btn-sm" data-original-title="Edit">
                        Edit
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="/manage/admin/plan/{{$plan->id}}/delete" title="" class="btn btn-danger btn-sm" data-original-title="delete" onclick="javascript:return confirm('Are you absolutely sure you want to delete?')">
                        Delete
                        <span class="glyphicon glyphicon-remove-sign"></span>
                    </a>
                </td>
            </tr>

            <tr id="pat_{{$plan->id}}" style="display:none;">
                <td colspan="7">
                    @foreach($plan->users()->get() as $user)
                        {{ $user->first_name }} {{ $user->last_name }}<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop

@stop