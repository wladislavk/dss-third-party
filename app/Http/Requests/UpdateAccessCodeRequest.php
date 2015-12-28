<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class UpdateAccessCodeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'access_code' => 'sometimes|required|string|unique:dental_access_codes',
            'notes'       => 'string',
            'status'      => 'integer',
            'plan_id'     => 'integer'
        ];
    }
}
