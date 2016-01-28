<?php

namespace DentalSleepSolutions\Http\Requests;

class DocumentCategoryStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required|string',
            'status' => 'integer'
        ];
    }
}
