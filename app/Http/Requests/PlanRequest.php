<?php namespace Ds3\Http\Requests;

use Ds3\Http\Requests\Request;

class PlanRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'name'             =>      'required',
            'monthly_fee'      =>      'required',
            'trial_period'     =>      'required',
            'fax_fee'          =>      'required',
            'free_fax'         =>      'required',
            'eligibility_fee'  =>      'required',
            'free_eligibility' =>      'required',
            'enrollment_fee'   =>      'required',
            'free_enrollment'  =>      'required',
            'efile_fee'        =>      'required',
            'free_efile'       =>      'required',
            'claim_fee'        =>      'required',
            'free_claim'       =>      'required',
            'vob_fee'          =>      'required',
            'free_vob'         =>      'required',
            'duration'         =>      'required',
            'producer_fee'     =>      'required',
            'user_fee'         =>      'required',
            'patient_fee'      =>      'required',
            'office_type'      =>      'required',
            'status'           =>      'required'
		];
	}

}
