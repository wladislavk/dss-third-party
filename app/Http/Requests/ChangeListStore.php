<?php

namespace DentalSleepSolutions\Http\Requests;

class ChangeListStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string'
        ];
    }
}
