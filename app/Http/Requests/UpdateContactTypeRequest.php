<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class UpdateContactTypeRequest extends Request
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
            'contacttype' => 'sometimes|string|required',
            'description' => 'string',
            'sortby'      => 'sometimes|integer|required',
            'status'      => 'sometimes|integer|required',
            'physician'   => 'integer',
            'corporate'   => 'integer'
        ];
    }
}
