<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportAttachmentStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_id'   => 'required|integer',
            'response_id' => 'required|integer',
            'filename'    => ['required', 'regex:/^support_attachment_[0-9]{1,2}_[0-9]_[0-9]{4}\.(gif|jpeg|png|bmp|jpg)$/']
        ];
    }
}
