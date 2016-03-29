<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportCategoryUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'  => 'sometimes|required|string',
            'status' => 'integer'
        ];
    }
}
