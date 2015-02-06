<?php namespace Ds3\Http\Requests;

use Ds3\Http\Requests\Request;

class AddAccessCodeRequest extends Request {

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
        $accessCode     = Request::input('current_access_code');
        $newAccessCode  = Request::input('access_code');
        if($accessCode != $newAccessCode )
        {
            return [
                'access_code' => 'required|unique:dental_access_codes'
            ];
        }else
        {
            return [
                'access_code' => 'required'
            ];
        }
	}

}
