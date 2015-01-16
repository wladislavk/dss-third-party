@extends('layouts.admin.master')

@section('content')

       <div class="bs-example" data-example-id="simple-table">
           <table class="table">
             <thead>
               <tr>
                 <th>#</th>
                 <th>Full Name</th>
                 <th>Email</th>
                 <th>Status</th>
                 <th>Actions</th>

               </tr>
             </thead>
             <tbody>
             @foreach($users as $user)
               <tr>
                 <th scope="row">{{ $user->userid }}</th>
                 <td>{{ $user->first_name." ".$user->last_name }}</td>
                 <td>{{ $user->email }}</td>
                 <td>
                 @if($user->suspended_date == null)
                    <span class="label label-success">{{ "Active" }}</span>
                 @else
                    <span class="label label-warning">{{ "Suspended" }}</span>
                 @endif
                 </td>
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
@stop
@stop