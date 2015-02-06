 @extends('layouts.admin.master')

 @section('content')

@foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">Error:</span>
                        <strong>{{ $error }}</strong>
                    </div>
@endforeach
<h4 class="modal-title">Add New Access Code</h4><br/><br/>
 <form name="contacttypefrm" action="/manage/admin/accesscode/{{$accesscode->id}}/update" method="post" onsubmit="return accesscodeabc(this)">
     <table class="table table-bordered table-hover">
         <tbody><tr>

         </tr>
         <tr bgcolor="#FFFFFF">
             <td valign="top" class="frmhead" width="30%">
                 Access Code
             </td>
             <td valign="top" class="frmdata">
                 <input type="text" name="access_code"  class="form-control" value="{{ $accesscode->access_code }}">
                 <span class="red">*</span>
             </td>
         </tr>
         <tr bgcolor="#FFFFFF">
             <td valign="top" class="frmhead">
                 Notes
             </td>
             <td valign="top" class="frmdata">
 		<textarea name="notes">"{{ $accesscode->notes }}"</textarea>
             </td>
         </tr>
         <tr bgcolor="#FFFFFF">
             <td valign="top" class="frmhead">
                  Plan
             </td>
             <td valign="top" class="frmdata">

                 {!! Form::select('plan_id',$plans,$accesscode->plan_id,['class'=>'form-control']) !!}
             </td>
         </tr>
         <tr bgcolor="#FFFFFF">
             <td valign="top" class="frmhead">
                Status
             </td>
             <td valign="top" class="frmdata">
 		        {!! Form::select('status',[1=>'active',2=>'In-Active'],$accesscode->status,['class'=>'form-control']) !!}
             </td>
         </tr>

         <tr>
             <td colspan="2" align="center">
                 <span class="red">
                     * Required Fields
                 </span><br>
                 <input type="hidden" name="ed" value="">
                 <input type="hidden" name="_token" value={!! csrf_token() !!}>
                 <input type="hidden" value="{{ $accesscode->access_code }}" name="current_access_code"/>
                 <input type="submit" name="accesscodesub" value="Update Access Code" class="btn btn-primary">
                 <a href="/manage/admin/accesscode" class="btn btn-success">Back</a>
             </td>
         </tr>
     </tbody></table>
     </form>


 @stop
 @stop
