<?php

namespace DentalSleepSolutions\Http\Requests;

class ChangeListUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'sometimes|required|string'
        ];
    }
}
