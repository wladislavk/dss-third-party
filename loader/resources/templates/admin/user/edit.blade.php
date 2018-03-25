@extends('layouts.admin.master')

@section('content')

    <div class="">
        <form method="POST" action="/manage/admin/user/{{$user->userid}}/update">
            <input name="first_name" class="form-control" value={{$user->first_name}} />
            <input name="last_name" class="form-control" value={{ $user->last_name  }} />
            <input name="email" class="form-control" value={{ $user->email }} /> <br>

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@stop
@stop