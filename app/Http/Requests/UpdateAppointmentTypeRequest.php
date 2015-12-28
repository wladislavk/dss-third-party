<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class UpdateAppointmentTypeRequest extends Request
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
            'color'     => 'sometimes|required|string',
            'classname' => 'sometimes|required|string',
            'docid'     => 'sometimes|required|integer'
        ];
    }
}
