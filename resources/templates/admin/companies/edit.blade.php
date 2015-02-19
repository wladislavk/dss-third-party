@extends('layouts.admin.master')

@section('content')

    <h4 class="modal-title">Add New Company</h4>
@include('layouts.partials.errors')
    {!! Form::open(['route'=>['manage.admin.companies.update',$company->id],'method'=>'put']) !!}
        <table class="table table-bordered table-hover">
            <tbody><tr>
                <td colspan="2" class="cat_head">
                   Add  Company
                               </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Name
                </td>
                <td valign="top" class="frmdata">
                    <input id="name" type="text" name="name" value="{{$company->name}}" class="form-control">
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Address 1
                </td>
                <td valign="top" class="frmdata">
                    <input id="add1" type="text" name="add1" value="{{$company->add1}}" class="form-control">
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Address 2
                </td>
                <td valign="top" class="frmdata">
                    <input id="add2" type="text" name="add2" value="{{$company->add2}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    City
                </td>
                <td valign="top" class="frmdata">
                    <input id="city" type="text" name="city" value="{{$company->city}}" class="form-control">
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    State
                </td>
                <td valign="top" class="frmdata">
                    <input id="state" type="text" name="state" value="{{$company->state}}" class="form-control">
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Postal Code
                </td>
                <td valign="top" class="frmdata">
                    <input id="zip" type="text" name="zip" value="{{$company->zip}}" class="form-control">
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Phone
                </td>
                <td valign="top" class="frmdata">
                    <input id="phone" type="text" name="phone" value="{{$company->phone}}" class="form-control extphonemask">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Fax
                </td>
                <td valign="top" class="frmdata">
                    <input id="fax" type="text" name="fax" value="{{$company->fax}}" class="form-control phonemask">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Email
                </td>
                <td valign="top" class="frmdata">
                    <input id="email" type="text" name="email" value="{{$company->email}}" class="form-control">
                </td>
            </tr>

            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Eligible API Key
                </td>
                <td valign="top" class="frmdata">
                    <input id="zip" type="text" name="eligible_api_key" value="{{$company->eligible_api_key}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Stripe SECRET Key
                </td>
                <td valign="top" class="frmdata">
                    <input id="stripe_secret_key" type="text" name="stripe_secret_key" value="{{$company->stripe_secret_key}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Stripe PUBLISHABLE Key
                </td>
                <td valign="top" class="frmdata">
                    <input id="stripe_publishable_key" type="text" name="stripe_publishable_key" value="{{$company->stripe_publishable_key}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    SFAX Security Context
                </td>
                <td valign="top" class="frmdata">
                    <input id="sfax_security_context" type="text" name="sfax_security_context" value="{{$company->sfax_security_context}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    SFAX Username
                </td>
                <td valign="top" class="frmdata">
                    <input id="sfax_app_id" type="text" name="sfax_app_id" value="{{$company->sfax_app_id}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    SFAX API Key
                </td>
                <td valign="top" class="frmdata">
                    <input id="sfax_app_key" type="text" name="sfax_app_key" value="{{$company->sfax_app_key}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    SFAX Encryption Key
                </td>
                <td valign="top" class="frmdata">
                    <input id="sfax_encryption_key" type="text" name="sfax_encryption_key" value="{{$company->sfax_encryption_key}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    SFAX Init Vector
                </td>
                <td valign="top" class="frmdata">
                    <input id="sfax_init_vector" type="text" name="sfax_init_vector" value="{{$company->sfax_init_vector}}" class="form-control">
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Company Type
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::select('company_type',$company_type,$company->company_type,['class'=>'form-control']) !!}
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
    		Sleep Test Required for VOB?
                </td>
                <td valign="top" class="frmdata">
                @if($company->vob_require_test == 1)
                    {!! Form::checkbox('vob_require_test',null, true) !!}
                @else
                    {!! Form::checkbox('vob_require_test',null, false) !!}
                @endif
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    <attr title="Choose backoffice billing plan associated with this account.  This is the plan that the Super Administrator will bill the COMPANY.">Plan</attr>
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::select('plan_id',$plans,$company->plan_id,['class'=>'form-control']) !!}
    	    </td>
    	</tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Status
                </td>
                <td valign="top" class="frmdata">

                    {!! Form::select('status',[1=>'Active',2=>'In-Active'],$company->status ,['class'=>'form-control']) !!}
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    <attr title="This option will allow any frontoffice user associated with this company to send Support tickets directly to this company by choosing the company in the ‘Send To’ section of the ticket.">Support Tickets Active?</attr>
                </td>
                <td valign="top" class="frmdata">
                @if($company->use_support == 1)
    		        {!! Form::checkbox('use_support',null, true) !!}
    		    @else
    		        {!! Form::checkbox('use_support',null, false) !!}
    		    @endif
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    <attr title="This option is for BILLING companies.  If checked it will NOT allow frontoffice user to file their own claims, all billing will go exclusively to the backoffice billing company.">Exclusive?</attr>
                </td>
                <td valign="top" class="frmdata">
                @if($company->exclusive == 1)
                    {!! Form::checkbox('exclusive',null, true) !!}
                @else
                    {!! Form::checkbox('exclusive',null, false) !!}
                @endif
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <span class="red">
                        * Required Fields
                    </span><br>
                    <input type="hidden" name="compsub" value="1">
                    <input type="hidden" name="ed" value="">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="submit" value="Update Company" class="btn btn-primary">
                    {!! HTML::link('manage/admin/companies','Back',['class'=>'btn btn-success']) !!}
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    @stop
    @stop