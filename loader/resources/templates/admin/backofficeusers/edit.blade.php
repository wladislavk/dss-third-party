@extends('layouts.admin.master')

@section('content')

@foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">Error:</span>
                        <strong>{{ $error }}</strong>
                    </div>
@endforeach
<h4 class="modal-title">Add New Back Office User</h4><br/><br/>
<a href="/manage/admin/backoffice/users" class="btn btn-success">Back</a><br/><br/>
<form name="userfrm" action="/manage/admin/backoffice/users/{{$backOfficeUser->adminid}}/edit" method="post" onsubmit="return check_add();">
    <table class="table table-bordered table-hover">
        <tbody><tr>
            <td colspan="2" class="cat_head">
               Add  Backoffice User
                           </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Username
            </td>
            <td valign="top" class="frmdata">
                <input id="username" type="text" name="username" value="{{ $backOfficeUser->username }}" class="form-control validate">
                <span class="red">*</span>
            </td>
        </tr>

            <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                First Name
            </td>
            <td valign="top" class="frmdata">
                <input id="first_name" type="text" name="first_name" value="{{ $backOfficeUser->first_name }}" class="form-control validate">
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Last Name
            </td>
            <td valign="top" class="frmdata">
                <input id="last_name" type="text" name="last_name" value="{{ $backOfficeUser->last_name }}" class="form-control validate">
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Email
            </td>
            <td valign="top" class="frmdata">
                <input id="email" type="text" name="email" value="{{ $backOfficeUser->email }}" class="form-control validate">
                <span class="red">*</span>
            </td>
        </tr>

                <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
               Company
            </td>
            <td valign="top" class="frmdata">
                {!! Form::select('companyid',[''=>'Select Companies'] + $companies,$user_company,['class'=>'form-control validate','id'=>'companyid']) !!}
            </td>
        </tr>
            <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Access Level
            </td>
            <td valign="top" class="frmdata">
                {!! Form::select('admin_access',[''=>'Select Access'] + $access_level, $backOfficeUser->admin_access,['class'=>'form-control validate','id'=>'admin_access']) !!}
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
                {!! Form::select('status',[''=>'Select Status'] + [1=>'Active',2=>'In-Active'],$backOfficeUser->status,['class'=>'form-control']) !!}
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <span class="red">
                    * Required Fields
                </span><br>
                <input type="hidden" name="usersub" value="1">
                <input type="hidden" name="ed" value="">
                <input type="hidden" name="usernameOld" value="{{ $backOfficeUser->username }}"/>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="submit" value="Update User" class="btn btn-primary">
            </td>
        </tr>
    </tbody></table>
    </form>

@stop

@stop
