<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class StoreContactTypeRequest extends Request
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
            'contacttype' => 'string|required',
            'description' => 'string',
            'sortby'      => 'integer|required',
            'status'      => 'integer|required',
            'physician'   => 'integer',
            'corporate'   => 'integer'
        ];
    }
}
