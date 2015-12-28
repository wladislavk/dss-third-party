<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class StoreAppointmentTypeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'string',
            'color'     => 'required|string',
            'classname' => 'required|string',
            'docid'     => 'required|integer'
        ];
    }
}
