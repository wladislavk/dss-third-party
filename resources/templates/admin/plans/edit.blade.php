 @extends('layouts.admin.master')

 @section('content')

<h4 class="modal-title">Add New Plan</h4>
@include('layouts.partials.errors')
{!! Form::model($plan, ['route' => ['plan.update', $plan->id]]) !!}
    <table class="table table-bordered table-hover">

            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Name
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('name',null,['class'=>'form-control']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Monthly Fee
                </td>
                <td valign="top" class="frmdata">
                   {!! Form::text('monthly_fee',null,['class'=>'form-control moneymask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Trial Period (days)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('trial_period',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Fax Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('fax_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Fax (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('free_fax',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Eligibility Check Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('eligibility_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Eligibility Checks (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('free_eligibility',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Enrollment Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('enrollment_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Enrollments (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('free_enrollment',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
        <!-- new -->
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Claim E-File Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('efile_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
        <!-- new -->
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free E-Claims (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('free_efile',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>

            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Claim Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('claim_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Claims (Lifetime)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('free_claim',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    VOB Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('vob_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free VOBs (Lifetime)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('free_vob',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Plan Length (months)
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('duration',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Producer Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('producer_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    User Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('user_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    New Patient Fee
                </td>
                <td valign="top" class="frmdata">
                    {!! Form::text('patient_fee',null,['class'=>'form-control numbermask']) !!}
                    <span class="red">*</span>
                </td>
            </tr>

    <!-- NEW -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
        Type
            </td>
            <td valign="top" class="frmdata">
              {!! Form::select('office_type',[1=>'Super->FO',2=>'Super->BO',3=>'BO Ins Co->FO'],null,['class'=>'form-control validate']) !!}
            </td>
        </tr>


        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
                {!! Form::select('status',[1=>'Active',2=>'In-Active'],null,['class'=>'form-control validate']) !!}
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <span class="red">
                    * Required Fields
                </span><br>
                <input type="hidden" name="plansub" value="1">
                <input type="hidden" name="ed" value="">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="submit" value="Update Plan" class="btn btn-primary">
                {!! HTML::link('manage/admin/plan','Back',['class'=>'btn btn-success']) !!}
            </td>
        </tr>
    </tbody>
    </table>
    {!! Form::close() !!}
  @stop
  @stop