@extends('layouts.admin.master')

@section('content')

<div class="page-header">
    Manage Users
</div>
@if($users)
  @if($users[0]->isSuper(\Session::get('admin_access')) || $users[0]->is_admin(\Session::get('admin_access')))

<div align="right">
  <a href="/manage/admin/user/new" class="btn btn-success">
    Add New User
    <span class="glyphicon glyphicon-plus"></span>
  </a>
  &nbsp;&nbsp;
</div>
@endif
@endif
    <div style="">
       <div class="bs-example" data-example-id="simple-table">
           <table class="table">
             <thead>
               <tr class="tr_bg_h">
                  <td valign="top" class="col_head" width="20%">ID</td>
                       <td valign="top" class="col_head" width="20%">Name</td>
                       <td valign="top" class="col_head" width="20%">Username</td>
                    @if($users)
                        @if($users[0]->isSuper(\Session::get('admin_access')))
                            <td valign="top" class="col_head" width="20%">Letterhead</td>
                            <td valign="top" class="col_head" width="10%">Company</td>
                            <td valign="top" class="col_head" width="10%">Login As</td>
                        @endif
                    @endif

                       <td valign="top" class="col_head" width="8%">Locations</td>
                       <td valign="top" class="col_head" width="8%">Contact</td>
                       <td valign="top" class="col_head" width="8%">Staff</td>
                       <td valign="top" class="col_head" width="8%">Patients</td>
                       <td valign="top" class="col_head" width="8%">Invoices</td>
                    <td valign="top" class="col_head" width="10%">Plan</td>
                       <td valign="top" class="col_head" width="10%">Action</td>
                   </tr>
             </thead>
             <tbody>
             @foreach($users as $user)
               <tr>
                  <td>{{ $user->userid }}</td>
                 <td scope="row">{{ $user->first_name." ".$user->last_name }}</td>
                 @if($user->status == 2)
                    <td>{{ "Registration Email: ".(($user->registration_email_date != null) ? date('m/d/Y H:i a', strtotime($user->registration_email_date)):'Nothing') }}</td>
                 @else
                    <td>{{ $user->username }}</td>
                 @endif

                 @if($user->status == 3)
                 <td>
                    <br />
                    Activated on: {{ ($user->created_at) ? date('m/d/Y',strtotime($user->created_at)):'' }}
                    <br />
                    Suspended on: {{   ($user->suspended_date) ? date('m/d/Y',strtotime($user->suspended_date)):'' }}
                    <br />
                    Suspended Reason: {{ $user->suspended_reason }}

                 </td>
                 @endif
                     @if($user->isSuper(\Session::get('admin_access')) || $user->isAdmin(\Session::get('admin_access')))
                     <td valign="top">
                        <a href="/manage/admin/letterhead.php?uid={{$user->userid}}">Update Images</a>
                     <td>

                  <td>
                     @if( $user->status != 2 )
                      <form action="login_as.php" method="post" target="Doctor_Login">
                            <input type="hidden" name="username" value="{{ $user->username }}">
                            <input type="hidden" name="password" value="{{ $user->password }}">
                            <input type="hidden" name="loginsub" value="1">
                            <input type="submit" name="btnsubmit" value=" Login " class="btn btn-success">
                        </form>
                      
                         @endif
                    @endif
                  </td>
                  <td valign="top" align="center">
                      <a href="#"class="btn btn-danger pull-right">{{ $user->getLocations()->count() }}</a>
                  </td>
                  <td><a href="#"class="btn btn-danger pull-right">{{ $user->getContacts()->count() }}</a></td>
                                  
                  <td><a href="#"class="btn btn-danger pull-right">{{  $user->getStaff() }}</td>
                  <td>{{  $user->getPatients()->count() }}</td>
                  <td>{{ $user->getInvoices()->count() }}</td>
                  <td>{{ $user->plan_name }}</td>
                 <td>
                    <a href="/manage/admin/{{$user->userid}}/user" class="btn btn-info">Edit</a>
                    @if($user->suspended_date !== null)
                        <a href="/manage/admin/user/{{$user->userid}}/un-suspend" class="btn btn-warning">Un-suspend</a>
                    @else
                        <a href="/manage/admin/user/{{$user->userid}}/suspend" class="btn btn-success">Suspend</a>
                    @endif
                    <a href="/manage/admin/user/{{ $user->userid}}/delete" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                 </td>
               </tr>
             @endforeach
             </tbody>
           </table>
         </div>
    s</div>
@stop
@stop