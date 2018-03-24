<?php
namespace Ds3\Http\Requests;

class BackOfficeUserRequest extends Request
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
        $rules = [
            'first_name'  => 'required',
            'last_name'   => 'required',
            'email'       => 'required|email',
            'status'      => 'required',
        ];
        
        $username    = Request::input('username');
        $usernameOld = Request::input('usernameOld');

        if ($username != $usernameOld) {
            $rules['username'] = 'required|unique:admin';
        } else {
            $rules['username'] = 'required';
        }

        return $rules;
    }
}
