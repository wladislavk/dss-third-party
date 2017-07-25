<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportAttachmentUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_id'   => 'sometimes|required|integer',
            'response_id' => 'sometimes|required|integer',
            'filename'    => [
                'sometimes',
                'required',
                'regex:/^support_attachment_[0-9]{1,2}_[0-9]_[0-9]{4}\.(gif|jpeg|png|bmp|jpg)$/'
            ]
        ];
    }
}
