<?php

namespace DentalSleepSolutions\Http\Requests;

class DocumentCategoryUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'sometimes|required|string',
            'status' => 'integer'
        ];
    }
}
