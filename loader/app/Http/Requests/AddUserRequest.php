<?php
namespace Ds3\Http\Requests;

class AddUserRequest extends Request
{
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
            'first_name'  =>  'required',
            'last_name'   =>  'required',
            'email'       =>  'required|email'
        ];
    }
}
