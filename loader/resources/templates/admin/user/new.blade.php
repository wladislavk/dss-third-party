@extends('layouts.admin.master')
@section('content')



        <form name="userfrm" action="/manage/admin/user/new" method="post" class="form-horizontal">

             <div class="page-header"><strong>Personal Details</strong></div>


                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">Error:</span>
                        <strong>{{ $error }}</strong>
                    </div>
                    @endforeach

                        <div class="form-group">
                            <label for="first_name" class="col-md-3 control-label">First Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-3 control-label">Last Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                             <label for="phone" class="col-md-3 control-label">Phone</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control extphonemask" name="phone" id="phone" placeholder="Phone number">
                                </div>
                        </div>
                        <div class="page-header">
                                        <strong>Options</strong>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Active services</label>
                                        <div class="col-md-9">
                                            <label class="col-md-4">
                                                <input type="checkbox" name="use_patient_portal" value="1" checked >
                                                Patient Portal
                                            </label>
                                            <label class="col-md-4">
                                                <input type="checkbox" name="use_digital_fax" value="1" checked>
                                                Digital Fax
                                            </label>
                                            <label class="col-md-4">
                                                <input type="checkbox" name="use_letters" value="1" checked>

                                                Letters
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-md-push-3">
                                            <label class="col-md-4">
                                                <input type="checkbox" name="use_eligible_api" value="1" >
                                                Eligible API
                                            </label>
                                            <label class="col-md-4">
                                                <input type="checkbox" name="use_course" value="1" >
                                                Course
                                            </label>
                                            <label class="col-md-4">
                                                <input type="checkbox" name="use_course_staff" value="1" checked>
                                                Staff Course
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-md-push-3">
                                            <label class="col-md-4">
                                                <input type="checkbox" name="eligible_test" value="1" >
                                                Eligible Test?
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Automated services</label>
                                        <div class="col-md-9">
                                            <label class="col-md-4">
                                                <input type="checkbox" name="tracker_letters" value="1" checked>
                                                Tracker Letters
                                            </label>
                                            <label class="col-md-4">
                                                <input type="checkbox" name="intro_letters" value="1" checked>
                                                Intro Letters
                                            </label>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="page-header">
                                                    <strong>Administration Details</strong>
                                                </div>
                                                <div class="form-group">
                                                    <label for="companyid" class="col-md-3 control-label">Admin Company</label>
                                                    <div class="col-md-9">
                                                        {!! Form::select('companyid',$adminCompanies,'',["class"=>"form-control"]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_type" class="col-md-3 control-label">User Type</label>
                                                    <div class="col-md-9">
                                                        {!! Form::select('user_type',$userType,'',["Class"=>"form-control","id"=>"user_type"]) !!}
                                                    </div>
                                                </div>
                                                <div class="page-header">
                                                                <strong>Companies Details</strong>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="billing_company_id" class="col-md-3 control-label">Billing Company</label>
                                                                <div class="col-md-9">
                                                                  {!! Form::select('billing_company_id',$billingCompanyType,'',["Class"=>"form-control","id"=>"user_type"]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">HST Company</label>
                                                                <div class="col-md-9">
                                                                    {!! Form::checkbox('hst_company[]','5') !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="access_code_id" class="col-md-3 control-label">Access Code</label>
                                                                <div class="col-md-9">
                                                                    {!! Form::select('access_code_id',$accessCode,'',["Class"=>"form-control","id"=>"access_code_id"]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="plan_id" class="col-md-3 control-label">Software Plan</label>
                                                                <div class="col-md-9">
                                                                    {!! Form::select('plan_id',$softwarePlans,'',["Class"=>"form-control","id"=>"plan_id"]) !!}

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="billing_plan_id" class="col-md-3 control-label">Billing Plan</label>
                                                                <div class="col-md-9">
                                                                    {!! Form::select('billing_plan_id',$billingPlans,'',["Class"=>"form-control","id"=>"billing_plan_id"]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="page-header">
                                                                <strong>Status Details</strong>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="status" class="col-md-3 control-label">Status</label>
                                                                    <div class="col-md-9">
                                                                        <select id="status" name="status" class="form-control" onchange="showSuspended();">
                                                                            <option value="1" >Active</option>
                                                                            <option value="2" >In-Active</option>
                                                                            <option value="3" >Suspended</option>
                                                                        </select>
                                                                    </div>
                                                       </div>
        <div id="extendView">
             <div class="page-header expanded">
                <strong>ID and Access Details</strong>
             </div>
            <div class="form-group expanded">
                <label for="username" class="col-md-3 control-label">Username</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="npi" class="col-md-3 control-label">NPI Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="npi" id="npi" placeholder="NPI Number">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="medicare_npi" class="col-md-3 control-label">Medicare Provider (NPI/DME) Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="medicare_npi" id="medicare_npi" placeholder="Medicare Provider (NPI/DME) Number">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="medicare_ptan" class="col-md-3 control-label">Medicare PTAN Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="medicare_ptan" id="medicare_ptan" placeholder="Medicare PTAN Number">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="tax_id_or_ssn" class="col-md-3 control-label">Tax ID or SSN</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="tax_id_or_ssn" id="tax_id_or_ssn" placeholder="Tax ID/SSN">
                </div>
            </div>
            <div class="form-group expanded">
                <label class="col-md-3 control-label">EIN or SSN required</label>
                <div class="col-md-2 col-md-push-3 checkbox">
                    <label>
                        EIN
                        <input id="ein" type="checkbox" name="ein">
                    </label>
                </div>
                <div class="col-md-2 col-md-push-3 checkbox">
                    <label>
                        SSN
                        <input id="ssn" type="checkbox" name="ssn">
                    </label>
                </div>
            </div>
            <div class="form-group expanded">
                <label for="practice" class="col-md-3 control-label">Practice</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="practice" id="practice" placeholder="Practice">
                </div>
            </div>
            <?php if (!isset($_REQUEST['ed'])) { ?>
            <div class="form-group expanded">
                <label for="password" class="col-md-3 control-label">Password</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Your password">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="password2" class="col-md-3 control-label">Confirm your password</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm your password">
                </div>
            </div>
            <?php } ?>


            <div class="form-group expanded">
                <label for="address" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="city" id="city" placeholder="City" >
                </div>
            </div>
            <div class="form-group expanded">
                <label for="state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="state" id="state" placeholder="State">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip/Postal Code">
                </div>
            </div>

            <div class="form-group expanded">
                <label for="fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control phonemask" name="fax" id="fax" placeholder="Fax number">
                </div>
            </div>

            <div class="page-header expanded">
                <strong>Mailing Details</strong>
            </div>
            <div class="form-group expanded">
                <label for="mailing_practice" class="col-md-3 control-label">Practice</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_practice" id="mailing_practice" placeholder="Practice">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_name" class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_name" id="mailing_name" placeholder="Name">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_email" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                    <input type="email" class="form-control" name="mailing_email" id="mailing_email" placeholder="Email">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_address" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_address" id="mailing_address" placeholder="Address" >
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_city" id="mailing_city" placeholder="City">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_state" id="mailing_state" placeholder="State">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="mailing_zip" id="mailing_zip" placeholder="Zip/Postal Code">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_phone" class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control extphonemask" name="mailing_phone" id="mailing_phone" placeholder="Phone number" >
                </div>
            </div>
            <div class="form-group expanded">
                <label for="mailing_fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control phonemask" name="mailing_fax" id="mailing_fax" placeholder="Fax number" >
                </div>
            </div>
            <div class="form-group expanded">
                <label for="use_service_npi" class="col-md-3 control-label">Use Service NPI?</label>
               <div class="col-md-9">
                     <input type="checkbox" name="use_service_npi" id="use_service_npi" />
        </div>
        </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Name</label>
                <div class="col-md-9">

                <input id="service_name" class="form-control" type="text" name="service_name" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Address</label>
                <div class="col-md-9">
                <input id="service_address" class="form-control" type="text" name="service_address" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service City</label>
                <div class="col-md-9">
                <input id="service_city" class="form-control" type="text" name="service_city"  class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service State</label>
                <div class="col-md-9">
                <input id="service_state" class="form-control" type="text" name="service_state"  class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Zip</label>
                <div class="col-md-9">
                <input id="service_zip" class="form-control" type="text" name="service_zip"  class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Phone</label>
                <div class="col-md-9">
                <input id="service_phone" class="form-control extphonemask" type="text" name="service_phone" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Fax</label>
                <div class="col-md-9">
                <input id="service_fax" class="form-control phonemask" type="text" name="service_fax"  class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service NPI</label>
                <div class="col-md-9">
                <input id="service_npi" class="form-control" type="text" name="service_npi"  class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Medicare NPI</label>
                <div class="col-md-9">
                <input id="service_medicare_npi" class="form-control" type="text" name="service_medicare_npi" class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Medicare PTAN</label>
                <div class="col-md-9">
                <input id="service_medicare_ptan" class="form-control" type="text" name="service_medicare_ptan"  class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service Tax ID or SSN</label>
                <div class="col-md-9">
                <input id="service_tax_id_or_ssn" class="form-control" type="text" name="service_tax_id_or_ssn"  class="tbox" />
                </div>
            </div>
            <div class="form-group expanded service_field">
                <label for="use_service_npi" class="col-md-3 control-label">Service EIN or SSN</label>
                <div class="col-md-9">
                <input id="service_ein" type="checkbox" name="service_ein" value="1"  class="tbox" />
                EIN
                <input id="service_ssn" type="checkbox" name="service_ssn" value="1"  class="tbox" />
                SSN
                </div>
            </div>


            <div class="form-group expanded">
                <label class="col-md-3 control-label">Visuals to use</label>
                <div class="col-md-9">
                    <label class="col-md-4">
                        <input type="checkbox" name="homepage" value="1" >
                        New Homepage
                    </label>
                    <label class="col-md-4">
                        <input type="checkbox" name="use_letter_header" value="1" >
                        Letter Header
                    </label>
                </div>
            </div>

<script type="text/javascript">
  function showSuspended(){
    if($('#status').val()==3){
      $('#suspended_reason').show();
    }else{
      $('#suspended_reason').hide();
    }
  }
</script>

            {{--<div id="suspended_reason" class="form-group" >--}}
                {{--<label for="suspended_reason" class="col-md-3 control-label">Suspended Reason</label>--}}
                {{--<div class="col-md-9">--}}
                    {{--<textarea name="suspended_reason" id="suspended_reason" class="form-control"></textarea>--}}
                {{--</div>--}}
            {{--</div>--}}
</div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="usersub" value="1">
                    <input type="hidden" name="ed" value="" >
                    <input type="hidden" name="ed">

                    {{--<a>--}}
                        {{--Delete--}}
                    {{--</a>--}}
                    {{--<a href="">Reset Password</a>--}}

                    {{--<input type="submit" class="btn btn-info" name="reg_but" onclick="return userregabc(this.form)" value="Send Registration Email">--}}
                    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                                    <input type="submit" name="save_but" class="btn btn-primary" value="Add User" />
                    <input type="submit" class="btn btn-info" name="reg_but" onclick="return userregabc(this.form)" value="Send Registration Email">
                    <a href="#" id="expandBtn" onclick="$('#extendView').toggle(); return false;" class="btn btn-default pull-right">Expand fields</a>

                        {{--<a href="#" >Registration Link</a>--}}
                </div>
            </div>

            <div>

            </div>
        </form>
    </div>

    <script>
        $(document).ready(function($e){
              $("#extendView").hide();

              $('#expandBtn').click(function(){
              var expandBtn = $('#expandBtn').html();
                    if( expandBtn === 'Expand fields')
                    {
                        $('#expandBtn').html('Hide fields');
                    }else
                        {
                            $('#expandBtn').html('Expand fields');
                        }
              });
        });
    </script>
@stop
@stop