 @extends('layouts.admin.master')

 @section('content')

<h4 class="modal-title">Add New Plan</h4>
@include('layouts.partials.errors')
<form name="planfrm" action="/manage/admin/plan/new" method="post" onsubmit="return check_add();">
    <table class="table table-bordered table-hover">

            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Name
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="name"  class="form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Monthly Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="monthly_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Trial Period (days)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="trial_period"  class="numbermask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Fax Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="fax_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Fax (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="free_fax" class="numbermask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Eligibility Check Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="eligibility_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Eligibility Checks (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="free_eligibility"  class="numbermask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Enrollment Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="enrollment_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Enrollments (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="free_enrollment" class="numbermask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
    	<!-- new -->
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Claim E-File Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="efile_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
    	<!-- new -->
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free E-Claims (Monthly)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="free_efile"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>

            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Claim Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="claim_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free Claims (Lifetime)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="free_claim"  class="numbermask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    VOB Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="vob_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Free VOBs (Lifetime)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="free_vob"  class="numbermask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Plan Length (months)
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="duration"  class="numbermask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    Producer Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="producer_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    User Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="user_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead" width="30%">
                    New Patient Fee
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="patient_fee"  class="moneymask form-control validate" />
                    <span class="red">*</span>
                </td>
            </tr>

	<!-- NEW -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Type
            </td>
            <td valign="top" class="frmdata">
                <select name="office_type" class="form-control validate">
			<option value="1">Super-&gt;FO</option>
			<option value="2">Super-&gt;BO</option>
			<option value="3">BO Ins Co-&gt;FO</option>
		</select>
            </td>
        </tr>


        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control validate">
                	<option value="1">Active</option>
                	<option value="2">In-Active</option>
                </select>
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
                <input type="submit" value="Add Plan" class="btn btn-primary">
                {!! HTML::link('manage/admin/plan','Back',['class'=>'btn btn-success']) !!}
            </td>
        </tr>
    </tbody>
    </table>
    </form>
  @stop
  @stop